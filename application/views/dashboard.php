<div class="content-wrapper mt-5">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3><?= $cpu; ?></h3>

                            <p>CPU</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3><?= $uptime; ?><sup style="font-size: 20px">%</sup></h3>

                            <p>Up Time</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3><?= $hotspotuser; ?></h3>

                            <p>Registered Student</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                        <a href="<?= site_url('/hotspot/users')?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3><?= $hotspotactive; ?></h3>

                            <p>Active student</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-pie-graph"></i>
                        </div>
                        <a href="<?= site_url('/hotspot/active')?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
            </div>
            <select name="interface" id="interface">
                <?php foreach ($interface as $interface){?> 
                    <option value="<?= $interface['name']?>"><?= $interface['name']?> </option>    
                <?php }?>
                
            </select>
            <div id="reloadtraffic"></div>
        </div>
    </div>

</div>
<script>
    setInterval("reloadtraffic();",1000);
    function reloadtraffic() {
       var interface = $('#interfaces').val();
       console.log(interface);
        $('#reloadtraffic').load('<?=site_url('dashboard/traffic/')?>') + interface;
    }
</script>

