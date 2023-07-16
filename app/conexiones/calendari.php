<?php 
require('conexion.php');
session_start();

switch($_GET['action']){
	// EVENTS
	case 'addEvent':
		$event = explode(' ',$_POST['dataCalendari']);
		$mesosEvent = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Des'];
		$mesEvent = array_search($event[1],$mesosEvent)+1;
		$eventData = $event[3].'-'.$mesEvent.'-'.$event[2].' 00:00:00';
		$addEventData = date('Y-m-d H:i:s', strtotime($eventData));

		$diaSeguent = intval($event[2])+1;

		$eventsDia = $database->count("calendari",["AND"=>['idUser'=>$_POST['userId'],"data[<>]"=>[date("Y-m-d H:i:s", mktime(0, 0, 0, $mesEvent, $event[2], $event[3])), date("Y-m-d H:i:s", mktime(0, 0, 0, $mesEvent, $diaSeguent, $event[3]))]]]);
		if($eventsDia>0){
			$eventId=$database->get("calendari","id",["AND"=>['idUser'=>$_POST['userId'],"data[<>]"=>[date("Y-m-d H:i:s", mktime(0, 0, 0, $mesEvent, $event[2], $event[3])), date("Y-m-d H:i:s", mktime(0, 0, 0, $mesEvent, $diaSeguent, $event[3]))]]]);
			$updateEvent = $database->update("calendari", ["type" => $_POST['category']],["id"=>$eventId]);
		}else{
			$nouEvent = $database->insert("calendari", [
				"idUser" => $_POST['userId'],
				"type" => $_POST['category'],
				"data" => $addEventData
			]);
		}

		header('Location: ../calendari.php?id=1&event=event-success');
		echo $eventsDia;
		break;
	
	default:
		header('Location: ../calendari.php?id=1');
		break;
}
?>