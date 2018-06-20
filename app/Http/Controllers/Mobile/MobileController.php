<?php

namespace App\Http\Controllers\Mobile;

use App\Model\Patient;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Exception\RequestExceptionInterface;

class MobileController extends Controller
{

    /**
     *Dummy code to test laravel function
     * @GET
     * @param Request $request
     */
    public function test(Request $request)
    {

    }

    /**
     *Dummy code to test laravel function
     * @POST
     * @param Request $request
     */
    public function testPOST(Request $request)
    {
        try {
            if ($request->hasFile('image')) {
                $phone = $request->input('phone');
                $patient = Patient::where('phone', $phone)->first();
                if ($patient != null) {

                    $image = $request->file('image');
                    $path = public_path('\photos\avatar');
                    $filename = 'user_avatar_' . $phone . '.' . $image->getClientOriginalExtension();
//                dd($filename);
                    $fullPath = implode('/',array_filter(explode('/', $path .$filename)));
                    $image->move($path, $filename);
//                $post->image = $path;
                    $patient->avatar = $filename;
                    $patient->save();
                    $response = new \stdClass();
                    $response->message = "Thay đổi ảnh đại diện thành công";
                    $response->status ="OK";
                    $response->data = $fullPath;
                    return response()->json($response, 200);
                } else {
                    $error = new \stdClass();
                    $error->error = "Không thể tìm thấy số điện thoại " . $phone;
                    $error->exception = "Nothing";
                    return response()->json($error, 400);
                }
            } else {

                $error = new \stdClass();
                $error->error = "Lỗi khi nhận hình ảnh " ;
                $error->exception = "Nothing";
                return response()->json($error, 400);
            }
        } catch (\Exception $ex) {
            return response()->json('php sida' . $ex->getMessage());
        }
    }


}
