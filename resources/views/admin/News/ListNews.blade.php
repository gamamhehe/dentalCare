@extends('admin.master')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content">
     
            <div class="row">
                <div class="box-body">
                    <label>Image-  </label>
                    <img id="holder" style="max-height:100px" name="holder" src="{{old('image')}}">
                    <div class="input-group">
                        <input id="thumbnail" class="form-control" type="text" name="image"
                               value="{{old('image')}}">
                        <span class="input-group-btn">
                             <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary ">
                               <i class="fa fa-picture-o"></i> Choose</a>
                           </span>
                    </div>
                </div>
                <div class="form-group">

                
                </div>
            </div>
            <div class="row" >
      
      <table id="dup-table" class="table text-center">
      <thead>
      <tr style="background-color: #eee;">
      <td class="col-sm-1">id</td>
      <!-- <td class="col-sm-2">title</td> -->
       <td class="col-sm-3">staff_id</td>
      <td class="col-sm-3">create_date</td>
      </tr>
      </thead>
      </table> 
    </div>
        </section>
    </div>
@endsection
@section('js')
    <script src="https://datatables.yajrabox.com/js/jquery.dataTables.min.js"></script>
<script src="https://datatables.yajrabox.com/js/datatables.bootstrap.js"></script> 

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        $(document).ready(function() {
          <?php if (Session::has('success')): ?>
          swal("Good job!", "", "success");  
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
        processing: true,
        serverSide: true,
        order: [[ 0, "desc" ]],
        bLengthChange:true,
        pageLength: 5,
        ajax: '/getDB',
        columns : [
          
              {data: 'id'},
              {data: 'title'},
              {
                  
                  data: 'staff_id'
              },
              {
                  
                  data: 'created_at'
              },
            ],
        });
    });
    </script>

@endsection
