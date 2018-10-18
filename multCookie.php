<?php 
setcookie("usern", "Tao Cheng", time()+3600);
?>
<html>
<body>
<TITLE>Multiplication results</TITLE>
<H3>Multiplication results</H3>

<?php 
	if (isset($_COOKIE["usern"])) 
	{
		$user = $_COOKIE["usern"];
  		print("Welcome $user !<br />");
	}
	else
  		print("Welcome guest!<br />");

	$m = $_GET["m"]; 
	$n = $_GET["n"];
	$result = $m * $n; 
	print("<P> The product of $m and $n is $result");
?>

</body>
</html>
