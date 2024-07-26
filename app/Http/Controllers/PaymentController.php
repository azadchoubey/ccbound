<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Razorpay\Api\Api;
use Auth;

class PaymentController extends Controller
{
    public function create(Request $request)
    {
        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
        $order  = $api->order->create(array('receipt' => '123', 'amount' => $request->amount * 100, 'currency' => 'INR'));

        $payment = new Payment();
        $payment->user_id = Auth::user()->id;
        $payment->amount = $request->amount;
        $payment->order_id = $order['id'];
        $payment->save();

        return $payment;
    }

    public function verify(Request $request)
    {
        try {
            $data = $request->all();

            $userPayment = Payment::where('order_id', $data['razorpay_order_id'])->first();

            $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));

            $paymentInfo = $api->payment->fetch($data['razorpay_payment_id']);

            $status = 0;

            DB::beginTransaction();

            try {
                if ($paymentInfo->status == 'captured') {
                    $userPayment->status = 'completed';
                    $wallet = Wallet::where('user_id', Auth::user()->id)->first();

                    if (!$wallet) {
                        throw new \Exception('User wallet not found.');
                    }

                    $wallet->amount = $wallet->amount + ($paymentInfo->amount / 100);
                    $wallet->save();

                    $transaction = new Transaction();
                    $transaction->user_id = Auth::user()->id;
                    $transaction->for = 'Add Money';
                    $transaction->transaction_id = $userPayment->id;
                    $transaction->type = 'credit';
                    $transaction->amount = $paymentInfo->amount / 100;
                    $transaction->save();

                    $status = 1;
                } else {
                    $userPayment->status = 'failed';
                }

                $userPayment->save();

                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                \Log::error('Error processing payment callback: ' . $e->getMessage());
                return response()->json(['error' => 'An error occurred while processing the payment.'], 500);
            }

            return $status;
        } catch (\Exception $e) {
            \Log::error('Unexpected error: ' . $e->getMessage());
            return response()->json(['error' => 'An unexpected error occurred.'], 500);
        }
    }
}
