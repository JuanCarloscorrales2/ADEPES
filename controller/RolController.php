<?php 
  require "../model/Rol.php";
  require "../model/BitacoraModel.php";
  session_start();
  //instancia de la clase rol
  $roll = new Rol();
  //bitacora
  $bita = new Bitacora();

  switch($_REQUEST["operador"]){

    case "listar_roles":
        $resultados = array(
            "sEcho" =>0,
            "iTotalRecords" => 0,
            "iTotalDisplayRecords" =>0,
            "aaData" =>[]
        );
       
        $datos = $_SESSION["consultar"]>=1?$roll->ListarRoles():[]; //obtiene los datos del metodo
        $secuencia = 1;
        if($datos){
            for($i=0; $i<count($datos); $i++){
                $boton_editar=$_SESSION["actualizar"]>=1?'<a class="dropdown-item" data-toggle="modal" data-target="#actualizar_rol" 
                onclick="ObtenerRolPorId('.$datos[$i]['idRol'].",'editar'".');">
                <i class="icon-edit"></i> Editar </a>':'<span class="tag tag-warning">No puede editar</span>';
                $boton_eliminar=$_SESSION["eliminar"]>=1?' <a class="dropdown-item" onclick="ObtenerRolPorId('.$datos[$i]['idRol'].",'eliminar'".');"><i class="icon-trash"></i> Eliminar </a>'
                :'<span class="tag tag-danger">No puede eliminar</span>';
             
                $list[] = array(
                    "IdSe" => $secuencia++, //numero secuencial
                    "Id"=>$datos[$i]['idRol'], //nombre de la tablas en la base de datos
                    "Rol"=>$datos[$i]['Rol'], //nombre de la tablas en la base de datos
                    "Descripcion"=>$datos[$i]['Descripcion'],
                    "Fecha"=>$datos[$i]['FechaCreacion'],
                    "Acciones"=>'<div class="btn-group"> 
                                    <button class="btn btn-info dropdown-toggle btn-sm" data-toggle="dropdown"
                                         aria-haspopup="true" aria-expanded="true"> <i class="icon-gear"> </i>
                                    </button>
                                    <div class="dropdown-menu">
                                     '.$boton_editar.$boton_eliminar.'
                                   
                                    </div>
                                 </div>',
                    
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

    case "registrar_rol":
        if( isset($_POST["rol"],$_POST["descripcion"]) && !empty($_POST["rol"]) && !empty($_POST["descripcion"]) ){
            $rol = $_POST["rol"];
            $descripcion = $_POST["descripcion"];

            if( $roll->RegistrarRol($rol, $descripcion) ){
                $bita->RegistrarBitacora($_SESSION["user"]["idUsuario"], 9, "Inserto", "Inserto el rol: ".$rol);
               $response = "success";  //si se inserto en la BD manda mensaje de exito
            }else{
                $response = "error"; 
            }
        }else{
            $response = "requerid"; //validad que ingresa todo los datos requeridos
        }

        echo $response;


    break;

    case "listar_roles_select":

        
        $datos = $roll->ListarRoles();
        if($datos){  //valida que traiga datos
            for($i=0; $i<count($datos); $i++){
               $list[]=array(  //se pone los campos que queremos guardar
                  "0"=>$datos[$i]['idRol'],
                  "1"=>$datos[$i]['Rol'],
               );
            }
            echo json_encode($list); //se devuelve los datos en formato json 
        }

        
    break;

    case "listar_roles_select_edit":

        if(isset($_POST["idUsuario"]) && !empty($_POST["idUsuario"])){
            $datos = $roll->ListarRolesSelectEdit($_POST["idUsuario"]);
            if($datos){  //valida que traiga datos
                for($i=0; $i<count($datos); $i++){
                    $list[]=array(  //se pone los campos que queremos guardar
                        "0"=>$datos[$i]['idRol'],
                        "1"=>$datos[$i]['Rol'],
                    );
                }
                echo json_encode($list); //se devuelve los datos en formato json 
            }
        }

        
    break;
    
    
   

    case "obtener_rol_por_id":
        if( isset($_POST["idRol"]) && !empty($_POST["idRol"]) ){
            $data = $roll->ObtenerRolPorId($_POST["idRol"]);
            if($data){
                $list[] = array(
                    "id"=>$data['idRol'],
                    "rol"=>$data['Rol'],
                    "descripcion"=>$data['Descripcion']

                );
                echo json_encode($list);
            }
        }

    break;
  
    case "actualizar_rol":
        if( isset($_POST["idRol"],$_POST["Rol"],$_POST["Descripcion"]) 
            && !empty($_POST["idRol"]) && !empty($_POST["Rol"]) && !empty($_POST["Descripcion"])
             ){
               
                $idRol = $_POST["idRol"];
                $Rol = $_POST["Rol"];
                $Descripcion = $_POST["Descripcion"];
                
               if( $roll->ActualizarRol($idRol, $Rol, $Descripcion) ){
                $bita->RegistrarBitacora($_SESSION["user"]["idUsuario"], 9, "Modifico", "Modificó el rol: ".$Rol);
                    $response = "success";  //si se inserto en la BD manda mensaje de exito
               
                }else{
                    $response = "error";  //error al insertar en BD
                }    
           
        }else{
            $response = "requerid"; //validad que ingresa todo los datos requeridos
        }

        echo $response;

    break;

    case "eliminar_rol":
        if( isset($_POST["idRol"]) && !empty($_POST["idRol"]) ){
     
            $eliminar = $roll->EliminarRol($_POST["idRol"]);
           if( $eliminar == "elimino"){
                $bita->RegistrarBitacora($_SESSION["user"]["idUsuario"], 9, "Elimino", "Elimino el rol con id: ".$_POST["idRol"]);
                $response ="success";  //si elimino correctamente

           }else if($eliminar == "Llave en uso"){  //si la llave ya esta en uso en otras tablas
              $bita->RegistrarBitacora($_SESSION["user"]["idUsuario"], 9, "Elimino", "Intento eliminar el rol con id: ".$_POST["idRol"]);
              $response = "llave_uso";
           }else{
              $response = "error";  //cualquier otro tipo de error
           }

        }else{
           $response = "error";
        }
        echo $response;
     
     break;

     case "registrarEventoBitacora":
        if( isset($_POST["evento"]) && !empty($_POST["evento"]) ){
  
           if($_POST["evento"] == 1){  //evento reporte
                if(  $bita->RegistrarBitacora($_SESSION["user"]["idUsuario"], 9, "Reporte", "Imprimió el reporte de LISTADO DE ROLES")){
                    $response ="success";  
  
                }else{
                    $response = "error";  //cualquier otro tipo de error
                }
  
           }else if($_POST["evento"] == 2){ //evento filtro
                if(  $bita->RegistrarBitacora($_SESSION["user"]["idUsuario"], 9, "Filtrar", "Realizo consulta de filtros en LISTADO DE ROLES")){
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



  } //fin switch