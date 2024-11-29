<?php date_default_timezone_set('Asia/Manila');

  $this->load->database();
  $query = $this->db->query("SELECT * FROM tbl_active_ip WHERE id = '".$active_id."'");
  foreach($query->result() as $queryresult){
    $name = $queryresult->name;
    $ip = $queryresult->ip_address;
    $mac = $queryresult->mac_address;
    $date = $queryresult->datetime_conn;
  }

  $whitelist = array();
  $query1 = $this->db->query("SELECT * FROM tbl_whitelist");
  $find_result = false;
  if(isset($query1)){
    foreach ($query1->result() as $row1) {
      array_push($whitelist, $row1->domain_name_txt);
    }
  }
?>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">User History -> MAC Address: <?=$mac?> ; Date Connected: <?=$date?> ;</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <button class="btn btn-success" id="btn_trusted"><h3>Trusted Site(s)</h3></button><button class="btn btn-danger" id="btn_suspicious" style="margin-left:20px;"><h3>Suspicious Site(s)</h3></button><br><br>
              <table class="table table-bordered table-hover" id="dataTable_trusted" style="display:none;">
                <thead>
                  <tr>
                    <th>Date</th>
                    <th>Domain Name</th>
                    <th>Client IP</th>
                    <th>Client MAC Address</th>
                    <th>User Log ID</th>
                  </tr>
                </thead>
                <tbody>
                  <?php

                    // Execute the SELECT query
                    $query = $this->db->query("SELECT * FROM tbl_userlog as ulog, tbl_whitelist as wlist WHERE ulog.client_mac_address = '".$mac_address."' ORDER BY ulog.userlog_id DESC");

                    $counts1 = 0;
                    if(isset($query)){
                      foreach ($query->result() as $row) {

                        $needle = $row->domain_name;
                        $find_result = false;
                        foreach ($whitelist as $key => $haystack) {
                            $position = strpos($needle, $haystack);

                            if ($position !== false) {
                              $find_result = true;
                              $break;
                            }
                        }

                        if($find_result == true){
                          $datetime = date("Y-m-d H:i:s", $row->domain_timestamp);
                          echo "<tr>";
                          echo "<td>".$datetime."</td>";
                          echo "<td>".$row->domain_name."</td>";
                          echo "<td>".$row->client_ip."</td>";
                          echo "<td>".$row->client_mac_address."</td>";
                          echo "<td>".$row->userlog_id."</td>";
                          echo "</tr>";
                          $counts1++;
                        }
                      }
                    }
                    if($counts1<=0){
                      echo "<tr><td colspan='5'>No Active Data Found . . .</td></tr>";
                    } 
                
                ?>
                </tbody>              
              </table>

              <table class="table table-bordered table-hover" id="dataTable_suspicious" style="display:none;">
                <thead>
                  <tr>
                    <th>Date & Time</th>
                    <th>Domain Name</th>
                    <th>Client IP</th>
                    <th>Client MAC Address</th>
                    <th>User Log ID</th>
                  </tr>
                </thead>
                <tbody>
                  <?php

                    // Execute the SELECT query
                    $query = $this->db->query("SELECT * FROM tbl_userlog as ulog, tbl_whitelist as wlist WHERE ulog.client_mac_address = '".$mac_address."' ORDER BY ulog.userlog_id DESC");

                    $counts1 = 0;
                    if(isset($query)){
                      foreach ($query->result() as $row) {

                        $needle = $row->domain_name;
                        $find_result = false;
                        foreach ($whitelist as $key => $haystack) {
                            $position = strpos($needle, $haystack);

                            if ($position !== false) {
                              $find_result = true;
                              $break;
                            }
                        }

                        if($find_result != true){
                          $datetime = date("Y-m-d H:i:s", $row->domain_timestamp);
                          echo "<tr>";
                          echo "<td>".$datetime."</td>";
                          echo "<td>".$row->domain_name."</td>";
                          echo "<td>".$row->client_ip."</td>";
                          echo "<td>".$row->client_mac_address."</td>";
                          echo "<td>".$row->userlog_id."</td>";
                          echo "</tr>";
                          $counts1++;
                        }
                      }
                    }
                    if($counts1<=0){
                      echo "<tr><td colspan='5'>No Active Data Found . . .</td></tr>";
                    } 
                
                ?>
                </tbody>              
              </table>
              <!-- /.card-body -->
            </div>
            
            <!-- /.card -->

            
          </div>
          <!-- /.col -->
        </div>


      </div>


      
        <!-- /.row -->
      <!-- /.container-fluid -->
    </div>


    
  </section>
  <!-- /.content -->
  
  <script>
    $(document).ready(function() {
        $('#btn_trusted').click(function(e) {
          e.preventDefault();
          $('#dataTable_suspicious').hide('slow');
          $('#dataTable_trusted').show('slow');
        });

        $('#btn_suspicious').click(function(e) {
          e.preventDefault();
          $('#dataTable_trusted').hide('slow');
          $('#dataTable_suspicious').show('slow');
        });
    });
</script>
</div>
<div class="content-wrapper" style="margin-top:-250px;">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>
</div>