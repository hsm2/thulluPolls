<?php
 ob_start();  //begin buffering the output
?>

<html>

<?php
session_start();
$mysqli = new mysqli("127.0.0.1", "thullupolls_root", "Surabhiharish", "thullupolls_thullupolls");
$id = '5c030de095690';

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

$val1 = 0;
$val2 = 0;
$val3 = 0;
$val4 = 0;

$data = array();

if ($result2->num_rows > 0) {
  while ($row = $result2->fetch_assoc()) {
    $t = $row['timestamp'];
    $name = $row['option_name'];
    $num = $row['option_num'];
    $date = new DateTime("@$t");
    $d = $date->format('U = Y-m-d H:i:s');
    if ($num == 1) {
      $val1 = $val1 + 1;
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
      $val2 = $val2 + 1;
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
      $val3 = $val3 + 1;
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
      $val4 = $val4 + 1;
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
    $data[] = array($t, $val1, $val2, $val3, $val4);
    array_push($data1dates, $d);
    array_push($data2dates, $d);
    array_push($data3dates, $d);
    array_push($data4dates, $d);
    $c = $c + 1;
  }
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
        var arr = [];
        var temp_arr  = ['X', '1', '2', '3', '4'];
        arr.push(temp_arr);

        <?php
        for ($a = 0; $a < sizeof($data); $a = $a + 1) {
          ?>
            var temp = [];
          <?php
          for ($b = 0; $b < sizeof($data[0]); $b = $b + 1) {
            ?> temp.push(<?php echo $data[$a][$b]?>);
            <?php
          }
          ?>
          arr.push(temp);
          <?php
        }
        ?>
        for (var i = 1; i < arr.length; i++) {
          arr[i][0] = new Date(arr[i][0] * 1000);
        }

        console.log("hllsdfaso");
        var data = google.visualization.arrayToDataTable(arr);
        console.log("hllo");


        var options = {
        chart: {
          title: 'Stats',
          subtitle: 'in min'
        },
        width: 900,
        height: 500,
        axes: {
          x: {
            0: {side: 'top'}
          }
        }
      };

        var options = {
          title: "Poll Stats",
          legend: {'position' : bottom},
          series: {
            1: { color: '#e2431e' },
            2: { color: '#e7711b' },
            3: { color: '#f1ca3a' },
            4: { color: '#6f9654' },
          }
        };

        var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
        chart.draw(data, google.charts.Line.convertOptions(options));
      }
    </script>
  </head>
  <body>
    <div id="chart_div" style="width: 900px; height: 500px;"></div>
  </body>
</html>=x
