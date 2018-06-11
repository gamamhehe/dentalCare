@extends('admin.master')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content">
     
            <div class="row">
                <div class="box-body">
                    <label>Image-   @if(session('success'))
    <h1>{{session('success')}}</h1>
@endif</label>
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
                <div class="form-group">

                 <form method ="post" class="form-horizontal" action="/createNews">
                     <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                    <label>Description</label>
                    <textarea id="tinyMCE" name="description" rows="10"
                              class="form-control"
                              id="input"
                              placeholder="Write your message..">{!!old('description')!!}</textarea>
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
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        $(document).ready(function() {
          if
          swal("Good job!", "You clicked the button!", "success");  
        });
        $('#lfm').filemanager('image');
        $(window).on('load', function () {
            $(document).ready(function () {
                Page.initTinyMCE();
                Page.initLFM();
            });
        });
    </script>
@endsection
