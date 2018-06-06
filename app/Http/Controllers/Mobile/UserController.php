<?php
/**
 * Created by PhpStorm.
 * User: Luc
 * Date: 04-Jun-18
 * Time: 11:43
 */

namespace App\Http\Controllers\Mobile;


use App\Model\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Mockery\Exception;

class UserController extends Controller
{


    public function register(Request $request)
    {
        try {
            $user = User::where('phone', $request->input('phone'))
                ->first();
            if ($user != null) {
                $error = new \stdClass();
                $error->error = "Số điện thoại đã tồn tại";
                $error->exception = "No Exception";
                return response()->json($error, 200);
            } else {
                $user = new User();
                $user->phone = $request->input('phone');
                $user->password = $request->input('password');
                ////HASH
                $user->isActive = 1;
                $user->isDelete = 0;
                $user->save();
                return response()->json($user, 200);
            }
        } catch (\Exception $ex) {
            $error = new \stdClass();
            $error->error = "Không thể đăng kí thông tin người dùng";
            $error->exception = $ex;
            return response()->json($error, 200);
        }
    }

    /**
     * @param Request $request
     * @return json
     */
    public function login(Request $request)
    {
        try {
            $error = new \stdClass();
            $phone = $request->input('phone');
            $password = $request->input('password');
            Log::info("LOGIN " . $phone);
            Log::info("LOGINI2" . $password);
            $user = User::where('phone', $phone)
                ->where('password', $password)
                ->first();
            if ($user != null) {
                return response()->json($user, 200);
            } else {
                $error->error = "Số điện thoại hoặc mật khẩu không chính xác";
                $error->exception = "No exception";
                return response()->json($error, 400);
            }
        } catch (Exception $ex) {
            $error->error = "Đã xảy ra lỗi";
            $error->exception = $ex;
            return response()->json($ex, 400);
        }
    }
    public
    function bookAppointment(Request $request)
    {
        ///lclclclcl

        return response()->json([$request->all()], 200);
    }
    public function loginGET()
    {
        return response()->json(['hello' => 'cha co gi ca haha'], 200);
    }


}