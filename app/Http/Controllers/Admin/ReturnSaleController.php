<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Utilities\Utility;
use App\Models\ReturnSale;

class ReturnSaleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $return_sales = ReturnSale::orderBy('id')->paginate(Utility::PAGINATE_COUNT);
        // return $return_sales;
        return view('admin.return_sales.index',compact('return_sales'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // return view('admin.return_sales.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Purchase  $sale
     * @return \Illuminate\Http\Response
     */

    public function show($id)
    {
        $return_sale = ReturnSale::find(decrypt($id));
        return view('admin.return_sales.show',compact('return_sale'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Purchase  $sale
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Purchase  $sale
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Purchase  $sale
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

    }

    public function changeStatus($id,$status) {
        $sale = ReturnSale::find(decrypt($id));
        $new_status = decrypt($status);

        $sale->update(['status'=>$new_status, Utility::saleStatus()[$new_status]['date_field']=>now()]);
        return redirect()->route('admin.return_sales.index')->with(['success'=>'Status changed Successfully']);
    }

    public function invoice_view($id)
    {
        $order_return = ReturnSale::find(decrypt($id));
        // return $order_return;
        return view('admin.return_sales.invoice_view',compact('order_return'));
    }
}
