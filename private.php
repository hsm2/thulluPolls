<?php
 ob_start();  //begin buffering the output
?>

<?php
session_start();
echo $_SESSION['username']
?>


<?php
$mysqli = new mysqli("127.0.0.1", "thullupolls_root", "Surabhiharish", "thullupolls_thullupolls");

if($_SERVER['REQUEST_METHOD'] == 'POST'){
  if (isset($_POST['view_stats'])) {
    $_SESSION['poll_id_stats'] = $mysqli->real_escape_string($_POST['id']);
    header("location:stats.php");
    ob_flush();
  }

  else if (isset($_POST['comment'])) {
    echo "hello";
    $_SESSION['flag'] = TRUE;
    $poll_id = $mysqli->real_escape_string($_POST['id']);
    $comment_id = uniqid();
    $user = $_SESSION['username'];
    $comment_text = $mysqli->real_escape_string($_POST['comments']);
    $_POST['comments'] = '';
    $s = "INSERT INTO Comments (id, poll_id, user_id, comment_text)". "VALUES ('$comment_id', '$poll_id', '$user', '$comment_text')";
    if(($mysqli->query($s) === true)){
          // echo "`hello`";
    }
  }

  else if (isset($_POST['vote'])){
    $number = $_POST['number'];
    $poll_id = $_POST['id'];
    $user = $_SESSION['username'];

    $insert_vote = "INSERT INTO OptionVoters (poll_id, option_num, user_id)" . "VALUES ('$poll_id', '$number', '$user')";;
    if(($mysqli->query($insert_vote) === true)) {
      //echo "inserted";
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

}

$mysqli->close();
?>

<html lang="">
<head>
<title>Thullu Polls | Pages | Participate</title>
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
    <!-- ################################################################################################ -->
    <!-- ################################################################################################ -->
    <div class="content three_quarter">
      <!-- ################################################################################################ -->
      <img class="imgr borderedbox inspace-5" src="../images/demo/imgr.gif" alt="">


      <!-- ################################################################################################ -->
      <?php
      $_SESSION['message'] = '';
      $mysqli = new mysqli("127.0.0.1", "thullupolls_root", "Surabhiharish", "thullupolls_thullupolls");

      $id = $_SESSION['private_poll_id'];
      $sql = "SELECT * FROM Poll WHERE id = '$id'";
      $result = $mysqli->query($sql);
      $result = $mysqli->query($sql);

      ?>
      <!-- ################################################################################################ -->
      <div id="comments">
        <h2>Private Poll</h2>
        <ul>
      <?php

      if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
          ?>
          <li>
            <article>
              <header>
                <figure class="avatar"><img src="../images/demo/avatar.png" alt=""></figure>
                <address>
                <font size="3"> <?php echo $row['poll_name']?> : <?php echo $row['question'] ?> </font> <br><a href="">This poll has: <b><?php echo $row['total_likes'] ?> </b>likes and <b><?php echo $row['total_votes'] ?> </b> votes</a>
                </address>
              </header>
              <div class="comcont">
                <p><b>Options:</b><br></p>
                  <?php
                      $id = $row['id'];
                      $sq = "SELECT * FROM Options WHERE poll_id = '$id'";
                      $result1 = $mysqli->query($sq);
                      if($result1->num_rows > 0) {
                        while($row1 = $result1->fetch_assoc()) {
                          ?> <p> <?php echo $row1['option_num']?> : <?php echo$row1['option_name'] ?> </p> <?php
                        }
                      }
                      ?>
                      <form  action="#" method="post" enctype="multipart/form-data" autocomplete="off" name="<?php echo $row['id'] ?>" onsubmit="">
                        <div class="alert alert-error"><?= $_SESSION['message'] ?></div>
                        <input type="text" placeholder="Option Number" name="number" required />
                        <input type="checkbox" name="Like" value="like"> Like
                        <div id="container">
                        <input type="submit" value="verify" name="vote" class="btn btn-block btn-primary"/>
                        <input type="hidden" name="id" value= "<?php echo $row['id'] ?>"/>
                      </div>
                      </center>
                        <div class="module"> </div>
                    </form>
                    <p><font size = "3"><b>Comments:</b></font></p>
                    <div class="myBox">
                      <?php
                          $id = $row['id'];
                          $sq = "SELECT user_id, comment_text FROM Comments WHERE poll_id = '$id'";
                          $res = $mysqli->query($sq);
                          if($res->num_rows > 0) {
                            while($row1 = $res->fetch_assoc()) {
                              ?> <p> <b><?php echo $row1['user_id']?></b>  : <?php echo $row1['comment_text'] ?> </p> <?php
                            }
                          }
                          ?>
                      </div>
                      <form class="form" action="#" method="post" enctype="multipart/form-data" autocomplete="off" name="<?php echo $row['id'] ?>" onsubmit="">
                        <div class="alert alert-error"><?= $_SESSION['message'] ?></div>
                        <input type="text" placeholder="Comment on this poll" name="comments" required />
                        <input type="submit" value="comment" name="comment"  class="btn" />
                        <input type="hidden" name="id" value= "<?php echo $row['id'] ?>"/>
                      </center>
                        <div class="module"> </div>
                      </form >

                      <form class="form" action="#" method="post" enctype="multipart/form-data" autocomplete="off" name="<?php echo $row['id'] ?>" onsubmit="">
                        <input type="submit" value="View Statistics" name="view_stats"  class="btn" style="font-size:6pt;color:red;background-color:white;border:2px solid #FFFFFF;padding:3px" />
                        <input type="hidden" name="id" value= "<?php echo $row['id'] ?>"/>
                      </form>

              </div>
            </article>
          </li>

        <?php
      }
    }
    else {
      echo "0 results";
    }
    $mysqli->close();
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
<!-- JAVASCRIPTS -->
<script src="../layout/scripts/jquery.min.js"></script>
<script src="../layout/scripts/jquery.backtotop.js"></script>
<script src="../layout/scripts/jquery.mobilemenu.js"></script>
</body>
</html>
