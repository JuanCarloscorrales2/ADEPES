<?php

require "../config/Conexion.php";

class Perfil {

    public $cnx; //variable publica para la conexion a la BD

    function __construct() //constructor
    {
        $this->cnx = Conexion::ConectarDB();
    }

     //funcion para listar los usuarios
     function ListarUsuarios(){
        $idUsuario=$_SESSION["user"]["idUsuario"];
        $query = "SELECT idUsuario, Usuario, NombreUsuario, CorreoElectronico FROM tbl_ms_usuario WHERE idUsuario=$idUsuario"; 
        $result = $this->cnx->prepare($query);
        if($result->execute()){
            if($result->rowCount() > 0){
                while($fila = $result->fetch(PDO::FETCH_ASSOC)){
                    $datos[] =  $fila;
                }
                return $datos;
            }

        }
        return false;
    }
    
     //funcion que valida que el usuario
     function ObtenerUsuarioPorId()
     {
        $idUsuario=$_SESSION["user"]["idUsuario"];
         $query = "SELECT idUsuario, Usuario, NombreUsuario, CorreoElectronico FROM tbl_ms_usuario 
                    WHERE idUsuario=$idUsuario"; 
         $result = $this->cnx->prepare($query);
         $result->bindParam(1,$idUsuario);
         if($result->execute())
         {
            return $result->fetch(PDO::FETCH_ASSOC);
         }
         return false;
     }
 

    //funcion para actualizar un usuario
    function ActualizarUsuario($idUsuario, $NombreUsuario, $CorreoElectronico ){
        $query = "UPDATE tbl_ms_usuario SET  NombreUsuario = ?, CorreoElectronico = ? WHERE idUsuario = ?";
        $result = $this->cnx->prepare($query); //preparacion de la sentencia
        $result->bindParam(1,$NombreUsuario);
        $result->bindParam(2,$CorreoElectronico);
        $result->bindParam(3,$idUsuario);

        if($result->execute()){ //validacion de la ejecucion
            return true;
        }

        return false; //si fallo se devuelvo false
    
    }

     

}

