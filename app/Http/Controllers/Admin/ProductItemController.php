<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Utilities\Utility;
use App\Models\Product;
use App\Models\ProductItem;
use App\Models\RentTerm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProductItemController extends Controller
{
    public function index($productid) {
        $productid = decrypt($productid);
        $products = ProductItem::where('product_id',$productid)->orderBy('id')->paginate(Utility::PAGINATE_COUNT);
        return view('admin.products.items',compact('products'));
    }

    public function view($id) {
        $product_item = ProductItem::findOrFail(decrypt($id));
        $products = Product::all();
        $rent_terms = RentTerm::all();
        return view('admin.products.view',compact('product_item','products','rent_terms'));
    }

}
