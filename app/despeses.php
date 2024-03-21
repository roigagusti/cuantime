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
?>
<!DOCTYPE html>
<html lang="es">
    <head>
    <!-- Meta data -->
    <?php include_once("sections/meta.php") ?>

    <!-- Títol i Favicons -->
    <title>Cuantime. <?php echo $text['Gastos'];?></title>

    <!-- CSS Libraries -->
    <link href="assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
    <link href="assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet">
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
                                <h4 class="mb-0"><?php echo $text['Gastos'];?></h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="index.php">Cuantime</a></li>
                                    <li class="breadcrumb-item active"><?php echo $text['Gastos'];?></li>
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
                                <button type="button" class="btn btn-success waves-effect waves-light mb-3" data-toggle="modal" data-target="#addDespesa"><i class="mdi mdi-plus mr-1"></i> <?php echo $text['Nuevo gasto'];?></button>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <!--<h4 class="card-title mb-4"></h4>-->
                                    <?php
                                    $despeses = $database->select("despeses", [
                                      "id",
                                      "idProjecte",
                                      "idUser",
                                      "data",
                                      "import",
                                      "iva",
                                      "irpf",
                                      "concepte",
                                      "proveidor"
                                    ],["idUser"=>$userAdminEmpresa,"ORDER"=>["data"=>"DESC"]]);
                                    $numDespesesToUser=count($despeses);
                                    if($numDespesesToUser==0){echo "<span style='color:#999'>".$text['Aun no se ha añadido ningún gasto']."</span>";}else{
                                    ?>

                                    <div class="table-responsive" style="min-height:300px">
                                        <table class="table table-centered table-nowrap mb-0">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th class="text-center" style="width:50px"><?php echo $text['Año'];?></th>
                                                    <th class="text-center" style="width:50px"><?php echo $text['Trimestre'];?></th>
                                                    <th class="text-center" style="width:100px"><?php echo $text['Fecha'];?></th>
                                                    <th><?php echo $text['Concepto'];?></th>
                                                    <th><?php echo $text['Proveedor'];?></th>
                                                    <th style="width:100px"><?php echo $text['Importe'];?></th>
                                                    <th style="width:100px">IVA</th>
                                                    <th style="width:100px">IRPF</th>
                                                    <th style="width:100px"><?php echo $text['Cobrado'];?></th>
                                                    <th><?php echo $text['Proyecto'];?></th>
                                                    <th style="width:30px"></th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            <?php
                                            foreach($despeses as $despesa){
                                                $anyDespesa = date("Y", strtotime($despesa['data']));
                                                $trimestreDespesa = trimestre($despesa['data'])."T";
                                                $projecteNom = $despesa['idProjecte'];
                                                if($projecteNom!="General"){
                                                    $projecteNom = $database->get("projectes","nom",["id"=>$despesa['idProjecte']]);
                                                }
                                                if(strlen($projecteNom)==0){$projecteNom="-";}
                                                if($despesa['iva']>0){$despesaIva=$despesa['import']*($despesa['iva']/100);}else{$despesaIva=0;}
                                                if($despesa['irpf']>0){$despesaIrpf=$despesa['import']*($despesa['irpf']/100);}else{$despesaIrpf=0;}
                                                $gastoBrut = $despesa['import']+$despesaIva-$despesaIrpf;
                                            ?>

                                                <tr>
                                                    <td class="text-center" ><?php echo $anyDespesa;?></td>
                                                    <td class="text-center"><?php echo $trimestreDespesa;?></td>
                                                    <td class="text-center" ><?php echo date("d.m.Y", strtotime($despesa['data']));?></td>
                                                    <td><a href="despesa-detall.php?id=<?php echo $despesa['id'];?>" class="text-body"><?php echo $despesa['concepte'];?></a></td>
                                                    <td><?php echo $despesa['proveidor'];?></td>
                                                    <td><?php echo number_format($despesa['import'],2,",",".");?> €</td>
                                                    <td><?php echo number_format($despesaIva,2,",",".");?> €</td>
                                                    <td><?php echo number_format($despesaIrpf,2,",",".");?> €</td>
                                                    <td><?php echo number_format($gastoBrut,2,",",".");?> €</td>
                                                    <td><?php echo $projecteNom;?></td>
                                                    <td>
                                                        <li class="list-inline-item dropdown">
                                                            <a class="text-body" href="despesa-detall.php?id=<?php echo $despesa['id'];?>">
                                                                <i class="uil uil-ellipsis-v"></i>
                                                            </a>
                                                        </li>
                                                    </td>
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
            <?php include_once("sections/modal-addDespesa.php") ?>
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

<script src="assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
<!-- JavaScripts custom -->
<script src="assets/js/app.js"></script>
<script src="js/script.js"></script>
<!-- Scripts custom -->

</body>
</html>