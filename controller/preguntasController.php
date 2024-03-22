<?php 
session_start(); //fuarda la sesion del usuario
  require_once "../model/preguntasModel.php";

 
  //instancia de la clase pregntasmodel
  $pregunta = new preguntasModel();

  switch($_REQUEST["operador"]){

    case "listar_preguntas_select":

      $datos = $pregunta->ListarPreguntas();
      if($datos){  //valida que traiga datos
          for($i=0; $i<count($datos); $i++){
             $list[]=array(  //se pone los campos que queremos guardar
                "0"=>$datos[$i]['idPregunta'],
                "1"=>$datos[$i]['Pregunta'],
             );
          }
          echo json_encode($list); //se devuelve los datos en formato json 
      }

      
  break;

    case "registrar_pregunta":
        
      if($pre = $pregunta->ParametroPreguntas() ){ //TRAE EL PARAMETRO DE maximo de preguntas
        foreach ($pre as $campos => $valor){
            $PARAMETROS["valores"][$campos] = $valor; //ALMACENA EL PARAMETRO DE preguntas
        }
      } 

      ////////
      $cantidad = $pregunta->CantidadPreguntasContestadas( $_SESSION["user"]["idUsuario"]); //trae la cantidad de preguntas contestadas
      foreach ($cantidad as $campos => $valor){
          $CantidadPreguntas["cant"][$campos] = $valor; //ALMACENA LA CANTIDAD DE preguntas DEL USUARIO
      }

        if( isset($_POST["idPregunta"],$_POST["Respuesta"]) && !empty($_POST["idPregunta"]) && !empty($_POST["Respuesta"]) ){
          
            $idPregunta = $_POST["idPregunta"];
            $Respuesta = $_POST["Respuesta"];
            $idUsuario = $_SESSION["user"]["idUsuario"];
            $CreadoPor = $_SESSION["user"]["Usuario"];

            if($pregunta->ValidarPregunta($idUsuario, $idPregunta) == "preguntaRegistrada"){  //valida que no seleccione la misma pregunta
              $response = "preguntaRegistrada"; 
            }else{
              if( $pregunta->RegistrarPregunta($idPregunta, $idUsuario, $Respuesta, $CreadoPor) ){
                $response = "success";  //si se inserto en la BD manda mensaje de exito
                //registra el numero de preguntas contestadas
                $pregunta->ActualizarCantidadPreguntasContestadas( $CantidadPreguntas["cant"]["Contestadas"] +1, $_SESSION["user"]["idUsuario"]);
             }else{
                 $response = "error"; 
             }

            }
            
            
        }else{
            $response = "requerid"; //validad que ingresa todo los datos requeridos
        }

        echo $response;


    break;

    case "cambiar_clave":
      if( isset($_POST["Clave"],$_POST["ConfirmarClave"]) && !empty($_POST["Clave"]) && !empty($_POST["ConfirmarClave"]) ){
          $Clave = $_POST["Clave"];
          $confirmarClave = $_POST["ConfirmarClave"];

          $minima = $pregunta->ClaveMinima();//TRAE EL PARAMETRO DE INTENTOS
          foreach ($minima as $campos => $valor){
              $CLAVEMINIMA["valores"][$campos] = $valor; //ALMACENA EL numero de intentos DE INTENTOS
          }
          $maximo = $pregunta->ClaveMaxima();//TRAE EL PARAMETRO DE INTENTOS
          foreach ($maximo as $campos => $valor){
              $CLAVEMAXIMA["valores"][$campos] = $valor; //ALMACENA EL numero de intentos DE INTENTOS
          }

          if($Clave != $confirmarClave){
            $response = "claveDistinta";
         
              
          }else if( strlen($Clave) < $CLAVEMINIMA["valores"]["Valor"]){
            $response = "claveminima";

          }else if( strlen($Clave) > $CLAVEMAXIMA["valores"]["Valor"]){

            $response = "claveMaxima";
          }else if(!preg_match('`[A-Z]`',$Clave)){ //Que  contenga mayusculas
            $response = "mayuscula"; 

          }else if(!preg_match('`[a-z]`',$Clave)){//valida que la clave contenga una minuscula
            $response = "minuscula"; 

          }else if(!preg_match('`[0-9]`',$Clave)){ //valida que la clave contenga un numero
              $response = "numero"; 

          }else if(!preg_match('`[_#@$&%]`',$Clave)){ //valida que la clave contenga caracteres especiales
              $response = "caracteres"; 
            
          }else if( $pregunta->validarClaveDistinta($Clave, $_SESSION["user"]["idUsuario"])){
            $response = "mismaClave";

          }else if( $pregunta->ActualizarClaveUsuario($Clave,  $_SESSION["user"]["idUsuario"]) ){
             $response = "success";  //si se inserto en la BD manda mensaje de exito
             $pregunta->ActualizarEstadoUsuario( $_SESSION["user"]["idUsuario"] ); //atualiza el rol y estado  del usuario a default
             session_destroy();
          }else{
              $response = "error"; 
              
          }
      }else{
          $response = "requerid"; //validad que ingresa todo los datos requeridos
          
      }

      echo $response;


  break;


  } //fin switch
?>