<?php
if(isset($_GET['lang'])){
	$lang = $_GET['lang'];
}else{
	$lang = "es";
}

if($lang =="es"){
	include_once("languages/es_translate.php");
}else{
	include_once("languages/ca_translate.php");
}
?>