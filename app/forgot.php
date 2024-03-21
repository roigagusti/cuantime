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
      <div class="forgot-notice"><?php echo $text['Introduce la dirección de correo electrónico asociada a tu cuenta y te enviaremos un vínculo para restablecer tu contraseña'];?>.</div>

      <form class="form-signin" action="conexiones/sendmail.php?type=forgot" method="post">
        <div class="login-input">
          <label for="email"><?php echo $text['Correo electrónico'];?></label>
          <input type="text" id="email" name="email" required>
        </div>

        <div class="submit-zone">
          <button class="btn-access" type="submit"><?php echo $text['Continuar'];?></button>
        </div>
      </form>
    </div>


    <div class="alert-zone">
      <div class="register"><?php echo $text['¿Tienes una cuenta?'];?> <a href="login.php?lang=<?php echo $text['lang']; ?>"><?php echo $text['Inicia sesión'];?></a><br>
      <?php echo $text['¿Aún no tienes una cuenta?'];?> <a href="register.php?lang=<?php echo $text['lang']; ?>"><?php echo $text['Crear cuenta'];?></a></div>
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
