@extends('admin.master')
@section('content')
    <div class="content-wrapper" >
        <!-- Content Header (Page header) -->
        <section class="content" >
            <div class="container"  >
                <div class="row " style="text-align: center; margin-right: 4em">
                    <label><h1>Danh sách Lịch hẹn của Bác Sĩ </h1></label>
                </div>
                <div class="row layout" style=" margin-right: 4em"  >
                    <table id="dup-table" class="table ">
                        <thead>
                        <tr style="background-color: #eee;">
                            <td class="col-sm-1">id</td>
                            <td class="col-sm-2" style="text-align: left;">Ngày bắt đầu</td>
                            <td class="col-sm-2">Thời gian khám </td>
                            <td class="col-sm-4" style="text-align: left;">Note</td>
                            <td class="col-sm-3">xx </td>
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
                                <form class="form-horizontal" role="form">
                                   <table style="border: 1px solid black;width: 100%">
                                      <tr>
                                        <th>Mã</th>
                                        <th>Dịch vụ</th>
                                        <th>Răng</th>
                                        <th>Note</th>
                                      </tr>
                                      <tr>
                                        <td>1</td>
                                        <td>Nhổ răng</td>
                                        <td>Răng số 1 - trên trái</td>
                                        <td>Lũng nặng</td>
                                      </tr>
                                       <tr>
                                        <td>2</td>
                                        <td>Trám</td>
                                        <td>Răng số 2 - trên trái</td>
                                        <td>2 xoang nhỏ hốc trái</td>
                                      </tr>
                                       
                                    </table>
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
        $('#lfm').filemanager('image');
        $(window).on('load', function () {
            $(document).ready(function () {
                Page.initTinyMCE();
                Page.initLFM();
            });
        });
        $(function() {
            $('#dup-table').DataTable({
                processing: true,
                serverSide: true,
                order: [[ 0, "desc" ]],
                bLengthChange:true,
                pageLength: 5,
                ajax: '/admin/getAppointment',
                columns : [

                    {data: 'id'},
                    {data: 'start_time'},
                    {data: 'estimated_time'},
                    {data: 'note'},
                    {

                        data: 'action'
                    },
                ],
            });
        });
       
         $(document).on('click', '.btn-dell', function(e) {
            var id=$(this).val();
           
            $.ajax({
             url: 'getTreatmentHistoryPatient/'+id, //this is your uri
            type: 'GET', //this is your method
          
            dataType: 'json',
            success: function(data){
               $('#create').modal('show');
                $('.form-horizontal').show();
                $('.modal-title').text('Add Post');
                // alert(data[0].id);
            },error: function(obj,text,error) {
                   //show error
                  alert( showNotice("error",obj.responseText));
                },
            });
    });


    </script>

@endsection
