@extends('admin.master')
@section('content')
    <div class="content-wrapper">
        <div class="container center_div" style="padding-top: 15px">
            <form action="sync-payment-post" method="POST" enctype="multipart/form-data">
                {{csrf_field()}}
                <input type="file" name="privateKey" class="file" data-show-preview="false" required>
                <button type="submit" class="btn btn-primary" style="margin-top: 10px">Đồng bộ</button>
            </form>
        </div>
    </div>
@endsection