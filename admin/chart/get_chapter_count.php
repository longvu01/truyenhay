<?php
  require_once("../../cdb.php");
  
  $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';

  if ($contentType === "application/json") {
    //Receive the RAW post data.
    $content = trim(file_get_contents("php://input"));
    $decoded = json_decode($content, true);
  }
  $max_date = $decoded['days'];
  
  if($max_date != 7 && $max_date != 30 && $max_date != 60) {
    $max_date = 30;
  }

  $cur_month = date('m');
  $today = date('d');
  if($today < $max_date) {
    // Last month
    $qty_day_last_month = $max_date - $today;
    $last_month = date('m', strtotime(" -1 month"));
    $last_month_date = date('Y-m-d', strtotime(" -1 month"));
    $max_day_of_last_month = (new DateTime($last_month_date))->format('t');
    $start_day_of_last_month = $max_day_of_last_month - $qty_day_last_month;

    $start_day_of_cur_month = 1;
  } else {
    $start_day_of_cur_month = $today - $max_date;
  }

  // Query
  $sql = "SELECT 
  novel.id as 'novel_id', 
  novel.title as 'novel_title', 
  DATE_FORMAT(chapter.create_at, '%e-%m') as 'date',
  count(chap) as 'chap_count'
  from novel 
  join chapter on novel.id = chapter.novel_id
  WHERE DATE(novel.create_at) >= CURDATE() - INTERVAL $max_date DAY
  group by novel.id,
  DATE_FORMAT(chapter.create_at, '%e-%m')";
  
  $result = mysqli_query($conn, $sql);
  // Array 1
  $arr=[];
  foreach ($result as $each) {
    $novel_id = $each['novel_id'];
    if(empty($arr[$novel_id])) {
      $arr[$novel_id] = [
        'name' => $each['novel_title'],
        'y' => (int)$each['chap_count'],
        'drilldown' => (int)$each['novel_id'],
      ];
    } else {
      $arr[$novel_id]['y'] += $each['chap_count'];
    }
  }
  // Array 2
  $arr2=[];
  foreach ($arr as $novel_id => $each) {
    $arr2[$novel_id] = [
      'name' => $each['name'],
      'id' => $novel_id,
    ];
    
    if(isset($start_day_of_last_month)) {
      for($i = $start_day_of_last_month; $i <= $max_day_of_last_month; ++$i) {
        $key = $i . '-' . $last_month;
        $arr2[$novel_id]['data'][$key] = [
          $key,
          0
        ];
      }
    }

    for($i = $start_day_of_cur_month; $i <= $today; ++$i) {
      $key = $i . '-' . $cur_month;
      $arr2[$novel_id]['data'][$key] = [
        $key,
        0
      ];
    }
  }
  
  foreach ($result as $each) {
    $novel_id = $each['novel_id'];
    $key = $each['date'];
    $arr2[$novel_id]['data'][$key] = [
      $key,
      (int)$each['chap_count']
    ];
  }

  $object = json_encode([$arr, $arr2]);

  echo $object;
?>