<?php
require_once("../cdb.php");
// Get id and back to last record from table when data is empty
if(empty($_POST['id']) ) {
    $sql = 'SELECT * FROM novel ORDER BY id DESC LIMIT 1';
    $resultLast = mysqli_query($conn, $sql);
    $item = mysqli_fetch_array($resultLast);
    $id = $item['id'];
    echo '<script>alert("❌Cần điền đầy đủ thông tin!")</script>';
    echo"<script>window.location = 'update.php?id='$id'</script>";
}

$id = $_POST['id'];
$category_id = $_POST['category_id'];
$img_link_new = $_FILES['img_link_new'];
if($img_link_new['size'] > 0) {
    $folder = '../photos/' ;
    $file_extension = explode('.', $img_link_new['name'])[1];
    $file_name = time() . '.' . $file_extension;
    $file_path = $folder . $file_name;
    move_uploaded_file($img_link_new["tmp_name"], $file_path);
} else {
    $file_name = $_POST['img_link_old'];
}

$category_id = $_POST['category_id'];
$title = $_POST['title'];
$status = $_POST['status'];
$pre_view = $_POST['pre_view'];

$sql = "update novel set
category_id = '$category_id',
title = '$title',
status = '$status',
img_link = '$file_name',
pre_view = '$pre_view'
where
id = $id";

// die($sql);

mysqli_query($conn, $sql);
$location = "window.location = 'update.php?id=$id'";
echo '<script>alert("✅Bạn đã sửa thông tin truyện thành công!")</script>';
echo"<script>$location</script>";
mysqli_close($conn);
?>