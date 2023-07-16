<div id="addClient" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="myModalLabel">Nuevo cliente</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="conexiones/administracio.php?action=addClient">
                <input type="hidden" class="form-control" value="<?php echo $userEmpresa;?>" name="userId">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Nombre</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Richard Hendricks" name="clientNom">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Empresa</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Pied Piper" name="clientEmpresa">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-8">
                            <div class="form-group">
                                <label>Dirección</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Hacker Way 1" name="clientDireccio">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Codigo postal</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" placeholder="94025" name="clientCP">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Ciudad</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Menlo Park" name="clientCiutat">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label>CIF</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="48650373Z" name="clientCIF">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-5">
                            <div class="form-group">
                                <label>Teléfono</label>
                                <div class="input-group">
                                    <input type="phone" class="form-control" placeholder="+34654131563" name="clientPhone">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Email</label>
                                <div class="input-group">
                                    <input type="email" class="form-control" placeholder="richard@piedpiper.com" name="clientEmail">
                                </div>
                            </div>
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