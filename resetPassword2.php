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
    <title>ADEPES | Recuperacion</title>
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
    <div
      class="bg-white p-5 rounded-5 text-secondary shadow"
      style="width: 35rem"
    >
      <div class="d-flex justify-content-center">
        <img
          src="app-assets/images/ico/logo.png"
          alt="login-icon"
          style="height: 7rem"
        />
      </div>
      <div class="text-center fs-2 fw-bold">Preguntas de seguridad</div>
      <form action="controller/resetPassword.php" method="post" class="form-container">
            <label for="pregunta" class="form-label">Seleccione una pregunta de seguridad:</label>
            <select name="pregunta" id="pregunta" required class="form-select">
              <?php
              // Verificar si hay preguntas almacenadas en la sesión
              if (isset($_SESSION["preguntas"]) && is_array($_SESSION["preguntas"])) {
                foreach ($_SESSION["preguntas"] as $pregunta) {
                  // Mostrar cada pregunta como una opción en el select
                  if (isset($pregunta["Pregunta"])) {
                    echo '<option value="' . $pregunta["idPregunta"] . '">' . $pregunta["Pregunta"] . '</option>';
                  } else {
                    echo '<option value="">Error: Pregunta no encontrada</option>';
                  }
                }
              } else {
                echo '<option value="">No se encontraron preguntas de seguridad</option>';
              }
              ?>
            </select>
  
  <label style="padding-top: 15px;" for="respuesta" class="form-label">Ingrese su respuesta:</label>
  <input  style="width: 100%; padding: 6px; border-radius:50px " onblur="CambiarMayuscula(this);" type="text" name="respuesta" id="respuesta"  autocomplete="off" required class="form-input" >

  <input type="hidden" name="action" value="procesarFormularioRespuestas">
  <input class="btn btn-primary" style="border: 2px solid #e7e7e7; height:40px; margin-top:10px;" type="submit" value="Verificar respuesta">
</form>

    <br>
    <?php if (isset($_GET['error']) && $_GET['error'] == 1): ?>

<div id="mensaje" class="alert alert-danger">Datos ingresados no correctos. Por favor, verifique sus respuestas.</div>
<script>
// Función para ocultar el mensaje después de cierto tiempo
setTimeout(function() {
var mensaje = document.getElementById('mensaje');
mensaje.style.display = 'none';
}, 3000); // Ocultar después de 3 segundos (3000 milisegundos)
</script>
<?php endif; ?>
       
<div class="p-2">
                <center>
                <a class="text-decoration-none text-info fw-semibold" href="index.php">Volver a iniciar sesión</a>
                </center>
                
  </div>
      </div>
       

    
   



  <script src="assets/js/validar_registro.js"></script>
   <!--ejecuta la funcion validar espacio y mayusculas que se aloja en funciones _validaciones-->
   <script src="assets/js/funciones_validaciones.js"></script>
   <!-- referencias para las alertas -->
<!-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  </body>
    


</html>