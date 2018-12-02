<?php
 ob_start();  //begin buffering the output
?>

<?php
session_start();
echo $_SESSION['username']
?>

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
      <h1><a href="index.html">Thullu Polls</a></h1>
    </div>
    <nav id="mainav" class="fl_right">
      <ul class="clear">
        <li class="active"><a href="index.html">Home</a></li>
        <li><a class="drop" href="#">Pages</a>
          <ul>
            <li><a href="participate.php">Participate in Polls</a></li>
            <li><a href="view_polls.php">View Your Polls</a></li>
            <li><a href="create.php">Create Polls</a></li>
          </ul>
        </li>
        <li><a href="view_polls.php"><?php echo $_SESSION['username'] ?></a></li>
        <li><a href="index.html" >Logout</a></li>
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
                </address>
                <time datetime="2045-04-06T08:15+00:00">Friday, 6<sup>th</sup> April 2045 @08:15:00</time>
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
