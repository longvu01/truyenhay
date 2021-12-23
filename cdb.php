<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "truyenhay";
    $conn= mysqli_connect($servername, $username, $password, $dbname);
	mysqli_query($conn,"SET NAMES 'utf8'");
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
?>