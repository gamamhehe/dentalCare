<!DOCTYPE html>
<html lang="en"><head>
<title> Trang chủ </title>
<meta charset="utf-8">
 
<meta name="viewport" content="width=device-width, initial-scale=1">  
<script type="text/javascript" src="/assets/user/bootstrap/bootstrap.js"></script>
<script src="/assets/user/js/jquery-3.2.1.js"></script>
<script src="/assets/user/js/jquery.easing.1.3.js"></script>

<link rel="stylesheet" href="/assets/user/js/jquery.fancybox.css" />
<script src="/assets/user/js/jquery.fancybox.js"></script>

<script type="text/javascript" src="/assets/user/js/myjs.js"></script>
<link href="https://fonts.googleapis.com/css?family=Italianno|Open+Sans:300,400,600,700,800&amp;subset=vietnamese" rel="stylesheet">
<link rel="stylesheet" href="/assets/user/bootstrap/bootstrap.css">
<!-- <link rel="stylesheet" href="http://gsgd.co.uk/sandbox/jquery/easing/jquery.easing.1.3.js"> -->
<link rel="stylesheet" href="/assets/user/bootstrap/font-awesome.css">
<link rel="stylesheet" href="/assets/user/css/mycss.css">
</head>
<body>
<div class="top">
	<!-- start menu -->
	<nav class="navbar navbar-light navbar-fixed-top bg-faded thanhmenu" style="background-color: blue;">
		<div class="container">
			<button class="navbar-toggler hidden-sm-up float-xs-right" type="button" data-toggle="collapse" data-target="#navmn">
			</button>
			
			<div class="collapse navbar-toggleable-xs" id="navmn">
				<!-- <a class="navbar-brand logo" href="#"><img src="images/icon/logo.png" alt=""></a> -->
				<ul class="nav navbar-nav float-sm-right">
					<li class="nav-item active">
						<a class="nav-link c1" href="#">Giới Thiệu</a>
					</li>
					<li class="nav-item">
						<a class="nav-link c2" href="/doctorList">Chuyên Gia</a>
					</li>
					<li class="nav-item">
						<a class="nav-link c3" href="#ourmenu">Event</a>
					</li>
					<li class="nav-item">
						<a class="nav-link c6" href="#contact">dịch vụ</a>
					</li>
					<li class="nav-item">
						<a class="nav-link c6" href="#contact">bản giá</a>
					</li>
					<li class="nav-item">
						<a class="nav-link c6" href="#contact">contact us</a>
					</li>
				</ul>
			</div>
		</div>
	</nav> 
	<!-- end menu -->

	
</div>
 
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
		<div class="textheader spacebottom">
			 Nha Khoa KIM quy tụ hơn 100 bác sĩ có chứng chỉ hành nghề, nhiều năm kinh nghiệm, tốt nghiệp răng hàm mặt trong và ngoài nước, đã từng học tập cũng như tu nghiệp nhiều năm tại các nước có nền nha khoa phát triển bậc nhất trên thế giới. Với kiến thức chuyên môn vững vàng cùng đôi bàn tay khéo léo, tận tâm với nghề, luôn áp dụng theo quy trình chuẩn quốc tế, các bác sĩ luôn mang đến kết quả tốt nhất cho khách hàng. 
		</div>
		<div class="col-sm-10 divcenter " style="width: 100%"> 
		<img class="centerThing"  src="/assets/images/DoctorPage/Trao-giai-bac-si.jpg" alt="" class="img-fluid img-responsive" width="100%">
		</div>
		
		 <br>
		 <em style="text-align: center;">Từ trái qua phải hàng đứng Gs Jim Yuan( ĐH Toronto Canada), Ts Grace Eun A Kim( ÚC), Ts ManingKy ( Hà Lan), Ths Bs Nguyen Huu Nam ( Viet Nam), Gs Ts Dong-Seok- Sohn ( Hàn Quốc), Ts Eric Park( Mỹ) Hàng ngồi là các bác sĩ được tốt nghiệp sau chương trình đào tạo chuyển giao công nghệ ,các học viên là những bác sĩ của Ấn Độ, Trung quốc, Thái lan, Úc , Hàn Quốc, Hà lan, Mỹ, và Việt Nam.</em>
		
	</div>
	<!-- motbacsi -->
	@foreach($doctors as $doctor)
		@if($doctor->id %2 ==0 )
	 	 <div class="row"  style="background-color: #eee;">
		<div class="" style="width: 100%;">
			<div class="modaltitle">
				<strong>{{$doctor->specialty}} :{{$doctor->name}}</strong>
			</div>
			<div class="row" >
				
				<div class="col-sm-4"  >
					<img class="centerThing img imgdentist"  src="{{$doctor->avatar}}" alt="" class="img-fluid img-responsive" >
				</div>
			<div class="col-sm-8 docdescript"><p style="padding-left: 4em;">{{$doctor->description}}</p></div>
			</div>
		</div>
	</div>
		@else 
 	<div class="row"  style="background-color: #eee;">
		<div class="" style="width: 100%;">
			<div class="modaltitle">
				<strong>{{$doctor->specialty}} :{{$doctor->name}}</strong>
			</div>
			<div class="row" >
				<div class="col-sm-8 docdescript resON"><p style="padding-left: 4em;">{{$doctor->description}}</p></div>
				<div class="col-sm-4"  >
					<img class="centerThing img imgdentist"  src="{{$doctor->avatar}}" alt="" class="img-fluid img-responsive" >
				</div>
				<div class="col-sm-8 docdescript resOFF"  ><p style="padding-left: 4em;">{{$doctor->description}}</p></div>
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
<!-- 
font-family: 'Italianno', cursive;
font-family: 'Open Sans', sans-serif; 
-->