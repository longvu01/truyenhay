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

// Xử lý upload ảnh
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

$id = addslashes($_POST['id']);
$category_id = addslashes($_POST['category_id']);
$status = addslashes($_POST['status']);
$author = addslashes($_POST['author']);
$pre_view = addslashes($_POST['pre_view']);

// Địa chỉ điều hướng quay lại khi trùng tên truyện hoặc sửa thông tin thành công
$location = "window.location = 'update.php?id=$id'";
$title = addslashes($_POST['title']);
$sql = "select count(*) from novel where title = '$title' and id != '$id'";
$result = mysqli_query($conn, $sql);
$number_rows = mysqli_fetch_array($result)['count(*)'];
// Nếu đã tồn tại tên truyện thì thông báo và điều hướng quay lại
if($number_rows == 1) {
    echo '<script>alert("Tên truyện này có người đặt rùi!")</script>';
    echo"<script>$location</script>";
    exit;
}
//

$sql = "update novel set
category_id = '$category_id',
title = '$title',
status = '$status',
author = '$author',
img_link = '$file_name',
pre_view = '$pre_view'
where
id = $id";

// die($sql);

mysqli_query($conn, $sql);
echo '<script>alert("✅Bạn đã sửa thông tin truyện thành công!")</script>';
echo"<script>$location</script>";
mysqli_close($conn);
?>