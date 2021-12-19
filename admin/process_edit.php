<?php
require_once("../cdb.php");

$id = $_POST['id'];
$cid = $_POST['cid'];
$img_link = $_POST['img_link'];
$title = $_POST['title'];
$original_price = isset($_POST["original_price"]) ? $_POST["original_price"] : "";
$current_price = $_POST['current_price'];
$size = $_POST['size'];
$colors = $_POST['colors'];
$gender = $_POST['gender'];
$description = $_POST['description'];

$sql = "update grab_content set
cid = '$cid',
img_link = '$img_link',
original_price = '$original_price',
current_price = '$current_price',
size = '$size',
colors = '$colors',
gender = '$gender',
description = '$description'
where
id = $id";

// die($sql);

mysqli_query($conn, $sql);


// Get id and back to last record from table
$sql = 'SELECT * FROM grab_content ORDER BY id DESC LIMIT 1';
$resultLast = mysqli_query($conn, $sql);
$item = mysqli_fetch_array($resultLast);
$id = $item['id'];
$location = "window.location = 'edit.php?id=$id'";
echo '<script>alert("Bạn đã sửa thông tin sản phẩm thành công!")</script>';
echo"<script>$location</script>";
mysqli_close($conn);
?>