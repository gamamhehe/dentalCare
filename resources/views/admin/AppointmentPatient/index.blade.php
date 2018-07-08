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
                                        <label class="control-label col-xs-2" for="title">Số điện thoại:</label>
                                        <div class="col-xs-10">
                                            <input type="text" class="form-control" id="name" name="name"
                                                   placeholder="Your name Here" required>
                                            <p class="error text-center alert alert-danger hidden"></p>
                                        </div>
                                    </div>
                                        <div class="form-group row add">
                                        <label class="control-label col-xs-2" for="title">List patient theo ở tr:</label>
                                        <div class="col-xs-10">
                                            <input type="text" class="form-control" id="name" name="name"
                                                   placeholder="Your name Here" required>
                                            <p class="error text-center alert alert-danger hidden"></p>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-xs-2" for="title">Ngày đặt :</label>
                                        <div class="col-xs-10">
                                            <div class="input-group date">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </div>
                                                <input type="text" placeholder="yyyy-mm-dd" class="form-control pull-right"
                                                       id="datepicker"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-xs-2" for="body">Bác sĩ :</label>
                                        <div class="col-xs-10">
                                            <input type="text" class="form-control" id="district" name="address"
                                                   placeholder="Your Body Here" required>
                                            <p class="error text-center alert alert-danger hidden"></p>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-xs-2" for="body">Estimate time</label>
                                        <div class="col-xs-10">
                                   <select class="hour " style="width: auto;"><option value="">hour</option><option value="0">00</option><option value="1">01</option><option value="2">02</option>
                                   </select>&nbsp                               
                                   <select class="minute " style="width: auto;"><option value="">minute</option><option value="0">00</option><option value="1">01</option><option value="2">02</option><option value="3">03</option><option value="4">04</option><option value="5">05</option><option value="6">06</option><option value="7">07</option><option value="8">08</option><option value="9">09</option><option value="10">10</option><option value="11">11</option><option value="12">12</option><option value="13">13</option><option value="14">14</option><option value="15">15</option><option value="16">16</option><option value="17">17</option><option value="18">18</option><option value="19">19</option><option value="20">20</option><option value="21">21</option><option value="22">22</option><option value="23">23</option><option value="24">24</option><option value="25">25</option><option value="26">26</option><option value="27">27</option><option value="28">28</option><option value="29">29</option><option value="30">30</option><option value="31">31</option><option value="32">32</option><option value="33">33</option><option value="34">34</option><option value="35">35</option><option value="36">36</option><option value="37">37</option><option value="38">38</option><option value="39">39</option><option value="40">40</option><option value="41">41</option><option value="42">42</option><option value="43">43</option><option value="44">44</option><option value="45">45</option><option value="46">46</option><option value="47">47</option><option value="48">48</option><option value="49">49</option><option value="50">50</option><option value="51">51</option><option value="52">52</option><option value="53">53</option><option value="54">54</option><option value="55">55</option><option value="56">56</option><option value="57">57</option><option value="58">58</option><option value="59">59</option>
                                   </select>
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
        $.ajax({
          type: 'POST',
          url: '/admin/create-Appointment',
          data: {
            '_token': $('input[name=_token]').val(),
            'id': $('.id').text()
          },
          success: function(data){
            if ((data.errors)) {
             alert(data.errors.body);
            } else {
               alert("DONE");
            }
          },
            });
    });
        $("#addPatient").click(function() {
        var x = document.getElementById("bdayxx").value;
        var district = document.getElementById("districtsPatient").value;
        if($.trim(x)){
            alert("NULL");
        }
        $.ajax({
          type: 'POST',
          url: '/admin/create-Patient',
          data: {
            '_token': $('input[name=_token]').val(),
            'name':  $('#namePatient').val(),
            'address':  $('#addressPatient').val(),
            'phone':  $('#phonePatient').val(),
                'date_of_birth' : x,
                'district_id' : district
          },
          success: function(data){
            if ((data.errors)) {
             alert(data.errors.body);
            } else {
               alert("DONE");
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
               swal('Error:',"", data);
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