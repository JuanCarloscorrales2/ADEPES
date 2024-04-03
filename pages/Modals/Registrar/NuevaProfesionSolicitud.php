<div class="modal fade" id="RegistarProfesionSolicitud" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">   <strong> <center>Nueva Profesión u Ocupación</center> </strong>   </h5>
        <button type="button" class="close" data-dismiss="modal" onclick="eventoCerrarModal();" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
          <div class="form-group">
            <label for="descripcion_rol" class="col-form-label">Descripción:</label>
            <input type="text" class="form-control" placeholder="Ingrese una breve descripción" id="descripcionProfesion" style="text-transform:uppercase;" onblur="CambiarMayuscula(this);" onkeypress="return soloLetras(event)" onkeyup="espacios(this);" maxlength="30">
           
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" onclick="eventoCerrarModal();"  data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-success" onclick="RegistrarProfesionSolicitud();" >Guardar</button>
      </div>
    </div>
  </div>
</div>

