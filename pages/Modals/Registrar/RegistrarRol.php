<div class="modal fade" id="RegistrarRol" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">   <strong> <center>Nuevo Rol</center> </strong>   </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick ="eventoCerrarModal();">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
          <div class="form-group">
            <label for="nombre_rol" class="col-form-label">Nombre del rol:</label>
            <input type="text" placeholder="Ingrese un nombre del rol" class="form-control" id="nombre_rol"  style="text-transform:uppercase;" onblur="CambiarMayuscula(this);" onkeypress="return soloLetras(event);" onkeyup="espacios(this);" oninput="validarInput(this);">
          </div>
          <div class="form-group">
            <label for="descripcion_rol" class="col-form-label">Descripción:</label>
            <textarea class="form-control" placeholder="Ingrese una breve descrición" id="descripcion_rol"  style="text-transform:uppercase;" onblur="CambiarMayuscula(this);" onkeypress="return soloLetras(event);" onkeyup="espacios(this);" oninput="validarInput(this);"></textarea>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick ="eventoCerrarModal();">Cerrar</button>
        <button type="button" class="btn btn-primary" onclick="RegistrarRol();" >Guardar</button>
      </div>
    </div>
  </div>
</div>
