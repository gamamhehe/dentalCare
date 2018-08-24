@extends('admin.master')
@section('title', 'Tìm kiếm bệnh nhân')
@section('content')
    <div class="content-wrapper">
        <div class="box">
            <div class="panel panel-default" style="">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" style="text-align: left"><h3>Tìm kiếm bệnh nhân</h3></div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" style="text-align: right" style="margin-top: 20px;">
                            @if(Session::get('roleAdmin') == 3 or Session::get('roleAdmin') == 1)
                                <button class="btn btn-success btn-lg create-patient" id="Patient" style="">Tạo bệnh nhân</button>
                            @endif
                            <button class="btn btn-success btn-lg create-modal" id="Appoint">Tạo lịch hẹn</button>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="form-group row">
                        <div class="col-md-12 col-xs-12"><input type="text" name="search" id="search" class="form-control"
                               placeholder="Số điên thoại bệnh nhân" style="margin:0px;"  value="{{old('search')}}"/></div>
                        
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered Mytable-hover" style="text-align: center;overflow-x:auto;">
                            <thead>
                            <tr>
                                <th style="text-align: center; " class="col-lg-2 col-md-2 col-sm-2 col-xs-2 ">Họ Tên</th>
                                <th style="text-align: center; " class="col-lg-1 col-md-1 col-sm-1 col-xs-1 ">Số điện thoại</th>
                                <th style="text-align: center; " class="col-lg-3 col-md-3 col-sm-3 col-xs-3 ">Địa Chỉ</th>
                                <th style="text-align: center; " class="col-lg-1 col-md-1 col-sm-1 col-xs-1 ">Ngày Sinh</th>
                                <th style="text-align: center; " class="col-lg-3 col-md-3 col-sm-3 col-xs-3 ">Tùy chọn</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if($patientList != null)
                                @foreach($patientList as $patient)
                                    <tr>
                                        <td style="text-align: center; " class="col-lg-2 col-md-2 col-sm-2 col-xs-2 ">{{$patient->name}}</td>
                                        <td style="text-align: center; " class="col-lg-1 col-md-1 col-sm-1 col-xs-1 ">{{$patient->phone}}</td>
                                        <td style="text-align: center; " class="col-lg-3 col-md-3 col-sm-3 col-xs-3 ">{{$patient->address}}</td>
                                        <td style="text-align: center; " class="col-lg-1 col-md-1 col-sm-1 col-xs-1 ">{{$patient->date_of_birth}}</td>
                                        <td  style="text-align: center; " class="col-lg-3 col-md-3 col-sm-3 col-xs-3 "> 
                                            <div style="padding-left: 1.8em;">
                                            <a href="thong-tin-benh-nhan/{{$patient->id}}" class="btn btn-sm btn-default btn-info">Thông tin bệnh nhân</a>
                                            <button type="button" class="btn btn-sm btn-success"
                                                    onclick="receive('{{$patient->id}}')">Nhận bệnh
                                            </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- tao lich hen -->
        <div id="create" class="modal fade" role="dialog">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title"></h4>
                    </div>
                    <div class="modal-body">
                        <form method="post" class="form-horizontal" action="create-appointment"
                              enctype="multipart/form-data" id="createAppoint">
                            {{ csrf_field() }}
                            <div class="form-group row add">
                             <div class="control-label col-md-4 col-sm-4 col-xs-12">
                             <label>Số điện thoại </label></div>
                                <div class="col-md-6 col-sm-6 col-xs-8" style="padding-right: 0;padding-left: 0;">
                                    <input type="text" class="form-control" id="phoneXXX" name="phoneXXX"
                                           required="required" placeholder="Số điện thoại" style="margin:0px;">
                                    <p class="error text-center alert alert-danger hidden"></p>
                                </div>
                                <div class="col-sm-2 col-xs-2" style="">
                                    <button class="btn btn-success" type="button" onclick="checkValid()">Kiểm tra</button>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-4 col-sm-4 col-xs-12" for="title">Danh sách bệnh nhân</label>
                                <div class="col-md-6 col-sm-6 col-xs-12" style="padding-right: 0;padding-left: 0;">
                                    <select style="margin:0px;width: 100%"
                                            id="PatientSelect" class="selectSpecialTwo col-sm-6 col-xs-7">

                                    </select>
                                </div>
                            </div>
                             @if(Session::get('roleAdmin') == 3 or Session::get('roleAdmin') == 1)
                            <div class="form-group">
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
                            <div class="form-group">
                               
                                <div class="control-label col-sm-4 col-xs-7" for="body"><label>Ngày đặt </label></div>
                          <div class="col-sm-6 col-xs-5 inputWithIcon" style="padding-right: 0;padding-left: 0;">
                              <input type="text" placeholder="Ngày hẹn" id="datepicker" class="form-control pull-right" id="startdate" style="margin:0px;" />
                              <i class="fa fa-calendar"></i>
                          </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-4  col-xs-7 inputWithIcon " for="body">Thời gian dự kiến </label>
                                <div class="col-sm-6 col-xs-5" style="padding-right: 0;padding-left: 0;">
                                 <input type="number" placeholder="Thời lượng" id="estimateTime" name="estimateTime "  class="form-control pull-right"  
                                  style="margin:0px; " />
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-warning" type="button" id="add">
                           Khởi tạo
                        </button>
                        <button class="btn btn-warning" type="button" data-dismiss="modal">
                            <span class="glyphicon glyphicon-remobe"></span>Đóng
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- tao nguoi benh -->
        <div id="createPatient" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content"  >
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title"></h4>
                    </div>
                    <div class="modal-body">
                        <form method="post" class="form-horizontal" action="create-patient"
                              enctype="multipart/form-data" id="createAppoint">
                            {{ csrf_field() }}
                            <div class="form-group row add">
                                <label class="control-label col-md-2 col-sm-3 col-xs-12" for="title">Họ & tên </label>
                                <div class="col-md-8 col-sm-8 col-xs-12">
                                    <input type="text" class="form-control" id="namePatient" name="namePatient"
                                           placeholder="Họ và tên bệnh nhân" required>
                                    <p class="error text-center alert alert-danger hidden"></p>
                                </div>
                            </div>
                            <div class="form-group row add">
                                <label class="control-label col-md-2 col-sm-3 col-xs-12" for="title">Số điện thoại </label>
                                <div class="col-md-8 col-sm-8 col-xs-12">
                                    <input type="text" class="form-control" id="phonePatient" name="phonePatient"
                                           placeholder="Số điện thoại" required>
                                    <p class="error text-center alert alert-danger hidden"></p>
                                </div>
                            </div>
                            <div class="form-group row add">
                                <label class="control-label col-md-2 col-sm-3 col-xs-12" for="title">Địa chỉ</label>
                                <div class="col-md-8 col-sm-8 col-xs-12">
                                    <input type="text" class="form-control" id="addressPatient" name="addressPatient"
                                           placeholder="Địa chỉ cư trú" required>
                                    <p class="error text-center alert alert-danger hidden"></p>
                                </div>
                            </div>
                               <div class="form-group row add">
                                <label class="control-label col-md-2 col-sm-3 col-xs-4" for="title">Thành phố </label>
                                <div class="col-md-4 col-sm-3 col-xs-8">
                                    <select name="cityPatient" id="cityPatient"  style="margin: 0px; "
                                            onchange="disctrict(this)" class="selectSpecialTwo" >
                                        @foreach($citys as $city)
                                            <option value="{{$city->id}}">{{$city->name}}</option>

                                        @endforeach
                                    </select>
                                </div>
                                <label class="control-label col-md-2 col-sm-3 col-xs-4" for="title">Quận </label>
                                <div class="col-md-4 col-sm-3 col-xs-8">
                                    <select name="districtsPatient" id="districtsPatient" class="selectSpecialTwo"  style="margin: 0px; ">
                                        @foreach($District as $one)
                                            <option value="{{$one->id}}">{{$one->name}}</option>

                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-2 col-sm-3 col-xs-4" for="title">Ngày sinh </label>
                                <div class="col-md-4 col-sm-3 col-xs-8">
                                    <div class="inputWithIcon" style="padding-right: 0;padding-left: 0;">
                                          <input type="text" placeholder="Ngày sinh" id="bdayxx" class="form-control pull-right" style="margin:0px;" />
                                          <i class="fa fa-calendar"></i>
                                    </div>
                                </div>
                                <label class="control-label col-md-2 col-sm-3 col-xs-4" for="title">Giới tính </label>
                                <div class="col-md-4 col-sm-3 col-xs-8">
                                    <select name="genderPatient" id="genderPatient" class="selectSpecialTwo" 
                                            style="margin: 0px; ">
                                        <option value="Male">Nam</option>
                                        <option value="FeMale">Nữ</option>
                                        <option value="Unknow">Khác</option>
                                    </select>
                                </div>
                            </div>
                         
                            <hr>
                            <div class="form-group row add">
                                <label class="control-label col-md-2 col-sm-3 col-xs-4" for="title">Bệnh tiền sử </label>
                                <div class=" row col-md-10 col-sm-9 col-xs-12"
                                     style=" float: left;">
                                    <div class=" ">
                                        @foreach($AnamnesisCatalog as $one)

                                            <div class="col-md-4 col-xs-6" style="text-align: left;">
                                                <input type="checkbox" class="anam" name="anam[]" value="{{$one->id}}" id="myCheck"  >
                                                {{$one->name}}
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-warning" type="button" id="addPatient">
                          Khởi tạo bệnh nhân
                        </button>
                        <button class="btn btn-warning" type="button" data-dismiss="modal">
                            <span class="glyphicon glyphicon-remobe"></span>Đóng
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
    <link rel="stylesheet" href="/assets/user/css/mycss.css">
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
    $(document).ready(function() {
            <?php if (Session::has('success')): ?>
            swal("{{ Session::get('success')}}", "", "success");
            <?php endif ?>
            <?php if (Session::has('error')): ?>
            swal("{{ Session::get('error')}}", "", "success");
            <?php endif ?>
        });
        $(function () {
            $('#datepicker').datepicker({
                startDate: 'd',
                autoclose: true,
            });
        });
        $(function () {
            $('#bdayxx').datepicker({
                endDate: 'd',
                autoclose: true,
            });
        });
        var x = 0;
        $(document).on('click', '.create-modal', function () {
            $('#create').modal('show');
            $('.form-horizontal').show();
            $('.modal-title').text('Khởi tạo lịch hẹn');
        });
        $(document).on('click', '.create-patient', function () {
            $('#createPatient').modal('show');
            $('.form-horizontal').show();
            $('.modal-title').text('Khởi tạo thông tin người bệnh');
        });

        $("#add").click(function () {

            var phone = document.getElementById("phoneXXX").value;
            var estimateTimeReal = document.getElementById("estimateTime").value;
            var patientID = document.getElementById("PatientSelect").value;
            var datepicker = document.getElementById("datepicker").value;
            var estimateTime = document.getElementById("estimateTime").value;
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
            }else if (estimateTime >90 || estimateTime < 10) {
                swal("Thời gian cuộc hẹn từ 10 - 90 phút !", "", "error");
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
                        var date = new Date("d-m-y h:i:s",data['start_time']);
                        var numberOrder = data['numerical_order'];
                        const dateTime = data['start_time'];
                        const parts = dateTime.split(/[- :]/);
                        const wanted = 'Vào lúc : ' + parts[3] + ':' + parts[4]+ 'Ngày :'+ parts[2] + '/' + parts[1] + '/' + parts[0] ;
                        console.log(dateTime);
                        var message = "Số thứ tự "+numberOrder;
                        swal(message, wanted, "success");
                    } else {
                        swal("Đặt lịch không thành công", "Vui lòng xem lại thời gian đặt", "error");
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
            var birthdateCreate = document.getElementById("bdayxx").value;
            var genderCreate = document.getElementById("genderPatient").value;
            var districtCreate = document.getElementById("districtsPatient").value;
            if ($.trim(nameCreate) == '' ) {
                swal("Vui lòng nhập họ và tên của bệnh nhân!", "", "error");
                return;
            }else if (nameCreate.length < 6 || nameCreate.length > 50 ) {
                swal("Họ tên phải từ 6 đến 35 kí tự!", "", "error");
                return;
            }else if (addressCreate.length < 6 || addressCreate.length > 50 ) {
                swal("Địa chỉ phải từ 6 đến 35 kí tự!", "", "error");
                return;
            }else if ($.trim(addressCreate) == '') {
                swal("Vui lòng nhập địa chỉ của bệnh nhân  !", "Bấm kiểm tra để có danh sách bệnh nhân", "error");
                return;
            }else if ($.trim(phoneCreate) == '') {
                swal("Vui lòng nhập số điện thoại  !", "", "error");
                return;
            }else if ($.trim(birthdateCreate) == "") {
                swal("Vui lòng chọn năm sinh  !", "", "error");
                return;
            } else if ($.trim(phoneCreate) != '') {
                var vali= /(^0)+([0-9]{9,10})\b/;
                var result= vali.test(phoneCreate);
                if(result == false){
                     swal("Số điện thoại sai cú pháp!", "Số điện thoại chỉ 10 và 11 kí tự và bắt đầu bằng số 0", "error");
                     return;
                } 
            } 
           
            $.ajax({
                type: 'POST',
                url: '/admin/create-patient',
                data: {
                    "_token": "{{ csrf_token() }}",
                    'name': nameCreate,
                    'address': addressCreate,
                    'phone': phoneCreate,
                    'date_of_birth': birthdateCreate,
                    'gender': genderCreate,
                    'district_id': districtCreate,
                    'anam' : data,

                },
                success: function (data) {
                    if ((data.errors)) {
                        alert(data.errors.body);
                    } else {
                        swal("Khởi tạo bệnh nhân thành công", "", "success");
                    }
                },
            });
        });

        function disctrict(sel) {
            var treatCateID = sel.value;
            $.ajax({
                url: '/admin/get-district/' + treatCateID, //this is your uri
                type: 'GET', //this is your method
                dataType: 'json',
                success: function (data) {
                    if (data.length == 0) {
                        $('#districtsPatient')
                            .find('option')
                            .remove()
                            .end()
                            .append('<option value="whatever">Chưa có quận huyện</option>')
                            .val('whatever')
                        ;
                    } else {
                        $('#districtsPatient')
                            .find('option')
                            .remove()
                            .end()
                        ;
                        for (var i = 0; i < data.length; i++) {
                            $('#districtsPatient').append("<option value=" + data[i].id + ">" + data[i].name + "</option>");

                        }
                    }
                }, error: function (obj, text, error) {
                    alert("NO");
                    $('#districtsPatient')
                        .find('option')
                        .remove()
                        .end()
                        .append('<option value="whatever">Chưa có dịch vụ</option>')
                        .val('whatever')
                    ;
                    alert(showNotice("error", obj.responseText));
                },
            });
        }

        $('#search').on('keyup',function(){

            var user = document.getElementById('User');
            var patient = document.getElementById('Patient');
            var appoint = document.getElementById('Appoint');
            var searchValue = document.getElementById('search').value;
            if (!searchValue) {
                searchValue = 'all'
                // swal("Nhập số điên thoại", "", "error");
                // return;
            }
            $.ajax({
                url: '/admin/live-search/' + searchValue, //this is your uri
                type: 'GET', //this is your method

                dataType: 'json',
                success: function (data) {
                    $('tbody').html(data.table_data);
                 
                        $('#total_records').text(data.total_data);
                }, error: function (data) {
                }
            });
        })


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

        function receive(id) {
            $.ajax({
                url: '/admin/list-appointment/' + id, //this is your uri
                type: 'GET', //this is your method

                dataType: 'json',
                success: function (data) {
                    if (data.statusOfReceive == -1) {
                        swal("Bệnh nhân này đang khám", "", "error");
                    }
                    if (data.statusOfReceive == 0) {
                        swal("Bác sĩ đang bận", "", "error");
                    }
                    if (data.statusOfReceive == 1) {
                        swal("Nhận bệnh nhân thành công", "", "success");
                    }
                    if (data.statusOfReceive == 2) {
                        swal("Không có lịch hẹn cho bệnh nhân này", "", "error");
                    }
                }, error: function (data) {
                    swal("Check connnection", "", "error");
                }
            });
        }
    </script>
@endsection