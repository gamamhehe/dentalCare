@extends('admin.master')
@section('title', 'Chỉnh sửa bệnh tiền sử')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="box">
            <div class="panel panel-default" style="">
                <div class="panel-heading">
                    <div class="row" style="text-align: center;">
                    <label><h1>Chỉnh sửa Bệnh Tiền Sử</h1></label>
                    </div>
                </div>
                <div class="panel-body">
                       <div class="modal-body">
                        <form method ="post" class="form-horizontal" action="{{ route('admin.edit.anamnesis', ['id' => $AnamnesisCatalog->id]) }}" enctype="multipart/form-data" id="createNews">
                    {{ csrf_field() }}
                     <div class="form-group row add"  >
                         <div class="control-label col-md-3 col-sm-3 col-xs-12"><label>Tên bệnh </label></div>
                        <div class="col-md-6 col-sm-6 col-xs-8" style="padding-right: 0;padding-left: 0;">
                            <input type="text" class="form-control input-width" id="name" name="name" placeholder="Input Title News" required="required" value="{{$AnamnesisCatalog->name}}" />
                        </div>
                    </div>
                   <div class="form-group row add"  >
                          <div class="control-label col-md-3 col-sm-3 col-xs-12"><label>Miêu tả bệnh </label></div>
                       <div class="col-md-6 col-sm-6 col-xs-8" style="padding-right: 0;padding-left: 0;">
                            <input type="text" class="form-control input-width" id="description" name="description" placeholder="Input Title News" required="required" value="{{$AnamnesisCatalog->description}}" />
                        </div>

                    </div>
                     <div class="form-group row add" >
           <div class="control-label col-md-9 col-sm-9 col-xs-12"  style="padding-right: 0px;">
                        <button type="submit" class="col-md-3 btn btn-default btn-success" style=" float: right;"  onclick="validateQuestionBeforeCreate(event,this)" id="createQForm" >Chỉnh sửa</button>
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
