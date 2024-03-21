<?php
// Redirecció a HTTPS
if(!isset($_SERVER["HTTPS"]) || $_SERVER["HTTPS"] != "on"){
  header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"], true, 301);
  exit;
}
include_once("conexiones/conexion.php");
session_start();
include_once("sections/sessionStart.php");

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
    <title>Cuantime. <?php echo $text['Clientes'];?></title>

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
                                <h4 class="mb-0"><?php echo $text['Perfil de contacto'];?></h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="index.php">Cuantime</a></li>
                                    <li class="breadcrumb-item"><a href="clients.php"><?php echo $text['Clientes'];?></a></li>
                                    <li class="breadcrumb-item active"><?php echo $text['Perfil de contacto'];?></li>
                                    </ol>
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- ZONA NOTIFIACIONS -->
                    <?php include_once("sections/notificacions.php") ?>

                    <?php
                    $clientNom = $database->get("clients","nom",["id"=>$_GET['id']]);
                    $clientEmpresa = $database->get("clients","empresa",["id"=>$_GET['id']]);
                    $clientDireccio = $database->get("clients","direccio",["id"=>$_GET['id']]);
                    $clientCP = $database->get("clients","codiPostal",["id"=>$_GET['id']]);
                    $clientCiutat = $database->get("clients","ciutat",["id"=>$_GET['id']]);
                    $clientCIF = $database->get("clients","cif",["id"=>$_GET['id']]);
                    $clientTelefon = $database->get("clients","telefon",["id"=>$_GET['id']]);
                    $clientMail = $database->get("clients","mail",["id"=>$_GET['id']]);
                    $clientUser = $database->get("clients","idUser",["id"=>$_GET['id']]);

                    $inicials = inicials($clientNom);
                    ?>

                    <div class="row mb-4">
                        <?php 
                        if($clientUser!=$userEmpresa){echo '<div class="col-lg-12"><div class="card h-100"><div class="card-body">La página a la que intentas acceder no está disponible</div></div></div><div class="d-print-none mt-4"><a href="clients.php" class="btn btn-link text-muted"><i class="uil uil-arrow-left mr-1"></i> Volver a clientes</a></div>';
                            }else{
                        ?>
                        <div class="col-xl-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="text-center">
                                        <div class="dropdown float-right">
                                            <a class="text-body dropdown-toggle font-size-18" href="#" role="button" data-toggle="dropdown" aria-haspopup="true">
                                              <i class="uil uil-ellipsis-v"></i>
                                            </a>
                                          
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item" data-toggle="modal" data-target="#editClient" style="cursor:pointer;"><?php echo $text['Editar contacto'];?></a>
                                                <a class="dropdown-item text-danger" data-toggle="modal" data-target="#removeConfirm" style="cursor:pointer;"><?php echo $text['Borrar contacto'];?></a>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                            <div class="avatar-lg mx-auto mb-4">
                                                <div class="avatar-title bg-soft-primary rounded-circle text-primary">
                                                    <span style="font-size:2.0em;"><?php echo $inicials;?></span>
                                                </div>
                                            </div>
                                        <h5 class="mt-3 mb-1"><?php echo $clientNom;?></h5>
                                        <p class="text-muted"><?php echo $clientEmpresa;?></p>

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
                                                <p class="mb-1"><?php echo $text['Nombre'];?>:</p>
                                                <h5 class="font-size-16"><?php echo $clientNom;?></h5>
                                            </div>
                                            
                                            <?php if($clientTelefon!=""){?>
                                            <div class="mt-4">
                                                <p class="mb-1"><?php echo $text['Teléfono'];?>:</p>
                                                <h5 class="font-size-16"><?php echo $clientTelefon;?></h5>
                                            </div>
                                        <?php } if($clientMail!=""){?>
                                            <div class="mt-4">
                                                <p class="mb-1"><?php echo $text['E-mail'];?>:</p>
                                                <h5 class="font-size-16"><?php echo $clientMail;?></h5>
                                            </div>
                                        <?php } if($clientCIF!=""){?>
                                            <div class="mt-4">
                                                <p class="mb-1"><?php echo $text['CIF'];?>:</p>
                                                <h5 class="font-size-16"><?php echo $clientCIF;?></h5>
                                            </div>
                                        <?php }?>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="d-print-none mt-4">
                                <a href="clients.php" class="btn btn-link text-muted">
                                    <i class="uil uil-arrow-left mr-1"></i> <?php echo $text['Volver a clientes'];?>
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
                                            <span class="d-none d-sm-block"><?php echo $text['Proyectos'];?></span> 
                                        </a>
                                    </li>
                                </ul>
                                <!-- Tab content -->
                                <?php
                                $numProjectes = $database->count("projectes",["idClient"=>$_GET['id']]);
                                if($numProjectes<1){echo '<span class="p-4 text-center">'.$text['No hay proyectos'].'</span>';}else{
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
                                                                <th scope="col"><?php echo $text['Proyectos'];?></th>
                                                                <th scope="col"><?php echo $text['Fecha'];?></th>
                                                                <th scope="col"><?php echo $text['Estado'];?></th>
                                                                <th scope="col" style="width: 120px;"><?php echo $text['Oferta'];?></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                             $projectes = $database->select("projectes", [
                                                                "id",
                                                                "idClient",
                                                                "nom",
                                                                "estat",
                                                                "created_date"
                                                                ],["idClient"=>$_GET['id']]);
                                                            $i=0;
                                                            foreach($projectes as $projecte){
                                                                $i++;
                                                                $estat = ["-","Pausa","En proceso","Entregado", "Acabado"];
                                                                $badge = ["","secondary","warning","info","success"];

                                                                $projecteNom = $projecte['nom'];
                                                                $projecteEstat = $projecte['estat'];

                                                                $projecteOferta = $database->get("ofertes","preu",["idProjecte"=>$projecte['id']]);
                                                            ?>
                                                            <tr>
                                                                <th scope="row"><?php echo $i;?></th>
                                                                <td><a href="#" class="text-dark"><?php echo $projecteNom;?></a></td>
                                                                <td><?php echo date('d-m-Y',strtotime($projecte['created_date']));?></td>
                                                                <td>
                                                                    <span class="badge badge-soft-<?php echo $badge[$projecteEstat];?> font-size-12"><?php echo $estat[$projecteEstat];?></span>
                                                                </td>
                                                                <td><?php echo number_format($projecteOferta,2,",",".");?> €</td>
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
                        <?php } ?>
                    </div>
                    <!-- end row -->


                </div> <!-- container-fluid -->
            </div>
            <!-- End Page-content -->


            <?php include_once("sections/footer.php") ?>
            <?php include_once("sections/modal-editClient.php") ?>
            <?php include_once("sections/modal-removeClient.php") ?>
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