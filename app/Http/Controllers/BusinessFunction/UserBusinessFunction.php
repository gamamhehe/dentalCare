<?php
/**
 * Created by PhpStorm.
 * User: gamamhehe
 * Date: 6/10/2018
 * Time: 12:55 AM
 */

namespace App\Http\Controllers\BusinessFunction;

use App\Model\User;
use Illuminate\Support\Facades\Hash;

trait UserBusinessFunction
{


    /**
     * @param $phone
     * @param $password
     * @return int
     */
    public function CheckLogin($phone, $password)
    {
        $result = User::where('phone', $phone)->first();
        if ($result != null) {
            if (Hash::check($password, $result->password)) {
                return $result;
            }
        } else {
            return null;
        }
    }
}