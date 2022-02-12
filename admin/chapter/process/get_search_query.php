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

  $i = 0;
  foreach ($result as $each) {
    $arr[$i]['chap_id'] = (int)$each['chap_id'];
    $arr[$i]['novel_id'] = (int)$each['novel_id'];
    $arr[$i]['chap'] = (int)$each['chap'];
    $arr[$i]['chapter_content'] = $each['chapter_content'];
    $arr[$i]['verify'] = (int)$each['verify'];
    $arr[$i]['n_name'] = $each['n_name'];
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