<!DOCTYPE html>
<html lang="en"><head>
<title>Bảng Giá Tham Khảo</title>
<meta charset="utf-8">
 
<meta name="viewport" content="width=device-width, initial-scale=1">  
<script type="text/javascript" src="/assets/user/bootstrap/bootstrap.js"></script>
<script src="/assets/user/js/jquery-3.2.1.js"></script>
<script src="/assets/user/js/jquery.easing.1.3.js"></script>
<script src="https://datatables.yajrabox.com/js/jquery.min.js"></script>
<script src="https://datatables.yajrabox.com/js/bootstrap.min.js"></script>
<script src="https://datatables.yajrabox.com/js/jquery.dataTables.min.js"></script>
<script src="https://datatables.yajrabox.com/js/datatables.bootstrap.js"></script>

<link rel="stylesheet" href="/assets/user/js/jquery.fancybox.css" />
<script src="/assets/user/js/jquery.fancybox.js"></script>

<script type="text/javascript" src="/assets/user/js/myjs.js"></script>
<link href="https://fonts.googleapis.com/css?family=Italianno|Open+Sans:300,400,600,700,800&amp;subset=vietnamese" rel="stylesheet">
<link rel="stylesheet" href="/assets/user/bootstrap/bootstrap.css">
<!-- <link rel="stylesheet" href="http://gsgd.co.uk/sandbox/jquery/easing/jquery.easing.1.3.js"> -->
<link rel="stylesheet" href="/assets/user/bootstrap/font-awesome.css">
<link rel="stylesheet" href="/assets/user/css/mycss.css">

 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link href="https://datatables.yajrabox.com/css/datatables.bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
</head>
<body>
 	<div class="top">
	<!-- start menu -->
	<nav class="navbar navbar-light bg-faded thanhmenu" style="background-color: blue;">
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
	<div class="container" >
	<div class="row" style="background: url(/assets/images/banggia.jpg);height: 7em;">
			<div class="col-sm-8 push-sm-2 text-xs-center Bacsititle" >
			<h1 style="margin-top: 0.8em;color: white"><strong>Bảng giá tham khảo</strong></h3>
			</div>
	</div>
		<div class="row" >
			
			<table id="dup-table" class="table text-center">
      <thead>
      <tr style="background-color: #eee;">
      <td class="col-sm-1">ID</td>
      <td class="col-sm-2">Tên dịch vụ</td>
      <td class="col-sm-9">Mô Tả</td>
      </tr>
      </thead>
      </table> 
		</div>
		 
	</div> 
	<div class="footer" style="background: url(/assets/images/HomePage/backgroundfooter.jpg);margin-top: 30px;">
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
<script src="https://datatables.yajrabox.com/js/jquery.dataTables.min.js"></script>
<script src="https://datatables.yajrabox.com/js/datatables.bootstrap.js"></script> 
<script type="text/javascript">
	 $(function() {
        $('#dup-table').DataTable({
        processing: true,
        serverSide: true,
        order: [[ 0, "desc" ]],
        bLengthChange:true,
        pageLength: 5,
        ajax: '/getDB',
        columns : [
          
              {data: 'id'},
              {data: 'name'},
              {
                  
                  data: 'description'
              },
            ],
        });
    });
       
</script>