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
            <li>
                <a href="{!! route('admin.dashboard') !!}">
                    <i class="fa fa-dashboard"></i> <span>Trang chủ</span>
                    </span>
                </a>
            </li>

            <li class="treeview">
                <a href="javascript:void(0);"><i class="fa fa-list-alt"></i> <span>Lịch hẹn</span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>
                <ul class="treeview-menu">
                    <li><a href="{{ route('admin.AppointmentPatient.index')}}">Tạo Lịch Hẹn</a></li>
                    <li><a href="{{ route('admin.listAppointment.dentist')}}">Lịch hẹn của tôi !</a></li>
                </ul>
            </li>

            <li class="treeview">
                <a href="javascript:void(0);"><i class="fa fa-list-alt"></i> <span>Xin nghỉ</span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>
                <ul class="treeview-menu">
                    <li><a href="{{ route('create.Absent')}}">Đơn xin nghỉ</a></li>
                    <li><a href="{{ route('admin.Manage.Absent')}}">Quản lí bởi ADmin nghen</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="javascript:void(0);"><i class="fa fa-list-alt"></i> <span>Quản lí lịch sử bệnh án</span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>
                <ul class="treeview-menu">
                    <li><a href="{{ route('admin.treatmentHistory')}}">Danh sách lịch sử bệnh án</a></li>
                    {{--<li><a href="{{ route('admin.create.news')}}">Khởi tạo bảng tin</a></li>--}}
                    <!--  <li><a href="/ks107">Manage Question</a></li>
                     <li><a href="/feedback">Manage Feedback</a></li> -->
                </ul>
            </li>
            <li class="treeview">
                <a href="javascript:void(0);"><i class="fa fa-list-alt"></i> <span>Quản lí chi trả</span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>
                <ul class="treeview-menu">
                    <li><a href="{{ route('admin.payment')}}">Danh sách chi trả</a></li>
                    {{--<li><a href="{{ route('admin.create.news')}}">Khởi tạo bảng tin</a></li>--}}
                    <!--  <li><a href="/ks107">Manage Question</a></li>
                     <li><a href="/feedback">Manage Feedback</a></li> -->
                </ul>
            </li>
             <li class="treeview">
                <a href="javascript:void(0);"><i class="fa fa-list-alt"></i> <span>Quản lí Tin Tức</span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>
                <ul class="treeview-menu">
                            <li><a href="{{ route('admin.list.news')}}">Danh sách tin tức</a></li>
                            <li><a href="{{ route('admin.create.news')}}">Khởi tạo bảng tin</a></li>
                           <!--  <li><a href="/ks107">Manage Question</a></li>
                            <li><a href="/feedback">Manage Feedback</a></li> -->
                </ul>
            </li>
              <li class="treeview">
                <a href="javascript:void(0);"><i class="fa fa-list-alt"></i> <span>Quản lí Bệnh Nguy Hiểm</span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>
                <ul class="treeview-menu">
                            <li><a href="{{ route('admin.list.anamnesis')}}">Danh sách bệnh tiền sử</a></li>
                            <li><a href="{{ route('admin.create.anamnesis')}}">Khởi tạo bệnh tiền sử</a></li>
                           <!--  <li><a href="/ks107">Manage Question</a></li>
                            <li><a href="/feedback">Manage Feedback</a></li> -->
                </ul>
            </li>
            <li class="treeview">
                <a href="javascript:void(0);"><i class="fa fa-list-alt"></i> <span>Quản lí Sự kiện</span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>
                <ul class="treeview-menu">
                    <li><a href="{{ route('admin.list.event')}}">Danh sách Sự kiện</a></li>
                    <li><a href="{{ route('admin.create.event')}}">Khởi tạo sự kiện</a></li>

                </ul>
            </li>
            <li class="treeview">
                <a href="javascript:void(0);"><i class="fa fa-list-alt"></i> <span>Quản lí Đánh giá </span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>
                <ul class="treeview-menu">
                    <li><a href="{{ route('admin.list.feedback')}}">Danh sách Đánh giá</a></li>
                    <!-- <li><a href="#"></a></li> -->

                </ul>
            </li>
            <li class="treeview">
                <a href="javascript:void(0);"><i class="fa fa-list-alt"></i> <span>Quản lí Tủ Thuốc </span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>
                <ul class="treeview-menu">
                    <li><a href="{{ route('admin.list.medicines')}}">Danh sách Đánh giá</a></li>
                    <li><a href="{{ route('admin.create.medicines')}}">Khởi tạo thuốc</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="javascript:void(0);"><i class="fa fa-list-alt"></i> <span>Quản lí Liệu trình </span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>
                <ul class="treeview-menu">
                    <li><a href="{{ route('admin.list.treatment')}}">Danh sách Liệu trình</a></li>
                    <li><a href="{{ route('admin.create.treatment')}}">Khởi tạo Liệu trình</a></li>
                </ul>
            </li>

 
        </ul>
    </section>
</aside>