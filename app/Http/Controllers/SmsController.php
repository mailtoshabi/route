<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Twilio\Rest\Client;

class SmsController extends Controller
{
    public function index() {
        return view('admin.sms');
    }

    public function send() {
        // Find your Account SID and Auth Token at twilio.com/console
        // and set the environment variables. See http://twil.io/secure
        $sid = getenv("TWILIO_SID");
        $token = getenv("TWILIO_TOKEN");
        $sender_number = getenv("TWILIO_FROM");
        $mobile = '+91'.request()->mobile;

        // return $sid;

        $twilio = new Client($sid, $token);

        $message = $twilio->messages
                        ->create($mobile, // to
                                [
                                    "body" => request()->description,
                                    "from" => $sender_number
                                ]
                        );

        dd("Message Sent Successfully");

    }
}
