<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BusinessFunction\AppointmentBussinessFunction;
use App\Http\Controllers\BusinessFunction\TreatmentBusinessFunction;
use App\Http\Controllers\BusinessFunction\TreatmentDetailBusinessFunction;
use App\Http\Controllers\BusinessFunction\TreatmentHistoryBusinessFunction;
use Illuminate\Http\Request;
use \Carbon\Carbon;
use App\Http\Controllers\Controller;

class TreatmentHistoryController extends Controller
{
    //
    use TreatmentHistoryBusinessFunction;
    use TreatmentDetailBusinessFunction;
    use TreatmentBusinessFunction;
    use AppointmentBussinessFunction;

    public function createTreatmentHistory(Request $request)
    {

        $idTreatmentHistory = $this->createTreatmentProcess($request->treatment_id, $request->patient_id, $request->tooth_number, $request->price, $request->description);
        if ($idTreatmentHistory) {
            return redirect()->route("admin.stepTreatment", ['idTreatmentHistory' => $idTreatmentHistory,
                'idTreatment' => $request->treatment_id]);

        } else {
            return redirect()->back()->withSuccess("Chưa");
        }
    }

    public function showTreatmentHistory(Request $request)
    {
        $patient = $request->session()->get('currentPatient', null);
        $result = [];
        if ($patient) {
            $idPatient = $patient->id;
            $result = $this->getTreatmentHistory($idPatient);
        }
        return view('WebUser.TreatmentHistory', ['listTreatmentHistory' => $result]);
    }

    public function getTreatmentHistoryByPatient($id)
    {
        $checkComingAppointment = $this->checkAppointmentComing($id);
        $data = array(
            'statusComing' => 0,
        );
        if ($checkComingAppointment) {
            $result = $this->getTreatmentHistoryByPatientId($checkComingAppointment);
            foreach ($result as $key) {
                $key->nameTreat = $key->belongsToTreatment()->first();
            }
            $data = array(
                'statusComing' => 1,
                'resultHis' => $result
            );
        }
        echo json_encode($data);
    }

    public function getList()
    {
        $treatmentHistoryList = $this->getListTreatmentHistory();
        return view('admin.treatmentHistory.list', ['treatmentHistoryList' => $treatmentHistoryList]);
    }

    public function getDetail(Request $request)
    {
        $treatmentHistory = $this->getTreatmentHistoryDetail($request->idTreatmentHistory);
        return view('admin.treatmentHistory.detail', ['treatmentHistory' => $treatmentHistory]);
    }

    public function search($searchValue)
    {
        $output = '';
        $data = $this->searchTreatmentHistory($searchValue);
        $total_row = $data->count();
        if ($total_row > 0) {
            foreach ($data as $row) {
                $row->price = number_format($row->price);
                $output .= '
         <tr class="even gradeC" align="left">
         <td style="text-align: center">' . $row->belongsToPatient()->first()->name . '</td>
                                        <td style="text-align: center">' . $row->belongsToPatient()->first()->phone . '</td>
                                        <td style="text-align: center">' . $row->belongsToTreatment()->first()->name . '</td>
                                        <td style="text-align: center">' . $row->tooth_number . '</td>
                                        <td style="text-align: center">' . $row->description . '</td>
                                        <td style="text-align: center">' . $row->price . 'VNĐ
                                        </td>
                                        <td align="center">
                                            <div>
                                                <form action="/admin/get-treatment-history-detail">
                                                     <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                                    <input type="hidden" name="idTreatmentHistory"
                                                           value="'. $row->id . '">
                                                    <button type="submit" class="btn btn-default btn-success">Xem chi tiết
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
         </tr>
        ';
            }
        }
        if ($total_row == 0) {
            $output = '
       <tr>
        <td align="center" colspan="5">Không Có Chi Trả Nào</td>
       </tr>
       ';
        }


        $data = array(
            'table_data' => $output,
            'total_data' => $total_row
        );
        echo json_encode($data);
    }

}
