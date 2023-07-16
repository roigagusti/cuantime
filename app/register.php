<?php
//Redirigir a connexió segura HTTPS
if(!isset($_SERVER["HTTPS"]) || $_SERVER["HTTPS"] != "on"){
  header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"], true, 301);
  exit;
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
  <title>Cuantime. Registro</title>

  <!-- CSS Libraries -->
  <!-- CSS Custom -->
  <link rel="stylesheet" type="text/css" href="css/access.css" media="screen">
  <link rel="stylesheet" type="text/css" href="css/access-responsive.css" media="screen">

  <!-- Scripts Libraries -->
  <!-- Scripts custom -->
</head>

<body>
<!-- Contingut de pàgina -->
<div class="register-content">
  <div class="left-side">
    <div class="franja-left">
      <div class="logo-register">
        <a href="/"><img src="img/cuantime_dark-lg.png"/></a>
      </div>
    </div>
  </div>
  <div class="right-side">
    <div class="franja-right box box-register">
      <div class="register-title">Crear tu cuenta Cuantime</div>

      <form class="form-signin" action="conexiones/register.php?lang=<?php echo $text['lang']; ?>" method="post">
        <div class="login-input">
          <label for="name">Nombre completo</label>
          <input type="text" id="name" name="name" placeholder="Gavin Belson" required>
          <label for="email">Correo electrónico</label>
          <input type="text" id="email" placeholder="gavin@hooli.com" name="email" required>
          <label for="password">Contraseña</label>
          <input type="password" id="password" placeholder="********" name="password" required>
          <label for="re-password">Confirmar contraseña</label>
          <input type="password" id="re-password" placeholder="********" name="re-password" required>
          <div class="terms">
            <!-- Pot ser "checked", "disabled" o "checked disabled"-->
            <input type="checkbox" name="agree-term" id="agree-term" onchange="termsChanged()">Estoy de acuerdo con los <a href="legal.php" target="_blank" class="term-service" required>Términos de servicio</a>
          </div>
        </div>

        <div class="submit-zone">
          <button class="btn-access disabled" type="submit">Crear cuenta</button>
        </div>
      </form>
      <div class="alert-zone">
      <div class="register">¿Tienes una cuenta? <a href="login.php?lang=<?php echo $text['lang']; ?>">Inicia sesión</a></div>

        <div class="fail <?php if($_GET['event'] == 'email-exists'){}else{echo 'hidden';}?>">La cuenta de email ya existe</div>
        <div class="fail <?php if($_GET['event'] == 'pass-differents'){}else{echo 'hidden';}?>">La contraseña y su confirmación no coinciden</div>
        <div class="fail <?php if($_GET['event'] == 'email-fail'){}else{echo 'hidden';}?>">No ha sido posible enviar el email de registro</div>
        <div class="success <?php if($_GET['event'] == 'success'){}else{echo 'hidden';}?>">Se ha completado el registro con éxito.<br>Se le ha enviado un email con instrucciones para activar la cuenta.</div>
      </div>
    </div>
  </div>
</div>
<!-- JavaScripts basics -->
<script src="assets/libs/jquery/jquery.min.js"></script>
<!-- JavaScripts custom -->
<script type="text/javascript" src="js/script.js"></script>
<!-- Scripts custom -->

</body>
</html>
