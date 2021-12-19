<?php
require_once("root/cdb.php");

// Back to home page when data is empty
$location = "window.location = 'index.php'";
//
if(empty($_POST['title']) || empty($_POST['cid'])) {
    echo '<script>alert("❌Cần điền đầy đủ thông tin!")</script>';
    echo"<script>$location</script>";
}

$cid = $_POST['cid'];
$img_link = $_FILES['img_link'];
$title = $_POST['title'];
$original_price = isset($_POST["original_price"]) ? $_POST["original_price"] : "";
$current_price = $_POST['current_price'];
$size = $_POST['size'];
$colors = $_POST['colors'];
$gender = $_POST['gender'];
$description = $_POST['description'];


$folder = 'photos/' ;
$file_extension = explode('.', $img_link['name'])[1];
$file_name = time() . '.' . $file_extension;
$file_path = $folder . $file_name;
move_uploaded_file($img_link["tmp_name"], $file_path);


$sql = "insert into grab_content (cid, img_link, title, original_price, current_price, size,colors, gender, description) values 
('$cid', '$file_name','$title','$original_price','$current_price','$size','$colors','$gender','$description')";

// die($sql);

mysqli_query($conn, $sql);


echo '<script>alert("Bạn đã thêm sản phẩm thành công!")</script>';
echo"<script>$location</script>";
mysqli_close($conn);
?>