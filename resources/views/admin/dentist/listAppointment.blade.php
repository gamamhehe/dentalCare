@extends('admin.master')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content">
            <div class="">
                <div class="row " style="text-align: center; margin-right: 4em">
                    <label><h1>Danh sách Lịch hẹn của Bác Sĩ </h1></label>
                </div>
                <div class="panel panel-default" style="">
                    <div class="panel-body">
                        <div class="form-group">
                            <table id="dup-table" class="table table-striped table-bordered">
                                <thead>
                                <tr style="background-color: #eee;">
                                    <td class="col-sm-2" style="text-align: left;">Ngày bắt đầu</td>
                                    <td class="col-sm-2">Thời gian khám</td>
                                    <td class="col-sm-3" style="text-align: left;">Ghi Chú</td>
                                    <td class="col-sm-3" style="text-align: left;">Trạng thái</td>
                                    <td class="col-sm-3">Tùy chọn</td>
                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </section>
    </div>
@endsection
@section('js')
    <link rel="stylesheet" href="/assets/user/css/mycss.css">
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
                order: [[0, "desc"]],
                bLengthChange: true,
                pageLength: 5,
                ajax: '/admin/get-appointment',
                columns: [
                    {data: 'start_time'},
                    {data: 'estimated_time'},
                    {data: 'note'},
                    {data: 'status'},
                    {
                        data: 'action'
                    },
                ],
            });
        });

        $(document).on('click', '.btn-dell', function (e) {
            var id = $(this).val();

            $.ajax({
                url: 'get-treatment-history-patient/' + id, //this is your uri
                type: 'GET', //this is your method

                dataType: 'json',
                success: function (data) {
                    if (data.statusComing == 0) {
                        swal("Bệnh nhân chưa đến hoặc đã khám xong", "", "error");
                        return;
                    }
                    $('#create').modal('show');
                    $('.form-horizontal').show();
                    $('.modal-title').text('Add Post');
                    document.getElementById('data').innerHTML = '';
                    data = data.resultHis;
                    if (data.length == 0) {
                        $('#data').append('<tr><td colspan="5" class="text-center">Không có dữ liệu</td></tr>');
                    } else {

                        for (var i = 0; i < data.length; i++) {
                            $('#data').append('<tr><td>' + data[i].id + '</td><td>' + data[i].nameTreat.name + '</td><td>' + data[i].tooth_number + '</td><td>' + data[i].description + '</td><td><a href="treatment-history-detail/' + data[i].id + '" class="btn btn-success" role="button">Skip</a></td></tr>');
                        }
                    }
                    // alert(data[0].id);
                }, error: function (obj, text, error) {
                    //show error
                    alert(showNotice("error", obj.responseText));
                },
            });
        });

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
                        swal("Hoàn tất cuộc hẹn", "success");
                    }
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
