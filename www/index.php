<?php
// Redirecció a HTTPS
if(!isset($_SERVER["HTTPS"]) || $_SERVER["HTTPS"] != "on"){
  header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"], true, 301);
  exit;
}
include_once("sections/languages.php");
include_once("sections/cookies.php");
?>
<!DOCTYPE html>
<html lang="es">
    <head>
    <!-- Meta data -->
    <?php include_once("sections/meta.php") ?>

    <!-- Títol i Favicons -->
    <title>Cuantime. <?php echo $text['MetaTitol'];?></title>

    <!-- CSS Libraries -->
    <link href="//app.cuantime.es/assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <link href="//app.cuantime.es/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="//app.cuantime.es/assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
    
    <link href="//app.cuantime.es/assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css">
    <link href="//app.cuantime.es/assets/libs/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css" rel="stylesheet">
    <link href="//app.cuantime.es/assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet">
    <link href="//app.cuantime.es/assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css" rel="stylesheet">
    <link href="//app.cuantime.es/assets/libs/bootstrap-editable/css/bootstrap-editable.css" rel="stylesheet">
    <!-- CSS Custom -->
    <link rel="stylesheet" type="text/css" href="css/style.css" media="screen">
    <link rel="stylesheet" type="text/css" href="css/responsive.css" media="screen">

    <!-- Scripts Libraries -->
    <!-- Scripts custom -->
</head>

<body>
    <?php include_once("sections/header.php") ?>

            <div class="page-content">
                <div class="container-fluid">
                
                <?php include_once("sections/contentInfo.php") ?>
                <?php include_once("sections/contentPricing.php") ?>




                </div> <!-- container-fluid -->
            </div>
            <!-- End Page-content -->


<!-- Footer -->
<?php include_once("sections/footer.php") ?>

<!-- JavaScripts basics -->
<script src="//app.cuantime.es/assets/libs/jquery/jquery.min.js"></script>
<script src="//app.cuantime.es/assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- JavaScripts custom -->
<script src="js/script.js"></script>
<!-- Scripts custom -->

</body>
</html>