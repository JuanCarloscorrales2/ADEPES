<?php
session_start();

if(isset($_SESSION ["user"]) ){
    header("location:pages/welcome.php");
} else{
  
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <link rel="icon" type="image/x-icon" href="/assets/logo-vt.svg" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>ADEPES | Login</title>
    <link rel="shortcut icon" type="image/x-icon" href="app-assets/images/ico/logox.ico">
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx"
      crossorigin="anonymous"
    />
  </head>
  <body class="bg-success d-flex justify-content-center align-items-center vh-100">
    <div
      class="bg-white p-5 rounded-5 text-secondary shadow"
      style="width: 25rem"
    >
      <div class="d-flex justify-content-center">
        <img
          src="app-assets/images/ico/logo.png"
          alt="login-icon"
          style="height: 7rem"
        />
      </div>
      <div class="text-center fs-1 fw-bold">Inicio de Sesión</div>
      
      <div class="input-group mt-4">
        <div class="input-group-text ">
          <img
            src="app-assets/images/perfil.png"
            alt="username-icon"
            style="height: 1.5rem"
          />
        </div>
        
        <input
          class="form-control bg-light" id="user"
          type="text"
          minlength="15" maxlength="15"
          style="text-transform:uppercase;" onblur="CambiarMayuscula(this);"
          onkeypress="return soloLetras(event)" onblur="limpia()"
          onkeyup="validarespacio(this);"
          placeholder="Ingrese su Usuario"
          autocomplete="off"
        />
      </div>
      <br>
      <div class="input-group mt-1">
        <div class="input-group-text ">
          <img
            src="app-assets/images/candado.png"
            alt="password-icon"
            style="height: 1.5rem"
          />
        </div>
        <input
          class="form-control bg-light" id="user_clave" 
          type="password"
          onkeyup="validarespacio(this);"
          maxlength="30"
          placeholder="Ingrese su Contraseña"
        />
        <button type="button" class="btn btn-light" style="border: 2px solid #e7e7e7" onclick="mostrarClave();" ><img src="app-assets/images/noVer2.png" id="foto2"
            style="height: 1rem"> </button>
      </div>
      <div class="d-flex justify-content-around mt-1">
      
        <div class="pt-1">
        <br>
          <a
            href="pages/metodosRecuperacion.php"
            class="text-decoration-none text-info fw-semibold fst-italic"
            style="font-size: 0.9rem"
            >¿Olvidaste tu Usuario / Contraseña?</a
          >
        </div>
      </div>
      <br>
      <div class="">
        <center>
           <button type="button" class="btn btn-primary btn-lg btn-block" onclick="ValidarUsuario();">Iniciar sesión</button>
        </center>
      </div>
      <div class="d-flex gap-1 justify-content-center mt-1">
        <div>¿No tienes cuenta?</div>
        <a href="pages/registrarUser.php" class="text-decoration-none text-info fw-semibold">Registrate</a>
      </div>
      <div class="p-3">
        <div class="border-bottom text-center" style="height: 0.9rem">
          <span class="bg-white px-3"></span>
        </div>
      </div>
      <div id="estado_login" class="card-footer">
    </div>


    <!--para ejecutra el jquery -->
    <script src="app-assets/js/core/libraries/jquery.min.js" type="text/javascript"> </script>
    <script src="assets/js/validar_usuario.js" type="text/javascript"> </script>
    <!--ejecuta la funcion validar espacio que se aloja en funciones _validaciones-->
    <script src="assets/js/funciones_validaciones.js"></script>
 
  </body>
  <script type="text/javascript">
  //funcion java script para mostrar la clave
  var fotoMostrada2 = 'noVer2';

  function mostrarClave(){ 
    var contra = document.getElementById("user_clave");
    var imagen = document.getElementById("foto2"); //variable para la imagen

    if(contra.type == 'password'){
      contra.type = 'text';
    }else{
      contra.type = 'password';
    }
    //funcion para cambir imagen de clave
    if(fotoMostrada2 == 'ver2'){
      imagen.src = 'app-assets/images/noVer2.png';
      fotoMostrada2 = 'noVer2';
    }else{
      imagen.src = 'app-assets/images/ver2.png';
      fotoMostrada2 = 'ver2';
    }
    

  }


  //funion que bloquea el copiar y pegar
window.onload = function() {
  var myInput = document.getElementById('user');
  
  myInput.onpaste = function(e) {
    e.preventDefault();
   
  }
  
  myInput.oncopy = function(e) {
    e.preventDefault();
 
  }
  var myClave = document.getElementById('user_clave');
  //clave
  myClave.onpaste = function(e) {
    e.preventDefault();
   
  }
  
  myClave.oncopy = function(e) {
    e.preventDefault();
 
  }
}
//funcion para solo letras del input usuario
function soloLetras(e) {
      key = e.keyCode || e.which;
      tecla = String.fromCharCode(key).toLowerCase();
      letras = "abcdefghijklmnñopqrstuvwxyz";
      especiales = []; //permite caracteres especiales usando Caracteres ASCII
  
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
  
  function limpia() {
      var val = document.getElementById("user").value;
      var tam = val.length;
      for(i = 0; i < tam; i++) {
          if(!isNaN(val[i]))
              document.getElementById("user").value = '';
      }
  }
  </script>

</html>

<?php
}
?>