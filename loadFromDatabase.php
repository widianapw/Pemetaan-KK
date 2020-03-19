<?php
    include "connectionWeb.php";
    $queryGetData = $koneksi->query("SELECT * from tb_coordinate");
    $row = array();
    while ($rowData = mysqli_fetch_array($queryGetData)) {
        $row[] = $rowData;
    }
    print json_encode($row);
?>