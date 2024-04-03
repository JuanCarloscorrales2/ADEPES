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
              <input type="text" placeholder="Ingrese sus nombres" class="form-control" id="nombre_edit" style="text-transform:uppercase;" 
              onblur="CambiarMayuscula(this);" onkeypress="return soloLetras(event)" onkeyup="espacios(this);" oninput="validarInput(this)">
            </div>

            <div class="form-group">
              <label for="" class="col-form-label">Apellidos:</label>
              <input type="text" placeholder="Ingrese sus apellidos"  class="form-control" id="apellido_edit" style="text-transform:uppercase;" 
              onblur="CambiarMayuscula(this);" onkeypress="return soloLetras(event)" onkeyup="espacios(this);" oninput="validarInput(this)">
            </div>

            <div class="form-group">
              <label for="" class="col-form-label">Identidad:</label>
              <input type="text" placeholder="Ingrese su número de identidad"  class="form-control" id="identidad_edit" style="text-transform:uppercase;" maxlength="15" readonly>
            </div>

            <div class="form-group">
              <label for="" class="col-form-label">Contacto:</label>
              <input type="text" placeholder="Ingrese su nuevo contacto"  class="form-control" id="cel_edit" style="text-transform:uppercase;" maxlength="15"
              oninput="validarContacto(this)">
            </div>

            <div class="form-group">
              <label for="" class="col-form-label">Dirección:</label>
              <input type="text" placeholder="Ingrese su nueva dirección"  class="form-control" id="add_edit" style="text-transform:uppercase;" maxlength="120"
              onblur="CambiarMayuscula(this);" onkeyup="espacios(this);" oninput="validarInput(this)">
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


<script>
  
//funciones para solo mayusculas y espacios. estas funcion van en los input de type="text"
 //funcion que valida un solo espacio entre palabras
 espacios=function(input){
  input.value=input.value.replace('  ',' ');//sustituimos dos espacios seguidos por uno 
}
 
 //Valida que solo ingrese mayusculas 
function CambiarMayuscula(elemento){
  let texto = elemento.value;
  elemento.value = texto.toUpperCase();
}

//funcion para solo permitir letras en el elemento del formulario.
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

if(letras.indexOf(tecla) == -1 && !tecla_especial)
    return false;
}
}

//valida que no se ingresen más de 3 letras seguidas
function validarInput(input) {
    var texto = input.value;
    var regex = /([a-zA-Z])\1{3,}/g; // La expresión regular coincide con 3 letras iguales o más seguidas
    
    if (regex.test(texto)) {
        // Elimina el último caracter ingresado si es parte de una secuencia de 3 letras iguales o más
        input.value = texto.substring(0, texto.length - 1);
    }
}

//función que valida no ingresar numeros negativos ni letras
function validarContacto(input) {
    var numero = input.value;

    // Eliminar caracteres que no sean números o guion
    var numeroLimpio = numero.replace(/[^\d-]/g, '');

    // Verificar si el número tiene un formato válido
    var formatoValido = /^\d{0,4}-?\d{0,4}$/;

    if (numeroLimpio !== numero || !formatoValido.test(numero)) {
        if (numero === '') {
            input.value = ''; // Limpiar el campo si está vacío
        } else {
            input.value = numero.substring(0, numero.length - 1); // Mantener el número hasta el último dígito válido
        }
    }
}
</script>