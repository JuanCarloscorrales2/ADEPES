<div class="modal fade" id="actualizar_tipo_prestamo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">   <strong> <center>Actualizar Préstamo</center> </strong>   </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
          <!-- input en el va oculto el idTipoPrestamo para actualizarlo -->
        <input type="hidden"  class="form-control" id="id_edit" >
          <div class="form-group">
            <label  class="col-form-label">Nombre:</label>
            <input type="text"  id="nombre_edit" placeholder="Ingrese el nombre del nuevo préstamo" class="form-control" style="text-transform:uppercase;" onblur="CambiarMayuscula(this);" onkeypress="return soloLetras(event)" onkeyup="espacios(this);" maxlength="15" oninput="validarInput(this);">
          </div>
          <div class="form-group">
            <label  class="col-form-label">Tasa:</label>
            <input type="number"  id="tasa_edit" placeholder="ingrese la tasa en porcentaje %" class="form-control" oninput="validarNumeroNegativo(this);">
          </div>
          <div class="form-group">
            <label  class="col-form-label">Plazo máximo:</label>
            <input type="number"  id="plazoMaximo_edit" class="form-control" oninput="validarNumeroNegativo(this);">
          </div>

          <div class="form-group">
              <label for="recipient-name" class="col-form-label">Seleccione el estado para el préstamo:</label>
              <select class="form-control" id="estado_prestamo_edit"> </select>
          </div>
          <div class="form-group">
            <label class="col-form-label">Monto mínimo:</label>
            <input type="number"  id="montoMinimo_edit"  class="form-control" oninput="validarNumeroNegativo(this);">
          </div>
          <div class="form-group">
            <label class="col-form-label">Monto máximo:</label>
            <input type="number"  id="montoMaximo_edit"  class="form-control" oninput="validarNumeroNegativo(this);">
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" onclick="ActualizarTipoPrestamo();" >Guardar</button>
      </div>
    </div>
  </div>
</div>

<script>
//validar que no se ingresen más de 3 letras seguidas
function validarInput(input) {
    var texto = input.value;
    var regex = /([a-zA-Z])\1{3,}/g; // La expresión regular coincide con 3 letras iguales o más seguidas
    
    if (regex.test(texto)) {
        // Elimina el último caracter ingresado si es parte de una secuencia de 3 letras iguales o más
        input.value = texto.substring(0, texto.length - 1);
    }
}
</script>
