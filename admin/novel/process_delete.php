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

    if(empty($_POST['id']) ) {
        echo '<script>alert("❌Yêu cầu không hợp lệ!")</script>';
        echo "<script>window.location = 'index.php'</script>";
        die();
    }
    
    // ----------------------------------------------------------------
    $id = addslashes($_POST['id']);

    // Xóa truyện
    $sql = "delete from novel where id = '$id'";
    mysqli_query($conn, $sql);

    // Xóa chương tương ứng
    $sql = "delete from chapter where novel_id = '$id'";
    mysqli_query($conn, $sql);
    
    // Thông báo và điều hướng quay lại
    echo "<script>alert('Bạn đã xoá truyện và các chương thành công!')</script>";
    echo "<script>window.location = 'search.php'</script>";
    mysqli_close($conn);
?>