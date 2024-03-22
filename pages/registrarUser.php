<?php  
  session_start();
  
 ?>
<?php  include "layouts/main_scripts.php";?> <!-- referencias ajax -->
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <link rel="icon" type="image/x-icon" href="/assets/logo-vt.svg" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>ADEPES | Registrate</title>
    <link rel="shortcut icon" type="image/x-icon" href="../app-assets/images/ico/logox.ico">
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx"
      crossorigin="anonymous"
    />
    <!-- Referencias de las alertas sweetalert-->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
 
     <!--para ejecutra el jquery -->
     <script src="app-assets/js/core/libraries/jquery.min.js" type="text/javascript"> </script>
  </head>
  <body class="bg-success d-flex justify-content-center align-items-center vh-100">
    <div
      class="bg-white p-5 rounded-5 text-secondary shadow"
      style="width: 25rem"
    >
      <div class="d-flex justify-content-center">
        <img
          src="../app-assets/images/ico/logo.png"
          alt="login-icon"
          style="height: 7rem"
        />
      </div>
      <div class="text-center fs-2 fw-bold">Regístrate</div>
  <form role="form" name="registro" action="controller/registroController.php" method="post">
      <div class="input-group mt-2">
        <div class="input-group-text ">
          <img
            src="../app-assets/images/perfil.png"
            alt="username-icon"
            style="height: 1.25rem"
          />
        </div>
        <input
          class="form-control bg-light"  id="username" name="username" 
          type="text"
          minlength="15" maxlength="15"
          onkeyup="validarespacio(this);"
          style="text-transform:uppercase;" onblur="CambiarMayuscula(this);"
          onkeypress="return soloLetras(event)" onblur="limpia()"
          placeholder="Ingrese nombre de usuario:*" 
          autocomplete="off"
        />
      </div>
          <div class="input-group mt-2">
        <div class="input-group-text ">
          <img
            src="../app-assets/images/perfil.png"
            alt="username-icon"
            style="height: 1.25rem"
          />
        </div>
        <br>
        <input
          class="form-control bg-light" id="nombreCompleto" name="nombreCompleto" 
          type="text"
          style="text-transform:uppercase;" onblur="CambiarMayuscula(this);"
          onkeypress="return soloLetras(event)" onblur="limpiaNombre()"
          onkeyup="espacios(this);"
          maxlength="100"
          placeholder="Ingrese nombre completo:*"
          autocomplete="off"
        />
      </div>
      <div class="input-group mt-2">
        <div class="input-group-text ">
          <img
            src="../app-assets/images/correo.png"
            alt="password-icon"
            style="height: 1.25rem"
          />
        </div>
        <br>
        <input
          class="form-control bg-light" id="correoUser" name="correoUser" 
          type="email"
          onkeyup="validarespacio(this);"
          placeholder="Ingrese un correo electrónico:*"
          maxlength="50"
          autocomplete="off"
        />
      </div>
      <div class="input-group mt-2">
        <div class="input-group-text ">
          <img
            src="../app-assets/images/candado.png"
            alt="password-icon"
            style="height: 1.25rem"
          />
        </div>
        <input
          class="form-control bg-light" id="Userclave" name="Userclave" 
          type="password"
          maxlength="30"
          onkeyup="validarespacio(this);"
          placeholder="Ingrese una Contraseña:*"
        />
        <button type="button" class="btn btn-light" style="border: 2px solid #e7e7e7" onclick="mostrarClave();" ><img src="../app-assets/images/noVer2.png" id="foto2"
            style="height: 1rem"> </button>
      </div>
      <div class="input-group mt-2">
        <div class="input-group-text ">
          <img
            src="../app-assets/images/candado.png"
            alt="password-icon"
            style="height: 1.25rem"
          />
        </div>
        <br>
        <input
          class="form-control bg-light" id="ConfirmClave" name="ConfirmClave" 
          type="password"
          maxlength="30"
          onkeyup="validarespacio(this);"
          placeholder="Confirmar contraseña:*"
        />
        <button type="button"  class="btn btn-light" style="border: 2px solid #e7e7e7" onclick="mostrarClaveConfirmar();" ><img src="../app-assets/images/noVer.png" id="foto"
            style="height: 1rem" ></button>
      </div>
      <br>
      <div class="">
        <center>
           <button  type="button"  class="btn btn-primary btn-lg btn-block" onclick="AutoregistroUsuario();">Registrarse</button>
        </center>
      </div>
      <div class="d-flex gap-1 justify-content-center mt-1">
        <div>¿Ya tienes una cuenta?</div>
        <a href="../index.php" class="text-decoration-none text-info fw-semibold">Inicio de sesión</a>
      </div>
      <div class="p-3">
        <div class="border-bottom text-center" style="height: 0.9rem">
          <span class="bg-white px-3"></span>
        </div>
      </div>
      <div id="estado_login" class="card-footer">
    </div>
  </form>  

  <script src="../assets/js/validar_registro.js"></script>
   <!--ejecuta la funcion validar espacio y mayusculas que se aloja en funciones _validaciones-->
   <script src="../assets/js/funciones_validaciones.js"></script>
  </body>
    
<script type="text/javascript">
  //funcion java script para mostrar la clave
  var fotoMostrada2 = 'noVer2';

  function mostrarClave(){ 
    var contra = document.getElementById("Userclave");
    var imagen = document.getElementById("foto2"); //variable para la imagen

    if(contra.type == 'password'){
      contra.type = 'text';
    }else{
      contra.type = 'password';
    }
    //funcion para cambir imagen de clave
    if(fotoMostrada2 == 'ver2'){
      imagen.src = '../app-assets/images/noVer2.png';
      fotoMostrada2 = 'noVer2';
    }else{
      imagen.src = '../app-assets/images/ver2.png';
      fotoMostrada2 = 'ver2';
    }
    

  }


  var fotoMostrada = 'noVer';
   //funcion java script para mostrar la clave confirmada
  function mostrarClaveConfirmar(){
    var contraConfirmar = document.getElementById("ConfirmClave");
    var imagen = document.getElementById("foto");
    if(contraConfirmar.type =='password' ){
      contraConfirmar.type = 'text';
      
    }else{
      contraConfirmar.type = 'password';
    }
     
    //funcion para cambir imagen de clave
    if(fotoMostrada == 'ver'){
      imagen.src = '../app-assets/images/noVer.png';
      fotoMostrada = 'noVer';
    }else{
      imagen.src = '../app-assets/images/ver.png';
      fotoMostrada = 'ver';
    }
  }

  /*******funion que bloquea el copiar y pegar ****************************************/
window.onload = function() {
  var myInput = document.getElementById('username'); //usuario
  
  myInput.onpaste = function(e) {
    e.preventDefault();
   
  }
  
  myInput.oncopy = function(e) {
    e.preventDefault();
 
  }
  //nombre
  var nombre = document.getElementById('nombreCompleto'); 
  
  nombre.onpaste = function(e) {
    e.preventDefault();
   
  }
  
  nombre.oncopy = function(e) {
    e.preventDefault();
 
  }
    //correo
  var correo = document.getElementById('correoUser'); 
  
  correo.onpaste = function(e) {
    e.preventDefault();
   
  }
  
  correo.oncopy = function(e) {
    e.preventDefault();
 
  }
  //clave
  var myClave = document.getElementById('Userclave');
  
  myClave.onpaste = function(e) {
    e.preventDefault();
   
  }
  
  myClave.oncopy = function(e) {
    e.preventDefault();
 
  }
   //confirmarclave
  var confirmarclave = document.getElementById('ConfirmClave'); 
  
   confirmarclave.onpaste = function(e) {
    e.preventDefault();
   
  }
  
  correo.oncopy = function(e) {
    e.preventDefault();
 
  }
}
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
  //user
  function limpia() {
      var val = document.getElementById("username").value;
      var tam = val.length;
      for(i = 0; i < tam; i++) {
          if(!isNaN(val[i]))
              document.getElementById("username").value = '';
      }
  }
  //nombre
  function limpiaNombre() {
      var val = document.getElementById("nombreCompleto").value;
      var tam = val.length;
      for(i = 0; i < tam; i++) {
          if(!isNaN(val[i]))
              document.getElementById("nombreCompleto").value = '';
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
  
  const inputElement = document.getElementById("username"); //id del input
  
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

</html>



