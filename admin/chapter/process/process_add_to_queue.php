<?php
    session_start();
    require_once("../../../connect.php");
    // Kiểm tra quyền, dữ liệu
    require_once("../../root/check_permission.php");

    $_SESSION['user_id'] = 2;
    $user_id = $_SESSION['user_id'];
    $_SESSION['role'] = 0;
    $role = $_SESSION['role'];

    if($role != 0) {
        $_SESSION['info_title'] = "Có lỗi!";
        $_SESSION['info_message'] = "❌Bạn không được sửa chương của người dùng!";
        $_SESSION['info_type'] = "error";

        header('Location: ../search.php');
        exit;
    }
    
    if(empty($_POST['chap_id']) || empty($_POST['chapter_content'])) {
        $_SESSION['info_title'] = "Có lỗi!";
        $_SESSION['info_message'] = "❌Cần điền đầy đủ thông tin!";
        $_SESSION['info_type'] = "error";

        header('Location: ../search.php');
        exit;
    }
    // ----------------------------------------------------------------
    $chap_id = addslashes($_POST['chap_id']);
    $chap = addslashes($_POST['chap']);
    $novel_id = addslashes($_POST['novel_id']);
    $chapter_content = addslashes($_POST['chapter_content']);
    $novel_title = addslashes($_POST['novel_title']);

    $sql = "insert into verify_queue_chapter 
    (user_id, novel_id, chap, chapter_content, chap_id, verify)
    values 
    ('$user_id', '$novel_id', '$chap', '$chapter_content', '$chap_id', 0)";
    // die($sql);

    mysqli_query($conn, $sql);

    $_SESSION['info_title'] = "Thành công!";
    $_SESSION['info_message'] = "✅Bạn đã sửa thông tin chương thành công! Hãy liên hệ với quản trị viên để được duyệt sớm nhất";
    $_SESSION['info_type'] = "success";

    header('Location: ../search.php' . '?search=' . $novel_title);

    mysqli_close($conn);
?>