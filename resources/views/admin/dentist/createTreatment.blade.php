@extends('admin.master')
@section('title', 'Khởi tạo liệu trình')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content">
        <div class="container"  >
            <div class="row" style="text-align: center;">
                <label><h1>Khởi tạo liệu trình </h1></label>
            </div>

            <form method ="post" class="form-horizontal" action="{{ route('admin.createTreatmentHistoryPatient.dentist') }}" enctype="multipart/form-data" id="createTreat" >
                {{ csrf_field() }}
               
                <div class="row" style="margin-bottom: 1em;">
                    <div class="col-sm-2"><label>Loại răng </label></div>
                    <div class="col-sm-10" style="padding-right: 0;">
                        <select name="tooth_number" style="height: 2em;" >
                            @foreach($listTooth as $Tooth)
                                <option value="{{$Tooth->tooth_number}}" name="tooth_numberID">{{$Tooth->tooth_name}}</option>
                            @endforeach
                        </select>
                     </div>
                </div>
                <input type="hidden" name="patient_id" value="{{$patient_id}}">
                 <div class="row" style="margin-bottom: 1em;">
                    <div class="col-sm-2"><label>Ghi chú </label></div>
                    <div class="col-sm-10" style="padding-right: 0;">
                        <textarea id="tinyMCE" name="description" rows="7"
                                  class="form-control"
                                  id="input"
                                  placeholder="Write your message..">{!!old('description')!!}</textarea>
                        </textarea> 
                    </div>
                </div>
                <div class="row" style="margin-bottom: 1em;">
                    <div class="col-sm-2"><label>Loại liệu trình </label></div>
                    <div class="col-sm-5" style="padding-right: 0;">
                        <select name="TreatmentCate" style="height: 2em;min-width: 25em;" onchange="getTreat(this);" id="TreatmentCate" >
                        <option value="0" name="treat_id">Chọn liệu Trình</option>
                            @foreach($listTreatmentCategories as $TreatmentCategories)
                                <option value="{{$TreatmentCategories->id}}" name="treat_id">{{$TreatmentCategories->name}}</option>
                            @endforeach
                        </select>
                     </div>
                     <div class="col-sm-5" style="padding-right: 0;">
                        <select name="treatment_id" style="height: 2em;min-width: 25em;" onchange="getTreatPrice(this);" id="Treat">
                             
                        </select>
                     </div>
                     
                 </div>
                <div class="row" style="margin-bottom: 1em;">
                    <div class="col-sm-2"><label>Khung giá </label></div>
                   
                    <div class="col-sm-5" style="padding-right: 0;">
                        <input type="text" class="form-control input-width" id="min_price" name="min_price" placeholder="Giá thấp nhất " required="required" readonly="readonly" />
                    </div>
                     <div class="col-sm-5" style="padding-right: 0;">
                        <input type="text" class="form-control input-width" id="max_price" name="max_price" placeholder="Giá cao nhất " readonly="readonly" />

                    </div>
                </div>
                <div class="row" style="margin-bottom: 1em;">
                    <div class="col-sm-2"><label>Giá dịch vụ </label></div>
                    <div class="col-sm-5" style="padding-right: 0;">
                        <input type="number" class="form-control input-width" id="price" name="price" placeholder="Giá dịch vụ" required="required"   />
                    </div>
                </div>
                <div class="row" style="margin-bottom: 1em;" >
                    <div class=""  style="margin-top: 1em;">
                        <button type="button" class="col-md-3 btn btn-default btn-success" style="margin-right: 10px;float: right;"  onclick="validateQuestionBeforeCreate(event,this)" id="createQForm" >Khởi tạo liệu trình</button>
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
   $('#lfm').filemanager('image');
        $(window).on('load', function () {
            $(document).ready(function () {
                Page.initTinyMCE();
                Page.initLFM();
            });
        });

    $(document).ready(function() {
    getTreat(sel);
       <?php if (Session::has('success')): ?>
     swal("{{ Session::get('success')}}", "", "success");
        <?php endif ?>   
    });
    function getTreat(sel)
    {
    var treatCateID = sel.value;
     $("#max_price").val();
            $.ajax({
             url: '/admin/get-treatment-by-cate/'+treatCateID, //this is your uri
            type: 'GET', //this is your method
            dataType: 'json',
            success: function(data){
                if(data.length == 0){
                    $('#Treat')
                    .find('option')
                    .remove()
                    .end()
                    .append('<option value="whatever">Chưa có dịch vụ</option>')
                    .val('whatever')
                ;
            }else{
                $('#Treat')
                    .find('option')
                    .remove()
                    .end()
                ;
                for (var i = 0; i < data.length; i++) {
                   $('#Treat').append("<option value="+data[i].id+" data-min="+data[i].min_price+" data-max="+data[i].max_price+">"+data[i].name+"</option>");
                    var min = data[i].min_price;
                      var max = data[i].max_price;
                     $('#min_price').val(min);
                     $('#price').val(min);
                      $('#max_price').val(max);
                }
            }
            },error: function(obj,text,error) {
                 $('#Treat')
                    .find('option')
                    .remove()
                    .end()
                    .append('<option value="whatever">Chưa có dịch vụ</option>')
                    .val('whatever')
                ;
                  alert( showNotice("error",obj.responseText));
                },
            });
    }
     function getTreatPrice(sel)
    {
       var max = $('#Treat').find(':selected').attr('data-max');
        var min = $('#Treat').find(':selected').attr('data-min');
        $('#min_price').val(min);
          $('#price').val(min);
        $('#max_price').val(max);
         
    }
    function validateQuestionBeforeCreate(evt,sel){
        // swal("Bài viết chưa được tạo!", "", "error");
 var conceptName = $('#TreatmentCate').find(":selected").val();
 var price = document.getElementById('price').value;
 if(conceptName == 0){
     swal("Hãy chọn liệu trình !", "", "error");
 }
 else if($.trim(price) == ''){
            swal("Hãy điền chi phí liệu trình!", "", "error");

        }else{
     document.getElementById('createTreat').submit();
 }

        // var name = document.getElementById('name').value;
        // var use = document.getElementById('discount').value;
        // var description = document.getElementById('description').value;

        // if($.trim(name) == ''){
        //     swal("Vui lòng điền tên thuốc!", "", "error");
        // }
        // else if($.trim(use) == ''){
        //     swal("Vui lòng điền cách sử dụng!", "", "error");

        // }else if($.trim(description) == ''){
        //     swal("Vui lòng điền đặc tả!", "", "error");

        // }
        // else{
        //     document.getElementById('createNews').submit();
        // }
    }

</script>
@endsection
  