<div class="modal fade" id="registral_estadocivil" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">   <strong> <center>Nuevo Estado Civil</center> </strong>   </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="eventoCerrarModal();">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
          <div class="form-group">
            <label for="descripcion_rol" class="col-form-label">Descripción:</label>
            <input type="text"  id="descripcion_estado_civil" placeholder="Ingrese un nombre del estado civil" class="form-control" style="text-transform:uppercase;" onblur="CambiarMayuscula(this);" onkeypress="return soloLetras(event)" onkeyup="espacios(this);" maxlength="20" oninput="validarInput(this);">
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="eventoCerrarModal();">Cerrar</button>
        <button type="button" class="btn btn-primary" onclick="RegistrarEstadoCivil();" >Guardar</button>
      </div>
    </div>
  </div>
</div>
