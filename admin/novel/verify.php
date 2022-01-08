<?php
    session_start();
    require_once("../../cdb.php");
    // Kiểm tra quyền, dữ liệu
    require_once("../root/check_permission.php");
    // $role = $_SESSION['role'];
    $role = 1;
    if($role != 1) {
        header('Location: index.php');
        die();
    }
    // Kiểm tra mã hợp lệ
    if(empty($_POST['id']) ) {
        $_SESSION['info_title'] = "Có lỗi!";
        $_SESSION['info_message'] = "❌Cần có mã để duyệt!";
        $_SESSION['info_type'] = "error";

        header('Location: search.php');
        die();
    }
    // ----------------------------------------------------------------
    $id = addslashes($_POST['id']);
    $sql = "update novel set verify = 1 where id = $id";

    mysqli_query($conn, $sql);

    // require_once '../mail.php';
    // // $email = $_SESSION['email'];
    // $email = "lelongvu17@gmail.com";
    // // $name = $_SESSION['name'];
    // $name = "Longg Vũ";
    // $title = "Truyện của bạn đã được duyệt";
    // $content = "Truyện của bạn đã được duyệt, hãy <a href='localhost/truyenhay/admin/chapter/index.php'>quay lại</a> và thêm chương mới nhé";
    // sendMail($email, $name, $title, $content);

    $_SESSION['info_title'] = "Thành công!";
    $_SESSION['info_message'] = "✅Bạn đã duyệt truyện này";
    $_SESSION['info_type'] = "success";

    header('Location: search.php');
    
    mysqli_close($conn);
?>