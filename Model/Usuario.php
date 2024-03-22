<?php

require "../config/Conexion.php";

class Usuario {

    public $cnx; //variable publica para la conexion a la BD

    function __construct() //constructor
    {
        $this->cnx = Conexion::ConectarDB();
    }
/***********************   CRUD   *********************************************************** */
    //funcion para listar los usuarios
    function ListarUsuarios(){
        $query = "SELECT usu.idUsuario, usu.Usuario, usu.NombreUsuario, ro.Rol,
                  ue.Descripcion as EstadoUsuario, usu.CorreoElectronico, usu.FechaCreacion, usu.FechaVencimiento
                  FROM tbl_ms_usuario usu INNER JOIN tbl_ms_roles ro on ro.idRol = usu.idRol
                  INNER JOIN tbl_ms_Estado_Usuario ue on ue.idEstadoUsuario = usu.idEstadoUsuario"; 
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
    

    //funcion para registar un usuario desde la gestion de usuarios
    function RegistrarUsuario($Usuario, $idRol, $NombreUsuario, $EstadoUsuario, $CorreoElectronico, $Clave, $CreadoPor, $FechaVencimiento)
    {
        $query = "INSERT INTO tbl_ms_usuario(Usuario, idRol, NombreUsuario, idEstadoUsuario, CorreoElectronico, Clave, CreadoPor, FechaVencimiento) 
         VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $result = $this->cnx->prepare($query);
        $result->bindParam(1,$Usuario);
        $result->bindParam(2,$idRol);
        $result->bindParam(3,$NombreUsuario);
        $result->bindParam(4,$EstadoUsuario);
        $result->bindParam(5,$CorreoElectronico);
        $clave_hash = password_hash($Clave,PASSWORD_DEFAULT); //encripta la clave
        $result->bindParam(6,$clave_hash);
        $result->bindParam(7,$CreadoPor);
        $result->bindParam(8,$FechaVencimiento);
        if($result->execute()){
            return true;
        }
        return false;
    }

    //funcion para actualizar un usuario
    function ActualizarUsuario($idUsuario, $NombreUsuario, $CorreoElectronico, $idRol, $idEstadoUsuario, $ModificadoPor, $FechaModificacion ){
        $query = "UPDATE tbl_ms_usuario SET  NombreUsuario = ?, CorreoElectronico = ?, idRol = ?, idEstadoUsuario = ?,
                  ModificadoPor = ?, FechaModificacion = ? WHERE idUsuario = ?";
        $result = $this->cnx->prepare($query); //preparacion de la sentencia
        $result->bindParam(1,$NombreUsuario);
        $result->bindParam(2,$CorreoElectronico);
        $result->bindParam(3,$idRol);
        $result->bindParam(4,$idEstadoUsuario);
        $result->bindParam(5,$ModificadoPor);
        $result->bindParam(6,$FechaModificacion);
        $result->bindParam(7,$idUsuario);
        

        if($result->execute()){ //validacion de la ejecucion
            return true;
        }

        return false; //si fallo se devuelvo false
    
    }

       //funcion para eliminar un usuario
    function EliminarUsuario($idUsuario){
       

        //return false; //si fallo se devuelvo false

        try{
            $query = "DELETE FROM tbl_ms_usuario WHERE idUsuario = ?";
            $result = $this->cnx->prepare($query); //preparacion de la sentencia
            $result->bindParam(1,$idUsuario);
            
    
            if($result->execute()){ //validacion de la ejecucion
                return "elimino";
            }

        } catch (PDOException $ex){
              $ex->getMessage(); 
             return "23000";
             
        } 
    
    }

    //FUNCION PARA ACTUALIZR el estado del usuario a Inactivo cuando no se puede eliminar
    function ActualizarUsuarioInactivo($idUsuario){
        $query = "UPDATE tbl_ms_usuario SET idEstadoUsuario = 4 WHERE idUsuario = ?";
        $result = $this->cnx->prepare($query); //preparacion de la sentencia
        $result->bindParam(1,$idUsuario);

        if($result->execute()){ //validacion de la ejecucion
            return true;
        }

        return false; //si fallo se devuelvo false

    }

    //funcion para eliminar un Las preguntas del usuario
    function EliminarPreguntasUsuario($idUsuario){
        $query = "DELETE FROM tbl_ms_preguntas_usuario WHERE idUsuario = ?";
        $result = $this->cnx->prepare($query); //preparacion de la sentencia
        $result->bindParam(1,$idUsuario);
        

        if($result->execute()){ //validacion de la ejecucion
            return true;
        }

        return false; //si fallo se devuelvo false     
        
    }

    

    //funcion para listar los estados
    function ListarEstadosEdit($idUsuario)
    {
        $query = "SELECT esta.idEstadoUsuario, esta.Descripcion FROM tbl_ms_usuario usu 
                  INNER JOIN tbl_ms_estado_usuario esta ON usu.idEstadoUsuario = esta.idEstadoUsuario
                  WHERE usu.idUsuario = ?
                  UNION SELECT idEstadoUsuario, Descripcion FROM tbl_ms_estado_usuario"; 
        $result = $this->cnx->prepare($query);
        $result->bindParam(1,$idUsuario);
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


/********************************************************************************* */

    //funcion que valida que el usuario no exista en la gestion de usuarios
    function ValidarUsuarioRegistro($Usuario)
    {
        $query = "SELECT * FROM tbl_ms_usuario WHERE Usuario = ?"; 
        $result = $this->cnx->prepare($query);
        $result->bindParam(1,$Usuario);
        if($result->execute())
        {
            if($result->rowCount() > 0){ //validacion para verificar si trae datos
                
                return "existeUsuario";
                
            }
        }
        return "noexiste";
    }
    //funcion que valida que el usuario no exista en la gestion de usuarios
    function ValidarCorreoRegistro($CorreoElectronico)
    {
        $query = "SELECT * FROM tbl_ms_usuario WHERE CorreoElectronico = ?"; 
        $result = $this->cnx->prepare($query);
        $result->bindParam(1,$CorreoElectronico);
        if($result->execute())
        {
            if($result->rowCount() > 0){ //validacion para verificar si trae datos
                
                return "existeCorreo";
                
            }
        }
        return "noexiste";
    }

     //funcion que valida que el usuario
    function ObtenerUsuarioPorId($idUsuario)
    {
        $query = "SELECT * FROM tbl_ms_usuario WHERE idUsuario = ?"; 
        $result = $this->cnx->prepare($query);
        $result->bindParam(1,$idUsuario);
        if($result->execute())
        {
           return $result->fetch(PDO::FETCH_ASSOC);
        }
        return false;
    }
 
   
/**********************************************Validacion del login************************************************************ */
    //funcion que valida que el usuario
    function ValidarUsuario($Usuario)
    {
        $query = "SELECT * FROM tbl_ms_usuario WHERE Usuario = ?"; 
        $result = $this->cnx->prepare($query);
        $result->bindParam(1,$Usuario);
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
    //FUNCION QUE VALIDA LA CLAVE DEL USUARIO
    function ValidarUsuarioClave($Clave, $idUsuario)
    {
        $query = "SELECT * FROM tbl_ms_usuario WHERE idUsuario = ?"; 
        $result = $this->cnx->prepare($query);
        $result->bindParam(1,$idUsuario);
        $result->execute();
        $fila = $result->fetch();
        if(password_verify($Clave, $fila["Clave"]))
        {      
                return true;      
            
        }
        return false;
    }

/************************************************************************************************************* */

/****************************************  Validaciones de intentos del login ******************************************************** */
    function ParametroIntentos()  //funcion que trae l parametro de intentos
    {
        $query = "SELECT * FROM tbl_ms_parametros WHERE idParametro = 1; "; 
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

    //funcion para registar los intentos del usuario
    function RegistrarUsuarioIntento($idUsuario)
    {
        $query = "UPDATE tbl_ms_usuario SET Intentos = (Intentos +1) WHERE idUsuario = ?";
        $result = $this->cnx->prepare($query);
        $result->bindParam(1,$idUsuario);
        if($result->execute()){
            return true;
        }
        return false;
    }

  //BORRA LOS INTENTOS DEL USUARIO
    function EliminarIntentosUsuario($idUsuario)
    {
        $query = "UPDATE tbl_ms_usuario SET Intentos = 0 WHERE idUsuario = ?"; 
        $result = $this->cnx->prepare($query); //preparacion de la sentencia
        $result->bindParam(1,$idUsuario);

        if($result->execute()){ //validacion de la ejecucion
            return true;
        }

        return false; //si fallo se devuelvo false
    }

    //FUNCION PARA ACTUALIZR el estado del usuario a bloqueado por numero de intentos superados
    function ActualizarUsuarioBloqueado($idUsuario){
        $query = "UPDATE tbl_ms_usuario SET idEstadoUsuario = 3 WHERE idUsuario = ?";
        $result = $this->cnx->prepare($query); //preparacion de la sentencia
        $result->bindParam(1,$idUsuario);

        if($result->execute()){ //validacion de la ejecucion
            return true;
        }

        return false; //si fallo se devuelvo false

    }

/***************************************************************************************************** */

    /*
    function ValidarUsuario($correo,$clave)
    {
        $query = "SELECT * FROM usuarios WHERE correo = ? ";
        $result = $this->cnx->prepare($query);
        $result->bindParam(1,$correo);
        $result->execute();
        $fila = $result->fetch();
        if(password_verify($clave,$fila["clave"])){
            return $fila;
        }
        return false;
    }*/


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


    function DiasVencimiento()  //funcion que trae l parametro de intentos
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

    

}




?>