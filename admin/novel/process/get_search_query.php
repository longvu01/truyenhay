<?php
  session_start();
  require_once("../../../cdb.php");

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

  // foreach ($result as $each) {
    $arr['c_name'] = array();
    $arr['title'] = array();
    $arr['img_link'] = array();
    $arr['status'] = array();
    $arr['total_chapters'] = array();
    $arr['pre_view'] = array();
    $arr['author'] = array();
    $arr['id'] = array();
    $arr['view_count'] = array();
    $arr['verify'] = array();
  // }

  $arr['role'] = $role;
  $arr['user_id'] = $user_id;
  $arr['search'] = $search;
  $arr['total_page'] = $total_page;
  $arr['nop'] = $nop;
  $arr['window'] = $window;

  foreach ($result as $each) {
    array_push($arr['c_name'], $each['c_name']);
    array_push($arr['title'], $each['title']);
    array_push($arr['img_link'], $each['img_link']);
    array_push($arr['status'], $each['status']);
    array_push($arr['total_chapters'], (int)$each['total_chapters']);
    array_push($arr['pre_view'], $each['pre_view']);
    array_push($arr['author'], $each['author']);
    array_push($arr['id'], (int)$each['id']);
    array_push($arr['view_count'], (int)$each['view_count']);
    array_push($arr['verify'], (int)$each['verify']);
  }

  echo json_encode($arr);

?>