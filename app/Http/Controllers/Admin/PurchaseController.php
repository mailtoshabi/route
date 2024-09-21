<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Utilities\Utility;
use App\Models\Branch;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Supplier;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $purchases = Purchase::orderBy('id')->paginate(Utility::PAGINATE_COUNT);
        return view('admin.purchases.index',compact('purchases'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $suppliers = Supplier::all();
        $branches = Branch::all();
        $products = Product::all();
        return view('admin.purchases.add',compact('suppliers','branches','products'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        // return request('product_ids');
        Validator::make(request()->all(), [
            'invoice_no' => 'required',
            'order_at' => 'required',
            'supplier_id' => 'required',
            'branch_id' => 'required',
        ],
            ['invoice_no.required' => 'Order Number is Required',
            'order_at.required' => 'Order Date is Required',
            'supplier_id.required' => 'Select A Supplier',
            'branch_id.required' => 'Select A Branch',
            ])->validate();

        $input = request()->except(['po_attachment','user_id','product_ids','quantities','prices','vats','_token','isImageDelete']);

        if(request()->hasFile('po_attachment')) {
            $extension = request('po_attachment')->extension();
            $fileName = 'purchase_pic_' . date('YmdHis') . '.' . $extension;
            request('po_attachment')->storeAs('purchases', $fileName);
            $input['po_attachment'] =$fileName;
        }
        $input['user_id'] =Auth::id();
        $purchase = Purchase::create($input);
        $branch = Branch::find(request('branch_id'));

        if(!empty(request('product_ids'))) {
            foreach(request('product_ids') as $index => $product_id) {
                if(!empty($product_id)&&(!empty(request('quantities')[$index]))&&(!empty(request('prices')[$index]))&&(!empty(request('vats')[$index]))) {
                    $product_id = decrypt($product_id);
                    $purchase->products()->attach($product_id,['quantity'=>request('quantities')[$index],'price'=>request('prices')[$index],'vat'=>request('vats')[$index]]);
                    // $product = Product::find($product_id);
                    // $new_stock = $product->quantity + request('quantities')[$index];
                    // $product->update(['quantity' => $new_stock]);

                    $branch->products()->attach($product_id,['quantity'=>request('quantities')[$index]]);
                }
            }
        }
        return redirect()->route('admin.purchases.index')->with(['success'=>'New Purchase Entry Added Successfully']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function show(Purchase $purchase)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $suppliers = Supplier::all();
        $branches = Branch::all();
        $purchase = Purchase::findOrFail(decrypt($id));
        $products = Product::all();
        return view('admin.purchases.add',compact('purchase','suppliers','branches','products'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        $id = decrypt($id);
        $purchase = Purchase::find($id);
        Validator::make(request()->all(), [
            'invoice_no' => 'required',
            'order_at' => 'required',
            'supplier_id' => 'required',
            'branch_id' => 'required',
        ],
            ['invoice_no.required' => 'Order Number is Required',
            'order_at.required' => 'Order Date is Required',
            'supplier_id.required' => 'Select A Supplier',
            'branch_id.required' => 'Select A Branch',
            ])->validate();

        $input = request()->except(['_token','_method','po_attachment','user_id','product_ids','quantities','prices','vats','isImageDelete']);

        // return $input;

        if(request()->hasFile('po_attachment')) {
            $extension = request('po_attachment')->extension();
            $fileName = 'purchase_pic_' . date('YmdHis') . '.' . $extension;
            request('po_attachment')->storeAs('purchases', $fileName);
            $input['po_attachment'] =$fileName;
        }
        $input['user_id'] =Auth::id();


        $purchase->update($input);

        // $purchase->products()->detach();
        // if(!empty(request('product_ids'))) {
        //     foreach(request('product_ids') as $index => $product_id) {
        //         if(!empty($product_id)&&(!empty(request('quantities')[$index]))&&(!empty(request('prices')[$index]))&&(!empty(request('vats')[$index]))) {
        //             $product_id = decrypt($product_id);
        //             $purchase->products()->attach($product_id,['quantity'=>request('quantities')[$index],'price'=>request('prices')[$index],'vat'=>request('vats')[$index]]);
        //         }
        //     }
        // }

        return redirect()->route('admin.purchases.index')->with(['success'=>'New Purchase Entry Updated Successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $purchase = Purchase::find(decrypt($id));
        // foreach($purchase->products as $product_pivot) {
        //     $product = Product::find($product_pivot->id);
        //     $new_stock = $product->quantity - $product_pivot->pivot->quantity;
        //     $product->update(['quantity' => $new_stock]);
        // }
        $branch = Branch::find($purchase->branch_id);
        $branch->products->detach();
        if(!empty($purchase->po_attachment)) {
            Storage::delete(Purchase::DIR_PUBLIC . $purchase->po_attachment);
            $input['image'] =null;
        }
        $purchase->delete();
        return redirect()->route('admin.purchases.index')->with(['success'=>'Purchase Entry Deleted Successfully']);
    }
    public function changeStatus($id) {
        $sale = Purchase::find(decrypt($id));
        $currentStatus = $sale->status;
        $status = $currentStatus ? 0 : 1;
        $sale->update(['status'=>$status]);
        return redirect()->route('admin.purchases.index')->with(['success'=>'Status changed Successfully']);
    }
}
