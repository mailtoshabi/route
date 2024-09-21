<?php

namespace App\Http\Controllers\Customer\Auth;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Customer;
use App\Models\CustomerOtp;

class AuthOtpController extends Controller
{
    public function login()
    {
        return view('front.auth.otpLogin');
    }

    public function generate(Request $request)
    {
        /* Validate Data */
        $request->validate([
            'phone' => 'required|exists:customers,phone'
        ]);
        // return '+91' . $request->phone;
        /* Generate An OTP */
        $customerOtp = $this->generateOtp($request->phone);
        $customerOtp->sendSMS('+91' . $request->phone);

        return redirect()->route('otp.verification', ['customer_id' => $customerOtp->customer_id])
                         ->with('success',  "OTP has been sent on Your Mobile Number.");
    }

    public function generateOtp($phone)
    {
        $customer = Customer::where('phone', $phone)->first();

        /* Customer Does not Have Any Existing OTP */
        $customerOtp = CustomerOtp::where('customer_id', $customer->id)->latest()->first();

        $now = now();

        if($customerOtp && $now->isBefore($customerOtp->expire_at)){
            return $customerOtp;
        }

        /* Create a New OTP */
        return CustomerOtp::create([
            'customer_id' => $customer->id,
            'otp' => rand(123456, 999999),
            'expire_at' => $now->addMinutes(10)
        ]);
    }

    public function verification($customer_id)
    {
        return view('front.auth.otpVerification')->with([
            'customer_id' => $customer_id
        ]);
    }

    public function loginWithOtp(Request $request)
    {
        /* Validation */
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'otp' => 'required'
        ]);

        /* Validation Logic */
        $customerOtp   = CustomerOtp::where('customer_id', $request->customer_id)->where('otp', $request->otp)->first();

        $now = now();
        if (!$customerOtp) {
            return redirect()->back()->with('error', 'Your OTP is not correct');
        }else if($customerOtp && $now->isAfter($customerOtp->expire_at)){
            return redirect()->route('otp.login')->with('error', 'Your OTP has been expired');
        }

        $customer = Customer::whereId($request->customer_id)->first();

        if($customer){

            $customerOtp->update([
                'expire_at' => now()
            ]);

            Auth::guard('customer')->login($customer);

            return redirect('/');
        }

        return redirect()->route('otp.login')->with('error', 'Your Otp is not correct');
    }
}
