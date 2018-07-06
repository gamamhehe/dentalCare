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
                             <button class="btn btn-success create-modal" id="Appoint" >Tạo lịch hẹn</button>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <input type="text" name="search" id="search" class="form-control" placeholder="Số điên thoại bệnh nhân"  />
                        <div class="row" style="margin-bottom: 1em;" >
                            <div class=""  style="margin-top: 1em;">
                                <button type="button" class="col-md-3 btn btn-default btn-success" style="margin-right: 10px;float: right;"  onclick="search()" >Tìm</button>
                            </div>
                        </div>

                    </div>
                  
 
                    <div class="table-responsive">
                        <h3 align="left" id="xxx">Số lượng bệnh nhân của tài khoản: <span id="total_records"></span></h3>
                        <table class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>Họ Tên</th>
                                <th>Địa Chỉ</th>
                                <th>Ngày Sinh</th>
                                <th>Tùy chọn</th>

                            </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
          <div id="create" class="modal fade" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title"></h4>
                            </div>
                            <div class="modal-body">
                                <form class="form-horizontal" role="form">
                                    <div class="form-group row add">
                                        <label class="control-label col-sm-2" for="title">Bệnh nhân :</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="name" name="name"
                                                   placeholder="Your name Here" required>
                                            <p class="error text-center alert alert-danger hidden"></p>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-sm-2" for="body">Date-picker :</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="address" name="address"
                                                   placeholder="Your Body Here" required>
                                            <p class="error text-center alert alert-danger hidden"></p>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-sm-2" for="body">Bác sĩ :</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="district" name="address"
                                                   placeholder="Your Body Here" required>
                                            <p class="error text-center alert alert-danger hidden"></p>
                                        </div>
                                    </div>
                                      <div class="form-group">
                                        <label class="control-label col-sm-2" for="body">Estimate time</label>
                                        <div class="col-sm-10">
                                           
                                      <input class="form-control datepicker">
                                            <p class="error text-center alert alert-danger hidden"></p>
                                        </div>
                                    </div>
                                    
                                    </div>
                                    <div>
                                      <div class="span5 col-md-5" id="sandbox-container"><input type="text" class="form-control"></div>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-warning" type="submit" id="add" onclick="save()" >
                                    <span class="glyphicon glyphicon-plus"></span>Save Post
                                </button>
                                <button class="btn btn-warning" type="button" data-dismiss="modal">
                                    <span class="glyphicon glyphicon-remobe"></span>Close
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
    </div>

<!-- </body>
</html> -->
@endsection
@section('js')
   <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
 <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
     
    $(document).ready(function(){
        $('#sandbox-container input').datepicker({
    startDate: "07/02/2018"
});
        <?php if (Session::has('success')): ?>
        swal("Xong nha má", "", "success");
        <?php endif ?>

        <?php if ($errors->first('message1')): ?>
        swal("Error", "", "success");
        <?php endif ?>
    });
     $(document).on('click','.create-modal', function() {
        $('#create').modal('show');
        $('.form-horizontal').show();
        $('.modal-title').text('Add Post');
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

</script>
@endsection