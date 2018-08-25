@extends('admin.master')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    
        <div class="box">
        <div class="panel panel-default" style="">
            <div class="panel-heading">
                <div class="row" style="text-align: center;">
                <label><h1>Khởi tạo liệu trình</h1></label>
                </div>
            </div>
            <div class="panel-body">
               <div class="modal-body">
            <form method ="post" class="form-horizontal" action="create-treatment" enctype="multipart/form-data" id="createNews">
                {{ csrf_field() }}
               <div class="form-group row add"  >
                    <div class="control-label col-md-3 col-sm-3 col-xs-12"><label>Tên liệu trình </label></div>
                   <div class="col-md-6 col-sm-6 col-xs-8" style="padding-right: 0;padding-left: 0;">
                        <input type="text" class="form-control input-width" id="name" name="name" placeholder="Tên liệu trình" required="required" />
                    </div>
                </div>
                <div class="form-group row add"  >
                    <div class="control-label col-md-3 col-sm-3 col-xs-12"><label>Mô tả </label></div>
                   <div class="col-md-6 col-sm-6 col-xs-8" style="padding-right: 0;padding-left: 0;">
                        <input type="text" class="form-control input-width" id="description" name="description" placeholder="Mô tả" required="required" />
                    </div>
                </div>
               <div class="form-group row add"  >
                    <div class="control-label col-md-3 col-sm-3 col-xs-12"><label>Loại liệu trình </label></div>
                   <div class="col-md-6 col-sm-6 col-xs-8" style="padding-right: 0;padding-left: 0;">
                        <select name="TreatmentCate" id="TreatmentCate" style="height: 2em;">
                            @foreach($listTreatmentCategories as $TreatmentCategories)
                                <option value="{{$TreatmentCategories->id}}" name="treat_id">{{$TreatmentCategories->name}}</option>
                            @endforeach
                        </select>
                     </div>
                </div>
                 <div class="form-group row add"  >
                    <div class="control-label col-md-3 col-sm-3 col-xs-12"><label>Giá điều trị </label></div>
                      <div class="col-md-3 col-sm-3 col-xs-4" style="padding-right: 0;padding-left: 0;">
                        <input type="number" class="form-control input-width" id="min_price" name="min_price" placeholder="Giá thấp nhất" min="1" required="required" />
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-4" style="padding-right: 0;padding-left: 0;">
                        <input type="number" class="form-control input-width" id="max_price" name="max_price" placeholder="Giá cao nhất" min="1" required="required" />
                    </div>
                </div>

              
               <div class="form-group row add" >
               <div class="control-label col-md-9 col-sm-9 col-xs-12"  style="padding-right: 0px;">
                        <button type="button" class="col-md-3 btn btn-default btn-success" style=" float: right;"  onclick="validateQuestionBeforeCreate(event,this)" id="createQForm" >Khởi tạo liệu trình</button>
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
        swal("Liệu trình đã được tạo!", "", "error");
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
        var treatmentCate = document.getElementById('TreatmentCate').value;
        var description = document.getElementById('description').value;
        var max_price = document.getElementById('max_price').value;
        var min_price = document.getElementById('min_price').value;

        if($.trim(name) == ''){
            swal("Vui lòng điền tên liệu trình!", "", "error");
        }else if($.trim(description) == ''){
            swal("Vui lòng điền mô tả!", "", "error");

        }
        else if($.trim(treatmentCate) == ''){
            swal("Vui lòng chọn loại!", "", "error");

        }else if($.trim(min_price) == ''){
            swal("Vui lòng điền giá tối thiểu!", "", "error");

        }else if($.trim(max_price) == ''){
            swal("Vui lòng điền giá tối đa!", "", "error");

        }else if(min_price > max_price){
            swal("Vui lòng giá tối thiểu không được lớn hơn giá tối đa!", "", "error");

        }
        else{
            document.getElementById('createNews').submit();
        }
    }

</script>
@endsection
  