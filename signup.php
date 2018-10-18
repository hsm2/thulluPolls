<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=us-ascii">
	<title></title>
	<link rel="stylesheet" href="w3.css">
</head>

<?php
session_start();
$_SESSION['message'] = '';
$mysqli = new mysqli("cpanel3.engr.illinois.edu", "funproject_funproject", "X5V-tfN-7Yh-nnb", "funproject_Database");
#include('bankinfo.php');
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if($_POST['password'] == $_POST['confirmpassword'] && ($_POST['bank_password'] == $_POST['bank_confirmpassword'])){
        $fullname = $mysqli->real_escape_string($_POST['fullname']);
        $username = $mysqli->real_escape_string($_POST['username']);
        $bank_username = $mysqli->real_escape_string($_POST['bank_username']);
        $bank_password = $mysqli->real_escape_string($_POST['bank_password']);
        $password = $_POST['password'];
        $bank_type = $_POST['bank_type'];
        #$bankID = 0;
        $_SESSION['fullname'] = $fullname;
        $_SESSION['username'] = $username;
        $balance = 0;
        $sql = "INSERT INTO User (username, name, password, balance, bankID ) " . "VALUES ('$username', '$fullname', '$password', '$balance', '$bank_type')";
        $sql1 = "INSERT INTO Bank (bankID, crypto_username, bank_username, password) " . "VALUES ('$bank_type', '$username', '$bank_username', '$bank_password')";

        if(($mysqli->query($sql) === true) && ($mysqli->query($sql1) === true)){
            $_SESSION['message'] = "Registration Successful! $username has been added to the database!";
            header("location: index.html");
            #header("location:bankinfo.php");
        }
        else{
            $_SESSION['message'] = "User could not be added to database";
        }

    }
    else{
        $_SESSION['message'] = "Two passwords do not match!";
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
      <!--<input type="submit" value="Register" name="register" class="btn btn-block btn-primary" /> -->

      <div class="module">



    <div>
	Select Your Bank: <br />
    <input name="bank_type" type="radio" value=0 checked />Bank A<br />
    <input name="bank_type" type="radio" value=1 />Bank B<br />
    <input name="bank_type" type="radio" value=2 />Bank C<br />
    <input name="bank_type" type="radio" value=3 />Bank D<br />
    <input name="bank_type" type="radio" value=4 />Bank E<br />
    <input name="bank_type" type="radio" value=5 />Bank F<br />
    <input name="bank_type" type="radio" value=6 />Bank G<br />
    <input name="bank_type" type="radio" value=7 />Bank H<br />
    <input name="bank_type" type="radio" value=8 />Bank I<br />
    <input name="bank_type" type="radio" value=9 />Bank J<br />
    </div>

      <input type="text" placeholder="Bank Username" name="bank_username" required />
      <input type="password" placeholder="Bank Password" name="bank_password" autocomplete="new-password" required />
      <input type="password" placeholder="Confirm Password" name="bank_confirmpassword" autocomplete="new-password" required />
      <input type="submit" value="Verify" name="verify" class="btn btn-block btn-primary" />
  </div>
    </form>
  </div>
</div>

</html>
