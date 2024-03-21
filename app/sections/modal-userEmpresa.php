<div id="userEmpresa" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="myModalLabel"><?php echo $text['Editar mi empresa'];?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="conexiones/administracio.php?action=editEmpresa">
                <input type="hidden" class="form-control" value="<?php echo $userEmpresa;?>" name="empresaId">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label><?php echo $text['Nombre'];?></label>
                                <div class="input-group">
                                    <input type="text" class="form-control" value="<?php echo $empresa['empresaNom'];?>" name="empresaNom">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-8">
                            <div class="form-group">
                                <label><?php echo $text['Dirección'];?></label>
                                <div class="input-group">
                                    <input type="text" class="form-control" value="<?php echo $empresa['empresaDireccio'];?>" name="empresaDireccio">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label><?php echo $text['Código postal'];?></label>
                                <div class="input-group">
                                    <input type="number" class="form-control" value="<?php echo $empresa['empresaCP'];?>" name="empresaCP">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label><?php echo $text['Ciudad'];?></label>
                                <div class="input-group">
                                    <input type="text" class="form-control" value="<?php echo $empresa['empresaCiutat'];?>" name="empresaCiutat">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label><?php echo $text['CIF'];?></label>
                                <div class="input-group">
                                    <input type="text" class="form-control" value="<?php echo $empresa['empresaCIF'];?>" name="empresaCIF">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-5">
                            <div class="form-group">
                                <label><?php echo $text['Teléfono'];?></label>
                                <div class="input-group">
                                    <input type="phone" class="form-control" value="<?php echo $empresa['empresaTelefon'];?>" name="empresaTelefon">
                                </div>
                            </div>
                        </div>
                    </div>

                    <br><br>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label><?php echo $text['Banco'];?></label>
                                <div class="input-group">
                                    <input type="text" class="form-control" value="<?php echo $empresa['empresaBanc'];?>" name="empresaBanc">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>SWIFT</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" value="<?php echo $empresa['empresaSWIFT'];?>" name="empresaSWIFT">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>IBAN</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" value="<?php echo $empresa['empresaIBAN'];?>" name="empresaIBAN">
                                </div>
                            </div>
                        </div>
                    </div>
                    <p><?php echo $text['Los datos bancarios se mostraran en las facturas que se realicen a clientes. Cuantime no utilizará, en ningún caso, estos datos para realizar cobros.'];?>

                    <br><br><br>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label><?php echo $text['Prefijo factura'];?></label>
                                <div class="input-group">
                                    <input type="text" class="form-control" value="<?php echo $empresa['empresaPrefixFactura'];?>" name="empresaPrefixFactura">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label><?php echo $text['Formato factura'];?></label>
                                <?php
                                $optionFormatFactura=["YYxxx.1","YY-xxx.1","YY xxx.1","xxx.1","xxxx.1"];

                                ?>
                                <select class="form-control" name="empresaFormatFactura">
                                    <?php 
                                    $j=$empresa['empresaFormatFactura'];
                                    for ($i=0;$i<5;$i++){
                                        echo '<option value="'.$j.'">'.$optionFormatFactura[$j-1].'</option>';
                                        $j++;
                                        if($j>5){$j=1;}
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