<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\User;
use App\Models\Company;
use App\Models\Subscription;
use App\Models\UserSubscription;
use App\Models\Coupon;
use App\Models\Transaction;
use App\Models\Wallet;
use Session;
use Auth;
use Illuminate\Validation\ValidationException;
use DateTime;

class SubscriptionController extends Controller
{

    public function create()
    {
        $company = Company::where('id', Auth::user()->company_id)->first();
        $accountsUsed = User::where('company_id', $company->id)->count();

        $subscriptions = Subscription::where('active', '1')->get();
        return Inertia::render('Subscription/Create', compact('company', 'accountsUsed', 'subscriptions'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        if ($request->coupon) {
            $coupon = $request->coupon;
            if (!Coupon::where('code', $coupon)->where('active', '1')->exists()) {
                throw ValidationException::withMessages(['coupon' => 'Invalid Coupon Code']);
            }
        }



        $plan = Subscription::where('id', $request->plan['id'])->first();

        if (!$plan) {
            throw ValidationException::withMessages(['plan' => 'Plan Not Found']);
        }
        $accounts = $request->accounts;
        $coupon = $request->coupon;

        $amount = $plan->price * $accounts;

        if ($request->coupon) {
            $coupon = Coupon::where('code', $request->coupon)->first();
            $final_amount = $amount - ($amount / $coupon->discount);
        } else {
            $final_amount = $amount;
        }

        $user = Auth::user();
        $wallet = Wallet::where('user_id', $user->id)->first();

        if ($wallet->amount < $final_amount) {
            throw ValidationException::withMessages(['amount' => 'Insufficient balance in the wallet.']);
        }


        $wallet = Wallet::where('user_id', Auth::user()->id)->first();
        $wallet->update(['amount' => $wallet->amount - $final_amount]);


        $end_date = new DateTime();

        $end_date = $end_date->modify('+' . $plan->days . 'day')->format('Y-m-d');


        $userSubscription = new UserSubscription();
        $userSubscription->amount = $final_amount;
        $userSubscription->months = $plan->months;
        $userSubscription->company_id = Auth::user()->company_id;
        $userSubscription->user_id = Auth::user()->id;
        $userSubscription->subscription = $plan->code;
        $userSubscription->accounts = $accounts;
        $userSubscription->end_date = $end_date;
        if ($request->coupon) {
            $coupon = Coupon::where('code', $request->coupon)->first();
            if ($coupon) {
                $userSubscription->coupon = $coupon->code;
                $userSubscription->discount = $amount - $final_amount;
            }
        }
        $userSubscription->save();

        $transaction = new Transaction();
        $transaction->user_id = Auth::user()->id;
        $transaction->for = 'Subscription';
        $transaction->transaction_id = $userSubscription->id;
        $transaction->type = 'debit';
        $transaction->amount = $final_amount;
        $transaction->status = 'completed';
        $transaction->save();
        Session::flash('toast', 'Subscribed successfully!!');

        return redirect(route('subscription.create'));
    }

    public function walletpay(Request $request)
    {
        return $request->all();
    }
}
