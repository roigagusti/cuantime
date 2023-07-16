<div class="tab-pane" id="ofertes">
    <div class="table-responsive">
        <table class="table table-nowrap table-hover mb-0">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Número</th>
                    <th scope="col">Estado</th>
                    <th scope="col">Honorarios</th>
                    <th scope="col">Fecha</th>
                </tr>
            </thead>
            <tbody>
                <?php
                 $ofertes = $database->select("ofertes", [
                    "id",
                    "numero",
                    "idProjecte",
                    "data",
                    "preu",
                    "estat"
                    ],["idProjecte"=>$_GET['id']]);
                $i=0;
                foreach($ofertes as $oferta){
                    $i++;
                    $estat = ["Pendiente de honorarios","Espera de respuesta","No aceptado", "Aceptado","Facturado"];
                    $badge = ["danger","warning","secondary","info","success"];
                    $estatOferta = $oferta['estat']-1;
                ?>
                <tr>
                    <th scope="row"><?php echo $i;?></th>
                    <td><?php echo 'PH_'.beautyExp($oferta['numero']);?></td>
                    <td>
                        <span class="badge badge-soft-<?php echo $badge[$estatOferta];?> font-size-12"><?php echo $estat[$estatOferta];?></span>
                    </td>                                                                
                    <td><?php echo number_format($oferta['preu'],2,",",".");?> €</td>
                    <td><?php echo date('d.m.Y',strtotime($oferta['data']));?></td>
                </tr>
                <?php }?>
            </tbody>
        </table>
    </div>
</div>