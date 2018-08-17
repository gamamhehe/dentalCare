@extends('admin.master')
@section('title', 'Khởi tạo lịch hẹn')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content">
        <div class="container"  >
            <div class="row" style="text-align: center;">
                <label><h1>Khởi tạo liệu trình</h1></label>
            </div>

            <form method ="post" class="form-horizontal" action="create-treatment" enctype="multipart/form-data" id="createNews">
                {{ csrf_field() }}
                <div class="modal-body">
                        <form method="post" class="form-horizontal" action="create-appointment"
                              enctype="multipart/form-data" id="createAppoint">
                            {{ csrf_field() }}
                            <div class="form-group row add">
                             <div class="control-label col-md-4 col-sm-4 col-xs-12"><label>Số điện thoại </label></div>
                                <div class="col-md-6 col-sm-6 col-xs-8" style="padding-right: 0;padding-left: 0;">
                                    <input type="text" class="form-control" id="phoneXXX" name="phoneXXX"
                                           required="required" placeholder="Số điện thoại" style="margin:0px;">
                                    <p class="error text-center alert alert-danger hidden"></p>
                                </div>
                                <div class="col-sm-2 col-xs-2" style="">
                                    <button class="btn btn-success" type="button" onclick="checkValid()">Kiểm tra</button>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-4 col-sm-4 col-xs-12" for="title">Danh sách bệnh nhân</label>
                                <div class="col-md-6 col-sm-6 col-xs-12" style="padding-right: 0;padding-left: 0;">
                                    <select style="margin:0px;width: 100%"
                                            id="PatientSelect" class="selectSpecialTwo col-sm-6 col-xs-7">

                                    </select>
                                </div>
                            </div>
                             @if(Session::get('roleAdmin') == 3 or Session::get('roleAdmin') == 1)
                            <div class="form-group">
                                <label class="control-label col-md-4 col-sm-4 col-xs-12" for="title">Danh sách bác sĩ</label>
                                <div class="col-md-6 col-sm-6 col-xs-12" style="padding-right: 0;padding-left: 0;">
                                    <select style="margin:0px;width: 100%"
                                            id="DentistSelect" class="selectSpecialTwo col-sm-6 col-xs-7">
                                            <option value="0" selected>Mặc định</option>
                                        @foreach($dentists as $dentist)
                                            <option value="{{$dentist->id}}">{{$dentist->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @else
                            <input type="hidden" id="DentistSelect" value="0">
                            @endif
                            <div class="form-group">
                               
                                <div class="control-label col-sm-4 col-xs-7" for="body"><label>Ngày đặt </label></div>
                          <div class="col-sm-6 col-xs-5 inputWithIcon" style="padding-right: 0;padding-left: 0;">
                              <input type="text" placeholder="Ngày hẹn" id="datepicker" class="form-control pull-right" id="startdate" style="margin:0px;" />
                              <i class="fa fa-calendar"></i>
                          </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-4  col-xs-7 " for="body">Thời gian dự kiến </label>
                                <div class="col-sm-6 col-xs-5" style="padding-right: 0;padding-left: 0;">
                                 <input type="number" placeholder="Ngày hẹn" id="estimateTime" name="estimateTime "  class="form-control pull-right" max="90" min="10
                                 .0
                                 "  style="margin:0px;" />
                                </div>
                            </div>
                        </form>
                    </div>

            </form>
        </div>


    </section>


</div>
@endsection
@section('js')
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
    $(document).ready(function() {
        <?php if (Session::has('success')): ?>
        swal("{{ Session::get('success')}}", "", "success");
        <?php endif ?>

        function xxx(evt,sel){
            var check  = document.getElementById('thumbnail').value;
            if(check.length!= 0){
                swal("Hết nulll nhaaa!", "", "error");
            }
        }
    });

    function validateQuestionBeforeCreate(evt,sel){
        // swal("Bài viết chưa được tạo!", "", "error");

        var name = document.getElementById('name').value;
        var use = document.getElementById('discount').value;
        var description = document.getElementById('description').value;

        if($.trim(name) == ''){
            swal("Vui lòng điền tên thuốc!", "", "error");
        }
        else if($.trim(use) == ''){
            swal("Vui lòng điền cách sử dụng!", "", "error");

        }else if($.trim(description) == ''){
            swal("Vui lòng điền đặc tả!", "", "error");

        }
        else{
            document.getElementById('createNews').submit();
        }
    }

</script>
@endsection
  