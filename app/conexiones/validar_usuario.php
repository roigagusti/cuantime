<?php 
require('conexion.php');
require('../sections/functions.php');
session_start();
//Comprovem que el mail i la contrassenya coincideixen
if(isset($_POST["email"])&&isset($_POST["password"])) {	
	$email = $_POST["email"];
	$password = $_POST["password"];
	//Comprovem que el mail hagi estat validat
	if(! filter_var($email, FILTER_VALIDATE_EMAIL)){
		header('Location: ../login.php?lang='.$_GET['lang'].'&event=email-error');

	}else{
    	if($database->has("users",["email" => $email])){
			$data = $database->get("users", [
			  "id",
			  "email",
			  "password",
			  "nom",
			  "active",
			  "emailconfirmed"
			  ], ["email" => $email]);
			
			if($data['emailconfirmed']==0){
				header('Location: ../login.php?event=email-not-confirmed');
				echo "Email not confirmed, you will be redirected or you can click <a href='../login.php?&event=email-not-confirmed'>here</a>.";
			}else if($data['active']==0){
				header('Location: ../login.php?event=deleted-account');
				echo "The account had been deleted, you will be redirected or you can click <a href='../login.php?event=deleted-account'>here</a>.";
			}else{
				if(password_verify($password,$data['password'])){
					$_SESSION["user_name"] = $email;

					if(!empty($_POST['rememberMe'])){
						$activeSession = $database->get("users","session",["email" => $email]);
						if(strlen($activeSession)>10){
							$session = $activeSession;
						}else{
							$session = token(64);
							$database->update("users", [
							  "session" => $session
							  ], ["email" => $email]);
						}
						setcookie("cuantime_sess", $session, time() + 30 * 24 * 60 * 60,'/login.php');
					}

					header('Location: ../index.php');
					echo "Welcome ".$data['nom'].". You will be redirected or you can click <a href='../index.php'>here</a>.";
				}else{
					header('Location: ../login.php?event=signin-error');
					echo "Wrong password, you will be redirected or you can click <a href='../login.php?event=signin-error'>here</a>.";
				}
			}
		}else{
			header('Location: ../login.php?event=error');
			echo "Email not found, you will be redirected or you can click <a href='../login.php?event=error'>here</a>.";
		}
	}
}elseif(isset($_GET['session'])){
	$activeSession = $database->get("users","session",["email" => $email]);
	if(strlen($activeSession)==0){
		setcookie("cuantime_sess", "", time()-60*60*24*7,"/login.php");
		unset($_COOKIE["cuantime_sess"]);
		header('Location: ../login.php');
		echo "Welcome to login. You will be redirected or you can click <a href='../login.php'>here</a>.";
	}
	$usuari = $database->get("users", [
		"email",
		"session"
		], ["session" => $_GET['session']]);
	$_SESSION["user_name"] = $usuari['email'];
	header('Location: ../index.php');
	echo "Welcome again. You will be redirected or you can click <a href='../index.php'>here</a>.";
}else{
	if(isset($_GET['token'])){
		if($_GET['token']!=""){
			if($database->has("users",["token" => $_GET['token']])){
				$usuari = $database->get("users", [
					"email",
					"token"
					], ["token" => $_GET['token']]);
				$database->update("users", [
					"token" => "",
					"emailconfirmed" => 1,
					], ["token" => $_GET['token']]);
				$_SESSION["user_name"] = $usuari['email'];
				header('Location: ../index.php');
				echo "Welcome. You will be redirected or you can click <a href='../index.php'>here</a>.";
			}else{
				header('Location: ../login.php?event=token-fail');
			}
		}else{
			header('Location: ../login.php?event=token-fail');			
		}
	}
}
?>