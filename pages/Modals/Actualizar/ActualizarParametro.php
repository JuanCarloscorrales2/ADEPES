<div class="modal fade" id="ActualizarParametro" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">   <strong> <center>Actualizar Parámetro</center> </strong>   </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form autocomplete="off">
              <input type="hidden"  class="form-control" id="idp_editar" onkeyup="CambiarMayuscula(this.value)" >

            <div class="form-group">
              <label for="" class="col-form-label">Parámetro:</label>
              <input type="text" placeholder="INGRESE NOMBRE DEL PARAMETRO" class="form-control" id="nombre_editar" style="text-transform:uppercase;" onblur="CambiarMayuscula(this);" onkeypress="return soloLetras(event)" onblur="limpiaNombre()"  maxlength="50" onkeyup="espacios(this);" readonly>
            </div>

            <div class="form-group">
              <label for="" class="col-form-label">Valor:</label>
              <input type="text" placeholder="INGRESE EL VALOR"  class="form-control" id="valor_edit" onblur="CambiarMayuscula(this);"  onblur="limpiaUsuario()" maxlength="100" onkeyup="espacios(this);" >
            </div>
     
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" onclick="ActualizarParametro();">Guardar</button>
      </div>
    </div>
  </div>
</div>


<script type="text/javascript">
 
 
/******************************************************************* */
  //Valida que solo ingrese mayusculas 
  function CambiarMayuscula(elemento){
    var idParametros = document.getElementById("idp_editar").value; //trae el id del parametros
    let texto = elemento.value;
    if(idParametros == 10 || idParametro = 11 )// 10 correo  11 clave del servidor
     //no cambia a mayuscula el parametro de correo
     input.value=input.value.replace('  ','');
    }else{
      elemento.value = texto.toUpperCase();
    }
    
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

  //funcion que valida un solo espacio entre palabras
  espacios=function(input){
    input.value = input.value.replace(/\s{2,}/g, ' ');//sustituimos dos espacios seguidos por uno 
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
