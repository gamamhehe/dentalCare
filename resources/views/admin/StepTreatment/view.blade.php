@extends('admin.master')
@section('title', 'Khởi tạo chi tiết lần khám')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="box" style="border: none">
            <div class="panel-heading" style="padding-bottom: 0px;border-bottom-width: 0px;padding-top: 0px;">
                <div class="row" style="text-align: center;">
                    <label><h1 style="margin-bottom: 0px;">Khởi tạo chi tiết lần khám </h1></label>
                    <div class="row img-center"><p><img class="img-center"
                                                        src="https://vivaclinic.vn/wp-content/uploads/2017/09/SHARP-3.png"
                                                        data-src="https://vivaclinic.vn/wp-content/uploads/2017/09/SHARP-3.png"
                                                        width="196" height="50" alt=""></p></div>
                </div>
            </div>
            <div class="panel-body" style="padding-top: 0px;">

                <form method="post" class="form-horizontal" action="create-treatment-detail"
                      enctype="multipart/form-data"
                      id="createAnamnesis">
                    {{ csrf_field() }}
                    <div class="form-group row">
                        <div class="col-sm-12">
                            <div class="col-sm-6">
                                <div class="row"
                                     style="color: green;text-align: center;border-bottom: 1px green solid;    margin-right: 1em">
                                    <h3>Các bước điều trị</h3></div>
                                <input type="hidden" value="{{$count}}" name="totalTreatStep">
                                <div class="row" style="margin-right: 2px;padding-bottom: 1em;margin-top: 1em;">
                                    @foreach($list as $one)
                                        <div class="form-group row" style="margin-bottom: 1em;border-bottom: 1px; ">
                                            <div class="col-md-7 col-sm-7 col-xs-8" style="padding-left:5em;">
                                                {{$one->name}}
                                            </div>
                                            <div class="col-md-3 col-sm-3 col-xs-3" style="padding-right: 0; ">
                                                <input type="checkbox" name="step[]" value="{{$one->id}}"
                                                       data-toggle="toggle"
                                                       data-size="mini" data-style="slow" data-onstyle="success"
                                                       data-offstyle="danger" data-on="Chọn" data-off="Hủy">
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="row">
                                    <div class="form-group row" style="margin-bottom: 1em;border-bottom: 1px; ">
                                        <div class="col-md-2 col-sm-2 col-xs-10"
                                             style="padding-left:5em;text-align: center;">
                                            <button type="button" class="btn btn-success btn-medicine">Đơn thuốc
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="row"
                                     style="color: green;text-align: center;border-bottom: 1px green solid;"><h3>Hình
                                        ảnh</h3></div>
                                <input type="hidden" id="totalImg" name="totalImg">
                                <div class="row" id="divImage" style="min-height: 200px;">
                                </div>
                                <div class="row input-group" style="margin-top:1em;">
                                    <input id="thumbnail" class="form-control" type="hidden" name="image"
                                           id="inputImage"
                                           value="{{old('image')}}" onchange="addImage()">
                                    <span class="input-group-btn">
                                    <a id="lfm" data-input="thumbnail" type="button" style="border-radius: 5px;"
                                       data-input="image1" data-pre view="holder" class="btn btn-success ">
                                    <i class="fa fa-picture-o"></i> Chọn ảnh</a>
                               </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row" style="margin-bottom: 1em;">
                        <div class="col-sm-12">
                            <div class="col-sm-2 col-xs-3 control-label" style="padding-right: 40px;"> Miêu tả bệnh
                            </div>
                            <div class="col-sm-10 col-xs-8" style="padding-right: 0;">
                                <textarea id="tinyMCE" name="description" rows="4"
                                          class="form-control"
                                          id="input"
                                          placeholder="Miêu tả bệnh">{!!old('description')!!}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-4">

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
                    <!-- popup -->
                    <div id="create" class="modal fade" role="dialog">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h3 class="modal-title" style="text-align: center;"></h3>
                                </div>
                                <div class="modal-body">
                                    <div class="row" style="text-align: center;">
                                        <div class="panel-body col-md-6 col-sm-12 col-xs-12">
                                            <div class="box" style="border-top:green 3px solid">
                                                <div><h4 class="box-title">Các loại thuốc</h4></div>
            <div class="box-body">
                <div class="form-group row">
                    <div class="col-xs-12"><input type="text" name="search"
                                                  id="search"
                                                  class="form-control"
                                                  placeholder="Tên thuốc"/></div>


                                                    </div>
                                                    <div class="table-responsive">
                                                        <table class="table table-striped table-bordered" style="display: block;height: 500px;overflow-y: scroll;">
                                                            <thead>
                                                            <tr>
                                                                <th class="col-md-4 col-xs-12">Tên thuốc</th>
                                                                <th class="col-md-4 col-xs-12">Công dụng</th>
                                                                <th class="col-md-2 col-xs-12">Tùy chọn</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            @if($medicineList)
                                                                @foreach($medicineList as $medicine)
                                                                    <tr>
                                                                        <td class="col-md-4 col-xs-12 ">{{$medicine->name }}</td>
                                                                        <td class="col-md-4 col-xs-12"> {{$medicine->use }}</td>
                                                                        <td class="col-md-3 col-xs-12">
                                                                            <button type="button"
                                                                                    class="btn btn-default divcenter btn-success"
                                                                                    style="margin-right: 10px;float: center;"
                                                                                    onclick="addToPrescription('{!!$medicine->name!!}', '{{$medicine->id}}')">
                                                                                <i class="fa fa-plus"></i>
                                                                            </button>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            @endif
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="panel-body col-md-6 col-sm-12 col-xs-12">
                                            <div class="box" style="border-top:green 3px solid">
                                                <div style="text-align: center"><label><h4>Đơn thuốc</h4></label></div>
                                                <div class="box-body">
                                                    <input type="hidden" name="_token"
                                                           value="<?php echo csrf_token(); ?>">
                                                    <div class="form-group row">
                                                        <div class="col-xs-6">Tên thuốc</div>
                                                        <div class="col-xs-6">Số lượng</div>
                                                    </div>
                                                    <div id="prescription" style="">
                                                    </div>
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
            </div>
        </div>
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
            if (x == 5) {
                document.getElementById("lfm").style.display = "none";
            }
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
            document.getElementById("lfm").style.display = "block";
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
                url: '/admin/medicine-search/' + searchValue, //this is your uri
                type: 'GET', //this is your method

                dataType: 'json',
                success: function (data) {
                    $('tbody').html(data.table_data);

                    if (data.total_data == 0) {
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
                    swal("Thuốc đã tồn tại trong đơn thuốc", "", "error")
                    return
                }
            }
            document.getElementById('prescription').insertAdjacentHTML('beforeend',
                " <div class='row' name='medicine' id='"+ id+ "'> <div class='col-xs-5'> <input type='hidden' name='medicine[]' value='" + id +
                "'><span>" + name + "</span></div> <div class='col-xs-5'> <input type='number' name='quantity[]' value='1' min='1' max='99' style='width:50%;border-radius:5px;border:1px green solid;'> viên</div>" +
                "<div class='col-xs-2'><button class='btn btn-danger btn-sm'  onclick='remove(" + id + ")'>Xóa</button></div></div>");
        }
        function remove(id){
            $("#" + id).remove();
        }
        //end don thuoc
    </script>
@endsection
