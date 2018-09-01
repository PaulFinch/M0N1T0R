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

$Menu_Dashboard = array("fa-dashboard", $server->warnings['dashboard'], $server->alarms['dashboard']);
$Menu_Services = array("fa-reorder", $server->warnings['services'], $server->alarms['services']);
$Menu_Processes = array("fa-reorder", $server->warnings['processes'], $server->alarms['processes']);
$Menu_Netstat = array("fa-reorder", $server->warnings['netstat'], $server->alarms['netstat']);

$Menu = array(
  "DASHBOARD" => $Menu_Dashboard,
  "SERVICES" => $Menu_Services,
  "PROCESSES" => $Menu_Processes,
  "NETSTAT" => $Menu_Netstat
);
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
  <link rel="stylesheet" href="AdminLTE/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="AdminLTE/bower_components/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="AdminLTE/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
  <link rel="stylesheet" href="AdminLTE/dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="AdminLTE/dist/css/skins/_all-skins.min.css">
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
                  if ($alarm > 0) { echo "<li><a href='?target=".$key."'><i class='fa fa-warning text-red'></i> ".$alarm." errors : ".strtoupper($key)."</a></li>"; }
                }
                foreach ($server->warnings as $key => $warning) {
                  if ($warning > 0) { echo "<li><a href='?target=".$key."'><i class='fa fa-warning text-yellow'></i> ".$warning." errors : ".strtoupper($key)."</a></li>"; }
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