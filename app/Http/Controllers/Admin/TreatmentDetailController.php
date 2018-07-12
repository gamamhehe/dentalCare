<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\BusinessFunction\TreatmentHistoryBusinessFunction;
use App\Http\Controllers\BusinessFunction\TreatmentDetailBusinessFunction;
use App\Http\Controllers\BusinessFunction\TreatmentImagesBusinessFunction;
use App\Http\Controllers\BusinessFunction\MedicineBusinessFunction;
class TreatmentDetailController extends Controller
{
	use TreatmentHistoryBusinessFunction;
	use TreatmentDetailBusinessFunction;
	use TreatmentImagesBusinessFunction;
	use MedicineBusinessFunction;
  	public function createTreatmentDetailController(Request $request){
  		 // $idTreatmentHistory=$request['idTreatmentHistory'];

      //details
  		$idTreatmentHistory=$request->idTreatmentHistory;
  		$description =$request['description'];
  		$dentist = $request->session()->get('currentAdmin');
  		$staffId= $dentist->belongToStaff()->first()->id;
  		$TreatmentDetailId =$this->createTreatmentDetail($idTreatmentHistory,$description,$staffId);
  		if($TreatmentDetailId){
	  			$message = 'success';
	  		}else{
	  			 $message = 'error';

	  			 return redirect()->back()->withInput()->with('message', $message);
	  		}
  		//done treatDetail
  		//image
  		$totalImg =$request['totalImg'];
  		for($i = 1;$i<= $totalImg;$i++){
  			$imgName = "img".$i;
  			$imgLink = $request[$imgName];
  			$result = $this->createTreatmentImage($TreatmentDetailId,$imgLink);
	  		if($result){
	  			$message = 'success';
	  		}else{
	  			 $message = 'error';

	  			 return redirect()->back()->withInput()->with('message', $message);
	  		}

  		}
      //done image
  		//medicine

      $medicine =$request['medicine'];
      $quantity =$request['quantity'];


        $resultMedicine = $this->createMedicineForTreatmentDetail($medicine,$TreatmentDetailId,$quantity);
      if($resultMedicine){
          $message = 'success';
        }else{
           
           $message = 'error';
           return redirect()->back()->withInput()->with('message', $message);
        }
      //done medicine
      //stepDo
        
        $steps =$request['step'];
       

        if(count($steps) != 0 ){
        $resultTreatmentStep = $this->createTreatmentDetailStep($steps,$TreatmentDetailId);
        if($resultTreatmentStep == TRUE){
         $message = 'success';
        }else{
          $message = 'error';
           return redirect()->back()->withInput()->with('message', $message);
        }
      }
      //end step
        return redirect('admin/treatmentDetail/'.$TreatmentDetailId);
 

  	}
    public function viewTreatmentDetailController(Request $request,$id){
      $treatmentDetail = $this->viewTreatmentDetail($id);
      $listMedicine = $this->loadMedicineOfTreatmentDetail($id);
      $listImg = $this->getImageByTreatmentDetail($id);
      $listStep = $this->getTreatmentDetailStep($id);
      return view('admin.StepTreatment.review',['listMedicine'=>$listMedicine,'listImg'=>$listImg,'listStep'=>$listStep,'treatmentDetail'=>$treatmentDetail]);
    }
}
