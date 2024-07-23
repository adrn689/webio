<?php

include "../config/database.php";

$username = $_GET['Username'];

$sql = "SELECT Full_Name FROM user WHERE Username = '$username'";
$result = mysqli_query($konek,$sql);

while($row = mysqli_fetch_assoc($result)){

    echo $row['Full_Name'];

}

?>