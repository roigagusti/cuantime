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
function dni($a){
    if(ctype_alpha(substr($a,-1))&&!ctype_alpha($a[0])){
      return substr($a,0,2).'.'.substr($a,2,3).'.'.substr($a,5,3).'-'.substr($a,8,1);
    }else if(ctype_alpha($a[0])&&!ctype_alpha(substr($a,-1))){
      return $a[0].'-'.substr($a,1,2).'.'.substr($a,3,3).'.'.substr($a,6,3);
    }else{
        return $a;
    }
}
function iban($a){
    if(strlen($a)%4==0){
        $div=strlen($a)/4;
        $iban='';
        for($i=0;$i<$div;$i++){ 
            $iban.=substr($a,$i*4,4).' ';
        }
        $iban = substr($iban,0,-1);
        return $iban;
    }else{
        return $a;
    }
}
function formatFactura($a){
    switch($a){
        case 1:
            return 'YYxxx.1';
            break;
        case 2:
            return 'YY-xxx.1';
            break;
        case 3:
            return 'YY xxx.1';
            break;
        case 4:
            return 'xxx.1';
            break;
        case 5:
            return 'xxxx.1';
            break;
        default:
            return 'YYxxx.1';
            break;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
    <head>
    <!-- Meta data -->
    <?php include_once("sections/meta.php") ?>

    <!-- Títol i Favicons -->
    <title>Cuantime. Perfil</title>

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
                                <h4 class="mb-0"></h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="index.php">Cuantime</a></li>
                                        <li class="breadcrumb-item active">Perfil</li>
                                    </ol>
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- ZONA NOTIFIACIONS -->
                    <?php include_once("sections/notificacions.php") ?>

                    <!--<php include_once("sections/dashboard-topQuadres.php") ?>-->
                    <!--<php include_once("sections/dashboard-varisQuadres.php") ?>-->
                    <?php 
                    $empresaUsuari = $database->get("users", "empresa",["id"=>$userId]);
                    $langUsuari = $database->get("users", "language",["id"=>$userId]);
                    $planUsuari = $database->get("users", "plan",["id"=>$userAdminEmpresa]);
                    $tipusUsuari = $database->get("users", "tipusUsuari",["id"=>$userId]);
                    $empresa = $database->get("empreses", [
                        "id",
                        "empresaNom",
                        "empresaDireccio",
                        "empresaCP",
                        "empresaCiutat",
                        "empresaTelefon",
                        "empresaCIF",
                        "empresaBanc",
                        "empresaIBAN",
                        "empresaSWIFT",
                        "empresaFormatFactura",
                        "empresaPrefixFactura",
                        "assignacioDefecteColab"
                        ],["id"=>$empresaUsuari]);
                    $nextNumeroFactura = $database->max("factures","numero",['idUser'=>$userId]);

                    $empresaNom = $empresa['empresaNom'];
                    if($empresa['empresaDireccio']==''){$empresaDireccio='-';}else{
                        $empresaDireccio = $empresa['empresaDireccio'];
                    }
                    if($empresa['empresaCP']==''){$empresaCP='-';}else{
                        $empresaCP = $empresa['empresaCP'];
                    }
                    if($empresa['empresaCiutat']==''){$empresaCiutat='-';}else{
                        $empresaCiutat = $empresa['empresaCiutat'];
                    }
                    if($empresa['empresaTelefon']==''){$empresaTelefon='-';}else{
                        $empresaTelefon = telefon($empresa['empresaTelefon']);
                    }
                    if($empresa['empresaCIF']==''){$empresaCIF='-';}else{
                        $empresaCIF = dni($empresa['empresaCIF']);
                    }

                    if($empresa['empresaBanc']==''){$empresaBanc='-';}else{
                        $empresaBanc = $empresa['empresaBanc'];
                    }
                    if($empresa['empresaIBAN']==''){$empresaIBAN='-';}else{
                        $empresaIBAN = iban($empresa['empresaIBAN']);
                    }
                    if($empresa['empresaSWIFT']==''){$empresaSWIFT='-';}else{
                        $empresaSWIFT = $empresa['empresaSWIFT'];
                    }

                    $empresaPrefixFactura = $empresa['empresaPrefixFactura'];
                    $empresaFormatFactura = formatFactura($empresa['empresaFormatFactura']);
                    $empresaNextFactura = $nextNumeroFactura+1;
                    $empresaAssignacio = $empresa['assignacioDefecteColab'];
                    ?>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="card">
                                <div class="card-body">
                                    <h4 style="font-size:16px">Mi empresa</h4>
                                    <div class="profileDades">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <ul class="dadesConfig">
                                                    <li><div class="row"><div class="dadesTitles">Nombre</div> <div class="dadesFacturacio"><?php echo $empresaNom;?></div></div></li>
                                                    <li><div class="row"><div class="dadesTitles">Dirección</div> <div class="dadesFacturacio"><?php echo $empresaDireccio;?></div></div></li>
                                                    <li><div class="row"><div class="dadesTitles">Código postal</div> <div class="dadesFacturacio"><?php echo $empresaCP;?></div></div></li>
                                                    <li><div class="row"><div class="dadesTitles">Ciudad</div> <div class="dadesFacturacio"><?php echo $empresaCiutat;?></div></div></li>
                                                    <li><div class="row"><div class="dadesTitles">Teléfono</div> <div class="dadesFacturacio"><?php echo $empresaTelefon;?></div></div></li>
                                                    <li><div class="row"><div class="dadesTitles">CIF</div> <div class="dadesFacturacio"><?php echo $empresaCIF;?></div></div></li>
                                                    <?php if($tipusUsuari<2){?>
                                                        <br>
                                                        <li><div class="row"><div class="dadesTitles">Banco</div> <div class="dadesFacturacio"><?php echo $empresaBanc;?></div></div></li>
                                                        <li><div class="row"><div class="dadesTitles">IBAN</div> <div class="dadesFacturacio"><?php echo $empresaIBAN;?></div></div></li>
                                                        <li><div class="row"><div class="dadesTitles">SWIFT</div> <div class="dadesFacturacio"><?php echo $empresaSWIFT;?></div></div></li>
                                                        <br>
                                                        <li><div class="row"><div class="dadesTitles">Prefijo factura</div> <div class="dadesFacturacio"><?php echo $empresaPrefixFactura;?></div></div></li>
                                                        <li><div class="row"><div class="dadesTitles">Formato factura</div> <div class="dadesFacturacio"><?php echo $empresaFormatFactura;?></div></div></li>
                                                        <li><div class="row"><div class="dadesTitles">Próxima factura</div> <div class="dadesFacturacio"><?php echo $empresaNextFactura;?></div></div></li>
                                                        <br>
                                                        <li><div class="row"><div class="dadesTitles">
                                                                Creación de expedientes sin oferta
                                                                <a data-container="body" data-toggle="popover" data-placement="bottom" data-content="Permitir crear nuevos expedientes si no hay oferta aceptada para ese expediente." data-original-title="" title="" aria-describedby="popover295241"><i class="uil uil-info-circle"></i></a>
                                                            </div> <div class="dadesFacturacio">No</div></div>
                                                        </li>
                                                        <!--<li><div class="row"><div class="dadesTitles">Asignación por defecto <a data-container="body" data-toggle="popover" data-placement="bottom" data-content="Cuantía econòmica que es dedica als col·laboradors per defecte. Es pot variar a cada projecte." data-original-title="" title="" aria-describedby="popover295241"><i class="uil uil-info-circle"></i></a></div> <div class="dadesFacturacio"><?php echo number_format($empresaAssignacio,2,'.',',');?> %</div></div></li>-->
                                                        <?php if($tipusUsuari<2){?>
                                                            <br>
                                                            <li><a data-toggle="modal" data-target="#userEmpresa" style="cursor:pointer;color:#34c38f">Editar datos</a></li>
                                                    <?php }}?>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="card">
                                <div class="card-body">
                                    <h4 style="font-size:16px">Visibilidad en menú</h4>
                                    <div class="profileDades">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <ul class="dadesConfig">
                                                    <li><div class="row"><div class="dadesTitles">Tareas</div> <div class="dadesFacturacio">Si</div></div></li>
                                                    <li><div class="row"><div class="dadesTitles">Expedientes</div> <div class="dadesFacturacio">Si</div></div></li>
                                                    <li><div class="row"><div class="dadesTitles">Administración</div> <div class="dadesFacturacio">Si</div></div></li>
                                                    <li><div class="row"><div class="dadesTitles">Management</div> <div class="dadesFacturacio">No</div></div></li>
                                                    <li><div class="row"><div class="dadesTitles">Personal</div> <div class="dadesFacturacio">Si</div></div></li>
                                                    <br>
                                                    <li><a data-toggle="modal" data-target="#userVisibility" style="cursor:pointer;color:#34c38f">Editar datos</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        </div>

                        <div class="col-lg-4">
                            <div class="card">
                                <div class="card-body">
                                    <h4 style="font-size:16px">Configuración personal</h4>
                                    <div class="profileConfig">
                                        <ul class="dadesConfig">
                                            <li><?php echo 'Nombre: '.$userName;?></li>
                                            <li><?php echo 'Email: '.$userEmail;?></li>
                                            <li><?php echo 'Contraseña: ********'?></li>
                                            <li><?php echo 'Idioma: '.ucfirst($langUsuari);?></li>
                                            <br>
                                            <li><a data-toggle="modal" data-target="#editProfile" style="cursor:pointer;color:#34c38f">Cambiar configuración</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <?php if($tipusUsuari<2){?>
                                <div class="card">
                                <div class="card-body">
                                    <h4 style="font-size:16px">Suscripciones</h4>
                                    <div class="profileSuscripcio">
                                        <?php switch($planUsuari){
                                            case 1: echo '<div class="planTitle"><i class="uil uil-laptop text-primary"></i><br><strong>Manos a la obra.</strong> Plan expansión (9.99€/mes)</div>';
                                                break;
                                            case 2: echo '<div class="planTitle"><i class="uil uil-plane-fly text-primary"></i><br><strong>Profesional.</strong> Plan profesional (19.99€/mes)</div>';
                                                break;
                                            default: echo '<div class="planTitle"><i class="uil uil-heart text-primary"></i><br><strong>Entre amigos.</strong> Plan inicial (0.00€/mes)</div>';
                                                break;
                                        }?>
                                        <?php if($userId==$userAdminEmpresa){?>
                                        <ul class="dadesConfig mt-4">
                                            <!--<li>Tu próxima facturación es el 9 de marzo de 2021</li>
                                            <br>-->
                                            <li><a data-toggle="modal" data-target="#payment" style="cursor:pointer;color:#34c38f">Cambiar de plan</a></li>
                                            <!--<li><a href="#">Gestionar información de pago</a></li>
                                            <li><a href="#">Datos de facturación</a></li>-->
                                        </ul>
                                        <?php }?>

                                    </div>

                                </div>
                            </div>
                            <?php }?>
                        </div>
                    </div>
                    <!-- end row -->

                </div> <!-- container-fluid -->
            </div>
            <!-- End Page-content -->


            <?php include_once("sections/footer.php") ?>
            <?php include_once("sections/modal-editProfile.php") ?>
            <?php include_once("sections/modal-userEmpresa.php") ?>
            <?php include_once("sections/modal-payment.php") ?>
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
<script src="https://js.stripe.com/v3/"></script>
<script>
// Create an instance of the Stripe object
// Set your publishable API key
var stripe = Stripe('<?php echo STRIPE_PUBLISHABLE_KEY; ?>');

// Create an instance of elements
var elements = stripe.elements();

var style = {
    base: {
        fontWeight: 400,
        fontFamily: 'Roboto, Open Sans, Segoe UI, sans-serif',
        fontSize: '16px',
        lineHeight: '1.4',
        color: '#555',
        backgroundColor: '#fff',
        '::placeholder': {
            color: '#888',
        },
    },
    invalid: {
        color: '#eb1c26',
    }
};

var cardElement = elements.create('cardNumber', {
    style: style
});
cardElement.mount('#card_number');

var exp = elements.create('cardExpiry', {
    'style': style
});
exp.mount('#card_expiry');

var cvc = elements.create('cardCvc', {
    'style': style
});
cvc.mount('#card_cvc');

// Validate input of the card elements
var resultContainer = document.getElementById('paymentResponse');
cardElement.addEventListener('change', function(event) {
    if (event.error) {
        resultContainer.innerHTML = '<p>'+event.error.message+'</p>';
    } else {
        resultContainer.innerHTML = '';
    }
});

// Get payment form element
var form = document.getElementById('paymentFrm');

// Create a token when the form is submitted.
form.addEventListener('submit', function(e) {
    e.preventDefault();
    createToken();
});

// Create single-use token to charge the user
function createToken() {
    stripe.createToken(cardElement).then(function(result) {
        if (result.error) {
            // Inform the user if there was an error
            resultContainer.innerHTML = '<p>'+result.error.message+'</p>';
        } else {
            // Send the token to your server
            stripeTokenHandler(result.token);
        }
    });
}

// Callback to handle the response from stripe
function stripeTokenHandler(token) {
    // Insert the token ID into the form so it gets submitted to the server
    var hiddenInput = document.createElement('input');
    hiddenInput.setAttribute('type', 'hidden');
    hiddenInput.setAttribute('name', 'stripeToken');
    hiddenInput.setAttribute('value', token.id);
    form.appendChild(hiddenInput);
    
    // Submit the form
    form.submit();
}
</script>

</body>
</html>