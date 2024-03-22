<div class="modal fade" id="actualizar_EstadoUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">   <strong> <center>Actualizar Estado Usuario</center> </strong>   </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
          <!-- input en el va oculto el idTipoPrestamo para actualizarlo -->
        <input type="hidden"  class="form-control" id="id_editarU" >
          <div class="form-group">
            <label  class="col-form-label">Estado Usuario:</label>
            <textarea id="estado_userdes" placeholder="Ingrese nuevo estado a actualizar" class="form-control" style="text-transform:uppercase;" onblur="CambiarMayuscula(this);" onkeypress="return soloLetras(event)" onkeyup="espacios(this);" ></textarea>
          </div>
    
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" onclick="ActualizarEstadousuario();" >Guardar</button>
      </div>
    </div>
  </div>
</div>
