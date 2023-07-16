<div id="removeConfirm" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="myModalLabel">Confirmar borrado</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="conexiones/rrhh.php?action=removeUser&id=<?php echo $_GET['id'];?>" >
                <div class="modal-body">
                    <p>¿Estás seguro que quieres borrar este usuario?</a></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light waves-effect" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger waves-effect waves-light">Borrar</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->