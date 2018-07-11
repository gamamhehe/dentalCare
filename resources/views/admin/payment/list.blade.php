@extends('admin.master')
@section('content')
    <div class="content-wrapper" >
        <div class="box">

            <div class="panel panel-default" style="">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-sm-5" style="text-align: left">Danh Sách Chi Trả  </div>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <input type="text" name="search" id="search" class="form-control" placeholder="Số điên thoại bệnh nhân" value="{{old('search')}}" />
                        <div class="row" style="margin-bottom: 1em;" >
                            <div class=""  style="margin-top: 1em;">
                                <button type="button" class="col-md-3 btn btn-default btn-success" style="margin-right: 10px;float: right;"  onclick="search()" >Tìm</button>
                            </div>
                        </div>

                    </div>


                    <div class="table-responsive">
                        <table class="table table-striped table-bordered" style="text-align: center">
                            <thead>
                            <tr>
                                <th style="text-align: center; width: 30%">Số Điện Thoại</th>
                                <th style="text-align: center; width: 30%">Tổng Tiền</th>
                                <th style="text-align: center; width: 20%">Đã Trả</th>
                                <th style="text-align: center; width: 20%">Trạng Thái</th>
                                <th style="text-align: center; width: 20%">Xem Chi Tiết</th>
                                <th style="text-align: center; width: 20%">Tạo Chi Trả</th>

                            </tr>
                            </thead>
                            <tbody>
                            @if($paymentList)
                                @foreach($paymentList as $payment)
                                    <tr class="even gradeC" align="left">
                                        <td style="text-align: center">{{$payment->phone}}</td>
                                        <td style="text-align: center">{{$payment->total_price}}</td>
                                        <td style="text-align: center">{{$payment->paid }}</td>
                                        @if($payment->is_done == true)

                                            <td style="text-align: center">Đã Hoàn Thành</td>
                                        @else
                                            <td style="text-align: center">Chưa Hoàn Thành</td>
                                        @endif
                                        <td align="center" style="width: 20%">
                                            <form action="{{route('getPaymentDetail')}}">
                                                {{ csrf_field() }}
                                                <input type="hidden" name="idPayment" value="{{$payment->id}}">
                                                <button type="submit" class="btn btn-default btn-success">Xem Chi Tiết Chi Trả</button>
                                            </form>
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
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>

        function search(){

            var searchValue = document.getElementById('search').value;
            if(!searchValue){
                swal("Nhập số điên thoại", "", "error");
                return;
            }
            $.ajax({
                url: '/admin/searchPayment/'+ searchValue, //this is your uri
                type: 'GET', //this is your method
                dataType: 'json',
                success: function(data){
                    $('tbody').html(data.table_data);
                },error: function (data) {
                    swal('Error:',"", "error");
                }
            });
        }
    </script>
@endsection