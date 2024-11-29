<?php
date_default_timezone_set('Asia/Manila');
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
                            <h3 class="card-title">Active Student/s List</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered table-hover" id="dataTable">
                                <thead>
                                    <tr>
                                        <th><?= $totalhotspotactive ?></th>
                                        <th>Name</th>
                                        <th>Ip-Address</th>
                                        <th>Mac-address</th>
                                        <th>Uptime</th>
                                        <th>Bytes In</th>
                                        <th>Bytes Out</th>
                                        <th>Comment</th>
                                        <th>Connectivity Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $counts1 = 0; foreach ($hotspotactive as $data) { ?>
                                    <?php
                                            $value = $data['idle-time'];
                                            $online_status = true;
                                            $numericPart = intval($value);

                                            // Check if the user is online
                                            if ($numericPart >= 15) {
                                                $connect_status = "<span style='color:red;'>Offline</span>";
                                                $online_status = false;
                                            } else {
                                                $connect_status = "<span style='color:green;font-weight:bold;'>Online</span>";
                                            }

                                            // Insert data into the database only if the user is online
                                            if ($online_status) {
                                                $this->load->database();

                                                // Check if the user is already in the database by mac_address
                                                $query = $this->db->query("SELECT * FROM tbl_active_ip WHERE mac_address = '".$data['mac-address']."'");

                                                if ($query->num_rows() == 0) {
                                                    // Prepare the SQL insert statement
                                                    $sql = "INSERT INTO `tbl_active_ip` (`id`, `name`, `ip_address`, `mac_address`, `uptime`, `bytes_in`, `bytes_out`, `conn_status`, `datetime_conn`, `date_created`, `date_updated`, `other_data`) 
                                                            VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

                                                    // Execute the query with bound parameters
                                                    $this->db->query($sql, [
                                                        NULL, // id auto-incremented
                                                        $data['user'], // Name
                                                        $data['address'], // IP Address
                                                        $data['mac-address'], // MAC Address
                                                        $data['uptime'], // Uptime
                                                        $data['bytes-in'], // Bytes In
                                                        $data['bytes-out'], // Bytes Out
                                                        "Connected", // Connection Status
                                                        date('Y-m-d H:i:s'), // Date and time when the user connected
                                                        date('Y-m-d H:i:s'), // Date Created
                                                        date('Y-m-d H:i:s'), // Date Updated
                                                        " " // Other Data (Empty string)
                                                    ]);
                                                }
                                            }
                                        ?>
                                    <!-- Display the table row for the user -->
                                    <tr <?= (($online_status) ? "" : "hidden") ?>>
                                        <?php $id = str_replace('*', '', $data[".id"]) ?>
                                        <th><a href="<?= site_url('hotspot/delActive/' . $id)?>" class="delete-link"
                                                data-name="<?= $data['user']; ?>"><i class="fa fa-trash"
                                                    style="color: red"></i></a></th>
                                        <th><?= $data['user']; ?></th>
                                        <th><?= $data['address'];?></th>
                                        <th><?= $data['mac-address'];?></th>
                                        <th><?= $data['uptime'];?></th>
                                        <th><?= formatBytes($data['bytes-in'], 2) ?></th>
                                        <th><?= formatBytes($data['bytes-out'], 3) ?></th>
                                        <th><?= $data['comment'] ?></th>
                                        <th><?= $connect_status ?></th>
                                    </tr>
                                    <?php $counts1++; ?>
                                    <?php } ?>
                                    <?php if ($counts1 <= 0) { ?>
                                    <tr>
                                        <td colspan='9'>No Active Data Found . . .</td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
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

    <script>
    $(document).ready(function() {
        // Function to update the textarea content
        function updateTextarea() {
            $.ajax({
                type: "GET",
                url: "<?= site_url('Hotspot/update_userlog_realtime'); ?>",
                success: function(response) {
                    // Update textarea content with the new data
                    $("#userlogs").text($("#userlogs").text() + response);
                    var textarea = document.getElementById('userlogs');
                    textarea.scrollTop = textarea.scrollHeight;

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

<div class="content-wrapper" style="margin-top:-270px;">
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
                            <h3 class="card-title">Inactive Student/s List</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered table-hover" id="dataTable">
                                <thead>
                                    <tr>
                                        <th><?= $totalhotspotactive ?></th>
                                        <th>Name</th>
                                        <th>Ip-Address</th>
                                        <th>Mac-address</th>
                                        <th>Uptime</th>
                                        <th>Bytes In</th>
                                        <th>Bytes Out</th>
                                        <th>Comment</th>
                                        <th>Connectivity Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $counts2 = 0; foreach ($hotspotactive as $data) { ?>
                                    <?php
                                            $value = $data['idle-time'];
                                            $offline_status = true;
                                            $numericPart = intval($value);
                                            
                                            if ($numericPart >= 15) {
                                                $connect_status = "<span style='color:red;'>Offline</span>";
                                                $offline_status = true;
                                            } else {
                                                $connect_status = "<span style='color:green;font-weight:bold;'>Online</span>";
                                                $offline_status = false;
                                            }
                                        ?>
                                    <tr <?= (($offline_status == true) ? $counts2++ : "hidden") ?>>
                                        <?php $id = str_replace('*', '', $data[".id"]) ?>
                                        <th><a href="<?= site_url('hotspot/delActive/' . $id)?>" class="delete-link"
                                                data-name="<?= $data['user']; ?>"><i class="fa fa-trash"
                                                    style="color: red"></i></a></th>
                                        <th><?= $data['user']; ?></th>
                                        <th><?= $data['address'];?></th>
                                        <th><?= $data['mac-address'];?></th>
                                        <th><?= $data['uptime'];?></th>
                                        <th><?= formatBytes($data['bytes-in'], 2) ?></th>
                                        <th><?= formatBytes($data['bytes-out'], 3) ?></th>
                                        <th><?= $data['comment'] ?></th>
                                        <th><?= $connect_status ?></th>
                                    </tr>
                                    <?php
                                        $this->load->database();
                                        $query = $this->db->query("SELECT * FROM tbl_active_ip WHERE mac_address = '".$data['mac-address']."'");
                                        if ($query->num_rows() == 0) {
                                            // Similar insert query as above
                                        }
                                    } ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>