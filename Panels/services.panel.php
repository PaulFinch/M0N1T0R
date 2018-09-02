<div class="row">
  <div class="col-md-12">
    <div class="box">
      <div class="box-body">
        <table id="Table" class="table table-striped table-bordered dt-responsive nowrap">
          <thead>
            <tr>
              <th style="">Unit</th>
              <th style="width: 70px">Load</th>
              <th style="width: 70px">Active</th>
              <th style="width: 70px">Sub</th>
            </tr>
          </thead>
          <body>
            <?PHP
              foreach ($server->services as $service) {
                if ($service[1] == 'loaded') { $label_load = 'label-success'; } else { $label_load = 'label-danger'; }
                if ($service[2] == 'active') { $label_active = 'label-success'; } else { $label_active = 'label-danger'; }
                if ($service[3] != 'failed') { $label_sub = 'label-success'; } else { $label_sub = 'label-danger'; }

                echo "<tr>";
                echo "<td>".$service[0]."</td>";
                echo "<td><span class='label ".$label_load."'>".$service[1]."</span></td>";
                echo "<td><span class='label ".$label_active."'>".$service[2]."</span></td>";
                echo "<td><span class='label ".$label_sub."'>".$service[3]."</span></td>";
                echo "</tr>";
              }
            ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>