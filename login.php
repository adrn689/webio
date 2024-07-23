<?php
session_start();
include "config/database.php";

$message = "Masukan Username dan Password";

if(isset($_POST['username'])){
  $username = $_POST ['username'];
  $pw = $_POST ['password'];
  $sql = "SELECT * FROM user WHERE username= '$username' LIMIT 1";

  $result = mysqli_query($konek, $sql);

  $datah = mysqli_fetch_assoc($result);
  if(!mysqli_num_rows($result)> 0 ){
      $message = "<b>Username Tidak Terdaftar<b>";

  } else{
    if(password_verify($pw, $datah['password'])){
      echo "<script> location.href='index.php' </script>";
      $_SESSION['username'] = $username;
      $_SESSION['fullname'] = $datah['Full_Name'];
      $_SESSION['role'] = $datah['role'];
    }else{
      $message = "<b>Password salah<b>";
    }
  }

}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>IOT PLATFORM LOGIN</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="../../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <!-- /.login-logo -->
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <a class="h1"><b>IOT</b>PLATFORM</a>
    </div>
    <div class="card-body">
      <p class="login-box-msg"><?php echo $message ?></p>

      <form action="" method="post">
        <div class="input-group mb-3">
          <input type="text" class="form-control" name = "username" placeholder="Username" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" name= " password" placeholder="Password" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block">MASUK</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="../../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>
</body>
</html>
