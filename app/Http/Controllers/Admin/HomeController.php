<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SubscriptionPayment;
use App\Models\BuyPackPayment;
use App\Models\User;
use App\Models\UserSubscription;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function subscriptionPayments(Request $request)
    {
        $payments = UserSubscription::where('subscription', '!=', '#SUB000000')->paginate();

        foreach ($payments as $payment) {
            $user = User::where('id', $payment->user_id)->first();
            $payment->user = $user;
        }

        if ($request->wantsJson()) {
            return $payments;
        }
        return Inertia::render('Admin/Subscription/Payments', compact('payments'));
    }

    public function uploadPackPayments(Request $request)
    {
        $payments = BuyPackPayment::paginate();

        if ($request->wantsJson()) {
            return $payments;
        }

        return Inertia::render('Admin/BuyUploadPack/Payments', compact('payments'));
    }
}
