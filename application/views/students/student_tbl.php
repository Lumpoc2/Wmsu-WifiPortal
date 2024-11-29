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
                            <h3 class="card-title">Student Information</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="pb-3">

                                <?php 
                /*
                if(isset($_POST['btnImport'])){
                  echo "xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx";
                }else{
                  echo "yyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyy";
                }
                */
                
                ?>
                                <form action="process_upload.php" method="post" enctype="multipart/form-data"
                                    style="float:right;">
                                    <input type="file" name="excelFile" class="" required>
                                    <input class="btn btn-primary" type="submit" value="Import from CSV Excel File"
                                        name="btnImport" id="btnImport">
                                </form>
                            </div>
                            <table class="table table-bordered table-hover" id="dataTable">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Firstname</th>
                                        <th>Lastname</th>
                                        <th>Email</th>
                                        <th>Year-Level</th>
                                        <th>Server</th>
                                        <th>Profile</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($students as $student): ?>

                                    <tr>
                                        <td>
                                            <a href="<?= base_url('Students/delete_student/' . $student->id . '/' . $student->email) ?>"
                                                class="delete-link"><i class="fa fa-trash" style="color: red"></i></a>
                                        </td>
                                        <td>
                                            <?= $student->firstname ?>
                                        </td>
                                        <td>
                                            <?= $student->lastname ?>
                                        </td>
                                        <td>
                                            <?= $student->email ?>
                                        </td>
                                        <td>
                                            <?= $student->yearLevel ?>
                                        </td>
                                        <td>
                                            <?= $student->server ?>
                                        </td>
                                        <td>
                                            <?= $student->userprofile ?>
                                        </td>
                                        <td>
                                            <center>
                                                <?php
                        $triggerUser = false;
                        foreach($hotspotuser as $users){
                          if($student->email == $users['name']){
                            $triggerUser = true;
                            break;
                          }
                        }
                        if($triggerUser != true){
                          ?>
                                                <!-- Assuming this is in your view file -->
                                                <button class="btn btn-success"><a
                                                        href="<?= base_url('Students/send_activation_emails/' .  $student->id) ?>"
                                                        style="color: white">Activate</a></button>
                                                <?php }else{ ?>
                                                <button class="btn btn-danger"><a
                                                        href="<?= base_url('Students/send_deactivation_emails/' .  $student->email) ?>"
                                                        style="color: white">Deactivate</a></button>
                                                <?php
                        }

                        ?>
                                            </center>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
    <script>
    $(document).ready(function() {
        $('.delete-link').click(function(e) {
            e.preventDefault();

            var deleteUrl = $(this).attr('href');

            Swal.fire({
                title: 'Delete Student Information ' + '?',
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