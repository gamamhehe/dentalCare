@extends('admin.master')
@section('content')
<div class="content-wrapper" >
    <!-- Content Header (Page header) -->
    <section class="content" >
        <div class="container"  >
            <div class="row " style="text-align: center; margin-right: 4em">
                <label><h1>Danh sách các Sự kiện</h1></label>
            </div>
            <div class="row layout" style=" margin-right: 4em"  >
                <table id="dup-table" class="table myTable table-bordered">
                    <thead>
                    <tr style="background-color: #eee;">
                        <td class="col-sm-1">Mã</td>
                        <td class="col-sm-3">Nhân viên</td>
                        <td class="col-sm-2">Ngày bắt đầu</td>
                        <td class="col-sm-2">Ngày kết thúc</td>
                        <td class="col-sm-2">Trạng thái</td>
                    </tr>
                    </thead>
                </table>
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
                                <form method ="post" class="form-horizontal" action="create-Appointment" enctype="multipart/form-data" id="createAppoint">
                                        {{ csrf_field() }}
                                        <input type="hidden" id="idAbsent">
                                    <div class="form-group row add">
                                    <label class="control-label col-xs-3" for="title">Người chấp thuận:</label>
                                    <div class="col-xs-8">
                                        <input type="text" class="form-control" id="staffApprove" name="staffApprove"
                                               required="required" disabled>
                                    </div>
                                    </div>
                                    <div class="form-group row add">
                                    <label class="control-label col-xs-3" for="title">Nhân viên làm đơn :</label>
                                    <div class="col-xs-8">
                                        <input type="text" class="form-control" id="staff" name="staff"
                                               required="required" disabled>
                                    </div>
                                    </div>
                                    <div class="form-group row add">
                                        <label class="control-label col-xs-3" for="title">Ngày nghỉ:</label>
                                        <div class="col-xs-8">
                                            <input type="text" class="form-control col-xs-5" id="end_date" name="end_date"
                                                   required="required" disabled>
                                            <input type="text" class="form-control col-xs-5" id="start_date" name="start_date"
                                           required="required" disabled>
                                        </div>
                                    </div>
                                         
                                    <div class="form-group">
                                        <label class="control-label col-xs-3" for="title">Lời nhắn</label>
                                            <div class="input-group date col-xs-8 " style="    padding-left: 15px">
                                                 <textarea  type="text" class="form-control input-width" id="message" name="message" placeholder="Lời nhắn" required="required"   cols="50" rows="3"></textarea>
                                            </div>
                                    </div>
                                    
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-warning" type="button" id="addApprove" >
                                    <span class="glyphicon glyphicon-plus"></span>Chấp nhận đơn
                                </button>
                                <button class="btn btn-warning" type="button" data-dismiss="modal">
                                    <span class="glyphicon glyphicon-remobe"></span>Đóng
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
    </section>
</div>
@endsection 
@section('js')
<script src="https://datatables.yajrabox.com/js/datatables.bootstrap.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
    $(document).ready(function() {
        <?php if (Session::has('success')): ?>
        swal("Good job!", "", "success");
        <?php endif ?>

    });
     $(document).on('click','.approve-Absent', function() {
        $('#create').modal('show');
        $('.form-horizontal').show();
        $('.modal-title').text('Khởi tạo lịch hẹn');
        $('#staffApprove').val($(this).data('id'));
        $('#idAbsent').val($(this).data('id'));
        $('#staff').val($(this).data('name'));
        $('#start_date').val($(this).data('start'));
        $('#end_date').val($(this).data('end'));
    });
     $(document).on('click','#addApprove', function() {
        
        $.ajax({
          type: 'POST',
          url: '/admin/approve-absent',
          data:{
             "_token": "{{ csrf_token() }}",
            'Absent': $('#idAbsent').val(),
            'message':$('#message').val()
             
          },
          success: function(data){
            if ((data==1)) {
                swal("Đặt lịch nghỉ thành công", "Kiểm tra và xóa những lịch hẹn trùng", "success");
                   $('#dup-table').DataTable().ajax.reload();
                    $('#create').modal('hide');
               
            } else {
                   swal(data, "", "error");
            }
          },
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
            pageLength: 10,
            ajax: '/admin/get-list-absent-admin',
            columns : [
                {data: 'id'},
                {data: 'nameStaff'},
                {data: 'start_date'},
                {data: 'end_date'},
                {

                    data: 'action'
                },
            ],
        });
    });
//     function deleteNews(obj){

// //          var linkDelete = "admin/deleteNews/";
//         var id = obj.getAttribute("id");
//         $.ajax(
//             {
//                 url: "/admin/delete-event/"+id,
//                 method:"get",
//                 data: {
//                     id:id
//                 },
//                 success: function ()
//                 {
//                     $('#dup-table').DataTable().ajax.reload();
//                 }

//             });
//     }
</script>

@endsection
