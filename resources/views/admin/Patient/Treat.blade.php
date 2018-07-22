@extends('admin.master')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
        <div class="panel panel-default" style="">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-sm-12" style="text-align: center;"><h1>Thông tin bệnh nhân</h1></div>
                        
                    </div>
                </div>
            </div>
        <div class="box box-info">
            <div class="box-header with-border box-info">
              <h3 class="box-title" style="float: left;">Thông tin bệnh nhân</h3>
            <button class="btn btn-success btn-sm" style="float: right;"> Tạo mới liệu trình</button>
            </div>
            <div class="panel-body">
                <div class="form-group row add">
                        <div class="col-sm-2"><label>Họ Tên</label></div> 
                        <div class="col-sm-6" style="padding-left: 0px;" >
                          <a href="admin/thong-tin-benh-nhan/{{$patient->id}}">{{$patient->name}}</a>
                        </div>
                </div> 
                  <div class="form-group row add">
                        <div class="col-sm-2"><label>Điện thoại</label></div> 
                        <div class="col-sm-4" style="padding-left: 0px;" >
                           <input type="text" value="{{$patient->phone}}" name="name" class="form-control pull-right" id="startdate" style="margin:0px;" disabled />
                        </div>
                </div> 
                <div class="form-group row add">
                        <div class="col-sm-2"><label>Bệnh tiền sử</label></div> 
                        <div class="col-sm-4" style="padding-left: 0px;" >
                           @foreach($patient->Anamnesis as $key)
                           <h5>{{$key->name->name}}</h5>
                           @endforeach
                        </div>
                       
                </div> 
                

            </div>
        </div>
       <!--  <div class="box box-info">
            <div class="box-header with-border box-info">
              <h3 class="box-title">Tiền sử bệnh án</h3>
            </div>
            <div class="panel-body">
                <div class="container">
                    <div class="row layout" style=" margin-right: 4em"  >
                    <table id="dup-table" class="table myTable table-bordered">
                        <thead>
                        <tr style="background-color: #eee;">
                            <td class="col-sm-1">id</td>
                            <td class="col-sm-6" style="text-align: left;">Tên Bệnh</td>
                            <td class="col-sm-3">Triệu chứng</td>
                        </tr>
                        </thead>
                    </table>
                </div> 
                </div>
            </div>
            
        </div> -->
        <div class="box box-info">
            <div class="box-header with-border box-info">
              <h3 class="box-title">Lịch sử bệnh án</h3>
            </div>
            <div class="panel-body">
                <!-- start -->
                <div class="container">
    <br />



    <br />

    <div class="panel-group" id="accordion">

        @if($listTreatmentHistory)
            @foreach($listTreatmentHistory as $treatmentHistory)
            <div class="panel panel-default">
            <div class="panel-heading">
            <h4 class="panel-title">
            <div class="container">
            <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse{{$treatmentHistory->treatment->id}}">{{$treatmentHistory->treatment->name}} </a>
            </div>
            <div class="container">
            <div class="col-sm-4">Giá           : {{$treatmentHistory->treatment->max_price}}  VNĐ</div>
            <div class="col-sm-4">Khuyến mãi    : 0%</div>
            <div class="col-sm-4">Còn lại       : {{$treatmentHistory->treatment->max_price}} VNĐ</div>
            <div class="col-sm-4">Răng          : {{$treatmentHistory->tooth->tooth_name}}</div>
            <div class="col-sm-4">Ngày bắt đầu  : {{$treatmentHistory->create_date}}</div>
            <div class="col-sm-4">Ngày kết thúc : 
            @if($treatmentHistory->finish_date)
            {{$treatmentHistory->finish_date}}
            @else
            <button class="btn btn-success btn-sm">SKIP</button>
            @endif
            </div>
            </div>
            </h4>
            </div>
            <div id="collapse{{$treatmentHistory->treatment->id}}" class="panel-collapse collapse in">
            <div class="panel-body">
                @foreach($treatmentHistory->details as $a)

                <div class="container" style="border: solid 1px grey;">
                <div class="row">
                <div class="col-sm-2">BÁC SĨ : </div>
                <div class="col-sm-8">{{$a->dentist->name}} </div>
                </div>
                <div class="row">
                <div class="col-sm-2">Ngày điều trị</div>
                <div class="col-sm-8">{{$a->create_date}} </div>
                </div>
                <div class="row">
                <div class="col-sm-2">Các bước đã thực hiện:</div>
                <div class="col-sm-8">
                    @foreach($a->treatment_detail_steps as $step)
                        <div class="row">
                            <div class="col-sm-8">+{{$step->step->name}} </div>
                        </div>
                    @endforeach
                </div>
                </div>
                <div class="row">
                <div class="col-sm-2">Toa thuốc</div>
                <div class="col-sm-8">
                giảm đau--------------------------30 viên <br>
                chóng sưng------------------------40 viên <br>
                aprical analink 500gram-----------40 viên <br>
                </div>
                </div>
                <div class="row" style="margin-top: 10px;">
                    @foreach($a->treatment_images as $b)
                        <div class="col-sm-4">
                            <img src="{{$b->image_link}}" alt="" class="img-responsive img-fluid">
                        </div>
                    @endforeach

                </div>
                </div>
                @endforeach


            </div>
            </div>

            </div>
            @endforeach
        @else
            <div class="container" style="background-color: whitesmoke;width: 100%;height: 200px;">
                    <h1 style="text-align: center;margin-top: 2em;">Bệnh nhân chưa từng điều trị</h1>
            </div>
        @endif








    </div>
</div>
                 <!-- end   -->
                
            </div>
        </div>
    </section>


</div>
@endsection
@section('js')
  <script src="https://datatables.yajrabox.com/js/datatables.bootstrap.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
    $(document).ready(function() {
        <?php if (Session::has('success')): ?>
        swal("Sự kiện đa được tạo!", "", "error");
        <?php endif ?>
     $("div.toolbar").html('<b>Custom tool bar! Text/images etc.</b>');
        function xxx(evt,sel){
            var check  = document.getElementById('thumbnail').value;
            if(check.length!= 0){
                swal("Hết nulll nhaaa!", "", "error");
            }
        }
    });
    
    $(function() {
            $('#dup-table').DataTable({
              "dom": '<"toolbar">frtip',
                language: {
            "lengthMenu": "Tổng kết quả Hiển thị _MENU_ ",
            "zeroRecords": "Không tìm thấy kết quả ",
            "info": "Hiển thị trang _PAGE_ trong tổng _PAGES_ trang",
            "infoEmpty": "Không có kết quả .",
            "infoFiltered": "(filtered from _MAX_ total records)",
            "search" : "Tìm kiếm ",
              "infoFiltered": "(Đã tìm từ _MAX_ kết quả)",

        },
                processing: true,
                serverSide: true,
                order: [[ 0, "desc" ]],
                bLengthChange:true,
                pageLength: 5,
                ajax: '/admin/get-list-anamnesis',
                columns : [

                    {data: 'id'},
                    {data: 'name'},
                    {

                        data: 'action'
                    },
                ],
            });
        });
    function validateQuestionBeforeCreate(evt,sel){
        // swal("Bài viết chưa được tạo!", "", "error");

        var name = document.getElementById('name').value;
        var discount = document.getElementById('discount').value;

        if($.trim(name) == ''){
            swal("Vui lòng điền tên sự kiện!", "", "error");
        }else if($.trim(discount) == ''){
            swal("Vui lòng điền mức giảm giá!", "", "error");

        }
        else{
            document.getElementById('createNews').submit();
        }
    }

</script>
@endsection
  