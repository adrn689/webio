
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
              <h3><span id="serv">0 </span>°</h3>
              <p class="mt-3 mb-1">Nilai Sudut</p>
            </div>
            <div class="icon">
             <i class="fas fa-ruler-combined"></i>
            </div>
            <a class="small-box-footer">
             <i class="fas fa-ruler-combined"></i>
            </a>
          </div>
        </div>
        <div class="col-lg-6">
          <div class="small-box bg-info">
            <div class="inner">
              <h3><span id="mtr">0</span>V</h3>
              <p class="mt-3 mb-1">Voltage</p>
            </div>
            <div class="icon">
              <i class="fas fa-bolt"></i>
            </div>
            <a class="small-box-footer">
             <i class="fas fa-bolt"></i>
            </a>
          </div>
        </div>
        <div class="col-lg-6">
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
                    <input id="range_5" onchange="pubSRV(this)" type="text" value="">
                  </div>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <div class="col-lg-6">
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
                    <input id="range_6" onchange="pubMTR(this)" type="text"  value="">
                  </div>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <div class="col-lg-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Server Broker MQTT</h3>
                </div>
                <div class="card-body">
                    <div class="row margin">
                    </div>
                    <iframe src="https://madrr.cloud.shiftr.io/embed?widgets=1" width="1350" height="600" frameborder="0" allowfullscreen></iframe>
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
        document.getElementById("suhuu").innerHTML = suhuValue;
        document.getElementById("kelem").innerHTML = keleValue;
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
        client.subscribe("modul/#", { qos: 2 });
    });

    client.on("message", function(topic, payload) {
        if (topic === "modul/pot") {
            document.getElementById("pot").innerHTML = payload;
        } else if (topic === "modul/srv") {
          document.getElementById("serv").innerHTML = payload;
        }else if (topic === "modul/mtr") {
        let hasil = (5 * payload) / 1023;
        document.getElementById("mtr").innerHTML = hasil;
    }
    else if (topic === "modul/ip") {
        document.getElementById("ip").innerHTML = payload;
    }
    });

    
    function pubSRV(value) {
          datas = document.getElementById("range_5").value;
          client.publish("modul/srv", datas, { qos: 1, retain: true });
    }
    function pubMTR(value) {
          datas = document.getElementById("range_6").value;
          client.publish("modul/mtr", datas, { qos: 1, retain: true });
    }
</script>
