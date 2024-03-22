<?php
session_start(); //fuarda la sesion del usuario
require "../model/Usuario.php";
//instancia de la clase usuario modelo
$usu = new Usuario();

switch($_REQUEST["operador"]){
    
    case "autoregistro_usuario":
        if( isset($_POST["Usuario"],$_POST["NombreUsuario"],$_POST["correoUser"],$_POST["Clave"],$_POST["ConfirmarClave"]) 
            && !empty($_POST["Usuario"]) && !empty($_POST["NombreUsuario"]) && !empty($_POST["correoUser"]) 
            && !empty($_POST["Clave"]) && !empty($_POST["ConfirmarClave"])){
            //valida que el correo tenga un dominio correcto
            if(strpos($_POST["correoUser"], '@gmail.com') !== false || strpos($_POST["correoUser"], '@yahoo.com') !== false || strpos($_POST["correoUser"], '@icloud.com') !== false){
                if($_POST["Clave"] == $_POST["ConfirmarClave"] ){

                    $Usuario = $_POST["Usuario"];
                    $idRol = 1;
                    $NombreUsuario = $_POST["NombreUsuario"];
                    $EstadoUsuario = 1;
                    $CorreoElectronico = $_POST["correoUser"];
                    $Clave = $_POST["Clave"];
                    $CreadoPor = $_POST["Usuario"];
                    $fecha_actual =  date('Y-m-d'); //almacena la fecha actual

                    $dias = $usu->DiasVencimiento(); //trae la cantidad de dias
                    foreach ($dias as $campos => $valor){
                        $DIASPARAMETRO["valores"][$campos] = $valor; //ALMACENA LA CANTIDAD DE dias de vencimiento DEL USUARIO
                    }
    
                    $FechaVencimiento = date("Y-m-d",strtotime($fecha_actual."+" .($DIASPARAMETRO["valores"]["Valor"])." days"));
                   
                    $minima = $usu->ClaveMinima();//TRAE EL PARAMETRO DE INTENTOS
                    foreach ($minima as $campos => $valor){
                        $CLAVEMINIMA["valores"][$campos] = $valor; //ALMACENA EL numero de intentos DE INTENTOS
                    }
                    $maximo = $usu->ClaveMaxima();//TRAE EL PARAMETRO DE INTENTOS
                    foreach ($maximo as $campos => $valor){
                        $CLAVEMAXIMA["valores"][$campos] = $valor; //ALMACENA EL numero de intentos DE INTENTOS
                    }
    
    
                    if( $usu->ValidarUsuarioRegistro($Usuario) == "existeUsuario"){
                        
                        $response = "existeUsuario"; 
                    }else if(   $usu->ValidarCorreoRegistro($CorreoElectronico) == "existeCorreo"){
                        $response = "existeCorreo"; 

                    }else if(  strlen($_POST["Clave"]) < $CLAVEMINIMA["valores"]["Valor"]){
                     
                        $response = "claveminima"; 

                    }else if(strlen($_POST["Clave"]) > $CLAVEMAXIMA["valores"]["Valor"]){
    
                        $response = "clavemaxima"; 

                    }else if(!preg_match('`[A-Z]`',$Clave) || !preg_match('`[a-z]`',$Clave) || !preg_match('`[0-9]`',$Clave) || !preg_match('`[_#@$&%]`',$Clave) ){ //valida que la clave contenga una mayuscula
    
                        $response = "caracteresClave"; 
                 
                    }else{
                        //correo de confirmacion
                        require ('../Model/Mailer.php'); 
                        $mailer = new Mailer();
                        $asunto ="Bienvenido A Fondo Revolvente";
                        $cuerpo = "Bienvenido al sistema del Fondo Revolvente, estimado $NombreUsuario: <br> se ha registrado con éxito, ahora puede proceder a iniciar sesión.";
                        if($mailer->enviarEmail($CorreoElectronico,$asunto, $cuerpo) ){
                           
                           
                            if( $usu->RegistrarUsuario($Usuario, $idRol, $NombreUsuario, $EstadoUsuario, $CorreoElectronico, $Clave, $CreadoPor, $FechaVencimiento)){
                               
                                $idU = $usu->ValidarUsuario($Usuario);//TRAE EL ID DE USUARIO PARA BITACORA
                                foreach ($idU as $campos => $valor){
                                    $IDUSUARIO["valores"][$campos] = $valor; //ALMACENA EL id usuario
                                }
                                 // REGISTRAR EN BITACORA
                                $usu->RegistrarBitacora( $IDUSUARIO["valores"]["idUsuario"] , 2,"Inserto", "Creo su cuenta de usuario desde autoregistro"); //registro de bitacora
                              
                                $response = "success";  //si se inserto en la BD y se envio el correo manda mensaje de exitos
                               // exit;
							}else{
                                $response = "errorBase";
                            }
                           
                        }else{
                            $response = "errorCorreo"; 
                        }
                    }
    
                }else{
                    $response = "ClaveDistinta";
                }

            }else{
                $response = "dominio";
            }
            
        }else{
            $response = "requerid"; //validad que ingresa todo los datos requeridos
        }

        echo $response;

    break;


}


//



?>