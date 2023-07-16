<?php
// Redirecció a HTTPS
if(!isset($_SERVER["HTTPS"]) || $_SERVER["HTTPS"] != "on"){
  header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"], true, 301);
  exit;
}
include_once("conexiones/conexion.php");
session_start();
include_once("sections/sessionStart.php");
?>
<!DOCTYPE html>
<html lang="es">
    <head>
    <!-- Meta data -->
    <?php include_once("sections/meta.php") ?>

    <!-- Títol i Favicons -->
    <title>011h. Time report</title>

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
                                <h4 class="mb-0">Time report</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="index.php">011h</a></li>
                                    <li class="breadcrumb-item active">Time report</li>
                                    </ol>
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- ZONA NOTIFIACIONS -->
                    <?php include_once("sections/notificacions.php") ?>

                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive" style="min-height:300px">

                                        <table id="mainTable" class="table table-centered table-nowrap mb-0">
                                            <thead class="thead-light tr-center">
                                                <tr>
                                                    <th class="tr-concept">Concept</th>
                                                    <th>Lunes, 31 Enero</th>
                                                    <th>Martes, 1 Febrero</th>
                                                    <th>Miércoles, 2 Febrero</th>
                                                    <th>Jueves, 3 Febrero</th>
                                                    <th>Viernes, 4 Febrero</th>
                                                    <th>Sábado, 5 Febrero</th>
                                                    <th>Domingo, 6 Febrero</th>
                                                </tr>
                                            </thead>
                                            <style>.tr-concept{text-align:left !important}.tr-center, .tr-center th{text-align:center}.tr-resume{text-align:center;font-weight:bold}.table-responsive{border:none !important}</style>
                                            <tbody class="tr-center">
                                                <tr>
                                                    <td class="tr-concept">To reduce PEC</td>
                                                    <td>8.0</td>
                                                    <td>8.0</td>
                                                    <td>0.0</td>
                                                    <td>8.0</td>
                                                    <td>8.0</td>
                                                    <td>0.0</td>
                                                    <td>0.0</td>
                                                </tr>
                                                <tr>
                                                    <td class="tr-concept">Permisos retribuidos</td>
                                                    <td>0.0</td>
                                                    <td>0.0</td>
                                                    <td>0.0</td>
                                                    <td>8.0</td>
                                                    <td>0.0</td>
                                                    <td>0.0</td>
                                                    <td>0.0</td>
                                                </tr>
                                                <tr>
                                                    <td class="tr-concept">Holidays</td>
                                                    <td>0.0</td>
                                                    <td>0.0</td>
                                                    <td>0.0</td>
                                                    <td>0.0</td>
                                                    <td>0.0</td>
                                                    <td>0.0</td>
                                                    <td>0.0</td>
                                                </tr>
                                                <tr>
                                                    <td class="tr-concept">Others</td>
                                                    <td>0.0</td>
                                                    <td>0.0</td>
                                                    <td>0.0</td>
                                                    <td>0.0</td>
                                                    <td>0.0</td>
                                                    <td>0.0</td>
                                                    <td>0.0</td>
                                                </tr>
                                            </tbody>
                                            <tfoot class="thead-light tr-resume">
                                                <tr>
                                                    <th class="tr-concept">TOTAL</th>
                                                    <td>8.0</td>
                                                    <td>8.0</td>
                                                    <td>8.0</td>
                                                    <td>8.0</td>
                                                    <td>8.0</td>
                                                    <td>0.0</td>
                                                    <td>0.0</td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div>
                                <button type="button" class="btn btn-success waves-effect waves-light mb-3" data-toggle="modal" data-target="#addExp">Guardar</button>
                            </div>
                        </div>
                    </div>
                    <!-- end row -->


                </div> <!-- container-fluid -->
            </div>
            <!-- End Page-content -->


            <?php include_once("sections/footer.php") ?>
            <?php include_once("sections/modal-addClient.php") ?>
            <?php include_once("sections/modal-removeConfirm.php") ?>
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

<script src="//gurayyarar.github.io/AdminBSBMaterialDesign//plugins/bootstrap-select/js/bootstrap-select.js"></script>
<script src="//gurayyarar.github.io/AdminBSBMaterialDesign//plugins/jquery-slimscroll/jquery.slimscroll.js"></script>
<script src="//gurayyarar.github.io/AdminBSBMaterialDesign//plugins/node-waves/waves.js"></script>
<script src="//gurayyarar.github.io/AdminBSBMaterialDesign//plugins/editable-table/mindmup-editabletable.js"></script>
<script src="//gurayyarar.github.io/AdminBSBMaterialDesign//js/pages/tables/editable-table.js"></script>    
<!-- JavaScripts custom -->
<script src="assets/js/app.js"></script>
<!-- Scripts custom -->

</body>
</html>