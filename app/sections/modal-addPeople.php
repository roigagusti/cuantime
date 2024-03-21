<div id="addPeople" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="myModalLabel"><?php echo $text['Nueva persona'];?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <?php 
            $usersEmpresa=$database->count("users",["empresa"=>$userEmpresa]);
            if($empresaPlan==0 && $usersEmpresa>1 || $empresaPlan==1 && $usersEmpresa>7 || $empresaPlan==2 && $usersEmpresa>24){
                echo '<div class="modal-body"><div class="row"><div class="col-lg-12"><p>Tu plan actual no permite añadir más usuarios a tu cuenta. Mejora tu cuenta desde <a href="perfil.php">aquí</a></p></div></div>';
            }else{
            ?>
            <form method="post" action="conexiones/rrhh.php?action=addPeople">
                <input type="hidden" class="form-control" value="<?php echo $userEmpresa;?>" name="empresaId">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label><?php echo $text['Nombre'];?></label>
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Monica Hall" name="name">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label><?php echo $text['Email'];?></label>
                                <div class="input-group">
                                    <input type="email" class="form-control" placeholder="monica@hooli.com" name="email">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label><?php echo $text['Permisos'];?></label>
                                <select class="form-control" name="permissos">
                                    <option value="1"><?php echo $text['Acceso completo'];?></option>
                                    <option value="2"><?php echo $text['Acceso básico'];?></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label><?php echo $text['Colaborador'];?></label>
                                <select class="form-control" name="tipusColaborador">
                                    <option value="0"><?php echo $text['Trabajador'];?></option>
                                    <option value="1"><?php echo $text['Autónomo'];?></option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <br>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label><?php echo $text['Sueldo anual'];?></label>
                                <div class="input-group">
                                    <input type="number" step="any" class="form-control" placeholder="6000" name="sou">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label><?php echo $text['Horas semanales'];?></label>
                                <div class="input-group">
                                    <input type="number" step="any" class="form-control" placeholder="20" name="horari">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label><?php echo $text['Precio por hora'];?></label>
                                <div class="input-group">
                                    <input type="number" step="any" class="form-control" placeholder="40" name="preu">
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
        <?php } ?>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->