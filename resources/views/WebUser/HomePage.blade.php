<!DOCTYPE html>
<html lang="en">
<head>
<title> Trang chủ </title>
<meta charset="utf-8">

<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="shortcut icon" type="image/png" href="/assets/images/icon/fap16.png"/>
<script src="/assets/user/js/jquery-3.2.1.js"></script>
<script src="/assets/user/js/jquery.easing.1.3.js"></script>

<link rel="stylesheet" href="/assets/user/js/jquery.fancybox.css"/>
<script src="/assets/user/js/jquery.fancybox.js"></script>

<script type="text/javascript" src="/assets/user/js/myjs.js"></script>
<link href="https://fonts.googleapis.com/css?family=Italianno|Open+Sans:300,400,600,700,800&amp;subset=vietnamese"
rel="stylesheet">
<link rel="stylesheet"
href="/assets/admin/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
<!-- Daterange picker -->
<link rel="stylesheet" href="/assets/admin/bower_components/bootstrap-daterangepicker/daterangepicker.css">
<link rel="stylesheet" href="/assets/user/bootstrap/bootstrap.css">
<!-- <link rel="stylesheet" href="http://gsgd.co.uk/sandbox/jquery/easing/jquery.easing.1.3.js"> -->
<link rel="stylesheet" href="/assets/user/bootstrap/font-awesome.css">
<link rel="stylesheet" href="/assets/user/css/mycss.css">
</head>
<body>
<nav class="navbar navbar-light navbar-fixed-top bg-faded navVisible thanhmenu" style="position: static;"
id="navHeader">
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
                <ul class="dropdown-menu dropdownHead"
                >
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

                    <div class="row" style="padding-bottom: 1em;">
                        <div class="col-xs-6"><a href="/thong-tin-ca-nhan" class="btn btn-block btn-success btn-flat">Hồ sơ</a></div> 
                        <div class="col-xs-6"> 
                            <button type="button"
                                class="btn btn-block btn-primary btn-block btn-flat create-patient">Đăng Ký
                            </button>
                        </div>
                    </div>
                    <div class="row" >
                    <div class="col-xs-12"> 
                        <a href="/signOut" class="btn btn-block btn-success btn-flat">Đăng xuất</a>
                        </div>
                    </div>

                </li>
            </ul>
            @else
            <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
               <img src="/assets/images/avatar/noPatient.jpg" class="user-image img-circle"
               alt="User Image"
               class="img-fluid img-responsive" style="max-height: 25px;">
           </a>
           <ul class="dropdown-menu dropdownHead"
           >
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
    <ul class="dropdown-menu dropdownHead" id="drop"
    >
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
                            <input type="text" class="form-control" placeholder="Số điện thoại"
                            name="phone" value="{{ old('phone') }}"
                            required autofocus>
                            <span class="glyphicon glyphicon-phone form-control-feedback"></span>

                        </div>
                        <div class="form-group has-feedback">
                            <input type="password" class="form-control" placeholder="Mật khẩu"
                            name="password" required>
                            <span class="glyphicon glyphicon-lock form-control-feedback"></span>

                        </div>
                                        <!--    @if (\Session::has('fail'))
                                            <span class="help-block has-error" style="color: #dd4b39">
                                               <strong>{!! \Session::get('fail') !!} </strong>
                                            </span>
                                            @endif -->
                                            <div class="row">
                                                <div class="col-xs-6">
                                                    <button type="button"
                                                    class="btn btn-primary btn-block btn-flat create-patient">Đăng Ký
                                                </button>
                                            </div>
                                            <!-- /.col -->
                                            <div class="col-xs-6">

                                                <button type="submit"
                                                class="btn btn-primary btn-block btn-flat">Đăng nhập
                                            </button>
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
                <ul class="dropdown-menu dropdownHead"
                >
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
           <ul class="dropdown-menu dropdownHead" >
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
    <ul class="dropdown-menu dropdownHead" id="drop"
    >
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
                            <input type="text" class="form-control" placeholder="Số điện thoại"
                            name="phone" value="{{ old('phone') }}"
                            required autofocus>
                            <span class="glyphicon glyphicon-phone form-control-feedback"></span>

                        </div>
                        <div class="form-group has-feedback">
                            <input type="password" class="form-control" placeholder="Mật khẩu"
                            name="password" required>
                            <span class="glyphicon glyphicon-lock form-control-feedback"></span>

                        </div>

                        <div class="row">
                            <!-- /.col -->
                            <div class="col-xs-12">
                                <button type="submit"
                                class="btn btn-primary btn-block btn-flat">Đăng nhập
                            </button>
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
<div id="createPatient" class="modal fade" role="dialog">
<div class="modal-dialog modal-md">
    <div class="modal-content"  >
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title"></h4>
        </div>
        <div class="modal-body">
            <form method="post" class="form-horizontal" action="create-patient"
            enctype="multipart/form-data" id="createAppoint">
            {{ csrf_field() }}
            <div class="form-group row add">
                <label class="control-label col-md-2 col-sm-3 col-xs-12" for="title">Họ & tên </label>
                <div class="col-md-8 col-sm-8 col-xs-12">
                    <input type="text" class="form-control" id="namePatient" name="namePatient"
                    placeholder="Họ và tên bệnh nhân" style="margin:0px;border: 1px solid #aaa;" required>

                </div>
            </div>
            <div class="form-group row add">
                <label class="control-label col-md-2 col-sm-3 col-xs-12" for="title">Địa chỉ</label>
                <div class="col-md-8 col-sm-8 col-xs-12">
                    <input type="text" class="form-control" id="addressPatient" name="addressPatient" style="margin:0px;border: 1px solid #aaa;"
                    placeholder="Địa chỉ cư trú" required>

                </div>
            </div>
            <div class="form-group row add">
                <label class="control-label col-md-2 col-sm-3 col-xs-12" for="title">Số điện thoại </label>
                <div class="col-md-8 col-sm-8 col-xs-12">
                    <input type="text" class="form-control" id="phonePatient" name="phonePatient" style="margin:0px;border: 1px solid #aaa;"
                    placeholder="Số điện thoại" required>

                </div>
            </div>
            <div class="form-group row add">
                <label class="control-label col-md-2 col-sm-3 col-xs-4" for="title">Ngày sinh </label>
                <div class="col-md-4 col-sm-3 col-xs-8">
                    <div class="inputWithIcon" style="padding-right: 0;padding-left: 0;">
                      <input type="text" placeholder="Ngày sinh" id="bdayxx" class="form-control pull-right" style="margin:0px;border: 1px solid #aaa;" />
                      <i class="fa fa-calendar"></i>
                  </div>
              </div>
              <label class="control-label col-md-2 col-sm-3 col-xs-4" for="title">Giới tính </label>
              <div class="col-md-4 col-sm-3 col-xs-8">
                <select name="genderPatient" id="genderPatient" class="selectSpecialTwo" 
                style="margin: 0px;border: 1px solid #aaa; ">
                <option value="Male">Nam</option>
                <option value="FeMale">Nữ</option>
                <option value="Unknow">Khác</option>
            </select>
        </div>
    </div>
    <div class="form-group row add">
        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="title">Thành phố </label>
        <div class="col-md-6 col-sm-4 col-xs-12">
            <select name="cityPatient" id="cityPatient"  style="margin: 0px;border: 1px solid #aaa; "
            onchange="disctrict(this)" class="selectSpecialTwo" >

        </select>
    </div>
    <label class="control-label col-md-4 col-sm-4 col-xs-12" for="title">Quận </label>
    <div class="col-md-4 col-sm-6 col-xs-12">
        <select name="districtsPatient" id="districtsPatient" class="selectSpecialTwo"  style="margin: 0px;border: 1px solid #aaa; ">

        </select>
    </div>
</div>
<hr>

</form>
</div>
<div class="modal-footer">
<button class="btn btn-warning" type="button" id="addPatient">
  Tạo bệnh nhân
</button>
<button class="btn btn-warning" type="button" data-dismiss="modal">
<span class="glyphicon glyphicon-remobe"></span>Close
</button>
</div>
</div>
</div>
</div>
<div class="box_dktv" style="overflow: hidden;width: 220px;max-width: 300px;">
<div class="divOut" style="padding: 4px;">
    <div class="container" style="    border: 1px solid white;
    padding: 5px;">
    <div class="row">
        <div class="col-xs-1"><img src="/assets/images/Homepage/dktv.png" alt="No Image" style="float: left;"
         class="img-responsive img-fruid"></div>
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
<div id="create" class="modal fade" role="dialog">
<div class="modal-dialog modal-sm">
    <div class="modal-content" style="height: 400px;min-height: 400px;">
        <div class="modal-header" style="background: url(/assets/images/HomePage/backgroundfooter.jpg);">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <div><img src="/assets/images/HomePage/logo.png" alt="" class="centerThing"></div>
        </div>
        <div class="modal-body" style="background: url(/assets/images/layoutRegister.jpg);">
            <form method="post" class="form-horizontal" action="create-appointment-user"
            enctype="multipart/form-data" id="AppointmentGuest">
            {{ csrf_field() }}

            <div class="form-group row add">
                @if(Session::has('currentUser'))
                <div class="col-sm-12">
                    <input type="text" class="form-control" id="guestPhone" name="guestPhone"
                    placeholder="{{Session::get('currentUser')->phone}}" 
                    value="{{Session::get('currentUser')->phone}}">
                    <input type="hidden" id="phoneNumber" name="phoneNumber"
                    value="{{Session::get('currentUser')->phone}}">
                </div>
                <div class="col-sm-12">
                    <input type="text" class="form-control" id="guestName" name="guestName"
                    placeholder="Họ và tên" required>
                </div>
                @else
                <div class="col-sm-12">
                    <input type="text" class="form-control" id="guestPhone" name="guestPhone"
                    placeholder="Số điện thoại" required >
                </div>
                <div class="col-sm-12">
                    <input type="text" class="form-control" id="guestName" name="guestName"
                    placeholder="Họ và tên" required>
                </div>
                @endif


                <div class="col-sm-12" style="margin: 8px 0;">
                    <div class="col-sm-12 inputWithIcon" style="padding-right: 0;padding-left: 0;">
                        <input type="text" placeholder="Ngày bắt đầu" name="start_date"
                        class="form-control pull-right" id="startdate" style="margin:0px;"/>
                        <i class="fa fa-calendar"></i>
                    </div>
                </div>

                <div class="col-sm-12" style="margin: 8px 0;">
                    <textarea name="guestNote" id="guestNote" style="resize: none;width: 100%" rows="4"
                    placeholder="Ghi chú"></textarea>
                </div>


                <div class="col-sm-12" style="padding-top: 2em;">
                    <button class="btn btn-warning" type="button" style=" width: 100%;" id="add"
                    onclick="save(this)">
                    <span class="glyphicon glyphicon-plus"></span>Hoàn thành
                </button>
            </div>

        </div>
    </form>
</div>

</div>
</div>
</div>
<div class="top">
<!-- start banner -->
<div class="banner">
    <div id="carousel" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#carousel" data-slide-to="0" class="active"></li>
            <li data-target="#carousel" data-slide-to="1"></li>
            <li data-target="#carousel" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner" role="listbox">
            <div class="carousel-item active hinhmot ">

                <div class="carousel-caption textbanner">
                    <div class="goi">
                        <h3 class="tdbanner1">&nbsp</h3>
                        <h4 class="tdbanner2"></h4>
                        <div class="nutbanner">
                            <a href="#" class="btn btn-outline-secondary create-modal">Đặt Lịch ngay</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="carousel-item  hinhhai img-responsive">
                <div class="carousel-caption textbanner">
                    <div class="goi">
                        <!--   <h3 class="tdbanner1">Nha khoa Gold</h3>
                        <h4 class="tdbanner2">Dental Gold</h4> -->
                        <div class="nutbanner">
                            <a href="#" class="btn btn-outline-secondary create-modal">Đặt Lịch ngay</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="carousel-item  hinhba img-responsive">
                <div class="carousel-caption textbanner">
                    <div class="goi">
                        <!--        <h3 class="tdbanner1">Nha khoa Gold</h3>
                        <h4 class="tdbanner2">Dental Gold</h4> -->
                        <div class="nutbanner">
                            <a href="#" class="btn btn-outline-secondary create-modal">Đặt Lịch ngay</a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="nutchuyen">
            <a class="left carousel-control" href="#carousel" role="button" data-slide="prev">
                <i class="fa fa-angle-double-left fa-2x"></i>
            </a>
            <a class="right carousel-control" href="#carousel" role="button" data-slide="next">
                <i class="fa fa-angle-double-right fa-2x"></i>
            </a>
        </div>
    </div>
</div>
<!-- end banner -->
</div>
<div class="container"
style="background: url(/assets/images/HomePage/t3-bg.jpg);width: 100%;padding-top: 30px;padding-bottom: 50px;">
<div class="row">
<div class="col-sm-8 push-sm-2 text-xs-center Bacsititle">
    <h3 class="wow bounceInLeft"><strong>CÔNG NGHỆ PHẪU THUẬT THẨM MỸ HOT NHẤT</strong></h3>
    <div class="gach">
        <div class="tron"></div>
    </div>
</div>
</div>
<div class="row">
<div class="col-lg-2 col-md-4 col-sm-6 col-xs-12 wow fadeInUp" data-wow-duration="0.5s" data-wow-delay="0.1s">
    <div class="daubep">
        <div class="tren">
            <img src="/assets/images/HomePage/dv1.jpg" class="centerThing img-responsive img-fruid circleBorder"
            style="max-width: 150px;">
        </div>
        <div class="duoi text-xs-center">
            <h5 class="tieude"><a href="" data-toggle="modal" data-target="#t31">BỌC RĂNG SỨ »</a></h5>
        </div>
    </div>
</div>
<div class="col-lg-2 col-md-4 col-sm-6 col-xs-12 wow fadeInUp" data-wow-duration="0.5s" data-wow-delay="0.1s">
    <div class="daubep">
        <div class="tren">
            <img src="/assets/images/HomePage/dv2.jpg" class="centerThing img-responsive img-fruid circleBorder"
            style="max-width: 150px;">
        </div>
        <div class="duoi text-xs-center">
            <p class="tieude"><a href="" data-toggle="modal" data-target="#t31">TẨY TRẮNG RĂNG »</a></p>
        </div>
    </div>
</div>
<div class="col-lg-2 col-md-4 col-sm-6 col-xs-12 wow fadeInUp" data-wow-duration="0.5s" data-wow-delay="0.1s">
    <div class="daubep">
        <div class="tren">
            <img src="/assets/images/HomePage/dv3.jpg" class="centerThing img-responsive img-fruid circleBorder"
            style="max-width: 150px;">
        </div>
        <div class="duoi text-xs-center">
            <h5 class="tieude"><a href="" data-toggle="modal" data-target="#t31">NIỀNG RĂNG »</a></h5>
        </div>
    </div>
</div>
<div class="col-lg-2 col-md-4 col-sm-6 col-xs-12 wow fadeInUp" data-wow-duration="0.5s" data-wow-delay="0.1s">
    <div class="daubep">
        <div class="tren">
            <img src="/assets/images/HomePage/dv4.jpg" class="centerThing img-responsive img-fruid circleBorder"
            style="max-width: 150px;">
        </div>
        <div class="duoi text-xs-center">
            <h5 class="tieude"><a href="" data-toggle="modal" data-target="#t31">CẤY GHÉP IMPLANT »</a></h5>
        </div>
    </div>
</div>

<div class="col-lg-2 col-md-4 col-sm-6 col-xs-12 wow fadeInUp" data-wow-duration="0.5s" data-wow-delay="0.1s">
    <div class="daubep">
        <div class="tren">
            <img src="/assets/images/HomePage/dv5.jpg" class="centerThing img-responsive img-fruid circleBorder"
            style="max-width: 150px;">
        </div>
        <div class="duoi text-xs-center">
            <h5 class="tieude"><a href="" data-toggle="modal" data-target="#t31">CHỈNH HÌNH »</a></h5>
        </div>
    </div>
</div>

<div class="col-lg-2 col-md-4 col-sm-6 col-xs-12 wow fadeInUp" data-wow-duration="0.5s" data-wow-delay="0.1s">
    <div class="daubep">
        <div class="tren">
            <img src="/assets/images/HomePage/dv6.jpg" class="centerThing img-responsive img-fruid circleBorder"
            style="max-width: 150px;">
        </div>
        <div class="duoi text-xs-center">
            <h5 class="tieude"><a href="" data-toggle="modal" data-target="#t31">RĂNG TOÀN DIỆN »</a></h5>
        </div>
    </div>
</div>
</div>
</div>
<!-- dich vu noi bat -->
<div class="container" style="margin-top: 30px;margin-bottom: 50px;">
<div class="row wow bounceIn">
    <div class="col-sm-8 push-sm-2 text-xs-center Bacsititle">
        <h3><strong>QUY TRÌNH THĂM KHÁM DENTAL GOLD</strong></h3>
        <div class="gach">
            <div class="tron"></div>
        </div>
    </div>
</div>
<div class="row" style="display: inline-flex;">
    <div class="col-lg-3 col-sm-6 col-xs-12  wow fadeInUp">
        <div class="daubep">
            <div class="tren" style="max-height: 160px;">
                <img src="/assets/images/QuyTrinhKham/buoc1.jpg" alt="" class="img-fluid">
            </div>
            <div class="duoi text-xs-center">
                <h4 class="textdaubep">ĐẶT LỊCH - TƯ VẤN</h4>
                <p class="" style="text-align:justify;">Quí khách có thể đặt hẹn bằng cách liên hệ trực tiếp nha
                    khoa hoặc để lại thông tin tại khung chat hỗ trợ. Nhân viên chúng tôi sẽ liên hệ và tư vấn<a
                    href="#"> ... </a></p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6 col-xs-12 wow fadeInUp">
            <div class="daubep">
                <div class="tren" style="max-height: 160px;">
                    <img src="/assets/images/QuyTrinhKham/buoc2.jpg" alt="" class="img-fluid">
                </div>
                <div class="duoi text-xs-center">
                    <h4 class="textdaubep">KHÁM TẠI NHA KHOA</h4>
                    <p class="" style="text-align:justify;">Đến tại phòng nha, quí khác sẽ được tư vấn và thăm khám miễn
                        phí về tình trạng răng<a href="#"> ... </a></p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 col-xs-12  wow fadeInUp">
                <div class="daubep">
                    <div class="tren" style="max-height: 160px;">
                        <img src="/assets/images/QuyTrinhKham/buoc3.jpg" alt="" class="img-fluid"
                        >
                    </div>
                    <div class="duoi text-xs-center">
                        <h4 class="textdaubep">X-QUANG-CHUẨN ĐOÁN</h4>
                        <p class="" style="text-align:justify;">Với thiết bị hiện đại và kinh nghiệm lâu năm của các nha sĩ,
                            quí khách có thể biết được chính xác tình trạng răng và cách điều trị<a href="#"> ... </a></p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 col-xs-12  wow fadeInUp">
                    <div class="daubep">
                        <div class="tren" style="max-height: 160px;">
                            <img src="/assets/images/QuyTrinhKham/buoc4.jpg" alt="" class="img-fluid">
                        </div>
                        <div class="duoi text-xs-center">
                            <h4 class="textdaubep">ĐIỀU TRỊ VÀ THEO DÕI</h4>
                            <p class="" style="text-align:justify;">Sau khi tiến hành điều trị tại phòng nha. Quí khách sẽ được
                                các nha sĩ theo dõi tình trạng răng cũng như chăm sóc răng định kì<a href="#"> ... </a></p>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- end dich vu noi bat -->
        <!-- banner 2 -->
        <div>
            <div>
                <img src="/assets/images/HomePage/banner.jpg" alt="" class="img-responsive" style=" width: 100%;

                background-size: cover;
                background-position: center;">
            </div>
        </div>
    </div>
    <!-- end banner 2 -->
    <!-- thiết bị-->
    <div class="container" style="margin-top: 30px;">
        <div class="row">
            <div class="col-sm-8 push-sm-2 text-xs-center Bacsititle">
                <h3><strong>HỆ THỐNG PHÒNG KHÁM TIÊN TIẾN NHẤT</strong></h3>
                <div class="gach">
                    <div class="tron"></div>

                </div>
            </div>
            <div class="col-sm-12">
                <img src="/assets/images/HomePage/Maymoc.jpg" alt="" class="img-responsive wow rotateInUpLeft"
                style=" width: 100%;max-height:450px;">
            </div>
        </div>
    </div>
    <!-- end thiet bi -->
    <!-- Feedback-->
    <div class="container" style="margin-top: 30px;">
        <div class="row">
            <div class="col-sm-8 push-sm-2 text-xs-center Bacsititle">
                <h3><strong>PHƯƠNG THỨC THANH TOÁN LINH HOẠT</strong></h3>
                <div class="gach">
                    <div class="tron"></div>

                </div>
            </div>
        </div>
        <!-- phuong thuc thanh toan -->
        <div class="row">
            <div class="col-sm-4  " style="float: left;">
                <div class="motmon">
                    <img src="/assets/images/HomePage/pay1.PNG" alt=""
                    class="img-fluid img-responsive"
                    style=" width: 100%;max-height:300px;">
                </div>
            </div>
            <div class="col-sm-4 ">
                <div class="motmon">
                    <img src="/assets/images/HomePage/pay2.PNG" alt="" class="img-responsive"
                    style=" width: 100%;max-height:300px;">
                </div>
            </div>
            <div class="col-sm-4 ">
                <div class="motmon">
                    <img src="/assets/images/HomePage/pay3.PNG" alt="" class="img-responsive"
                    style=" width: 100%;max-height:300px;">
                </div>
            </div>
        </div>
        <!-- end phuong thuc thanh toan -->
    </div>
    <!-- end Feedback -->

    <!-- end liên hệ -->
    <div id="particle-canvas" style="width: 100%;height: 400px;position:relative;z-index: 1">
        <div style="height: 300px;width: 100%;z-index: 2;position:absolute;z-index:2">

        </div>
    </div>
    <!-- footer -->
    <div class="footer" style="background: url(/assets/images/HomePage/backgroundfooter.jpg);">
        <div class="contact" id="contact">
            <div class="container">
                <div class="row">
                    <div class="col-sm-4">
                        <div><img src="/assets/images/HomePage/logo.png" alt="" class="img-responsive"></div>
                        <br>
                        <div>Website: <a href="https://google.com.vn">projectcapstone.vn</a></div>
                        <div>Bác sĩ tư vấn (24/7) : <a class="zalovb" id="callme"
                         onclick="ga('send', 'event', 'Phone', 'Click', 'Hotline');"
                         href="tel:0968999777" rel="nofollow">1900.7979</a></div>
                     </div>
                     <div class="col-sm-4">
                        <div class="place">Hà Nội</div>
                        <div>"Tel:"
                            <a id="callme" onclick="ga('send', 'event', 'Phone', 'Click', 'Hotline');"
                            href="tel:02473006466">024.73.00.64.66</a><br>
                            Mobile:<a class="zalovb" id="callme" onclick="ga('send', 'event', 'Phone', 'Click', 'Hotline');"
                            href="tel:0968999777" rel="nofollow">0968.999.777</a>
                            <hr>
                        </div>
                        <div>
                            <a class="chidan" rel="nofollow" target="_blank"
                            href="https://www.google.com/maps/place/B%E1%BB%87nh+Vi%E1%BB%87n+Th%E1%BA%A9m+M%E1%BB%B9+Kangnam/@21.000406,105.8297107,17z/data=!4m13!1m7!3m6!1s0x3135ac8758878c1f:0x8a59d1e808ee7392!2zMTkwIFRyxrDhu51uZyBDaGluaCwgS2jGsMahbmcgVGjGsOG7o25nLCDEkOG7kW5nIMSQYSwgSMOgIE7hu5lpLCBWaeG7h3QgTmFt!3b1!8m2!3d21.002795!4d105.828991!3m4!1s0x3135ac7d0b3e238b:0xdf9ae7b52fbbdef!8m2!3d21.0003971!4d105.8305875">190
                            Trường Chinh - Đống Đa - Hà Nội</a>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="place">Hồ Chí Minh</div>
                        <div>"Tel:"
                            <a id="callme" onclick="ga('send', 'event', 'Phone', 'Click', 'Hotline');"
                            href="tel:02473006466">024.73.00.64.66</a><br>
                            Mobile:<a class="zalovb" id="callme" onclick="ga('send', 'event', 'Phone', 'Click', 'Hotline');"
                            href="tel:0968999777" rel="nofollow">0968.999.777</a>
                            <hr>
                        </div>
                        <div>
                            <a class="chidan" rel="nofollow" target="_blank"
                            href="https://www.google.com/maps/place/B%E1%BB%87nh+Vi%E1%BB%87n+Th%E1%BA%A9m+M%E1%BB%B9+Kangnam/@21.000406,105.8297107,17z/data=!4m13!1m7!3m6!1s0x3135ac8758878c1f:0x8a59d1e808ee7392!2zMTkwIFRyxrDhu51uZyBDaGluaCwgS2jGsMahbmcgVGjGsOG7o25nLCDEkOG7kW5nIMSQYSwgSMOgIE7hu5lpLCBWaeG7h3QgTmFt!3b1!8m2!3d21.002795!4d105.828991!3m4!1s0x3135ac7d0b3e238b:0xdf9ae7b52fbbdef!8m2!3d21.0003971!4d105.8305875">190
                            Trường Chinh - Quận 12 - TP.Hồ Chí Minh</a>
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
        </div>
        <section class='rating-widget'>


        </section>
    </div>

</div>
<!-- end footer -->

</body>
</html>
<script type="text/javascript" src="/assets/user/bootstrap/bootstrap.js"></script>
<script src="/assets/admin/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<script src="/assets/admin/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script src="/assets/user/js/wow.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>

$(document).ready(function () {
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
    if (phone) {
        swal(phone, "", "error");
    }
    $.ajax({
            url: '/get-city', //this is your uri
            type: 'GET', //this is your method
            dataType: 'json',
            success: function (data) {
                if (data.length == 0) {
                    $('#cityPatient')
                    .find('option')
                    .remove()
                    .end()
                    .append('<option value="whatever">Chưa có thành phố</option>')
                    .val('whatever')
                    ;
                } else {
                    $('#cityPatient')
                    .find('option')
                    .remove()
                    .end()
                    ;
                    for (var i = 0; i < data.length; i++) {
                        $('#cityPatient').append("<option value=" + data[i].id + ">" + data[i].name + "</option>");

                    }
                }
            }, error: function (obj, text, error) {

                $('#cityPatient')
                .find('option')
                .remove()
                .end()
                .append('<option value="whatever">Chưa có thành phố</option>')
                .val('whatever')
                ;
                
            },
        });
});
$(function () {
    $('#bdayxx').datepicker({
        endDate: 'd',
        autoclose: true,
    });
});

function changeInfo(id) {
    var Chooseid = id;


    $.ajax({
        url: 'changeCP/' + Chooseid,
        type: 'GET',
        success: function (result) {
            location.reload();
        }, error: function (data) {
            alert(data);
        }
    });
}

$(document).on('click', '.create-modal', function () {
    $('#create').modal('show');
    $('.form-horizontal').show();
    $('.modal-title').text('Add Post');
});
$(document).on('click', '.create-patient', function () {
    $('#createPatient').modal('show');
    $('.form-horizontal').show();
    $('.modal-title').text('Khởi tạo thông tin người bệnh');
});
function disctrict(sel) {
    var treatCateID = sel.value;
    $.ajax({
            url: '/get-district/' + treatCateID, //this is your uri
            type: 'GET', //this is your method
            dataType: 'json',
            success: function (data) {
                if (data.length == 0) {
                    $('#districtsPatient')
                    .find('option')
                    .remove()
                    .end()
                    .append('<option value="whatever">Chưa có quận huyện</option>')
                    .val('whatever')
                    ;
                } else {
                    $('#districtsPatient')
                    .find('option')
                    .remove()
                    .end()
                    ;
                    for (var i = 0; i < data.length; i++) {
                        $('#districtsPatient').append("<option value=" + data[i].id + ">" + data[i].name + "</option>");

                    }
                }
            }, error: function (obj, text, error) {
                alert("NO");
                $('#districtsPatient')
                .find('option')
                .remove()
                .end()
                .append('<option value="whatever">Chưa có dịch vụ</option>')
                .val('whatever')
                ;
                alert(showNotice("error", obj.responseText));
            },
        });
}
function save() {
    var guestName = $('#guestName').val();
    var guestPhone = $('#guestPhone').val();
    var guestTime = $('#startdate').val();
    if ($.trim(guestPhone) == '') {
        swal("Vui lòng điền số điện thoại!", "", "error");
    } else if ($.trim(guestName) == '') {
        swal("Vui lòng điền họ tên!", "", "error");

    } else if ($.trim(guestTime) == '') {
        swal("Vui lòng chọn ngày khám!", "", "error");
    }
    else {
        var vali= /(^0)+([0-9]{9,10})\b/;

        var result= vali.test(guestPhone);
        if(result == true){
            document.getElementById('AppointmentGuest').submit();    
        }else{
         swal("Số điện thoại sai cú pháp!", "Số điện thoại chỉ 10 và 11 kí tự và bắt đầu bằng số 0", "error");
     }
 } 

}

$("#addPatient").click(function () {

var nameCreate = document.getElementById("namePatient").value;
var addressCreate = document.getElementById("addressPatient").value;
var phoneCreate = document.getElementById("phonePatient").value;
var birthdateCreate = document.getElementById("bdayxx").value;
var genderCreate = document.getElementById("genderPatient").value;
var districtCreate = document.getElementById("districtsPatient").value;
if ($.trim(nameCreate) == '' ) {
    swal("Vui lòng nhập họ và tên của bệnh nhân!", "", "error");
    return;
}else if (nameCreate.length < 6 || nameCreate.length > 50 ) {
    swal("Họ tên phải từ 6 đến 35 kí tự!", "", "error");
    return;
}else if (addressCreate.length < 4 || addressCreate.length > 50 ) {
    swal("Địa chỉ phải từ 4 đến 35 kí tự!", "", "error");
    return;
}else if ($.trim(addressCreate) == '') {
    swal("Vui lòng nhập địa chỉ của bệnh nhân  !", "Bấm kiểm tra để có danh sách bệnh nhân", "error");
    return;
}else if ($.trim(phoneCreate) == '') {
    swal("Vui lòng nhập số điện thoại  !", "", "error");
    return;
}else if ($.trim(birthdateCreate) == "") {
    swal("Vui lòng chọn năm sinh  !", "", "error");
    return;
}else if ($.trim(districtCreate) == "") {
    swal("Vui lòng quận huyện  !", "", "error");
    return;
} else if ($.trim(phoneCreate) != '') {
    var vali= /(^0)+([0-9]{9,10})\b/;
    var result= vali.test(phoneCreate);
    if(result == false){
       swal("Số điện thoại sai cú pháp!", "Số điện thoại chỉ 10 và 11 kí tự và bắt đầu bằng số 0", "error");
       return;
   } 
} 
$.ajax({
type: 'POST',
url: '/admin/create-patient-web',
data: {
    "_token": "{{ csrf_token() }}",
    'name': nameCreate,
    'address': addressCreate,
    'phone': phoneCreate,
    'date_of_birth': birthdateCreate,
    'gender': genderCreate,
    'district_id': districtCreate,
    'anam' : "",

},
success: function (data) {
    if ((data.errors)) {
        alert(data.errors.body);
    } else {
       if(data==0){
        swal("Số điện thoại đã tồn tại!", "", "error");
       }else if(data==1){
         swal("Tài khoản tạo thành công!", "", "success");
       }else{
        swal("Có lỗi xảy ra khi tạo!", "", "error");
       }
    }
},
});

});
</script>