<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">

            <div class="col-sm-6">
                <h3>Hotspot
                    <?= $title ?>
                </h3>
            </div>
            <div class="col-lg-6">
                <form action="<?= site_url('controll/saveEditDhcp'); ?>" method="POST">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="dns-server">DNS-Server</label>
                            <input type="hidden" value="<?= $DhcpNet['.id'] ?>" name="id">
                            <input type="text" name="dns-server" class="form-control" value="<?= $DhcpNet['dns-server']; ?>"
                                id="dns-server" placeholder="Enter DNS-Server" required>
                        </div>
                       
                       
                        
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="submit" class="btn btn-success">Save</button>
                    </div>
                </form>
            </div>
        </div>
</div>
</div>