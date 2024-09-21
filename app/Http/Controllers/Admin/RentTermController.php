<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Utilities\Utility;
use App\Models\RentTerm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RentTermController extends Controller
{
    public function index() {
        $rent_terms = RentTerm::orderBy('id')->paginate(Utility::PAGINATE_COUNT);
        return view('admin.rent_products.rent_terms.index',compact('rent_terms'));
    }

    public function create() {
        return view('admin.rent_products.rent_terms.add');
    }

    public function store () {
        $validated = request()->validate([
            'name' => 'required|unique:rent_terms,name',
            'name_ar' => 'required|unique:rent_terms,name_ar',
            'rent_term_type_id' => 'required',
            'days' => 'required',
        ]);
        $input = request()->only(['name','name_ar','rent_term_type_id','days']);
        $input['user_id'] =Auth::id();
        $rent_term = RentTerm::create($input);
        return redirect()->route('admin.rent_products.rent_terms.index')->with(['success'=>'New RentTerm Added Successfully']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RentTerm  $rentTerm
     * @return \Illuminate\Http\Response
     */
    public function show(RentTerm $rentTerm)
    {
        //
    }

    public function edit($id) {
        $rent_term = RentTerm::findOrFail(decrypt($id));
        return view('admin.rent_products.rent_terms.add',compact('rent_term'));
    }

    public function update () {
        $id = decrypt(request('rent_term_id'));
        $rent_term = RentTerm::find($id);
        $validated = request()->validate([
            'name' => 'required|unique:rent_terms,name,'. $id,
            'name_ar' => 'required|unique:rent_terms,name_ar,'. $id,
            'rent_term_type_id' => 'required',
            'days' => 'required',
        ]);
        $input = request()->only(['name','name_ar','rent_term_type_id','days']);
        $input['user_id'] =Auth::id();
        $rent_term->update($input);
        return redirect()->route('admin.rent_products.rent_terms.index')->with(['success'=>'RentTerm Updated Successfully']);
    }

    public function destroy($id) {
        $rent_term = RentTerm::find(decrypt($id));
        $rent_term->delete();
        return redirect()->route('admin.rent_products.rent_terms.index')->with(['success'=>'RentTerm Deleted Successfully']);
    }

    public function changeStatus($id) {
        $rent_term = RentTerm::find(decrypt($id));
        $currentStatus = $rent_term->status;
        $status = $currentStatus ? 0 : 1;
        $rent_term->update(['status'=>$status]);
        return redirect()->route('admin.rent_products.rent_terms.index')->with(['success'=>'Status changed Successfully']);
    }
}
