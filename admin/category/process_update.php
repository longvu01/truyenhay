<?php
    session_start();
    require_once("../../cdb.php");
    // Kiểm tra quyền, dữ liệu
    require_once("../root/check_permission.php");
    // $role = $_SESSION['role'];
    $role = 1;
    if($role != 1) {
        echo"<script>window.location = '../' </script>";
        die();
    }

    $location = "window.location = 'index.php'";

    if(empty($_POST['id'])) {
        echo "<script>alert('❌Yêu cầu không hợp lệ!')</script>";
        echo "<script>$location</script>";
    }
   // ----------------------------------------------------------------
    $id = addslashes($_POST['id']);
    $category_name = addslashes($_POST['category_name']);

    $sql = "update categories set
    category_name = '$category_name'
    where
    id = $id";

    // die($sql);
    mysqli_query($conn, $sql);

    // Thông báo và điều hướng quay lại
    echo '<script>alert("✅Bạn đã sửa thể loại thành công!")</script>';
    echo"<script>$location</script>";
    mysqli_close($conn);
?>