<div class="tab-pane active" id="dedicacio">
    <div class="table-responsive">
        <table class="table table-nowrap table-hover mb-0">
            <thead>
                <tr>
                    <th scope="col" style="width:100px">#</th>
                    <th scope="col"><?php echo $text['Nombre'];?></th>
                    <th scope="col" style="width:100px"><?php echo $text['Horas'];?></th>
                    <th scope="col" style="width:120px;" class="text-center"><?php echo $text['Asignación'];?></th>
                    <th scope="col" style="width:120px;"><?php echo $text['Ganancia'];?></th>
                </tr>
            </thead>
            <tbody>
            <?php
            $persones = $database->select("users", [
                "id",
                "nom",
                "empresa",
                ],["AND"=>["empresa"=>$userEmpresa,"active"=>1],"ORDER"=>["nom"=>"ASC"]]);
            $i=0;
            $projecteOferta = $database->sum("ofertes","preu",["idProjecte"=>$_GET['id']]);
            foreach ($persones as $persona) {
                $inicials = inicials($persona['nom']);                             

                // Càlcul de DEDICACIÓ
                $partesDedicats = $database->select("partes",["id","data","idProjecte","percentatge"],["AND"=>["idProjecte"=>$_GET['id'],"idUser"=>$persona['id']]]);
                $tempsDedicat=0;
                foreach($partesDedicats as $parteDedicat){
                    $parteExplode = explode('-',$parteDedicat['data']);
                    $diaParte = intval($parteExplode[2]);
                    $mesParte = $parteExplode[1];
                    $anyParte = $parteExplode[0];
                    $fitxatgesDedicats = $database->select("fitxatges", [
                    "id",
                    "timeIn",
                    "timeOut"
                    ],["timeIn[<>]"=>[date("Y-m-d", mktime(0, 0, 0, $mesParte, $diaParte, $anyParte)), date("Y-m-d", mktime(0, 0, 0, $mesParte, $diaParte+1, $anyParte))]]);
                    $tempsDedicatPerParte=0;
                    foreach ($fitxatgesDedicats as $fitxatgeDedicat) {
                        if($fitxatgeDedicat['timeOut']!=NULL){
                            $tempsDedicatPerParte+=(strtotime($fitxatgeDedicat['timeOut'])-strtotime($fitxatgeDedicat['timeIn']));
                        }
                    }
                    $tempsDedicat+=$tempsDedicatPerParte*(intval($parteDedicat['percentatge'])/100);
                }

                // Càlcul d'ASSIGNACIÓ
                if($persona['id']==$userAdminEmpresa){
                    $assignacio=100-$assignacioEncarregat;
                }elseif($persona['id']==$projecteUserId){
                    $assignacio=$assignacioEncarregat;
                }else{
                    $assignacio=0;
                }
                $i++;
            ?>
                <tr>
                    <td scope="row"><?php echo $i;?></td> 
                    <td>
                        <div class="avatar-xs d-inline-block mr-2">
                            <div class="avatar-title bg-soft-primary rounded-circle text-primary">
                                <span style="font-size:0.9em;"><?php echo $inicials;?></span>
                            </div>
                        </div>
                        <a href="equip-detall.php?id=<?php echo $persona['id'];?>" class="text-body"><?php echo beautyNameTwoWords($persona['nom']);?></a>  
                    </td>
                    <td><?php echo beautyTime($tempsDedicat);?></td>
                    <td class="text-center"><?php echo number_format($assignacio,2,",",".");?> %</td>
                    <td><?php echo number_format($projecteOferta*($assignacio/100),2,",",".");?> €</td>
                </tr>

            <?php }?>
            </tbody>
        </table>
    </div>
</div>