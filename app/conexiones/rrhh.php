<?php 
require('conexion.php');
session_start();

function nearest5Mins($time) {
  $time = (round(strtotime($time) / 300)) * 300;
  return date('Y-m-d H:i', $time);
}
function token($longitud) {
	$key = '';
	$pattern = '1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$max = strlen($pattern)-1;
	for($i=0;$i < $longitud;$i++) $key .= $pattern{mt_rand(0,$max)};
	return $key;
}

$data = date('Y-m-d H:i:s');

switch($_GET['action']){
	// FITXAR
	case 'fitxarEntrar':
		$novaFitxada = $database->insert("fitxatges", [
			"timeIn" => $data,
			"idUser" => $_POST['userId']
		]);

		header('Location: ../..'.$_GET['url']);
		break;

	case 'fitxarSortir':
        $lastFitxada = $database->max("fitxatges","id",["idUser"=>$_POST['userId']]);
		$updateFitxada = $database->update("fitxatges",[
			"timeOut" => $data
		],["id"=>$lastFitxada]);

		header('Location: ../..'.$_GET['url']);
		break;

	case 'manualFitxar':
		$timeInBase = $_POST['iniciData'].' '.$_POST['iniciHora'];
		$timeOutBase = $_POST['finalData'].' '.$_POST['finalHora'];
		$timeIn = date('Y-m-d H:i',strtotime($timeInBase));

		if($_POST['checkHoraFinal']=="on"){
			$timeOut = date('Y-m-d H:i',strtotime($timeOutBase));
		}else{
			$timeOut = NULL;
		}

		$novaFitxada = $database->insert("fitxatges", [
			"timeIn" => $timeIn,
			"timeOut" => $timeOut,
			"idUser" => $_POST['userId']
		]);
		$dataUrl= date('d-m-Y',strtotime($_POST['iniciData']));

		header('Location: ../fitxatges-editar.php?dia='.$dataUrl);
		break;

	case 'updateFitxar':
		$a = explode("-",$_GET['dia']);
		$diaInvers = $a[2].'-'.$a[1].'-'.$a[0];
		$timeInBase = $diaInvers.' '.$_POST['iniciHora'];
		$timeOutBase = $diaInvers.' '.$_POST['finalHora'];
		$timeIn = date('Y-m-d H:i',strtotime($timeInBase));
		$timeOut = date('Y-m-d H:i',strtotime($timeOutBase));

		$updateFitxada = $database->update("fitxatges", [
			"timeIn" => $timeIn,
			"timeOut" => $timeOut
		],["id"=>$_GET['id']]);

		header('Location: ../fitxatges-editar.php?dia='.$_GET['dia']);
		break;

	case 'removeFitxatge':
		$removeFitxada = $database->delete("fitxatges",["id"=>$_GET['id']]);

		header('Location: ../fitxatges-editar.php?dia='.$_GET['dia']);
		break;


	// PARTES
	case 'addParte':
		$nouParte = $database->insert("partes", [
			"data" => $_POST['parteData'],
			"idProjecte" => $_POST['idProjecte'],
			"percentatge" => $_POST['partePercentatge'],
			"comment" => $_POST['parteComment'],
			"idUser" => $_POST['userId']
		]);
		
		$dataUrl= date('d-m-Y',strtotime($_POST['parteData']));
		header('Location: ../fitxatges-editar.php?dia='.$dataUrl);
		break;

	case 'updateParte':
		$a = explode("-",$_GET['dia']);

		$diaInvers = $a[2].'-'.$a[1].'-'.$a[0];
		$timeInBase = $diaInvers.' '.$_POST['iniciHora'];
		$timeOutBase = $diaInvers.' '.$_POST['finalHora'];
		$timeIn = date('Y-m-d H:i',strtotime($timeInBase));
		$timeOut = date('Y-m-d H:i',strtotime($timeOutBase));

		$updateParte = $database->update("partes", [
			"idProjecte" => $_POST['idProjecte'],
			"percentatge" => $_POST['partePercentatge'],
			"comment" => $_POST['parteComentari']
		],["id"=>$_GET['id']]);

		header('Location: ../fitxatges-editar.php?dia='.$_GET['dia']);
		break;

	case 'removeParte':
		$removeParte = $database->delete("partes",["id"=>$_GET['id']]);

		header('Location: ../fitxatges-editar.php?dia='.$_GET['dia']);
		break;


	// EQUIP
	case 'addPeople':
		$nom = $_POST["name"];
		$email = $_POST["email"];

		if($database->has("users",["email" => $email])){
			header('Location: ../equip.php?event=email-exists');
		}else{
			$taulausuaris = $database->insert("users", [
			"email" => $email,
			"password" => password_hash('123456', PASSWORD_DEFAULT),
			"created_date" => date('Y-m-d H:i:s'),
			"nom" => $nom,
			"tipusUsuari" => $_POST["permissos"],
			"tipusColaborador" => $_POST["tipusColaborador"],
			"empresa" => $_POST["empresaId"],
			"sou" => $_POST["sou"],
			"horari" => $_POST["horari"],
			"preu" => $_POST["preu"],
			"emailconfirmed" => 0,
			"language" => "español",
			"token" => token(64)
			]);

			header('Location: sendmail.php?type=newCollab&to='.$email);
		}
		break;

	case 'editUserType':
		$editUserType = $database->update("users", [
			"tipusUsuari" => $_GET['type']
		],['id'=>$_GET['id']]);

		header('Location: ../equip.php');
		break;

	case 'editUserColab':
		$editUserColab = $database->update("users", [
			"tipusColaborador" => $_GET['type']
		],['id'=>$_GET['id']]);

		header('Location: ../equip.php');
		break;

	case 'asignProject':
		$asingProject = $database->update("projectes", [
			"idUserEncarregat" => $_GET['id']
		],['id'=>$_GET['project']]);

		header('Location: ../expedients.php');
		break;

	case 'editUser':
		$editUser = $database->update("users", [
			"nom" => $_POST['userNom'],
			"email" => $_POST['userEmail']
		],['id'=>$_POST['userId']]);

		header('Location: ../equip-detall.php?id='.$_POST['userId'].'&event=user-success');
		break;

	case 'editProfile':
		$editProfile = $database->update("users", [
			"nom" => $_POST['userNom'],
			"language" => $_POST['userIdioma']
		],['id'=>$_POST['userId']]);

		if($_POST['userPass']!=""){
			if($_POST['userPass']==$_POST['userPass2']){
				$editProfilePass = $database->update("users", [
				"password" => password_hash($_POST['userPass'], PASSWORD_DEFAULT)
			],['id'=>$_POST['userId']]);
			}else{
				header('Location: ../perfil.php?event=pass-error');
			}
		}
		
		header('Location: ../perfil.php?event=profile-success');
		break;

	case 'editSou':
		$editSou = $database->update("users", [
			"sou" => $_POST['sou']
		],['id'=>$_GET['id']]);

		header('Location: ../equip.php');
		break;

	case 'editHorari':
		$editHorari = $database->update("users", [
			"horari" => $_POST['horari']
		],['id'=>$_GET['id']]);

		header('Location: ../equip.php');
		break;

	case 'editCost':
		$editCost = $database->update("users", [
			"preu" => $_POST['preu']
		],['id'=>$_GET['id']]);

		header('Location: ../equip.php');
		break;

	case 'removeUser':
		$rmUser = $database->update("users",["active"=>0],['id'=>$_GET['id']]);

		header('Location: ../equip.php?event=user-deleted');
		break;

	
	default:
		header('Location: ../fitxatges.php');
		break;
}
?>