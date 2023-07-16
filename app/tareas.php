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

$pagina = 'tareas';
?>
<!DOCTYPE html>
<html lang="es">
    <head>
    <!-- Meta data -->
    <?php include_once("sections/meta.php") ?>

    <!-- Títol i Favicons -->
    <title>Cuantime. Tareas</title>

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
                                <h4 class="mb-0">Tareas</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="index.php">Cuantime</a></li>
                                        <li class="breadcrumb-item active">Tareas</li>
                                    </ol>
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
                                <button type="button" class="btn btn-success waves-effect waves-light mb-3" data-toggle="modal" data-target="#addTask"><i class="mdi mdi-plus mr-1"></i> Añadir tarea</button>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <?php
                        if($userType<2){
                            $projectes = $database->select("projectes", [
                            "id",
                            "exp",
                            "idClient",
                            "nom",
                            "estat",
                            "created_date",
                            "idUser",
                            "assignacioEncarregat"
                            ],["AND"=>["idUser"=>$userAdminEmpresa,"exp[>]"=>0,"estat[>]"=>2,"estat[<]"=>5],"ORDER"=>["created_date"=>"DESC"]]);
                        }else{
                            $projectes = $database->select("projectes", [
                            "id",
                            "exp",
                            "idClient",
                            "nom",
                            "estat",
                            "created_date",
                            "assignacioEncarregat"
                            ],["AND"=>["idUserEncarregat"=>$userId,"exp[>]"=>0,"estat[>]"=>2,"estat[<]"=>5],"ORDER"=>["created_date"=>"DESC"]]);
                        }

                        if(count($projectes)==0){echo '<div class="col-md-12"><div class="card"><div class="card-body"><span style="color:#999">Aun no se te ha asignado ningún proyecto</span></div></div></div>';}else{

                        foreach($projectes as $projecte){
                            $projecteNom = $projecte['nom'];
                            $projecteExp = $projecte['exp'];
                        ?>
                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-body">
                                    <a href="expedient-detall.php?id=<?php echo $projecte['id'];?>" class="text-body"><strong><?php echo beautyExp($projecte['exp']);?></strong>. <?php echo $projecte['nom'];?></a>

                                    <?php
                                    $tasques = $database->select("tasques", [
                                        "id",
                                        "idProjecte",
                                        "idUser",
                                        "titol",
                                        "missatge",
                                        "prioritat",
                                        "active",
                                        "created_date"
                                        ],["AND"=>["idProjecte"=>$projecte['id'],"active"=>1],"ORDER"=>["created_date"=>"ASC"]
                                    ]);
                                    if(count($tasques)==0){echo '<div class="row"><div class="col-md-12 notTasks text-center">No hay tareas</div></div>';}
                                    foreach($tasques as $tasca){
                                        $estat = ["Sin prisa","Tener en cuenta","Manos a la obra", "Urgente"];
                                        $badge = ["secondary","info","warning","danger"];
                                    ?>
                                    <div class="taskItem shadow-none">
                                        <a href="#tascaCollapse<?php echo $tasca['id'];?>" class="collapsed text-body" data-toggle="collapse">
                                            <div class="taskTitle">
                                                <?php echo $tasca['titol'];?>
                                            </div>
                                        </a>

                                        <div id="tascaCollapse<?php echo $tasca['id'];?>" class="collapse">
                                            <div class="card-body taskBody">
                                                <div class="row">
                                                    <div class="taskTime">
                                                        <?php echo dateDistance($tasca['created_date']);?>
                                                    </div>

                                                    <div class="taskPriority text-right">
                                                        <div class="dropdown show">
                                                            <a class="text-body" href="" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                            </a>
                                                            <a class="text-body" href="" role="button" data-toggle="dropdown" aria-haspopup="true">
                                                                <span class="badge badge-pill badge-soft-<?php echo $badge[$tasca['prioritat']];?> font-size-12"><?php echo $estat[$tasca['prioritat']];?></span>
                                                            </a>
                                                            <div class="dropdown-menu dropdown-menu-right text-right">
                                                                <a class="dropdown-item" href="conexiones/administracio.php?action=estatTask&prioritat=0&id=<?php echo $tasca['id'];?>">
                                                                    <span class="badge badge-pill badge-soft-secondary font-size-12">Sin prisa</span>
                                                                </a>
                                                                <a class="dropdown-item" href="conexiones/administracio.php?action=estatTask&prioritat=1&id=<?php echo $tasca['id'];?>">
                                                                    <span class="badge badge-pill badge-soft-info font-size-12">Tener en cuenta</span>
                                                                </a>
                                                                <a class="dropdown-item" href="conexiones/administracio.php?action=estatTask&prioritat=2&id=<?php echo $tasca['id'];?>">
                                                                    <span class="badge badge-pill badge-soft-warning font-size-12">Manos a la obra</span>
                                                                </a>
                                                                <a class="dropdown-item" href="conexiones/administracio.php?action=estatTask&prioritat=3&id=<?php echo $tasca['id'];?>">
                                                                    <span class="badge badge-pill badge-soft-danger font-size-12">Urgente</span>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="taskDescription">
                                                    <?php echo nl2br($tasca['missatge']);?>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12 taskClose text-center">
                                                        <a href="conexiones/administracio.php?action=removeTask&id=<?php echo $tasca['id'];?>">Borrar tarea</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>

                                </div>
                            </div>
                        </div>
                        <?php }} ?>
                    </div>
                    <!-- end row -->


                </div> <!-- container-fluid -->
            </div>
            <!-- End Page-content -->


            <?php include_once("sections/footer.php") ?>
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

</body>
</html>