@extends('admin.layout.index')
@section('content')
    <!-- Page Content -->
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">News
                        <small>List</small>
                    </h1>
                </div>
                <!-- /.col-lg-12 -->
                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <thead>
                    <tr align="center">
                        <th>ID</th>
                        <th>Title</th>
                        <th>Image</th>
                        <th>Summary</th>
                        <th>Category</th>
                        <th>Categories</th>
                        <th>View</th>
                        <th>Highlights</th>
                        <th>Delete</th>
                        <th>Edit</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($tintuc as $value)
                        <tr class="odd gradeX" align="center">
                            <td>{{$value->id}}</td>
                            <td>{{$value->TieuDe}}</td>
                            <td>
                                <img width="100px" src="/upload/tintuc/{{ $value->Hinh }}">
                            </td>
                            <td>{{$value->TomTat}}</td>
                            <td>{{$value->loaitin->theloai->Ten}}</td>
                            <td>{{$value->loaitin->Ten}}</td>
                            <td>{{$value->SoLuotXem}}</td>
                            <td>
                                @if($value->NoiBat == 0)
                                    {{ 'Không' }}
                                @else
                                    {{ 'Có' }}
                                @endif
                            </td>
                            <td class="center"><i class="fa fa-trash-o  fa-fw"></i><a
                                        href="/admin/tintuc/xoa/{{$value->id}}">
                                    Delete</a></td>
                            <td class="center"><i class="fa fa-pencil fa-fw"></i> <a
                                        href="/admin/tintuc/sua/{{$value->id}}">Edit</a></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /#page-wrapper -->
@endsection