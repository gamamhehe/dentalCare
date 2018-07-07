<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BusinessFunction\PaymentBusinessFunction;
use App\Http\Requests;
use App\Model\PaymentDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Validator;
use URL;
use Session;
use Redirect;
use Input;

/** All Paypal Details class **/
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\Amount;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\ExecutePayment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\Transaction;
use App\Http\Controllers\Controller;

class PaypalController extends Controller
{
    use PaymentBusinessFunction;
    private $_api_context;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
//        parent::__construct();

        /** setup PayPal api context **/
        $paypal_conf = \Config::get('paypal');
        $this->_api_context = new ApiContext(new OAuthTokenCredential($paypal_conf['client_id'], $paypal_conf['secret']));
        $this->_api_context->setConfig($paypal_conf['settings']);
    }

    /**
     * Show the application paywith paypalpage.
     *
     * @return \Illuminate\Http\Response
     */
    public function payWithPaypal()
    {
        return view('danhsachchitra');
    }

    /**
     * Store a details of payment with paypal.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postPaymentWithpaypal(Request $request)
    {
        $payer = new Payer();
        $payer->setPaymentMethod('paypal');
        $amountPayment = $request->amount/20000;
        $amount = new Amount();
        $amount->setCurrency('USD')
            ->setTotal($amountPayment);

        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setDescription('Your transaction description');

        $redirect_urls = new RedirectUrls();
        $redirect_urls->setReturnUrl(URL::route('status')) /** Specify return URL **/
        ->setCancelUrl(URL::route('status'));

        $payment = new Payment();
        $payment->setIntent('Sale')
            ->setPayer($payer)
            ->setRedirectUrls($redirect_urls)
            ->setTransactions(array($transaction));
        /** dd($payment->create($this->_api_context));exit; **/
        try {
            $payment->create($this->_api_context);
        } catch (\PayPal\Exception\PPConnectionException $ex) {
            if (\Config::get('app.debug')) {
                \Session::put('error','Connection timeout');
                return Redirect::route('danhsachchitra');
                /** echo "Exception: " . $ex->getMessage() . PHP_EOL; **/
                /** $err_data = json_decode($ex->getData(), true); **/
                /** exit; **/
            } else {
                \Session::put('error','Some error occur, sorry for inconvenient');
                return Redirect::route('danhsachchitra');
                /** die('Some error occur, sorry for inconvenient'); **/
            }
        }

        foreach($payment->getLinks() as $link) {
            if($link->getRel() == 'approval_url') {
                $redirect_url = $link->getHref();
                break;
            }
        }

        /** add payment ID to session **/
        session(['paypal_payment_id' => $payment->getId()]);
        session(['payment_id' => $request->payment_id]);
        session(['amount' => $amountPayment]);
        if(isset($redirect_url)) {
            /** redirect to paypal **/
            return Redirect::away($redirect_url);
        }

        \Session::put('error','Unknown error occurred');
        return Redirect::route('danhsachchitra');
    }

    public function getPaymentStatus(Request $request)
    {
        /** Get the payment ID before session clear **/
        $payment_id = $request->session()->get('paypal_payment_id', null);
        /** clear the session payment ID **/
        $request->session()->remove('paypal_payment_id');
//        dd($request);
        if (empty($request->PayerID) || empty($request->token)) {
            \Session::put('error','Payment failed');
            return Redirect::route('danhsachchitra');
        }
        $payment = Payment::get($payment_id, $this->_api_context);
        /** PaymentExecution object includes information necessary **/
        /** to execute a PayPal account payment. **/
        /** The payer_id is added to the request query parameters **/
        /** when the user is redirected from paypal back to your site **/
        $execution = new PaymentExecution();
        $execution->setPayerId($request->PayerID);
        /**Execute the payment **/
        $result = $payment->execute($execution, $this->_api_context);
        /** dd($result);exit; /** DEBUG RESULT, remove it later **/
        if ($result->getState() == 'approved') {

            /** it's all right **/
            /** Here Write your database logic like that insert record or value in database if you want **/
            $this->updatePaymentPrepaid($request->session()->get('amount', 0) * 20000, $request->session()->get('payment_id'));
            $paymentDetail = new PaymentDetail();
            $paymentDetail->payment_id = $request->session()->get('payment_id');
            $paymentDetail->received_money = $request->session()->get('amount', 0) * 20000;
            $paymentDetail->date_create = Carbon::now();
            $paymentDetail->staff_id = 1;

            $this->createPaymentDetail($paymentDetail);
            $request->session()->remove('payment_id');
            $request->session()->remove('amount');
            \Session::put('success','Payment success');
            return Redirect::route('danhsachchitra');
        }
        \Session::put('error','Payment failed');

        return Redirect::route('danhsachchitra');
    }
}