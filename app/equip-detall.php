<?php
// Redirecció a HTTPS
if(!isset($_SERVER["HTTPS"]) || $_SERVER["HTTPS"] != "on"){
  header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"], true, 301);
  exit;
}
include_once("conexiones/conexion.php");
session_start();
include_once("sections/sessionStart.php");

function beautyTime($time){
    //Entro un valor en segons, que em permet fer diferencies de temps en segons, i surt "0h 00 min".
    $horesDiaries = floor(intval($time)/3600);
    $minutsDiaris = round((intval($time)%3600)/60,0);
    if($minutsDiaris < 10){$minutsDiaris = "0".$minutsDiaris;}
    return $horesDiaries."h ".$minutsDiaris." min";
}
function inicials($name){
    //Entro un nom complet i obtinc un nom paraula+espai+paraula.
    $trans = array("À"=>"A","Á"=>"A","È"=>"E","É"=>"E","Ì"=>"I","Í"=>"I","Ò"=>"O","Ó"=>"O","Ù"=>"U","Ú"=>"U");
    $nomWords = explode(" ", strtr($name,$trans));
    $inicials = strtoupper($nomWords[0][0].$nomWords[1][0]);
    return $inicials;
}
?>
<!DOCTYPE html>
<html lang="es">
    <head>
    <!-- Meta data -->
    <?php include_once("sections/meta.php") ?>

    <!-- Títol i Favicons -->
    <title>Cuantime. Equipo</title>

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
                                <h4 class="mb-0">Perfil de colaborador</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="index.php">Cuantime</a></li>
                                    <li class="breadcrumb-item"><a href="equip.php">Equip</a></li>
                                    <li class="breadcrumb-item active">Perfil de colaborador</li>
                                    </ol>
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- ZONA NOTIFIACIONS -->
                    <?php include_once("sections/notificacions.php") ?>

                    <?php
                    $tipusUsuaris=['Administrador','Completo','Básico'];
                    $tipusColaboracions=['Fija','Variable'];

                    $userNom = $database->get("users","nom",["id"=>$_GET['id']]);
                    $userEmail = $database->get("users","email",["id"=>$_GET['id']]);
                    
                    $userIdEmpresa = $database->get("users","empresa",["id"=>$_GET['id']]);
                    $userEmpresa = $database->get("empreses","empresaNom",["id"=>$userIdEmpresa]);

                    $userTipus = $tipusUsuaris[$database->get("users","tipusUsuari",["id"=>$_GET['id']])];
                    $userColaborador = $tipusColaboracions[$database->get("users","tipusColaborador",["id"=>$_GET['id']])];

                    $inicials = inicials($userNom);
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
                                                <a class="dropdown-item" data-toggle="modal" data-target="#editUser" style="cursor:pointer;">Editar colaborador</a>
                                                <a class="dropdown-item text-danger" data-toggle="modal" data-target="#removeConfirm" style="cursor:pointer;">Borrar colaborador</a>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                            <div class="avatar-lg mx-auto mb-4">
                                                <div class="avatar-title bg-soft-primary rounded-circle text-primary">
                                                    <span style="font-size:2.0em;"><?php echo $inicials;?></span>
                                                </div>
                                            </div>
                                        <h5 class="mt-3 mb-1"><?php echo $userNom;?></h5>
                                        <p class="text-muted"><?php echo $userEmpresa;?></p>

                                        <div class="mt-4">
                                            <a href="mailto:<?php echo $userEmail;?>" class="btn btn-light btn-sm"><i class="uil uil-envelope-alt mr-2"></i> Enviar email</a>
                                        </div>
                                    </div>

                                    <hr class="my-4">

                                    <div class="text-muted">
                                        <div class="table-responsive mt-4">
                                            <div>
                                                <p class="mb-1">Nombre:</p>
                                                <h5 class="font-size-16"><?php echo $userNom;?></h5>
                                            </div>
                                            <div class="mt-4">
                                                <p class="mb-1">E-mail:</p>
                                                <h5 class="font-size-16"><?php echo $userEmail;?></h5>
                                            </div>
                                            <div class="mt-4">
                                                <p class="mb-1">Tipo de usuario:</p>
                                                <h5 class="font-size-16"><?php echo $userTipus;?></h5>
                                            </div>
                                            <div class="mt-4">
                                                <p class="mb-1">Tipo de colaboración:</p>
                                                <h5 class="font-size-16"><?php echo $userColaborador;?></h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="d-print-none mt-4">
                                <a href="equip.php" class="btn btn-link text-muted">
                                    <i class="uil uil-arrow-left mr-1"></i> Volver a equipo
                                </a>
                            </div>
                        </div>

                        <div class="col-xl-8">
                            <div class="card mb-0">
                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-toggle="tab" href="#tasks" role="tab">
                                            <i class="uil uil-clipboard-notes font-size-20"></i>
                                            <span class="d-none d-sm-block">Proyectos</span> 
                                        </a>
                                    </li>
                                </ul>
                                <!-- Tab content -->
                                <?php
                                $numProjectes = $database->count("projectes",["idUserEncarregat"=>$_GET['id']]);
                                if($numProjectes<1){echo '<span class="p-4 text-center">No hay proyectos</span>';}else{
                                ?>
                                <div class="tab-content p-4">
                                    <div class="tab-pane active" id="about" role="tabpanel">
                                        <div>
                                            <div>
                                                <div class="table-responsive">
                                                    <table class="table table-nowrap table-hover mb-0">
                                                        <thead>
                                                            <tr>
                                                                <th scope="col">#</th>
                                                                <th scope="col">Proyectos</th>
                                                                <th scope="col">Dedicación</th>
                                                                <th scope="col">Estado</th>
                                                                <th scope="col" style="width: 120px;">Oferta</th>
                                                                <th scope="col" style="width: 120px;" class="text-center">Asignación</th>
                                                                <th scope="col" style="width: 120px;">Ganancia</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                             $projectes = $database->select("projectes", [
                                                                "id",
                                                                "exp",
                                                                "idClient",
                                                                "nom",
                                                                "estat",
                                                                "created_date",
                                                                "assignacioEncarregat"
                                                                ],["idUserEncarregat"=>$_GET['id'],"ORDER"=>["created_date"=>"DESC"]]);
                                                            $i=0;
                                                            foreach($projectes as $projecte){
                                                                $i++;
                                                                $estat = ["-","Pausa","Por asignar","En proceso","Entregado", "Acabado"];
                                                                $badge = ["","secondary","danger","warning","info","success"];

                                                                $projecteNom = $projecte['nom'];
                                                                $projecteEstat = $projecte['estat'];

                                                                $projecteOferta = $database->sum("ofertes","preu",["idProjecte"=>$projecte['id']]);

                                                                // Càlcul de DEDICACIÓ
                                                                $partesDedicats = $database->select("partes",["id","data","idProjecte","percentatge"],["idProjecte"=>$projecte['id']]);
                                                                $tempsDedicat=0;
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
                                                                    $tempsDedicat+=$tempsDedicatPerParte*(intval($parteDedicat['percentatge'])/100);
                                                                }
                                                            ?>
                                                            <tr>
                                                                <td scope="row"><?php echo $i;?></td>
                                                                <td><a href="expedient-detall.php?id=<?php echo $projecte['id'];?>" class="text-dark"><?php echo $projecteNom;?></a></td>
                                                                <?php 
                                                                if($tempsDedicat==0){
                                                                    echo '<td style="color:#999">0h 00 min</td>';
                                                                }else{
                                                                    echo '<td>'.beautyTime($tempsDedicat).'</td>';
                                                                }?>
                                                                <td>
                                                                    <span class="badge badge-soft-<?php echo $badge[$projecteEstat];?> font-size-12"><?php echo $estat[$projecteEstat];?></span>
                                                                </td>
                                                                <td><?php echo number_format($projecteOferta,2,",",".");?> €</td>
                                                                <td class="text-center"><?php echo number_format($projecte['assignacioEncarregat'],2,",",".");?> %</td>
                                                                <td><?php echo number_format($projecteOferta*($projecte['assignacioEncarregat']/100),2,",",".");?> €</td>
                                                            </tr>
                                                            <?php }?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                            </div>
                        </div>
                    </div>
                    <!-- end row -->


                </div> <!-- container-fluid -->
            </div>
            <!-- End Page-content -->


            <?php include_once("sections/footer.php") ?>
            <?php include_once("sections/modal-editUser.php") ?>
            <?php include_once("sections/modal-removeUser.php") ?>
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
<!-- JavaScripts custom -->
<script src="assets/js/app.js"></script>
<!-- Scripts custom -->

</body>
</html>