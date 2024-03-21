<div id="addParte" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="myModalLabel"><?php echo $text['Añadir dedicación'];?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="conexiones/rrhh.php?action=addParte">
                <input type="hidden" class="form-control" value="<?php echo $userId;?>" name="userId">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label><?php echo $text['Dedicación'];?> (%)</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" value="100" name="partePercentatge">
                                    <input type="hidden" value="0" name="parteData" id="parteData">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="form-group">
                                <label class="control-label"><?php echo $text['Proyecto'];?></label>
                                <select class="form-control" name="idProjecte" required>
                                    <option><?php echo $text['Seleccionar proyecto'];?></option>
                                    <?php 
                                    $projectes = $database->select("projectes", [
                                        "id",
                                        "nom",
                                        "exp",
                                        "idUser"
                                        ],["idUser"=>$userAdminEmpresa,"ORDER"=>["exp"=>"DESC"]]);
                                    foreach ($projectes as $projecte) {
                                        if($projecte['exp']>0){
                                            echo '<option value="'.$projecte['id'].'">'.$projecte['exp'].' - '.$projecte['nom'].'</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                            <label><?php echo $text['Comentario'];?></label>
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="exp. 1042" name="parteComment">
                            </div>
                        </div>
                        </div>
                    </div>
                        
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light waves-effect" data-dismiss="modal"><?php echo $text['Cancelar'];?></button>
                    <button type="submit" class="btn btn-primary waves-effect waves-light"><?php echo $text['Añadir'];?></button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->