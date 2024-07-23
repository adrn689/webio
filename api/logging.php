<?php
include "../config/database.php";

$webhookResponse = json_decode(file_get_contents('php://input'), true);
$topic = $webhookResponse["topic"];
$payload = $webhookResponse["payload"];

$exploder = explode("/", $topic);
$jenis = $exploder[1];
$name = $exploder[2];

if ($jenis === 'lora') {
    $sql = "INSERT INTO data_lora (value, name, topic_mqtt) VALUES ('$payload', '$name', '$topic')";
} elseif ($jenis === 'mqtt') {
    $sql = "INSERT INTO data_mqtt (value, name, topic_mqtt) VALUES ('$payload', '$name', '$topic')";
}
// Execute the SQL query
if (!mysqli_query($konek, $sql)) {
    // Handle query error
    die("Error executing query: " . mysqli_error($konek));
}

?>