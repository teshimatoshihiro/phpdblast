<?php

//ログイン確認
// session_start();
include("functions.php");
// DBに接続する
$pdo = connect_to_db();


// データを取得するクエリを作成
$sql = "SELECT occupation, COUNT(*) AS count FROM users_table GROUP BY occupation";

// クエリを実行してデータを取得
$stmt = $pdo->prepare($sql);
$stmt->execute();
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

// データベース接続を閉じるなどの後処理を追加してください

// var_dump($_POST);
// exit;


// データ変換のための配列を初期化
$labels = [];
$dataPoints = [];

// 取得したデータを変換
foreach ($data as $row) {
  $labels[] = $row['occupation'];
  $dataPoints[] = $row['count'];
}

// データをJSON形式に変換
$chartData = [
  'labels' => $labels,
  'dataPoints' => $dataPoints
];

$jsonChartData = json_encode($chartData);
?>



<!-- ////////////////////////////////////////////////////// -->
<!DOCTYPE html>
<html>
<head>
  <title>職種別グラフ</title>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    /* キャンバスのサイズを指定 */
    #myChart {
      width: 400px;
      height: 400px;
    }
  </style>
</head>
<body>
  <canvas id="myChart">職種別グラフ</canvas>

  <script>
    // PHPから渡されたデータをJavaScriptで取得
    var chartData = <?php echo $jsonChartData; ?>;

    // Chart.jsで円グラフを描画
    var ctx = document.getElementById('myChart').getContext('2d');
    var myChart = new Chart(ctx, {
      type: 'pie',
      data: {
        labels: chartData.labels,
        datasets: [{
          data: chartData.dataPoints,
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






