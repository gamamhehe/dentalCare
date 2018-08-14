@extends('admin.master')
@section('content')
    <div class="content-wrapper" >
        <div class="box">

            <div class="panel panel-default" style="">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-sm-5" style="text-align: left">Danh Sách tiền sử bệnh án</div>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label>Họ tên: </label>
                        <span>{{$treatmentHistory->patient->name}}</span>
                    </div>
                    <div class="form-group">
                        <label>Số điện thoại: </label>
                        <span>{{$treatmentHistory->patient->phone}}</span>
                    </div>
                    <div class="form-group">
                        <label>Liệu trình khám: </label>
                        <span>{{$treatmentHistory->treatment->name}}</span>
                    </div>
                    <div class="form-group">
                        <label>Chi trả: </label>
                        <span>
                            <a href="{{route('getPaymentDetail', ['idPayment' => $treatmentHistory->payment_id])}}">Chi Trả</a>
                        </span>
                    </div>
                    <div class="form-group">
                        <label>Miêu tả: </label>
                        <span>{{$treatmentHistory->description}}</span>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered" style="text-align: center">
                            <thead>
                            <tr>
                                <th style="text-align: center; width: 30%">Bước khám</th>
                                <th style="text-align: center; width: 30%">Ngày khám</th>
                                <th style="text-align: center; width: 20%">Ghi chú</th>
                                <th style="text-align: center; width: 20%">Tùy chọn</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($treatmentHistory->listDetail as $treatmentHistoryDetail)
                                    <tr class="even gradeC" align="left">
                                        <td style="text-align: center">
                                            @foreach($treatmentHistoryDetail->listStepDone as $step)
                                                @if($loop->last)
                                                    {{$step}}.
                                                @else
                                                    {{$step}},
                                                @endif
                                            @endforeach
                                        </td>
                                        <td style="text-align: center">{{$treatmentHistoryDetail->created_date}}</td>
                                        <td style="text-align: center">{{$treatmentHistoryDetail->note }}</td>
                                        <td style="text-align: center"> <a class="btn btn-success btn-sm" style="float: right;"
                                                                           href="/admin/treatment-detail/{{$treatmentHistoryDetail->id}}">Chi tiết</a></td>
                                    </tr>
                                @endforeach
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
@endsection