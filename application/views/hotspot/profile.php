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
              <h3 class="card-title">User Profile</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <div class="pb-3">
                <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#modal-add-profile">
                  Add Profile
                </button>

              </div>
              <table class="table table-bordered table-hover" id="dataTable">
                <thead>
                  <tr>

                    <th>
                      <?= $totalhotspotprofile ?>
                    </th>
                    <th>Name</th>
                    <th>Shared User</th>
                    <th>Rate Limit</th>
                    <th>Session time-out</th>

                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($hotspotprofile as $data) { ?>
                    <tr>
                      <?php $id = str_replace('*', '', $data[".id"]) ?>
                      <th>
                        <a href="<?= site_url('Hotspot/editUserProfile/' . $id) ?>"><i class="fa fa-edit"
                            style="color: green"></i></a>
                        <a href="<?= site_url('Hotspot/delProfile/' . $id) ?>" class="delete-link"
                          data-name="<?= $data['name']; ?>"><i class="fa fa-trash" style="color: red"></i></a>
                      </th>
                      <th>
                        <?= $data['name']; ?>
                      </th>
                      <th>
                        <?= $data['shared-users']; ?>
                      </th>
                      <th>
                        <?= $data['rate-limit']; ?>
                      </th>
                      <th>
                        <?= $data['session-timeout']; ?>
                      </th>
                      <th>
                        <?= $data['comment']; ?>
                      </th>
                    </tr>
                  <?php } ?>
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
</div>
<div class="modal fade" id="modal-add-profile" style="display: none;" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content bg-secondary">
      <div class="modal-header">
        <h4 class="modal-title">Add User Profile</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true"></span>
        </button>
      </div>
      <form action="<?= site_url('Hotspot/addUserProfile'); ?>" method="POST" class='user-Profile'>
        <div class="modal-body">
          <div class="form-group">
            <label for="user">User</label>
            <input type="text" name="user" class="form-control" id="user" placeholder="Enter User" required>
          </div>

          <div class="form-group">
            <label for="rate_limit">Rate limit</label>
            <input type="rate_limit" name="rate_limit" class="form-control" id="rate_limit"
              placeholder="Enter Rate limit" required>
          </div>

          <div class="form-group">
            <label for="shared_user">Shared user</label>
            <input type="number" name="shared_user" class="form-control" id="shared_user"
              placeholder="Enter shared user" required>
          </div>
          <div class="form-group">
            <label for="session_limit">Session Limit</label>
            <input type="text" name="session_limit" class="form-control" id="session_limit"
              placeholder="Enter Time Limit">
          </div>

        </div>

        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-outline-light">Save</button>
        </div>
      </form>
    </div>

  </div>
  <script>
    $(document).ready(function () {
      $('.delete-link').click(function (e) {
        e.preventDefault();

        var deleteUrl = $(this).attr('href');
        var Profilename = $(this).data('name');

        Swal.fire({
          title: 'Delete User Profile ' + Profilename + '?',
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
  $('.user-Profile').submit(function (e) {
    e.preventDefault();

    var formData = $(this).serialize();

    $.ajax({
      type: "POST",
      url: $(this).attr('action'),
      data: formData,
      success: function (response) {
        if (response.success) {
          Swal.fire({
            title: 'Success!',
            text: response.message,
            icon: 'success',
          });
          setTimeout(function(){
            location.reload();
          }, 2000);
        } else {
          Swal.fire({
            title: 'Error!',
            text: response.message,
            icon: 'error'
          });
        }
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