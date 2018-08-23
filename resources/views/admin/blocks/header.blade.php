<header class="main-header">
    <!-- Logo -->
    <a href="/admin/dashboard" class="logo" style="background-color: white">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><img src="/assets/images/Logo/logo.png" alt="" class="img-responsive" style="width: 100%;max-height: 50px;padding-top:5px; "></span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg">
        <img src="/assets/images/Logo/word.png" alt="" class="img-responsive" style="width: 100%;max-height: 100px;padding-top:10px; ">
        </span>
  <!--        <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <span class="hidden-xs">{{Session::get('currentAdmin')->belongToStaff()->first()->name}}</span>
                </a>
                <ul class="dropdown-menu">
                    <li class="user-header">
                        <p>{{ Session::get('currentAdmin')->belongToStaff()->first()->name}}</p>
                        <div>  <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                                    <img src="{{Session::get('currentAdmin')->belongToStaff()->first()->avatar}}" class="centerThing img-responsive img-fruid circleBorder" style="max-width: 100px;max-height: 100px;" >

                                </a></div>
                    </li>
                    <li class="user-footer">
                        <div class="pull-left">
                            <a href="profile-staff" class="btn btn-default btn-flat">Trang cá nhân</a>
                        </div>
                        <div class="pull-right">
                            <a href="{!! route('admin.logout') !!}" class="btn btn-default btn-flat">Đăng xuất</a>
                        </div>
                    </li>
                </ul>
            </li> -->
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    @include('admin.blocks.nav')
</header>