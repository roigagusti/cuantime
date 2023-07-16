<?php 
require('conexion.php');
session_start();

switch($_GET['action']){
	// PROJECTES
	case 'addMessage':
		$addMessage = $database->insert("missatges", [
			"idProjecte" => $_POST['idProjecte'],
			"idUser" => $_POST['userId'],
			"missatge" => $_POST['missatge'],
			"created_date" => date('Y-m-d H:i:s')
		]);

		header('Location: ../expedient-detall.php?id='.$_POST['idProjecte']);
		break;

	case 'addFile':
	    $fileTmpPath = $_FILES['addFile']['tmp_name'];
	    $fileName = $_FILES['addFile']['name'];
	    $fileSize = $_FILES['addFile']['size'];
	    $fileType = $_FILES['addFile']['type'];
	    $fileNameCmps = explode(".", $fileName);
	    $fileExtension = strtolower(end($fileNameCmps));
	    $allowedfileExtensions = array('jpg', 'gif', 'png', 'pdf');

	    if (in_array($fileExtension, $allowedfileExtensions)){
	      $uploadFileDir = '../img/missatges/';
	      $dest_path = $uploadFileDir.$fileName;

	      if(move_uploaded_file($fileTmpPath, $dest_path)){
	        $message = 'success';
	        $addFile = $database->insert("arxius", [
				"url" => $fileName,
				"titol"=>$_POST['fileTitle'],
				"fileType"=>$fileExtension,
				"idProjecte" => $_POST['idProjecte'],
				"idUser" => $_POST['userId'],
				"created_date" => date('Y-m-d H:i:s')
			]);
	      }else{
	        $message = 'fail';
	      }
	    }else{
	      $message = 'file-type-not-allowed';
	    }

		if($_POST['missatge']!=''){
			$idFile=$database->get("arxius","id",["AND"=>["url"=>$fileName,"idUser"=>$_POST['userId'],"idProjecte" => $_POST['idProjecte']]]);
			$addMessage = $database->insert("missatges", [
				"idProjecte" => $_POST['idProjecte'],
				"idUser" => $_POST['userId'],
				"missatge" => $_POST['missatge'],
				"idFile"=>$idFile,
				"created_date" => date('Y-m-d H:i:s')
			]);
		}

		header('Location: ../expedient-detall.php?id='.$_POST['idProjecte'].'&event='.$message);
		break;
	
	default:
		header('Location: ../expedients.php');
		break;
}
?>