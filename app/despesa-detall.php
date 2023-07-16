<?php
// Redirecció a HTTPS
if(!isset($_SERVER["HTTPS"]) || $_SERVER["HTTPS"] != "on"){
  header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"], true, 301);
  exit;
}
include_once("conexiones/conexion.php");
session_start();
include_once("sections/sessionStart.php");
?>
<!DOCTYPE html>
<html lang="es">
    <head>
    <!-- Meta data -->
    <?php include_once("sections/meta.php") ?>

    <!-- Títol i Favicons -->
    <title>Cuantime. Gasto</title>

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

        <?php
        $idProjecte = $database->get("despeses","idProjecte",["id"=>$_GET['id']]);
        $importDespesa = $database->get("despeses","import",["id"=>$_GET['id']]);
        $importIVA = $database->get("despeses","iva",["id"=>$_GET['id']]);
        $importIRPF = $database->get("despeses","irpf",["id"=>$_GET['id']]);
        $despesaUser = $database->get("despeses","idUser",["id"=>$_GET['id']]);

        $nomProjecte = $database->get("projectes","nom",["id"=>$idProjecte]);
        $expProjecte = $database->get("projectes","exp",["id"=>$idProjecte]);
        $idClient = $database->get("projectes","idClient",["id"=>$idProjecte]);

        $concepteDespesa = $database->get("despeses","concepte",["id"=>$_GET['id']]);
        $despesaProveidor = $database->get("despeses","proveidor",["id"=>$_GET['id']]);
        $dataDespesa = $database->get("despeses","data",["id"=>$_GET['id']]);

        $despesaClient = $database->get("despeses","despesaNom",["id"=>$_GET['id']]);
        if(strlen($despesaClient)>0){
            $despesaNom = $database->get("despeses","despesaNom",["id"=>$_GET['id']]);
            $despesaDireccio = $database->get("despeses","despesaDireccio",["id"=>$_GET['id']]);
            $despesaCP = $database->get("despeses","despesaCP",["id"=>$_GET['id']]);
            $despesaCiutat = $database->get("despeses","despesaCiutat",["id"=>$_GET['id']]);
            $despesaCIF = $database->get("despeses","despesaCIF",["id"=>$_GET['id']]);
        }else{
            $despesaNom = $database->get("clients","nom",["id"=>$idClient]);   
            $despesaDireccio = $database->get("clients","direccio",["id"=>$idClient]); 
            $despesaCP= $database->get("clients","codiPostal",["id"=>$idClient]);    
            $despesaCiutat= $database->get("clients","ciutat",["id"=>$idClient]);    
            $despesaCIF= $database->get("clients","cif",["id"=>$idClient]);             
        }

        if($database->get("despeses","despesaTelefon",["id"=>$_GET['id']])){
            $despesaTelefonBase = $database->get("despeses","despesaTelefon",["id"=>$_GET['id']]);
            $despesaTelefon = '<br>Telèfon: '.$despesaTelefonBase;
        }else{
            $despesaTelefonBase = $database->get("clients","telefon",["id"=>$idClient]);   
            $despesaTelefon = '<br>Telèfon: '.$despesaTelefonBase;      
        }

        if($database->get("despeses","despesaTelefon",["id"=>$_GET['id']])){
            $despesaEmailBase = $database->get("despeses","despesaEmail",["id"=>$_GET['id']]);
            $despesaEmail = '<br>Email: '.$despesaEmailBase;
        }else{
            $despesaEmailBase = $database->get("clients","mail",["id"=>$idClient]);   
            $despesaEmail = '<br>Email: '.$despesaEmailBase;       
        }
        ?>    

        <!-- ============================================================== -->
        <!-- PÀGINA INICIAL -->
        <!-- ============================================================== -->
        <div class="main-content">

            <div class="page-content">
                <div class="container-fluid">

                    <!-- Zona superior de títol -->
                    <div class="row d-print-none">
                        <div class="col-12">
                            <div class="page-title-box d-flex align-items-center justify-content-between">
                                <h4 class="mb-0">Gasto detall</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="index.php">Aldasoro</a></li>
                                    <li class="breadcrumb-item"><a href="despeses.php">Gastos</a></li>
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
                        <?php 
                        if($despesaUser!=$userAdminEmpresa){echo '<div class="col-lg-12"><div class="card h-100"><div class="card-body">La página a la que intentas acceder no está disponible</div></div></div><div class="d-print-none mt-4"><a href="despeses.php" class="btn btn-link text-muted"><i class="uil uil-arrow-left mr-1"></i> Volver a gastos</a></div>';
                            }else{
                        ?>


                        <div class="dadesFactura d-print-none">
                            <form action="conexiones/administracio.php?action=editDespesa&id=<?php echo $_GET['id'];?>" method="post">
                                <div class="card">
                                    <a href="#dadesClient-collapse" class="collapsed text-dark" data-toggle="collapse">
                                        <div class="p-4">
                                            
                                            <div class="media align-items-center">
                                                <div class="mr-3">
                                                    <i class="uil uil-user text-primary h2"></i>
                                                </div>
                                                <div class="media-body overflow-hidden">
                                                    <h5 class="font-size-16 mb-1">Datos del proveedor</h5>
                                                    <p class="text-muted text-truncate mb-0">Editar datos del proveedor</p>
                                                </div>
                                                <i class="mdi mdi-chevron-up accor-down-icon font-size-24"></i>
                                            </div>
                                            
                                        </div>
                                    </a>
                                    <div id="dadesClient-collapse" class="collapse">
                                        <div class="p-4 border-top">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label>Nombre</label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" name="despesaNom" value="<?php echo $despesaNom;?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label>Empresa</label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" name="despesaEmpresa" value="<?php echo $despesaProveidor;?>">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-8">
                                                    <div class="form-group">
                                                        <label>Dirección</label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" name="despesaDireccio" value="<?php echo $despesaDireccio;?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="form-group">
                                                        <label>Código postal</label>
                                                        <div class="input-group">
                                                            <input type="number" class="form-control" name="despesaCP" value="<?php echo $despesaCP;?>">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <div class="form-group">
                                                        <label>Ciudad</label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" name="despesaCiutat" value="<?php echo $despesaCiutat;?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3">
                                                    <div class="form-group">
                                                        <label>CIF</label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" name="despesaCIF" value="<?php echo $despesaCIF;?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-5">
                                                    <div class="form-group">
                                                        <label>Teléfono</label>
                                                        <div class="input-group">
                                                            <input type="phone" class="form-control" name="despesaTelefon" value="<?php echo $despesaTelefonBase;?>">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <label>Email</label>
                                                        <div class="input-group">
                                                            <input type="email" class="form-control" name="despesaEmail" value="<?php echo $despesaEmailBase;?>">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card">
                                    <a href="#dadesFactura-collapse" class="collapsed text-dark" data-toggle="collapse" aria-expanded="true">
                                        <div class="p-4">
                                            
                                            <div class="media align-items-center">
                                                <div class="mr-3">
                                                    <i class="uil uil-invoice text-primary h2"></i>
                                                </div>
                                                <div class="media-body overflow-hidden">
                                                    <h5 class="font-size-16 mb-1">Datos de la despesa</h5>
                                                    <p class="text-muted text-truncate mb-0">Editar datos del gasto</p>
                                                </div>
                                                <i class="mdi mdi-chevron-up accor-down-icon font-size-24"></i>
                                            </div>
                                            
                                        </div>
                                    </a>

                                    <div id="dadesFactura-collapse" class="collapse show">
                                        <div class="p-4 border-top">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label>Fecha del gasto</label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" data-provide="datepicker" data-date-format="yyyy/mm/dd" data-date-autoclose="true" value="<?php echo date('Y/m/d',strtotime($dataDespesa));?>" name="despesaData">
                                                            <div class="input-group-append">
                                                                <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <label>Concepto</label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" value="<?php echo $concepteDespesa;?>" name="despesaConcepte">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-8">
                                                    <div class="form-group">
                                                        <label>Proyecto repercutido</label>
                                                        <select class="form-control" name="despesaProjecte" required>
                                                            <option value="<?php echo $idProjecte;?>"><?php echo $expProjecte.' - '.$nomProjecte;?></option>
                                                            <?php 
                                                            $projectes = $database->select("projectes", [
                                                                "id",
                                                                "nom",
                                                                "exp",
                                                                "idUser"
                                                                ],["idUser"=>$userId,"ORDER"=>["exp"=>"DESC"]]);
                                                            foreach ($projectes as $projecte) {
                                                                echo '<option value="'.$projecte['id'].'">'.$projecte['exp'].' - '.$projecte['nom'].'</option>';
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="form-group">
                                                        <label>Importe</label>
                                                        <div class="input-group">
                                                            <input type="number" step="any" onchange="calculPreu()" id="facturaImport" class="form-control" name="despesaImport" value="<?php echo $importDespesa;?>">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg offset-6 col-lg-3 text-right">+ <?php echo number_format($importIVA,2,",",".");?>% IVA</div>
                                                <div class="col-lg-3">
                                                    <div id="valorIVA" class="text-right"><?php echo number_format($importDespesa*($importIVA/100),2,",",".").' €';?></div>
                                                </div>
                                            </div>

                                            <div class="row mt-2">
                                                <div class="col-lg offset-6 col-lg-3 text-right">- <?php echo number_format($importIRPF,2,",",".");?>% IRPF</div>
                                                <div class="col-lg-3">
                                                    <div id="valorIRPF" class="text-right"><?php echo number_format(-$importDespesa*($importIRPF/100),2,",",".").' €';?></div>
                                                </div>
                                            </div>

                                            <div class="row mt-2">
                                                <div class="col-lg offset-6 col-lg-3 text-right">
                                                    <strong>TOTAL</strong>
                                                </div>
                                                <div class="col-lg-3">
                                                    <div id="valorTOTAL" class="text-right" style="font-weight: bold;"><?php echo number_format($importDespes+$importDespes*($importIVA/100)-$importDespes*($importIRPF/100),2,",",".").' €';?></div>
                                                </div>
                                            </div>

                                            <p class="impMod" onclick="showImpost()" style="cursor:pointer;color:#34c38f;">Modificar impuestos</p>
                                            <p class="impAma hidden" onclick="showImpost()" style="cursor:pointer;color:#34c38f;">Esconder impuestos</p>
                                            <div class="impAma hidden">
                                                <div class="row">
                                                    <div class="col-lg-2">Porcentaje de IVA</div>
                                                    <div class="col-lg-2">
                                                        <input type="text" onchange="calculPreu()" class="form-control text-right" name="despesaIVA" id="facturaIVA" value="<?php echo $importIVA;?>">
                                                    </div>
                                                </div>
                                                <div class="row" style="margin-top:5px;margin-bottom: 10px">
                                                    <div class="col-lg-2">Porcentaje de IRPF</div>
                                                    <div class="col-lg-2">
                                                        <input type="text" onchange="calculPreu()" class="form-control text-right" name="despesaIRPF" id="facturaIRPF" value="<?php echo $importIRPF;?>">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- BOTONS -->
                                <div class="d-print-none mt-4 mb-1">
                                    <div class="float-right printerFooter">
                                        <a data-toggle="modal" data-target="#removeDespesa" class="btn btn-danger w-md waves-effect waves-light" style="margin-right:5px">Borrar gasto</a>
                                        <button type="submit" class="btn btn-success waves-effect waves-light mr-1">Guardar gasto</button>
                                        <!--<a href="javascript:window.print()" class="btn btn-success waves-effect waves-light mr-1"><i class="fa fa-print"></i></a>-->
                                    </div>
                                </div>
                            </form>
                            
                            <div class="d-print-none mt-4 ">
                                <a href="despeses.php" class="btn btn-link text-muted">
                                    <i class="uil uil-arrow-left mr-1"></i> Volver a gastos
                                </a>
                            </div>

                        </div>

                        <!-- FACTURA --->
                        <style>
                        .cardFactura{
                            margin-top:25mm;
                            margin-left:20mm;
                            margin-right:20mm;
                            margin-bottom:10mm;
                            font-family: Tahoma, Arial, Verdana, sans-serif;
                        }
                        .numero-factura{
                            color:#bfbfbf;
                            font-size:10pt;
                        }
                        .facturaTo{
                            font-size: 10pt;
                            margin:0;
                            line-height: 1.2;
                        }
                        .facturaTo .nameTo{
                            font-size: 8pt;
                            font-weight: bold;
                            line-height: 2.5;
                        }
                        .facturaTitle{
                            font-size: 10pt !important;
                            margin-top:20mm;
                        }
                        .facturaDate{
                            text-align: right;
                        }


                        .tabla-factura{
                            border-color: #fff;
                            margin-top:5mm;
                            font-size: 10pt;
                        }
                        .tabla-factura th{
                            border-bottom: #dcdcdc 1px solid;
                            padding-bottom:10px;
                        }
                        .concepte{
                            height:100px !important;
                            border-bottom: #dcdcdc 1px solid;
                        }
                        .concepte td{
                            vertical-align: top !important;
                            padding-top:20px;
                        }
                        .subtotal,.iva,.irpf,.total{
                            height: 30px;
                        }
                        .last-row-factura{
                            border-bottom: #dcdcdc 1px solid;
                            padding-bottom:15px;
                        }
                        .salt{
                            height: 15px;
                        }
                        .tabla-factura-contingut{
                            width: 100%;
                        }
                        .facturaFooter{
                            font-size:10pt;
                            color:#ccc;
                            margin-top:72.36mm;
                        }
                        .footerTitle{
                            font-weight: bold;
                            line-height: 1.5px;
                        }
                        .printerFooter{
                            padding-bottom:20px !important;
                        }
                        </style>
                        <div class="avisNoFactura d-print-none">Visualización de gasto no disponible</div>
                        <!--<div class="fullFactura">
                            <div class="card">
                                <div class="card-body cardFactura">
                                    <div class="row">
                                        <div class="col-xl-12">
                                            <div class="float-right numero-factura">Número de factura: <?php echo $numeroFactura;?></div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-xl-12 facturaTo">
                                            <span class="nameTo"><?php echo mb_strtoupper($facturaNom);?></span><br>
                                            <?php echo $facturaDireccio;?><br>
                                            <?php echo $facturaCP.' '.$facturaCiutat;?><br>
                                            <?php echo 'CIF '.$facturaCIF;?>
                                            <?php echo $facturaTelefon;?>
                                            <?php echo $facturaEmail;?></p>
                                        </div>
                                    </div>

                                    <div class="row facturaTitle">
                                        <div class="col-lg-6"><strong>FACTURA</strong></div>
                                        <div class="col-lg-6 facturaDate">Barcelona, <?php echo date('d/m/Y',strtotime($dataFactura));?></div>
                                    </div>

                                    <div class="tabla-factura">
                                        <table class="table-nowrap table-centered tabla-factura-contingut">
                                            <thead>
                                                <tr>
                                                    <th>Descripció</th>
                                                    <th style="width: 200px;"></th>
                                                    <th class="text-right" style="width: 120px;">Import</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr class="concepte">
                                                    <td>Col·laboració professional en el projecte <?php echo $nomProjecte;?></td>
                                                    <td></td>
                                                    <td class="text-right"><?php echo number_format($importFactura,2,",",".").' €';?></td>
                                                </tr>
                                                <tr class="salt">
                                                <tr class="subtotal">
                                                    <td></td>
                                                    <td><strong>Base imposable</strong></td>
                                                    <td class="text-right"><strong><?php echo number_format($importFactura,2,",",".").' €';?></strong></td>
                                                </tr>
                                                <tr class="iva">
                                                    <td></td>
                                                    <td>+ <?php echo number_format($importIVA,2,",",".");?>% IVA</td>
                                                    <td class="text-right"><?php echo number_format($importFactura*$importIVA/100,2,",",".").' €';?></td>
                                                </tr>
                                                <tr class="irpf <?php if($importIRPF==0){echo "hidden";}?>">
                                                    <td></td>
                                                    <td class="last-row-factura">- <?php echo number_format($importIRPF,2,",",".");?>% IRPF</td>
                                                    <td class="last-row-factura text-right"><?php echo number_format($importFactura*(-$importIRPF/100),2,",",".").' €';?></td>
                                                </tr>
                                                <tr class="salt">
                                                <tr class="total">
                                                    <td></td>
                                                    <td><strong>Import total</strong></td>
                                                    <td class="text-right"><strong><?php echo number_format($importFactura*(1+($importIVA-$importIRPF)/100),2,",",".").' €';?></strong></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="row facturaFooter">
                                        <div class="col-xl-3">Factura emesa per</div>
                                        <div class="col-xl-4">
                                            <span class=footerTitle>Agustí Roig Malaret</span><br>
                                            NIF 47.917.961-Z<br>
                                            Passeig de Sant Joan 144<br>
                                            08037 Barcelona, Espanya
                                        </div>
                                        <div class="col-xl-5">
                                            <span class=footerTitle>Compte bancari</span><br>
                                            BBVA<br>
                                            Beneficiari: Agustí Roig Malaret<br>
                                            IBAN: ES33 0182 3842 1202 0859 2702<br>
                                            SWIFT: BBVAESBB
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>-->
                    <?php } ?>
                    </div>
                    <!-- end row -->


                </div> <!-- container-fluid -->
            </div>
            <!-- End Page-content -->


            <?php include_once("sections/footer.php") ?>
            <?php include_once("sections/modal-removeDespesa.php") ?>
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