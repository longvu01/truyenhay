<?php
  session_start();
  require_once("../../../connect.php");

  $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';

  $content = trim(file_get_contents("php://input"));
  $content = trim(file_get_contents("php://input"));
  $decoded = json_decode($content, true);

  /// Variables
  $page = addslashes($decoded['page']);
  $search = addslashes($decoded['search']);

  $role = $_SESSION['role'];
  $user_id = $_SESSION['id'];
  $nop = $_SESSION['nop'];
  $window = $_SESSION['window'];

  // Condition for each role
  $cond = "where (novel.title like '%$search%' 
  or author like '%$search%')";
  if($role != 1) {
    $cond .= "and user_id = '$user_id' ";
  }

  // Total records
  $sql_total_records = "select count(*) from novel $cond";
  $arr_total = mysqli_query($conn, $sql_total_records);
  $total_result = mysqli_fetch_array($arr_total);
  $total_records = $total_result['count(*)'];

  // Number records / page
  $total_page = ceil($total_records / $nop);
  if($page > $total_page || $page < 1) $page = 1;
  $offset = $nop * ($page - 1);

  // Final condition
  $cond .= "order by novel.id limit $nop offset $offset";

  // sql select and search
  $sql = "select
  novel.*,
  categories.category_name as c_name
  from novel 
  join categories on novel.category_id = categories.id
  $cond";
  // die($sql);
  $result = mysqli_query($conn, $sql);

  $i = 0;
  foreach ($result as $each) {
    $arr[$i]['c_name'] = (int)$each['c_name'];
    $arr[$i]['title'] = (int)$each['title'];
    $arr[$i]['img_link'] = (int)$each['img_link'];
    $arr[$i]['status'] = $each['status'];
    $arr[$i]['total_chapters'] = (int)$each['total_chapters'];
    $arr[$i]['pre_view'] = $each['pre_view'];
    $arr[$i]['author'] = $each['author'];
    $arr[$i]['id'] = $each['id'];
    $arr[$i]['view_count'] = $each['view_count'];
    $arr[$i]['verify'] = $each['verify'];
    ++$i;
  }

  $arr2['role'] = $role;
  $arr2['user_id'] = $user_id;
  $arr2['search'] = $search;
  $arr2['total_page'] = $total_page;
  $arr2['nop'] = $nop;
  $arr2['window'] = $window;

  echo json_encode([$arr, $arr2]);
?>