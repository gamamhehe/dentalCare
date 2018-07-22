<?php
/**
 * Created by PhpStorm.
 * User: Luc
 * Date: 21-Jul-18
 * Time: 22:09
 */

namespace App\Http\Controllers\Mobile;


use App\Http\Controllers\BusinessFunction\RequestAbsentBusinessFunction;

class RequestAbsentController extends  BaseController
{
    use RequestAbsentBusinessFunction;
        public function changeStatusDelete($requestAbsentId){
            $requestAbsent = $this->getReqAbsentById($requestAbsentId);
            try {
                if ($requestAbsent != null) {
                    $requestAbsent->is_deleted = 1;
                    $this->updateRequestAbsent($requestAbsent);
                    $successResponse = $this->getSuccessObj(200, "OK", "Xóa thành công", "Null");
                    return response()->json($successResponse, 200);
                } else {
                    $error = $this->getErrorObj("Không tìm thấy đơn xin nghỉ", 400);
                    return response()->json($error, 400);
                }
            }catch (\Exception $ex){
                $error = $this->getErrorObj("Lỗi máy chủ", $ex);
                return response()->json($error, 500);
            }
        }
}