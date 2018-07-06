<?php
/**
 * Created by PhpStorm.
 * User: Luc
 * Date: 06-Jul-18
 * Time: 21:27
 */

namespace App\Http\Controllers\Mobile;


use App\Http\Controllers\Controller;

class BaseController extends Controller
{
    public function getErrorObj($message,$exceptionObj){
        $error = new \stdClass();
        $error->error= $message;
        $error->exception = $this->getExceptionMsg($exceptionObj);
        return $error;
    }

    public function getExceptionMsg($exceptionObj){
        $message = "No exception";
        if($exceptionObj!=null) {
            $message ='Message: ' . $exceptionObj->getMessage()
                . ' File: ' . $exceptionObj->getFile()
                . ' Line: ' . $exceptionObj->getLine();
        }
        return $message;
    }
}