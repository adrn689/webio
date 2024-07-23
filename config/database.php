<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "webiot";

$konek = mysqli_connect($servername,$username,$password,$database);

if(!$konek){

    die("koneksi gagal: ". mysqli_connect_error());

}

//echo "koneksi ok";
?>