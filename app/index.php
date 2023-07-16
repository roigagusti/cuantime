<?php
// Redirecció a HTTPS
if(!isset($_SERVER["HTTPS"]) || $_SERVER["HTTPS"] != "on"){
  header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"], true, 301);
  exit;
}

session_start();
if(empty($_SESSION['user_name'])){
	if(isset($_COOKIE['username'])){
		$_SESSION["user_name"] = $_COOKIE['username'];
	}
}

header('Location:expedients.php');
?>