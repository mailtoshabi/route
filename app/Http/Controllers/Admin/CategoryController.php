<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Utilities\Utility;
use App\Models\Category;
use App\Models\RentalType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class CategoryController extends Controller
{
    public function index() {
        $categories = Category::orderBy('id')->paginate(Utility::PAGINATE_COUNT);
        return view('admin.categories.index',compact('categories'));
    }

    public function create() {
        $rental_types = RentalType::all();
        return view('admin.categories.add',compact('rental_types'));
    }

    public function store () {
        $validated = request()->validate([
            'name' => 'required|unique:categories,name',
            'name_ar' => 'required|unique:categories,name_ar'
        ]);
        $input = request()->only(['name', 'name_ar', 'rental_type_id', 'meta_title', 'meta_keywords','meta_description']);
        if(request()->hasFile('image')) {
            $extension = request('image')->extension();
            $fileName = 'category_pic_' . date('YmdHis') . '.' . $extension;
            request('image')->storeAs('categories', $fileName);
            $input['image'] =$fileName;
        }
        $input['user_id'] =Auth::id();
        $category = Category::create($input);
        return redirect()->route('admin.categories.index')->with(['success'=>'New Category Added Successfully']);
    }

    public function edit($id) {
        $category = Category::findOrFail(decrypt($id));
        $rental_types = Category::all();
        return view('admin.categories.add',compact('rental_types', 'category'));
    }

    public function update () {
        $id = decrypt(request('category_id'));
        $category = Category::find($id);
        //return Category::DIR_PUBLIC . $category->image;
        $validated = request()->validate([
            'name' => 'required|unique:categories,name,'. $id,
            'name_ar' => 'required|unique:categories,name_ar,'. $id
        ]);
        $input = request()->only(['name', 'name_ar', 'rental_type_id', 'meta_title', 'meta_keywords','meta_description']);
        if(request('isImageDelete')==1) {
            Storage::delete(Category::DIR_PUBLIC . $category->image);
            $input['image'] =null;
        }
        if(request()->hasFile('image')) {
            $extension = request('image')->extension();
            $fileName = 'category_pic_' . date('YmdHis') . '.' . $extension;
            request('image')->storeAs('categories', $fileName);
            $input['image'] =$fileName;
        }
        $input['user_id'] =Auth::id();
        $category->update($input);
        return redirect()->route('admin.categories.index')->with(['success'=>'Category Updated Successfully']);
    }

    public function destroy($id) {
        $category = Category::find(decrypt($id));
        if(!empty($category->image)) {
            Storage::delete(Category::DIR_PUBLIC . $category->image);
            $input['image'] =null;
        }
        $category->delete();
        return redirect()->route('admin.categories.index')->with(['success'=>'Category Deleted Successfully']);
    }

    public function changeStatus($id) {
        $category = Category::find(decrypt($id));
        $currentStatus = $category->status;
        $status = $currentStatus ? 0 : 1;
        $category->update(['status'=>$status]);
        return redirect()->route('admin.categories.index')->with(['success'=>'Status changed Successfully']);
    }
}
