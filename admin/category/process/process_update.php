<?php
    session_start();
    require_once("../../../connect.php");
    require_once("../../root/check_permission.php");
    // $role = $_SESSION['role'];
    $role = 1;
    require_once("../../root/check_permission_admin.php");

    require_once("../../root/decode_ajax.php");

    if(empty($decoded['id'])) {
        $arr['info_title'] = "Có lỗi!";
        $arr['info_message'] = "❌Yêu cầu không hợp lệ!";
        $arr['info_type'] = "error";
        
        echo json_encode($arr);
        exit;
    } else if (!trim($decoded['category_name'])) {
        $arr['info_title'] = "Có lỗi!";
        $arr['info_message'] = "❌Tên thể loại không được để trống!";
        $arr['info_type'] = "error";
        
        echo json_encode($arr);
        exit;
    }
   // ----------------------------------------------------------------
    $id = addslashes($decoded['id']);
    $category_name = addslashes($decoded['category_name']);

    // die($category_name);

    $sql = "update categories set
    category_name = '$category_name'
    where
    id = $id";
    // die($sql);
    mysqli_query($conn, $sql);

    // Thông báo và điều hướng quay lại
    $arr['info_title'] = "Thành công!";
    $arr['info_message'] = "✅Bạn đã sửa thể loại thành công!";
    $arr['info_type'] = "success";

    echo json_encode($arr);