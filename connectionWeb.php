<?php
$servername = "remotemysql.com";
$username = "xMfWTRxQLF";
$password = "st9CO7KUue";
$db = "xMfWTRxQLF";

// Create connection
$koneksi = new mysqli($servername, $username, $password, $db);
if(mysqli_connect_errno()){
    printf ("Gagal terkoneksi : ".mysqli_connect_error());
    exit();
}

?>