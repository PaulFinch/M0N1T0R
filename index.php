<?PHP
require_once('head.php');
?>

<aside class="main-sidebar">
  <section class="sidebar">
    <ul class="sidebar-menu" data-widget="tree">
      <li class="header">MAIN NAVIGATION</li>
      <?PHP
      foreach ($Menu as $Manu_item => $Menu_config) {
        $active = '';
        if (strtolower($Manu_item) == $target) { $active = 'active'; }
        echo "<li class='".$active."'><a href='?target=".strtolower($Manu_item)."'><i class='fa ".$Menu_config[0]."'></i> <span>".$Manu_item."</span>";
        echo "<span class='pull-right-container'>";
        if ($Menu_config[2] != 0) { echo "<small class='label pull-right bg-red'>".$Menu_config[2]."</small>"; }
        if ($Menu_config[1] != 0) { echo "<small class='label pull-right bg-yellow'>".$Menu_config[1]."</small>"; }
        echo "</span>";
        echo "</a></li>";
      }
      ?>
      <li><a href="security.php?action=logout"><i class="fa fa-user-times"></i><span>LOGOUT</span></a></li>
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
				$target_file = 'Panels/'.$target.'.php';
				if (is_file($target_file)) { require_once($target_file); }
				?>

			</div>
		</div>
	</section>
</div>

<?PHP
require_once('tail.php');
?>