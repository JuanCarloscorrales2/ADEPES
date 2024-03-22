<?php

require "../config/Conexion.php";

class Preguntas {

    public $cnx; //variable publica para la conexion a la BD

    function __construct() //constructor
    {
        $this->cnx = Conexion::ConectarDB(); //conexion a la base de datos
    }


    //funcion para listar los roles
    function ListarPreguntas()
    {
        $query = "SELECT * FROM tbl_ms_preguntas"; //sentencia sql
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


    //FUNCION PARA REGISTRAr UNa pregunta
    function RegistrarPregunta($Pregunta){
        $query = "INSERT INTO tbl_ms_preguntas(Pregunta) VALUES(?)";
        $result = $this->cnx->prepare($query); //preparacion de la sentencia
        $result->bindParam(1,$Pregunta);
     

        if($result->execute()){ //validacion de la ejecucion
            return true;
        }

        return false; //si fallo se devuelvo false

    }

    //funcion que valida que el usuario
    function ObtenerPreguntaPorId($idPregunta)
    {
        $query = "SELECT * FROM tbl_ms_preguntas WHERE idPregunta = ?"; 
        $result = $this->cnx->prepare($query);
        $result->bindParam(1,$idPregunta);
        if($result->execute())
        {
           return $result->fetch(PDO::FETCH_ASSOC);
        }
        return false;
    }

   
    //funcion para actualizar una pregunta
    function ActualizarPregunta($idPregunta, $Pregunta ){
        $query = "UPDATE tbl_ms_preguntas SET  Pregunta = ? WHERE idPregunta = ?";
        $result = $this->cnx->prepare($query); //preparacion de la sentencia
        $result->bindParam(1,$Pregunta);
        $result->bindParam(2,$idPregunta);
 
        if($result->execute()){ //validacion de la ejecucion
            return true;
        }

        return false; //si fallo se devuelvo false
    
    }
    

    //FUNCION PARA ELIMINAR UNA pregunta
    function EliminarPregunta($idPregunta) {
        try {
            $query = "DELETE FROM tbl_ms_preguntas WHERE idPregunta = ?";
            $result = $this->cnx->prepare($query);
            $result->bindParam(1, $idPregunta);
    
            if ($result->execute()) {
                return "elimino";
            }
    
        } catch (PDOException $e) {
           
            if ($e->errorInfo[1] === 1451) { // El código 1451 suele ser asociado con violaciones de claves externas
            
                return "Llave en uso"; // mensaje de llave ya en uso error 1451
            } else {
                
                return "error";
            }
        }
    }
    



 
 }