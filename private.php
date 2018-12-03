<?php
 ob_start();  //begin buffering the output
?>

<?php
session_start();
echo $_SESSION['username']
?>

<?php
header("location:welcome.php");
ob_flush();
?>
