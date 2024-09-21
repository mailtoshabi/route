<?php

namespace App\Http\Controllers\Driver;

use App\Http\Controllers\Controller;
use App\Http\Utilities\Utility;
use App\Models\Delivery;
use App\Models\ProductItem;
use App\Models\SaleBatch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeliveryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $delivery = Delivery::find(decrypt($id));
        $customer = $delivery->deliverable_type=='App\Models\ProductSale'? $delivery->deliverable->sale->customer:$delivery->deliverable->customer;
        return view('drivers.sales.show',compact('delivery','customer'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function open_deliveries()
    {
        $active= 1;
        $deliveries = Delivery::orderBy('id')->where('final_status',Utility::ITEM_INACTIVE)
        ->where('driver_id',Auth::guard('driver')->id())
        ->paginate(Utility::PAGINATE_COUNT);
        return view('drivers.sales.index',compact('deliveries','active'));

    }

    public function closed_deliveries()
    {
        $active= 0;
        $deliveries = Delivery::orderBy('id')->where('final_status',Utility::ITEM_ACTIVE)
        ->where('driver_id',Auth::guard('driver')->id())
        ->paginate(Utility::PAGINATE_COUNT);
        return view('drivers.sales.index',compact('deliveries','active'));

    }

    public function accept($id)
    {
        // $sale_batch = SaleBatch::find(decrypt($id));
        // if($sale_batch->status==Utility::STATUS_NEW) {
        //     foreach($sale_batch->product_items as $product_item) {
        //         $sale_batch->product_items()->updateExistingPivot($product_item, ['status'=>Utility::STATUS_ACCEPTED, 'date_accepted'=>now()]);
        //     }
        //     $input = ['status'=>Utility::STATUS_ACCEPTED];
        //     $sale_batch->update($input);
        //     return redirect()->route('driver.orders.show', encrypt($sale_batch->id))->with(['success'=>'Status changed Successfully']);
        // }else {
        //     return redirect()->route('driver.orders.show', encrypt($sale_batch->id))->with(['failed'=>'Something went wrong']);
        // }
    }

    public function accept_single($id,$product_item_id)
    {
        // $sale_batch = SaleBatch::find(decrypt($id));
        // $product_item = ProductItem::find(decrypt($product_item_id));
        // // return $product_item->pivot;

        // // $product_item_sale_batch = $sale_batch->product_items()->wherePivot('id',$pivot_id)->first();

        // $product_item_sale = $sale_batch->product_items()->wherePivot('product_item_id',decrypt($product_item_id))->first();
        // // return $product_item_sale;

        // if($product_item_sale->pivot->status==Utility::STATUS_NEW) {
        //     $sale_batch->product_items()->updateExistingPivot($product_item, ['status'=>Utility::STATUS_ACCEPTED, 'date_accepted'=>now()]);

        //     $checkUnAccepted = $sale_batch->product_items()->wherePivot('status', '!=', Utility::STATUS_ACCEPTED)->first();
        //     if($checkUnAccepted) {
        //         $input = ['status'=>Utility::STATUS_PARTIALLY];
        //         $sale_batch->update($input);
        //     }else {
        //         $input = ['status'=>Utility::STATUS_ACCEPTED];
        //         $sale_batch->update($input);
        //     }
        //     return redirect()->route('driver.orders.show', encrypt($sale_batch->id))->with(['success'=>'Status changed Successfully']);
        // }else {
        //     return redirect()->route('driver.orders.show', encrypt($sale_batch->id))->with(['failed'=>'Something went wrong']);
        // }


    }

}
