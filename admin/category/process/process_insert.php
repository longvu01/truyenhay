<?php
  session_start();
  require_once("../../../connect.php");
  require_once("../../root/check_permission.php");
  // $role = $_SESSION['role'];
  $role = 1;
  require_once("../../root/check_permission_admin.php");

  require_once("../../root/decode_ajax.php");

  if (!trim($decoded['category_name'])) {
    $arr['info_title'] = "Có lỗi!";
    $arr['info_message'] = "❌Tên thể loại không được để trống!";
    $arr['info_type'] = "error";
    
    echo json_encode($arr);
    exit;
}
  // ----------------------------------------------------------------
  $category_name = addslashes($decoded['category_name']);

  $sql = "select count(*) from categories where category_name = '$category_name'";
  $result = mysqli_query($conn, $sql);
  $number_rows = mysqli_fetch_array($result)['count(*)'];
  // Nếu đã tồn tại tên thể loại thì thông báo
  if($number_rows == 1) {
      $arr['info_title'] = "Có lỗi!";
      $arr['info_message'] = "Thể loại bạn thêm đã tồn tại!";
      $arr['info_type'] = "error";

      echo json_encode($arr);
      exit;
  }

  $sql = "insert into categories (category_name) values ('$category_name')";
  mysqli_query($conn, $sql);

  $arr['info_title'] = "Thành công!";
  $arr['info_message'] = "Bạn đã thêm thể loại thành công!";
  $arr['info_type'] = "success";

  // Get new ID
  $sql = "select id from categories where category_name = '$category_name'";
  $result = mysqli_query($conn, $sql);
  foreach ($result as $each) $arr['id_insert'] = $each['id'];
  $arr['category_name'] = $category_name;

  echo json_encode($arr);
