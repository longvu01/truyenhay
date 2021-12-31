<?php
require_once("../../cdb.php");
$location = "window.location = 'index.php'";
if(empty($_POST['id']) ) {
    echo '<script>alert("❌Yêu cầu không hợp lệ!")</script>';
    echo"<script>$location</script>";
}

$id = $_POST['id'];
$category_name = $_POST['category_name'];

$sql = "update categories set
category_name = '$category_name'
where
id = $id";

// die($sql);

mysqli_query($conn, $sql);
echo '<script>alert("✅Bạn đã sửa thể loại thành công!")</script>';
echo"<script>$location</script>";
mysqli_close($conn);
?>