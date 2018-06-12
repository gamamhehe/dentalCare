@extends('admin.master')
@section('content')
     <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content">
            <div class="row">
                <div  style="text-align: center;">
                    <label><h1>Tạo bài viết</h1></label>
                   <!--  <img id="holder" style="max-height:100px" name="holder" > -->
                   
                </div>
                <div>

                 <form method ="post" class="form-horizontal" action="/create-News" enctype="multipart/form-data">
                   {{ csrf_field() }}
                <div class="container">
                <div class="row">
                        <div style="margin-top: 1em;">
                            <div class="col-sm-2"><label>Title </label></div>
                            <div class="col-sm-10" style="padding-right: 0;">  
                              
                              <input type="text" class="form-control input-width" id="title" name="title" placeholder="Input Title News" required="required" />
                              
                            </div>
                        </div>
                    </div>
                <div class="row">
                    <div style="margin-top: 1em;">
                        <div class="col-sm-2"><label>Image Header </label></div>
                        <div class="col-sm-10">  
                            <div class="col-sm-1" style="padding-left: 0 " id="divan">  
                                <input id="thumbnail" class="form-control" type="text" name="image_header"  required="required" readonly="readonly"  >  
                                <!-- <label id="thumbnail"></label> -->
                            </div>
                            <div class="col-sm-2"> 
                            <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary" >
                               <i class="fa fa-picture-o"></i> Choose</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" style="">    
                    <div style="margin-top: 1em;">   <textarea id="tinyMCE" name="content" rows="10"
                              class="form-control"
                              
                              placeholder="Write your message.." style="max-width: 90px;" ></textarea></div>         
                 
                    <div class=""  style="margin-top: 1em;">
                        <button type="button" class="col-md-3 btn btn-default btn-success" style="margin-right: 10px;float: right;"  onclick="validateQuestionBeforeCreate(event,this)" id="createQForm" >Create Question</button>
                    </div>        
                  </div></div>
               
                
                    </form>
                </div>
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
        var title = document.getElementById('title').value;
        var img = document.getElementById('thumbnail').value;
        var textarea  = document.getElementById('tinyMCE').value;
        if(title.length==0){
             swal("Vui lòng điền tiêu đề!", "", "error");
        }else if(img.length==0){
         swal("Vui lòng chọn ảnh!", "", "error");
        }else if(textarea.length==0){
        swal("Vui lòng thêm chi tiết bảng tin!", "", "error");
        }else{
         swal("THanh cmn công!", "", "success");
        }
    }
          
    </script>
@endsection
  