<div class="vertical-menu">
    <!-- Logo -->
    <div class="navbar-brand-box">
        <a href="//app.cuantime.es/" class="logo logo-dark">
            <span class="logo-sm">
                <img src="img/cuantime_light-sm.png" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="img/cuantime_light-lg.png" alt="" height="18">
            </span>
        </a>

        <a href="//app.cuantime.es/" class="logo logo-light">
            <span class="logo-sm">
                <img src="img/cuantime_light-sm.png" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="img/cuantime_light-lg.png" alt="" height="18">
            </span>
        </a>
    </div>

    <button type="button" class="btn btn-sm px-3 font-size-16 header-item waves-effect vertical-menu-btn">
        <i class="fa fa-fw fa-bars"></i>
    </button>

    <div data-simplebar class="sidebar-menu-scroll">
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title">Menú</li>

                <li>
                    <a href="tareas.php" class="waves-effect">
                        <i class="uil-list-ui-alt"></i>
                        <span>Tareas</span>
                    </a>
                </li>
                <li>
                    <a href="expedients.php" class="waves-effect">
                        <i class="uil-folder"></i>
                        <span><?php echo $text['Expedients'];?></span>
                    </a>
                </li>

                <?php if($userType<2){?>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="uil-invoice"></i>
                        <span><?php echo $text['Administració'];?></span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="clients.php"><?php echo $text['Clients'];?></a></li>
                        <li><a href="ofertes.php"><?php echo $text['Ofertes'];?></a></li>
                        <li><a href="factures.php"><?php echo $text['Factures'];?></a></li>
                        <li><a href="despeses.php"><?php echo $text['Despeses'];?></a></li>
                        <li><a href="impuestos.php"><?php echo $text['Impuestos'];?></a></li>
                    </ul>
                </li>
                <?php } ?>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="uil-clock-nine"></i>
                        <span>Personal</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="fitxatges.php"><?php echo $text['Fitxatges'];?></a></li>
                        <?php
                        if($userType<2){echo '<li><a href="equip.php">'.$text['Equip'].'</a></li>';};
                        ?>
                    </ul>
                </li>

            </ul>
        </div>
    </div>
</div>