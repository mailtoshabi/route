<?php

namespace App\Http\Controllers\Branch;

use App\Http\Controllers\Controller;
use App\Http\Utilities\Utility;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductItem;
use App\Models\RentTerm;
use App\Models\TaxType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProductItemController extends Controller
{
    public function index() {
        $product_items = ProductItem::where('branch_id',Auth::guard('branch')->id())->orderBy('id')->paginate(Utility::PAGINATE_COUNT);
        return view('branches.product_items.index',compact('product_items'));
    }

    public function create() {
        $categories = Category::all();
        $brands = Brand::all();
        $taxes = TaxType::all();
        $products = Product::all();
        $rent_terms = RentTerm::all();
        return view('branches.product_items.add',compact('categories','brands','taxes','rent_terms','products'));
    }

    public function store () {
        Validator::make(request()->all(), [
            'item_code' => 'required|unique:product_items,item_code',
            'product_id' => 'required',
            'name' => 'required|unique:product_items,name',
            'name_ar' => 'required|unique:product_items,name_ar',
            'model_year' => 'required',])->validate();

        $input = request()->except(['_token','is_customer','rent_terms','prices','product_id','branch_id','customer_id','image','images','is_trending','is_featured','is_available','available_at']); // 'related_products'

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

        //TODO: write code for "images" here

        $input['images'] = '';
        $input['is_customer'] =Utility::LENDER_TYPE_BRANCH;
        $input['branch_id'] =Auth::guard('branch')->id();
        $input['customer_id'] =null;
        $input['available_at'] =null;
        $input['product_id'] = decrypt(request('product_id'));

        $product_item = ProductItem::create($input);

        if(!empty(request('rent_terms'))) {
            foreach(request('rent_terms') as $index => $rent_termId) {
                if(!empty($rent_termId)&&(!empty(request('prices')[$index]))) {
                    $rent_termId = decrypt($rent_termId);
                    $product_item->rentTerms()->attach($rent_termId,['price'=>request('prices')[$index]]);
                }
            }
        }
        return redirect()->route('branch.product_items.index')->with(['success'=>'New Product Added Successfully']);
    }

    public function edit($id) {
        $categories = Category::all();
        $brands = Brand::all();
        $taxes = TaxType::all();
        $products = Product::all();
        $rent_terms = RentTerm::all();
        $product_item = ProductItem::findOrFail(decrypt($id));
        return view('branches.product_items.add',compact('categories','brands','products','taxes','rent_terms','product_item'));
    }

    public function update () {
        $id = decrypt(request('product_item_id'));
        $product_item = ProductItem::find($id);

        Validator::make(request()->all(), [
            'item_code' => 'required|unique:product_items,item_code,'. $id,
            'product_id' => 'required',
            'name' => 'required|unique:product_items,name,'. $id,
            'name_ar' => 'required|unique:product_items,name_ar,'. $id,
            'model_year' => 'required',])->validate();

        $input = request()->except(['_token','_method','product_item_id','rent_terms','prices','product_id','branch_id','customer_id','image','images','is_trending','is_featured','is_available','available_at']);

        $input['is_trending'] = 0;
        if(request()->has('is_trending')) {
            $input['is_trending'] = 1;
        }

        $input['is_featured'] = 0;
        if(request()->has('is_featured')) {
            $input['is_featured'] = 1;
        }

        if(request('isImageDelete')==1) {
            Storage::delete(ProductItem::DIR_PUBLIC . $product_item->image);
            $input['image'] =null;
        }
        if(request()->hasFile('image')) {
            $extension = request('image')->extension();
            $fileName = 'product_pic_' . date('YmdHis') . '.' . $extension;
            request('image')->storeAs('products', $fileName);
            $input['image'] =$fileName;
        }
        //TODO: write code for "images" here

        // if(Auth::guard('web')->check()) {
        //     $input['user_id'] =Auth::id();
        // }else {
        //     $input['seller_id'] =Auth::guard('seller')->id();
        // }

        $product_item->update($input);
        $product_item->rentTerms()->detach();
        if(!empty(request('rent_terms'))) {
            foreach(request('rent_terms') as $index => $rent_termId) {
                if(!empty($rent_termId)&&(!empty(request('prices')[$index]))) {
                    $rent_termId = decrypt($rent_termId);
                    $product_item->rentTerms()->attach($rent_termId,['price'=>request('prices')[$index]]);
                }
            }
        }

        return redirect()->route('branch.product_items.index')->with(['success'=>'Product Updated Successfully']);
    }

    public function destroy($id) {
        $product_item = ProductItem::find(decrypt($id));
        if(!empty($product_item->image)) {
            Storage::delete(ProductItem::DIR_PUBLIC . $product_item->image);
            $input['image'] =null;
        }
        //TODO: write code for images here
        $product_item->delete();
        return redirect()->route('admin.product_item.index')->with(['success'=>'Product Item Deleted Successfully']);
    }

    public function changeStatus($id) {
        $product_item = ProductItem::find(decrypt($id));
        $currentStatus = $product_item->status;
        $status = $currentStatus ? 0 : 1;
        $product_item->update(['status'=>$status]);
        return redirect()->route('admin.product_item.index')->with(['success'=>'Status changed Successfully']);
    }
}
