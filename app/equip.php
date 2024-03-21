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
    <title>Cuantime. <?php echo $text['Equipo'];?></title>

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
                                <h4 class="mb-0"><?php echo $text['Equipo'];?></h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="index.php">Cuantime</a></li>
                                    <li class="breadcrumb-item active"><?php echo $text['Equipo'];?></li>
                                    </ol>
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- ZONA NOTIFIACIONS -->
                    <?php include_once("sections/notificacions.php") ?>

                    <div class="row">
                        <div class="col-md-4">
                            <?php if($userType<1){?>
                            <div>
                                <button type="button" class="btn btn-success waves-effect waves-light mb-3" data-toggle="modal" data-target="#addPeople"><i class="mdi mdi-plus mr-1"></i> <?php echo $text['Nueva persona'];?></button>
                            </div>
                            <?php }?>
                        </div>
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <!--<h4 class="card-title mb-4"></h4>-->
                                    <?php
                                    $persones = $database->select("users", [
                                      "id",
                                      "nom",
                                      "empresa",
                                      "email",
                                      "sou",
                                      "horari",
                                      "preu",
                                      "tipusUsuari",
                                      "tipusColaborador",
                                      "emailconfirmed"
                                      ],["AND"=>["empresa"=>$userEmpresa,"active"=>1],"ORDER"=>["nom"=>"ASC"]]);
                                    ?>
                                    <div class="table-responsive">
                                        <table class="table table-centered table-nowrap mb-0">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th scope="col"><?php echo $text['Nombre'];?></th>
                                                    <th scope="col"><?php echo $text['Empresa'];?></th>
                                                    <th scope="col"><?php echo $text['Email'];?></th>
                                                    <th scope="col"><?php echo $text['Estado'];?></th>
                                                    <th scope="col"><?php echo $text['Usuario'];?></th>
                                                    <th scope="col"><?php echo $text['Colaboración'];?></th>
                                                    <th scope="col" style="text-align: center;"><?php echo $text['Sueldo anual'];?></th>
                                                    <th scope="col" style="text-align: center;"><?php echo $text['Horario'];?></th>
                                                    <th scope="col" style="text-align: center;"><?php echo $text['Coste'];?></th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            <?php
                                            foreach ($persones as $persona) {
                                                $nomEmpresa=$database->get("empreses","empresaNom",["id"=>$persona['empresa']]);
                                                $inicials = inicials($persona['nom']);
                                                $tipusUsuaris=['Administrador','Completo','Básico'];
                                                $tipusColaboracions=['Trabajador','Autonomo'];

                                                if($persona['tipusColaborador']==0){
                                                    $sou=number_format($persona['sou'],2,",",".").' €';
                                                    $horari=$persona['horari'].'h/sem';
                                                    if($persona['horari']==0){$cost="-";}else{
                                                        $cost=number_format($persona['sou']/($persona['horari']*4*12),2,",",".").'€/h';
                                                    }
                                                }else{
                                                    $sou='-';
                                                    $horari='-';
                                                    $cost=number_format($persona['preu'],2,",",".").'€/h';
                                                }
                                                if($persona['emailconfirmed']==1){
                                                    $estatConfirm='Activo';
                                                    $classEstat='';
                                                }else{
                                                    $estatConfirm='Pendiente';
                                                    $classEstat='style="color:#999!important";';
                                                }
                                            ?>

                                                <tr>
                                                    <td>
                                                        <div class="avatar-xs d-inline-block mr-2">
                                                            <div class="avatar-title bg-soft-primary rounded-circle text-primary">
                                                                <span style="font-size:0.9em;"><?php echo $inicials;?></span>
                                                            </div>
                                                        </div>
                                                        <!--<img src="assets/images/users/avatar-2.jpg" alt="" class="avatar-xs rounded-circle mr-2">-->
                                                        <a href="equip-detall.php?id=<?php echo $persona['id'];?>" class="text-body" <?php echo $classEstat;?>><?php echo $persona['nom'];?></a>
                                                    </td>
                                                    <td <?php echo $classEstat;?>><?php echo $nomEmpresa;?></td>
                                                    <td <?php echo $classEstat;?>><?php echo $persona['email'];?></td>
                                                    <td <?php echo $classEstat;?>><?php echo $estatConfirm;?></td>
                                                    <td>
                                                        <?php if($persona['tipusUsuari']==0){
                                                            echo $tipusUsuaris[$persona['tipusUsuari']];
                                                        }else{?>
                                                            <div class="dropdown">
                                                                <a class="text-body" href="#" role="button" data-toggle="dropdown" aria-haspopup="true">
                                                                    <?php echo $tipusUsuaris[$persona['tipusUsuari']];?>
                                                                </a>
                                                                <div class="dropdown-menu dropdown-menu-right">
                                                                    <a class="dropdown-item" href="conexiones/rrhh.php?action=editUserType&type=1&id=<?php echo $persona['id'];?>">
                                                                        <?php echo $text['Acceso completo'];?>
                                                                    </a>
                                                                    <a class="dropdown-item" href="conexiones/rrhh.php?action=editUserType&type=2&id=<?php echo $persona['id'];?>">
                                                                        <?php echo $text['Acceso básico'];?>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        <?php } ?>
                                                    </td>
                                                    <td>
                                                        <div class="dropdown">
                                                            <a class="text-body" href="#" role="button" data-toggle="dropdown" aria-haspopup="true">
                                                                <?php echo $tipusColaboracions[$persona['tipusColaborador']];?>
                                                            </a>
                                                            <div class="dropdown-menu dropdown-menu-right">
                                                                <a class="dropdown-item" href="conexiones/rrhh.php?action=editUserColab&type=0&id=<?php echo $persona['id'];?>">
                                                                    <?php echo $text['Trabajador'];?>
                                                                </a>
                                                                <a class="dropdown-item" href="conexiones/rrhh.php?action=editUserColab&type=1&id=<?php echo $persona['id'];?>">
                                                                    <?php echo $text['Autónomo'];?>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </td>

                                                    <?php if($persona['tipusColaborador']==0){?>
                                                        <td style="text-align: center;">
                                                            <div class="dropdown">
                                                                <?php 
                                                                if($userType==0){
                                                                    echo '<a class="text-body" href="#" role="button" data-toggle="dropdown" aria-haspopup="true">'.$sou.'</a>';
                                                                }else{
                                                                    echo $sou;
                                                                }
                                                                ?>
                                                                <div class="dropdown-menu dropdown-menu-right">
                                                                    <form action="conexiones/rrhh.php?action=editSou&id=<?php echo $persona['id'];?>" method="post">
                                                                        <input style="width:60% !important;display:inline;margin-left:10px;" type="number" step="any" class="form-control" value="<?php echo $persona['sou'];?>" name="sou">
                                                                        <button style="margin-top:-5px" type="submit" class="btn btn-primary waves-effect waves-light"><i class="uil uil-check"></i></button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td style="text-align: center;">
                                                            <div class="dropdown">
                                                                <?php 
                                                                if($userType==0){
                                                                    echo '<a class="text-body" href="#" role="button" data-toggle="dropdown" aria-haspopup="true">'.$horari.'</a>';
                                                                }else{
                                                                    echo $horari;
                                                                }
                                                                ?>
                                                                <div class="dropdown-menu dropdown-menu-right">
                                                                    <form action="conexiones/rrhh.php?action=editHorari&id=<?php echo $persona['id'];?>" method="post">
                                                                        <input style="width:60% !important;display:inline;margin-left:10px;" type="number" step="any" class="form-control" value="<?php echo $persona['horari'];?>" name="horari">
                                                                        <button style="margin-top:-5px" type="submit" class="btn btn-primary waves-effect waves-light"><i class="uil uil-check"></i></button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td style="text-align: center;"><?php echo $cost;?></td>
                                                        <td style="width:100px">
                                                            <a href="calendari.php?id=<?php echo $persona['id'];?>" class="btn btn-light btn-sm w-xs">
                                                                <i class="uil-calender"></i> <?php echo $text['Calendario'];?>
                                                            </a>
                                                        </td>

                                                    <?php }else{?>
                                                        <td style="text-align: center;">-</td>
                                                        <td style="text-align: center;">-</td>
                                                        <td style="text-align: center;">
                                                            <div class="dropdown">
                                                                <?php 
                                                                if($userType==0){
                                                                    echo '<a class="text-body" href="#" role="button" data-toggle="dropdown" aria-haspopup="true">'.$cost.'</a>';
                                                                }else{
                                                                    echo $cost;
                                                                }
                                                                ?>
                                                                <div class="dropdown-menu dropdown-menu-right">
                                                                    <form action="conexiones/rrhh.php?action=editCost&id=<?php echo $persona['id'];?>" method="post">
                                                                        <input style="width:60% !important;display:inline;margin-left:10px;" type="number" step="any" class="form-control" value="<?php echo $persona['preu'];?>" name="preu">
                                                                        <button style="margin-top:-5px" type="submit" class="btn btn-primary waves-effect waves-light"><i class="uil uil-check"></i></button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td></td>

                                                    <?php } ?>

                                                </tr>
                                                <? } ?>
                                                  
                                            </tbody>

                                            
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end row -->


                </div> <!-- container-fluid -->
            </div>
            <!-- End Page-content -->


            <?php include_once("sections/footer.php") ?>
            <?php include_once("sections/modal-addPeople.php") ?>
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