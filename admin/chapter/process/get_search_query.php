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
  $cond = "Where novel.title like '%$search%' ";
  if($role != 1) {
    $cond .= "and user_id = '$user_id' ";
  }
  
  // Total records
  $sql_total_records = "select sum(total_chapters) from novel $cond";
  $arr_total = mysqli_query($conn, $sql_total_records);
  $total_result = mysqli_fetch_array($arr_total);
  $total_records = $total_result['sum(total_chapters)'];
  
  // Number records / page
  $total_page = ceil($total_records / $nop);
  if($page > $total_page || $page < 1) $page = 1;
  $offset = $nop * ($page - 1);

  // Final condition
  $cond .= "order by novel.id, chap limit $nop offset $offset";

  // sql select and search
  $sql = "select 
  chapter.*,
  novel.title as n_name
  from chapter 
  join novel on chapter.novel_id = novel.id
  $cond";
  // die($sql);
  
  $result = mysqli_query($conn, $sql);
  
  // foreach ($result as $each) {
    $arr['chap_id'] = array();
    $arr['novel_id'] = array();
    $arr['chap'] = array();
    $arr['chapter_content'] = array();
    $arr['verify'] = array();
    $arr['n_name'] = array();
  // }

  $arr['role'] = $role;
  $arr['user_id'] = $user_id;
  $arr['search'] = $search;
  $arr['total_page'] = $total_page;
  $arr['nop'] = $nop;
  $arr['window'] = $window;

  foreach ($result as $each) {
    array_push($arr['chap_id'], (int)$each['chap_id']);
    array_push($arr['novel_id'], (int)$each['novel_id']);
    array_push($arr['chap'], (int)$each['chap']);
    array_push($arr['chapter_content'], $each['chapter_content']);
    array_push($arr['verify'], (int)$each['verify']);
    array_push($arr['n_name'], $each['n_name']);
  }

  echo json_encode($arr);

?>