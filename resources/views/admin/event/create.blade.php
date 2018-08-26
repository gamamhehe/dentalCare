@extends('admin.master')
@section('title', 'Khởi tạo Sự kiện')
@section('content')
<div class="content-wrapper">
    <div class="box">
       <div class="panel panel-default" style="">
            <div class="panel-heading">
            <div class="row" style="text-align: center;">
                <label><h1>Tạo Sự kiện</h1></label>
            </div>
            </div>
            <div class="panel-body">
                <div class="modal-body">
            <form method ="post" class="form-horizontal" action="create-event" enctype="multipart/form-data" id="createNews">
                {{ csrf_field() }}
                <div class="form-group row add"  >
                    <div class="control-label col-md-3 col-sm-3 col-xs-12"><label>Tên sự kiện </label></div>
                        <div class="col-md-6 col-sm-6 col-xs-8" style="padding-right: 0;padding-left: 0;">
                        <input type="text" class="form-control input-width" id="name" name="name" placeholder="Tên sự kiện" required="required" />
                    </div>
                </div>
                 <div class="form-group row add"  >
                    <div class="control-label col-md-3 col-sm-3 col-xs-12"><label>Phần trăm giảm </label></div>
                    <div class="col-md-6 col-sm-6 col-xs-8" style="padding-right: 0;padding-left: 0;">
                        <input type="text" class="form-control input-width" id="discount" name="discount" placeholder="Phần trăm giảm giá" required="required" />
                    </div>
                </div>
                  <div class="form-group row add"  >
                    <div class="control-label col-md-3 col-sm-3 col-xs-12"><label>Dịch vụ </label></div>
                    <div class="col-md-6 col-sm-6 col-xs-8" style="padding-right: 0;padding-left: 0;">
                        <select name="listTreatment" class="selectSpecialTwo">
                           @foreach($listTreatment as $treatment)
                                <option value="{{$treatment->id}}" name="treat_id">{{$treatment->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                 <div class="form-group row add" >
                     <div class="control-label col-md-9 col-sm-9 col-xs-12"  style="padding-right: 0px;">
                        <button  type="button" class="col-md-3 btn btn-default btn-success" style="  float: right;"  onclick="validateQuestionBeforeCreate(event,this)" id="createQForm" >Tạo sự kiện</button>
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
  