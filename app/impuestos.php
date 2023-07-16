<?php
// Redirecció a HTTPS
if(!isset($_SERVER["HTTPS"]) || $_SERVER["HTTPS"] != "on"){
  header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"], true, 301);
  exit;
}
include_once("conexiones/conexion.php");
session_start();
include_once("sections/sessionStart.php");

function trimestre($datetime){
    $mes = date("m",strtotime($datetime));
    $mes = is_null($mes) ? date('m') : $mes;
    $trim=floor(($mes-1) / 3)+1;
    return $trim;
}
// Si no té paràmetres redirigir a paràmetres bàsics
if(!strlen($_SERVER['QUERY_STRING'])>0){
  header('Location: impuestos.php?modelo=303&ejercicio='.date("Y").'&periodo='.trimestre(date('m')).'T');
}
?>
<!DOCTYPE html>
<html lang="es">
    <head>
    <!-- Meta data -->
    <?php include_once("sections/meta.php") ?>

    <!-- Títol i Favicons -->
    <title>Cuantime. Impuestos</title>

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
                                <h4 class="mb-0">Hacienda. Impuestos</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="index.php">Cuantime</a></li>
                                        <li class="breadcrumb-item">Hacienda</li>
                                        <li class="breadcrumb-item active">Impuestos</li>
                                    </ol>
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- ZONA NOTIFIACIONS -->
                    <?php include_once("sections/notificacions.php") ?>

                    <!--<php include_once("sections/dashboard-topQuadres.php") ?>-->
                    <!--<php include_once("sections/dashboard-varisQuadres.php") ?>-->

                    <style>
                    .chooseModel{
                        margin-left:16.66%;
                    }
                    </style>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <?php
                                        $modelos=[303=>'IVA trimestral',130=>'IRPF trimestral',111=>'IRPF trimestral'];
                                        ?>
                                        <div class="chooseModel">
                                            <div class="row">
                                                <form action="impuestos.php" method="get" style="display:contents;">
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label>Modelo</label>
                                                            <select class="form-control" name="modelo">
                                                                <?php
                                                                if($_GET['modelo']==303){
                                                                    echo '<option value="303">303. IVA trimestral</option>';
                                                                    echo '<option value="130">130. IRPF trimestral</option>';
                                                                }else{
                                                                    echo '<option value="130">130. IRPF trimestral</option>';
                                                                    echo '<option value="303">303. IVA trimestral</option>';
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label>Ejercicio (año)</label>
                                                            <select class="form-control" name="ejercicio">
                                                                <?php 
                                                                if(date("Y")>2021){
                                                                    for($i=date('Y'); $i>=2021; $i=$i-1) { 
                                                                        echo '<option value="'.$i.'">'.$i.'</option>';
                                                                    }
                                                                }else{
                                                                    echo '<option value="2021">2021</option>';
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label>Periodo (trim.)</label>
                                                            <select class="form-control" name="periodo">
                                                                <option value="<?php echo $_GET['periodo'];?>"><?php echo $_GET['periodo'];?></option>
                                                                <?php
                                                                for($i=1; $i<=4; $i++){
                                                                    if($i!=$_GET['periodo'][0]){
                                                                        echo '<option value="'.$i.'T">'.$i.'T</option>';
                                                                    }
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3 exportModel">
                                                        <button type="submit" class="btn btn-success waves-effect waves-light mb-3">Ver modelo</button>
                                                        <a href="#" class="btn btn-outline-success waves-effect waves-light mb-3">Exportar</a>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body" id="modelDisplay">
                                    <?php 
                                    if($empresaPlan<1){
                                        echo '<span style="color:#999">Tu suscripción no contiene la cumplimentación automática de modelos para Hacienda. Actualízala ahora desde tu <a href="perfil.php">Perfil</a> para poder rellenarlos.</span>';
                                    }else{
                                        include_once('sections/impuestos-'.$_GET['modelo'].'.php');
                                    }
                                    ?>   
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end row -->


                </div> <!-- container-fluid -->
            </div>
            <!-- End Page-content -->


            <?php include_once("sections/footer.php") ?>
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
<script src="assets/js/pages/form-advanced.init.js"></script>
<script src="assets/libs/select2/js/select2.min.js"></script>
<script src="assets/libs/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
<script src="assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
<script src="assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js"></script>
<script src="assets/libs/bootstrap-maxlength/bootstrap-maxlength.min.js"></script>
<!-- JavaScripts custom -->
<script src="assets/js/app.js"></script>
<script src="js/script.js"></script>
<!-- Scripts custom -->
<script type="text/javascript">
function model(m,e,p){
    $('#modelDisplay').load('sections/impuestos-'+m+'.php?ejercicio='+e+'&periodo='+p);
};
</script>
</body>
</html>