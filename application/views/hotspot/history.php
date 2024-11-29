<?php date_default_timezone_set('Asia/Manila'); ?>
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
              <h3 class="card-title">User History List</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table class="table table-bordered table-hover" id="dataTable">
                <thead>
                  <tr>
                    <th>Mac-address</th>
                    <th>Uptime</th>
                    <th>Date & Time Connected</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    $this->load->database();

                    // Execute the SELECT query
                    $query = $this->db->query("SELECT * FROM tbl_active_ip GROUP BY mac_address");

                    $counts1 = 0;
                    if(isset($query)){
                      foreach ($query->result() as $row) {
                        echo "<tr>";
                        $query = $this->db->query("SELECT * FROM tbl_userlog WHERE client_mac_address = '".$row->mac_address."'"); //meowmeow

                        if ($query !== FALSE) {
                          // Query was successful
                          $num_rows = $query->num_rows();
                          if($num_rows > 0){
                            echo "<td><a href='".site_url('hotspot/historylist/'.$row->id.'/'.$row->mac_address)."'>".$row->mac_address."</a></td>";
                          }else{
                            echo "<td>".$row->mac_address."</td>";
                          }
                        }
                        echo "<td>".$row->uptime."</td>";
                        echo "<td>".$row->datetime_conn."</td>";
                        echo "</tr>";
                        $counts1++;
                      }
                    }
                    if($counts1<=0){
                      echo "<tr><td colspan='4'>No Active Data Found . . .</td></tr>";
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
        $('.delete-link').click(function(e) {
            e.preventDefault();

            var deleteUrl = $(this).attr('href');
            var Activename = $(this).data('name');

            Swal.fire({
                title: 'Delete Active student ' + Activename + '?',
                text: "This action cannot be undone.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = deleteUrl;
                }
            });
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

  <script>
    $(document).ready(function() {
        $('.delete-link').click(function(e) {
            e.preventDefault();

            var deleteUrl = $(this).attr('href');
            var Activename = $(this).data('name');

            Swal.fire({
                title: 'Delete Active student ' + Activename + '?',
                text: "This action cannot be undone.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = deleteUrl;
                }
            });
        });
    });
</script>
<script>
  $(document).ready(function () {
    // Function to update the textarea content
    function updateTextarea() {
        $.ajax({
            type: "GET",
            url: "<?= site_url('Hotspot/update_userlog_realtime'); ?>",
            success: function(response) {
                // Update textarea content with the new data
                $("#userlogs").text($("#userlogs").text()+response);
                var textarea = document.getElementById('userlogs');
                textarea.scrollTop = textarea.scrollHeight;
                //$("#userlogs").text("asdasdas");

                // Set a timeout for the next update
                setTimeout(updateTextarea, 2000); // 2000 milliseconds (2 seconds)
            }
        });
    }

    // Initial call to start the update process
    updateTextarea();
  });
</script>
</div>
