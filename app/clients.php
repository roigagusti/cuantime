<?php
// Redirecció a HTTPS
if(!isset($_SERVER["HTTPS"]) || $_SERVER["HTTPS"] != "on"){
  header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"], true, 301);
  exit;
}
include_once("conexiones/conexion.php");
session_start();
include_once("sections/sessionStart.php");

function telefon($a){
    if(strlen($a)==9){
      return substr($a,0,3).' '.substr($a,3,3).' '.substr($a,6,3);
    }else if(substr($a,0,3)=='+34'||substr($a,0,3)=='+33'){
      return '+'.substr($a,1,2).' '.substr($a,3,3).' '.substr($a,6,3).' '.substr($a,9,3);
    }
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
                                <h4 class="mb-0"><?php echo $text['Clientes'];?></h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="index.php">Cuantime</a></li>
                                    <li class="breadcrumb-item active"><?php echo $text['Clientes'];?></li>
                                    </ol>
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- ZONA NOTIFIACIONS -->
                    <?php include_once("sections/notificacions.php") ?>

                    <div class="row">
                        <div class="col-md-4">
                            <div>
                                <button type="button" class="btn btn-success waves-effect waves-light mb-3" data-toggle="modal" data-target="#addClient"><i class="mdi mdi-plus mr-1"></i> <?php echo $text['Nuevo cliente'];?></button>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <!--<h4 class="card-title mb-4"></h4>-->
                                    <?php
                                    $numClients = $database->count("clients",["idUser"=>$userEmpresa]);
                                    if(isset($_GET['page'])){
                                        $page = $_GET['page'];
                                    }else{
                                        $page = 1;
                                    }
                                    $pages = ceil($numClients/10);
                                    $limitStart = $page*10-10;
                                    $limitEnd = $limitStart+10;
                                    $clients = $database->select("clients", [
                                      "id",
                                      "nom",
                                      "empresa",
                                      "mail",
                                      "telefon",
                                      "direccio",
                                      "codiPostal",
                                      "ciutat",
                                      "idUser"
                                      ],["idUser"=>$userEmpresa,"ORDER"=>["nom"=>"ASC"],"LIMIT"=>[$limitStart,$limitEnd]]);
                                    $numClientsToUser=count($clients);
                                    if($numClientsToUser==0){echo "<span style='color:#999'>".$text['Aun no se ha añadido ningún cliente']."</span>";}else{
                                    ?>
                                    <div class="table-responsive">
                                        <table class="table table-centered table-nowrap mb-0">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th scope="col"><?php echo $text['Nombre'];?></th>
                                                    <th scope="col"><?php echo $text['Empresa'];?></th>
                                                    <th scope="col"><?php echo $text['Email'];?></th>
                                                    <th class="text-center" scope="col"><?php echo $text['Teléfono'];?></th>
                                                    <th scope="col"><?php echo $text['Dirección'];?></th>
                                                    <th class="text-center" scope="col"><?php echo $text['Código Postal'];?></th>
                                                    <th scope="col"><?php echo $text['Ciudad'];?></th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            <?php
                                            foreach ($clients as $client) {
                                                $inicials = inicials($client['nom']);
                                            ?>

                                                <tr>
                                                    <td>
                                                        <div class="avatar-xs d-inline-block mr-2">
                                                            <div class="avatar-title bg-soft-primary rounded-circle text-primary">
                                                                <span style="font-size:0.9em;"><?php echo $inicials;?></span>
                                                            </div>
                                                        </div>
                                                        <!--<img src="assets/images/users/avatar-2.jpg" alt="" class="avatar-xs rounded-circle mr-2">-->
                                                        <a href="client-detall.php?id=<?php echo $client['id'];?>" class="text-body"><?php echo $client['nom'];?></a>
                                                    </td>
                                                    <td><?php echo $client['empresa'];?></td>
                                                    <td><?php echo $client['mail'];?></td>
                                                    <td class="text-center"><?php echo telefon($client['telefon']);?></td>
                                                    <td><?php echo $client['direccio'];?></td>
                                                    <td class="text-center"><?php echo $client['codiPostal'];?></td>
                                                    <td><?php echo $client['ciutat'];?></td>
                                                </tr>

                                                <? } ?>
                                                  
                                            </tbody>

                                            
                                        </table>
                                    </div>
                                    <!-- end table-responsive -->
                                    <div class="row mt-4">
                                        <div class="col-sm-6">
                                            <div>
                                                <p class="mb-sm-0">
                                                    <?php 
                                                    $valorInicial = $limitStart+1;
                                                    $valorFinal = min($limitEnd,$numClients);

                                                    echo $text["Mostrando del"]." ".$valorInicial." al ".$valorFinal." de ".$numClients." clientes.";?>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="float-sm-right">
                                                <ul class="pagination mb-sm-0">
                                                    <li class="page-item <?php if($page==1){echo "disabled";}?>">
                                                        <?php $prevPage = $page -1; $nextPage = $page +1;?>
                                                        <a href="<?php echo 'clients.php?page='.$prevPage;?>" class="page-link"><i class="mdi mdi-chevron-left"></i></a>
                                                    </li>

                                                    <?php 
                                                    if($page == 1){
                                                        if($pages>=1){?>
                                                            <li class="page-item active">
                                                                <a href="clients.php?page=1" class="page-link">1</a>
                                                            </li>
                                                        <?php } if($pages>=2){?>
                                                            <li class="page-item">
                                                                <a href="clients.php?page=2" class="page-link">2</a>
                                                            </li>
                                                        <?php } if($pages>=3){?>
                                                            <li class="page-item">
                                                                <a href="clients.php?page=3" class="page-link">3</a>
                                                            </li>
                                                        <?php } ?>
                                                        <li class="page-item">
                                                            <a href="clients.php?page=2" class="page-link"><i class="mdi mdi-chevron-right"></i></a>
                                                        </li>
                                                    <?php }else{ ?>
                                                        <li class="page-item">
                                                            <a href="<?php echo 'clients.php?page='.$prevPage;?>" class="page-link"><?php echo $prevPage;?></a>
                                                        </li>
                                                        <li class="page-item active">
                                                            <a href="<?php echo 'clients.php?page='.$page;?>" class="page-link"><?php echo $page;?></a>
                                                        </li>
                                                        <?php if($nextPage<=$pages){?>
                                                            <li class="page-item">
                                                                <a href="<?php echo 'clients.php?page='.$nextPage;?>" class="page-link"><?php echo $nextPage;?></a>
                                                            </li>
                                                        <?php }?>
                                                        <li class="page-item <?php if($nextPage>$pages){echo "disabled";}?>">
                                                            <a href="<?php echo 'clients.php?page='.$nextPage;?>" class="page-link"><i class="mdi mdi-chevron-right"></i></a>
                                                        </li>
                                                    <?php } ?>


                                                </ul>
                                            </div>
                                        </div>
                                    </div>
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
<!-- JavaScripts custom -->
<script src="assets/js/app.js"></script>
<!-- Scripts custom -->

</body>
</html>