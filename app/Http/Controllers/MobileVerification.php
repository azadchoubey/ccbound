<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Twilio\Rest\Client;
use Auth;
use Twilio\Exceptions\TwilioException;
use Carbon\Carbon;

class MobileVerification extends Controller
{
    public function sendOtp()
    {
        if (Auth::check()) {
            $token = env("TWILIO_AUTH_TOKEN");
            $twilio_sid = env("TWILIO_SID");
            $twilio_verify_sid = env("TWILIO_VERIFY_SID");
            $twilio = new Client($twilio_sid, $token);
            $twilio->verify->v2->services($twilio_verify_sid)
                ->verifications
                ->create(Auth::user()->number, "sms");
        }
    }

    public function verifyOtpForm()
    {
        if(Auth::user()->number_verified_at != NULL){
            return redirect(route('enquiry.index'));
        }
        // $token = env("TWILIO_AUTH_TOKEN");
        // $twilio_sid = env("TWILIO_SID");
        // $twilio_verify_sid = env("TWILIO_VERIFY_SID");
        // $twilio = new Client($twilio_sid, $token);
        // $twilio->verify->v2->services($twilio_verify_sid)
        //     ->verifications
        //     ->create(Auth::user()->number, "sms");
        return Inertia::render('Auth/VerifyMobile');
    }

    public function verifyOtp(Request $request)
    {

        $data = $request->validate([
            'otp' => ['required', 'numeric'],
        ]);
        try {
            $token = getenv("TWILIO_AUTH_TOKEN");
            $twilio_sid = getenv("TWILIO_SID");
            $twilio_verify_sid = getenv("TWILIO_VERIFY_SID");
            $twilio = new Client($twilio_sid, $token);
            $verification = $twilio->verify->v2->services($twilio_verify_sid)
                ->verificationChecks
                ->create(['code' => $data['otp'], 'to' => Auth::user()->number]);
            if ($verification->valid) {
                $user = Auth::user();
                $user->number_verified_at = Carbon::now()->toDateTimeString();
                $user->save();
                return 1;
            } else {
                return 0;
            }
        } catch (TwilioException $e) {
            return -1;
        }
    }
}
