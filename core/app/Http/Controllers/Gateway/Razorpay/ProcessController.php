<?php

namespace App\Http\Controllers\Gateway\Razorpay;

use App\Models\Deposit;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Razorpay\Api\Api;

class ProcessController extends Controller
{
    // Payment status constants
    private const PAYMENT_INITIATE = 'payment_initiate';
    private const PAYMENT_COMPLETE = 'payment_complete';
    private const PAYMENT_FAILED = 'payment_failed';

    public static function process($deposit)
    {
        $razorAcc = json_decode($deposit->gatewayCurrency()->gateway_parameter);

        $api_key = $razorAcc->key_id;
        $api_secret = $razorAcc->key_secret;

        try {
            $api = new Api($api_key, $api_secret);
            $order = $api->order->create([
                'receipt' => $deposit->trx,
                'amount' => round($deposit->final_amount * 100),
                'currency' => $deposit->method_currency,
                'payment_capture' => 1,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()]);
        }

        $deposit->btc_wallet = $order->id;
        $deposit->status = self::PAYMENT_INITIATE;
        $deposit->save();

        $val['key'] = $razorAcc->key_id;
        $val['amount'] = round($deposit->final_amount * 100);
        $val['currency'] = $deposit->method_currency;
        $val['order_id'] = $order->id;
        $val['buttontext'] = "Pay with Razorpay";
        $val['description'] = "Donation Payment";
        $val['image'] = siteLogo();

        $send['val'] = $val;
        $send['method'] = 'POST';

        $alias = $deposit->gateway->alias;
        $send['url'] = route('ipn.' . $alias);
        $send['custom'] = $deposit->trx;
        $send['checkout_js'] = "https://checkout.razorpay.com/v1/checkout.js";
        $send['view'] = 'user.payment.' . $alias;

        return json_encode($send);
    }

    public function ipn(Request $request)
    {
        $deposit = Deposit::where('btc_wallet', $request->razorpay_order_id)->orderBy('id', 'DESC')->first();

        if (!$deposit) {
            return back()->withErrors(['error' => 'Invalid request: Deposit not found']);
        }

        $razorAcc = json_decode($deposit->gatewayCurrency()->gateway_parameter);
        $sig = hash_hmac('sha256', $request->razorpay_order_id . "|" . $request->razorpay_payment_id, $razorAcc->key_secret);
        $deposit->detail = $request->all();
        $deposit->save();

        if ($sig === $request->razorpay_signature) {
            $deposit->status = self::PAYMENT_COMPLETE;
            $deposit->save();
            return redirect($deposit->success_url)->with(['success' => 'Transaction was successful']);
        }

        return back()->withErrors(['error' => 'Invalid Request or Signature Mismatch']);
    }
}
