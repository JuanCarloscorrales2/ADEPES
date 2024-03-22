<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body  bgcolor="008f39">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>
<?php 
  require_once "../model/resetPassword.php";

  
  class RecuperarContrasenaController {
      private $modeloUsuario;
  
      public function __construct() {
          $this->modeloUsuario = new resetPasswordModel(); 
      }
  
      public function procesarFormularioRecuperacion() {
        
          $usuario = $_POST["usuario"];

          $_SESSION["nombreUsuario"] = $usuario;

      
  
         
          $usuarioExiste = $this->modeloUsuario->usuarioExiste($usuario);
  
          if ($usuarioExiste) {
  
            
              $preguntas = $this->modeloUsuario->obtenerPreguntasSeguridad();
             
            
              $_SESSION["preguntas"] = $preguntas;
  
            
              header("Location: ../resetPassword2.php");
              exit(); 
          } else {
            
              header("Location: ../resetPassword.php?error=1");
              exit();
          }
      }

      public function procesarFormularioRespuestas($nombreUsuario, $idPreguntaSeleccionada, $respuesta) {
       
        $userId = $this->modeloUsuario->obtenerIdUsuario($nombreUsuario);
        $_SESSION["idusuario"] = $userId;
        if (!$userId) {
            echo "Usuario no encontrado";
        }

        $preguntas = $this->modeloUsuario->ListarPreguntasUsuario($userId);
        $preguntaSeleccionada = null;
   
        foreach ($preguntas as $pregunta) {
            if ($pregunta['idPregunta'] == $idPreguntaSeleccionada) {
                $preguntaSeleccionada = $pregunta;
                break;
            }
        }
    
        if ($preguntaSeleccionada) {
        //  var_dump($preguntaSeleccionada); imprime el areglo de preguntas y respuestas
            // Verificar si la respuesta es correcta
            if ($preguntaSeleccionada['Respuesta'] === $respuesta) {
                // Respuesta correcta, redirigir a la siguiente pantalla
                header("Location: ../resetPassword3.php");
                exit();
            } else {
                // Respuesta incorrecta, redirigir a la pantalla de respuestas nuevamente
             // echo "Respuesta incorrecta";
             echo '<script>
             Swal.fire({
             icon: "warning",
             title: "Atención...",
             text: "Pregunta/Respuesta Incorrecta",
             showConfirmButton: true,
             confirmButtonText: "Aceptar"
             }).then(function(result){
                 if(result.value){                   
                 window.location = "../resetPassword2.php";
                 }
             });
             </script>';
            }
        } else {
          // echo "Pregunta no encontrada";
           echo '<script>
           Swal.fire({
           icon: "warning",
           title: "Atención...",
           text: "Pregunta/Respuesta Incorrecta",
           showConfirmButton: true,
           confirmButtonText: "Aceptar"
           }).then(function(result){
               if(result.value){                   
               window.location = "../resetPassword2.php";
               }
           });
           </script>';
        }
    }

    public function procesarFormularioContraseña() {
        $nombreUsuario = $_SESSION["nombreUsuario"];
      
        $contraseña = $_POST['Userclave'];
        $confirmacionContraseña = $_POST['ConfirmClave'];
        //clave minima
        $minima = $this->modeloUsuario->ClaveMinima();//TRAE EL PARAMETRO DE minimo
        foreach ($minima as $campos => $valor){
          $CLAVEMINIMA["valores"][$campos] = $valor; //ALMACENA EL numero de minimo de la clave
        }   
        //clave maxima
        $maximo = $this->modeloUsuario->ClaveMaxima();//TRAE EL PARAMETRO DE maximo
        foreach ($maximo as $campos => $valor){
            $CLAVEMAXIMA["valores"][$campos] = $valor; //ALMACENA EL numero de maximo de la clave
        }

        //dias de vencimiento
        $fecha_actual =  date('Y-m-d'); //almacena la fecha actual
        $dias = $this->modeloUsuario->DiasVencimiento(); //trae la cantidad de dias
        foreach ($dias as $campos => $valor){
          $DIASPARAMETRO["valores"][$campos] = $valor; //ALMACENA LA CANTIDAD DE dias de vencimiento DEL USUARIO
         }

        $FechaVencimiento = date("Y-m-d",strtotime($fecha_actual."+" .($DIASPARAMETRO["valores"]["Valor"])." days"));           

        if(strlen($contraseña) < $CLAVEMINIMA["valores"]["Valor"] || strlen($contraseña) > $CLAVEMAXIMA["valores"]["Valor"]){
          echo '<script>		
                    Swal.fire({
                    icon: "warning",
                    title: "Atención...",
                    text: "Su contraseña debe tener un mínimo de '.$CLAVEMINIMA["valores"]["Valor"].' y un máximo de '.$CLAVEMAXIMA["valores"]["Valor"].' caracteres",
                    showConfirmButton: true,
                    confirmButtonText: "Aceptar"
                    }).then(function(result){
                        if(result.value){                   
                        window.location = "../resetPassword3.php";
                        }
                    });
                    </script>';
        }else{
          if (!preg_match('`[A-Z]`',$contraseña) || !preg_match('`[a-z]`',$contraseña) || !preg_match('`[0-9]`',$contraseña) 
          || !preg_match('`[_#@$&%]`',$contraseña)) {
            header("Location: ../resetPassword3.php?error=2");
            exit();

          }else if ($contraseña == $confirmacionContraseña) {
          
              $resultado = $this->modeloUsuario->actualizarContraseña($nombreUsuario,$FechaVencimiento, $contraseña);
              $bitacora = $this->modeloUsuario->RegistrarBitacora($_SESSION["idusuario"], 5, "Recuperación", "Recupero su clave por el método de preguntas");
          
              if ($resultado) {   
              //header("Location: ../index.php?exito=1");
                echo '<script>
                      Swal.fire({
                      icon: "success",
                      title: "Recuperación Exitosa",
                      text: "Contraseña restablecida con éxito",
                      showConfirmButton: true,
                      confirmButtonText: "Aceptar"
                      }).then(function(result){
                          if(result.value){                   
                          window.location = "../index.php";
                          }
                      });
                      </script>';
                exit();
              } else {
                header("Location: ../resetPassword3.php?error=1");
                exit();
              }
           
          } else {
      
              header("Location: ../resetPassword3.php?error=1");
              exit();
          }

        }
      
       
      }

    
    }

    

    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["action"]) && $_POST["action"] === "procesarFormularioContraseña") {
        $controller = new RecuperarContrasenaController();
        $controller->procesarFormularioContraseña();
    }
  
  // Crear una instancia del controlador y procesar el formulario si se envió
  if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["action"]) && $_POST["action"] === "procesarFormularioRecuperacion") {
      $controller = new RecuperarContrasenaController();
      $controller->procesarFormularioRecuperacion();
  }

  // Verificar si se envió el formulario de respuestas

  if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["action"]) && $_POST["action"] === "procesarFormularioRespuestas") {
    $controller = new RecuperarContrasenaController();
    
    // Obtener el nombre de usuario desde la sesión
    $nombreUsuario = $_SESSION["nombreUsuario"];

    $preguntas = $_SESSION["preguntas"];
    
    // Obtener las respuestas enviadas por el formulario
    $respuestas = $_POST["respuesta"];
    
    $preguntaSeleccionada = $_POST['pregunta'];

    $controller->procesarFormularioRespuestas($nombreUsuario, $preguntaSeleccionada, $respuestas,);
  }
  
  