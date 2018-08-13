<!DOCTYPE html>
<html lang="en"><head>
<title> Đội ngũ bác sĩ </title>
<meta charset="utf-8">

<meta name="viewport" content="width=device-width, initial-scale=1">
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
<!-- <link rel="stylesheet" href="http://gsgd.co.uk/sandbox/jquery/easing/jquery.easing.1.3.js"> -->
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
                                                     
                                                </div>
                                                <div class="form-group has-feedback">
                                                    <input type="password" class="form-control" placeholder="Password" name="password" required>
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
                    <a class="nav-link  " href="/su-kien">Sự kiện</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link  " href="/bang-gia">Bảng giá</a>
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
                                                     
                                                </div>
                                                <div class="form-group has-feedback">
                                                    <input type="password" class="form-control" placeholder="Password" name="password" required>
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
                <div>ĐĂNG KÝ TƯ VẤN</div>

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
                <textarea name="guestNote" id="guestNote" style="resize: none;width: 100%" rows="4" placeholder="Nhu cầu khi khám"></textarea>
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
 
	<!-- div bac si -->
<div class="container" style="margin-top: 50px;margin-bottom: 50px;background-image: ">
	<div class="row" style="padding-top: 2em;">
			<div class="col-sm-8 push-sm-2 text-xs-center Bacsititle">
				<h3><strong>ĐỘI NGŨ BÁC SĨ CHUYÊN SÂU VỀ NHA KHOA  </strong></h3>
				<div class="gach">
					<div class="tron"></div>
				</div>
			</div>
	</div>

	
	<div class="row spacebottom">
		<div class="col-sm-10 divcenter " style="width: 180%">
		<img class="centerThing"  src="/assets/images/DoctorPage/Trao-giai-bac-si.jpg" alt="" class="img-fluid img-responsive" width="80%">
		</div>
		
		 <br>
		 <em style="text-align: center;">Từ trái qua phải hàng đứng Gs Jim Yuan( ĐH Toronto Canada), Ts Grace Eun A  ( ÚC), Ts ManingKy ( Hà Lan), Ths Bs Nguyen Huu Nam ( Viet Nam), Gs Ts Dong-Seok- Sohn ( Hàn Quốc), Ts Eric Park( Mỹ) Hàng ngồi là các bác sĩ được tốt nghiệp sau chương trình đào tạo chuyển giao công nghệ ,các học viên là những bác sĩ của Ấn Độ, Trung quốc, Thái lan, Úc , Hàn Quốc, Hà lan, Mỹ, và Việt Nam.</em>
		
	</div>
	<!-- motbacsi -->
	@foreach($doctors as $doctor)
		@if($doctor->id %2 ==0 )
	 	 <div class="row"  style="background-color: #eee;">
		<div class="" style="width: 100%;">
			<div class="modaltitle">
				<strong>{{$doctor->degree}} :{{$doctor->name}}</strong>
			</div>
			<div class="row" >
				
				<div class="col-sm-4"  >
					<img class="centerThing img imgdentist"  src="{{$doctor->avatar}}" alt="" class="img-fluid img-responsive" >
				</div>
			<div class="col-sm-8 docdescript"><p style="padding-left: 0em;">Tốt nghiệp Đại học Y Dược TPHCM (chuyên ngành Bác sĩ Răng Hàm Mặt).
                    Chuyên gia cấy ghép implant (Hoàn thành khóa đào tạo cắm ghép implant tại Singapore).
                    Hơn 5 năm kinh nghiệm làm việc tại Bệnh viện Quận 2, Bệnh viện Răng Hàm Mặt TP.HCM…</p></div>
			</div>
		</div>
	</div>
		@else 
 	<div class="row"  style="background-color: #eee;">
		<div class="" style="width: 100%;">
			<div class="modaltitle">
				<strong>{{$doctor->degree}} :{{$doctor->name}}</strong>
			</div>
			<div class="row" >
				<div class="col-sm-8 docdescript resON"><p style="padding-left: 4em;">Tốt nghiệp Đại Học Y Hà Nội (Chuyên ngành Bác sĩ Răng Hàm Mặt).
                        Chứng chỉ đào tạo liên tục chuyên ngành phục hình răng, chứng chỉ đào tạo cấy ghép implant tại Bệnh viện Răng Hàm Mặt Trung Ương TP.HCM.
                        Hơn 5 năm kinh nghiệm.</p></div>
				<div class="col-sm-4"  >
					<img class="centerThing img imgdentist"  src="{{$doctor->avatar}}" alt="" class="img-fluid img-responsive" >
				</div>
				<div class="col-sm-8 docdescript resOFF"  ><p style="padding-left: 4em;">Tốt nghiệp Đại Học Y Hà Nội (Chuyên ngành Bác sĩ Răng Hàm Mặt).
                        Chứng chỉ đào tạo liên tục chuyên ngành phục hình răng, chứng chỉ đào tạo cấy ghép implant tại Bệnh viện Răng Hàm Mặt Trung Ương TP.HCM.
                        Hơn 5 năm kinh nghiệm.</p></div>
			</div>
		</div>
	</div>
		@endif
	
	@endforeach
	 
</div>
		<!-- end div bac si -->
		<!-- dich vu noi bat -->
<!-- <div class="container" style="margin-top: 30px;margin-bottom: 50px;background-image: ">
	<div class="row">
			<div class="col-sm-8 push-sm-2 text-xs-center Bacsititle">
				<h3><strong>DỊCH VỤ NỔI BẬT - PRomotion ???</strong></h3>
				<h4>THẨM MỸ RĂNG HÀM MẶT ĐẦU NGÀNH VIỆT NAM</h4>
				<div class="gach">
					<div class="tron"></div>
				</div>
			</div>
	</div>
	
</div> -->
 
	<!-- footer -->
<div class="footer" style="background: url(/assets/images/HomePage/backgroundfooter.jpg);">
	<div class="contact" id="contact">
		<div class="container">
			 <div class="row">
			 	<div class="col-sm-4">
			 		<div><img src="/assets/images/HomePage/logo.png" alt=""></div><br>
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
			 			<a class="chidan" rel="nofollow" target="_blank" href="https://www.google.com/maps/place/B%E1%BB%87nh+Vi%E1%BB%87n+Th%E1%BA%A9m+M%E1%BB%B9+Kangnam/@21.000406,105.8297107,17z/data=!4m13!1m7!3m6!1s0x3135ac8758878c1f:0x8a59d1e808ee7392!2zMTkwIFRyxrDhu51uZyBDaGluaCwgS2jGsMahbmcgVGjGsOG7o25nLCDEkOG7kW5nIMSQYSwgSMOgIE7hu5lpLCBWaeG7h3QgTmFt!3b1!8m2!3d21.002795!4d105.828991!3m4!1s0x3135ac7d0b3e238b:0xdf9ae7b52fbbdef!8m2!3d21.0003971!4d105.8305875">190 Trường Chinh - Đống Đa - Hà Nội</a>
			 		</div>
			 	</div>
			 	<div class="col-sm-4">
			 		<div class="place">Hồ Chí Minh</div>
			 		<div>"Tel:"
			 			<a id="callme" onclick="ga('send', 'event', 'Phone', 'Click', 'Hotline');" href="tel:02473006466">024.73.00.64.66</a><br>
			 			Mobile:<a class="zalovb" id="callme" onclick="ga('send', 'event', 'Phone', 'Click', 'Hotline');" href="tel:0968999777" rel="nofollow">0968.999.777</a><hr>
			 		</div>
			 		<div>
			 			<a class="chidan" rel="nofollow" target="_blank" href="https://www.google.com/maps/place/B%E1%BB%87nh+Vi%E1%BB%87n+Th%E1%BA%A9m+M%E1%BB%B9+Kangnam/@21.000406,105.8297107,17z/data=!4m13!1m7!3m6!1s0x3135ac8758878c1f:0x8a59d1e808ee7392!2zMTkwIFRyxrDhu51uZyBDaGluaCwgS2jGsMahbmcgVGjGsOG7o25nLCDEkOG7kW5nIMSQYSwgSMOgIE7hu5lpLCBWaeG7h3QgTmFt!3b1!8m2!3d21.002795!4d105.828991!3m4!1s0x3135ac7d0b3e238b:0xdf9ae7b52fbbdef!8m2!3d21.0003971!4d105.8305875">190 Trường Chinh - Quận 12 - TP.Hồ Chí Minh</a>
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