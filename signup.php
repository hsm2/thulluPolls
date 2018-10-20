<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=us-ascii">
	<title></title>
	<link rel="stylesheet" href="w3.css">
</head>

<?php
session_start();
$_SESSION['message'] = '';
$mysqli = new mysqli("cpanel3.engr.illinois.edu", "thullupolls_thullu", "Thullu123!", "thullupolls_thullupolls");
#include('bankinfo.php');
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if($_POST['password'] == $_POST['confirmpassword']){
        $name = $_POST['name'];
        $id = $_POST['username'];
        $password = $_POST['password'];
        $_SESSION['name'] = $name;
        $_SESSION['username'] = $username;
        $sql = "INSERT INTO User (username, name, password) " . "VALUES ('$id', '$name', '$password')";

        if(($mysqli->query($sql) === true)){
            $_SESSION['message'] = "Registration Successful! Welcome $id";
            header("location: index.html");
        }
        else{
            $_SESSION['message'] = "Account was not created";
        }

    }
    else{
        $_SESSION['message'] = "Two passwords do not match! Please type a valid password";
    }
}
$mysqli->close();
?>

<div class="body-content">
  <div class="module">
      <a class="topnav" href="index.html" title="Homepage">Home</a>
    <h1>Create an account</h1>
    <form class="form" action="signup.php" method="post" enctype="multipart/form-data" autocomplete="off">
      <div class="alert alert-error"><?= $_SESSION['message'] ?></div>
      <input type="text" placeholder="Full Name" name="fullname" required />
      <input type="text" placeholder="User Name" name="username" required />
      <input type="password" placeholder="Password" name="password" autocomplete="new-password" required />
      <input type="password" placeholder="Confirm Password" name="confirmpassword" autocomplete="new-password" required />
      <input type="submit" value="verify" name="Create Account" class="btn btn-block btn-primary" />

      <div class="module">
    </form>
  </div>
</div>
