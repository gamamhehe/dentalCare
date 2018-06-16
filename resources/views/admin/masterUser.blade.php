<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>
        @yield('title')
    </title>
    <script>
        var baseUrl = '{{ url("/") }}';
    </script>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <script type="text/javascript" src="/assets/user/bootstrap/bootstrap.js"></script>
    <script src="/assets/user/js/jquery-3.2.1.js"></script>
    <script src="/assets/user/js/jquery.easing.1.3.js"></script>
    <link rel="stylesheet" href="/assets/user/bootstrap/font-awesome.css">
    <link rel="stylesheet" href="/assets/user/css/mycss.css">
    <link rel="stylesheet" href="/assets/user/js/jquery.fancybox.css" />
    <script src="/assets/user/js/jquery.fancybox.js"></script>

    <script type="text/javascript" src="/assets/user/js/myjs.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Italianno|Open+Sans:300,400,600,700,800&amp;subset=vietnamese" rel="stylesheet">
    <link rel="stylesheet" href="/assets/user/bootstrap/bootstrap.css">
    <!-- <link rel="stylesheet" href="http://gsgd.co.uk/sandbox/jquery/easing/jquery.easing.1.3.js"> -->
    <link rel="stylesheet" href="/assets/user/bootstrap/font-awesome.css">
    <link rel="stylesheet" href="/assets/user/css/mycss.css">
    <!-- Google Font -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    @yield('css')
</head>
<body class="hold-transition skin-blue sidebar-mini">
@include('admin.blocks.headerWeb')

@yield('content')
@include('admin.blocks.footerWeb')
<script src="/assets/admin/bower_components/jquery/dist/jquery.min.js"></script>
<script src="/assets/admin/bower_components/jquery-ui/jquery-ui.min.js"></script>
<script>
    $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.7 -->
<script src="/assets/admin/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Morris.js charts -->
<script src="/assets/admin/bower_components/raphael/raphael.min.js"></script>
<!-- Sparkline -->
<script src="/assets/admin/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
<!-- jvectormap -->
<script src="/assets/admin/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="/assets/admin/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- jQuery Knob Chart -->
<script src="/assets/admin/bower_components/jquery-knob/dist/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="/assets/admin/bower_components/moment/min/moment.min.js"></script>
<script src="/assets/admin/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- datepicker -->
<script src="/assets/admin/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="/assets/admin/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<!-- Slimscroll -->
<script src="/assets/admin/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="/assets/admin/bower_components/fastclick/lib/fastclick.js"></script>
<script src="/assets/admin/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="/assets/admin/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="/assets/admin/dist/js/adminlte.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="/assets/admin/dist/js/pages/dashboard.js"></script>
{{--<script src="//cdn.ckeditor.com/4.5.7/standard/ckeditor.js"></script>--}}
<!-- AdminLTE for demo purposes -->
<script src="/assets/admin/input_file/fileinput.js"></script>
<script src="/vendor/laravel-filemanager/js/lfm.js"></script>
<script src="/assets/admin/dist/js/demo.js"></script>
<script src="{{URL::to('assets/admin/tinymce/js/tinymce/tinymce.min.js')}}"></script>
<script src="{{URL::to('assets/admin/main.js')}}"></script>
@yield('js')
</body>
</html>
