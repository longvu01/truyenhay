<?php
    session_start();
    require_once("../../cdb.php");

    if(empty($_POST['id'])) {
        header('Location: index.php');
        exit;
    } else if (trim($_POST['category_name']) == '') {
        $_SESSION['info_title'] = "Có lỗi!";
        $_SESSION['info_message'] = "❌Tên thể loại không được để trống!";
        $_SESSION['info_type'] = "error";
        header('Location: index.php');
        exit;
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
    $_SESSION['info_title'] = "Thành công!";
    $_SESSION['info_message'] = "✅Bạn đã sửa thể loại thành công!";
    $_SESSION['info_type'] = "success";
    
    header('Location: index.php');
    mysqli_close($conn);
?>