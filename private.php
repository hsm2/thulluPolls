<style>
.myBox {
border: none;
padding: 5px;
font: 12px/14px sans-serif;
width: 500px;
height: 100px;
overflow: scroll;
}

#container div{
    display:inline-block;
    width:130px;
}

div.wpforms-container-full .wpforms-form button[type=submit] {

color: #0099CC; /* Text color */

background-color: transparent; /* Remove background color */

border: 2px solid #0099CC; /* Border thickness, line style, and color */

border-radius: 5px; /* Adds curve to border corners */

text-transform: uppercase; /* Make letters uppercase */

}

</style>

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
