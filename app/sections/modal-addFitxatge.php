<style>
.control-me::after{
    display: none;
}
#customSwitch1:checked ~ .control-me::after{
    display:initial;
}
</style>

<div id="addFitxatge" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="myModalLabel">Crear fichaje</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form method="post" action="conexiones/rrhh.php?action=manualFitxar">
                <input type="hidden" class="form-control" value="<?php echo $userId;?>" name="userId">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="form-group">
                                <label>Fecha de inicio</label>
                                <div class="input-group">
                                    <?php 
                                    if($_SERVER["PHP_SELF"]=="/fitxatges-editar.php"){
                                        $iniciDataValue = date('Y-m-d',strtotime($_GET['dia']));
                                    }else{
                                        $iniciDataValue = date('Y-m-d');
                                    }
                                    ?>
                                    <input type="text" class="form-control" data-provide="datepicker" data-date-format="yyyy/mm/dd" data-date-autoclose="true" value="<?php echo $iniciDataValue;?>" name="iniciData">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Hora de inicio</label>
                                <div class="input-group">
                                    <input type="time" class="form-control" data-date-format="hh:mm" data-date-autoclose="true" id="example-time-input" value="00:00" name="iniciHora">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="custom-control custom-switch mb-3" dir="ltr">
                        <input type="checkbox" class="custom-control-input" id="customSwitch1" name="checkHoraFinal">
                        <label class="custom-control-label" for="customSwitch1">Añadir hora de finalización</label>
                    </div>

                    <div class="row hidden" id="horaFinal">
                        <div class="col-lg-8">
                            <div class="form-group">
                                <label>Fecha de finalización</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" data-provide="datepicker" data-date-format="yyyy/mm/dd" data-date-autoclose="true" value="<?php echo $iniciDataValue;?>" name="finalData">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Hora de finalización</label>
                                <div class="input-group">
                                    <input type="time" class="form-control" data-date-format="hh:mm" data-date-autoclose="true" id="example-time-input" value="23:59" name="finalHora">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Comentario</label>
                        <div>
                            <textarea class="form-control" rows="5" name="comentari"></textarea>
                        </div>
                    </div>

                        
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light waves-effect" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary waves-effect waves-light">Crear</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->