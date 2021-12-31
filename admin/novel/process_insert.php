<?php
require_once("../../cdb.php");

// Back to home page when data is empty
$location = "window.location = 'index.php'";
//
if(empty(addslashes($_POST['title']))) {
    echo '<script>alert("❌Cần điền đầy đủ thông tin!")</script>';
    echo"<script>$location</script>";
}

$user_id = addslashes($_POST['user_id']);
$category_id = addslashes($_POST['category_id']);
$author = addslashes($_POST['author']);
$img_link = $_FILES['img_link'];
$pre_view = addslashes($_POST['pre_view']);

$folder = '../../photos/' ;
$file_extension = explode('.', $img_link['name'])[1];
$file_name = time() . '.' . $file_extension;
$file_path = $folder . $file_name;
move_uploaded_file($img_link["tmp_name"], $file_path);

// Kiểm tra tên truyện đã tồn tại trong DB chưa
$title = addslashes($_POST['title']);
$sql = "select count(*) from novel where title = '$title'";
$result = mysqli_query($conn, $sql);
$number_rows = mysqli_fetch_array($result)['count(*)'];
// Nếu đã tồn tại tên truyện thì thông báo và điều hướng quay lại
if($number_rows == 1) {
    echo '<script>alert("Tên truyện này có người đặt rùi!")</script>';
    echo"<script>$location</script>";
    exit;
}


$sql = "insert into novel (user_id, category_id, title, author, img_link, pre_view) values ('$user_id', '$category_id', '$title', '$author', '$file_name', '$pre_view')";

// die($sql);

mysqli_query($conn, $sql);
$location = "window.location = '../chapter/index.php'";
echo '<script>alert("Bạn đã thêm truyện thành công!")</script>';
// echo"<script>$location</script>";
mysqli_close($conn);
?>