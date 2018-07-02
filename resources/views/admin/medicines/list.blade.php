@extends('admin.master')
@section('content')
<div class="content-wrapper" >
    <!-- Content Header (Page header) -->
    <section class="content" >
        <div class="container"  >
            <div class="row " style="text-align: center; margin-right: 4em">
                <label><h1>Danh sách các Sự kiện</h1></label>
            </div>
            <div class="row layout" style=" margin-right: 4em"  >
                <table id="dup-table" class="table ">
                    <thead>
                    <tr style="background-color: #eee;">
                        <td class="col-sm-1">id</td>
                        <td class="col-sm-3" style="text-align: left;">Tên thuốc</td>
                        <td class="col-sm-1">Use</td>
                        <td class="col-sm-2">Đặc tả</td>
                        <td class="col-sm-2">Lựa chọn</td>
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
        swal("Good job!", "", "success");
        <?php endif ?>

    });

    $(function() {
        $('#dup-table').DataTable({
            processing: true,
            serverSide: true,
            order: [[ 0, "desc" ]],
            bLengthChange:true,
            pageLength: 5,
            ajax: '/admin/getListMedicines',
            columns : [

                {data: 'id'},
                {data: 'name'},
                {data: 'use'},
                {data: 'description'},
                {

                    data: 'action'
                },
            ],
        });
    });
    function deleteNews(obj){

//          var linkDelete = "admin/deleteNews/";
        var id = obj.getAttribute("id");
        $.ajax(
            {
                url: "/admin/deleteMedicines/"+id,
                method:"get",
                data: {
                    id:id
                },
                success: function ()
                {
                    $('#dup-table').DataTable().ajax.reload();
                }

            });
    }
</script>

@endsection
