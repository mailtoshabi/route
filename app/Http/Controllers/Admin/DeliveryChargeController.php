<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DeliveryCharge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeliveryChargeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $delivery_charge = DeliveryCharge::first();
        return view('admin.settings.delivery-charge',compact('delivery_charge'));
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
        $request->validate([
            'min_order_amount' => 'required',
            'delivery_charge' => 'required',
        ]);

        $delivery_charge = new DeliveryCharge();

        $delivery_charge->min_order_amount   =  $request->min_order_amount;
        $delivery_charge->delivery_charge   =  $request->delivery_charge??0;
        $delivery_charge->user_id =  Auth::user()->id;
        $delivery_charge->save();

        if($delivery_charge){
            $success_message = "Delivery charge added successfully";
            return  redirect()->route('admin.settings.delivery-charge.index')->with('success_message', $success_message);
        }
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $product = DeliveryCharge::findOrFail($request->delivery_charge_id);

        $request->validate([
            'min_order_amount' => 'required',
            'delivery_charge' => 'required',
        ]);

        $product->min_order_amount = $request->input("min_order_amount");
        $product->delivery_charge = $request->input("delivery_charge");
        $product->update();

        return  redirect()->route('admin.settings.delivery-charge.index')->with('success_message', 'Delivery charge updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
