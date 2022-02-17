<?php
    session_start();
    require_once("../../../connect.php");
    // Kiểm tra quyền, dữ liệu
    require_once("../../root/check_permission.php");
    $_SESSION['role'] = 1;
    $role = $_SESSION['role'];
    require_once("../../root/check_permission_admin.php");

    if(empty($_POST['chap_id'])) {
        $_SESSION['info_title'] = "Có lỗi!";
        $_SESSION['info_message'] = "❌Cần có mã để duyệt!";
        $_SESSION['info_type'] = "error";

        header('Location: ../search.php');
        exit;
    }

    if(empty($_POST['chapter_content'])) {
            $_SESSION['info_title'] = "Có lỗi!";
            $_SESSION['info_message'] = "❌Bạn cần giữ nguyên dữ liệu của người dùng!";
            $_SESSION['info_type'] = "error";
        
        header('Location: ../search.php');
        exit;
    }
   // ----------------------------------------------------------------
    $chap_id = addslashes($_POST['chap_id']);
    $chapter_content = addslashes($_POST['chapter_content']);
    
    $sql = "update chapter set 
    chapter_content = '$chapter_content',
    verify = 1 
    where chap_id = $chap_id";
    
    mysqli_query($conn, $sql);

    // Xóa trong hàng chờ (nếu có)
    $sql = "delete from verify_queue_chapter where chap_id = '$chap_id'";
    mysqli_query($conn, $sql);

    // Thông báo và điều hướng quay lại
    $_SESSION['info_title'] = "Thành công!";
    $_SESSION['info_message'] = "Bạn đã duyệt chương này ✅";
    $_SESSION['info_type'] = "success";

    header('Location: ../search.php');

    mysqli_close($conn);
?>