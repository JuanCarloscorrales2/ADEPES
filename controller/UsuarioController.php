<?php
session_start(); //fuarda la sesion del usuario
require "../model/Usuario.php";
//instancia de la clase usuario modelo
$usu = new Usuario();

switch ($_REQUEST["operador"]) {

    case "validar_usuario":

        if (isset($_POST["usuario"], $_POST["clave"]) && !empty($_POST["usuario"]) && !empty(["clave"])) {

            if ($user = $usu->ValidarUsuario($_POST["usuario"])) {  //valida que el usuario existe

                foreach ($user as $campos => $valor) {
                    $_SESSION["user"][$campos] = $valor;    //almacena los datos del usuario
                }
                if ($intentos = $usu->ParametroIntentos()) { //TRAE EL PARAMETRO DE INTENTOS
                    foreach ($intentos as $campos => $valor) {
                        $PARAMETROS["valores"][$campos] = $valor; //ALMACENA EL numero de intentos DE INTENTOS
                    }
                }

                if ($usu->ValidarUsuarioClave($_POST["clave"], $_SESSION["user"]["idUsuario"])) { //valida que la clave es correcta
                    //valida el estado del usuario
                    if ($_SESSION["user"]["idEstadoUsuario"] == 1) {  //nuevo
                        $response = "nuevo";
                        //session_destroy();

                    } else if ($_SESSION["user"]["idEstadoUsuario"] == 2 &&  $_SESSION["user"]["Intentos"]  >= $PARAMETROS["valores"]["Valor"]) { //Activo

                        $usu->ActualizarUsuarioBloqueado($_SESSION["user"]["idUsuario"]); //BLOQUEA EL USUARIO POR MAXIMO DE INTENTOS ACANZADOS
                        $response = "bloqueado";
                        session_destroy();
                    } else if ($_SESSION["user"]["idEstadoUsuario"] == 2 && $_SESSION["user"]["idRol"] == 1) { //default
                        $response = "default";
                        $usu->EliminarIntentosUsuario($_SESSION["user"]["idUsuario"]); //elimina los intentos del usuario
                        session_destroy();
                    } else if ($_SESSION["user"]["idEstadoUsuario"] == 2) { //ACTIVO
                        $response = "success";
                        $usu->RegistrarBitacora($_SESSION["user"]["idUsuario"], 1, "Ingreso", "Ingreso al Sistema"); //registro de bitacora
                        $usu->EliminarIntentosUsuario($_SESSION["user"]["idUsuario"]); //elimina los intentos del usuario

                    } else if ($_SESSION["user"]["idEstadoUsuario"] == 3) { //bloqueado
                        $response = "bloqueado";
                        session_destroy();
                    } else if ($_SESSION["user"]["idEstadoUsuario"] == 4) { //Inactivo
                        $response = "inactivo";
                        session_destroy();
                    }
                } else if ($_SESSION["user"]["idEstadoUsuario"] == 4) {
                    $response = "inactivo";
                    session_destroy();
                    //SI SOLO EL USUARIO ES CORRECTO  VALIDA QUE NO A SUPERADO LOS INTENTOS
                } else if (($_SESSION["user"]["Intentos"] + 1) >  $PARAMETROS["valores"]["Valor"]) {
                    $response = "bloqueado";
                    $usu->ActualizarUsuarioBloqueado($_SESSION["user"]["idUsuario"]); //BLOQUEA EL USUARIO POR MAXIMO DE INTENTOS ACANZADOS
                    session_destroy();
                } else {  //SI EL USUARI Y CLAVE NO EXISTEN
                    $response = "notfound";
                    $usu->RegistrarUsuarioIntento($_SESSION["user"]["idUsuario"]); //inserta intentos
                    session_destroy();
                }
            } else {
                // VALOR DE INGRESO DE USUARIO...
                $response = "requerid";
            }
        } else {
            $response = "requerid";
        }

        echo $response;

        break;

    case "cerrar_session":  //metodo de cierre de sesion
        $usu->RegistrarBitacora($_SESSION["user"]["idUsuario"], 1, "Salio", "Salio del Sistema"); //registro de bitacora
        unset($_SESSION["user"]); //destruye las datos que inicio session
        header("location:../");

        break;

    case "listar_usuarios":

        $datos = $usu->ListarUsuarios(); //obtiene los datos del metodo
        if ($datos) {
            for ($i = 0; $i < count($datos); $i++) {
                $boton_editar = $_SESSION["actualizar"] >= 1 ? '<a class="dropdown-item" data-toggle="modal" data-target="#ActualizarUsuario"
                onclick="ObtenerUsuarioPorId(' . $datos[$i]['idUsuario'] . ",'editar'" . ');">
                <i class="icon-edit"></i> Editar </a>' : '<span class="tag tag-warning">No puede editar</span>';
                $boton_eliminar = $_SESSION["eliminar"] >= 1 ? ' <a class="dropdown-item" onclick="ObtenerUsuarioPorId(' . $datos[$i]['idUsuario'] . ",'eliminar'" . ');">
                <i class="icon-trash"></i> Eliminar </a>'
                    : '<span class="tag tag-danger">No puede eliminar</span>';
                $list[] = array(
                    "Acciones" => ($datos[$i]['Usuario'] != "ADMIN") ?
                        '<div class="btn-group"> 

                                    <button class="btn btn-info dropdown-toggle btn-sm" data-toggle="dropdown"
                                         aria-haspopup="true" aria-expanded="true"> <i class="icon-gear"> </i>
                                    </button>
                                    <div class="dropdown-menu">
                                    ' . $boton_eliminar . '
                                    ' . $boton_editar . '
                                   
                                    </div>

                                 </div>' :
                        '<div class="btn-group"> 
                                            <button class="btn btn-info dropdown-toggle btn-sm" data-toggle="dropdown"
                                                aria-haspopup="true" aria-expanded="true"> <i class="icon-gear"> </i>
                                            </button>
                                            <div class="dropdown-menu">
' . $boton_editar . '
                                            </div>
                                    </div>',


                    //   "Id"=>$datos[$i]['idUsuario'], //nombre de la tablas en la base de datos
                    "Usuario" => $datos[$i]['Usuario'], //nombre de la tablas en la base de datos
                    "Nombre" => $datos[$i]['NombreUsuario'],
                    "Rol" => $datos[$i]['Rol'],
                    "Estado" => $datos[$i]['EstadoUsuario'],
                    "Correo" => $datos[$i]['CorreoElectronico'],
                    // "FechaC"=>$datos[$i]['FechaCreacion'],
                    "Fecha" => $datos[$i]['FechaVencimiento'],



                );
            }

            $resultados = array(
                "sEcho" => 1,
                "iTotalRecords" => count($list),
                "iTotalDisplayRecords" => count($list),
                "aaData" => $list
            );
        }
        echo json_encode($resultados); //datos en formato json para la datatable

        break;


    case "obtener_usuario_por_id":
        if (isset($_POST["idUsuario"]) && !empty($_POST["idUsuario"])) {
            $data = $usu->ObtenerUsuarioPorId($_POST["idUsuario"]);
            if ($data) {
                $list[] = array(
                    "id" => $data['idUsuario'],
                    "rol" => $data['idRol'],
                    "usuario" => $data['Usuario'],
                    "nombre" => $data['NombreUsuario'],
                    "estado" => $data['idEstadoUsuario'],
                    "clave" => $data['Clave'],
                    "correo" => $data['CorreoElectronico'],

                );
                echo json_encode($list);
            }
        }

        break;

    case "listar_estados_select":

        if (isset($_POST["idUsuario"]) && !empty($_POST["idUsuario"])) {
            $datos = $usu->ListarEstadosEdit($_POST["idUsuario"]);
            if ($datos) {  //valida que traiga datos
                for ($i = 0; $i < count($datos); $i++) {
                    $list[] = array(  //se pone los campos que queremos guardar
                        "0" => $datos[$i]['idEstadoUsuario'],
                        "1" => $datos[$i]['Descripcion'],
                    );
                }
                echo json_encode($list); //se devuelve los datos en formato json 
            }
        }


        break;

    case "registrar_usuario":
        if (
            isset($_POST["Usuario"], $_POST["idRol"], $_POST["NombreUsuario"], $_POST["CorreoElectronico"], $_POST["Clave"], $_POST["ConfirmarClave"])
            && !empty($_POST["Usuario"]) && !empty($_POST["idRol"]) && !empty($_POST["NombreUsuario"]) && !empty($_POST["CorreoElectronico"])
            && !empty($_POST["Clave"]) && !empty($_POST["ConfirmarClave"])
        ) {
          
            if ((strpos($_POST["CorreoElectronico"], '@gmail.com') !== false || strpos($_POST["CorreoElectronico"], '@yahoo.com') !== false) && strpos($_POST["CorreoElectronico"], '@') > 0) {
                if ($_POST["Clave"] == $_POST["ConfirmarClave"]) {

                    $Usuario = $_POST["Usuario"];
                    $idRol = $_POST["idRol"];
                    $NombreUsuario = $_POST["NombreUsuario"];
                    $EstadoUsuario = 1;
                    $CorreoElectronico = $_POST["CorreoElectronico"];
                    $Clave = $_POST["Clave"];
                    $CreadoPor = $_SESSION["user"]["Usuario"];
                    $fecha_actual =  date('Y-m-d'); //almacena la fecha actual
                    $dias = $usu->DiasVencimiento(); //trae la cantidad de dias
                    foreach ($dias as $campos => $valor) {
                        $DIASPARAMETRO["valores"][$campos] = $valor; //ALMACENA LA CANTIDAD DE dias de vencimiento DEL USUARIO
                    }

                    $FechaVencimiento = date("Y-m-d", strtotime($fecha_actual . "+" . ($DIASPARAMETRO["valores"]["Valor"]) . " days"));

                    $minima = $usu->ClaveMinima(); //TRAE EL PARAMETRO DE INTENTOS
                    foreach ($minima as $campos => $valor) {
                        $CLAVEMINIMA["valores"][$campos] = $valor; //ALMACENA EL numero de intentos DE INTENTOS
                    }
                    $maximo = $usu->ClaveMaxima(); //TRAE EL PARAMETRO DE INTENTOS
                    foreach ($maximo as $campos => $valor) {
                        $CLAVEMAXIMA["valores"][$campos] = $valor; //ALMACENA EL numero de intentos DE INTENTOS
                    }


                    if ($usu->ValidarUsuarioRegistro($Usuario) == "existeUsuario") {

                        $response = "existeUsuario";
                    } else if ($usu->ValidarCorreoRegistro($CorreoElectronico) == "existeCorreo") {
                        $response = "existeCorreo";
                    } else if (strlen($_POST["Clave"]) < $CLAVEMINIMA["valores"]["Valor"]) {

                        $response = "claveminima";
                    } else if (strlen($_POST["Clave"]) > $CLAVEMAXIMA["valores"]["Valor"]) {

                        $response = "clavemaxima";
                    } else if (!preg_match('`[A-Z]`', $Clave)) { //valida que la clave contenga una mayuscula

                        $response = "mayuscula";
                    } else if (!preg_match('`[a-z]`', $Clave)) { //valida que la clave contenga una minuscula

                        $response = "minuscula";
                    } else if (!preg_match('`[0-9]`', $Clave)) { //valida que la clave contenga un numero

                        $response = "numero";
                    } else if (!preg_match('`[_#@$&%]`', $Clave)) { //valida que la clave contenga caracteres especiales

                        $response = "caracteres";
                    } else {
                        //correo de confirmacion
                        require('../Model/Mailer.php');
                        $mailer = new Mailer();
                        $asunto = "Bienvenido A Fondo Revolvente";
                        $cuerpo = "Estimado $NombreUsuario se le a creado una cuenta de usuario
                        <br>DATOS DE ACCESO:<br>USUARIO :$Usuario<br>CONTRASEÑA :$Clave
                        <br>Inicia sesión aquí http://localhost/ADEPES/";

                        if($mailer->enviarEmailRegistro($CorreoElectronico,$asunto, $cuerpo) ){
                            if($usu->RegistrarUsuario($Usuario, $idRol, $NombreUsuario, $EstadoUsuario, $CorreoElectronico, $Clave, $CreadoPor, $FechaVencimiento)
                            &&  $usu->RegistrarBitacora( $_SESSION["user"]["idUsuario"], 3,"Inserto", "Creo el usuario: ".$Usuario)){
                               
                                $response = "success";  //si se inserto en la BD y se envio el correo manda mensaje de exitos
                            
 
							}
                   
                        }else{
                            $response = "errorCorreo_NO_AUTENTICADO";
                         
                        }
                    }
                } else {
                    $response = "ClaveDistinta";
                }
            } else {
                $response = "dominio";
            }
        } else {
            $response = "requerid"; //validad que ingresa todo los datos requeridos
        }

        echo $response;

        break;

    case "actualizar_usuario":
        if (
            isset($_POST["Usuario"], $_POST["idUsuario"], $_POST["NombreUsuario"], $_POST["CorreoElectronico"], $_POST["idRol"], $_POST["idEstadoUsuario"])
            && !empty($_POST["Usuario"]) && !empty($_POST["idUsuario"]) && !empty($_POST["NombreUsuario"]) && !empty($_POST["CorreoElectronico"]) && !empty($_POST["idRol"])
            && !empty($_POST["idEstadoUsuario"])
        ) {
            //valida que el correo tenga un dominio correcto
            if (strpos($_POST["CorreoElectronico"], '@gmail.com') !== false || strpos($_POST["CorreoElectronico"], '@yahoo.com') !== false) {

                $idUsuario = $_POST["idUsuario"];
                $idRol = $_POST["idRol"];
                $idEstadoUsuario = $_POST["idEstadoUsuario"];
                $NombreUsuario = $_POST["NombreUsuario"];
                $CorreoElectronico = $_POST["CorreoElectronico"];
                $fecha_actualA =  date('Y-m-d'); //almacena la fecha actual
                $ModificadoPor = $_SESSION["user"]["Usuario"];


                if ($usu->ActualizarUsuario($idUsuario, $NombreUsuario, $CorreoElectronico, $idRol, $idEstadoUsuario, $ModificadoPor, $fecha_actualA)) {

                    $usu->RegistrarBitacora($_SESSION["user"]["idUsuario"], 3, "Modifico", "Actualizo al usuario: " . $NombreUsuario); //registro de bitacora

                    if ($usu->EliminarIntentosUsuario($idUsuario)) {
                        $response = "success";  //si se inserto en la BD manda mensaje de exito
                    }
                } else {
                    $response = "error";  //error al insertar en BD
                }
            } else {
                $response = "dominio"; //correo incorrecto
            }
        } else {
            $response = "requerid"; //validad que ingresa todo los datos requeridos
        }

        echo $response;

        break;

    case "eliminar_usuario":
        if (isset($_POST["idUsuario"]) && !empty($_POST["idUsuario"])) {

            $eliminar = $usu->EliminarUsuario($_POST["idUsuario"]);
            if ($eliminar == "elimino") {
                $usu->RegistrarBitacora($_SESSION["user"]["idUsuario"], 3, "Elimino", "Elimino un usuario con id: ".$_POST["idUsuario"]);
                $response = "success";
            } else if ($eliminar = "23000") {
                $usu->ActualizarUsuarioInactivo($_POST["idUsuario"]);
                $usu->RegistrarBitacora($_SESSION["user"]["idUsuario"], 3, "Elimino", "Inactivo el usuario con id: ".$_POST["idUsuario"]);
                $response = "inactivo";
            } else {
                $response = "error";
            }
        } else {
            $response = "error";
        }
        echo $response;


        break;


        case "registrarEventoBitacora":
            if( isset($_POST["evento"]) && !empty($_POST["evento"]) ){
      
               if($_POST["evento"] == 1){  //evento reporte
                    if( $usu->RegistrarBitacora($_SESSION["user"]["idUsuario"], 3, "Reporte", "Imprimió el reporte de LISTADO DE LISTADO DE USUARIOS")){
                        $response ="success";  
      
                    }else{
                        $response = "error";  //cualquier otro tipo de error
                    }
      
               }else if($_POST["evento"] == 2){ //evento filtro
                    if(   $usu->RegistrarBitacora($_SESSION["user"]["idUsuario"], 3, "Filtrar", "Realizo consulta de filtros en LISTADO DE USUARIOS")){
                        $response ="success";  
      
                    }else{
                        $response = "error";  //cualquier otro tipo de error
                    }
               }
                
               
      
            }else{
               $response = "error";
            }
            echo $response;
         
         break;
}


//
