<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\ChargeLog;
use App\Models\Game;
use App\Models\GrantToken;
use App\Models\PaymentCreate;
use App\Models\PaymentExecute;
use App\Models\Subscription;
use App\Models\SubUnsubsLog;
use App\Models\CoinLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class PaymentController extends Controller
{


    public function payTest()
    {
        return view('pay-test');
    }


    // This is the old version of the getToken method, kept for reference
    // It is not used in the current implementation but may be useful for future reference or rollback
    public function getTokenOLD()
    {





        // https://checkout.sandbox.bka.sh/v1.2.0-beta/
        // https://checkout.pay.bka.sh/v1.2.0-beta/checkout/token/

        $bkashApiBase = 'https://checkout.pay.bka.sh/v1.2.0-beta/checkout/token/';

        $appKey = '2l6u3m4i01ed69foin29vp42m';
        $appSecret = '1d2qur3hm323h26h6a0m5pqucka8qkaae5drfimo4vejabo032qi';


        $grantToken = GrantToken::select()->latest('expires_time')->first();

        if (!$grantToken) {
            $requestData = [
                'app_key' => $appKey,
                'app_secret' => $appSecret,
            ];

            $response = $this->callBkashApi($bkashApiBase . 'grant', $requestData);

            $grantToken =  GrantToken::create([
                'token_type' => $response['token_type'],
                'id_token' => $response['id_token'],
                'refresh_token' => $response['refresh_token'],
                'expires_time' => Carbon::now()->addSeconds($response['expires_in']),
                'response' => json_encode($response),
            ]);


            return $grantToken->id_token;
        }


        if ($grantToken && $grantToken->expires_time > Carbon::now()) {
            return $grantToken->id_token;
        } else {



            $requestData = [
                'app_key' => $appKey,
                'app_secret' => $appSecret,
                'refresh_token' => $grantToken->refresh_token,
            ];


            $response = $this->callBkashApi($bkashApiBase . 'refresh', $requestData);


            if (isset($response['status']) && $response['status'] == 'fail') {
                $requestData = [
                    'app_key' => $appKey,
                    'app_secret' => $appSecret,
                ];

                $response = $this->callBkashApi($bkashApiBase . 'grant', $requestData);

                $grantToken =  GrantToken::create([
                    'token_type' => $response['token_type'],
                    'id_token' => $response['id_token'],
                    'refresh_token' => $response['refresh_token'],
                    'expires_time' => Carbon::now()->addSeconds($response['expires_in']),
                    'response' => json_encode($response),
                ]);


                return $grantToken->id_token;
            }




            $grantToken =  GrantToken::create([
                'token_type' => $response['token_type'],
                'id_token' => $response['id_token'],
                'refresh_token' => $response['refresh_token'],
                'expires_time' => Carbon::now()->addSeconds($response['expires_in']),
                'response' => json_encode($response),
            ]);


            return $grantToken->id_token;
        }
    }

    public function getToken()
    {





        // https://checkout.sandbox.bka.sh/v1.2.0-beta/
        // https://checkout.pay.bka.sh/v1.2.0-beta/checkout/token/

        $bkashApiBase = 'https://checkout.pay.bka.sh/v1.2.0-beta/checkout/token/';

        $appKey = '2l6u3m4i01ed69foin29vp42m';
        $appSecret = '1d2qur3hm323h26h6a0m5pqucka8qkaae5drfimo4vejabo032qi';

        $grantToken = DB::connection('mysql2')
            ->table('grant_token')
            ->orderBy('id', 'desc')
            ->first();

        // IF the table is empty, create a new grant token

        if (!$grantToken) {
            $requestData = [
                'app_key' => $appKey,
                'app_secret' => $appSecret,
            ];

            $response = $this->callBkashApi($bkashApiBase . 'grant', $requestData);

            DB::connection('mysql2')->table('grant_token')->insert([
                'msisdn' => null,
                'id_token' => $response['id_token'],
                'expires_in' => 3600,
                'refresh_token' => $response['refresh_token'],
                'expire_time' => Carbon::now()->addHour()->format('Y-m-d H:i:s'),
                'status' => null,
                'msg' => null,
                'created' => Carbon::now()->format('Y-m-d H:i:s'),
            ]);


            return $response['id_token'];
        }



        if ($grantToken && Carbon::parse($grantToken->expire_time)->gt(Carbon::now())) {
            return $grantToken->id_token;
        } else {


            $requestData = [
                'app_key' => $appKey,
                'app_secret' => $appSecret,
                'refresh_token' => $grantToken->refresh_token,
            ];


            $response = $this->callBkashApi($bkashApiBase . 'refresh', $requestData);


            // Check after the refresh token is expired, if it is expired, then create a new grant token
            if (isset($response['status']) && $response['status'] == 'fail') {
                $requestData = [
                    'app_key' => $appKey,
                    'app_secret' => $appSecret,
                ];

                $response = $this->callBkashApi($bkashApiBase . 'grant', $requestData);
            }

            DB::connection('mysql2')->table('grant_token')->insert([
                'msisdn' => null,
                'id_token' => $response['id_token'],
                'expires_in' => 3600,
                'refresh_token' => $response['refresh_token'],
                'expire_time' => Carbon::now()->addHour()->format('Y-m-d H:i:s'),
                'status' => null,
                'msg' => null,
                'created' => Carbon::now()->format('Y-m-d H:i:s'),
            ]);


            return $response['id_token'];
        }
    }


    public function callBkashApi($url, $requestData)
    {

        $headers = array(
            'Content-Type:application/json',
            'username:BDGAMERS',
            'password:B@1PtexcaQMvb'
        );

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($requestData));
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);

        $response = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);



        if ($error) {
            throw new Exception("cURL Error: " . $error);
        }



        return json_decode($response, true);
    }






    public function createPayment(Request $request, $msisdn)
    {





        $id_token = $this->getToken();



        if (!$request->amount) {
            $campaign = Campaign::select()->where('id', $request->campaign_id)->first();
        }

        $invoice_no = $this->getInvoiceNo();
        $payCreate = new PaymentCreate();
        $payCreate->invoice_no = $invoice_no;
        $payCreate->id_token = $id_token;
        $payCreate->user_msisdn = $msisdn;
        $payCreate->redirect_url = $request->redirect_url;
        $payCreate->keyword = 'purchase-coin';
        $payCreate->campaign_id = null;

        if (!$request->amount && $campaign) {
            $payCreate->keyword = $campaign->game_keyword;
            $payCreate->campaign_id = $request->campaign_id;
            $amount = $campaign->amount;
        } else {
            $amount = $request->amount;
        }

        $payCreate->save();


        $amount = (string)$amount;
        $invoice_no = (string)$invoice_no;



        $request_data = array(
            'amount'                =>  $amount,
            'currency'                => 'BDT',
            'intent'                => 'sale',
            'merchantInvoiceNumber'    =>  $invoice_no,
        );



        $url = curl_init('https://checkout.pay.bka.sh/v1.2.0-beta/checkout/payment/create');
        $request_data_json = json_encode($request_data);
        $header = array(
            'Content-Type:application/json',
            "authorization: $id_token",
            'x-app-key:2l6u3m4i01ed69foin29vp42m'
        );

        curl_setopt($url, CURLOPT_HTTPHEADER, $header);
        curl_setopt($url, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($url, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($url, CURLOPT_POSTFIELDS, $request_data_json);
        curl_setopt($url, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($url, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        curl_setopt($url, CURLOPT_TIMEOUT, 30);
        $response = curl_exec($url);

        curl_close($url);



        $response = json_decode($response, true);



        $payCreate->payment_id = $response['paymentID'];
        $payCreate->amount = $response['amount'];
        $payCreate->response = $response;
        $payCreate->save();

        return $response;
    }

    public function executePayment(Request $request, $msisdn, $paymentID)
    {
        $payCreate = PaymentCreate::select()->where('payment_id', $paymentID)->first();

        try {

            sleep(1);




            if ($payCreate->keyword == 'purchase-coin') {
                return $this->executePaymentForPurchaseCoin($payCreate);
            }




            // Subscription
            $redirectURL  = "";


            $date = date("Y-m-d");
            $subs = "";
            $hasSubs = Subscription::where('msisdn', $payCreate->user_msisdn)
                ->where('campaign_id', $payCreate->campaign_id)
                ->whereDate('subs_date', $date)
                ->first();
            $subsUnsubs = new SubUnsubsLog();

            if ($hasSubs) {
                $subs = $hasSubs;
                $subsUnsubs->message = 'Duplicate Try';
                $redirectURL = '/?payment=duplicate_try&campaign_id=' . $payCreate->campaign_id;
            } else {
                $subs = new Subscription();
                $id_token = $payCreate->id_token;

                $payment_url = 'https://checkout.pay.bka.sh/v1.2.0-beta/checkout/payment/execute/' . $paymentID;
                $url = curl_init($payment_url);
                $header = array(
                    'Content-Type:application/json',
                    "authorization: $id_token",
                    'x-app-key:2l6u3m4i01ed69foin29vp42m'
                );
                curl_setopt($url, CURLOPT_HTTPHEADER, $header);
                curl_setopt($url, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($url, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($url, CURLOPT_FOLLOWLOCATION, 1);
                curl_setopt($url, CURLOPT_TIMEOUT, 30);
                $response = curl_exec($url);
                curl_close($url);





                sleep(15);
                $paymentQueryUrl = "https://bdgamers.b2mwap.com/api/payment-query/" . $paymentID;

                $payQuery =  Http::get($paymentQueryUrl);
                $payQuery = json_decode($payQuery->body(), true);



                $payExe = new PaymentExecute();
                $payExe->campaign_id = $payCreate->campaign_id;
                $payExe->payment_create_id = $payCreate->id;
                $payExe->keyword = $payCreate->keyword;
                $payExe->user_msisdn = $payCreate->user_msisdn;
                $payExe->response = $response;
                $payExe->save();

                $response = json_decode($response, true);





                if (isset($response['errorCode'])) {
                    $payExe->error_code = $response['errorCode'];
                    $payExe->error_message = $response['errorMessage'];
                    $payExe->amount = $payCreate->amount;
                    $payExe->invoice_no = $payCreate->invoice_no;
                    $payExe->payment_id = $payCreate->payment_id;
                    $payExe->transaction_status = 'failed';
                    $redirectURL = '/?payment=failed&campaign_id=' . $payCreate->campaign_id;
                    if ($response['errorCode'] == 2029) {
                        $redirectURL = '/?payment=duplicate_all_transactions&campaign_id=' . $payCreate->campaign_id;
                    }
                    $payExe->redirect_url = $redirectURL;
                    $payExe->save();
                    return redirect($redirectURL);
                } else {


                    $payExe->invoice_no = $response['merchantInvoiceNumber'];
                    $payExe->payment_id = $response['paymentID'];
                    $payExe->bkash_msisdn = $response['customerMsisdn'];
                    $payExe->amount = $response['amount'];
                    $payExe->trxID = $response['trxID'];
                    $payExe->transaction_status = $response['transactionStatus'];
                    $payExe->error_message = "";
                    $redirectURL = '/?payment=success&campaign_id=' . $payCreate->campaign_id;
                    $payExe->redirect_url = $redirectURL;
                    $payExe->save();
                }
                // charge log

                if ($payQuery['transaction_status'] == 'Completed') {
                    $payExe->transaction_status = 'completed';
                    $payExe->save();

                    $charge = new ChargeLog();
                    $charge->payment_id = $paymentID;
                    $charge->campaign_id = $payCreate->campaign_id;
                    $charge->msisdn = $payCreate->user_msisdn;
                    $charge->keyword = $payCreate->keyword;
                    $charge->amount = $payExe->amount;
                    $charge->type = 'subs';
                    $charge->charge_date = $date;
                    $charge->save();

                    $subsUnsubs->message = 'success';
                } else {
                    $payExe->transaction_status = 'failed';
                    $payExe->save();
                    $subsUnsubs->message = 'failed';
                }

                // $campaign->incrementParticipation();

            }

            $subs->campaign_id = $payCreate->campaign_id;
            $subs->msisdn = $payCreate->user_msisdn;
            $subs->payment_id = $paymentID;
            $subs->keyword = $payCreate->keyword;
            $subs->subs_date = $date;
            if ($payQuery['transaction_status'] == 'Completed') {
                $subs->status = 1;
                $subsUnsubs->status = 1;
            } else {
                $subs->status = 0;
                $subsUnsubs->status = 0;
            }
            $subs->save();



            // subs unsubs log
            $subsUnsubs->msisdn = $payCreate->user_msisdn;
            $subsUnsubs->subscription_id = $subs->id;
            $subsUnsubs->payment_id = $paymentID;
            $subsUnsubs->type = 'subs';
            $subsUnsubs->keyword = $payCreate->keyword;
            $subsUnsubs->date = $date;
            $subsUnsubs->save();
            return redirect($redirectURL);
        } catch (\Throwable $th) {
            return redirect('/?payment=failed&campaign_id=' . $payCreate->campaign_id);
        }
    }

    public function executePaymentForPurchaseCoin($payCreate)
    {

        $payment_url = 'https://checkout.pay.bka.sh/v1.2.0-beta/checkout/payment/execute/' . $payCreate->payment_id;
        $id_token = $payCreate->id_token;

        $url = curl_init($payment_url);
        $header = array(
            'Content-Type:application/json',
            "authorization: $id_token",
            'x-app-key:2l6u3m4i01ed69foin29vp42m'
        );
        curl_setopt($url, CURLOPT_HTTPHEADER, $header);
        curl_setopt($url, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($url, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($url, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($url, CURLOPT_TIMEOUT, 30);
        $response = curl_exec($url);
        curl_close($url);
        $payExe = new PaymentExecute();
        $payExe->campaign_id = $payCreate->campaign_id;
        $payExe->payment_create_id = $payCreate->id;
        $payExe->keyword = $payCreate->keyword;
        $payExe->user_msisdn = $payCreate->user_msisdn;
        $payExe->response = $response;

        $response = json_decode($response, true);

        $redirectURL = '/';

        if (isset($response['errorCode'])) {
            $payExe->error_code = $response['errorCode'];
            $payExe->error_message = $response['errorMessage'];
            $payExe->amount = $payCreate->amount;
            $payExe->invoice_no = $payCreate->invoice_no;
            $payExe->payment_id = $payCreate->payment_id;
            $payExe->transaction_status = 'failed';
            $redirectURL = '/' . $payCreate->redirect_url . '/?payment=failed';
            $payExe->save();
            return redirect($redirectURL);
        } else {

            $payExe->invoice_no = $response['merchantInvoiceNumber'];
            $payExe->payment_id = $response['paymentID'];
            $payExe->bkash_msisdn = $response['customerMsisdn'];
            $payExe->amount = $response['amount'];
            $payExe->trxID = $response['trxID'];
            $payExe->transaction_status = $response['transactionStatus'];
            $payExe->error_message = "";
            $redirectURL = '/' . $payCreate->redirect_url . '/?payment=success';
            $payExe->save();
        }
        // charge log
        $charge = new ChargeLog();
        $charge->payment_id = $payCreate->payment_id;
        $charge->campaign_id = $payCreate->campaign_id;
        $charge->msisdn = $payCreate->user_msisdn;
        $charge->keyword = $payCreate->keyword;
        $charge->amount = $payExe->amount;
        $charge->type = 'buy-coins';
        $charge->charge_date = date('Y-m-d');
        $charge->save();

        $newCoin = new CoinLog();
        $newCoin->user_id = Auth::user()->id;
        $newCoin->campaign_id = null;
        $newCoin->phone = Auth::user()->phone;
        $newCoin->coin = intval($payExe->amount) * 100;
        $newCoin->status = "success";
        $newCoin->type = "buy";
        $newCoin->message = "Purchased " . $newCoin->coin . " coins";
        $newCoin->date = Carbon::now()->toDateString();
        $newCoin->time = Carbon::now()->toTimeString();
        $newCoin->save();

        Auth::user()->increment('coin', $newCoin->coin);

        $redirectURL = $redirectURL . '&coins=' . $newCoin->coin;

        return redirect($redirectURL);
    }


    public function getInvoiceNo()
    {

        $invoice_no = rand(111111, 999999);

        $findIsExist = PaymentCreate::select()->where('invoice_no', $invoice_no)->first();

        if ($findIsExist) {
            $this->getInvoiceNo();
        }
        return $invoice_no;
    }
}
