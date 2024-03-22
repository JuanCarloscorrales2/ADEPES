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
 
    case "listar_Bitacora_Fecha":

        $datos = $bitacora->ListarBitacoraPorFecha(); //obtiene los datos del metodo
        if($datos){
            for($i=0; $i<count($datos); $i++){
                $list[] = array(
                    "USUARIO"=>$datos[$i]['Usuario'], //nombre de la tablas en la base de datos
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

        

    



  } //fin switch



?>