<?php
  session_start();
  require_once("../../../connect.php");
  require_once("../../root/check_permission.php");
  
  require_once("../../root/decode_ajax.php");
  
  /// Variables
  $page = addslashes($decoded['page']);
  $search = addslashes($decoded['search']);
  
  $role = $_SESSION['role'];
  $user_id = $_SESSION['id'];
  $nop = $_SESSION['nop'];
  $window = $_SESSION['window'];

  // Condition for each role 
  $cond = "where (novel.title like '%$search%' 
  or novel.author like '%$search%')";
  if($role != 1) {
    $cond .= " and user_id = '$user_id' ";
  } else {
    $cond .= " and verify = 0 ";
  }

  // Total records
  $sql_total_records = "select count(*) from novel $cond";
  $arr_total = mysqli_query($conn, $sql_total_records);
  $total_result = mysqli_fetch_array($arr_total);
  $total_records = $total_result['count(*)'];
  $num_records_novel = $total_records;
  if($role == 1) {
    $sql_total_records_queue = "select count(*) from verify_queue_novel
    where (verify_queue_novel.title like '%$search%' or verify_queue_novel.author like '%$search%')";
    $arr_total_queue = mysqli_query($conn, $sql_total_records_queue);
    $total_result_queue = mysqli_fetch_array($arr_total_queue);
    $total_records += $total_result_queue['count(*)'];
  }
  // Number records / page
  $total_page = ceil($total_records / $nop);
  if($page > $total_page || $page < 1) $page = 1;
  $offset = $nop * ($page - 1);

  // Final condition
  // $cond .= "order by novel.id limit $nop offset $offset";
  $cond .= "order by verify desc limit $nop offset $offset";

  $arr = []; 
  $i = 0;
  
  $sql = "select
  novel.*,
  categories.category_name as c_name
  from novel 
  join categories on novel.category_id = categories.id
  $cond";
  $result = mysqli_query($conn, $sql);
  
  foreach ($result as $each) {
    $arr[$i]['c_name'] = $each['c_name'];
    $arr[$i]['img_link'] = $each['img_link'];
    $arr[$i]['status'] = $each['status'];
    $arr[$i]['pre_view'] = $each['pre_view'];
    $arr[$i]['author'] = $each['author'];
    $arr[$i]['id'] = (int)$each['id'];
    $arr[$i]['title'] = $each['title'];
    $arr[$i]['verify'] = (int)$each['verify'];
    $arr[$i]['total_chapters'] = (int)$each['total_chapters'];
    $arr[$i]['view_count'] = (int)$each['view_count'];
    ++$i;
  }

  $arr2['role'] = $role;
  $arr2['user_id'] = $user_id;
  $arr2['search'] = $search;
  $arr2['total_page'] = $total_page;
  $arr2['nop'] = $nop;
  $arr2['window'] = $window;

  // Nếu đủ 5 bản ghi thì dừng
  if($i == $nop) {
    echo json_encode([$arr, $arr2]);
    exit;
  }
  
  if($role == 1) {
    // Số bản ghi lấy trong queue lần đầu khi hết bản ghi trong novel
    $records_use_first_time = $nop - ($num_records_novel % $nop);
    // Page bắt đầu dùng bản ghi trong queue
    $page_start_use_records = ceil($num_records_novel / $nop);
    if($page > $page_start_use_records) {
      // Nếu là page liền kề thì offset = số bản ghi dùng lần đầu (page trước)
      if($page = $page_start_use_records + 1) {
        $offset = $records_use_first_time;
      } else
      // Tăng dần 5($nop) bản ghi theo từng page
        $offset = $records_use_first_time + (($page - $page_start_use_records - 1) * $nop);
      // Lấy từ đầu trong lần đầu tiên
    } else $offset = 0;

    $sql = "select
    verify_queue_novel.*,
    categories.category_name as c_name
    from verify_queue_novel 
    join categories on verify_queue_novel.category_id = categories.id
    where (verify_queue_novel.title like '%$search%' or verify_queue_novel.author like '%$search%')
    limit $nop offset $offset";
    // die($sql);
    $result = mysqli_query($conn, $sql);

    foreach ($result as $each) {
      $arr[$i]['c_name'] = $each['c_name'];
      $arr[$i]['title'] = $each['title'];
      $arr[$i]['img_link'] = $each['img_link'];
      $arr[$i]['status'] = $each['status'];
      $arr[$i]['total_chapters'] = (int)$each['total_chapters'];
      $arr[$i]['pre_view'] = $each['pre_view'];
      $arr[$i]['author'] = $each['author'];
      $arr[$i]['id'] = (int)$each['novel_id'];
      $arr[$i]['verify'] = (int)$each['verify'];
      ++$i;
      if($i == $nop) {
        echo json_encode([$arr, $arr2]);
        exit;
      }
    }
  }

  echo json_encode([$arr, $arr2]);
?>