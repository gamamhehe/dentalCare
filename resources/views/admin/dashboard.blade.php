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
                          <div class="col-sm-2"><label>Từ ngày </label></div>
                          <div class="col-sm-3 inputWithIcon" style="padding-right: 0;padding-left: 0;">
                          <input type="text" placeholder="Ngày bắt đầu" name="start_date" class="form-control pull-right" id="startdate" style="margin:0px;" />
                          <i class="fa fa-calendar"></i>
                          </div>
                          <div class="col-sm-2"><label>đến ngày</label></div>
                          <div class="col-sm-3 inputWithIcon" style="padding-right: 0;padding-left: 0;">
       <input type="text" placeholder="Ngày kết thúc" name="end_date" class="form-control pull-right" id="enddate" style="margin:0px;" />
   <i class="fa fa-calendar"></i>
                          </div>
                        </div>
                <div class="form-group">

                    <form method="post" class="form-horizontal" action="/createNews">
                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                        <label>Description <i class="fa fa-star text-yellow"></i></label>
                        <textarea id="tinyMCE" name="description" rows="10"
                                  class="form-control"
                                  id="input"
                                  placeholder="Write your message..">{!!old('description')!!}</textarea>
                        <div class="box-footer">
                            <button type="submit" class="col-md-3 btn btn-default btn-md" style="margin-right: 10px"
                                    onclick="checkValid">Create Question
                            </button>

                        </div>
                    </form>
                </div>
                <div class="form-group">
                    <form method="get" class="form-horizontal" action="{{route('testFunction')}}">
                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                        <input type="hidden" name="Absent[]" value="1">
                        <input type="hidden" name="Quantity[]" value="1">
                        <input type="text" name="Absent[]" value="2">
                        <input type="text" name="Absent[]" value="3">
                        <input type="text" name="Absent[]" value="4">
                        <label>Description</label>
                        <button type="submit" class="col-md-3 btn btn-default btn-md" style="margin-right: 10px"
                                onclick="checkValid">Create Question
                        </button>
                    </form>
                </div>
            </div>
        </section>
        {{--<section>--}}
        {{--<div id="paypal-button"></div>--}}
        {{--<script src="https://www.paypalobjects.com/api/checkout.js"></script>--}}
        {{--<script>--}}
        {{--paypal.Button.render({--}}
        {{--env: 'sandbox',--}}
        {{--client: {--}}
        {{--sandbox: 'Adlrxyv1TYdbEKdlmnMAl8Lp5dGzUqbddB36_9S8G9FI1BzBhKYloEc2cPnlfSZjL9qiViqQtgcvrqtt'--}}
        {{--},--}}
        {{--payment: function (data, actions) {--}}
        {{--return actions.payment.create({--}}
        {{--transactions: [{--}}
        {{--amount: {--}}
        {{--total: '100',--}}
        {{--currency: 'USD'--}}
        {{--}--}}
        {{--}]--}}
        {{--});--}}
        {{--},--}}
        {{--onAuthorize: function (data, actions) {--}}
        {{--return actions.payment.execute()--}}
        {{--.then(function () {--}}
        {{--window.alert('Thank you for your purchase!');--}}
        {{--});--}}
        {{--}--}}
        {{--}, '#paypal-button');--}}
        {{--</script>--}}
        {{--</section>--}}

    </div>
@endsection
@section('js')
<script src="https://datatables.yajrabox.com/js/datatables.bootstrap.js"></script>
 <link rel="stylesheet" href="/assets/user/css/mycss.css">
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
       
            $("#startdate").datepicker({
            startDate: 'd',
            autoclose: true,
            });
         

        });

    </script>
@endsection
