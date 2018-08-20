@extends('admin.master')
@section('title', 'Chỉnh sửa bệnh tiền sử')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content">
            <div class="container"  >
                <div class="row" style="text-align: center;">
                    <label><h1>Chỉnh sửa Bệnh Tiền Sử</h1></label>
                </div>
                <form method ="post" class="form-horizontal" action="{{ route('admin.edit.anamnesis', ['id' => $AnamnesisCatalog->id]) }}" enctype="multipart/form-data" id="createNews">
                    {{ csrf_field() }}
                    <div class="row layout" style="margin-bottom: 1em;margin-right: 4em">
                        <div class="col-sm-3"><label>Tên bệnh </label></div>
                        <div class="col-sm-9" style="padding-right: 0;">
                            <input type="text" class="form-control input-width" id="name" name="name" placeholder="Input Title News" required="required" value="{{$AnamnesisCatalog->name}}" />
                        </div>
                    </div>
                    <div class="row layout"  style="margin-bottom: 1em;margin-right: 4em">
                        <div class="col-sm-3"><label>Miêu tả bệnh </label></div>
                        <div class="col-sm-9" style="padding-right: 0;">
                            <input type="text" class="form-control input-width" id="description" name="description" placeholder="Input Title News" required="required" value="{{$AnamnesisCatalog->description}}" />
                        </div>

                    </div>
                    <div class=""  style="margin-top: 1em;">
                        <button type="submit" class="col-md-3 btn btn-default btn-success" style="margin-right: 10px;float: right;"  onclick="validateQuestionBeforeCreate(event,this)" id="createQForm" >Chỉnh sửa</button>
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

            var name = document.getElementById('name').value;
            var description = document.getElementById('description').value;


            if($.trim(name) == ''){
                swal("Vui lòng điền tên bệnh!", "", "error");
            } else if($.trim(textarea) == ''){
                swal("Vui lòng thêm mô tả bệnh!", "", "error");
            }
            else{
                document.getElementById('createNews').submit();
            }
        }

    </script>
@endsection
