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

$owner = $_SESSION['username'];
$sql = "SELECT poll_name FROM Poll WHERE owner = '$owner'";
$result = $mysqli->query($sql);

if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    ?>
    <p> Name : <?php echo $row[0] ?> </p>
    <?php
  }
}
else {
  echo "0 results";
}
?>
