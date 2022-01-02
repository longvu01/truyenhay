<?php
    require_once("../../cdb.php");
    // Kiểm tra quyền, dữ liệu
    require_once("../root/check_permission.php");
    // $role = $_SESSION['role'];
    $role = 1;
    if($role != 1) {
        echo "<script>window.location = 'index.php' </script>";
        die();
    }
    
    $location = "window.location = 'search.php'";
    if(empty($_POST['chap_id']) ) {
        echo '<script>alert("❌Cần điền đầy đủ thông tin!")</script>';
        echo "<script>$location</script>";
        die();
    }
   // ----------------------------------------------------------------
    $chap_id = addslashes($_POST['chap_id']);
    $sql = "update chapter set verify = 1 where chap_id = $chap_id";

    mysqli_query($conn, $sql);

    // Thông báo và điều hướng quay lại
    echo '<script>alert("Bạn đã duyệt chương thành công ✅")</script>';
    echo"<script>$location</script>";
    mysqli_close($conn);
?>