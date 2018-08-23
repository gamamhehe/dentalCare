@extends('admin.master')
@section('title', 'Chỉnh sửa tin tức')
@section('content')
<div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content" >
    <div class="container"  >
      <div class="row " style="text-align: center; margin-right: 4em">
          <label><h1>Danh sách Tin Tức</h1></label>
      </div>
      <div class="row layout" style=" margin-right: 4em"  >
        <table id="dup-table" class="table myTable table-bordered Mytable-hover">
          <thead>
          <tr style="height: 1.3em;">
            <td class="col-sm-1">ID</td>
            <td class="col-sm-6" style="text-align: left;">Tên Bài Viết</td>
            <td class="col-sm-3">Lựa chọn</td>
          </tr>
          </thead>
        </table> 
      </div>
    </div>
        </section>
    </div>
@endsection
@section('js')
<link rel="stylesheet" href="/assets/user/css/mycss.css">
<script src="https://datatables.yajrabox.com/js/datatables.bootstrap.js"></script> 
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        $(document).ready(function() {
          <?php if (Session::has('success')): ?>
       swal("{{ Session::get('success')}}", "", "success");
        <?php endif ?>
         
        });
        $('#lfm').filemanager('image');
        $(window).on('load', function () {
            $(document).ready(function () {
                Page.initTinyMCE();
                Page.initLFM();
            });
        });
         $(function() {
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
        pageLength: 5,
        ajax: '/admin/get-list-news',
        columns : [
          
              {data: 'id'},
              {data: 'title'},
              {
                  
                  data: 'action'
              },
            ],
        });
    });
         function deleteNews(obj){
          alert("xx");
           var id = obj.getAttribute("id");
           $.ajax(
            {
            url: "/admin/delete-news/"+id,
            method:"GET",
            success: function ()
            {
                $('#dup-table').DataTable().ajax.reload();
            }

        });
         }
       
    </script>

@endsection
