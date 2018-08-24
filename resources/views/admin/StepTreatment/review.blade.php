@extends('admin.master')
@section('title', 'Chi tiết lần khám')
@section('content')
  <div class="content-wrapper">
            <div class="box" style="border: none">
               <div class="panel-heading" style="padding-bottom: 0px;border-bottom-width: 0px;padding-top: 0px;">
                       <div class="row" style="text-align: center;">
                        <label><h1 style="margin-bottom: 0px;">Xem lại chi tiết lần khám  </h1></label>
                       <div class="row img-center"><p><img class="img-center" src="https://vivaclinic.vn/wp-content/uploads/2017/09/SHARP-3.png" data-src="https://vivaclinic.vn/wp-content/uploads/2017/09/SHARP-3.png" width="196" height="50" alt=""></p></div>
                        </div>
                </div>
                <div class="panel-body" style="padding-top: 0px;">
                    <div class="form-group row"  >
                        <div class="col-sm-12">
                            <div class="col-sm-6">
                            <div class="row" style="color: green;text-align: center;border-bottom: 1px green solid;    margin-right: 1em"><h3>Các bước đã chọn để điều trị</h3></div>
                            <div class="row" style="margin-right: 2px;padding-bottom: 1em;margin-top: 1em;">
                                   @foreach($listStep as $one)
                                    <div class="form-group row" style="margin-bottom: 1em;border-bottom: 1px; ">
                                            <div class="col-md-7 col-sm-7 col-xs-12"  >
                                         {{$one->stepName->name}}
                                         
                                            </div>
                                        <div class="col-md-3 col-sm-3 col-xs-12" style="padding-right: 0; ">
                                            <input type="checkbox" checked data-toggle="toggle" disabled 
                                                   data-size="mini" data-style="slow" data-onstyle="success"
                                                   data-offstyle="danger" data-on="" data-off="">
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                             
                            </div>
                            <div class="col-sm-6">
                                    <div class="row" style="color: green;text-align: center;border-bottom: 1px green solid;"><h3>Hình Ảnh</h3></div>     

                                <div class="row" id="divImage" style="min-height: 200px;bpadding-bottom: 1em;margin-top: 1em;" >
                                @foreach($listImg as $img)
                            <div id="" class="col-lg-2 col-sm-2 col-xs-2">
                            <div class="" style="max-height: 150px;max-width: 100px;min-height: 150px;min-width: 100px;"> 
                            <img class="thumbnail img-responsive img-fruid" style=" display: block;margin-left: auto;    margin-right: auto;" src="{{$img->image_link}}">
                            </div>
                            </div>
                                @endforeach
                                </div>
                              
                            </div>
                        </div>
                    </div>
                     <div class="form-group row">
                        <div class="col-sm-4">
                            <button type="button" class="btn btn-success btn-medicine">Đơn Thuốc</button>
                        </div>
                        <div class="col-sm-7">
                        </div>
                    </div>
                    <div class="form-group row" style="margin-bottom: 1em;">
                        <div class="col-sm-12">
                            <div class="col-sm-2"><label>Miêu tả bệnh </label></div>
                            <div class="col-sm-10" style="padding-right: 0;">
                            <textarea id="tinyMCE" name="description" rows="9"
                                      class="form-control"
                                      id="input"
                                      placeholder="Write your message..">{{$treatmentDetail->note}}</textarea>
                            </div>
                        </div>
                    </div>
                   
                </div>
            </div>
                    {{ csrf_field() }}
                    
                    <div class="" style="margin-top: 1em;">
                    </div>
                    <div id="create" class="modal fade" role="dialog">
                    <div class="modal-dialog  ">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title"></h4>
                            </div>
                            <div class="modal-body" style="">
                                <div class="row" style="text-align: center;">
                        
                                <div class="panel-body col-xs-12" style="background-color: white;">
                                <div class="row" style="border-bottom: green 2px solid;">
                                    <label ><h1 style="text-align: center;font-family: 'Italianno', cursive;
                        font-size: 48px;">Đơn Thuốc</h1></label>
                                </div>
                                            <div class="row" style="margin-top:1em ">
                                                    <div class="col-xs-7">Tên thuốc</div>
                                                    <div class="col-xs-2">Số lượng</div>
                                            </div>
                                @foreach($listMedicine as $once)
                                <div class="row" > 
                                <div class="col-xs-7"> 
                                  <span>{{$once->medicineName->name}}</span>
                                </div> 
                                <div class="col-xs-3"> 
                                {{$once->quantity}} vien</div>
                                </div>
                                @endforeach
                                            <hr>
                                    </div>
                            </div>
                            </div>
                            
                        </div>
                    </div>
                    </div>
</div>
                    <!-- end popup -->
                    <input type="hidden" name="idTreatmentHistory" value="{{Request::get('idTreatmentHistory')}}">

@endsection
@section('js')
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        $(document).ready(function () {
        <?php if (session('message')=="success"): ?>
          swal("Tạo thành công!", "", "success");  
        <?php endif ?>
         <?php if (session('message')=="error"): ?>
          swal( "Lỗi ! Liệu trình chưa được tạo" , "", "error");  
        <?php endif ?>






            $('.thumbnail').click(function () {
                $('.modal-body').empty();
                var title = $(this).parent('a').attr("title");
                $('.modal-title').html(title);
                $($(this).parents('div').html()).appendTo('.modal-body');
                $('#myModal').modal({show: true});
            });
        });
        $('#lfm').filemanager('image');
        $(document).on('click', '.btn-dell', function (e) {

            $('#create').modal('show');
            $('.form-horizontal').show();
            $('.modal-title').text('Add Post');
        });

        function validateQuestionBeforeCreate(evt, sel) {
            // swal("Bài viết chưa được tạo!", "", "error");

            var name = document.getElementById('name').value;
            var description = document.getElementById('description').value;

            if ($.trim(name) == '') {
                swal("Vui lòng điền tiêu đề!", "", "error");
            } else if ($.trim(description) == '') {
                swal("Vui lòng chọn ảnh!", "", "error");

            } else {
                document.getElementById('createAnamnesis').submit();
            }
        }
         
         $(document).on('click','.btn-medicine', function() {
        $('#create').modal('show');
        $('.form-horizontal').show();
        $('.modal-title').text('Đơn thuốc');
    });
 
        
    </script>
@endsection
 