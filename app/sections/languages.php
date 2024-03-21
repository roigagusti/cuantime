<?php
if($userLang=="español"){
	$lang = "es";
	include_once("languages/es_translate.php");
}elseif($userLang=="català"){
	$lang = "ca";
	include_once("languages/ca_translate.php");
}elseif($userLang=="français"){
	$lang = "fr";
	include_once("languages/fr_translate.php");
}else{
	$lang = "en";
	include_once("languages/en_translate.php");
}
?>