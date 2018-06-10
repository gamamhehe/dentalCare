<?php

namespace App\Http\Controllers\Mobile;

use App\Model\City;
use App\Model\District;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AddressController extends Controller
{
    public function getAllCitites(){
        $cities = City::all();
        return response()->json($cities, 200);
    }

    public function getDistrictsByCity($cityId){
        $districts = District::where('city_id',$cityId)->get();
        return response()->json($districts,200);
    }
}
