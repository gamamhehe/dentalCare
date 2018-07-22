@extends('admin.master')
@section('content')
    <div class="content-wrapper" >
        <!-- Content Header (Page header) -->
        <section class="content" >
    <div class="profile">
      <div class="container">
        <div class="row">
          <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
            <div class="row picture">
              <!-- <img src="{{$staff->staffDetail->avatar}}" alt="" class="img-responsive"> -->
              <link href='https://fonts.googleapis.com/css?family=Raleway:400,300' rel='stylesheet' type='text/css'>
<div class="container clearfix">
   <div class="avatar">
     <input id="fileUpload" type="file" />
      <svg version="1.1" id="camera" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
         viewBox="0 0 25 15" enable-background="new 0 0 25 15" xml:space="preserve">
      <path id="cameraFrame" fill="none" stroke="white" stroke-miterlimit="10" d="M23.1,14.1H1.9c-0.6,0-1-0.4-1-1V1.9c0-0.6,0.4-1,1-1h21.2
         c0.6,0,1,0.4,1,1v11.3C24.1,13.7,23.7,14.1,23.1,14.1z"/>
      <path id="circle" fill="none" stroke="#ffffff" stroke-width="1.4" stroke-miterlimit="12" d="M17.7,7.5c0-2.8-2.3-5.2-5.2-5.2S7.3,4.7,7.3,7.5s2.3,5.2,5.2,5.2
         S17.7,10.3,17.7,7.5z"/>
      <g id="plus">
         <path fill="none" id="plusLine" class="line" stroke="#ffffff" stroke-linecap="round" stroke-miterlimit="10" d="M20.9,2.3v4.4"/>
         <path fill="none" class="line"stroke="#ffffff" stroke-linecap="round" stroke-miterlimit="10" d="M18.7,4.6h4.4"/>
      </g>
     </svg>
     <div id="openModal">
       <span>Drop here or</span>
     </div>
      </div
   </div>
        
</div>

            </div>
            <div class="row work">
              <h5 class="list">Trình độ</h5>
              <div class="_1work">
                {{$staff->staffDetail->degree}}
              </div>
            </div>
            <div class="row skills">
              <h5 class="list">Kĩ năng</h5>
               <div class="_1work">
                {!!$staff->staffDetail->description!!}
              </div>
            </div>
          </div>
          <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8" style="padding-left: 70px;">

            <!-- Header profile -->
            <div class="row head-profile">
              <div class="header">
                <h4 class="name ">{{$staff->staffDetail->name}}</h4>
              </div>
              <span class="working"><h3>{{$staff->Role->name}}</h3></span>
             
              <div class="rank">
               <h5 class="">Đánh giá : </h5>  
                <b>{{$start}}</b>
                <ul>
                 <i class="fa fa-star text-yellow"></i>
                </ul>
              </div>
              <div class="btn-all">
                <button type="button" class="btn btn-default num-none"><i class="fa fa-comment"></i>Send message</button>
                <button type="button" class="btn btn-info"><i class="fa fa-check"></i>Liên lạc</button>
                <button type="button" class="btn btn-default num-none">Report User</button>
              </div>
            </div>

            <!-- Body profile -->
            <div class="row body-profile">

              <!-- List Click tab -->
              <ul class="nav nav-tabs">
               
                <li class="active"><a data-toggle="tab" href="#menu2"><i class="fa fa-user"></i>Thông tin</a></li>
                <li><a data-toggle="tab" href="#menu3"><i class="fa fa-calendar"></i>Sẽ thêm sau</a></li>
              </ul>
              
              <!-- Tab content -->
              <div class="tab-content">
                <div id="menu1" class="tab-pane fade">
                  <h3>Thông tin</h3>
                  <p>Hok biết ghi gì</p>
                </div>
                <div id="menu2" class="tab-pane fade in active">

                  <!-- Contact Infomation -->
                  <h5 class="list1">Thông tin liên lạc</h5>
                  <div class="row">
                    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                      <p>Di động : </p>
                    </div>
                    <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                      <a href="">{{$staff->phone}}</a>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                      <p>Địa chỉ : </p>
                    </div>
                    <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                      <p>{{$staff->staffDetail->address}} <br>Quận,Thành phố</p>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                      <p>Email : </p>
                    </div>
                    <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                      <a href=""><h1>Init DB xong thì thêm vào !!!!  </h1></a>
                    </div>
                  </div>

                  <!-- Basic Infomartion -->
                  <h5 class="list1">Thông tin cơ bản</h5>
                  <div class="row">
                    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                      <p>Ngày tháng năm sinh : </p>
                    </div>
                    <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                      <p>{{$staff->staffDetail->date_of_birth}}</p>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                      <p>Giới tính : </p>
                    </div>
                    <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                      <p>{{$staff->staffDetail->gender}}</p>
                    </div>
                  </div>
                 <div id="menu3" class="tab-pane fade">
                  <h3>Menu 1</h3>
                  <p>Some content in menu 1.</p>
                </div> 
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
        </section>
    </div>
@endsection
@section('js')
<script src="https://datatables.yajrabox.com/js/datatables.bootstrap.js"></script> 
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<link rel="stylesheet" href="/assets/user/css/mycss.css">
    <script>
       
       
    </script>

@endsection
