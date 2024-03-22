<?php  
session_start();
if(isset($_SESSION["user"])){

  require_once "../model/preguntasModel.php";

 
  //instancia de la clase pregntasmodel
  $pregunta = new preguntasModel();
  $cantidad = $pregunta->CantidadPreguntasContestadas( $_SESSION["user"]["idUsuario"]); //trae la cantidad de preguntas contestadas
  foreach ($cantidad as $campos => $valor){
      $CantidadPreguntas["cant"][$campos] = $valor; //ALMACENA LA CANTIDAD DE preguntas DEL USUARIO
  }
  if($pre = $pregunta->ParametroPreguntas() ){ //TRAE EL PARAMETRO DE maximo de preguntas
    foreach ($pre as $campos => $valor){
        $PARAMETROS["valores"][$campos] = $valor; //ALMACENA EL PARAMETRO DE preguntas
    }
  } 
 ?>
<!-- ========= | scripts robust | ============-->
<?php  include "layouts/main_scripts.php";?> <!-- para mostrar datos en select ocupa la referencias ajax -->
 
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <link rel="icon" type="image/x-icon" href="/assets/logo-vt.svg" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>ADEPES | Configuración preguntas</title>
    <link rel="shortcut icon" type="image/x-icon" href="../app-assets/images/ico/logox.ico">
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
      style="width: 40rem">
      <center>
      <div class="text-left fs-4 fw-light">Configura tus preguntas de seguridad</div>
      <br>
      <div class="text-left fs-8 fw-bold">En caso de que olvides la contraseña</div>
     </center>
      <br>
      <section id="form" class="">

      <form>

        <div class="alert alert-primary" role="alert">
          <center>
            Preguntas contestadas <?php echo $CantidadPreguntas["cant"]["Contestadas"]; ?> de <?php echo $PARAMETROS["valores"]["Valor"]; 
            
            if( $CantidadPreguntas["cant"]["Contestadas"] ==  $PARAMETROS["valores"]["Valor"] &&  $_SESSION["user"]["CreadoPor"] == "ADMIN"){ 
             // $pregunta->ActualizarEstadoUsuario( $_SESSION["user"]["idUsuario"] ); //atualiza el rol y estado  del usuario a default
              header('Location: ../pages/configPreguntaClave.php'); //si fue creado por el ADMIN lo lleva a cambio de clave
            
            }

            if( $CantidadPreguntas["cant"]["Contestadas"] ==  $PARAMETROS["valores"]["Valor"] &&  $_SESSION["user"]["CreadoPor"] !== "ADMIN"){ 
              $pregunta->ActualizarEstadoUsuario( $_SESSION["user"]["idUsuario"] ); //atualiza el rol y estado  del usuario a default
              header('Location: ../index.php'); //si fue creado por el ADMIN lo lleva a cambio de clave
             
              session_destroy();
            }
            ?>
          </center>
          </div>
            

            <div class="form-group">
              <label for="" class="col-form-label">Seleccione una pregunta:</label>
                <select class="form-control" id="pregunta_usuario"> </select>
            </div>
            <div class="form-group">
              <label for="" class="col-form-label">Respuesta:</label>
              <input type="text" placeholder="Ingrese su respuesta" id="respuesta" class="form-control" style="text-transform:uppercase;" onblur="CambiarMayuscula(this);">
            </div>
            

            <br>
            <button type="button" id="refresh" class="btn btn-primary" onclick="RegistrarPregunta();" >Guardar</button>
            
        </form> 
      </section>
      <section id="lista">
     <!-- <a href="../index.php"><input type="button" value="Regresar"></a> -->
      </section>
    </div> 

    <script  src="../assets/js/PreguntasUser.js"></script>
    <!-- referencias para las alertas -->
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<!--validaciones -->
<script src="../assets/js/funciones_validaciones.js"></script>
    
</body>

</html>

<?php  //include "layouts/footer.php";  
  }
  else {
	  header("location:../");
  }
?>