<?php
// Redirecció a HTTPS
if(!isset($_SERVER["HTTPS"]) || $_SERVER["HTTPS"] != "on"){
  header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"], true, 301);
  exit;
}
include_once("conexiones/conexion.php");
session_start();
include_once("sections/sessionStart.php");
include_once("classes/functions.php");
$pagina = 'expedient-detall';
?>
<!DOCTYPE html>
<html lang="es">
    <head>
    <!-- Meta data -->
    <?php include_once("sections/meta.php") ?>

    <!-- Títol i Favicons -->
    <title>Cuantime. <?php echo $text['Expedientes'];?></title>

    <!-- CSS Libraries -->
    <link href="assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
    
    <link href="assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css">
    <link href="assets/libs/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css" rel="stylesheet">
    <link href="assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet">
    <link href="assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css" rel="stylesheet">
    <!-- CSS Custom -->
    <link rel="stylesheet" type="text/css" href="css/style.css" media="screen">
    <link rel="stylesheet" type="text/css" href="css/responsive.css" media="screen">

    <!-- Scripts Libraries -->
    <!-- Scripts custom -->
</head>

<body>
    <div id="layout-wrapper">
        <?php include_once("sections/header.php") ?>
        <?php include_once("sections/sidebar-menu.php") ?>

        <!-- ============================================================== -->
        <!-- PÀGINA INICIAL -->
        <!-- ============================================================== -->
        <div class="main-content">

            <div class="page-content">
                <div class="container-fluid">

                    <!-- Zona superior de títol -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-flex align-items-center justify-content-between">
                                <h4 class="mb-0"><?php echo $text['Proyecto'];?></h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="index.php">Cuantime</a></li>
                                    <li class="breadcrumb-item"><a href="expedients.php"><?php echo $text['Expedientes'];?></a></li>
                                    <li class="breadcrumb-item active"><?php echo $text['Proyecto'];?></li>
                                    </ol>
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- ZONA NOTIFIACIONS -->
                    <?php include_once("sections/notificacions.php") ?>

                    <?php
                    $projecteNom = $database->get("projectes","nom",["id"=>$_GET['id']]);
                    $projecteExp = $database->get("projectes","exp",["id"=>$_GET['id']]);
                    $projecteCiutat = $database->get("projectes","ciutat",["id"=>$_GET['id']]);
                    $projecteClientId = $database->get("projectes","idClient",["id"=>$_GET['id']]);
                    $projecteClient = $database->get("clients","nom",["id"=>$projecteClientId]);
                    $projecteUserId = $database->get("projectes","idUserEncarregat",["id"=>$_GET['id']]);
                    if($projecteUserId==0){
                        $projecteUser='-';
                    }else{
                        $projecteUser= $database->get("users","nom",["id"=>$projecteUserId]);
                    }
                    if($projecteExp==''){
                        $projecteExp='PH';
                        $projecteUser="-";
                    }
                    ?>

                    <div class="row mb-4">
                        <div class="col-xl-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="text-center">
                                        <div class="dropdown float-right">
                                            <a class="text-body dropdown-toggle font-size-18" href="#" role="button" data-toggle="dropdown" aria-haspopup="true">
                                              <i class="uil uil-ellipsis-v"></i>
                                            </a>
                                          
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item" data-toggle="modal" data-target="#editExp" style="cursor:pointer;"><?php echo $text['Editar proyecto'];?></a>
                                                <a class="dropdown-item text-danger" data-toggle="modal" data-target="#removeConfirm" style="cursor:pointer;"><?php echo $text['Borrar proyecto'];?></a>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <h5 class="mt-3 mb-1"><?php echo beautyExp($projecteExp).'. '.$projecteNom;?></h5>
                                        <p class="text-muted"><?php echo $projecteClient;?></p>

                                        <div class="mt-4">
                                            <?php if($clientMail!=""){?>
                                                <a href="mailto:<?php echo $clientMail;?>" class="btn btn-light btn-sm"><i class="uil uil-envelope-alt mr-2"></i> <?php echo $text['Enviar email'];?></a>
                                            <?php } if($clientTelefon!=""){?>
                                                <a href="tel:<?php echo $clientTelefon;?>" class="btn btn-light btn-sm"><i class="uil uil-phone-alt mr-2"></i> <?php echo $text['Llamar'];?></a>
                                            <?php } ?>
                                        </div>
                                    </div>

                                    <hr class="my-4">

                                    <div class="text-muted">
                                        <div class="table-responsive mt-4">
                                            <div>
                                                <p class="mb-1"><?php echo $text['Ciudad'];?>:</p>
                                                <h5 class="font-size-16"><?php echo $projecteCiutat;?></h5>
                                            </div>
                                            <div>
                                                <p class="mb-1"><?php echo $text['Asignado a'];?>:</p>
                                                <h5 class="font-size-16"><?php echo $projecteUser;?></h5>
                                            </div>
                                            <?php
                                            $assignacioEncarregat = $database->get("projectes","assignacioEncarregat",["id"=>$_GET['id']]);
                                            ?>
                                            <div>
                                                <p class="mb-1"><?php echo $text['Asignación económica'];?>:</p>
                                                <h5 class="font-size-16"><?php echo number_format($assignacioEncarregat,2,",",".");?> %</h5>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="d-print-none mt-4">
                                <a href="expedients.php" class="btn btn-link text-muted">
                                    <i class="uil uil-arrow-left mr-1"></i> <?php echo $text['Volver a expedientes'];?>
                                </a>
                            </div>
                        </div>

                        <div class="col-xl-8">
                            <div class="card mb-0">
                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-toggle="tab" href="#dedicacio" role="tab">
                                            <i class="uil uil-clock-nine font-size-20"></i>
                                            <span class="d-none d-sm-block"><?php echo $text['Dedicación'];?></span> 
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#tasques" role="tab">
                                            <i class="uil uil-list-ui-alt font-size-20"></i>
                                            <span class="d-none d-sm-block"><?php echo $text['Tareas'];?></span> 
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#missatges" role="tab">
                                            <i class="uil uil-comment font-size-20"></i>
                                            <span class="d-none d-sm-block"><?php echo $text['Mensajes'];?></span> 
                                        </a>
                                    </li>
                                    <!--<li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#docs" role="tab">
                                            <i class="uil uil-paperclip font-size-20"></i>
                                            <span class="d-none d-sm-block">Documentos</span> 
                                        </a>
                                    </li>-->
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#ofertes" role="tab">
                                            <i class="uil uil-file-blank font-size-20"></i>
                                            <span class="d-none d-sm-block"><?php echo $text['Ofertas'];?></span> 
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#factures" role="tab">
                                            <i class="uil uil-invoice font-size-20"></i>
                                            <span class="d-none d-sm-block"><?php echo $text['Facturas'];?></span> 
                                        </a>
                                    </li>
                                </ul>
                                <!-- Tab content -->
                                <div class="tab-content p-4">
                                    <!-- DEDICACIO -->
                                    <?php include_once("sections/expDedicacio.php") ?>

                                    <!-- TASQUES -->
                                    <?php include_once("sections/expTasques.php") ?>

                                    <!-- MISSATGES -->
                                    <?php include_once("sections/expMissatges.php") ?>

                                    <!-- DOCUMENTS -->
                                    <?php include_once("sections/expDocuments.php") ?>

                                    <!-- OFERTES -->
                                    <?php include_once("sections/expOfertes.php") ?>

                                    <!-- FACTURES -->
                                    <?php include_once("sections/expFactures.php") ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end row -->


                </div> <!-- container-fluid -->
            </div>
            <!-- End Page-content -->


            <?php include_once("sections/footer.php") ?>
            <?php include_once("sections/modal-editExp.php") ?>
            <?php include_once("sections/modal-removeExp.php") ?>
            <?php include_once("sections/modal-addFile.php") ?>
            <?php include_once("sections/modal-addTask.php") ?>
        </div>
        <!-- end main content-->
    </div>
    <!-- END layout-wrapper -->

<!-- JavaScripts basics -->
<script src="assets/libs/jquery/jquery.min.js"></script>
<script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/libs/metismenu/metisMenu.min.js"></script>
<script src="assets/libs/simplebar/simplebar.min.js"></script>
<script src="assets/libs/node-waves/waves.min.js"></script>
<script src="assets/libs/waypoints/lib/jquery.waypoints.min.js"></script>
<script src="assets/libs/jquery.counterup/jquery.counterup.min.js"></script>

<script src="assets/libs/apexcharts/apexcharts.min.js"></script>
<script src="assets/js/pages/dashboard.init.js"></script>
<script src="assets/libs/apexcharts/apexcharts.min.js"></script>
<script src="assets/js/pages/dashboard.init.js"></script>
<script src="assets/js/pages/form-advanced.init.js"></script>
<script src="assets/libs/select2/js/select2.min.js"></script>
<script src="assets/libs/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
<script src="assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
<script src="assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js"></script>
<script src="assets/libs/bootstrap-maxlength/bootstrap-maxlength.min.js"></script>
<script src="assets/js/pages/table-responsive.init.js"></script>
<!-- JavaScripts custom -->
<script src="assets/js/app.js"></script>
<!-- Scripts custom -->
</script>
</body>
</html>