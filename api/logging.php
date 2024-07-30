<?php
include "../config/database.php";

$webhookResponse = json_decode(file_get_contents('php://input'), true);
$topic = $webhookResponse["topic"];
$payload = $webhookResponse["payload"];

$exploder = explode("/", $topic);
$jenis = $exploder[1];
$name = $exploder[2];

echo $jenis;
echo $topic;

if ($jenis === 'lora') {
    $sql = "INSERT INTO data_lora (value, name, topic_mqtt) VALUES ('$payload', '$name', '$topic')";
} elseif ($jenis === 'mqtt') {
    $sql = "INSERT INTO data_mqtt (value, name, topic_mqtt) VALUES ('$payload', '$name', '$topic')";
}

if (!mysqli_query($konek, $sql)) {

    die("Error executing query: " . mysqli_error($konek));
}

?>