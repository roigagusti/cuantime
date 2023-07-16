<div class="tab-pane" id="missatges" role="tabpanel">
    <div>
        <div data-simplebar="init" style="max-height: 430px;"><div class="simplebar-wrapper" style="margin: 0px;"><div class="simplebar-height-auto-observer-wrapper"><div class="simplebar-height-auto-observer"></div></div><div class="simplebar-mask"><div class="simplebar-offset" style="right: -17px; bottom: 0px;"><div class="simplebar-content-wrapper" style="height: auto; overflow: hidden scroll;"><div class="simplebar-content" style="padding: 0px;">
            <?php
            $missatges=$database->select("missatges",[
                "id",
                "idProjecte",
                "idUser",
                "missatge",
                "idFile",
                "created_date"
            ],["idProjecte"=>$_GET['id'],"ORDER"=>["created_date"=>"DESC"]]);
            if(count($missatges)==0){echo '<span class="p-4 text-center">No hay mensajes</span>';}
            foreach ($missatges as $missatge){
                $missatgeNomUser=$database->get("users","nom",["id"=>$missatge['idUser']]);
            ?>
                <div class="media border-bottom py-4">
                    <div class="avatar-xs d-inline-block mr-2">
                        <div class="avatar-title bg-soft-primary rounded-circle text-primary">
                            <span style="font-size:0.9em;"><?php echo inicials($missatgeNomUser);?></span>
                        </div>
                    </div>
                    <div class="media-body">
                        <h5 class="font-size-15 mt-0 mb-1"><?php echo beautyNameTwoWords($missatgeNomUser);?> <small class="text-muted float-right"><?php echo dateDistance($missatge['created_date']);?></small></h5>
                        <p class="text-muted"><?php echo nl2br($missatge['missatge']);?></p>
                        <?php 
                        if(isset($missatge['idFile'])){
                            $typeFile = $database->get("arxius","fileType",["id"=>$missatge['idFile']]);
                            $urlFile = $database->get("arxius","url",["id"=>$missatge['idFile']]);
                            if($typeFile!="pdf"){
                                echo '<a href="img/missatges/'.$urlFile.'" target="_blank" class="btn btn-light btn-sm w-xs"><img src="img/missatges/'.$urlFile.'" class="rounded" style="height:100px"></a>';
                            }else{
                                echo '<a href="img/missatges/'.$urlFile.'" target="_blank" class="btn btn-light btn-sm w-xs">Pdf <i class="uil uil-download-alt ml-2"></i></a>';
                            }
                        }
                        ?>                                                                
                    </div>
                </div>
            <?php } ?>
        </div></div></div></div><div class="simplebar-placeholder" style="width: auto; height: 491px;"></div></div><div class="simplebar-track simplebar-horizontal" style="visibility: hidden;"><div class="simplebar-scrollbar" style="transform: translate3d(0px, 0px, 0px); display: none;"></div></div><div class="simplebar-track simplebar-vertical" style="visibility: visible;"><div class="simplebar-scrollbar" style="transform: translate3d(0px, 0px, 0px); display: block; height: 376px;"></div></div></div>

        <div class="border rounded mt-4">
            <form action="conexiones/missatges.php?action=addMessage" method="post" enctype="multipart/form-data" >
                <div class="px-2 py-1 bg-light">
                    <input type="hidden" class="form-control" value="<?php echo $userId;?>" name="userId">
                    <input type="hidden" class="form-control" value="<?php echo $_GET['id'];?>" name="idProjecte">
                    
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-sm btn-link text-dark text-decoration-none" data-toggle="modal" data-target="#addClient"><i class="uil uil-link"></i></button>
                      </div>
                    
                </div>
                <input type="file" class="hidden" name="addFile" id="addFile" max-size="5000">
                <textarea rows="3" class="form-control border-0 resize-none" name="missatge" placeholder="Escribir mensaje..."></textarea>
                <button type="submit" class="btn btn-success waves-effect waves-light mr-1">Enviar</button>
            </form>
        </div> <!-- end .border-->
    </div>
</div>