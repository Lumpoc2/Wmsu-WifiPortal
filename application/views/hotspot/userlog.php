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
              <h3 class="card-title">User Logs</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <div class="pb-3">

              </div>
              <textarea class="form-control" id="userlogs" style="min-height:600px;max-height:600px;overflow-y:hidden;"></textarea>
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
</div>
  <script>
    $(document).ready(function () {
      // Function to update the textarea content
      function updateTextarea() {
          $.ajax({
              type: "GET",
              url: "<?= site_url('Hotspot/update_userlog'); ?>",
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