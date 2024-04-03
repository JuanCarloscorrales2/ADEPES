<div class="modal fade" id="RegistrarUsuario" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">   <strong> <center>Nuevo Usuario</center> </strong>   </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick ="eventoCerrarModal();">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>


            <div class="form-group">
            <label for="" class="col-form-label">Vencimiento de Usuario:</label>
              <input type="text" id="vencimiento" class="form-control" value="<?php  echo date("Y-m-d",strtotime($fecha_actual."+" .$DIASPARAMETRO["valores"]["Valor"]." days"));  ?>"  readonly> 
              <br>
              <label for="" class="col-form-label">Nombre completo:</label>
              <input type="text" placeholder="Ingrese el nombre completo" class="form-control" id="nombre" style="text-transform:uppercase;" onblur="CambiarMayuscula(this);" onkeypress="return soloLetras(event)" onblur="limpiaNombre()" onkeyup="espacios(this);" maxlength="100" autocomplete="off" oninput="validarInput(this);">
            </div>

            <div class="form-group">
              <label for="" class="col-form-label">Usuario:</label>
              <input type="text" placeholder="Ingrese un nombre de usuario"  class="form-control" id="usuario" style="text-transform:uppercase;" onblur="CambiarMayuscula(this);" onkeyup="validarespacio(this);" onkeypress="return soloLetras(event)" onblur="limpiaUsuario()" maxlength="15" autocomplete="off">
            </div>

            <div class="form-group">
              <label for="" class="col-form-label">Correo Electrónico:</label>
              <input type="email" placeholder="Ingrese su correo" class="form-control" id="correo" onkeyup="validarespacio(this);" autocomplete="off">
            </div>

            <div class="form-group">
              <label for="recipient-name" class="col-form-label">Seleccione el rol para el usuario:</label>
                <select class="form-control" id="tipos_roles"> </select>
            </div>
            <label for="" class="col-form-label">Estado del Usuario:</label>
              <input type="text"  class="form-control" value ="Nuevo" readonly>
              <br>

            <div class="form-group">
              <label for="" class="col-form-label">contraseña:  </label> 
              <label for="" class="col-form-label"><input type="password" placeholder="Ingrese un nombre una contraseña"  class="form-control" id="clave" 
              value = "<?php $claves = generarPassword($CLAVEMAXIMA["valores"]["Valor"]);  echo $claves;  ?>" maxlength="30" size=40 style="width:520px" onkeyup="validarespacio(this);">
               </label> <button type="button" class="btn btn-warning btn-sm" onclick="mostrarClave();" style="float: right;" >
               <img src="../app-assets/images/noVer2.png" id="foto2"> </button>
            </div>
            
            <div class="form-group">
              <label for="" class="col-form-label">Confirmar Contraseña:</label> 
                <label for="" class="col-form-label"><input type="password" placeholder="Confirme su contraseña"  class="form-control" id="claveConfirmar"
                value = "<?php echo $claves;  ?>" maxlength="30" size=40 style="width:520px" onkeyup="validarespacio(this);">
                </label> <button type="button" class="btn btn-warning btn-sm" onclick="mostrarClaveConfirmar();" style="float: right;" >
                <img src="../app-assets/images/noVer.png" id="foto"> </button>
              
            </div>
            
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick ="eventoCerrarModal();">Cerrar</button>
        <button type="button" class="btn btn-primary" onclick="RegistrarUsuario();" >Guardar</button>
      </div>
    </div>
  </div>
</div>

<script>
//valida que no se ingresen más de 3 letras seguidas
function validarInput(input) {
    var texto = input.value;
    var regex = /([a-zA-Z])\1{3,}/g; // La expresión regular coincide con 3 letras iguales o más seguidas
    
    if (regex.test(texto)) {
        // Elimina el último caracter ingresado si es parte de una secuencia de 3 letras iguales o más
        input.value = texto.substring(0, texto.length - 1);
    }
}
</script>

