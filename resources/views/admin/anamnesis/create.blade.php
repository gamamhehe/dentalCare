@extends('admin.master')
@section('title', 'Khởi tạo bệnh tiền sử')
@section('content')
<div class="content-wrapper">
       <div class="box">
        <div class="panel panel-default" style="">
            <div class="panel-heading">
                <div class="row" style="text-align: center;">
                <label><h1>Tạo Bệnh tiền sử</h1></label>
                </div>
            </div>
            <div class="panel-body">
                       <div class="modal-body">
            <form method ="post" class="form-horizontal" action="create-anamnesis" enctype="multipart/form-data" id="createAnamnesis">
                {{ csrf_field() }}
                <div class="form-group row add"  >
                    <div class="control-label col-md-3 col-sm-3 col-xs-12"><label>Tên bệnh </label></div>
                    <div class="col-md-6 col-sm-6 col-xs-8" style="padding-right: 0;padding-left: 0;">
                        <input type="text" class="form-control input-width" id="name" name="name" placeholder="Tên bệnh" required="required" />
                    </div>
                </div>
                <div class="form-group row add"  >
                    <div class="control-label col-md-3 col-sm-3 col-xs-12"><label>Miêu tả bệnh </label></div>
                   <div class="col-md-6 col-sm-6 col-xs-8" style="padding-right: 0;padding-left: 0;">
                        <input type="text" class="form-control input-width" id="description" name="description" placeholder="Miêu tả triệu chứng" required="required" />
                    </div>
                </div>
  

               <div class="form-group row add" >
               <div class="control-label col-md-9 col-sm-9 col-xs-12"  style="padding-right: 0px;">
                    <button type="button" class="col-md-3 btn btn-default btn-success" style="  float: right;"  onclick="validateQuestionBeforeCreate(event,this)">Tạo</button>
                    </div>
                </div>
            </form>
                      </div>
                </div>
        </div>
        </div>
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
                alert("DKM");
            }
            Page.initTinyMCE();
            Page.initLFM();

        });
    });
    function validateQuestionBeforeCreate(evt,sel){
        // swal("Bài viết chưa được tạo!", "", "error");

        var name = document.getElementById('name').value;
        var description = document.getElementById('description').value;

        if($.trim(name) == ''){
            swal("Vui lòng điền tiêu đề!", "", "error");
        }else if($.trim(description) == ''){
            swal("Vui lòng chọn ảnh!", "", "error");

        }else{
            document.getElementById('createAnamnesis').submit();
        }
    }

</script>
@endsection
