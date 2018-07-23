<?php
/**
 * Created by PhpStorm.
 * User: Luc
 * Date: 17-Jun-18
 * Time: 23:09
 */

namespace App\Http\Controllers\Mobile;


use App\Http\Controllers\BusinessFunction\PaymentBusinessFunction;
use App\Http\Controllers\BusinessFunction\StaffBusinessFunction;
use App\Http\Controllers\Mobile\BaseController;
use App\Model\PaymentDetail;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use PayPal\Api\Payment;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;


class PaymentController extends BaseController
{
    use PaymentBusinessFunction;
    use StaffBusinessFunction;

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

    public function verifyPaymentPaypal(Request $request)
    {
//        $response["error"] = false;
//        $response["message"] = "Payment verified successfully";
        global $userId;


//        require_once '../include/Config.php';
        $paymentId = $request->input('payment_id');
        $localPaymentId = $request->input('local_payment_id');
        $paymentClientJson = $request->input('payment_client_json');
        Log::info("PaymentId: " . $localPaymentId . " PaymentId: " . $paymentId . " PaymentJson: " . $paymentClientJson);
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

            $payment = $this->getPaymentById($localPaymentId);
            if ($payment == null) {
                $error = $this->getErrorObj("Không tìm thấy thông tin thanh toán",
                    "No exception in payment == null");
                return response()->json($error, 400);
            }
            $user = $payment->beLongsToUser()->first();
            $staff = $user == null ? null : $user->belongToStaff()->first();
            $received_money = $payment->total_price - $payment->paid;
            $payment->paid = $payment->total_price;
            $payment->is_done = 1;
            $paymentDetail = new PaymentDetail();
            $paypalStaff = $this->getStaffByName('paypal');
            $paymentDetail->payment_id = $localPaymentId;
            $paymentDetail->received_money = $received_money;
            $paymentDetail->date_create = Carbon::now();
            $paymentDetail->staff_id = $paypalStaff->id;
            $result = $this->updatePaymentModel($payment, $paymentDetail);
//            $this->logInfo('userid: '.$user->id);
//            $this->logInfo('paymentdetail id:'.$paymentDetail->id);

//            Log::info("RESULT  ");
            if ($result) {
//                Log::info("RESULT khac null");
                $listPayments = $this->getPaymentByPhone($payment->phone);
                return response()->json($listPayments, 200);
            } else {
                $error = $this->getErrorObj("Lỗi không thể lưu dữ liệu",
                    "No exception result null");
//                Log::info("RESULT bang  null");
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

    public function updatePaymentPrice(Request $request)
    {
        $paymentId = $request->input('payment_id');
        $staffId = $request->input('staff_id');
        $payment = $this->getPaymentById($paymentId);
        try {
            if ($payment != null) {
                if ($payment->is_done == 1) {
                    $error = $this->getErrorObj("Bạn đã thanh toán cho điều trị", "No exception");
                    return response()->json($error, 400);
                }
                $payRequired = $payment->total_price - $payment->paid;
                $amount = $request->input('amount');
                if ($amount > $payRequired) {
                    $error = $this->getErrorObj("Số tiền phải trả vượt quá số tiền cần trả", "No exception");
                    return response()->json($error, 400);
                }
                $payment->paid = $payment->paid + $amount;
                if ($payment->paid == $payment->total_price) {
                    $payment->is_done = 1;
                }
                $paymentDetail = new PaymentDetail();
                $paymentDetail->payment_id = $payment->id;
                $paymentDetail->staff_id = $staffId;
                $paymentDetail->received_money = $amount;
                $paymentDetail->date_create = Carbon::now();
                $this->updatePaymentModel($payment, $paymentDetail);
                $successReponse = $this->getSuccessObj(200, "OK", "Thanh toán thành công", "No data");
                return response()->json($successReponse);
            } else {
                $error = $this->getErrorObj("Không tìm thấy id của thanh toán", "No exception");
                return response()->json($error, 400);
            }
        }catch (Exception $ex){
            $error = $this->getErrorObj("Lỗi máy chủ", $ex);
            return response()->json($error, 500);
        }

    }


}