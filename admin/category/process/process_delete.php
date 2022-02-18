<?php
    session_start();
    require_once("../../../connect.php");
    require_once("../../root/check_permission.php");
    // $role = $_SESSION['role'];
    $role = 1;
    require_once("../../root/check_permission_admin.php");

    require_once("../../root/decode_ajax.php");

    if (!trim($decoded['id'])) {
        $arr['info_title'] = "Có lỗi!";
        $arr['info_message'] = "❌Yêu cầu không hợp lệ!";
        $arr['info_type'] = "error";
        
        echo json_encode($arr);
        exit;
    }

    // ----------------------------------------------------------------
    $id = addslashes($decoded['id']);

    $sql = "select count(*) from novel where category_id = '$id'";
    $result = mysqli_query($conn, $sql);
    $number_rows = mysqli_fetch_array($result)['count(*)'];

    if($number_rows > 0) {
        $arr['info_title'] = "Có lỗi!";
        $arr['info_message'] = "Cần xóa hết truyện có thể loại này trước!";
        $arr['info_type'] = "error";

        echo json_encode($arr);
        exit;
    }

    $sql = "delete from categories where id = '$id'";
    mysqli_query($conn, $sql);

    // Thông báo và điều hướng quay lại
    $arr['info_title'] = "Thành công!";
    $arr['info_message'] = "Bạn đã xoá thể loại thành công!";
    $arr['info_type'] = "success";
    $arr['id_delete'] = $id;

    echo json_encode($arr);