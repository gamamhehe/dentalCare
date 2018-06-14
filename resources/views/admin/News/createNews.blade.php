@extends('admin.master')
@section('content')
     <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content">
         <div class="container"  >
             <div class="row" style="text-align: center;">
                 <label><h1>Tạo bài viết</h1></label>
             </div>
             <form method ="post" class="form-horizontal" action="/create-News" enctype="multipart/form-data" id="createNews">
                  {{ csrf_field() }}
                   <div class="row" style="margin-bottom: 1em;">
                        
                            <div class="col-sm-2"><label>Title </label></div>
                            <div class="col-sm-10" style="padding-right: 0;">  
                              
                              <input type="text" class="form-control input-width" id="title" name="title" placeholder="Input Title News" required="required" />
                              
                            </div>
                        
                    </div>
                    <div class="row" style="margin-bottom: 1em;">
                    
                        <div class="col-sm-2"><label>Image Header </label></div>
                        <div class="col-sm-10">  
                            <div class="col-sm-10" style="padding-left: 0 " id="divan">  
                                <input id="thumbnail" class="form-control" type="text" name="image_header"  required="required" readonly="readonly"  >  
                                <!-- <label id="thumbnail"></label> -->
                            </div>
                            <div class="col-sm-2"> 
                            <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary" >
                               <i class="fa fa-picture-o"></i> Choose</a>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="margin-bottom: 1em;" >    
                    <div>   
                    <textarea id="tinyMCE" name="content" rows="10"                              
                              placeholder="Write your message.." s ></textarea></div>         
                 
                    <div class=""  style="margin-top: 1em;">
                        <button type="button" class="col-md-3 btn btn-default btn-success" style="margin-right: 10px;float: right;"  onclick="validateQuestionBeforeCreate(event,this)" id="createQForm" >Create Question</button>
                    </div>        
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
  