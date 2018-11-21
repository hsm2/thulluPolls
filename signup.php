<?php
 ob_start();  //begin buffering the output
?>

<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=us-ascii">
	<title></title>
	<link rel="stylesheet" href="w3.css">
</head>

<?php
session_start();
$_SESSION['message'] = '';
$mysqli = new mysqli("127.0.0.1", "thullupolls_root", "Surabhiharish", "thullupolls_thullupolls");
$link = mysqli_connect("127.0.0.1", "thullupolls_root", "Surabhiharish", "thullupolls_thullupolls");

if (!$link) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}

echo "Success: A proper connection to MySQL was made! The my_db database is great." . PHP_EOL;
echo "Host information: " . mysqli_get_host_info($link) . PHP_EOL;

mysqli_close($link);

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if($_POST['password'] == $_POST['confirmpassword']){
        $name = $mysqli->real_escape_string($_POST['name']);
        $id = $mysqli->real_escape_string($_POST['id']);
        $password = $mysqli->real_escape_string($_POST['password']);
        $_SESSION['name'] = $name;
        $_SESSION['id'] = $id;
				$sql1 = "SELECT id FROM User WHERE id=$id";
				if($mysqli->query($sql1) == true) {
					// if(empty($sql1)) {
					// 	$sql = "INSERT INTO User (id, name, password) " . "VALUES ('$id', '$name', '$password')";
					//
		      //   if(($mysqli->query($sql) === true)){
		      //       $_SESSION['message'] = "Registration Successful! Welcome $id";
		      //       header("location: index.html");
					// 			ob_flush();
		      //   }
		      //   else{
		      //       $_SESSION['message'] = "Account was not created:(";
		      //   }
					//
					// }
					// else {
					// 	$_SESSION['message'] = "Username already exsits. Please try a different one."
					// }
				}
				else{
					$_SESSION['message'] = "User name query not working."
				}

    }
    else{
        $_SESSION['message'] = "Two passwords do not match! Please type a valid password.";
    }
}
$mysqli->close();
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
								<a class="topnav" href="index.html" title="Homepage">Home</a>
								<h2 class="gradient-text">Create an account</h2>
								<form class="form" action="signup.php" method="post" enctype="multipart/form-data" autocomplete="off">
						      <div class="alert alert-error"><?= $_SESSION['message'] ?></div>
						      <input type="text" placeholder="Full Name" name="name" required />
						      <input type="text" placeholder="User Name" name="id" required />
						      <input type="password" placeholder="Password" name="password" autocomplete="new-password" required />
						      <input type="password" placeholder="Confirm Password" name="confirmpassword" autocomplete="new-password" required />
						      <input type="submit" value="verify" name="Create Account" class="btn btn-block btn-primary" />

						      <div class="module">
						    </form>
								<!-- <p><a href="#" class="btn btn-gradient">Sign In</a></p>
								<p><a href="#" class="btn btn-gradient">Sign up</a></p> -->
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>



		<footer id="fh5co-footer">
			<div class="container">
				<div class="row">
					<div class="col-md-4">
						<div class="fh5co-footer-widget">
							<a href="index.html">Motion <sup>&trade;</sup></a> Free HTML5 &copy; All Rights Reserved.  <br> Designed by <a href="http://gettemplates.co" target="_blank">GetTemplates.co</a> Images: <a href="http://pixeden.com" target="_blank">Pixeden</a>
						</div>
					</div>
					<div class="col-md-3 col-md-push-1">
						<div class="fh5co-footer-widget">
							<p><a href="tel://+1 234 567 8910">+1 234 567 8910</a> <br> <a href="#">info@yourdomain.com</a></p>
						</div>
					</div>
					<div class="col-md-4 col-md-push-1">
						<div class="fh5co-footer-widget gtco-social-wrap">
							<ul class="gtco-social">
								<li><a href="#" class="icon-twitter"></a></li>
								<li><a href="#" class="icon-dribbble"></a></li>
								<li><a href="#" class="icon-instagram"></a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</footer>


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
