<?php
require_once("../cdb.php");

// Back to home page when data is empty
$location = "window.location = 'index.php'";
//
if(empty($_POST['title'])) {
    echo '<script>alert("❌Cần điền đầy đủ thông tin!")</script>';
    echo"<script>$location</script>";
}

$user_id = $_POST['user_id'];
$category_id = $_POST['category_id'];
$title = $_POST['title'];
$author = $_POST['author'];
$img_link = $_FILES['img_link'];
$pre_view = $_POST['pre_view'];

$folder = '../photos/' ;
$file_extension = explode('.', $img_link['name'])[1];
$file_name = time() . '.' . $file_extension;
$file_path = $folder . $file_name;
move_uploaded_file($img_link["tmp_name"], $file_path);

$sql = "insert into novel (user_id, category_id, title, author, img_link, pre_view) values ('$user_id', '$category_id', '$title', '$author', '$file_name', '$pre_view')";

// die($sql);

mysqli_query($conn, $sql);

echo '<script>alert("Bạn đã thêm truyện thành công!")</script>';
echo"<script>$location</script>";
mysqli_close($conn);
?>