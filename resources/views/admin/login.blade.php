<!DOCTYPE html>
<html class="login">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>AdminLTE 2 | Log in</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="/assets/admin/bower_components/bootstrap/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="/assets/admin/bower_components/font-awesome/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="/assets/admin/bower_components/Ionicons/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="/assets/admin/dist/css/AdminLTE.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="/assets/admin/plugins/iCheck/square/blue.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Google Font -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition login">
 
<div class="login-box">
    <div class="login-logo">
        <a href="/"><b>Dental Gold</b></a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body" style="background: rgba(230, 230, 230,0.7);border-radius: 25px;" >
        
        <form action="{!! url('/loginAdmin') !!}" method="Post">
            {{ csrf_field() }}
            <div class="form-group has-feedback {{ $errors->has('phone') ? ' has-error' : '' }}">
                <input type="text" class="form-control" placeholder="Phone" name="phone" value="{{ old('phone') }}"
                       required autofocus>
                <span class="glyphicon glyphicon-phone form-control-feedback"></span>
                @if ($errors->has('phone'))
                    <span class="help-block">
                                        <strong>{{ $errors->first('phone') }}</strong>
                                    </span>
                @endif
            </div>
            <div class="form-group has-feedback">
                <input type="password" class="form-control" placeholder="Password" name="password" required style="background-color: #fff;">
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                @if ($errors->has('password'))
                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                @endif
            </div>
            @if (\Session::has('fail'))
                <span class="help-block has-error" style="color: #dd4b39">
                       <strong>{!! \Session::get('fail') !!}</strong>
                </span>
            @endif
            <div class="row">
                <!-- /.col -->
                <div class="col-xs-12"><button type="submit" class="btn btn-primary btn-block">Đăng Nhập</button></div>
                <!-- /.col -->
            </div>
        </form>
        <!-- /.social-auth-links -->
        <a href="#">Tôi không nhớ mật khẩu</a><br>
        <!-- <a href="register.html" class="text-center">Register a new membership</a> -->
    </div>
    <!-- /.login-box-body -->
</div>
<!-- /.login-box -->
 <link rel="stylesheet" href="/assets/user/css/mycss.css">
<!-- jQuery 3 -->
<script src="/assets/admin/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="/assets/admin/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="/assets/admin/plugins/iCheck/icheck.min.js"></script>
<script>
    $(function () {
        $('input').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%' /* optional */
        });
    });
</script>
</body>
</html>
