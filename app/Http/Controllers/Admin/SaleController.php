<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Utilities\Utility;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sales = Sale::orderBy('id')->paginate(Utility::PAGINATE_COUNT);
        // return $sales;
        return view('admin.sales.index',compact('sales'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.sales.add');
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
        $sale = Sale::find(decrypt($id));
        return view('admin.sales.show',compact('sale'));
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
        // return 'hi';
        $sale = Sale::find(decrypt($id));
        $new_status = decrypt($status);

        $sale->update(['status'=>$new_status, Utility::saleStatus()[$new_status]['date_field']=>now()]);
        return redirect()->route('admin.sales.index')->with(['success'=>'Status changed Successfully']);
    }
}
