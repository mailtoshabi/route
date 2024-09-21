<?php

namespace App\Models;

use App\Http\Utilities\Utility;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Exception;
use Twilio\Rest\Client;

class CustomerOtp extends Model
{
    use HasFactory;

    protected $fillable = ['customer_id', 'otp', 'expire_at'];

    public function sendSMS($receiverNumber)
    {
        $content = $this->otp . Utility::OTP_MESSAGE;

        try {
            $sid = getenv("TWILIO_SID");
            $token = getenv("TWILIO_TOKEN");
            $sender_number = getenv("TWILIO_FROM");

            $twilio = new Client($sid, $token);

            $message = $twilio->messages
                            ->create($receiverNumber, // to
                                    [
                                        "body" => $content,
                                        "from" => $sender_number
                                    ]
                            );

        } catch (Exception $e) {
            info("Error: ". $e->getMessage());
        }
    }
}
