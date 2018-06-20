<?php

namespace App\Http\Controllers\Mobile;

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
                $image = $request->file('image');
                $path = public_path() . '/photos/avatar';
                $filename = 'user_avatar_'.$phone. '.'.$image->getClientOriginalExtension();
//                dd($filename); 
                $fullpath = $path .$filename;
                $image->move($path, $filename);
//                $post->image = $path;
                return response($fullpath, 200);
            } else {

            }
        }catch(\Exception $ex){
            return response()->json('php sida');
        }
    }


}
