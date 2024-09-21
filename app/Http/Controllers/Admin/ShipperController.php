<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Utilities\Utility;
use App\Models\Delivery;
use App\Models\Shipper;
use Illuminate\Http\Request;

class ShipperController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $shippers = Shipper::where('status',Utility::ITEM_ACTIVE)->orderBy('id')->paginate(Utility::PAGINATE_COUNT);
        return view('admin.shippers.index',compact('shippers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $shipper = Shipper::find(decrypt($id));
        return view('admin.shippers.show',compact('shipper'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function edit($id)
    // {

    //     $banks=Bank::all();
    //     $shipper = Shipper::find(decrypt($id));
    //     return view('admin.shippers.edit',compact('shipper','banks'));
    // }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function update($id)
    // {
    //     $id = decrypt($id);
    //     $shipper = Shipper::find($id);
    //     return $shipper;
    //     $validated = request()->validate([
    //         'first_name' => 'required',
    //         'last_name' => 'required',
    //         'legal_name' => 'required',
    //         'email' => 'required|unique:shippers,email,'. $id,
    //     ]);
    //     $input = request()->except(['email_verified_at','_token','_method']);
    //     $input['user_id'] =Auth::id();
    //     $shipper->update($input);
    //     return redirect()->route('admin.shippers.index')->with(['success'=>'Shipper Updated Successfully']);
    // }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function destroy($id)
    // {
    //     $post = Shipper::find(decrypt($id))->delete();
    //     return response()->json(['success'=>'Vendor Deleted successfully']);
    // }

    // public function changeStatus($id) {
    //     $shipper = Shipper::find(decrypt($id));
    //     $currentStatus = $shipper->status;
    //     $status = $currentStatus ? 0 : 1;
    //     $shipper->update(['status'=>$status]);
    //     return redirect()->route('admin.shippers.index')->with(['success'=>'Status changed Successfully']);
    // }

    public function active_orders($id)
    {
        $deliveries = Delivery::orderBy('id')
        ->join('drivers','drivers.id','=','deliveries.driver_id')
        ->join("shippers",function($join){
        $join->on("shippers.id","=","drivers.driverable_id")
            ->where('drivers.driverable_type', 'App\Models\Shipper');
        })
        ->where('shippers.id',decrypt($id))
        ->where('deliveries.status','!=',Utility::STATUS_RETURN_WAREHOUSE)
        ->select('deliveries.*')
        ->paginate(Utility::PAGINATE_COUNT);
        $shipper_name = Shipper::where('id',decrypt($id))->pluck('name')->first();
        return view('admin.shippers.orders',compact('deliveries','shipper_name'));
    }

    public function history_orders($id)
    {
        $deliveries = Delivery::orderBy('id')
        ->join('drivers','drivers.id','=','deliveries.driver_id')
        ->join("shippers",function($join){
        $join->on("shippers.id","=","drivers.driverable_id")
            ->where('drivers.driverable_type', 'App\Models\Shipper');
        })
        ->where('shippers.id',decrypt($id))
        ->where('deliveries.status',Utility::STATUS_RETURN_WAREHOUSE)
        ->select('deliveries.*')
        ->paginate(Utility::PAGINATE_COUNT);
        $shipper_name = Shipper::where('id',decrypt($id))->pluck('name')->first();
        return view('admin.shippers.orders',compact('deliveries','shipper_name'));
    }

    public function show_deliveries($id)
    {
        $delivery = Delivery::find(decrypt($id));
        $customer = $delivery->deliverable_type=='App\Models\ProductSale'? $delivery->deliverable->sale->customer:$delivery->deliverable->customer;
        // return $delivery;
        return view('admin.shippers.show_deliveries',compact('delivery','customer'));
    }

}
