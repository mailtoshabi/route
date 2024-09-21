<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Utilities\Utility;
use App\Models\DriverTicket;
use App\Models\TicketReply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DriverTicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tickets = DriverTicket::orderBy('id')->paginate(Utility::PAGINATE_COUNT);
        return view('admin.drivers.tickets',compact('tickets'));
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
     * @param  \App\Models\DriverTicket  $driverTicket
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $ticket = DriverTicket::findOrFail(decrypt($id));
        return view('admin.drivers.ticket_show',compact('ticket'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DriverTicket  $driverTicket
     * @return \Illuminate\Http\Response
     */
    public function edit(DriverTicket $driverTicket)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DriverTicket  $driverTicket
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DriverTicket $driverTicket)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DriverTicket  $driverTicket
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $driver = DriverTicket::find(decrypt($id));
        $driver->delete();
        return redirect()->route('admin.drivers.tickets.index')->with(['success'=>'Ticket Deleted Successfully']);
    }

    public function changeApproval($id) {
        $driver = DriverTicket::find(decrypt($id));
        $currentApproval = $driver->approve;
        $approve = $currentApproval==1 ? 0 : 1;
        $driver->update(['approve'=>$approve]);
        return redirect()->route('admin.drivers.tickets.index')->with(['success'=>'Status changed Successfully']);
    }

    public function changeStatus($id,$status) {
        $driver = DriverTicket::find(decrypt($id));
        $driver->update(['status'=>$status]);
        return redirect()->route('admin.drivers.tickets.index')->with(['success'=>'Status changed Successfully']);
    }

    public function store_reply()
    {
        $validated = request()->validate([
            'description' => 'required',
        ]);
        $ticket_id = decrypt(request('ticket_replyable_id'));

        $driver_ticket = DriverTicket::find($ticket_id);

        $ticket_reply = new TicketReply;
        $ticket_reply->description = request('description');
        $ticket_reply->user_id = Auth::id();

        $driver_ticket->replies()->save($ticket_reply);

        $driver_ticket->status = Utility::TICKET_ADMIN_REPLIED;
        $driver_ticket->save();

        return redirect()->back();
    }
}
