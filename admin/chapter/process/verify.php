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

    if(empty($_POST['chap_id']) ) {
        $_SESSION['info_title'] = "Có lỗi!";
        $_SESSION['info_message'] = "❌Cần có mã để duyệt!";
        $_SESSION['info_type'] = "error";

        header('Location: ../search.php');
        exit;
    }
   // ----------------------------------------------------------------
    $chap_id = addslashes($_POST['chap_id']);
    $sql = "update chapter set verify = 1 where chap_id = $chap_id";

    mysqli_query($conn, $sql);

    // Thông báo và điều hướng quay lại
    $_SESSION['info_title'] = "Thành công!";
    $_SESSION['info_message'] = "Bạn đã duyệt chương thành công ✅";
    $_SESSION['info_type'] = "success";

    header('Location: ../search.php');

    mysqli_close($conn);
?>