<?php  

if(isset($_SESSION["user"])){
  
?>
<div class="modal fade" id="ActualizarPerfil" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">   <strong> <center>Actualizar Perfil</center> </strong>   </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" >
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
              <input type="hidden"  class="form-control" id="id_edit" value=<?php echo $_SESSION["user"]["idUsuario"]; ?>>

            <div class="form-group">
              <label for="" class="col-form-label">Usuario:</label>
              <input type="text" placeholder="Ingrese un nombre de usuario"  class="form-control" id="usuario_edit" style="text-transform:uppercase;" onblur="CambiarMayuscula(this);" onkeyup="validarespacio(this);" onkeypress="return soloLetras(event)" onblur="limpiaUsuario()" maxlength="15" readonly
              value=<?php echo $_SESSION["user"]["Usuario"]; ?>>
            </div>

            
            <div class="form-group">
              <label for="" class="col-form-label">Nombre completo:</label>
              <input type="text" placeholder="Ingrese su nombre completo" class="form-control" id="nombre_edit" style="text-transform:uppercase;" onblur="CambiarMayuscula(this);" onkeypress="return soloLetras(event)" 
              value=<?php echo $_SESSION["user"]["NombreUsuario"]; ?>>
            </div>


            <div class="form-group">
              <label for="" class="col-form-label">Correo Electrónico:</label>
              <input type="email" placeholder="Ingrese su correo" class="form-control" id="correo_edit" onkeyup="validarespacio(this);" 
              value=<?php echo $_SESSION["user"]["CorreoElectronico"]; ?>>
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

<script type="text/javascript">
 
 
/******************************************************************* */

//funcion para solo letras del input usuario
function soloLetras(e) {
      key = e.keyCode || e.which;
      tecla = String.fromCharCode(key).toLowerCase();
      letras = "abcdefghijklmnñopqrstuvwxyz";
      especiales = [32]; //permite caracteres especiales usando Caracteres ASCII
  
      tecla_especial = false
      for(var i in especiales) {
          if(key == especiales[i]) {
              tecla_especial = true;
              break;
          }
      }
  
      if(letras.indexOf(tecla) == -1 && !tecla_especial)
          return false;
  }
  
  //funcion que valida un solo espacio entre palabras
  espacios=function(input){
     input.value=input.value.replace('  ',' ');//sustituimos dos espacios seguidos por uno 
}
/************************************************************************* */
// funcion que valida que no se repite mas de 3 veces una misma letra
function contarLetras(input) {
	const contador = {};
	
	for (let i = 0; i < input.length; i++) {
	  const letra = input[i];
	  contador[letra] = (contador[letra] || 0) + 1;
	}
	
	return contador;
  }
  
  function validarRepeticionMaxima(input, nuevaLetra) {
	const contador = contarLetras(input);
	contador[nuevaLetra] = (contador[nuevaLetra] || 0) + 1;
	
	for (let letra in contador) {
	  if (contador[letra] > 3) {
		return false;
	  }
	}
	
	return true;
  }
  
  const inputElement = document.getElementById("nombre_edit"); //id del input
  
  inputElement.addEventListener("input", function() {
	const textoInput = inputElement.value;
	const nuevaLetra = textoInput[textoInput.length - 1];
	const esValido = validarRepeticionMaxima(textoInput.slice(0, -1), nuevaLetra);
	
	if (!esValido) {
	  inputElement.value = textoInput.slice(0, -1); // Eliminamos la última letra ingresada.
	}
  });


  


  /******************************************************************************************** */
</script>

<!--validaciones -->
<script src="../assets/js/funciones_validaciones.js"></script>
<?php   
  }
  else {
	  header("location:../");
  }
?>