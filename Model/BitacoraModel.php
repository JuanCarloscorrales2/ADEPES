<?php

require_once("../config/Conexion.php");

class Bitacora {

    public $cnx; //variable publica para la conexion a la BD

    function __construct() //constructor
    {
        $this->cnx = Conexion::ConectarDB(); //conexion a la base de datos
    }


    //funcion para listar los datos de bitaccora
    function ListarBitacora()
    {
        $query = "SELECT usu.Usuario, obj.Objeto, bita.Accion, bita.Descripcion, 
        DATE_FORMAT(bita.Fecha, '%m-%d-%Y %h:%i:%s') AS Fecha FROM tbl_ms_bitacora bita 
            INNER JOIN tbl_ms_objetos obj ON obj.idObjetos = bita.idObjetos 
            INNER JOIN tbl_ms_usuario usu ON bita.idUsuario = usu.idUsuario"; //sentencia sql
        $result = $this->cnx->prepare($query);
        if($result->execute())
        {
            if($result->rowCount() > 0){ //validacion para verificar si trae datos
                while($fila = $result->fetch(PDO::FETCH_ASSOC)){  //guardar los datos en un arreglo
                    $datos[] = $fila;
                }
                return $datos;
            }
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

     //funcion para listar los datos de bitaccora por rango de fecha
     function FiltrarPorFecha($fechaInicio, $fechaFinal)
     {
        $query = "SELECT usu.Usuario, obj.Objeto, bita.Accion, bita.Descripcion, 
            DATE_FORMAT(bita.Fecha, '%m-%d-%Y %h:%i:%s') AS Fecha FROM tbl_ms_bitacora bita 
            INNER JOIN tbl_ms_objetos obj ON obj.idObjetos = bita.idObjetos 
            INNER JOIN tbl_ms_usuario usu ON bita.idUsuario = usu.idUsuario
            WHERE DATE(bita.Fecha) >= ? AND DATE(bita.Fecha) <= ?;"; //sentencia sql
        $result = $this->cnx->prepare($query);
        $result->bindParam(1,$fechaInicio);
        $result->bindParam(2,$fechaFinal);
        if($result->execute())
        {
            if($result->rowCount() > 0){ //validacion para verificar si trae datos
                while($fila = $result->fetch(PDO::FETCH_ASSOC)){  //guardar los datos en un arreglo
                    $datos[] = $fila;
                }
                return $datos;
            }
        }
        return false;
     }

 
    
}




?>