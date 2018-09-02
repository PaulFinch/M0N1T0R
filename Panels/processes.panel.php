<div class="row">
  <div class="col-md-12">
    <div class="box">
      <div class="box-body">
        <table id="Table" class="table table-striped table-bordered dt-responsive nowrap">
          <thead>
            <tr>
              <th style="width: 100px">UID</th>
              <th style="width: 100px">User</th>
              <th style="width: 100px">PID</th>
              <th style="width: 100px">PPID</th>
              <th style="width: 100px">TTY</th>
              <th style="width: 100px">%CPU</th>
              <th style="width: 100px">%MEM</th>
              <th style="">Process</th>
            </tr>
          </thead>
          <tbody>
            <?PHP
              foreach ($server->processes as $process) {
                echo "<tr>";
                echo "<td>".$process[0]."</span></td>";
                echo "<td>".$process[1]."</td>";
                echo "<td>".$process[2]."</td>";
                echo "<td>".$process[3]."</td>";
                echo "<td>".$process[4]."</td>";
                echo "<td>".$process[5]."</td>";
                echo "<td>".$process[6]."</td>";
                echo "<td>".$process[7]."</td>";
                echo "</tr>";
              }
            ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>