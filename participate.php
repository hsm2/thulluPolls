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



<style>
.myBox {
border: none;
padding: 5px;
font: 12px/14px sans-serif;
width: 500px;
height: 100px;
overflow: scroll;
}

</style>

<?php
$mysqli = new mysqli("127.0.0.1", "thullupolls_root", "Surabhiharish", "thullupolls_thullupolls");

$max_q = "SELECT p.poll_name as poll_name, u.name as name, p.total_likes as total_likes FROM Poll p, User u WHERE u.id = p.owner and p.total_likes = (SELECT MAX(total_likes) FROM Poll) AND p.visibility='public'";
$r = $mysqli->query($max_q);
$max_p = $r->fetch_assoc();


$max_pop = "SELECT p.poll_name as poll_name, u.name as name, p.total_votes as total_votes FROM Poll p, User u WHERE u.id = p.owner  and p.total_votes = (SELECT MAX(total_votes) FROM Poll) AND p.visibility='public'";
$r1 = $mysqli->query($max_pop);
$max_pop = $r1->fetch_assoc();


if($_SERVER['REQUEST_METHOD'] == 'POST'){
  if (isset($_POST['view_stats'])) {
    $_SESSION['poll_id_stats'] = $mysqli->real_escape_string($_POST['id']);
    header("location:stats.php");
    ob_flush();
  }

  if (isset($_POST['comment'])) {
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

  if (isset($_POST['vote'])){
    $number = $_POST['number'];
    $user = $_SESSION['username'];
    $poll_id = $_POST['id'];
    $timestamp = time();
    $delete_vote = "DELETE FROM OptionVoters WHERE poll_id = '$poll_id' AND user_id = '$user'";
    $insert_vote = "INSERT INTO OptionVoters (poll_id, option_num, user_id, timestamp)" . "VALUES ('$poll_id', '$number', '$user', $timestamp)";
    $votes = 1;
    $res = $mysqli->query($delete_vote);
    if(($res->affected_rows > 0)) {
      $votes = 0;
    }
    $mysqli->query($insert_vote);

    if ($_POST['Like'] == 'like') {
      $sql8 = "SELECT * FROM Likes WHERE poll_id = '$poll_id' AND user_id = '$user'";
      $res2 = $mysqli->query($sql8);
      if ($res2->num_rows == 0) {
        $sql7 = "SELECT total_likes FROM Poll WHERE id = '$poll_id'";
        $result2 = $mysqli->query($sql7);
        $likes = 1;
        if($result2->num_rows > 0) {
          while ($row = $result2->fetch_assoc()) {
              $likes = $likes + $row['total_likes'];
          }
        }
        $sql8 = "UPDATE Poll SET total_likes='$likes' WHERE id='$poll_id'";
        $mysqli->query($sql8);
        $sql8 = "INSERT INTO Likes (poll_id, user_id)" . "VALUES ('$poll_id', '$user')";
        $mysqli->query($sql8);
      }
    }

    $sql = "SELECT total_votes FROM Poll WHERE id = '$poll_id'";
    $result1 = $mysqli->query($sql);
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
  header("location:participate.php");
  ob_flush();
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
    <div class="sidebar one_quarter first">
      <!-- ################################################################################################ -->
      <h6>The Most Liked Poll of the day is:</h6>
      <p> <b> <?php echo $max_p['poll_name'];?> </b>by <?php echo $max_p['name']?> with a total of <?php echo $max_p['total_likes'];?> likes! </p>
      <div class="sdb_holder">
        <h6>The Most Popular poll of the day is:</h6>
        <p> <p> <b> <?php echo $max_pop['poll_name'];?> </b>by <?php echo $max_pop['name']?> with a total of <?php echo $max_pop['total_votes'];?> votes! </p>

      </div>
      <!-- ################################################################################################ -->
    </div>
    <!-- ################################################################################################ -->
    <!-- ################################################################################################ -->
    <div class="content three_quarter">
      <!-- ################################################################################################ -->
      <img class="imgr borderedbox inspace-5" src="../images/demo/imgr.gif" alt="">


      <!-- ################################################################################################ -->
      <?php
      $_SESSION['message'] = '';
      $mysqli = new mysqli("127.0.0.1", "thullupolls_root", "Surabhiharish", "thullupolls_thullupolls");

      $owner = $_SESSION['username'];
      $sql = "SELECT * FROM Poll WHERE visibility = 'public' ORDER BY total_likes DESC, total_votes DESC";
      $result = $mysqli->query($sql);

      ?>
      <!-- ################################################################################################ -->
      <div id="comments">
        <h2>Public Polls</h2>
        <ul>
      <?php

      if ($result->num_rows > 0) {
        $_SESSION['idarr'] = array();
        $_SESSION['commentarr'] = array();
        $c = 0;
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
                      array_push($_SESSION['idarr'], $id);
                      array_push($_SESSION['commentarr'], "");
                      $sq = "SELECT * FROM Options WHERE poll_id = '$id'";
                      $result1 = $mysqli->query($sq);
                      if($result1->num_rows > 0) {
                        while($row1 = $result1->fetch_assoc()) {
                          ?> <p> <?php echo $row1['option_num']?> : <?php echo$row1['option_name'] ?> </p> <?php
                        }
                      }
                      ?>
                      <form class="form" action="#" method="post" enctype="multipart/form-data" autocomplete="off" name="<?php echo $row['id'] ?>" onsubmit="">
                        <div class="alert alert-error"><?= $_SESSION['message'] ?></div>
                        <input type="text" placeholder="Option Number" name="number" required />
                        Like <input type="checkbox" name="Like" value="like">
                        <input type="submit" value="verify" name="vote" class="btn btn-block btn-primary"/>
                        <input  type="hidden" name="id" value= "<?php echo $row['id'] ?>" />
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
                        <input type="hidden" name="id" value= "<?php echo $row['id'] ?>" />
                      </center>
                        <div class="module"> </div>
                      </form>

                      <form class="form" action="#" method="post" enctype="multipart/form-data" autocomplete="off" name="<?php echo $row['id'] ?>" onsubmit="">
                        <input type="submit" value="View Statistics" name="view_stats"  class="btn" style="font-size:8pt;color:#C8273D;background-color:white;border:2px solid #FFFFFF;padding:3px" />
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
