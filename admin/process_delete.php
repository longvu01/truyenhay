<?php
require_once("root/cdb.php");

$id = $_POST['id'];

$sql = "delete from grab_content where id = '$id'";

// die($sql);

mysqli_query($conn, $sql);

// Get id and back to last record from table
$sql = 'SELECT * FROM grab_content ORDER BY id DESC LIMIT 1';
$resultLast = mysqli_query($conn, $sql);
$item = mysqli_fetch_array($resultLast);
$id = $item['id'];
$location = "window.location = 'delete.php?id=$id'";


echo '<script>alert("Bạn đã xoá sản phẩm thành công!")</script>';
echo"<script>$location</script>";
mysqli_close($conn);
?>