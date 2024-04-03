<?php
require "../model/parametros.php";
require "../model/BitacoraModel.php";
date_default_timezone_set('America/Tegucigalpa');
session_start();
//instancia de la clase rol
$parametros = new Parametro();
//bitacora
$bita = new Bitacora();

switch ($_REQUEST["operador"]) {

    case "listar_parametros":
        $resultados = array(
            "sEcho" => 0,
            "iTotalRecords" => 0,
            "iTotalDisplayRecords" => 0,
            "aaData" => []
        );
        $datos = $_SESSION["consultar"] >= 1 ? $parametros->ListarParametros() : [];
        if ($datos) {
            for ($i = 0; $i < count($datos); $i++) {
                $boton_editar = $_SESSION["actualizar"] >= 1 ? ' <a class="dropdown-item" data-toggle="modal" data-target="#ActualizarParametro" 
                onclick="ObtenerParametroPorId(' . $datos[$i]['idParametro'] . ",'editar'" . ');"><i class="icon-edit"></i> Editar </a>
 ' : '<span class="tag tag-warning">No puede editar</span>';
                $list[] = array(
                    "IDSECUENCIAL"=>$datos[$i]['numero_secuencial'],
                    "Id" => $datos[$i]['idParametro'], //nombre de la tablas en la base de datos
                    "parametro" => $datos[$i]['Parametro'], //nombre de la tablas en la base de datos
                    "valor" => $datos[$i]['Valor'],
                    "Fecha" => $datos[$i]['FechaCreacion'],
                    "FechaM" => $datos[$i]['FechaModificacion'],
                    "Acciones" => '<div class="btn-group"> 
                                    <button class="btn btn-info dropdown-toggle btn-sm" data-toggle="dropdown"
                                         aria-haspopup="true" aria-expanded="true"> <i class="icon-gear"> </i>
                                    </button>
                                    <div class="dropdown-menu">
                                       ' . $boton_editar . '
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



    case "obtener_parametro_por_id":
        if (isset($_POST["idParametro"]) && !empty($_POST["idParametro"])) {
            $data = $parametros->ObtenerParametroPorId($_POST["idParametro"]);
            if ($data) {
                $list[] = array(
                    "Id" => $data['idParametro'],
                    "parametro" => $data['Parametro'],
                    "valor" => $data['Valor']

                );
                echo json_encode($list);
            }
        }

        break;


        case "actualizar_parametro":
            if( isset($_POST["idParametro"] ,$_POST["Valor"] ) && !empty($_POST["idParametro"]) && !empty($_POST["Valor"])){
                   
                    $idParametro = $_POST["idParametro"];
                    $Valor = $_POST["Valor"];
                    $FechaModificacion = date('Y-m-d');
    
                    if($datoP =  $parametros->tipoDatoParametro($idParametro ) ){
                        foreach ($datoP as $campos => $valor){
                            $tipoDato["valores"][$campos] = $valor; //ALMACENA EL tipo de dato
                        }
                    }
    
                    
    
                    if($cantidadP =  $parametros->cantidadPreguntas() ){
                        foreach ($cantidadP as $campos => $valor){
                            $cant["valores"][$campos] = $valor; //ALMACENA la cantidad de preguntas
                        }
                    }
                    $preguntas = $cant["valores"]["cantidad"];
    
    
                    if($idParametro == 10 ){  //valida que el parametro de correo acepte numero
                        if( $parametros->ActualizarParametro($idParametro, $Valor, $FechaModificacion ) ){
                            $bita->RegistrarBitacora($_SESSION["user"]["idUsuario"], 28, "Modifico", "Modificó el parámetro con id: ".$idParametro." con valor: ".$Valor);
                            $response = "success";  //si se inserto en la BD manda mensaje de exito
                       
                        }else{
                            $response = "error";  //error al insertar en BD
                        }
    
                    }else if(!preg_match('/^(?=.*[1-9])\d*\.?\d+$/', $Valor)&& $tipoDato["valores"]["idTipoDato"] == 2){ //solo numero
                       
                        $response = "soloNumero"; 
    
                    }else if(!preg_match('/^[a-zA-Z\s]+$/', $Valor) && $tipoDato["valores"]["idTipoDato"] == 1){ //solo letra 
                        $response = "soloLetra";
    
                    }else if($idParametro == 2 && $Valor > $preguntas){ //solo letra 
                        $response = "excedePreguntas";
    
                    }else{
                        
                        if( $parametros->ActualizarParametro($idParametro, $Valor, $FechaModificacion ) ){
                            $bita->RegistrarBitacora($_SESSION["user"]["idUsuario"], 28, "Modifico", "Modificó el parámetro con id: ".$idParametro." con valor: ".$Valor);
                            $response = "success";  //si se inserto en la BD manda mensaje de exito
                       
                        }else{
                            $response = "error";  //error al insertar en BD
                        }
                    }
    
                
                
                    
               
            }else{
                $response = "requerid"; //validad que ingresa todo los datos requeridos
            }
    
            echo $response;
    
        break;

        case "registrarEventoBitacora":
            if( isset($_POST["evento"]) && !empty($_POST["evento"]) ){
      
               if($_POST["evento"] == 1){  //evento reporte
                    if(  $bita->RegistrarBitacora($_SESSION["user"]["idUsuario"], 28, "Reporte", "Imprimió el reporte de LISTADO DE PARÁMETRO")){
                        $response ="success";  
      
                    }else{
                        $response = "error";  //cualquier otro tipo de error
                    }
      
               }else if($_POST["evento"] == 2){ //evento filtro
                    if(  $bita->RegistrarBitacora($_SESSION["user"]["idUsuario"], 28, "Filtrar", "Realizo consulta de filtros en LISTADO DE PARÁMETRO")){
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
