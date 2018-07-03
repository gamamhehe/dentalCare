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