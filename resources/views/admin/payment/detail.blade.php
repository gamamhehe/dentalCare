@extends('admin.master')
@section('content')
    <div class="content-wrapper" >
        <div class="box">

            <div class="panel panel-default" style="">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-sm-5" style="text-align: left">Danh Sách Chi Trả Chi Tiết </div>
                         <a href="#" class="create-modal btn btn-success btn-sm">
                                        <i class="glyphicon glyphicon-plus">XXX</i>
                                    </a>
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
                                        <label class="control-label col-sm-2" for="title">Tên :</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="name" name="name"
                                                   placeholder="Your name Here" required>
                                            <p class="error text-center alert alert-danger hidden"></p>
                                        </div>
                                    </div>
                                 
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-warning" type="submit" id="add" onclick="save()" >
                                    <span class="glyphicon glyphicon-plus"></span>Save Post
                                </button>
                                <button class="btn btn-warning" type="button" data-dismiss="modal">
                                    <span class="glyphicon glyphicon-remobe"></span>Close
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label>Số điện thoại bệnh nhân: </label>
                        <span>{{$payment->phone}}</span>
                    </div>
                    <div class="form-group">
                        <label>Số tổng số tiền: </label>
                        <span>{{number_format($payment->total_price)}}</span>
                    </div>
                    <div class="form-group">
                        <label>Số tiền đã trả: </label>
                        <span>{{number_format($payment->paid)}}</span>
                    </div>
                    <div class="form-group">
                        <label>Trạng thái thanh toán: </label>
                        <span>
                            @if($payment->is_done == true)
                                <span style="text-align: center">Đã Hoàn Thành</span>
                            @else
                                <span style="text-align: center">Chưa Hoàn Thành</span>
                            @endif
                        </span>
                    </div>
                    <div class="form-group">
                        <label>Những liệu trình của chi trả: </label>
                        <span>
                            @foreach($payment->listTreatment as $treatment)
                                @if($loop->last)
                                    {{$treatment}}.
                                @else
                                    {{$treatment}},
                                @endif
                            @endforeach
                        </span>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered" style="text-align: center">
                            <thead>
                            <tr>
                                <th style="text-align: center; width: 30%">Nhân Viên Thu</th>
                                <th style="text-align: center; width: 30%">Số Tiền Nhận</th>
                                <th style="text-align: center; width: 20%">Ngày Trả</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if($listDetail)
                                @foreach($listDetail as $paymentDetail)
                                    <tr class="even gradeC" align="left">
                                        <td style="text-align: center">{{$paymentDetail->staff}}</td>
                                        <td style="text-align: center">{{number_format($paymentDetail->received_money)}}</td>
                                        <td style="text-align: center">{{$paymentDetail->date_create }}</td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="form-group">
                        @foreach($payment->updateList as $update)
                            <span>+ {{$update->update_information}}</span>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- </body>
    </html> -->
@endsection
@section('js')
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
         $(document).on('click','.create-modal', function() {
        $('#create').modal('show');
        $('.form-horizontal').show();
        $('.modal-title').text('Add Post');
    });
    </script>
@endsection