<?php
 ob_start();  //begin buffering the output
?>

<?php
session_start();
if($_SESSION['username'] == '') {
  header("location:index.html");
}
echo $_SESSION['username'];
$_SESSION['flag'] = TRUE;
?>

<?php
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


<html lang="">
<head>
<title>Thullu Polls | Pages | Participate | Statistics</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<link href="../layout/styles/layout.css" rel="stylesheet" type="text/css" media="all">
</head>
<body id="top">
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<div class="wrapper row1">
  <header id="header" class="hoc clear">
    <!-- ################################################################################################ -->
    <div id="logo" class="fl_left">
      <h1><a href="welcome.php">Thullu Polls</a></h1>
    </div>
    <nav id="mainav" class="fl_right">
      <ul class="clear">
        <li class="active"><a href="welcome.php">Home</a></li>
        <li><a class="drop" href="#">Pages</a>
          <ul>
            <li><a href="participate.php">Participate in Polls</a></li>
            <li><a href="private_id.php">Participate in Private Polls</a></li>
            <li><a href="view_polls.php">View Your Polls</a></li>
            <li><a href="create.php">Create Polls</a></li>
          </ul>
        </li>
        <li><a href="view_polls.php"><?php echo $_SESSION['username'] ?></a></li>
        <li><a href="logout.php" >Logout</a></li>
      </ul>
    </nav>
    <!-- ################################################################################################ -->
  </header>
</div>
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<div class="wrapper row2">
  <div id="breadcrumb" class="hoc clear">
    <!-- ################################################################################################ -->
    <ul>
      <li><a href="welcome.php">Home</a></li>
      <li><a href="participate.php">Participate</a></li>
    </ul>
    <!-- ################################################################################################ -->
  </div>
</div>
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<div class="wrapper row3">
  <main class="hoc container clear">
    <!-- main body -->
    <!-- ################################################################################################ -->
    <div class="content three_quarter first">
      <!-- ################################################################################################ -->
      <h1>Information on the <b><?php echo $poll['poll_name']?></b> poll: </h1>
      <img class="imgr borderedbox inspace-5" src="../images/demo/imgr.gif" alt="">
      <p>

      </p>
      <div id="comments">
        <h2><?php echo $poll['poll_name'] ?></h2>
        <ul>
          <li>
            <article>
              <header>
                <figure class="avatar"><img src="../images/demo/avatar.png" alt=""></figure>
                <address>
                Pie Chart of Options
                </address>
              </header>
              <div class="comcont">
                <p>
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
                  <body>
                    <div id="piechart" style="width: 300px; height: 200px;"></div>
                    <div id="chartContainer" style="height: 300px; width: 100%;"></div>
                    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
                  </body>
                </p>
              </div>
              <address>
                Line Chart of
              </address>
              <div class="comcont">
                <p>
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
                                width: 300,
                                height: 200,
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

                </p>

            </div>
            </article>
          </li>

        </ul>
      </div>
      <!-- ################################################################################################ -->
    </div>
    <!-- ################################################################################################ -->
    <!-- ################################################################################################ -->
    <div class="sidebar one_quarter">
      <!-- ################################################################################################ -->
      <h6>Lorem ipsum dolor</h6>
      <nav class="sdb_holder">
        <ul>
          <li><a href="#">Navigation - Level 1</a></li>
          <li><a href="#">Navigation - Level 1</a>
            <ul>
              <li><a href="#">Navigation - Level 2</a></li>
              <li><a href="#">Navigation - Level 2</a></li>
            </ul>
          </li>
          <li><a href="#">Navigation - Level 1</a>
            <ul>
              <li><a href="#">Navigation - Level 2</a></li>
              <li><a href="#">Navigation - Level 2</a>
                <ul>
                  <li><a href="#">Navigation - Level 3</a></li>
                  <li><a href="#">Navigation - Level 3</a></li>
                </ul>
              </li>
            </ul>
          </li>
          <li><a href="#">Navigation - Level 1</a></li>
        </ul>
      </nav>
      <div class="sdb_holder">
        <h6>Lorem ipsum dolor</h6>
        <address>
        Full Name<br>
        Address Line 1<br>
        Address Line 2<br>
        Town/City<br>
        Postcode/Zip<br>
        <br>
        Tel: xxxx xxxx xxxxxx<br>
        Email: <a href="#">contact@domain.com</a>
        </address>
      </div>
      <div class="sdb_holder">
        <article>
          <h6>Pie chart of poll options:</h6>
          <p>Nuncsed sed conseque a at quismodo tris mauristibus sed habiturpiscinia sed.</p>
          <ul>
            <li><a href="#">Lorem ipsum dolor sit</a></li>
            <li>Etiam vel sapien et</li>
            <li><a href="#">Etiam vel sapien et</a></li>
          </ul>
          <p>Nuncsed sed conseque a at quismodo tris mauristibus sed habiturpiscinia sed. Condimentumsantincidunt dui mattis magna intesque purus orci augue lor nibh.</p>
          <p class="more"><a href="#">Continue Reading &raquo;</a></p>
        </article>
      </div>
      <!-- ################################################################################################ -->
    </div>
    <!-- ################################################################################################ -->
    <!-- / main body -->
    <div class="clear"></div>
  </main>
</div>
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<a id="backtotop" href="#top"><i class="fa fa-chevron-up"></i></a>
<!-- JAVASCRIPTS -->
<script src="../layout/scripts/jquery.min.js"></script>
<script src="../layout/scripts/jquery.backtotop.js"></script>
<script src="../layout/scripts/jquery.mobilemenu.js"></script>
</body>
</html>
