<?php
require_once("../cdb.php");

$id = $_GET['id'];

$sql = "delete from categories where id = '$id'";

// die($sql);

mysqli_query($conn, $sql);

// Get id and back to last record from table
$location = "window.location = 'custom_category.php'";

echo '<script>alert("Bạn đã xoá thể loại thành công!")</script>';
echo"<script>$location</script>";
mysqli_close($conn);
?>