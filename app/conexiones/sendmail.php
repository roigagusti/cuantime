<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../lib/PHPMailer/src/Exception.php';
require '../lib/PHPMailer/src/PHPMailer.php';
require '../lib/PHPMailer/src/SMTP.php';

/* cridar arxiu "sendmail.php"
  
  POST PARÀMETRES
    to = destinatari del mail

  GET PARÀMETRES
    to = destinatari del mail
    type = tipus d'email a enviar
    lang = idioma en que s'ha d'efectuar els mails

  PARÀMETRES DES D'ARXIU EMAIL
    subject = assumpte
    body = text del mail
    returnsuccess = url de redirecció en cas de success a contar des de l'arrel de app
    returnfail = url de redirecció en cas de fail a contar des de l'arrel de app
*/

switch($_GET['type']){
  case "register":
    $to = $_GET['to'];
    include_once("mails/registration.php");
    break;
  case "newCollab":
    $to = $_GET['to'];
    include_once("mails/newCollab.php");
    break;
  case "forgot":
    $to = $_POST['email'];
    include_once("mails/forgot.php");
    break;
  default:
    $to = $_GET['to'];
    $subject = $_GET['subject'];
    $body = $_GET['body'];
}

// Enviem mail via API (api.enviaremail.ml)
$url = 'https://sendemail.agustiroig.com';
$ch = curl_init($url);

$data = array(
    'to' => $to,
    'subject' => $subject,
    'body' => $body
);
$payload = json_encode($data);

//attach encoded JSON string to the POST fields
curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($ch);
$obj = json_decode($result);
$emailSent = $obj->result->sent;
curl_close($ch);
print($result)

// if($emailSent == 1){
//   header('Location: '.$returnsuccess);
// }else{
//   header('Location: '.$returnfail);
// }
?>