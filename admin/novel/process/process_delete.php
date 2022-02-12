<?php
    session_start();
    require_once("../../../connect.php");
    // Kiểm tra quyền, dữ liệu
    require_once("../../root/check_permission.php");
    // $role = $_SESSION['role'];
    $role = 1;
    if($role != 1) {
        header('Location: ../');
        exit;
    }

    if(empty($_POST['id']) ) {
        $_SESSION['info_title'] = "Có lỗi!";
        $_SESSION['info_message'] = "❌Yêu cầu không hợp lệ!";
        $_SESSION['info_type'] = "error";

        header('Location: ../');
        exit;
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
    $_SESSION['info_title'] = "Thành công!";
    $_SESSION['info_message'] = "Bạn đã xoá truyện và các chương thành công!";
    $_SESSION['info_type'] = "success";

    header('Location: ../search.php');

    mysqli_close($conn);
?>