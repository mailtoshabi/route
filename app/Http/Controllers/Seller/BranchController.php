<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Http\Utilities\Utility;
use App\Models\Branch;
use App\Models\ProductItem;
use App\Models\SalesItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BranchController extends Controller
{
    public function index() {
        $branches = Branch::orderBy('id')->paginate(Utility::PAGINATE_COUNT);
        return view('seller.branches.index',compact('branches'));
    }

    public function create() {
        return view('seller.branches.add');
    }

    public function store () {
        $validated = request()->validate([
            'name' => 'required|unique:branches,name',
            'name_ar' => 'required|unique:branches,name_ar',
            'email' => 'required|email|unique:customers,email',
            'password' => 'required|min:6',
        ]);
        $input = request()->except(['_token','email_verified_at','isImageDelete']);
        if(request()->hasFile('image')) {
            $extension = request('image')->extension();
            $fileName = 'branch_pic_' . date('YmdHis') . '.' . $extension;
            request('image')->storeAs('branches', $fileName);
            $input['image'] =$fileName;
        }
        $input['user_id'] =Auth::id();
        $branch = Branch::create($input);
        return redirect()->route('seller.branches.index')->with(['success'=>'New Branch Added Successfully']);
    }

    public function edit($id) {
        $branch = Branch::findOrFail(decrypt($id));
        return view('seller.branches.add',compact('branch'));
    }

    public function view($id) {
        $branch = Branch::findOrFail(decrypt($id));
        return view('seller.branches.view',compact('branch'));
    }

    public function update () {
        $id = decrypt(request('branch_id'));
        $branch = Branch::find($id);
        $validated = request()->validate([
            'name' => 'required|unique:branches,name,'. $id,
            'name_ar' => 'required|unique:branches,name_ar,'. $id,
            'email' => 'required|unique:customers,email,'. $id,
            'password' => 'required|min:6',
        ]);
        $input = request()->only(['_token','_method','email_verified_at','isImageDelete']);
        if(request('isImageDelete')==1) {
            Storage::delete(Branch::DIR_PUBLIC . $branch->image);
            $input['image'] =null;
        }
        if(request()->hasFile('image')) {
            $extension = request('image')->extension();
            $fileName = 'branch_pic_' . date('YmdHis') . '.' . $extension;
            request('image')->storeAs('branches', $fileName);
            $input['image'] =$fileName;
        }
        //$input['user_id'] =Auth::id();
        $branch->update($input);
        return redirect()->route('seller.branches.index')->with(['success'=>'Branch Updated Successfully']);
    }

    public function destroy($id) {
        $branch = Branch::find(decrypt($id));
        if(!empty($branch->image)) {
            Storage::delete(Branch::DIR_PUBLIC . $branch->image);
            $input['image'] =null;
        }
        $branch->delete();
        return redirect()->route('seller.branches.index')->with(['success'=>'Branch Deleted Successfully']);
    }

    public function changeStatus($id) {
        $branch = Branch::find(decrypt($id));
        $currentStatus = $branch->status;
        $status = $currentStatus ? 0 : 1;
        $branch->update(['status'=>$status]);
        return redirect()->route('seller.branches.index')->with(['success'=>'Status changed Successfully']);
    }
}
