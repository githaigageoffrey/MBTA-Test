<h4>Subways With Most and Least Stops</h4>
<div class="row" style="margin-top:25px;">
    <?php foreach ($subway as $key => $routes) {
      if(isset($subways[$key])){
    ?>
        <div class="col-md-6">
          <h6>Subway Name: <?php echo $subways[$key];?></h6>
          <h6>Count : <?php echo $subway["count"][$key];?></h6>
          <div class="table-responsive">
            <table class="table table-striped table-sm">
              <thead>
                <tr>
                  <th>#</th>
                  <th>From</th>
                  <th>To</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($routes as $key => $route) {
                  echo "<tr>";
                    echo "<td>".($key+1)."</td>";
                    echo "<td>".($route[0])."</td>";
                    echo "<td>".($route[1])."</td>";
                  echo "</tr>";
                }?>
              </tbody>
            </table>
          </div>
        </div>
  <?php }}?>
</div>

<div class="clearfix"></div>

<div class="row justify-content-md-center"  style="margin-top:25px;">
  <div class="col-md-8 col-md-offset-3">
    <h6>List of route connecting more than one subway</h6>
    <div class="table-responsive">
      <table class="table table-striped table-sm">
        <thead>
          <tr>
            <th>#</th>
            <th>From</th>
            <th>Stop</th>
            <th>Destination</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($connections as $key => $route) {
            echo "<tr>";
              echo "<td>".($key+1)."</td>";
              echo "
                <td>".($route["from"])."
                    <br/>
                    Via: ".($subways[$route["via1"]])."
                </td>";
              echo "<td>".($route["stop"])."</td>";
              echo "<td>".($route["to"])."
                    <br/>
                    Via: ".($subways[$route["via2"]])."
                </td>";
            echo "</tr>";
          }?>
        </tbody>
      </table>
    </div>
  </div>
</div>
