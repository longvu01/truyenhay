<?php
require_once("../../cdb.php");

$id = addslashes($_POST['id']);

$sql = "delete from novel where id = '$id'";

// die($sql);

mysqli_query($conn, $sql);

// Get id and back to last record from table
$sql = 'SELECT * FROM novel ORDER BY id DESC LIMIT 1';
$resultLast = mysqli_query($conn, $sql);
$item = mysqli_fetch_array($resultLast);
$id = $item['id'];
$location = "window.location = 'search.php'";

echo '<script>alert("Bạn đã xoá truyện thành công!")</script>';
echo"<script>$location</script>";
mysqli_close($conn);
?>