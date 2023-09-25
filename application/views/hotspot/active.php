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
                    <th>Name</th>
                    <th>Ip-Address</th>
                    <th>Mac-address</th>
                    <th>Uptime</th>
                    <th>Bytes In</th>
                    <th>Bytes Out</th>
                    <th>Comment</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($hotspotactive as $data) { ?>
                    <tr>
                    <th><a href="<?= site_url('hotspot/delActive/' . $id)?>"onclick="return confirm('Delete Student  <?= $data['user']; ?> ?')"><i class="fa fa-trash" style="color: red"></i></a></th>
                    <th><?= $data['user']; ?> </th>
                    <th><?= $data['address'];?></th>
                     <th><?= $data['mac-address'];?></th>
                     <th><?= $data['uptime'];?></th>
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
