<?php

require "../config/Conexion.php";
session_start();
class resetPasswordModel {

    public $cnx; 

    function __construct() 
    {
        $this->cnx = Conexion::ConectarDB(); 
    }

    //funcion para validar el usuario
    function usuarioExiste($usuario) {
        $sql = "SELECT idUsuario FROM tbl_ms_usuario WHERE Usuario = ? AND idEstadoUsuario != 4";
        $result = $this->cnx->prepare($sql);
        $result->execute([$usuario]);
    
        if ($result->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }
    
    
    public function ListarPreguntasUsuario($idUsuario) {
        $sql = "SELECT pu.idPregunta, p.Pregunta, pu.Respuesta
        FROM tbl_ms_preguntas_usuario pu
        INNER JOIN tbl_ms_preguntas p ON pu.idPregunta = p.idPregunta
        WHERE pu.idUsuario = ?";
        $result = $this->cnx->prepare($sql);
        $result->bindParam(1, $idUsuario);
    
        if ($result->execute()) {
            $preguntas = array();
            while ($fila = $result->fetch(PDO::FETCH_ASSOC)) {
                $preguntas[] = $fila;
            }
            return $preguntas;
        }
        return array();
    }
    

    public function obtenerPreguntasSeguridad() {
        $sql = "SELECT idPregunta, Pregunta FROM tbl_ms_preguntas";
        $result = $this->cnx->query($sql);
      
        if ($result) {
          return $result->fetchAll(PDO::FETCH_ASSOC);
        }
      
        return array();
      }

    //obtener id de usuario por nombre de usuario
    public function obtenerIdUsuario($usuario) {
        $sql = "SELECT idUsuario FROM tbl_ms_usuario WHERE Usuario = ?";
        $result = $this->cnx->prepare($sql);
        $result->execute([$usuario]);
    
        if ($result->rowCount() > 0) {
            $fila = $result->fetch(PDO::FETCH_ASSOC);
            return $fila['idUsuario'];
        } else {
            return null;
        }
    }
      

    function validarRespuestas($usuario, $respuestas) {
        $sql = "SELECT pu.idUsuario, pu.idPregunta, pu.CreadoPor, p.Pregunta, pu.Respuesta
                FROM tbl_ms_preguntas_usuario pu
                INNER JOIN tbl_ms_preguntas p ON pu.idPregunta = p.idPregunta
                WHERE pu.CreadoPor = ?";
        $result = $this->cnx->prepare($sql);
        $result->bindValue(1, $usuario);

        if ($result->execute()) {
            $datos = array();
            while ($fila = $result->fetch(PDO::FETCH_ASSOC)) {
                $datos[] = $fila;
            }
    
            $respuestasCorrectas = array();
            foreach ($datos as $pregunta) {
                $preguntaTexto = $pregunta['Pregunta'];
                $respuestaCorrecta = $pregunta['Respuesta'];
                var_dump($respuestaCorrecta);

                
                if (isset($respuestas[$preguntaTexto]) && $respuestas[$preguntaTexto] === $respuestaCorrecta) {
                    $respuestasCorrectas[] = $pregunta;
                }
            }
            
            return $respuestasCorrectas;
        }
    
        return array();
    }

    public function actualizarContraseña($idUsuario, $FechaVencimiento, $contraseña) {
        $sql = "UPDATE tbl_ms_usuario SET Clave = ?, idEstadoUsuario=2,  Intentos=0, FechaVencimiento = ? WHERE Usuario = ?";
        $result = $this->cnx->prepare($sql);
        $clave_hash = password_hash($contraseña,PASSWORD_DEFAULT); //encripta la clave
        $result->bindValue(1,$clave_hash);
        $result->bindValue(2, $FechaVencimiento);
        $result->bindValue(3, $idUsuario);
      
        return $result->execute();
      }
      
    //funcion para el parametro minimo de clave
    public  function ClaveMinima()  //funcion que trae l parametro de intentos
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

    //funcion para el parametro maximo de clave
   public function ClaveMaxima()  //funcion que trae l parametro de intentos
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

    public function DiasVencimiento()  //funcion que trae el parametro de fecha de vencimiento
    {
        $query = "SELECT * FROM tbl_ms_parametros WHERE idParametro = 5; "; 
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

    //FUNCION PARA REGISTRAR  EN LA BITACORA
    public function RegistrarBitacora($idUsuario, $idObjetos, $Accion, $Descripcion){
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