<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Utilities\Utility;
use App\Models\Driver;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class VehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $vehicles = Vehicle::orderBy('id')->paginate(Utility::PAGINATE_COUNT);
        return view('admin.vehicles.index',compact('vehicles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $drivers = Driver::all();
        // return $drivers;
        return view('admin.vehicles.add',compact('drivers'));
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
            'driver_id' => 'required',
            'manufacture' => 'required',
            'model' => 'required',
            'vnumber' => 'required',
        ]);
        $input = request()->except(['_token','image',]);
        if(request()->hasFile('image')) {
            $extension = request('image')->extension();
            $fileName = 'vehicle_pic_' . date('YmdHis') . '.' . $extension;
            request('image')->storeAs('vehicles', $fileName);
            $input['image'] =$fileName;
        }
        $input['user_id'] =Auth::id();
        $vehicle = Vehicle::create($input);
        return redirect()->route('admin.vehicles.index')->with(['success'=>'New Vehicle Added Successfully']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function show(Vehicle $vehicle)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $drivers = Driver::all();
        $vehicle = Vehicle::findOrFail(decrypt($id));
        return view('admin.vehicles.add',compact('vehicle','drivers'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        $vehicle = Vehicle::find(decrypt($id));
        //return Vehicle::DIR_PUBLIC . $vehicle->image;
        $validated = request()->validate([
            'driver_id' => 'required',
            'manufacture' => 'required',
            'model' => 'required',
            'vnumber' => 'required',
        ]);
        $input = request()->except(['_token','_method','image',]);
        if(request('isImageDelete')==1) {
            Storage::delete(Vehicle::DIR_PUBLIC . $vehicle->image);
            $input['image'] =null;
        }
        if(request()->hasFile('image')) {
            $extension = request('image')->extension();
            $fileName = 'vehicle_pic_' . date('YmdHis') . '.' . $extension;
            request('image')->storeAs('vehicles', $fileName);
            $input['image'] =$fileName;
        }
        //$input['user_id'] =Auth::id();
        $vehicle->update($input);
        return redirect()->route('admin.vehicles.index')->with(['success'=>'Vehicle Updated Successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $vehicle = Vehicle::find(decrypt($id));
        if(!empty($vehicle->image)) {
            Storage::delete(Vehicle::DIR_PUBLIC . $vehicle->image);
            $input['image'] =null;
        }
        $vehicle->delete();
        return redirect()->route('admin.vehicles.index')->with(['success'=>'Vehicle Deleted Successfully']);
    }

    public function changeStatus($id) {
        $vehicle = Vehicle::find(decrypt($id));
        $currentStatus = $vehicle->status;
        $status = $currentStatus ? 0 : 1;
        $vehicle->update(['status'=>$status]);
        return redirect()->route('admin.vehicles.index')->with(['success'=>'Status changed Successfully']);
    }
}
