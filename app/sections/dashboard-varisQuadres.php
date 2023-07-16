<div class="row">
    <div class="col-xl-8">
        <div class="card" id="analisiVentes">
            <div class="card-body">
                <div class="float-right">
                    <div class="dropdown">
                        <a class="dropdown-toggle text-reset" href="#" id="dropdownMenuButton5"
                            data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false">
                            <span class="font-weight-semibold">Ordenat per:</span> <span class="text-muted">Anys<i class="mdi mdi-chevron-down ml-1"></i></span>
                        </a>

                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton5">
                            <a class="dropdown-item" href="#">Mesos</a>
                            <a class="dropdown-item" href="#">Anys</a>
                            <a class="dropdown-item" href="#">Setmanes</a>
                        </div>
                    </div>
                </div>
                <h4 class="card-title mb-4">Anàlisi de ventes</h4>

                <div class="mt-1">
                    <ul class="list-inline main-chart mb-0">
                        <li class="list-inline-item chart-border-left mr-0 border-0">
                            <h3 class="text-primary"><span data-plugin="counterup">80.371</span>€<span class="text-muted d-inline-block font-size-15 ml-3">Facturació</span></h3>
                        </li>
                        <li class="list-inline-item chart-border-left mr-0">
                            <h3><span data-plugin="counterup">32.588</span>€<span class="text-muted d-inline-block font-size-15 ml-3">Despeses</span>
                            </h3>
                        </li>
                        <li class="list-inline-item chart-border-left mr-0">
                            <h3><span data-plugin="counterup">47.783</span>€<span class="text-muted d-inline-block font-size-15 ml-3">Beneficis</span></h3>
                        </li>
                    </ul>
                </div>

                <div class="mt-3">
                    <div id="sales-analytics-chart" class="apex-charts" dir="ltr"></div>
                </div>
            </div> <!-- end card-body-->
        </div> <!-- end card-->
    </div> <!-- end col-->

    <div class="col-xl-4">
        <div class="card" id="topVentes">
            <div class="card-body">
                <div class="float-right">
                    <div class="dropdown">
                        <a class="dropdown-toggle text-reset" href="#" id="dropdownMenuButton1"
                            data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false">
                            <span class="font-weight-semibold">Ordenat:</span> <span class="text-muted">Anys<i class="mdi mdi-chevron-down ml-1"></i></span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton1">
                            <a class="dropdown-item" href="#">Mesos</a>
                            <a class="dropdown-item" href="#">Anys</a>
                            <a class="dropdown-item" href="#">Setmanes</a>
                        </div>
                    </div>
                </div>


                <h4 class="card-title mb-4">Clients més beneficiosos</h4>
                <?php
                $factures = $database->select("factures", [
                  "id",
                  "numero",
                  "idProjecte",
                  "import"
                  ],["ORDER"=>["import"=>"DESC"],"LIMIT"=>10]);
                $maximImport = $database->max("factures","import");
                foreach ($factures as $factura) {
                    $clientId = $database->get("projectes","idClient",["id"=>$factura['idProjecte']]);
                    $clientNom = $database->get("clients","nom",["id"=>$clientId]);
                    if(strlen($clientNom)>20){
                        $clientNomPrint = substr($clientNom,0,20)."...";
                    }else{
                        $clientNomPrint = $clientNom;
                    }
                    $percentBenef = 100*$factura['import']/$maximImport;
                ?>

                <div class="row align-items-center no-gutters mt-3">
                    <div class="col-sm-8">
                        <p class="text-truncate mt-1 mb-0"><strong><?php echo $factura['numero'];?></strong> - <?php echo $clientNomPrint." (".number_format($factura['import'],2)." €)";?></p>
                    </div>

                    <div class="col-sm-4">
                        <div class="progress mt-1" style="height: 6px;">
                            <div class="progress-bar progress-bar bg-primary" role="progressbar"
                                style="<?php echo "width: ".$percentBenef."%";?>" aria-valuenow="<?php echo $percentBenef;?>" aria-valuemin="0"
                                aria-valuemax="<?php echo $percentBenef;?>">
                            </div>
                        </div>
                    </div>
                </div>
                <?php } ?>
                <!-- end row-->

            </div> <!-- end card-body-->
        </div> <!-- end card-->
    </div> <!-- end Col -->
</div> <!-- end row-->