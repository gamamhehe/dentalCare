<!DOCTYPE html>
<html lang="en"><head>
<title> Giới thiệu </title>
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
	<link rel="stylesheet" href="/assets/user/bootstrap/font-awesome.css">
	<link rel="stylesheet" href="/assets/user/css/mycss.css">
</head>
<body>
<nav class="navbar navbar-light     bg-faded thanhmenu">
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
                    <a class="nav-link  " href="/lien-he">Liên hệ</a>
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
                                    <a href="/thong-tin-ca-nhan" class="btn btn-success btn-flat">Profile</a>
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
	<!-- div bac si -->
<div class="container" style="margin-top: 50px;margin-bottom: 50px;background-image: ">
	<div class="row" style="padding-top: 2em;">
			<div class="col-sm-8 push-sm-2 text-xs-center Bacsititle">
				<h3><strong>CHUỖI HỆ THỐNG NHA KHOA HÀNG ĐẦU VIỆT NAM – UY TÍN VÀ CHẤT LƯỢNG</strong></h3>
				<div class="gach">
					<div class="tron"></div>
				</div>
			</div>
	</div>

	
	 <div class="entry-content" itemprop="text"> <article class="sv_st1"><h2 style="text-align: justify;">Với sứ mệnh giúp cho mọi khách hàng được tiếp cận những dịch vụ điều trị, thẩm mỹ nha khoa tiên tiến nhất trên thế giới ngay tại Việt Nam. Nha Khoa  đã không ngừng nỗ lực, nâng cao chất lượng và chuyên môn, đồng thời liên tục mở rộng cơ sở cho ra đời chuỗi hệ thống nha khoa hàng đầu Việt Nam, mang đến kết quả tối ưu nhất, an toàn nhất, làm hài lòng tất cả khách hàng khi đến thăm khám, điều trị.</h2><p style="text-align: justify;"><span style="color: #0000ff;"><strong><img class="alignnone size-full wp-image-2915     lazyloaded" src="https://nhakhoa.com/wp-content/uploads/2017/03/hot-moi-can-ho-1.gif" data-lazy-src="https://nhakhoa.com/wp-content/uploads/2017/03/hot-moi-can-ho-1.gif" alt="" width="41" height="22"><noscript><img class="alignnone size-full wp-image-2915" src="https://nhakhoa.com/wp-content/uploads/2017/03/hot-moi-can-ho-1.gif" alt="" width="41" height="22" /></noscript>XEM THÊM:</strong></span></p><p style="text-align: justify;"><strong><img class="alignnone size-full wp-image-2870     lazyloaded" src="https://nhakhoa.com/wp-content/uploads/2016/11/icon-1-1.png" data-lazy-src="https://nhakhoa.com/wp-content/uploads/2016/11/icon-1-1.png" alt="" width="14" height="14"><noscript><img class="alignnone size-full wp-image-2870" src="https://nhakhoa.com/wp-content/uploads/2016/11/icon-1-1.png" alt="" width="14" height="14" /></noscript>&nbsp;<a href="https://nhakhoa.com/nha-khoa--ky-ket-hop-tac-chuyen-mon-voi-waups-va-biotem.html">Nha khoa  ký kết hợp tác chuyên môn với WAUPS và Biotem</a></strong></p><p style="text-align: justify;"><strong><img class="alignnone size-full wp-image-2870     lazyloaded" src="https://nhakhoa.com/wp-content/uploads/2016/11/icon-1-1.png" data-lazy-src="https://nhakhoa.com/wp-content/uploads/2016/11/icon-1-1.png" alt="" width="14" height="14"><noscript><img class="alignnone size-full wp-image-2870" src="https://nhakhoa.com/wp-content/uploads/2016/11/icon-1-1.png" alt="" width="14" height="14" /></noscript> <a href="https://nhakhoa.com/khach-hang-dang-ky-trong-rang.html">3000 KH đăng ký trồng răng implant tại Nha Khoa  chỉ trong 1 tháng</a></strong></p><p style="text-align: justify;"><span style="color: #0000ff; font-size: 14pt; font-family: 'comic sans ms', sans-serif;"><strong>CHUỖI HỆ THỐNG KHANG TRANG – HIỆN ĐẠI</strong></span></p><p style="text-align: justify;">Nha Khoa  sở hữu hơn 30 cơ sở, phủ rộng khắp các tỉnh thành trên cả nước từ Hà Nội, TP. Hồ Chí Minh, Đồng Nai, Tiền Giang, Vũng Tàu… và liên tục phát triển, mở rộng thêm để giúp khách hàng dễ dàng tiếp cận những dịch vụ chăm sóc răng miệng tiêu chuẩn quốc tế ngay trong nước.</p><p style="text-align: center;"><img class="alignnone size-full wp-image-7312     lazyloaded" src="https://nhakhoa.com/wp-content/uploads/2017/12/toanha-binhduong.png" data-lazy-src="https://nhakhoa.com/wp-content/uploads/2017/12/toanha-binhduong.png" alt="" width="700" height="570" data-lazy-srcset="https://nhakhoa.com/wp-content/uploads/2017/12/toanha-binhduong.png 700w, https://nhakhoa.com/wp-content/uploads/2017/12/toanha-binhduong-555x452.png 555w" data-lazy-sizes="(max-width: 700px) 100vw, 700px" srcset="https://nhakhoa.com/wp-content/uploads/2017/12/toanha-binhduong.png 700w, https://nhakhoa.com/wp-content/uploads/2017/12/toanha-binhduong-555x452.png 555w" sizes="(max-width: 700px) 100vw, 700px"><noscript><img class="alignnone size-full wp-image-7312" src="https://nhakhoa.com/wp-content/uploads/2017/12/toanha-binhduong.png" alt="" width="700" height="570" srcset="https://nhakhoa.com/wp-content/uploads/2017/12/toanha-binhduong.png 700w, https://nhakhoa.com/wp-content/uploads/2017/12/toanha-binhduong-555x452.png 555w" sizes="(max-width: 700px) 100vw, 700px" /></noscript></p><p style="text-align: center;"><img class="alignnone size-full wp-image-7902     lazyloaded" src="https://nhakhoa.com/wp-content/uploads/2017/12/Không-gian-NK-bổ-sung-3.jpg" data-lazy-src="https://nhakhoa.com/wp-content/uploads/2017/12/Không-gian-NK-bổ-sung-3.jpg" alt="Địa chỉ làm răng implant" width="700" height="467" data-lazy-srcset="https://nhakhoa.com/wp-content/uploads/2017/12/Không-gian-NK-bổ-sung-3.jpg 700w, https://nhakhoa.com/wp-content/uploads/2017/12/Không-gian-NK-bổ-sung-3-555x370.jpg 555w" data-lazy-sizes="(max-width: 700px) 100vw, 700px" srcset="https://nhakhoa.com/wp-content/uploads/2017/12/Không-gian-NK-bổ-sung-3.jpg 700w, https://nhakhoa.com/wp-content/uploads/2017/12/Không-gian-NK-bổ-sung-3-555x370.jpg 555w" sizes="(max-width: 700px) 100vw, 700px"><noscript><img class="alignnone size-full wp-image-7902" src="https://nhakhoa.com/wp-content/uploads/2017/12/Không-gian-NK-bổ-sung-3.jpg" alt="Địa chỉ làm răng implant" width="700" height="467" srcset="https://nhakhoa.com/wp-content/uploads/2017/12/Không-gian-NK-bổ-sung-3.jpg 700w, https://nhakhoa.com/wp-content/uploads/2017/12/Không-gian-NK-bổ-sung-3-555x370.jpg 555w" sizes="(max-width: 700px) 100vw, 700px" /></noscript></p><p style="text-align: center;"><em>Chuỗi hệ thống Nha Khoa  với gần 30 cơ sở phủ rộng khắp từ Nam ra Bắc</em></p> </article><p style="text-align: justify;"><span style="font-size: 14pt; font-family: 'comic sans ms', sans-serif; color: #0000ff;"><strong>NHA KHOA SẠCH SẼ VÔ TRÙNG</strong></span></p><p style="text-align: justify;">Nha Khoa  đặc biệt chú trọng đến yếu tố vô trùng, nhằm đảm bảo tính an toàn, hiệu quả và tránh lây nhiễm chéo cho khách hàng. Điều này được thể hiện bằng việc mỗi ghế nha khoa là 1 phòng, mỗi khách hàng khi đến sẽ sắp xếp vào 1 phòng riêng biệt và mỗi khách hàng là 1 bộ tay khoan, bộ dụng cụ riêng. Đồng thời, Nha Khoa  cũng tiên phong xây dựng phòng vô trùng trung tâm – hấp dụng cụ chỉ thị màu, ngày hấp dụng cụ.</p><p style="text-align: center;"><img class="alignnone size-full wp-image-7270     lazyloaded" src="https://nhakhoa.com/wp-content/uploads/2017/01/IMG_0105.jpg" data-lazy-src="https://nhakhoa.com/wp-content/uploads/2017/01/IMG_0105.jpg" alt="" width="700" height="466" data-lazy-srcset="https://nhakhoa.com/wp-content/uploads/2017/01/IMG_0105.jpg 700w, https://nhakhoa.com/wp-content/uploads/2017/01/IMG_0105-555x369.jpg 555w" data-lazy-sizes="(max-width: 700px) 100vw, 700px" srcset="https://nhakhoa.com/wp-content/uploads/2017/01/IMG_0105.jpg 700w, https://nhakhoa.com/wp-content/uploads/2017/01/IMG_0105-555x369.jpg 555w" sizes="(max-width: 700px) 100vw, 700px"><noscript><img class="alignnone size-full wp-image-7270" src="https://nhakhoa.com/wp-content/uploads/2017/01/IMG_0105.jpg" alt="" width="700" height="466" srcset="https://nhakhoa.com/wp-content/uploads/2017/01/IMG_0105.jpg 700w, https://nhakhoa.com/wp-content/uploads/2017/01/IMG_0105-555x369.jpg 555w" sizes="(max-width: 700px) 100vw, 700px" /></noscript></p><p style="text-align: center;"><em>Tại Nha Khoa  mỗi ghế nha khoa là 1 phòng, mỗi khách hàng khi đến sẽ sắp xếp vào 1 phòng riêng biệt và mỗi khách hàng là 1 bộ tay khoan, bộ dụng cụ riêng</em></p> <article class="sv_st1"><p style="text-align: justify;"><span style="color: #0000ff; font-size: 14pt; font-family: 'comic sans ms', sans-serif;"><strong>HÀNG TRĂM THIẾT BỊ MÁY MÓC TIÊN TIẾN</strong></span></p><p style="text-align: justify;">Trang thiết bị máy móc là một trong những&nbsp;điểm mạnh vượt trội của Nha Khoa  mà rất ít địa chỉ nào có thể vượt qua được. Để chăm sóc sức khỏe răng miệng, điều trị và phục hình răng hàm mặt tốt nhất&nbsp;đến khách hàng,  đã&nbsp;nhập khẩu trực tiếp hàng trăm thiết bị, máy móc hiện đại từ những tập đoàn nha khoa uy tín trên thế giới như: Máy X Quang Conebeam CT 3D, máy Panorex – Cephalometric, công nghệ thiết kế răng sứ CAD/CAM 3D, máy in mẫu răng hàm mặt 3D, phần mềm phân tích Simplant 3D, công nghệ VCeph 3D, máy tẩy trắng răng Brite Smile…</p><p style="text-align: center;"><img class="alignnone size-full wp-image-7316     lazyloaded" src="https://nhakhoa.com/wp-content/uploads/2017/07/MG_5476.jpg" data-lazy-src="https://nhakhoa.com/wp-content/uploads/2017/07/MG_5476.jpg" alt="" width="700" height="466" data-lazy-srcset="https://nhakhoa.com/wp-content/uploads/2017/07/MG_5476.jpg 700w, https://nhakhoa.com/wp-content/uploads/2017/07/MG_5476-555x369.jpg 555w" data-lazy-sizes="(max-width: 700px) 100vw, 700px" srcset="https://nhakhoa.com/wp-content/uploads/2017/07/MG_5476.jpg 700w, https://nhakhoa.com/wp-content/uploads/2017/07/MG_5476-555x369.jpg 555w" sizes="(max-width: 700px) 100vw, 700px"><noscript><img class="alignnone size-full wp-image-7316" src="https://nhakhoa.com/wp-content/uploads/2017/07/MG_5476.jpg" alt="" width="700" height="466" srcset="https://nhakhoa.com/wp-content/uploads/2017/07/MG_5476.jpg 700w, https://nhakhoa.com/wp-content/uploads/2017/07/MG_5476-555x369.jpg 555w" sizes="(max-width: 700px) 100vw, 700px" /></noscript></p><p style="text-align: center;"><em>Máy X Quang Conebeam CT 3D ứng dụng trong cấy răng implant, phẫu thuật hàm</em></p><p style="text-align: center;"><img class="alignnone size-full wp-image-7313     lazyloaded" src="https://nhakhoa.com/wp-content/uploads/2017/12/IMG_9164.jpg" data-lazy-src="https://nhakhoa.com/wp-content/uploads/2017/12/IMG_9164.jpg" alt="" width="700" height="466" data-lazy-srcset="https://nhakhoa.com/wp-content/uploads/2017/12/IMG_9164.jpg 700w, https://nhakhoa.com/wp-content/uploads/2017/12/IMG_9164-555x369.jpg 555w" data-lazy-sizes="(max-width: 700px) 100vw, 700px" srcset="https://nhakhoa.com/wp-content/uploads/2017/12/IMG_9164.jpg 700w, https://nhakhoa.com/wp-content/uploads/2017/12/IMG_9164-555x369.jpg 555w" sizes="(max-width: 700px) 100vw, 700px"><noscript><img class="alignnone size-full wp-image-7313" src="https://nhakhoa.com/wp-content/uploads/2017/12/IMG_9164.jpg" alt="" width="700" height="466" srcset="https://nhakhoa.com/wp-content/uploads/2017/12/IMG_9164.jpg 700w, https://nhakhoa.com/wp-content/uploads/2017/12/IMG_9164-555x369.jpg 555w" sizes="(max-width: 700px) 100vw, 700px" /></noscript></p><p style="text-align: center;"><em>Máy X quang Panorex ứng dụng trong cấy răng implant, nhổ răng khôn, niềng răng, phẫu thuật hàm</em></p><p style="text-align: center;"><img class="alignnone size-full wp-image-7959     lazyloaded" src="https://nhakhoa.com/wp-content/uploads/2017/12/IMG_9181-e1515042040697.jpg" data-lazy-src="https://nhakhoa.com/wp-content/uploads/2017/12/IMG_9181-e1515042040697.jpg" alt="" width="700" height="467"><noscript><img class="alignnone size-full wp-image-7959" src="https://nhakhoa.com/wp-content/uploads/2017/12/IMG_9181-e1515042040697.jpg" alt="" width="700" height="467" /></noscript></p><p style="text-align: center;"><em>Máy X quang Cephalometric ứng dụng trong chỉnh nha – niềng răng, phẫu thuật hàm</em></p><p style="text-align: center;"><img class="alignnone size-full wp-image-7324     lazyloaded" src="https://nhakhoa.com/wp-content/uploads/2016/11/Rang-Ham-Mat-QTSG-3.jpg" data-lazy-src="https://nhakhoa.com/wp-content/uploads/2016/11/Rang-Ham-Mat-QTSG-3.jpg" alt="" width="700" height="466" data-lazy-srcset="https://nhakhoa.com/wp-content/uploads/2016/11/Rang-Ham-Mat-QTSG-3.jpg 700w, https://nhakhoa.com/wp-content/uploads/2016/11/Rang-Ham-Mat-QTSG-3-555x369.jpg 555w" data-lazy-sizes="(max-width: 700px) 100vw, 700px" srcset="https://nhakhoa.com/wp-content/uploads/2016/11/Rang-Ham-Mat-QTSG-3.jpg 700w, https://nhakhoa.com/wp-content/uploads/2016/11/Rang-Ham-Mat-QTSG-3-555x369.jpg 555w" sizes="(max-width: 700px) 100vw, 700px"><noscript><img class="alignnone size-full wp-image-7324" src="https://nhakhoa.com/wp-content/uploads/2016/11/Rang-Ham-Mat-QTSG-3.jpg" alt="" width="700" height="466" srcset="https://nhakhoa.com/wp-content/uploads/2016/11/Rang-Ham-Mat-QTSG-3.jpg 700w, https://nhakhoa.com/wp-content/uploads/2016/11/Rang-Ham-Mat-QTSG-3-555x369.jpg 555w" sizes="(max-width: 700px) 100vw, 700px" /></noscript></p><p style="text-align: center;"><em>Phần mềm phân tích Simplant 3D ứng dụng trong cấy răng implant</em></p><p style="text-align: center;"><img class="alignnone size-full wp-image-7317     lazyloaded" src="https://nhakhoa.com/wp-content/uploads/2017/07/MG_5540.jpg" data-lazy-src="https://nhakhoa.com/wp-content/uploads/2017/07/MG_5540.jpg" alt="" width="700" height="466" data-lazy-srcset="https://nhakhoa.com/wp-content/uploads/2017/07/MG_5540.jpg 700w, https://nhakhoa.com/wp-content/uploads/2017/07/MG_5540-555x369.jpg 555w" data-lazy-sizes="(max-width: 700px) 100vw, 700px" srcset="https://nhakhoa.com/wp-content/uploads/2017/07/MG_5540.jpg 700w, https://nhakhoa.com/wp-content/uploads/2017/07/MG_5540-555x369.jpg 555w" sizes="(max-width: 700px) 100vw, 700px"><noscript><img class="alignnone size-full wp-image-7317" src="https://nhakhoa.com/wp-content/uploads/2017/07/MG_5540.jpg" alt="" width="700" height="466" srcset="https://nhakhoa.com/wp-content/uploads/2017/07/MG_5540.jpg 700w, https://nhakhoa.com/wp-content/uploads/2017/07/MG_5540-555x369.jpg 555w" sizes="(max-width: 700px) 100vw, 700px" /></noscript></p><p style="text-align: center;"><em>Máy tẩy trắng răng Brite Smile</em></p><p style="text-align: justify;"><span style="color: #0000ff; font-size: 14pt; font-family: 'comic sans ms', sans-serif;"><b>HƠN 150 BÁC SĨ CÓ CHỨNG CHỈ HÀNH NGHỀ</b></span></p><p style="text-align: justify;">Nha Khoa  quy tụ hơn 100 bác sĩ có chứng chỉ hành nghề, nhiều năm kinh nghiệm, tốt nghiệp răng hàm mặt trong và ngoài nước, đã từng học tập cũng như&nbsp;tu nghiệp nhiều năm tại các nước có nền nha khoa phát triển bậc nhất trên thế giới.&nbsp;Với&nbsp;kiến thức chuyên môn vững vàng cùng đôi bàn tay khéo léo, tận tâm với nghề, luôn áp dụng theo quy trình chuẩn quốc tế, các bác sĩ luôn mang đến kết quả tốt nhất cho khách hàng.</p><p style="text-align: center;"><img class="alignnone size-full wp-image-7266     lazyloaded" src="https://nhakhoa.com/wp-content/uploads/2017/01/doingubsnkk-1-1.png" data-lazy-src="https://nhakhoa.com/wp-content/uploads/2017/01/doingubsnkk-1-1.png" alt="" width="700" height="403" data-lazy-srcset="https://nhakhoa.com/wp-content/uploads/2017/01/doingubsnkk-1-1.png 700w, https://nhakhoa.com/wp-content/uploads/2017/01/doingubsnkk-1-1-555x320.png 555w" data-lazy-sizes="(max-width: 700px) 100vw, 700px" srcset="https://nhakhoa.com/wp-content/uploads/2017/01/doingubsnkk-1-1.png 700w, https://nhakhoa.com/wp-content/uploads/2017/01/doingubsnkk-1-1-555x320.png 555w" sizes="(max-width: 700px) 100vw, 700px"><noscript><img class="alignnone size-full wp-image-7266" src="https://nhakhoa.com/wp-content/uploads/2017/01/doingubsnkk-1-1.png" alt="" width="700" height="403" srcset="https://nhakhoa.com/wp-content/uploads/2017/01/doingubsnkk-1-1.png 700w, https://nhakhoa.com/wp-content/uploads/2017/01/doingubsnkk-1-1-555x320.png 555w" sizes="(max-width: 700px) 100vw, 700px" /></noscript></p><p style="text-align: center;"><em>Nha Khoa  quy tụ hơn 150 bác sĩ có chứng chỉ hành nghề</em></p><p style="text-align: justify;">Bên cạnh đó,&nbsp;Nha Khoa  còn quy tụ hơn 600 điều dưỡng viên, phụ tá được đào tạo bài bản và chuyên nghiệp. Khi tới với chúng tôi, mỗi khách hàng sẽ được một bác sĩ trực tiếp thăm khám, tư vấn, điều trị và đội ngũ phụ tá nha khoa có nhiệm vụ hỗ trợ, thực hiện theo y lệnh của bác sĩ.</p><p style="text-align: justify;">Hợp tác với các bs trường Đại học Hàn Quốc, Canada, Mỹ về đào tạo chuyên môn cho các Bs Việt Nam nói riêng và 1 số nước khác. Từng bước thay đổi cách nhìn về chuyên môn của Việt Nam trên trường quốc tế</p><p style="text-align: center;"><img class="wp-image-9075 size-full aligncenter     lazyloaded" src="https://nhakhoa.com/wp-content/uploads/2018/03/Trao-giai-bac-si-700.jpg" data-lazy-src="https://nhakhoa.com/wp-content/uploads/2018/03/Trao-giai-bac-si-700.jpg" alt="" width="700" height="483" data-lazy-srcset="https://nhakhoa.com/wp-content/uploads/2018/03/Trao-giai-bac-si-700.jpg 700w, https://nhakhoa.com/wp-content/uploads/2018/03/Trao-giai-bac-si-700-555x383.jpg 555w" data-lazy-sizes="(max-width: 700px) 100vw, 700px" srcset="https://nhakhoa.com/wp-content/uploads/2018/03/Trao-giai-bac-si-700.jpg 700w, https://nhakhoa.com/wp-content/uploads/2018/03/Trao-giai-bac-si-700-555x383.jpg 555w" sizes="(max-width: 700px) 100vw, 700px"><noscript><img class="wp-image-9075 size-full aligncenter" src="https://nhakhoa.com/wp-content/uploads/2018/03/Trao-giai-bac-si-700.jpg" alt="" width="700" height="483" srcset="https://nhakhoa.com/wp-content/uploads/2018/03/Trao-giai-bac-si-700.jpg 700w, https://nhakhoa.com/wp-content/uploads/2018/03/Trao-giai-bac-si-700-555x383.jpg 555w" sizes="(max-width: 700px) 100vw, 700px" /></noscript></p><p style="text-align: center;"><em>Từ trái qua phải hàng đứng Gs Jim Yuan( ĐH Toronto Canada), Ts Grace Eun A ( ÚC), Ts ManingKy ( Hà Lan), Ths Bs Nguyen Huu Nam ( Viet Nam), Gs Ts Dong-Seok- Sohn ( Hàn Quốc), Ts Eric&nbsp; Park( Mỹ) Hàng ngồi là các bác sĩ được tốt nghiệp sau chương trình đào tạo chuyển giao công nghệ ,các học viên là những bác sĩ của Ấn Độ, Trung quốc, Thái lan, Úc , Hàn Quốc, Hà lan, Mỹ, và Việt Nam</em></p> </article> <article class="sv_st1"><p style="text-align: justify;"><span style="color: #0000ff; font-size: 14pt; font-family: 'comic sans ms', sans-serif;"><strong>ĐA DẠNG DỊCH VỤ ĐỈNH CAO</strong></span></p><p style="text-align: justify;">Nha Khoa  đã và đang ứng dụng thành công&nbsp;hàng loạt các dịch vụ nha khoa, điều trị, phục hình và thẩm mỹ răng hàm mặt hiện đại hàng đầu trên thế giới như: Cấy ghép implant, niềng răng – chỉnh nha, bọc răng sứ thẩm mỹ, điều trị cười hở lợi, phẫu thuật hàm hô móm vẩu, nhổ răng không đau, tẩy trắng răng, cạo vôi và đánh bóng, trám răng sâu, nội nha chữa tủy, điều trị viêm nha chu, tạo khóe miệng cười, đính đá vào răng, làm răng thỏ,&nbsp;nha khoa trẻ em…. &nbsp;giúp chăm sóc toàn diện sức khỏe răng miệng cho khách hàng trong cũng như ngoài nước.</p><p style="text-align: justify;">Tại Nha Khoa , các dịch vụ nha khoa đều được áp dụng theo quy trình chuẩn quốc tế, tuân thủ nghiêm ngặt các quy định của cơ quan y tế từ khâu thăm khám, tư vấn, chụp phim, đến điều trị. Nhờ đó, những bệnh lý, vấn đề của khách hàng sẽ được giải quyết nhanh nhất, tốt nhất, chuyên nghiệp nhất, tạo sự hài lòng cao về chất&nbsp;chất lượng dịch vụ.</p><p style="text-align: center;"><img class="alignnone size-full wp-image-7578     lazyloaded" src="https://nhakhoa.com/wp-content/uploads/2016/11/DSC08440-4.jpg" data-lazy-src="https://nhakhoa.com/wp-content/uploads/2016/11/DSC08440-4.jpg" alt="" width="700" height="465" data-lazy-srcset="https://nhakhoa.com/wp-content/uploads/2016/11/DSC08440-4.jpg 700w, https://nhakhoa.com/wp-content/uploads/2016/11/DSC08440-4-555x369.jpg 555w" data-lazy-sizes="(max-width: 700px) 100vw, 700px" srcset="https://nhakhoa.com/wp-content/uploads/2016/11/DSC08440-4.jpg 700w, https://nhakhoa.com/wp-content/uploads/2016/11/DSC08440-4-555x369.jpg 555w" sizes="(max-width: 700px) 100vw, 700px"><noscript><img class="alignnone size-full wp-image-7578" src="https://nhakhoa.com/wp-content/uploads/2016/11/DSC08440-4.jpg" alt="" width="700" height="465" srcset="https://nhakhoa.com/wp-content/uploads/2016/11/DSC08440-4.jpg 700w, https://nhakhoa.com/wp-content/uploads/2016/11/DSC08440-4-555x369.jpg 555w" sizes="(max-width: 700px) 100vw, 700px" /></noscript></p><p style="text-align: center;"><em>Nha Khoa  đã và đang ứng dụng thành công&nbsp;hàng loạt các dịch vụ nha khoa, điều trị, phục hình và thẩm mỹ răng hàm mặt hiện đại hàng đầu trên thế giới</em></p><p style="text-align: justify;"><span style="color: #0000ff; font-size: 14pt; font-family: 'comic sans ms', sans-serif;"><strong>KHÔNG PHÁT SINH CHI PHÍ – DỊCH VỤ CHUYÊN NGHIỆP</strong></span></p><p style="text-align: justify;">Nha Khoa  điều trị bệnh không phân khúc khách hàng, không phát sinh chi phí trong suốt quá trình điều trị, nhằm cân bằng mức chi phí y tế với mức thu nhập bình quân của người Việt. Đồng thời, mong muốn khẳng định chất lượng dịch vụ chuyên nghiệp, uy tín, bền vững và luôn đặt quyền lợi của khách hàng lên làm đầu, Nha Khoa  cũng thực hiện những chế độ bảo hành dịch vụ dài hạn dành cho khách hàng, giúp khách hàng yên tâm điều trị.</p><p style="text-align: center;"><img class="alignnone size-full wp-image-7974     lazyloaded" src="https://nhakhoa.com/wp-content/uploads/2017/12/hang-ngan-kh-chon-nkk-1.png" data-lazy-src="https://nhakhoa.com/wp-content/uploads/2017/12/hang-ngan-kh-chon-nkk-1.png" alt="" width="700" height="378" data-lazy-srcset="https://nhakhoa.com/wp-content/uploads/2017/12/hang-ngan-kh-chon-nkk-1.png 700w, https://nhakhoa.com/wp-content/uploads/2017/12/hang-ngan-kh-chon-nkk-1-555x300.png 555w" data-lazy-sizes="(max-width: 700px) 100vw, 700px" srcset="https://nhakhoa.com/wp-content/uploads/2017/12/hang-ngan-kh-chon-nkk-1.png 700w, https://nhakhoa.com/wp-content/uploads/2017/12/hang-ngan-kh-chon-nkk-1-555x300.png 555w" sizes="(max-width: 700px) 100vw, 700px"><noscript><img class="alignnone size-full wp-image-7974" src="https://nhakhoa.com/wp-content/uploads/2017/12/hang-ngan-kh-chon-nkk-1.png" alt="" width="700" height="378" srcset="https://nhakhoa.com/wp-content/uploads/2017/12/hang-ngan-kh-chon-nkk-1.png 700w, https://nhakhoa.com/wp-content/uploads/2017/12/hang-ngan-kh-chon-nkk-1-555x300.png 555w" sizes="(max-width: 700px) 100vw, 700px" /></noscript></p><p style="text-align: center;"><img class="alignnone size-full wp-image-7918     lazyloaded" src="https://nhakhoa.com/wp-content/uploads/2016/11/IMG_9945-1.jpg" data-lazy-src="https://nhakhoa.com/wp-content/uploads/2016/11/IMG_9945-1.jpg" alt="Trồng răng implant ở đâu tốt nhất" width="700" height="467" data-lazy-srcset="https://nhakhoa.com/wp-content/uploads/2016/11/IMG_9945-1.jpg 700w, https://nhakhoa.com/wp-content/uploads/2016/11/IMG_9945-1-555x370.jpg 555w" data-lazy-sizes="(max-width: 700px) 100vw, 700px" srcset="https://nhakhoa.com/wp-content/uploads/2016/11/IMG_9945-1.jpg 700w, https://nhakhoa.com/wp-content/uploads/2016/11/IMG_9945-1-555x370.jpg 555w" sizes="(max-width: 700px) 100vw, 700px"><noscript><img class="alignnone size-full wp-image-7918" src="https://nhakhoa.com/wp-content/uploads/2016/11/IMG_9945-1.jpg" alt="Trồng răng implant ở đâu tốt nhất" width="700" height="467" srcset="https://nhakhoa.com/wp-content/uploads/2016/11/IMG_9945-1.jpg 700w, https://nhakhoa.com/wp-content/uploads/2016/11/IMG_9945-1-555x370.jpg 555w" sizes="(max-width: 700px) 100vw, 700px" /></noscript></p><p style="text-align: center;"><em>Nha Khoa &nbsp;luôn đặt quyền lợi của khách hàng lên làm đầu</em></p><p style="text-align: justify;">Ngoài ra,&nbsp;Nha Khoa  đã vinh dự trở thành một trong số rất ít những trung tâm nha khoa được các công ty Bảo hiểm nổi tiếng trong và ngoài nước chọn là đối tác, để khách hàng có gói bảo hiểm thuộc chương trình bảo hiểm Care Plus tin tưởng, sử dụng dịch vụ.</p><p style="text-align: justify;">Với nhưng ưu điểm như cơ sở hạ tầng khang trang, quy mô lớn, đạt chuẩn, trang thiết bị, máy móc hiện đại bậc nhất, đội ngũ bác sĩ chuyên khoa hàng đầu Việt Nam, cùng chi phí hợp lý, Nha Khoa  chính là sự lựa chọn đáng tin cậy, đồng hành chăm sóc nụ cười của bạn.</p><div style="padding: 10px; margin-top: 20px; border: 1px solid #9fdbf7; text-align: center; background: none 0% 0% repeat scroll #f5feff;"><p style="text-align: center;"><span style="font-size: 14pt; color: #ff0000;"><strong>HƠN 10.000 KHÁCH HÀNG ĐÃ&nbsp;CHĂM SÓC RĂNG MIỆNG TẠI NHA KHOA </strong></span></p><p style="text-align: center;"><span style="color: #003300; font-size: 14pt;"><strong>BẠN THÌ SAO?</strong></span></p><p style="text-align: center;"><span style="color: #3366ff; font-family: 'comic sans ms', sans-serif;">HÃY NHANH TAY ĐĂNG KÝ ĐỂ CÓ CƠ HỘI LÀM RĂNG VỚI MỨC GIÁ HẤP DẪN NHẤT VÀ ĐƯỢC&nbsp;TIẾP CẬN VỚI NHỮNG DỊCH VỤ CHẤT LƯỢNG CHUẨN QUỐC TẾ NGAY TẠI VIỆT NAM</span></p><p style="padding-top: 5px; text-align: center;" align="center"><a href="#fm-contact-frame"><img class="alignnone wp-image-3183 size-full     lazyloaded" src="https://nhakhoa.com/wp-content/uploads/2016/11/nut-dang-ky-e1490148792312.png" data-lazy-src="https://nhakhoa.com/wp-content/uploads/2016/11/nut-dang-ky-e1490148792312.png" alt="" width="300" height="90"><noscript><img class="alignnone wp-image-3183 size-full" src="https://nhakhoa.com/wp-content/uploads/2016/11/nut-dang-ky-e1490148792312.png" alt="" width="300" height="90" /></noscript></a></p></div><div style="padding: 5px 20px; border: 1px dashed #7ab34c; margin: 16px 0px 20px; text-align: justify; background: none 0px 0px repeat scroll #eff9e6;"><p style="text-align: center;"><span style="color: #0000ff; font-size: 14pt;"><strong>&nbsp;HÀNG NGÀN KHÁCH HÀNG</strong></span></p><p style="text-align: center;"><span style="color: #0000ff; font-size: 14pt;"><strong>ĐÃ TÌM THẤY NỤ CƯỜI MỚI TẠI NHA KHOA </strong></span></p><p style="text-align: justify;">Với hệ thống hơn 30 cơ sở trải dài khắp từ Nam ra Bắc, quy tụ đội ngũ 100 bác sĩ chuyên gia đầu ngành, trang bị máy móc hiện đại cùng công nghệ tiên tiến, Nha Khoa <em>&nbsp;</em>đã chăm sóc và thẩm mỹ nụ cười, tự hào đã làm hài lòng hàng ngàn khách hàng trong và ngoài nước.</p><p style="text-align: center;"><iframe src="//www.youtube.com/embed/t2SGvYBG-RE" data-lazy-src="//www.youtube.com/embed/t2SGvYBG-RE" width="560" height="314" allowfullscreen="allowfullscreen" class="     lazyloaded"></iframe></p><p style="text-align: center;"><img class="alignnone size-full wp-image-40067     lazyloaded" src="https://benhvienranghammat.com.vn/wp-content/uploads/2017/10/700x700-5.jpg" data-lazy-src="https://benhvienranghammat.com.vn/wp-content/uploads/2017/10/700x700-5.jpg" alt="" width="700" height="700"><noscript><img class="alignnone size-full wp-image-40067" src="https://benhvienranghammat.com.vn/wp-content/uploads/2017/10/700x700-5.jpg" alt="" width="700" height="700" /></noscript></p><p style="text-align: center;"><em>Diễn Viên Kịch, MC, Người mẫu Nguyên Thành hài lòng về hàm răng trắng sáng hơn, không ê buốt sau khi tẩy trắng răng tại Nha Khoa </em></p><p style="text-align: center;"><img class="alignnone size-full wp-image-40063     lazyloaded" src="https://benhvienranghammat.com.vn/wp-content/uploads/2017/10/700x700-1.jpg" data-lazy-src="https://benhvienranghammat.com.vn/wp-content/uploads/2017/10/700x700-1.jpg" alt="" width="700" height="700"><noscript><img class="alignnone size-full wp-image-40063" src="https://benhvienranghammat.com.vn/wp-content/uploads/2017/10/700x700-1.jpg" alt="" width="700" height="700" /></noscript></p><p style="text-align: center;"><em>Hotgirl, mẫu ảnh Tuyết Trinh đã tự tin khoe nụ cười “chuẩn không cần chỉnh”, không còn mặc cảm răng xỉn màu, lệch lạc nhờ bọc răng sứ tại Nha Khoa </em></p><p style="text-align: center;"><img class="alignnone size-full wp-image-40071 lazyload" src="data:image/gif;base64,R0lGODdhAQABAPAAAP///wAAACwAAAAAAQABAEACAkQBADs=" data-lazy-src="https://benhvienranghammat.com.vn/wp-content/uploads/2017/10/700x700-9.jpg" alt="" width="700" height="700"><noscript><img class="alignnone size-full wp-image-40071" src="https://benhvienranghammat.com.vn/wp-content/uploads/2017/10/700x700-9.jpg" alt="" width="700" height="700" /></noscript></p><p style="text-align: center;"><em>Người Mẫu, MC, Ca Sĩ Hồ Khắc Vĩnh khoe kết quả của mình ngay sau khi tẩy trắng răng</em></p><p style="text-align: center;"><img class="alignnone size-full wp-image-40080 lazyload" src="data:image/gif;base64,R0lGODdhAQABAPAAAP///wAAACwAAAAAAQABAEACAkQBADs=" data-lazy-src="https://benhvienranghammat.com.vn/wp-content/uploads/2017/10/IMG_9920.jpg" alt="" width="700" height="467"><noscript><img class="alignnone size-full wp-image-40080" src="https://benhvienranghammat.com.vn/wp-content/uploads/2017/10/IMG_9920.jpg" alt="" width="700" height="467" /></noscript></p><p style="text-align: center;"><em>Hot boy, người mẫu Nguyễn Tuấn An tin tưởng lựa chọn Nha Khoa  để bọc răng sứ</em></p><p style="text-align: center;"><img class="alignnone size-full wp-image-40072 lazyload" src="data:image/gif;base64,R0lGODdhAQABAPAAAP///wAAACwAAAAAAQABAEACAkQBADs=" data-lazy-src="https://benhvienranghammat.com.vn/wp-content/uploads/2017/10/700x700-10.jpg" alt="" width="700" height="700"><noscript><img class="alignnone size-full wp-image-40072" src="https://benhvienranghammat.com.vn/wp-content/uploads/2017/10/700x700-10.jpg" alt="" width="700" height="700" /></noscript></p><p style="text-align: center;"><em>Mẫu ảnh, hot girl Ngọc Yến xinh đẹp hơn sau khi bọc răng sứ tại Nha Khoa </em></p><p style="text-align: center;"><img class="alignnone size-full wp-image-40065 lazyload" src="data:image/gif;base64,R0lGODdhAQABAPAAAP///wAAACwAAAAAAQABAEACAkQBADs=" data-lazy-src="https://benhvienranghammat.com.vn/wp-content/uploads/2017/10/700x700-3.jpg" alt="" width="700" height="700"><noscript><img class="alignnone size-full wp-image-40065" src="https://benhvienranghammat.com.vn/wp-content/uploads/2017/10/700x700-3.jpg" alt="" width="700" height="700" /></noscript></p><p style="text-align: center;"><em>Người mẫu, diễn Viên Lê Nhật Nam lịch lãm, cuốn hút hơn và tự tin mọi lúc mọi nơi nhờ hàm răng bọc sứ trắng sáng, đều đặn&nbsp;</em></p><p style="text-align: center;"><img class="alignnone size-full wp-image-40276 lazyload" src="data:image/gif;base64,R0lGODdhAQABAPAAAP///wAAACwAAAAAAQABAEACAkQBADs=" data-lazy-src="https://benhvienranghammat.com.vn/wp-content/uploads/2017/10/MAI-PHUONG-3.jpg" alt="" width="700" height="419"><noscript><img class="alignnone size-full wp-image-40276" src="https://benhvienranghammat.com.vn/wp-content/uploads/2017/10/MAI-PHUONG-3.jpg" alt="" width="700" height="419" /></noscript><img class="alignnone size-medium wp-image-40277 lazyload" src="data:image/gif;base64,R0lGODdhAQABAPAAAP///wAAACwAAAAAAQABAEACAkQBADs=" data-lazy-src="https://benhvienranghammat.com.vn/wp-content/uploads/2017/10/THANH-NGA-3.jpg" alt="" width="700" height="419"><noscript><img class="alignnone size-medium wp-image-40277" src="https://benhvienranghammat.com.vn/wp-content/uploads/2017/10/THANH-NGA-3.jpg" alt="" width="700" height="419" /></noscript><img class="alignnone size-medium wp-image-40278 lazyload" src="data:image/gif;base64,R0lGODdhAQABAPAAAP///wAAACwAAAAAAQABAEACAkQBADs=" data-lazy-src="https://benhvienranghammat.com.vn/wp-content/uploads/2017/10/THANH-TRÀ-3.jpg" alt="" width="700" height="419"><noscript><img class="alignnone size-medium wp-image-40278" src="https://benhvienranghammat.com.vn/wp-content/uploads/2017/10/THANH-TRÀ-3.jpg" alt="" width="700" height="419" /></noscript><img class="alignnone size-medium wp-image-40279 lazyload" src="data:image/gif;base64,R0lGODdhAQABAPAAAP///wAAACwAAAAAAQABAEACAkQBADs=" data-lazy-src="https://benhvienranghammat.com.vn/wp-content/uploads/2017/10/VĂN-KHÔI-3.jpg" alt="" width="700" height="419"><noscript><img class="alignnone size-medium wp-image-40279" src="https://benhvienranghammat.com.vn/wp-content/uploads/2017/10/VĂN-KHÔI-3.jpg" alt="" width="700" height="419" /></noscript></p><p style="text-align: center;"><em>Hình ảnh KH bọc răng sứ tại&nbsp;Nha khoa </em></p><p style="text-align: center;"><img class="alignnone size-full wp-image-8700 lazyload" src="data:image/gif;base64,R0lGODdhAQABAPAAAP///wAAACwAAAAAAQABAEACAkQBADs=" data-lazy-src="https://nhakhoa.com/wp-content/uploads/2018/01/NGUYEN-THI-NGA.jpg" alt="" width="700" height="419" data-lazy-srcset="https://nhakhoa.com/wp-content/uploads/2018/01/NGUYEN-THI-NGA.jpg 700w, https://nhakhoa.com/wp-content/uploads/2018/01/NGUYEN-THI-NGA-555x332.jpg 555w" data-lazy-sizes="(max-width: 700px) 100vw, 700px"><noscript><img class="alignnone size-full wp-image-8700" src="https://nhakhoa.com/wp-content/uploads/2018/01/NGUYEN-THI-NGA.jpg" alt="" width="700" height="419" srcset="https://nhakhoa.com/wp-content/uploads/2018/01/NGUYEN-THI-NGA.jpg 700w, https://nhakhoa.com/wp-content/uploads/2018/01/NGUYEN-THI-NGA-555x332.jpg 555w" sizes="(max-width: 700px) 100vw, 700px" /></noscript> <img class="alignnone size-full wp-image-8699 lazyload" src="data:image/gif;base64,R0lGODdhAQABAPAAAP///wAAACwAAAAAAQABAEACAkQBADs=" data-lazy-src="https://nhakhoa.com/wp-content/uploads/2018/01/HO-CANH.jpg" alt="" width="700" height="419" data-lazy-srcset="https://nhakhoa.com/wp-content/uploads/2018/01/HO-CANH.jpg 700w, https://nhakhoa.com/wp-content/uploads/2018/01/HO-CANH-555x332.jpg 555w" data-lazy-sizes="(max-width: 700px) 100vw, 700px"><noscript><img class="alignnone size-full wp-image-8699" src="https://nhakhoa.com/wp-content/uploads/2018/01/HO-CANH.jpg" alt="" width="700" height="419" srcset="https://nhakhoa.com/wp-content/uploads/2018/01/HO-CANH.jpg 700w, https://nhakhoa.com/wp-content/uploads/2018/01/HO-CANH-555x332.jpg 555w" sizes="(max-width: 700px) 100vw, 700px" /></noscript> <img class="alignnone size-full wp-image-8698 lazyload" src="data:image/gif;base64,R0lGODdhAQABAPAAAP///wAAACwAAAAAAQABAEACAkQBADs=" data-lazy-src="https://nhakhoa.com/wp-content/uploads/2018/01/KH-NUOC-NGOAI.jpg" alt="" width="700" height="419" data-lazy-srcset="https://nhakhoa.com/wp-content/uploads/2018/01/KH-NUOC-NGOAI.jpg 700w, https://nhakhoa.com/wp-content/uploads/2018/01/KH-NUOC-NGOAI-555x332.jpg 555w" data-lazy-sizes="(max-width: 700px) 100vw, 700px"><noscript><img class="alignnone size-full wp-image-8698" src="https://nhakhoa.com/wp-content/uploads/2018/01/KH-NUOC-NGOAI.jpg" alt="" width="700" height="419" srcset="https://nhakhoa.com/wp-content/uploads/2018/01/KH-NUOC-NGOAI.jpg 700w, https://nhakhoa.com/wp-content/uploads/2018/01/KH-NUOC-NGOAI-555x332.jpg 555w" sizes="(max-width: 700px) 100vw, 700px" /></noscript> <img class="alignnone size-full wp-image-8696 lazyload" src="data:image/gif;base64,R0lGODdhAQABAPAAAP///wAAACwAAAAAAQABAEACAkQBADs=" data-lazy-src="https://nhakhoa.com/wp-content/uploads/2018/01/BUI-THI-HAI.jpg" alt="" width="700" height="419" data-lazy-srcset="https://nhakhoa.com/wp-content/uploads/2018/01/BUI-THI-HAI.jpg 700w, https://nhakhoa.com/wp-content/uploads/2018/01/BUI-THI-HAI-555x332.jpg 555w" data-lazy-sizes="(max-width: 700px) 100vw, 700px"><noscript><img class="alignnone size-full wp-image-8696" src="https://nhakhoa.com/wp-content/uploads/2018/01/BUI-THI-HAI.jpg" alt="" width="700" height="419" srcset="https://nhakhoa.com/wp-content/uploads/2018/01/BUI-THI-HAI.jpg 700w, https://nhakhoa.com/wp-content/uploads/2018/01/BUI-THI-HAI-555x332.jpg 555w" sizes="(max-width: 700px) 100vw, 700px" /></noscript></p><p style="text-align: center;"><em>Hình ảnh KH trồng răng implant tại Nha Khoa </em></p><p style="text-align: center;"><a href="#fm-contact-frame"><img class="alignnone wp-image-39484 size-full lazyload" src="data:image/gif;base64,R0lGODdhAQABAPAAAP///wAAACwAAAAAAQABAEACAkQBADs=" data-lazy-src="https://benhvienranghammat.com.vn/wp-content/uploads/2017/10/dang-ky-gif.gif" alt="" width="365" height="136"><noscript><img class="alignnone wp-image-39484 size-full" src="https://benhvienranghammat.com.vn/wp-content/uploads/2017/10/dang-ky-gif.gif" alt="" width="365" height="136" /></noscript></a></p><p style="text-align: center;"><span style="font-size: 14pt;"><strong><span style="color: #0000ff;"><a style="color: #0000ff;" href="tel:19006899">HOẶC GỌI ĐĂNG KÝ: 19006899</a></span></strong></span></p></div> </article></div>
	<!-- motbacsi -->
	 
	 
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
<script>
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