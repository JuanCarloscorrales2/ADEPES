<div class="modal fade" id="actualizar_Rubro" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">   <strong> <center>Actualizar Rubro</center> </strong>   </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
          <!-- Input que contiene el id del estado se encuentra oculto -->
           <input type="hidden"  class="form-control" id="id_edit" >
          <div class="form-group">
            <label for="descripcion_rol" class="col-form-label">Descripción:</label>
            <input type="text"  id="descripcion_rubro_edit" placeholder="Edite el Rubro" class="form-control" style="text-transform:uppercase;" onblur="CambiarMayuscula(this);" onkeypress="return soloLetras(event)" onkeyup="espacios(this);" maxlength="20">
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" onclick="ActualizarRubro();" >Guardar</button>
      </div>
    </div>
  </div>
</div>