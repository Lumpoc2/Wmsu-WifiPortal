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
                <form action="<?= site_url('controll/saveEditFilter'); ?>" method="POST">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="chain">Chain</label>
                            <input type="hidden" value="<?= $filter['.id'] ?>" name="id">
                            <input type="text" name="chain" class="form-control" value="<?= $filter['chain']; ?>"
                                id="chain" placeholder="Enter Name" required>
                        </div>
                        <div class="form-group">
                            <label for="action">Action</label>
                            <input type="text" name="action" class="form-control" value="<?= $filter['action']; ?>"
                                id="action" placeholder="Enter Action" required>
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
                            <label for="layer7-protocol">Layer7-protocol</label>
                            <select name="layer7-protocol" id="layer7-protocol" class="form-control">
                                <?php foreach ($layerProtocol as $data) { ?>
                                    <option>
                                        <?= $data['name']; ?>
                                    </option>
                                <?php } ?>
                            </select>
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