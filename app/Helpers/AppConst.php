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

    const MSG_SMS_APPOINTMENT = "";
    const MSG_REMINDER_APPOINTMENT = "Lịch hẹn của bạn sẽ diễn ra trong vòng 30 phút nữa";

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
//0 vua tao
//1 dang kham
//2 xong
    /**
     * @param $order numerical_order of appointment
     * @param $date DateTime Object
     * @return string
     */
    public static function getSmsMSG($order, $date)
    {
        $startTime = $date->format("H:i");
        $startDate = $date->format("d-m-Y");
        return "Cam on ban da dat lich kham, so thu tu cua ban la "
            . $order . ' .Du kien kham vao luc ' . $startTime . ' ngay ' . $startDate;
    }
}