<?php
    session_start();
    require_once("../root/check_permission.php");

    // $role = $_SESSION['role'];
    $role = 1;
    if($role != 1) {
        header('Location: ../.php');
        exit;
    }
?>

<!-- Start HTML -->
  <?php require_once ('../root/lazy.php'); ?>
  <?php lazy('Thống kê chi tiết') ?>

  <link rel='stylesheet' href='./css/chart_details.css'>
  <script defer src = "../../js/main.js"></script>
  <script defer src="https://code.highcharts.com/highcharts.js"></script>
  <script defer src="https://code.highcharts.com/modules/data.js"></script>
  <script defer src="https://code.highcharts.com/modules/drilldown.js"></script>
  <script defer src="https://code.highcharts.com/modules/exporting.js"></script>
  <script defer src="https://code.highcharts.com/modules/export-data.js"></script>
  <script defer src="https://code.highcharts.com/modules/accessibility.js"></script>
  <script defer src = "../../js/toast_msg.js"></script>
  <script defer src = "./js/get_chapter_count.js"></script>

</head>
<body>
  <div id="toast"></div>
  <?php require_once ('../root/header.php'); ?>
  <?php require_once ('../root/menu.php'); ?>
  <div class="wrapper">
    <div class=" form__process">
        <h1 class= "form__title">Thống kê chương</h1>
    </div>

    <label for="" class="chart__label">
      Chọn số ngày thống kê: 
      <select name="" id="chart__select">
        <option value="7">7</option>
        <option value="30" selected>30</option>
        <option value="60">60</option>
      </select>
    </label>
    
    <figure class="highcharts-figure">
      <div id="container"></div>
    </figure>
  </div>

  <?php require_once ('../root/footer.php')?>
  <?php require_once ('../root/show_toast.php')?>

</body>
</html>