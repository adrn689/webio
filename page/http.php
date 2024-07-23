<?php
// Ensure the database connection is established
require "config/database.php";

// Check if connection was successful
if (!$konek) {
    die("Connection failed: " . mysqli_connect_error());
}

// Default values
$suhu = "";
$kelembapan = "";

// Check if 'Name' and 'Value' are present in the URL parameters
if (isset($_GET['Name']) && isset($_GET['Value'])) {
    $nama = $_GET['Name'];
    $value = $_GET['Value'];

    // Insert data into database
    $sql = "INSERT INTO data_http (Nama, Value) VALUES ('$nama', '$value')";

    if (mysqli_query($konek, $sql)) {
        echo "done";
    } else {
        echo "fail";
    }
}

// Get the most recent entry for each sensor type from the database
$suhu_result = mysqli_query($konek, "SELECT Value FROM data_http WHERE Nama='suhu' ORDER BY Time DESC LIMIT 1");
$kelembapan_result = mysqli_query($konek, "SELECT Value FROM data_http WHERE Nama='kelembapan' ORDER BY Time DESC LIMIT 1");

if ($row = mysqli_fetch_assoc($suhu_result)) {
    $suhu = $row['Value'];
}
if ($row = mysqli_fetch_assoc($kelembapan_result)) {
    $kelembapan = $row['Value'];
}

// Get data for charts
$resultpotgraf = mysqli_query($konek, "SELECT Time, Value FROM data_http WHERE Nama='suhu'");
$resultpot1graf = mysqli_query($konek, "SELECT Time, Value FROM data_http WHERE Nama='kelembapan'");
$waktu0 = "'0',";
$data0 = "0";
$waktu1 = "'0',";
$data1 = "0";

while ($row = mysqli_fetch_array($resultpotgraf)) {
    $waktu0 .= "'" . $row['Time'] . "',";
    $data0 .= "," . $row['Value'];
}
while ($row = mysqli_fetch_array($resultpot1graf)) {
    $waktu1 .= "'" . $row['Time'] . "',";
    $data1 .= "," . $row['Value'];
}

// Execute the query to get all data for the table
$sql = "SELECT * FROM data_http";
$result = mysqli_query($konek, $sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        .card-body .d-flex {
            height: 100%;
            align-items: center;
        }
    </style>
</head>
<body>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h3 class="m-0"><b>TEST HTTP</b></h3>
                    </div>
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div><!-- /.content-header -->

        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3><span id="suhu"><?php echo $suhu; ?></span> °C</h3>
                                <p class="mt-3 mb-1">SUHU</p>
                            </div>
                            <div class="icon">
                               <i class="fas fa-thermometer-half"></i>
                            </div>
                            <a class="small-box-footer">
                               <i class="fas fa-thermometer-half"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3><span id="kele"><?php echo $kelembapan; ?></span> %</h3>
                                <p class="mt-3 mb-1">KELEMBAPAN</p>
                            </div>
                            <div class="icon">
                                 <i class="fas fa-tint"></i>
                            </div>
                            <a class="small-box-footer">
                              <i class="fas fa-tint"></i>   
                            </a>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <!-- AREA CHART -->
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Grafik Data Suhu</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="chart">
                                    <canvas id="areaChart1" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <!-- AREA CHART -->
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Grafik Data Kelembapan</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="chart">
                                    <canvas id="areaChart2" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Data Sensor</h3>
                            </div>
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Name</th>
                                            <th>Value</th>
                                            <th>Time</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                                            <tr>
                                                <td><?php echo $row['Number']; ?></td>
                                                <td><?php echo $row['Nama']; ?></td>
                                                <td><?php echo $row['Value']; ?></td>
                                                <td><?php echo $row['Time']; ?></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>No</th>
                                            <th>Name</th>
                                            <th>Value</th>
                                            <th>Time</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div><!-- /.content -->
    </div><!-- /.content-wrapper -->

    <script type="text/javascript">
        var suhuValue = "<?php echo $suhu; ?>";
        var keleValue = "<?php echo $kelembapan; ?>";
        document.getElementById("suhu").innerHTML = suhuValue;
        document.getElementById("kele").innerHTML = keleValue;
    </script>
    <!-- jQuery -->
    <script src="../plugins/jquery/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
    <script>
        $(function () {
            var areaChartCanvas1 = $('#areaChart1').get(0).getContext('2d');
            var areaChartData1 = {
                labels: [<?php echo $waktu0 ?>],
                datasets: [{
                    label: 'Suhu',
                    backgroundColor: 'rgba(255, 204, 0, 0.9)',
                    borderColor: 'rgba(255, 204, 0, 0.5)',
                    pointRadius: false,
                    pointColor: '#3b8bba',
                    pointStrokeColor: 'rgba(60,141,188,1)',
                    pointHighlightFill: '#fff',
                    pointHighlightStroke: 'rgba(60,141,188,1)',
                    data: [<?php echo $data0 ?>]
                }]
            };

            var areaChartOptions = {
                maintainAspectRatio: false,
                responsive: true,
                legend: {
                    display: false
                },
                scales: {
                    xAxes: [{
                        gridLines: {
                            display: false,
                        }
                    }],
                    yAxes: [{
                        gridLines: {
                            display: false,
                        }
                    }]
                }
            };

            new Chart(areaChartCanvas1, {
                type: 'line',
                data: areaChartData1,
                options: areaChartOptions
            });

            var areaChartCanvas2 = $('#areaChart2').get(0).getContext('2d');
            var areaChartData2 = {
                labels: [<?php echo $waktu1 ?>],
                datasets: [{
                    label: 'Kelembapan',
                    backgroundColor: 'rgba(23, 162, 184, 0.9)',
                    borderColor: 'rgba(23, 162, 184, 0.5)',
                    pointRadius: false,
                    pointColor: '#3b8bba',
                    pointStrokeColor: 'rgba(60,141,188,1)',
                    pointHighlightFill: '#fff',
                    pointHighlightStroke: 'rgba(60,141,188,1)',
                    data: [<?php echo $data1 ?>]
                }]
            };

            new Chart(areaChartCanvas2, {
                type: 'line',
                data: areaChartData2,
                options: areaChartOptions
            });
        });
    </script>  
</body>
</html>
