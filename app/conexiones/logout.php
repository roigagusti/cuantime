<?php
require('conexion.php');
session_start();
// Esborrem la sessió a la BBDD
$database->update("users", [
  "session" => ""
  ], ["email" => $_SESSION["user_name"]]);
//Esborrem la sessió a la Cookie
setcookie("cuantime_sess", "", time()-60*60*24*7,"/login.php");
unset($_COOKIE["cuantime_sess"]);
// Esborrem la sessió PHP
session_destroy();
echo 'You have successfully logged out. You will be redirected or you can click <a href="../login.php?lang='.$_GET['lang'].'>here</a>';
if(isset($_GET['lang'])){
	header('Location: ../login.php?lang='.$_GET['lang']);
}else{
	header('Location: ../login.php');
}
?>
