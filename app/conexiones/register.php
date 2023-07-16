<?php 
require('conexion.php');
session_start();

function token($longitud) {
	$key = '';
	$pattern = '1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$max = strlen($pattern)-1;
	for($i=0;$i < $longitud;$i++) $key .= $pattern{mt_rand(0,$max)};
	return $key;
}

if(isset($_POST["email"])&&isset($_POST["password"])&&isset($_POST["re-password"])) {
	$nom = $_POST["name"];
	$email = $_POST["email"];
	$password = $_POST["password"];
	$repassword = $_POST["re-password"];

	if($password != $repassword){
		header('Location: ../register.php?event=pass-differents');
	}else{
		if($profile == "0"){
			header('Location: ../register.php?event=not-profile');
		}else{
			if($database->has("users",["email" => $email])){
				header('Location: ../register.php?event=email-exists');
			}else{
				$addEmpresa = $database->insert("empreses", [
					"created_date" => date('Y-m-d H:i:s'),
					"empresaNom" => $nom,
		            "empresaFormatFactura" => 1,
		            "empresaPrefixFactura" => "F_"
				]);
				$empresaId = $database->get("empreses",'id',["ORDER"=>["created_date"=>"DESC"]]);

				$taulausuaris = $database->insert("users", [
				"email" => $email,
				"password" => password_hash($password, PASSWORD_DEFAULT),
				"created_date" => date('Y-m-d H:i:s'),
				"nom" => $nom,
				"empresa"=>$empresaId,
				"emailconfirmed" => 0,
				"language" => "español",
				"token" => token(64)
				]);
				$userId = $database->get("users",'id',["ORDER"=>["created_date"=>"DESC"]]);

				$updateEmpresa = $database->update("empreses", [
					"userAdmin" => $userId
				],["id"=>$empresaId]);

				header('Location: sendmail.php?type=register&to='.$email);
			}
		}
	}
}
?>