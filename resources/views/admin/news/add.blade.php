@extends('admin.layout.index')
@section('content')
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">News
                        <small>Add</small>
                    </h1>
                </div>
                <!-- /.col-lg-12 -->
                <div class="col-lg-7" style="padding-bottom:120px">
                    @if(count($errors) > 0)
                        <div class="alert alert-danger">
                            @foreach($errors->all() as $err)
                                <strong>{{$err}}</strong><br>
                            @endforeach
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger">
                            <strong>{{session('error')}}</strong>
                        </div>
                    @endif

                    @if(session('message'))
                        <div class="alert alert-success">
                            <strong>{{session('message')}}</strong>
                        </div>
                    @endif
                    <form action="/admin/tintuc/them" method="POST" enctype="multipart/form-data"> <!-- Form bắt buộc phải có thuộc tính enctype thì mới up được file lên -->
                        {{ csrf_field() }}
                        <div class="form-group">
                            <p><label>Category</label></p>
                            <select class="form-control input-width catefield" name="cate">
                                @foreach($theloai as $chitietTL)
                                    <option value="{{ $chitietTL->id }}">{{ $chitietTL->Ten }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <p><label>Categories</label></p>
                            <select class="form-control input-width subcatefield" name="sub_cate">
                                @foreach($loaitin as $chitietLT)
                                    <option value="{{ $chitietLT->id }}">{{ $chitietLT->Ten }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <p><label>Title</label></p>
                            <input type="text" class="form-control input-width" name="article_title" placeholder="Input Title News" value="{{ old('article_title') }}" />
                        </div>

                        <div class="form-group">
                            <p><label>Summary</label></p>
                            <textarea name="article_desc" id="demo" class="form-control ckeditor" rows="3">
                                    {{ old('article_desc') }}
                                </textarea>
                        </div>

                        <div class="form-group">
                            <p><label>Content</label></p>
                            <textarea name="article_content" id="demo" class="form-control ckeditor" rows="3">
                                    {{ old('article_content') }}
                                </textarea>
                        </div>

                        <div class="form-group">
                            <p><label>Image</label></p>
                            <input type="file" class="form-control" name="article_img">
                        </div>

                        <div class="form-group">
                            <p><label>HighLights</label></p>
                            <label class="radio-inline">
                                <input name="article_rep" value="1" checked="" type="radio">Yes
                            </label>
                            <label class="radio-inline">
                                <input name="article_rep" value="0" type="radio">No
                            </label>
                        </div>

                        <button type="submit" class="btn btn-default">Add</button>
                        <button type="reset" class="btn btn-default btn-mleft">Reset</button>
                    </form>
                </div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
@endsection