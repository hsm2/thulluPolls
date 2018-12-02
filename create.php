<?php
 ob_start();  //begin buffering the output
?>

<?php
session_start();
echo $_SESSION['username']
?>

<?php
$_SESSION['message'] = '';
$mysqli = new mysqli("127.0.0.1", "thullupolls_root", "Surabhiharish", "thullupolls_thullupolls");

if($_SERVER['REQUEST_METHOD'] == 'POST'){
	$pollName = $mysqli->real_escape_string($_POST['name']);
	$question = $mysqli->real_escape_string($_POST['q1']);
	$answer1 = $mysqli->real_escape_string($_POST['a1']);
	$answer2 = $mysqli->real_escape_string($_POST['a2']);
	$answer3 = $mysqli->real_escape_string($_POST['a3']);
  $answer4 = $mysqli->real_escape_string($_POST['a4']);
  $visibility = "private";
  if ($_POST['Public'] == 'public') {
    $visibility = "public";
  }

	$owner = $_SESSION['username'];

	$poll_id = uniqid();

	$sql1 = "INSERT INTO Poll (id, owner, poll_name, question, total_likes, total_votes, visibility)"
					. "VALUES ('$poll_id', '$owner', '$pollName', '$question', 0, 0, '$visibility')";
	$sql2 = "INSERT INTO Options (option_num, option_name, poll_id, total_votes)"
					. "VALUES (1, '$answer1', '$poll_id', 0)";
	$sql3 = "INSERT INTO Options (option_num, option_name, poll_id, total_votes)"
					. "VALUES (2, '$answer2', '$poll_id', 0)";
	$sql4 = "INSERT INTO Options (option_num, option_name, poll_id, total_votes)"
					. "VALUES (3, '$answer3', '$poll_id', 0)";
  $sql5 = "INSERT INTO Options (option_num, option_name, poll_id, total_votes)"
        	. "VALUES (4, '$answer4', '$poll_id', 0)";

	$flag = true;
	if ($mysqli->query($sql1) == false ) {
		$_SESSION['message'] = "Problem 1";
		echo "Problem 1";
		$flag = false;
	}
	if ($mysqli->query($sql2) == false) {
		$_SESSION['message'] = "Problem 2";
		echo "Problem 1";
		$flag = false;
	}
	if ($mysqli->query($sql3) == false) {
		$_SESSION['message'] = "Problem 3";
		echo "Problem 1";
		$flag = false;
	}
	if ($mysqli->query($sql4) == false) {
		$_SESSION['message'] = "Problem 4";
		echo "Problem 4";
		$flag = false;
	}
  if ($mysqli->query($sql5) == false) {
		$_SESSION['message'] = "Problem 4";
		echo "Problem 4";
		$flag = false;
	}
	$_SESSION['show_poll'] = $poll_id;
  header("location: poll_id.php");
  ob_flush();
	$mysqli->close();
}
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

        <ul>

          <li>
            <article>
              <header>
                </header>
                <figure class="avatar"><img src="../images/demo/avatar.png" alt=""></figure>
                <address>
                  <div class="comcont">
                    <form class="form"  method="post" enctype="multipart/form-data" autocomplete="off">
    						      <div class="alert alert-error"><?= $_SESSION['message'] ?></div>
    						      <input style="width: 300px;  padding-right: 20px; border: 3px solid #555;" type="text" placeholder="Poll Name" name="name" required /> <br><br>
    						      Question <br><input style=" width: 300px; height: 50px; border: 3px solid #555;" type="text" placeholder="Question" name="q1" /> <br><br>
    						      Answer Choice 1 <br> <input style=" width: 300px; height: 50px; border: 3px solid #555;" type="text" placeholder="Answer Choice 1" name="a1"/><br><br>
    						      Answer Choice 2 <br> <input style=" width: 300px; height: 50px; border: 3px solid #555;" type="text" placeholder="Answer Choice 2" name="a2"/><br><br>
                      Answer Choice 3 <br> <input style=" width: 300px; height: 50px; border: 3px solid #555;" type="text" placeholder="Answer Choice 3" name="a3"/> <br><br>
                      Answer Choice 4 <br> <input style=" width: 300px; height: 50px; border: 3px solid #555;" type="text" placeholder="Answer Choice 4" name="a4"/> <br><br>
                      <input type="checkbox" name="Public" value="public"> Public Post <br><br><br>

    						      <input type="submit" value="Create Poll" name="Create Poll" class="btn btn-block btn-primary" />
    						      <div class="module">
    						    </form>

                  </div>
                </address>
            </article>

          </li>

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
