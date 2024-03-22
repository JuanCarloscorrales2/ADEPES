<?php

require "../config/Conexion.php";

class Estado {

    public $cnx; //variable publica para la conexion a la BD

    function __construct() //constructor
    {
        $this->cnx = Conexion::ConectarDB(); //conexion a la base de datos
    }


   /*********************FUNCIONES DE LA TABLA ESTADO USUARIO ********************************************************/


  //funcion para listar los datos de la tabla estado user
  function listarEstadousuario()
  {
      $query = "SELECT * FROM tbl_ms_estado_usuario"; //sentencia sql
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
    
  }
     
 //FUNCION PARA REGISTRAR UN NUEVO estado
 function RegistrarEstadousuario($Descripcion){
    $query = "INSERT INTO tbl_ms_estado_usuario (Descripcion) VALUES(?)";
    $result = $this->cnx->prepare($query); //preparacion de la sentencia
    $result->bindParam(1,$Descripcion);

    if($result->execute()){ //validacion de la ejecucion
        return true;
    }

    return false; //si fallo se devuelvo false

}

 //funcion que trae los datos del estado usuario a actualizar
 function ObtenerEstadousuarioPorId($idEstadoUsuario)
 {
     $query = "SELECT * FROM tbl_ms_estado_usuario WHERE idEstadoUsuario = ?"; 
     $result = $this->cnx->prepare($query);
     $result->bindParam(1,$idEstadoUsuario);
     if($result->execute())
     {
        return $result->fetch(PDO::FETCH_ASSOC);
     }
     return false;
 }

    //FUNCION PARA ACTUALIZR LOS ESTADO USER 
    function ActualizarEstadousuario($idEstadoUsuario, $Descripcion){
        $query = "UPDATE tbl_ms_estado_usuario SET Descripcion = ? WHERE idEstadoUsuario = ?";
        $result = $this->cnx->prepare($query); //preparacion de la sentencia
        $result->bindParam(1,$Descripcion);
        $result->bindParam(2,$idEstadoUsuario);
     

        if($result->execute()){ //validacion de la ejecucion
            return true;
        }

        return false; //si fallo se devuelvo false

    }

    
//FUNCION PARA ELIMINAR UN ESTADO
    function EliminarEstadousuario($idEstadoUsuario) {
        try {
            $query = "DELETE FROM tbl_ms_estado_usuario WHERE idEstadoUsuario = ?";
            $result = $this->cnx->prepare($query);
            $result->bindParam(1, $idEstadoUsuario);
    
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