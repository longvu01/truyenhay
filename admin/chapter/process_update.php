<?php
    session_start();
    require_once("../../cdb.php");
    // Kiểm tra quyền, dữ liệu
    require_once("../root/check_permission.php");
    // $role = $_SESSION['role'];
    $role = 0;
    if($role != 0) {
        $_SESSION['info_title'] = "Có lỗi!";
        $_SESSION['info_message'] = "❌Bạn không được sửa chương của người dùng!";
        $_SESSION['info_type'] = "error";

        header('Location: index.php');
        exit;
    }
    
    if(empty($_POST['chap_id']) || empty($_POST['chapter_content'])) {
        $_SESSION['info_title'] = "Có lỗi!";
        $_SESSION['info_message'] = "❌Cần điền đầy đủ thông tin!";
        $_SESSION['info_type'] = "error";

        header('Location: index.php');
        exit;
    }
    // ----------------------------------------------------------------
    $chap_id = addslashes($_POST['chap_id']);
    $chapter_content = addslashes($_POST['chapter_content']);
    $novel_title = addslashes($_POST['novel_title']);

    $sql = "update chapter set
    chapter_content = '$chapter_content',
    verify = 0
    where
    chap_id = $chap_id";

    mysqli_query($conn, $sql);

    // Thông báo và điều hướng quay lại
    $_SESSION['info_title'] = "Thành công!";
    $_SESSION['info_message'] = "✅Bạn đã sửa thông tin chương thành công!";
    $_SESSION['info_type'] = "success";

    header('Location: search.php' . '?search=' . $novel_title);

    mysqli_close($conn);
?>