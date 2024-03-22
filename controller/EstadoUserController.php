<?php
require "../model/EstadoUser.php";
session_start(); //fuarda la sesion del usuario
//instancia de la clase rol
$tablas = new Estado();

switch ($_REQUEST["operador"]) {

     /**************  VALIDACIONES TABLA ESTADO USUARIO*****************************************************************************/
    case "listar_ Estadousuario":

        $datos = $tablas->listarEstadousuario(); //obtiene los datos del metodo
        if($datos){
            for($i=0; $i<count($datos); $i++){
                $list[] = array(
                    "Acciones"=>'<div class="btn-group"> 
                    <button class="btn btn-info dropdown-toggle btn-sm" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="true"> <i class="icon-gear"> </i>
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" data-toggle="modal" data-target="#actualizar_EstadoUser" 
                        onclick="ObtenerEstadousuarioPorId('.$datos[$i]['idEstadoUsuario'].",'editar'".');">
                        <i class="icon-edit"></i> Editar </a>
                        
                        <a class="dropdown-item" onclick="ObtenerEstadousuarioPorId('.$datos[$i]['idEstadoUsuario'].",'eliminar'".');">
                        <i class="icon-trash"></i> Eliminar </a>
                        
                            
                        </div>
                    </div>',
                    "NO"=>$datos[$i]['idEstadoUsuario'], //nombre de la tablas en la base de datos
                    "ESTADOUSUARIO"=>$datos[$i]['Descripcion'],
                
                    
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


    case "obtener_estadousuario_por_id": //sirve para obtener el id para poder actualizar o eliminar
        if( isset($_POST["idEstadoUsuario"]) && !empty($_POST["idEstadoUsuario"]) ){
            $data = $tablas->ObtenerEstadousuarioPorId($_POST["idEstadoUsuario"]);
            if($data){
                $list[] = array(
                    "ID"=>$data['idEstadoUsuario'],  //nombres de la base de datos
                    "ESTADOUSUARIO"=>$data['Descripcion'],//nombres de la base de datos
                   
    
                );
                echo json_encode($list);
            }
        }
    
    break;

    case "actualizar_estadousuario":
        if( isset($_POST["idEstadoUsuario"],$_POST["Descripcion"])  && !empty($_POST["idEstadoUsuario"]) && !empty($_POST["Descripcion"]) ){
               
                $idEstadoUsuario = $_POST["idEstadoUsuario"];
                $Descripcion = $_POST["Descripcion"];
               
              
                if( $tablas->ActualizarEstadousuario($idEstadoUsuario, $Descripcion) ){
                    $response = "success";  //si se inserto en la BD manda mensaje de exito
               
                }else{
                    $response = "error";  //error al insertar en BD
                }    
           
        }else{
            $response = "requerid"; //validad que ingresa todo los datos requeridos
        }
    
        echo $response;
    
    break;  

    case "registrar_Estadousuario":
        if( isset($_POST["Descripcion"]) && !empty($_POST["Descripcion"])){
    
            $descripcion = $_POST["Descripcion"];
    
            if( $tablas->RegistrarEstadousuario($descripcion) ){
               $response = "success";  //si se inserto en la BD manda mensaje de exito
            }else{
                $response = "error"; 
            }
        }else{
            $response = "requerid"; //validad que ingresa todo los datos requeridos
        }
    
        echo $response;
    
    
    break;

    case "eliminar_Estadousuario":
        if( isset($_POST["idEstadoUsuario"]) && !empty($_POST["idEstadoUsuario"]) ){
     
            $eliminar = $tablas->EliminarEstadousuario($_POST["idEstadoUsuario"]);
           if( $eliminar == "elimino"){
                $response ="success";  //si elimino correctamente
    
           }else if($eliminar == "Llave en uso"){  //si la llave ya esta en uso en otras tablas
              $response = "llave_uso";
           }else{
              $response = "error";  //cualquier otro tipo de error
           }
    
        }else{
           $response = "error";
        }
        echo $response;
     
     break;
     
        



}

