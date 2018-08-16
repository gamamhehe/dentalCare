@extends('admin.master')
@section('title', 'Chỉnh sửa Sự kiện')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content">
        <div class="container"  >
            <div class="row" style="text-align: center;">
                <label><h1>Chỉnh sửa Sự kiện</h1></label>
            </div>
            <form method ="post" class="form-horizontal" action="{{ route('admin.edit.event', ['id' => $Event->id]) }}" enctype="multipart/form-data" id="createNews">
                {{ csrf_field() }}
                <div class="row layout" style="margin-bottom: 1em;margin-right: 4em">
                    <div class="col-sm-2"><label>Sự kiện </label></div>
                    <div class="col-sm-10" style="padding-right: 0;">
                        <input type="text" class="form-control input-width" id="name" name="name" placeholder="Tên sự kiện" required="required" value="{{$Event->name}}" />
                    </div>
                </div>
                <div class="row layout" style="margin-bottom: 1em;margin-right: 4em">
                    <div class="col-sm-2"><label>Phần trăm giảm </label></div>
                    <div class="col-sm-10" style="padding-right: 0;">
                        <input type="text" class="form-control input-width" id="discount" name="discount" placeholder="Input Title News" required="required" value="{{$Event->discount}}" />
                    </div>
                </div>
                <div class="row" style="margin-bottom: 1em;">
                    <div class="col-sm-2"><label>Dịch vụ </label></div>
                    <div class="col-sm-10" style="padding-right: 0;padding-left:0">
                        <select name="listTreatment" style="height: 2em;">
                            @foreach($listTreatment as $treatment)
                                <option value="{{$treatment->id}}" name="treat_id">{{$treatment->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row layout" style="margin-bottom: 1em;margin-right: 4em">
                    <div class="col-sm-2"><label>Ngày bắt đầu</label></div>
                    <div class="col-sm-10" style="padding-right: 0;">
                        <input type="text" class="form-control input-width" id="discount" name="discount" placeholder="Input Title News" required="required" value="{{$Event->start_date}}" />
                    </div>
                </div>
                <div class="row layout" style="margin-bottom: 1em;margin-right: 4em">
                    <div class="col-sm-2"><label>Ngày kết thúc </label></div>
                    <div class="col-sm-10" style="padding-right: 0;">
                        <input type="text" class="form-control input-width" id="discount" name="discount" placeholder="Input Title News" required="required" value="{{$Event->end_date}}" />
                    </div>
                </div>
                <div class="row layout" style="margin-bottom: 1em;margin-right: 4em">
                    <div class="col-sm-2"><label>Ngày khởi tạo </label></div>
                    <div class="col-sm-10" style="padding-right: 0;">
                        <input type="text" class="form-control input-width" id="discount" name="discount" placeholder="Input Title News" required="required" value="{{$Event->created_date}}" />
                    </div>
                </div>
                <div class="row layout" style="margin-bottom: 1em;margin-right: 4em" >

                    <div class=""  style="margin-top: 1em;padding-bottom: 5em;">
                        <button type="submit" class="col-md-3 btn btn-default btn-success" style="margin-right: 10px;float: right;"  onclick="validateQuestionBeforeCreate(event,this)" id="createQForm" >Hoàn tất chỉnh sửa</button>
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
  