<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Payout;
use App\Models\Transaction;
use App\Models\Wallet;

class PayoutController extends Controller
{
    public function index()
    {
        $payouts = Payout::orderBy('id', 'desc')->paginate();
        return Inertia::render('Admin/Payout/Index', compact('payouts'));
    }

    public function update(Payout $payout, Request $request)
    {
        $payout->status = $request->status;
        $payout->save();

        $transaction = Transaction::where('user_id', $payout->user_id)->where('for', 'Payout')->where('transaction_id', $payout->id)->first();
        $transaction->status = $request->status;
        $transaction->save();

        if ($request->status === 'rejected') {
            $wallet = Wallet::where('user_id', $transaction->user_id)->first();
            $wallet->amount = $wallet->amount + $transaction->amount;
            $wallet->save();
        }

        return $transaction;
    }
}
