<div class="modal fade" id="ActualizarUsuario" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">   <strong> <center>Actualizar Usuario</center> </strong>   </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
              <input type="hidden"  class="form-control" id="id_edit" >

            <div class="form-group">
              <label for="" class="col-form-label">Nombre completo:</label>
              <input type="text" placeholder="Ingrese un nombre del rol" class="form-control" id="nombre_edit" style="text-transform:uppercase;" onblur="CambiarMayuscula(this);" onkeypress="return soloLetras(event)" onblur="limpiaNombre()" onkeyup="espacios(this);"  >
            </div>

            <div class="form-group">
              <label for="" class="col-form-label">Usuario:</label>
              <input type="text" placeholder="Ingrese un nombre de usuario"  class="form-control" id="usuario_edit" style="text-transform:uppercase;" onblur="CambiarMayuscula(this);" onkeyup="validarespacio(this);" onkeypress="return soloLetras(event)" onblur="limpiaUsuario()" maxlength="15" readonly>
            </div>

            <div class="form-group">
              <label for="" class="col-form-label">Correo Electrónico:</label>
              <input type="email" placeholder="Ingrese su correo" class="form-control" id="correo_edit" onkeyup="validarespacio(this);">
            </div>

            <div class="form-group">
              <label for="" class="col-form-label">Seleccione el rol para el usuario:</label>
              <div class="position-relative has-icon-right">
                <select class="form-control" id="tipos_roles_edit"> </select>
              <div class="form-control-position"> <i class="icon-user"></i> </div>
            </div>

            <div class="form-group">
              <label for="" class="col-form-label">Seleccione el Estado para el usuario:</label>
              <div class="position-relative has-icon-right">
                <select class="form-control" id="tipos_estado_edit"> </select>
              <div class="form-control-position"> <i class="icon-user"></i> </div>
            </div>
                    
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" onclick="ActualizarUsuario();">Guardar</button>
      </div>
    </div>
  </div>
</div>


