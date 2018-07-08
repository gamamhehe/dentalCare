<?php
/**
 * Created by PhpStorm.
 * User: Luc
 * Date: 17-Jun-18
 * Time: 23:09
 */

namespace App\Http\Controllers\Mobile;


use App\Http\Controllers\BusinessFunction\PaymentBusinessFunction;
use App\Http\Controllers\Mobile\BaseController;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use PayPal\Api\Payment;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;


class PaymentController extends BaseController
{
    use PaymentBusinessFunction;

    public function getByPhone(Request $request, $phone)
    {
        try {
            $payments = $this->getPaymentByPhone($phone);
            return response()->json($payments, 200);
        } catch (\Exception $ex) {
            $error = new \stdClass();
            $error->error = "Có lỗi xảy ra, không thể lấy dữ liệu";
            $error->exception = $ex->getMessage() . " File: " . $ex->getFile() . " line: " . $ex->getLine();
            return response()->json($error, 400);
        }
    }

    public function verifyPayment(Request $request)
    {
//        $response["error"] = false;
//        $response["message"] = "Payment verified successfully";
        global $userId;


//        require_once '../include/Config.php';
        $paymentId = $request->input('payment_id');
        $localPaymentId = $request->input('local_payment_id');
        $paymentClientJson = $request->input('payment_client_json');
        Log::info("PaymentId: " . $localPaymentId." PaymentId: " . $paymentId . " PaymentJson: " . $paymentClientJson);
        try {
            $payment_client = json_decode($paymentClientJson, true);

            $apiContext = new  ApiContext(
                new OAuthTokenCredential(
                    env('PAYPAL_CLIENT_ID', false), // ClientID
                    env('PAYPAL_SECRET', false)// ClientSecret
                )
            );

            // Gettin payment details by making call to paypal rest api
            $payment = Payment::get($paymentId, $apiContext);
            Log::info("Payment State: " . $payment->getState());
            // Verifying the state approved
            if ($payment->getState() != 'approved') {
                $error = $this->getErrorObj(
                    "Thanh toán chưa được xác thực",
                    "No exception approve");
                return response()->json($error);
            }

            // Amount on client side
            $amountClient = $payment_client["amount"];

            // Currency on client side
            $currency_client = $payment_client["currency_code"];

            // Paypal transactions
            $transaction = $payment->getTransactions()[0];
            // Amount on server side
            $amount_server = $transaction->getAmount()->getTotal();
            // Currency on server side
            $currency_server = $transaction->getAmount()->getCurrency();
            $sale_state = $transaction->getRelatedResources()[0]->getSale()->getState();

            // Storing the payment in payments table
//            $db = new DbHandler();

            //
//            $paymentRecord = $this->getPaymentById($localPaymentId);

//            $payment_id_in_db =
//                $db->storePayment(
//                    $payment->getId(),
//                    $userId, $payment->getCreateTime(),
//                    $payment->getUpdateTime(),
//                    $payment->getState(),
//                    $amount_server,
//                    $amount_server);
            // Verifying the amount
            if ($amount_server != $amountClient) {
                $error = $this->getErrorObj(
                    "Số tiền thanh toán không hợp lệ",
                    "No exception amount client");
                return response()->json($error, 400);
            }
            // Verifying the currency
            if ($currency_server != $currency_client) {
                $error = $this->getErrorObj(
                    "Tiền tệ không hợp lệ",
                    "No exception currency client");
                return response()->json($error, 400);
            }
            // Verifying the sale state
            if ($sale_state != 'completed') {
                $error = $this->getErrorObj(
                    "Giao dịch không thành công",
                    "No exception completed");
                return response()->json($error, 400);
            }
            // storing the saled items
//            insertItemSales($payment_id_in_db, $transaction, $sale_state);
//            return response()->json($response);
            $result = $this->updatePaymentPaid($amountClient, $localPaymentId);
            if($result){
                return response()->json("SUCCESS",200);
            }else{
                $error = $this->getErrorObj("Lỗi không thể lưu dữ liệu",
                    "No exception result null");
                return response()->json($error, 400);
            }
        } catch (\PayPal\Exception\PayPalConnectionException $exc) {
            $this->logInfo("EXCEPTION: " . $exc->getMessage());
            if ($exc->getCode() == 404) {
                $error = $this->getErrorObj(
                    "Không tìm thấy payment 404",
                    $exc);
                return response()->json($error, 400);
            } else {
                $error = $this->getErrorObj(
                    "Lỗi không xác định else",
                    $exc);
                return response()->json($error, 400);
            }
        } catch (\Exception $exc) {
            $error = $this->getErrorObj(
                "Unknown error occurred!",
                $this->getExceptionMsg($exc)
            );
            $this->logInfo("EXCEPTION: " . $exc->getMessage());
            return response()->json($error, 400);
        }

    }


}