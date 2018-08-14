<?php
/**
 * Created by PhpStorm.
 * User: Luc
 * Date: 03-Jul-18
 * Time: 09:12
 */

namespace App\Helpers;


use DateTime;

class AppConst
{
    const RESPONSE_REMINDER = 'RESPONSE_REMINDER';
    const RESPONSE_FEEDBACK = 'RESPONSE_FEEDBACK';
    const RESPONSE_PROMOTION = 'RESPONSE_PROMOTION';
    const RESPONSE_RELOAD = 'RESPONSE_RELOAD';

    const TOPIC_PROMOTION = "PROMOTION";

    const MSG_SMS_APPOINTMENT = "";
    const MSG_REMINDER_APPOINTMENT = "Lịch hẹn của bạn sẽ diễn ra trong vòng 30 phút nữa";
    const MSG_REMINDER_FORGOT_APPOINTMENT = "XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX";

    const MSG_LOGOUT_ERROR = "Không tìm thấy phiên đăng nhập của tài khoản";
    const MSG_LOGOUT_SUCCESS = "Đăng xuất thành công";


    const PERSONAL_CLIENT_ID = 'PERSONAL_CLIENT_ID';
    const PERSONAL_CLIENT_SECRET = 'PASSWORD_CLIENT_SECRET';

    const PASSWORD_CLIENT_ID = 'PASSWORD_CLIENT_ID';
    const PASSWORD_CLIENT_SECRET = 'PASSWORD_CLIENT_SECRET';

    const ROLE_ADMIN = 1;
    const ROLE_DENTIST = 2;
    const ROLE_RECEPTIONIST = 3;
    const ROLE_PATIENT = 4;

    const TREATMENT_HISTORY_PATH = '/assets/images/TreatmentHistory/';
    const AVATAR_PATH = '/assets/images/avatar/';


    const ACTION_RELOAD_APPOINTMENT = "ACTION_RELOAD_APPOINTMENT";
//  0 vua tao =>Chua tới
//  1 da toi
//  2 dang kham
//  3 xong
//  4 xoa
    const APPT_STATUS_CREATED = 0;
    const APPT_STATUS_ISCOMMING = 1;
    const APPT_STATUS_TREATING = 2;
    const APPT_STATUS_DONE = 3;
    const APPT_STATUS_DELETED = 4;
    const APPT_STATUS_SENT = 5;

//  const PAYMENT_STATUS_
//  const PAYMENT_STATUS_
//  const PAYMENT_STATUS_
    const PAYMENT_STATUS_NOT_DONE = 1;
    const PAYMENT_STATUS_DONE = 2;
    const PAYMENT_STATUS_CANCEL = 3;

    /**
     * @param $order numerical_order of appointment
     * @param $date DateTime Object
     * @param bool $isVnMSG
     * @return string
     */
    public static function getSmsMSG($order, $date, $isVnMSG = false)
    {
        $startTime = $date->format("H:i");
        $startDate = $date->format("d-m-Y");
        if ($isVnMSG) {
            return "Cảm ơn bạn đã đặt lịch khám, số thứ tự của bạn là "
                . $order . ' .Dự kiến khám lúc ' . $startTime . ' ngày ' . $startDate . ' tại 190 Trường Chinh - Quận 12 - TP HCM';
        } else {
            return "Cam on ban da dat lich kham, so thu tu cua ban la "
                . $order . ' .Du kien kham vao luc ' . $startTime . ' ngay ' . $startDate . ' tai 190 Truong Chinh - Quan 12 - TP HCM';
        }
    }

    public static function getSmsNewUser()
    {
        return "Tai khoan mat khau mac dinh tai Dental Gold la so dien thoai cua ban.";
    }

    public static function getSmsMSGForAbsent($name, $startDate, $endDate)
    {
//
//        $startDate = $date->format("d-m-Y");
//        $endDate = $date->format("d-m-Y");
//        return "Đon xin nghi cua " . $name . " da duoc chap nhan.Bat dau tu ngay "
//            . $startDate . 'den het ngay  ' . $startTime . '  .';
    }
}