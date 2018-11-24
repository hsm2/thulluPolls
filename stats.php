<html>
  <head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      var mysql = require('mysql');

      var con = mysql.createConnection({
        host: "127.0.0.1",
        user: "thullupolls_root",
        password: "Surabhiharish",
        database: "thullupolls_thullupolls"
      });

      con.connect(function(err) {
        if (err) throw err;
        console.log("Connected!");
      });

      con.connect(function(err) {
        if (err) throw err;
        con.query("SELECT * FROM Options", function (err, result, fields) {
          if (err) throw err;
          console.log(result);
        });
      });


      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Task', 'Hours per Day'],
          ['Work',     11],
          ['Eat',      2],
          ['Commute',  2],
          ['Watch TV', 2],
          ['Sleep',    7]
        ]);

        var options = {
          title: 'My Daily Activities'
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
