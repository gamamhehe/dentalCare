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
use PayPal\Api\Payment;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;


class PaymentController extends BaseController
{
    use PaymentBusinessFunction;

    public function getByPhone(Request $request,$phone)
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
        $response["error"] = false;
        $response["message"] = "Payment verified successfully";
        global $userId;


//        require_once '../include/Config.php';
        $paymentId = $request->input('payment_id');
        $paymentClientJson = $request->input('payment_client_json');

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

            // Verifying the state approved
            if ($payment->getState() != 'approved') {
                $response["error"] = true;
                $response["message"] = "Payment has not been verified. Status is " . $payment->getState();
//                echoResponse(200, $response);
                $error = $this->getErrorObj("Thanh toán chưa được xác thực", "No exception");
                return $response()->json($error);
            }

            // Amount on client side
            $amount_client = $payment_client["amount"];

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
//            $payment_id_in_db = $db->storePayment($payment->getId(), $userId, $payment->getCreateTime(), $payment->getUpdateTime(), $payment->getState(), $amount_server, $amount_server);

            // Verifying the amount
            if ($amount_server != $amount_client) {
                $response["error"] = true;
                $response["message"] = "Payment amount doesn't matched.";
//                echoResponse(200, $response);
                $error = $this->getErrorObj("Số tiền thanh toán không hợp lệ", "No exception");

                return $response()->json($error);
            }

            // Verifying the currency
            if ($currency_server != $currency_client) {
                $response["error"] = true;
                $response["message"] = "Tiền tệ không hợp lệ";
//                echoResponse(200, $response);
$error = $this->getErrorObj("Tiền tệ không hợp lệ", "No exception");

                return $response()->json($response);
            }

            // Verifying the sale state
            if ($sale_state != 'completed') {
                $response["error"] = true;
                $response["message"] = "";
//                echoResponse(200, $response);
                $error = $this->getErrorObj("Giao dịch không thành công", "No exception");

                return $response()->json($response);
            }

            // storing the saled items
//            insertItemSales($payment_id_in_db, $transaction, $sale_state);

//            echoResponse(200, $response);
                return $response()->json("SUCCESS");
        } catch (\PayPal\Exception\PayPalConnectionException $exc) {
            if ($exc->getCode() == 404) {
                $response["error"] = true;
                $response["message"] = "Payment not found!";
                $error = $this->getErrorObj(
                    "Không tìm thấy payment",
                    "No exception"
                );
                return response()->json($error, 400);
            } else {
                $response["error"] = true;
                $response["message"] = "Unknown error occurred!" . $exc->getMessage();
                $error = $this->getErrorObj(
                    "Lỗi không xác định",
                    "No exception"
                );
                return response()->json($error, 400);
            }
        } catch (\Exception $exc) {
            $response["error"] = true;
            $response["message"] = "Unknown error occurred!" . $exc->getMessage();
            $error = $this->getErrorObj(
                "Unknown error occurred!",
                $this->getExceptionMsg($exc)
            );
            return response()->json($error, 400);
        }

    }


}