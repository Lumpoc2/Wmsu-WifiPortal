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
                                <label for="chain">chain</label>
                                <input type="hidden" value="<?= $filter['.id'] ?>" name="id">
                                <select name="chain" id="chain" class="form-control">
                                    <?php 
                                    $uniqueActions = []; // Array to track unique actions
                                    foreach ($firewall as $data) { 
                                        if (!in_array($data['chain'], $uniqueActions)) { // Check if action is already added
                                            $uniqueActions[] = $data['chain']; // Add action to the unique list
                                    ?>
                                            <option value="<?= htmlspecialchars($data['chain']); ?>">
                                                <?= htmlspecialchars($data['chain']); ?>
                                            </option>
                                    <?php 
                                        } 
                                    } 
                                    ?>
                                </select>
                            </div>
                         <div class="form-group">
                            <label for="action">Action</label>
                            <select name="action" id="action" class="form-control">
                                <?php 
                                $uniqueActions = []; // Array to track unique actions
                                foreach ($firewall as $data) { 
                                    if (!in_array($data['action'], $uniqueActions)) { // Check if action is already added
                                        $uniqueActions[] = $data['action']; // Add action to the unique list
                                ?>
                                        <option value="<?= htmlspecialchars($data['action']); ?>">
                                            <?= htmlspecialchars($data['action']); ?>
                                        </option>
                                <?php 
                                    } 
                                } 
                                ?>
                            </select>
                        </div>
                     <div class="form-group">
                        <label for="dst-address-list">dst-address-list</label>
                            <select name="dst-address-list" id="dst-address-list" class="form-control">
                                <?php foreach ($firewall as $data) { ?>
                                  <?php if (isset($data["dst-address-list"]) && !empty($data["dst-address-list"])): ?>
                                    <option>
                                         <?= $data['dst-address-list']; ?>
                                    </option>
                                    <?php endif; ?>
                                    
                                <?php } ?>
                            </select>
                    </div>

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