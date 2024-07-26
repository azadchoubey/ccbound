<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\User;
use App\Models\Wallet;
use App\Models\Company;
use App\Models\Payout;
use App\Models\Subscription;
use App\Models\Transaction;
use App\Models\UploadPack;
use App\Models\UserSubscription;
use App\Models\UserUploadPack;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;
use Auth;
use Session;

class HomeController extends Controller
{
    public function contacts()
    {
        $contacts = Auth::user()->contacts;
        return Inertia::render('Contacts', compact('contacts'));
    }

    public function notifications()
    {
        return Inertia::render('Notifications');
    }

    public function wallet()
    {
        $wallet = Auth::user()->wallet;
        $transactions = Transaction::where('user_id', Auth::user()->id)->get();
        return Inertia::render('Wallet', compact('wallet', 'transactions'));
    }

    public function payout()
    {
        return Inertia::render('Payout');
    }

    public function storePayout(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'amount' => [
                'required',
                'integer',
            ],
            'upi' => 'nullable|string',
            'account_number' => 'string',
            'account_branch' => 'string',
            'ifsc_code' => 'string',
            'gst_number' => 'string',
            'pan_number' => 'string',
            'aadhar_number' => 'string',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $user = Auth::user();
        $wallet = Wallet::where('user_id', $user->id)->first();

        if ($wallet->amount < $request->input('amount')) {
            throw ValidationException::withMessages(['amount' => 'Insufficient balance in the wallet.']);
        }

        $payout = Payout::create([
            'user_id' => Auth::user()->id,
            'amount' => $request->input('amount'),
            'upi' => $request->input('upi_id'),
            'account_number' => $request->input('account_number'),
            'account_branch' => $request->input('account_branch'),
            'ifsc_code' => $request->input('ifsc_code'),
            'gst_number' => $request->input('gst_no'),
            'pan_number' => $request->input('pan_no'),
            'aadhar_number' => $request->input('aadhaar_number'),
        ]);

        $wallet = Wallet::where('user_id', Auth::user()->id)->first();
        $wallet->update(['amount' => $wallet->amount - $request->input('amount')]);

        $transaction = new Transaction();
        $transaction->user_id = Auth::user()->id;
        $transaction->for = 'Payout';
        $transaction->transaction_id = $payout->id;
        $transaction->type = 'debit';
        $transaction->amount = $request->amount;
        $transaction->save();
        Session::flash('toast', 'Payout Request sent successfully!!');
        return redirect(route('wallet'));
    }

    public function subscription()
    {
        $company = Company::where('id', Auth::user()->id)->first();
        $accountsUsed = User::where('company_id', $company->id)->count();

        $subscriptions = Subscription::where('active', '1')->get();
        return Inertia::render('Subscription', compact('company', 'accountsUsed', 'subscriptions'));
    }

    public function refer()
    {
        return Inertia::render('Refer');
    }

    public function referShow()
    {
        $users = User::where('referrer', Auth::user()->id)->get();
        return Inertia::render('ReferShow', compact('users'));
    }

    public function help()
    {
        return Inertia::render('Help');
    }

    public function buy()
    {

        $price = UploadPack::first();
        return Inertia::render('Buy', compact('price'));
    }

    public function storeBuy(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'products' => [
                'required',
                'integer',
            ],
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $user = Auth::user();
        $wallet = Wallet::where('user_id', $user->id)->first();

        $price = UploadPack::first();

        $total_amount = $request->products * $price->price;
        if ($wallet->amount < $total_amount) {
            throw ValidationException::withMessages(['amount' => 'Insufficient balance in the wallet.']);
        }

        $userUpload = new UserUploadPack();
        $userUpload->user_id = Auth::user()->id;
        $userUpload->payment_id = Auth::user()->id;
        $userUpload->price_per_product = $price->price;
        $userUpload->total_products = $request->products;
        $userUpload->products_uploaded = 0;
        $userUpload->products_left = $request->products;
        $userUpload->save();

        $wallet = Wallet::where('user_id', Auth::user()->id)->first();
        $wallet->update(['amount' => $wallet->amount - $total_amount]);

        $transaction = new Transaction();
        $transaction->user_id = Auth::user()->id;
        $transaction->for = 'Upload Pack';
        $transaction->transaction_id = $userUpload->id;
        $transaction->type = 'debit';
        $transaction->amount = $total_amount;
        $transaction->status = 'completed';
        $transaction->save();

        $userUpload->payment_id = $transaction->id;
        $userUpload->save();

        Session::flash('toast', 'Upload Pack bought successfully!!');
        return redirect(route('wallet'));
    }

    public function buyShow()
    {
        return Inertia::render('BuyShow');
    }

    public function links()
    {
        return Inertia::render('Links');
    }

    public function settings()
    {
        return Inertia::render('Settings');
    }

    public function deActive()
    {
        if (Auth::check()) {
            if (Auth::user()->active == 1) {
                return redirect('/');
            }
        } else {
            return redirect(route('login'));
        }
        return Inertia::render('Deactive');
    }
}
