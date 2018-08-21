@extends('admin.master')
@section('content')
    <div class="content-wrapper">
        <form action="checkKey" method="POST" enctype="multipart/form-data">
            {{csrf_field()}}
            <input type="file" name="privateKey">
            <button type="submit">CHECK</button>
        </form>
    </div>
@endsection