<?php
 ob_start();  //begin buffering the output
?>

<html>

<?php
session_start();
$mysqli = new mysqli("127.0.0.1", "thullupolls_root", "Surabhiharish", "thullupolls_thullupolls");
$id = '5c031b1f9272c';

$sql1 = "SELECT option_name, total_votes FROM Options WHERE poll_id = '$id' GROUP BY option_num";
$result1 = $mysqli->query($sql1);

$sql2 = "SELECT o.option_num, o.option_name, ov.timestamp FROM OptionVoters ov, Options o WHERE (ov.poll_id = '$id' AND o.poll_id = ov.poll_id) ORDER BY timestamp";
$result2 = $mysqli->query($sql2);

$options = array();
$votes = array();

if($result1->num_rows > 0) {
  while ($row = $result1->fetch_assoc()) {
      array_push($options, $row['option_name']);
      array_push($votes, $row['total_votes']);
  }
}

$data1votes = array();
$data1dates = array();
$data2votes = array();
$data2dates = array();
$data3votes = array();
$data3dates = array();
$data4votes = array();
$data4dates = array();
$c = 0;

if ($result2->num_rows > 0) {
  while ($row = $result2->fetch_assoc()) {
    $t = $row['timestamp'];
    $name = $row['option_name'];
    $num = $row['option_num'];
    $date = new DateTime("@$t");
    $d = $date->format('U = Y-m-d H:i:s');
    if ($num == 1) {
      if ($c == 0) {
        array_push($data1votes, 1);
      }
      else {
        array_push($data1votes, $data1votes[$c - 1] + 1);
      }
      array_push($data2votes, $data2votes[$c - 1]);
      array_push($data3votes, $data3votes[$c - 1]);
      array_push($data4votes, $data4votes[$c - 1]);
    }
    else if ($num == 2) {
      if ($c == 0) {
        array_push($data2votes, 1);
      }
      else {
        array_push($data2votes, $data2votes[$c - 1] + 1);
      }
      array_push($data1votes, $data1votes[$c - 1]);
      array_push($data3votes, $data3votes[$c - 1]);
      array_push($data4votes, $data4votes[$c - 1]);
    }
    else if ($num == 3) {
      if ($c == 0) {
        array_push($data3votes, 1);
      }
      else {
        array_push($data3votes, $data3votes[$c - 1] + 1);
      }
      array_push($data1votes, $data1votes[$c - 1]);
      array_push($data2votes, $data2votes[$c - 1]);
      array_push($data4votes, $data4votes[$c - 1]);
    }
    else {
      if ($c == 0) {
        array_push($data4votes, 1);
      }
      else {
        array_push($data4votes, $data4votes[$c - 1] + 1);
      }
      array_push($data1votes, $data1votes[$c - 1]);
      array_push($data2votes, $data2votes[$c - 1]);
      array_push($data3votes, $data3votes[$c - 1]);
    }
    array_push($data1dates, $d);
    array_push($data2dates, $d);
    array_push($data3dates, $d);
    array_push($data4dates, $d);
    ?> <h2> <?php echo $data1dates[0]?> </h2> <?php
    $c = $c + 1;
  }
  ?> <h2> <?php echo "adddkjf"?> </h2> <?php
}
else {
  ?> <h2> <?php echo "ahhhhh no values"?> </h2> <?php
}


?>
<html>
  <head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable
            ([['X', '1', '2', '3', '4', '5', '6'],
              [1, 2, 3, 4, 5, 6, 7],
              [2, 3, 4, 5, 6, 7, 8],
              [3, 4, 5, 6, 7, 8, 9],
              [4, 5, 6, 7, 8, 9, 10],
              [5, 6, 7, 8, 9, 10, 11],
              [6, 7, 8, 9, 10, 11, 12]
        ]);

        var options = {
          legend: 'none',
          series: {
            0: { color: '#e2431e' },
            1: { color: '#e7711b' },
            2: { color: '#f1ca3a' },
            3: { color: '#6f9654' },
            4: { color: '#1c91c0' },
            5: { color: '#43459d' },
          }
        };

        var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
    </script>
  </head>
  <body>
    <div id="chart_div" style="width: 900px; height: 500px;"></div>
  </body>
</html>
