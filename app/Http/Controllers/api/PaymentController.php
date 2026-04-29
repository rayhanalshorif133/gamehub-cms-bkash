<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\PaymentController as PayController;
use App\Models\Subscription;
use App\Models\SubsLog;
use App\Models\PaymentLog;
use App\Models\ChargeLog;
use App\Models\Boost;
use App\Models\UserHasBoost;
use App\Models\Campaign;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PaymentController extends Controller
{

    public function appPaymentCallback(Request $request, $msisdn, $campaign_id, $amount)
    {
        // Log the callback data


        $paymentLog = new PaymentLog();
        $paymentLog->campaign_id = $campaign_id;
        $paymentLog->msisdn = $msisdn;
        $paymentLog->status = $request->status;
        $paymentLog->payment_id = $request->paymentID;
        $paymentLog->msg = $request->msg;
        $paymentLog->amount = $amount;
        $paymentLog->date = date('Y-m-d');
        $paymentLog->save();

        try {
            if ($request->status != 'success') {
                return redirect(url('?payment=failed&msg=' . $request->msg . '&campaign_id=' . $campaign_id));
            } else {

                $camp = Campaign::find($campaign_id);
                if (!$camp) {
                    return redirect(url('?payment=failed&campaign_id=n/a'));
                }

                $subs = new Subscription();
                $subs->campaign_id = $campaign_id;
                $subs->msisdn = $msisdn;
                $subs->payment_id = $request->paymentID;
                $subs->keyword = $camp->game_keyword;
                $subs->subs_date = date('Y-m-d');
                $subs->status = 1;
                $subs->save();

                $log = new SubsLog();
                $log->msisdn = $msisdn;
                $log->subscription_id = $subs->id;
                $log->payment_id = $request->paymentID;
                $log->type = 'subs';
                $log->keyword = $camp->game_keyword;
                $log->amount = $amount;
                $log->status = 1;
                $log->message = 'Subscription successful';
                $log->date = date('Y-m-d');
                $log->response = json_encode($request->all());
                $log->save();



                $charge = new ChargeLog();
                $charge->payment_id = $request->paymentID;
                $charge->campaign_id = $campaign_id;
                $charge->msisdn = $msisdn;
                $charge->keyword = $camp->game_keyword;
                $charge->amount = $amount;
                $charge->type = 'subs';
                $charge->charge_date = date('Y-m-d');
                $charge->expire_date = date('Y-m-d', strtotime($camp->end_date));
                $charge->save();

                $redirectURL = '/?payment=success&campaign_id=' . $campaign_id;
                return redirect(url($redirectURL));
            }
        } catch (\Throwable $th) {
            return redirect(url('?payment=failed&campaign_id=' . $campaign_id));
        }
    }


    public function webPaymentCallback(Request $request, $msisdn, $campaign_id, $amount)
    {
        // Log the callback data

        // https://bdg.b2mwap.com/public/api/callback-payment-web/msisdn/01923988380/campaign_id/8/amount/1?status=success&msisdn=01923988380&amount=1&paymentID=CH0011QVBI3PZ1774866712954&invoice_no=787491


        $paymentLog = new PaymentLog();
        $paymentLog->campaign_id = $campaign_id;
        $paymentLog->msisdn = $msisdn;
        $paymentLog->status = $request->status;
        $paymentLog->payment_id = $request->paymentID;
        $paymentLog->msg = $request->msg;
        $paymentLog->amount = $amount;
        $paymentLog->date = date('Y-m-d');
        $paymentLog->save();

        try {
            if ($request->status != 'success') {
                return redirect('/landing?status=failed');
            } else {

                $camp = Campaign::find($campaign_id);
                if (!$camp) {
                    return redirect('/landing?status=failed&campaign_id=n/a');
                }

                $subs = new Subscription();
                $subs->campaign_id = $campaign_id;
                $subs->msisdn = $msisdn;
                $subs->payment_id = $request->paymentID;
                $subs->keyword = $camp->game_keyword;
                $subs->subs_date = date('Y-m-d');
                $subs->status = 1;
                $subs->save();

                $log = new SubsLog();
                $log->msisdn = $msisdn;
                $log->subscription_id = $subs->id;
                $log->payment_id = $request->paymentID;
                $log->type = 'subs';
                $log->keyword = $camp->game_keyword;
                $log->amount = $amount;
                $log->status = 1;
                $log->message = 'Subscription successful';
                $log->date = date('Y-m-d');
                $log->response = json_encode($request->all());
                $log->save();



                $charge = new ChargeLog();
                $charge->payment_id = $request->paymentID;
                $charge->campaign_id = $campaign_id;
                $charge->msisdn = $msisdn;
                $charge->keyword = $camp->game_keyword;
                $charge->amount = $amount;
                $charge->type = 'subs';
                $charge->charge_date = date('Y-m-d');
                $charge->expire_date = date('Y-m-d', strtotime($camp->end_date));
                $charge->save();

                $redirectURL = '/new-password/' . $msisdn . '/' . $campaign_id . '?payment=success';
                return redirect($redirectURL);
            }
        } catch (\Throwable $th) {
            return redirect('/landing?status=failed&campaign_id=' . $campaign_id);
        }
    }

    public function appPaymentBoostCallback(Request $request, $msisdn, $campaign_id, $amount, $boost_id)
    {
        // Log the callback data
        /* 
        https://bdg.b2mwap.com/api/app-callback-payment-boost/msisdn/8801923988380/campaign_id/8/amount/1.00/boost/1?status=success&msisdn=8801923988380&amount=1&paymentID=CH0011YYtbkjO1775124275557&invoice_no=561067

        */

        try {
            $paymentLog = new PaymentLog();
            $paymentLog->campaign_id = $campaign_id;
            $paymentLog->msisdn = $msisdn;
            $paymentLog->status = $request->status;
            $paymentLog->payment_id = $request->paymentID;
            $paymentLog->msg = 'Boost Payment';
            $paymentLog->amount = $amount;
            $paymentLog->date = date('Y-m-d');
            $paymentLog->save();

            if ($request->status != 'success') {
                return redirect('/boost-buy/score?payment=failed');
            } else {

                $boost = Boost::find($boost_id);
                $camp = Campaign::find($campaign_id);
                
                $userBoost = new UserHasBoost();
                $userBoost->msisdn = $msisdn;
                $userBoost->keyword = $camp->game_keyword;
                $userBoost->camp_id = $campaign_id;
                $userBoost->boost_id = $boost_id;
                $userBoost->validity = $boost->validity;
                $userBoost->start_time = Carbon::now();
                $userBoost->expire_time = Carbon::now()->addSeconds($boost->validity);
                $userBoost->date = Carbon::today()->toDateString();
                $userBoost->save();

                return redirect('/boost-buy/score?payment=success');
            }
        } catch (\Throwable $th) {
            return redirect('/boost-buy/score?payment=failed');
        }
    }
}
