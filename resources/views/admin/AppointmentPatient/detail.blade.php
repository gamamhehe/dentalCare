@extends('admin.master')
@section('title', 'Chi tiết lịch hẹn')
@section('content')
    <div class="content-wrapper">
        <div class="box">
            <div class="panel panel-default" style="">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-sm-12" style="text-align: center;">
                        <label><h3>Chi tiết lịch hẹn</h3></label></div>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="form-group row">
                        <div class="col-md-12">
                            <!-- left -->
                            <div class="col-xs-6">
                                <div class="box-header with-border box-warning">
                                    <h3 class="box-title" style="float: left;">Thông tin lịch hẹn</h3>

                                </div>
                                <div class="panel-body">
                                    <div class="form-group row add">
                                        <div class="col-sm-4"><label>Thời gian bắt đầu</label></div>
                                        <div class="col-sm-6" style="padding-left: 0px;">
                                            <input type="text" value="{{$appointment->start_time}}" name="name"
                                                   class="form-control pull-right"  style="margin:0px;"
                                                   disabled/>
                                        </div>
                                    </div>
                                    <div class="form-group row add">
                                        <div class="col-sm-4"><label>Thời gian cuộc hẹn</label></div>
                                        <div class="col-sm-6" style="padding-left: 0px;">
                                            <input type="text" value="{{$appointment->estimated_time}}" name="name"
                                                   class="form-control pull-right"  style="margin:0px;"
                                                   disabled/>
                                        </div>
                                    </div>
                                    <div class="form-group row add">
                                        <div class="col-sm-4"><label>Trạng thái</label></div>
                                        <div class="col-sm-6" style="padding-left: 0px;">
                                            <input type="text" value="{{$appointment->statusString}}" name="name"
                                                   class="form-control pull-right"  style="margin:0px;"
                                                   disabled/>
                                        </div>
                                    </div>
                                    <div class="form-group row add">
                                            <div class="col-sm-4"><label>Số thứ tự</label></div>
                                            <div class="col-sm-6" style="padding-left: 0px;">
                                                <input type="text" value="{{$appointment->numerical_order}}" name="special" id="special" 
                                                       class="form-control pull-right"  style="margin:0px;" disabled 
                                                       />
                                            </div>
                                    </div>
                                    <div class="form-group row add">
                                            <div class="col-sm-4"><label>Bác sĩ</label></div>
                                            <div class="col-sm-6" style="padding-left: 0px;">
                                                <input type="text" value="{{$dentist->name}}" name="special" id="special" 
                                                       class="form-control pull-right"  style="margin:0px;" disabled 
                                                       />
                                            </div>
                                            <div class="col-sm-2">  @if($appointment->status ==1 )
                                        <a class="btn btn-info btn-sm applyChangePatient" style="float: right;"
                                           href="#"> Đổi bác sĩ
                                        </a>
                                        @endif</div>
                                    </div>
                                    
                                </div>
                            </div>
                            <!-- right -->
                            <div class="col-xs-6">
                               
                                    <div class="box-header with-border box-info">
                                        <h3 class="box-title" style="float: left;">Thông tin tài khoản</h3>
                                    </div>
                                     @if($patient)
                                    <div class="panel-body">
                                        <div class="form-group row add">
                                        @if($appointment->status != 0)
                                        <a class="btn btn-success btn-sm" style="float: right;"
                                           href="/admin/create-treatment/{{$patient->id}}"> Tạo mới liệu trình
                                        </a>
                                        @endif
                                        @if($appointment->status == 0)
                                        @if(Session::get('roleAdmin') == 3 or Session::get('roleAdmin') == 1)
                                          <a class="btn btn-info btn-sm applyApp" style="float: right;"
                                           href="#"> Nhận bệnh
                                        </a>
                                        @endif
                                        @endif
                                      
                                        </div>
                                        <div class="form-group row add">
                                            <div class="col-sm-4"><label>Họ tên</label></div>
                                            <div class="col-sm-6" style="padding-left: 0px;">
                                                <a href="/admin/thong-tin-benh-nhan/{{$patient->id}}">{{$patient->name}}</a>
                                               
                                            </div>
                                        </div>
                                        <div class="form-group row add">
                                            <div class="col-sm-4"><label>Số điện thoại</label></div>
                                            <div class="col-sm-6" style="padding: 0px;margin: 0px;">
                                                <input type="text" value="{{$appointment->phone}}" name="special" id="special" 
                                                       class="form-control pull-right"  style="margin:0px;" disabled 
                                                       />
                                            </div>
                                        </div>
                                        
                                        <div class="form-group row add">
                                            <div class="col-sm-4"><label>Bệnh tiền sử</label></div>
                                            <div class="col-sm-6" style="padding-left: 0px;">
                                                <ul style="padding: 0px;margin: 0px;">
                                                    @if($patient->Anamnesis)
                                                        @foreach($patient->Anamnesis as $key)
                                                            <li>{{$key->name}}</li>

                                                        @endforeach
                                                    @else
                                                        <p>Không có .</p>
                                                    @endif
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                     @else
                                    <div class="panel-body">
                                     <div class="form-group row add">
                                        <div class="col-sm-11">  * Bệnh nhân mới.Hãy cập nhật thông tin bệnh nhân</div>
                                        <div class="col-sm-1">
                                                @if($appointment->status != 0)
                                                <a class="btn btn-success btn-sm" style="float: right;"
                                                   href="#"> Tạo mới liệu trình
                                                </a>
                                                @endif
                                                @if($appointment->status == 0)
                                                    @if(Session::get('roleAdmin') == 3 or Session::get('roleAdmin') == 1)
                                                      <a class="btn btn-info btn-sm applyApp" style="float: right;"
                                                       href="#"> Nhận bệnh
                                                    </a>
                                                    @endif
                                                @endif
                                        </div>
                                     
                                        </div>
                                        <div class="form-group row add">
                                            <div class="col-sm-4"><label>Họ Tên</label></div>
                                            <div class="col-sm-6" style="padding: 0px;margin: 0px;">
                                                <input type="text" value="{{$appointment->name}}" name="name"
                                                       class="form-control pull-right" id="phone" style="margin:0px;width: 100%"
                                                       disabled/>
                                            </div>
                                        </div>
                                        <div class="form-group row add">
                                            <div class="col-sm-4"><label>Điện thoại</label></div>
                                            <div class="col-sm-6" style="padding: 0px;margin: 0px;">
                                                <input type="text" value="{{$appointment->phone}}" name="phone"
                                                       class="form-control pull-right" id="phone" style="margin:0px;width: 100%"
                                                       disabled/>
                                            </div>
                                        </div>
                                        
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
         @if($listTreatmentHistory)
        <div class="box box-info">
            <div class="panel panel-default" style="">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-sm-12" style="text-align: center;"> <h4>Lịch sử bệnh án</h4></div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <!-- start -->
                        <div class="form-group row">
                           <div class="col-md-12 col-sm-12 col-xs-12">
                                <div id="accordion" class="accordion-container ">
                                @if($listTreatmentHistory)
                                    @foreach($listTreatmentHistory as $treatmentHistory)
                                        <article class="content-entry">
                                            <div class="article-title">
                                                <div class="row">
                                                    <h4 class="panel-title">
                                                        <div class="container">
                                                            <h4>
                                                                <i style="position: relative; top: 5px;left: 5px;"></i>{{$treatmentHistory->treatment->name}}
                                                            </h4>
                                                        </div>
                                                        <div class="container">
                                                            <div class="col-sm-4">Giá gốc
                                                                : {{$treatmentHistory->price}} VNĐ
                                                            </div>
                                                            <div class="col-sm-4">Khuyến mãi : {{$treatmentHistory->percentDiscount}}%</div>
                                                            <div class="col-sm-4">Tổng tiền
                                                                : {{$treatmentHistory->total_price}} VNĐ
                                                            </div>
                                                            <div class="col-sm-4">Răng
                                                                : {{$treatmentHistory->tooth->tooth_name}}</div>
                                                            <div class="col-sm-4">Ngày bắt đầu
                                                                : {{$treatmentHistory->created_date}}</div>
                                                            <div class="col-sm-4">
                                                                @if($treatmentHistory->finish_date)
                                                                    Ngày kết thúc :  {{$treatmentHistory->finish_date}}
                                                                @else
                                                                    <a href="{{ route("admin.stepTreatment", ['idTreatmentHistory' => $treatmentHistory->id,
                        'idTreatment' => $treatmentHistory->treatment->id])}}" class="btn btn-success" role="button">Tiếp tục</a>
                                                                @endif</div>
                                                        </div>
                                                    </h4>
                                                </div>
                                            </div>
                                            <div class="accordion-content">
                                                @foreach($treatmentHistory->details as $a)
                                                    @if($a)
                                                        <div class="row">
                                                            <div class="col-sm-2">BÁC SĨ :</div>
                                                            <div class="col-sm-8">{{$a->dentist->name}} </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-sm-2">Ngày điều trị</div>
                                                            <div class="col-sm-8">{{$a->create_date}} </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-sm-2">Các bước đã thực hiện:</div>
                                                            <div class="col-sm-8">
                                                                @foreach($a->treatment_detail_steps as $step)
                                                                    <div class="row">
                                                                        <div class="col-sm-8">{{$step->step->name}} </div>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-sm-2">Toa thuốc</div>
                                                            <div class="col-sm-9">
                                                                <table class="table table-striped Mytable-hover">
                                                                    <tr>
                                                                        <th>Tên thuốc</th>
                                                                        <th>Số lượng</th>
                                                                    </tr>
                                                                    <tbody>
                                                                    @foreach($a->prescriptions as $prescription)
                                                                        <tr>
                                                                            <td>{{$prescription->medicine->name}}</td>
                                                                            <td>{{$prescription->quantity}} viên</td>
                                                                        </tr>
                                                                    @endforeach
                                                                    </tbody>
                                                                </table>

                                                            </div>
                                                        </div>
                                                        <div class="row" style="margin-top: 10px;">
                                                            @foreach($a->treatment_images as $b)
                                                                <div class="col-sm-4">
                                                                    <img src="{{$b->image_link}}" alt=""
                                                                         class="img-responsive img-fluid">
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                        <hr>
                                                    @else
                                                        <div class="row">
                                                            <div class="col-sm-2">BÁC SĨ :</div>
                                                            <div class="col-sm-8">NULL nhé</div>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </article>
                                    @endforeach
                              
                                @endif
                            </div>
                           </div>
                            
                            <!--/#accordion-->


                        </div>
                    </div>
            </div>
        </div>
        @endif
    </div>
 
       

 

     
@if($patient != null)
<div id="create" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg" >
                <div class="modal-content centerThing" style="text-align: center;">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">x</button>
                        <h4 class="modal-title"></h4>
                    </div>
                    <div class="modal-body">
                        <form method="post" class="form-horizontal" action="create-patient"
                              enctype="multipart/form-data" id="createAppoint">
                            {{ csrf_field() }}
                            <div class="form-group row add">
                                <label class="control-label col-xs-2" for="title">Họ & Tên </label>
                                <div class="col-xs-10">
                                    <input type="text" class="form-control" id="namePatient" name="namePatient"
                                           placeholder="Họ và tên bệnh nhân" required>
                                    <p class="error text-center alert alert-danger hidden"></p>
                                </div>
                            </div>
                            <div class="form-group row add">
                                <label class="control-label col-xs-2" for="title">Địa chỉ </label>
                                <div class="col-xs-10">
                                    <input type="text" class="form-control" id="addressPatient" name="addressPatient"
                                           placeholder="Địa chỉ cư trú" required>
                                    <p class="error text-center alert alert-danger hidden"></p>
                                </div>
                            </div>
                            <div class="form-group row add">
                                <label class="control-label col-xs-2" for="title">Thành Phố </label>
                                <div class="col-xs-3">
                                    <select name="cityPatient" id="cityPatient" style="height: 30px;"
                                            onchange="disctrict(this)">
                                        @foreach($citys as $city)
                                            <option value="{{$city->id}}">{{$city->name}}</option>

                                        @endforeach
                                    </select>
                                </div>
                                <label class="control-label col-xs-1" for="title">Quận </label>
                                <div class="col-xs-3">
                                    <select name="districtsPatient" id="districtsPatient" style="height: 30px;">
                                        @foreach($District as $one)
                                            <option value="{{$one->id}}">{{$one->name}}</option>

                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row add">
                                <label class="control-label col-xs-2" for="title">Số Di động </label>
                                <div class="col-xs-10">
                                    <input type="text" class="form-control" id="phonePatient" name="phonePatient"
                                           placeholder="Số điện thoại di động" value="{{$appointment->phone}}" disabled required>
                                    <input type="hidden" value="{{$appointment->phone}}" id="PhoneAppoint">
                                    <p class="error text-center alert alert-danger hidden"></p>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-xs-2" for="title">Năm sinh </label>
                                <div class="col-xs-10">
                                   <div class="col-sm-3 inputWithIcon" style="padding-right: 0;padding-left: 0;">
                          <input type="text" placeholder="Ngày sinh" name="start_dateX" class="form-control pull-right" id="start_dateX" style="margin:0px;" />
                          <i class="fa fa-calendar"></i>
                          </div>
                                  
                                </div>
                            </div>
                            <div class="form-group row add">
                                <label class="control-label col-xs-2" for="title">Giới tính </label>
                                <div class="col-xs-10">
                                    <select name="genderPatient" id="genderPatient"
                                            style="height: 30px;width: 5em;float: left;">
                                        <option value="Male">Nam</option>
                                        <option value="FeMale">Nữ</option>
                                        <option value="Unknow">Khác</option>
                                    </select>
                                </div>
                            </div>
                           
                            <hr>
                            <div class="form-group row add">
                                <label class="control-label col-xs-2" for="title">Bệnh tiền sử </label>
                                <div class=" row col-xs-10"
                                     style=" float: left;border: 2px gray solid;border-radius: 20px;">
                                    <div class=" ">
                                        @foreach($AnamnesisCatalog as $one)

                                            <div class="col-xs-3" style="text-align: left;">
                                                <input type="checkbox" class="anam" name="anam[]" value="{{$one->id}}" id="myCheck" onclick="myFunction()">
                                                {{$one->name}}
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                            </div>

                        </form>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-info" type="button" id="addPatientExist">
                           Tạo bệnh nhân
                        </button>
                        <button class="btn btn-info" type="button" data-dismiss="modal">
                            <span class="glyphicon glyphicon-remobe"></span>Đóng
                        </button>
                    </div>
                </div>
            </div>
        </div>
@else
<div id="create" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg" >
                <div class="modal-content centerThing" style="text-align: center;">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">x</button>
                        <h4 class="modal-title"></h4>
                    </div>
                    <div class="modal-body">
                        <form method="post" class="form-horizontal" action="create-patient"
                              enctype="multipart/form-data" id="createAppoint">
                            {{ csrf_field() }}
                            <div class="form-group row add">
                                <label class="control-label col-xs-2" for="title">Họ & Tên </label>
                                <div class="col-xs-10">
                                    <input type="text" class="form-control" id="namePatient" name="namePatient"
                                           placeholder="Họ và tên bệnh nhân" required>
                                    <p class="error text-center alert alert-danger hidden"></p>
                                </div>
                            </div>
                            <div class="form-group row add">
                                <label class="control-label col-xs-2" for="title">Địa chỉ </label>
                                <div class="col-xs-10">
                                    <input type="text" class="form-control" id="addressPatient" name="addressPatient"
                                           placeholder="Địa chỉ cư trú" required>
                                    <p class="error text-center alert alert-danger hidden"></p>
                                </div>
                            </div>
                            <div class="form-group row add">
                                <label class="control-label col-xs-2" for="title">Thành Phố </label>
                                <div class="col-xs-3">
                                    <select name="cityPatient" id="cityPatient" style="height: 30px;"
                                            onchange="disctrict(this)">
                                        @foreach($citys as $city)
                                            <option value="{{$city->id}}">{{$city->name}}</option>

                                        @endforeach
                                    </select>
                                </div>
                                <label class="control-label col-xs-1" for="title">Quận </label>
                                <div class="col-xs-3">
                                    <select name="districtsPatient" id="districtsPatient" style="height: 30px;">
                                        @foreach($District as $one)
                                            <option value="{{$one->id}}">{{$one->name}}</option>

                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row add">
                                <label class="control-label col-xs-2" for="title">Số Di động </label>
                                <div class="col-xs-10">
                                    <input type="text" class="form-control" id="phonePatient" name="phonePatient"
                                           placeholder="Số điện thoại di động" value="{{$appointment->phone}}" disabled required>
                                    <input type="hidden" value="{{$appointment->phone}}" id="PhoneAppoint">
                                    <p class="error text-center alert alert-danger hidden"></p>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-xs-2" for="title">Năm sinh </label>
                                <div class="col-xs-10">
                                   <div class="col-sm-3 inputWithIcon" style="padding-right: 0;padding-left: 0;">
                          <input type="text" placeholder="Ngày sinh" name="start_dateX" class="form-control pull-right" id="start_dateX" style="margin:0px;" />
                          <i class="fa fa-calendar"></i>
                          </div>
                                  
                                </div>
                            </div>
                            <div class="form-group row add">
                                <label class="control-label col-xs-2" for="title">Giới tính </label>
                                <div class="col-xs-10">
                                    <select name="genderPatient" id="genderPatient"
                                            style="height: 30px;width: 5em;float: left;">
                                        <option value="Male">Nam</option>
                                        <option value="FeMale">Nữ</option>
                                        <option value="Unknow">Khác</option>
                                    </select>
                                </div>
                            </div>
                           
                            <hr>
                            <div class="form-group row add">
                                <label class="control-label col-xs-2" for="title">Bệnh tiền sử </label>
                                <div class=" row col-xs-10"
                                     style=" float: left;border: 2px gray solid;border-radius: 20px;">
                                    <div class=" ">
                                        @foreach($AnamnesisCatalog as $one)

                                            <div class="col-xs-3" style="text-align: left;">
                                                <input type="checkbox" class="anam" name="anam[]" value="{{$one->id}}" id="myCheck" onclick="myFunction()">
                                                {{$one->name}}
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                            </div>

                        </form>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-info" type="button" id="addPatient">
                           Tạo bệnh nhân
                        </button>
                    
                        <button class="btn btn-info" type="button" data-dismiss="modal">
                            <span class="glyphicon glyphicon-remobe"></span>Đóng
                        </button>
                    </div>
                </div>
            </div>
        </div>
@endif
<!-- nhan benh -->
<div id="create2" class="modal fade" role="dialog" >
    <div class="modal-dialog md-sm" >
        <div class="modal-content" >
            <div class="modal-header"">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <div class="centerThing"><h2 style="text-align: center;" >Cập nhật lịch hẹn bệnh nhân</h2></div>
            </div>
            <div class="modal-body" style="background: url(/assets/images/layoutRegister.jpg);">
                 <form method ="post" class="form-horizontal" action="create-appointment-user" enctype="multipart/form-data" id="AppointmentGuestX">
                 {{ csrf_field() }}

                    <div class="form-group row add">
                      <div class="form-group">
                                <label class="control-label col-xs-3" for="title">Số điện thoại</label>
                                <div class="col-xs-8" style="padding-right: 0px;">
                                   <div class="col-sm-12 inputWithIcon" style="padding-right: 0;padding-left: 0;">
                          <input type="text" placeholder="Ngày sinh" name="start_dateX" class="form-control pull-right" id="start_dateX" style="margin:0px;" value="{{$appointment->phone}}"  disabled />
                          <i class="fa fa-phone"></i>
                          </div>
                                  
                                </div>
                            </div>
                      <div class="form-group">
                                <label class="control-label col-xs-3" for="title">Bệnh nhân khám </label>
                                <div class="col-xs-8" style="padding-right: 0px;">
                                    <div class="col-sm-12 col-xs-12 inputWithIcon" style="padding-right: 0;padding-left: 0;">
                                        <div class="col-sm-8 col-xs-12" style="padding-right: 0;padding-left: 0;">
                                            <select name="PatientSelected" id="PatientSelected" style="height: 30px;width: 100%">
                                                @foreach($listPatient as $one)
                                                    <option value="{{$one->id}}">{{$one->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-sm-3 col-xs-12" style="padding-right: 0;padding-left: 0;">
                                                 <a class="btn btn-info btn-sm" href="#create" data-toggle="modal" data-dismiss="modal">Tạo mới bệnh nhân </a>
                                        </div>
                                    </div>
                                  
                                </div>
                            </div>
                    <div class="col-sm-12" style="padding-top: 2em;">
                     <button class="btn btn-info" type="button" style=" width: 100%;" id="add" onclick="save(this)" >
                        Cập nhật
                     </button>
                 </div>

             </div>
         </form>
     </div>

 </div>
</div>
</div>
<div id="doc" class="modal fade" role="dialog" >
    <div class="modal-dialog modal-lg" >
        <div class="modal-content" >
            <div class="modal-header"">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <div class="centerThing"><h2 style="text-align: center;" >Bác Sĩ</h2></div>
            </div>
            <div class="modal-body" >
                 <form method ="post" class="form-horizontal" action="create-appointment-user" enctype="multipart/form-data" id="AppointmentGuestX">
                 {{ csrf_field() }}

                    <div class="form-group row add">
                       <div class="col-sm-12" style="padding-top: 2em;">
                        <table class="table table-striped table-bordered Mytable-hover" style="text-align: center;">
                            <thead>
                            <tr>
                                <th style="text-align: center; " class="col-lg-2 col-md-2 col-sm-2 col-xs-2 ">Bác Sĩ</th>
                                <th style="text-align: center; " class="col-lg-1 col-md-1 col-sm-1 col-xs-1 ">Trạng thái</th>
                                 <th style="text-align: center; " class="col-lg-1 col-md-1 col-sm-1 col-xs-1 ">Tùy chọn</th>
                                 
                            </tr>
                            </thead>
                            <tbody id="docTwo">
                        
                            </tbody>
                        </table>
                        </div>
                    <div class="col-sm-12" style="padding-top: 2em;">
                    
                 </div>

             </div>
         </form>
     </div>

 </div>
</div>
</div>
@endsection
@section('js')
    <script src="https://datatables.yajrabox.com/js/datatables.bootstrap.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <link rel="stylesheet" href="/assets/user/css/mycss.css">
    <script>
        $(document).on('click','.th2', function() {
            $('#create').modal('show');
            $('.form-horizontal').show();
            $('.modal-title').text('Khởi tạo bệnh nhân');
});
         $(document).on('click','.applyChangePatient', function() {
            var select = document.getElementById('PatientSelected');
             $.ajax({
                    url: '/admin/get-free-dentist-status',  
                    type: 'GET',
                    dataType: 'json',
                   success: function (data) {
                    $('tbody').html(data.table_data);
                 
                        $('#total_records').text(data.total_data);
                    }, error: function (data) {
                    },
                });
            $('#doc').modal('show');
            $('.form-horizontal').show();
            $('.modal-title').text('Bác Sĩ');
});
       $(document).on('click','.applyApp', function() {
        var case3 = '{{$case3}}';
        if(case3 == 1){
                       $.ajax({
                    url: '/admin/apply-appointment-change-status',  
                    type: 'GET',
                    data: {
                        'appID': '{{$appointment->id}}',
                    },  
                    success: function (data) {
                        if ((data.errors)) {
                            alert(data.errors.body);
                        } else {
                             location.reload(true);
                            swal("Nhận bệnh thành công", "", "success");
                        }
                    },
                });
            return;
        }else{
            var patientExist = '{{$patient}}';

        if($.trim(patientExist) == ''){//no patient
            $('#create').modal('show');
            $('.form-horizontal').show();
            $('.modal-title').text('Khởi tạo bệnh nhân');
        }else{//have patient
            $('#create2').modal('show');
            $('.form-horizontal').show();
            $('.modal-title').text('');
        }
        }                   
       

 
    // 
});
        $(document).ready(function () {
            <?php if (Session::has('success')): ?>
            swal("Sự kiện đa được tạo!", "", "error");
            <?php endif ?>
            $("div.toolbar").html('<b>Custom tool bar! Text/images etc.</b>');

            function xxx(evt, sel) {
                var check = document.getElementById('thumbnail').value;
                if (check.length != 0) {
                    swal("Hết nulll nhaaa!", "", "error");
                }
            }

            $("#start_dateX").datepicker({
            // startDate: 'd',
             changeYear: true,
    changeMonth: true,
            showMonthAfterYear: true,
            autoclose: true,
            });
        });

        function checkComing(id) {
            $.ajax({
                url: '/admin/check-coming/' + id, //this is your uri
                type: 'GET', //this is your method

                dataType: 'json',
                success: function (data) {
                    if (data.statusComing == 0) {
                        swal("Bệnh nhân chưa đến hoặc đã khám xong", "", "error");
                    }
                    if (data.statusComing == 1) {
                        window.location.replace('http://' + data.url + "/admin/create-treatment/" + data.idPatient);
                    }
                }, error: function (data) {
                    swal("Check connnection", "", "error");
                }
            });
        }

        $(function () {
            $('#dup-table').DataTable({
                "dom": '<"toolbar">frtip',
                language: {
                    "lengthMenu": "Tổng kết quả Hiển thị _MENU_ ",
                    "zeroRecords": "Không tìm thấy kết quả ",
                    "info": "Hiển thị trang _PAGE_ trong tổng _PAGES_ trang",
                    "infoEmpty": "Không có kết quả .",
                    "infoFiltered": "(filtered from _MAX_ total records)",
                    "search": "Tìm kiếm ",
                    "infoFiltered": "(Đã tìm từ _MAX_ kết quả)",

                },
                processing: true,
                serverSide: true,
                order: [[0, "desc"]],
                bLengthChange: true,
                pageLength: 5,
                ajax: '/admin/get-list-anamnesis',
                columns: [

                    {data: 'id'},
                    {data: 'name'},
                    {

                        data: 'action'
                    },
                ],
            });
        });
        function save(){
                var guestName = $('#PatientSelected').val();
           
             $.ajax({
                url: '/admin/apply-appointment-exist',  
                type: 'GET',
                data: {
                    
                    'patientID': guestName,
                    'appID': '{{$appointment->id}}',
                },  
                success: function (data) {
                    if ((data.errors)) {
                         swal("Nhận bệnh không thành công", "", "error");
                    } else {
                         location.reload(true);
                        swal("Nhận bệnh thành công", "", "success");
                    }
                },
            });
        }
        function validateQuestionBeforeCreate(evt, sel) {
            // swal("Bài viết chưa được tạo!", "", "error");

            var name = document.getElementById('name').value;
            var discount = document.getElementById('discount').value;

            if ($.trim(name) == '') {
                swal("Vui lòng điền tên sự kiện!", "", "error");
            } else if ($.trim(discount) == '') {
                swal("Vui lòng điền mức giảm giá!", "", "error");

            }
            else {
                document.getElementById('createNews').submit();
            }
        }

        $(function () {
            var Accordion = function (el, multiple) {
                this.el = el || {};
                this.multiple = multiple || false;

                var links = this.el.find('.article-title');
                links.on('click', {
                    el: this.el,
                    multiple: this.multiple
                }, this.dropdown)
            }

            Accordion.prototype.dropdown = function (e) {
                var $el = e.data.el;
                $this = $(this),
                    $next = $this.next();

                $next.slideToggle();
                $this.parent().toggleClass('open');

                if (!e.data.multiple) {
                    $el.find('.accordion-content').not($next).slideUp().parent().removeClass('open');
                }
                ;
            }
            var accordion = new Accordion($('.accordion-container'), false);
        });
        $("#addPatientExist").click(function () {
         
            var data=[];
             $('.anam:checked').each(function(){
                data.push($(this).val());
             })
            var nameCreate = document.getElementById("namePatient").value;
            var addressCreate = document.getElementById("addressPatient").value;
            var phoneCreate = document.getElementById("phonePatient").value;
            var birthdateCreate = document.getElementById("start_dateX").value;
            var genderCreate = document.getElementById("genderPatient").value;
            var districtCreate = document.getElementById("districtsPatient").value;
            var appID ='{{$appointment->id}}';
            if ($.trim(nameCreate) == '') {
                swal("Vui lòng điền họ tên bệnh nhân!", "", "error");
                return;
            } else if ($.trim(addressCreate) == '') {
                swal("Vui lòng điền địa chỉ bệnh nhân  !", "", "error");
                return;
            }else if ($.trim(birthdateCreate) == '') {
                swal("Vui lòng điền ngày sinh!", "", "error");
                return;
            }else{
              $.ajax({
                type: 'GET',
                url: '/admin/apply-appointment',
                data: {
                    "_token": "{{ csrf_token() }}",
                    'name': nameCreate,
                    'address': addressCreate,
                    'phone': phoneCreate,
                    'date_of_birth': birthdateCreate,
                    'gender': genderCreate,
                    'district_id': districtCreate,
                    'anam' : data,
                    'appId':appID,

                },
                success: function (data) {
                    if ((data.errors)) {
                        alert(data.errors.body);
                    } else {
                        location.reload(true);
                        swal("Khởi tạo bệnh nhân thành công", "", "success");
                    }
                },
            });   
            }
           
        });
        $("#addPatient").click(function () {
         
            var data=[];
             $('.anam:checked').each(function(){
                data.push($(this).val());
             })
            var nameCreate = document.getElementById("namePatient").value;
            var addressCreate = document.getElementById("addressPatient").value;
            var phoneCreate = document.getElementById("phonePatient").value;
            var birthdateCreate = document.getElementById("start_dateX").value;
            var genderCreate = document.getElementById("genderPatient").value;
            var districtCreate = document.getElementById("districtsPatient").value;
            var appID ='{{$appointment->id}}';
            if ($.trim(nameCreate) == '') {
                swal("Vui lòng điền họ tên bệnh nhân!", "", "error");
                return;
            } else if ($.trim(addressCreate) == '') {
                swal("Vui lòng điền địa chỉ bệnh nhân  !", "", "error");
                return;
            }else if ($.trim(birthdateCreate) == '') {
                swal("Vui lòng điền ngày sinh!", "", "error");
                return;
            }else{
              $.ajax({
                type: 'GET',
                url: '/admin/apply-appointment',
                data: {
                    "_token": "{{ csrf_token() }}",
                    'name': nameCreate,
                    'address': addressCreate,
                    'phone': phoneCreate,
                    'date_of_birth': birthdateCreate,
                    'gender': genderCreate,
                    'district_id': districtCreate,
                    'anam' : data,
                    'appId':appID,

                },
                success: function (data) {
                    if ((data.errors)) {
                        alert(data.errors.body);
                    } else {
                        location.reload(true);
                        swal("Khởi tạo bệnh nhân thành công", "", "success");
                    }
                },
            });   
            }
           
        });
        function savePatient(id){
           
            $.ajax({
                type: 'GET',
                url: '/admin/change-dentist-free',
                data: {
                    "_token": "{{ csrf_token() }}",
                    'docID':id,
                    'appointmentID':'{{$appointment->id}}',

                },
                success: function (data) {
                    if (data==0) {
                         swal("Thay đổi không thành công", "", "error");
                    } else {
                        window.location.reload();
                    }
                },
            });   
        }

    </script>
@endsection
