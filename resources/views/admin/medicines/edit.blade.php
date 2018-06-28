@extends('admin.master')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content">
        <div class="container"  >
            <div class="row" style="text-align: center;">
                <label><h1>Chỉnh sửa Thuốc</h1></label>
            </div>
            <form method ="post" class="form-horizontal" action="{{ route('admin.edit.medicines', ['id' => $Medicines->id]) }}" enctype="multipart/form-data" id="createNews">
                {{ csrf_field() }}
                <div class="row" style="margin-bottom: 1em;">
                    <div class="col-sm-2"><label>Mã thuốc </label></div>
                    <div class="col-sm-10" style="padding-right: 0;">
                        <input type="text" class="form-control input-width" readonly id="name" name="name" placeholder="Tên thuốc" required="required" value="{{$Medicines->id}}"/>
                    </div>
                </div>
                <div class="row" style="margin-bottom: 1em;">
                    <div class="col-sm-2"><label>Tên thuốc </label></div>
                    <div class="col-sm-10" style="padding-right: 0;">
                        <input type="text" class="form-control input-width" id="name" name="name" placeholder="Tên thuốc" required="required" value="{{$Medicines->name}}"/>
                    </div>
                </div>
                <div class="row" style="margin-bottom: 1em;">
                    <div class="col-sm-2"><label>Cách sử dụng ( use ) </label></div>
                    <div class="col-sm-10" style="padding-right: 0;">
                        <input type="text" class="form-control input-width" id="use" name="use" placeholder="cách sử dụng" required="required" value="{{$Medicines->use}}"/>
                    </div>
                </div>
                <div class="row" style="margin-bottom: 1em;">
                    <div class="col-sm-2"><label>Đặc tả </label></div>
                    <div class="col-sm-10" style="padding-right: 0;">
                        <input type="text" class="form-control input-width" id="description" name="description" placeholder="Đặc tả" required="required"  value="{{$Medicines->description}}"/>
                    </div>
                </div>

                <div class="row" style="margin-bottom: 1em;" >
                    <div class=""  style="margin-top: 1em;">
                        <button type="submit" class="col-md-3 btn btn-default btn-success" style="margin-right: 10px;float: right;"  onclick="validateQuestionBeforeCreate(event,this)" id="createQForm" >Chỉnh sửa thuốc</button>
                    </div>
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
        swal("Bài viết chưa được tạo!", "", "error");
        <?php endif ?>

        function xxx(evt,sel){
            var check  = document.getElementById('thumbnail').value;
            if(check.length!= 0){
                swal("Hết nulll nhaaa!", "", "error");
            }
        }
    });
    $('#lfm').filemanager('image');
    $(window).on('load', function () {
        $(document).ready(function () {
            var check  = document.getElementById('thumbnail').value;
            if(check.length !=0){
            }
            Page.initTinyMCE();
            Page.initLFM();

        });
    });
    function validateQuestionBeforeCreate(evt,sel){

        var title = document.getElementById('title').value;
        var img = document.getElementById('thumbnail').value;

        var textarea  =tinyMCE.get('tinyMCE').getContent({format: 'text'});

        if($.trim(title) == ''){
            swal("Vui lòng điền tiêu đề!", "", "error");
        }else if($.trim(img) == ''){
            swal("Vui lòng chọn ảnh!", "", "error");

        }else if($.trim(textarea) == ''){
            swal("Vui lòng thêm nội dung bài viết!", "", "error");
        }
        else{
            document.getElementById('createNews').submit();
        }
    }

</script>
@endsection
  