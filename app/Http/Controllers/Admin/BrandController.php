<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Utilities\Utility;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BrandController extends Controller
{
    public function index() {
        $brands = Brand::orderBy('id')->paginate(Utility::PAGINATE_COUNT);
        return view('admin.brands.index',compact('brands'));
    }

    public function create() {
        return view('admin.brands.add');
    }

    public function store () {
        $validated = request()->validate([
            'name' => 'required|unique:brands,name',
            'name_ar' => 'required|unique:brands,name_ar',
        ]);
        $input = request()->only(['name','name_ar']);
        if(request()->hasFile('image')) {
            $extension = request('image')->extension();
            $fileName = 'brand_pic_' . date('YmdHis') . '.' . $extension;
            request('image')->storeAs('brands', $fileName);
            $input['image'] =$fileName;
        }
        $input['user_id'] =Auth::id();
        $brand = Brand::create($input);
        return redirect()->route('admin.brands.index')->with(['success'=>'New Brand Added Successfully']);
    }

    public function edit($id) {
        $brand = Brand::findOrFail(decrypt($id));
        return view('admin.brands.add',compact('brand'));
    }

    public function update () {
        $id = decrypt(request('brand_id'));
        $brand = Brand::find($id);
        $validated = request()->validate([
            'name' => 'required|unique:brands,name,'. $id,
            'name_ar' => 'required|unique:brands,name_ar,'. $id,
        ]);
        $input = request()->only(['name','name_ar']);
        if(request('isImageDelete')==1) {
            Storage::delete(Brand::DIR_PUBLIC . $brand->image);
            $input['image'] =null;
        }
        if(request()->hasFile('image')) {
            $extension = request('image')->extension();
            $fileName = 'brand_pic_' . date('YmdHis') . '.' . $extension;
            request('image')->storeAs('brands', $fileName);
            $input['image'] =$fileName;
        }
        $input['user_id'] =Auth::id();
        $brand->update($input);
        return redirect()->route('admin.brands.index')->with(['success'=>'Brand Updated Successfully']);
    }

    public function destroy($id) {
        $brand = Brand::find(decrypt($id));
        if(!empty($brand->image)) {
            Storage::delete(Brand::DIR_PUBLIC . $brand->image);
            $input['image'] =null;
        }
        $brand->delete();
        return redirect()->route('admin.brands.index')->with(['success'=>'Brand Deleted Successfully']);
    }

    public function changeStatus($id) {
        $brand = Brand::find(decrypt($id));
        $currentStatus = $brand->status;
        $status = $currentStatus ? 0 : 1;
        $brand->update(['status'=>$status]);
        return redirect()->route('admin.brands.index')->with(['success'=>'Status changed Successfully']);
    }
}
