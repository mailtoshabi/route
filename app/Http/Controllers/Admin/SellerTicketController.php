<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Utilities\Utility;
use App\Models\SellerTicket;
use App\Models\TicketReply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SellerTicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tickets = SellerTicket::orderBy('id')->paginate(Utility::PAGINATE_COUNT);
        return view('admin.sellers.tickets',compact('tickets'));
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
     * @param  \App\Models\SellerTicket  $sellerTicket
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $ticket = SellerTicket::findOrFail(decrypt($id));
        return view('admin.sellers.ticket_show',compact('ticket'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SellerTicket  $sellerTicket
     * @return \Illuminate\Http\Response
     */
    public function edit(SellerTicket $sellerTicket)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SellerTicket  $sellerTicket
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SellerTicket $sellerTicket)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SellerTicket  $sellerTicket
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $seller = SellerTicket::find(decrypt($id));
        $seller->delete();
        return redirect()->route('admin.sellers.tickets.index')->with(['success'=>'Ticket Deleted Successfully']);
    }

    public function changeApproval($id) {
        $seller = SellerTicket::find(decrypt($id));
        $currentApproval = $seller->approve;
        $approve = $currentApproval==1 ? 0 : 1;
        $seller->update(['approve'=>$approve]);
        return redirect()->route('admin.sellers.tickets.index')->with(['success'=>'Status changed Successfully']);
    }

    public function changeStatus($id,$status) {
        $seller = SellerTicket::find(decrypt($id));
        $seller->update(['status'=>$status]);
        return redirect()->route('admin.sellers.tickets.index')->with(['success'=>'Status changed Successfully']);
    }

    public function store_reply()
    {
        $validated = request()->validate([
            'description' => 'required',
        ]);
        $ticket_id = decrypt(request('ticket_replyable_id'));

        $seller_ticket = SellerTicket::find($ticket_id);

        $ticket_reply = new TicketReply;
        $ticket_reply->description = request('description');
        $ticket_reply->user_id = Auth::id();

        $seller_ticket->replies()->save($ticket_reply);

        $seller_ticket->status = Utility::TICKET_ADMIN_REPLIED;
        $seller_ticket->save();

        return redirect()->back();
    }
}
