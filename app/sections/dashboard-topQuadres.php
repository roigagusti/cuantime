<?php
$anyRelatiu = (date("z")+1)/365;
//Facturació anual
$cashLastYear = $database->sum("factures","import",["data[<>]" => [date("Y-m-d", mktime(0, 0, 0, 1, 1, date("Y")-1)), date("Y-m-d", mktime(0, 0, 0, 31, 12, date("Y")-1))]]);
$cashCurrentYear = $database->sum("factures","import",["data[<>]" => [date("Y-m-d", mktime(0, 0, 0, 1, 1, date("Y"))), date("Y-m-d")]]);
$relativeCash = $cashLastYear*$anyRelatiu;
$incrementCurrentCash = 100*($cashCurrentYear/$relativeCash)-100;

//Noves propostes d'honoraris
$propostesLastYear = $database->count("ofertes",["data[<>]" => [date("Y-m-d", mktime(0, 0, 0, 1, 1, date("Y")-1)), date("Y-m-d", mktime(0, 0, 0, 31, 12, date("Y")-1))]]);
$propostesCurrentYear = $database->count("ofertes",["data[<>]" => [date("Y-m-d", mktime(0, 0, 0, 1, 1, date("Y"))), date("Y-m-d")]]);
$propostesRelatives = $propostesLastYear*$anyRelatiu;
$incrementCurrentPropostes = 100*($propostesCurrentYear/$propostesRelatives)-100;

//Clients
$numClients = $database->count("clients");
?>



<div class="row">
    <div class="col-md-6 col-xl-3">
        <div class="card">
            <div class="card-body">
                <div class="float-right mt-2">
                    <div id="total-revenue-chart"></div>
                </div>
                <div>
                    <h4 class="mb-1 mt-1"><span data-plugin="counterup"><?php echo number_format($cashCurrentYear,2);?></span> €</h4>
                    <p class="text-muted mb-0">Ingressos anuals</p>
                </div>
                <p class="text-muted mt-3 mb-0">
                    <?php if($incrementCurrentCash>0){?>
                        <span class="text-success mr-1"><i class="mdi mdi-arrow-up-bold ml-1"></i>
                    <?php }else{ ?>
                        <span class="text-danger mr-1"><i class="mdi mdi-arrow-down-bold ml-1"></i>
                    <?php }?>
                        <?php echo number_format($incrementCurrentCash,2)."%";?></span> respecte l'any passat
                </p>
            </div>
        </div>
    </div> <!-- end col-->

    <div class="col-md-6 col-xl-3">
        <div class="card">
            <div class="card-body">
                <div class="float-right mt-2">
                    <div id="orders-chart"> </div>
                </div>
                <div>
                    <h4 class="mb-1 mt-1"><span data-plugin="counterup"><?php echo $propostesCurrentYear;?></span></h4>
                    <p class="text-muted mb-0">Propostes d'honoraris</p>
                </div>
                <p class="text-muted mt-3 mb-0">
                    <?php if($incrementCurrentCash>0){?>
                        <span class="text-success mr-1"><i class="mdi mdi-arrow-up-bold ml-1"></i>
                    <?php }else{ ?>
                        <span class="text-danger mr-1"><i class="mdi mdi-arrow-down-bold ml-1"></i>
                    <?php }?>
                        <?php echo number_format($incrementCurrentPropostes,2)."%";?></span> respecte l'any passat
                </p>
            </div>
        </div>
    </div> <!-- end col-->

    <div class="col-md-6 col-xl-3">
        <div class="card">
            <div class="card-body">
                <div class="float-right mt-2">
                    <div id="customers-chart"> </div>
                </div>
                <div>
                    <h4 class="mb-1 mt-1"><span data-plugin="counterup"><?php echo $numClients;?></span></h4>
                    <p class="text-muted mb-0">Clients actius</p>
                </div>
            </div>
        </div>
    </div> <!-- end col-->

    <div class="col-md-6 col-xl-3">

        <div class="card">
            <div class="card-body">
                <div class="float-right mt-2">
                    <div id="growth-chart"></div>
                </div>
                <div>
                    <h4 class="mb-1 mt-1"><span data-plugin="counterup"><?php echo number_format(($incrementCurrentCash+$incrementCurrentPropostes)/2,2);?></span>%</h4>
                    <p class="text-muted mb-0">Creixement anual</p>
                </div>
            </div>
        </div>
    </div> <!-- end col-->
</div> <!-- end row-->