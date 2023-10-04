<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
     
        <div class="col-sm-6">
            <h3>Hotspot <?= $title ?></h3>
        </div>
                <div class="col-lg-6">
                <form action="<?= site_url('controll/saveEditLayer'); ?>" method="POST">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="hidden" value="<?= $layer['.id'] ?>" name="id">
                            <input type="text" name="name" class="form-control" value=" <?= $layer['name']; ?>" id="name" placeholder="Enter Name"
                                required>
                        </div>

                        <div class="form-group">
                            <label for="regexp">URL</label>
                            <input type="text" name="regexp" class="form-control" value=" <?= $layer['regexp']; ?>" id="regexp"
                                placeholder="Enter URL" required>
                        </div>

                    <div class="modal-footer justify-content-between">
                        <button type="submit" class=" btn btn-success">Save</button>
                    </div>
                </form>
                </div>
        </div>
    </div>
</div>