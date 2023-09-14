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
              <table class="table table-bordered table-hover" id="dataTable" >
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
                          <?php foreach($hotspotuser as $data){?>
                          <tr>
                            <th></th>
                            <th><?= $data ['name'] ?></th>
                            <th><?= $data ['password'] ?></th>
                            <th><?= $data ['profie'] ?></th>
                            <th><?= $data ['uptime'] ?></th>
                            <th><?= formatBytes($data ['bytes-in'],2) ?></th>
                            <th><?= formatBytes($data ['bytes-out'],3) ?></th>
                            <th><?= $data ['comment'] ?></th>
                          </tr>
                          <?php }?>
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
