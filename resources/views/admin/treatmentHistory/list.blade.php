@extends('admin.master')
@section('title', 'Lịch sử bệnh án bệnh nhân')
@section('content')
    <div class="content-wrapper">
        <div class="box">
            <div class="panel panel-default" style="">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="text-align: center;"><label><h3>Lịch sử bệnh án bệnh nhân </h3>
                            </label></div>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <input type="text" name="search" id="search" class="form-control"
                               placeholder="Số điên thoại hoặc tên bệnh nhân" value="{{old('search')}}"/>
                    </div>


                    <div class="table-responsive">
                        <table class="Mytable-hover table table-striped table-bordered" style="text-align: center">
                            <thead>
                            <tr>
                                <th class="col-lg-2 col-md-2 col-sm-2 col-xs-2" style="text-align: center">Họ Tên</th>
                                <th class="col-lg-2 col-md-2 col-sm-2 col-xs-2" style="text-align: center">Số điện thoại</th>
                                <th class="col-lg-2 col-md-2 col-sm-2 col-xs-2" style="text-align: center">Liệu trình khám</th>
                                <th class="col-lg-2 col-md-2 col-sm-2 col-xs-2" style="text-align: center">Số Răng</th>
                               
                                <th class="col-lg-2 col-md-2 col-sm-2 col-xs-2" style="text-align: center">Giá cả</th>
                                <th class="col-lg-1 col-md-1 col-sm-1 col-xs-1" style="text-align: center">Tùy Chọn</th>
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
                                       
                                        <td style="text-align: center">{{number_format($treatmentHistory->price)}}VNĐ
                                        </td>
                                        <td align="center">
                                            <div>
                                                <form action="{{route('gettreatmentHistoryDetail')}}">
                                                    {{ csrf_field() }}
                                                    <input type="hidden" name="idTreatmentHistory"
                                                           value="{{$treatmentHistory->id}}">
                                                    <button type="submit" class="btn btn-default btn-info">Xem chi
                                                        tiết
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
        $('#search').on('keyup', function () {
            var searchValue = document.getElementById('search').value;
            if (searchValue) {
                $.ajax({
                        url: '/admin/search-treatment-history/' + searchValue, //this is your uri
                        type: 'GET', //this is your method
                        dataType: 'json',
                        success: function (data) {
                            $('tbody').html(data.table_data);
                        }, error: function (data) {
                            swal('Error:', "", "error");
                        }
                    }
                )
            }
        })

    </script>
@endsection