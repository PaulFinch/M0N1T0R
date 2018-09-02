<?PHP
  echo "<h2 class='page-header'>Load</h2>";
  echo "<div class='row'>";
    if ($server->top_cpu_pct > $server->alarm_thresholds['cpu']) { $bgcolor = 'bg-red'; } elseif ($server->top_cpu_pct > $server->warning_thresholds['cpu']) { $bgcolor = 'bg-yellow'; } else { $bgcolor = 'bg-green'; }
    echo "<div class='col-md-3 col-sm-6 col-xs-12'>";
      echo "<div class='info-box ".$bgcolor."'>";
        echo "<span class='info-box-icon'><i class='fa fa-gears'></i></span>";
        echo "<div class='info-box-content'>";
          echo "<span class='info-box-text'>CPU</span>";
          echo "<span class='info-box-number'>".$server->top_cpu_pct."%</span>";
          echo "<div class='progress'>";
          echo "<div class='progress-bar progress-bar-striped' style='width: ".$server->top_cpu_pct."%'></div>";
          echo "</div>";
          echo "<span class='progress-description'>".$server->top_load[0]." - ".$server->top_load[1]." - ".$server->top_load[2]."</span>";
         echo "</div>";
      echo "</div>";
    echo "</div>";

    $bgcolor = 'bg-gray';
    echo "<div class='col-md-3 col-sm-6 col-xs-12'>";
      echo "<div class='info-box ".$bgcolor."'>";
        echo "<span class='info-box-icon'><i class='fa fa-cube'></i></span>";
        echo "<div class='info-box-content'>";
          echo "<span class='info-box-text'>PROCESSES</span>";
          echo "<span class='info-box-number'>".$server->top_tasks[0]."</span>";
          echo "<span class='progress-description'>".$server->top_tasks[1]." running, ".$server->top_tasks[2]." sleeping, ".$server->top_tasks[3]." stopped, ".$server->top_tasks[4]." zombie</span>";
         echo "</div>";
      echo "</div>";
    echo "</div>";

    if ($server->top_mem_pct > $server->alarm_thresholds['mem']) { $bgcolor = 'bg-red'; } elseif ($server->top_mem_pct > $server->warning_thresholds['mem']) { $bgcolor = 'bg-yellow'; } else { $bgcolor = 'bg-green'; }
    echo "<div class='col-md-3 col-sm-6 col-xs-12'>";
      echo "<div class='info-box ".$bgcolor."'>";
        echo "<span class='info-box-icon'><i class='fa fa-server'></i></span>";
        echo "<div class='info-box-content'>";
          echo "<span class='info-box-text'>MEMORY</span>";
          echo "<span class='info-box-number'>".$server->top_mem_pct."%</span>";
          echo "<div class='progress'>";
          echo "<div class='progress-bar progress-bar-primary progress-bar-striped' role='progressbar' aria-valuenow='40' aria-valuemin='0' aria-valuemax='100' style='width: ".$server->top_mem_pct."%'></div>";
          echo "</div>";
          echo "<span class='progress-description'>Free: ".formatSize(($server->top_mem[0] - $server->top_mem[2])*1024)."</span>";
         echo "</div>";
      echo "</div>";
    echo "</div>";

    if ($server->top_swap_pct > $server->alarm_thresholds['swap']) { $bgcolor = 'bg-red'; } elseif ($server->top_swap_pct > $server->warning_thresholds['swap']) { $bgcolor = 'bg-yellow'; } else { $bgcolor = 'bg-green'; }
    echo "<div class='col-md-3 col-sm-6 col-xs-12'>";
      echo "<div class='info-box ".$bgcolor."'>";
        echo "<span class='info-box-icon'><i class='fa fa-server'></i></span>";
        echo "<div class='info-box-content'>";
          echo "<span class='info-box-text'>SWAP</span>";
          echo "<span class='info-box-number'>".$server->top_swap_pct."%</span>";
          echo "<div class='progress'>";
          echo "<div class='progress-bar progress-bar-primary progress-bar-striped' role='progressbar' aria-valuenow='40' aria-valuemin='0' aria-valuemax='100' style='width: ".$server->top_swap_pct."%'></div>";
          echo "</div>";
          echo "<span class='progress-description'>Free: ".formatSize(($server->top_swap[0] - $server->top_swap[2]) * 1024)."</span>";
         echo "</div>";
      echo "</div>";
    echo "</div>";

    $bgcolor = 'bg-gray';
    echo "<div class='col-md-3 col-sm-6 col-xs-12'>";
      echo "<div class='info-box ".$bgcolor."'>";
        echo "<span class='info-box-icon'><i class='fa fa-user'></i></span>";
        echo "<div class='info-box-content'>";
          echo "<span class='info-box-text'>CONNECTED USERS</span>";
          echo "<span class='info-box-number'>".$server->top_users."</span>";
         echo "</div>";
      echo "</div>";
    echo "</div>";

    $bgcolor = 'bg-gray';
    echo "<div class='col-md-3 col-sm-6 col-xs-12'>";
      echo "<div class='info-box ".$bgcolor."'>";
        echo "<span class='info-box-icon'><i class='fa fa-clock-o'></i></span>";
        echo "<div class='info-box-content'>";
          echo "<span class='info-box-text'>UPTIME</span>";
          echo "<span class='info-box-number'>".$server->uptime[0]." Days</span>";
          echo "<span class='progress-description'>".$server->uptime[1]." hours, ".$server->uptime[2]." minutes, ".$server->uptime[3]." seconds</span>";
         echo "</div>";
      echo "</div>";
    echo "</div>";
  echo "</div>";

  echo "<h2 class='page-header'>Storage</h2>";
  echo "<div class='row'>";
  foreach ($server->partitions as $partition) {
    if ($partition[4] > $server->alarm_thresholds['storage']) { $bgcolor = 'bg-red'; } elseif ($partition[4] > $server->warning_thresholds['storage']) { $bgcolor = 'bg-yellow'; } else { $bgcolor = 'bg-green'; }
    echo "<div class='col-md-3 col-sm-6 col-xs-12'>";
    echo "<div class='info-box ".$bgcolor."'>";
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
      if ($temperature[1] > $server->alarm_thresholds['temp']) { $bgcolor = 'bg-red'; } elseif ($temperature[1] > $server->warning_thresholds['temp']) { $bgcolor = 'bg-yellow'; } else { $bgcolor = 'bg-green'; }
      echo "<div class='col-md-3 col-sm-6 col-xs-12'>";
        echo "<div class='info-box ".$bgcolor."'>";
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
      if ($temperature > $server->alarm_thresholds['hddtemp']) { $bgcolor = 'bg-red'; } elseif ($temperature > $server->warning_thresholds['hddtemp']) { $bgcolor = 'bg-yellow'; } else { $bgcolor = 'bg-green'; }
      echo "<div class='col-md-3 col-sm-6 col-xs-12'>";
        echo "<div class='info-box ".$bgcolor."'>";
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