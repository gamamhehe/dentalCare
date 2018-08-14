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
    <link rel="shortcut icon" type="image/png" href="/assets/images/icon/fap16.png"/>
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="/assets/admin/bower_components/bootstrap/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <!-- <link rel="stylesheet" href="/assets/admin/bower_components/font-awesome/css/font-awesome.min.css"> -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css"
          integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
    <!-- Ionicons -->
    <link rel="stylesheet" href="/assets/admin/bower_components/Ionicons/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="/assets/admin/dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="/assets/admin/dist/css/skins/_all-skins.min.css">
    <!-- Morris chart -->
    <!-- jvectormap -->
    <link rel="stylesheet" href="/assets/admin/bower_components/jvectormap/jquery-jvectormap.css">
    <!-- Date Picker -->
    <link rel="stylesheet"
          href="/assets/admin/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="/assets/admin/bower_components/bootstrap-daterangepicker/daterangepicker.css">
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="/assets/admin/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
    <link rel="stylesheet" href="/assets/admin/app_css_custom.css">
    <link rel="stylesheet" href="/assets/admin/input_file/fileinput.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link href="/assets/user/datatable/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!-- Google Font -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    @yield('css')
</head>
<body class="hold-transition skin-blue sidebar-mini">
<input type="hidden" value="{{Session::get('currentAdmin')->belongToStaff()->first()->id}}" id="staff_id">
<div class="wrapper">
    @include('admin.blocks.header')
    @include('admin.blocks.sidebar')
    @include('admin.blocks.footer')
    @yield('content')
</div>
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

<script src="https://js.pusher.com/4.1/pusher.min.js"></script>
<script>

    // Enable pusher logging - don't include this in production

    var pusher = new Pusher('e3c057cd172dfd888756', {
        cluster: 'ap1',
        encrypted: true
    });

    var channel = pusher.subscribe('receivePatient');
    channel.bind('ReceivePatient', function (dataPush) {
        var staff_id = $('#staff_id').val();
        if (dataPush.staff_id == staff_id) {
            // viet code trong nay
            var num = $('#notiNumber').text();
            if (dataPush.pushStatus == 0) {
                $('#notiNumber').html(Number(num) + 1);
                document.getElementById("notiNumber").style.visibility = "visible";
                $.ajax({
                    url: '/admin/change-session', //this is your uri
                    type: 'GET', //this is your method

                    dataType: 'json',
                    success: function (data) {
                    },
                    error: function (data) {
                    }
                });
            }
            if (dataPush.pushStatus == 1) {
                $('#notiNumber').html(Number(num) - 1);
                var num2 = $('#notiNumber').text();
                if (Number(num2) == 0) {
                    document.getElementById("notiNumber").style.visibility = "hidden";
                }
                $.ajax({
                    url: '/admin/change-session', //this is your uri
                    type: 'GET', //this is your method
                    dataType: 'json',
                    success: function (data) {
                        window.location.href = "/admin/appointment-detail/" + dataPush.id;
                    },
                    error: function (data) {
                        window.location.href = "/admin/appointment-detail/" + dataPush.id;
                    }
                });
            }
        }
    });
</script>
@yield('js')
</body>
</html>
