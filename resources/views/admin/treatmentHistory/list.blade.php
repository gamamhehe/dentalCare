@extends('admin.master')
@section('title', 'Lịch sử bệnh án bệnh nhân')
@section('content')
<div class="content-wrapper">
        <div class="box">
            <div class="panel panel-default" style="">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"  > <label><h3>Lịch sử bệnh án bệnh nhân </h3></label></div>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <input type="text" name="search" id="search" class="form-control" placeholder="Số điên thoại hoặc tên bệnh nhân" value="{{old('search')}}" />
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
                                <th style="text-align: center; width: 15%">Họ Tên</th>
                                <th style="text-align: center; width: 10%">Số điện thoại</th>
                                <th style="text-align: center; width: 25%">Liệu trình khám</th>
                                <th style="text-align: center; width: 5%">Răng</th>
                                <th style="text-align: center; width: 20%">Miêu tả</th>
                                <th style="text-align: center; width: 10%">Giá cả</th>
                                <th style="text-align: center; width: 15%">Tùy Chọn</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if($treatmentHistoryList)
                                @foreach($treatmentHistoryList as $treatmentHistory)
                                    <tr class="even gradeC" align="left">
                                        <td style="text-align: center">{{$treatmentHistory->patient->name}}</td>
                                        <td style="text-align: center">{{$treatmentHistory->patient->phone}}</td>
                                        <td style="text-align: center">{{$treatmentHistory->treatment->name}}</td>
                                        <td style="text-align: center">{{$treatmentHistory->tooth_number}}</td>
                                        <td style="text-align: center">{!!$treatmentHistory->description!!}</td>
                                        <td style="text-align: center">{{number_format($treatmentHistory->price)}} VNĐ</td>
                                        <td align="center">
                                            <div>
                                                <form action="{{route('gettreatmentHistoryDetail')}}">
                                                    {{ csrf_field() }}
                                                    <input type="hidden" name="idTreatmentHistory" value="{{$treatmentHistory->id}}">
                                                    <button type="submit" class="btn btn-default btn-success">Xem chi tiết
                                                    </button>
                                                </form>
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
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        function search(){

            $.ajax({
                url: '/admin/live_search/'+ searchValue, //this is your uri
                type: 'GET', //this is your method

                dataType: 'json',
                success: function(data){
                },error: function (data) {
                    swal('Error:',"", data);
                }
            });
        }

    </script>
@endsection