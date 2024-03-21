<?php
// Redirecció a HTTPS
if(!isset($_SERVER["HTTPS"]) || $_SERVER["HTTPS"] != "on"){
  header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"], true, 301);
  exit;
}
include_once("conexiones/conexion.php");
session_start();
include_once("sections/sessionStart.php");

function nearest5Mins($time) {
  $time = (round(strtotime($time) / 300)) * 300;
  return date('Y-m-d H:i', $time);
}

function beautyTime($time){
    //Entro un valor en segons, que em permet fer diferencies de temps en segons, i surt "0h 00 min".
    $horesDiaries = floor(intval($time)/3600);
    $minutsDiaris = round((intval($time)%3600)/60,0);
    if($minutsDiaris < 10){$minutsDiaris = "0".$minutsDiaris;}
    return $horesDiaries."h ".$minutsDiaris." min";
}

$data = date('Y-m-d H:i:s');
?>
<!DOCTYPE html>
<html lang="es">
    <head>
    <!-- Meta data -->
    <?php include_once("sections/meta.php") ?>

    <!-- Títol i Favicons -->
    <title>Cuantime. <?php echo $text['Fichajes'];?></title>

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
                                <h4 class="mb-0"><?php echo $text['Fichajes'];?></h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="index.php">Cuantime</a></li>
                                        <li class="breadcrumb-item active"><?php echo $text['Fichajes'];?></li>
                                    </ol>
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- ZONA NOTIFIACIONS -->
                    <?php include_once("sections/notificacions.php") ?>

                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-xs-12 col-lg-3 month-count">
                                        <!--<span class="text-md text-gray-600">Aquest mes</span>
                                        <div class="font-bold">00:00h</div>-->
                                    </div>
                                    <div class="col-xs-12 col-lg-6 fitx-data-picker">
                                        <div class="form-group">
                                            <?php 
                                            $internMonth = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
                                            if(isset($_GET['date'])){
                                                $dataExplotada=explode('-',$_GET['date']);
                                                $pickupValue = $internMonth[$dataExplotada[0]-1]." ".date("Y",strtotime($dataExplotada[1]));
                                            }else{
                                                $pickupValue = $month[date("n")-1]." ".date("Y");
                                            }
                                            ?>
                                            <input type="text" class="form-control fitx-mes-picker" value="<?php echo $pickupValue;?>" data-provide="datepicker" data-date-format="M yyyy" data-date-min-view-mode="1" data-date-autoclose="true" style="cursor:pointer;" onchange="actData()" id="inputActData">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-lg-3 add-fitxatge">
                                        <button type="button" class="btn btn-outline-success btn-rounded waves-effect waves-light" data-toggle="modal" data-target="#addFitxatge"><?php echo $text['Añadir fichaje'];?></button>
                                    </div>
                                </div>
                                <!-- end table-responsive -->

                                <div class="table-responsive mb-4 taula-fitxatges">
                                        <table class="table table-centered table-hover table-nowrap mb-0">
                                            <thead>
                                              <tr>
                                                <th scope="col"><?php echo $text['Fecha'];?></th>
                                                <th scope="col"><?php echo $text['Horas'];?></th>
                                                <th scope="col"><?php echo $text['Dedicación'];?></th>
                                                <th scope="col" style="width:100px"></th>
                                              </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $diesMes = [31,28,31,30,31,30,31,31,30,31,30,31];
                                                if(isset($_GET['date'])){
                                                    $currentMonth=$dataExplotada[0];
                                                    $currentYear=$dataExplotada[1];

                                                    $diesCurrentMonth = $diesMes[$currentMonth-1];
                                                }else{
                                                    $currentMonth = date("n");
                                                    $diesCurrentMonth = $diesMes[$currentMonth-1];
                                                    $currentYear = date("Y");
                                                }
                                                
                                                for($i=1;$i<=$diesCurrentMonth;$i++){
                                                    $diaLoop=$i;
                                                    $dataLoop = date("d-m-Y",strtotime($diaLoop.'-'.$currentMonth.'-'.$currentYear));
                                                    $numDiaSetmana = date("w",strtotime($dataLoop));
                                                    $diaSetmanaLoop = $diesSetmana[$numDiaSetmana];
                                                ?>
                                                <tr <?php if($numDiaSetmana==6||$numDiaSetmana==0){echo 'style="background-color:#f5f6f8;"';}?>>
                                                    <td>
                                                        <a class="text-body" href="fitxatges-editar.php?dia=<?php echo $dataLoop;?>" aria-expanded="true" aria-controls="collapseDay<?php echo $i;?>" id="<?php echo $dataLoop;?>"><strong><?php echo $diaSetmanaLoop.', '.$diaLoop.' '.$month[$currentMonth-1];?></strong></a>
                                                        <div class="collapsep" id="collapseDay<?php echo $i;?>" style="margin-top:10px;">
                                                            <?php
                                                            $fitxatges = $database->select("fitxatges", [
                                                              "id",
                                                              "timeIn",
                                                              "timeOut",
                                                              "idUser"
                                                              ],["ORDER"=>["timeIn"=>"ASC"],"AND"=>["timeIn[<>]"=>[date("Y-m-d", mktime(0, 0, 0, date("n",strtotime($dataLoop)), $diaLoop, $currentYear)), date("Y-m-d", mktime(0, 0, 0, date("n",strtotime($dataLoop)), $diaLoop+1, $currentYear))],"idUser"=>$userId]]);
                                                            $j=0;
                                                            $temps = 0;
                                                            foreach ($fitxatges as $fitxatge) {
                                                                $j++;
                                                                if($fitxatge['timeOut']!=NULL){
                                                                    echo '<div><i class="fitxatge-icon uil-clock-nine"></i> '.date("H:i",strtotime($fitxatge['timeIn']))." - ".date("H:i",strtotime($fitxatge['timeOut']))."</div>";
                                                                    $temps = $temps+(strtotime($fitxatge['timeOut'])-strtotime($fitxatge['timeIn']));
                                                                }
                                                            }
                                                            if($j==0){
                                                                echo '<div style="color:#ccc;">'.$text['No hay fichajes'].'</div>';
                                                            }
                                                            ?>
                                                        </div>
                                                    </td>
                                                    <?php
                                                    $horesDiaries = floor(intval($temps)/3600);
                                                    $minutsDiaris = round((intval($temps)%3600)/60,0);
                                                    if($minutsDiaris < 10){$minutsDiaris = "0".$minutsDiaris;}
                                                    $parteData = date("Y",strtotime($dataLoop))."-".date("n",strtotime($dataLoop))."-".$diaLoop;
                                                    $numPartes = $database->count("partes", ["AND"=>["idUser"=>$userId,"data"=>$parteData]]);
                                                    ?>
                                                    <td style="vertical-align: top!important;"><?php echo beautyTime($temps);?></td>
                                                    <td style="vertical-align: top!important;"><a onclick="<?php echo "dataOnValue('".$parteData."')";?>" data-toggle="modal" data-target="#addParte" style="cursor:pointer;">
                                                        <?php 
                                                        $partes = $database->select("partes", [
                                                            "id",
                                                            "data",
                                                            "idProjecte",
                                                            "percentatge",
                                                            "comment",
                                                            "idUser"
                                                            ],["AND"=>["idUser"=>$userId,"data"=>$parteData]]);
                                                        if($numPartes==0){echo '<div style="color:#ccc;">'.$text['No hay dedicación'].'</div>';}
                                                        foreach ($partes as $parte) {
                                                            $percentatgePartes = $database->sum("partes", "percentatge",["AND"=>["idUser"=>$userId,"data"=>$parteData]]);
                                                            if($percentatgePartes==100){$fitxatgeColor='#34c38f';$fitxatgeIcon='fitxatge-icon';}else{$fitxatgeColor='#f46a6a';$fitxatgeIcon='fitxatge-icon-danger';}
                                                            if(strlen($parte['comment'])>0){
                                                                $comment = ' - '.$parte['comment'];
                                                            }
                                                            $expProjecte = $database->get("projectes","exp",["id"=>$parte['idProjecte']]);
                                                            $nomProjecte = $database->get("projectes","nom",["id"=>$parte['idProjecte']]);
                                                            $dedicacioParte = $temps*($parte['percentatge']/100);
                                                            echo '<a href="fitxatges-editar.php?dia='.$dataLoop.'" style="color:#333;"><div><i class="'.$fitxatgeIcon.' uil-folder"></i> <span style="color: '.$fitxatgeColor.';">'.round($parte['percentatge'],0).'%</span> - '.$expProjecte.'. '.$nomProjecte.' <span style="color:#999;">('.beautyTime($dedicacioParte).')'.$comment.'</span></div></a>';
                                                            $comment = '';
                                                        }
                                                        ?></a>
                                                    </td>
                                                    <td style="vertical-align: top!important;">
                                                        <li class="list-inline-item dropdown<?php if($temps==0){echo ' hidden';}?>">
                                                            <a class="dropdown-item" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" style="cursor:pointer;">
                                                                <i class="uil uil-ellipsis-v"></i>
                                                            </a>
                                                            <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(-126px, 32px, 0px);">
                                                                <a class="dropdown-item" onclick="<?php echo "dataOnValue('".$parteData."')";?>" data-toggle="modal" data-target="#addParte" style="cursor:pointer;"><?php echo $text['Añadir asignación'];?></a>
                                                                <a class="dropdown-item" href="fitxatges-editar.php?dia=<?php echo $dataLoop;?>" style="cursor:pointer;"><?php echo $text['Editar día'];?></a>
                                                            </div>
                                                        </li>
                                                    </td>
                                                </tr>
                                            <?php }?>
                                            </tbody>
                                        </table>
                                    </div>
                            </div>
                        </div>
                    </div>


                </div> <!-- container-fluid -->
            </div>
            <!-- End Page-content -->


            <?php include_once("sections/footer.php") ?>
            <?php include_once("sections/modal-addFitxatge.php") ?>
            <?php include_once("sections/modal-addParte.php") ?>

            </div>       
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