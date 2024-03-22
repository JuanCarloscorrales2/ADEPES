<?php
session_start()

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <link rel="icon" type="image/x-icon" href="../assets/logo-vt.svg" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>ADEPES | Recuperación de contraseña</title>
    <link rel="shortcut icon" type="image/x-icon" href="../app-assets/images/ico/logox.ico">
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx"
      crossorigin="anonymous"
    />
       <!-- Referencias de las alertas sweetalert-->
       <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

        <!--para ejecutra el jquery -->
         <script src="app-assets/js/core/libraries/jquery.min.js" type="text/javascript"> </script>

  </head>

  <body class="bg-success d-flex justify-content-center align-items-center vh-100">
            <div
                class="bg-white p-5 rounded-5 text-secondary shadow"
                style="width: 30rem">
                    <div class="d-flex justify-content-center">
                    <img
                    src="../app-assets/images/ico/logo.png"
                    alt="login-icon"
                    style="height: 7rem"
                    />
                    </div>
                    <br>
                    <div class="text-center fs-3 fw-bold">Recuperación de contraseña</div>
                <br>
    <form  autocomplete="off" action="../controller/recuperacion_correo.php" method="post">
        <div class="input-group mt-2">
        <div class="input-group-text ">
          <img
            src="../app-assets/images/perfil.png"
            alt="username-icon"
            style="height: 1.25rem"
          />
        </div>
        <input
          class="form-control bg-light" type="text" id="username" name="username"
          onkeyup="validarespacio(this);"
          style="text-transform:uppercase;" onblur="CambiarMayuscula(this);"
          onkeypress="return soloLetras(event)" onblur="limpia()"
          placeholder="INGRESE SU USUARIO*" 
        />
      </div>
      <br>
      <div class="">
        <center >
        <input type="submit" style="width:390px; height:50px;" class="btn btn-info btn-lg"  value="Enviar contraseña por correo"/>
        </center>
      </div>
      <div class="p-2">
                <center>
                <a class="text-decoration-none text-info fw-semibold" href="../index.php">Volver a iniciar sesión</a>
                </center>
                
            </div>
    </form>
      
    </div>
    <!--para ejecutra el jquery -->
    <script src="app-assets/js/core/libraries/jquery.min.js" type="text/javascript"> </script>
    <script src="assets/js/validar_usuario.js" type="text/javascript"> </script>
    <!--ejecuta la funcion validar espacio que se aloja en funciones _validaciones-->
    <script src="../assets/js/funciones_validaciones.js"></script>
    <script src="../controller/LoginController.php"></script>
</body>
<script type="text/javascript">
    //funion que bloquea el copiar y pegar
window.onload = function() {
  var myInput = document.getElementById('username');
  
  myInput.onpaste = function(e) {
    e.preventDefault();
   
  }
  
  myInput.oncopy = function(e) {
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
