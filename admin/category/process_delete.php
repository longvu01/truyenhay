<?php
    session_start();
    require_once("../../cdb.php");

    // $role = $_SESSION['role'];
    $role = 1;
    if($role != 1) {
        header('Location: index.php');
        die();
    }

    if(empty($_GET['id']) ) {
        $_SESSION['info_title'] = "Có lỗi!";
        $_SESSION['info_message'] = "❌Yêu cầu không hợp lệ!";
        $_SESSION['info_type'] = "error";

        header('Location: index.php');
        die();
    }
    // ----------------------------------------------------------------
    $id = addslashes($_GET['id']);

    $sql = "select count(*) from novel where category_id = '$id'";
    $result = mysqli_query($conn, $sql);
    $number_rows = mysqli_fetch_array($result)['count(*)'];

    if($number_rows > 0) {
        $_SESSION['info_title'] = "Có lỗi!";
        $_SESSION['info_message'] = "Cần xóa hết truyện có thể loại này trước!";
        $_SESSION['info_type'] = "error";

        header('Location: index.php');
        die();
    }

    $sql = "delete from categories where id = '$id'";
    
    mysqli_query($conn, $sql);

    // Thông báo và điều hướng quay lại
    $_SESSION['info_title'] = "Thành công!";
    $_SESSION['info_message'] = "Bạn đã xoá thể loại thành công!";
    $_SESSION['info_type'] = "success";

    header('Location: index.php');

    mysqli_close($conn);
?>