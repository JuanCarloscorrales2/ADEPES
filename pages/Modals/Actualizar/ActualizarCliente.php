<div class="modal fade" id="ActualizarCliente" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">   <strong> <center>Actualizar Cliente</center> </strong>   </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
              <input type="hidden"  class="form-control" id="id_edit" >

            <div class="form-group">
              <label for="" class="col-form-label">Nombres:</label>
              <input type="text" placeholder="Ingrese sus nombres" class="form-control" id="nombre_edit" style="text-transform:uppercase;"  >
            </div>

            <div class="form-group">
              <label for="" class="col-form-label">Apellidos:</label>
              <input type="text" placeholder="Ingrese sus apellidos"  class="form-control" id="apellido_edit" style="text-transform:uppercase;" >
            </div>

            <div class="form-group">
              <label for="" class="col-form-label">Identidad:</label>
              <input type="text" placeholder="Ingrese su número de identidad"  class="form-control" id="identidad_edit" style="text-transform:uppercase;" maxlength="15" readonly>
            </div>

            <div class="form-group">
              <label for="" class="col-form-label">Contacto:</label>
              <input type="text" placeholder="Ingrese su nuevo contacto"  class="form-control" id="cel_edit" style="text-transform:uppercase;" maxlength="15">
            </div>

            <div class="form-group">
              <label for="" class="col-form-label">Dirección:</label>
              <input type="text" placeholder="Ingrese su nueva dirección"  class="form-control" id="add_edit" style="text-transform:uppercase;" maxlength="120">
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" onclick="ActualizarClientes();">Guardar</button>
      </div>
    </div>
  </div>
</div>
