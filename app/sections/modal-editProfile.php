<div id="editProfile" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="myModalLabel"><?php echo $text['Editar perfil'];?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="conexiones/rrhh.php?action=editProfile" >
                <input type="hidden" name="userId" value="<?php echo $userId;?>">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label><?php echo $text['Nombre'];?></label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="userNom" value="<?php echo $userName;?>">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label><?php echo $text['Email'];?></label>
                                <div class="input-group">
                                    <input type="email" class="form-control" name="userEmail" value="<?php echo $userEmail;?>" disabled>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label><?php echo $text['Contraseña'];?></label>
                                <div class="input-group">
                                    <input type="password" class="form-control" name="userPass" placeholder="******">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label><?php echo $text['Confirmar contraseña'];?></label>
                                <div class="input-group">
                                    <input type="password" class="form-control" name="userPass2" placeholder="******">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label><?php echo $text['Idioma'];?></label>
                                <select class="form-control" name="userIdioma">
                                    <?php if($langUsuari=="español"){
                                        echo '<option value="español">Español</option>';
                                        echo '<option value="català">Català</option>';
                                        echo '<option value="english">English</option>';
                                        echo '<option value="français">Français</option>';
                                    }elseif($langUsuari=="català"){
                                        echo '<option value="català">Català</option>';
                                        echo '<option value="español">Español</option>';
                                        echo '<option value="english">English</option>';
                                        echo '<option value="français">Français</option>';
                                    }elseif($langUsuari=="français"){
                                        echo '<option value="français">Français</option>';
                                        echo '<option value="català">Català</option>';
                                        echo '<option value="español">Español</option>';
                                        echo '<option value="english">English</option>';
                                    }else{
                                        echo '<option value="english">English</option>';
                                        echo '<option value="català">Català</option>';
                                        echo '<option value="español">Español</option>';
                                        echo '<option value="français">Français</option>';
                                    }
                                    ?>
                                </select>
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