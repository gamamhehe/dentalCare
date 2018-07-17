@extends('admin.master')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content">
            <div class="col-xs-6">
              <div class="box box-info">
                <div class="row" style="text-align: center;">
                    <label><h1>Đơn xin nghỉ</h1></label>
                </div>
                <form method ="post" class="form-horizontal" action="create-absent" enctype="multipart/form-data" id="createAbsent">
                    {{ csrf_field() }}
                     <div class="box-body">
                        <div class="form-group">
                          <div class="col-sm-2"><label>Từ ngày </label></div>
                          <div class="col-sm-3 inputWithIcon" style="padding-right: 0;padding-left: 0;">
                          <input type="text" placeholder="Ngày bắt đầu" name="start_date" class="form-control pull-right" id="startdate" style="margin:0px;" />
                          <i class="fa fa-calendar"></i>
                          </div>
                          <div class="col-sm-2"><label>đến ngày</label></div>
                          <div class="col-sm-3 inputWithIcon" style="padding-right: 0;padding-left: 0;">
       <input type="text" placeholder="Ngày kết thúc" name="end_date" class="form-control pull-right" id="enddate" style="margin:0px;" />
   <i class="fa fa-calendar"></i>
                          </div>
                        </div>
                         <div class="form-group">
                        <div class="col-sm-2"><label>Lí do</label></div> 
                      
                        <div class="col-sm-10" style="padding-left: 0px;" >
                            <textarea  type="text" class="form-control input-width" id="reason" name="reason" placeholder="Lí do" required="required" id="reason" cols="30" rows="10"></textarea>
                        </div>
                    </div>
                     </div>
                     <div class="box-footer">
             <button type="button" class="col-md-3 btn btn-default btn-success" style="margin-right: 10px;float: right;" onclick="validateQuestionBeforeCreate(event,this)">Gửi Đơn</button>
              </div>
                   
                </form>
            </div>
            </div>

            <!-- //phải -->
            <div class="col-xs-6">
          <!-- Horizontal Form -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Đơn xin nghỉ</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <table id="dup-table" class="table table-bordered">
                    <thead>
                    <tr style="background-color: #eee;">
                        <td class="col-sm-1">STT</td>
                        <td class="col-sm-3">Từ Ngày</td>
                        <td class="col-sm-3">Đến Ngày</td>
                        <td class="col-sm-2">Trạng Thái</td>
                    </tr>
                    </thead>
                </table>
            </div>
            <!-- /.box-body -->
          </div>
        </div>
        </section>
    </div>
@endsection
@section('js')
<script src="https://datatables.yajrabox.com/js/datatables.bootstrap.js"></script>
 <link rel="stylesheet" href="/assets/user/css/mycss.css">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        $(document).on('click','#datepicker', function() {
           document.getElementById("datepicker2").value = null;
           document.getElementById("datepicker2").placeholder = "Ngày kết thúc";

        });
        $(document).ready(function() {
          <?php if (Session::has('success')): ?>
          swal("Đơn xin nghỉ đã được gởi!", "", "success");  
        <?php endif ?>
          <?php if (Session::has('error')): ?>
          swal("Đơn xin nghỉ chưa được gởi.", "Ngày xin nghỉ đã được chấp nhận!", "error");  
        <?php endif ?>
             $("#startdate").datepicker({
        startDate: new Date(),
        autoclose: true,
          }).on('changeDate', function (selected) {
        var minDate = new Date(selected.date.valueOf());
        $('#enddate').datepicker('setStartDate', minDate);
          });
    
        $("#enddate").datepicker({
             autoclose: true,
        })
            .on('changeDate', function (selected) {
                var minDate = new Date(selected.date.valueOf());
            });
        $(document).on('click','#startdate', function() {
                 document.getElementById("enddate").value = null;
                 document.getElementById("enddate").placeholder = "Ngày kết thúc";
                 // $("#datepicker2").datepicker("setMinDate", new Date(2018, 10 -1, 25));
                });

        });
   
        
    $(function() {
        $('#dup-table').DataTable({
            language: {
            "lengthMenu": "Tổng kết quả Hiển thị _MENU_ ",
            "zeroRecords": "Không tìm thấy kết quả ",
            "info": "Hiển thị trang _PAGE_ trong tổng _PAGES_ trang",
            "infoEmpty": "Không có kết quả .",
            "infoFiltered": "(filtered from _MAX_ total records)",
            "search" : "Tìm kiếm ",
            "infoFiltered": "(Đã tìm từ _MAX_ kết quả)"
        },
            processing: true,
            serverSide: true,
            order: [[ 0, "desc" ]],
            bLengthChange:true,
            pageLength: 5,
            ajax: '/admin/get-list-absent',
            columns : [

                {data: 'id'},
                {data: 'start_date'},
                {data: 'end_date'},
                {

                    data: 'action'
                },
            ],
        });
    });
    function validateQuestionBeforeCreate(evt,sel){
         // swal("Bài viết chưa được tạo!", "", "error");
 
      var startdate = document.getElementById('startdate').value;
        var enddate = document.getElementById('enddate').value;
        var reason  =document.getElementById('reason').value
        $.ajax({
          type: 'GET',
          url: '/admin/valid-absent',
          success: function(data){
           if(data<=3){
               if($.trim(startdate) == ''){
             swal("Vui lòng chọn ngày bắt đầu nghỉ!", "", "error");
                }else if($.trim(enddate) == ''){
                 swal("Vui lòng chọn ngày kết thúc nghỉ!", "", "error");

                }else if($.trim(reason) == ''){
                      swal("Vui lòng thêm nguyên nhân nghỉ !", "", "error");
                }else{
                  document.getElementById('createAbsent').submit();            
                }
           }else{
              swal("Số đơn xin nghỉ quá nhiều!", "Hãy xóa để có thể tạo đơn mới", "error");
           }
          },
        });
    }
    function deleteNews(obj){

//          var linkDelete = "admin/deleteNews/";
        var id = obj.getAttribute("id");
        $.ajax(
            {
                url: "/admin/delete-absent",
                method:"get",
                data: {
                    id:id
                },
                success: function ()
                {
                    $('#dup-table').DataTable().ajax.reload();
                }

            });
    }
        

    </script>
@endsection
