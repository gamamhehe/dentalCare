@extends('admin.master')
@section('title', 'Khởi tạo lịch hẹn')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
   <div class="box">
            <div class="panel panel-default" style="">
                <div class="panel-heading">
                          <div class="row" style="text-align: center;">
                            <label><h1>Khởi tạo lịch hẹn</h1></label>
                        </div>
                </div>
            <div class="panel-body">
                <form method ="post" class="form-horizontal" action="create-treatment" enctype="multipart/form-data" id="createNews">
                {{ csrf_field() }}
                <div class="modal-body">
                        <form method="post" class="form-horizontal" action="create-appointment"
                              enctype="multipart/form-data" id="createAppoint">
                            {{ csrf_field() }}
                            <div class="form-group row add">
                             <div class="control-label col-md-4 col-sm-4 col-xs-12"><label>Số điện thoại </label></div>
                                <div class="col-md-6 col-sm-6 col-xs-8" style="padding-right: 0;padding-left: 0;">
                                    <input type="text" class="form-control" id="phoneXXX" name="phoneXXX"
                                           required="required" placeholder="Số điện thoại" style="margin:0px;">
                                    <p class="error text-center alert alert-danger hidden"></p>
                                </div>
                                <div class="col-sm-2 col-xs-2" style="">
                                    <button class="btn btn-success" type="button" onclick="checkValid()">Kiểm tra</button>
                                </div>
                            </div>
                            <div class="form-group add row">
                                <label class="control-label col-md-4 col-sm-4 col-xs-12" for="title">Danh sách bệnh nhân</label>
                                <div class="col-md-6 col-sm-6 col-xs-12" style="padding-right: 0;padding-left: 0;">
                                    <select style="margin:0px;width: 100%"
                                            id="PatientSelect" class="selectSpecialTwo col-sm-6 col-xs-7">

                                    </select>
                                </div>
                            </div>
                             @if(Session::get('roleAdmin') == 3 or Session::get('roleAdmin') == 1)
                            <div class="form-group add row">
                                <label class="control-label col-md-4 col-sm-4 col-xs-12" for="title">Danh sách bác sĩ</label>
                                <div class="col-md-6 col-sm-6 col-xs-12" style="padding-right: 0;padding-left: 0;">
                                    <select style="margin:0px;width: 100%"
                                            id="DentistSelect" class="selectSpecialTwo col-sm-6 col-xs-7">
                                            <option value="0" selected>Mặc định</option>
                                        @foreach($dentists as $dentist)
                                            <option value="{{$dentist->id}}">{{$dentist->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @else
                            <input type="hidden" id="DentistSelect" value="0">
                            @endif
                            <div class="form-group add row">
                               
                                <div class="control-label col-sm-4 col-xs-7" for="body"><label>Ngày đặt </label></div>
                          <div class="col-sm-6 col-xs-5 inputWithIcon" style="padding-right: 0;padding-left: 0;">
                              <input type="text" placeholder="Ngày hẹn" id="datepicker" class="form-control pull-right" id="startdate" style="margin:0px;" />
                              <i class="fa fa-calendar"></i>
                          </div>
                            </div>
                            <div class="form-group add row">
                                <label class="control-label col-sm-4  col-xs-7 " for="body">Thời gian dự kiến </label>
                                <div class="col-sm-6 col-xs-5" style="padding-right: 0;padding-left: 0;">
                                 <input type="number" placeholder="Thời lượng" id="estimateTime" name="estimateTime "  class="form-control pull-right" max="90" min="10
                                 .0
                                 "  style="margin:0px;" />
                                </div>
                            </div>
                            <div class="form-group add row" style="text-align: center;">
                                <button class="btn btn-info centerThing" type="button" id="add">
                                   Khởi tạo
                                </button>
                            </div>
                        </form>
                    </div>

                </form>
            </div>
            </div>
    </div>
            

           
</div>




 
@endsection
@section('js')
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
    $(document).ready(function() {
        <?php if (Session::has('success')): ?>
        swal("{{ Session::get('success')}}", "", "success");
        <?php endif ?>

        
    });
 
        function checkValid() {

            var xxx = document.getElementById('phoneXXX').value;
            $('#phoneXXX').prop('onchange', true);
            $.ajax({
                url: '/admin/get-list-patient/' + xxx, //this is your uri
                type: 'GET', //this is your method

                dataType: 'json',
                success: function (data) {
                    $('#PatientSelect')
                        .find('option')
                        .remove()
                        .end()

                    ;
                    if (data.length == 0) {
                        swal("Số điện thoại không tồn tại", "", "error");
                    } else {
                        swal("Số điện thoại hợp lệ.Hãy chọn bệnh nhân", "", "success");
                        for (var i = 0; i < data.length; i++) {
                            $('#PatientSelect').append("<option value=" + data[i].id + ">" + data[i].name + "</option>");
                        }
                    }
                }, error: function (data) {
                    swal("Vui lòng điền số điện thoại", "", "error");
                }
            });
        }
        $(function () {
            $('#datepicker').datepicker({
                startDate: 'd',
                autoclose: true,
            });
        });
                $("#add").click(function () {

            var phone = document.getElementById("phoneXXX").value;
            var estimateTimeReal = document.getElementById("estimateTime").value;
            var patientID = document.getElementById("PatientSelect").value;
            var datepicker = document.getElementById("datepicker").value;

             var dentistID = document.getElementById("DentistSelect").value;
             if(dentistID==null){
                alert("xxx");return;
             }
            if ($.trim(phone) == '') {
                swal("Vui lòng điền số điện thoại!", "Hãy bấm Kiểm tra để xác nhận số điện thoại", "error");
                return;
            }else if ($.trim(patientID) == '') {
                swal("Vui lòng chọn bệnh nhân  !", "Bấm kiểm tra để có danh sách bệnh nhân", "error");
                return;
            }else if ($.trim(datepicker) == '') {
                swal("Vui lòng chọn ngày đặt cho lịch hẹn  !", "", "error");
                return;
            }else{
                 $.ajax({
                type: 'POST',
                url: '/admin/create-appointment',
                data: {
                    "_token": "{{ csrf_token() }}",
                    'phone': phone,
                    'dentistID':dentistID,
                    'estimateTimeReal': estimateTimeReal,
                    'patientID': patientID,
                    'datepicker': datepicker,
                },
                success: function (data) {
                    if (data!= 0) {

                        swal("Đặt lịch thành công", "", "success");
                    } else {
                        swal("Đặt lịch không thành công", "Vui lòng xem lại thời gian đặt", "error");
                    }
                },
            });
            }
           
        });

</script>
@endsection
  