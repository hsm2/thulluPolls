<?php
 ob_start();  //begin buffering the output
?>

<html>

<?php
session_start();
$mysqli = new mysqli("127.0.0.1", "thullupolls_root", "Surabhiharish", "thullupolls_thullupolls");
$id = $_SESSION['poll_id_stats'];

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

   <script>
   window.onload = function () {
     var data1 = [];
     var data2 = [];
     var data3 = [];
     var data4 = [];
     console.log("<?php echo $data1votes[0] ?>");
     <?php
        for($i = 0; $i < sizeof($data1dates); $i = $i + 1) {
          ?>data1.push(<?php $data1dates[$i]?>, <?php $data1votes[$i]?>);
          data2.push(<?php $data2dates[$i]?>, <?php $data2votes[$i]?>);
          data3.push(<?php $data3dates[$i]?>, <?php $data3votes[$i]?>);
          data4.push(<?php $data4dates[$i]?>, <?php $data4votes[$i]?>);
          console.log("here");
          <?php
        }
     ?>

     console.log(data1);
     console.log(data2);
     console.log(data3);
     console.log(data4);
   var chart = new CanvasJS.Chart("chartContainer", {
   	animationEnabled: true,
   	title:{
   		text: "Daily High Temperature at Different Beaches"
   	},
   	axisX: {
   		valueFormatString: "DD MMM,YY"
   	},
   	axisY: {
   		title: "Total votes",
   		includeZero: true,
   	},
   	legend:{
   		cursor: "pointer",
   		fontSize: 16,
   		itemclick: toggleDataSeries
   	},
   	toolTip:{
   		shared: true
   	},
   	data: [{
   		name: "Myrtle Beach",
   		type: "spline",
   		showInLegend: true,
   		dataPoints: data1,
   	},
   	{
   		name: "Martha Vineyard",
   		type: "spline",
   		showInLegend: true,
   		dataPoints: data2
   	},
    {
   		name: "Martha Vineyard",
   		type: "spline",
   		showInLegend: true,
   		dataPoints: data3
   	},
   	{
   		name: "Nantucket",
   		type: "spline",
   		showInLegend: true,
   		dataPoints: data4
   	}]
   });
   chart.render();

   function toggleDataSeries(e){
   	if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
   		e.dataSeries.visible = false;
   	}
   	else{
   		e.dataSeries.visible = true;
   	}
   	chart.render();
   }

   }
   </script>


 </head>
 <body>
   <div id="piechart" style="width: 900px; height: 500px;"></div>
   <div id="chartContainer" style="height: 300px; width: 100%;"></div>
   <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
 </body>
</html>

<!DOCTYPE HTML>
