<div id="addExp" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="myModalLabel">Crear expediente</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <?php 
            $expOrfes = $database->select("projectes", ["id","exp","idUser"],["AND"=>["idUser"=>$userAdminEmpresa,"exp"=>0]]);
            $expSuscep = 0;
            foreach($expOrfes as $expOrfe){
                $ofertaEstat = $database->get("ofertes","estat",["idProjecte"=>$expOrfe['id']]);
                if($ofertaEstat>3){$expSuscep++;}
            }
            if($expSuscep==0){echo '<div class="modal-body"><div class="row"><div class="col-lg-12"><p>No hay ninguna oferta aceptada.</p></div></div>';}else{
            ?>
            <form method="post" action="conexiones/administracio.php?action=addExp" >
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Número expedient</label>
                                <?php 
                                    $lastExp = $database->max("projectes","exp",["idUser"=>$userAdminEmpresa]);
                                    $numeroExp = $lastExp+1;
                                ?>
                                <div class="input-group">
                                    <input type="text" class="form-control disabled" value="<?php echo $numeroExp;?>" name="numeroExp" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label class="control-label">Estado inicial</label>
                                <select class="form-control" name="estatExp">
                                    <option value="2">En proceso</option>
                                    <option value="1">Pausa</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="control-label">Oferta</label>
                                <select class="form-control" name="expId">
                                    <option>Seleccionar oferta aceptada</option>
                                    <?php
                                    $senseExpedient = $database->select("projectes", [
                                        "id",
                                        "exp",
                                        "nom",
                                        "estat",
                                        "created_date",
                                        "idUser"
                                        ],[ "AND"=>["idUser"=>$userAdminEmpresa,"exp"=>0],
                                            "ORDER"=>["created_date"=>"DESC"]
                                        ]);
                                    foreach ($senseExpedient as $exp) {
                                        $ofertaEstat = $database->get("ofertes","estat",["idProjecte"=>$exp['id']]);
                                        if($ofertaEstat==4){
                                            $ofertaNumero = $database->get("ofertes","numero",["idProjecte"=>$exp['id']]);
                                            echo '<option value="'.$exp['id'].'">'.$ofertaNumero.' - '.$exp['nom'].'</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <p><a href="ofertes.php"><i class="mdi mdi-plus mr-1"></i> Nueva oferta</a></p>
                    <p>Solo se muestran las ofertas aceptadas</a></p>
                    
                        
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light waves-effect" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary waves-effect waves-light">Crear</button>
                </div>
            </form>
            <?php }?>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->