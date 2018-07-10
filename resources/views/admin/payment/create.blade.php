@extends('admin.master')
@section('content')
    <div class="content-wrapper" >
        <div class="box">

            <div class="panel panel-default" style="">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-sm-5" style="text-align: left">Chi Trả  </div>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <form action="{{route('create.payment')}}" method="post">
                            {{ csrf_field() }}
                            <label>Số Điện Thoại</label>
                            <input type="text" name="phone" class="form-control" placeholder="Số điên thoại bệnh nhân" value="{{old('phone')}}" />
                            <label>Số Tiền</label>
                            <input type="text" name="receive_money" class="form-control" value="{{old('receive_money')}}" />
                            <div class="row" style="margin-bottom: 1em;" >
                                <div class=""  style="margin-top: 1em;">
                                    <button type="submit" class="col-md-3 btn btn-default btn-success" style="margin-right: 10px;float: right;">Thanh Toán</button>
                                </div>
                            </div>
                        </form>

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
        $(document).ready(function() {
            <?php if (Session::has('error')): ?>
            swal("Không có số điện thoại này!", "", "error");
            <?php endif ?>
        });
    </script>
@endsection