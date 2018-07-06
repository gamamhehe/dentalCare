<!-- <!DOCTYPE html>
<html>
<head>
    <title>Danh sách bệnh nhân</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body> -->
@extends('admin.master')
@section('content')
    <div class="content-wrapper" >
        <div class="box">
            
            <div class="panel panel-default" style="">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-sm-5" style="text-align: left">Tìm bệnh nhân  </div>
                        <div class="col-sm-7" style="text-align: right">
                            <button class="btn btn-success" id="User" >Tạo tài khoản</button>
                            <button class="btn btn-success" id="Patient" >Tạo bệnh nhân</button>
                             <button class="btn btn-success" id="Appoint" >Tạo lịch hẹn</button>
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
    </div>

<!-- </body>
</html> -->
@endsection
@section('js')
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
 <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
    $(document).ready(function(){
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
                $('#User').prop('disabled', false);
                $('#Patient').prop('disabled', false)
                $('#Appoint').prop('disabled', false)
                if(data.total_data == -1){
                    swal("Hãy tạo tài khoản", "", "error");
                    $('#xxx').text(" ");
                    $('#User').prop('disabled', false);
                    $('#Patient').prop('disabled', true)
                    $('#Appoint').prop('disabled', true)
                    
                    
                }
                if(data.total_data == 0){
                    swal("Chưa có hồ sơ bệnh nhân", "", "error");
                    $('#total_records').text(data.total_data);
                    $('#Appoint').prop('disabled', true)
                }
            },error: function (data) {
               swal("Check connnection", "", "error");
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