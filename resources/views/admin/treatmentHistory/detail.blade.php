@extends('admin.master')
@section('title', 'Danh sách lịch sử điều trị')
@section('content')
<div class="content-wrapper">
        <div class="box">

            <div class="panel panel-default" style="">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-sm-12" style="text-align: center;"><label><h3>Danh sách lịch sử bệnh án</h3></label></div>
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
                        <span>{!!$treatmentHistory->description !!}</span>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered" style="text-align: center">
                            <thead>
                            <tr>
                                <th class="col-lg-2 col-md-2 col-sm-2 col-xs-2" style="text-align: center">Bước khám</th>
                                <th class="col-lg-2 col-md-2 col-sm-2 col-xs-2" style="text-align: center">Ngày khám</th>
                                <th class="col-lg-2 col-md-2 col-sm-2 col-xs-2" style="text-align: center">Ghi chú</th>
                                <th class="col-lg-2 col-md-2 col-sm-2 col-xs-2" style="text-align: center">Tùy chọn</th>
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
                                        <td style="text-align: center"> <a class="btn btn-success btn-sm" 
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