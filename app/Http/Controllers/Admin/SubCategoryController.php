<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Utilities\Utility;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class SubCategoryController extends Controller
{
    public function index() {
        $sub_categories = SubCategory::orderBy('id')->paginate(Utility::PAGINATE_COUNT);
        return view('admin.sub_categories.index',compact('sub_categories'));
    }

    public function create() {
        $categories = Category::all();
        return view('admin.sub_categories.add',compact('categories'));
    }

    public function store () {
        $validated = request()->validate([
            'name' => 'required|unique:sub_categories,name',
            'name_ar' => 'required|unique:sub_categories,name_ar'
        ]);
        $input = request()->only(['name', 'name_ar', 'category_id', 'meta_title', 'meta_keywords','meta_description']);
        if(request()->hasFile('image')) {
            $extension = request('image')->extension();
            $fileName = 'category_pic_' . date('YmdHis') . '.' . $extension;
            request('image')->storeAs('sub_categories', $fileName);
            $input['image'] =$fileName;
        }
        $input['user_id'] =Auth::id();
        $category = SubCategory::create($input);
        return redirect()->route('admin.sub_categories.index')->with(['success'=>'New SubCategory Added Successfully']);
    }

    public function edit($id) {
        $category = SubCategory::findOrFail(decrypt($id));
        $categories = Category::all();
        return view('admin.sub_categories.add',compact('categories', 'category'));
    }

    public function update () {
        $id = decrypt(request('category_id'));
        $category = SubCategory::find($id);
        //return SubCategory::DIR_PUBLIC . $category->image;
        $validated = request()->validate([
            'name' => 'required|unique:sub_categories,name,'. $id,
            'name_ar' => 'required|unique:sub_categories,name_ar,'. $id
        ]);
        $input = request()->only(['name', 'name_ar', 'category_id', 'meta_title', 'meta_keywords','meta_description']);
        if(request('isImageDelete')==1) {
            Storage::delete(SubCategory::DIR_PUBLIC . $category->image);
            $input['image'] =null;
        }
        if(request()->hasFile('image')) {
            $extension = request('image')->extension();
            $fileName = 'category_pic_' . date('YmdHis') . '.' . $extension;
            request('image')->storeAs('sub_categories', $fileName);
            $input['image'] =$fileName;
        }
        $input['user_id'] =Auth::id();
        $category->update($input);
        return redirect()->route('admin.sub_categories.index')->with(['success'=>'SubCategory Updated Successfully']);
    }

    public function destroy($id) {
        $category = SubCategory::find(decrypt($id));
        if(!empty($category->image)) {
            Storage::delete(SubCategory::DIR_PUBLIC . $category->image);
            $input['image'] =null;
        }
        $category->delete();
        return redirect()->route('admin.sub_categories.index')->with(['success'=>'Sub Category Deleted Successfully']);
    }

    public function changeStatus($id) {
        $category = SubCategory::find(decrypt($id));
        $currentStatus = $category->status;
        $status = $currentStatus ? 0 : 1;
        $category->update(['status'=>$status]);
        return redirect()->route('admin.sub_categories.index')->with(['success'=>'Status changed Successfully']);
    }
}
