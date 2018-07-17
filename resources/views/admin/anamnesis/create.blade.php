@extends('admin.master')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content">
            <div class="container"  >
                <div class="row" style="text-align: center;">
                    <label><h1>Tạo Bệnh tiền sử</h1></label>
                </div>

                <form method ="post" class="form-horizontal" action="create-anamnesis" enctype="multipart/form-data" id="createAnamnesis">
                    {{ csrf_field() }}
                    <div class="row" style="margin-bottom: 1em;">
                        <div class="col-sm-2"><label>Tên bệnh </label></div>
                        <div class="col-sm-10" style="padding-right: 0;">
                            <input type="text" class="form-control input-width" id="name" name="name" placeholder="Input Title News" required="required" />
                        </div>

                    </div>
                    <div class="row" style="margin-bottom: 1em;">
                        <div class="col-sm-2"><label>Miêu tả bệnh </label></div>
                        <div class="col-sm-10" style="padding-right: 0;">
                            <input type="text" class="form-control input-width" id="description" name="description" placeholder="Input Title News" required="required" />
                        </div>

                    </div>
                    <div class=""  style="margin-top: 1em;">
                        <button type="button" class="col-md-3 btn btn-default btn-success" style="margin-right: 10px;float: right;"  onclick="validateQuestionBeforeCreate(event,this)">Tạo</button>
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
