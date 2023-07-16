<div id="addDespesa" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="myModalLabel">Añadir gasto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="conexiones/administracio.php?action=addDespesa" >
                <input type="hidden" class="form-control" value="<?php echo $userAdminEmpresa;?>" name="userId">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-5">
                            <div class="form-group">
                                <label>Fecha gasto</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" data-provide="datepicker" data-date-format="yyyy/mm/dd" data-date-autoclose="true" value="<?php echo date('Y-m-d');?>" name="despesaData">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-7">
                            <div class="form-group">
                                <label class="control-label">Repercusión a</label>
                                <select class="form-control" name="idProjecte" required>
                                    <option>General</option>
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
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Concepto</label>
                                <input type="text" class="form-control" name="despesaConcepte">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-10">
                            <div class="form-group">
                                <label>Proveedor</label>
                                <input type="text" class="form-control" name="despesaProveidor">
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-group">
                                <label>Importe</label>
                                <input type="text" onchange="calculPreu()" class="form-control facturaValors" name="despesaImport" id="facturaImport" required>
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
                        <div class="col-lg offset-6 col-lg-3 text-right">- 0.00% IRPF</div>
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

                    <p class="impMod" onclick="showImpost()" style="cursor:pointer;color:#34c38f;">Modificar impuestos</p>
                    <p class="impAma hidden" onclick="showImpost()" style="cursor:pointer;color:#34c38f;">Esconder impuestos</p>
                    <div class="impAma hidden">
                        <div class="row">
                            <div class="col-lg-6">Porcentaje de IVA</div>
                            <div class="col-lg-6">
                                <input type="text" onchange="calculPreu()" class="form-control text-right" name="despesaIVA" id="facturaIVA" value="21">
                            </div>
                        </div>
                        <div class="row" style="margin-top:5px;margin-bottom: 10px">
                            <div class="col-lg-6">Porcentaje de IRPF</div>
                            <div class="col-lg-6">
                                <input type="text" onchange="calculPreu()" class="form-control text-right" name="despesaIRPF" id="facturaIRPF" value="0">
                            </div>
                        </div>
                    </div>

                    <div class="custom-control custom-switch mb-3" dir="ltr">
                        <input type="checkbox" class="custom-control-input" id="customSwitch1" name="checkHoraFinal">
                        <label class="custom-control-label" for="customSwitch1">Añadir datos de facturación</label>
                    </div>

                    <div class="hidden" id="horaFinal">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Nombre</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Richard Hendricks" name="despesaNom">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-8">
                                <div class="form-group">
                                    <label>Dirección</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Hacker Way 1" name="despesaDireccio">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Código postal</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" placeholder="94025" name="despesaCP">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Ciudad</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Menlo Park" name="despesaCiutat">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label>CIF</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="48650373Z" name="despesaCIF">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-5">
                                <div class="form-group">
                                    <label>Teléfono</label>
                                    <div class="input-group">
                                        <input type="phone" class="form-control" placeholder="+34654131563" name="despesaTelefon">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Email</label>
                                    <div class="input-group">
                                        <input type="email" class="form-control" placeholder="richard@piedpiper.com" name="despesaEmail">
                                    </div>
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