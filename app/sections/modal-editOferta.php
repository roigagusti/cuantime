<?php
include_once("../conexiones/conexion.php");
session_start();
include_once("sessionStart.php");
$ofertes = $database->select("ofertes", [
    "id",
    "idProjecte",
    "numero",
    "data",
    "preu",
    "estat"
],["id"=>$_GET['id']]); 
foreach($ofertes as $oferta){
    $clientId=$database->get("projectes","idClient",["id"=>$oferta['idProjecte']]);
    $clientNom=$database->get("clients","nom",["id"=>$clientId]);
    $projecteNom=$database->get("projectes","nom",["id"=>$oferta['idProjecte']]);
    $projecteCiutat=$database->get("projectes","ciutat",["id"=>$oferta['idProjecte']]);
?>

            
            <form method="post" action="conexiones/administracio.php?action=editOferta" >
                <input type="hidden" value="<?php echo $oferta['id'];?>" name="ofertaId">
                <input type="hidden" value="<?php echo $oferta['idProjecte']?>" name="projecteId">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="form-group">
                                <label class="control-label"><?php echo $text['Cliente'];?></label>
                                <select class="form-control" name="client">
                                    <?php
                                    echo '<option value="'.$clientId.'">'.$clientNom.'</option>';
                                    
                                    $numeroLastOferta = $database->max("ofertes","numero");
                                    $numeroOferta = $numeroLastOferta+1;
                                    $clients = $database->select("clients", [
                                        "id",
                                        "nom",
                                        "idUser"
                                        ],["idUser"=>$userEmpresa,"ORDER"=>["id"=>"DESC"]]);
                                    foreach ($clients as $client) {
                                        echo '<option value="'.$client['id'].'">'.$client['nom'].'</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <p><a href="clients.php"><i class="mdi mdi-plus mr-1"></i> <?php echo $text['Crear cliente'];?></a></p>

                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label><?php echo $text['Número propuesta'];?></label>
                                <div class="input-group">
                                    <input type="text" class="form-control" value="<?php echo $oferta['numero'];?>" name="numeroProposta">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="form-group">
                                <label><?php echo $text['Nombre de proyecto'];?></label>
                                <div class="input-group">
                                    <input type="text" class="form-control" value="<?php echo $projecteNom;?>"  name="nomProjecte">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-8">
                            <div class="form-group">
                                <label><?php echo $text['Ciudad'];?></label>
                                <div class="input-group">
                                    <input type="text" class="form-control" value="<?php echo $projecteCiutat;?>"   name="ciutatProjecte">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label><?php echo $text['Precio'];?></label>
                                <div class="input-group">
                                    <input type="text" class="form-control" value="<?php echo $oferta['preu'];?>" name="preuProjecte">
                                </div>
                            </div>
                        </div>
                    </div>
                        
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary waves-effect waves-light"><?php echo $text['Guardar'];?></button>
                </div>
            </form>
            <form method="POST" action="conexiones/administracio.php?action=removeOferta">
                <input type="hidden" value="<?php echo $oferta['id'];?>" name="ofertaId">
                <div class="modal-body" style="padding-top:0;">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="control-label"><?php echo $text['Borrar'];?></label>
                                <p><?php echo $text['Escribe "BORRAR" para confirmar'];?></p>
                                <input type="text" class="form-control" name="deleteProjecte">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light waves-effect" data-dismiss="modal"><?php echo $text['Cancelar'];?></button>
                    <button type="submit" class="btn btn-danger waves-effect waves-light"><?php echo $text['Borrar'];?></button>
                </div>
            </form>
<?php } ?>