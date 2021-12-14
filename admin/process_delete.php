<?php
require_once("../cdb.php");

$id = $POST['id'];

$sql = "delete from test_table where id = '$id'";

// die($sql);

mysqli_query($conn, $sql);




// Get id and back to last record from table
$sql = 'SELECT * FROM test_table ORDER BY id DESC LIMIT 1';
$resultLast = mysqli_query($conn, $sql);
$item = mysqli_fetch_array($resultLast);
$id = $item['id'];
$location = "window.location = 'delete.php?id=$id'";
echo '<script>alert("Bạn đã xoá sản phẩm thành công!")</script>';
echo"<script>$location</script>";
mysqli_close($conn);
?>