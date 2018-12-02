<?php
 ob_start();
session_start();
$_SESSION['message'] = '';
$mysqli = new mysqli("127.0.0.1", "thullupolls_root", "Surabhiharish", "thullupolls_thullupolls");

echo 'no';
echo $_SERVER['REQUEST_METHOD'];

if($_SERVER['REQUEST_METHOD'] == 'POST'){
  echo "Im here";
    if($_POST['password'] == $_POST['confirmpassword']){
        echo "hello";
        $name = $mysqli->real_escape_string($_POST['name']);
        $id = $mysqli->real_escape_string($_POST['id']);
        $password = $mysqli->real_escape_string($_POST['password']);
        $_SESSION['name'] = $name;
        $_SESSION['id'] = $id;
				$sql1 = "SELECT * FROM User WHERE id='$id'";
				$result = $mysqli->query($sql1);
				if(mysqli_num_rows($result) == 0) {
						$sql = "INSERT INTO User (id, name, password) " . "VALUES ('$id', '$name', '$password')";
						if(($mysqli->query($sql) === true)){
									$_SESSION['message'] = "Registration Successful! Welcome $id";
									header("location: index.html");
									ob_flush();
						}
						else{
									$_SESSION['message'] = "Account was not created:(";
						}
					}
					else {
						$_SESSION['message'] = "Username already exsits. Please try a different one.";
					}
				}
    else{
        echo "goodbye";
        $_SESSION['message'] = "Two passwords do not match! Please type a valid password.";
    }
}

$mysqli->close();
?>

<html lang="en">
<head>
	<title>Register</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->
	<link rel="icon" type="image/png" href="Login_v19/images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="Login_v19/vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="Login_v19/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="Login_v19/fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="Login_v19/vendor/animate/animate.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="Login_v19/vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="Login_v19/vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="Login_v19/vendor/select2/select2.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="Login_v19/vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="Login_v19/css/util.css">
	<link rel="stylesheet" type="text/css" href="Login_v19/css/main.css">
<!--===============================================================================================-->
</head>
<body>

	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100 p-l-55 p-r-55 p-t-65 p-b-50">
				<form method="post" class="login100-form validate-form" enctype="multipart/form-data" autocomplete="off" >
					<span class="login100-form-title p-b-33">
						Register Account
					</span>
          <div class="alert alert-error"><?= $_SESSION['message'] ?></div>
					<div class="wrap-input100 validate-input" data-validate = "Full name is required">
						<input class="input100" type="text" name="name" placeholder="Full Name" required>
						<span class="focus-input100-1"></span>
						<span class="focus-input100-2"></span>
					</div>

					<div class="wrap-input100 rs1 validate-input" data-validate="Username is required">
						<input class="input100" type="text" name="id" placeholder="Username">
						<span class="focus-input100-1"></span>
						<span class="focus-input100-2"></span>
					</div>

          <div class="wrap-input100 rs1 validate-input" data-validate="Password is required">
						<input class="input100" type="password" name="password" placeholder="Password">
						<span class="focus-input100-1"></span>
						<span class="focus-input100-2"></span>
					</div>

          <div class="wrap-input100 rs1 validate-input" data-validate="Confirm password is required">
						<input class="input100" type="password" name="confirmpassword" placeholder="Confirm Password">
						<span class="focus-input100-1"></span>
						<span class="focus-input100-2"></span>
					</div>

					<div class="container-login100-form-btn m-t-20">
						<button class="login100-form-btn">
							Sign up
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>



<!--===============================================================================================-->
	<script src="Login_v19/vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="Login_v19/vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script src="Login_v19/vendor/bootstrap/js/popper.js"></script>
	<script src="Login_v19/vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="Login_v19/vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="Login_v19/vendor/daterangepicker/moment.min.js"></script>
	<script src="Login_v19/vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script src="Login_v19/vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
	<script src="Login_v19/js/main.js"></script>

</body>
</html>
