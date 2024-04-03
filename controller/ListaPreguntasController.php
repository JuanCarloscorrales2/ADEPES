<?php
require "../model/ListaPreguntas.php";
require "../model/BitacoraModel.php";
session_start();
//instancia de la clase rol
$pregunta = new Preguntas();
//bitacora
$bita = new Bitacora();

switch ($_REQUEST["operador"]) {

    case "listar_preguntas":
        $resultados = array(
            "sEcho" => 0,
            "iTotalRecords" => 0,
            "iTotalDisplayRecords" => 0,
            "aaData" => []
        );
        $datos = $_SESSION["consultar"] >= 1 ? $pregunta->ListarPreguntas() : [];
        if ($datos) {
            for ($i = 0; $i < count($datos); $i++) {
                $boton_editar = $_SESSION["actualizar"] >= 1 ? '<a class="dropdown-item" data-toggle="modal" data-target="#ActualizarPregunta"
                onclick="ObtenerPreguntaPorId(' . $datos[$i]['idPregunta'] . ",'editar'" . ');">
                <i class="icon-edit"></i> Editar </a>' : '<span class="tag tag-warning">No puede editar</span>';
                $boton_eliminar = $_SESSION["eliminar"] >= 1 ? '<a class="dropdown-item" onclick="ObtenerPreguntaPorId(' . $datos[$i]['idPregunta'] . ",'eliminar'" . ');"><i class="icon-trash"></i> Eliminar </a>'
                    : '<span class="tag tag-danger">No puede eliminar</span>';
                $list[] = array(
                    "idP" => $datos[$i]['idPregunta'], //nombre de la tablas en la base de datos
                    "Pregunta" => $datos[$i]['Pregunta'], //nombre de la tablas en la base de datos

                    "Acciones" => '<div class="btn-group"> 
                                    <button class="btn btn-info dropdown-toggle btn-sm" data-toggle="dropdown"
                                         aria-haspopup="true" aria-expanded="true"> <i class="icon-gear"> </i>
                                    </button>
                                    <div class="dropdown-menu">
' . $boton_editar . '
' . $boton_eliminar . '    
                                    </div>
                                 </div>',

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

    case "registrar_pregunta":
        if (isset($_POST["Pregunta"]) && !empty($_POST["Pregunta"])) {
            $preguntas = $_POST["Pregunta"];

            if ($pregunta->RegistrarPregunta($preguntas)) {
                $bita->RegistrarBitacora($_SESSION["user"]["idUsuario"], 29, "Inserto", "Inserto la pregunta: ".$preguntas);
                $response = "success";  //si se inserto en la BD manda mensaje de exito
            } else {
                $response = "error";
            }
        } else {
            $response = "requerid"; //validad que ingresa todo los datos requeridos
        }

        echo $response;


        break;




    case "obtener_pregunta_por_id":
        if (isset($_POST["idPregunta"]) && !empty($_POST["idPregunta"])) {
            $data = $pregunta->ObtenerPreguntaPorId($_POST["idPregunta"]);
            if ($data) {
                $list[] = array(
                    "id" => $data['idPregunta'],
                    "Pregunta" => $data['Pregunta'],

                );
                echo json_encode($list);
            }
        }

        break;



    case "actualizar_pregunta":
        if (isset($_POST["idPregunta"], $_POST["Pregunta"]) && !empty($_POST["idPregunta"]) && !empty($_POST["Pregunta"])) {

            $idPregunta = $_POST["idPregunta"];
            $Pregunta = $_POST["Pregunta"];

            if ($pregunta->ActualizarPregunta($idPregunta, $Pregunta)) {
                $bita->RegistrarBitacora($_SESSION["user"]["idUsuario"], 29, "Modifico", "Modificó la pregunta con id: ".$idPregunta." nuevo valor: ".$Pregunta);
                $response = "success";  //si se inserto en la BD manda mensaje de exito

            } else {
                $response = "error";  //error al insertar en BD
            }
        } else {
            $response = "requerid"; //validad que ingresa todo los datos requeridos
        }

        echo $response;

        break;


    case "eliminar_pregunta":
        if (isset($_POST["idPregunta"]) && !empty($_POST["idPregunta"])) {

            $eliminar = $pregunta->EliminarPregunta($_POST["idPregunta"]);
            if ($eliminar == "elimino") {
                $bita->RegistrarBitacora($_SESSION["user"]["idUsuario"], 29, "Elimino", "Elimino una pregunta de seguridad");
                $response = "success";  //si elimino correctamente

            } else if ($eliminar == "Llave en uso") {  //si la llave ya esta en uso en otras tablas
                $bita->RegistrarBitacora($_SESSION["user"]["idUsuario"], 29, "Elimino", "Intento eliminar la pregunta con id: ".$_POST["idPregunta"]);
                $response = "llave_uso";
            } else {
                $response = "error";  //cualquier otro tipo de error
            }
        } else {
            $response = "error";
        }
        echo $response;

        break;

        case "registrarEventoBitacora":
            if( isset($_POST["evento"]) && !empty($_POST["evento"]) ){
        
               if($_POST["evento"] == 1){  //evento reporte
                    if(  $bita->RegistrarBitacora($_SESSION["user"]["idUsuario"], 29, "Reporte", "Imprimió el reporte de LISTADO DE PREGUNTAS DE SEGURIDAD")){
                        $response ="success";  
        
                    }else{
                        $response = "error";  //cualquier otro tipo de error
                    }
        
               }else if($_POST["evento"] == 2){ //evento filtro
                    if(  $bita->RegistrarBitacora($_SESSION["user"]["idUsuario"], 29, "Filtrar", "Realizo consulta de filtros en LISTADO DE PREGUNTAS DE SEGURIDAD")){
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
