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
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Thống kê chung</title>
  <link rel="stylesheet" href="./css/chart_full.css">
  <link rel="stylesheet" href="../../css/reset1.css">
  <link rel="stylesheet" href="../../css/base1.css">
  <link rel="stylesheet" href="../../css/style1.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,300;0,400;0,700;0,800;0,900;1,500&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <script defer src = "../../js/main.js"></script>
</head>
<body>
  <?php require_once ('../root/header.php'); ?>
  <?php require_once ('../root/menu.php'); ?>
  <div class="wrapper">
    <div class=" form__process">
        <h1 class= "form__title">Thống kê chung</h1>
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

  <?php require_once ('../root/footer.php'); ?>

  <!--  -->
  <script src = "../../js/jquery-3.6.0.min.js"></script>
  <script src="https://code.highcharts.com/highcharts.js"></script>
  <script src="https://code.highcharts.com/modules/series-label.js"></script>
  <script src="https://code.highcharts.com/modules/exporting.js"></script>
  <script src="https://code.highcharts.com/modules/export-data.js"></script>
  <script src="https://code.highcharts.com/modules/accessibility.js"></script>
  <script type="text/javascript">
    $(document).ready(function() {
      let days = 30;
      if(days != 7 || days != 30 || days != 60) {
        days = 30;
      }
      callAjax(days)

      let chartSelect = $('#chart__select');
      chartSelect.change(function() {
        days = (+$(this).val());
        if(days !== 7 && days !== 30 && days !== 60) {
          days = 30;
        }
        callAjax(days)
      });
    })

    function callAjax(days) {
      $.ajax({
        url: 'get_quantity_full.php',
        dataType: 'json',
        data: {days}  
      })
      .done(function(response) {
        const arrX = (Object.keys(response));
        const arrViewCount = (Object.values(response)).map(a=>a[0]);
        const arrVerified = (Object.values(response)).map(a=>a[1]);
        getChart(arrX, arrViewCount, arrVerified, days)
      })
    }

    function getChart(arrX, arrViewCount, arrVerified, days) {
      Highcharts.chart('container', {

      title: {
        text: `Thống kê lượt viết, duyệt truyện trong ${days} ngày gần đây`
      },

      yAxis: {
        title: {
          text: 'Số lượng'
        }
      },

      xAxis: {
        categories: arrX
      },

      legend: {
        layout: 'vertical',
        align: 'right',
        verticalAlign: 'middle'
      },

      plotOptions: {
        series: {
          label: {
            connectorAllowed: false
          },
        }
      },

      series: [{
          name: 'Lượt viết',
          data: arrViewCount
        },
        {
          name: 'Lượt duyệt',
          data: arrVerified
        }
      ],

      responsive: {
        rules: [{
          condition: {
            maxWidth: 500
          },
          chartOptions: {
            legend: {
              layout: 'horizontal',
              align: 'center',
              verticalAlign: 'bottom'
            }
          }
        }]
      }
      });
    }

    
  </script>

</body>
</html>