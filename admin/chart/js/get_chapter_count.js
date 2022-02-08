'use strict';
let chartSelect = document.querySelector('#chart__select');

const callAjax = async function (days) {
  try {
    const url = 'get_chapter_count.php';
    const data = await fetch(url, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify({ days }),
    });

    if (!data.ok) throw new Error(`${data.statusText} (${data.status})`);

    const res = await data.json();

    const arr = Object.values(res[0]);
    const arrDetails = [];
    Object.values(res[1]).forEach(each => {
      each.data = Object.values(each.data);
      arrDetails.push(each);
    });
    // Create the chart
    getChart(arr, arrDetails, days);
  } catch (err) {
    showToast({
      title: 'Có lỗi',
      message: `${err.message}`,
      type: 'error',
    });
    console.log(err);
  }
};

let days = 30;
if (days != 7 || days != 30 || days != 60) {
  days = 30;
}
callAjax(days);

chartSelect.addEventListener('change', function (e) {
  days = +e.target.value;
  if (days !== 7 && days !== 30 && days !== 60) {
    days = 30;
  }
  callAjax(days);
});

function getChart(arr, arrDetails, days) {
  Highcharts.chart('container', {
    chart: {
      type: 'column',
    },
    title: {
      text: `Tổng số chương của những truyện mới được viết ${days} ngày gần đây`,
    },
    accessibility: {
      announceNewData: {
        enabled: true,
      },
    },
    xAxis: {
      type: 'category',
    },
    yAxis: {
      title: {
        text: 'Tổng chương',
      },
    },
    legend: {
      enabled: false,
    },
    plotOptions: {
      series: {
        borderWidth: 0,
        dataLabels: {
          enabled: true,
          format: '{point.y:f}',
        },
      },
    },

    tooltip: {
      headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
      pointFormat:
        '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:f}</b> chương<br/>',
    },

    series: [
      {
        name: 'Truyện',
        colorByPoint: true,
        data: arr,
      },
    ],

    drilldown: {
      series: arrDetails,
    },
  });
}
