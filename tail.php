<footer class="main-footer">
  <div class="pull-right">AdminLTE 2.4.5</div>
  M0N1T0R v1.0
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

<script src="AdminLTE/bower_components/jquery/dist/jquery.min.js"></script>
<script src="AdminLTE/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="AdminLTE/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="AdminLTE/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="AdminLTE/dist/js/adminlte.min.js"></script>
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
