<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Utilities\Utility;
use App\Models\CustomerTicket;
use App\Models\TicketReply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CustomerTicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tickets = CustomerTicket::orderBy('id')->paginate(Utility::PAGINATE_COUNT);
        return view('admin.customers.tickets',compact('tickets'));
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
     * @param  \App\Models\CustomerTicket  $customerTicket
     * @return \Illuminate\Http\Response
     */
    public function show ($id)
    {
        $ticket = CustomerTicket::findOrFail(decrypt($id));
        return view('admin.customers.ticket_show', compact('ticket'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CustomerTicket  $customerTicket
     * @return \Illuminate\Http\Response
     */
    public function edit(CustomerTicket $customerTicket)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CustomerTicket  $customerTicket
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CustomerTicket $customerTicket)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CustomerTicket  $customerTicket
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $customer = CustomerTicket::find(decrypt($id));
        $customer->delete();
        return redirect()->route('admin.customers.tickets.index')->with(['success'=>'Ticket Deleted Successfully']);
    }

    public function changeApproval($id) {
        $customer = CustomerTicket::find(decrypt($id));
        $currentApproval = $customer->approve;
        $approve = $currentApproval==1 ? 0 : 1;
        $customer->update(['approve'=>$approve]);
        return redirect()->route('admin.customers.tickets.index')->with(['success'=>'Status changed Successfully']);
    }

    public function changeStatus($id,$status) {
        $customer = CustomerTicket::find(decrypt($id));
        $customer->update(['status'=>$status]);
        return redirect()->route('admin.customers.tickets.index')->with(['success'=>'Status changed Successfully']);
    }

    public function store_reply()
    {
        $validated = request()->validate([
            'description' => 'required',
        ]);
        $ticket_id = decrypt(request('ticket_replyable_id'));

        $customer_ticket = CustomerTicket::find($ticket_id);

        $ticket_reply = new TicketReply;
        $ticket_reply->description = request('description');
        $ticket_reply->user_id = Auth::id();

        $customer_ticket->replies()->save($ticket_reply);

        $customer_ticket->status = Utility::TICKET_ADMIN_REPLIED;
        $customer_ticket->save();

        return redirect()->back();
    }
}
