<?php
require_once("../cdb.php");
// Get id and back to last record from table when data is empty
if(empty($_POST['chap_id']) ) {
    echo '<script>alert("❌Cần điền đầy đủ thông tin!")</script>';
    echo"<script>window.location = 'search_chapter.php'</script>";
}
// die();
$chap_id = $_POST['chap_id'];
$chapter_content = $_POST['chapter_content'];
$novel_title = $_POST['novel_title'];

$sql = "update chapter set
chapter_content = '$chapter_content'
where
chap_id = $chap_id";

// die($sql);

mysqli_query($conn, $sql);
$location = "window.location = 'search_chapter.php?search=$novel_title'";
echo '<script>alert("✅Bạn đã sửa thông tin chương thành công!")</script>';
echo "<script>$location</script>";
mysqli_close($conn);
?>