@extends('admin.master')
@section('content')
    <div class="content-wrapper" >
        <!-- Content Header (Page header) -->
        <section class="content" >
            <div class=""  >
                <div class="">
                    <div class="col-md-12">
                        <h1>Tạo Nhân viên</h1>
                    </div>
                </div>

                <div class="">
                    <div class="table table-responsive">
                        <table class="table myTable table-bordered" id="table">
                            <tr>
                                <th width="150px">No</th>
                                <th>Họ & Tên</th>
                                <th>Địa chỉ</th>
                                <th>Phone</th>
                                <th class="text-center" width="150px">
                                    <a href="#" class="create-modal btn btn-success btn-sm">
                                        <i class="glyphicon glyphicon-plus"></i>
                                    </a>
                                </th>
                            </tr>
                            {{ csrf_field() }}
                            <?php  $no=1; ?>
                            @foreach ($post as $value)
                                <tr class="post{{$value->id}}">
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $value->name }}</td>
                                    <td>{{ $value->address }}</td>
                                    <td>{{ $value->phone }}</td>
                                    <td>
                                        <a href="#" class="show-modal btn btn-info btn-sm" data-id="{{$value->id}}" data-name="{{$value->name}}" data-address="{{$value->address}}"
                                           data-date="{{$value->date_of_birth}}" data-phone="{{$value->phone}}"  data-sex="{{$value->gender}}">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        <a href="#" class="edit-modal btn btn-warning btn-sm" data-id="{{$value->id}}" data-title="{{$value->name}}" data-body="{{$value->name}}">
                                            <i class="glyphicon glyphicon-pencil"></i>
                                        </a>
                                        
                                        <button value="{{$value->id}}" class="btn btn-danger btn-sm btn-dell">  <i class="glyphicon glyphicon-trash" ></i></button>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                    {{--{{$post->links()}}--}}
                </div>
                {{-- Modal Form Create Post --}}
                <div id="create" class="modal fade" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title"></h4>
                            </div>
                            <div class="modal-body">
                                <form class="form-horizontal" role="form">
                                    <div class="form-group row add">
                                        <label class="control-label col-sm-2" for="title">Tên :</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="name" name="name"
                                                   placeholder="Your name Here" required>
                                            <p class="error text-center alert alert-danger hidden"></p>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-sm-2" for="body">Address :</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="address" name="address"
                                                   placeholder="Your Body Here" required>
                                            <p class="error text-center alert alert-danger hidden"></p>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-sm-2" for="body">Quận :</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="district" name="address"
                                                   placeholder="Your Body Here" required>
                                            <p class="error text-center alert alert-danger hidden"></p>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-sm-2" for="body">Bằng cấp :</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="degree" name="degree"
                                                   placeholder="Your Body Here" required>
                                            <p class="error text-center alert alert-danger hidden"></p>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-sm-2" for="body">Mô tả :</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="description" name="description"
                                                   placeholder="Your Body Here" required>
                                            <p class="error text-center alert alert-danger hidden"></p>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-sm-2" for="body">Phone:</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="phone" name="phone"
                                                   placeholder="Your Body Here" required>
                                            <p class="error text-center alert alert-danger hidden"></p>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-sm-2" for="body">Giới tính :</label>
                                        <div class="col-sm-4">
                                            <select name="gender">
                                                <option value="Male">Nam</option>
                                                <option value="Female">Nữ</option>
                                                <option value="Option">Khác</option>
                                            </select>
                                            <p class="error text-center alert alert-danger hidden"></p>
                                        </div>
                                        <label class="control-label col-sm-2" for="body">Chức vụ :</label>
                                        <div class="col-sm-4">
                                            <select name="role">
                                                <option value="1">Bác Sĩ</option>
                                                <option value="2">Y Tá</option>
                                                <option value="3">Ai biết</option>
                                            </select>
                                            <p class="error text-center alert alert-danger hidden"></p>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-warning" type="submit" id="add" onclick="save()" >
                                    <span class="glyphicon glyphicon-plus"></span>Save Post
                                </button>
                                <button class="btn btn-warning" type="button" data-dismiss="modal">
                                    <span class="glyphicon glyphicon-remobe"></span>Close
                                </button>
                            </div>
                        </div>
                    </div>
                </div></div>
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
                        </div>
                    </div>
                </div>
            </div>

            {{-- Modal Form Edit and Delete Post --}}
            <div id="myModal"class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title"></h4>
                        </div>
                        <div class="modal-body">
                            <form class="form-horizontal" role="modal">

                                <div class="form-group">
                                    <label class="control-label col-sm-2"for="id">ID</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="fid" disabled>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-sm-2"for="title">Title</label>
                                    <div class="col-sm-10">
                                        <input type="name" class="form-control" id="t">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-sm-2"for="body">Body</label>
                                    <div class="col-sm-10">
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

        </section>
    </div>

@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<script type="text/javascript">
    $(document).on('click','.create-modal', function() {
        $('#create').modal('show');
        $('.form-horizontal').show();
        $('.modal-title').text('Add Post');
    });
    $(document).on('click', '.show-modal', function() {
        $('#show').modal('show');
        $('#idShow').text($(this).data('id'));
        $('#nameShow').text($(this).data('name'));
        $('#addressShow').text($(this).data('address'));
        $('#dateShow').text($(this).data('date'));
        $('#phoneShow').text($(this).data('phone'));
        $('#sexShow').text($(this).data('sex'));
    });
    $(document).on('click','.edit-modal', function() {
        $('#create').modal('show');
        $('.form-horizontal').show();
        $('.modal-title').text('Add Post');
    });
    $(document).on('click', '.btn-dell', function(e) {
            var id=$(this).val();
            alert(id);
            $.ajax({
             url: '/admin/delete-post', //this is your uri
            type: 'GET', //this is your method
            data:  { id :id},
            dataType: 'json',
            success: function(data){
               $('tbody tr.post'+id).remove();
            },error: function(obj,text,error) {
                   //show error
                  alert( showNotice("error",obj.responseText));
                },
            });
    });


</script>