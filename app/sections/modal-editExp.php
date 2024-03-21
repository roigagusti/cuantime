<div id="editExp" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="myModalLabel"><?php echo $text['Editar expediente'];?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="conexiones/administracio.php?action=editExp" >
                <input type="hidden" name="expId" value="<?php echo $_GET['id'];?>">
                <div class="modal-body">
                    <?php 
                    if($projecteExp!='PH'){
                    ?>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label><?php echo $text['Número de expediente'];?></label>
                                <div class="input-group">
                                    <input type="number" step="any" class="form-control" name="expNum" value="<?php echo $projecteExp;?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label><?php echo $text['Asignación económica'];?></label>
                                <div class="input-group">
                                    <input type="number" step="any" class="form-control" name="assignacio" value="<?php echo $assignacioEncarregat;?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <p><?php echo $text['El resto de datos del expediente pueden modificarse desde la Oferta'];?>.</p>
                        
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light waves-effect" data-dismiss="modal"><?php echo $text['Cancelar'];?></button>
                    <button type="submit" class="btn btn-primary waves-effect waves-light"><?php echo $text['Guardar'];?></button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->