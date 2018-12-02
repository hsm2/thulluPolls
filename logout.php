<?php
 ob_start();  //begin buffering the output
?>

<?php
session_start();
session_destroy();
header("location:index.html");
ob_flush();
 ?>
