<?php
 ob_start();  //begin buffering the output
?>

<html>

<?php
session_start();
if($_SESSION['username'] == '') {
  header("location:index.html");
}
$mysqli = new mysqli("127.0.0.1", "thullupolls_root", "Surabhiharish", "thullupolls_thullupolls");
$id = $_SESSION['poll_id_stats'];

$sql1 = "SELECT option_name, total_votes FROM Options WHERE poll_id = '$id' GROUP BY option_num";
$result1 = $mysqli->query($sql1);

$sql2 = "SELECT o.option_num, o.option_name, ov.timestamp FROM OptionVoters ov, Options o WHERE (ov.poll_id = '$id' AND o.poll_id = ov.poll_id AND o.option_num = ov.option_num) ORDER BY timestamp";
$result2 = $mysqli->query($sql2);

$sql3 = "SELECT poll_name, question FROM Poll WHERE id = '$id'";
$result3 = $mysqli->query($sql3);

$options = array();
$votes = array();

if($result1->num_rows > 0) {
  while ($row = $result1->fetch_assoc()) {
      array_push($options, $row['option_name']);
      array_push($votes, $row['total_votes']);
  }
}

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
    if ($num == 1) {
      $val1 = $val1 + 1;
    }
    else if ($num == 2) {
      $val2 = $val2 + 1;
    }
    else if ($num == 3) {
      $val3 = $val3 + 1;
    }
    else {
      $val4 = $val4 + 1;
    }
    $data[] = array($t, $val1, $val2, $val3, $val4);
  }
}
else {
  ?> <h2> <?php echo "ahhhhh no values"?> </h2> <?php
}

$poll = $result3->fetch_assoc();

?>
<html>
 <head>
   <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
   <script type="text/javascript">
     google.charts.load('current', {'packages':['corechart']});
     google.charts.setOnLoadCallback(drawChart);

     function drawChart() {
       var data = google.visualization.arrayToDataTable([
        ['Task', 'Hours per Day'],
        ["<?php echo $options[0] ?>", <?php echo $votes[0] ?>],
        ["<?php echo $options[1]?>",  <?php echo $votes[1] ?>],
        ["<?php echo $options[2]?>",  <?php echo $votes[2] ?>],
        ["<?php echo $options[3]?>",  <?php echo $votes[3] ?>]

       ]);

       var options = {
         title: 'Statistics'
       };

       var chart = new google.visualization.PieChart(document.getElementById('piechart'));

       chart.draw(data, options);
     }

   </script>

 </head>
 <body>
   <div id="piechart" style="width: 900px; height: 500px;"></div>
   <div id="chartContainer" style="height: 300px; width: 100%;"></div>
   <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
 </body>
</html>

<html>
  <head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
    google.charts.load('current', {'packages':['line']});
    google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var arr = [];
        var temp_arr  = ['X', '1', '2', '3', '4'];
        //arr.push(temp_arr);

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
        for (var i = 0; i < arr.length; i++) {
          arr[i][0] = new Date(arr[i][0] * 1000);
        }
        //console.log(arr);
        var data = new google.visualization.DataTable();
        data.addColumn('date', 'Date');
        data.addColumn('number', "<?php echo $options[0] ?>");
        data.addColumn('number', "<?php echo $options[1] ?>");
        data.addColumn('number', "<?php echo $options[2] ?>");
        data.addColumn('number', "<?php echo $options[3] ?>");

        data.addRows(arr);
        var options = {
                chart: {
                  title: '<?php echo $poll['question'] ?>'
                },
                width: 900,
                height: 500,
                axes: {
                  x: {
                    0: {side: 'top'}
                  }
                }
              };

              var chart = new google.charts.Line(document.getElementById('line_top_x'));
            chart.draw(data, google.charts.Line.convertOptions(options));
      }
    </script>
  </head>
  <body>
    <div <div id="line_top_x"></div>
  </body>
</html>
