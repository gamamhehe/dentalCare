<<<<<<< HEAD
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
            {{--<li class="treeview">--}}
                {{--<a href="#">--}}
                    {{--<i class="fa fa-edit"></i> <span>Form</span>--}}
                    {{--<span class="pull-right-container">--}}
              {{--<i class="fa fa-angle-left pull-right"></i>--}}
            {{--</span>--}}
                {{--</a>--}}
                {{--<ul class="treeview-menu">--}}
                    {{--<li><a href="{!! route('list.form') !!}"><i class="fa fa-circle-o"></i> List Of Form</a></li>--}}
                    {{--<li><a href="{!! route('getAdd.form') !!}"><i class="fa fa-circle-o"></i> Add Form</a></li>--}}
                {{--</ul>--}}
            {{--</li>--}}
        </ul>
    </section>
=======
<aside class="main-sidebar" style="position: fixed">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{ Session::get('image') }}" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                {{ Session::get('nameUser') }}
                <br>
                @php
                    $gmailUser = Session::get('gmailAddress')
                @endphp
                @if($gmailUser != '')
                    <small>({{ Session::get('gmailAddress') }})</small>
                @else
                    <small>(Not Yet Login Gmail)</small>
                @endif
            </div>
        </div>
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">MAIN NAVIGATION</li>
            <li>
                <a href="{!! route('dashboard') !!}">
                    <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                    </span>
                </a>
            </li>
            <li>
                <a href="{!! route('login.gmail') !!}">
                    <i class="fa fa-envelope"></i> <span>Login Gmail</span>
                    </span>
                </a>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-edit"></i> <span>Form</span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{!! route('list.form') !!}"><i class="fa fa-circle-o"></i> List Of Form</a></li>
                    <li><a href="{!! route('getAdd.form') !!}"><i class="fa fa-circle-o"></i> Add Form</a></li>
                </ul>
        </ul>
    </section>
>>>>>>> 6647e7f68513f34b86ec6c59d3a99f618da1b2de
</aside>