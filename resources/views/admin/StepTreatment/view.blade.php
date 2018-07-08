@extends('admin.master')
@section('content')
  <link rel="stylesheet" href="{{asset("/plugins/datepicker/datepicker3.css")}}">
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content">
            <div class=""  >
                <div class="row" style="text-align: center;">
                    <label><h1>STEP OR treatHis detail</h1></label>
                </div>

                <form method ="post" class="form-horizontal" action="create-Step" enctype="multipart/form-data" id="createAnamnesis">
                    {{ csrf_field() }}
                  <div class="row" >
                    <div class="col-sm-12">
                        <div class="col-sm-6">
                            @foreach($list as $one)
                            <div class="row" style="margin-bottom: 1em;border-bottom: 1px">
                                 <div class="col-sm-5" id="content">
                                     {{$one->name}}
                                 </div>
                                <div class="col-sm-4" style="padding-right: 0;">
                             <input type="checkbox" name="{{$one->id}}" checked data-toggle="toggle" data-size="mini" data-style="slow" data-onstyle="success" data-offstyle="danger" data-on="" data-off="">
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <div class="col-sm-6" >
                        <div class="row" style="height: 150px;max-height: 150px;">
                             <!-- ==== -->
      <div class="col-lg-3 col-sm-4 col-xs-6"><a title="Image 1" href="#"><img class="thumbnail img-responsive" src="//placehold.it/600x350"></a></div>
      <div class="col-lg-3 col-sm-4 col-xs-6"><a title="Image 2" href="#"><img class="thumbnail img-responsive" src="//placehold.it/600x350/2255EE"></a></div>
      <div class="col-lg-3 col-sm-4 col-xs-6"><a title="Image 3" href="#"><img class="thumbnail img-responsive" src="//placehold.it/600x350/449955/FFF"></a></div>
      <div class="col-lg-3 col-sm-4 col-xs-6"><a title="Image 4" href="#"><img class="thumbnail img-responsive" src="//placehold.it/600x350/992233"></a></div>
      <div class="col-lg-3 col-sm-4 col-xs-6"><a title="Image 5" href="#"><img class="thumbnail img-responsive" src="//placehold.it/600x350/2255EE"></a></div>
      <div class="col-lg-3 col-sm-4 col-xs-6"><a title="Image 6" href="#"><img class="thumbnail img-responsive" src="//placehold.it/600x350/449955/FFF"></a></div>
      <div class="col-lg-3 col-sm-4 col-xs-6"><a title="Image 8" href="#"><img class="thumbnail img-responsive" src="//placehold.it/600x350/777"></a></div>
      <div class="col-lg-3 col-sm-4 col-xs-6"><a title="Image 9" href="#"><img class="thumbnail img-responsive" src="//placehold.it/600x350/992233"></a></div>
      <div class="col-lg-3 col-sm-4 col-xs-6"><a title="Image 10" href="#"><img class="thumbnail img-responsive" src="//placehold.it/600x350/EEE"></a></div>
      <div class="col-lg-3 col-sm-4 col-xs-6"><a title="Image 11" href="#"><img class="thumbnail img-responsive" src="//placehold.it/600x350/449955/FFF"></a></div>
      <div class="col-lg-3 col-sm-4 col-xs-6"><a title="Image 12" href="#"><img class="thumbnail img-responsive" src="//placehold.it/600x350/DDD"></a></div>
      <div class="col-lg-3 col-sm-4 col-xs-6"><a title="Image 13" href="#"><img class="thumbnail img-responsive" src="//placehold.it/600x350/992233"></a></div>
                             <!-- ====== -->
                        
                        </div>


                        <div class="row"></div>
                            <div class="input-group">
                            <div class="box-body">
                    <label>Image</label>
                    <img id="holder" style="max-height:100px" name="holder" src="{{old('image')}}">
                    
                    <div class="input-group">
                        <input id="thumbnail" class="form-control" type="text" name="image"
                               value="{{old('image')}}">
                        <span class="input-group-btn">
                             <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary ">
                               <i class="fa fa-picture-o"></i> Choose</a>

                           </span>
                    </div>
                </div>
                            </div>
                        </div>
                    </div>
                  </div>
                   
                    
                    <div class="row" style="margin-bottom: 1em;">
                        <div class="col-sm-12">
                            <div class="col-sm-2"><label>Miêu tả bệnh </label></div>
                            <div class="col-sm-10" style="padding-right: 0;">
                            <textarea id="tinyMCE" name="description" rows="10"
                                  class="form-control"
                                  id="input"
                                  placeholder="Write your message..">{!!old('description')!!}</textarea>
                            </div>
                           </div>
                           

                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <button type="button" class="btn btn-success btn-dell">POPUP :)</button>
                        </div>
                        <div class="col-sm-7">
                            <button type="submit" class="col-md-3 btn btn-default btn-success" style="margin-right: 10px;float: right;"  onclick="validateQuestionBeforeCreate(event,this)" id="createQForm" >Tạo</button>
                        </div>
                    </div>
                    <div class=""  style="margin-top: 1em;">
                    </div>
                    <div>
                    </div>
                </form>
            </div>
<!-- popup -->
<div tabindex="-1" class="modal fade" id="myModal" role="dialog">
  <div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header">
        <button class="close" type="button" data-dismiss="modal">×</button>
        <h3 class="modal-title">Heading</h3>
    </div>
    <div class="modal-body">
        
    </div>
    <div class="modal-footer">
        <button class="btn btn-default" data-dismiss="modal">Close</button>
    </div>
   </div>
  </div>
</div>

<!-- endpopup -->
   

        </section>


    </div>
@endsection
@section('js')
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<script src="{{asset("/plugins/datepicker/bootstrap-datepicker.js")}}"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
 $(function () {
      $('#datepicker').datepicker({
      autoclose: true
    });
  });
        $(document).ready(function() {
                   $('.thumbnail').click(function(){
      $('.modal-body').empty();
    var title = $(this).parent('a').attr("title");
    $('.modal-title').html(title);
    $($(this).parents('div').html()).appendTo('.modal-body');
    $('#myModal').modal({show:true});
});
        });
        $('#lfm').filemanager('image');
        $(window).on('load', function () {
            $(document).ready(function () {
                var check  = document.getElementById('thumbnail').value;
                var div1  = document.getElementById('image1').value;
                if(check.length !=0){
                    alert("DKM");
                }
                alert( Page.initLFM());
                Page.initTinyMCE();
                Page.initLFM();

            });
        });
        $(document).on('click', '.btn-dell', function(e) {
        
          $('#create').modal('show');
                $('.form-horizontal').show();
                $('.modal-title').text('Add Post');
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
