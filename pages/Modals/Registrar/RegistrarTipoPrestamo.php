<div class="modal fade" id="registral_tipo_prestamo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">   <strong> <center>Nuevo Préstamo</center> </strong>   </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick ="eventoCerrarModal();">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
          <div class="form-group">
            <label  class="col-form-label">Nombre:</label>
            <input type="text"  id="nombre" placeholder="Ingrese el nombre del nuevo préstamo" class="form-control" style="text-transform:uppercase;" onblur="CambiarMayuscula(this);" onkeypress="return soloLetras(event)" onkeyup="espacios(this);" maxlength="15">
          </div>
          <div class="form-group">
            <label  class="col-form-label">Tasa:</label>
            <input type="number"  id="tasa" placeholder="ingrese la tasa en porcentaje %" class="form-control">
          </div>
          <div class="form-group">
            <label  class="col-form-label">Plazo máximo:</label>
            <input type="number"  id="plazoMaximo" placeholder="Ingrese un nombre del rol" class="form-control">
          </div>
          <div class="form-group">
            <label class="col-form-label">Monto mínimo:</label>
            <input type="number"  id="montoMinimo"  class="form-control">
          </div>
          <div class="form-group">
            <label class="col-form-label">Monto máximo:</label>
            <input type="number"  id="montoMaximo"  class="form-control">
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick ="eventoCerrarModal();">Cerrar</button>
        <button type="button" class="btn btn-primary" onclick="RegistrarTipoPrestamo();" >Guardar</button>
      </div>
    </div>
  </div>
</div>
