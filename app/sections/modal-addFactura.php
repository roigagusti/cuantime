<div id="addFactura" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="myModalLabel"><?php echo $text['Crear factura']?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="conexiones/administracio.php?action=addFactura" >
                <input type="hidden" class="form-control" value="<?php echo $userAdminEmpresa;?>" name="userId">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label><?php echo $text['Número de factura']?></label>
                                <div class="input-group">
                                    <?php 
                                    $numeroLastFactura = $database->max("factures","numero",["idUser"=>$userAdminEmpresa]);
                                    $numeroFactura = $numeroLastFactura+1;
                                    ?>
                                    <input type="text" class="form-control disabled" style="color:#999" value="<?php echo $numeroFactura;?>" name="numeroFactura" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="form-group">
                                <label class="control-label"><?php echo $text['Proyecto']?></label>
                                <select class="form-control" name="idProjecte" required>
                                    <option><?php echo $text['Seleccionar proyecto']?></option>
                                    <?php 
                                    $projectes = $database->select("projectes", [
                                        "id",
                                        "nom",
                                        "exp",
                                        "idUser"
                                        ],["idUser"=>$userAdminEmpresa,"ORDER"=>["exp"=>"DESC"]]);
                                    foreach ($projectes as $projecte) {
                                        echo '<option value="'.$projecte['id'].'">'.$projecte['exp'].' - '.$projecte['nom'].'</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <style>
                    .facturaValors{
                        text-align: right;
                    }
                    </style>
                    <div class="row">
                        <div class="col-lg-10">
                            <div class="form-group">
                                <label><?php echo $text['Concepto']?></label>
                                <input type="text" class="form-control" name="facturaConcepte">
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-group">
                                <label><?php echo $text['Importe']?></label>
                                <input type="text" onchange="calculPreu()" class="form-control facturaValors" step="any" name="facturaImport" id="facturaImport" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg offset-6 col-lg-3 text-right">+ 21.00% IVA</div>
                        <div class="col-lg-3">
                            <div id="valorIVA" class="text-right">0.00 €</div>
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-lg offset-6 col-lg-3 text-right">- 15.00% IRPF</div>
                        <div class="col-lg-3">
                            <div id="valorIRPF" class="text-right">0.00 €</div>
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-lg offset-6 col-lg-3 text-right">
                            <strong>TOTAL</strong>
                        </div>
                        <div class="col-lg-3">
                            <div id="valorTOTAL" class="text-right" style="font-weight: bold;">0.00 €</div>
                        </div>
                    </div>

                    <p class="impMod" onclick="showImpost()" style="cursor:pointer;color:#34c38f;"><?php echo $text['Modificar impuestos']?></p>
                    <p class="impAma hidden" onclick="showImpost()" style="cursor:pointer;color:#34c38f;"><?php echo $text['Esconder impuestos']?></p>
                    <div class="impAma hidden">
                        <div class="row">
                            <div class="col-lg-6"><?php echo $text['Porcentaje de'];?> IVA</div>
                            <div class="col-lg-6">
                                <input type="text" onchange="calculPreu()" class="form-control text-right" name="facturaIVA" id="facturaIVA" value="21">
                            </div>
                        </div>
                        <div class="row" style="margin-top:5px;margin-bottom: 10px">
                            <div class="col-lg-6"><?php echo $text['Porcentaje de'];?> IRPF</div>
                            <div class="col-lg-6">
                                <input type="text" onchange="calculPreu()" class="form-control text-right" name="facturaIRPF" id="facturaIRPF" value="15">
                            </div>
                        </div>
                    </div>

                    <div class="custom-control custom-switch mb-3" dir="ltr">
                        <input type="checkbox" class="custom-control-input" id="customSwitch1" name="checkHoraFinal">
                        <label class="custom-control-label" for="customSwitch1"><?php echo $text['Añadir datos de facturación'];?></label>
                    </div>

                    <div class="hidden" id="horaFinal">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label><?php echo $text['Nombre'];?></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Richard Hendricks" name="facturaNom">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-8">
                                <div class="form-group">
                                    <label><?php echo $text['Dirección'];?></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Hacker Way 1" name="facturaDireccio">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label><?php echo $text['Código postal'];?></label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" placeholder="94025" name="facturaCP">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label><?php echo $text['Ciudad'];?></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Menlo Park" name="facturaCiutat">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label><?php echo $text['CIF'];?></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="48650373Z" name="facturaCIF">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-5">
                                <div class="form-group">
                                    <label><?php echo $text['Teléfono'];?></label>
                                    <div class="input-group">
                                        <input type="phone" class="form-control" placeholder="+34654131563" name="facturaTelefon">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label><?php echo $text['Email'];?></label>
                                    <div class="input-group">
                                        <input type="email" class="form-control" placeholder="richard@piedpiper.com" name="facturaEmail">
                                    </div>
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
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->