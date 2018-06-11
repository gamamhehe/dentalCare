@extends('admin.master')
@section('content')
     <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content">
            <div class="row">
                <div class="box-body">
                    <label>Image    @if(session('success'))
    <h1>{{session('success')}}</h1>
@endif</label>
                   <!--  <img id="holder" style="max-height:100px" name="holder" > -->
                   
                </div>
                <div class="form-group">

                 <form method ="post" class="form-horizontal" action="/createNews" enctype="multipart/form-data">
                   {{ csrf_field() }}
                   
                    <div class="input-group">
                   
                   
                    </div>
                <div class="row">
                <div>
                <div class="col-sm-3"><label>Title </label></div>
                <div class="col-sm-8">  
                  <div class="col-sm-10"><input type="text" class="form-control input-width" name="title" placeholder="Input Title News" required="required" /></div>
                </div>
                </div>
                </div>
                <div class="row">
                <div>
                <div class="col-sm-3"><label>Image Header </label></div>
                <div class="col-sm-8">  
                        <div class="col-sm-10">  <input id="thumbnail" class="form-control" type="text" name="image_header"  required="required">  </div>
                        <div class="col-sm-2"> <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary ">
                               <i class="fa fa-picture-o"></i> Choose</a></div>
                </div>
                </div>
                </div>
                             
                    <textarea id="tinyMCE" name="content" rows="10"
                              class="form-control"
                              id="input"
                              placeholder="Write your message.."  ></textarea>
                    <div class="box-footer">
                        <button type="submit" class="col-md-3 btn btn-default btn-md" style="margin-right: 10px" onclick="checkValid">Create Question</button>
                    </div>          
                    </form>
                </div>
            </div>
        </section>
    </div>
@endsection
@section('js')
    <script>
        $('#lfm').filemanager('image');
        $(window).on('load', function () {
            $(document).ready(function () {
                Page.initTinyMCE();
                Page.initLFM();
            });
        });
    </script>
@endsection
  