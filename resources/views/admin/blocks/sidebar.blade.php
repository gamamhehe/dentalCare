<aside class="main-sidebar" style="">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
       
        <ul class="sidebar-menu" data-widget="tree">
            <li class="sidebar">
                <a href="{{ route('admin.AppointmentPatient.index')}}"><i
                            class="fa fa-list-alt"></i><span>Bệnh nhân</span></a>
            </li>
            <li class="treeview" class="sidebar sideHover">
                <a href="javascript:void(0);"><i class="fa fa-list-alt"></i><span>Lịch hẹn </span>
                    @if(Session::get('currentAppointmentComming') != 0)
                        <span class="pull-right-container">
              <span class="label label-primary pull-right" style="margin-right: 20px"
                    id="notiNumber"> {{ Session::get('currentAppointmentComming') }}</span>
            </span>
                    @endif
                    @if(Session::get('currentAppointmentComming') == 0)
                        <span class="pull-right-container">
              <span class="label label-primary pull-right" style="margin-right: 20px;visibility: hidden"
                    id="notiNumber"> {{ Session::get('currentAppointmentComming') }}</span>
            </span>
                        @endif
                    <span
                            class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>
                <ul class="treeview-menu">
                    <li><a href="{{ route('admin.AppointmentPatientManual.create')}}">Tạo lịch hẹn</a></li>
                    <li><a href="{{ route('admin.listAppointment.dentist')}}">Danh sách lịch hẹn</a></li>
                    <li><a href="{{ route('admin.listAppointmentInDate.dentist')}}">Danh sách lịch hẹn trong ngày</a></li>
                </ul>
            </li>
            
            <li class="sidebar">
                <a href="{{ route('admin.absent')}}"><i class="fa fa-list-alt"></i><span>Nghỉ phép</span></a>
            </li>
            <li>
                <a href="{{ route('admin.treatmentHistory')}}"><i class="fa fa-list-alt"></i><span>Quản lí lịch sử bệnh án</span></a>
            </li>
            <li>
                <a href="{{ route('admin.Staff.list')}}"><i class="fa fa-list-alt"></i><span>Quản lí nhân sự</span></a>
            </li>
            @if(Session::get('roleAdmin') == 3 or Session::get('roleAdmin') == 1)
                <li>
                    <a href="{{ route('admin.payment')}}"><i class="fa fa-list-alt"></i><span>Quản lí chi trả</span></a>
                </li>
            @endif
            @if(Session::get('roleAdmin') == 3 or Session::get('roleAdmin') == 1)
                <li class="treeview">
                    <a href="javascript:void(0);"><i class="fa fa-list-alt"></i><span>Quản lí tin tức</span><span
                                class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>
                    <ul class="treeview-menu">
                        <li><a href="{{ route('admin.list.news')}}">Danh sách tin tức</a></li>
                        <li><a href="{{ route('admin.create.news')}}">Khởi tạo bảng tin</a></li>
                    </ul>
                </li>
            @endif
            <li class="treeview">
                <a href="javascript:void(0);"><i class="fa fa-list-alt"></i><span>Quản lí bệnh nguy hiểm</span><span
                            class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>
                <ul class="treeview-menu">
                    <li><a href="{{ route('admin.list.anamnesis')}}">Danh sách bệnh tiền sử</a></li>
                    <li><a href="{{ route('admin.create.anamnesis')}}">Khởi tạo bệnh tiền sử</a></li>
                </ul>
            </li>
            @if(Session::get('roleAdmin') == 3 or Session::get('roleAdmin') == 1)
                <li class="treeview">
                    <a href="javascript:void(0);"><i class="fa fa-list-alt"></i><span>Quản lí sự kiện</span><span
                                class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>
                    <ul class="treeview-menu">
                        <li><a href="{{ route('admin.list.event')}}">Danh sách sự kiện</a></li>
                        <li><a href="{{ route('admin.create.event')}}">Khởi tạo sự kiện</a></li>

                    </ul>
                </li>
            @endif
            <li class="treeview">
                <a href="javascript:void(0);"><i class="fa fa-list-alt"></i><span>Quản lí đánh giá </span><span
                            class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>
                <ul class="treeview-menu">
                    <li><a href="{{ route('admin.list.feedback')}}">Danh sách đánh giá</a></li>
                    <!-- <li><a href="#"></a></li> -->

                </ul>
            </li>
              
            @if(Session::get('roleAdmin') == 2 or Session::get('roleAdmin') == 1)
                <li class="treeview">
                    <a href="javascript:void(0);"><i class="fa fa-list-alt"></i><span>Quản lí tủ thuốc </span><span
                                class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>
                    <ul class="treeview-menu">
                        <li><a href="{{ route('admin.list.medicines')}}">Danh sách thuốc</a></li>
                        <li><a href="{{ route('admin.create.medicines')}}">Khởi tạo thuốc</a></li>
                    </ul>
                </li>
            @endif
            @if(Session::get('roleAdmin') == 2 or Session::get('roleAdmin') == 1)
                <li class="treeview">
                    <a href="javascript:void(0);"><i class="fa fa-list-alt"></i><span>Quản lí Liệu trình </span><span
                                class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>
                    <ul class="treeview-menu">
                        <li><a href="{{ route('admin.list.treatment')}}">Danh sách liệu trình</a></li>
                        <li><a href="{{ route('admin.create.treatment')}}">Khởi tạo liệu trình</a></li>
                    </ul>
                </li>
            @endif
            @if(Session::get('roleAdmin') == 1)
                <li class="sidebar">
                    <a href="{{ route('admin.sync.payment')}}"><i class="fa fa-list-alt"></i><span>Đồng bộ chi trả</span></a>
                </li>
            @endif
            
        </ul>
    </section>
</aside>
  <link rel="stylesheet" href="/assets/user/css/mycss.css">