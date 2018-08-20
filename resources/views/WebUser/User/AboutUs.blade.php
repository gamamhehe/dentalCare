<!DOCTYPE html>
<html lang="en"><head>
<title> Giới thiệu </title>
<meta charset="utf-8">

<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="shortcut icon" type="image/png" href="/assets/images/icon/fap16.png"/>
<script src="/assets/user/js/jquery-3.2.1.js"></script>
<script src="/assets/user/js/jquery.easing.1.3.js"></script>
<link rel="stylesheet" href="/assets/user/js/jquery.fancybox.css"/>
<script src="/assets/user/js/jquery.fancybox.js"></script>

<script type="text/javascript" src="/assets/user/js/myjs.js"></script>
<link href="https://fonts.googleapis.com/css?family=Italianno|Open+Sans:300,400,600,700,800&amp;subset=vietnamese" rel="stylesheet">
<link rel="stylesheet" href="/assets/admin/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
<!-- Daterange picker -->
<link rel="stylesheet" href="/assets/admin/bower_components/bootstrap-daterangepicker/daterangepicker.css">
<link rel="stylesheet" href="/assets/user/bootstrap/bootstrap.css">
<link rel="stylesheet" href="/assets/user/bootstrap/font-awesome.css">
<link rel="stylesheet" href="/assets/user/css/mycss.css">
</head>
<body>
    <nav class="navbar navbar-light navbar-fixed-top bg-faded navVisible thanhmenu" style="position: static;" id="navHeader">
        <div class="container">
            <button class="navbar-toggler hidden-sm-up float-xs-right" type="button" data-toggle="collapse"
            data-target="#navmn">
        </button>

        <div class="collapse navbar-toggleable-xs" id="navmn">
            <!-- <a class="navbar-brand logo" href="#"><img src="images/icon/logo.png" alt=""></a> -->
            <ul class="nav navbar-nav float-sm-right">

                <li class="nav-item active">
                    <a class="nav-link " href="/gioi-thieu">Giới Thiệu</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link  " href="/danh-sach-bac-si">Chuyên Gia</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link  " href="/su-kien">Sự kiện</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link  " href="/bang-gia">Bảng giá</a>
                </li>

                <li class="nav-item">

                    @if(Session::has('currentUser'))
                    <li class="nav-item dropdown ">
                        @if(Session::has('listPatient'))
                        <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                            <img src="{{Session::get('currentPatient')->avatar}}" class="user-image img-circle"
                            alt="User Image"
                            class="img-fluid img-responsive" style="max-height: 25px;">
                        </a>
                        <ul class="dropdown-menu"
                        style="position: absolute;right: 0;left: auto;background-color: whitesmoke">
                        <!-- User image -->
                        <li class="user-header">
                            <div class="container" style=";padding:10px 0px; ">
                                <div class="row">
                                    <div class="col-sm-4 hoverImg" style="float: left;padding-left: 20px;">
                                        <img src="{{Session::get('currentPatient')->avatar}}"
                                        class="img-circle img-responsive img-fluid borderImg " id="divAcc1"
                                        alt="User Image" width="50px;">
                                    </div>
                                    @foreach(\Session::get('listPatient') as $key => $value)
                                    <div class="col-sm-2">

                                        <img src="{{ $value->avatar }}"
                                        class="img-circle img-responsive img-fluid" alt="User Image"
                                        id="{!! $value->id !!}" width="50px;"
                                        onclick="changeInfo(this.id)">
                                    </div>
                                    @endforeach
                                </div>
                            </div>

                        </li>
                        <li class="user-header" id="acc1" style="display: block">
                            <p>

                                {{Session::get('currentPatient')->name}}
                            </p>
                        </li>
                        <li class="user-header" id="acc2" style="display: none">
                            <p>
                                @foreach(\Session::get('listPatient') as $key)
                                @if($key->id != Session::get('currentPatient')->id )
                                <h1>{{$key->name}}</h1>
                                @endif

                                @endforeach
                            </p>
                        </li>
                        <hr>

                        <li class="a-hover">
                            <a href="/lich-su-benh-an">Lịch sử khám bệnh</a>
                        </li>
                        <li class="gachngang"></li>
                        <li class="  a-hover">
                            <a href="/danh-sach-chi-tra"><span>Danh sách chi trả</span></a>
                        </li>
                        <li class="gachngang"></li>
                        <li class=" a-hover">
                            <a href="#"><span>Lịch hẹn</span></a>
                        </li>
                        <li class="gachngang"></li>

                        <!-- Menu Body -->
                        <!-- Menu Footer-->
                        <li class="user-footer" style="background-color: whitesmoke;padding-top: 5px;">

                            <div class="pull-left" style="padding-left: 1em;">
                                <a href="/thong-tin-ca-nhan" class="btn btn-success btn-flat">Hồ sơ</a>
                            </div>
                            <div class="pull-right" style="padding-right: 1em;">
                                <a href="/signOut" class="btn btn-success btn-flat">Đăng xuất</a>
                            </div>

                        </li>
                    </ul>
                    @else
                    <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                       <img src="/assets/images/avatar/noPatient.jpg" class="user-image img-circle"
                       alt="User Image"
                       class="img-fluid img-responsive" style="max-height: 25px;">
                   </a>
                   <ul class="dropdown-menu"
                   style="position: absolute;right: 0;left: auto;background-color: whitesmoke">
                   <!-- User image -->

                   <li class="user-header" id="acc1" style="display: block">
                     <div>
                        <p style="color: red">
                            Tài khoản chưa có hồ sơ bệnh nhân
                        </p>
                        <p>Hãy liên hệ với nhân viên</p>

                    </div>
                </li>

                <hr>


                <!-- Menu Body -->
                <!-- Menu Footer-->
                <li class="user-footer" style="background-color: whitesmoke;padding-top: 5px;">


                    <div align="center">
                        <a href="/signOut" class="btn btn-success btn-flat">Đăng xuất</a>
                    </div>

                </li>
            </ul>
            @endif

        </li>

        @else
        <li class="nav-item dropdown ">
            <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown" id="buttonLogin">
                {{--<img src="assets/images/icon/user.jpg" class="user-image img-circle" alt="User Image"--}}
                {{--class="img-fluid img-responsive" style="max-height: 25px;">--}}
                Đăng Nhập
            </a>
            <ul class="dropdown-menu" id="drop"
            style="position: absolute;right: 0;left: auto;background-color: whitesmoke;">
            <!-- User image -->
            <li class="user-header">
                Đăng nhập

            </li>
            <!-- Menu Body -->

            <!-- Menu Footer-->
            <li class="user-footer" style="background-color: whitesmoke">
                <div class="col-ms-12 col-md-offset-12">
                    <div class="panel panel-default">
                        <div class="panel-body" style="padding-left: 0.5em;padding-right: 0.5em;">

                            <form action="{!! url('/loginUser') !!}" method="Post">
                                {{ csrf_field() }}
                                <div class="form-group has-feedback {{ $errors->has('phone') ? ' has-error' : '' }}">
                                    <input type="text" class="form-control" placeholder="Số điện thoại" name="phone" value="{{ old('phone') }}"
                                    required autofocus>
                                    <span class="glyphicon glyphicon-phone form-control-feedback"></span>

                                </div>
                                <div class="form-group has-feedback">
                                    <input type="password" class="form-control" placeholder="Mật khẩu" name="password" required>
                                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>

                                </div>
                                     <!--    @if (\Session::has('fail'))
                                            <span class="help-block has-error" style="color: #dd4b39">
                                               <strong>{!! \Session::get('fail') !!} </strong>
                                        </span>
                                        @endif -->
                                        <div class="row">
                                            <!-- /.col -->
                                            <div class="col-xs-12">
                                                <button type="submit" class="btn btn-primary btn-block btn-flat">Đăng nhập</button>
                                            </div>
                                            <!-- /.col -->

                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </li>
            @endif
        </li>



    </ul>
</div>
</div>
</nav>
<nav class="navbar navbar-light navbar-fixed-top bg-faded navHidden thanhmenu" id="navTop">
    <div class="container">
        <button class="navbar-toggler hidden-sm-up float-xs-right" type="button" data-toggle="collapse"
        data-target="#navmn">
    </button>

    <div class="collapse navbar-toggleable-xs" id="navmn">
        <!-- <a class="navbar-brand logo" href="#"><img src="images/icon/logo.png" alt=""></a> -->
        <ul class="nav navbar-nav float-sm-right">

            <li class="nav-item active">
                <a class="nav-link " href="/gioi-thieu">Giới Thiệu</a>
            </li>
            <li class="nav-item">
                <a class="nav-link  " href="/danh-sach-bac-si">Chuyên Gia</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/su-kien">Sự kiện</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/bang-gia">Bảng giá</a>
            </li>

            <li class="nav-item">

                @if(Session::has('currentUser'))
                <li class="nav-item dropdown ">
                    @if(Session::has('listPatient'))
                    <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                        <img src="{{Session::get('currentPatient')->avatar}}" class="user-image img-circle"
                        alt="User Image"
                        class="img-fluid img-responsive" style="max-height: 25px;">
                    </a>
                    <ul class="dropdown-menu"
                    style="position: absolute;right: 0;left: auto;background-color: whitesmoke">
                    <!-- User image -->
                    <li class="user-header">
                        <div class="container" style=";padding:10px 0px; ">
                            <div class="row">
                                <div class="col-sm-4 hoverImg" style="float: left;padding-left: 20px;">
                                    <img src="{{Session::get('currentPatient')->avatar}}"
                                    class="img-circle img-responsive img-fluid borderImg " id="divAcc1"
                                    alt="User Image" width="50px;">
                                </div>
                                @foreach(\Session::get('listPatient') as $key => $value)
                                <div class="col-sm-2">

                                    <img src="{{ $value->avatar }}"
                                    class="img-circle img-responsive img-fluid" alt="User Image"
                                    id="{!! $value->id !!}" width="50px;"
                                    onclick="changeInfo(this.id)">
                                </div>
                                @endforeach
                            </div>
                        </div>

                    </li>
                    <li class="user-header" id="acc1" style="display: block">
                        <p>

                            {{Session::get('currentPatient')->name}}
                        </p>
                    </li>
                    <li class="user-header" id="acc2" style="display: none">
                        <p>
                            @foreach(\Session::get('listPatient') as $key)
                            @if($key->id != Session::get('currentPatient')->id )
                            <h1>{{$key->name}}</h1>
                            @endif

                            @endforeach
                        </p>
                    </li>
                    <hr>

                    <li class="a-hover">
                        <a href="/lich-su-benh-an">Lịch sử khám bệnh</a>
                    </li>
                    <li class="gachngang"></li>
                    <li class="  a-hover">
                        <a href="/danh-sach-chi-tra"><span>Danh sách chi trả</span></a>
                    </li>
                    <li class="gachngang"></li>
                    <li class=" a-hover">
                        <a href="#"><span>Lịch hẹn</span></a>
                    </li>
                    <li class="gachngang"></li>

                    <!-- Menu Body -->
                    <!-- Menu Footer-->
                    <li class="user-footer" style="background-color: whitesmoke;padding-top: 5px;">

                        <div class="pull-left" style="padding-left: 1em;">
                            <a href="/thong-tin-ca-nhan" class="btn btn-success btn-flat">Hồ sơ</a>
                        </div>
                        <div class="pull-right" style="padding-right: 1em;">
                            <a href="/signOut" class="btn btn-success btn-flat">Đăng xuất</a>
                        </div>

                    </li>
                </ul>
                @else
                <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                   <img src="/assets/images/avatar/noPatient.jpg" class="user-image img-circle"
                   alt="User Image"
                   class="img-fluid img-responsive" style="max-height: 25px;">
               </a>
               <ul class="dropdown-menu"
               style="position: absolute;right: 0;left: auto;background-color: whitesmoke">
               <!-- User image -->

               <li class="user-header" id="acc1" style="display: block">
                 <div>
                    <p style="color: red">
                        Tài khoản chưa có hồ sơ bệnh nhân
                    </p>
                    <p>Hãy liên hệ với nhân viên</p>

                </div>
            </li>

            <hr>


            <!-- Menu Body -->
            <!-- Menu Footer-->
            <li class="user-footer" style="background-color: whitesmoke;padding-top: 5px;">


                <div align="center">
                    <a href="/signOut" class="btn btn-success btn-flat">Đăng xuất</a>
                </div>

            </li>
        </ul>
        @endif

    </li>

    @else
    <li class="nav-item dropdown ">
        <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown" id="buttonLogin">
            {{--<img src="assets/images/icon/user.jpg" class="user-image img-circle" alt="User Image"--}}
            {{--class="img-fluid img-responsive" style="max-height: 25px;">--}}
            Đăng Nhập
        </a>
        <ul class="dropdown-menu" id="drop"
        style="position: absolute;right: 0;left: auto;background-color: whitesmoke;">
        <!-- User image -->
        <li class="user-header">
            Đăng nhập

        </li>
        <!-- Menu Body -->

        <!-- Menu Footer-->
        <li class="user-footer" style="background-color: whitesmoke">
            <div class="col-ms-12 col-md-offset-12">
                <div class="panel panel-default">
                    <div class="panel-body" style="padding-left: 0.5em;padding-right: 0.5em;">

                        <form action="{!! url('/loginUser') !!}" method="Post">
                            {{ csrf_field() }}
                            <div class="form-group has-feedback {{ $errors->has('phone') ? ' has-error' : '' }}">
                                <input type="text" class="form-control" placeholder="Số điện thoại" name="phone" value="{{ old('phone') }}"
                                required autofocus>
                                <span class="glyphicon glyphicon-phone form-control-feedback"></span>

                            </div>
                            <div class="form-group has-feedback">
                                <input type="password" class="form-control" placeholder="Mật khẩu" name="password" required>
                                <span class="glyphicon glyphicon-lock form-control-feedback"></span>

                            </div>
                                     <!--    @if (\Session::has('fail'))
                                            <span class="help-block has-error" style="color: #dd4b39">
                                               <strong>{!! \Session::get('fail') !!} </strong>
                                        </span>
                                        @endif -->
                                        <div class="row">
                                            <!-- /.col -->
                                            <div class="col-xs-12">
                                                <button type="submit" class="btn btn-primary btn-block btn-flat">Đăng nhập</button>
                                            </div>
                                            <!-- /.col -->

                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </li>
            @endif
        </li>



    </ul>
</div>
</div>
</nav>
<!-- regist -->
<div class="box_dktv" style="overflow: hidden;width: 220px;max-width: 300px;">
    <div class="divOut" style="padding: 4px;">
        <div class="container" style="    border: 1px solid white;
        padding: 5px;">
        <div class="row">
            <div class="col-xs-1"> <img src="/assets/images/Homepage/dktv.png" alt="No Image" style="float: left;" class="img-responsive img-fruid"></div>
            <div class="col-xs-10">
                <a href="#" class="btnkn2tv create-modal" style="color: white;">
                    <div>
                        <div>Đặt lịch hẹn</div>

                        <div>Hotline: 1900.9999</div>
                    </div>
                </a></div>
            </div>
        </div>
    </div>
</div>
<!-- end qc -->
<!-- modal -->
<div id="create" class="modal fade" role="dialog" >
    <div class="modal-dialog modal-sm">
        <div class="modal-content" style="height: 400px;min-height: 400px;">
            <div class="modal-header" style="background: url(/assets/images/HomePage/backgroundfooter.jpg);">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <div><img src="/assets/images/HomePage/logo.png" alt="" class="centerThing"></div>
            </div>
            <div class="modal-body" style="background: url(/assets/images/layoutRegister.jpg);">
               <form method ="post" class="form-horizontal" action="create-appointment-user" enctype="multipart/form-data" id="AppointmentGuest">
                   {{ csrf_field() }}

                   <div class="form-group row add">
                    @if(Session::has('currentUser'))
                    <div class="col-sm-12">
                        <input type="text" class="form-control" id="guestPhone" name="guestPhone"
                        placeholder="Số điện thoại" disabled value="{{Session::get('currentPatient')->phone}}">
                        <input type="hidden" id="phoneNumber" name="phoneNumber" value="{{Session::get('currentPatient')->phone}}">
                    </div>
                    <div class="col-sm-12">
                        <input type="text" class="form-control" id="guestName" name="guestName"
                        placeholder="Họ và tên" required>
                    </div>
                    @else
                    <div class="col-sm-12">
                        <input type="text" class="form-control" id="guestPhone" name="guestPhone"
                        placeholder="Số điện thoại" required>
                    </div>
                    <div class="col-sm-12">
                        <input type="text" class="form-control" id="guestName" name="guestName"
                        placeholder="Họ và tên" required>
                    </div>
                    @endif


                    <div class="col-sm-12" style="margin: 8px 0;">
                      <div class="col-sm-12 inputWithIcon" style="padding-right: 0;padding-left: 0;">
                          <input type="text" placeholder="Ngày bắt đầu" name="start_date" class="form-control pull-right" id="startdate" style="margin:0px;" />
                          <i class="fa fa-calendar"></i>
                      </div>
                  </div>

                  <div class="col-sm-12" style="margin: 8px 0;">
                    <textarea name="guestNote" id="guestNote" style="resize: none;width: 100%" rows="4" placeholder="Ghi chú"></textarea>
                </div>


                <div class="col-sm-12" style="padding-top: 2em;">
                   <button class="btn btn-warning" type="button" style=" width: 100%;" id="add" onclick="save(this)" >
                       <span class="glyphicon glyphicon-plus"></span>Hoàn thành
                   </button>
               </div>

           </div>
       </form>
   </div>

</div>
</div>
</div>
<!-- end -->
<!-- row1 -->
<div class="container" style="padding-top: 1em;">
    <div class="row" >
        <div class="col-sm-8 push-sm-2 text-xs-center Bacsititle"> 
          <h3 style="text-align: center;"><span style="font-size: 120%; color: blue;"><strong>Nha khoa GOLD Clinic</strong></span></h3>
          <p><img class="img-center" src="https://vivaclinic.vn/wp-content/uploads/2017/09/SHARP-3.png" data-src="https://vivaclinic.vn/wp-content/uploads/2017/09/SHARP-3.png" width="196" height="50" alt=""></a></p>
      </div>
  </div> 
</div>


<div class="container" style="margin-bottom: 2em;">
    <div class="row">
        <div class="col-md-6 col-sm-12 col-lg-6 col-xs-12">
            <ul  style="list-style-type:none;">
                <li class="listType"><i class="fa fa-star text-yellow"></i>Bạn đang tìm kiếm một phòng khám để duy trì sức khỏe răng miệng?</li>
                <li class="listType"><i class="fa fa-star text-yellow"></i>Bạn có một nụ cười tỏa nắng?</li>
                <li class="listType"><i class="fa fa-star text-yellow"></i>Hay bạn muốn xóa các vết đồi mồi, nám da, những nốt mụn không mong muốn...?</li>
            </ul>
            <div style=" padding: 7px 0 7px 25px;margin:0;position: relative;font-size: 15px; ">
                <h3 style="text-align: left;"><span style="font-size: 25px; color: #000000;font-family: "UTM AvoBold";"> <strong>Chúng tôi dùng khoa học để làm đẹp</strong></span></h3>
                <p>Bác sỹ tốt sẽ luôn mong làn da và hàm răng của bạn được đẹp chứ không phải vì những mục đích khác. Bác sỹ tốt là người giúp bạn hiểu rõ việc chăm sóc răng miệng và làn da từ những việc nhỏ nhất như đánh răng và bảo vệ làn da đúng cách mới là điều quan trọng nhất,...</p>
            </div>
        </div>
        <div class="col-md-6 col-sm-12 col-lg-6 col-xs-12"  >
          <img src="/assets/images/gt1.jpg" alt="" class="img-responsive"   style=" width: 100%;">
      </div>
  </div>
</div>
<div class="container" style="background: url(/assets/images/bg4.jpg);width: 100%;padding-top: 30px;padding-bottom: 50px;margin-bottom: 50px;">
    <div class="row" >
        <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12" style="padding: 10px;position: relative;">
            <div class="col-sm-8 push-sm-2 text-xs-center Bacsititle">
                <h3 class="wow bounceInLeft"><strong>Nha khoa GOLD Clinic</strong></h3>
            </div>
            <p>
            <img class="img-center" src="https://vivaclinic.vn/wp-content/uploads/2017/09/SHARP-3.png" data-src="https://vivaclinic.vn/wp-content/uploads/2017/09/SHARP-3.png" width="196" height="50" alt=""> 
            </p>
        </div>
        <div class="col-md-6 col-sm-12 col-lg-6" style="padding: 10px;position: relative;">
            <div style="background-color: white;margin:0px 2em 0em 2em;border-radius: 25px;">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <ul  style="list-style-type:none;">
                        <li class="listType"><i class="fa fa-star text-yellow"></i>Chỉnh răng mắc cài tự gài di răng sinh lý, khay trong suốt Invisalign.</li>
                        <li class="listType"><i class="fa fa-star text-yellow"></i>Phục hình răng sứ Cercon 4D.</li>
                        <li class="listType"><i class="fa fa-star text-yellow"></i>Implant thế hệ Active -</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-sm-12 col-lg-6" style="padding: 10px;position: relative;">
            <div style="background-color: white;margin:0px 2em 0em 2em;border-radius: 25px;">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <ul  style="list-style-type:none;">
                        <li class="listType"><i class="fa fa-star text-yellow"></i>Tẩy trắng răng không đau với thuốc tẩy nhập khẩu từ Hoa Kỳ</li>
                        <li class="listType"><i class="fa fa-star text-yellow"></i>Ultrathin Veneer - Mặt dán răng sứ siêu mỏng.</li>
                        <li class="listType"><i class="fa fa-star text-yellow"></i>Điều trị cười hở lợi, lợi thâm đen.</li>
                    </ul>
                </div>
            </div>
        </div>

    </div>


</div>
<!-- row2 -->
<div class="container">
    <div class="row">
        <div class="col-sm-8 push-sm-2 text-xs-center Bacsititle">
            <h3 class="wow bounceInLeft">
                <strong>PHÒNG PHẪU THUẬT ĐẠT TIÊU CHUẨN QUỐC TẾ TRANG THIẾT BỊ HIỆN ĐẠI</strong></h3>
                <p><img class="img-center" src="https://vivaclinic.vn/wp-content/uploads/2017/09/SHARP-3.png" data-src="https://vivaclinic.vn/wp-content/uploads/2017/09/SHARP-3.png" width="196" height="50" alt=""></a></p>
            </div>
        </div>
        <div class="row">
           <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
               <p style="font-size: 15px; ">PHÒNG PHẪU THUẬT ĐẠT TIÊU CHUẨN QUỐC TẾ TRANG THIẾT BỊ HIỆN ĐẠI 
                Các ca phẫu thuật thẩm mỹ tại Gold Clinic đều được thực hiện trong phòng phẫu thuật đạt tiêu chuẩn Bộ Y Tế và các tiêu chuẩn quốc tế nghiêm ngặt. Các hệ thống trong phòng mổ, công nghệ được nhập khẩu và chuyển giao trực tiếp từ các nhãn hiệu thiết bị y khoa danh tiếng của Đức, Mỹ, Hàn Quốc… giúp ca phẫu thuật diễn ra chính xác và an toàn cao.</p>
                <p>Các thiết bị hiện đại, đạt chất lượng Hàn Quốc đang được bác sĩ Gold Clinic ứng dụng trong quá trình thăm khám tổng quát có thể kể đến như:
                </p>
                <p>
                    + <strong>Máy X quang kỹ thuật số CT</strong> thế hệ mới nhất được Bệnh viện thẩm mỹ Gold Clinic nhập trực tiếp từ Mỹ về Việt Nam. Đây là thiết bị chụp X quang mới nhất được các bệnh viện thẩm mỹ uy tín tại Mỹ, Hàn Quốc… áp dụng hiện nay.</p>
                    <div><img src="/assets/images/bvtm-kangnam-2.jpg" alt="" class="img-responsive img-fruid img-center" style=" width: 100%;"></div>
                    <p style="text-align: center;"><em>Máy X-quang kỹ thuật số mới nhất đang được ứng dụng tại Gold Clinic</em></p>

                    + <strong>Công nghệ 3D mô phỏng kết quả sau thẩm mỹ</strong> được xem là cách thức tư vấn thực tế và trực quan cho khách hàng.</p>
                    <img src="/assets/images/bvtm-kangnam-2-2.jpg" alt="" class="img-responsive img-fruid img-center" style=" width: 100%;">
                    <p style="text-align: center;"><em>Phòng phẫu thuật hiện đại tiên tiến chuẩn quốc tế</em></p>
                    <p>Với những phản hồi tích cực Gold Clinic đang là địa chỉ thẩm mỹ được các chị em truyền tai nhau trên các diễn đàn thẩm mỹ, chia sẻ kinh nghiệm làm đẹp trở thành sự lựa chọn đáng tin tưởng của hàng trăm nghìn khách hàng. Đến với Gold Clinic chị em có thể hoàn toàn tự tin và yên tâm có thể khắc phục mọi khuyết điểm ngoại hình với kết quả ổn định, hoàn hảo nhất và độ an toàn cao.</p>

                    <p><strong>Liên hệ ngay tổng đài 1900 9999, đến trực tiếp Gold Clinic hoặc Click Đặt lịch hẹn để được giải đáp mọi thắc mắc</strong></p>
                </div>
            </div>
        </div>


        <!-- footer -->
        <div class="footer" style="background: url(/assets/images/HomePage/backgroundfooter.jpg);">
           <div class="contact" id="contact">
              <div class="container">
                <div class="row">
                   <div class="col-sm-4">
                      <div><img src="/assets/images/HomePage/footer2.png" alt="" class="img-responsive img-fruid"></div><br>
                      <div>Website: <a href="https://google.com.vn">projectcapstone.vn</a></div>			 		
                      <div>Bác sĩ tư vấn (24/7) : <a class="zalovb" id="callme" onclick="ga('send', 'event', 'Phone', 'Click', 'Hotline');" href="tel:0968999777" rel="nofollow">1900.7979</a></div> 
                  </div>
                  <div class="col-sm-4">
                      <div class="place">Hà Nội</div>
                      <div>"Tel:"
                         <a id="callme" onclick="ga('send', 'event', 'Phone', 'Click', 'Hotline');" href="tel:02473006466">024.73.00.64.66</a><br>
                         Mobile:<a class="zalovb" id="callme" onclick="ga('send', 'event', 'Phone', 'Click', 'Hotline');" href="tel:0968999777" rel="nofollow">0968.999.777</a><hr>
                     </div>
                     <div>
                         <a class="chidan" rel="nofollow" target="_blank" href="https://www.google.com/maps/place/B%E1%BB%87nh+Vi%E1%BB%87n+Th%E1%BA%A9m+M%E1%BB%B9+Gold Clinic/@21.000406,105.8297107,17z/data=!4m13!1m7!3m6!1s0x3135ac8758878c1f:0x8a59d1e808ee7392!2zMTkwIFRyxrDhu51uZyBDaGluaCwgS2jGsMahbmcgVGjGsOG7o25nLCDEkOG7kW5nIMSQYSwgSMOgIE7hu5lpLCBWaeG7h3QgTmFt!3b1!8m2!3d21.002795!4d105.828991!3m4!1s0x3135ac7d0b3e238b:0xdf9ae7b52fbbdef!8m2!3d21.0003971!4d105.8305875">190 Trường Chinh - Đống Đa - Hà Nội</a>
                     </div>
                 </div>
                 <div class="col-sm-4">
                  <div class="place">Hồ Chí Minh</div>
                  <div>"Tel:"
                     <a id="callme" onclick="ga('send', 'event', 'Phone', 'Click', 'Hotline');" href="tel:02473006466">024.73.00.64.66</a><br>
                     Mobile:<a class="zalovb" id="callme" onclick="ga('send', 'event', 'Phone', 'Click', 'Hotline');" href="tel:0968999777" rel="nofollow">0968.999.777</a><hr>
                 </div>
                 <div>
                     <a class="chidan" rel="nofollow" target="_blank" href="https://www.google.com/maps/place/B%E1%BB%87nh+Vi%E1%BB%87n+Th%E1%BA%A9m+M%E1%BB%B9+Gold Clinic/@21.000406,105.8297107,17z/data=!4m13!1m7!3m6!1s0x3135ac8758878c1f:0x8a59d1e808ee7392!2zMTkwIFRyxrDhu51uZyBDaGluaCwgS2jGsMahbmcgVGjGsOG7o25nLCDEkOG7kW5nIMSQYSwgSMOgIE7hu5lpLCBWaeG7h3QgTmFt!3b1!8m2!3d21.002795!4d105.828991!3m4!1s0x3135ac7d0b3e238b:0xdf9ae7b52fbbdef!8m2!3d21.0003971!4d105.8305875">190 Trường Chinh - Quận 12 - TP.Hồ Chí Minh</a>
                 </div>
             </div>
         </div>
     </div>
 </div>
 <div class="container" style="background-color: black;width: 100%">
    <div class="row">
        <div class="col-xs-12">
            <p>Designed by Phuc. All Rights Reserved</p>
        </div>
    </div>
</div></div>

<!-- end footer -->

</body>
</html>
<script type="text/javascript" src="/assets/user/bootstrap/bootstrap.js"></script>
<script src="/assets/admin/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<script src="/assets/admin/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script src="/assets/user/js/wow.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>

    $(document).ready( function(){
        new WOW().init();
        <?php if (Session::has('success')): ?>
        swal("Lịch hẹn đã được đặt", "{{Session::get('success')}}", "success");  
    <?php endif ?>
    <?php if (Session::has('error')): ?>
    swal("{{Session::get('error')}}", "", "error");  
<?php endif ?>
$("#startdate").datepicker({
    startDate: 'd',
    autoclose: true,
});
    // start;$errors->has('phone')
    <?php if (Session::has('fail')): ?>
    swal("{{Session::get('fail')}}", "", "error");
<?php endif ?>
<?php if (Session::has('phone')): ?>
    swal("{{$errors->first('phone') }}", "", "error");
<?php endif ?>
<?php if (Session::has('phone')): ?>
    swal("{{$errors->first('pass') }}", "", "error");
<?php endif ?>

    // end;
    var phone = '{{$errors->first('phone')}}';
    var pass = '{{$errors->first('password')}}';
    if(phone){
       swal(phone, "", "error");
   }else{

   }
});
    function changeInfo(id) {
        var Chooseid = id;


        $.ajax({
            url: 'changeCP/' + Chooseid,
            type:'GET',
            success: function(result){
                location.reload();
            } ,error: function (data) {
                alert(data);
            }
        });
    }
    $(document).on('click','.create-modal', function() {
        $('#create').modal('show');
        $('.form-horizontal').show();
        $('.modal-title').text('Add Post');
    });
    function save(){
        var guestName = $('#guestName').val();
        var guestPhone = $('#guestPhone').val();
        var guestTime = $('#startdate').val();
        if($.trim(guestName) == ''){
         swal("Vui lòng điền họ tên!", "", "error");
     }else if($.trim(guestPhone) == ''){
         swal("Vui lòng điền số điện thoại!", "", "error");

     }else if($.trim(guestTime) == ''){
      swal("Vui lòng chọn ngày khám!", "", "error");
  }
  else{
    document.getElementById('AppointmentGuest').submit();    
}

}
</script>