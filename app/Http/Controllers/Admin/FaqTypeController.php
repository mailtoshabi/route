<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Utilities\Utility;
use App\Models\FaqType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class FaqTypeController extends Controller
{
    public function index() {
        $faq_types = FaqType::orderBy('id')->paginate(Utility::PAGINATE_COUNT);
        return view('admin.faqs.types.index',compact('faq_types'));
    }

    public function create() {
        $faq_types = FaqType::all();
        return view('admin.faqs.types.add',compact('faq_types'));
    }

    public function store () {
        $validated = request()->validate([
            'name' => 'required|unique:faq_types,name',
            'name_ar' => 'required|unique:faq_types,name_ar'
        ]);
        $input = request()->only(['name', 'name_ar']);
        $input['user_id'] =Auth::id();
        $faq_type = FaqType::create($input);
        return redirect()->route('admin.faqs.types.index')->with(['success'=>'New Faq Type Added Successfully']);
    }

    public function edit($id) {
        $faq_type = FaqType::findOrFail(decrypt($id));
        $faq_types = FaqType::all();
        return view('admin.faqs.types.add',compact('faq_types', 'faq_type'));
    }

    public function update () {
        $id = decrypt(request('faq_type_id'));
        $faq_type = FaqType::find($id);
        //return FaqType::DIR_PUBLIC . $faq_type->image;
        $validated = request()->validate([
            'name' => 'required|unique:faq_types,name,'. $id,
            'name_ar' => 'required|unique:faq_types,name_ar,'. $id
        ]);
        $input = request()->only(['name', 'name_ar']);
        $input['user_id'] =Auth::id();
        $faq_type->update($input);
        return redirect()->route('admin.faqs.types.index')->with(['success'=>'Faq Type Updated Successfully']);
    }

    public function destroy($id) {
        $faq_type = FaqType::find(decrypt($id));
        $faq_type->delete();
        return redirect()->route('admin.faqs.types.index')->with(['success'=>'Faq Type Deleted Successfully']);
    }

    public function changeStatus($id) {
        $faq_type = FaqType::find(decrypt($id));
        $currentStatus = $faq_type->status;
        $status = $currentStatus ? 0 : 1;
        $faq_type->update(['status'=>$status]);
        return redirect()->route('admin.faqs.types.index')->with(['success'=>'Status changed Successfully']);
    }
}
