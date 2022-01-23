<?php
  require_once("../../cdb.php");
  $max_date = $_GET['days'];
    
  if($max_date != 7 && $max_date != 30 && $max_date != 60) {
    $max_date = 30;
  }

  $today = date('d');
  if($today < $max_date) {
    // Last month
    $qty_day_last_month = $max_date - $today;
    $last_month = date('m', strtotime(" -1 month"));
    $last_month_date = date('Y-m-d', strtotime(" -1 month"));
    $max_day_of_last_month = (new DateTime($last_month_date))->format('t');
    $start_day_of_last_month = $max_day_of_last_month - $qty_day_last_month;

    for($i = $start_day_of_last_month; $i <= $max_day_of_last_month; ++$i) {
      $key = $i . '-' . $last_month;
      $arr[$key] = [0,0];
    }
    
    $start_day_of_cur_month = 1;
  } else {
    $start_day_of_cur_month = $today - $max_date;
  }

  // Current month
  $cur_month = date('m');
  for($i = $start_day_of_cur_month; $i <= $today; ++$i) {
    $key = $i . '-' . $cur_month;
    $arr[$key] = [0,0];
  }

  // Query
  // ViewCount
  $sql = "SELECT DATE_FORMAT(create_at, '%e-%m') as 'day',
  count(chap_id) as 'view_count' 
  from chapter 
  WHERE DATE(create_at) >= CURDATE() - INTERVAL $max_date DAY
  group by DATE_FORMAT(create_at, '%e-%m')";

  $resultViewCount = mysqli_query($conn, $sql);

  foreach ($resultViewCount as $each) {
    $arr[$each['day']][0] = (int)$each['view_count'];
  }

  // Verified
  $sql = "SELECT DATE_FORMAT(create_at, '%e-%m') as 'day',
  count(verify) as 'verify' 
  from chapter 
  WHERE DATE(create_at) >= CURDATE() - INTERVAL $max_date DAY
  and verify = 1
  group by DATE_FORMAT(create_at, '%e-%m')";

  $resultVerified = mysqli_query($conn, $sql);

  foreach ($resultVerified as $each) {
    $arr[$each['day']][1] = (int)$each['verify'];
  }
  
  echo json_encode($arr);
?>