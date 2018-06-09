@extends('admin.master')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content">
            <div class="row">
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
                <div class="form-group">
                <form action=""></form>
                    <label>Description</label>
                    <textarea id="tinyMCE" name="description" rows="10"
                              class="form-control"
                              id="input"
                              placeholder="Write your message..">{!!old('description')!!}</textarea>
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
