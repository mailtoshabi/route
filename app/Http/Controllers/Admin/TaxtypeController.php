<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TaxType;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TaxtypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $tax_type = TaxType::orderBy('id','desc')->get();

            return DataTables::of($tax_type)

                ->addColumn('name', function ($row) {
                    return $row->name;
                })
                ->addColumn('perc', function ($row) {
                        return $row->perc;
                })
                ->addColumn('user_id', function ($row) {
                        return $row->user->name;
                })
                ->addColumn('created_at', function ($row) {
                    return $row->created_at->format('d/m/Y');
                })
                ->addColumn('action', function ($row) {
                    $btn = ' <a href="' . route('admin.settings.tax-types.edit', $row->id) . '" class="text-success"><i class="mdi mdi-pencil font-size-18"></i></a>';

                        $btn .= '
                        <a href="javascript:void(0);" class="text-danger" onclick="deletePost('. $row->id .')"><i class="delete mdi mdi-delete font-size-18"></i></a>';

                    return $btn;
                })

                ->rawColumns(['name','perc','action','created_at','user_id'])
                ->make(true);
        }

        return view('admin.settings.tax-types');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.settings.tax-types-add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $post = TaxType::updateOrCreate(['id' => $request->post_id], [
            'name' => $request->name,
            'perc' => $request->perc,
            'user_id' => auth()->user()->id,
            'created_at' =>new \DateTime(),
            'updated_at'=>new \DateTime()
          ]);

          if($request->post_id >0)
          {
           return redirect()->route('admin.settings.tax-types.index')->with('save_message', 'Tax Type Updated Successfully');
          }
          else
          {
           return redirect()->route('admin.settings.tax-types.index')->with('save_message', 'Tax Type Saved Successfully');
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
        $delivery_charge = TaxType::find($id);
      return view('admin.settings.tax-types-add',compact('delivery_charge'));
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = TaxType::find($id)->delete();
        return response()->json(['success'=>'Vendor Deleted successfully']);
    }
}
