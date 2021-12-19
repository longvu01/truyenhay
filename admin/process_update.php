<?php
require_once("root/cdb.php");
// Get id and back to last record from table when data is empty
if(empty($_POST['id']) ) {
    $sql = 'SELECT * FROM grab_content ORDER BY id DESC LIMIT 1';
    $resultLast = mysqli_query($conn, $sql);
    $item = mysqli_fetch_array($resultLast);
    $id = $item['id'];
    echo '<script>alert("❌Cần điền đầy đủ thông tin!")</script>';
    echo"<script>window.location = 'update.php?id='$id'</script>";
}

$id = $_POST['id'];
$cid = $_POST['cid'];
$img_link_new = $_FILES['img_link_new'];
if($img_link_new['size'] > 0) {
    $folder = 'photos/' ;
    $file_extension = explode('.', $img_link_new['name'])[1];
    $file_name = time() . '.' . $file_extension;
    $file_path = $folder . $file_name;
    move_uploaded_file($img_link_new["tmp_name"], $file_path);
} else {
    $file_name = $_POST['img_link_old'];
}
$title = $_POST['title'];
$original_price = isset($_POST["original_price"]) ? $_POST["original_price"] : "";
$current_price = $_POST['current_price'];
$size = $_POST['size'];
$colors = $_POST['colors'];
$gender = $_POST['gender'];
$description = $_POST['description'];

$sql = "update grab_content set
cid = '$cid',
img_link = '$file_name',
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
$location = "window.location = 'update.php?id=$id'";
echo '<script>alert("✅Bạn đã sửa thông tin sản phẩm thành công!")</script>';
echo"<script>$location</script>";
mysqli_close($conn);
?>