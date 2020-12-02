<h4>Dashboard  Vs Rely on Server</h4>
<h6>"subway" routes:
"Light Rail" (type 0) and "Heavy Rail" (type 1)</h6>
<div class="row">
  <div class="col-md-8">
    <div class="table-responsive">
      <table class="table table-striped table-sm">
        <thead>
          <tr>
            <th>#</th>
            <th>Long Name</th>
            <th>Type</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($routes as $key => $route) {
            echo "<tr>";
              echo "<td>".($key+1)."</td>";
              echo "<td>".$route["name"]."</td>";
              echo "<td>".$subways[$route["type"]]."</td>";
            echo "</tr>";
          }?>
          
        </tbody>
      </table>
    </div>
  </div>
</div>
