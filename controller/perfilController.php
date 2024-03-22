<?php
session_start(); //fuarda la sesion del usuario
require "../model/perfil.php";
//instancia de la clase usuario modelo
$perfil = new Perfil();

switch($_REQUEST["operador"]){

    case "listar_usuarios":

        $datos = $perfil->ListarUsuarios(); //obtiene los datos del metodo
        if($datos){
            for($i=0; $i<count($datos); $i++){
                $list[] = array(
  
                 //   "Id"=>$datos[$i]['idUsuario'], //nombre de la tablas en la base de datos
                    "Usuario"=>$datos[$i]['Usuario'], //nombre de la tablas en la base de datos
                    "Nombre"=>$datos[$i]['NombreUsuario'],
                    "Correo"=>$datos[$i]['CorreoElectronico'],

                );

            }

            $resultados = array(
                "sEcho" =>1,
                "iTotalRecords" => count($list),
                "iTotalDisplayRecords" => count($list),
                "aaData" =>$list
            );
        }
        echo json_encode($resultados); //datos en formato json para la datatable

    break;

    case "obtener_usuario_por_id":
        if( isset($_POST["idUsuario"]) && !empty($_POST["idUsuario"]) ){
            $data = $perfil->ObtenerUsuarioPorId($_POST["idUsuario"]);
            if($data){
                $list[] = array(
                    "idusuario"=>$data['idUsuario'],
                    "Usuario"=>$data['Usuario'],
                    "nombre"=>$data['NombreUsuario'],
                    "Correo"=>$data['CorreoElectronico'],

                );
                echo json_encode($list);
            }
        }

    break;

    case "actualizar_usuario":
        if( isset($_POST["idUsuario"],$_POST["NombreUsuario"],$_POST["CorreoElectronico"]) 
             && !empty($_POST["idUsuario"]) && !empty($_POST["NombreUsuario"]) && !empty($_POST["CorreoElectronico"]) ){
             //valida que el correo tenga un dominio correcto
                    $idUsuario = $_POST["idUsuario"];
                    $NombreUsuario = $_POST["NombreUsuario"];
                    $CorreoElectronico = $_POST["CorreoElectronico"];

                    if( $perfil->ActualizarUsuario($idUsuario, $NombreUsuario, $CorreoElectronico) ){
                        
                        $response = "success";  //si se inserto en la BD manda mensaje de exito
                   
                    }else{
                        $response = "error";  //error al insertar en BD
                    }    
    
        }else{
            $response = "requerid"; //validad que ingresa todo los datos requeridos
        }

        echo $response;

    break;

   
}
    