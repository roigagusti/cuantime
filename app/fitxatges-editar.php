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
function beautyDate(){
    //Entro un valor en "dd-mm-aaaa" i em retorna en format "Dilluns, 01 Febrer".
    $dia = $_GET['dia'];
    $diesSetmana = ['Domingo','Lunes','Martes','Miércoles','Jueves','Viernes','Sábado'];
    $mes = ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Deciembre'];
    $values = explode("-",$dia);

    $diaSetmana = $diesSetmana[date('w', strtotime($dia))];
    $a = $values[0];
    $b = $mes[intval($values[1])-1];
    return $diaSetmana.', '.$a.' de '.$b;
}
?>
<!DOCTYPE html>
<html lang="es">
    <head>
    <!-- Meta data -->
    <?php include_once("sections/meta.php") ?>

    <!-- Títol i Favicons -->
    <title>Cuantime. Fichajes</title>

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
        <?php
        $dia = explode("-",$_GET['dia']);
        $diaLoop = $dia[0];
        $mesLoop = $dia[1];
        $anyLoop = $dia[2];
        $parteData = date("Y",strtotime($anyLoop))."-".date("n",strtotime($_GET['dia']))."-".$diaLoop;
        $fitxatges = $database->select("fitxatges", [
            "id",
            "timeIn",
            "timeOut",
            "idUser"
            ],["ORDER"=>["timeIn"=>"ASC"],"AND"=>["timeIn[<>]"=>[date("Y-m-d", mktime(0, 0, 0, $mesLoop, $diaLoop, $anyLoop)), date("Y-m-d", mktime(0, 0, 0, $mesLoop, $diaLoop+1, $anyLoop))],"idUser"=>$userId]]);
        $numFitxatgesToUser=count($fitxatges);
        ?>
        <div class="main-content">

            <div class="page-content">
                <div class="container-fluid">

                    <!-- Zona superior de títol -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-flex align-items-center justify-content-between">
                                <h4 class="mb-0">Editar dedicación</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="index.php">Cuantime</a></li>
                                    <li class="breadcrumb-item"><a href="fitxatges.php">Fichajes</a></li>
                                    <li class="breadcrumb-item active">Editar dedicación</li>
                                    </ol>
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- ZONA NOTIFIACIONS -->
                    <?php include_once("sections/notificacions.php") ?>

                    <div class="row">
                        <div class="col-xl-4">
                            <div class="card checkout-order-summary">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <a class="text-body" href="#"><strong><?php echo beautyDate();?></strong></a>
                                        </div>
                                        <div class="col-md-4 text-right">
                                            <?php
                                            $ahir = date("d-m-Y", strtotime($_GET['dia'].' -1 day'));
                                            $dema = date("d-m-Y", strtotime($_GET['dia'].' +1 day'));
                                            ?>
                                            <a class="text-body" href="fitxatges-editar.php?dia=<?php echo $ahir;?>"><i class="mdi mdi-chevron-left accor-down-icon font-size-20"></i></a>
                                            <a class="text-body" href="fitxatges-editar.php?dia=<?php echo $dema;?>"><i class="mdi mdi-chevron-right accor-down-icon font-size-20"></i></a>
                                        </div>
                                    </div>
                                    <div style="margin-top:20px;">
                                        <?php
                                        if($numFitxatgesToUser==0){echo '<div style="color:#ccc;">No hay fichajes</div>';}else{
                                        foreach($fitxatges as $fitxatge){
                                            if($fitxatge['timeOut']==NULL){
                                                $fitxatgeTimeOut = '<span style="color:#ccc">...</span>';
                                            }else{
                                                $fitxatgeTimeOut = date("H:i",strtotime($fitxatge['timeOut']));
                                            }
                                            echo '<div><i class="fitxatge-icon uil-clock-nine"></i> '.date("H:i",strtotime($fitxatge['timeIn']))." - ".$fitxatgeTimeOut.'</div>';
                                        }}
                                        ?>
                                    </div>
                                    <div style="margin-top:20px;">
                                        <?php 
                                        $dataParte = $anyLoop.'-'.$mesLoop.'-'.$diaLoop;
                                        $partes = $database->select("partes", [
                                            "id",
                                            "data",
                                            "idProjecte",
                                            "percentatge",
                                            "comment",
                                            "idUser"
                                            ],["AND"=>["idUser"=>$userId,"data"=>$dataParte]]);
                                        foreach ($partes as $parte) {
                                            $expProjecte = $database->get("projectes","exp",["id"=>$parte['idProjecte']]);
                                            $nomProjecte = $database->get("projectes","nom",["id"=>$parte['idProjecte']]);
                                            if(strlen($parte['comment'])>0){
                                                $comment = ' - '.$parte['comment'];
                                            }
                                            echo '<div><i class="fitxatge-icon uil-folder"></i> <span style="color: #34c38f;">'.round($parte['percentatge'],0).'%</span> - '.$expProjecte.'. '.$nomProjecte.' <span style="color:#999;">'.$comment.'</span></div>';
                                            $comment='';
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row my-4">
                                <div class="col">
                                    <a href="fitxatges.php" class="btn btn-link text-muted">
                                        <i class="uil uil-arrow-left mr-1"></i> Volver a fichajes</a>
                                </div> <!-- end col -->
                            </div> 
                        </div>
                        <div class="col-xl-8">
                            <div class="custom-accordion">
                                <div class="card">
                                    <a href="#checkout-billinginfo-collapse" class="collapsed text-dark" data-toggle="collapse" aria-expanded="true">
                                        <div class="p-4">
                                            
                                            <div class="media align-items-center">
                                                <div class="mr-3">
                                                    <i class="uil uil-clock-nine text-primary h2"></i>
                                                </div>
                                                <div class="media-body overflow-hidden">
                                                    <h5 class="font-size-16 mb-1">Fichajes</h5>
                                                    <p class="text-muted text-truncate mb-0">Clica para editar los fichajes diarios</p>
                                                </div>
                                                <i class="mdi mdi-chevron-up accor-down-icon font-size-24"></i>
                                            </div>
                                            
                                        </div>
                                    </a>

                                    <div id="checkout-billinginfo-collapse" class="collapse show">
                                        <div class="p-4 border-top">
                                            <?php
                                            $i=1;
                                            if(count($fitxatges)==0){echo '<div style="color:#ccc;">No hay fichajes</div>';}
                                            foreach($fitxatges as $fitxatge){ 
                                                if($fitxatge['timeOut']==NULL){
                                                    $fitxatgeTimeOut = '<span style="color:#ccc">...</span>';
                                                }else{
                                                    $fitxatgeTimeOut = date("H:i",strtotime($fitxatge['timeOut']));
                                                }
                                            ?>
                                            <div class="row">
                                                <div class="col-lg-12 mt-3">
                                                    <a class="text-body" data-toggle="collapse" href="#collapseFitxatge<?php echo $i;?>" aria-expanded="true" aria-controls="collapseFitxatge<?php echo $i;?>">
                                                        <i class="fitxatge-icon uil-clock-nine"></i> 
                                                        <?php echo date("H:i",strtotime($fitxatge['timeIn']))." - ".$fitxatgeTimeOut;?>
                                                    </a>
                                                    <span style="float:right"><a href="#" data-toggle="modal" data-target="#removeFitxatge" style="color:#999">Eliminar</a></span>
                                                </div>
                                            </div>
                                            <div class="collapse" id="collapseFitxatge<?php echo $i;?>" style="margin-top:20px;">
                                                <form method="post" action="conexiones/rrhh.php?action=updateFitxar<?php echo '&dia='.$_GET['dia'].'&id='.$fitxatge['id'];?>">
                                                    <div>
                                                        <div class="row">
                                                            <div class="col-lg-4">
                                                                <div class="form-group mb-4">
                                                                    <label>Hora de inicio</label>
                                                                    <input type="time" class="form-control" data-date-format="hh:mm" data-date-autoclose="true" id="example-time-input" value="<?php echo date("H:i",strtotime($fitxatge['timeIn']));?>" name="iniciHora">
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <div class="form-group mb-4">
                                                                    <label>Hora final</label>
                                                                    <input type="time" class="form-control" data-date-format="hh:mm" data-date-autoclose="true" id="example-time-input" value="<?php echo date("H:i",strtotime($fitxatge['timeOut']));?>" name="finalHora">
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4" style="text-align: right;padding-top:25px">
                                                                <button type="submit" class="btn btn-success">Guardar</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <div id="removeFitxatge" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title mt-0" id="myModalLabel">Confirmar borrado</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <form method="post" action="conexiones/rrhh.php?action=removeFitxatge<?php echo '&id='.$fitxatge['id'].'&dia='.$_GET['dia'];?>" >
                                                            <div class="modal-body">
                                                                <p>¿Estás seguro que quieres borrar este fichaje?</a></p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-light waves-effect" data-dismiss="modal">Cancelar</button>
                                                                <button type="submit" class="btn btn-danger waves-effect waves-light">Borrar</button>
                                                            </div>
                                                        </form>
                                                    </div><!-- /.modal-content -->
                                                </div><!-- /.modal-dialog -->
                                            </div><!-- /.modal -->
                                            <?php $i++;} ?>
                                        </div>
                                    </div>

                                    <div class="row"><div class="col-md-12"><button type="button" class="btn btn-outline-success waves-effect waves-light mb-3" data-toggle="modal" data-target="#addFitxatge" style="margin-left: 20px;"><i class="mdi mdi-plus mr-1"></i> Añadir fichaje</button></div></div>
                                </div>

                                <div class="card">
                                    <a href="#checkout-shippinginfo-collapse" class="collapsed text-dark" data-toggle="collapse" aria-expanded="true">
                                        <div class="p-4">
                                            
                                            <div class="media align-items-center">
                                                <div class="mr-3">
                                                    <i class="uil uil-folder text-primary h2"></i>
                                                </div>
                                                <div class="media-body overflow-hidden">
                                                    <h5 class="font-size-16 mb-1">Dedicación</h5>
                                                    <p class="text-muted text-truncate mb-0">Clica para editar la dedicación diaria</p>
                                                </div>
                                                <i class="mdi mdi-chevron-up accor-down-icon font-size-24"></i>
                                            </div>
                                            
                                        </div>
                                    </a>

                                    <div id="checkout-shippinginfo-collapse" class="collapse show">
                                        <div class="p-4 border-top">
                                            <?php
                                            $j=1;
                                            if(count($partes)==0){echo '<div style="color:#ccc;">No hay dedicación</div>';}
                                            foreach($partes as $parte){
                                            $expProject = $database->get("projectes","exp",["id"=>$parte['idProjecte']]);
                                            $nomProject = $database->get("projectes","nom",["id"=>$parte['idProjecte']]);
                                            ?>
                                            <div class="row">
                                                <div class="col-lg-12 mt-3">

                                                    <a class="text-body" data-toggle="collapse" href="#collapseParte<?php echo $j;?>" aria-expanded="true" aria-controls="collapseParte<?php echo $j;?>"><i class="fitxatge-icon uil-folder"></i> <span style="color: #34c38f;"><?php echo round($parte['percentatge'],0).'%</span> - '.$expProject.'. '.$nomProject.' <span style="color:#999;">'.$parte['comment'];?></span></a> <span style="float:right"><a href="#" data-toggle="modal" data-target="#removeParte<?php echo $j;?>" style="color:#999">Eliminar</a></span>

                                                    <div class="collapse" id="collapseParte<?php echo $j;?>" style="margin-top:20px;">
                                                        <form method="post" action="conexiones/rrhh.php?action=updateParte<?php echo '&dia='.$_GET['dia'].'&id='.$parte['id'];?>">
                                                            <div>
                                                                <div class="row">
                                                                    <div class="col-lg-2">
                                                                        <div class="form-group mb-4">
                                                                            <label>Dedicación (%)</label>
                                                                            <input type="text" class="form-control" value="<?php echo $parte['percentatge'];?>" name="partePercentatge">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-4">
                                                                        <div class="form-group mb-4">
                                                                            <label>Proyecto</label>
                                                                            <select class="form-control" name="idProjecte">
                                                                            <option value="<?php echo $parte['idProjecte'];?>"><?php echo $expProject.'. '.$nomProject;?></option>
                                                                            <?php
                                                                            $exps = $database->select("projectes", [
                                                                                "id",
                                                                                "exp",
                                                                                "nom",
                                                                                "created_date",
                                                                                "idUser"
                                                                                ],[ "AND"=>["idUser"=>$userId,"exp[>]"=>0],
                                                                                    "ORDER"=>["exp"=>"DESC"]
                                                                                ]);
                                                                            foreach ($exps as $exp) {
                                                                                echo '<option value="'.$exp['id'].'">'.$exp['exp'].' - '.$exp['nom'].'</option>';
                                                                            }
                                                                            ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-4">
                                                                        <div class="form-group mb-4">
                                                                            <label>Comentario</label>
                                                                            <input type="text" class="form-control" value="<?php echo $parte['comment'];?>" name="parteComentari">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-2" style="text-align: right;padding-top:25px">
                                                                        <button type="submit" class="btn btn-success">Guardar</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <div id="removeParte<?php echo $j;?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title mt-0" id="myModalLabel">Confirmar borrado</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <form method="post" action="conexiones/rrhh.php?action=removeParte<?php echo '&id='.$parte['id'].'&dia='.$_GET['dia'];?>" >
                                                                    <div class="modal-body">
                                                                        <p>¿Estás seguro que quieres borrar esta dedicación?</a></p>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-light waves-effect" data-dismiss="modal">Cancelar</button>
                                                                        <button type="submit" class="btn btn-danger waves-effect waves-light">Borrar</button>
                                                                    </div>
                                                                </form>
                                                            </div><!-- /.modal-content -->
                                                        </div><!-- /.modal-dialog -->
                                                    </div><!-- /.modal -->
                                                </div>
                                            </div>
                                        <?php $j++;}?>
                                        </div>
                                    </div>

                                    <div class="row"><div class="col-md-12"><button type="button" class="btn btn-outline-success waves-effect waves-light mb-3" data-toggle="modal" data-target="#addParte" onclick="<?php echo "dataOnValue('".$parteData."')";?>" style="margin-left: 20px;"><i class="mdi mdi-plus mr-1"></i> Añadir dedicación</button></div></div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    <!-- end row -->


                </div> <!-- container-fluid -->
            </div>
            <!-- End Page-content -->


            <?php include_once("sections/footer.php") ?>
            <?php include_once("sections/modal-editClient.php") ?>
            <?php include_once("sections/modal-removeClient.php") ?>
            <?php include_once("sections/modal-addFitxatge.php") ?>
            <?php include_once("sections/modal-addParte.php") ?>
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
<script src="js/script.js"></script>
<!-- Scripts custom -->

</body>
</html>