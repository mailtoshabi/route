<?php

namespace App\Http\Controllers\Branch;

use App\Http\Controllers\Controller;
use App\Http\Utilities\Utility;
use App\Models\Sale;
use Illuminate\Http\Request;

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
        return view('branches.sales.index',compact('sales'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

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
        $html = view('branches.sales.show',compact('sale'))->render();
        return response()->json(['html'=>$html]);
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
        return redirect()->route('branch.sales.index')->with(['success'=>'Status changed Successfully']);
    }
}
