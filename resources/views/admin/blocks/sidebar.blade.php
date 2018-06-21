<aside class="main-sidebar" style="position: fixed">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left info">
                {{ Session::get('nameUser') }}
                <br>
                {{--@php--}}
                    {{--$gmailUser = Session::get('gmailAddress')--}}
                {{--@endphp--}}
                {{--@if($gmailUser != '')--}}
                    {{--<small>({{ Session::get('gmailAddress') }})</small>--}}
                {{--@else--}}
                    {{--<small>(Not Yet Login Gmail)</small>--}}
                {{--@endif--}}
            </div>
        </div>
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">MAIN NAVIGATION</li>
            <li>
                <a href="{!! route('admin.dashboard') !!}">
                    <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                    </span>
                </a>
            </li>
             <li class="treeview">
                <a href="javascript:void(0);"><i class="fa fa-list-alt"></i> <span>Quản lí Tin Tức</span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>
                <ul class="treeview-menu">
                            <li><a href="list-News">Danh sách tin tức</a></li>
                            <li><a href="create-News">Khởi tạo bảng tin</a></li>
                           <!--  <li><a href="/ks107">Manage Question</a></li>
                            <li><a href="/feedback">Manage Feedback</a></li> -->
                </ul>
            </li>
              <li class="treeview">
                <a href="javascript:void(0);"><i class="fa fa-list-alt"></i> <span>Quản lí Bệnh Nguy Hiểm</span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>
                <ul class="treeview-menu">
                            <li><a href="list-Anamnesis">Danh sách bệnh tiền sử</a></li>
                            <li><a href="create-Anamnesis">Khởi tạo bệnh tiền sử</a></li>
                           <!--  <li><a href="/ks107">Manage Question</a></li>
                            <li><a href="/feedback">Manage Feedback</a></li> -->
                </ul>
            </li>
            <li class="treeview">
                <a href="javascript:void(0);"><i class="fa fa-list-alt"></i> <span>Quản lí Sự kiện</span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>
                <ul class="treeview-menu">
                    <li><a href="#">Danh sách Sự kiện</a></li>
                    <li><a href="#">Khởi tạo sự kiện</a></li>

                </ul>
            </li>
            <li class="treeview">
                <a href="javascript:void(0);"><i class="fa fa-list-alt"></i> <span>Quản lí Đánh giá </span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>
                <ul class="treeview-menu">
                    <li><a href="/list-feedback">Danh sách Đánh giá</a></li>
                    <!-- <li><a href="#"></a></li> -->

                </ul>
            </li>
 
        </ul>
    </section>
</aside>