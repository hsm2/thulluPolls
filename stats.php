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

echo $options;
echo "not";

?>
//
// <html>
//   <head>
//     <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
//     <script type="text/javascript" src="require.js">
//       console.log("5");
//       google.charts.load('current', {'packages':['corechart']});
//       google.charts.setOnLoadCallback(drawChart);
//       console.log("8");
//       var mysql = require('mysql');
//
//
//       con.connect(function(err) {
//         if (err) throw err;
//         console.log("Connected!");
//       });
//
//       con.connect(function(err) {
//         if (err) throw err;
//         con.query("SELECT * FROM Options", function (err, result, fields) {
//           if (err) throw err;
//           console.log(result);
//         });
//       });
//
//
//       function drawChart() {
//         var data = google.visualization.arrayToDataTable([
//           ['Task', 'Hours per Day'],
//           ['Work',     11],
//           ['Eat',      2],
//           ['Commute',  2],
//           ['Watch TV', 2],
//           ['Sleep',    7]
//         ]);
//
//         var options = {
//           title: 'My Daily Activities'
//         };
//
//         var chart = new google.visualization.PieChart(document.getElementById('piechart'));
//
//         chart.draw(data, options);
//       }
//     </script>
