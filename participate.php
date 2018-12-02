<style>
/* Force scrollbars onto browser window */
body {
margin-bottom: 200%;
}

/* Box styles */
.myBox {
border: none;
padding: 5px;
font: 12px/14px sans-serif;
width: 250px;
height: 100px;
overflow: scroll;
}

/* Scrollbar styles */
::-webkit-scrollbar {
width: 12px;
height: 12px;
}

::-webkit-scrollbar-track {
border: 1px solid yellowgreen;
border-radius: 10px;
}

::-webkit-scrollbar-thumb {
background: yellowgreen;
border-radius: 10px;
}

::-webkit-scrollbar-thumb:hover {
background: #88ba1c;
}
</style>


<?php
 ob_start();  //begin buffering the output
?>

<?php
@session_start();
echo $_SESSION['username']
?>

<?php
$mysqli = new mysqli("127.0.0.1", "thullupolls_root", "Surabhiharish", "thullupolls_thullupolls");

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $poll_id = $_SESSION['poll_id'];
    $id = uniqid();
    $user = $_SESSION['username'];
    $comment_text = $mysqli->real_escape_string($_POST['comment']);
    $_POST['comment'] = '';
    $s = "INSERT INTO Comments (id, poll_id, user_id, comment_text)". "VALUES ('$id', '$poll_id', '$user', '$comment_text')";
    if(($mysqli->query($s) === true)){
          echo "hello";
    }

    $number = $_POST['number'];
    $poll_id = $_SESSION['poll_id'];

    $insert_vote = "INSERT INTO OptionVoters (poll_id, option_num, user_id)" . "VALUES ('$poll_id', '$number', '$user')";;
    if(($mysqli->query($insert_vote) === true)) {
      echo "inserted";
    }

    if ($_POST['Like'] == 'like') {
      $sql7 = "SELECT total_likes FROM Poll WHERE id = '$poll_id'";
      $result2 = $mysqli->query($sql7);
      $likes = 1;
      if($result2->num_rows > 0) {
        while ($row = $result2->fetch_assoc()) {
            $likes = $likes + $row['total_votes'];
        }
      }
      $sql8 = "UPDATE Poll SET total_likes='$likes' WHERE id='$poll_id'";
      $mysqli->query($sql8);
    }

    $sql = "SELECT total_votes FROM Poll WHERE id = '$poll_id'";
    $result1 = $mysqli->query($sql);
    $votes = 1;
    if($result1->num_rows > 0) {
      while ($row = $result1->fetch_assoc()) {
          $votes = $votes + $row['total_votes'];
      }
    }
    else {
      echo "Not a valid option:(";
    }

    $sql1 = "UPDATE Poll SET total_votes='$votes' WHERE id='$poll_id'";
    $mysqli->query($sql1);

    $sql3 = "SELECT total_votes FROM Options WHERE poll_id = '$poll_id' AND option_num = '$number'";
    $result = $mysqli->query($sql3);
    $num = 0;
    if($result1->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $num = $num + $row['total_votes'];
        }
    }
    $num = $num + 1;

    $sql4 = "UPDATE Options SET total_votes='$num' WHERE poll_id = '$poll_id' AND option_num = '$number'";
    $mysqli->query($sql4);
}

$mysqli->close();
?>


<html lang="">
<head>
<title>Thullu Polls</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<link href="layout/styles/layout.css" rel="stylesheet" type="text/css" media="all">
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
        <li><a href="index.html" onclick="<?php session_destroy();?>">Logout</a></li>
      </ul>
    </nav>
    <!-- ################################################################################################ -->
  </header>
</div>
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<div class="wrapper bgded overlay" style="background-image:url('images/Green.html');">
  <div id="pageintro" class="hoc clear">
    <!-- ################################################################################################ -->
    <article>
      <html>
      <head><meta http-equiv="Content-Type" content="text/html; charset=us-ascii">
      	<title></title>
      	<link rel="stylesheet" href="w3.css">
      </head>

      <html>
      	<head>
      	<meta charset="utf-8">
      	<meta http-equiv="X-UA-Compatible" content="IE=edge">
      	<title>Thullu Polls &mdash; Share Your Opinions</title>
      	<meta name="viewport" content="width=device-width, initial-scale=1">
      	<meta name="description" content="Free HTML5 Website Template by gettemplates.co" />
      	<meta name="keywords" content="free website templates, free html5, free template, free bootstrap, free website template, html5, css3, mobile first, responsive" />
      	<meta name="author" content="gettemplates.co" />

        	<!-- Facebook and Twitter integration -->
      	<meta property="og:title" content=""/>
      	<meta property="og:image" content=""/>
      	<meta property="og:url" content=""/>
      	<meta property="og:site_name" content=""/>
      	<meta property="og:description" content=""/>
      	<meta name="twitter:title" content="" />
      	<meta name="twitter:image" content="" />
      	<meta name="twitter:url" content="" />
      	<meta name="twitter:card" content="" />

      	<!-- <link href="https://fonts.googleapis.com/css?family=Merriweather:300,400|Montserrat:400,700" rel="stylesheet"> -->

      	<link href="https://fonts.googleapis.com/css?family=Lora" rel="stylesheet">

      	<!-- Animate.css -->
      	<link rel="stylesheet" href="css/animate.css">
      	<!-- Icomoon Icon Fonts-->
      	<link rel="stylesheet" href="css/icomoon.css">
      	<!-- Themify Icons-->
      	<link rel="stylesheet" href="css/themify-icons.css">
      	<!-- Bootstrap  -->
      	<link rel="stylesheet" href="css/bootstrap.css">
      	<!-- Theme style  -->
      	<link rel="stylesheet" href="css/style.css">

      	<!-- Modernizr JS -->
      	<script src="js/modernizr-2.6.2.min.js"></script>
      	<!-- FOR IE9 below -->
      	<!--[if lt IE 9]>
      	<script src="js/respond.min.js"></script>
      	<![endif]-->

      	</head>
      	<body>
          <div class="dtc animate-box">
            <center>
            <h2 class="gradient-text">Public Polls</h2>
            <a class="topnav" href="welcome.php" title="Homepage">Home</a><br>
            <a class="topnav" href="private_id.php" title="Private Polls">Private Polls</a>
          </div>
        </body>


      	<!-- jQuery -->
      	<script src="js/jquery.min.js"></script>
      	<!-- jQuery Easing -->
      	<script src="js/jquery.easing.1.3.js"></script>
      	<!-- Bootstrap -->
      	<script src="js/bootstrap.min.js"></script>
      	<!-- Waypoints -->
      	<script src="js/jquery.waypoints.min.js"></script>

      	<!-- Main -->
      	<script src="js/main.js"></script>

      	</body>
      </html>


      <?php
      $_SESSION['message'] = '';
      $mysqli = new mysqli("127.0.0.1", "thullupolls_root", "Surabhiharish", "thullupolls_thullupolls");

      $owner = $_SESSION['username'];
      $sql = "SELECT * FROM Poll WHERE visibility = 'public' and owner <> '$owner'";
      $result = $mysqli->query($sql);

      ?>
      <div id="gtco-project">
        <div class="container">
          <div class="row row-pb-md">

            <script src="js/jquery.min.js"></script>
          	<!-- jQuery Easing -->
          	<script src="js/jquery.easing.1.3.js"></script>
          	<!-- Bootstrap -->
          	<script src="js/bootstrap.min.js"></script>
          	<!-- Waypoints -->
          	<script src="js/jquery.waypoints.min.js"></script>

          	<!-- Main -->
          	<script src="js/main.js"></script>
      <?php

      if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
          ?>
          <div class="col-md-4 col-sm-4 col-xs-6 fh5co-project animate-box">
              <h3><b><font size = "4"> <?php echo $row['poll_name'] ?> </font></b></h3>
              <h3><b><font size = "4"><?php echo $row['question'] ?></font> </b> </h3>

              <h3><b><font size = "4">Options: </font></b></h3><?php
                  $id = $row['id'];
                  $sq = "SELECT * FROM Options WHERE poll_id = '$id'";
                  $result1 = $mysqli->query($sq);
                  if($result1->num_rows > 0) {
                    while($row1 = $result1->fetch_assoc()) {
                      ?> <h3> <?php echo $row1['option_num']?> : <?php echo$row1['option_name'] ?> </h3> <?php
                    }
                  }
                  ?>

                  <form class="form" action="#" method="post" enctype="multipart/form-data" autocomplete="off" onsubmit="<?php $_SESSION['poll_id'] = $id?>">
                    <div class="alert alert-error"><?= $_SESSION['message'] ?></div>
                    <input type="text" placeholder="Option Number" name="number" required />
                    <input type="checkbox" name="Like" value="like"> Like <br><br><br>
                    <input type="submit" value="verify" name=<?= $id ?> class="btn btn-block btn-primary" onClick = "<?= $_SESSION['comment'] = "no"?>"/>
                  </center>
                    <div class="module"> </div>
                  </form>
                  <h2><font size = "3">Comments:</font></h2>
                  <div class="myBox">
                    <?php
                        $id = $_SESSION['poll_id'];
                        $sq = "SELECT user_id, comment_text FROM Comments WHERE poll_id = '$id'";
                        $res = $mysqli->query($sq);
                        if($res->num_rows > 0) {
                          while($row1 = $res->fetch_assoc()) {
                            ?> <h5> <b><?php echo $row1['user_id']?><b>  : <?php echo $row1['comment_text'] ?> </h5> <?php
                          }
                        }
                        ?>
                    </div>
                    <form class="form" action="#" method="post" enctype="multipart/form-data" autocomplete="off" onsubmit="<?php $_SESSION['poll_id'] = $id?>">
                      <div class="alert alert-error"><?= $_SESSION['message'] ?></div>
                      <input type="text" placeholder="Comment on this poll" name="comment" required />
                      <input type="submit" value="comment" name=<?= $id ?> class="btn"/>
                    </center>
                      <div class="module"> </div>
                    </form>
                  <a class="topnav" href="stats.php" title="Homepage" onClick = "<?php $_SESSION['poll_id_stats'] = $id?>"><font color="red">View Statistics of this poll.</font></a>
                  <?php
              ?>
          </div>
      	<!-- jQuery -->
      	<script src="js/jquery.min.js"></script>
      	<!-- jQuery Easing -->
      	<script src="js/jquery.easing.1.3.js"></script>
      	<!-- Bootstrap -->
      	<script src="js/bootstrap.min.js"></script>
      	<!-- Waypoints -->
      	<script src="js/jquery.waypoints.min.js"></script>

      	<!-- Main -->
      	<script src="js/main.js"></script>
          <?php
        }
      }
      else {
        echo "0 results";
      }
      ?>
      </div>

    </article>
    <!-- ################################################################################################ -->
  </div>
</div>
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<!-- JAVASCRIPTS -->
<script src="layout/scripts/jquery.min.js"></script>
<script src="layout/scripts/jquery.backtotop.js"></script>
<script src="layout/scripts/jquery.mobilemenu.js"></script>
<script src="layout/scripts/jquery.flexslider-min.js"></script>
</body>
</html>
