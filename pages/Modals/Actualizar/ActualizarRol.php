<div class="modal fade" id="actualizar_rol" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">   <strong> <center>Actualizar Rol</center> </strong>   </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
          <!-- input en el va oculto el idTipoPrestamo para actualizarlo -->
        <input type="hidden"  class="form-control" id="id_editar" >
          <div class="form-group">
            <label  class="col-form-label">Nombre del Rol:</label>
            <input type="text"  id="nombres_rol" placeholder="Ingrese el nombre del nuevo rol" class="form-control" style="text-transform:uppercase;" onblur="CambiarMayuscula(this);" onkeypress="return soloLetras(event);" onkeyup="espacios(this);" oninput="validarInput(this);">
          </div>
          <div class="form-group">
            <label  class="col-form-label">Descripción:</label>
            <textarea id="rol_desc" placeholder="Ingrese la descripción del nuevo rol" class="form-control" style="text-transform:uppercase;" onblur="CambiarMayuscula(this);" onkeypress="return soloLetras(event);" onkeyup="espacios(this);" oninput="validarInput(this);"></textarea>
          </div>
    
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" onclick="ActualizarRoles();" >Guardar</button>
      </div>
    </div>
  </div>
</div>
