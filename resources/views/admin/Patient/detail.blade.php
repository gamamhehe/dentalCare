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
        <div class="box box-info">
            <div class="box-header with-border box-info">
                <h3 class="box-title">Thông tin cá nhân</h3>
            </div>
            <div class="panel-body">
                <div class="form-group row add">
                    <div class="col-sm-2"><label>Họ Tên</label></div>
                    <div class="col-sm-6" style="padding-left: 0px;">
                        <input type="text" value="{{$patient->name}}" name="name" class="form-control pull-right"
                               id="startdate" style="margin:0px;" disabled/>
                    </div>
                </div>
                <div class="form-group row add">
                    <div class="col-sm-2"><label>Địa chỉ</label></div>
                    <div class="col-sm-6" style="padding-left: 0px;">
                        <input type="text" value="{{$patient->address}}" name="name" class="form-control pull-right"
                               id="startdate" style="margin:0px;" disabled/>
                    </div>
                    <div class="col-sm-1"><label>Giới tính</label></div>
                    <div class="col-sm-3" style="padding-left: 0px;">
                        <input type="text" value="{{$patient->gender}}" name="name" class="form-control pull-right"
                               id="startdate" style="margin:0px;" disabled/>
                    </div>

                </div>
                <div class="form-group row add">
                    <div class="col-sm-2"><label>Điện thoại</label></div>
                    <div class="col-sm-4" style="padding-left: 0px;">
                        <input type="text" value="{{$patient->phone}}" name="name" class="form-control pull-right"
                               id="startdate" style="margin:0px;" disabled/>
                    </div>
                    <div class="col-sm-2"><label>Ngày sinh</label></div>
                    <div class="col-sm-4" style="padding-left: 0px;">
                        <input type="text" value="{{$patient->date_of_birth}}" name="name"
                               class="form-control pull-right" id="startdate" style="margin:0px;" disabled/>
                    </div>
                </div>
                <div class="form-group row add">
                    <div class="col-sm-2"><label>Bệnh tiền sử</label></div>
                    <div class="col-sm-4" style="padding-left: 0px;">
                        <input type="text" placeholder="Ngày bắt đầu" name="name" class="form-control pull-right"
                               id="startdate" style="margin:0px;" disabled/>
                    </div>
                    <div class="col-sm-2"><label>Bệnh tiền sử</label></div>
                    <div class="col-sm-4" style="padding-left: 0px;">
                        <input type="text" placeholder="Ngày bắt đầu" name="name" class="form-control pull-right"
                               id="startdate" style="margin:0px;" disabled/>
                    </div>
                </div>
                <div class="form-group row add">
                    <div class="col-sm-2"><label>Tài chính</label></div>
                    <div class="col-sm-4" style="padding-left: 0px;">
                        <input type="text" placeholder="Hết thiếu hay thiếu nói 1 lời" name="name"
                               class="form-control pull-right" id="startdate" style="margin:0px;" disabled/>
                    </div>
                    <div class="col-sm-2"><label>Lịch hẹn tiếp theo</label></div>
                    <div class="col-sm-4" style="padding-left: 0px;">
                        <input type="text" placeholder="Ngày bắt đầu" name="name" class="form-control pull-right"
                               id="startdate" style="margin:0px;" disabled/>
                    </div>
                </div>

            </div>
        </div>

        <div class="box box-info">
            <div class="box-header with-border box-info">
                <h3 class="box-title">Tiền sử bệnh án</h3>
            </div>
            <div class="panel-body">
                <!-- start -->
                <div class="container">
                    <br/>
                    <br/>
                    <div id="accordion" class="accordion-container">
                        @if($listTreatmentHistory)
                            @foreach($listTreatmentHistory as $treatmentHistory)
                                <article class="content-entry">
                                    <div class="article-title">
                                        <div class="row">
                                            <h4 class="panel-title">
                                                <div class="container">
                                                    <h4>
                                                        <i style="position: relative; top: 5px;left: 5px;"></i>{{$treatmentHistory->treatment->name}}
                                                    </h4>
                                                </div>
                                                <div class="container">
                                                    <div class="col-sm-4">Giá
                                                        : {{$treatmentHistory->treatment->max_price}} VNĐ
                                                    </div>
                                                    <div class="col-sm-4">Khuyến mãi : 0%</div>
                                                    <div class="col-sm-4">Còn lại
                                                        : {{$treatmentHistory->treatment->max_price}} VNĐ
                                                    </div>
                                                    <div class="col-sm-4">Răng
                                                        : {{$treatmentHistory->tooth->tooth_name}}</div>
                                                    <div class="col-sm-4">Ngày bắt đầu
                                                        : {{$treatmentHistory->create_date}}</div>
                                                    <div class="col-sm-4">Ngày kết thúc
                                                        : {{$treatmentHistory->finish_date}}</div>
                                                </div>
                                            </h4>
                                        </div>
                                    </div>
                                    <div class="accordion-content">
                                        @foreach($treatmentHistory->details as $a)
                                            @if($a)
                                                <div class="row">
                                                    <div class="col-sm-2">BÁC SĨ :</div>
                                                    <div class="col-sm-8">{{$a->dentist->name}} </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-2">Ngày điều trị</div>
                                                    <div class="col-sm-8">{{$a->create_date}} </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-2">Các bước đã thực hiện:</div>
                                                    <div class="col-sm-8">
                                                        @foreach($a->treatment_detail_steps as $step)
                                                            <div class="row">
                                                                <div class="col-sm-8">{{$step->step->name}} </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-2">Toa thuốc</div>
                                                    <div class="col-sm-9">
                                                        <table class="table table-striped Mytable-hover">
                                                            <tr>
                                                                <th>Tên thuốc</th>
                                                                <th>Số lượng</th>
                                                            </tr>
                                                            <tbody>
                                                            @foreach($a->prescriptions as $prescription)
                                                                <tr>
                                                                    <td>{{$prescription->medicine->name}}</td>
                                                                    <td>{{$prescription->quantity}} viên</td>
                                                                </tr>
                                                            @endforeach
                                                            </tbody>
                                                        </table>

                                                    </div>
                                                </div>
                                                <div class="row" style="margin-top: 10px;">
                                                    @foreach($a->treatment_images as $b)
                                                        <div class="col-sm-4">
                                                            <img src="{{$b->image_link}}" alt=""
                                                                 class="img-responsive img-fluid">
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <hr>
                                            @else
                                                <div class="row">
                                                    <div class="col-sm-2">BÁC SĨ :</div>
                                                    <div class="col-sm-8">NULL nhé</div>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </article>
                            @endforeach
                        @else
                            <div class="container" style="background-color: whitesmoke;width: 100%;height: 200px;">
                                <h1 style="text-align: center;margin-top: 2em;">Bệnh nhân chưa từng điều trị</h1>
                            </div>
                        @endif
                    </div>
                    <br/>
                    <br/>
                    <!--/#accordion-->


                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <link rel="stylesheet" href="/assets/user/css/mycss.css">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        $(document).ready(function () {
            <?php if (Session::has('success')): ?>
            swal("Sự kiện đa được tạo!", "", "error");

            <?php endif ?>

            function xxx(evt, sel) {
                var check = document.getElementById('thumbnail').value;
                if (check.length != 0) {
                    swal("Hết nulll nhaaa!", "", "error");
                }
            }
        });
        //accordion
        $(function () {
            var Accordion = function (el, multiple) {
                this.el = el || {};
                this.multiple = multiple || false;

                var links = this.el.find('.article-title');
                links.on('click', {
                    el: this.el,
                    multiple: this.multiple
                }, this.dropdown)
            }

            Accordion.prototype.dropdown = function (e) {
                var $el = e.data.el;
                $this = $(this),
                    $next = $this.next();

                $next.slideToggle();
                $this.parent().toggleClass('open');

                if (!e.data.multiple) {
                    $el.find('.accordion-content').not($next).slideUp().parent().removeClass('open');
                }
                ;
            }
            var accordion = new Accordion($('.accordion-container'), false);
        });

        //end accordion

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
