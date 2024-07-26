<?php

namespace App\Actions\Fortify;

use App\Models\User;
use App\Models\Company;
use App\Models\Wallet;
use App\Models\UserSubscription;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use libphonenumber\PhoneNumber;
use Laravel\Jetstream\Jetstream;
use Twilio\Rest\Client;
use DateTime;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {

        $validator = Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'number' => ['required', 'unique:users', new \App\Rules\PhoneRegexRule],
            'password' => $this->passwordRules(),
            'companyName' => ['required'],
            'address' => ['nullable', 'string', 'max:255'],
            'country' => ['nullable'],
            'website' => ['nullable', 'regex:/^www\.[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/'],
        ]);

        $validator->sometimes('logo', ['image', 'mimes:jpeg,jpg,png,gif,svg', 'max:510002'], function ($input) {
            return !empty($input['logo']);
        });
        
        $validator->validate();

        $logoWithExt = request()->file('logo')->getClientOriginalName();
        $logo = pathinfo($logoWithExt, PATHINFO_FILENAME);
        $extension = request()->file('logo')->getClientOriginalExtension();
        $logoNameToStore = $logo . '_' . time() . '.' . $extension;
        // request()->file('logo')->storeAs('company_logo', $logoNameToStore);
        request()->file('logo')->move(public_path('storage/company_logo'), $logoNameToStore);

        $company = new Company();
        $company->name = $input['companyName'];
        $company->logo = $logoNameToStore;
        $company->address = $input['address'];
        $company->website = $input['website'];
        $company->country = $input['country'];
        $company->state = $input['state'];
        $company->city = $input['city'];
        $company->save();

        $user = User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'number' => $input['number'],
            'password' => Hash::make($input['password']),
            'company_id' => $company->id,
            'address' => $input['address'],
            'country' => $input['country'],
            'state' => $input['state'],
            'city' => $input['city'],
        ]);

        if ($input['referrer_id']) {
            $user->referrer = $input['referrer_id'];
            $user->save();
        }

        $end_date = new DateTime();

        $end_date = $end_date->modify('+14 day')->format('Y-m-d');

        $userSubscription = new UserSubscription();
        $userSubscription->user_id = $user->id;
        $userSubscription->amount = 0;
        $userSubscription->months = 0;
        $userSubscription->company_id = $company->id;
        $userSubscription->subscription = '#SUB000000';
        $userSubscription->accounts = 1;
        $userSubscription->end_date = $end_date;
        $userSubscription->save();

        $wallet = new Wallet();
        $wallet->user_id = $user->id;
        $wallet->amount = 0;
        $wallet->save();

        // $token = env("TWILIO_AUTH_TOKEN");
        // $twilio_sid = env("TWILIO_SID");
        // $twilio_verify_sid = getenv("TWILIO_VERIFY_SID");
        // $twilio = new Client($twilio_sid, $token);
        // $twilio->verify->v2->services($twilio_verify_sid)
        //     ->verifications
        //     ->create($input['number'], "sms");

        return $user;
    }
}
