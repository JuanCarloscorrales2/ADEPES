<?php

require "../config/Conexion.php";

class preguntasModel {

    public $cnx; //variable publica para la conexion a la BD

    function __construct() //constructor
    {
        $this->cnx = Conexion::ConectarDB(); //conexion a la base de datos
    }


    function ListarPreguntas(){

        $sql="SELECT * FROM tbl_ms_preguntas WHERE estadoPregunta=1";
        $result = $this->cnx->prepare($sql);
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


    //FUNCION PARA REGISTRAr preguntas
    function RegistrarPregunta($idPregunta, $idUsuario, $Respuesta, $CreadoPor){
        $query = "INSERT INTO tbl_ms_preguntas_usuario(idPregunta, idUsuario, Respuesta, CreadoPor) VALUES(?, ?, ?, ?)";
        $result = $this->cnx->prepare($query); //preparacion de la sentencia
        $result->bindParam(1,$idPregunta);
        $result->bindParam(2,$idUsuario);
        $result->bindParam(3,$Respuesta);
        $result->bindParam(4,$CreadoPor);
    

        if($result->execute()){ //validacion de la ejecucion
            return true;
        }

        return false; //si fallo se devuelvo false

    }





    /****************************** */
    function ParametroPreguntas()  //funcion que trae l parametro de maximo de preguntas
    {
        $query = "SELECT * FROM tbl_ms_parametros WHERE idParametro = 2; "; 
        $result = $this->cnx->prepare($query);
        if($result->execute())
        {
            if($result->rowCount() > 0){ //validacion para verificar si trae datos
                
                while($fila = $result->fetch(PDO::FETCH_ASSOC)){
                    return $fila;
                }
                
            }
        }
        return false;
    }

     //TRAE LOS INTENTOS realizados por el USUARIO
     function CantidadPreguntasContestadas($idUsuario)
     {
         $query = "SELECT count(idPregunta) AS Contestadas FROM tbl_ms_preguntas_usuario WHERE idUsuario =?"; 
         $result = $this->cnx->prepare($query);
         $result->bindParam(1,$idUsuario);
         if($result->execute())
         {
             if($result->rowCount() > 0){ //validacion para verificar si trae datos
                 
                 while($fila = $result->fetch(PDO::FETCH_ASSOC)){
                     return $fila;
                 }
                 
             }
         }
         return false;
     }
    
    //registra las el numero de preguntas contestadas
    function ActualizarCantidadPreguntasContestadas($PreguntasContestadas, $idUsuario)
    {
        $query = "UPDATE tbl_ms_usuario SET PreguntasContestadas = ? WHERE idUsuario = ?";

        $result = $this->cnx->prepare($query);
        $result->bindParam(1,$PreguntasContestadas);
        $result->bindParam(2,$idUsuario);
        if($result->execute()){
            return true;
        }
        return false;
    }

    //Cambia el estado del usuario a activo
    function ActualizarEstadoUsuario($idUsuario)
    {
        $query = "UPDATE tbl_ms_usuario SET idEstadoUsuario = 2 WHERE idUsuario = ?";

        $result = $this->cnx->prepare($query);
        $result->bindParam(1,$idUsuario);
        if($result->execute()){
            return true;
        }
        return false;
    }

    //
    //funcion que valida que  no se repitan preguntas
    function ValidarPregunta($idUsuario, $idPregunta)
    {
        $query = "SELECT * FROM tbl_ms_preguntas_usuario WHERE idUsuario = ? and idPregunta =?"; 
        $result = $this->cnx->prepare($query);
        $result->bindParam(1,$idUsuario);
        $result->bindParam(2,$idPregunta);
        if($result->execute())
        {
            if($result->rowCount() > 0){ //validacion para verificar si trae datos
                
                return "preguntaRegistrada";
                
            }
        }
        return "noexiste";
    }
    

     //actualiza la clave
    function ActualizarClaveUsuario($Clave, $idUsuario)
    {
        $query = "UPDATE tbl_ms_usuario SET Clave = ? WHERE idUsuario = ?";

        $result = $this->cnx->prepare($query);
        $clave_hash = password_hash($Clave,PASSWORD_DEFAULT); //encripta la clave
        $result->bindParam(1,$clave_hash);
        $result->bindParam(2,$idUsuario);
        if($result->execute()){
            return true;
        }
        return false;
    }


    function ClaveMinima()  //funcion que trae l parametro de intentos
    {
        $query = "SELECT * FROM tbl_ms_parametros WHERE idParametro = 3; "; 
        $result = $this->cnx->prepare($query);
        if($result->execute())
        {
            if($result->rowCount() > 0){ //validacion para verificar si trae datos
                
                while($fila = $result->fetch(PDO::FETCH_ASSOC)){
                    return $fila;
                }
                
            }
        }
        return false;
    }

    function ClaveMaxima()  //funcion que trae l parametro de intentos
    {
        $query = "SELECT * FROM tbl_ms_parametros WHERE idParametro = 4; "; 
        $result = $this->cnx->prepare($query);
        if($result->execute())
        {
            if($result->rowCount() > 0){ //validacion para verificar si trae datos
                
                while($fila = $result->fetch(PDO::FETCH_ASSOC)){
                    return $fila;
                }
                
            }
        }
        return false;
    }
  
    //funcion que verifica que no sea la misma clave
    function validarClaveDistinta($Clave, $idUsuario){

        $sql="SELECT Clave FROM tbl_ms_usuario WHERE idUsuario = ? AND Clave =?";
        $result = $this->cnx->prepare($sql);
        $result->bindParam(1,$idUsuario);
        $result->bindParam(2,$Clave);
        if($result->execute())
        {
            if($result->rowCount() > 0){ //validacion para verificar si trae datos
                return true;
            }
        }
        return false;
    }

}




?>