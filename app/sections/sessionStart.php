<?php
function inicialsNom($nom){
	$trans = array("À"=>"A","Á"=>"A","È"=>"E","É"=>"E","Ì"=>"I","Í"=>"I","Ò"=>"O","Ó"=>"O","Ù"=>"U","Ú"=>"U");
    $nomWords = explode(" ", strtr($nom,$trans));
    $inicials = strtoupper($nomWords[0][0].$nomWords[1][0]);
    return $inicials;
}
if(isset($_SESSION['user_name'])) {
  $userId = $database->get("users","id",["email"=>$_SESSION['user_name']]);
  $userEmail = $_SESSION['user_name'];
  $userName = $database->get("users","nom",["id"=>$userId]);
  $userEmpresa = $database->get("users","empresa",["email"=>$_SESSION['user_name']]);
  $userAdminEmpresa = $database->get("empreses","userAdmin",["id"=>$userEmpresa]);
  $userType = $database->get("users","tipusUsuari",["email"=>$_SESSION['user_name']]);
  $empresaPlan = $database->get("users","plan",["id"=>$userAdminEmpresa]);
  $userColab = $database->get("users","tipusColaborador",["email"=>$_SESSION['user_name']]);
  $userNameArray = explode(' ',$userName);
  $userFirstName = $userNameArray[0];

  $userLang = $database->get("users","language",["id"=>$userId]);
  include_once("languages.php");
//Si no hi ha sessió redirigir a Login
}else{
  header('Location: login.php');
}
?>