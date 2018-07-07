<?php
/**
 * Created by PhpStorm.
 * User: Luc
 * Date: 06-Jul-18
 * Time: 21:27
 */

namespace App\Http\Controllers\Mobile;


use App\Helpers\AppConst;
use App\Http\Controllers\Controller;

class BaseController extends Controller
{
    public function getErrorObj($message, $exceptionObj)
    {
        $error = new \stdClass();
        $error->error = $message;
        $error->exception = $this->getExceptionMsg($exceptionObj);
        return $error;
    }

    public function getSuccessObj($code, $status, $message, $data)
    {
        $successResponse = new \stdClass();
        $successResponse->code = $code;
        $successResponse->status = $status;
        $successResponse->message = $message;
        $successResponse->data = $data;
        return $successResponse;
    }

    public function getExceptionMsg($exceptionObj)
    {
        $message = "No exception";
        if ($exceptionObj != null && is_object($exceptionObj)) {
            $message = 'Message: ' . ($exceptionObj->getMessage())
                . ' File: ' . $exceptionObj->getFile()
                . ' Line: ' . $exceptionObj->getLine();
        }
        return $message;
    }
}