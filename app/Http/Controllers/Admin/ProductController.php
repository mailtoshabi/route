<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Utilities\Utility;
use App\Models\Branch;
use App\Models\Brand;
use App\Models\Category;
use App\Models\CustomerReview;
use App\Models\Product;
use App\Models\ProductItem;
use App\Models\RentTerm;
use App\Models\SubCategory;
use App\Models\TaxType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index() {

        $products = Product::orderBy('id')->paginate(Utility::PAGINATE_COUNT);
        return view('admin.products.index',compact('products'));
    }

    public function create() {
        $sub_categories = SubCategory::all();
        $brands = Brand::all();
        $taxes = TaxType::all();
        // $rent_terms = RentTerm::all();
        $branches = Branch::all();
        return view('admin.products.add',compact('sub_categories','brands','taxes','branches')); //,'rent_terms'
    }

    public function store () {
        Validator::make(request()->all(), [
            'name' => 'required|unique:products,name',
            'sub_category_id' => 'required',
            'branch_id' => 'required',
            'price_day' => 'required',
            'price_week' => 'required',
            'price_month' => 'required',
            // 'tax_type_id' => 'required',
        ],
            // ['tax_type_id.required' => 'Select type of Tax',]
            )->validate();

        $input = request()->except(['_token','user_id','image','images','prices','is_trending','is_featured','is_available','available_at']); // 'related_products', 'sub_categories','rent_terms'
        $input['is_trending'] = 0;
        if(request()->has('is_trending')) {
            $input['is_trending'] = 1;
        }

        $input['is_featured'] = 0;
        if(request()->has('is_featured')) {
            $input['is_featured'] = 1;
        }

        if(request()->hasFile('image')) {
            $extension = request('image')->extension();
            $fileName = 'product_pic_' . date('YmdHis') . '.' . $extension;
            request('image')->storeAs('products', $fileName);
            $input['image'] =$fileName;
        }

        $input['images'] = '';
        $input['available_at'] =null;
        $input['user_id'] =Auth::id();

        $product = Product::create($input);
        // if(!empty(request('sub_categories'))) {
        //     $sub_categoryIds = [];
        //     foreach(request('sub_categories') as $sub_categoryId) {
        //         $sub_categoryIds[] = decrypt($sub_categoryId);
        //     }
        //     $product->sub_categories()->attach($sub_categoryIds);
        // }

        // if(!empty(request('rent_terms'))) {
        //     foreach(request('rent_terms') as $index => $rent_termId) {
        //         if(!empty($rent_termId)&&(!empty(request('prices')[$index]))) {
        //             $rent_termId = decrypt($rent_termId);
        //             $product->rentTerms()->attach($rent_termId,['price'=>request('prices')[$index]]);
        //         }
        //     }
        // } //

        return redirect()->route('admin.products.index')->with(['success'=>'New Product Added Successfully']);
    }

    public function edit($id) {
        $sub_categories = SubCategory::all();
        $brands = Brand::all();
        $product = Product::findOrFail(decrypt($id));
        $taxes = TaxType::all();
        $rent_terms = RentTerm::all();
        $branches = Branch::all();
        return view('admin.products.add',compact('product', 'sub_categories','brands','taxes','branches')); //,'rent_terms'
    }

    public function update () {
        $id = decrypt(request('product_id'));
        $product = Product::find($id);

        Validator::make(request()->all(), [
            'name' => 'required|unique:products,name,'. $id,
            'sub_category_id' => 'required',
            // 'tax_type_id' => 'required',
        ],
            // ['tax_type_id.required' => 'Select type of Tax',]
            )->validate();

        $input = request()->except(['_token','_method','user_id','image','images','is_trending','is_featured','is_available','available_at']); //'related_products','sub_categories','rent_terms','prices'
        $input['is_trending'] = 0;
        if(request()->has('is_trending')) {
            $input['is_trending'] = 1;
        }

        $input['is_featured'] = 0;
        if(request()->has('is_featured')) {
            $input['is_featured'] = 1;
        }

        if(request('isImageDelete')==1) {
            Storage::delete(Product::DIR_PUBLIC . $product->image);
            $input['image'] =null;
        }
        if(request()->hasFile('image')) {
            $extension = request('image')->extension();
            $fileName = 'product_pic_' . date('YmdHis') . '.' . $extension;
            request('image')->storeAs('products', $fileName);
            $input['image'] =$fileName;
        }

        $input['images'] = '';
        $input['available_at'] =null;

        // if(Auth::guard('web')->check()) {
        //     $input['user_id'] =Auth::id();
        // }else {
        //     $input['seller_id'] =Auth::guard('seller')->id();
        // }

        $product->update($input);
        // if(!empty(request('sub_categories'))) {
        //     $sub_categoryIds = [];
        //     foreach(request('sub_categories') as $sub_category_id) {
        //         $sub_categoryIds[] = decrypt($sub_category_id);
        //     }
        //     $product->sub_categories()->sync($sub_categoryIds);
        // }

        // $product->rentTerms()->detach();
        // if(!empty(request('rent_terms'))) {
        //     foreach(request('rent_terms') as $index => $rent_termId) {
        //         if(!empty($rent_termId)&&(!empty(request('prices')[$index]))) {
        //             $rent_termId = decrypt($rent_termId);
        //             $product->rentTerms()->attach($rent_termId,['price'=>request('prices')[$index]]);
        //         }
        //     }
        // }
        return redirect()->route('admin.products.index')->with(['success'=>'Product Updated Successfully']);
    }

    public function destroy($id) {
        $product = Product::find(decrypt($id));
        if(!empty($product->image)) {
            Storage::delete(Product::DIR_PUBLIC . $product->image);
            $input['image'] =null;
        }
        $product->delete();
        return redirect()->route('admin.products.index')->with(['success'=>'Product Deleted Successfully']);
        // return redirect()->route('admin.products.index')->with(['success'=>'Product Deleted Successfully']);
    }

    public function changeStatus($id) {
        $product = Product::find(decrypt($id));
        $currentStatus = $product->status;
        $status = $currentStatus ? 0 : 1;
        $product->update(['status'=>$status]);
        return redirect()->route('admin.products.index')->with(['success'=>'Status changed Successfully']);
        // return redirect()->route('admin.products.index')->with(['success'=>'Status changed Successfully']);
    }

    public function inventoryTransfer() {
        $products = Product::all();
        $branches = Branch::all();
        return view('admin.products.inventory-transfer',compact('products','branches'));
    }
    //TODO : should be deleted this from here and transferred to ProductItemController

    // public function getBranchStock() {
    //     $branch_id = request('branch');
    //     $product_id = request('product');
    //     $product_name = Product::where('id',$product_id)->pluck('name');
    //     $branch_name = Branch::where('id',$branch_id)->pluck('name');
    //     if(!empty($branch_id) && !empty($product_id)) {
    //         $branch_products = DB::table('branch_product')->where(['branch_id'=>$branch_id, 'product_id'=>$product_id])->get();
    //         $stock = 0;
    //         foreach($branch_products as $branch_product) {
    //             $stock += $branch_product->quantity;
    //         }
    //         return response()->json(['stock'=>$stock, 'product'=>$product_name[0], 'branch'=>$branch_name[0]]);
    //     }
    // }
    //TODO : should be deleted this from here and transferred to ProductItemController

    // public function inventoryTransferStore() {
    //     // return request()->all();
    //     // return 'hi';
    //     Validator::make(request()->all(), [
    //         'product_id' => 'required',
    //         'branch_from' => 'required',
    //         'quantity' => 'required|lte:total_quantity',
    //         'branch_to' => 'required|different:branch_from',],
    //         ['product_id' => 'Choose a Product',
    //         'branch_from' => 'Select the Branch From',
    //         'branch_to.required' => 'Select the Branch To',
    //         'branch_to.different' => 'Both Branches cannot be same',])->validate();

    //         $product_id = request('product_id');
    //         $branch_from = request('branch_from');
    //         $branch_to = request('branch_to');
    //         $requested_quantity = request('quantity');
    //         $total_quantity = request('total_quantity');

    //         // $branch_products = DB::table('branch_product')->where(['branch_id'=>$branch_from, 'product_id'=>$product_id])->get();
    //         // $current_quantity = 0;
    //         // foreach($branch_products as $branch_product) {
    //         //     $current_quantity += $branch_product->quantity;
    //         // }
    //         $remaining_quantity = $total_quantity - $requested_quantity;
    //         if($requested_quantity <= $total_quantity) {
    //             DB::table('branch_product')->where(['branch_id'=>$branch_from, 'product_id'=>$product_id])->delete();
    //             if($remaining_quantity > 0) {
    //                 DB::table('branch_product')->insert(
    //                     ['branch_id' => $branch_from, 'product_id' => $product_id, 'quantity' => $remaining_quantity, 'created_at' => now()]
    //                 );
    //             }
    //             DB::table('branch_product')->insert(
    //                 ['branch_id' => $branch_to, 'product_id' => $product_id, 'quantity' => $requested_quantity, 'created_at' => now()]
    //             );
    //         }
    //     return redirect()->route('admin.products.inventory.transfer')->with(['success'=>'Inventory Transfered Successfully']);
    // }
    //TODO : should be deleted this from here and transferred to ProductItemController


    public function products() {
        $products = Product::orderBy('id')->paginate(Utility::PAGINATE_COUNT);
        return view('admin.products.all',compact('products'));
    }
}
