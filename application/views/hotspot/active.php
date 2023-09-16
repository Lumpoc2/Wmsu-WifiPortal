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
              <h3 class="card-title">Active Student</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">    
              <!-- <?php var_dump($hotspotactive)?> -->
              <table class="table table-bordered table-hover" id="dataTable">
                <thead>
                  <tr>
                    <th><?= $totalhotspotactive ?></th>
                    <th>User</th>
                    <th>Server</th>
                    <th>login by</th>
                    <th>Uptime</th>
                    <th>Bytes In</th>
                    <th>Bytes Out</th>
                    <th>Comment</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($hotspotactive as $data) { ?>
                    <tr>
                      <th></th>
                      <th><?= $data['user']; ?></th>
                      <th><?= $data['server'] ?></th>
                      <th><?= $data['login-by'] ?></th>
                      <th><?= $data['profile'] ?></th>
                      <th><?= $data['uptime'] ?></th>
                      <th><?= formatBytes($data['bytes-in'], 2) ?></th>
                      <th><?= formatBytes($data['bytes-out'], 3) ?></th>
                      <th><?= $data['comment'] ?></th>
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
