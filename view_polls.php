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
?>
<p> Hello1 : </p>
<?php

$owner = $_SESSION['username'];
$sql = "SELECT poll_name FROM Poll WHERE owner = '$owner'";

?>
<p> Hello : </p>
<?php

if ($result->num_rows > 0) {
  // Show each data returned by mysql
  while($row = $result->fetch_assoc()) {
  ?>

  <!-- USING HTML HERE : Here I am using php within html tags -->
  <p> Name : <?php echo $row ?> </p>

<?php
  }
}
else {
  echo "0 results";
}
?>
