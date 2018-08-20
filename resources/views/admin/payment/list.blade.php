@extends('admin.master')
@section('title', 'Danh sách chi trả')
@section('content')
    <div class="content-wrapper">
        <div class="box">

            <div class="panel panel-default" style="">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-sm-5" style="text-align: left">Danh Sách Chi Trả </div>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <input type="text" name="search" id="search" class="form-control"
                               placeholder="Số điên thoại bệnh nhân" value="{{old('search')}}"/>
                        <div class="row" style="margin-bottom: 1em;">
                            <div class="" style="margin-top: 1em;">
                                <button type="button" class="col-md-3 btn btn-default btn-success"
                                        style="margin-right: 10px;float: right;" onclick="search()">Tìm
                                </button>
                            </div>
                        </div>

                    </div>
                    <div id="create" class="modal fade" role="dialog">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title"></h4>
                                </div>
                                <div class="modal-body">
                                    <form class="form-horizontal" role="form">
                                        <div class="form-group row add">
                                            <label class="control-label col-sm-2" for="title">Số tiền :</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="name" name="name"
                                                       placeholder="Số tiền" required>
                                                <p class="error text-center alert alert-danger hidden"></p>
                                            </div>
                                        </div>

                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-warning" type="submit" id="add" onclick="save()">
                                        <span class="glyphicon"></span>Thanh toán
                                    </button>
                                    <button class="btn btn-warning" type="button" data-dismiss="modal">
                                        <span class="glyphicon glyphicon-remobe"></span>Đóng
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered Mytable-hover" style="text-align: center">
                            <thead>
                            <tr>
                                <th style="text-align: center; width: 20%">Số Điện Thoại</th>
                                <th style="text-align: center; width: 15%">Tổng Tiền</th>
                                <th style="text-align: center; width: 15%">Còn Thiếu</th>
                                <th style="text-align: center; width: 20%">Trạng Thái</th>
                                <th style="text-align: center; width: 40%">Tuỳ Chọn</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if($paymentList)
                                @foreach($paymentList as $payment)
                                    <tr class="even gradeC" align="left">
                                        <td style="text-align: center">{{$payment->phone}}</td>
                                        <td style="text-align: center">{{number_format($payment->total_price)}}</td>
                                        <td style="text-align: center">{{number_format($payment->total_price - $payment->paid) }}</td>
                                        @if($payment->status == true)
                                            <td style="text-align: center">Đã Hoàn Thành</td>
                                        @else
                                            <td style="text-align: center">Chưa Hoàn Thành</td>
                                        @endif
                                        <td align="center">
                                            <div>
                                                <form action="{{route('getPaymentDetail')}}">
                                                    {{ csrf_field() }}
                                                    <input type="hidden" name="idPayment" value="{{$payment->id}}">
                                                    <button type="submit" style="float: left;margin-right: 10px;" class="btn btn-default btn-success">Xem chi tiết Chi Trả
                                                    </button>
                                                </form>
                                                @if($payment->status == \App\Helpers\AppConst::PAYMENT_STATUS_NOT_DONE)

                                                        <input type="hidden" name="idPayment" value="{{$payment->id}}">
                                                    <a href="#" class="create-modal btn btn-success  ">
                                                         Tạo chi trả 
                                                    </a>

                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- </body>
    </html> -->
@endsection
@section('js')
    <link rel="stylesheet" href="/assets/user/css/mycss.css">
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        $(document).on('click', '.create-modal', function () {
            $('#create').modal('show');
            $('.form-horizontal').show();
            $('.modal-title').text('Chi trả');
        });

        function search() {

            var searchValue = document.getElementById('search').value;
            if (!searchValue) {
                swal("Nhập số điên thoại", "", "error");
                return;
            }
            $.ajax({
                url: '/admin/search-payment/' + searchValue, //this is your uri
                type: 'GET', //this is your method
                dataType: 'json',
                success: function (data) {
                    $('tbody').html(data.table_data);
                }, error: function (data) {
                    swal('Error:', "", "error");
                }
            });
        }
    </script>
@endsection