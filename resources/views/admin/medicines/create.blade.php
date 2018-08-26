@extends('admin.master')
@section('title', 'Khởi tạo Thuốc')
@section('content')
<div class="content-wrapper">
 <div class="box">
        <div class="panel panel-default" style="">
            <div class="panel-heading">
                <div class="row" style="text-align: center;">
                <label><h1>Khởi tạo thuốc</h1></label>
                </div>
            </div>
            <div class="panel-body">
                       <div class="modal-body">
            <form method ="post" class="form-horizontal" action="create-medicines" enctype="multipart/form-data" id="createNews">
                {{ csrf_field() }}
                 <div class="form-group row add"  >
                    <div class="control-label col-md-3 col-sm-3 col-xs-12"><label>Tên thuốc </label></div>
                <div class="col-md-6 col-sm-6 col-xs-8" style="padding-right: 0;padding-left: 0;">
                        <input type="text" class="form-control input-width" id="name" name="name" placeholder="Tên thuốc" required="required" />
                    </div>
                </div>
                 <div class="form-group row add"  >
                    <div class="control-label col-md-3 col-sm-3 col-xs-12"><label>Cách sử dụng ( use ) </label></div>
                     <div class="col-md-6 col-sm-6 col-xs-8" style="padding-right: 0;padding-left: 0;">
                        <input type="text" class="form-control input-width" id="use" name="use" placeholder="Cách sử dụng" required="required" />
                    </div>
                </div>
                 <div class="form-group row add"  >
                    <div class="control-label col-md-3 col-sm-3 col-xs-12"><label>Mô tả </label></div>
                   <div class="col-md-6 col-sm-6 col-xs-8" style="padding-right: 0;padding-left: 0;">
                        <input type="text" class="form-control input-width" id="description" name="description" placeholder="Mô tả" required="required" />
                    </div>
                </div>

               <div class="form-group row add" >
               <div class="control-label col-md-9 col-sm-9 col-xs-12"  style="padding-right: 0px;">
                        <button type="submit" class="col-md-3 btn btn-default btn-success" style=" float: right;"  onclick="validateQuestionBeforeCreate(event,this)" id="createQForm" >Khởi tạo thuốc</button>
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
        swal("Sự kiện đã được tạo!", "", "error");
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
  