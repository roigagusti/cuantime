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
    <title>Cuantime. <?php echo $text['Facturas'];?></title>

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
        $numeroFactura = $database->get("factures","numero",["id"=>$_GET['id']]);
        $idProjecte = $database->get("factures","idProjecte",["id"=>$_GET['id']]);
        $importFactura = $database->get("factures","import",["id"=>$_GET['id']]);
        $importIVA = $database->get("factures","iva",["id"=>$_GET['id']]);
        $importIRPF = $database->get("factures","irpf",["id"=>$_GET['id']]);
        $facturaUser = $database->get("factures","idUser",["id"=>$_GET['id']]);

        $nomProjecte = $database->get("projectes","nom",["id"=>$idProjecte]);
        $expProjecte = $database->get("projectes","exp",["id"=>$idProjecte]);
        $idClient = $database->get("projectes","idClient",["id"=>$idProjecte]);

        $facturacioClient = $database->get("factures","facturaNom",["id"=>$_GET['id']]);
        if(strlen($facturacioClient)>0){
            $facturaNom = $database->get("factures","facturaNom",["id"=>$_GET['id']]);
            $facturaDireccio = $database->get("factures","facturaDireccio",["id"=>$_GET['id']]);
            $facturaCP = $database->get("factures","facturaCP",["id"=>$_GET['id']]);
            $facturaCiutat = $database->get("factures","facturaCiutat",["id"=>$_GET['id']]);
            $facturaCIF = $database->get("factures","facturaCIF",["id"=>$_GET['id']]);
        }else{
            $facturaNom = $database->get("clients","nom",["id"=>$idClient]);   
            $facturaDireccio = $database->get("clients","direccio",["id"=>$idClient]); 
            $facturaCP= $database->get("clients","codiPostal",["id"=>$idClient]);    
            $facturaCiutat= $database->get("clients","ciutat",["id"=>$idClient]);    
            $facturaCIF= $database->get("clients","cif",["id"=>$idClient]);             
        }

        if($database->get("factures","facturaTelefon",["id"=>$_GET['id']])){
            $facturaTelefonBase = $database->get("factures","facturaTelefon",["id"=>$_GET['id']]);
            $facturaTelefon = '<br>Telèfon: '.$facturaTelefonBase;
        }else{
            $facturaTelefonBase = $database->get("clients","telefon",["id"=>$idClient]);   
            $facturaTelefon = '<br>Telèfon: '.$facturaTelefonBase;      
        }

        if($database->get("factures","facturaTelefon",["id"=>$_GET['id']])){
            $facturaEmailBase = $database->get("factures","facturaEmail",["id"=>$_GET['id']]);
            $facturaEmail = '<br>Email: '.$facturaEmailBase;
        }else{
            $facturaEmailBase = $database->get("clients","mail",["id"=>$idClient]);   
            $facturaEmail = '<br>Email: '.$facturaEmailBase;       
        }

        $facturaIVA = $database->get("factures","iva",["id"=>$_GET['id']]);
        $facturaIRPF = $database->get("factures","irpf",["id"=>$_GET['id']]);

        $numeroFactura = $database->get("factures","numero",["id"=>$_GET['id']]);
        $dataFactura = $database->get("factures","data",["id"=>$_GET['id']]);
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
                                <h4 class="mb-0"><?php echo $text['Factura detalle'];?></h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="index.php">Aldasoro</a></li>
                                    <li class="breadcrumb-item"><a href="factures.php"><?php echo $text['Facturas'];?></a></li>
                                    <li class="breadcrumb-item active">F_<?php echo beautyExp($numeroFactura);?></li>
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
                        if($facturaUser!=$userAdminEmpresa){echo '<div class="col-lg-12"><div class="card h-100"><div class="card-body">La página a la que intentas acceder no está disponible</div></div></div><div class="d-print-none mt-4"><a href="factures.php" class="btn btn-link text-muted"><i class="uil uil-arrow-left mr-1"></i> Volver a facturas</a></div>';
                            }else{
                        ?>


                        <div class="dadesFactura d-print-none">
                            <form action="conexiones/administracio.php?action=editFactura&id=<?php echo $_GET['id'];?>" method="post">
                                <div class="card">
                                    <a href="#dadesClient-collapse" class="collapsed text-dark" data-toggle="collapse">
                                        <div class="p-4">
                                            
                                            <div class="media align-items-center">
                                                <div class="mr-3">
                                                    <i class="uil uil-user text-primary h2"></i>
                                                </div>
                                                <div class="media-body overflow-hidden">
                                                    <h5 class="font-size-16 mb-1"><?php echo $text['Datos del cliente'];?></h5>
                                                    <p class="text-muted text-truncate mb-0"><?php echo $text['Editar datos del cliente'];?></p>
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
                                                        <label><?php echo $text['Nombre'];?></label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" name="clientNom" value="<?php echo $facturaNom;?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label><?php echo $text['Empresa'];?></label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" name="clientEmpresa" value="<?php echo $facturaEmpresa;?>">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-8">
                                                    <div class="form-group">
                                                        <label><?php echo $text['Dirección'];?></label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" name="clientDireccio" value="<?php echo $facturaDireccio;?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="form-group">
                                                        <label><?php echo $text['Código postal'];?></label>
                                                        <div class="input-group">
                                                            <input type="number" class="form-control" name="clientCP" value="<?php echo $facturaCP;?>">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <div class="form-group">
                                                        <label><?php echo $text['Ciudad'];?></label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" name="clientCiutat" value="<?php echo $facturaCiutat;?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3">
                                                    <div class="form-group">
                                                        <label>CIF</label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" name="clientCIF" value="<?php echo $facturaCIF;?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-5">
                                                    <div class="form-group">
                                                        <label><?php echo $text['Teléfono'];?></label>
                                                        <div class="input-group">
                                                            <input type="phone" class="form-control" name="clientTelefon" value="<?php echo $facturaTelefonBase;?>">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <label><?php echo $text['Email'];?></label>
                                                        <div class="input-group">
                                                            <input type="email" class="form-control" name="clientEmail" value="<?php echo $facturaEmailBase;?>">
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
                                                    <h5 class="font-size-16 mb-1"><?php echo $text['Datos de la factura'];?></h5>
                                                    <p class="text-muted text-truncate mb-0"><?php echo $text['Editar datos de facturación'];?></p>
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
                                                        <label><?php echo $text['Número de factura'];?></label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" name="facturaNumero" value="<?php echo $numeroFactura;?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label><?php echo $text['Fecha de facturación'];?></label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" data-provide="datepicker" data-date-format="yyyy/mm/dd" data-date-autoclose="true" value="<?php echo date('Y/m/d',strtotime($dataFactura));?>" name="facturaData">
                                                            <div class="input-group-append">
                                                                <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-8">
                                                    <div class="form-group">
                                                        <label><?php echo $text['Proyecto'];?></label>
                                                        <select class="form-control" name="facturaProjecte" required>
                                                            <option value="<?php echo $idProjecte;?>"><?php echo $expProjecte.' - '.$nomProjecte;?></option>
                                                            <?php 
                                                            $projectes = $database->select("projectes", [
                                                                "id",
                                                                "nom",
                                                                "exp",
                                                                "idUser"
                                                                ],["idUser"=>$userEmpresa,"ORDER"=>["exp"=>"DESC"]]);
                                                            foreach ($projectes as $projecte) {
                                                                echo '<option value="'.$projecte['id'].'">'.$projecte['exp'].' - '.$projecte['nom'].'</option>';
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="form-group">
                                                        <label><?php echo $text['Importe'];?></label>
                                                        <div class="input-group">
                                                            <input type="number" onchange="calculPreu()" id="facturaImport" step="any" class="form-control" name="facturaImport" value="<?php echo $importFactura;?>">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg offset-6 col-lg-3 text-right">+ <?php echo number_format($facturaIVA,2,",",".");?>% IVA</div>
                                                <div class="col-lg-3">
                                                    <div id="valorIVA" class="text-right"><?php echo number_format($importFactura*($importIVA/100),2,",",".").' €';?></div>
                                                </div>
                                            </div>

                                            <div class="row mt-2">
                                                <div class="col-lg offset-6 col-lg-3 text-right">- <?php echo number_format($facturaIRPF,2,",",".");?>% IRPF</div>
                                                <div class="col-lg-3">
                                                    <div id="valorIRPF" class="text-right"><?php echo number_format(-$importFactura*($importIRPF/100),2,",",".").' €';?></div>
                                                </div>
                                            </div>

                                            <div class="row mt-2">
                                                <div class="col-lg offset-6 col-lg-3 text-right">
                                                    <strong>TOTAL</strong>
                                                </div>
                                                <div class="col-lg-3">
                                                    <div id="valorTOTAL" class="text-right" style="font-weight: bold;"><?php echo number_format($importFactura+$importFactura*($importIVA/100)-$importFactura*($importIRPF/100),2,",",".").' €';?></div>
                                                </div>
                                            </div>

                                            <p class="impMod" onclick="showImpost()" style="cursor:pointer;color:#34c38f;"><?php echo $text['Modificar impostos'];?></p>
                                            <p class="impAma hidden" onclick="showImpost()" style="cursor:pointer;color:#34c38f;"><?php echo $text['Amagar impostos'];?></p>
                                            <div class="impAma hidden">
                                                <div class="row">
                                                    <div class="col-lg-2"><?php echo $text['Porcentaje de'];?> IVA</div>
                                                    <div class="col-lg-2">
                                                        <input type="text" onchange="calculPreu()" class="form-control text-right" name="facturaIVA" id="facturaIVA" value="<?php echo $facturaIVA;?>">
                                                    </div>
                                                </div>
                                                <div class="row" style="margin-top:5px;margin-bottom: 10px">
                                                    <div class="col-lg-2"><?php echo $text['Porcentaje de'];?> IRPF</div>
                                                    <div class="col-lg-2">
                                                        <input type="text" onchange="calculPreu()" class="form-control text-right" name="facturaIRPF" id="facturaIRPF" value="<?php echo $facturaIRPF;?>">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- BOTONS -->
                                <div class="d-print-none mt-4 mb-1">
                                    <div class="float-right printerFooter">
                                        <a data-toggle="modal" data-target="#removeFactura" class="btn btn-danger w-md waves-effect waves-light" style="margin-right:5px"><?php echo $text['Borrar factura'];?></a>
                                        <button type="submit" class="btn btn-success waves-effect waves-light mr-1"><?php echo $text['Guardar factura'];?></button>
                                        <!--<a href="javascript:window.print()" class="btn btn-success waves-effect waves-light mr-1"><i class="fa fa-print"></i></a>-->
                                    </div>
                                </div>
                            </form>
                            
                            <div class="d-print-none mt-4 ">
                                <a href="factures.php" class="btn btn-link text-muted">
                                    <i class="uil uil-arrow-left mr-1"></i> <?php echo $text['Volver a facturas'];?>
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
                        <div class="avisNoFactura d-print-none"><?php echo $text['Visualización de factura no disponible'];?></div>
                        <div class="fullFactura">
                            <div class="card">
                                <div class="card-body cardFactura">
                                    <div class="row">
                                        <div class="col-xl-12">
                                            <div class="float-right numero-factura"><?php echo $text['Número de factura'];?>: <?php echo beautyExp($numeroFactura);?></div>
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
                                        <table class="table-centered tabla-factura-contingut">
                                            <thead>
                                                <tr>
                                                    <th><?php echo $text['Descripción'];?></th>
                                                    <th style="width:120px"></th>
                                                    <th style="width:120px" class="text-right"><?php echo $text['Importe'];?></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr class="concepte">
                                                    <td><?php echo $text['Colaboració profesional en el proyecto'];?> <?php echo $nomProjecte;?></td>
                                                    <td></td>
                                                    <td class="text-right"><?php echo number_format($importFactura,2,",",".").' €';?></td>
                                                </tr>
                                                <tr class="salt">
                                                <tr class="subtotal">
                                                    <td></td>
                                                    <td><strong><?php echo $text['Base imponible'];?></strong></td>
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
                                                    <td><strong><?php echo $text['Importe total'];?></strong></td>
                                                    <td class="text-right"><strong><?php echo number_format($importFactura*(1+($importIVA-$importIRPF)/100),2,",",".").' €';?></strong></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <?php
                                    $empresaUser = $database->get("users","empresa",["email"=>$_SESSION['user_name']]);
                                    $empresa = $database->get("empreses",[
                                        "empresaNom",
                                        "empresaDireccio",
                                        "empresaCP",
                                        "empresaCiutat",
                                        "empresaTelefon",
                                        "empresaCIF",
                                        "empresaBanc",
                                        "empresaIBAN",
                                        "empresaSWIFT"
                                    ],["id"=>$empresaUser]);
                                    ?>

                                    <div class="row facturaFooter">
                                        <div class="col-xl-3"><?php echo $text['Factura emitida por'];?></div>
                                        <div class="col-xl-4">
                                            <span class=footerTitle>
                                                <?php 
                                                if(strlen($empresa['empresaNom'])==0){
                                                    echo "Nombre de empresa";
                                                }else{
                                                    echo $empresa['empresaNom'];
                                                };?>
                                            </span><br>
                                                <?php 
                                                if(strlen($empresa['empresaCIF'])==0){
                                                    echo "CIF: -";
                                                }else{
                                                    echo "CIF: ".dni($empresa['empresaCIF']);
                                                };?><br>
                                            <?php echo $empresa['empresaDireccio'];?><br>
                                            <?php echo $empresa['empresaCP'].' '.$empresa['empresaCiutat'];?>
                                        </div>
                                        <div class="col-xl-5" style="padding-right:0">
                                            <span class=footerTitle><?php echo $text['Cuenta bancaria'];?></span><br>
                                            <?php echo $empresa['empresaBanc'];?><br>
                                            <?php echo $text['Beneficiario'];?>: <?php echo $empresa['empresaNom'];?><br>
                                            IBAN: <?php echo iban($empresa['empresaIBAN']);?><br>
                                            SWIFT: <?php echo $empresa['empresaSWIFT'];?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    </div>
                    <!-- end row -->


                </div> <!-- container-fluid -->
            </div>
            <!-- End Page-content -->


            <?php include_once("sections/footer.php") ?>
            <?php include_once("sections/modal-removeFactura.php") ?>
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