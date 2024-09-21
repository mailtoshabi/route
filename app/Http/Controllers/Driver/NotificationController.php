<?php

namespace App\Http\Controllers\Driver;

use App\Http\Controllers\Controller;
use App\Http\Utilities\Utility;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class NotificationController extends Controller
{
    public function index()
    {
        $messages = Notification::where('type',Utility::NOTIFICATION_TYPE_ALL)->orWhere('type',Utility::NOTIFICATION_TYPE_DRIVER)->orderBy('id')->paginate(Utility::PAGINATE_COUNT);
        return view('drivers.notifications.index',compact('messages'));
    }

}
