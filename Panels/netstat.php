<div class="row">
  <div class="col-md-12">
    <div class="box">
      <div class="box-body">
        <table id="Table" class="table table-striped table-bordered dt-responsive nowrap">
          <thead>
            <tr>
              <th style="">Proto</th>
              <th style="">Address</th>
              <th style="">Port</th>
            </tr>
          </thead>
          <body>
            <?PHP
              foreach ($server->netstat as $net) {
                echo "<tr>";
                echo "<td>".$net[0]."</td>";
                echo "<td>".$net[1]."</span></td>";
                echo "<td>".$net[2]."</span></td>";
                echo "</tr>";
              }
            ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>