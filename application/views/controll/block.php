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
              <h3 class="card-title">Block site by URL</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <div class="pb-3">
                <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#modal-add-Url">
                  Add Url
                </button>
              </div>
              <table class="table table-bordered table-hover" id="dataTable">
                <thead>
                  <tr>
                    <th>
                      <?= $totallayerProtocol ?>
                    </th>
                    <th>URL</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($layerProtocol as $data) { ?>
                    <tr>
                    <?php $id = str_replace('*','',$data[".id"]) ?>
                      <th>
                      <a href="<?= site_url('controll/editLayer/' . $id)?>"><i class="fa fa-edit" style="color: green"></i></a>
                        <a href="<?= site_url('controll/delLayer7/' . $id)?>"onclick="return confirm('Delete URL  <?= $data['regexp']; ?> ?')"><i class="fa fa-trash" style="color: red"></i></a>
                      </th> 
                      <th>
                        <?= $data['regexp']; ?>
                      </th>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
              <!-- /.card-body -->

            </div>
            <div class="card-body">
              <div class="pb-3">
                <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#modal-add-block">
                  Add Firewall
                </button>
              </div>
              <table class="table table-bordered table-hover" id="dataTable">
                <thead>
                  <tr>
                    <th></th>
                    <th>Chain</th>
                    <th>Action</th>
                    <th>Src-address</th>
                    <th>Layer7-protocol</th>

                  </tr>
                </thead>
                <tbody>
                  <!-- <?php var_dump($firewall) ?> -->
                  <?php foreach ($firewall as $data) { ?>
                    <!-- <?php if (isset($data["src-address"]) && isset($data["layer7-protocol"])): ?> -->
                      <tr>
                      <?php $id = str_replace('*','',$data[".id"]) ?>
                      <th>
                      <a href="<?= site_url('controll/editFilter/' . $id)?>"><i class="fa fa-edit" style="color: green"></i></a>
                        <a href="<?= site_url('controll/delFilter/' . $id)?>"onclick="return confirm('Delete Firewall')"><i class="fa fa-trash" style="color: red"></i></a>
                      </th> 
                      </th> 
                        <th><?= $data["chain"]; ?></th>
                        <th><?= $data["action"]; ?></th>
                        <th><?= $data["src-address"]; ?></th>
                        <th><?= $data["layer7-protocol"]; ?></th>
                      </tr>
                    <?php endif; ?>
                  <?php } ?>
                </tbody>
              </table>
              <!-- /.card -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
  </section>
  <!-- /.content -->
  <div class="modal fade" id="modal-add-block" style="display: none;" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content bg-secondary">
        <div class="modal-header">
          <h4 class="modal-title">Add filter</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true"></span>
          </button>
        </div>
        <form action="<?= site_url('controll/addControll'); ?>" method="POST">
          <div class="modal-body">
            <div class="form-group">
              <label for="layer7-protocol">layer7-protocol</label>

              <select name="layer7-protocol" id="layer7-protocol" class="form-control">
              
              <?php foreach ($layerProtocol as $data) { ?>
                  <option>
                    <?= $data['name']; ?>
                  </option>
                <?php } ?>
              </select>

            </div>
            <div class="form-group">
              <label for="src-address">src-address</label>

              <select name="src-address" id="src-address" class="form-control">
              
              <?php foreach ($dhcp as $data) { ?>
                  <option>
                    <?= $data['address']; ?>
                  </option>
                <?php } ?>
              </select>

            </div>
           

            <div class="form-group">
              <label for="chain">Chain</label>
              <input type="text" name="chain" class="form-control" id="chain" placeholder="forward" required>
            </div>

            <div class="form-group">
              <label for="action">Actions</label>
              <input type="text" name="action" class="form-control" id="action" placeholder="drop" required>
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
  <div class="modal fade" id="modal-add-Url" style="display: none;" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content bg-secondary">
        <div class="modal-header">
          <h4 class="modal-title">Add Url</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true"></span>
          </button>
        </div>
        <form action="<?= site_url('controll/addLayer7'); ?>" method="POST">
          <div class="modal-body">

            <div class="form-group">
              <label for="name">Name</label>

              <input type="text" name="name" class="form-control" id="name" placeholder="Name" required>
            </div>

            <div class="form-group">
              <label for="regexp">URL</label>
              <input type="text" name="regexp" class="form-control" id="regexp" placeholder="Enter your URL" required>
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
  
</div>

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
  
  <!-- /.content -->
  <div class="modal fade" id="modal-add-DNS" style="display: none;" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content bg-secondary">
        <div class="modal-header">
          <h4 class="modal-title">Add DNS</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true"></span>
          </button>
        </div>
        <form action="<?= site_url('controll/addDns'); ?>" method="POST">
          <div class="modal-body">

            <div class="form-group">
              <label for="dns-server">Dns-Server</label>

              <input type="text" name="dns-server" class="form-control" id="dns-server" placeholder="Dns-Server" required>
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
  
</div>

