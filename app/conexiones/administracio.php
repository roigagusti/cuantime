<?php 
require('conexion.php');
session_start();

switch($_GET['action']){
	// OFERTES
	case 'addOferta':
		if($_POST['projecteSelect']=='x'){
			$nouProjecte = $database->insert("projectes", [
				"nom" => $_POST['nomProjecte'],
				"ciutat" => $_POST['ciutatProjecte'],
				"idClient" => $_POST['client'],			
				"estat" => 0,		
				"idUserEncarregat" => 0,
				"created_date" => date('Y-m-d H:i:s'),
				"idUser" => $_POST['userId']
			]);
			$idProjecte = $database->max("projectes","id",["idUser"=>$_POST['userId']]);
		}else{
			$idProjecte = $_POST['projecteSelect'];
		}
		$numeroProjecte = substr($_POST['numeroProjecte'],3);

		$novaOferta = $database->insert("ofertes", [
			"numero" => $numeroProjecte,
			"idProjecte" => $idProjecte,
			"preu" => $_POST['preuProjecte'],
			"estat" => 2,
			"data" => date('Y-m-d'),
			"idUser" => $_POST['userId']
		]);

		header('Location: ../ofertes.php?event=oferta-success&id='.$idProjecte.'&num='.$numeroProjecte);
		break;

	case 'editOferta':
		$editProjecte = $database->update("projectes", [
			"nom" => $_POST['nomProjecte'],
			"ciutat" => $_POST['ciutatProjecte'],
			"idClient" => $_POST['client'],
			"modification_date" => date('Y-m-d H:i:s')
		],['id'=>$_POST['projecteId']]);

		$editOferta = $database->update("ofertes", [
			"numero" => $_POST['numeroProposta'],
			"preu" => $_POST['preuProjecte']
		],['id'=>$_POST['ofertaId']]);

		header('Location: ../ofertes.php?event=edit-oferta-success');
		break;

	case 'estatOferta':
		$estatOferta = $database->update("ofertes", [
			"estat" => $_GET['estat']
		],['id'=>$_GET['id']]);

		header('Location: ../ofertes.php?event=edit-estat-oferta-success');
		break;

	case 'removeOferta':
		$test_delete = strtolower($_POST['deleteProjecte']);
		if($test_delete=="esborrar" || $test_delete=="borrar" || $test_delete=="delete" || $test_delete=="supprimer"){
			$rmOferta = $database->delete("ofertes",['id'=>$_POST['ofertaId']]);

			header('Location: ../ofertes.php?event=oferta-deleted');
		}else{
			header('Location: ../ofertes.php?event=oferta-not-deleted');
		}
		break;

	// EXPEDIENTS - PROJECTES
	case 'addExp':
		$ofertaEstat = $database->get("ofertes","estat",["idProjecte"=>$oferta['id']]);

		$nouExp = $database->update("projectes", [
			"exp" => $_POST['numeroExp'],
			"estat" => $_POST['estatExp'],
			"modification_date" => date('Y-m-d H:i:s')
		],["id"=>$_POST['expId']]);

		header('Location: ../expedients.php?event=exp-success');
		break;

	case 'editExp':
		$editExp = $database->update("projectes", [
			"exp" => $_POST['expNum'],
			"assignacioEncarregat" => $_POST['assignacio']
		],['id'=>$_POST['expId']]);

		header('Location: ../expedient-detall.php?id='.$_POST['expId'].'&event=edit-num-exp-success');
		break;

	case 'estatExp':
		$estatProjectes = $database->update("projectes", [
			"estat" => $_GET['estat']
		],['id'=>$_GET['id']]);

		header('Location: ../expedients.php?event=edit-estat-exp-success');
		break;

	case 'removeExp':
		$rmExp = $database->update("projectes", [
			"exp" => ''
		],['id'=>$_GET['id']]);

		header('Location: ../expedients.php?event=exp-deleted');
		break;


	// FACTURES
	case 'addFactura':
		if($_POST['facturaNom']!=""){$facturaNom=$_POST['facturaNom'];}else{$facturaNom=NULL;}
		if($_POST['facturaDireccio']!=""){$facturaDireccio=$_POST['facturaDireccio'];}else{$facturaDireccio=NULL;}
		if($_POST['facturaCP']!=""){$facturaCP=$_POST['facturaCP'];}else{$facturaCP=NULL;}
		if($_POST['facturaCiutat']!=""){$facturaCiutat=$_POST['facturaCiutat'];}else{$facturaCiutat=NULL;}
		if($_POST['facturaCIF']!=""){$facturaCIF=$_POST['facturaCIF'];}else{$facturaCIF=NULL;}
		if($_POST['facturaTelefon']!=""){$facturaTelefon=$_POST['facturaTelefon'];}else{$facturaTelefon=NULL;}
		if($_POST['facturaEmail']!=""){$facturaEmail=$_POST['facturaEmail'];}else{$facturaEmail=NULL;}
		$novaFactura = $database->insert("factures", [
			"numero"=> $_POST['numeroFactura'],
			"idProjecte"=> $_POST['idProjecte'],
			"data" => date('Y-m-d'),
			"import" => $_POST['facturaImport'],
			"estat"=> 1,
			"iva"=>$_POST['facturaIVA'],
			"irpf"=>$_POST['facturaIRPF'],
			"facturaNom" => $facturaNom,
			"facturaDireccio" => $facturaDireccio,
			"facturaCP" => $facturaCP,
			"facturaCiutat" => $facturaCiutat,
			"facturaCIF" => $facturaCIF,
			"facturaTelefon" => $facturaTelefon,
			"facturaEmail" => $facturaEmail,
			"idUser" => $_POST['userId']
		]);
		echo 'numero: '.$_POST['numeroFactura'].'<br>';
		echo 'idProjecte: '.$_POST['idProjecte'].'<br>';
		echo 'data: '.date('Y-m-d').'<br>';
		echo 'import: '.$_POST['facturaImport'].'<br>';
		echo 'iva: '.$_POST['facturaIVA'].'<br>';
		echo 'irpf: '.$_POST['facturaIRPF'].'<br>';
		echo 'facturaNom: '.$facturaNom.'<br>';
		echo 'facturaDireccio: '.$facturaDireccio.'<br>';
		echo 'facturaCP: '.$facturaCP.'<br>';
		echo 'facturaCiutat: '.$facturaCiutat.'<br>';
		echo 'facturaCIF: '.$facturaCIF.'<br>';
		echo 'facturaTelefon: '.$facturaTelefon.'<br>';
		echo 'facturaEmail: '.$facturaEmail.'<br>';
		echo 'idUser: '.$_POST['userId'];
		
		//header('Location: ../factures.php?event=factura-success');
		break;

	case 'estatFactura':
		$estatFactura = $database->update("factures", [
			"estat" => $_GET['estat']
		],['id'=>$_GET['id']]);

		header('Location: ../factures.php?event=edit-estat-factura-success');
		break;

	case 'editFactura':
		$editFactura = $database->update("factures", [
			"numero" => $_POST['facturaNumero'],
			"idProjecte" => $_POST['facturaProjecte'],
			"data" => date('Y-m-d',strtotime($_POST['facturaData'])),
			"import" => $_POST['facturaImport'],
			"iva" => $_POST['facturaIVA'],
			"irpf" => $_POST['facturaIRPF'],
			"facturaNom" => $_POST['clientNom'],
			"facturaDireccio" => $_POST['clientDireccio'],
			"facturaCP" => $_POST['clientCP'],
			"facturaCiutat" => $_POST['clientCiutat'],
			"facturaCIF" => $_POST['clientCIF'],
			"facturaTelefon" => $_POST['clientTelefon'],
			"facturaEmail" => $_POST['clientEmail']
		],['id'=>$_GET['id']]);

		header('Location: ../factura-detall.php?id='.$_GET['id'].'&event=edit-factura-success');
		break;

	case 'removeFactura':
		$rmFactura = $database->delete("factures",['id'=>$_GET['id']]);

		header('Location: ../factures.php?event=factura-deleted');
		break;

	// DESPESES
	case 'addDespesa':
		if($_POST['despesaNom']!=""){$despesaNom=$_POST['despesaNom'];}else{$despesaNom=NULL;}
		if($_POST['despesaDireccio']!=""){$despesaDireccio=$_POST['despesaDireccio'];}else{$despesaDireccio=NULL;}
		if($_POST['despesaCP']!=""){$despesaCP=$_POST['despesaCP'];}else{$despesaCP=NULL;}
		if($_POST['despesaCiutat']!=""){$despesaCiutat=$_POST['despesaCiutat'];}else{$despesaCiutat=NULL;}
		if($_POST['despesaCIF']!=""){$despesaCIF=$_POST['despesaCIF'];}else{$despesaCIF=NULL;}
		if($_POST['despesaTelefon']!=""){$despesaTelefon=$_POST['despesaTelefon'];}else{$despesaTelefon=NULL;}
		if($_POST['despesaEmail']!=""){$despesaEmail=$_POST['despesaEmail'];}else{$despesaEmail=NULL;}
		$novadespesa = $database->insert("despeses", [
			"idProjecte"=> $_POST['idProjecte'],
			"data" => date('Y-m-d',strtotime($_POST['despesaData'])),
			"concepte"=>$_POST['despesaConcepte'],
			"proveidor"=>$_POST['despesaProveidor'],
			"import" => $_POST['despesaImport'],
			"iva"=>$_POST['despesaIVA'],
			"irpf"=>$_POST['despesaIRPF'],
			"despesaNom" => $despesaNom,
			"despesaDireccio" => $despesaDireccio,
			"despesaCP" => $despesaCP,
			"despesaCiutat" => $despesaCiutat,
			"despesaCIF" => $despesaCIF,
			"despesaTelefon" => $despesaTelefon,
			"despesaEmail" => $despesaEmail,
			"idUser" => $_POST['userId']
		]);

		header('Location: ../despeses.php?event=despesa-success');
		break;

	case 'editDespesa':
		$editDespesa = $database->update("despeses", [
			"idProjecte" => $_POST['despesaProjecte'],
			"data" => date('Y-m-d',strtotime($_POST['despesaData'])),
			"import" => $_POST['despesaImport'],
			"iva" => $_POST['despesaIVA'],
			"irpf" => $_POST['despesaIRPF'],
			"concepte"=>$_POST['despesaConcepte'],
			"proveidor" => $_POST['despesaEmpresa'],
			"despesaNom" => $_POST['despesaNom'],
			"despesaDireccio" => $_POST['despesaDireccio'],
			"despesaCP" => $_POST['despesaCP'],
			"despesaCiutat" => $_POST['despesaCiutat'],
			"despesaCIF" => $_POST['despesaCIF'],
			"despesaTelefon" => $_POST['despesaTelefon'],
			"despesaEmail" => $_POST['despesaEmail']
		],['id'=>$_GET['id']]);

		header('Location: ../despesa-detall.php?id='.$_GET['id'].'&event=edit-despesa-success');
		break;

	case 'removeDespesa':
		$rmDespesa = $database->delete("despeses",['id'=>$_GET['id']]);

		header('Location: ../despeses.php?event=despesa-deleted');
		break;

	// CLIENTS
	case 'addClient':
		$nouClient = $database->insert("clients", [
			"nom" => $_POST['clientNom'],
			"empresa" => $_POST['clientEmpresa'],
			"direccio" => $_POST['clientDireccio'],
			"codiPostal" => $_POST['clientCP'],
			"ciutat" => $_POST['clientCiutat'],
			"cif" => $_POST['clientCIF'],
			"telefon" => $_POST['clientPhone'],
			"mail" => $_POST['clientEmail'],
			"idUser" => $_POST['userId']
		]);

		header('Location: ../clients.php?event=client-success');
		break;

	case 'editClient':
		$editClient = $database->update("clients", [
			"nom" => $_POST['clientNom'],
			"empresa" => $_POST['clientEmpresa'],
			"direccio" => $_POST['clientDireccio'],
			"codiPostal" => $_POST['clientCP'],
			"ciutat" => $_POST['clientCiutat'],
			"cif" => $_POST['clientCIF'],
			"telefon" => $_POST['clientPhone'],
			"mail" => $_POST['clientEmail']
		],['id'=>$_POST['clientId']]);

		header('Location: ../client-detall.php?id='.$_POST['clientId'].'&event=edit-client-success');
		break;

	case 'removeClient':
		$rmClient = $database->delete("clients",['id'=>$_GET['id']]);

		header('Location: ../clients.php?event=client-deleted');
		break;

	// EMPRESA
	case 'editEmpresa':
		$editEmpresa = $database->update("empreses", [
			"empresaNom" => $_POST['empresaNom'],
            "empresaDireccio" => $_POST['empresaDireccio'],
            "empresaCP" => $_POST['empresaCP'],
            "empresaCiutat" => $_POST['empresaCiutat'],
            "empresaTelefon" => $_POST['empresaTelefon'],
            "empresaCIF" => $_POST['empresaCIF'],
            "empresaBanc" => $_POST['empresaBanc'],
            "empresaIBAN" => $_POST['empresaIBAN'],
            "empresaSWIFT" => $_POST['empresaSWIFT'],
            "empresaFormatFactura" => $_POST['empresaFormatFactura'],
            "empresaPrefixFactura" => $_POST['empresaPrefixFactura']
		],['id'=>$_POST['empresaId']]);

		header('Location: ../perfil.php?event=edit-empresa-success');
		break;

	// TASQUES
	case 'addTask':
		if($_POST['proyecto']==0){
			header('Location: ../tareas.php?event=task-error');
		}else{
		$addTask = $database->insert("tasques", [
			"idProjecte" => $_POST['proyecto'],
			"idUser" => $_POST['userId'],
			"titol" => $_POST['titulo'],
			"missatge" => $_POST['descripcion'],
			"prioritat" => $_POST['prioridad'],
			"active" => 1,
			"created_date" => date('Y-m-d H:i:s')
		],["id"=>$_POST['expId']]);

		header('Location: ../tareas.php?event=task-success');}
		break;

	case 'estatTask':
		$estatTask = $database->update("tasques", [
			"prioritat" => $_GET['prioritat']
		],['id'=>$_GET['id']]);

		header('Location: ../tareas.php?event=task-priority-success');
		break;

	case 'removeTask':
		$rmTask = $database->update("tasques", [
			"active" => 0
		],['id'=>$_GET['id']]);

		header('Location: ../tareas.php?event=task-deleted');
		break;
	
	default:
		header('Location: ../ofertes.php');
		break;
}
?>