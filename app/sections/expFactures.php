<div class="tab-pane" id="factures">
    <div class="table-responsive">
        <table class="table table-nowrap table-hover mb-0">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Número</th>
                    <th scope="col">Estado</th>
                    <th scope="col">Importe</th>
                    <th scope="col">Fecha</th>
                </tr>
            </thead>
            <tbody>
                <?php
                 $factures = $database->select("factures", [
                    "id",
                    "numero",
                    "idProjecte",
                    "data",
                    "import",
                    "estat"
                    ],["idProjecte"=>$_GET['id']]);
                $i=0;
                foreach($factures as $factura){
                    $i++;
                    $estat = ["Pendiente","Pagado"];
                    $badge = ["warning","success"];
                    $estatFactura = $factura['estat']-1;
                ?>
                <tr>
                    <th scope="row"><?php echo $i;?></th>
                    <td><?php echo 'F_'.beautyExp($factura['numero']);?></td>
                    <td>
                        <span class="badge badge-soft-<?php echo $badge[$estatFactura];?> font-size-12"><?php echo $estat[$estatFactura];?></span>
                    </td>                                                                
                    <td><?php echo number_format($factura['import'],2,",",".");?> €</td>
                    <td><?php echo date('d.m.Y',strtotime($factura['data']));?></td>
                </tr>
                <?php }?>
            </tbody>
        </table>
    </div>
</div>