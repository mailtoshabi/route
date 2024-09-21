<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Utilities\Utility;
use App\Models\CustomerReview;
use Illuminate\Http\Request;

class CustomerReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reviews = CustomerReview::orderBy('id')->paginate(Utility::PAGINATE_COUNT);
        return view('admin.products.customer-reviews',compact('reviews'));
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
     * @param  \App\Models\CustomerReview  $customerReview
     * @return \Illuminate\Http\Response
     */
    public function show(CustomerReview $customerReview)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CustomerReview  $customerReview
     * @return \Illuminate\Http\Response
     */
    public function edit(CustomerReview $customerReview)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CustomerReview  $customerReview
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CustomerReview $customerReview)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CustomerReview  $customerReview
     * @return \Illuminate\Http\Response
     */
    public function destroy(CustomerReview $customerReview)
    {
        //
    }

    public function changeStatus($id) {
        $review = CustomerReview::find(decrypt($id));
        $currentStatus = $review->status;
        $status = $currentStatus ? 0 : 1;
        $review->update(['status'=>$status]);
        return redirect()->route('admin.products.reviews.index')->with(['success'=>'Status changed Successfully']);
    }
}
