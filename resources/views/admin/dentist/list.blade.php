@extends('admin.master')
@section('title', 'Quản lí nhân sự')
@section('content')
<div class="content-wrapper">
   <div class="box">
        <div class="panel panel-default" style="">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="text-align: center;"><h3>Danh sách nhân viên</h3></div>
                </div>
            </div>
            <div class="panel-body">
            <div class="row " style="text-align: center; margin-right: 4em">
                    <a href="#" class="btn btn-success create-modal " style="float:right; ">  Thêm mới</a>
                    </div>
                   <div class="">
                    <table id="dup-table" class="table myTable table-bordered Mytable-hover">
                        <thead>
                          <tr style="height: 1.3em;">
                            <td class="col-sm-1">STT</td>
                            <td class="col-sm-6" style="text-align: left;">Họ và tên</td>
                            <td class="col-sm-3" style="text-align: left;">Chức vụ</td>
                            <td class="col-sm-3">Lựa chọn</td>
                        </tr>
                        </thead>
                    </table> 
                    </div>
            </div>
        </div>

    </div>
<div class=""  >
<div id="create" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" role="form">
                        <div class="col-md-12"> 
                           <div class="col-md-3 col-sm-3 col-xs-12"><label class="control-label  " for="title">Họ tên</label></div>
                            <div class="col-md-9 col-sm-9  col-xs-12">
                                <input type="text" class="form-control" id="nameC" name="nameC"
                                placeholder="Họ và tên" required  >
                                <p class="error text-center alert alert-danger hidden"></p>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="col-md-3 col-sm-3 col-xs-4"> <label class="control-label  " for="body">Vai trò</label>
                             </div>
                             <div class="col-md-8 col-sm-8 col-xs-8">
                                <select name="roleC" id="roleC" class="selectSpecialTwo col-sm-8 col-xs-12">
                                    @foreach($roles as $role)
                                    <option value="{{$role->id}}">{{$role->name}}</option>
                                    @endforeach
                                </select>
                                <p class="error text-center alert alert-danger hidden"></p>
                            </div>
                                <div class="col-md-3 col-sm-3 col-xs-4">
                                  <label class="control-label  " for="body">Giới tính</label>
                                </div>
                                <div class="col-md-8 col-sm-8 col-xs-8">
                                    <select name="genderC" id="genderC" class="selectSpecialTwo col-sm-8 col-xs-12">
                                        <option value="Nam">Nam</option>
                                        <option value="Nữ">Nữ</option>
                                        <option value="Khác">Khác</option>
                                    </select>
                                </div>
                        </div>
                        <div class="col-md-12">
                           <div class="col-md-3 col-sm-3 col-xs-12"><label class="control-label  " for="body">Số điện thoại</label></div>
                           <div class="col-md-9 col-sm-9  col-xs-12">
                            <input type="text" class="form-control" id="phoneC" name="phoneC"
                            placeholder="Số điện thoại" required>
                            <p class="error text-center alert alert-danger hidden"></p>
                            </div>
                        </div>
                        <div class="col-md-12">
                           <div class="col-md-3 col-sm-3 col-xs-12"><label class="control-label  " for="body">Ngày sinh</label></div>
                           <div class="col-md-9 col-sm-9  col-xs-12">
                            <div class="inputWithIcon" style="padding-right: 0;padding-left: 0;">
                                      <input type="text" placeholder="Ngày sinh" id="bdayC" class="form-control pull-right" style="margin:0px;" />
                                      <i class="fa fa-calendar"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                           <div class="col-md-3 col-sm-3 col-xs-12"><label class="control-label  " for="body">Email</label></div>
                           <div class="col-md-9 col-sm-9  col-xs-12">
                            <input type="text" class="form-control" id="emailC" name="emailC"
                            placeholder="Email" required >
                            <p class="error text-center alert alert-danger hidden"></p>
                            </div>
                        </div>
                        <div class="col-md-12">
                           <div class="col-md-3 col-sm-3 col-xs-12">   
                            <label class="control-label" for="body">Địa chỉ</label>
                            </div>
                            <div class="col-md-9 col-sm-9  col-xs-12">
                            <input type="text" class="form-control" id="addressC" name="addressC"
                            placeholder="Địa  chỉ" required>
                            <p class="error text-center alert alert-danger hidden"></p>
                            </div>
                        </div>
                        <div class="col-md-12" style="padding-bottom: 5px;">
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">  
                            <label class="control-label"  for="body">Thành phố </label>
                            </div>
                            <div class="col-lg-9 col-md-7 col-sm-9  col-xs-12">
                                <select name="cityPatientC" id="cityPatientC"  style="margin: 0px; "
                                onchange="disctrict(this)" class="selectSpecialTwo col-lg-9 col-sm-9 col-md-7 col-xs-12" >
                                @foreach($citys as $city)
                                <option value="{{$city->id}}">{{$city->name}}</option>
                                @endforeach
                            </select>
                            </div>
                        </div>
                        <div class="col-md-12" style="padding-bottom: 5px;">
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">  
                            <label class="control-label"  for="body">Quận</label>
                            </div>
                            <div class="col-lg-9 col-md-7 col-sm-9  col-xs-12">
                                <select name="districtsPatientC" id="districtsPatientC" class="selectSpecialTwo col-lg-9 col-sm-9 col-md-7 col-xs-12"  style="margin: 0px; ">
                                    @foreach($District as $one)
                                    <option value="{{$one->id}}">{{$one->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="col-md-3 col-sm-3 col-xs-6">  
                                    <label class="control-label"  for="body">Bằng cấp</label>
                                    </div>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="degreeC" name="degreeC"
                                placeholder="Bằng cấp" >
                                <p class="error text-center alert alert-danger hidden"></p>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="col-md-3 col-sm-3 col-xs-6">  
                                    <label class="control-label"  for="body">Ghi chú</label>
                            </div>
                            <div class="col-sm-9">
                                <textarea  id="description" style="width: 100%;resize: none;" rows="3" > </textarea>  
                                <p class="error text-center alert alert-danger hidden"></p>
                            </div>
                        </div>
                        <div class="form-group">
                         <div class="col-lg-12">
                        </div>
                        </div>
                    </form>
                </div>
            <div class="modal-footer">
                <button class="btn btn-warning" type="button" id="addStaff"   >
                    <span class="glyphicon glyphicon-plus"></span>Khởi tạo
                </button>
            </div>
            </div>
        </div>
</div>



<div id="edit" class="modal fade" role="dialog">
<div class="modal-dialog modal-md">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title"></h4>
        </div>
        <div class="modal-body">
            <form class="form-horizontal" role="form">
                <div class="form-group row add">
                    <label class="control-label col-sm-3" for="title">Tên</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="nameE" name="nameE"
                        placeholder="Họ và tên" required>
                        <p class="error text-center alert alert-danger hidden"></p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-3" for="body">Địa chỉ</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="addressE" name="addressE"
                        placeholder="Địa  chỉ" required>
                        <p class="error text-center alert alert-danger hidden"></p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-3" for="body">Ngày Sinh</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="date_of_birthE" name="date_of_birthE"
                         disabled>
                        <p class="error text-center alert alert-danger hidden"></p>
                    </div>
                </div>
                 
                <input type="hidden" id="idE" name="idE">
                <div class="form-group">
                    <label class="control-label col-sm-3" for="body">Số điện thoại</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="phoneE" name="phoneE"
                        placeholder="Số điện thoại"  disabled>
                        <p class="error text-center alert alert-danger hidden"></p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-3" for="body">Giới tính</label>
                    <div class="col-sm-4">
                        <select name="gender" id="sexE" class="selectSpecialTwo">
                            <option value="Male">Nam</option>
                            <option value="Female">Nữ</option>
                            <option value="Option">Khác</option>
                        </select>
                        <p class="error text-center alert alert-danger hidden"></p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-3" for="body">Vai trò</label>
                    <div class="col-sm-4">
                        <select name="roleE" id="roleE" class="selectSpecialTwo">
                            @foreach($roles as $role)
                            <option value="{{$role->id}}">{{$role->name}}</option>
                            @endforeach
                        </select>
                        <p class="error text-center alert alert-danger hidden"></p>
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button class="btn btn-warning" type="submit" id="updateStaff" >
                <span class="glyphicon glyphicon-plus"></span>Hoàn tất chỉnh sửa
            </button>
            <button class="btn btn-warning" type="button" data-dismiss="modal">
                <span class="glyphicon glyphicon-remobe"></span>Đóng
            </button>
        </div>
    </div>
</div>
</div>
</div>
{{-- Modal Form Show POST --}}
<div id="show" class="modal fade" role="dialog">
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title"></h4>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <label for="">ID:</label>
                <b id="idShow"/>
            </div>
            <div class="form-group">
                <label for="">Họ tên :</label>
                <b id="nameShow"/>
            </div>
            <div class="form-group">
                <label for="">Địa chỉ :</label>
                <b id="addressShow"/>
            </div>
            <div class="form-group">
                <label for="">Phone :</label>
                <b id="phoneShow"/>
            </div>
            <div class="form-group">
                <label for="">Ngày sinh :</label>
                <b id="dateShow"/>
            </div>
            <div class="form-group">
                <label for="">Giới tính :</label>
                <b id="sexShow"/>
            </div>
            <div class="form-group">
                <label for="">Chức vụ :</label>
                <b id="roleShow"/>
            </div>
        </div>
    </div>
</div>
</div>

{{-- Modal Form Edit and Delete Post --}}
<div id="myModal" class="modal fade" role="dialog">
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title"></h4>
        </div>
        <div class="modal-body">
            <form class="form-horizontal" role="modal">

                <div class="form-group">
                    <label class="control-label col-sm-3"for="id">ID</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="fid" disabled>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-3"for="title">Title</label>
                    <div class="col-sm-8">
                        <input type="name" class="form-control" id="t">
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-3" for="body">Body</label>
                    <div class="col-sm-8">
                        <textarea type="name" class="form-control" id="b"></textarea>
                    </div>
                </div>
            </form>
            {{-- Form Delete Post --}}
            <div class="deleteContent">
                Are You sure want to delete <span class="title"></span>?
                <span class="hidden id"></span>
            </div>

        </div>
        <div class="modal-footer">

            <button type="button" class="btn actionBtn" data-dismiss="modal">
                <span id="footer_action_button" class="glyphicon"></span>
            </button>

            <button type="button" class="btn btn-warning" data-dismiss="modal">
                <span class="glyphicon glyphicon"></span>close
            </button>

        </div>
    </div>
</div>
</div>
</div>
@endsection
@section('js')
<link rel="stylesheet" href="/assets/user/css/mycss.css">
 
    <script src="https://datatables.yajrabox.com/js/datatables.bootstrap.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
$(document).ready(function() {
    });
$(document).on('click','.create-modal', function() {
    $('#create').modal('show');
    $('.form-horizontal').show();
    $('.modal-title').text('Khởi tạo nhân viên');
});
$(document).on('click', '.show-modal', function() {
    $('#show').modal('show');
    $('.modal-title').text('Chi tiết nhân viên');
    $('#idShow').text($(this).data('id'));
    $('#nameShow').text($(this).data('name'));
    $('#addressShow').text($(this).data('address'));
    $('#dateShow').text($(this).data('date'));
    $('#phoneShow').text($(this).data('phone'));
    $('#sexShow').text($(this).data('sex'));
    $('#roleShow').text($(this).data('role'));
});
$(document).on('click','.edit-modal', function() {
   
    $('.form-horizontal').show();
    $('.modal-title').text('Chỉnh sửa nhân viên');
    document.getElementById("nameE").value =$(this).data('name');
     document.getElementById("addressE").value =$(this).data('address');
     document.getElementById("phoneE").value =$(this).data('phone');
      document.getElementById("date_of_birthE").value =$(this).data('date');
    $('#roleE').val($(this).data('role'));
     document.getElementById("idE").value =$(this).data('id');
     $('#edit').modal('show');
});
function disctrict(sel) {
    var treatCateID = sel.value;
    $.ajax({
            url: '/admin/get-district/' + treatCateID, //this is your uri
            type: 'GET', //this is your method
            dataType: 'json',
            success: function (data) {
                if (data.length == 0) {
                    $('#districtsPatientC')
                    .find('option')
                    .remove()
                    .end()
                    .append('<option value="whatever">Chưa có quận huyện</option>')
                    .val('whatever')
                    ;
                } else {
                    $('#districtsPatientC')
                    .find('option')
                    .remove()
                    .end()
                    ;
                    for (var i = 0; i < data.length; i++) {
                        $('#districtsPatientC').append("<option value=" + data[i].id + ">" + data[i].name + "</option>");

                    }
                }
            }, error: function (obj, text, error) {
                alert("NO");
                $('#districtsPatient')
                .find('option')
                .remove()
                .end()
                .append('<option value="whatever">Chưa có dịch vụ</option>')
                .val('whatever')
                ;
                alert(showNotice("error", obj.responseText));
            },
        });
}
$(document).on('click', '.btn-dell', function(e) {
    var id=$(this).val();
    alert(id);
    $.ajax({
         url: '/admin/delete-staff', //this is your uri
        type: 'GET', //this is your method
        data:  { id :id},
        dataType: 'json',
        success: function(data){
           swal("{{ Session::get('success')}}", "", "success");
       },error: function(obj,text,error) {
               //show error
               alert( showNotice("error",obj.responseText));
           },
       });
});
$('#dup-table').DataTable({
    language: {
        "lengthMenu": "Tổng kết quả Hiển thị _MENU_ ",
        "zeroRecords": "Không tìm thấy kết quả ",
        "info": "Hiển thị trang _PAGE_ trong tổng _PAGES_ trang",
        "infoEmpty": "Không có kết quả .",
        "infoFiltered": "(filtered from _MAX_ total records)",
        "search" : "Tìm kiếm ","infoFiltered": "(Đã tìm từ _MAX_ kết quả)"
    },
   processing: true,
                serverSide: true,
                order: [[ 0, "desc" ]],
                bLengthChange:true,
                pageLength: 10,
    ajax: '/admin/get-dentist',
    columns : [

    {data: 'id'},
    {data: 'name'},
    {data: 'RoleStaff'},
    {

      data: 'action'
  },
  ],
});
$(function () {
        $('#bdayC').datepicker({
            endDate: 'd',
            autoclose: true,
        });
    });
$("#addStaff").click(function () {
    var nameCreate = document.getElementById("nameC").value;
    var roleCreate = document.getElementById("roleC").value;
    var genderCreate = document.getElementById("genderC").value;
    var phoneCreate = document.getElementById("phoneC").value;
    var email = document.getElementById("emailC").value;
    var addressCreate = document.getElementById("addressC").value;
    var birthdateCreate = document.getElementById("bdayC").value;
    var cityCreate = document.getElementById("cityPatientC").value;
    var districtCreate = document.getElementById("districtsPatientC").value;
    var degreeCreate = document.getElementById("degreeC").value;
    var note = document.getElementById("description").value;
    if ($.trim(nameCreate) == '' ) {
        swal("Vui lòng nhập họ và tên của nhân viên!", "", "error");
        return;
    }else if (nameCreate.length < 6 || nameCreate.length > 50 ) {
        swal("Họ tên phải từ 6 đến 35 kí tự!", "", "error");
        return;
    }else if (phoneCreate.length < 6 || phoneCreate.length > 50 ) {
        swal("Số điện thoại phải từ 6 đến 35 kí tự!", "", "error");
        return;
    } else if ($.trim(birthdateCreate) == "") {
        swal("Vui lòng chọn năm sinh  !", "", "error");
        return;
    }else if ($.trim(email) == '') {
        swal("Vui lòng nhập email  !", "", "error");
        return;
    }else if (addressCreate.length < 6 || addressCreate.length > 50 ) {
        swal("Địa chỉ phải từ 6 đến 35 kí tự!", "", "error");
        return;
    }else if ($.trim(addressCreate) == '') {
        swal("Vui lòng nhập địa chỉ của nhân viên  !", "error");
        return;
    }else if ($.trim(degreeCreate) == "") {
        swal("Vui lòng điền bằng cấp  !", "", "error");
        return;
    } else if ($.trim(phoneCreate) != '') {
        var vali= /(^0)+([0-9]{9,10})\b/;
        var result= vali.test(phoneCreate);
        if(result == false){
           swal("Số điện thoại sai cú pháp!", "Số điện thoại chỉ 10 và 11 kí tự và bắt đầu bằng số 0", "error");
           return;
       } 
   } 
   
   $.ajax({
    type: 'POST',
    url: '/admin/create-staff',
    data: {
        "_token": "{{ csrf_token() }}",
        'name': nameCreate,
        'address': addressCreate,
        'phone': phoneCreate,
        'date_of_birth': birthdateCreate,
        'gender': genderCreate,
        'district_id': districtCreate,
        'city_id' : cityCreate,
        'role_id' : roleCreate,
        'email' :email,
        'degree' :degreeCreate,
        'description' : note,

    },
    success: function (data) {
        if (data == 0) {
            swal("Số điện thoại đã tồn tại", "", "error");
        } else if(data == 1) {
            $('#dup-table').DataTable().ajax.reload();
            $('#create').modal('show');
                $(document.body).on('hidden.bs.modal', function () {
                    $('#create').removeData('bs.modal')
                });
            swal("Tạo không thành công", "", "error");
        }else{
        var table = $('#dup-table').dataTable()
                    table.fnStandingRedraw();
        swal("Khởi tạo thành công", "", "success");
        }
    },
});
});
$("#updateStaff").click(function () {
    var id = document.getElementById("idE").value;
    var nameCreate = document.getElementById("nameE").value;
    var roleCreate = document.getElementById("roleE").value;
    var addressCreate = document.getElementById("addressE").value;
    var gender = document.getElementById("sexE").value;
    var phone = document.getElementById("phoneE").value;
    if ($.trim(nameCreate) == '' ) {
        swal("Vui lòng nhập họ và tên của nhân viên!", "", "error");
        return;
    }else if (nameCreate.length < 6 || nameCreate.length > 250 ) {
        swal("Họ tên phải từ 6 đến 250 kí tự!", "", "error");
        return;
    }else if (addressCreate.length < 6 || addressCreate.length > 250 ) {
        swal("Địa chỉ phải từ 6 đếnxx 250 kí tự!", "", "error");
        return;
    }    
   
   $.ajax({
    type: 'POST',
    url: '/admin/edit-staff',
    data: {
        "_token": "{{ csrf_token() }}",
        'id' : id,
        'name': nameCreate,
        'address': addressCreate,
        'gender': gender,
        'role_id' : roleCreate,
        'phone':phone,
    },
    success: function (data) {
        if (data == 1) {
            swal("Cập nhật không thành công", "", "error");
        }  else if (data==0){
        swal("Cập nhật thành công", "", "success");
        }
    },
});
});
</script>
@endsection