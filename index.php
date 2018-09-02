<?PHP
  require_once('Lib/Classes/Servers.class.php');
  require_once('Lib/Functions/Helpers.php');
  session_start();
  setlocale (LC_ALL, 'en_US.utf8','eng');

  if (!isset($_SESSION['user'])) {
    header ("location: login.php");
    exit();
  }

  if (isset($_GET["target"])) { $target = $_GET["target"]; } else { $target = "dashboard"; }

  if (!isset($_SESSION["server"])) { $_SESSION["server"] = new Server(); }
  if ((isset($_GET["refresh"])) && ($_GET["refresh"] == "true")) { $_SESSION["server"]->refresh_all(); }
  $server = $_SESSION["server"];
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <?PHP
    echo "<title>".strtoupper($server->host)." M0N1T0R</title>";
  ?>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="Lib/AdminLTE/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="Lib/AdminLTE/bower_components/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="Lib/AdminLTE/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
  <link rel="stylesheet" href="Lib/AdminLTE/dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="Lib/AdminLTE/dist/css/skins/_all-skins.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>

<body class="hold-transition skin-blue sidebar-mini">
  <div class="wrapper">

    <header class="main-header">
      <a href="index.php" class="logo">
        <?PHP
          echo "<span class='logo-mini'><b>".strtoupper(substr($server->host, 0, 1))."</b></span>";
          echo "<span class='logo-lg'><b>".strtoupper(substr($server->host, 0, 1))."</b>".strtoupper(substr($server->host, 1))."</span>";
        ?>
      </a>
      <nav class="navbar navbar-static-top" role="navigation">
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
          <span class="sr-only">Toggle navigation</span>
        </a>
        <div class="navbar-custom-menu">
          <ul class="nav navbar-nav">
            <?PHP
              $notifications = array_sum($server->alarms) + array_sum($server->warnings);

              echo "<li class='dropdown notifications-menu'>";
              echo "<a href='#'' class='dropdown-toggle' data-toggle='dropdown'>";
              echo "<i class='fa fa-bell-o'></i>";
              if ($notifications > 0) { echo "<span class='label label-warning'>".$notifications."</span>"; }
              echo "</a>";
              echo "<ul class='dropdown-menu'>";

              echo "<li class='header'>You have ".$notifications." notification(s)</li>";
              echo "<li>";
              echo "<ul class='menu'>";
              foreach ($server->alarms as $key => $alarm) {
                if ($alarm > 0) { echo "<li><a href='?target=".$key."'><i class='fa fa-warning text-red'></i> ".$alarm." error(s) : ".strtoupper($key)."</a></li>"; }
              }
              foreach ($server->warnings as $key => $warning) {
                if ($warning > 0) { echo "<li><a href='?target=".$key."'><i class='fa fa-warning text-yellow'></i> ".$warning." warning(s) : ".strtoupper($key)."</a></li>"; }
              }
              echo "</ul>";
              echo "</li>";
            ?>
          </ul>
          </li>
          <li>
            <?PHP
              echo "<a href='?target=".$target."&refresh=true'><i class='fa fa-refresh'></i></a>";
            ?>
          </li>
          <li>
            <a href="#" data-toggle="control-sidebar"><i class="fa fa-info-circle"></i></a>
          </li>
          </ul>
        </div>
      </nav>
    </header>

    <aside class="main-sidebar">
      <section class="sidebar">
        <ul class="sidebar-menu" data-widget="tree">
          <li class="header">MAIN NAVIGATION</li>
          <?PHP
            $target_file = '';
            $files = glob('Panels/*.panel.php');
            sort($files);
            foreach($files as $file) {
              $Menu_item = substr(basename($file),0,-10);
              if (strtolower($Menu_item) == $target) { 
                $active = 'active';
                $target_file = $file;
              } else { $active = ''; }

              echo "<li class='".$active."'><a href='?target=".$Menu_item."'><i class='fa fa-reorder'></i> <span>".strtoupper($Menu_item)."</span>";
              echo "<span class='pull-right-container'>";
              if ($server->alarms[$Menu_item] != 0) { echo "<small class='label pull-right bg-red'>".$server->alarms[$Menu_item]."</small>"; }
              if ($server->warnings[$Menu_item] != 0) { echo "<small class='label pull-right bg-yellow'>".$server->warnings[$Menu_item]."</small>"; }
              echo "</span>";
              echo "</a></li>";
            }
          ?>
          <li><a href="login.php?action=logout"><i class="fa fa-user-times"></i><span>LOGOUT</span></a></li>
        </ul>
      </section>
    </aside>

    <div class="content-wrapper">
      <section class="content-header">
        <?PHP
          echo "<h1>".strtoupper($target)."</h1>";
        ?>
      </section>
      <section class="content">
        <div class="row justify-content-md-center">
          <div class="col-md-12">
            <?PHP
              if (is_file($target_file)) { require_once($target_file); }
            ?>
          </div>
        </div>
      </section>
    </div>

    <footer class="main-footer">
      <div class="pull-right">AdminLTE 2.4.5</div>
      M0N1T0R v1.1
    </footer>

    <aside class="control-sidebar control-sidebar-dark">
      <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
        <li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-info-circle"></i></a></li>
      </ul>
      <div class="tab-content">
        <div class="tab-pane active" id="control-sidebar-home-tab">
          <h3 class="control-sidebar-heading"><b>System Information</b></h3>
          <?PHP
            echo "<div class='form-group'><label class='control-sidebar-subheading'><b>Host:</b> ".$server->host."</label></div>";
            echo "<div class='form-group'><label class='control-sidebar-subheading'><b>IP:</b> ".$server->ip."</label></div>";
            echo "<div class='form-group'><label class='control-sidebar-subheading'><b>Server:</b> ".$server->software."</label></div>";
            echo "<div class='form-group'><label class='control-sidebar-subheading'><b>Kernel:</b> ".$server->kernel."</label></div>";
            echo "<div class='form-group'><label class='control-sidebar-subheading'><b>PHP:</b> ".$server->php."</label></div>";
          ?>
        </div>
      </div>
    </aside>
    <div class="control-sidebar-bg"></div>
  </div>

  <script src="Lib/AdminLTE/bower_components/jquery/dist/jquery.min.js"></script>
  <script src="Lib/AdminLTE/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
  <script src="Lib/AdminLTE/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
  <script src="Lib/AdminLTE/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
  <script src="Lib/AdminLTE/dist/js/adminlte.min.js"></script>
  <script>
    $(function () {
      $('#Table').DataTable({
        'paging': true,
        'lengthChange': true,
        'searching': true,
        'ordering': true,
        'info': true,
        'autoWidth': false
      })
    })
  </script>
</body>

</html>