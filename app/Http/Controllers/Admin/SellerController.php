<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Utilities\Utility;
use App\Models\Bank;
use App\Models\Sale;
use App\Models\SalesItem;
use App\Models\Seller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;
use Yajra\DataTables\Facades\DataTables;

class SellerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sellers = Seller::where('status',Utility::ITEM_ACTIVE)->orderBy('id')->paginate(Utility::PAGINATE_COUNT);
        return view('admin.sellers.index',compact('sellers'));
    }

    public function approved(Request $request)
    {
        $sellers = Seller::where('status',Utility::ITEM_ACTIVE)->orderBy('id')->paginate(Utility::PAGINATE_COUNT);
        $status = Utility::ITEM_INACTIVE;
        return view('admin.sellers.approved',compact('sellers','status'));
    }

    public function data($appr_status='')
    {
        if (request()->ajax()) {

            if(!empty($appr_status)) {
                $vendor_applications = Seller::where('status',$appr_status)->latest()->get();
            }else {
                $vendor_applications = Seller::all();
            }


            return DataTables::of($vendor_applications)

            ->addColumn('image',  function ($row) {
                if(!empty($row->image)){
                $file= URL::asset('storage/sellers/' . $row->image);
                return '<img src="'.$file.'" width="50px" height="50px"/>';
                }
                return '';

            })->escapeColumns([])
                ->addColumn('created_at', function ($row) {
                      return date('Y-m-d H:i:s',strtotime($row->created_at));
                })
                ->addColumn('status', function ($row) {
                    $btn = '';
                        $status = $row->status == 1 ? "checked" : '';
                        $btn .= '
                        <label class="form-check form-switch form-switch-sm form-check-custom form-check-solid">
                            <input class="form-check-input" ' . $status . ' type="checkbox" value="1" id="status_' . $row->id . '"
                                 onchange="changeStatus(' . encrypt($row->id) . ')"/>
                            <span class="form-check-label fw-bold text-muted" for="kt_modal_connected_accounts_google"></span>
                        </label>';

                    return $btn;
                })
                ->addColumn('action', function ($row) {
                    $btn = ' <a href="' . route('admin.sellers.edit', encrypt($row->id)) . '" class="text-success"><i class="mdi mdi-pencil font-size-18"></i></a>';

                        $btn .= '
                        <a href="javascript:void(0);" class="text-danger" onclick="deletePost('. encrypt($row->id) .')"><i class="delete mdi mdi-delete font-size-18"></i></a>';

                    return $btn;
                })

                ->rawColumns([ 'status','action','created_at','seller_image'])
                ->make(true);
        }

        return view('admin.sellers.index');
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
        $seller = Seller::find(decrypt($id));
        return view('admin.sellers.show',compact('seller'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $banks=Bank::all();
        $seller = Seller::find(decrypt($id));
        return view('admin.sellers.edit',compact('seller','banks'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        $id = decrypt($id);
        $seller = Seller::find($id);
        return $seller;
        $validated = request()->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'legal_name' => 'required',
            'email' => 'required|unique:sellers,email,'. $id,
        ]);
        $input = request()->except(['email_verified_at','_token','_method']);
        $input['user_id'] =Auth::id();
        $seller->update($input);
        return redirect()->route('admin.sellers.index')->with(['success'=>'Seller Updated Successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Seller::find(decrypt($id))->delete();
        return response()->json(['success'=>'Vendor Deleted successfully']);
    }


    public function download(Request $request)
    {
        if($request->type==1)
        {
            $file = public_path(). "/vat_scan/".$request->id;
        }
        else
        {
            $file = public_path(). "/cr_scan/".$request->id;
        }



        if (file_exists($file)) {
            return response()->download($file);
        } else {
            echo('File not found.');
        }
    }

    public function showtab($id) {
        $status = decrypt($id);
        $sellers = Seller::where('status',$status)->orderBy('id')->paginate(Utility::PAGINATE_COUNT);
        return view('admin.sellers.index',compact('sellers','status'));
    }

    public function changeStatus($id) {
        $seller = Seller::find(decrypt($id));
        $currentStatus = $seller->status;
        $status = $currentStatus ? 0 : 1;
        $seller->update(['status'=>$status]);
        return redirect()->route('admin.sellers.index')->with(['success'=>'Status changed Successfully']);
    }

    public function active_orders($id)
    {
        $orders = SalesItem::orderBy('id')
        ->join('product_items','product_items.id','=','sales_items.product_item_id')
        ->join('branches','branches.id','=','product_items.branch_id')
        ->join('sellers','sellers.id','=','branches.seller_id')
        ->where('sellers.id',decrypt($id))
        ->where('sales_items.status','!=',Utility::STATUS_CLOSED)
        ->select('sales_items.*')
        ->paginate(Utility::PAGINATE_COUNT);
        $seller_name = Seller::find(decrypt($id))->pluck('name');
        return view('admin.sellers.orders',compact('orders','seller_name'));
    }

    public function history_orders($id)
    {
        $orders = SalesItem::orderBy('id')
        ->join('product_items','product_items.id','=','sales_items.product_item_id')
        ->join('branches','branches.id','=','product_items.branch_id')
        ->join('sellers','sellers.id','=','branches.seller_id')
        ->where('sellers.id',decrypt($id))
        ->where('sales_items.status',Utility::STATUS_CLOSED)
        ->select('sales_items.*')
        ->paginate(Utility::PAGINATE_COUNT);
        $seller_name = Seller::find(decrypt($id))->pluck('name');
        return view('admin.sellers.orders',compact('orders','seller_name'));
    }

}
