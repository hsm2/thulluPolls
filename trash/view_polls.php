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
      <a class="topnav" href="welcome.php" title="Homepage">Home</a>
      <h2 class="gradient-text">My Polls</h2>
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
$sql = "SELECT * FROM Poll WHERE owner = '$owner'";
$result = $mysqli->query($sql);

?>
<div id="gtco-project">
  <div class="container">
    <div class="row row-pb-md">
      <div class="col-md-7">
        <h3>Your Polls</h3>
        <p class="desc">Information on Polls</p>
      </div>
    </div>
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
        <h3><b>Poll Name:</b> <?php echo $row['poll_name'] ?> </h3>
        <h3><b>Poll Id: </b><?php echo $row['id'] ?> </h3>
        <h3><b>Visibility: </b><?php echo $row['visibility'] ?> </h3>
        <h3><b>Total Votes: </b><?php echo $row['total_votes'] ?> </h3>
        <h3><b>Total Likes: </b><?php echo $row['total_likes'] ?> </h3>
        <h3><b>Most Popular Option: </b><?php
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

        echo $option ?> with <?php echo $max?> total votes.</h3>
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
<div class="row">
  <div class="col-md-12 text-center">
    <a href="#" class="btn btn-gradient gtco-load"><i class="ti-reload"></i> load more...</a>
  </div>
</div>
</div>
</div>
<?php
?>

<html>
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
</html>
