@extends('admin.masterUser')
@section('content')
    <div class="top"><div class="top">
            <!-- start menu -->
            <nav class="navbar navbar-light navbar-fixed-top   bg-faded thanhmenu">
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
                                <a class="nav-link  " href="/doctorList">Chuyên Gia</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link  " href="#ourmenu">Event</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link  " href="#contact">dịch vụ</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link  " href="/banggia">bản giá</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link  " href="#contact">contact us</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link  " href="#contact">contact us</a>
                            </li>
                            <li class="nav-item dropdown ">
                                <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                                    <img src="assets/images/icon/user.jpg" class="user-image img-circle" alt="User Image" class="img-fluid img-responsive" style="max-height: 25px;">

                                </a>
                                <ul class="dropdown-menu"  style="position: absolute;right: 0;left: auto;background-color: whitesmoke">
                                    <!-- User image -->
                                    <li class="user-header" >
                                        <img src="assets/images/icon/user.jpg" class="img-circle" alt="User Image">

                                        <p>
                                            Alexander Pierce - Web Developer
                                            <small>Member since Nov. 2012</small>
                                        </p>
                                    </li>
                                    <!-- Menu Body -->

                                    <!-- Menu Footer-->
                                    <li class="user-footer">
                                        <div class="pull-left" style="padding-left: 1em;">
                                            <a href="#" class="btn btn-success btn-flat">Profile</a>
                                        </div>
                                        <div class="pull-right" style="padding-right: 1em;">
                                            <a href="#" class="btn btn-success btn-flat">Sign out</a>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item dropdown ">
                                <div class="dropdown">
                                    <button class="btn btn-default dropdown-toggle" type="button" id="menu1" data-toggle="dropdown">Tutorials
                                        <span class="caret"></span></button>
                                    <ul class="dropdown-menu" role="menu" aria-labelledby="menu1">
                                        <li role="presentation" class="dropdown-header">Dropdown header 1</li>
                                        <li role="presentation"><a role="menuitem" tabindex="-1" href="#">HTML</a></li>
                                        <li role="presentation"><a role="menuitem" tabindex="-1" href="#">CSS</a></li>
                                        <li role="presentation"><a role="menuitem" tabindex="-1" href="#">JavaScript</a></li>
                                        <li role="presentation" class="divider"></li>
                                        <li role="presentation" class="dropdown-header">Dropdown header 2</li>
                                        <li role="presentation"><a role="menuitem" tabindex="-1" href="#">About Us</a></li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            <!-- end menu -->

        </div></div>
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
                <div>Trồng implent với công nghệ <a href="#"> ...  </a></div>
            </div>
            <div class="col-sm-3 motmon">
                <img src="/assets/images/HomePage/rangsu.jpg" alt="" class="img-fluid img-responsive">
                <div class="tieude"><a href="">Làm răng sứ</a></div>
                <div>Răng sứ được nhập khẩu<a href="#"> ...  </a></div>
            </div>
            <div class="col-sm-3 motmon">
                <img src="/assets/images/HomePage/taytrangrag.jpg" alt="" class="img-fluid img-responsive">
                <div class="tieude"><a href="">Tẩy Trắng Răng</a></div>
                <div>Quy trình tẩy trắng<a href="#"> ... </a></div>
            </div>
            <div class="col-sm-3 motmon">
                <img src="/assets/images/HomePage/nienrang.jpg" alt="" class="img-fluid img-responsive">
                <div class="tieude"><a href="">Niền Răng</a></div>
                <div>Niền răng được phân loại<a href="#"> ... </a></div>
            </div>
        </div>
    </div>
@endsection
@section('js')

@endsection
