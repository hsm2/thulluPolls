<?php
 ob_start();  //begin buffering the output
?>

<?php
session_start();
$mysqli = new mysqli("127.0.0.1", "thullupolls_root", "Surabhiharish", "thullupolls_thullupolls");
$id = $_SESSION['poll_id_stats'];

$sql = "SELECT option_name, total_votes FROM Options WHERE poll_id = '$id' GROUP BY option_num";
$result = $mysqli->query($sql);

$options = array();
$votes = array();

if($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
      array_push($options, $row['option_name']);
      array_push($votes, $row['total_votes']);
  }
}

?>
<html>
 <head>
   <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
   <script type="text/javascript">
     google.charts.load('current', {'packages':['corechart']});
     google.charts.setOnLoadCallback(drawChart);

     function drawChart() {

       <?php
       echo $options[0];
       echo $options[1];
       echo $options[2];
       echo $options[3];

       echo $votes[0];
       echo $votes[1];
       echo $votes[2];
       echo $votes[3];

        ?>

       var data = google.visualization.arrayToDataTable([
         ['Task', 'Hours per Day'],
         ['Work',     11],
          ['Eat',      2],
          ['Commute',  2],
          ['Watch TV', 2],
          ['Sleep',    7]
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
 </body>
</html>
