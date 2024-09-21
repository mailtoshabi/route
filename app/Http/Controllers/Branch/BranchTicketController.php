<?php

namespace App\Http\Controllers\Branch;

use App\Http\Controllers\Controller;
use App\Http\Utilities\Utility;
use App\Models\BranchTicket;
use App\Models\TicketReply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BranchTicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tickets = BranchTicket::where('branch_id',Auth::guard('branch')->id())->orderBy('id')->paginate(Utility::PAGINATE_COUNT);
        return view('branches.tickets.index',compact('tickets'));
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
     * @param  \App\Models\BranchTicket  $driverTicket
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $ticket = BranchTicket::findOrFail(decrypt($id));
        return view('branches.tickets.show',compact('ticket'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BranchTicket  $driverTicket
     * @return \Illuminate\Http\Response
     */
    public function edit(BranchTicket $driverTicket)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BranchTicket  $driverTicket
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BranchTicket $driverTicket)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BranchTicket  $driverTicket
     * @return \Illuminate\Http\Response
     */
    // public function destroy($id)
    // {
    //     $driver = BranchTicket::find(decrypt($id));
    //     $driver->delete();
    //     return redirect()->route('branch.tickets.index')->with(['success'=>'Ticket Deleted Successfully']);
    // }

    // public function changeApproval($id) {
    //     $driver = BranchTicket::find(decrypt($id));
    //     $currentApproval = $driver->approve;
    //     $approve = $currentApproval==1 ? 0 : 1;
    //     $driver->update(['approve'=>$approve]);
    //     return redirect()->route('branch.tickets.index')->with(['success'=>'Status changed Successfully']);
    // }

    // public function changeStatus($id,$status) {
    //     $driver = BranchTicket::find(decrypt($id));
    //     $driver->update(['status'=>$status]);
    //     return redirect()->route('branch.tickets.index')->with(['success'=>'Status changed Successfully']);
    // }

    public function store_reply()
    {
        $validated = request()->validate([
            'description' => 'required',
        ]);
        $ticket_id = decrypt(request('ticket_replyable_id'));

        $driver_ticket = BranchTicket::find($ticket_id);

        $ticket_reply = new TicketReply;
        $ticket_reply->description = request('description');
        $ticket_reply->user_id = Auth::guard('branch')->id();

        $driver_ticket->replies()->save($ticket_reply);

        $driver_ticket->status = Utility::TICKET_ADMIN_REPLIED;
        $driver_ticket->save();

        return redirect()->back();
    }
}
