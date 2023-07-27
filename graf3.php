<?php

include("functions.php");
$pdo = connect_to_db();

// データを取得するクエリを作成
$sql_occupation = "SELECT occupation, COUNT(*) AS count FROM users_table GROUP BY occupation";
$sql_department = "SELECT department, COUNT(*) AS count FROM users_table GROUP BY department";
$sql_residential = "SELECT residential, COUNT(*) AS count FROM users_table GROUP BY residential";

// クエリを実行してデータを取得
$stmt_occupation = $pdo->prepare($sql_occupation);
$stmt_department = $pdo->prepare($sql_department);
$stmt_residential = $pdo->prepare($sql_residential);
$stmt_occupation->execute();
$stmt_department->execute();
$stmt_residential->execute();

$data_occupation = $stmt_occupation->fetchAll(PDO::FETCH_ASSOC);
$data_department = $stmt_department->fetchAll(PDO::FETCH_ASSOC);
$data_residential = $stmt_residential->fetchAll(PDO::FETCH_ASSOC);

// データベース接続を閉じるなどの後処理を追加してください

// データ変換のための配列を初期化
$labels_occupation = [];
$dataPoints_occupation = [];
$labels_department = [];
$dataPoints_department = [];
$labels_residential = [];
$dataPoints_residential = [];

// 取得したデータを変換
foreach ($data_occupation as $row) {
  $labels_occupation[] = $row['occupation'];
  $dataPoints_occupation[] = $row['count'];
}

foreach ($data_department as $row) {
  $labels_department[] = $row['department'];
  $dataPoints_department[] = $row['count'];
}

foreach ($data_residential as $row) {
  $labels_residential[] = $row['residential'];
  $dataPoints_residential[] = $row['count'];
}

// データをJSON形式に変換
$chartData_occupation = [
  'labels' => $labels_occupation,
  'dataPoints' => $dataPoints_occupation
];
$jsonChartData_occupation = json_encode($chartData_occupation);

$chartData_department = [
  'labels' => $labels_department,
  'dataPoints' => $dataPoints_department
];
$jsonChartData_department = json_encode($chartData_department);

$chartData_residential = [
  'labels' => $labels_residential,
  'dataPoints' => $dataPoints_residential
];
$jsonChartData_residential = json_encode($chartData_residential);
?>


<!DOCTYPE html>
<html>
<head>
  <title>職種・部署・居住地別グラフ</title>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    /* グラフコンテナのスタイル */
    .chart-container {
      width: 400px;
      height: 400px;
      display: inline-block;
      margin-right: 20px;
    }
  </style>
</head>
<body>
  <div class="chart-container">
    <canvas id="occupationChart">職種別グラフ</canvas>
  </div>

  <div class="chart-container">
    <canvas id="departmentChart">部署別グラフ</canvas>
  </div>

  <div class="chart-container">
    <canvas id="residentialChart">居住地別グラフ</canvas>
  </div>

  <script>
    // PHPから渡されたデータをJavaScriptで取得
    var chartData_occupation = <?php echo $jsonChartData_occupation; ?>;
    var chartData_department = <?php echo $jsonChartData_department; ?>;
    var chartData_residential = <?php echo $jsonChartData_residential; ?>;

    // Chart.jsでグラフを描画
    var ctx_occupation = document.getElementById('occupationChart').getContext('2d');
    var occupationChart = new Chart(ctx_occupation, {
      type: 'pie',
      data: {
        labels: chartData_occupation.labels,
        datasets: [{
          data: chartData_occupation.dataPoints,
          backgroundColor: [
            'rgba(255, 99, 132, 0.6)',
            'rgba(54, 162, 235, 0.6)',
            'rgba(255, 206, 86, 0.6)',
            'rgba(75, 192, 192, 0.6)',
            'rgba(153, 102, 255, 0.6)',
            'rgba(255, 159, 64, 0.6)'
          ],
          borderColor: [
            'rgba(255, 99, 132, 1)',
            'rgba(54, 162, 235, 1)',
            'rgba(255, 206, 86, 1)',
            'rgba(75, 192, 192, 1)',
            'rgba(153, 102, 255, 1)',
            'rgba(255, 159, 64, 1)'
          ],
          borderWidth: 1
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        legend: {
          position: 'right',
        },
        tooltips: {
          callbacks: {
            label: function(tooltipItem, data) {
              var label = data.labels[tooltipItem.index] || '';

              if (label) {
                label += ': ';
              }
              label += data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index] + '件';
              return label;
            }
          }
        }
      }
    });

    var ctx_department = document.getElementById('departmentChart').getContext('2d');
    var departmentChart = new Chart(ctx_department, {
      type: 'pie',
      data: {
        labels: chartData_department.labels,
        datasets: [{
          data: chartData_department.dataPoints,
          backgroundColor: [
            'rgba(255, 99, 132, 0.6)',
            'rgba(54, 162, 235, 0.6)',
            'rgba(255, 206, 86, 0.6)',
            'rgba(75, 192, 192, 0.6)',
            'rgba(153, 102, 255, 0.6)',
            'rgba(255, 159, 64, 0.6)'
          ],
          borderColor: [
            'rgba(255, 99, 132, 1)',
            'rgba(54, 162, 235, 1)',
            'rgba(255, 206, 86, 1)',
            'rgba(75, 192, 192, 1)',
            'rgba(153, 102, 255, 1)',
            'rgba(255, 159, 64, 1)'
          ],
          borderWidth: 1
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        legend: {
          position: 'right',
        },
        tooltips: {
          callbacks: {
            label: function(tooltipItem, data) {
              var label = data.labels[tooltipItem.index] || '';

              if (label) {
                label += ': ';
              }
              label += data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index] + '件';
              return label;
            }
          }
        }
      }
    });

    var ctx_residential = document.getElementById('residentialChart').getContext('2d');
    var residentialChart = new Chart(ctx_residential, {
      type: 'pie',
      data: {
        labels: chartData_residential.labels,
        datasets: [{
          data: chartData_residential.dataPoints,
          backgroundColor: [
            'rgba(255, 99, 132, 0.6)',
            'rgba(54, 162, 235, 0.6)',
            'rgba(255, 206, 86, 0.6)',
            'rgba(75, 192, 192, 0.6)',
            'rgba(153, 102, 255, 0.6)',
            'rgba(255, 159, 64, 0.6)'
          ],
          borderColor: [
            'rgba(255, 99, 132, 1)',
            'rgba(54, 162, 235, 1)',
            'rgba(255, 206, 86, 1)',
            'rgba(75, 192, 192, 1)',
            'rgba(153, 102, 255, 1)',
            'rgba(255, 159, 64, 1)'
          ],
          borderWidth: 1
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        legend: {
          position: 'right',
        },
        tooltips: {
          callbacks: {
            label: function(tooltipItem, data) {
              var label = data.labels[tooltipItem.index] || '';

              if (label) {
                label += ': ';
              }
              label += data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index] + '件';
              return label;
            }
          }
        }
      }
    });
  </script>
</body>
</html>


<!-- ////////////////////////////////////////////////////// -->
<!-- <!DOCTYPE html>
<html>
<head>
  <title>職種・部署・居住地別グラフ</title>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    /* キャンバスのサイズを指定 */
    .chart-container {
      width: 400px;
      height: 400px;
      margin-bottom: 30px;
    }
  </style>
</head>
<body>
  <div class="chart-container">
    <canvas id="occupationChart">職種別グラフ</canvas>
  </div>

  <div class="chart-container">
    <canvas id="departmentChart">部署別グラフ</canvas>
  </div>

  <div class="chart-container">
    <canvas id="residentialChart">居住地別グラフ</canvas>
  </div>

  <script>
    // PHPから渡されたデータをJavaScriptで取得
    var chartData_occupation = <?php echo $jsonChartData_occupation; ?>;
    var chartData_department = <?php echo $jsonChartData_department; ?>;
    var chartData_residential = <?php echo $jsonChartData_residential; ?>;

    // Chart.jsでグラフを描画
    var ctx_occupation = document.getElementById('occupationChart').getContext('2d');
    var occupationChart = new Chart(ctx_occupation, {
      type: 'pie',
      data: {
        labels: chartData_occupation.labels,
        datasets: [{
          data: chartData_occupation.dataPoints,
          backgroundColor: [
            'rgba(255, 99, 132, 0.6)',
            'rgba(54, 162, 235, 0.6)',
            'rgba(255, 206, 86, 0.6)',
            'rgba(75, 192, 192, 0.6)',
            'rgba(153, 102, 255, 0.6)',
            'rgba(255, 159, 64, 0.6)'
          ],
          borderColor: [
            'rgba(255, 99, 132, 1)',
            'rgba(54, 162, 235, 1)',
            'rgba(255, 206, 86, 1)',
            'rgba(75, 192, 192, 1)',
            'rgba(153, 102, 255, 1)',
            'rgba(255, 159, 64, 1)'
          ],
          borderWidth: 1
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        legend: {
          position: 'right',
        },
        tooltips: {
          callbacks: {
            label: function(tooltipItem, data) {
              var label = data.labels[tooltipItem.index] || '';

              if (label) {
                label += ': ';
              }
              label += data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index] + '件';
              return label;
            }
          }
        }
      }
    });

    var ctx_department = document.getElementById('departmentChart').getContext('2d');
    var departmentChart = new Chart(ctx_department, {
      type: 'pie',
      data: {
        labels: chartData_department.labels,
        datasets: [{
          data: chartData_department.dataPoints,
          backgroundColor: [
            'rgba(255, 99, 132, 0.6)',
            'rgba(54, 162, 235, 0.6)',
            'rgba(255, 206, 86, 0.6)',
            'rgba(75, 192, 192, 0.6)',
            'rgba(153, 102, 255, 0.6)',
            'rgba(255, 159, 64, 0.6)'
          ],
          borderColor: [
            'rgba(255, 99, 132, 1)',
            'rgba(54, 162, 235, 1)',
            'rgba(255, 206, 86, 1)',
            'rgba(75, 192, 192, 1)',
            'rgba(153, 102, 255, 1)',
            'rgba(255, 159, 64, 1)'
          ],
          borderWidth: 1
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        legend: {
          position: 'right',
        },
        tooltips: {
          callbacks: {
            label: function(tooltipItem, data) {
              var label = data.labels[tooltipItem.index] || '';

              if (label) {
                label += ': ';
              }
              label += data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index] + '件';
              return label;
            }
          }
        }
      }
    });

    var ctx_residential = document.getElementById('residentialChart').getContext('2d');
    var residentialChart = new Chart(ctx_residential, {
      type: 'pie',
      data: {
        labels: chartData_residential.labels,
        datasets: [{
          data: chartData_residential.dataPoints,
          backgroundColor: [
            'rgba(255, 99, 132, 0.6)',
            'rgba(54, 162, 235, 0.6)',
            'rgba(255, 206, 86, 0.6)',
            'rgba(75, 192, 192, 0.6)',
            'rgba(153, 102, 255, 0.6)',
            'rgba(255, 159, 64, 0.6)'
          ],
          borderColor: [
            'rgba(255, 99, 132, 1)',
            'rgba(54, 162, 235, 1)',
            'rgba(255, 206, 86, 1)',
            'rgba(75, 192, 192, 1)',
            'rgba(153, 102, 255, 1)',
            'rgba(255, 159, 64, 1)'
          ],
          borderWidth: 1
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        legend: {
          position: 'right',
        },
        tooltips: {
          callbacks: {
            label: function(tooltipItem, data) {
              var label = data.labels[tooltipItem.index] || '';

              if (label) {
                label += ': ';
              }
              label += data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index] + '件';
              return label;
            }
          }
        }
      }
    });
  </script>
</body>
</html> -->
