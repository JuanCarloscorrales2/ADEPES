<?php 
  require "../model/BitacoraModel.php";
  session_start();
  //instancia de la clase rol
  $bitacora = new Bitacora();

  switch($_REQUEST["operador"]){

    case "listar_Bitacora":
        $resultados = array(
            "sEcho" => 0,
            "iTotalRecords" => 0,
            "iTotalDisplayRecords" => 0,
            "aaData" => []
        );
        $datos = $_SESSION["consultar"] >= 1 ? $bitacora->ListarBitacora() : [];
        if($datos){
            for($i=0; $i<count($datos); $i++){
                $list[] = array(
                    "USUARIO"=>$datos[$i]['Usuario'], //nombre de la tablas en la base de datos
                    "OBJETO"=>$datos[$i]['Objeto'],
                    "ACCION"=>$datos[$i]['Accion'],
                    "DESCRIPCION"=>$datos[$i]['Descripcion'],
                    "FECHA"=>$datos[$i]['Fecha'],
                    

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

    case "listar_Bitacora_porFecha":

        $fechaInicio = isset($_GET['fechaInicio']) ? $_GET['fechaInicio'] : null;
        $fechaFinal = isset($_GET['fechaFinal']) ? $_GET['fechaFinal'] : null;
    
        $resultados = array(
            "sEcho" => 0,
            "iTotalRecords" => 0,
            "iTotalDisplayRecords" => 0,
            "aaData" => []
        );
        $datos = $_SESSION["consultar"] >= 1 ? $bitacora->FiltrarPorFecha($fechaInicio, $fechaFinal) : [];
        if($datos){
            for($i=0; $i<count($datos); $i++){
                $list[] = array(
                    "USUARIO"=>$datos[$i]['Usuario'], //nombre de la tablas en la base de datos
                    "OBJETO"=>$datos[$i]['Objeto'],
                    "ACCION"=>$datos[$i]['Accion'],
                    "DESCRIPCION"=>$datos[$i]['Descripcion'],
                    "FECHA"=>$datos[$i]['Fecha'],
                    

                );

            }
          
            $resultados = array(
                "sEcho" =>1,
                "iTotalRecords" => count($list),
                "iTotalDisplayRecords" => count($list),
                "aaData" =>$list
            );
            $bitacora->RegistrarBitacora($_SESSION["user"]["idUsuario"], 31, "Filtrar", "Realizo consulta por rango de fechas");
        }

        echo json_encode($resultados); //datos en formato json para la datatable
    
        break;

        case "registrarEventoBitacora":
            if( isset($_POST["evento"]) && !empty($_POST["evento"]) ){
      
               if($_POST["evento"] == 1){  //evento reporte
                    if(  $bitacora->RegistrarBitacora($_SESSION["user"]["idUsuario"], 31, "Reporte", "Imprimió el reporte de LISTADO DE REGISTROS DE BITÁCORA DEL SISTEMA")){
                        $response ="success";  
      
                    }else{
                        $response = "error";  //cualquier otro tipo de error
                    }
      
               }else if($_POST["evento"] == 2){ //evento filtro
                    if(  $bitacora->RegistrarBitacora($_SESSION["user"]["idUsuario"], 31, "Filtrar", "Realizo consulta en el filtro general")){
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



?>