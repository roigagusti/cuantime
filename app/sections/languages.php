<?php
$lang = "ca";
if($userLang=="español"){
	$lang = "es";
	include_once("languages/es_translate.php");
}else{
	$lang = "ca";
	include_once("languages/ca_translate.php");
}
?>