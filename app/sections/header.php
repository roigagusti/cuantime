<header id="page-topbar">
    <div class="navbar-header">
        <div class="d-flex">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <a href="/" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="img/cuantime_light-sm.png" alt="" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="img/cuantime_light-lg.png" alt="" height="20">
                    </span>
                </a>

                <a href="/" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="img/cuantime_light-sm.png" alt="" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="img/cuantime_light-lg" alt="" height="20">
                    </span>
                </a>
            </div>

            <!-- BARRES RESPONSIVE -->
            <button type="button" class="btn btn-sm px-3 font-size-16 header-item waves-effect vertical-menu-btn">
                <i class="fa fa-fw fa-bars"></i>
            </button>

            <!-- BUSCADOR -->
            <form class="app-search d-none d-lg-block" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
                <div class="position-relative">
                    <input type="text" class="form-control" name="searchQuery" placeholder="<?php echo $text['Buscar'];?>...">
                </div>
            </form>
        </div>

        <div class="d-flex">
            <!-- TANCAR BUSCADOR -->
            <?php if(isset($_POST['searchQuery'])){?>
            <div class="dropdown d-inline-block searchResultsCloseIcon">
                <button onclick="closeSearch()" class="btn header-item" data-toggle="">
                    <span aria-hidden="true" style="font-size:24px">×</span>
                </button>
            </div>
            <?php } ?>

            <!-- FITXAR -->
            <div class="d-inline-block p-3">
                <?php 
                $lastFitxadaId = $database->max("fitxatges","id",["idUser"=>$userId]);
                $lastFitxada = $database->get("fitxatges","timeOut",["id"=>$lastFitxadaId]);
                $countFitxades = $database->count("fitxatges",["idUser"=>$userId]);

                if($countFitxades>0){
                    if($lastFitxada==NULL){
                        $fitxadesBGC = "rgba(244,106,106,.25)";
                        $fitxadesFormAction = "fitxarSortir";
                        $fitxadesButtonColor = "danger";
                        $fitxadesButtonText = "Sortir";

                        $lastInFitxada = $database->get("fitxatges","timeIn",["id"=>$lastFitxadaId]);
                        $a='2021-02-08 23:59:00';

                            //minutes  passed between the given and current date
                        $seconds_passed = time()-strtotime($lastInFitxada);
                        $valorTemps = floor(intval($seconds_passed)/3600).' h '.round((intval($seconds_passed)%3600)/60,0).' min';
                    }else{
                        $fitxadesBGC = "#d8f2ec";
                        $fitxadesFormAction = "fitxarEntrar";
                        $fitxadesButtonColor = "success";
                        $fitxadesButtonText = "Entrar";   
                        $valorTemps = "0h 00 min";             
                    }
                }else{
                    $fitxadesBGC = "#d8f2ec";
                    $fitxadesFormAction = "fitxarEntrar";
                    $fitxadesButtonColor = "success";
                    $fitxadesButtonText = "Entrar"; 
                    $valorTemps = "0h 00 min";        
                }
                ?>
                <div class="header-fitxar" style="border-radius:30px;background-color:<?php echo $fitxadesBGC;?>">
                    <div style="width:100px;text-align: center;display: inline-block;"><?php echo $valorTemps;?></div>
                    <form class="d-inline-block" method="post" action="conexiones/rrhh.php?action=<?php echo $fitxadesFormAction;?>&url=<?php echo $_SERVER['REQUEST_URI'];?>">
                        <input type="hidden" class="form-control" value="<?php echo $userId;?>" name="userId">
                        <button type="submit" class="btn btn-<?php echo $fitxadesButtonColor;?> btn-rounded waves-effect waves-light"><?php echo $fitxadesButtonText;?></button>
                    </form>
                </div>
            </div>

            
            <!-- USUARI -->
            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="bg-soft-primary rounded-circle text-primary" style="
                    width:36px;
                    height:36px;
                    -webkit-box-align: center;
                    -ms-flex-align: center;
                    align-items: center;
                    background-color: #34c38f;
                    color: #fff;
                    display: inline-flex;
                    font-weight: 500;
                    -webkit-box-pack: center;
                    -ms-flex-pack: center;
                    justify-content: center;">
                    <span style="font-size:0.9em;"><?php echo inicialsNom($userName);?></span>
                    </span>
                    <span class="d-none d-xl-inline-block ml-1 font-weight-medium font-size-15"><?php echo $userFirstName;?></span>
                    <i class="uil-angle-down d-none d-xl-inline-block font-size-15"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item d-block" href="perfil.php"><span class="align-middle"><?php echo $text['Configuración'];?></span>
                    <a class="dropdown-item" href="conexiones/logout.php"><span class="align-middle"><?php echo $text['Cerrar sesión'];?></span></a>
                </div>
            </div>

        </div>
    </div>
</header>

<!-- RESPOSTA DEL BUSCADOR -->
<?php 
if(isset($_POST['searchQuery'])){
    echo '<div class="searchResults">';
    $clientsNom = $database->select("clients", [
        "id",
        "nom",
        "idUser"
        ],["AND"=>["idUser"=>$userEmpresa,"nom[~]"=>$_POST['searchQuery']]]);
    $clientsEmpresa = $database->select("clients", [
        "id",
        "empresa",
        "idUser"
        ],["AND"=>["idUser"=>$userEmpresa,"empresa[~]"=>$_POST['searchQuery']]]);
    $projectesNom = $database->select("projectes", [
        "id",
        "exp",
        "nom",
        "idUser"
        ],["AND"=>["idUser"=>$userAdminEmpresa,"exp[>]"=>0,"nom[~]"=>$_POST['searchQuery']]]);
    $projectesCiutat = $database->select("projectes", [
        "id",
        "exp",
        "nom",
        "ciutat",
        "idUser"
        ],["AND"=>["idUser"=>$userAdminEmpresa,"exp[>]"=>0,"ciutat[~]"=>$_POST['searchQuery']]]);

    if(count($clientsNom)>0){
        echo '<span style="font-size:0.75em;font-weight:bold">CLIENTES</span><br>';
        echo '<ul class="resultQuery">';
        foreach ($clientsNom as $client) {
            echo '<li><a href="client-detall.php?id='.$client['id'].'" class="text-body">'.$client['nom'].'</a> <small style="color:#ccc">NOMBRE</small></li>';
        }
        echo '</ul>';
    }
    if(count($clientsEmpresa)>0){
        if(count($clientsNom)==0){echo '<span style="font-size:0.75em;font-weight:bold">CLIENTES</span><br>';}
        echo '<ul class="resultQuery">';
        foreach ($clientsEmpresa as $client) {
            echo '<li><a href="client-detall.php?id='.$client['id'].'" class="text-body">'.$client['empresa'].'</a> <small style="color:#ccc">EMPRESA</small></li>';
        }
        echo '</ul>';
    }
    if(count($projectesNom)>0){
        if(count($clientsNom)+count($clientsEmpresa)>0){echo '<br>';}
        echo '<span style="font-size:0.75em;font-weight:bold">EXPEDIENTES</span><br>';
        echo '<ul class="resultQuery">';
        foreach ($projectesNom as $projecte) {
            echo '<li><a href="expedient-detall.php?id='.$projecte['id'].'" class="text-body"><strong>'.$projecte['exp'].'</strong>. '.$projecte['nom'].'</a> <small style="color:#ccc">NOMBRE</small></li>';
        }
        echo '</ul>';
    }
    if(count($projectesCiutat)>0){
        if(count($projectesNom)==0){echo '<span style="font-size:0.75em;font-weight:bold">EXPEDIENTES</span><br>';}
        echo '<ul class="resultQuery">';
        foreach ($projectesCiutat as $projecte) {
            echo '<li><a href="expedient-detall.php?id='.$projecte['id'].'" class="text-body"><strong>'.$projecte['exp'].'</strong>. '.$projecte['nom'].'</a> <small style="color:#ccc">CIUDAD</small></li>';
        }
        echo '</ul>';
    }
    $resultats=count($clientsNom)+count($clientsEmpresa)+count($projectesNom)+count($projectesCiutat);
    if($resultats==0){
        echo "<span style='color:#666'>No se han encontrado resultados</span>";        
    }
    echo '</div>';
}
?>
<script>
function closeSearch(){
    $(".searchResults").addClass("hidden");
    $(".searchResultsCloseIcon").addClass("hidden");
};
document.onkeydown = function(evt) {
    evt = evt || window.event;
    if (evt.keyCode == 27) {
        $(".searchResults").addClass("hidden");
        $(".searchResultsCloseIcon").addClass("hidden");
    }
};
</script>