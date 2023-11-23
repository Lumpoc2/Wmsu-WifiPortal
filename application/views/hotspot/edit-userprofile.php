<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
     
        <div class="col-sm-6">
            <h3>Hotspot <?= $title ?></h3>
        </div>
                <div class="col-lg-6">
                <form action="<?= site_url('hotspot/saveEditUser'); ?>" method="POST" class="edit-link">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="hidden" value="<?= $profile['.id'] ?>" name="id">
                            <input type="text" name="name" class="form-control" value=" <?= $profile['name']; ?>" id="name" placeholder="Enter Name"
                                required>
                        </div>

                        <div class="form-group">
                            <label for="shared-users">Shared-Users</label>
                            <input type="text" name="shared-users" class="form-control" value=" <?= $profile['shared-users']; ?>" id="shared-users"
                                placeholder="Enter Shared-Users" required>
                        </div>

                        <div class="form-group">
                            <label for="rate-limit">Rate Limit</label>
                            <input type="text" name="rate-limit" class="form-control"  value=" <?= $profile['rate-limit']; ?>" id="rate-limit"
                                placeholder="Enter Rate Limit">
                        </div>
                        <div class="form-group">
                            <label for="session-timeout">Session-Timeout</label>
                            <input type="text" name="session-timeout" class="form-control"  value=" <?= $profile['session-timeout']; ?>" id="session-timeout"
                                placeholder="Enter Session-Timeout">
                        </div>
                        <div class="form-group">
                            <label for="comment">comment</label>
                            <input type="text" name="comment" class="form-control"  value=" <?= $profile['comment']; ?>" id="comment"
                                placeholder="Enter Time Limit">
                        </div>
                    </div>

                    <div class="modal-footer justify-content-between">
                        <button type="submit" class=" btn btn-success">Save</button>
                    </div>
                </form>
                </div>
        </div>
    </div>
    <script>
    $(document).ready(function() {
        $('.edit-link').submit(function(e) {
            e.preventDefault(); // Prevent the form from submitting normally

            var formData = $(this).serialize(); // Serialize form data

            $.ajax({
                type: "POST",
                url: $(this).attr('action'),
                data: formData,
                success: function(response) {
                    Swal.fire({
                        title: 'Success',
                        text: 'Do you want to update more?',
                        icon: 'success',
                        confirmButtonText: 'Enter'
                    });
                }
            });
        });
    });
</script>
</div>