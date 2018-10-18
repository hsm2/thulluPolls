<?php                                                                            
session_start();                                                                 
if (isset($_SESSION['usern'])){                                               
echo "User : ".$_SESSION['usern'];                                            
$_SESSION['viewCount'] = $_SESSION['viewCount'] + 1;
} else {                                                                         
echo "Set the user";                                                         
$_SESSION['usern'] = session_id();
$_SESSION['viewCount'] = 1;
}

echo "<br> Count : " . $_SESSION['viewCount'];                                   

?>

