@extends('admin.master')
@section('content')
    <div class="content-wrapper" >
        <!-- Content Header (Page header) -->
        <section class="content" >
            <div class="container"  >
                <div class="row " style="text-align: center; margin-right: 4em">
                    <label><h1>Danh sách Đánh giá Bác sĩ</h1></label>
                </div>
                <div class="row layout" style=" margin-right: 4em"  >
                    <table id="dup-table" class="table myTable table-bordered">
                        <thead>
                        <tr style="background-color: #eee;">
                            <td class="col-sm-1">id</td>
                            <td class="col-sm-6" style="text-align: left;">Nội dung</td>
                            <td class="col-sm-1" style="text-align: left;">Đánh giá</td>
                            <td class="col-sm-2">xx </td>
                        </tr>
                        </thead>
                    </table>
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
            "search" : "Tìm kiếm ",
            "infoFiltered": "(Đã tìm từ _MAX_ kết quả)"
        },
                processing: false,
                serverSide: true,
                order: [[ 0, "desc" ]],
                bLengthChange:true,
                pageLength: 5,
                ajax: '/admin/get-list-feedback',
                columns : [

                    {data: 'id'},
                    {data: 'content'},
                    {data: 'demo'},
                    {

                        data: 'action'
                    },
                ],
            });
        });
        function deleteFeedback(obj){
            var id = obj.getAttribute("id");
            $.ajax(
                {
                    url: "/admin/delete-feedback/"+id,
                    method:"get",
                    data: {
                        id:id
                    },
                    success: function ()
                    {
                         swal("Xóa thành công", "", "success");
                        $('#dup-table').DataTable().ajax.reload();
                    }
                });
        }
    </script>

@endsection
