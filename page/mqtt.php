<?php
// Ensure the database connection is established
require "config/database.php";
if (!$konek) {
    die("Connection failed: " . mysqli_connect_error());
}
$suhu = "";
$kelembapan = "";

$suhu_result = mysqli_query($konek, "SELECT value FROM data_mqtt WHERE name='suhu' ORDER BY Time DESC LIMIT 1");
$kelembapan_result = mysqli_query($konek, "SELECT value FROM data_mqtt WHERE name='kelembapan' ORDER BY Time DESC LIMIT 1");
// Execute the query and handle potential errors

if ($row = mysqli_fetch_assoc($suhu_result)) {
  $suhu = $row['value'];
}
if ($row = mysqli_fetch_assoc($kelembapan_result)) {
  $kelembapan = $row['value'];
}

$resultpotgraf = mysqli_query($konek, "SELECT time, value FROM data_mqtt WHERE name='suhu'");
$resultpot1graf = mysqli_query($konek, "SELECT time, value FROM data_mqtt WHERE name='kelembapan'");
$waktu0 = "'0',";
$data0 = "0";
$waktu1 = "'0',";
$data1 = "0";

while ($row = mysqli_fetch_array($resultpotgraf)) {
    $waktu0 .= "'" . $row['time'] . "',";
    $data0 .= "," . $row['value'];
}
while ($row = mysqli_fetch_array($resultpot1graf)) {
    $waktu1 .= "'" . $row['time'] . "',";
    $data1 .= "," . $row['value'];
}


$sql = "SELECT * FROM data_mqtt";
$result = mysqli_query($konek, $sql);

if (!$result) {
    die("Query failed: " . mysqli_error($konek));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
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
          <h3 class="m-0"><b>TESTING MQTT</b></h3>
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
              <h3><span id="suhuu">3 </span>°C</h3>
              <p class="mt-3 mb-1">suhu</p>
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
              <h3><span id="kelem">3</span>%</h3>
              <p class="mt-3 mb-1">Kelembapan</p>
            </div>
            <div class="icon">
                <i class="fas fa-tint"></i>
            </div>
            <a class="small-box-footer">
              <i class="fas fa-tint"></i>
            </a>
          </div>
        </div>
        <div class="col-lg-6">
          <div class="card">
            <div class="card-header bg-olive d-flex justify-content-center">
              <p class="mt-2 mb-1">Testing Digital Ouput</p>
            </div>
            <div class="card-body table-responsive pad bg-teal">
              <div class="d-flex justify-content-center align-items-center" style="height: 100%;">
                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                  <label class="btn bg-olive active" id="lampuonid">
                    <input type="radio" name="options1" onchange="publishled(this)" id="lampuon" autocomplete="off"> 0/LOW
                  </label>
                  <label class="btn bg-olive" id="lampuoffid">
                    <input type="radio" name="options1" onchange="publishled(this)" id="lampuoff" autocomplete="off"> 1/HIGH
                  </label>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-6">
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Testing Analog Ouput</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="row margin">
                </div>
                <div class="row margin">
                  <div class="col-sm-12">
                    <input id="range_5" type="text" name="range_5" value="">
                  </div>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <div class="col-md-6">
          <!-- AREA CHART -->
          <div class="card card-warning">
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
                <canvas id="grafik" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <!-- AREA CHART -->
          <div class="card card-info">
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
                <canvas id="grafik1" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Data Sensor</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Name</th>
                    <th>Value</th>
                    <th>Topic MQTT</th>
                    <th>Time</th>
                  </tr>
                </thead>
                <tbody>
                  <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                      <td><?php echo $row['id']; ?></td>
                      <td><?php echo $row['name']; ?></td>
                      <td><?php echo $row['value']; ?></td>
                      <td><?php echo $row['topic_mqtt']; ?></td>
                      <td><?php echo $row['time']; ?></td>
                    </tr>
                  <?php } ?>
                </tbody>
                <tfoot>
                  <tr>
                    <th>No</th>
                    <th>Name</th>
                    <th>Value</th>
                    <th>Topic MQTT</th>
                    <th>Time</th>
                  </tr>
                </tfoot>
              </table>
            </div>
            <!-- /.card-body -->
          </div>
        </div>
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div><!-- /.content -->
</div><!-- /.content-wrapper -->
<script type="text/javascript">
        var suhuValue = "<?php echo $suhu; ?>";
        var keleValue = "<?php echo $kelembapan; ?>";
        document.getElementById("suhuu").innerHTML = suhuValue;
        document.getElementById("kelem").innerHTML = keleValue;
    </script>

<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
<script>
    const ctx1 = document.getElementById('grafik').getContext('2d');
    const ctx2 = document.getElementById('grafik1').getContext('2d');
                                          
    const chartOptions = {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true
            }
        }
    };

    new Chart(ctx1, {
        type: 'line',
        data: {
            labels: [<?php echo $waktu0 ?>],
            datasets: [{
                label: 'Nilai Suhu',
                backgroundColor: 'rgba(255, 204, 0, 0.9)',
                borderColor: 'rgba(255, 204, 0, 0.5)',
                data: [<?php echo $data0 ?>],
                borderWidth: 3
            }]
        },
        options: chartOptions
    });

    new Chart(ctx2, {
        type: 'line',
        data: {
            labels: [<?php echo $waktu1 ?>],
            datasets: [{
                label: 'Nilai Kelembapan',
                backgroundColor: 'rgba(23, 162, 184, 0.9)',
                borderColor: 'rgba(23, 162, 184, 0.5)',
                data: [<?php echo $data1 ?>],
                borderWidth: 3
            }]
        },
        options: chartOptions
    });
</script>

<script src="https://unpkg.com/mqtt/dist/mqtt.min.js"></script>
<script>
    const clientId = "webiot";
    const host = 'wss://madrr.cloud.shiftr.io:443';

    const options = {
        keepalive: 30,
        clientId: clientId,
        username: "madrr",
        password: "Ks7svcYRmOSgEyTm",
        protocolId: 'MQTT',
        protocolVersion: 4,
        clean: true,
        reconnectPeriod: 1000,
        connectTimeout: 30 * 1000,
    };

    console.log("menghubungkan ke broker");
    const client = mqtt.connect(host, options);

    client.on("connect", () => {
        console.log("terhubung");
        document.getElementById("status").innerHTML = "Online Broker";

        client.subscribe("QWERR/1/#", { qos: 1 });
    });

    client.on("message", function(topic, payload) {
        if (topic === "QWERR/1/pot") {
            document.getElementById("pot").innerHTML = payload;
        } else if (topic === "QWERR/1/led") {
            if (payload == "on") {
                document.getElementById("lampuonid").classList.add("active");
                document.getElementById("lampuoffid").classList.remove("active");
            } else {
                document.getElementById("lampuoffid").classList.add("active");
                document.getElementById("lampuonid").classList.remove("active");
            }
        }
    });

    function publishled(value) {
        let data;
        if (document.getElementById("lampuon").checked) {
            data = "on";
        }
        if (document.getElementById("lampuoff").checked) {
            data = "off";
        }
        client.publish("QWERR/1/led", data, { qos: 1, retain: true });
    }
</script>
