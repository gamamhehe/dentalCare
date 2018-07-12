@extends('admin.master')
@section('content')
    <link rel="stylesheet" href="{{asset("/plugins/datepicker/datepicker3.css")}}">
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content">
            <div class="">
                <div class="row" style="text-align: center;">
                    <label><h1>Khởi tạo chi tiết lần khám </h1></label>
                    <div class="row" style="margin-left: 35em;">
                        <hr style="
height: 55px;
background-image: url(/assets/images/icon/type_4.png);
background-repeat: no-repeat;">
                    </div>
                </div>

                <form method="post" class="form-horizontal" action="createTreatmentDetail" enctype="multipart/form-data"
                      id="createAnamnesis">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="col-sm-6">
                                <input type="hidden" value="{{$count}}" name="totalTreatStep">
                                @foreach($list as $one)
                                    <div class="row" style="margin-bottom: 1em;border-bottom: 1px">
                                        <div class="col-sm-5" id="content">
                                            {{$one->name}}
                                        </div>
                                        <div class="col-sm-4" style="padding-right: 0;">
                                            <input type="checkbox" name="step[]" value="{{$one->id}}"
                                                   data-toggle="toggle"
                                                   data-size="mini" data-style="slow" data-onstyle="success"
                                                   data-offstyle="danger" data-on="" data-off="">
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="col-sm-6">
                                <input type="hidden" id="totalImg" name="totalImg">
                                <div class="row" id="divImage" style="min-height: 200px;border: 1px green solid;">
                                </div>
                                <div class="row input-group" style="margin-top:1em;">
                                    <input id="thumbnail" class="form-control" type="hidden" name="image"
                                           id="inputImage"
                                           value="{{old('image')}}" onchange="addImage()">
                                    <span class="input-group-btn">
                                <a id="lfm" data-input="thumbnail"
                                   data-input="image1" data-pre view="holder" class="btn btn-primary ">
                                <i class="fa fa-picture-o"></i> Chọn ảnh</a>
                           </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="margin-bottom: 1em;">
                        <div class="col-sm-12">
                            <div class="col-sm-2"><label>Miêu tả bệnh </label></div>
                            <div class="col-sm-10" style="padding-right: 0;">
                            <textarea id="tinyMCE" name="description" rows="10"
                                      class="form-control"
                                      id="input"
                                      placeholder="Write your message..">{!!old('description')!!}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <button type="button" class="btn btn-success btn-medicine">Đơn Thuốc</button>
                        </div>
                        <div class="col-sm-7">
                            <button type="submit" class="col-md-3 btn btn-default btn-success"
                                    style="margin-right: 10px;float: right;"
                                    onclick="validateQuestionBeforeCreate(event,this)" id="createQForm">Tạo
                            </button>
                        </div>
                    </div>
                    <div class="" style="margin-top: 1em;">
                    </div>
                    <div>
                    </div>
                    <!-- popup -->
                    <div id="create" class="modal fade" role="dialog">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title"></h4>
                                </div>
                                <div class="modal-body">
                                    <div class="row" style="text-align: center;">
                                        <div class="col-xs-6">
                                            <div class="box" style="border-top:green 3px solid">
                                                <div>
                                                    <h3 class="box-title">Tìm Đơn Thuốc</h3>
                                                </div>
                                                <!-- /.box-header -->
                                                <div class="box-body">
                                                    <div class="form-group">
                                                        <input type="text" name="search" id="search"
                                                               class="form-control" placeholder="Tên thuốc"/>
                                                    </div>
                                                    <div class="table-responsive">
                                                        <table class="table table-striped table-bordered">
                                                            <thead>
                                                            <tr>
                                                                <th>Tên thuốc</th>
                                                                <th>Công dụng</th>
                                                                <th>Thêm vào đơn thuốc</th>

                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="panel-body col-xs-6"
                                             style="background-color: white;border-top:green 3px solid">
                                            <label><h1 style="text-align: center;font-family: 'Italianno', cursive;
    font-size: 48px;">Đơn Thuốc</h1></label>
                                            <div style="background-color: white;border-top: green 2px solid;text-align: left;">
                                                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                                <div class="row">
                                                    <div class="col-xs-7">Tên thuốc</div>
                                                    <div class="col-xs-2">Số lượng</div>
                                                </div>
                                                <div id="prescription" style="">


                                                </div>
                                                <hr>
                                            </div>


                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
            </div>
            <!-- end popup -->
            <input type="hidden" name="idTreatmentHistory" value="{{Request::get('idTreatmentHistory')}}">
            <input type="hidden" name="listStepTreatment" value="{{Request::get('listStepTreatment')}}">
            </form><!-- form tong -->
        </section>
    </div>
    <!-- popup -->

    <!-- endpopup -->




    </div>


@endsection
@section('js')
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        $(document).ready(function () {
            <?php if (session('message') == "success"): ?>
            swal("Tạo thành công!", "", "success");
            <?php endif ?>
            <?php if (session('message') == "error"): ?>
            swal("Lỗi ! Liệu trình chưa được tạo", "", "error");
            <?php endif ?>






            $('.thumbnail').click(function () {
                $('.modal-body').empty();
                var title = $(this).parent('a').attr("title");
                $('.modal-title').html(title);
                $($(this).parents('div').html()).appendTo('.modal-body');
                $('#myModal').modal({show: true});
            });
        });
        $('#lfm').filemanager('image');
        $(document).on('click', '.btn-dell', function (e) {

            $('#create').modal('show');
            $('.form-horizontal').show();
            $('.modal-title').text('Add Post');
        });

        function validateQuestionBeforeCreate(evt, sel) {
            // swal("Bài viết chưa được tạo!", "", "error");

            var name = document.getElementById('name').value;
            var description = document.getElementById('description').value;

            if ($.trim(name) == '') {
                swal("Vui lòng điền tiêu đề!", "", "error");
            } else if ($.trim(description) == '') {
                swal("Vui lòng chọn ảnh!", "", "error");

            } else {
                document.getElementById('createAnamnesis').submit();
            }
        }

        var x = 0;

        function addImage() {
            x = x + 1;
            document.getElementById("totalImg").value = x;
            var src = document.getElementById('thumbnail').value;
            var tmpId = src.substring(src.length - 10)
            document.getElementById('divImage').insertAdjacentHTML('beforeend',
                "<div id='" + tmpId + "'class='col-lg-2 col-sm-2 col-xs-2'><div class='row' style='max-height: 150px;max-width: 100px;min-height: 150px;min-width: 100px;'> <img class='thumbnail img-responsive img-fruid' style=' display: block;margin-left: auto;    margin-right: auto;' src='" + src + "'><input type='hidden' name='img" + x + "' value='" + src + "'></div><hr style='height:8px;border-bottom: 2px dashed #999;' /><div class='row' style='text-align:center;'><button type='button' class='btn btn-danger' onclick='removeDiv(\"" + tmpId + "\")'>xóa</button></div></div>");
        }

        function removeDiv(id) {
            var div = document.getElementById(id).remove();
            x = x - 1;
            document.getElementById("totalImg").value = x;
            return
        }

        $(document).on('click', '.btn-medicine', function () {
            $('#create').modal('show');
            $('.form-horizontal').show();
            $('.modal-title').text('Đơn thuốc');
        });
        //don thuoc
        $('#search').on('keyup', function () {
            // $value=$(this).val();
            var searchValue = $(this).val();
            if (!searchValue) {
                //     swal("Nhập tên thuốc", "", "error");
                $('tbody').html('')
                return;
            }
            $.ajax({
                url: '/admin/medicine_search/' + searchValue, //this is your uri
                type: 'GET', //this is your method

                dataType: 'json',
                success: function (data) {
                    $('tbody').html(data.table_data);

                    if (data.total_data == 0) {
                        swal("Không có loại thuốc này", "", "error");
                        $('#total_records').text(data.total_data);
                    }
                }, error: function (data) {
                    swal("Check connnection", "", "error");
                }
            });
        })

        function addToPrescription(name, id) {
            var prescription = document.getElementById('prescription').innerHTML;
            if (prescription != null) {
                prescription = prescription.toString()

                if (prescription.indexOf('value="' + id + '">') != -1) {
                    swal("Thuốc này đã tồn tại trong đơn thuốc", "", "error")
                    return
                }
            }
            document.getElementById('prescription').insertAdjacentHTML('beforeend',
                " <div class='row' name='medicine'> <div class='col-xs-7'> <input type='hidden' name='medicine[]' value='" + id +
                "'><span>" + name + "</span></div> <div class='col-xs-3'> <input type='number' name='quantity[]' value='1' style='width:40px;border-radius:5px;border:1px green solid;'> vien</div></div>");
        }

        //end don thuoc
    </script>
@endsection
