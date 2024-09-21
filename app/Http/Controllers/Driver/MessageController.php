<?php

namespace App\Http\Controllers\Driver;

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
        $messages = Message::where('type',Utility::MESSAGE_TYPE_ALL)->orWhere('type',Utility::MESSAGE_TYPE_BRANCH)->orderBy('id')->paginate(Utility::PAGINATE_COUNT);
        return view('drivers.messages.index',compact('messages'));
    }

}
