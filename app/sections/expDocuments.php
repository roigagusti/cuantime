<div class="tab-pane" id="docs">
    <div class="table-responsive">
        <table class="table table-nowrap table-hover mb-0">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Usuario</th>
                    <th scope="col">Título</th>
                    <th scope="col">Nombre de archivo</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                <?php
                 $arxius = $database->select("arxius", [
                    "id",
                    "titol",
                    "url",
                    "idProjecte",
                    "idUser",
                    "fileType"
                    ],["idProjecte"=>$_GET['id']]);
                $i=0;
                foreach($arxius as $arxiu){
                    $i++;
                    if($arxiu['titol']==''){
                        $titolArxiu='-';
                    }else{
                        $titolArxiu=$arxiu['titol'];
                    }
                    $userArxiu=$database->get("users","nom",['id'=>$arxiu['idUser']]);
                ?>
                <tr>
                    <th scope="row"><?php echo $i;?></th>                               
                    <td><?php echo beautyNameTwoWords($userArxiu);?></td>
                    <td><?php echo $titolArxiu;?></td>
                    <td><?php echo $arxiu['url'];?></td>
                    <td><?php echo '<a href="img/missatges/'.$arxiu['url'].'" target="_blank" class="btn btn-light btn-sm w-xs">'.$arxiu['fileType'].' <i class="uil uil-download-alt ml-2"></i></a>';?></td>
                </tr>
                <?php }?>
            </tbody>
        </table>
    </div>
</div>