<?php

include "../config/database.php";

$sql = "INSERT INTO device (Id_device, mcu_type, name_user, active) VALUES('123456', 'esp32','useriot','yes')";

if(mysqli_query($konek, $sql)){
    echo "berhasil ditambah";
}
else{
    echo "gagal ditambah";
}

?>