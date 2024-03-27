<?php

require "../config/Conexion.php";

class Parametro {

    public $cnx; //variable publica para la conexion a la BD

    function __construct() //constructor
    {
        $this->cnx = Conexion::ConectarDB(); //conexion a la base de datos
    }


    //funcion para listar los roles
    function ListarParametros()
    {
        $query = "SELECT 
                    (@row_number:=@row_number + 1) AS numero_secuencial,
                    tbl_ms_parametros.*
                  FROM 
                    (SELECT @row_number := 0) AS init,
                    tbl_ms_parametros"; // Consulta SQL con variable de usuario
        $result = $this->cnx->prepare($query);
        if($result->execute())
        {
            if($result->rowCount() > 0){ // Validación para verificar si trae datos
                while($fila = $result->fetch(PDO::FETCH_ASSOC)){  // Guardar los datos en un arreglo
                    $datos[] = $fila;
                }
                return $datos;
            }
        }
        return false;
    }
    




    //funcion que valida que el usuario
    function ObtenerParametroPorId($idParametro)
    {
        $query = "SELECT * FROM tbl_ms_parametros WHERE idParametro=?"; 
        $result = $this->cnx->prepare($query);
        $result->bindParam(1,$idParametro);
        if($result->execute())
        {
           return $result->fetch(PDO::FETCH_ASSOC);
        }
        return false;
    }


    
    //funcion para actualizar un parametro
    function ActualizarParametro($idParametro, $Valor, $FechaModificacion ){
        $query = "UPDATE tbl_ms_parametros SET  Valor = ?, FechaModificacion = ? WHERE idParametro = ?";
        $result = $this->cnx->prepare($query); //preparacion de la sentencia
        $result->bindParam(1,$Valor);
        $result->bindParam(2,$FechaModificacion);
        $result->bindParam(3,$idParametro);
        

        if($result->execute()){ //validacion de la ejecucion
            return true;
        }

        return false; //si fallo se devuelvo false
    
    }

    //funcion que valida que el usuario
    function tipoDatoParametro($idParametro) //funcion que trae el tipo de dato del parametro
    {
        $query = "SELECT idTipoDato FROM tbl_ms_parametros WHERE idParametro=?"; 
        $result = $this->cnx->prepare($query);
        $result->bindParam(1,$idParametro);
        if($result->execute())
        {
           return $result->fetch(PDO::FETCH_ASSOC);
        }
        return false;
    }
    
    function cantidadPreguntas() //funcion que trae la cantidad de preguntas
    {
        $query = "SELECT count(idPregunta) as cantidad FROM tbl_ms_preguntas;"; 
        $result = $this->cnx->prepare($query);
        
        if($result->execute())
        {
           return $result->fetch(PDO::FETCH_ASSOC);
        }
        return false;
    }



 
 }