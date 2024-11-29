<?php
 
 if(!isset($_SESSION['logged'])){
    redirect('Auth');
 }


$dataPoints3 = array();
try {
    // Database connection parameters
    $dsn = "mysql:host=195.35.61.69;dbname=u991923994_fal_db";
    $username = "u991923994_fal";
    $password = '$R3s~qkna+xj';

    // Create a PDO instance
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


    // Prepare and execute a SELECT query
    $query = "SELECT *, COUNT(ulog.domain_name) as ulog_count FROM tbl_userlog as ulog GROUP BY domain_name ORDER BY ulog_count DESC LIMIT 10";
    $statement = $pdo->prepare($query);
    $statement->execute();

    // Fetch all rows as associative arrays
    $rows = $statement->fetchAll(PDO::FETCH_ASSOC);

    for ($i = 0; $i < count($rows); $i++) {
        $row = $rows[$i];
        array_push($dataPoints3, array("y" => $row['ulog_count'], "label" => $row['domain_name'] ));
    }


} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
} finally {
    // Close the database connection
    $pdo = null;
}
 
?>

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
                            <h3><?= $totalhotspotuser; ?></h3>

                            <p>Registered Student</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                        <a href="<?= site_url('/hotspot/users')?>" class="small-box-footer">More info <i
                                class="fas fa-arrow-circle-right"></i></a>
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
                        <a href="<?= site_url('/hotspot/active')?>" class="small-box-footer">More info <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <?php
// Query to get the total traffic for the current week
$weeklyQuery = "SELECT SUM(bytes_out) as weeklyTraffic 
                FROM tbl_active_ip 
                WHERE YEARWEEK(datetime_conn, 1) = YEARWEEK(CURDATE(), 1)";
$weeklyResult = $this->db->query($weeklyQuery);
$weeklyTraffic = $weeklyResult->row()->weeklyTraffic;

// Query to get the total traffic for the current month
$monthlyQuery = "SELECT SUM(bytes_out) as monthlyTraffic 
                 FROM tbl_active_ip 
                 WHERE MONTH(datetime_conn) = MONTH(CURDATE()) 
                 AND YEAR(datetime_conn) = YEAR(CURDATE())";
$monthlyResult = $this->db->query($monthlyQuery);
$monthlyTraffic = $monthlyResult->row()->monthlyTraffic;
?>

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3><?= formatbytes($weeklyTraffic, 3); ?></h3>
                            <p>Total Week Usage</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-pie-graph"></i>
                        </div>
                        <a href="<?= site_url('/hotspot/active')?>" class="small-box-footer">More info <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3><?= formatbytes($monthlyTraffic, 3); ?></h3>
                            <p>Total Month Usage</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-pie-graph"></i>
                        </div>
                        <a href="<?= site_url('/hotspot/active')?>" class="small-box-footer">More info <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="col-lg-3 col-6">
                    <!-- small box for Total Bytes Out -->
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3><?= formatbytes($totalBytesOut, 3); ?></h3> <!-- Display total Bytes Out -->
                            <p>Total Bytes Out</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-pie-graph"></i>
                        </div>
                        <a href="<?= site_url('/hotspot/active')?>" class="small-box-footer">More info <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- Display weekly and monthly traffic in the dashboard -->

                <!-- ./col -->
            </div>
            <select name="interface" id="interface" hidden>
                <?php foreach ($interface as $interface){?>
                <option value="<?= $interface['name']?>"><?= $interface['name']?> </option>
                <?php }?>

            </select>
            <div id="reloadtraffic"></div>
            <div id="reloadtraffics" hidden></div>
            <div id="chartDownloadSpeed" style="height: 370px; width: 100%;"></div>
            <div id="chartUploadSpeed" style="height: 370px; width: 100%;"></div>
            <div id="chartVisiting" style="height: 370px; width: 100%;"></div>
            <?php
 
            $dataPoints = array();
            array_push($dataPoints, array("x" => 0, "y" => 0));
            
            ?>
            <?php
// Path to the Pi-hole FTL database
define('DB_PATH', '/etc/pihole/pihole-FTL.db');

// Automatically retrieve the local machine's IP address
$localIp = $_SERVER['SERVER_ADDR']; // Get the local machine's IP address

// Connect to the SQLite database
try {
    $pdo = new PDO('sqlite:' . DB_PATH);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    die("Error connecting to the database: " . $e->getMessage());
}

// Query to fetch the top 10 most visited domains by day, excluding the local machine and Google URLs
try {
    $stmt = $pdo->prepare("
        SELECT DATE(timestamp) as visit_date, domain, COUNT(*) as visit_count
        FROM queries
        WHERE client != :local_machine
        AND domain NOT LIKE '%google%'
        GROUP BY visit_date, domain
        ORDER BY visit_date DESC, visit_count DESC
    ");
    $stmt->bindValue(':local_machine', $localIp, PDO::PARAM_STR); // Use the dynamically fetched IP
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    die("Error executing query: " . $e->getMessage());
}

// Function to extract the main domain
function getMainDomain($domain) {
    $parsed = parse_url($domain);
    $host = isset($parsed['host']) ? $parsed['host'] : $domain;

    // Remove the "www." prefix, if it exists
    $host = preg_replace('/^www\./', '', $host);

    // Split by dot and remove the subdomain
    $parts = explode('.', $host);

    // If the domain has more than two parts (i.e., it's a subdomain), take only the last two parts
    if (count($parts) > 2) {
        $host = implode('.', array_slice($parts, -2));
    }

    return $host;
}

// Group results by date and domain, and accumulate visit counts
$dailyDomainCounts = [];
foreach ($results as $row) {
    $mainDomain = getMainDomain($row['domain']);
    $visitDate = $row['visit_date'];

    if (!isset($dailyDomainCounts[$visitDate])) {
        $dailyDomainCounts[$visitDate] = [];
    }

    if (isset($dailyDomainCounts[$visitDate][$mainDomain])) {
        $dailyDomainCounts[$visitDate][$mainDomain] += (int)$row['visit_count'];
    } else {
        $dailyDomainCounts[$visitDate][$mainDomain] = (int)$row['visit_count'];
    }
}

// Prepare data for the chart
$dataPoints = [];
foreach ($dailyDomainCounts as $date => $domains) {
    // For each day, take the top 10 domains
    $sortedDomains = [];
    foreach ($domains as $domain => $count) {
        $sortedDomains[] = ['label' => $domain, 'y' => $count];
    }

    // Sort domains by visit count in descending order
    usort($sortedDomains, function($a, $b) {
        return $b['y'] - $a['y'];
    });

    // Limit to top 10 domains for the day
    $topDomains = array_slice($sortedDomains, 0, 10);

    $dataPoints[] = [
        'date' => $date,
        'domains' => $topDomains
    ];
}

// Prepare data for displaying in the chart (for the latest day)
$latestDay = $dataPoints[0];
?>
            <script>
            window.onload = function() {

                setInterval(function() {
                    reloadtraffic()
                }, 1500);

                function reloadtraffic() {
                    var interface = $('#interfaces').val();
                    console.log(interface);
                    $('#reloadtraffic').load('<?=site_url('dashboard/traffic/')?>') + interface;
                    $('#reloadtraffics').html("RX => " + $('#rx').val() + "<br><br>" + "TX => " + $('#tx').val());
                    updateChart(parseInt($('#tx').val(), 10), parseInt($('#rx').val(), 10));
                };

                var dataPoints = <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>;
                var dataPoints1 = <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>;

                var chart = new CanvasJS.Chart("chartDownloadSpeed", {
                    theme: "light2",
                    title: {
                        text: "Download Internet Speed"
                    },
                    axisX: {
                        title: "Time in millisecond"
                    },
                    axisY: {
                        suffix: " Byte(s)"
                    },
                    data: [{
                        type: "line",
                        yValueFormatString: "#,##0.0#",
                        toolTipContent: "{y} Byte(s)",
                        dataPoints: dataPoints
                    }]
                });
                chart.render();


                var chart3 = new CanvasJS.Chart("chartVisiting", {
                    animationEnabled: true,
                    theme: "light2",
                    title: {
                        text: "Top 10 Most Visited Sites"
                    },
                    axisY: {
                        title: "(per Counting of Visits)"
                    },
                    data: [{
                        type: "column",
                        yValueFormatString: "#,##0.## count",
                        dataPoints: <?php echo json_encode($topDomains, JSON_NUMERIC_CHECK); ?>
                    }]
                });
                chart3.render();


                var chart1 = new CanvasJS.Chart("chartUploadSpeed", {
                    theme: "light2",
                    title: {
                        text: "Upload Internet Speed"
                    },
                    axisX: {
                        title: "Time in millisecond"
                    },
                    axisY: {
                        suffix: " Byte(s)"
                    },
                    data: [{
                        type: "line",
                        yValueFormatString: "#,##0.0#",
                        toolTipContent: "{y} Byte(s)",
                        dataPoints: dataPoints1
                    }]
                });
                chart1.render();

                //var updateInterval = 1500;
                //setInterval(function () { updateChart() }, updateInterval);

                var xValue = dataPoints.length;
                var yValue = dataPoints[dataPoints.length - 1].y;

                function updateChart(tx, rx) {
                    yValue = rx;
                    yValuess = tx;
                    dataPoints.push({
                        x: xValue,
                        y: yValue
                    });
                    dataPoints1.push({
                        x: xValue,
                        y: yValuess
                    });
                    xValue++;
                    chart.render();
                    chart1.render();
                };

            }
            </script>
            <script>
            $(document).ready(function() {
                // Function to update the textarea content
                function updateTextarea() {
                    $.ajax({
                        type: "GET",
                        url: "<?= site_url('Hotspot/update_userlog_realtime'); ?>",
                        success: function(response) {
                            // Update textarea content with the new data
                            $("#userlogs").text($("#userlogs").text() + response);
                            var textarea = document.getElementById('userlogs');
                            textarea.scrollTop = textarea.scrollHeight;
                            //$("#userlogs").text("asdasdas");

                            // Set a timeout for the next update
                            setTimeout(updateTextarea, 2000); // 2000 milliseconds (2 seconds)
                        }
                    });
                }

                // Initial call to start the update process
                updateTextarea();
            });
            </script>
        </div>






    </div>
    <!-- /.card -->
</div>
<!-- /.col -->
</div>
<!-- /.row -->
</div>

</div>