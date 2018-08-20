@extends('admin.master')
@section('title', 'Khởi tạo đơn thuốc')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content">
            <div class="row" style="text-align: center;">
                <label><h1>Tạo Đơn Thuốc</h1></label>
            </div>
            <div class="row" style="text-align: center;">
                <div class="col-xs-6">
                      <div class="box"  style="border-top:green 3px solid">
                        <div>
                          <h3 class="box-title">Tìm Đơn Thuốc</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                           <div class="form-group">
                                    <input type="text" name="search" id="search" class="form-control" placeholder="Tên thuốc"/>
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
                      </div>
                </div>
                <div class="panel-body col-xs-6" style="background-color: white;border-top:green 3px solid">
                    <label><h1 style="text-align: center;font-family: 'Italianno', cursive;
    font-size: 48px;">Đơn Thuốc</h1></label>
                    <form action="{{ route('prescription') }}" class="form-horizontal" enctype="multipart/form-data">

                    <div style="background-color: white;border-top: green 2px solid;text-align: left;">
                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                        <div class="row">
                                <div class="col-xs-7">Tên thuốc</div>
                                <div class="col-xs-2">Số lượng</div>
                        </div>
                        <div id="prescription" style="">

                          
                        </div>
                        <hr>
                        <button class="btn btn-success" style="float: right" type="submit">Tạo</button>
                    </div>
                      
                        
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
        $('#search').on('keyup',function(){

            // $value=$(this).val();
            var searchValue = $(this).val();
            if (!searchValue) {
            //     swal("Nhập tên thuốc", "", "error");
                $('tbody').html('')
                return;
            }
            $.ajax({
                url: '/admin/medicine-search/' + searchValue, //this is your uri
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
        })

        function addToPrescription(name, id) {
            var prescription = document.getElementById('prescription').innerHTML;
            if (prescription != null) {
                prescription = prescription.toString()

                if (prescription.indexOf('value="' + id + '">') != -1) {
                    swal("Thuốc này đã tồn tại trong đơn thuốc", "", "error")
                    return
                }
            }
            document.getElementById('prescription').insertAdjacentHTML('beforeend', 
                " <div class='row' name='medicine'> <div class='col-xs-7'> <input type='hidden' name='medicine[]' value='" + id +
                "'><span>" + name + "</span></div> <div class='col-xs-3'> <input type='number' name='quantity[]' value='1' style='width:40px;border-radius:5px;border:1px green solid;'> vien</div></div>");
        }
    </script>
@endsection
 
                          
                   