@extends('admin.master')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="container">
            <div class="row" style="text-align: center;">
                <label><h1>Tạo Đơn Thuốc</h1></label>
            </div>
            <div class="row" style="text-align: center;">
                <div class="panel-body col-md-6">
                    <div class="form-group">
                        <input type="text" name="search" id="search" class="form-control" placeholder="Tên thuốc"/>
                        <div class="row" style="margin-bottom: 1em;">
                            <div class="" style="margin-top: 1em;">
                                <button type="button" class="col-md-3 btn btn-default btn-success"
                                        style="margin-right: 10px;float: right;" onclick="search()">Tìm
                                </button>
                            </div>
                        </div>

                    </div>


                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>Tên thuốc</th>
                                <th>Công dụng</th>
                                <th>Thêm vào đơn thuốc</th>

                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="panel-body col-md-6" style="text-align: center;">
                    <label><h1>Đơn Thuốc</h1></label>
                    <form action="{{ route('prescription') }}" class="form-horizontal" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                        <div id="prescription">
                        </div>
                        <button type="submit">Tạo</button>
                    </form>
                </div>
            </div>
        </div>

    </div>

    </section>


    </div>
@endsection
@section('js')
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        function search() {

            var searchValue = document.getElementById('search').value;
            if (!searchValue) {
                swal("Nhập tên thuốc", "", "error");
                return;
            }
            $.ajax({
                url: '/admin/medicine_search/' + searchValue, //this is your uri
                type: 'GET', //this is your method

                dataType: 'json',
                success: function (data) {
                    $('tbody').html(data.table_data);

                    if (data.total_data == 0) {
                        swal("Không có loại thuốc này", "", "error");
                        $('#total_records').text(data.total_data);
                    }
                }, error: function (data) {
                    swal("Check connnection", "", "error");
                }
            });
        }

        function addToPrescription(name, id) {
            var prescription = document.getElementById('prescription').innerHTML;
            if (prescription != null) {
                prescription = prescription.toString()
                if (prescription.indexOf('value="' + id + '"') != -1) {
                    swal("Thuốc này đã tồn tại trong đơn thuốc", "", "error")
                    return
                }
            }
            document.getElementById('prescription').insertAdjacentHTML('beforeend', "<div name='medicine'><input type='hidden' name='medicine[]' value='" + id +
                "'><span>" + name + "</span><input type='number' name='quantity[]' value='1' style='width:40px'></div>");
        }
    </script>
@endsection
  