<!DOCTYPE html>
<html lang="en">
<head>
     <title>Thông tin cá nhân</title>
    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/png" href="/assets/images/icon/fap16.png"/>
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
<nav class="navbar navbar-light navbar-fixed-top bg-faded navVisible thanhmenu" style="position: static;" id="navHeader">
    <div class="container">
        <button class="navbar-toggler hidden-sm-up float-xs-right" type="button" data-toggle="collapse"
                data-target="#navmn">
        </button>

        <div class="collapse navbar-toggleable-xs" id="navmn">
              <a class=" logo" href="/" style="padding-top: 10px;"><img src="/assets/images/Logo/logo.png" class="centerThing img-responsive img-fruid" style="width: 100%;max-width: 55px;float: left;padding-top: 7px;"    ></a>
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
                    <a class="nav-link  " href="/bang-gia">Dịch vụ</a>
                </li>
                
                <li class="nav-item">

                @if(Session::has('currentUser'))
                    <li class="nav-item dropdown ">
                        <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                            <img src="{{Session::get('currentPatient')->avatar}}" class="user-image img-circle" alt="User Image"
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
                                                 class="img-circle img-responsive img-fluid borderImg "  id="divAcc1" alt="User Image"   width="50px;">
                                        </div>
                                        @foreach(\Session::get('listPatient') as $key => $value)
                                        <div class="col-sm-2"  >

                                            <img src="{{ $value->avatar }}"
                                                 class="img-circle img-responsive img-fluid" alt="User Image"  id="{!! $value->id !!}" width="50px;" onclick="changeInfo(this.id)">
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
           <a class=" logo" href="/" style="padding-top: 10px;"><img src="/assets/images/Logo/logo.png" class="centerThing img-responsive img-fruid" style="width: 100%;max-width: 55px;float: left;padding-top: 7px;"    ></a>
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
                    <a class="nav-link  " href="/bang-gia">Dịch vụ</a>
                </li>
                
                <li class="nav-item">

                @if(Session::has('currentUser'))
                    <li class="nav-item dropdown ">
                        <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                            <img src="{{Session::get('currentPatient')->avatar}}" class="user-image img-circle" alt="User Image"
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
                                                 class="img-circle img-responsive img-fluid borderImg "  id="divAcc1" alt="User Image"   width="50px;">
                                        </div>
                                        @foreach(\Session::get('listPatient') as $key => $value)
                                        <div class="col-sm-2"  >

                                            <img src="{{ $value->avatar }}"
                                                 class="img-circle img-responsive img-fluid" alt="User Image"  id="{!! $value->id !!}" width="50px;" onclick="changeInfo(this.id)">
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
<div class="container" >
    <div class="row">
        <div class="col-sm-8 push-sm-2 text-xs-center Bacsititle">
            <h3><strong>Thông tin cá nhân</strong></h3>
            <div class="gach">
                <div class="tron"></div>
            </div>
        </div>
    </div>
    <div class="row" style="background-color: whitesmoke;">
        <div class="col-sm-2">
            <div><img src="{{$patient->avatar}}" alt="" class="img-responsive img-fluid" style="text-align: center;"></div>
        </div>
        <div class="col-sm-4">
            <div>
                <div class="row" style="padding: 10px;">
                    <div class="col-sm-4">Họ và Tên :</div>
                    <div class="col-sm-8">{{$patient->name}}</div>
                </div>
                <div class="row" style="padding: 10px;">
                    <div class="col-sm-4">Địa chỉ :</div>
                    <div class="col-sm-8">{{$patient->address}} </div>
                </div>
                <div class="row" style="padding: 10px;">
                    <div class="col-sm-4">Năm Sinh :</div>
                    <div class="col-sm-8">{{$patient->date_of_birth}}</div>
                </div>
                <div class="row" style="padding: 10px;">
                    <div class="col-sm-4">Điện thoại :</div>
                    <div class="col-sm-8">{{$patient->phone}}</div>
                </div>
                <div class="row" style="padding: 10px;">
                    <div class="col-sm-4">Giới tính :</div>
                    <div class="col-sm-8">{{$patient->gender}}</div>
                </div>
                <div class="row" style="padding: 10px;">
                    <div class="col-sm-4">Bệnh tiền sử :</div>
                    <div class="col-sm-8">
                    @if($anamnesis != null)
                        @foreach($anamnesis as $anam)
                        {{$anam->name->name}} 
                        @endforeach
                    @else
                 <p>Không có</p>
                    @endif
                    </div>
                </div>


            </div>

        </div>
        <div class="col-sm-6" >
        <div class="row"><h4 style="color: blue;text-align: center;">Danh sách lịch hẹn tương lai</h4></div>
           
             
           
            <table class="table table-striped table-bordered Mytable-hover" style="text-align: center;overflow-x:auto;">
    <thead>
      <tr>
        <th>No.</th>
        <th>Ngày</th>
        <th>Số thứ tự</th>
        <th>Giờ</th>
      </tr>
    </thead>
    <tbody>
     @foreach($listAppointment as $key => $appointment)
      <tr>
        <td>{{$key}}</td>
        <td>{{$appointment->dateComming}} </td>
        <td>{{$appointment->numerical_order}}</td>
        <td>{{$appointment->timeComming}} </td>
      </tr>
        @endforeach

    </tbody>
  </table>
        </div>
      
    </div>
    <!-- <div class="row">
        <div class="col-sm-8 push-sm-2 text-xs-center Bacsititle">
            <h3><strong>Lịch hẹn</strong></h3>
            <div class="gach">
                <div class="tron"></div>
            </div>
        </div>
    </div> -->
  
</div>
 
<!-- footer -->
<div class="footer" style="background: url(/assets/images/footer2.jpg);">
    <div class="contact" id="contact">
        <div class="container">
            <div class="row">
                <div class="col-sm-4">
                    <div><img src="/assets/images/HomePage/footer2.png" alt="" class="img-responsive img-fruid"></div>
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
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
    $(document).ready( function(){
         <?php if (Session::has('success')): ?>
          swal("Thay đổi ảnh thành công!", "", "error");  
        <?php endif ?>
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
    function validate(){
         var linkImg = document.getElementById('avatar').value;
       if($.trim(linkImg) == ''){
             swal("Vui lòng chọn ảnh!", "", "error");
        } 
        else{
            document.getElementById('ChangeAvatar').submit();      
        }
        
    }
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
    // particle.min.js hosted on GitHub
    // Scroll down for initialisation code

    
</script>