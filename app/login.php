<?php
//Redirigir a connexió segura HTTPS
if(!isset($_SERVER["HTTPS"]) || $_SERVER["HTTPS"] != "on"){
  header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"], true, 301);
  exit;
}
if(isset($_COOKIE['cuantime_sess'])){
  header("Location: https://app.cuantime.es/conexiones/validar_usuario.php?session=".$_COOKIE['cuantime_sess']);
}
#Incloure direcció dels arxius de traducció
include_once("sections/languages.php");
?>
<!DOCTYPE html>
<html lang="<?php echo $text['lang']; ?>">
  <head>
    <!-- Meta data -->
  <?php include_once("sections/meta.php"); ?>

  <!-- Títol i Favicons -->
  <title>Cuantime. <?php echo $text['Inicia sesión'];?></title>

  <!-- CSS Libraries -->
  <!-- CSS Custom -->
  <link rel="stylesheet" type="text/css" href="css/access.css" media="screen">
  <link rel="stylesheet" type="text/css" href="css/access-responsive.css" media="screen">

  <!-- Scripts Libraries -->
  <!-- Scripts custom -->
</head>

<body>
<!-- Contingut de pàgina -->
<div class="content">
  <div class="franja-central">
    <div class="logo">
      <a href="/"><img src="img/cuantime_light-lg.png" /></a>
    </div>


    <div class="box box-login box-shadow">
      <div class="login-title"><?php echo $text['Inicia sesión en tu cuenta'];?></div>

      <form class="form-signin" action="conexiones/validar_usuario.php?lang=<?php echo $text['lang']; ?>" method="post">
        <div class="login-input">
          <label for="email"><?php echo $text['Correo electrónico'];?></label>
          <input type="text" id="email" placeholder="gavin@hooli.com" name="email" required>
          <label for="password"><div class="label-pass"><?php echo $text['Contraseña'];?></div><div class="label-forgot"><a href="forgot.php"><?php echo $text['¿Olvidaste tu contraseña?'];?></a></div></label>
          <input type="password" id="password" placeholder="********" name="password" required>
          <div class="rememberMe">
            <input type="checkbox" class="custom-control-input" name="rememberMe" id="rememberMe"><?php echo $text['Recuerdame'];?>
          </div>
        </div>

        <div class="submit-zone">
          <button class="btn-access" type="submit"><?php echo $text['Continuar'];?></button>
        </div>
      </form>
    </div>


    <div class="alert-zone">
      <div class="register"><?php echo $text['¿Aún no tienes una cuenta?'];?> <a href="register.php?lang=<?php echo $text['lang']; ?>"><?php echo $text['Crear cuenta'];?></a></div>
      
      <div class="fail <?php if($_GET['event'] == 'signin-error'){}else{echo 'hidden';}?>"><?php echo $text['El usuario o la contraseña no son correctos'];?></div>
      <div class="fail <?php if($_GET['event'] == 'email-error'){}else{echo 'hidden';}?>"><?php echo $text['Por favor, escribe un email válido'];?></div>
      <div class="fail <?php if($_GET['event'] == 'error'){}else{echo 'hidden';}?>"><?php echo $text['Email no encontrado'];?></div>
      <div class="fail <?php if($_GET['event'] == 'insufficient-data'){}else{echo 'hidden';}?>"><?php echo $text['No hay suficientes datos'];?></div>
      <div class="fail <?php if($_GET['event'] == 'email-fail'){}else{echo 'hidden';}?>"><?php echo $text['No ha sido posible enviar el email de registro, ponte en contacto con el equipo'];?> <a href="mailto:agusti@mesural.com?subject=No%20he%20podido%20registrarme&body=He%20intentado%20registrarme%20pero%20me%20aparece%20un%20aviso%20conforme%20no%20se%20ha%20podido%20enviar%20el%20email%20de%20registro%20a%20<?php echo $_GET['to'];?>.%20Muchas%20gracias." style="color:#a00000;font-weight:500"><?php echo $text['aquí'];?></a></div>
      <div class="fail <?php if($_GET['event'] == 'email-not-confirmed'){}else{echo 'hidden';}?>"><?php echo $text['El email aun no ha sido validado'];?></div>
      <div class="fail <?php if($_GET['event'] == 'token-fail'){}else{echo 'hidden';}?>"><?php echo $text['El código de acceso no es valido'];?></div>
      <div class="fail <?php if($_GET['event'] == 'deleted-account'){}else{echo 'hidden';}?>"><?php echo $text['La cuenta se eliminó anteriormente'];?>.<br><?php echo $text['Para recuperarla ponte en contacto con nosotros en'];?> <a href='mailto:agusti@mesural.com'>agusti@mesural.com</a>.</div>
      <div class="success <?php if($_GET['event'] == 'success'){}else{echo 'hidden';}?>"><?php echo $text['Se ha completado el registro con éxito'];?>.<br><?php echo $text['Se ha enviado un email con instrucciones para activar la cuenta'];?>.</div>
      <div class="success <?php if($_GET['event'] == 'forgot-success'){}else{echo 'hidden';}?>"><?php echo $text['Se ha enviado las instrucciones para recuperar la contraseña por email'];?>.<br><?php echo $text['Por favor comprueba tu email'];?>.</div>
      <div class="success <?php if($_GET['event'] == 'unsubscribed-success'){}else{echo 'hidden';}?>"><?php echo $text['Te has desuscrito con éxito de las comunicaciones por email de Cuantime'];?></div>
      <div class="success <?php if($_GET['event'] == 'deleted-success'){}else{echo 'hidden';}?>"><?php echo $text['La cuenta ha sido eliminada correctamente de Cuantime'];?></div>
    </div>

  </div>
</div>
<div class="footer">
  <a href="/">© Cuantime</a>
  <a href="#"><?php echo $text['Contacto'];?></a>
  <a href="legal.php"><?php echo $text['Privacidad y condiciones'];?></a>
</div>
<!-- JavaScripts basics -->
<script src="assets/libs/jquery/jquery.min.js"></script>
<!-- JavaScripts custom -->
<script type="text/javascript" src="js/script.js"></script>
<!-- Scripts custom -->

</body>
</html>
