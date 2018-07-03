@extends('admin.master')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content">
        <div class="container"  >
            <div class="row" style="text-align: center;">
                <label><h1>Khởi tạo liệu trình</h1></label>
            </div>

            <form method ="post" class="form-horizontal" action="create-Treatment" enctype="multipart/form-data" id="createNews">
                {{ csrf_field() }}
                <div class="row" style="margin-bottom: 1em;">
                    <div class="col-sm-2"><label>Tên liệu trình </label></div>
                    <div class="col-sm-10" style="padding-right: 0;">
                        <input type="text" class="form-control input-width" id="name" name="name" placeholder="Tên thuốc" required="required" />
                    </div>
                </div>
                <div class="row" style="margin-bottom: 1em;">
                    <div class="col-sm-2"><label>Mô tả </label></div>
                    <div class="col-sm-10" style="padding-right: 0;">
                        <input type="text" class="form-control input-width" id="description" name="description" placeholder="Đặc tả" required="required" />
                    </div>
                </div>
                <div class="row" style="margin-bottom: 1em;">
                    <div class="col-sm-2"><label>Loại liệu trình </label></div>
                    <div class="col-sm-10" style="padding-right: 0;">
                        <select name="TreatmentCate" style="height: 2em;">
                            @foreach($listTreatmentCategories as $TreatmentCategories)
                                <option value="{{$TreatmentCategories->id}}" name="treat_id">{{$TreatmentCategories->name}}</option>
                            @endforeach
                        </select>
                     </div>
                </div>
                <div class="row" style="margin-bottom: 1em;">
                    <div class="col-sm-2"><label>Giá điều trị </label></div>
                    <div class="col-sm-5" style="padding-right: 0;">
                        <input type="text" class="form-control input-width" id="max_price" name="max_price" placeholder="Giá thấp nhất" required="required" />
                    </div>
                    <div class="col-sm-5" style="padding-right: 0;">
                        <input type="text" class="form-control input-width" id="min_price" name="min_price" placeholder="Giá cao nhất" required="required" />
                    </div>
                </div>

                <div class="row" style="margin-bottom: 1em;" >
                    <div class=""  style="margin-top: 1em;">
                        <button type="submit" class="col-md-3 btn btn-default btn-success" style="margin-right: 10px;float: right;"  onclick="validateQuestionBeforeCreate(event,this)" id="createQForm" >Khởi tạo x liệu trình</button>
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
  