@extends('admin.master')
@section('title', 'Khởi tạo tin tức')
@section('content')
<div class="content-wrapper">
        <!-- Content Header (Page header) -->
      <div class="box">
        <div class="panel panel-default" style="">
            <div class="panel-heading">
                <div class="row" style="text-align: center;">
                <label><h1>Tạo Tin Tức</h1></label>
                </div>
            </div>
            <div class="panel-body">
                <div class="modal-body">
                      <form method ="post" class="form-horizontal" action="create-news" enctype="multipart/form-data" id="createNews">
                  {{ csrf_field() }}
                   <div class="form-group row add"  >
                      <div class="control-label col-md-2 col-sm-2 col-xs-12"><label>Tiêu đề</label></div>
                            <div class="col-md-8 col-sm-8 col-xs-12" style="padding-right: 0;padding-left: 0;">
                              <input type="text" class="form-control input-width" id="title" name="title" placeholder="Input Title News" required="required" />
                            </div>
                    </div>
                    <div class="form-group row add"  >
                      <div class="control-label col-md-2 col-sm-2 col-xs-12"><label>Ảnh tiêu đề</label></div>
                             <div class="col-md-8 col-sm-8 col-xs-12" style="padding-right: 0;padding-left: 0;">
                                <input id="thumbnail" class="form-control" type="text" name="image_header"  required="required" readonly="readonly"  >  
                            </div>
                            <div class="col-sm-2"> 
                            <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary" >
                               <i class="fa fa-picture-o"></i> Chọn ảnh</a>
                            </div>
                    </div>
                    <div class="form-group row add"  >
                       <div class="control-label col-md-2 col-sm-2 col-xs-12"><label>Nội dung </label></div>
                       <div class="col-md-10 col-sm-10 col-xs-12" style="padding-right: 0;padding-left: 0;">
                    <textarea id="tinyMCE" name="content" rows="10"                         
                              placeholder="Write your message.." s ></textarea></div>         
                    </div>
                 <div class="form-group row add" >
               <div class="control-label col-md-12 col-sm-12 col-xs-12"  style="padding-right: 0px;">
                         <button type="button" class="col-md-3 btn btn-default btn-success" style="margin-right: 10px;float: right;"  onclick="validateQuestionBeforeCreate(event,this)" id="createQForm" >Tạo câu hỏi</button>
                     </div></div> 

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
            swal("Không còn trống!", "", "error");  
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
  