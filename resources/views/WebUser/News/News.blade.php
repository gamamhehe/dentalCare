<!DOCTYPE html>
<html lang="en"><head>
<title> {{$News->title}} </title>
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
    <script src="{{URL::to('assets/admin/tinymce/js/tinymce/tinymce.min.js')}}"></script>
</head>
<body>
<div class="top">
	<!-- start menu -->
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
                                    <a href="/myProfile" class="btn btn-success btn-flat">Profile</a>
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
                                                        <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
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
	<!-- end menu -->
    <div class="container" style="
      padding-top: 2em;
    color: blue;">
        <div class="row">
            <div class="col-sm-8 push-sm-2 text-xs-center Bacsititle">
                <h3><strong>{{$News->title}}</strong></h3>
                <div class="gach">
                    <div class="tron"></div>
                </div>
            </div>
        </div>
    </div>
	<!-- start banner -->
    @if($News->id == 7)
	<div class="container">
        <div>
            <div>
                <p>TẠI SAO N&Ecirc;N THỰC HIỆN TRỒNG RĂNG IMPLANT?</p>
            </div>
            <p align="justify">Hiện nay,&nbsp;phương ph&aacute;p&nbsp;cấy gh&eacute;p&nbsp;implant được rất đ&ocirc;ng kh&aacute;ch h&agrave;ng&nbsp;lựa chọn bởi ngo&agrave;i việc phục h&igrave;nh răng bị mất hiệu quả,&nbsp;kỹ thuật n&agrave;y&nbsp;c&ograve;n mang nhiều ưu điểm vượt trội,&nbsp;khắc phục ho&agrave;n to&agrave;n những thiếu s&oacute;t của biện ph&aacute;p trồng răng truyền thống như:</p>
            <ul>
                <li><strong>&nbsp;Mang t&iacute;nh thẩm mỹ ho&agrave;n hảo, giống như răng thật:&nbsp;</strong></li>
            </ul>
            <p align="justify">Răng implant sau khi phục h&igrave;nh c&oacute; m&agrave;u sắc trắng s&aacute;ng, độ b&oacute;ng, h&igrave;nh d&aacute;ng như răng thật, ho&agrave;n to&agrave;n sẽ kh&ocirc;ng ai ph&aacute;t hiện được khi nh&igrave;n bằng mắt thường. Bạn c&oacute; thể&nbsp; ăn nhai b&igrave;nh thường m&agrave; kh&ocirc;ng gặp phải vấn đề g&igrave;.</p>
            <p align="justify">&nbsp;<img class="alignnone size-medium wp-image-9091     lazyloaded" style="display: block; margin-left: auto; margin-right: auto;" src="https://nhakhoakim.com/wp-content/uploads/2018/01/implant-1.png" sizes="(max-width: 700px) 100vw, 700px" srcset="https://nhakhoakim.com/wp-content/uploads/2018/01/implant-1.png 700w, https://nhakhoakim.com/wp-content/uploads/2018/01/implant-1-555x331.png 555w" alt="" width="700" height="418" data-lazy-src="https://nhakhoakim.com/wp-content/uploads/2018/01/implant-1.png" data-lazy-srcset="https://nhakhoakim.com/wp-content/uploads/2018/01/implant-1.png 700w, https://nhakhoakim.com/wp-content/uploads/2018/01/implant-1-555x331.png 555w" data-lazy-sizes="(max-width: 700px) 100vw, 700px" /></p>
            <p align="justify"><em>Răng implant sau khi phục h&igrave;nh bền đẹp, trắng s&aacute;ng, giống như răng th&acirc;t.</em></p>
            <ul>
                <li><strong>&nbsp;Kh&ocirc;ng đau, hạn chế x&acirc;m lấn, đảm bảo an to&agrave;n:&nbsp;</strong></li>
            </ul>
            <p align="justify">To&agrave;n bộ quy tr&igrave;nh cấy gh&eacute;p implant được tiến h&agrave;nh trong điều kiện v&ocirc; tr&ugrave;ng, c&oacute; sự hỗ trợ của nhiều m&aacute;y m&oacute;c,&nbsp;thiết bị hiện đại v&agrave; c&ocirc;ng nghệ 3D tiến tiến,&nbsp;gi&uacute;p x&aacute;c định ch&iacute;nh x&aacute;c t&igrave;nh trạng mất răng, vị tr&iacute; cắm trụ&nbsp;ph&ugrave; hợp. Do&nbsp;đ&oacute;, c&oacute; khả năng hạn chế tổn thương&nbsp;m&ocirc; mềm&nbsp;xuống mức thấp nhất, đảm bảo an to&agrave;n v&agrave; hiệu quả cải thiện tốt.</p>
            <p align="justify">Ngo&agrave;i ra, kh&aacute;ch h&agrave;ng sẽ được g&acirc;y m&ecirc; hoặc g&acirc;y t&ecirc;&nbsp;trước khi thực hiện cắm trụ implant&nbsp;n&ecirc;n kh&ocirc;ng c&oacute; cảm gi&aacute;c đau đớn. Kh&ocirc;ng cần x&acirc;m lấn hay cắt rạch nhiều n&ecirc;n vết thương sẽ hồi phục nhanh ch&oacute;ng.</p>
            <ul>
                <li><strong>&nbsp;Kh&ocirc;ng g&acirc;y ảnh hưởng đến c&aacute;c răng kh&aacute;c</strong></li>
            </ul>
            <p>Răng implant tồn tại đ&ocirc;̣c l&acirc;̣p như một chiếc răng thật tr&ecirc;n cung h&agrave;m, kh&ocirc;ng g&acirc;y ảnh hưởng đến c&aacute;c răng kh&aacute;c v&agrave; cũng kh&ocirc;ng cần t&aacute;c động đến cấu tr&uacute;c răng như những&nbsp;phương ph&aacute;p kh&aacute;c.</p>
            <p><img class="size-full wp-image-8692 aligncenter     lazyloaded" style="display: block; margin-left: auto; margin-right: auto;" src="https://nhakhoakim.com/wp-content/uploads/2018/01/implant-2.jpg" sizes="(max-width: 700px) 100vw, 700px" srcset="https://nhakhoakim.com/wp-content/uploads/2018/01/implant-2.jpg 700w, https://nhakhoakim.com/wp-content/uploads/2018/01/implant-2-555x277.jpg 555w" alt="" width="700" height="349" data-lazy-src="https://nhakhoakim.com/wp-content/uploads/2018/01/implant-2.jpg" data-lazy-srcset="https://nhakhoakim.com/wp-content/uploads/2018/01/implant-2.jpg 700w, https://nhakhoakim.com/wp-content/uploads/2018/01/implant-2-555x277.jpg 555w" data-lazy-sizes="(max-width: 700px) 100vw, 700px" /></p>
            <p><em>Trụ implant tồn tại độc lập tr&ecirc;n cung h&agrave;m, khả năng chịu lực cao, đảm bảo chức năng ăn nhai tốt.</em></p>
            <ul>
                <li><strong>&nbsp;Tuổi thọ d&agrave;i l&acirc;u, khả năng chịu lực tốt:&nbsp;</strong></li>
            </ul>
            <p align="justify">Trụ răng Implant được thiết kế đặc biệt v&agrave; chế tạo từ vật liệu bền vững l&agrave; Titanium, c&oacute; khả năng t&iacute;ch hợp tốt với xương ổ răng&nbsp;c&ugrave;ng&nbsp;nướu một c&aacute;ch nhanh ch&oacute;ng, d&ugrave;&nbsp;sử dụng trong thời gian d&agrave;i cũng kh&ocirc;ng biến chất, kh&ocirc;ng bị oxy h&oacute;a trong m&ocirc;i trường&nbsp;khoang miệng. Hơn thế nữa, răng&nbsp;Implant&nbsp;kh&ocirc;ng g&acirc;y k&iacute;ch ứng,&nbsp;phản ứng đ&agrave;o thải&nbsp;hay t&aacute;c dụng phụ với cơ thể, lại c&oacute; thể tồn tại l&acirc;u d&agrave;i, thậm ch&iacute; l&agrave; trọn đời nếu chăm s&oacute;c v&agrave; giữ g&igrave;n đ&uacute;ng c&aacute;ch.</p>
            <p align="justify">B&ecirc;n cạnh đ&oacute;, răng implant c&oacute; độ cứng cao, khả năng chịu lực tốt, đảm bảo khả năng ăn nhai b&igrave;nh thường như răng thật sau khi trồng.</p>
            <ul>
                <li><strong>&nbsp;Ngăn&nbsp;chặn&nbsp;t&igrave;nh trạng ti&ecirc;u xương h&agrave;m</strong></li>
            </ul>
            <p>Sau khi mất răng, nếu ch&uacute;ng ta kh&ocirc;ng thực hiện&nbsp;c&aacute;c biện ph&aacute;p phục h&igrave;nh cấy gh&eacute;p răng mới th&igrave; xương h&agrave;m sẽ dần bị ti&ecirc;u hủy do kh&ocirc;ng c&oacute; bất cứ sự t&aacute;c động cơ học n&agrave;o hỗ trợ xương h&agrave;m ph&aacute;t triển. Ti&ecirc;u xương dẫn đến hiện tượng tụt nướu, nướu mất c&acirc;n đối, g&acirc;y teo quai h&agrave;m khiến m&aacute; bị h&oacute;p, khu&ocirc;n mặt trở n&ecirc;n gi&agrave; hơn so với tuổi thật.</p>
            <p>Tiến h&agrave;nh cấy gh&eacute;p implant vừa c&oacute; thể ngăn chặn t&igrave;nh trạng&nbsp;ti&ecirc;u xương&nbsp;diễn ra, vừa gi&uacute;p bạn tr&aacute;nh được những vấn đề kh&ocirc;ng mong muốn, ảnh hưởng đến thẩm mỹ v&agrave; sức khỏe răng miệng về sau.</p>
            <p>&nbsp;</p>
            <hr />
            <p>QUY TR&Igrave;NH TRỒNG RĂNG IMPLANT HIỆU QUẢ V&Agrave; AN TO&Agrave;N TẠI NHA KHOA KIM</p>
            <p>Tại Nha Khoa KIM, quy tr&igrave;nh cấy gh&eacute;p implant được thực hiện một c&aacute;ch an to&agrave;n, khoa học, tu&acirc;n thủ nghi&ecirc;m ngặt quy định của Bộ Y tế theo những bước cơ bản sau:</p>
            <p><strong>&nbsp;Bước 1: Thăm kh&aacute;m v&agrave; chụp phim bằng m&aacute;y X quang Cone Bean CT 3D</strong></p>
            <p>Trước ti&ecirc;n, b&aacute;c sĩ sẽ thăm kh&aacute;m t&igrave;nh h&igrave;nh răng miệng, rồi kiểm tra t&igrave;nh trạng mất răng&nbsp;một c&aacute;ch tổng quan.&nbsp;Sau đ&oacute;, tiến h&agrave;nh chụp phim bằng m&aacute;y chụp X-quang Cone Bean CT 3D c&ugrave;ng m&aacute;y chụp X quang khảo s&aacute;t bề mặt Panorex.</p>
            <p>Từ h&igrave;nh ảnh kh&ocirc;ng gian 3 chiều m&agrave; m&aacute;y chụp được c&aacute;c b&aacute;c sĩ sẽ ph&acirc;n t&iacute;ch kỹ cấu tr&uacute;c xương h&agrave;m, t&igrave;nh trạng ti&ecirc;u xương, x&aacute;c định ch&iacute;nh x&aacute;c k&iacute;ch thước, chiều d&agrave;i, độ s&acirc;u, rộng của xương h&agrave;m cũng như nướu răng. Từ đ&oacute;, đ&aacute;nh gi&aacute; xem c&oacute; ph&ugrave; hợp để gh&eacute;p Implant kh&ocirc;ng hay phải thực hiện n&acirc;ng xoang hay gh&eacute;p xương v&agrave; vạt nướu&hellip; Rồi tư vấn cho kh&aacute;ch h&agrave;ng phương ph&aacute;p hay loại trụ implant ph&ugrave; hợp.<img class="aligncenter wp-image-7980 size-full     lazyloaded" style="display: block; margin-left: auto; margin-right: auto;" title="Trồng răng implant " src="https://nhakhoakim.com/wp-content/uploads/2016/11/MG_5476.jpg" sizes="(max-width: 700px) 100vw, 700px" srcset="https://nhakhoakim.com/wp-content/uploads/2016/11/MG_5476.jpg 700w, https://nhakhoakim.com/wp-content/uploads/2016/11/MG_5476-555x369.jpg 555w" alt="Trồng răng implant " width="700" height="466" data-lazy-src="https://nhakhoakim.com/wp-content/uploads/2016/11/MG_5476.jpg" data-lazy-srcset="https://nhakhoakim.com/wp-content/uploads/2016/11/MG_5476.jpg 700w, https://nhakhoakim.com/wp-content/uploads/2016/11/MG_5476-555x369.jpg 555w" data-lazy-sizes="(max-width: 700px) 100vw, 700px" /></p>
            <p style="text-align: center;"><em>Kh&aacute;ch h&agrave;ng được kiểm tra t&igrave;nh trạng mất răng chi tiết bằng m&aacute;y chụp phim X-quang Cone Bean CT 3D.</em></p>
            <p><strong>&nbsp;Bước 2: L&ecirc;n kế hoạch điều trị v&agrave; đặt lịch cấy gh&eacute;p implant</strong></p>
            <p>Khi c&oacute; đầy đủ những th&ocirc;ng&nbsp;số cơ bản&nbsp;b&aacute;c sĩ sẽ l&ecirc;n kế hoạch điều trị cụ thể v&agrave; sử dụng phần mềm Simplant 3D để&nbsp;giả định vị tr&iacute; cấy gh&eacute;p implant, m&ocirc; phỏng qu&aacute; tr&igrave;nh cắm trụ một c&aacute;ch trực quan cho kh&aacute;ch h&agrave;ng. Th&ocirc;ng qua đ&oacute;,&nbsp;b&aacute;c sĩ sẽ biết được n&ecirc;n cắm trụ implant ở vị tr&iacute; n&agrave;o th&igrave; kh&ocirc;ng ảnh hưởng đến d&acirc;y thần kinh, tỉ lệ xương cần gh&eacute;p l&agrave; bao nhi&ecirc;u, rồi cần bọc t&aacute;ch nướu như thế n&agrave;o th&igrave; c&oacute; thể hạn chế tổn thương xuống mức thấp nhất,&hellip;Như vậy, gi&uacute;p đảm bảo t&iacute;nh ch&iacute;nh x&aacute;c v&agrave; n&acirc;ng cao hiệu quả phục hồi răng.</p>
            <p style="text-align: center;">Nếu kh&aacute;ch h&agrave;ng đồng &yacute; với kế hoạch cấy gh&eacute;p implant, b&aacute;c sĩ sẽ&nbsp;l&agrave; l&ecirc;n lịch hẹn&nbsp;trồng răng&nbsp;implant dựa tr&ecirc;n thời gian, mong muốn cũng như&nbsp;điều kiện sức khoẻ của từng đối tượng.</p>
            <p style="text-align: center;"><img class="alignnone size-full wp-image-8940     lazyloaded" src="https://nhakhoakim.com/wp-content/uploads/2018/01/MG_5591.jpg" sizes="(max-width: 700px) 100vw, 700px" srcset="https://nhakhoakim.com/wp-content/uploads/2018/01/MG_5591.jpg 700w, https://nhakhoakim.com/wp-content/uploads/2018/01/MG_5591-555x369.jpg 555w" alt="" width="700" height="466" data-lazy-src="https://nhakhoakim.com/wp-content/uploads/2018/01/MG_5591.jpg" data-lazy-srcset="https://nhakhoakim.com/wp-content/uploads/2018/01/MG_5591.jpg 700w, https://nhakhoakim.com/wp-content/uploads/2018/01/MG_5591-555x369.jpg 555w" data-lazy-sizes="(max-width: 700px) 100vw, 700px" /></p>
            <p style="text-align: center;"><em>B&aacute;c sĩ ph&acirc;n t&iacute;ch xương v&agrave;&nbsp;giả định c&aacute;c vị tr&iacute; cấy gh&eacute;p implant tr&ecirc;n phần mềm Simplant</em></p>
            <p><strong>&nbsp;Bước 3: Thực hiện cấy gh&eacute;p&nbsp;trụ&nbsp;implant trong điều kiện v&ocirc; tr&ugrave;ng</strong></p>
            <p>Khi đ&atilde; đảm bảo c&aacute;c điều kiện về sức khỏe, thời gian,&hellip;bạn&nbsp;sẽ được thực hiện&nbsp;cấy gh&eacute;p trụ implant trong ph&ograve;ng phẫu thuật v&ocirc; tr&ugrave;ng. Bước đầu ti&ecirc;n, b&aacute;c sĩ vệ sinh răng miệng sạch sẽ, sau đ&oacute; g&acirc;y t&ecirc; hoặc g&acirc;y m&ecirc; t&ugrave;y thuộc v&agrave;o thể trạng mỗi người, rồi tiến h&agrave;nh b&oacute;c t&aacute;ch nướu, khoan lỗ tr&ecirc;n xương h&agrave;m&nbsp;v&agrave;&nbsp;đặt trụ răng v&agrave;o.&nbsp;Trường hợp, kh&aacute;ch h&agrave;ng bị ti&ecirc;u xương h&agrave;m, tụt xoang, teo nướu&hellip;b&aacute;c sĩ sẽ &aacute;p dụng c&aacute;c phương ph&aacute;p gh&eacute;p xương, gh&eacute;p nướu, n&acirc;ng xoang&hellip;trước khi cắm trụ răng.</p>
            <p style="text-align: center;">Th&ocirc;ng thường, để đảm bảo tuổi thọ v&agrave; độ bền cho răng th&igrave; sau khi cố định trụ răng l&ecirc;n khung h&agrave;m xong,&nbsp;bạn cần&nbsp;chờ một khoảng thời gian để trụ implant ổn định rồi mới bọc m&atilde;o sứ. L&uacute;c n&agrave;y, để đảm bảo thẩm mỹ v&agrave; khả năng ăn nhai b&aacute;c sĩ sẽ gắn răng tạm cho kh&aacute;ch h&agrave;ng.</p>
            <p style="text-align: center;"><img class="alignnone size-full wp-image-8618     lazyloaded" src="https://nhakhoakim.com/wp-content/uploads/2016/11/Phong-tieu-phau.jpg" sizes="(max-width: 700px) 100vw, 700px" srcset="https://nhakhoakim.com/wp-content/uploads/2016/11/Phong-tieu-phau.jpg 700w, https://nhakhoakim.com/wp-content/uploads/2016/11/Phong-tieu-phau-555x369.jpg 555w" alt="" width="700" height="466" data-lazy-src="https://nhakhoakim.com/wp-content/uploads/2016/11/Phong-tieu-phau.jpg" data-lazy-srcset="https://nhakhoakim.com/wp-content/uploads/2016/11/Phong-tieu-phau.jpg 700w, https://nhakhoakim.com/wp-content/uploads/2016/11/Phong-tieu-phau-555x369.jpg 555w" data-lazy-sizes="(max-width: 700px) 100vw, 700px" /></p>
            <p style="text-align: center;"><em>Qu&aacute; tr&igrave;nh cấy gh&eacute;p implant được tiến h&agrave;nh trong ph&ograve;ng phẫu thuật v&ocirc; tr&ugrave;ng.</em></p>
            <p><strong>&nbsp;Bước 4: Lấy dấu mẫu h&agrave;m v&agrave; thiết kế răng sứ</strong></p>
            <p>Ho&agrave;n th&agrave;nh qu&aacute; tr&igrave;nh cắm trụ implant, b&aacute;c sĩ sẽ lấy dấu mẫu h&agrave;m bằng kỹ thuật Scan 3D tự động để c&oacute; th&ocirc;ng số ch&iacute;nh x&aacute;c về tỉ lệ v&agrave; k&iacute;ch thước khu&ocirc;n h&agrave;m, vị tr&iacute; c&aacute;c răng, nhằm hỗ trợ tốt cho qu&aacute; tr&igrave;nh l&agrave;m m&atilde;o răng sứ.</p>
            <p>Tại đ&acirc;y, c&aacute;c kỹ thuật vi&ecirc;n chuy&ecirc;n nghiệp sẽ tiến h&agrave;nh thiết kế v&agrave; chế tạo răng sứ bằng c&ocirc;ng nghệ CAD/CAM 3D tự động dựa&nbsp;tr&ecirc;n&nbsp;những số liệu từ trước. Đảm bảo răng sứ vừa kh&iacute;t với trụ răng, tr&aacute;nh t&igrave;nh trạng lệch khớp cắn hay răng lỏng, hở sau khi phục h&igrave;nh.</p>
            <p><img class="aligncenter wp-image-7810 size-full     lazyloaded" style="display: block; margin-left: auto; margin-right: auto;" title="Trồng răng implant -4" src="https://nhakhoakim.com/wp-content/uploads/2016/11/CAD-CAM.jpg" sizes="(max-width: 700px) 100vw, 700px" srcset="https://nhakhoakim.com/wp-content/uploads/2016/11/CAD-CAM.jpg 700w, https://nhakhoakim.com/wp-content/uploads/2016/11/CAD-CAM-555x415.jpg 555w" alt="Trồng răng implant -4" width="700" height="525" data-lazy-src="https://nhakhoakim.com/wp-content/uploads/2016/11/CAD-CAM.jpg" data-lazy-srcset="https://nhakhoakim.com/wp-content/uploads/2016/11/CAD-CAM.jpg 700w, https://nhakhoakim.com/wp-content/uploads/2016/11/CAD-CAM-555x415.jpg 555w" data-lazy-sizes="(max-width: 700px) 100vw, 700px" /></p>
            <p style="text-align: center;"><em>Thiết kế v&agrave; chế tạo răng sứ&nbsp;bằng c&ocirc;ng nghệ&nbsp;CAD/CAM 3D hiện đại.</em></p>
            <p><strong>&nbsp;Bước 5:&nbsp;Gắn&nbsp;m&atilde;o sứ l&ecirc;n trụ implant v&agrave; hẹn lịch t&aacute;i kh&aacute;m</strong></p>
            <p>Khi trụ răng đ&atilde; t&iacute;ch hợp tốt với xương h&agrave;m v&agrave; nướu,&nbsp;th&igrave;&nbsp;b&aacute;c sĩ sẽ gắn m&atilde;o sứ l&ecirc;n trụ implant v&agrave; cố định một c&aacute;ch chắc chắn,&nbsp;ho&agrave;n tất qu&aacute; tr&igrave;nh&nbsp;phục h&igrave;nh răng.</p>
            <p>Cu&ocirc;́i cùng bác sĩ&nbsp;hẹn lịch t&aacute;i kh&aacute;m cho bệnh nh&acirc;n để kiểm tra t&igrave;nh trạng răng sau khi phục hồi v&agrave; hướng dẫn c&aacute;ch chăm s&oacute;c, giữ g&igrave;n, vệ sinh răng miệng đ&uacute;ng c&aacute;ch</p>
        </div>
        <div>
            <div id="sv_qt"><hr />
                <h3><strong>NHA KHOA KIM &ndash; ĐỊA CHỈ TRỒNG RĂNG IMPLANT UY T&Iacute;N NHẤT HIỆN NAY</strong></h3>
                <p>Nha Khoa KIM l&agrave; hệ thống nha khoa được x&acirc;y dựng theo ti&ecirc;u chuẩn quốc tế, ti&ecirc;n phong thực hiện c&aacute;c dịch vụ nha khoa kh&ocirc;ng đau, gi&uacute;p kh&aacute;ch h&agrave;ng y&ecirc;n t&acirc;m v&agrave; thoải m&aacute;i khi chăm s&oacute;c sức khỏe răng miệng. Trải qua qu&aacute; tr&igrave;nh hoạt động v&agrave; ph&aacute;t triển, với cơ sở vật chất hiện đại &ndash; trang thiết bị, m&aacute;y m&oacute;c t&acirc;n tiến &ndash; đội ngũ b&aacute;c sĩ giỏi, d&agrave;y dặn kinh nghiệm &ndash; chất lượng dịch vụ tốt, Nha Khoa KIM tự h&agrave;o l&agrave; địa chỉ trồng răng implant uy t&iacute;n được nhiều chuy&ecirc;n gia đ&aacute;nh gi&aacute; cao.</p>
                <p><img class="alignnone size-full wp-image-7312     lazyloaded" style="display: block; margin-left: auto; margin-right: auto;" src="https://nhakhoakim.com/wp-content/uploads/2017/12/toanha-binhduong.png" sizes="(max-width: 700px) 100vw, 700px" srcset="https://nhakhoakim.com/wp-content/uploads/2017/12/toanha-binhduong.png 700w, https://nhakhoakim.com/wp-content/uploads/2017/12/toanha-binhduong-555x452.png 555w" alt="" width="700" height="570" data-lazy-src="https://nhakhoakim.com/wp-content/uploads/2017/12/toanha-binhduong.png" data-lazy-srcset="https://nhakhoakim.com/wp-content/uploads/2017/12/toanha-binhduong.png 700w, https://nhakhoakim.com/wp-content/uploads/2017/12/toanha-binhduong-555x452.png 555w" data-lazy-sizes="(max-width: 700px) 100vw, 700px" /></p>
                <p style="text-align: center;"><em>Nha Khoa KIM &ndash; Địa chỉ phục h&igrave;nh răng implant hiệu quả, an to&agrave;n.&nbsp;</em></p>
                <p>Hơn 15 năm qua,&nbsp;Nha khoa KIM&nbsp;đ&atilde; gi&uacute;p h&agrave;ng ng&agrave;n kh&aacute;ch h&agrave;ng khắc phục t&igrave;nh trạng mất răng nhanh ch&oacute;ng, an to&agrave;n, mang lại hiệu quả phục hồi như mong đợi. B&ecirc;n cạnh đ&oacute;, tại đ&acirc;y c&ograve;n đ&aacute;p ứng đầy đủ những điều kiện của một địa chỉ l&agrave;m răng tốt, uy t&iacute;n với nhiều ưu điểm vượt trội như:</p>
            </div>
            <p><img class="alignnone size-full wp-image-7610     lazyloaded" src="https://nhakhoakim.com/wp-content/uploads/2016/11/cong-i.png" alt="" width="25" height="24" data-lazy-src="https://nhakhoakim.com/wp-content/uploads/2016/11/cong-i.png" />&nbsp;Nha khoa KIM quy tụ nhiều b&aacute;c sĩ nha khoa h&agrave;ng đầu, gi&agrave;u kinh nghiệm trong cấy gh&eacute;p implant, do từng thực hiện v&ocirc; số ca phục hồi răng bị mất cho kh&aacute;ch h&agrave;ng bằng phương ph&aacute;p n&agrave;y trước đ&acirc;y. Hơn nữa, những b&aacute;c sĩ tại đ&acirc;y đều l&agrave; những người c&oacute; tr&igrave;nh độ chuy&ecirc;n m&ocirc;n cao, kiến thức vững v&agrave;ng, thao t&aacute;c chuẩn x&aacute;c, kh&eacute;o l&eacute;o, biết được phương ph&aacute;p n&agrave;o l&agrave; ph&ugrave; hợp cho từng trường hợp ri&ecirc;ng biệt. Đủ năng lực gi&uacute;p bạn sở hữu h&agrave;m răng đều đẹp m&agrave; kh&ocirc;ng gặp phải vấn đề g&igrave;.</p>
            <p><img class="alignnone size-full wp-image-9075     lazyloaded" style="display: block; margin-left: auto; margin-right: auto;" src="https://nhakhoakim.com/wp-content/uploads/2018/03/Trao-giai-bac-si-700.jpg" sizes="(max-width: 700px) 100vw, 700px" srcset="https://nhakhoakim.com/wp-content/uploads/2018/03/Trao-giai-bac-si-700.jpg 700w, https://nhakhoakim.com/wp-content/uploads/2018/03/Trao-giai-bac-si-700-555x383.jpg 555w" alt="" width="700" height="483" data-lazy-src="https://nhakhoakim.com/wp-content/uploads/2018/03/Trao-giai-bac-si-700.jpg" data-lazy-srcset="https://nhakhoakim.com/wp-content/uploads/2018/03/Trao-giai-bac-si-700.jpg 700w, https://nhakhoakim.com/wp-content/uploads/2018/03/Trao-giai-bac-si-700-555x383.jpg 555w" data-lazy-sizes="(max-width: 700px) 100vw, 700px" /></p>
            <p style="text-align: center;"><em>Đội ngũ b&aacute;c sĩ gi&agrave;u kinh nghiệm, giỏi chuy&ecirc;n m&ocirc;n tại Nha Khoa KIM</em></p>
            <p><strong><img class="alignnone size-full wp-image-7610     lazyloaded" src="https://nhakhoakim.com/wp-content/uploads/2016/11/cong-i.png" alt="" width="25" height="24" data-lazy-src="https://nhakhoakim.com/wp-content/uploads/2016/11/cong-i.png" />&nbsp;</strong>L&agrave; cơ sở nha khoa ti&ecirc;n phong trong việc ứng dụng c&ocirc;ng nghệ 3D v&agrave;o qu&aacute; tr&igrave;nh phục h&igrave;nh răng bị mất, gi&uacute;p việc trồng răng implant an to&agrave;n, ch&iacute;nh x&aacute;c, nhanh ch&oacute;ng, kh&ocirc;ng xảy ra c&aacute;c vấn đề ngo&agrave;i &yacute; muốn như m&aacute;y chụp X quang Cone Bean CT 3D, phần mềm lấy dấu h&agrave;m Scan 3D, phần mềm giả định vị tr&iacute; cấy gh&eacute;p Simplant 3D, hay CN thiết kế v&agrave; chế tạo răng sứ CAD/ CAM 3D&hellip; B&ecirc;n cạnh đ&oacute;, tất cả c&aacute;c c&ocirc;ng đoạn cắm gh&eacute;p implant đều c&oacute; sự hỗ trợ của m&aacute;y m&oacute;c, thiết bị hiện đại, t&acirc;n tiến bậc nhất. Đảm bảo tiến tr&igrave;nh cấy implant diễn ra thuận lợi, mang đến kết quả tốt như &yacute; muốn cho kh&aacute;ch h&agrave;ng.</p>
            <p><strong><img class="alignnone size-full wp-image-7610     lazyloaded" src="https://nhakhoakim.com/wp-content/uploads/2016/11/cong-i.png" alt="" width="25" height="24" data-lazy-src="https://nhakhoakim.com/wp-content/uploads/2016/11/cong-i.png" />&nbsp;</strong>Đặc biệt, Nha khoa KIM lu&ocirc;n đặt an to&agrave;n của kh&aacute;ch h&agrave;ng l&ecirc;n h&agrave;ng đầu n&ecirc;n&nbsp;tất cả&nbsp;dụng cụ v&agrave; thiết bị sử dụng đều được xử l&yacute; v&ocirc; tr&ugrave;ng bằng m&aacute;y hấp tiệt tr&ugrave;ng c&ocirc;ng nghệ cao, mỗi kh&aacute;ch h&agrave;ng l&agrave; 1 bộ tay khoan c&ugrave;ng 1 bộ dụng cụ ri&ecirc;ng&nbsp;nhằm tr&aacute;nh t&igrave;nh trạng l&acirc;y nhiễm ch&eacute;o. Ngo&agrave;i ra, quy tr&igrave;nh cấy gh&eacute;p implant ở đ&acirc;y tu&acirc;n thủ nghi&ecirc;m ngặt quy định của Bộ Y tế, mọi c&ocirc;ng đoạn đều được tiến h&agrave;nh một c&aacute;ch cẩn thận.</p>
            <p><img class="aligncenter wp-image-7917 size-full     lazyloaded" style="display: block; margin-left: auto; margin-right: auto;" title="Phương ph&aacute;p trồng răng implant" src="https://nhakhoakim.com/wp-content/uploads/2016/11/MG_5595.jpg" sizes="(max-width: 700px) 100vw, 700px" srcset="https://nhakhoakim.com/wp-content/uploads/2016/11/MG_5595.jpg 700w, https://nhakhoakim.com/wp-content/uploads/2016/11/MG_5595-555x369.jpg 555w" alt="Phương ph&aacute;p trồng răng implant" width="700" height="466" data-lazy-src="https://nhakhoakim.com/wp-content/uploads/2016/11/MG_5595.jpg" data-lazy-srcset="https://nhakhoakim.com/wp-content/uploads/2016/11/MG_5595.jpg 700w, https://nhakhoakim.com/wp-content/uploads/2016/11/MG_5595-555x369.jpg 555w" data-lazy-sizes="(max-width: 700px) 100vw, 700px" /></p>
            <p style="text-align: center;"><em>Thiết bị, dụng cụ sử dụng tại Nha khoa KIM được xử l&yacute; v&ocirc; tr&ugrave;ng ho&agrave;n to&agrave;n.</em></p>
            <p style="text-align: center;"><strong><img class="alignnone size-full wp-image-7610     lazyloaded" src="https://nhakhoakim.com/wp-content/uploads/2016/11/cong-i.png" alt="" width="25" height="24" data-lazy-src="https://nhakhoakim.com/wp-content/uploads/2016/11/cong-i.png" />&nbsp;</strong>Chất liệu răng sứ v&agrave; trụ implant nhập khẩu trực tiếp từ ch&acirc;u &Acirc;u, đ&atilde; được FDA Hoa Kỳ kiểm định về chất lượng. C&oacute; độ bền cao, th&acirc;n thiện, l&agrave;nh t&iacute;nh, kh&ocirc;ng g&acirc;y k&iacute;ch ứng với khoang miệng, c&oacute; khả năng tương th&iacute;ch cao với cơ thể, tuổi thọ l&acirc;u d&agrave;i.</p>
            <p style="text-align: center;"><strong><img class="alignnone size-full wp-image-7610     lazyloaded" src="https://nhakhoakim.com/wp-content/uploads/2016/11/cong-i.png" alt="" width="25" height="24" data-lazy-src="https://nhakhoakim.com/wp-content/uploads/2016/11/cong-i.png" />&nbsp;</strong>Đến với Nha khoa KIM bạn sẽ được&nbsp;thăm kh&aacute;m miễn ph&iacute;, c&aacute;c b&aacute;c sĩ v&agrave; tư vấn vi&ecirc;n chuy&ecirc;n nghiệp sẽ tư vấn tận t&igrave;nh mọi vấn đề li&ecirc;n quan về phương ph&aacute;p cấy gh&eacute;p implant. Hơn nữa, tại đ&acirc;y c&ograve;n cung cấp chế độ bảo h&agrave;nh răng đảm bảo cho kh&aacute;ch h&agrave;ng, gi&uacute;p mọi người y&ecirc;n t&acirc;m cải thiện t&igrave;nh trạng mất răng m&agrave; kh&ocirc;ng phải băn khoăn qu&aacute; nhiều.</p>
            <p style="text-align: center;"><img class="wp-image-7918 size-full aligncenter     lazyloaded" title="Trồng răng implant ở đ&acirc;u tốt" src="https://nhakhoakim.com/wp-content/uploads/2016/11/IMG_9945-1.jpg" sizes="(max-width: 700px) 100vw, 700px" srcset="https://nhakhoakim.com/wp-content/uploads/2016/11/IMG_9945-1.jpg 700w, https://nhakhoakim.com/wp-content/uploads/2016/11/IMG_9945-1-555x370.jpg 555w" alt="Trồng răng implant ở đ&acirc;u tốt" width="700" height="467" data-lazy-src="https://nhakhoakim.com/wp-content/uploads/2016/11/IMG_9945-1.jpg" data-lazy-srcset="https://nhakhoakim.com/wp-content/uploads/2016/11/IMG_9945-1.jpg 700w, https://nhakhoakim.com/wp-content/uploads/2016/11/IMG_9945-1-555x370.jpg 555w" data-lazy-sizes="(max-width: 700px) 100vw, 700px" /></p>
            <p style="text-align: center;"><em>Đến Nha khoa KIM bạn sẽ được tư vấn tận t&igrave;nh mọi vấn đề&nbsp;li&ecirc;n quan đến kỹ thuật cấy gh&eacute;p implant.</em></p>
            <p style="text-align: center;">&nbsp;</p>
            <hr />
            <p style="text-align: center;">H&Igrave;NH ẢNH KH&Aacute;CH H&Agrave;NG SAU KHI TRỒNG RĂNG IMPLANT TẠI NHA KHOA KIM</p>
            <p style="text-align: center;">Rất nhiều kh&aacute;ch h&agrave;ng thực hiện cấy răng implant tại Nha khoa KIM v&agrave; đạt được kết quả h&agrave;i l&ograve;ng như mong đợi.</p>
            <p style="text-align: center;"><img class="alignnone size-full wp-image-8700     lazyloaded" src="https://nhakhoakim.com/wp-content/uploads/2018/01/NGUYEN-THI-NGA.jpg" sizes="(max-width: 700px) 100vw, 700px" srcset="https://nhakhoakim.com/wp-content/uploads/2018/01/NGUYEN-THI-NGA.jpg 700w, https://nhakhoakim.com/wp-content/uploads/2018/01/NGUYEN-THI-NGA-555x332.jpg 555w" alt="" width="700" height="419" data-lazy-src="https://nhakhoakim.com/wp-content/uploads/2018/01/NGUYEN-THI-NGA.jpg" data-lazy-srcset="https://nhakhoakim.com/wp-content/uploads/2018/01/NGUYEN-THI-NGA.jpg 700w, https://nhakhoakim.com/wp-content/uploads/2018/01/NGUYEN-THI-NGA-555x332.jpg 555w" data-lazy-sizes="(max-width: 700px) 100vw, 700px" />&nbsp;<img class="alignnone size-full wp-image-8699     lazyloaded" src="https://nhakhoakim.com/wp-content/uploads/2018/01/HO-CANH.jpg" sizes="(max-width: 700px) 100vw, 700px" srcset="https://nhakhoakim.com/wp-content/uploads/2018/01/HO-CANH.jpg 700w, https://nhakhoakim.com/wp-content/uploads/2018/01/HO-CANH-555x332.jpg 555w" alt="" width="700" height="419" data-lazy-src="https://nhakhoakim.com/wp-content/uploads/2018/01/HO-CANH.jpg" data-lazy-srcset="https://nhakhoakim.com/wp-content/uploads/2018/01/HO-CANH.jpg 700w, https://nhakhoakim.com/wp-content/uploads/2018/01/HO-CANH-555x332.jpg 555w" data-lazy-sizes="(max-width: 700px) 100vw, 700px" />&nbsp;<img class="alignnone size-full wp-image-8698     lazyloaded" src="https://nhakhoakim.com/wp-content/uploads/2018/01/KH-NUOC-NGOAI.jpg" sizes="(max-width: 700px) 100vw, 700px" srcset="https://nhakhoakim.com/wp-content/uploads/2018/01/KH-NUOC-NGOAI.jpg 700w, https://nhakhoakim.com/wp-content/uploads/2018/01/KH-NUOC-NGOAI-555x332.jpg 555w" alt="" width="700" height="419" data-lazy-src="https://nhakhoakim.com/wp-content/uploads/2018/01/KH-NUOC-NGOAI.jpg" data-lazy-srcset="https://nhakhoakim.com/wp-content/uploads/2018/01/KH-NUOC-NGOAI.jpg 700w, https://nhakhoakim.com/wp-content/uploads/2018/01/KH-NUOC-NGOAI-555x332.jpg 555w" data-lazy-sizes="(max-width: 700px) 100vw, 700px" />&nbsp;<img class="alignnone size-full wp-image-8696     lazyloaded" src="https://nhakhoakim.com/wp-content/uploads/2018/01/BUI-THI-HAI.jpg" sizes="(max-width: 700px) 100vw, 700px" srcset="https://nhakhoakim.com/wp-content/uploads/2018/01/BUI-THI-HAI.jpg 700w, https://nhakhoakim.com/wp-content/uploads/2018/01/BUI-THI-HAI-555x332.jpg 555w" alt="" width="700" height="419" data-lazy-src="https://nhakhoakim.com/wp-content/uploads/2018/01/BUI-THI-HAI.jpg" data-lazy-srcset="https://nhakhoakim.com/wp-content/uploads/2018/01/BUI-THI-HAI.jpg 700w, https://nhakhoakim.com/wp-content/uploads/2018/01/BUI-THI-HAI-555x332.jpg 555w" data-lazy-sizes="(max-width: 700px) 100vw, 700px" /></p>
            <p><em>H&igrave;nh ảnh kh&aacute;ch h&agrave;ng trước v&agrave; sau khi cấy răng implant tại Nha Khoa KIM</em></p>
            <p><em>Lưu &yacute;: Kết quả t&ugrave;y thuộc v&agrave;o cơ địa của từng người.</em></p>
        </div>
	</div>
    @elseif($News->id==8)
    <div class="container">
        <p>NI&Ecirc;̀NG RĂNG INVISALIGN &ndash; GIẢI PHÁP CHỈNH NHA AN TOÀN, TH&Acirc;̉M MỸ CAO</p>
        <p data-fontsize="22" data-lineheight="48">Niềng răng invisalign l&agrave; kỹ thuật chỉnh nha hi&ecirc;̣n đại do các nh&agrave; khoa học hàng đ&acirc;̀u nước&nbsp;Mỹ nghi&ecirc;n cứu v&agrave; sáng ch&ecirc;́. Bằng cách sử dụng các khay ni&ecirc;̀ng trong su&ocirc;́t được thi&ecirc;́t k&ecirc;́ bằng nhự dẻo cao c&acirc;́p đ&ecirc;̉ &ocirc;m sát khít vào th&acirc;n răng, từ đó&nbsp;tạo ra một lực k&eacute;o dịch chuyển, xắp xếp cố định c&aacute;c răng bị h&ocirc;, móm, v&acirc;̉u, răng thưa, mọc kh&acirc;́p kh&ecirc;̉nh&hellip;. trở về đ&uacute;ng vị tr&iacute; khớp cắn tr&ecirc;n cung hàm, đ&ocirc;̀ng thời mang lại cho người d&ugrave;ng những&nbsp;c&ocirc;ng&nbsp;dụng n&ocirc;̉i b&acirc;̣t như:</p>
        <p style="text-align: center;" data-fontsize="22" data-lineheight="48">&nbsp;<img class="alignnone size-full wp-image-9300     lazyloaded" src="https://nhakhoakim.com/wp-content/uploads/2017/07/icon.png" alt="" width="25" height="25" data-lazy-src="https://nhakhoakim.com/wp-content/uploads/2017/07/icon.png" />&nbsp;Niềng răng invisalign được làm bằng nhựa dẻo trong suốt, có khả năng &ocirc;m s&aacute;t kh&iacute;t bề mặt răng n&ecirc;n&nbsp;đảm bảo t&iacute;nh thẩm mỹ r&acirc;́t cao, có th&ecirc;̉ thoải mái giao ti&ecirc;́p mà kh&ocirc;ng sợ bị người khác phát hi&ecirc;̣n.</p>
        <p style="text-align: center;" data-fontsize="22" data-lineheight="48"><img class="size-full wp-image-8320     lazyloaded" src="https://nhakhoakim.com/wp-content/uploads/2016/11/invisalign-1-1.jpg" sizes="(max-width: 700px) 100vw, 700px" srcset="https://nhakhoakim.com/wp-content/uploads/2016/11/invisalign-1-1.jpg 700w, https://nhakhoakim.com/wp-content/uploads/2016/11/invisalign-1-1-555x290.jpg 555w" alt="" width="700" height="366" data-lazy-src="https://nhakhoakim.com/wp-content/uploads/2016/11/invisalign-1-1.jpg" data-lazy-srcset="https://nhakhoakim.com/wp-content/uploads/2016/11/invisalign-1-1.jpg 700w, https://nhakhoakim.com/wp-content/uploads/2016/11/invisalign-1-1-555x290.jpg 555w" data-lazy-sizes="(max-width: 700px) 100vw, 700px" /></p>
        <p style="text-align: center;" data-fontsize="22" data-lineheight="48"><em>Niềng răng invisalign đảm bảo tính th&acirc;̉m mỹ cao, khó bị phát hi&ecirc;̣n khi giao ti&ecirc;́p</em></p>
        <p data-fontsize="22" data-lineheight="48"><img class="alignnone size-full wp-image-9300     lazyloaded" src="https://nhakhoakim.com/wp-content/uploads/2017/07/icon.png" alt="" width="25" height="25" data-lazy-src="https://nhakhoakim.com/wp-content/uploads/2017/07/icon.png" />&nbsp;Niềng răng kh&ocirc;ng mắc c&agrave;i Invisalign còn có khả năng khắc phục hiệu quả h&agrave;ng loạt các khiếm khuyết sai lệch tr&ecirc;n răng như: Mọc thưa, lộn xộn, lệch lạc, khểnh, h&ocirc;, vẩu, m&oacute;m, chen ch&uacute;c&hellip; Mang lại h&agrave;m răng đều đẹp, c&acirc;n đối, h&agrave;i h&ograve;a v&agrave; đ&uacute;ng khớp cắn.</p>
        <p data-fontsize="22" data-lineheight="48"><img class="alignnone size-full wp-image-9300     lazyloaded" src="https://nhakhoakim.com/wp-content/uploads/2017/07/icon.png" alt="" width="25" height="25" data-lazy-src="https://nhakhoakim.com/wp-content/uploads/2017/07/icon.png" />&nbsp;Ngược lại với niềng răng mắc c&agrave;i, phương pháp niềng răng invisalign&nbsp;được thiết kế dưới dạng khay&nbsp;n&ecirc;n&nbsp;c&oacute; thể th&aacute;o lắp dễ d&agrave;ng, vừa tiện lợi cho việc ăn uống, vừa dễ d&agrave;ng vệ sinh răng miệng hằng ng&agrave;y.</p>
        <p data-fontsize="22" data-lineheight="48"><img class="alignnone size-full wp-image-5677     lazyloaded" style="display: block; margin-left: auto; margin-right: auto;" src="https://nhakhoabienhoa.net/wp-content/uploads/2016/12/nieng-rang4.jpg" alt="" width="700" height="400" data-lazy-src="https://nhakhoabienhoa.net/wp-content/uploads/2016/12/nieng-rang4.jpg" /></p>
        <p style="text-align: center;" data-fontsize="22" data-lineheight="48"><em>Niềng răng invisalign&nbsp;c&oacute; thể th&aacute;o lắp dễ d&agrave;ng, vừa tiện lợi cho việc ăn uống, vừa dễ d&agrave;ng vệ sinh răng miệng hằng ng&agrave;y</em></p>
        <p><img class="alignnone size-full wp-image-9300     lazyloaded" src="https://nhakhoakim.com/wp-content/uploads/2017/07/icon.png" alt="" width="25" height="25" data-lazy-src="https://nhakhoakim.com/wp-content/uploads/2017/07/icon.png" />&nbsp;Niềng răng kh&ocirc;ng mắc c&agrave;i Invisalign được chế tạo từ nhựa y tế chuy&ecirc;n dụng, c&aacute;c khay niềng được b&aacute;c sĩ chế tạo ph&ugrave; hợp với k&iacute;ch cỡ của h&agrave;m răng, n&ecirc;n rất an to&agrave;n v&agrave; l&agrave;nh t&iacute;nh với cơ thể, kh&ocirc;ng g&acirc;y đau đớn hay kh&oacute; chịu khi mang niềng mỗi ng&agrave;y.</p>
        <hr />
        <p>NI&Ecirc;̀NG RĂNG INVISALIGN TẠI NHA KHOA KIM GIÁ BAO NHI&Ecirc;U?</p>
        <p data-fontsize="22" data-lineheight="48">Hiện tại, Nha Khoa Kim l&agrave; một trong những địa chỉ đ&atilde; &aacute;p dụng th&agrave;nh c&ocirc;ng kỹ thuật ni&ecirc;̀ng răng Invisalign&nbsp;với một mức gi&aacute; vừa phải, ph&ugrave; hợp với nhu cầu v&agrave; nguồn t&agrave;i ch&iacute;nh của mọi kh&aacute;ch h&agrave;ng.&nbsp;</p>
        <hr />
        <p>NHA KHOA KIM &ndash; ĐỊA CHỈ NI&Ecirc;̀NG RĂNG&nbsp;INVISALIGN&nbsp;UY TÍN&nbsp;VÀ HI&Ecirc;̣U QUẢ HI&Ecirc;̣N NAY</p>
        <div class="reading-box element-bottomshadow">
            <p>Được x&acirc;y dựng theo m&ocirc; h&igrave;nh chuẩn nha khoa quốc tế, &aacute;p dụng kỹ thuật thăm kh&aacute;m v&agrave; điều trị hiện đại, Nha Khoa KIM đ&atilde; v&agrave; đang l&agrave; địa chỉ niềng răng&nbsp; Invisalign được đ&ocirc;ng đảo kh&aacute;ch h&agrave;ng tin tưởng lựa chọn, khi muốn khắc phục c&aacute;c khiếm khuyết, cải thiện h&agrave;m răng đều, đẹp v&agrave; tự nhi&ecirc;n.</p>
            <p style="text-align: center;"><img class="alignnone size-full wp-image-7610     lazyloaded" src="https://nhakhoakim.com/wp-content/uploads/2016/11/cong-i.png" alt="" width="25" height="24" data-lazy-src="https://nhakhoakim.com/wp-content/uploads/2016/11/cong-i.png" />&nbsp;Tại Nha Khoa KIM, trực ti&ecirc;́p thăm khám, tư v&acirc;́n và ni&ecirc;̀ng răng Invisalign cho khách hàng là đ&ocirc;̣i ngũ bác sĩ có tay nghề chuy&ecirc;n m&ocirc;n cao, gi&agrave;u kinh nghiệm trong lĩnh vực răng h&agrave;m mặt cũng như được đ&agrave;o tạo b&agrave;i bản. Kh&ocirc;ng chỉ trực tiếp thăm kh&aacute;m v&agrave; niềng răng cho kh&aacute;ch h&agrave;ng, c&aacute;c b&aacute;c sĩ tại đ&acirc;y c&ograve;n c&oacute; khả năng xử l&yacute; nhạy b&eacute;n, chuẩn x&aacute;c mọi t&igrave;nh huống, chắc chắn sẽ làm khách hàng hài lòng với k&ecirc;́t quả đạt được.</p>
            <p style="text-align: center;"><img class="alignnone size-full wp-image-9220     lazyloaded" src="https://nhakhoakim.com/wp-content/uploads/2018/03/doingubsnkk-1-1.png" sizes="(max-width: 700px) 100vw, 700px" srcset="https://nhakhoakim.com/wp-content/uploads/2018/03/doingubsnkk-1-1.png 700w, https://nhakhoakim.com/wp-content/uploads/2018/03/doingubsnkk-1-1-555x320.png 555w" alt="" width="700" height="403" data-lazy-src="https://nhakhoakim.com/wp-content/uploads/2018/03/doingubsnkk-1-1.png" data-lazy-srcset="https://nhakhoakim.com/wp-content/uploads/2018/03/doingubsnkk-1-1.png 700w, https://nhakhoakim.com/wp-content/uploads/2018/03/doingubsnkk-1-1-555x320.png 555w" data-lazy-sizes="(max-width: 700px) 100vw, 700px" /></p>
            <p style="text-align: center;"><em>Đội ngũ b&aacute;c sĩ gi&agrave;u kinh nghiệm, giỏi chuy&ecirc;n m&ocirc;n tại Nha khoa KIM</em></p>
            <p><img class="alignnone size-full wp-image-7610     lazyloaded" src="https://nhakhoakim.com/wp-content/uploads/2016/11/cong-i.png" alt="" width="25" height="24" data-lazy-src="https://nhakhoakim.com/wp-content/uploads/2016/11/cong-i.png" />&nbsp;B&ecirc;̣nh vi&ecirc;̣n c&ograve;n ti&ecirc;n phong trong vi&ecirc;̣c trang bị đầy đủ h&agrave;ng loạt máy móc&nbsp;v&agrave; thiết bị t&ocirc;́i t&acirc;n: Máy chụp CT 3D Panorex &amp; Cephalometric, phần mềm Vceph 3D &hellip;&nbsp;qua đó h&ocirc;̃ trợ&nbsp;b&aacute;c sĩ d&ecirc;̃ dàng&nbsp;x&aacute;c định được cụ thể t&igrave;nh trạng răng h&agrave;m hiện tại, nguy&ecirc;n nh&acirc;n v&agrave; mức độ lệch lạc&hellip; của răng cần khắc phục, gi&uacute;p mang lại kết quả nhanh ch&oacute;ng, an to&agrave;n, ch&iacute;nh x&aacute;c nhất.</p>
            <p style="text-align: center;"><img class="alignnone size-full wp-image-7610     lazyloaded" src="https://nhakhoakim.com/wp-content/uploads/2016/11/cong-i.png" alt="" width="25" height="24" data-lazy-src="https://nhakhoakim.com/wp-content/uploads/2016/11/cong-i.png" />&nbsp;B&ecirc;n cạnh đó,&nbsp;Nha khoa KIM cũng đặc biệt ch&uacute; trọng cao đến yếu tố v&ocirc; tr&ugrave;ng kh&ocirc;ng khí bằng cách trang bị h&ecirc;̣ th&ocirc;́ng máy phun sương hi&ecirc;̣n đại và lò h&acirc;́p sát khu&acirc;̉n dụng cụ. Mỗi kh&aacute;ch h&agrave;ng khi đến thăm kh&aacute;m tại đ&acirc;y đều được sắp xếp v&agrave;o 1 ph&ograve;ng ri&ecirc;ng biệt, 1 b&aacute;c sĩ thực hiện, 1 bộ tay khoan, 1 bộ dụng cụ ri&ecirc;ng, nhằm tránh tình trạng l&acirc;y nhi&ecirc;̃m chéo.</p>
            <p style="text-align: center;"><img class="alignnone size-full wp-image-6210     lazyloaded" src="https://nhakhoabienhoa.net/wp-content/uploads/2016/12/cay-ghep-rang-implant-o-dau-tot-2-1.jpg" alt="" width="700" height="500" data-lazy-src="https://nhakhoabienhoa.net/wp-content/uploads/2016/12/cay-ghep-rang-implant-o-dau-tot-2-1.jpg" /></p>
            <p style="text-align: center;"><em>Nha khoa KIM cũng đặc biệt ch&uacute; trọng cao đến yếu tố v&ocirc; tr&ugrave;ng kh&ocirc;ng khí</em></p>
            <p><img class="alignnone size-full wp-image-7610     lazyloaded" src="https://nhakhoakim.com/wp-content/uploads/2016/11/cong-i.png" alt="" width="25" height="24" data-lazy-src="https://nhakhoakim.com/wp-content/uploads/2016/11/cong-i.png" />&nbsp;Trước khi thực hiện niềng răng Invisalign tại Nha Khoa KIM, kh&aacute;ch h&agrave;ng c&ograve;n được &nbsp;k&yacute; hợp đồng để cam kết hiệu quả v&agrave; thời gian niềng răng theo đ&uacute;ng lộ tr&igrave;nh điều trị đ&atilde; lập ra ban đầu.</p>
        </div>
    </div>
    @elseif($News->id==9)
        <div class="container">
            <p><strong>Mặt d&aacute;n sứ Veneer l&agrave; g&igrave;? Ph&ugrave; hợp với đối tượng n&agrave;o?</strong></p>
            <p>Mặt d&aacute;n sứ Veneer l&agrave; kỹ thuật phục h&igrave;nh răng tối ưu, sử dụng vật liệu d&aacute;n răng được thiết kế dựa tr&ecirc;n k&iacute;ch thước răng của từng người với độ d&agrave;y từ 0,5 &ndash; 0,6 mm để thay thế men răng thật, nhằm khắc phục nhanh ch&oacute;ng c&aacute;c khuyết điểm về răng xấu, bảo to&agrave;n cấu tr&uacute;c răng v&agrave; đặc biệt l&agrave; cải thiện t&iacute;nh thẩm mỹ tốt hơn.</p>
            <p><img class="alignnone size-full wp-image-6347     lazyloaded" style="display: block; margin-left: auto; margin-right: auto;" src="https://nhakhoakim.com/wp-content/uploads/2016/11/veneer-su-gia-bao-nhieu-1.jpg" sizes="(max-width: 600px) 100vw, 600px" srcset="https://nhakhoakim.com/wp-content/uploads/2016/11/veneer-su-gia-bao-nhieu-1.jpg 600w, https://nhakhoakim.com/wp-content/uploads/2016/11/veneer-su-gia-bao-nhieu-1-555x404.jpg 555w" alt="" width="600" height="437" data-lazy-src="https://nhakhoakim.com/wp-content/uploads/2016/11/veneer-su-gia-bao-nhieu-1.jpg" data-lazy-srcset="https://nhakhoakim.com/wp-content/uploads/2016/11/veneer-su-gia-bao-nhieu-1.jpg 600w, https://nhakhoakim.com/wp-content/uploads/2016/11/veneer-su-gia-bao-nhieu-1-555x404.jpg 555w" data-lazy-sizes="(max-width: 600px) 100vw, 600px" /></p>
            <p><em>Mặt d&aacute;n sứ veneer l&agrave; phương ph&aacute;p phục h&igrave;nh răng được nhiều người hiện nay ưa chuộng</em></p>
            <p>Hiện nay, tại c&aacute;c trung t&acirc;m nha khoa lớn thường &aacute;p dụng phổ biến phương ph&aacute;p n&agrave;y cho một số trường hợp dưới đ&acirc;y:</p>
            <p><img class="alignnone size-full wp-image-2953     lazyloaded" src="https://nhakhoakim.com/wp-content/uploads/2016/11/tick-1.png" alt="" width="30" height="30" data-lazy-src="https://nhakhoakim.com/wp-content/uploads/2016/11/tick-1.png" />Răng bị nhiễm m&agrave;u do nhiễm thuốc kh&aacute;ng sinh m&agrave; tẩy trắng răng kh&ocirc;ng thể mang lại hiệu quả</p>
            <p><img class="alignnone size-full wp-image-2953     lazyloaded" src="https://nhakhoakim.com/wp-content/uploads/2016/11/tick-1.png" alt="" width="30" height="30" data-lazy-src="https://nhakhoakim.com/wp-content/uploads/2016/11/tick-1.png" />&nbsp;Răng bị thưa,&nbsp;hai răng cửa c&oacute; k&iacute;ch thước to hơn c&aacute;c răng c&ograve;n lại</p>
            <p><img class="alignnone size-full wp-image-2953     lazyloaded" src="https://nhakhoakim.com/wp-content/uploads/2016/11/tick-1.png" alt="" width="30" height="30" data-lazy-src="https://nhakhoakim.com/wp-content/uploads/2016/11/tick-1.png" />&nbsp;Răng bị sứt mẻ,&nbsp;bể vỡ</p>
            <p><img class="alignnone size-full wp-image-2953     lazyloaded" src="https://nhakhoakim.com/wp-content/uploads/2016/11/tick-1.png" alt="" width="30" height="30" data-lazy-src="https://nhakhoakim.com/wp-content/uploads/2016/11/tick-1.png" />&nbsp;Răng cửa bị tổn thương&hellip;</p>
            <p><strong>Tại sao mặt d&aacute;n sứ Veneer lại được nhiều người y&ecirc;u th&iacute;ch?</strong></p>
            <p>Mặc d&ugrave; vẫn c&ograve;n l&agrave; một phương ph&aacute;p kh&aacute; mới mẻ nhưng mặt d&aacute;n sứ veneer lại thu h&uacute;t được sự quan t&acirc;m của rất nhiều người v&agrave; nhanh ch&oacute;ng chiếm trọn sự tin y&ecirc;u của đ&ocirc;ng đảo kh&aacute;ch h&agrave;ng tr&ecirc;n khắp thế giới nhờ v&agrave;o những ưu điểm nổi trội như:</p>
            <p><strong><img class="alignnone size-full wp-image-26933 lazyloaded" src="https://benhvienranghammat.com.vn/wp-content/uploads/2016/06/tick-3.jpg" alt="tick-3" width="22" height="24" data-lazy-src="https://benhvienranghammat.com.vn/wp-content/uploads/2016/06/tick-3.jpg" />&nbsp;Hạn chế m&agrave;i răng, bảo tồn răng thật tối đa</strong></p>
            <p>Thay v&igrave; phải m&agrave;i xung quanh răng như c&aacute;c phương ph&aacute;p bọc răng sứ kh&aacute;c, mặt d&aacute;n&nbsp;răng&nbsp;sứ Veneer chỉ cần thực hiện m&agrave;i một phần men răng ở mặt trước của răng v&agrave; tỷ lệ m&agrave;i rất &iacute;t, khoảng 1/2 so với l&agrave;m răng th&ocirc;ng thường n&ecirc;n c&oacute; thể gi&uacute;p&nbsp;hỗ trợ bảo tồn răng thật tối đa,&nbsp;kh&ocirc;ng cần phải lấy tủy, kh&ocirc;ng&nbsp;l&agrave;m răng bị &ecirc; buốt cả trong v&agrave; sau khi&nbsp;l&agrave;m.</p>
            <p><strong><img class="alignnone size-full wp-image-26933 lazyloaded" src="https://benhvienranghammat.com.vn/wp-content/uploads/2016/06/tick-3.jpg" alt="tick-3" width="22" height="24" data-lazy-src="https://benhvienranghammat.com.vn/wp-content/uploads/2016/06/tick-3.jpg" />&nbsp;Đảm bảo t&iacute;nh thẩm mỹ cao</strong></p>
            <p>Mặt d&aacute;n sứ Veneer được cấu tạo từ chất liệu sứ nguy&ecirc;n chất, v&igrave; vậy c&oacute; thể gi&uacute;p khắc phục hiệu quả c&aacute;c khiếm khuyết tr&ecirc;n răng như: Răng bị mất men, sứt mẻ, m&eacute;o , vẹo, thiếu c&acirc;n đối&hellip; đặc biệt l&agrave; đối với răng cửa.</p>
            <p><img class="alignnone wp-image-6348     lazyloaded" style="display: block; margin-left: auto; margin-right: auto;" src="https://nhakhoakim.com/wp-content/uploads/2016/11/mat-dan-veneer-su.jpg" sizes="(max-width: 600px) 100vw, 600px" srcset="https://nhakhoakim.com/wp-content/uploads/2016/11/mat-dan-veneer-su.jpg 800w, https://nhakhoakim.com/wp-content/uploads/2016/11/mat-dan-veneer-su-768x480.jpg 768w, https://nhakhoakim.com/wp-content/uploads/2016/11/mat-dan-veneer-su-555x347.jpg 555w" alt="" width="600" height="375" data-lazy-src="https://nhakhoakim.com/wp-content/uploads/2016/11/mat-dan-veneer-su.jpg" data-lazy-srcset="https://nhakhoakim.com/wp-content/uploads/2016/11/mat-dan-veneer-su.jpg 800w, https://nhakhoakim.com/wp-content/uploads/2016/11/mat-dan-veneer-su-768x480.jpg 768w, https://nhakhoakim.com/wp-content/uploads/2016/11/mat-dan-veneer-su-555x347.jpg 555w" data-lazy-sizes="(max-width: 600px) 100vw, 600px" /></p>
            <p style="text-align: center;"><em>Mặt d&aacute;n sứ&nbsp;Veneer&nbsp; đảm bảo t&iacute;nh thẩm mỹ cao với h&agrave;m răng đều, đẹp, tự nhi&ecirc;n</em></p>
            <p><strong><img class="alignnone size-full wp-image-26933 lazyloaded" src="https://benhvienranghammat.com.vn/wp-content/uploads/2016/06/tick-3.jpg" alt="tick-3" width="22" height="24" data-lazy-src="https://benhvienranghammat.com.vn/wp-content/uploads/2016/06/tick-3.jpg" />&nbsp;Kh&ocirc;ng g&acirc;y ảnh hưởng đến răng thật</strong></p>
            <p>&nbsp;Kh&aacute;c với c&aacute;c phương ph&aacute;p bọc răng sứ th&ocirc;ng thường, mặt d&aacute;n sứ Veneer c&oacute; thể bảo tồn được tối đa răng thật , nhờ đ&oacute; gi&uacute;p giảm thiểu tối đa t&igrave;nh trạng m&agrave;i răng, cũng như kh&ocirc;ng g&acirc;y ảnh hưởng đến c&aacute;c răng kế cận.</p>
            <p><strong><img class="alignnone size-full wp-image-26933 lazyloaded" src="https://benhvienranghammat.com.vn/wp-content/uploads/2016/06/tick-3.jpg" alt="tick-3" width="22" height="24" data-lazy-src="https://benhvienranghammat.com.vn/wp-content/uploads/2016/06/tick-3.jpg" />&nbsp;Kh&ocirc;ng g&acirc;y kh&oacute; khăn khi ăn nhai&nbsp;</strong></p>
            <p style="text-align: left;">Mặt d&aacute;n&nbsp;răng&nbsp;sứ Veneer được thiết kế kh&aacute; mỏng, chỉ khoảng từ 0,5 &ndash; 0,6 mm, do đ&oacute; khi được gắn v&agrave;o răng sẽ kh&ocirc;ng l&agrave;m bạn cảm thấy vướng v&iacute;u, cộm cấn hay kh&oacute; chịu.Thoải m&aacute;i ăn nhai v&agrave; giao tiếp m&agrave; kh&ocirc;ng sợ bị người kh&aacute;c ph&aacute;t hiện.</p>
            <p style="text-align: center;"><img class="alignnone size-full wp-image-6349     lazyloaded" src="https://nhakhoakim.com/wp-content/uploads/2016/11/trong-rang-su.jpg" sizes="(max-width: 600px) 100vw, 600px" srcset="https://nhakhoakim.com/wp-content/uploads/2016/11/trong-rang-su.jpg 600w, https://nhakhoakim.com/wp-content/uploads/2016/11/trong-rang-su-555x415.jpg 555w" alt="" width="600" height="450" data-lazy-src="https://nhakhoakim.com/wp-content/uploads/2016/11/trong-rang-su.jpg" data-lazy-srcset="https://nhakhoakim.com/wp-content/uploads/2016/11/trong-rang-su.jpg 600w, https://nhakhoakim.com/wp-content/uploads/2016/11/trong-rang-su-555x415.jpg 555w" data-lazy-sizes="(max-width: 600px) 100vw, 600px" /></p>
            <p style="text-align: center;"><em>Mặt d&aacute;n&nbsp;răng&nbsp;sứ Veneer được thiết kế kh&aacute; mỏng n&ecirc;n kh&aacute; thoải m&aacute;i khi ăn nhai, kh&ocirc;ng lo cộm cấn</em></p>
            <p><strong><img class="alignnone size-full wp-image-26933 lazyloaded" src="https://benhvienranghammat.com.vn/wp-content/uploads/2016/06/tick-3.jpg" alt="tick-3" width="22" height="24" data-lazy-src="https://benhvienranghammat.com.vn/wp-content/uploads/2016/06/tick-3.jpg" />&nbsp;Tuổi thọ cao</strong></p>
            <p>Tuổi thọ của mặt d&aacute;n sứ Veneer c&oacute; thể k&eacute;o d&agrave;i từ 10 &ndash; 15 năm nếu được chăm s&oacute;c v&agrave; bảo vệ đ&uacute;ng c&aacute;ch.&nbsp; B&ecirc;n cạnh đ&oacute;, mặt d&aacute;n sứ c&ograve;n b&aacute;m&nbsp;chắc tr&ecirc;n th&acirc;n răng, kh&ocirc;ng bị k&ecirc;nh hở, kh&ocirc;ng dễ bị bong, bật khi nhai gắn, chải răng nhờ chất liệu kết d&iacute;nh đặc biệt, kh&ocirc;ng dễ bị h&oacute;a lỏng l&agrave;m rơi miếng d&aacute;n n&ecirc;n bạn c&oacute; thể y&ecirc;n t&acirc;m khi sử dụng.</p>
        </div>
    @elseif($News->id==10)
        <div class="container">
            <p>TẠI SAO N&Ecirc;N TẨY TRẮNG RĂNG BẰNG C&Ocirc;NG NGHỆ BLEACH BRIGHT?</p>
            <p>Tẩy trắng răng c&ocirc;ng nghệ Bleach Bright được coi l&agrave; một ph&aacute;t minh vượt bậc của ng&agrave;nh nha khoa thẩm mỹ. Hoạt động dựa tr&ecirc;n sự kết hợp đặc biệt giữa chất gel l&agrave;m trắng với &aacute;nh s&aacute;ng xanh dịu nhẹ, tẩy trắng răng c&ocirc;ng nghệ Bleach Bright&nbsp;sẽ nhanh ch&oacute;ng ph&aacute; vỡ c&aacute;c li&ecirc;n kết h&oacute;a học b&ecirc;n trong răng, gi&uacute;p loại bỏ hiệu quả c&aacute;c lớp ng&agrave; răng ố v&agrave;ng đem đến vẻ trắng s&aacute;ng cho h&agrave;m răng v&agrave; chiếm trọn cảm t&igrave;nh của đ&ocirc;ng đảo kh&aacute;ch h&agrave;ng cũng như nhiều chuy&ecirc;n gia nha khoa bởi:</p>
            <p><img class="alignnone size-full wp-image-7611     lazyloaded" src="https://nhakhoakim.com/wp-content/uploads/2016/11/thang-i.png" alt="" width="25" height="25" data-lazy-src="https://nhakhoakim.com/wp-content/uploads/2016/11/thang-i.png" />Hiệu quả tẩy trắng răng vượt trội, l&ecirc;n nhiều t&ocirc;ng m&agrave;u ngay sau khi thực hiện</p>
            <p><img class="alignnone size-full wp-image-7611     lazyloaded" src="https://nhakhoakim.com/wp-content/uploads/2016/11/thang-i.png" alt="" width="25" height="25" data-lazy-src="https://nhakhoakim.com/wp-content/uploads/2016/11/thang-i.png" />&nbsp;Mang đến h&agrave;m răng trắng s&aacute;ng đều m&agrave;u tự nhi&ecirc;n từ s&acirc;u b&ecirc;n trong.</p>
            <p><img class="alignnone size-full wp-image-7611     lazyloaded" src="https://nhakhoakim.com/wp-content/uploads/2016/11/thang-i.png" alt="" width="25" height="25" data-lazy-src="https://nhakhoakim.com/wp-content/uploads/2016/11/thang-i.png" />&nbsp;Thời gian thực hiện ngắn, kỹ thuật đơn giản, nhẹ nh&agrave;ng</p>
            <p><img class="alignnone size-full wp-image-8383     lazyloaded" src="https://nhakhoakim.com/wp-content/uploads/2016/11/nieng-rang-00-1.jpg" sizes="(max-width: 700px) 100vw, 700px" srcset="https://nhakhoakim.com/wp-content/uploads/2016/11/nieng-rang-00-1.jpg 700w, https://nhakhoakim.com/wp-content/uploads/2016/11/nieng-rang-00-1-555x321.jpg 555w" alt="" width="700" height="405" data-lazy-src="https://nhakhoakim.com/wp-content/uploads/2016/11/nieng-rang-00-1.jpg" data-lazy-srcset="https://nhakhoakim.com/wp-content/uploads/2016/11/nieng-rang-00-1.jpg 700w, https://nhakhoakim.com/wp-content/uploads/2016/11/nieng-rang-00-1-555x321.jpg 555w" data-lazy-sizes="(max-width: 700px) 100vw, 700px" /></p>
            <p><em>Tẩy rắng răng mang đến h&agrave;m răng trắng s&aacute;ng, đều m&agrave;u</em></p>
            <p><img class="alignnone size-full wp-image-7611     lazyloaded" src="https://nhakhoakim.com/wp-content/uploads/2016/11/thang-i.png" alt="" width="25" height="25" data-lazy-src="https://nhakhoakim.com/wp-content/uploads/2016/11/thang-i.png" />&nbsp;C&oacute; t&iacute;nh&nbsp;an to&agrave;n cao, kh&ocirc;ng g&acirc;y t&aacute;c dụng phụ đến sức khỏe hay cho răng nướu, kh&ocirc;ng ảnh hưởng đến men răng</p>
            <p><img class="alignnone size-full wp-image-7611     lazyloaded" src="https://nhakhoakim.com/wp-content/uploads/2016/11/thang-i.png" alt="" width="25" height="25" data-lazy-src="https://nhakhoakim.com/wp-content/uploads/2016/11/thang-i.png" />&nbsp;Kh&ocirc;ng c&oacute;&nbsp;dấu hiệu của dị ứng hay biến chứng n&agrave;o&nbsp;v&igrave; c&ocirc;ng nghệ c&oacute; khả năng kiểm so&aacute;t lượng nhiệt v&agrave; &aacute;nh s&aacute;ng ph&aacute;t ra.</p>
            <p><img class="alignnone size-full wp-image-7611     lazyloaded" src="https://nhakhoakim.com/wp-content/uploads/2016/11/thang-i.png" alt="" width="25" height="25" data-lazy-src="https://nhakhoakim.com/wp-content/uploads/2016/11/thang-i.png" />&nbsp;M&agrave;u sắc của răng được duy tr&igrave; l&acirc;u d&agrave;i.&nbsp;Khả năng duy tr&igrave; độ trắng s&aacute;ng của răng l&acirc;u d&agrave;i từ 3 &ndash; 5 năm</p>
            <p><img class="alignnone size-full wp-image-7611     lazyloaded" src="https://nhakhoakim.com/wp-content/uploads/2016/11/thang-i.png" alt="" width="25" height="25" data-lazy-src="https://nhakhoakim.com/wp-content/uploads/2016/11/thang-i.png" />&nbsp;Với&nbsp;phản ứng t&aacute;i kho&aacute;ng men, sau khi tẩy trắng răng bằng c&ocirc;ng nghệ n&agrave;y sẽ gi&uacute;p cho răng chắc khỏe hơn</p>
            <hr />
            <p>H&Agrave;NG NG&Agrave;N KH&Aacute;CH H&Agrave;NG&nbsp;Đ&Atilde; T&Igrave;M THẤY NỤ CƯỜI MỚI TẠI NHA KHOA KIM</p>
            <p style="text-align: left;">Với hệ thống gần 30 cơ sở trải d&agrave;i khắp từ Nam ra Bắc, quy tụ đội ngũ 100 b&aacute;c sĩ chuy&ecirc;n gia đầu ng&agrave;nh, trang bị m&aacute;y m&oacute;c hiện đại c&ugrave;ng c&ocirc;ng nghệ ti&ecirc;n tiến, Nha Khoa KIM<em>&nbsp;</em>đ&atilde; chăm s&oacute;c v&agrave; thẩm mỹ nụ cười, tự h&agrave;o đ&atilde; l&agrave;m h&agrave;i l&ograve;ng h&agrave;ng ng&agrave;n kh&aacute;ch h&agrave;ng trong v&agrave; ngo&agrave;i nước.</p>
            <p style="text-align: center;"><iframe class="     lazyloaded" src="https://www.youtube.com/embed/OpE9UNHyhfg?rel=0" width="560" height="315" frameborder="0" allowfullscreen="allowfullscreen" data-lazy-src="https://www.youtube.com/embed/OpE9UNHyhfg?rel=0" data-mce-fragment="1"></iframe></p>
            <p style="text-align: center;"><em>Diễn vi&ecirc;n, người mẫu Tuy&ecirc;́t Trinh với nụ cười ho&agrave;n hảo v&agrave; h&agrave;m răng trắng đẹp sau khi đến&nbsp;Nha Khoa KIM tẩy trắng răng</em></p>
            <p style="text-align: center;"><img class="alignnone size-full wp-image-8580     lazyloaded" src="https://nhakhoakim.com/wp-content/uploads/2016/11/4-3.jpg" sizes="(max-width: 700px) 100vw, 700px" srcset="https://nhakhoakim.com/wp-content/uploads/2016/11/4-3.jpg 700w, https://nhakhoakim.com/wp-content/uploads/2016/11/4-3-95x95.jpg 95w, https://nhakhoakim.com/wp-content/uploads/2016/11/4-3-50x50.jpg 50w, https://nhakhoakim.com/wp-content/uploads/2016/11/4-3-555x555.jpg 555w, https://nhakhoakim.com/wp-content/uploads/2016/11/4-3-45x45.jpg 45w" alt="" width="700" height="700" data-lazy-src="https://nhakhoakim.com/wp-content/uploads/2016/11/4-3.jpg" data-lazy-srcset="https://nhakhoakim.com/wp-content/uploads/2016/11/4-3.jpg 700w, https://nhakhoakim.com/wp-content/uploads/2016/11/4-3-95x95.jpg 95w, https://nhakhoakim.com/wp-content/uploads/2016/11/4-3-50x50.jpg 50w, https://nhakhoakim.com/wp-content/uploads/2016/11/4-3-555x555.jpg 555w, https://nhakhoakim.com/wp-content/uploads/2016/11/4-3-45x45.jpg 45w" data-lazy-sizes="(max-width: 700px) 100vw, 700px" /></p>
            <p style="text-align: center;"><em>Diễn Vi&ecirc;n Kịch, MC, Người mẫu Nguy&ecirc;n Th&agrave;nh h&agrave;i l&ograve;ng về h&agrave;m răng trắng s&aacute;ng hơn, kh&ocirc;ng &ecirc; buốt sau khi tẩy trắng răng tại Nha Khoa KIM</em></p>
            <p style="text-align: center;"><img class="alignnone size-full wp-image-8581     lazyloaded" src="https://nhakhoakim.com/wp-content/uploads/2016/11/7-3.jpg" sizes="(max-width: 700px) 100vw, 700px" srcset="https://nhakhoakim.com/wp-content/uploads/2016/11/7-3.jpg 700w, https://nhakhoakim.com/wp-content/uploads/2016/11/7-3-95x95.jpg 95w, https://nhakhoakim.com/wp-content/uploads/2016/11/7-3-50x50.jpg 50w, https://nhakhoakim.com/wp-content/uploads/2016/11/7-3-555x555.jpg 555w, https://nhakhoakim.com/wp-content/uploads/2016/11/7-3-45x45.jpg 45w" alt="" width="700" height="700" data-lazy-src="https://nhakhoakim.com/wp-content/uploads/2016/11/7-3.jpg" data-lazy-srcset="https://nhakhoakim.com/wp-content/uploads/2016/11/7-3.jpg 700w, https://nhakhoakim.com/wp-content/uploads/2016/11/7-3-95x95.jpg 95w, https://nhakhoakim.com/wp-content/uploads/2016/11/7-3-50x50.jpg 50w, https://nhakhoakim.com/wp-content/uploads/2016/11/7-3-555x555.jpg 555w, https://nhakhoakim.com/wp-content/uploads/2016/11/7-3-45x45.jpg 45w" data-lazy-sizes="(max-width: 700px) 100vw, 700px" /></p>
            <p style="text-align: center;"><em>Hotgirl, mẫu ảnh Di&ecirc;̣u Ngọc đ&atilde; tự tin khoe nụ cười &ldquo;chuẩn kh&ocirc;ng cần chỉnh&rdquo;, kh&ocirc;ng c&ograve;n mặc cảm răng xỉn m&agrave;u nhờ&nbsp;tẩy trắng răng tại Nha Khoa KIM</em></p>
            <p style="text-align: center;"><img class="alignnone size-full wp-image-8579     lazyloaded" src="https://nhakhoakim.com/wp-content/uploads/2016/11/3-5.jpg" sizes="(max-width: 700px) 100vw, 700px" srcset="https://nhakhoakim.com/wp-content/uploads/2016/11/3-5.jpg 700w, https://nhakhoakim.com/wp-content/uploads/2016/11/3-5-95x95.jpg 95w, https://nhakhoakim.com/wp-content/uploads/2016/11/3-5-50x50.jpg 50w, https://nhakhoakim.com/wp-content/uploads/2016/11/3-5-555x555.jpg 555w, https://nhakhoakim.com/wp-content/uploads/2016/11/3-5-45x45.jpg 45w" alt="" width="700" height="700" data-lazy-src="https://nhakhoakim.com/wp-content/uploads/2016/11/3-5.jpg" data-lazy-srcset="https://nhakhoakim.com/wp-content/uploads/2016/11/3-5.jpg 700w, https://nhakhoakim.com/wp-content/uploads/2016/11/3-5-95x95.jpg 95w, https://nhakhoakim.com/wp-content/uploads/2016/11/3-5-50x50.jpg 50w, https://nhakhoakim.com/wp-content/uploads/2016/11/3-5-555x555.jpg 555w, https://nhakhoakim.com/wp-content/uploads/2016/11/3-5-45x45.jpg 45w" data-lazy-sizes="(max-width: 700px) 100vw, 700px" /></p>
            <p style="text-align: center;"><em>Hot boy, người mẫu Nguyễn Tuấn An tin tưởng lựa chọn Nha Khoa KIM để&nbsp;tẩy trắng răng</em></p>
            <p style="text-align: center;"><img class="alignnone size-full wp-image-8577   lazyloading" src="https://nhakhoakim.com/wp-content/uploads/2016/11/1-4.jpg" sizes="(max-width: 700px) 100vw, 700px" srcset="https://nhakhoakim.com/wp-content/uploads/2016/11/1-4.jpg 700w, https://nhakhoakim.com/wp-content/uploads/2016/11/1-4-95x95.jpg 95w, https://nhakhoakim.com/wp-content/uploads/2016/11/1-4-50x50.jpg 50w, https://nhakhoakim.com/wp-content/uploads/2016/11/1-4-555x555.jpg 555w, https://nhakhoakim.com/wp-content/uploads/2016/11/1-4-45x45.jpg 45w" alt="" width="700" height="700" data-lazy-src="https://nhakhoakim.com/wp-content/uploads/2016/11/1-4.jpg" data-lazy-srcset="https://nhakhoakim.com/wp-content/uploads/2016/11/1-4.jpg 700w, https://nhakhoakim.com/wp-content/uploads/2016/11/1-4-95x95.jpg 95w, https://nhakhoakim.com/wp-content/uploads/2016/11/1-4-50x50.jpg 50w, https://nhakhoakim.com/wp-content/uploads/2016/11/1-4-555x555.jpg 555w, https://nhakhoakim.com/wp-content/uploads/2016/11/1-4-45x45.jpg 45w" data-lazy-sizes="(max-width: 700px) 100vw, 700px" /></p>
            <p style="text-align: center;"><em>Mẫu ảnh, hot girl Ngọc Yến xinh đẹp hơn sau khi&nbsp;tẩy trắng răng&nbsp;tại Nha Khoa KIM</em></p>
            <p style="text-align: center;"><img class="alignnone size-full wp-image-8578     lazyloaded" src="https://nhakhoakim.com/wp-content/uploads/2016/11/2-1.jpg" sizes="(max-width: 700px) 100vw, 700px" srcset="https://nhakhoakim.com/wp-content/uploads/2016/11/2-1.jpg 700w, https://nhakhoakim.com/wp-content/uploads/2016/11/2-1-95x95.jpg 95w, https://nhakhoakim.com/wp-content/uploads/2016/11/2-1-50x50.jpg 50w, https://nhakhoakim.com/wp-content/uploads/2016/11/2-1-555x555.jpg 555w, https://nhakhoakim.com/wp-content/uploads/2016/11/2-1-45x45.jpg 45w" alt="" width="700" height="700" data-lazy-src="https://nhakhoakim.com/wp-content/uploads/2016/11/2-1.jpg" data-lazy-srcset="https://nhakhoakim.com/wp-content/uploads/2016/11/2-1.jpg 700w, https://nhakhoakim.com/wp-content/uploads/2016/11/2-1-95x95.jpg 95w, https://nhakhoakim.com/wp-content/uploads/2016/11/2-1-50x50.jpg 50w, https://nhakhoakim.com/wp-content/uploads/2016/11/2-1-555x555.jpg 555w, https://nhakhoakim.com/wp-content/uploads/2016/11/2-1-45x45.jpg 45w" data-lazy-sizes="(max-width: 700px) 100vw, 700px" /></p>
            <p style="text-align: center;"><em>Người mẫu, diễn Vi&ecirc;n L&ecirc; Nhật Nam lịch l&atilde;m, cuốn h&uacute;t hơn v&agrave; tự tin mọi l&uacute;c mọi nơi nhờ h&agrave;m răng trắng s&aacute;ng</em></p>
        </div>
    @endif
	<!-- end Feedback --> 

		<!-- end liên hệ -->
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

</div>
<!-- end footer -->
	
</body>
</html>
<!-- 
font-family: 'Italianno', cursive;
font-family: 'Open Sans', sans-serif; 
-->