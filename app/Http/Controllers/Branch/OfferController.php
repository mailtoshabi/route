<?php

namespace App\Http\Controllers\Branch;

use App\Http\Controllers\Controller;
use App\Http\Utilities\Utility;
use App\Models\Offer;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OfferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $offers = Offer::orderBy('id')->paginate(Utility::PAGINATE_COUNT);
        return view('branches.offers.index', compact('offers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $products = Product::active()->get();
        return view('branches.offers.add', compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return request()->all();
        $validated = request()->validate([
            'title' => 'required|unique:offers,title',
            'title_ar' => 'required',
            'discount' => 'required',
            'type' => 'required',
            'starts_at' => 'required',
            'ends_at' => 'required',
            'products' => 'required',
        ]);
        $productIds = [];
        foreach(request('products') as $product_id) {
            $productIds[] = decrypt($product_id);
        }
        $input = request()->except(['_token','user_id','products']);
        $input['user_id'] =Auth::id();
        $offer = Offer::create($input);
        $offer->products()->attach($productIds);
        return redirect()->route('branch.offers.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Offer  $offer
     * @return \Illuminate\Http\Response
     */
    public function show(Offer $offer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Offer  $offer
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $offer = Offer::findOrFail(decrypt($id));
        $products = Product::active()->get();
        return view('branches.offers.add', compact('offer', 'products'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Offer  $offer
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        $id = decrypt($id);
        $offer = Offer::find($id);

        $validated = request()->validate([
            'title' => 'required|unique:offers,title,'. $id,
            'title_ar' => 'required',
            'discount' => 'required',
            'type' => 'required',
            'starts_at' => 'required',
            'ends_at' => 'required',
            'products' => 'required',
        ]);

        $productIds = [];
        foreach(request('products') as $product_id) {
            $productIds[] = decrypt($product_id);
        }

        $input = request()->except(['_token','_method','user_id','products']);
        $input['user_id'] =Auth::id();
        $offer->update($input);
        $offer->products()->sync($productIds);
        return redirect()->route('branch.offers.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Offer  $offer
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $offer = Offer::find(decrypt($id));
        $offer->delete();
        return redirect()->route('branch.offers.index')->with(['success'=>'Offer Deleted Successfully']);
    }

    public function changeStatus($id) {
        $offer = Offer::find(decrypt($id));
        $currentStatus = $offer->status;
        $status = $currentStatus ? 0 : 1;
        $offer->update(['status'=>$status]);
        return redirect()->route('branch.offers.index')->with(['success'=>'Status changed Successfully']);
    }
}
