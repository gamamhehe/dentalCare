@extends('admin.master')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="panel panel-default" style="">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-sm-12" style="text-align: center;"><h1>Thông tin bệnh nhân</h1></div>
            </div>
        </div>
    </div>
    <div class="row" style="background-color: white;">
         
<div class="col-xs-6">
    <div class="container">
        <div class="box box-info">
            <div class="col-xs-6">
                <div class="container" style="padding: 0px;margin: 0px;">
                    <div class="box box-warning">
                        <div class="col-xs-6">
                            <div class="box-header with-border box-warning">
                                <h3 class="box-title" style="float: left;">Thông tin lịch hẹn</h3>

                            </div>
                            <div class="panel-body">
                                <div class="form-group row add">
                                    <div class="col-sm-4"><label>Thời gian bắt đầu</label></div>
                                    <div class="col-sm-6" style="padding-left: 0px;">
                                        <input type="text" value="{{$appointment->start_time}}" name="name"
                                               class="form-control pull-right" id="startdate" style="margin:0px;"
                                               disabled/>
                                    </div>
                                </div>
                                <div class="form-group row add">
                                    <div class="col-sm-4"><label>Thời gian cuộc hẹn</label></div>
                                    <div class="col-sm-6" style="padding-left: 0px;">
                                        <input type="text" value="{{$appointment->estimated_time}}" name="name"
                                               class="form-control pull-right" id="startdate" style="margin:0px;"
                                               disabled/>
                                    </div>
                                </div>
                                <div class="form-group row add">
                                    <div class="col-sm-4"><label>Trạng thái</label></div>
                                    <div class="col-sm-6" style="padding-left: 0px;">
                                        <input type="text" value="{{$appointment->statusString}}" name="name"
                                               class="form-control pull-right" id="startdate" style="margin:0px;"
                                               disabled/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-6">
                <div class="container">
                    <div class="box box-info">
                        <div class="col-xs-6">
                            <div class="box-header with-border box-info">
                                <h3 class="box-title" style="float: left;">Thông tin bệnh nhân</h3>
                                <button class="btn btn-success btn-sm" style="float: right;"> Tạo mới liệu trình
                                </button>
                            </div>
                            <div class="panel-body">
                                <div class="form-group row add">
                                    <div class="col-sm-4"><label>Họ Tên</label></div>
                                    <div class="col-sm-6" style="padding-left: 0px;">
                                        {{--<a href="admin/thong-tin-benh-nhan/{{$patient->id}}">{{$patient->name}}</a>--}}
                                    </div>
                                </div>
                                <div class="form-group row add">
                                    <div class="col-sm-4"><label>Điện thoại</label></div>
                                    <div class="col-sm-6" style="padding: 0px;margin: 0px;">
                                        <input type="text" value="{{$patient->phone}}" name="name"
                                               class="form-control pull-right" id="startdate" style="margin:0px;"
                                               disabled/>
                                    </div>
                                </div>
                                <div class="form-group row add">
                                    <div class="col-sm-4"><label>Bệnh tiền sử</label></div>
                                    <div class="col-sm-6" style="padding-left: 0px;">
                                        <ul style="padding: 0px;margin: 0px;">
                                           @if($patient->Anamnesis)
                                            @foreach($patient->Anamnesis as $key)
                                                <li>{{$key->name->name}}</li>

                                            @endforeach
                                           @endif
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
            swal("Sự kiện đa được tạo!", "", "error");
            <?php endif ?>
            $("div.toolbar").html('<b>Custom tool bar! Text/images etc.</b>');

            function xxx(evt, sel) {
                var check = document.getElementById('thumbnail').value;
                if (check.length != 0) {
                    swal("Hết nulll nhaaa!", "", "error");
                }
            }
        });

        function checkComing(id) {
            $.ajax({
                url: '/admin/check-coming/' + id, //this is your uri
                type: 'GET', //this is your method

                dataType: 'json',
                success: function (data) {
                    if (data.statusComing == 0) {
                        swal("Bệnh nhân chưa đến hoặc đã khám xong", "", "error");
                    }
                    if (data.statusComing == 1) {
                        window.location.replace('http://' + data.url + "/admin/create-treatment/" + data.idPatient);
                    }
                }, error: function (data) {
                    swal("Check connnection", "", "error");
                }
            });
        }

        $(function () {
            $('#dup-table').DataTable({
                "dom": '<"toolbar">frtip',
                language: {
                    "lengthMenu": "Tổng kết quả Hiển thị _MENU_ ",
                    "zeroRecords": "Không tìm thấy kết quả ",
                    "info": "Hiển thị trang _PAGE_ trong tổng _PAGES_ trang",
                    "infoEmpty": "Không có kết quả .",
                    "infoFiltered": "(filtered from _MAX_ total records)",
                    "search": "Tìm kiếm ",
                    "infoFiltered": "(Đã tìm từ _MAX_ kết quả)",

                },
                processing: true,
                serverSide: true,
                order: [[0, "desc"]],
                bLengthChange: true,
                pageLength: 5,
                ajax: '/admin/get-list-anamnesis',
                columns: [

                    {data: 'id'},
                    {data: 'name'},
                    {

                        data: 'action'
                    },
                ],
            });
        });

        function validateQuestionBeforeCreate(evt, sel) {
            // swal("Bài viết chưa được tạo!", "", "error");

            var name = document.getElementById('name').value;
            var discount = document.getElementById('discount').value;

            if ($.trim(name) == '') {
                swal("Vui lòng điền tên sự kiện!", "", "error");
            } else if ($.trim(discount) == '') {
                swal("Vui lòng điền mức giảm giá!", "", "error");

            }
            else {
                document.getElementById('createNews').submit();
            }
        }

    </script>
@endsection
