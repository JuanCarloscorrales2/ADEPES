<?php
require "../model/Permisos.php";
require "../model/BitacoraModel.php";
session_start();
//instancia de la clase rol
$permiso = new Permisos();
 //bitacora
 $bita = new Bitacora();
switch ($_REQUEST["operador"]) {

    case "listar_permisos":
        $resultados = array(
            "sEcho" => 0,
            "iTotalRecords" => 0,
            "iTotalDisplayRecords" => 0,
            "aaData" => []
        );
        //$datos = $permiso->ListarPermisos(); //obtiene los datos del metodo
        $datos = $_SESSION["consultar"] >= 1 ?  $permiso->ListarPermisos() : [];
        if ($datos) {
            for ($i = 0; $i < count($datos); $i++) {
                $list[] = array(
                    "Id" => $datos[$i]['idPermiso'], //nombre de la tablas en la base de datos
                    "Rol" => $datos[$i]['Rol'], //nombre de la tablas en la base de datos
                    "Objeto" => $datos[$i]['Objeto'],
                    "Insertar" => $datos[$i]['insertar'] >= 1 ? '<span class="tag tag-success">Sí</span>' : '<span class="tag tag-warning">No</span>',
                    "Eliminar" => $datos[$i]['eliminar'] >= 1 ? '<span class="tag tag-success">Sí</span>' : '<span class="tag tag-warning">No</span>',
                    "Consultar" => $datos[$i]['consultar'] >= 1 ? '<span class="tag tag-success">Sí</span>' : '<span class="tag tag-warning">No</span>',
                    "Actualizar" => $datos[$i]['actualizar'] >= 1 ? '<span class="tag tag-success">Sí</span>' : '<span class="tag tag-warning">No</span>',

                    "Reportes" => $datos[$i]['reportes'] >= 1 ? '<span class="tag tag-success">Sí</span>' : '<span class="tag tag-warning">No</span>',

                    "Acciones" => '<div class="btn-group"> 
                                    <button class="btn btn-info dropdown-toggle btn-sm" data-toggle="dropdown"
                                         aria-haspopup="true" aria-expanded="true"> <i class="icon-gear"> </i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <button class="dropdown-item"  data-toggle="modal" data-target="#Actualizarpermiso" onclick="ObtenerPermisoPorId(' . $datos[$i]['idPermiso'] . ",'editar',". $datos[$i]['idRol']. ');"><i class="icon-edit"
                                        ></i> Editar </button>
                                        <button class="dropdown-item" onclick="eliminar_permiso(' . $datos[$i]['idPermiso'] . "" . ');"><i class="icon-trash"
                                        ></i> Eliminar </button>
                                 </div>'






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


    case "listar_roles_select":


        $datos = $permiso->ListarRoles();
        if ($datos) {  //valida que traiga datos
            for ($i = 0; $i < count($datos); $i++) {
                $list[] = array(  //se pone los campos que queremos guardar
                    "0" => $datos[$i]['idRol'],
                    "1" => $datos[$i]['Rol'],
                );
            }
            echo json_encode($list); //se devuelve los datos en formato json 
        }


        break;

    case "listar_objetos_select":

        $esModulo = $_REQUEST["solo_modulos"];

        $esActualizacion = isset($_REQUEST["actualizacion"]) ? 'a' : '';
        $idObjeto = isset($_REQUEST["actualizacion"]) ? $_REQUEST["objeto"] : '';
        $datos = $permiso->ListarObjetos($esModulo, $idObjeto);
        if ($datos) {  //valida que traiga datos
            for ($i = 0; $i < count($datos); $i++) {
                if ($esModulo) {
                    $list[] = array(  //se pone los campos que queremos guardar
                        "id" => $datos[$i]['idObjetos'],
                        "objeto" => $datos[$i]['Objeto'],
                        "ver" =>
                        '<div class="switchToggle">' .
                            '<input type="checkbox" id="switchver' . $esActualizacion . $datos[$i]['idObjetos'] . '"  onclick="chequear_permiso(event,\'ver\',' . $datos[$i]['idObjetos'] . ')">' .
                            '<label for="switchver' .  $esActualizacion . $datos[$i]['idObjetos'] . '">Toggle</label>' .
                            '</div>',
                        "insertar" =>  '<div class="switchToggle">' .
                            '<input type="checkbox" id="switchinsertar' . $esActualizacion . $datos[$i]['idObjetos'] . '"  onclick="chequear_permiso(event,\'insertar\',' . $datos[$i]['idObjetos'] . ')">' .
                            '<label for="switchinsertar' .  $esActualizacion . $datos[$i]['idObjetos'] . '">Toggle</label>' .
                            '</div>',
                        "actualizar" =>  '<div class="switchToggle">' .
                            '<input type="checkbox" id="switchactualizar' . $esActualizacion . $datos[$i]['idObjetos'] . '"  onclick="chequear_permiso(event,\'actualizar\',' . $datos[$i]['idObjetos'] . ')">' .
                            '<label for="switchactualizar' .  $esActualizacion . $datos[$i]['idObjetos'] . '">Toggle</label>' .
                            '</div>',
                            "reportes" =>  '<div class="switchToggle">' .
                            '<input type="checkbox" id="switchreportes' . $esActualizacion . $datos[$i]['idObjetos'] . '"  onclick="chequear_permiso(event,\'reportes\',' . $datos[$i]['idObjetos'] . ')">' .
                            '<label for="switchreportes' .  $esActualizacion . $datos[$i]['idObjetos'] . '">Toggle</label>' .
                            '</div>',
                        "eliminar" =>  '<div class="switchToggle">' .
                            '<input type="checkbox" id="switcheliminar' . $esActualizacion . $datos[$i]['idObjetos'] . '" onclick="chequear_permiso(event,\'eliminar\',' . $datos[$i]['idObjetos'] . ')">' .
                            '<label for="switcheliminar' . $esActualizacion . $datos[$i]['idObjetos'] . '">Toggle</label>' .
                            '</div>',
                    );
                } else {
                    $list[] = array(  //se pone los campos que queremos guardar
                        "0" => $datos[$i]['idObjetos'],
                        "1" => $datos[$i]['Objeto'],
                    );
                }
            }
            if ($esModulo) {
                $resultados = array(
                    "sEcho" => 1,
                    "iTotalRecords" => count($list),
                    "iTotalDisplayRecords" => count($list),
                    "aaData" => $list
                );
                echo json_encode($resultados);
            } else {

                echo json_encode($list); //se devuelve los datos en formato json 
            }
        } else {
            $resultados = array(
                "sEcho" => 0,
                "iTotalRecords" => 0,
                "iTotalDisplayRecords" => 0,
                "aaData" => []
            );
        }


        break;



    case "registrar_permiso":
        if (isset($_POST["rol"], $_POST["objeto"], $_POST["insertar"], $_POST["eliminar"], $_POST["consultar"], $_POST["actualizar"]) && !empty($_POST["rol"]) && !empty($_POST["objeto"]) && !empty($_POST["insertar"]) && !empty($_POST["eliminar"]) && !empty($_POST["consultar"]) && !empty($_POST["actualizar"])) {
            $rol = $_POST["rol"];
            $objeto = $_POST["objeto"];
            $insertar = $_POST["insertar"];
            $eliminar = $_POST["eliminar"];
            $consultar = $_POST["consultar"];
            $actualizar = $_POST["actualizar"];
            $reportes = $_POST["reportes"];
            if ($permiso->RegistrarPermiso($rol, $objeto, $insertar, $eliminar, $consultar, $actualizar,$reportes )) {
                $bita->RegistrarBitacora($_SESSION["user"]["idUsuario"], 27, "Inserto", "Inserto nuevo permiso al rol con id: ".$rol);
                $response = "success";  //si se inserto en la BD manda mensaje de exito
            } else {
                $response = "error";
            }
        } else {
            $response = "requerid"; //validad que ingresa todo los datos requeridos
        }

        echo $response;


        break;

    case "actualizar_permiso":
        if (isset($_POST["id"], $_POST["rol"], $_POST["objeto"], $_POST["insertar"], $_POST["eliminar"], $_POST["consultar"], $_POST["actualizar"],$_POST["reportes"]) && !empty($_POST["rol"]) && !empty($_POST["objeto"]) && !empty($_POST["insertar"]) && !empty($_POST["eliminar"]) && !empty($_POST["consultar"]) && !empty($_POST["actualizar"])&&!empty($_POST["reportes"])) {
            $rol = $_POST["rol"];
            $objeto = $_POST["objeto"];
            $insertar = $_POST["insertar"];
            $eliminar = $_POST["eliminar"];
            $consultar = $_POST["consultar"];
            $actualizar = $_POST["actualizar"];
            $reportes = $_POST["reportes"];
            if ($permiso->ActualizarPermiso($_POST["id"], $rol, $objeto, $insertar, $eliminar, $consultar, $actualizar,$reportes)) {
                $bita->RegistrarBitacora($_SESSION["user"]["idUsuario"], 27, "Modifico", "Modificó el permiso del rol: ".$rol);
                $response = "success";  //si se inserto en la BD manda mensaje de exito
            } else {
                $response = "error";
            }
        } else {
            $response = "requerid"; //validad que ingresa todo los datos requeridos
        }

        echo $response;


        break;

    case "obtener_permiso_por_id":
        if (isset($_POST["idPermiso"]) && !empty($_POST["idPermiso"])) {
            $data = $permiso->ObtenerPermisoPorId($_POST["idPermiso"]);
            if ($data) {
                $list[] = array(
                    "idPermiso" => $data['idPermiso'],
                    "Rol" => $data['idRol'],
                    "idObjeto" => $data['idObjetos'],
                    "Objeto" => $data['Objeto'],
                    "Insertar" => $data['insertar'],
                    "Eliminar" => $data['eliminar'],
                    "Consultar" => $data['consultar'],
                    "Reportes" => $data['reportes'],
                    "Actualizar" => $data['actualizar'],

                );
                echo json_encode($list);
            }
        }

        break;
    case "eliminar_permiso":
        if (isset($_POST["id"]) && !empty($_POST["id"])) {
            if ($permiso->EliminarPermiso($_POST["id"])) {
                $bita->RegistrarBitacora($_SESSION["user"]["idUsuario"], 27, "Elimino", "Elimino un permiso");
                $response = "success";  //si se inserto en la BD manda mensaje de exito
            } else {
                $response = "error";
            }
        } else {
            $response = "requerid"; //validad que ingresa todo los datos requeridos
        }

        echo $response;


        break;

    case "listar_roles_select_edit":

        if (isset($_POST["idPermiso"]) && !empty($_POST["idPermiso"])) {
            $datos = $permiso->ListarRolesSelectEdit($_POST["idPermiso"]);
            if ($datos) {  //valida que traiga datos
                for ($i = 0; $i < count($datos); $i++) {
                    $list[] = array(  //se pone los campos que queremos guardar
                        "0" => $datos[$i]['idRol'],
                        "1" => $datos[$i]['Rol'],
                    );
                }
                echo json_encode($list); //se devuelve los datos en formato json 
            }
        }


        break;


        case "registrarEventoBitacora":
            if( isset($_POST["evento"]) && !empty($_POST["evento"]) ){
      
               if($_POST["evento"] == 1){  //evento reporte
                    if(  $bita->RegistrarBitacora($_SESSION["user"]["idUsuario"], 27, "Reporte", "Imprimió el reporte de LISTADO DE PERMISOS")){
                        $response ="success";  
      
                    }else{
                        $response = "error";  //cualquier otro tipo de error
                    }
      
               }else if($_POST["evento"] == 2){ //evento filtro
                    if(  $bita->RegistrarBitacora($_SESSION["user"]["idUsuario"], 27, "Filtrar", "Realizo consulta de filtros en LISTADO DE PERMISOS")){
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

        //fin switch

}
