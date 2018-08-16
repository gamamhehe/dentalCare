@extends('admin.master')
@section('title', 'Khởi tạo tin tức')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content">
        <div class="container"  >
            <div class="row" style="text-align: center;">
                <label><h1>Tạo Sự kiện</h1></label>
            </div>

            <form method ="post" class="form-horizontal" action="create-event" enctype="multipart/form-data" id="createNews">
                {{ csrf_field() }}
                <div class="row" style="margin-bottom: 1em;">
                    <div class="col-sm-2"><label>Tên sự kiện </label></div>
                    <div class="col-sm-10" style="padding-right: 0;">
                        <input type="text" class="form-control input-width" id="name" name="name" placeholder="Tên sự kiện" required="required" />
                    </div>
                </div>
                <div class="row" style="margin-bottom: 1em;">
                    <div class="col-sm-2"><label>Phần trăm giảm </label></div>
                    <div class="col-sm-10" style="padding-right: 0;">
                        <input type="text" class="form-control input-width" id="discount" name="discount" placeholder="Phần trăm giảm giá" required="required" />
                    </div>
                </div>
                <div class="row" style="margin-bottom: 1em;">
                    <div class="col-sm-2"><label>Dịch vụ </label></div>
                    <div class="col-sm-10" style="padding-right: 0;">
                        <select name="listTreatment" style="height: 2em;">
                           @foreach($listTreatment as $treatment)
                                <option value="{{$treatment->id}}" name="treat_id">{{$treatment->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row" style="margin-bottom: 1em;" >
                    <div class=""  style="margin-top: 1em;">
                        <button type="button" class="col-md-3 btn btn-default btn-success" style="margin-right: 10px;float: right;"  onclick="validateQuestionBeforeCreate(event,this)" id="createQForm" >Tạo sự kiện</button>
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
        swal("Sự kiện đa được tạo!", "", "error");
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
        var discount = document.getElementById('discount').value;

        if($.trim(name) == ''){
            swal("Vui lòng điền tên sự kiện!", "", "error");
        }else if($.trim(discount) == ''){
            swal("Vui lòng điền mức giảm giá!", "", "error");

        }
        else{
            document.getElementById('createNews').submit();
        }
    }

</script>
@endsection
  