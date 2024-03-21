<div id="editClient" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="myModalLabel"><?php echo $text['Editar cliente'];?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="conexiones/administracio.php?action=editClient" >
                <input type="hidden" name="clientId" value="<?php echo $_GET['id'];?>">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label><?php echo $text['Nombre'];?></label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="clientNom" value="<?php echo $clientNom;?>">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label><?php echo $text['Empresa'];?></label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="clientEmpresa" value="<?php echo $clientEmpresa;?>">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-8">
                            <div class="form-group">
                                <label><?php echo $text['Dirección'];?></label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="clientDireccio" value="<?php echo $clientDireccio;?>">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label><?php echo $text['Código postal'];?></label>
                                <div class="input-group">
                                    <input type="number" class="form-control" name="clientCP" value="<?php echo $clientCP;?>">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label><?php echo $text['Ciudad'];?></label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="clientCiutat" value="<?php echo $clientCiutat;?>">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label><?php echo $text['CIF'];?></label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="clientCIF" value="<?php echo $clientCIF;?>">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-5">
                            <div class="form-group">
                                <label><?php echo $text['Teléfono'];?></label>
                                <div class="input-group">
                                    <input type="phone" class="form-control" name="clientPhone" value="<?php echo $clientTelefon;?>">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label><?php echo $text['Email'];?></label>
                                <div class="input-group">
                                    <input type="email" class="form-control" name="clientEmail" value="<?php echo $clientMail;?>">
                                </div>
                            </div>
                        </div>
                    </div>
                        
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light waves-effect" data-dismiss="modal"><?php echo $text['Cancelar'];?></button>
                    <button type="submit" class="btn btn-primary waves-effect waves-light"><?php echo $text['Guardar'];?></button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->