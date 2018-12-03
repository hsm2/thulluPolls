<?php
 ob_start();  //begin buffering the output
?>

<?php
session_start();
if($_SESSION['username'] == '') {
  header("location:index.html");
}
echo $_SESSION['username'];

$mysqli = new mysqli("127.0.0.1", "thullupolls_root", "Surabhiharish", "thullupolls_thullupolls");
?>

<style>
.myBox {
border: none;
font: 14px/14px sans-serif;
width: 500px;
height: 100px;
overflow: scroll;
}

</style>

<html lang="">
<head>
<title>Thullu Polls | Pages | View Polls</title>
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
      <li><a href="view_polls.php">View Your Polls</a></li>
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
    <div class="content">
      <!-- ################################################################################################ -->
      <img class="imgr borderedbox inspace-5" src="../images/demo/imgr.gif" alt="">
      <div id="comments">
        <h2>Your Polls</h2>
        <?php
        $_SESSION['message'] = '';
        $mysqli = new mysqli("127.0.0.1", "thullupolls_root", "Surabhiharish", "thullupolls_thullupolls");

        $owner = $_SESSION['username'];
        $sql = "SELECT * FROM Poll WHERE owner = '$owner'";
        $result = $mysqli->query($sql);

        ?>
        <ul>
          <?php
          if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
              ?>

          <li>
            <article>
              <header>
                </header>
                <figure class="avatar"><img src="../images/demo/avatar.png" alt=""></figure>
                <address>
                  <div class="comcont">
                  <p><b>Poll Name:</b> <?php echo $row['poll_name'] ?> </p>
                  <p><b>Poll Id: </b><?php echo $row['id'] ?> </p>
                  <p><b>Visibility: </b><?php echo $row['visibility'] ?> </p>
                  <p><b>Total Votes: </b><?php echo $row['total_votes'] ?> </p>
                  <p><b>Total Likes: </b><?php echo $row['total_likes'] ?> </p>
                  <p><b>Most Popular Option: </b><?php
                      $id = $row['id'];
                      $sq = "SELECT * FROM Options WHERE poll_id = '$id'";
                      $result1 = $mysqli->query($sq);
                      $max = 0;
                      $option = "hi";
                      if($result1->num_rows > 0) {
                        while($row1 = $result1->fetch_assoc()) {
                          if($row1['total_votes'] >= $max) {
                            $max = $row1['total_votes'];
                            $option = $row1['option_name'];
                          }
                        }
                      }

                  echo $option ?> with <?php echo $max?> total votes.</p>
                  </div>
                  <p   style="margin-block-end: .025em ">List of Users:</p>
                  <div class="myBox">
                  <?php
                  $id = $row['id'];
                  $sq = "SELECT ov.user_id as user_id, u.name as name, o.option_name as option_name FROM OptionVoters ov, User u, Options o WHERE ov.option_num = o.option_num AND ov.poll_id = o.poll_id AND o.poll_id='$id' AND ov.user_id=u.id";
                          $res = $mysqli->query($sq);
                          if ($res->num_rows > 0) {
                            while($row = $res->fetch_assoc()) {
                              ?> <p> <b>(<?php echo $row['user_id']?>)</b>  <?php echo $row['name'] ?> voted for <?php echo $row['option_name']?></p>  <?php
                            }
                          }
                          else {
                            echo "sldkfj";
                          }
                          ?>
                </div>
                </address>

                <?php
                $id = $row['id'];
                $options = array();
                $votes = array();

                if($result1->num_rows > 0) {
                  while ($row = $result1->fetch_assoc()) {
                      array_push($options, $row['option_name']);
                      array_push($votes, $row['total_votes']);
                  }
                }
                ?>

                <address>
                  <article>
                    <header>
                      <figure class="avatar"><img src="../images/demo/avatar.png" alt=""></figure>
                      <address>
                      Pie Chart of Options:
                      </address>
                    </header>
                    <div class="comcont">
                      <p> Hi
                        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
                        <script type="text/javascript">
                          google.charts.load('current', {'packages':['corechart']});
                          google.charts.setOnLoadCallback(drawChart);


                          function drawChart() {
                            echo "hello";
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
                            echo "drew";
                          }

                        </script>
                        <body>
                          <div id="piechart" style="width: 500px; height: 300px;"></div>
                          <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
                        </body>
                      </p>
                    </div>
                  </article>
                </address>
            </article>

          </li>
          <?php
        }
      }
      else {
        echo "0 results";
      }
      ?>
        </ul>
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
<a id="backtotop" href="#top"><i class="fa fa-chevron-up"></i></a>
<!-- JAVASCRIPTS -->
<script src="../layout/scripts/jquery.min.js"></script>
<script src="../layout/scripts/jquery.backtotop.js"></script>
<script src="../layout/scripts/jquery.mobilemenu.js"></script>
</body>
</html>
