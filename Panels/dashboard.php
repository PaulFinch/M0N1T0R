<h2 class="page-header">Load</h2>
<div class="row">
  <div class="col-md-3 col-sm-6 col-xs-12">
    <div class="info-box bg-aqua">
      <span class="info-box-icon"><i class="fa fa-gears"></i></span>
      <div class="info-box-content">
        <?PHP
          echo "<span class='info-box-text'>CPU</span>";
          echo "<span class='info-box-number'>".$server->top_cpu_pct."%</span>";
          echo "<div class='progress'>";
          echo "<div class='progress-bar progress-bar-striped' style='width: ".$server->top_cpu_pct."%'></div>";
          echo "</div>";
          echo "<span class='progress-description'>".$server->top_load[0]." - ".$server->top_load[1]." - ".$server->top_load[2]."</span>";
        ?>
      </div>
    </div>
  </div>
  <div class="col-md-3 col-sm-6 col-xs-12">
    <div class="info-box bg-yellow">
      <span class="info-box-icon"><i class="fa fa-server"></i></span>
      <div class="info-box-content">
        <?PHP
          echo "<span class='info-box-text'>MEMORY</span>";
          echo "<span class='info-box-number'>".$server->top_mem_pct."%</span>";
          echo "<div class='progress'>";
          echo "<div class='progress-bar progress-bar-primary progress-bar-striped' role='progressbar' aria-valuenow='40' aria-valuemin='0' aria-valuemax='100' style='width: ".$server->top_mem_pct."%'></div>";
          echo "</div>";
          echo "<span class='progress-description'>Free: ".formatSize(($server->top_mem[0] - $server->top_mem[2])*1024)."</span>";
        ?>
      </div>
    </div>
  </div>
  <div class="col-md-3 col-sm-6 col-xs-12">
    <div class="info-box bg-yellow">
      <span class="info-box-icon"><i class="fa fa-server"></i></span>
      <div class="info-box-content">
        <?PHP
          echo "<span class='info-box-text'>SWAP</span>";
          echo "<span class='info-box-number'>".$server->top_swap_pct."%</span>";
          echo "<div class='progress'>";
          echo "<div class='progress-bar progress-bar-primary progress-bar-striped' role='progressbar' aria-valuenow='40' aria-valuemin='0' aria-valuemax='100' style='width: ".$server->top_swap_pct."%'></div>";
          echo "</div>";
          echo "<span class='progress-description'>Free: ".formatSize(($server->top_swap[0] - $server->top_swap[2]) * 1024)."</span>";
        ?>
      </div>
    </div>
  </div>
  <div class="col-md-3 col-sm-6 col-xs-12">
    <div class="info-box bg-red">
      <span class="info-box-icon"><i class="fa fa-cube"></i></span>
      <div class="info-box-content">
        <?PHP
          echo "<span class='info-box-text'>PROCESSES</span>";
          echo "<span class='info-box-number'>".$server->top_tasks[0]."</span>";
          echo "<span class='progress-description'>".$server->top_tasks[1]." running, ".$server->top_tasks[2]." sleeping, ".$server->top_tasks[3]." stopped, ".$server->top_tasks[4]." zombie</span>";
        ?>
      </div>
    </div>
  </div>
  <div class="col-md-3 col-sm-6 col-xs-12">
    <div class="info-box bg-purple">
      <span class="info-box-icon"><i class="fa fa-user"></i></span>
      <div class="info-box-content">
        <?PHP
          echo "<span class='info-box-text'>CONNECTED USERS</span>";
          echo "<span class='info-box-number'>".$server->top_users."</span>";
        ?>
      </div>
    </div>
  </div>
  <div class="col-md-3 col-sm-6 col-xs-12">
    <div class="info-box bg-purple">
      <span class="info-box-icon"><i class="fa fa-clock-o"></i></span>
      <div class="info-box-content">
        <?PHP
          echo "<span class='info-box-text'>UPTIME</span>";
          echo "<span class='info-box-number'>".$server->uptime[0]." Days</span>";
          echo "<span class='progress-description'>".$server->uptime[1]." hours, ".$server->uptime[2]." minutes, ".$server->uptime[3]." seconds</span>";
        ?>
      </div>
    </div>
  </div>
</div>

<?PHP
  echo "<h2 class='page-header'>Storage</h2>";
  echo "<div class='row'>";
  foreach ($server->partitions as $partition) {
    echo "<div class='col-md-3 col-sm-6 col-xs-12'>";
    echo "<div class='info-box bg-green'>";
    echo "<span class='info-box-icon'><i class='fa fa-database'></i></span>";
    echo "<div class='info-box-content'>";
    echo "<span class='info-box-text'>".$partition[5]."</span>";
    echo "<span class='info-box-number'>".$partition[4]."%</span>";
    echo "<div class='progress'>";
    echo "<div class='progress-bar' style='width: ".$partition[4]."%'></div>";
    echo "</div>";
    echo "<span class='progress-description'>Free: ".(formatSize($partition[3] * 1024))."</span>";
    echo "</div>";
    echo "</div>";
    echo "</div>";
  }
  echo "</div>";

  if (is_executable("/usr/bin/hddtemp") || is_executable("/usr/bin/sensors")) { 
    echo "<h2 class='page-header'>Sensors</h2>";
    echo "<div class='row'>";
    foreach ($server->temperatures as $temperature) {
      echo "<div class='col-md-3 col-sm-6 col-xs-12'>";
      echo "<div class='info-box bg-teal'>";
      echo "<span class='info-box-icon'><i class='fa fa-thermometer-empty'></i></span>";
      echo "<div class='info-box-content'>";
      echo "<span class='info-box-text'>".$temperature[0]."</span>";
      echo "<span class='info-box-number'>".$temperature[1]."°</span>";
      echo "</div>";
      echo "</div>";
      echo "</div>";
    }
    echo "</div>";
    echo "<div class='row'>";
    foreach ($server->disks_temperatures as $key => $temperature) {
      echo "<div class='col-md-3 col-sm-6 col-xs-12'>";
      echo "<div class='info-box bg-gray'>";
      echo "<span class='info-box-icon'><i class='fa fa-thermometer-empty'></i></span>";
      echo "<div class='info-box-content'>";
      echo "<span class='info-box-text'>/dev/".$key."</span>";
      echo "<span class='info-box-number'>".$temperature."°</span>";
      echo "</div>";
      echo "</div>";
      echo "</div>";
    }
    echo "</div>";
  }
?>