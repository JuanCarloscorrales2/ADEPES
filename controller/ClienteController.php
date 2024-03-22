<?php
session_start(); //fuarda la sesion del usuario
require "../model/Clientes.php";
//instancia de la clase clientes modelo
$cli = new Cliente();

switch($_REQUEST["op"]){

    case "listar_clientes":
        $resultados = array(
            "sEcho" =>0,
            "iTotalRecords" => 0,
            "iTotalDisplayRecords" =>0,
            "aaData" =>[]
        );
        $datos = $_SESSION["consultar"]>=1? $cli->ListarClientes():[]; //obtiene los datos del metodo
        if($datos){
            for($i=0; $i<count($datos); $i++){
                $boton_editar=$_SESSION["actualizar"]>=1?   '<a class="dropdown-item" data-toggle="modal" data-target="#ActualizarCliente"
                onclick="ObtenerClientePorId('.$datos[$i]['idPersona'].",'editar'".');"><i class="icon-edit"></i> Editar </a>':'<span class="tag tag-warning">No puede editar</span>';
                $boton_eliminar=$_SESSION["eliminar"]>=1?'<a class="dropdown-item" onclick="ObtenerClientePorId('.$datos[$i]['idPersona'].",'eliminar'".');"><i class="icon-trash"></i> Eliminar </a> ':'<span class="tag tag-danger">No puede eliminar</span>';
             
                $list[] = array(
                    "Acciones"=>'<div class="btn-group"> 
                                    <button class="btn btn-info dropdown-toggle btn-sm" data-toggle="dropdown"
                                         aria-haspopup="true" aria-expanded="true"> <i class="icon-gear"> </i>
                                    </button>
                                    <div class="dropdown-menu">
                                   '.$boton_editar.'
                                   <!-- <a class="dropdown-item"><i class="icon-eye"></i> Ver préstamos </a> -->
                                    '.$boton_eliminar.'
                                    </div>
                                 </div>', 
                    "idSolicitud"=>$datos[$i]['idSolicitud'],                
                    "idPersona"=>$datos[$i]['idPersona'],                       
                    "Nombre"=>$datos[$i]['Nombre'], //nombre de la tablas en la base de datos
                    "Identidad"=>$datos[$i]['identidad'], //nombre de la tablas en la base de datos
                    "Genero"=>$datos[$i]['genero'],
                    "Contacto"=>$datos[$i]['Telefono'],
                    "Direccion"=>$datos[$i]['Direccion'],
                    "Profesion"=>$datos[$i]['Profesion'],
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
                    "fecha"=>$data['FechaAprob'],
                    "tasa"=>$data['tasa'],

                );
                echo json_encode($list);
            }
        }

    break;

    case "actualizar_cliente":
        if( isset($_POST["idPersona"],$_POST["nombres"],$_POST["apellidos"],$_POST["contacto"],$_POST["direccion"]) 
            && !empty($_POST["idPersona"]) && !empty($_POST["nombres"]) && !empty($_POST["apellidos"]) && !empty($_POST["contacto"]) && !empty($_POST["direccion"]) ){
               
                $idPersona = $_POST["idPersona"];
                $nombres = $_POST["nombres"];
                $apellidos = $_POST["apellidos"];
                $contacto = $_POST["contacto"];
                $direccion = $_POST["direccion"];
                if( $cli->ActualizarCliente($idPersona, $nombres, $apellidos, $contacto, $direccion) ){
                    $response = "success";  //si se inserto en la BD manda mensaje de exito
               
                }else{
                    $response = "error";  //error al insertar en BD
                }    
           
        }else{
            $response = "requerid"; //validad que ingresa todo los datos requeridos
        }

        echo $response;

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

    case "eliminar_cliente":
        if( isset($_POST["idPersona"]) && !empty($_POST["idPersona"]) ){
     
            $eliminar = $cli->EliminarCliente($_POST["idPersona"]);
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
