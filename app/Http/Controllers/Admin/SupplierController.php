<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Utilities\Utility;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $suppliers = Supplier::orderBy('id')->paginate(Utility::PAGINATE_COUNT);
        return view('admin.suppliers.index',compact('suppliers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.suppliers.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = request()->validate([
            'name' => 'required',
            'name_ar' => 'required',
            'legal_name' => 'required',
            'email' => 'required|email|unique:suppliers,email',
        ]);
        $input = request()->except(['_token','_method']);
        if(request()->hasFile('image')) {
            $extension = request('image')->extension();
            $fileName = 'supplier_pic_' . date('YmdHis') . '.' . $extension;
            request('image')->storeAs('suppliers', $fileName);
            $input['image'] =$fileName;
        }
        $input['user_id'] =Auth::id();
        $supplier = Supplier::create($input);
        return redirect()->route('admin.suppliers.index')->with(['success'=>'New Supplier Added Successfully']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $supplier = Supplier::find(decrypt($id));
        return view('admin.suppliers.add',compact('supplier'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update()
    {
        $id = decrypt(request('supplier_id'));
        $supplier = Supplier::find($id);
        $validated = request()->validate([
            'name' => 'required',
            'name_ar' => 'required',
            'legal_name' => 'required',
            'email' => 'required|unique:suppliers,email,'. $id,
        ]);
        $input = request()->except(['_token','_method','supplier_id']);
        if(request('isImageDelete')==1) {
            Storage::delete(Supplier::DIR_PUBLIC . $supplier->image);
            $input['image'] =null;
        }
        if(request()->hasFile('image')) {
            $extension = request('image')->extension();
            $fileName = 'supplier_pic_' . date('YmdHis') . '.' . $extension;
            request('image')->storeAs('suppliers', $fileName);
            $input['image'] =$fileName;
        }
        $input['user_id'] =Auth::id();
        $supplier->update($input);
        return redirect()->route('admin.suppliers.index')->with(['success'=>'Supplier Updated Successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $supplier = Supplier::find(decrypt($id));
        if(!empty($supplier->image)) {
            Storage::delete(Supplier::DIR_PUBLIC . $supplier->image);
            $input['image'] =null;
        }
        $supplier->delete();
        return redirect()->route('admin.suppliers.index')->with(['success'=>'Supplier Deleted Successfully']);
    }

    public function changeStatus($id) {
        $supplier = Supplier::find(decrypt($id));
        $currentStatus = $supplier->status;
        $status = $currentStatus ? 0 : 1;
        $supplier->update(['status'=>$status]);
        return redirect()->route('admin.suppliers.index')->with(['success'=>'Status changed Successfully']);
    }
}
