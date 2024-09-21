<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Utilities\Utility;
use App\Models\Delivery;
use App\Models\Driver;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DriverController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $drivers = Driver::orderBy('id')->paginate(Utility::PAGINATE_COUNT);
        return view('admin.drivers.index',compact('drivers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.drivers.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $validated = request()->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:drivers,email',
            'password' => 'required|min:6',
        ]);
        $input = request()->except(['_token','email_verified_at',]);
        if(request()->hasFile('image')) {
            $extension = request('image')->extension();
            $fileName = 'driver_pic_' . date('YmdHis') . '.' . $extension;
            request('image')->storeAs('drivers', $fileName);
            $input['image'] =$fileName;
        }
        $input['user_id'] =Auth::id();
        $driver = Driver::create($input);
        return redirect()->route('admin.drivers.index')->with(['success'=>'New Driver Added Successfully']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Driver  $driver
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $driver = Driver::findOrFail(decrypt($id));
        $req_type = 1;
        $reviews = $driver->reviews;
        return view('admin.drivers.view',compact('driver','req_type','reviews'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Driver  $driver
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $driver = Driver::findOrFail(decrypt($id));
        return view('admin.drivers.add',compact('driver'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Driver  $driver
     * @return \Illuminate\Http\Response
     */
    public function update()
    {
        $id = decrypt(request('driver_id'));
        $driver = Driver::find($id);
        //return Driver::DIR_PUBLIC . $driver->image;
        $validated = request()->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|unique:drivers,email,'. $id,
            'password' => 'required|min:6',
        ]);
        $input = request()->except(['_token','_method','email_verified_at',]);
        if(request('isImageDelete')==1) {
            Storage::delete(Driver::DIR_PUBLIC . $driver->image);
            $input['image'] =null;
        }
        if(request()->hasFile('image')) {
            $extension = request('image')->extension();
            $fileName = 'driver_pic_' . date('YmdHis') . '.' . $extension;
            request('image')->storeAs('drivers', $fileName);
            $input['image'] =$fileName;
        }
        //$input['user_id'] =Auth::id();
        $driver->update($input);
        return redirect()->route('admin.drivers.index')->with(['success'=>'Driver Updated Successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Driver  $driver
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $driver = Driver::find(decrypt($id));
        if(!empty($driver->image)) {
            Storage::delete(Driver::DIR_PUBLIC . $driver->image);
            $input['image'] =null;
        }
        $driver->delete();
        return redirect()->route('admin.drivers.index')->with(['success'=>'Driver Deleted Successfully']);
    }

    public function changeStatus($id) {
        $driver = Driver::find(decrypt($id));
        $currentStatus = $driver->status;
        $status = $currentStatus ? 0 : 1;
        $driver->update(['status'=>$status]);
        return redirect()->route('admin.drivers.index')->with(['success'=>'Status changed Successfully']);
    }

    public function active_orders()
    {
        $deliveries = Delivery::orderBy('id')->where('status','!=',Utility::STATUS_RETURN_WAREHOUSE)
                    ->paginate(Utility::PAGINATE_COUNT);
        return view('admin.drivers.orders',compact('deliveries'));
    }

    public function history_orders()
    {
        $deliveries = Delivery::orderBy('id')->where('status',Utility::STATUS_RETURN_WAREHOUSE)
                    ->paginate(Utility::PAGINATE_COUNT);
        return view('admin.drivers.orders',compact('deliveries'));
    }
}
