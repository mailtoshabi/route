<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Utilities\Utility;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MessageController extends Controller
{
    public function index()
    {
        $messages = Message::orderBy('id')->paginate(Utility::PAGINATE_COUNT);
        return view('admin.messages.index',compact('messages'));
    }

    public function create() {
        return view('admin.messages.add');
    }

    public function store () {
        $validated = request()->validate([
            'title' => 'required',
            'description' => 'required',
            'type' => 'required',
        ]);
        $input = request()->only(['title','description','type','status']);

        $input['user_id'] =Auth::id();
        $message = Message::create($input);
        return redirect()->route('admin.messages.index')->with(['success'=>'New Message Added Successfully']);
    }

    public function edit($id) {
        $message_notification = Message::findOrFail(decrypt($id));
        return view('admin.messages.add',compact('message_notification'));
    }

    public function update () {
        $id = decrypt(request('message_id'));
        $message = Message::find($id);
        $validated = request()->validate([
            'title' => 'required',
            'description' => 'required',
            'type' => 'required',
        ]);
        $input = request()->only(['title','description','type','status']);
        $message->update($input);
        return redirect()->route('admin.messages.index')->with(['success'=>'Message Updated Successfully']);
    }

    public function destroy($id) {
        $message = Message::find(decrypt($id));
        $message->delete();
        return redirect()->route('admin.messages.index')->with(['success'=>'Message Deleted Successfully']);
    }

    public function changeStatus($id) {
        $message = Message::find(decrypt($id));
        $currentStatus = $message->status;
        $status = $currentStatus ? 0 : 1;
        $message->update(['status'=>$status]);
        return redirect()->route('admin.messages.index')->with(['success'=>'Status changed Successfully']);
    }
}
