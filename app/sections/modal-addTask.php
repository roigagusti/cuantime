<div id="addTask" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="myModalLabel">Añadir tarea</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="conexiones/administracio.php?action=addTask">
                <input type="hidden" class="form-control" value="<?php echo $userId;?>" name="userId">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="form-group">
                                <label class="control-label">Proyecto</label>
                                <select class="form-control" name="proyecto" required>
                                    <?php if($pagina=='expedient-detall'){
                                        echo '<option value="'.$_GET['id'].'">'.$projecteExp.'. '.$projecteNom.'</option>';
                                    }else{
                                        echo '<option>Seleccionar proyecto</option>';
                                        $projectes = $database->select("projectes", [
                                            "id",
                                            "exp",
                                            "idClient",
                                            "nom",
                                            "idUserEncarregat",
                                            "estat"
                                            ],["AND"=>["idUserEncarregat"=>$userId,"exp[>]"=>0,"estat[>]"=>2,"estat[<]"=>5],"ORDER"=>["exp"=>"DESC"]]);
                                        foreach ($projectes as $projecte) {
                                            echo '<option value="'.$projecte['id'].'">'.$projecte['exp'].'. '.$projecte['nom'].'</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Prioridad</label>
                                <select class="form-control" name="prioridad">
                                    <option value="0">Sin prisa</option>
                                    <option value="1">Tener en cuenta</option>
                                    <option value="2">Manos a la obra</option>
                                    <option value="3">Urgente</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Título de tarea</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" value="" name="titulo">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Descripción</label>
                                <div class="input-group">
                                    <textarea type="text" class="form-control" name="descripcion"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                        
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light waves-effect" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary waves-effect waves-light">Añadir</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->