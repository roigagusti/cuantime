<?php 
/* Register i Login */
function token($longitud) {
  $key = '';
  $pattern = '1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
  $max = strlen($pattern)-1;
  for($i=0;$i < $longitud;$i++) $key .= $pattern{mt_rand(0,$max)};
  return $key;
}
function inicials($name){
    //Entro un nom complet i obtinc un nom paraula+espai+paraula.
    $trans = array("À"=>"A","Á"=>"A","È"=>"E","É"=>"E","Ì"=>"I","Í"=>"I","Ò"=>"O","Ó"=>"O","Ù"=>"U","Ú"=>"U");
    $nomWords = explode(" ", strtr($name,$trans));
    $inicials = strtoupper($nomWords[0][0].$nomWords[1][0]);
    return $inicials;
}



/* Beautifiers */
function beautyTime($time){
    //Entro un valor en segons, que em permet fer diferencies de temps en segons, i surt "0h 00 min".
    $horesDiaries = floor(intval($time)/3600);
    $minutsDiaris = round((intval($time)%3600)/60,0);
    if($minutsDiaris < 10){$minutsDiaris = "0".$minutsDiaris;}
    return $horesDiaries."h ".$minutsDiaris." min";
}
function beautyNameTwoWords($name){
    //Entro un nom complet i obtinc un nom paraula+espai+paraula.
    $firstWords=explode(' ',$name);
    return $firstWords[0].' '.$firstWords[1];
}
function beautyExp($num){
    $beauty = sprintf('%04d', $num);
    return $beauty;
}



/* Time format */ 
function dateDistance($datetime)
{
  $strTime = array("segundos", "minutos", "horas", "días", "meses", "años");
  $length = array("60","60","24","30","12","10");
  $timestamp = strtotime($datetime);
  $currentTime = time();
  $diff = $currentTime - $timestamp;
  if($diff<60){return "Hace un momento";}else{
    for($i = 0; $diff >= $length[$i] && $i < count($length)-1; $i++) {
    $diff = $diff / $length[$i];
    }

    $diff = round($diff);
    return "Hace ".$diff." ".$strTime[$i];
  }
}



/* Factures */
function dni($a){
  if(ctype_alpha(substr($a,-1))&&!ctype_alpha($a[0])){
    return substr($a,0,2).'.'.substr($a,2,3).'.'.substr($a,5,3).'-'.substr($a,8,1);
  }else if(ctype_alpha($a[0])&&!ctype_alpha(substr($a,-1))){
    return $a[0].'-'.substr($a,1,2).'.'.substr($a,3,3).'.'.substr($a,6,3);
  }else{
      return $a;
  }
}
function iban($a){
  if(strlen($a)%4==0){
      $div=strlen($a)/4;
      $iban='';
      for($i=0;$i<$div;$i++){ 
          $iban.=substr($a,$i*4,4).' ';
      }
      $iban = substr($iban,0,-1);
      return $iban;
  }else{
      return $a;
  }
}
?>