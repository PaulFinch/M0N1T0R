<?PHP
  session_start();
  setlocale (LC_ALL, 'en_US.utf8','eng');
  
  if ((isset($_GET["action"])) && ($_GET["action"]=='login')) {
    if (((isset($_POST['chklogin'])) && (isset($_POST['chkpass']))) && ((!empty($_POST['chklogin'])) && (!empty($_POST['chkpass'])))) {

      $cred_login = 'admin';
      $cred_pass = '$2y$10$JnEYR9QPPJYVqK4np2rW6eLzVe9933KFoS5aVCadHjqg3K3xHS2ui';

      if ((strcmp($_POST['chklogin'], $cred_login) == 0) && (password_verify($_POST['chkpass'], $cred_pass))) {
        $_SESSION['user'] = $cred_login;
        header ("location: index.php");
        exit();
      } else {
        $_SESSION = array(); 
        @session_write_close();
        @session_destroy ();
        header ("location: login.php");
        exit();
      }
    }
    else {
      $_SESSION = array(); 
      @session_write_close();
      @session_destroy();
      header ("location: login.php");
      exit();
    }
  }

  if ((isset($_GET["action"])) && ($_GET["action"]=='logout')) {
    $_SESSION = array(); 
    @session_write_close();
    @session_destroy();
    header ("location: login.php");
    exit();
  }
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>M0N1T0R | Log in</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="Lib/AdminLTE/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="Lib/AdminLTE/bower_components/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="Lib/AdminLTE/dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>

<body class="hold-transition login-page">
  <div class="login-box">
    <div class="login-logo">
      <b>M0N1T0R</b>
    </div>
    <div class="login-box-body">
      <p class="login-box-msg">Sign in to start your session</p>
      <form action="?action=login" method="post">
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
  <script src="Lib/AdminLTE/bower_components/jquery/dist/jquery.min.js"></script>
  <script src="Lib/AdminLTE/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
</body>

</html>