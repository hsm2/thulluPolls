<?php
 ob_start();  //begin buffering the output
?>

<?php
session_start();
echo $_SESSION['username']
?>

<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=us-ascii">
	<title></title>
	<link rel="stylesheet" href="w3.css">
</head>

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

	<div class="gtco-loader"></div>

	<div id="page">

		<nav class="gtco-nav" role="navigation">
			<div class="container">

				<div class="row">
					<div class="col-xs-10 text-right fh5co-top-social">
						<ul class="gtco-social">
							<li><a href="#" class="icon-twitter"></i></a></li>
							<li><a href="#" class="icon-dribbble"></i></a></li>
							<li><a href="#" class="icon-instagram"></i></a></li>
						</ul>
					</div>
				</div>

			</div>
		</nav>
		<div id="gtco-intro">
			<div class="container">
				<div class="row">
					<div class="col-md-10 col-md-offset-1 text-center">
						<div class="dt js-height">
							<div class="dtc animate-box">
                <a class="topnav" href="welcome.php" title="Homepage">Home</a>
								<h2 class="gradient-text">Create a Poll</h2>
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

                <form action="poll_id.php">
								    <button class="btn btn-gradient" type="submit">View My Polls</button>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>


	</div>

	<div class="gototop js-top">
		<a href="#" class="js-gotop"><i class="icon-arrow-up"></i></a>
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

	</body>
</html>
