@extends('admin.master')
@section('title', 'Danh sách lịch hẹn trong ngày')
@section('content')
    <div class="content-wrapper">
        <div class="box">
            <div class="panel panel-default" style="">
                <div class="panel-heading">
                    <div class="row " style="text-align: center; margin-right: 4em">
                        <label><h3>Danh sách lịch hẹn trong ngày </h3></label>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <table id="dup-table" class="table table-striped table-bordered">
                        <thead>
                        <tr style="background-color: #eee;">
                            <th class="col-lg-0.5 col-md-1 col-sm-1 col-xs-1">Số điện thoại</th>
                            <th class="col-lg-1 col-md-1 col-sm-1 col-xs-1">Số thứ tự</th>
                            @if(Session::get('roleAdmin') == 3 or Session::get('roleAdmin') == 1)
                                
                                 <th class="col-lg-1 col-md-1 col-sm-1 col-xs-1">Nha sĩ</th>
                            @endif
                           
                            <th class="col-lg-1 col-md-1 col-sm-1 col-xs-1">Giờ bắt đầu</th>
                            <th class="col-lg-1 col-md-1 col-sm-1 col-xs-1">Thời lượng khám</th>
                            <th class="col-lg-2 col-md-2 col-sm-2 col-xs-2">Ghi chú</th>
                            <th class="col-lg-2 col-md-2 col-sm-2 col-xs-2">Trạng thái</th>
                            <th class="col-lg-2 col-md-2 col-sm-2 col-xs-2">Tùy chọn</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>



@endsection
@section('js')
    <script src="https://datatables.yajrabox.com/js/datatables.bootstrap.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        $(document).ready(function () {
            <?php if (Session::has('success')): ?>
            swal("{{ Session::get('success')}}", "", "success");
            <?php endif ?>
            <?php if (Session::has('error')): ?>
            swal("{{ Session::get('error')}}", "", "success");
            <?php endif ?>
        });
        $('#lfm').filemanager('image');
        $(window).on('load', function () {
            $(document).ready(function () {
                Page.initTinyMCE();
                Page.initLFM();
            });
        });
        $(function () {
            $('#dup-table').DataTable({
                "dom": 'frtip',
                language: {
                    "lengthMenu": "Tổng kết quả Hiển thị _MENU_ ",
                    "zeroRecords": "Không tìm thấy kết quả ",
                    "info": "Hiển thị trang _PAGE_ trong tổng _PAGES_ trang",
                    "infoEmpty": "Không có kết quả .",
                    "infoFiltered": "(filtered from _MAX_ total records)",
                    "search": "Tìm kiếm ",
                    "infoFiltered": "(Đã tìm từ _MAX_ kết quả)"
                },
                processing: false,
                serverSide: true,
                order: [[2, "desc"]],
                bLengthChange: true,
                pageLength: 15,
                ajax: '/admin/get-appointment-in-date',
                columns: [
                    {data: 'phone'},
                    {data: 'numerical_order'},
                        @if(Session::get('roleAdmin') == 3 or Session::get('roleAdmin') == 1)
                    {
                        data: 'dentist'
                    },
                        @endif
                    {
                        data: 'time'
                    },
                    {data: 'estimated_time'},
                    {data: 'note'},
                    {data: 'statusButton'},
                    {
                        data: 'action'
                    },
                ],
            });
        });

        // $(document).on('click', '.btn-dell', function(e) {
        //     var id=$(this).val();
        //
        //     $.ajax({
        //         url: 'get-treatment-history-patient/'+id, //this is your uri
        //         type: 'GET', //this is your method
        //
        //         dataType: 'json',
        //         success: function(data){
        //             if(data.statusComing == 0){
        //                 swal("Bệnh nhân chưa đến hoặc đã khám xong", "", "error");
        //                 return;
        //             }
        //             $('#create').modal('show');
        //             $('.form-horizontal').show();
        //             $('.modal-title').text('Add Post');
        //             document.getElementById('data').innerHTML = '';
        //             data = data.resultHis;
        //             if(data.length == 0){
        //                 $('#data').append('<tr><td colspan="5" class="text-center">Không có dữ liệu</td></tr>');
        //             }else{
        //
        //                 for (var i = 0; i < data.length; i++) {
        //                     $('#data').append('<tr><td>' + data[i].id + '</td><td>' + data[i].nameTreat.name + '</td><td>' + data[i].tooth_number +'</td><td>' + data[i].description +'</td><td><a href="treatment-history-detail/'+data[i].id+'" class="btn btn-success" role="button">Skip</a></td></tr>');
        //                 }
        //             }
        //             // alert(data[0].id);
        //         },error: function(obj,text,error) {
        //             //show error
        //             alert( showNotice("error",obj.responseText));
        //         },
        //     });
        // });
        function checkDone(id) {
            $.ajax({
                url: '/admin/check-done/' + id, //this is your uri
                type: 'GET', //this is your method

                dataType: 'json',
                success: function (data) {
                    if (data.statusDone == 0) {
                        swal("Cuộc hẹn này chưa được bắt đầu", "", "error");
                    }
                    if (data.statusDone == 1) {
                        swal("Hoàn tất cuộc hẹn", '', "success");
                    }
                    setTimeout(function () {
                        location.reload();
                    }, 1000);
                }, error: function (data) {
                    swal("Check connnection", "", "error");
                }
            });
        }

        function checkStart(id) {
            $.ajax({
                url: '/admin/start-appointment/' + id, //this is your uri
                type: 'GET', //this is your method
                dataType: 'json',
                success: function (data) {
                }, error: function (data) {
                }
            });
        }
    </script>

@endsection
