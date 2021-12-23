<?php
require_once("../cdb.php");

$chap_id = $_POST['chap_id'];
$novel_title = $_POST['novel_title'];

// Cập nhật lại tổng số chap trong bảng novel tương ứng với chap_id
$sql = "update novel 
set total_chapters = total_chapters - 1
where id = (select novel_id from chapter where chap_id = '$chap_id')";
// die($sql);
mysqli_query($conn, $sql);

// Xóa chương tương ứng với chap_id
$sql = "delete from chapter where chap_id = '$chap_id'";
// die($sql);
mysqli_query($conn, $sql);

$location = "window.location = 'search_chapter.php?search=$novel_title'";
echo '<script>alert("Bạn đã xoá chương thành công!")</script>';
echo"<script>$location</script>";
mysqli_close($conn);
?>