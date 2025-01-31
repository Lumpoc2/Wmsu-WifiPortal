
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
     
        <div class="col-sm-6">
            <h3>Hotspot <?= $title ?></h3>
        </div>
                <div class="col-lg-6">
                <form action="<?= site_url('Hotspot/saveEditUser'); ?>" method="POST" id="editUserForm">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="user">User</label>
                            <input type="hidden" value="<?= $user['.id'] ?>" name="id">
                            <input required type="text" name="user" class="form-control" value=" <?= $user['name']; ?>" id="user" placeholder="Enter User"
                                required>
                        </div>

                        <div class="form-group">
                            <label for="password">Password</label>
                            <input required type="password" name="password" class="form-control" value=" <?= $user['password']; ?>" id="password"
                                placeholder="Enter Password" required>
                        </div>

                        <div class="form-group">
                            <label for="server">Server</label>
                            <select name="server" id="server" class="form-control"  >
                                <?= $user['server']; ?>
                                <?php foreach ($server as $data) { ?>
                                    <option>
                                        <?= $data['name']; ?>
                                    </option>
                                <?php } ?>
                            </select>

                        </div>

                        <div class="form-group">
                            <label for="profile">Profile</label>
                            <select name="profile" id="profile" class="form-control">
                                <option><?= $user['profile']; ?></option>
                                <?php foreach ($profile as $data) { ?>
                                    <option>
                                        <?= $data['name'] ?>
                                    </option>
                                <?php } ?>
                            </select>

                        </div>

                        <div class="form-group">
                            <label for="timelimit">Time Limit</label>
                            <input required type="text" name="timelimit" class="form-control"  value=" <?= $user['limit-uptime']; ?>" id="timelimit"
                                placeholder="Enter Time Limit">
                        </div>
                        <div class="form-group">
                            <label for="comment">comment</label>
                            <input required type="text" name="comment" class="form-control"  value=" <?= $user['comment']; ?>" id="comment"
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
                            text: 'Data has been updated successfully.',
                            icon: 'success',
                            confirmButtonText: 'Enter'
                        });
                    }
                });
            });
        });
    </script>
</div>
