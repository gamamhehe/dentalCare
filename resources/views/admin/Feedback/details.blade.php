@extends('admin.master')
@section('title', 'Chỉnh sửa đánh giá dịch vụ')
@section('content')
<div class="content-wrapper">
 <div class="box">
        <div class="panel panel-default" style="">
            <div class="panel-heading">
                <div class="row" style="text-align: center;">
                <label><h1>Chi tiết đánh giá</h1></label>
                </div>
            </div>
            <div class="panel-body">
                       <div class="modal-body">
                <form method ="post" class="form-horizontal" action="{{ route('admin.edit.feedback', ['id' =>$Feedback->id]) }}" enctype="multipart/form-data" id="createNews">
                    {{ csrf_field() }}
                    <div class="form-group row add"  >
                    <div class="control-label col-md-3 col-sm-3 col-xs-12"><label>ID </label></div>
                     <div class="col-md-6 col-sm-6 col-xs-8" style="padding-right: 0;padding-left: 0;">
                            <input type="text" class="form-control input-width" id="title" name="Feedback_id" placeholder="Input Title News" readonly="readonly" value="{{$Feedback->id}}" />
                        </div>
                    </div>
                   <div class="form-group row add"  >
                    <div class="control-label col-md-3 col-sm-3 col-xs-12"><label>Nha Sĩ chịu trách nhiệm </label></div>
                      <div class="col-md-6 col-sm-6 col-xs-8" style="padding-right: 0;padding-left: 0;">
                            <input type="text" class="form-control input-width" id="dentist_name" name="dentist_name" placeholder="Input Title News" readonly="readonly" value="{{$Feedback->treatment_detail->name}}" />
                        </div>
                    </div>
                     <div class="form-group row add"  >
                    <div class="control-label col-md-3 col-sm-3 col-xs-12"><label>Ngày tạo</label></div>
                        <div class="col-md-6 col-sm-6 col-xs-8" style="padding-right: 0;padding-left: 0;">
                            <input type="text" class="form-control input-width" id="date_feedback" name="date_feedback" placeholder="Input Title News" readonly="readonly" value="{{$Feedback->date_feedback}}" />
                        </div>
                    </div>
                    <div class="form-group row add"  >
                    <div class="control-label col-md-3 col-sm-3 col-xs-12"><label>Đánh giá</label></div>
                       <div class="col-md-6 col-sm-6 col-xs-8" style="padding-right: 0;padding-left: 0;">
                            @for( $x = 1; $x <= $Feedback->number_start; $x++)
                                {{--<input type="text" class="form-control input-width" id="title" name="title" placeholder="Input Title News" readonly="readonly" value="{{$Feedback->number_start}} sao" />--}}
                                <span style="height: 3px;width: 1.3em;">☆</span>
                            @endfor                        </div>
                    </div>
                    <div class="form-group row add"  >
                    <div class="control-label col-md-3 col-sm-3 col-xs-12"><label>Nội dung</label></div>

                        <div class="col-md-6 col-sm-6 col-xs-8" style="padding-right: 0;padding-left: 0;">
                            <div class="col-sm-12" style="padding-left: 0 " id="divan">
                                  <textarea rows="4" cols="50" style="width: 100%">
                                      {{$Feedback->content}}
                                    </textarea>
                            </div>
                        </div>

                    </div>
                    <div class=""  style="margin-top: 1em;padding-bottom: 5em;">
                        <button type="submit" class="col-md-3 btn btn-default btn-success" style="margin-right: 10px;float: right;"  onclick="validateQuestionBeforeCreate(event,this)" id="createQForm" >Hoàn tất</button>
                    </div>
                </form>
           </div>
                </div>
        </div>
        </div>
</div>
@endsection
@section('js')
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

  

   
@endsection
