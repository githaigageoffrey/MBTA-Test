<div class="row" style="margin-top:25px;">
  <h5>Download and Storing Json File Vs Rely on Server</h5>
  <!-- <h6>"subway" routes: "Light Rail" (type 0) and "Heavy Rail" (type 1)</h6> -->
</div>
<div class="row" style="margin-top:25px;">
  <div class="col-md-6">
    <div class="table-responsive">
      <table class="table table-striped table-sm">
        <thead>
          <tr>
            <th>#</th>
            <th>Long Name</th>
            <th>Subway</th>
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
  <div class="col-md-6">
    
    <figure class="highlight">
      <h5> Reasons for Downloading than relying on the server</h5>
            <ul>
                <li>Fast access (no waiting time on server requests)</li>
                <li>Reliable (especially if the API is hosted in a different location experiencing downtimes)</li>
                <li>Improved frontend performance (especially when paginating & filtering)</li>
                <li>Can easily work offline with a message to the user that the system is currently offline and one can be able to perform searches</li>
                <li>The API is not updates/modified so often to warrant online filtering</li>
                <li>When one downloads the API, gives more freedom to filter and present data in different variety without minding the load time</li>
              </ul>
          <h5> To achieve accuracy to the data</h5>
            <ul>
              <li> Use of websockets to listen to any event or update</li>
              <li> Constant pinning to get any update after the last modified time</li>
              <li> Use of state management approach to update the front-end once the file is updated</li>
              <li> Perfect for Non-transactonal API's ie informational API's</li>
            </ul>
    </figure>
  </div>
</div>
