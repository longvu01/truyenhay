'use strict';
let chartSelect = document.querySelector('#chart__select');
const spinner = document.querySelector('.load-spinner');
////
const toggleRenderSpinner = function () {
  spinner.classList.toggle('hidden');
};

const callAjax = async function (days) {
  try {
    toggleRenderSpinner();

    const url = './process/get_quantity_full.php';
    const data = await fetch(url, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify({ days }),
    });

    if (!data.ok) throw new Error(`${data.statusText} (${data.status})`);

    const res = await data.json();

    toggleRenderSpinner();

    const arrX = Object.keys(res);
    const arrViewCount = Object.values(res).map(a => a[0]);
    const arrVerified = Object.values(res).map(a => a[1]);
    getChart(arrX, arrViewCount, arrVerified, days);
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

function getChart(arrX, arrViewCount, arrVerified, days) {
  Highcharts.chart('container', {
    title: {
      text: `Thống kê lượt viết, duyệt truyện trong ${days} ngày gần đây`,
    },

    yAxis: {
      title: {
        text: 'Số lượng',
      },
    },

    xAxis: {
      categories: arrX,
    },

    legend: {
      layout: 'vertical',
      align: 'right',
      verticalAlign: 'middle',
    },

    plotOptions: {
      series: {
        label: {
          connectorAllowed: false,
        },
      },
    },

    series: [
      {
        name: 'Lượt viết',
        data: arrViewCount,
      },
      {
        name: 'Lượt duyệt',
        data: arrVerified,
      },
    ],

    responsive: {
      rules: [
        {
          condition: {
            maxWidth: 500,
          },
          chartOptions: {
            legend: {
              layout: 'horizontal',
              align: 'center',
              verticalAlign: 'bottom',
            },
          },
        },
      ],
    },
  });
}
