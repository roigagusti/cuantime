<div id="removeConfirm" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="myModalLabel"><?php echo $text['Confirmar borrado'];?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="conexiones/administracio.php?action=removeClient&id=<?php echo $_GET['id'];?>" >
                <div class="modal-body">
                    <p><?php echo $text['¿Estás seguro que quieres borrar este cliente?'];?></a></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light waves-effect" data-dismiss="modal"><?php echo $text['Cancelar'];?></button>
                    <button type="submit" class="btn btn-danger waves-effect waves-light"><?php echo $text['Borrar'];?></button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->