<?php

require "../config/Conexion.php";

class Rol {

    public $cnx; //variable publica para la conexion a la BD

    function __construct() //constructor
    {
        $this->cnx = Conexion::ConectarDB(); //conexion a la base de datos
    }


    //funcion para listar los roles
    function ListarRoles()
    {
        $query = "SELECT * FROM tbl_ms_roles"; //sentencia sql
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


    //FUNCION PARA REGISTRAr UN ROL
    function RegistrarRol($rol, $descripcion){
        $query = "INSERT INTO tbl_ms_roles(Rol, Descripcion) VALUES(?, ?)";
        $result = $this->cnx->prepare($query); //preparacion de la sentencia
        $result->bindParam(1,$rol);
        $result->bindParam(2,$descripcion);

        if($result->execute()){ //validacion de la ejecucion
            return true;
        }

        return false; //si fallo se devuelvo false

    }

    //funcion que valida que el usuario
    function ObtenerRolPorId($idRol)
    {
        $query = "SELECT * FROM tbl_ms_roles WHERE idRol = ?"; 
        $result = $this->cnx->prepare($query);
        $result->bindParam(1,$idRol);
        if($result->execute())
        {
           return $result->fetch(PDO::FETCH_ASSOC);
        }
        return false;
    }


    //FUNCION QUE trae el rol del usuario a actualizar
    function ListarRolesSelectEdit($idUsuario) {
        $query = "SELECT ro.idRol, ro.Rol FROM tbl_ms_usuario usu INNER JOIN tbl_ms_roles ro ON usu.idRol = ro.idRol
                  WHERE usu.idUsuario = ? UNION SELECT idRol, Rol FROM tbl_ms_roles"; 
        $result = $this->cnx->prepare($query);
        $result->bindParam(1,$idUsuario);
        if($result->execute())
        {
            if($result->rowCount() > 0){ //validacion para verificar si trae datos
                
               while($fila = $result->fetch(PDO::FETCH_ASSOC)){
                   $datos[] = $fila;
               }
                return $datos;
            }
        }
        return false;
   
    }


    
    //FUNCION PARA ACTUALIZR ROL
    function ActualizarRol($idRol, $Rol, $Descripcion){
        $query = "UPDATE tbl_ms_roles SET Rol = ?, Descripcion = ? WHERE idRol = ?";
        $result = $this->cnx->prepare($query); //preparacion de la sentencia
        $result->bindParam(1,$Rol);
        $result->bindParam(2,$Descripcion);
        $result->bindParam(3,$idRol);

        if($result->execute()){ //validacion de la ejecucion
            return true;
        }

        return false; //si fallo se devuelvo false

    }


    //FUNCION PARA ELIMINAR UN  ROL
    function EliminarRol($idRol) {
        try {
            $query = "DELETE FROM tbl_ms_roles WHERE idRol = ?";
            $result = $this->cnx->prepare($query);
            $result->bindParam(1, $idRol);
    
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