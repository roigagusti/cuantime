<div id="addOferta" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="myModalLabel"><?php echo $text['Nueva oferta'];?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="conexiones/administracio.php?action=addOferta">
                <input type="hidden" class="form-control" value="<?php echo $userAdminEmpresa;?>" name="userId">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label><?php echo $text['Número propuesta'];?></label>
                                <div class="input-group">
                                    <?php
                                    $numeroLastOferta = $database->max("ofertes","numero",["idUser"=>$userAdminEmpresa]);
                                    $numeroOferta = $numeroLastOferta+1;
                                    ?>
                                    <input type="text" class="form-control disabled" style="color:#999" value="PH_<?php echo $numeroOferta;?>" name="numeroProjecte" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="form-group" id="clientManual">
                                <label class="control-label"><?php echo $text['Cliente'];?></label>
                                <select class="form-control" name="client">
                                    <option><?php echo $text['Seleccionar cliente'];?></option>
                                    <?php 
                                    $clients = $database->select("clients", [
                                        "id",
                                        "nom",
                                        "idUser"
                                        ],["idUser"=>$userEmpresa,"ORDER"=>["nom"=>"ASC"]]);
                                    foreach ($clients as $client) {
                                        echo '<option value="'.$client['id'].'">'.$client['nom'].'</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <p id="crearClientManual"><a href="clients.php"><i class="mdi mdi-plus mr-1"></i> <?php echo $text['Crear cliente'];?></a></p>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label><?php echo $text['Nombre de proyecto'];?></label>
                                <div class="input-group" id="projecteManual">
                                    <input type="text" class="form-control" name="nomProjecte">
                                </div>

                                <select class="form-control hidden" name="projecteSelect" id="projecteSelect">
                                    <option value="x"><?php echo $text['Seleccionar proyecto'];?></option>
                                    <?php 
                                    $projectes = $database->select("projectes",["id","exp","nom","idUser"],["AND"=>["idUser"=>$userAdminEmpresa,"exp[>]"=>0],"ORDER"=>['exp'=>'DESC']]);
                                    foreach ($projectes as $projecte) {
                                        echo '<option value="'.$projecte['id'].'">'.$projecte['exp'].'. '.$projecte['nom'].'</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="custom-control custom-switch mb-3" dir="ltr">
                                <input type="checkbox" class="custom-control-input" id="customSwitch1">
                                <label class="custom-control-label" for="customSwitch1"><?php echo $text['Vincular a proyecto existente'];?></label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-8">
                            <div class="form-group" id="ciutatManual">
                                <label><?php echo $text['Ciudad'];?></label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="ciutatProjecte">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label><?php echo $text['Precio'];?></label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="preuProjecte">
                                </div>
                            </div>
                        </div>
                    </div>
                        
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light waves-effect" data-dismiss="modal"><?php echo $text['Cancelar'];?></button>
                    <button type="submit" class="btn btn-primary waves-effect waves-light"><?php echo $text['Crear'];?></button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->