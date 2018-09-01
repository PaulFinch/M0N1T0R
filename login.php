<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>M0N1T0R | Log in</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="AdminLTE/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="AdminLTE/bower_components/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="AdminLTE/dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>

<body class="hold-transition login-page">
  <div class="login-box">
    <div class="login-logo">
      <b>M0N1T0R</b>
    </div>
    <div class="login-box-body">
      <p class="login-box-msg">Sign in to start your session</p>
      <form action="security.php?action=login" method="post">
        <div class="form-group has-feedback">
          <input type="login" id="chklogin" name="chklogin" class="form-control" placeholder="Login">
          <span class="fa fa-user form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
          <input type="password" id="chkpass" name="chkpass" class="form-control" placeholder="Password">
          <span class="fa fa-key form-control-feedback"></span>
        </div>
        <div class="row">
          <div class="col-xs-4">
            <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
          </div>
        </div>
      </form>
    </div>
  </div>
  <script src="AdminLTE/bower_components/jquery/dist/jquery.min.js"></script>
  <script src="AdminLTE/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
</body>

</html>