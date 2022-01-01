<?php
require_once("../../cdb.php");
// Get id and back to last record from table when data is empty
$location = "window.location = 'search.php'";
if(empty($_POST['chap_id']) ) {
    $sql = 'SELECT * FROM chapter ORDER BY chap_id DESC LIMIT 1';
    $resultLast = mysqli_query($conn, $sql);
    $item = mysqli_fetch_array($resultLast);
    $id = $item['id'];
    echo '<script>alert("❌Cần điền đầy đủ thông tin!")</script>';
    echo"<script>$location</script>";
}

$chap_id = addslashes($_POST['chap_id']);
$sql = "update chapter set verify = 1 where chap_id = $chap_id";

// die($sql);

mysqli_query($conn, $sql);
echo '<script>alert("✅Bạn đã duyệt chương này!")</script>';
echo"<script>$location</script>";
mysqli_close($conn);
?>