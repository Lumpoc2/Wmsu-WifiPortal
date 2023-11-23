
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
                <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#modal-add-user">
                  Add User
                </button>
              </div>
              <table class="table table-bordered table-hover" id="dataTable">
                <thead>
                  <tr>
                    <th><?= $totalhotspotuser ?></th>
                    <th>Username</th>
                    <th>Password</th>
                    <th>Profile</th>
                    <th>Uptime</th>
                    <th>Bytes In</th>
                    <th>Bytes Out</th>
                    <th>Comment</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
             
                  <?php foreach ($hotspotuser as $data) { ?>
                    <!-- <?php var_dump($data) ?> -->
                    <tr>
                    <?php $id = str_replace('*','',$data[".id"]) ?>
                      <th>
                        <a href="<?= site_url('hotspot/editUser/' . $id)?>"><i class="fa fa-edit" style="color: green"></i></a>
                        <a href="<?= site_url('hotspot/delUser/' . $id)?>" class="delete-link"  data-name="<?= $data['name']; ?>"><i class="fa fa-trash" style="color: red" ></i></a>
                      </th>  
                      <th><?= $data['name']; ?></th>
                      <th><?= $data['password']; ?></th>
                      <th><?= $data['profile']; ?></th>
                      <th><?= $data['uptime']; ?></th>
                      <th><?= formatbytes($data['bytes-in'], 2); ?></th>
                      <th><?= formatbytes($data['bytes-out'], 3); ?></th>
                      <th><?= $data['comment']; ?></th>
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
<div class="modal fade" id="modal-add-user" style="display: none;" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content bg-secondary">
      <div class="modal-header">
        <h4 class="modal-title">Add User Hotspot</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true"></span>
        </button>
      </div>
      <form action="<?= site_url('hotspot/addUser'); ?>" method="POST">
        <div class="modal-body">
        <div class="form-group">
              <label for="user">User</label>
              <input  type="text" name="user" class="form-control" id="user" placeholder="Enter User" required>
            </div>
            
            <div class="form-group">
              <label for="password">Password</label>
              <input  type="password" name="password" class="form-control" id="password" placeholder="Enter Password" required>
            </div>
            
            <div class="form-group">
              <label for="server">Server</label>
              <select name="server" id="server" class="form-control">
                <option>all</option>
                <?php foreach ($server as $data) {?>
                  <option><?=$data['name']; ?></option>
                <?php } ?>
              </select>

            </div>
            
            <div class="form-group">
              <label for="profile">Profile</label>
              <select name="profile" id="profile" class="form-control">
                <option>all</option>
                <?php foreach ($profile as $data){ ?>
                  <option><?=$data['name']?></option>
                <?php } ?>
              </select>

            </div>
            
            <div class="form-group">
              <label for="timelimit" >Time Limit</label>
              <input  type="text" name="timelimit" class="form-control" id="timelimit" placeholder="Enter Time Limit">
            </div>
           
        </div>
       
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-outline-light">Save</button>
      </div>
      </form>
    </div>

  </div>

</div>
  <script>
    $(document).ready(function() {
        $('.delete-link').click(function(e) {
            e.preventDefault();

            var deleteUrl = $(this).attr('href');
            var studentName = $(this).data('name');

            Swal.fire({
                title: 'Delete Student ' + studentName + '?',
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
