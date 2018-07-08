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


        <form id="payment-form" role="form" action="{!! route('paypal') !!}" method="POST">
            {{ csrf_field() }}
            <input type="hidden" name="amount" value="200000">
            <input type="hidden" name="payment_id" value="1">
            <img src="/photos/shares/paypal_button.png" alt="" class="img-responsive img-fluid">
            <button type="submit">Paypal Payment</button>
        </form>

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
