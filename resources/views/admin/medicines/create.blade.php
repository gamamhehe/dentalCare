@extends('admin.master')
@section('title', 'Khởi tạo Thuốc')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content">
        <div class="container"  >
            <div class="row" style="text-align: center;">
                <label><h1>Tạo Thuốc</h1></label>
            </div>

            <form method ="post" class="form-horizontal" action="create-medicines" enctype="multipart/form-data" id="createNews">
                {{ csrf_field() }}
                <div class="row" style="margin-bottom: 1em;">
                    <div class="col-sm-2"><label>Tên thuốc </label></div>
                    <div class="col-sm-10" style="padding-right: 0;">
                        <input type="text" class="form-control input-width" id="name" name="name" placeholder="Tên thuốc" required="required" />
                    </div>
                </div>
                <div class="row" style="margin-bottom: 1em;">
                    <div class="col-sm-2"><label>Cách sử dụng ( use ) </label></div>
                    <div class="col-sm-10" style="padding-right: 0;">
                        <input type="text" class="form-control input-width" id="use" name="use" placeholder="cách sử dụng" required="required" />
                    </div>
                </div>
                <div class="row" style="margin-bottom: 1em;">
                    <div class="col-sm-2"><label>Đặc tả </label></div>
                    <div class="col-sm-10" style="padding-right: 0;">
                        <input type="text" class="form-control input-width" id="description" name="description" placeholder="Đặc tả" required="required" />
                    </div>
                </div>

                <div class="row" style="margin-bottom: 1em;" >
                    <div class=""  style="margin-top: 1em;">
                        <button type="submit" class="col-md-3 btn btn-default btn-success" style="margin-right: 10px;float: right;"  onclick="validateQuestionBeforeCreate(event,this)" id="createQForm" >Khởi tạo thuốc</button>
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
  