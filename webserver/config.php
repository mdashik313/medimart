<?php

$servername = "localhost";
$dBUsername = "id20470329_root";
$dBPassword = "YOBkBl$)u%0XS5{K";
$dBName = "id20470329_micro_db";

$conn = mysqli_connect($servername, $dBUsername, $dBPassword, $dBName);


if($conn->connect_error){
    die("Connection failed: ".mysqli_connect_error());
}


?>