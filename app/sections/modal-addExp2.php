<div id="addExp" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="myModalLabel">Crear</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            
            <form method="post" action="conexiones/administracio.php?action=addExp" >
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-4">
                            Holi
                        </div>
                        <div class="col-lg-4">
                            Hihi
                        </div>
                    </div>
                    <p><a href="ofertes.php"><i class="mdi mdi-plus mr-1"></i> New offer</a></p>
                    <p>Solo se muestran las ofertas aceptadas</p>
                    
                        
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light waves-effect" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary waves-effect waves-light">Crear</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->