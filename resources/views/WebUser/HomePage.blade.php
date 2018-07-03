<!DOCTYPE html>
<html lang="en">
<head>
    <title> Trang chủ </title>
    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script type="text/javascript" src="/assets/user/bootstrap/bootstrap.js"></script>
    <script src="/assets/user/js/jquery-3.2.1.js"></script>
    <script src="/assets/user/js/jquery.easing.1.3.js"></script>

    <link rel="stylesheet" href="/assets/user/js/jquery.fancybox.css"/>
    <script src="/assets/user/js/jquery.fancybox.js"></script>

    <script type="text/javascript" src="/assets/user/js/myjs.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Italianno|Open+Sans:300,400,600,700,800&amp;subset=vietnamese"
          rel="stylesheet">
    <link rel="stylesheet" href="/assets/user/bootstrap/bootstrap.css">
    <!-- <link rel="stylesheet" href="http://gsgd.co.uk/sandbox/jquery/easing/jquery.easing.1.3.js"> -->
    <link rel="stylesheet" href="/assets/user/bootstrap/font-awesome.css">
    <link rel="stylesheet" href="/assets/user/css/mycss.css">
</head>
<body style="margin: 0px;padding: 0px;">
<nav class="navbar navbar-light     bg-faded thanhmenu">
    <div class="container">
        <button class="navbar-toggler hidden-sm-up float-xs-right" type="button" data-toggle="collapse"
                data-target="#navmn">
        </button>

        <div class="collapse navbar-toggleable-xs" id="navmn">
            <!-- <a class="navbar-brand logo" href="#"><img src="images/icon/logo.png" alt=""></a> -->
            <ul class="nav navbar-nav float-sm-right">

                <li class="nav-item active">
                    <a class="nav-link " href="/gioithieu">Giới Thiệu</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link  " href="/doctorList">Chuyên Gia</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link  " href="/event">Event</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link  " href="#contact">dịch vụ</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link  " href="/banggia">bản giá</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link  " href="/gioithieu">contact us</a>
                </li>
                <li class="nav-item">

                @if(Session::has('currentUser'))
                    <li class="nav-item dropdown ">
                        <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                            {{--<img src="{{Session::get('currentPatient')->avatar}}" class="user-image img-circle" alt="User Image"--}}
                                 {{--class="img-fluid img-responsive" style="max-height: 25px;">--}}

                        </a>
                        <ul class="dropdown-menu"
                            style="position: absolute;right: 0;left: auto;background-color: whitesmoke">
                            <!-- User image -->

                            <li class="user-header">
                                <div class="container" style=";padding:10px 0px; ">
                                    <div class="row">
                                        <div class="col-sm-4 hoverImg" style="float: left;padding-left: 20px;">
                                            <img src="{{Session::get('currentPatient')->avatar}}"
                                                 class="img-circle img-responsive img-fluid borderImg "  id="divAcc1" alt="User Image"   width="70px;">
                                        </div>
                                        <div class="col-sm-7 " style="float: left ;padding-left: 0;padding-right: 0;">

                                            @foreach(\Session::get('listPatient') as $key => $value)
                                            <img src="{{ $value->avatar }}" style="margin: 0.3em;"
                                            class="img-circle img-responsive img-fluid" alt="User Image"  id="{!! $value->id !!}" width="40px;" onclick="changeInfo(this.id)">
                                            @endforeach
                                        </div>

                                        {{--@foreach(\Session::get('listPatient') as $key => $value)--}}


                                                {{--<img src="{{ $value->avatar }}"--}}
                                                     {{--class="img-circle img-responsive img-fluid" alt="User Image"  id="{!! $value->id !!}" width="50px;" onclick="changeInfo(this.id)">--}}

                                        {{--@endforeach--}}
                                                {{--<img src="{{ $value->avatar }}"--}}
                                                     {{--class="img-circle img-responsive img-fluid" alt="User Image"  id="{!! $value->id !!}" width="50px;" onclick="changeInfo(this.id)">--}}
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                            </li>
                            <li class="user-header" id="acc1" style="display: block">
                                <p>

                                    {{--{{Session::get('currentPatient')->name}}--}}
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

                            <li class="a-hover">
                                <a href="#">Lịch sử khám bệnh</a>
                            </li>
                            <li class="gachngang"></li>
                            <li class="  a-hover">
                                <a href="/danhsachchitra"><span>Danh sách chi trả</span></a>
                            </li>
                            <li class="gachngang"></li>
                            <li class=" a-hover">
                                <a href="#/lichsubenhan/1"><span>Lịch hẹn</span></a>
                            </li>

                            <!-- Menu Body -->

                            <!-- Menu Footer-->
                            <li class="user-footer" style="background-color: whitesmoke;padding-top: 5px;">

                                <div class="pull-left" style="padding-left: 1em;">
                                    <a href="/myProfile/1" class="btn btn-success btn-flat">Profile</a>
                                </div>
                                <div class="pull-right" style="padding-right: 1em;">
                                    <a href="/signOut" class="btn btn-success btn-flat">Sign out</a>
                                </div>

                            </li>
                        </ul>
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
                                                    <input type="text" class="form-control" placeholder="Phone" name="phone" value="{{ old('phone') }}"
                                                           required autofocus>
                                                    <span class="glyphicon glyphicon-phone form-control-feedback"></span>
                                                    @if ($errors->has('phone'))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first('phone') }} </strong>
                                                        </span>
                                                    @endif
                                                </div>
                                                <div class="form-group has-feedback">
                                                    <input type="password" class="form-control" placeholder="Password" name="password" required>
                                                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                                                    @if ($errors->has('password'))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first('password') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                                @if (\Session::has('fail'))
                                                    <span class="help-block has-error" style="color: #dd4b39">
                                                       <strong>{!! \Session::get('fail') !!} </strong>
                                                </span>
                                                @endif
                                                <div class="row">
                                                    <!-- /.col -->
                                                    <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
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
<div class="top">

    <!-- start menu -->

    <!-- end menu -->

    <!-- start banner -->
    <div class="banner">
        <div id="carousel" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#carousel" data-slide-to="0" class="active"></li>
                <li data-target="#carousel" data-slide-to="1"></li>
                <li data-target="#carousel" data-slide-to="2"></li>
            </ol>
            <div class="carousel-inner" role="listbox">
                <div class="carousel-item active hinhmot">

                    <div class="carousel-caption textbanner">
                        <div class="goi">
                            <h3 class="tdbanner1">Phúc Đẹp trai</h3>
                            <h4 class="tdbanner2">Dental PHúc Tài Lực Trịnh</h4>
                            <div class="nutbanner">
                                <a href="" class="btn btn-outline-secondary">Đặt Lịch ngay</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="carousel-item  hinhhai">
                    <div class="carousel-caption textbanner">
                        <div class="goi">
                            <h3 class="tdbanner1">Phúc Đẹp trai</h3>
                            <h4 class="tdbanner2">Dental PHúc Tài Lực Trịnh</h4>
                            <div class="nutbanner">
                                <a href="" class="btn btn-outline-secondary">Đặt Lịch ngay</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="carousel-item  hinhba">
                    <div class="carousel-caption textbanner">
                        <div class="goi">
                            <h3 class="tdbanner1">Phúc Đẹp trai</h3>
                            <h4 class="tdbanner2">Dental PHúc Tài Lực Trịnh</h4>
                            <div class="nutbanner">
                                <a href="" class="btn btn-outline-secondary">Đặt Lịch ngay</a>
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
<div class="container" style="margin-top: 30px;margin-bottom: 50px;">
    <div class="row">
        <div class="col-sm-8 push-sm-2 text-xs-center Bacsititle">
            <h3><strong>CÔNG NGHỆ PHẪU THUẬT THẨM MỸ HOT NHẤT</strong></h3>
            <div class="gach">
                <div class="tron"></div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-3 motmon">
            <img src="/assets/images/HomePage/implent.jpg" alt="" class="img-fluid img-responsive">
            <div class="tieude"><a href="">Trồng răng implent</a></div>
            <div>Trồng implent với công nghệ tiên tiến của Nhật Bản <a href="/tintuc/7"> Chi tiết</a></div>
        </div>
        <div class="col-sm-3 motmon">
            <img src="/assets/images/HomePage/rangsu.jpg" alt="" class="img-fluid img-responsive">
            <div class="tieude"><a href="">Làm răng sứ</a></div>
            <div>Răng sứ được nhập khẩu từ Anh và Pháp mang đến sự an tâm và vẻ đẹp thẩm mỹ rạng ngời<a href="/tintuc/8"> Chi tiết</a></div>
        </div>
        <div class="col-sm-3 motmon">
            <img src="/assets/images/HomePage/taytrangrag.jpg" alt="" class="img-fluid img-responsive">
            <div class="tieude"><a href="">Tẩy Trắng Răng</a></div>
            <div>Quy trình tẩy trắng nhanh và không đau mang lại cảm giác tự tin với nụ cười tỏa sáng <a href="/tintuc/9">Chi tiết </a></div>
        </div>
        <div class="col-sm-3 motmon">
            <img src="/assets/images/HomePage/nienrang.jpg" alt="" class="img-fluid img-responsive">
            <div class="tieude"><a href="">Niền Răng</a></div>
            <div>Niền răng giúp nụ cười tự tin tỏa sáng trước mọi ánh nhìn , đồng thời mang lại sự cân đối<a href="/tintuc/10"> Chi tiết</a></div>
        </div>
    </div>
</div>
<!-- dich vu noi bat -->
<div class="container" style="margin-top: 30px;margin-bottom: 50px;">
    <div class="row">
        <div class="col-sm-8 push-sm-2 text-xs-center Bacsititle">
            <h3><strong>QUY TRÌNH THĂM KHÁM WECARE</strong></h3>
            <div class="gach">
                <div class="tron"></div>
            </div>
        </div>
    </div>
    <div class="row" style="display: inline-flex;">
        <div class="col-sm-3">
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
        <div class="col-sm-3">
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
        <div class="col-sm-3">
            <div class="daubep">
                <div class="tren" style="max-height: 160px;">
                    <img src="/assets/images/QuyTrinhKham/buoc3.jpg" alt="" class="img-fluid"
                         style="max-height: 165px;">
                </div>
                <div class="duoi text-xs-center">
                    <h4 class="textdaubep">X-QUANG-CHUẨN ĐOÁN</h4>
                    <p class="" style="text-align:justify;">Với thiết bị hiện đại và kinh nghiệm lâu năm của các nha sĩ,
                        quí khách có thể biết được chính xác tình trạng răng và cách điều trị<a href="#"> ... </a></p>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
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
        <img src="/assets/images/HomePage/Maymoc.jpg" alt="" class="img-responsive"
             style=" width: 100%;max-height:450px;">
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
    <div class="row col-sm">
        <div class="col-sm-4  motmon" style="float: left;"><img src="/assets/images/HomePage/pay1.PNG" alt=""
                                                                class="img-fluid img-responsive"
                                                                style=" width: 100%;max-height:300px;"></div>
        <div class="col-sm-4 motmon"><img src="/assets/images/HomePage/pay2.PNG" alt="" class="img-responsive"
                                          style=" width: 100%;max-height:300px;"></div>
        <div class="col-sm-4 motmon"><img src="/assets/images/HomePage/pay3.PNG" alt="" class="img-responsive"
                                          style=" width: 100%;max-height:300px;"></div>
    </div>
    <!-- end phuong thuc thanh toan -->
</div>
<!-- end Feedback -->

<!-- end liên hệ -->
<!-- footer -->
<div class="footer" style="background: url(/assets/images/HomePage/backgroundfooter.jpg);">
    <div class="contact" id="contact">
        <div class="container">
            <div class="row">
                <div class="col-sm-4">
                    <div><img src="/assets/images/HomePage/logo.png" alt=""></div>
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
</div>

</div>
<!-- end footer -->

</body>
</html>
<script>
    $(document).ready( function(){

        var phone = '{{$errors->first('phone')}}';
        var pass = '{{$errors->first('password')}}';
        if(phone){
            $("#drop").toggle();
            $(document).click(function(){
                $("#drop").toggle();
            });
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

</script>