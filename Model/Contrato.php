<?php

require "../config/Conexion.php";

class Contrato {

    public $cnx; //variable publica para la conexion a la BD

    function __construct() //constructor
    {
        $this->cnx = Conexion::ConectarDB(); //conexion a la base de datos
    }

//FUNCION PARA REGISTRAr UN solicitante

function RegistrarContrato($idSolicitud, $contratoCredito, $fianzaSolidaria, $pagare, $porAvales, $emisionCheque, $cuenta, $adicional, $CreadoPor, $ModificadoPor) {
    
    $queryC ="SELECT *FROM tbl_mn_contrato WHERE idSolicitud = ?";
    $resultC = $this->cnx->prepare($queryC);
    $resultC->bindParam(1, $idSolicitud);
    if ($resultC->execute()) {
        if($resultC->rowCount() > 0){ //validacion para verificar si existe ya un contrato con el id lo actualiza

           $query = "UPDATE tbl_mn_contrato SET contratoCredito = ?, fianzaSolidaria = ?, pagare = ?, porAvales = ?,
            emisionCheque = ?, cuenta = ?, adicional = ?, ModificadoPor = ?, FechaModificacion = CURRENT_TIMESTAMP WHERE idSolicitud = ?;";                                                                                                       
           $result = $this->cnx->prepare($query);
       
           
           $result->bindParam(1, $contratoCredito);
           $result->bindParam(2, $fianzaSolidaria);
           $result->bindParam(3, $pagare);
           $result->bindParam(4, $porAvales);
           $result->bindParam(5, $emisionCheque);
           $result->bindParam(6, $cuenta);
           $result->bindParam(7, $adicional);
           $result->bindParam(8, $ModificadoPor);
           $result->bindParam(9, $idSolicitud);
           
           
           if ($result->execute()) {
               return "Actualizo";
           }

        }else{  //inserta un contrato
           $query = "INSERT INTO tbl_mn_contrato(idSolicitud, contratoCredito, fianzaSolidaria, pagare, porAvales, emisionCheque, cuenta, adicional, CreadoPor, FechaCreacion)
            VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, CURRENT_TIMESTAMP)";                                                                                                       
           $result = $this->cnx->prepare($query);
       
           $result->bindParam(1, $idSolicitud);
           $result->bindParam(2, $contratoCredito);
           $result->bindParam(3, $fianzaSolidaria);
           $result->bindParam(4, $pagare);
           $result->bindParam(5, $porAvales);
           $result->bindParam(6, $emisionCheque);
           $result->bindParam(7, $cuenta);
           $result->bindParam(8, $adicional);
           $result->bindParam(9, $CreadoPor);
       
           if ($result->execute()) {
               return "Inserto";
           }
        }
    }
    
   

    return false;
}

function traerContrato($idSolicitud) {
    $query = "SELECT contra.idSolicitud, contra.contratoCredito, contra.fianzaSolidaria, contra.pagare,
    contra.porAvales, contra.emisionCheque, contra.cuenta, contra.adicional, DATE(soli.fechaAprob) AS fechaAprob,
    soli.idEstadoSolicitud FROM tbl_mn_contrato contra
    INNER JOIN tbl_mn_solicitudes_creditos soli on contra.idSolicitud = soli.idSolicitud
    WHERE contra.idSolicitud = ?"; 
    $result = $this->cnx->prepare($query);
    $result->bindParam(1,$idSolicitud);
    if($result->execute())
    {
        return $result->fetch(PDO::FETCH_ASSOC);
    }
    return false;
}

//funcion para  aprobacion por contrato
function AprobarContrato($fechaAprobacion, $idEstadoSolicitud, $idSolicitud){
    $query = "UPDATE tbl_mn_solicitudes_creditos SET fechaAprob= ?, idEstadoSolicitud = ? WHERE idSolicitud = ?"; 
    $result = $this->cnx->prepare($query);
    $result->bindParam(1,$fechaAprobacion);
    $result->bindParam(2,$idEstadoSolicitud);
    $result->bindParam(3,$idSolicitud);
    if($result->execute())
    {
      return true;
         
    }
    return false;
}

//funciion para ver si la solicitud esta aprobada o no
function ConsultarEstadoSolicitud($idSolicitud)
{
    $query = "SELECT idEstadoSolicitud FROM tbl_mn_solicitudes_creditos WHERE idSolicitud =? ";
    $result = $this->cnx->prepare($query);
    $result->bindParam(1,$idSolicitud);
    if($result->execute())
    {
        return $result->fetch(PDO::FETCH_ASSOC);
    }
    return false;

    
}

//FUNCION PARA REGISTRAR  EN LA BITACORA
function RegistrarBitacora($idUsuario, $idObjetos, $Accion, $Descripcion){
    $query = "INSERT INTO tbl_ms_bitacora(idUsuario, idObjetos, Accion, Descripcion) VALUES(?, ?, ?, ?)";
    $result = $this->cnx->prepare($query); //preparacion de la sentencia
    $result->bindParam(1,$idUsuario);
    $result->bindParam(2,$idObjetos);
    $result->bindParam(3,$Accion);
    $result->bindParam(4,$Descripcion);

    if($result->execute()){ //validacion de la ejecucion
        return true;
    }

    return false; //si fallo se devuelvo false

}

 

 
 }