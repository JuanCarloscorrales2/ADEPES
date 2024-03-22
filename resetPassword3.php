<?php  
  session_start();
  
 ?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <link rel="icon" type="image/x-icon" href="/assets/logo-vt.svg" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>ADEPES | Nueva contraseña</title>
    <link rel="shortcut icon" type="image/x-icon" href="app-assets/images/ico/logox.ico">
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
    <div class="bg-white p-5 rounded-5 text-secondary shadow" style="width: 35rem">
      <div class="d-flex justify-content-center">
        <img
          src="app-assets/images/ico/logo.png"
          alt="login-icon"
          style="height: 7rem"
        />
      </div>
      <div class="text-center fs-2 fw-bold">Nueva contraseña</div>
      <div style="text-align: center;">
      <form action="controller/resetPassword.php" method="post">

<div class="input-group mt-2">
  <div class="input-group-text ">
    <img
      src="app-assets/images/candado.png"
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
  <button type="button" class="btn btn-light" style="border: 2px solid #e7e7e7" onclick="mostrarClave();" ><img src="app-assets/images/noVer2.png" id="foto2"
      style="height: 1rem"> </button>
</div>
<br>
<div class="">
  <div class="input-group-text ">
    <img
      src="app-assets/images/candado.png"
      alt="password-icon"
      style="height: 1.25rem"
    />
  <input
    class="form-control bg-light" id="ConfirmClave" name="ConfirmClave" 
    type="password"
    maxlength="30"
    onkeyup="validarespacio(this);"
    placeholder="Confirmar contraseña:*"
  />
  <button type="button"  class="btn btn-light" style="border: 2px solid #e7e7e7" onclick="mostrarClaveConfirmar();" ><img src="app-assets/images/noVer.png" id="foto"
      style="height: 1rem" ></button>
</div>
</div>
<br>

<input type="hidden" name="action" value="procesarFormularioContraseña">
<input type="submit" value="Guardar contraseña" style="width:390px; height:50px;" class="btn btn-info btn-lg">
<br>
<?php if (isset($_GET['error']) && $_GET['error'] == 1): ?>
  <div id="mensaje" class="alert alert-danger">Las contraseñas no coinciden.</div>

  <script>
    // Función para ocultar el mensaje después de cierto tiempo
    setTimeout(function() {
      var mensaje = document.getElementById('mensaje');
      mensaje.style.display = 'none';
    }, 3000); // Ocultar después de 3 segundos (3000 milisegundos)
  </script>
<?php endif; ?>
<a href="index.php" class="text-decoration-none text-info fw-semibold"> <-- Iniciar sessión</a>


      </div>
      <?php if (isset($_GET['error']) && $_GET['error'] == 2): ?>
  <div id="mensaje" class="alert alert-warning">Su nueva contraseña debe tener Mayúsculas, Minúsculas y un caracteres especial _#@$&%.</div>

  <script>
    // Función para ocultar el mensaje después de cierto tiempo
    setTimeout(function() {
      var mensaje = document.getElementById('mensaje');
      mensaje.style.display = 'none';
    }, 5000); // Ocultar después de 5 segundos (3000 milisegundos)
  </script>
<?php endif; ?>
<a href="index.php" class="text-decoration-none text-info fw-semibold"> </a>


      </div>
</form>
  <br>
</div>






  <script src="assets/js/validar_registro.js"></script>
   <!--ejecuta la funcion validar espacio y mayusculas que se aloja en funciones _validaciones-->
   <script src="assets/js/funciones_validaciones.js"></script>
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
      imagen.src = 'app-assets/images/noVer2.png';
      fotoMostrada2 = 'noVer2';
    }else{
      imagen.src = 'app-assets/images/ver2.png';
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
      imagen.src = 'app-assets/images/noVer.png';
      fotoMostrada = 'noVer';
    }else{
      imagen.src = 'app-assets/images/ver.png';
      fotoMostrada = 'ver';
    }
  }

  /*******funion que bloquea el copiar y pegar ****************************************/
window.onload = function() {
  var myInput = document.getElementById('Userclave'); //usuario
  
  myInput.onpaste = function(e) {
    e.preventDefault();
   
  }
  
  myInput.oncopy = function(e) {
    e.preventDefault();
 
  }
  //condirmar clave
  var confirmarClave = document.getElementById('ConfirmClave'); 
  
  confirmarClave.onpaste = function(e) {
    e.preventDefault();
   
  }
  
  confirmarClave.oncopy = function(e) {
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
</script>

</html>