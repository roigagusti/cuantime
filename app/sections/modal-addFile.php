<div id="addClient" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="myModalLabel">Añadir archivo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="conexiones/missatges.php?action=addFile" enctype="multipart/form-data">
                <input type="hidden" class="form-control" value="<?php echo $userId;?>" name="userId">
                <input type="hidden" class="form-control" value="<?php echo $_GET['id'];?>" name="idProjecte">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Título de archivo</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="fileTitle">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Archivo</label>
                                <div class="input-group">
                                    <input type="file" name="addFile" id="addFile" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="control-label">Mensaje</label>
                                <textarea rows="3" class="form-control resize-none" name="missatge" placeholder="Escribir mensaje..."></textarea>
                            </div>
                        </div>
                    </div>                    
                        
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light waves-effect" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary waves-effect waves-light">Enviar</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->