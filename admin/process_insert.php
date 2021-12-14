<?php
require_once("../cdb.php");

$cid = $_POST['cid'];
$img_link = $_POST['img_link'];
$title = $_POST['title'];
$original_price = isset($_POST["original_price"]) ? $_POST["original_price"] : "";
$current_price = $_POST['current_price'];
$size = $_POST['size'];
$colors = $_POST['colors'];
$gender = $_POST['gender'];
$description = $_POST['description'];

$sql = "insert into grab_content (cid, img_link, title, original_price, current_price, size,colors, gender, description) values 
('$cid', '$img_link','$title','$original_price','$current_price','$size','$colors','$gender','$description')";

// die($sql);

mysqli_query($conn, $sql);





$location = "window.location = 'index.php'";
echo '<script>alert("Bạn đã thêm sản phẩm thành công!")</script>';
echo"<script>$location</script>";
mysqli_close($conn);
?>