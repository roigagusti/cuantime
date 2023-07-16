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
    <title>Cuantime. <?php echo $text['Expedients'];?></title>

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
                                <h4 class="mb-0"><?php echo $text['Expedients'];?></h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="index.php">Cuantime</a></li>
                                        <li class="breadcrumb-item active"><?php echo $text['Expedients'];?></li>
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
                                <button type="button" class="btn btn-success waves-effect waves-light mb-3" data-toggle="modal" data-target="#addExp"><i class="mdi mdi-plus mr-1"></i> <?php echo $text['Crear expedient'];?></button>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <!--<h4 class="card-title mb-4"></h4>-->
                                    <?php
                                    $projectes = $database->select("projectes",[
                                      "id",
                                      "exp",
                                      "nom",
                                      "estat",
                                      "idClient",
                                      "idUserEncarregat",
                                      "idUser",
                                      ],["AND"=>["idUser"=>$userAdminEmpresa],"ORDER"=>["exp"=>"DESC"]]);
                                    if(count($projectes)==0){echo "<span style='color:#999'>".$text['cap-expedient']."</span>";}else{
                                    ?>

                                    <div class="table-responsive" style="min-height:300px">
                                        <table class="table table-centered table-nowrap mb-0">
                                            <thead class="thead-light">
                                                <tr>
                                                    <!--th style="width: 20px;">
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="customCheck">
                                                            <label class="custom-control-label" for="customCheck">&nbsp;</label>
                                                        </div>
                                                    </th>-->
                                                    <th><?php echo $text['Número'];?></th>
                                                    <th><?php echo $text['Estat'];?></th>
                                                    <th><?php echo $text['Projecte'];?></th>
                                                    <th><?php echo $text['Client'];?></th>
                                                    <th><?php echo $text['Assignat'];?></th>
                                                    <th><?php echo $text['Ofertes'];?></th>
                                                    <th><?php echo $text['Dedicació'];?></th>
                                                    <th><?php echo $text['Cost'];?></th>
                                                    <th><?php echo $text['Balanç'];?></th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            <?php
                                            $i=0;
                                            foreach ($projectes as $projecte) {
                                                $i++;
                                                $clientNom = $database->get("clients","nom",["id"=>$projecte['idClient']]);

                                                $estat = ["-","Pausa","Por asignar","En proceso","Entregado", "Acabado"];
                                                $badge = ["","secondary","danger","warning","info","success"];

                                                $estatsOferta = ["-","Pendiente de honorarios","Esperando respuesta"];

                                                $estatOferta = $database->get("ofertes","estat",["idProjecte"=>$projecte['id']]);
                                                if($projecte['exp']=='' and $estatOferta<2){
                                                ?>
                                                <tr>
                                                    <td><a href="expedient-detall.php?id=<?php echo $projecte['id'];?>" class="text-body"><strong>------</strong></a></td>
                                                    <td><span class="badge badge-pill badge-soft-secondary font-size-12"><?php echo $estatsOferta[$estatOferta];?></span></td>
                                                    <td><a href="expedient-detall.php?id=<?php echo $projecte['id'];?>" class="text-body"><?php echo $projecte['nom'];?></a></td>
                                                    <td><?php echo '<a class="text-body" href="client-detall.php?id='.$projecte['idClient'].'">'.$clientNom.'</a>';?>
                                                    </td>
                                                    <td>-</td>
                                                    <td>-</td>
                                                    <td>-</td>
                                                    <td>-</td>
                                                    <td>-</td>
                                                </tr>
                                                <?php
                                                }

                                                if($projecte['exp']>0){if($projecte['exp']<9999999){
                                                    // Usuari assignat
                                                    if($projecte['idUserEncarregat']>0){
                                                        $userAssignatNom = $database->get("users","nom",["id"=>$projecte['idUserEncarregat']]);
                                                        $userAssignat=beautyNameTwoWords($userAssignatNom);
                                                    }else{
                                                        $userAssignat='-';
                                                    }

                                                    // Càlcul d'OFERTES
                                                    $sumaOfertesAcceptades = $database->sum("ofertes","preu",["AND"=>["idProjecte"=>$projecte['id'],"estat[>]"=>3]]);
                                                    
                                                    // Càlcul de DEDICACIÓ
                                                    $persones = $database->select("users", [
                                                        "id",
                                                        "nom",
                                                        "empresa",
                                                        "tipusColaborador",
                                                        "sou",
                                                        "horari",
                                                        "preu"
                                                        ],["AND"=>["empresa"=>$userEmpresa,"active"=>1],"ORDER"=>["nom"=>"ASC"]]);
                                                    $tempsDedicat=0;
                                                    $costProductiu=0;
                                                    foreach ($persones as $persona) {
                                                        $partesDedicats = $database->select("partes",["id","data","idProjecte","percentatge"],["AND"=>["idProjecte"=>$projecte['id'],"idUser"=>$persona['id']]]);
                                                        $tempsDedicatPerPersona=0;
                                                        $costProductiuPerPersona=0;
                                                        foreach($partesDedicats as $parteDedicat){
                                                            $parteExplode = explode('-',$parteDedicat['data']);
                                                            $diaParte = intval($parteExplode[2]);
                                                            $mesParte = $parteExplode[1];
                                                            $anyParte = $parteExplode[0];
                                                            $fitxatgesDedicats = $database->select("fitxatges", [
                                                            "id",
                                                            "timeIn",
                                                            "timeOut"
                                                            ],["timeIn[<>]"=>[date("Y-m-d", mktime(0, 0, 0, $mesParte, $diaParte, $anyParte)), date("Y-m-d", mktime(0, 0, 0, $mesParte, $diaParte+1, $anyParte))]]);
                                                            $tempsDedicatPerParte=0;
                                                            foreach ($fitxatgesDedicats as $fitxatgeDedicat) {
                                                                if($fitxatgeDedicat['timeOut']!=NULL){
                                                                    $tempsDedicatPerParte+=(strtotime($fitxatgeDedicat['timeOut'])-strtotime($fitxatgeDedicat['timeIn']));
                                                                }
                                                            }
                                                            $tempsDedicatPerPersona+=$tempsDedicatPerParte*(intval($parteDedicat['percentatge'])/100);

                                                            // Càlcul de COST PRODUCTIU
                                                            if($persona['tipusColaborador']==1){
                                                                $personaCost=$persona['preu'];
                                                            }else{
                                                                $personaCost=($persona['sou']/12)/($persona['horari']*4);
                                                            }
                                                            $costProductiuPerPersona=$tempsDedicatPerPersona*($personaCost/3600);
                                                        }
                                                        $tempsDedicat+=$tempsDedicatPerPersona;
                                                        $costProductiu+=$costProductiuPerPersona;
                                                    }

                                                    // Càlcul de BALANÇ
                                                    $balanc = $sumaOfertesAcceptades-$costProductiu;
                                                    
                                            ?>

                                                <tr>
                                                    <td><a href="expedient-detall.php?id=<?php echo $projecte['id'];?>" class="text-body"><strong><?php echo beautyExp($projecte['exp']);?></strong></a></td>
                                                    <td>
                                                        <div class="dropdown">
                                                            <a class="text-body" href="" role="button" data-toggle="dropdown" aria-haspopup="true">
                                                                <span class="badge badge-pill badge-soft-<?php echo $badge[$projecte['estat']];?> font-size-12"><?php echo $estat[$projecte['estat']];?></span>
                                                            </a>
                                                            <div class="dropdown-menu dropdown-menu-right text-right">
                                                                <a class="dropdown-item" href="conexiones/administracio.php?action=estatExp&estat=0&id=<?php echo $projecte['id'];?>">
                                                                    <span class="font-size-12">-</span>
                                                                </a>
                                                                <a class="dropdown-item" href="conexiones/administracio.php?action=estatExp&estat=1&id=<?php echo $projecte['id'];?>">
                                                                    <span class="badge badge-pill badge-soft-secondary font-size-12">Pausa</span>
                                                                </a>
                                                                <a class="dropdown-item" href="conexiones/administracio.php?action=estatExp&estat=2&id=<?php echo $projecte['id'];?>">
                                                                    <span class="badge badge-pill badge-soft-danger font-size-12">Por asignar</span>
                                                                </a>
                                                                <a class="dropdown-item" href="conexiones/administracio.php?action=estatExp&estat=3&id=<?php echo $projecte['id'];?>">
                                                                    <span class="badge badge-pill badge-soft-warning font-size-12">En proceso</span>
                                                                </a>
                                                                <a class="dropdown-item" href="conexiones/administracio.php?action=estatExp&estat=4&id=<?php echo $projecte['id'];?>">
                                                                    <span class="badge badge-pill badge-soft-info font-size-12">Entregado</span>
                                                                </a>
                                                                <a class="dropdown-item" href="conexiones/administracio.php?action=estatExp&estat=5&id=<?php echo $projecte['id'];?>">
                                                                    <span class="badge badge-pill badge-soft-success font-size-12">Acabado</span>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td><a href="expedient-detall.php?id=<?php echo $projecte['id'];?>" class="text-body"><?php echo $projecte['nom'];?></a></td>
                                                    <td><?php echo '<a class="text-body" href="client-detall.php?id='.$projecte['idClient'].'">'.$clientNom.'</a>';?>
                                                    </td>
                                                    <td>
                                                        <div class="dropdown">
                                                            <a class="text-body" href="#" role="button" data-toggle="dropdown" aria-haspopup="true">
                                                                <?php echo $userAssignat;?>
                                                            </a>
                                                            <div class="dropdown-menu dropdown-menu-right">
                                                                <?php
                                                                $recursosPersonal = $database->select("users",["id","nom","empresa"],["AND"=>["empresa"=>$userEmpresa,"active"=>1]]);
                                                                    echo '<a class="dropdown-item" href="conexiones/rrhh.php?action=asignProject&project='.$projecte['id'].'&id=0">-</a>';
                                                                foreach($recursosPersonal as $recursPersonal){
                                                                    $posiblesUsers = beautyNameTwoWords($recursPersonal['nom']);
                                                                    echo '<a class="dropdown-item" href="conexiones/rrhh.php?action=asignProject&project='.$projecte['id'].'&id='.$recursPersonal['id'].'">'.$posiblesUsers.'</a>';
                                                                }
                                                                ?>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <?php
                                                    ?>
                                                    <td><?php echo number_format($sumaOfertesAcceptades,2,",",".");?> €</td>
                                                    <?php 
                                                    if($tempsDedicat==0){
                                                        echo '<td style="color:#999">0h 00 min</td>';
                                                    }else{
                                                        echo '<td>'.beautyTime($tempsDedicat).'</td>';
                                                    }

                                                    if($costProductiu==0){
                                                        echo '<td style="color:#999">0.00 €</td>';
                                                    }else{
                                                        echo '<td>'.number_format($costProductiu,2,",",".").' €</td>';
                                                    }

                                                    if($balanc==0){
                                                        echo '<td style="color:#999">0.00 €</td>';
                                                    }else if($balanc<0){
                                                        echo '<td style="color:#f46a6a">'.number_format($balanc,2,",",".").' €</td>';
                                                    }else{
                                                        echo '<td style="color:#34c38f">'.number_format($balanc,2,",",".").' €</td>';
                                                    }
                                                    ?>
                                                </tr>
                                            <?php }}}?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <?php } ?>
                                    <!-- end table-responsive -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end row -->


                </div> <!-- container-fluid -->
            </div>
            <!-- End Page-content -->


            <?php include_once("sections/footer.php") ?>
            <?php include_once("sections/modal-addExp.php") ?>
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
<!--<script src="assets/libs/admin-resources/rwd-table/rwd-table.min.js"></script>-->
<script src="assets/js/pages/table-responsive.init.js"></script>
<!-- JavaScripts custom -->
<script src="assets/js/app.js"></script>
<!-- Scripts custom -->

</body>
</html>