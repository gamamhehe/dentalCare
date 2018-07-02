@extends('admin.master')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content">
            <div class="container"  >
                <div class="row" style="text-align: center;">
                    <label><h1>Chi tiết Feedback</h1></label>
                </div>
                <form method ="post" class="form-horizontal" action="{{ route('admin.edit.news', ['id' => 7]) }}" enctype="multipart/form-data" id="createNews">
                    {{ csrf_field() }}
                    <div class="row layout" style="margin-bottom: 1em;margin-right: 4em">
                        <div class="col-sm-2"><label>ID </label></div>
                        <div class="col-sm-10" style="padding-right: 0;">
                            <input type="text" class="form-control input-width" id="title" name="title" placeholder="Input Title News" readonly="readonly" value="{{$Feedback->id}}" />
                        </div>
                    </div>
                    <div class="row layout" style="margin-bottom: 1em;margin-right: 4em">
                        <div class="col-sm-2"><label>Bác Sĩ chịu trách nhiệm </label></div>
                        <div class="col-sm-10" style="padding-right: 0;">
                            <input type="text" class="form-control input-width" id="title" name="title" placeholder="Input Title News" readonly="readonly" value="{{$Feedback->treatment_detail_id->name}}" />
                        </div>
                    </div>
                    <div class="row layout" style="margin-bottom: 1em;margin-right: 4em">
                        <div class="col-sm-2"><label>Ngày tạo</label></div>
                        <div class="col-sm-10" style="padding-right: 0;">
                            <input type="text" class="form-control input-width" id="title" name="title" placeholder="Input Title News" readonly="readonly" value="{{$Feedback->date_feedback}}" />
                        </div>
                    </div>
                    <div class="row layout" style="margin-bottom: 1em;margin-right: 4em">
                        <div class="col-sm-2"><label>Đánh giá</label></div>
                        <div class="col-sm-10" style="padding-right: 0;">
                            @for( $x = 1; $x <= $Feedback->number_start; $x++)
                            {{--<input type="text" class="form-control input-width" id="title" name="title" placeholder="Input Title News" readonly="readonly" value="{{$Feedback->number_start}} sao" />--}}
                                <span style="height: 3px;width: 1.3em;">☆</span>
                            @endfor
                        </div>
                    </div>
                    <div class="row layout" style="margin-bottom: 1em;margin-right: 4em">
                        <div class="col-sm-2"><label>Nội dung</label></div>
                        <input type="hidden" value="" name="News_id" />
                        <div class="col-sm-10">
                            <div class="col-sm-12" style="padding-left: 0 " id="divan">
                                 <textarea rows="4"  style="width:100%;" readonly="readonly">
                                     {{$Feedback->content}}</textarea>
                            </div>
                        </div>

                    </div>



                </form>
            </div>

        </section>



    </div>
@endsection
@section('js')
    {{--<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>--}}
    {{--<script>--}}
    {{--$(document).ready(function() {--}}
    {{--<?php if (Session::has('success')): ?>--}}
    {{--swal("Bài viết chưa được tạo!", "", "error");--}}
    {{--<?php endif ?>--}}

    {{--function xxx(evt,sel){--}}
    {{--var check  = document.getElementById('thumbnail').value;--}}
    {{--if(check.length!= 0){--}}
    {{--swal("Hết nulll nhaaa!", "", "error");--}}
    {{--}--}}
    {{--}--}}
    {{--});--}}
    {{--$('#lfm').filemanager('image');--}}
    {{--$(window).on('load', function () {--}}
    {{--$(document).ready(function () {--}}
    {{--var check  = document.getElementById('thumbnail').value;--}}
    {{--if(check.length !=0){--}}
    {{--}--}}
    {{--Page.initTinyMCE();--}}
    {{--Page.initLFM();--}}

    {{--});--}}
    {{--});--}}
    {{--function validateQuestionBeforeCreate(evt,sel){--}}

    {{--var title = document.getElementById('title').value;--}}
    {{--var img = document.getElementById('thumbnail').value;--}}

    {{--var textarea  =tinyMCE.get('tinyMCE').getContent({format: 'text'});--}}

    {{--if($.trim(title) == ''){--}}
    {{--swal("Vui lòng điền tiêu đề!", "", "error");--}}
    {{--}else if($.trim(img) == ''){--}}
    {{--swal("Vui lòng chọn ảnh!", "", "error");--}}

    {{--}else if($.trim(textarea) == ''){--}}
    {{--swal("Vui lòng thêm nội dung bài viết!", "", "error");--}}
    {{--}--}}
    {{--else{--}}
    {{--document.getElementById('createNews').submit();--}}
    {{--}--}}
    {{--}--}}

    {{--</script>--}}
@endsection