<div class="modal fade" id="RegistrarEstadoUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">   <strong> <center>Nuevo Estado Usuario</center> </strong>   </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
          <div class="form-group">
            <label for="descripcion_estadoU" class="col-form-label">Estado Usuario:</label>
            <textarea class="form-control" placeholder="Ingrese el nuevo estado" id="descripcion_estadoU"  style="text-transform:uppercase;" onblur="CambiarMayuscula(this);"onkeypress="return soloLetras(event)" onkeyup="espacios(this);"></textarea>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" onclick="RegistrarEstadousuario();" >Guardar</button>
      </div>
    </div>
  </div>
</div>
