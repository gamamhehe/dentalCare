@extends('admin.master')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content">
            <div class="container"  >
                <div class="row" style="text-align: center;">
                    <label><h1>STEP ???????</h1></label>
                </div>

                <form method ="post" class="form-horizontal" action="create-Anamnesis" enctype="multipart/form-data" id="createAnamnesis">
                    {{ csrf_field() }}
                    <div class="row" style="margin-bottom: 1em;">
                         
                        <div class="col-sm-12" style="padding-right: 0;">
                           <button class="btn-danger btn "> cc step</button>
                            <button class="btn-danger btn "> cc step</button>
                             <button class="btn-danger btn "> cc step</button>
                              <button class="btn-danger btn "> cc step</button>
                               <button class="btn-danger btn "> cc step</button>
                                <button class="btn-danger btn "> cc step</button>
                                 <button class="btn-danger btn "> cc step</button>

                        </div>
                    </div>
                    <div class="row" style="margin-bottom: 1em;">
                        <div class="col-sm-2"><label>Miêu tả bệnh </label></div>
                        <div class="col-sm-6" style="padding-right: 0;">
                        <textarea name="description" id="description" cols="80" rows="10"></textarea>
                        </div>
                        <div class="col-sm-2">
                                    <div class="input-group">
                                        <label class="input-group-btn">
                                            <span class="btn btn-default">
                                              <!--   フアイルを選択  -->
                                              <!--   <input type="file" style="display: none;" multiple name='file'> -->
                                                <input type="file" name="file">
                                            </span>
                                        </label>
                                     <!--    <input type="text" class="form-control" value="選択されていよせん" style="background: none; border: none" readonly> -->
                                    </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <button class="btn btn-success">POPUP :)</button>
                        </div>
                        <div class="col-sm-7">
                            <button type="button" class="col-md-3 btn btn-default btn-success" style="margin-right: 10px;float: right;"  onclick="validateQuestionBeforeCreate(event,this)" id="createQForm" >Tạo</button>
                        </div>
                    </div>
                    <div class=""  style="margin-top: 1em;">
                       
                    </div>
                    <div>
                        



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
