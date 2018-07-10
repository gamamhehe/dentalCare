@extends('admin.master')
@section('content')
    <div class="content-wrapper" >
        <div class="box">
            
            <div class="panel panel-default" style="">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-sm-5" style="text-align: left">Tìm bệnh nhân  </div>
                        <div class="col-sm-7" style="text-align: right">
                            <button class="btn btn-success create-patient" id="Patient" >Tạo bệnh nhân</button>
                             <button class="btn btn-success create-modal" id="Appoint" >Tạo lịch hẹn</button>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <input type="text" name="search" id="search" class="form-control" placeholder="Số điên thoại bệnh nhân" value="{{old('search')}}" />
                        <div class="row" style="margin-bottom: 1em;" >
                            <div class=""  style="margin-top: 1em;">
                                <button type="button" class="col-md-3 btn btn-default btn-success" style="margin-right: 10px;float: right;"  onclick="search()" >Tìm</button>
                            </div>
                        </div>

                    </div>
                  
 
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered" style="text-align: center">
                            <thead>
                            <tr>
                                <th style="text-align: center; width: 30%">Họ Tên</th>
                                <th style="text-align: center; width: 30%">Địa Chỉ</th>
                                <th style="text-align: center; width: 20%">Ngày Sinh</th>
                                <th style="text-align: center; width: 20%">Tùy chọn</th>

                            </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- tao lich hen -->
          <div id="create" class="modal fade" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title"></h4>
                            </div>
                            <div class="modal-body">
                                <form method ="post" class="form-horizontal" action="create-Appointment" enctype="multipart/form-data" id="createAppoint">
                                        {{ csrf_field() }}
                                    <div class="form-group row add">
                                        <label class="control-label col-xs-4" for="title">Số điện thoại:</label>
                                        <div class="col-xs-6">
                                            <input type="text" class="form-control" id="phoneXXX" name="phoneXXX"
                                                   placeholder="Your name Here" required="required">
                                            <p class="error text-center alert alert-danger hidden"></p>
                                        </div>
                                        <div class="col-xs-2" style="padding-left:0px;">
                                            <button class="btn btn-success" type="button" onclick="checkValid()">Check</button>
                                        </div>
                                    </div>
                                        <div class="form-group row add">
                                        <label class="control-label col-xs-4" for="title">Danh sách bệnh nhân:</label>
                                        <div class="col-xs-8">
                                            <select name="treatment_id" style="height: 2em;min-width: 25em;"
                                             id="PatientSelect">
                             
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-xs-4" for="title">Ngày đặt:</label>
                                            <div class="input-group date col-xs-5 " style="    padding-left: 15px">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </div>
                                                <input type="text" placeholder="yyyy-mm-dd" class="form-control pull-right"
                                                       id="datepicker"/>
                                            </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-xs-4" for="body">Estimate time:</label>
                                        <div class="col-xs-8">
                                   <select class="hour" name="estimateTime" id="estimateTime" style="width: auto;">
                                    @for ($i = 0; $i < 10; $i++)
                                          <option value="{{$i}}">{{$i}}</option>
                                    @endfor
                                                                
                                   </select>&nbsp                               
                                    
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-warning" type="button" id="add" >
                                    <span class="glyphicon glyphicon-plus"></span>Save Post
                                </button>
                                <button class="btn btn-warning" type="button" data-dismiss="modal">
                                    <span class="glyphicon glyphicon-remobe"></span>Close
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
        <!-- tao nguoi benh -->
         <div id="createPatient" class="modal fade" role="dialog">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content" style="width: 900px;text-align: center;">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title"></h4>
                            </div>
                            <div class="modal-body" >
                                <form method ="post" class="form-horizontal" action="create-Patient" enctype="multipart/form-data" id="createAppoint">
                                        {{ csrf_field() }}
                                    <div class="form-group row add">
                                        <label class="control-label col-xs-2" for="title">Họ & Tên :</label>
                                        <div class="col-xs-10">
                                            <input type="text" class="form-control" id="namePatient" name="namePatient"
                                                   placeholder="Họ và tên bệnh nhân" required>
                                            <p class="error text-center alert alert-danger hidden"></p>
                                        </div>
                                    </div>
                                     <div class="form-group row add">
                                        <label class="control-label col-xs-2" for="title">Địa chỉ :</label>
                                        <div class="col-xs-10">
                                            <input type="text" class="form-control" id="addressPatient" name="addressPatient"
                                                   placeholder="Địa chỉ cư trú" required>
                                            <p class="error text-center alert alert-danger hidden"></p>
                                        </div>
                                    </div>
                                     <div class="form-group row add">
                                        <label class="control-label col-xs-2" for="title">Số Di động :</label>
                                        <div class="col-xs-10">
                                            <input type="text" class="form-control" id="phonePatient" name="phonePatient"
                                                   placeholder="Số điện thoại di động" required>
                                            <p class="error text-center alert alert-danger hidden"></p>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-xs-2" for="title">Năm sinh</label>
                                        <div class="col-xs-10">
                                            <div class="input-group date">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>  <input type="date" id="bdayxx" name="bday" required="required">
                                                </div>
                                              
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row add">
                                        <label class="control-label col-xs-2" for="title">Giới tính :</label>
                                        <div class="col-xs-10">
                                            <select name="genderPatient" id="genderPatient">
                                                <option value="Male">Nam</option>
                                                <option value="FeMale">Nữ</option>
                                                <option value="Unknow">Khác</option>
                                            </select>
                                        </div>
                                    </div>
                                      <div class="form-group row add">
                                        <label class="control-label col-xs-3" for="title">Quận ajax nè :</label>
                                        <div class="col-xs-3">
                                            <select name="districtsPatient" id="districtsPatient">
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                            </select>
                                        </div>
                                    </div>
                                  
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-warning" type="button" id="addPatient" >
                                    <span class="glyphicon glyphicon-plus"></span>Tạo bệnh nhân
                                </button>
                                <button class="btn btn-warning" type="button" data-dismiss="modal">
                                    <span class="glyphicon glyphicon-remobe"></span>Close
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
        <!-- end tao nguoi benh -->

    </div>

<!-- </body>
</html> -->
@endsection
@section('js')
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
 $(function () {
      $('#datepicker').datepicker({
      autoclose: true
    });
  });
    var x = 0;
    // function changePhone(){
    //     x = x +1;
    //     if( x>1){
    //         alert(x);
    //     }
    // }
    $(document).ready(function(){
        $('#sandbox-container input').datepicker({
    startDate: "07/02/2018"
});
        <?php if (Session::has('success')): ?>
        swal("Nhận bệnh nhân thành công", "", "success");
        <?php endif ?>

        <?php if ($errors->first('notHaveAppointment')): ?>
        swal("Không có lịch hẹn cho bệnh nhân này", "", "error");
        <?php endif ?>
        <?php if ($errors->first('dentistBusy')): ?>
        swal("Bác sĩ đang bận", "", "error");
        <?php endif ?>
    });
     $(document).on('click','.create-modal', function() {
        $('#create').modal('show');
        $('.form-horizontal').show();
        $('.modal-title').text('Khởi tạo lịch hẹn');
    });
     $(document).on('click','.create-patient', function() {
        $('#createPatient').modal('show');
        $('.form-horizontal').show();
        $('.modal-title').text('Khởi tạo thông tin người bệnh');
    });

    $("#add").click(function() {
        
        var phone = document.getElementById("phoneXXX").value;
        var estimateTimeReal = document.getElementById("estimateTime").value;
        var patientID = document.getElementById("PatientSelect").value;
        var datepicker = document.getElementById("datepicker").value;
        $.ajax({
          type: 'POST',
          url: '/admin/create-Appointment',
          data:{
             "_token": "{{ csrf_token() }}",
            'phone': phone,
            'estimateTimeReal':estimateTimeReal,
            'patientID':patientID,
            'datepicker':datepicker,
           
          },
          success: function(data){
            if ((data.errors)) {
             alert(data.errors.body);
            } else {
                  swal("Đặt lịch hẹn thành công", "", "success");
            }
          },
            });
    });

        $("#addPatient").click(function() {
        var nameCreate =document.getElementById("namePatient").value; 
        var addressCreate =document.getElementById("addressPatient").value; 
        var phoneCreate =document.getElementById("phonePatient").value; 
        var birthdateCreate = document.getElementById("bdayxx").value;
        var genderCreate = document.getElementById("genderPatient").value;
        var districtCreate = document.getElementById("districtsPatient").value;
        $.ajax({
          type: 'POST',
          url: '/admin/create-Patient',
           data:{
             "_token": "{{ csrf_token() }}",
            'name' : nameCreate,
            'address' : addressCreate,
            'phone': phoneCreate,
            'date_of_birth':birthdateCreate,
            'gender':genderCreate,
            'district_id':districtCreate,
           
          },
          success: function(data){
            if ((data.errors)) {
             alert(data.errors.body);
            } else {
             swal("Khởi tạo bệnh nhân thành công", "", "success");
            }
          },
            });
    });















    function search(){
        
        var user = document.getElementById('User');
        var patient = document.getElementById('Patient');
        var appoint = document.getElementById('Appoint');
        var searchValue = document.getElementById('search').value;
        if(!searchValue){
             swal("Nhập số điên thoại", "", "error");
             return;
        }
        $.ajax({
            url: '/admin/live_search/'+ searchValue, //this is your uri
            type: 'GET', //this is your method

            dataType: 'json',
            success: function(data){
                $('tbody').html(data.table_data);
                $('#Patient').prop('disabled', false)
                $('#Appoint').prop('disabled', false)
                if(data.total_data == -1){
                    swal("Hãy tạo tài khoản", "", "error");
                    $('#xxx').text(" ");
                    $('#Patient').prop('disabled', false)
                    $('#Appoint').prop('disabled', true)
                    
                    
                }
                if(data.total_data == 0){
                    swal("Chưa có hồ sơ bệnh nhân", "", "error");
                    $('#total_records').text(data.total_data);
                    $('#Appoint').prop('disabled', true)
                }
            },error: function (data) {
               swal('Error:',"", data);
            }
        });
    }
     
 

    function checkValid(){
       
        var xxx = document.getElementById('phoneXXX').value;
        $('#phoneXXX').prop('onchange', true);
         $.ajax({
            url: '/admin/getListPatient/'+ xxx, //this is your uri
            type: 'GET', //this is your method

            dataType: 'json',
            success: function(data){
                 $('#PatientSelect')
                    .find('option')
                    .remove()
                    .end()
                    
                ;
               if(data.length==0){
                  swal("Số điện thoại không tồn tại", "", "error");
               }else{
                swal("Số điện thoại hợp lệ.Hãy chọn bệnh nhân", "", "success");
                for (var i = 0; i < data.length; i++) {
                    $('#PatientSelect').append("<option value="+data[i].id+">"+data[i].name+"</option>");
                }
               }
            },error: function (data) {
                swal("Vui lòng điền số điện thoại", "", "error");
            }
        });
    }

    function receive(id){
        $.ajax({
            url: '/admin/list-Appointment/'+ id, //this is your uri
            type: 'GET', //this is your method

            dataType: 'json',
            success: function(data){
                if(data.statusOfReceive == 0){
                    swal("Bác sĩ đang bận", "", "error");
                }
                if(data.statusOfReceive == 1){
                    swal("Nhận bệnh nhân thành công", "", "success");
                }
                if(data.statusOfReceive == 2){
                    swal("Không có lịch hẹn cho bệnh nhân này", "", "error");
                }
            },error: function (data) {
                swal("Check connnection", "", "error");
            }
        });
    }
</script>
@endsection