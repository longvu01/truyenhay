<?php
  session_start();
  require_once("../../../connect.php");
  require_once("../../root/check_permission.php");
  // $role = $_SESSION['role'];
  $role = 1;
  require_once("../../root/check_permission_admin.php");
  
  require_once("../../root/decode_ajax.php");

  /// Variables
  $limit = 5;
  $offset = addslashes($decoded['offset']);

  $sql = "select * from categories order by id 
  limit $limit offset $offset";
  $result = mysqli_query($conn, $sql);

  $arr = [];

  $i = 0;
  foreach ($result as $each) {
    $arr[$i]['id'] = (int)$each['id'];
    $arr[$i]['category_name'] = $each['category_name'];
    ++$i;
  }

  echo json_encode($arr);