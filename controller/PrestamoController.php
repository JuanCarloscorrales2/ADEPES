<?php
session_start(); //fuarda la sesion del usuario
require "../model/Clientes.php";
//instancia de la clase clientes modelo
$cli = new Cliente();

switch($_REQUEST["oper"]){

    case "listar_prestamos":
        $resultados = array(
            "sEcho" => 0,
            "iTotalRecords" => 0,
            "iTotalDisplayRecords" => 0,
            "aaData" => []
         );

        //$datos = $cli->ListarPrestamos(); //obtiene los datos del metodo
        $datos = $_SESSION["consultar"] >= 1 ?  $cli->ListarPrestamos() : [];
        $secuencia = 1;
        if($datos){
            for($i=0; $i<count($datos); $i++){
                $list[] = array(
                    "Acciones"=>'<div class="btn-group"> 
                                    <button class="btn btn-info dropdown-toggle btn-sm" data-toggle="dropdown"
                                         aria-haspopup="true" aria-expanded="true"> <i class="icon-gear"> </i>
                                    </button>
                                    <div class="dropdown-menu">
                                    <button class="dropdown-item" data-toggle="modal" data-target="#planPagos" 
                                    onclick="ObtenerClientePorId('.$datos[$i]['idPersona'].",'plan'".');"><i class="icon-book"></i> Plan de Pagos</button>
                                        
                                    </div>
                                 </div>', 
                    "IdSe" => $secuencia++, //numero secuencial
                    "idSolicitud"=>$datos[$i]['idSolicitud'],                
                    "idPersona"=>$datos[$i]['idPersona'],                       
                    "Nombre"=>$datos[$i]['Nombre'], //nombre de la tablas en la base de datos
                    "Prestamo"=>$datos[$i]['Prestamo'],
                    "Monto"=>$datos[$i]['Monto'],
                    "Desembolso"=>$datos[$i]['FechaAprob'],
                    "Plazo"=>$datos[$i]['Plazo'],
                    "Rubro"=>$datos[$i]['rubro'],
                    "Descripcion"=>$datos[$i]['Descripcion'],
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

    case "obtener_cliente_por_id":
        if( isset($_POST["idPersona"]) && !empty($_POST["idPersona"]) ){
            $data = $cli->ObtenerClientePorId($_POST["idPersona"]);
            if($data){
                foreach($data as $campos => $valor){
                    $_SESSION["Cliente"][$campos]=$valor;
                }
                $list[] = array(
                    "idS"=>$data['idSolicitud'],
                    "idP"=>$data['idPersona'],
                    "nombre"=>$data['nombres'],
                    "apellido"=>$data['apellidos'],
                    "identidad"=>$data['identidad'],
                    "telefono"=>$data['Telefono'],
                    "direccion"=>$data['Direccion'],
                    "monto"=>$data['Monto'],
                    "plazo"=>$data['Plazo'],
                    "fecha"=>$data['fechaDesembolso'],
                    "tasa"=>$data['tasa'],

                );
                echo json_encode($list);
            }
        }

    break;

    case "obtener_aval_por_id":
        if( isset($_POST["idSolicitud"]) && !empty($_POST["idSolicitud"]) ){
            $data = $cli->ObtenerAvalPorId($_POST["idSolicitud"]);
            if($data){
                foreach($data as $campos => $valor){
                    $_SESSION["Aval"][$campos]=$valor;
                }
             
                $list[] = array(
                    "idAval"=>$data['idAval'],
                    "idS"=>$data['idSolicitud'],
                    "idP"=>$data['idPersona'],
                    "nombre"=>$data['Nombre'],
                    "identidad"=>$data['identidad'],
                    "telefono"=>$data['Telefono'],
                    "direccion"=>$data['Direccion'],

                );
                echo json_encode($list);
            }
        }

    break;


    case "mostrar_planPagos":

        if(isset($_POST["idSolicitud"]) && !empty($_POST["idSolicitud"])){
            $data = $cli->PlanDePagos($_POST["idSolicitud"]);
            if($data){
             
                for($i=0; $i<count($data); $i++){
                    $list[]=array(  //se pone los campos que queremos guardar
                        "NumeroCuotas"=>$data[$i]['NumeroCuotas'],
                        "FechaCuota"=>$data[$i]['FechaCuota'],
                        "valorCuota"=>$data[$i]['valorCuota'],
                        "valorInteres"=>$data[$i]['valorInteres'],
                        "valorCapital"=>$data[$i]['valorCapital'],
                        "saldoCapital"=>$data[$i]['saldoCapital'],
                        "Descripcion"=>$data[$i]['Descripcion'],
                        
                    );
                }
                echo json_encode($list); //se devuelve los datos en formato json 

               
            }
        }
 
    break;


    



}

?>