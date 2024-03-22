<div class="modal fade" id="ActualizarPregunta" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">   <strong> <center>Actualizar Pregunta</center> </strong>   </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form autocomplete="off">
            <input type="hidden"  class="form-control" id="id_editar" >

          <div class="form-group">
            <label for="descripcion_rol" class="col-form-label">Ingrese una nueva pregunta:</label>
            <input class="form-control" placeholder="INGRESE UNA NUEVA PREGUNTA" id="pregunta_editar" style="text-transform:uppercase;" onblur="CambiarMayuscula(this);" onkeypress="return soloLetras(event)" onblur="limpiaNombre()"  onkeyup="espacios(this);" maxlength="100" ></input>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" onclick="ActualizarPregunta();" >Guardar</button>
      </div>
    </div>
  </div>
</div>


<script type="text/javascript">
 
 
/******************************************************************* */
  //Valida que solo ingrese mayusculas 
  function CambiarMayuscula(elemento){
    let texto = elemento.value;
    elemento.value = texto.toUpperCase();
  }
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
  //user
  function limpiaUsuario() {
      var val = document.getElementById("pregunta_editar").value;
      var tam = val.length;
      for(i = 0; i < tam; i++) {
          if(!isNaN(val[i]))
              document.getElementById("pregunta_editar").value = '';
      }
  }
  //nombre
  function limpiaNombre() {
      var val = document.getElementById("pregunta_editar").value;
      var tam = val.length;
      for(i = 0; i < tam; i++) {
          if(!isNaN(val[i]))
              document.getElementById("pregunta_editar").value = '';
      }
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
  
  const inputElement = document.getElementById("nueva_preguntas"); //id del input
  
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
