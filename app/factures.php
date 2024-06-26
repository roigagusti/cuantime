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
?>
<!DOCTYPE html>
<html lang="es">
    <head>
    <!-- Meta data -->
    <?php include_once("sections/meta.php") ?>

    <!-- Títol i Favicons -->
    <title>Cuantime. <?php echo $text['Facturas'];?></title>

    <!-- CSS Libraries -->
    <link href="assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
    
    <link href="assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css">
    <link href="assets/libs/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css" rel="stylesheet">
    <link href="assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet">
    <link href="assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css" rel="stylesheet">
    <link href="assets/libs/bootstrap-editable/css/bootstrap-editable.css" rel="stylesheet">
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
                                <h4 class="mb-0"><?php echo $text['Facturas'];?></h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="index.php">Cuantime</a></li>
                                    <li class="breadcrumb-item active"><?php echo $text['Facturas'];?></li>
                                    </ol>
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- ZONA NOTIFIACIONS -->
                    <?php include_once("sections/notificacions.php") ?>

                    <!--<php include_once("sections/dashboard-topQuadres.php") ?>-->
                    <!--<php include_once("sections/dashboard-varisQuadres.php") ?>-->

                    <div class="row">
                        <div class="col-md-4">
                            <div>
                                <button type="button" class="btn btn-success waves-effect waves-light mb-3" data-toggle="modal" data-target="#addFactura"><i class="mdi mdi-plus mr-1"></i> <?php echo $text['Nueva factura'];?></button>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <!--<h4 class="card-title mb-4"></h4>-->
                                    <?php
                                    $factures = $database->select("factures", [
                                      "id",
                                      "numero",
                                      "idProjecte",
                                      "data",
                                      "import",
                                      "estat"
                                    ],["idUser"=>$userAdminEmpresa,"ORDER"=>["numero"=>"DESC"]]);
                                    $numFacturesToUser=count($factures);
                                    if($numFacturesToUser==0){echo "<span style='color:#999'>".$text['Aun no se ha añadido ninguna factura']."</span>";}else{
                                    ?>

                                    <div class="table-responsive" style="min-height:300px">
                                        <table class="table table-centered table-nowrap mb-0">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th style="width:100px"><?php echo $text['Número de factura'];?></th>
                                                    <th class="text-center" style="width:100px"><?php echo $text['Estado'];?></th>
                                                    <th class="text-center" style="width:100px"><?php echo $text['Importe'];?></th>
                                                    <th><?php echo $text['Cliente'];?></th>
                                                    <th class="text-center" style="width:100px"><?php echo $text['Fecha'];?></th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            <?php
                                            foreach ($factures as $factura) {
                                                $projecteNom = $database->get("projectes","nom",["id"=>$factura['idProjecte']]);
                                                $clientId = $database->get("projectes","idClient",["id"=>$factura['idProjecte']]);
                                                $clientNom = $database->get("clients","nom",["id"=>$clientId]);
                                                $estat = ["Pendiente","Pagado"];
                                                $badge = ["warning","success"];
                                            ?>

                                                <tr>
                                                    <td><a href="factura-detall.php?id=<?php echo $factura['id'];?>" class="text-body font-weight-bold" style="cursor:pointer"><?php echo "F_".beautyExp($factura['numero']);?></a> </td>
                                                    <td class="text-center">
                                                        <div class="dropdown">
                                                            <a class="text-body" href="#" role="button" data-toggle="dropdown" aria-haspopup="true">
                                                                <span class="badge badge-soft-<?php echo $badge[$factura['estat']-1];?> font-size-12"><?php echo $estat[$factura['estat']-1];?></span>
                                                            </a>
                                                            <div class="dropdown-menu dropdown-menu-right text-right">
                                                                <a class="dropdown-item" href="conexiones/administracio.php?action=estatFactura&estat=1&id=<?php echo $factura['id'];?>">
                                                                    <span class="badge badge-pill badge-soft-warning font-size-12"><?php echo $text['Pendiente'];?></span>
                                                                </a>
                                                                <a class="dropdown-item" href="conexiones/administracio.php?action=estatFactura&estat=2&id=<?php echo $factura['id'];?>">
                                                                    <span class="badge badge-pill badge-soft-success font-size-12"><?php echo $text['Pagado'];?></span>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="text-right"><?php echo number_format($factura['import'],2,",",".");?> €</td>
                                                    <td><a class="text-body" href="client-detall.php?id=<?php echo $clientId;?>"><?php echo $clientNom;?></a></td>
                                                    <td class="text-center"><?php echo date("d.m.Y", strtotime($factura['data']));?></td>
                                                </tr>
                                            <?php }?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- end table-responsive -->
                                    <?php }?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end row -->


                </div> <!-- container-fluid -->
            </div>
            <!-- End Page-content -->


            <?php include_once("sections/footer.php") ?>
            <?php include_once("sections/modal-addFactura.php") ?>
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


<script src="assets/libs/bootstrap-editable/js/index.js"></script>
<script src="assets/libs/moment/min/moment.min.js"></script>
<script src="assets/js/pages/form-xeditable.init.js"></script> 
<!-- JavaScripts custom -->
<script src="assets/js/app.js"></script>
<script src="js/script.js"></script>
<!-- Scripts custom -->

</body>
</html>