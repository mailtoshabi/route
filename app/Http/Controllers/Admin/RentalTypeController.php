<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Utilities\Utility;
use App\Models\RentalType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class RentalTypeController extends Controller
{
    public function index() {
        $rental_types = RentalType::orderBy('id')->paginate(Utility::PAGINATE_COUNT);
        return view('admin.rental_types.index',compact('rental_types'));
    }

    public function create() {
        $rental_types = RentalType::all();
        return view('admin.rental_types.add',compact('rental_types'));
    }

    public function store () {
        $validated = request()->validate([
            'name' => 'required|unique:rental_types,name',
            'name_ar' => 'required|unique:rental_types,name_ar'
        ]);
        $input = request()->only(['name', 'name_ar', 'meta_title', 'meta_keywords','meta_description']);
        if(request()->hasFile('image')) {
            $extension = request('image')->extension();
            $fileName = 'rental_type_pic_' . date('YmdHis') . '.' . $extension;
            request('image')->storeAs('rental_types', $fileName);
            $input['image'] =$fileName;
        }
        $input['user_id'] =Auth::id();
        $rental_type = RentalType::create($input);
        return redirect()->route('admin.rental_types.index')->with(['success'=>'New RentalType Added Successfully']);
    }

    public function edit($id) {
        $rental_type = RentalType::findOrFail(decrypt($id));
        $rental_types = RentalType::all();
        return view('admin.rental_types.add',compact('rental_types', 'rental_type'));
    }

    public function update () {
        $id = decrypt(request('rental_type_id'));
        $rental_type = RentalType::find($id);
        //return RentalType::DIR_PUBLIC . $rental_type->image;
        $validated = request()->validate([
            'name' => 'required|unique:rental_types,name,'. $id,
            'name_ar' => 'required|unique:rental_types,name_ar,'. $id
        ]);
        $input = request()->only(['name', 'name_ar', 'meta_title', 'meta_keywords','meta_description']);
        if(request('isImageDelete')==1) {
            Storage::delete(RentalType::DIR_PUBLIC . $rental_type->image);
            $input['image'] =null;
        }
        if(request()->hasFile('image')) {
            $extension = request('image')->extension();
            $fileName = 'rental_type_pic_' . date('YmdHis') . '.' . $extension;
            request('image')->storeAs('rental_types', $fileName);
            $input['image'] =$fileName;
        }
        $input['user_id'] =Auth::id();
        $rental_type->update($input);
        return redirect()->route('admin.rental_types.index')->with(['success'=>'RentalType Updated Successfully']);
    }

    public function destroy($id) {
        $rental_type = RentalType::find(decrypt($id));
        if(!empty($rental_type->image)) {
            Storage::delete(RentalType::DIR_PUBLIC . $rental_type->image);
            $input['image'] =null;
        }
        $rental_type->delete();
        return redirect()->route('admin.rental_types.index')->with(['success'=>'RentalType Deleted Successfully']);
    }

    public function changeStatus($id) {
        $rental_type = RentalType::find(decrypt($id));
        $currentStatus = $rental_type->status;
        $status = $currentStatus ? 0 : 1;
        $rental_type->update(['status'=>$status]);
        return redirect()->route('admin.rental_types.index')->with(['success'=>'Status changed Successfully']);
    }
}
