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
    <form >
      <div class="">
        <center >
        <a class="btn btn-info btn-lg" style="width:390px; height:50px;" href="../pages/recuperacionContrasena.php" role="button">Recuperar  vía correo</a>
        </center>
      </div>
      <br>
      <div class="">
        <center >
        <a class="btn btn-info btn-lg" style="width:390px; height:50px;" href="../resetPassword.php" role="button">Recuperar  vía preguntas secretas</a>
        </center>
      </div>
      <div class="p-2">
                <center>
                <a class="text-decoration-none text-info fw-semibold" href="../index.php">Volver a iniciar sesión</a>
                </center>
                
            </div>
    </form>
      
    </div>
 

</body>


  
</html>
