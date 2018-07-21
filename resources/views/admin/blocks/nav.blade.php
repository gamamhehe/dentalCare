<nav class="navbar navbar-static-top">
    <!-- Sidebar toggle button-->
    <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
    </a>

    <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
            <!-- Messages: style can be found in dropdown.less-->

            <!-- User Account: style can be found in dropdown.less -->
            <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <span class="hidden-xs">{{Session::get('currentAdmin')->belongToStaff()->first()->name}}</span>
                </a>
                <ul class="dropdown-menu">
                    <!-- User image -->
                    <li class="user-header">

                        <p>
                            {{ Session::get('currentAdmin')->belongToStaff()->first()->name}}
                        </p>
                    </li>
                    <!-- Menu Body -->
                    {{--<li class="user-body">--}}
                        {{--<div class="row">--}}
                            {{--<div class="col-xs-4 text-center">--}}
                                {{--<a href="#">Followers</a>--}}
                            {{--</div>--}}
                            {{--<div class="col-xs-4 text-center">--}}
                                {{--<a href="#">Sales</a>--}}
                            {{--</div>--}}
                            {{--<div class="col-xs-4 text-center">--}}
                                {{--<a href="#">Friends</a>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<!-- /.row -->--}}
                    {{--</li>--}}
                    <!-- Menu Footer-->
                    <li class="user-footer">
                        <div class="pull-left">
                            <a href="profile-staff" class="btn btn-default btn-flat">Trang cá nhân</a>
                        </div>
                        <div class="pull-right">
                            <a href="{!! route('admin.logout') !!}" class="btn btn-default btn-flat">Đăng xuất</a>
                        </div>
                    </li>
                </ul>
            </li>
            <!-- Control Sidebar Toggle Button -->
        </ul>
    </div>
</nav>