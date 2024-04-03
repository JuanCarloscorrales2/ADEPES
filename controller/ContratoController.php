<?php
session_start(); //fuarda la sesion del usuario
require "../model/Contrato.php";
date_default_timezone_set('America/Tegucigalpa');
//instancia de la clase usuario modelo
$contrato = new Contrato();

switch ($_REQUEST["operador"]) {

    case "guardar_contrato":

       

        if (isset($_POST["contratoCredito"]) && !empty($_POST["contratoCredito"])) {

            $CreadoPor =  $_SESSION["user"]["Usuario"];
            $ModificadoPor =  $_SESSION["user"]["Usuario"];
            $idUsuario =  $_SESSION["user"]["idUsuario"];

            $nombre =$_POST["nombre"];
            $idSolicitud = $_POST["idSolicitud"];
            $contratoCredito = $_POST["contratoCredito"];
            $fianzaSolidaria = $_POST["fianzaSolidaria"];
            $pagare = $_POST["pagare"];
            $porAvales = $_POST["porAvales"];
            $emisionCheques = $_POST["emisionCheques"];
            $cuentas = $_POST["cuentas"];
            $adicional = $_POST["adicional"];

            $resultado = $contrato->RegistrarContrato($idSolicitud, $contratoCredito, $fianzaSolidaria, $pagare, $porAvales, $emisionCheques, $cuentas, $adicional, $CreadoPor, $ModificadoPor, $idUsuario);

            if($resultado  == "Inserto"){
                
                $contrato->RegistrarBitacora($idUsuario, 6, "Inserto", "Creo el contrato del cliente: ".$nombre) ;
                $response = "success";  //si se inserto o actualizo en la BD manda mensaje de exito
            
            }else if($resultado ==  "Actualizo"){
                
                $contrato->RegistrarBitacora($idUsuario, 6, "Modifico", "Modificó el contrato del cliente: ".$nombre) ;
                $response = "success";  //si se inserto o actualizo en la BD manda mensaje de exito
            }else{
                $response = "error"; 
            }

        }else{
            $response = "requerid";  
        }
       
        echo $response;

    break;

    case "guardar_contrato_y_aprobar":

       

        if (isset($_POST["contratoCredito"], $_POST["pagare"], $_POST["emisionCheques"]) && !empty($_POST["contratoCredito"])
        && !empty($_POST["emisionCheques"]) && !empty($_POST["pagare"]) ) {

            $CreadoPor =  $_SESSION["user"]["Usuario"];
            $ModificadoPor =  $_SESSION["user"]["Usuario"];
            $idUsuario =  $_SESSION["user"]["idUsuario"];

            $nombre =$_POST["nombre"];
            $idSolicitud = $_POST["idSolicitud"];
            $fechaHoy = date('Y-m-d');
            $fechaAprobacion = $_POST["fechaContrato"];
            $idEstadoSolicitud = 4; //estado de solicitud aprobacion de contrato
            $contratoCredito = $_POST["contratoCredito"];
            $fianzaSolidaria = $_POST["fianzaSolidaria"];
            $pagare = $_POST["pagare"];
            $porAvales = $_POST["porAvales"];
            $emisionCheques = $_POST["emisionCheques"];
            $cuentas = $_POST["cuentas"];
            $adicional = $_POST["adicional"];

            //trae el estado del contrato
            $estado = $contrato->ConsultarEstadoSolicitud($idSolicitud); 
            foreach ($estado as $campos => $valor) {
                $ESTADOSOLI["valores"][$campos] = $valor; //ALMACENA EL ESTADO DE LA SOLICITUD
            }

            if($fechaAprobacion < $fechaHoy){
                $response = "fechaMenor"; 

            }else if($ESTADOSOLI["valores"]["idEstadoSolicitud"] !=1){
                $response = "NoAprobado";

            }else if($contrato->AprobarContrato($fechaAprobacion, $idEstadoSolicitud,$idSolicitud) ){
                $resultado =$contrato->RegistrarContrato($idSolicitud, $contratoCredito, $fianzaSolidaria, $pagare, $porAvales, $emisionCheques, $cuentas, $adicional, $CreadoPor, $ModificadoPor);
                if($resultado == "Actualizo"){
                    $hoy = date('d-m-Y');
                    $contrato->RegistrarBitacora($idUsuario, 6, "Modifico", "Modificó y aprobó el contrato del cliente: ".$nombre."| Aprobación: ".$hoy);
                    $response = "success";  //si se inserto o actualizo en la BD manda mensaje de exito
                }else{
                    $response = "error"; 
                }
                
            }else{
                $response = "error"; 
            }

        }else{
            $response = "requerid";  
        }
       
        echo $response;

    break;

    case "traer_contrato":

        if(isset($_POST["idSolicitud"]) && !empty($_POST["idSolicitud"])){
            $data = $contrato->traerContrato($_POST["idSolicitud"]);
            if($data){
                $list[] = array(
                    "idSolicitud"=>$data['idSolicitud'],
                    "contratoCredito"=>$data['contratoCredito'],
                    "fianzaSolidaria"=>$data['fianzaSolidaria'],
                    "pagare"=>$data['pagare'],
                    "porAvales"=>$data['porAvales'],
                    "emisionCheque"=>$data['emisionCheque'],
                    "cuenta"=>$data['cuenta'],
                    "adicional"=>$data['adicional'],
                    "fechaAprob"=>$data['fechaAprob'],
                    "estado"=>$data['idEstadoSolicitud']

                );
                echo json_encode($list);
            }
        }
 
    break;

   
}


//
