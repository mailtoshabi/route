<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Utilities\Utility;
use App\Models\Faq;
use App\Models\FaqType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FaqController extends Controller
{
    public function index()
    {
        $faqs = Faq::orderBy('id')->paginate(Utility::PAGINATE_COUNT);
        return view('admin.faqs.index',compact('faqs'));
    }

    public function create() {
        $faq_types = FaqType::all();
        return view('admin.faqs.add',compact('faq_types'));
    }

    public function store () {
        $validated = request()->validate([
            'title' => 'required',
            'description' => 'required',
            'faq_type_id' => 'required',
        ]);
        $input = request()->only(['title','description','faq_type_id','status']);

        $input['user_id'] =Auth::id();
        $faq = Faq::create($input);
        return redirect()->route('admin.faqs.index')->with(['success'=>'New Faq Added Successfully']);
    }

    public function edit($id) {
        $faq = Faq::findOrFail(decrypt($id));
        $faq_types = FaqType::all();
        return view('admin.faqs.add',compact('faq','faq_types'));
    }

    public function update () {
        $id = decrypt(request('faq_id'));
        $faq = Faq::find($id);
        $validated = request()->validate([
            'title' => 'required',
            'description' => 'required',
            'faq_type_id' => 'required',
        ]);
        $input = request()->only(['title','description','faq_type_id','status']);
        $faq->update($input);
        return redirect()->route('admin.faqs.index')->with(['success'=>'Faq Updated Successfully']);
    }

    public function destroy($id) {
        $faq = Faq::find(decrypt($id));
        $faq->delete();
        return redirect()->route('admin.faqs.index')->with(['success'=>'Faq Deleted Successfully']);
    }

    public function changeStatus($id) {
        $faq = Faq::find(decrypt($id));
        $currentStatus = $faq->status;
        $status = $currentStatus ? 0 : 1;
        $faq->update(['status'=>$status]);
        return redirect()->route('admin.faqs.index')->with(['success'=>'Status changed Successfully']);
    }
}
