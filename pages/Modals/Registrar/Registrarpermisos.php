<div class="modal fade" id="RegistrarPermiso" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"> <strong>
            <center>Otorgar Permisos</center>
          </strong> </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>


          <div class="form-group">
            <label for="recipient-name" class="col-form-label"><strong>Seleccione el rol:</strong></label>
            <select class="form-control" id="tipos_roles"> </select>
          </div>
          <label class="col-form-label" for="codigo"><strong>Permisos </strong></label>
          <div class="table-responsive">
            <table class="table" id="tabla_modulos_ingreso">
              <thead>
                <tr>
                  <th>Id Modulo</th>
                  <th>Módulo</th>
                  <th>Ver</th>
                  <th>Insertar</th>
                  <th>Actualizar</th>
                  <th>Generar Reportes</th>
                  <th>Eliminar</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
          </div>

          <!-- PERMISOS-->


        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" onclick="RegistrarPermiso();">Guardar</button>
      </div>
    </div>
  </div>
</div>