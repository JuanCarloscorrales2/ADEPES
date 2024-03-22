<?php

require_once("../config/Conexion.php");

class Permisos
{

    public $cnx; //variable publica para la conexion a la BD

    function __construct() //constructor
    {
        $this->cnx = Conexion::ConectarDB(); //conexion a la base de datos
    }



    //funcion para listar los roles
    function ListarPermisos()
    {
        $query = "SELECT p.idPermiso,r.idRol, r.Rol, o.Objeto, p.insertar, p.eliminar, p.consultar, p.actualizar,p.reportes
                FROM tbl_ms_permisos p
                INNER JOIN tbl_ms_roles r ON p.idRol=r.idRol
                INNER JOIN tbl_ms_objetos o ON p.idObjeto=o.idObjetos
                order by  p.idPermiso"; //sentencia sql
        $result = $this->cnx->prepare($query);
        if ($result->execute()) {
            if ($result->rowCount() > 0) { //validacion para verificar si trae datos
                while ($fila = $result->fetch(PDO::FETCH_ASSOC)) {  //guardar los datos en un arreglo
                    $datos[] = $fila;
                }
                return $datos;
            }
        }
        return false;
    }
    function ListarPermisosRol($objeto, $rol)
    {
        $query = "SELECT p.idPermiso, r.Rol, o.Objeto, p.insertar, p.eliminar, p.consultar, p.actualizar,p.reportes
                FROM tbl_ms_permisos p
                INNER JOIN tbl_ms_roles r ON p.idRol=r.idRol
                INNER JOIN tbl_ms_objetos o ON p.idObjeto=o.idObjetos where p.idObjeto=? and r.idRol=?
                order by  p.idPermiso"; //sentencia sql
        $result = $this->cnx->prepare($query);
        $result->bindParam(1, $objeto);
        $result->bindParam(2, $rol);
        if ($result->execute()) {
            if ($result->rowCount() > 0) { //validacion para verificar si trae datos
                while ($fila = $result->fetch(PDO::FETCH_ASSOC)) {  //guardar los datos en un arreglo
                    return  $fila;
                }
            }
        }
        return false;
    }

    //funcion para listar los roles
    function ListarRoles()
    {
        $query = "SELECT * FROM tbl_ms_roles"; //sentencia sql
        $result = $this->cnx->prepare($query);
        if ($result->execute()) {
            if ($result->rowCount() > 0) { //validacion para verificar si trae datos
                while ($fila = $result->fetch(PDO::FETCH_ASSOC)) {  //guardar los datos en un arreglo
                    $datos[] = $fila;
                }
                return $datos;
            }
        }
        return false;
    }


    function ListarObjetos($esModulo = false, $idObjeto = false)
    {
        $filtro = $idObjeto ? ' and idObjetos=' . $idObjeto : '';
        $query = "SELECT * FROM tbl_ms_objetos" . ($esModulo ? ' where esModulo=1' : '') . $filtro; //sentencia sql
        $result = $this->cnx->prepare($query);
        if ($result->execute()) {
            if ($result->rowCount() > 0) { //validacion para verificar si trae datos
                while ($fila = $result->fetch(PDO::FETCH_ASSOC)) {  //guardar los datos en un arreglo
                    $datos[] = $fila;
                }
                return $datos;
            }
        }
        return false;
    }


    //FUNCION PARA REGISTRAr permisos
    function RegistrarPermiso($rol, $objeto, $insertar, $eliminar, $consultar, $actualizar, $reportes)
    {
        $query = "INSERT INTO tbl_ms_permisos(idRol, idObjeto, insertar, eliminar, consultar, actualizar,reportes) 
        VALUES (?,?,?,?,?,?,?)";
        $result = $this->cnx->prepare($query); //preparacion de la sentencia
        $result->bindParam(1, $rol);
        $result->bindParam(2, $objeto);
        $result->bindParam(3, $insertar);
        $result->bindParam(4, $eliminar);
        $result->bindParam(5, $consultar);
        $result->bindParam(6, $actualizar);
        $result->bindParam(7, $reportes);
        if ($result->execute()) { //validacion de la ejecucion
            return true;
        }

        return false; //si fallo se devuelvo false

    }

    //FUNCION PARA REGISTRAr permisos
    function ActualizarPermiso($id, $rol, $objeto, $insertar, $eliminar, $consultar, $actualizar,$reportes)
    {
        $query = "update tbl_ms_permisos set idRol=?, idObjeto=?, insertar=?, eliminar=?, consultar=?, actualizar=?, reportes=?
            where idPermiso=?";
        $result = $this->cnx->prepare($query); //preparacion de la sentencia

        $result->bindParam(1, $rol);
        $result->bindParam(2, $objeto);
        $result->bindParam(3, $insertar);
        $result->bindParam(4, $eliminar);
        $result->bindParam(5, $consultar);
        $result->bindParam(6, $actualizar);
        $result->bindParam(7, $reportes);
        $result->bindParam(8, $id);


        if ($result->execute()) { //validacion de la ejecucion
            return true;
        }

        return false; //si fallo se devuelvo false

    }
    function EliminarPermiso($id)
    {
        $query = "delete from tbl_ms_permisos where idPermiso=?";
        $result = $this->cnx->prepare($query); //preparacion de la sentencia
        $result->bindParam(1, $id);

        if ($result->execute()) { //validacion de la ejecucion
            return true;
        }

        return false; //si fallo se devuelvo false

    }

    function ObtenerPermisoPorId($idPermiso)
    {


        $query = "SELECT p.idPermiso,r.idRol, r.Rol,o.idObjetos, o.Objeto, p.insertar, p.eliminar, p.consultar, p.actualizar,p.reportes
                    FROM tbl_ms_permisos p
                    INNER JOIN tbl_ms_roles r ON p.idRol=r.idRol
                    INNER JOIN tbl_ms_objetos o ON p.idObjeto=o.idObjetos
                    WHERE p.idPermiso =?";
        $result = $this->cnx->prepare($query);
        $result->bindParam(1, $idPermiso);
        if ($result->execute()) {
            return $result->fetch(PDO::FETCH_ASSOC);
        }
        return false;
    }


    //FUNCION QUE trae el rol del usuario a actualizar
    function ListarRolesSelectEdit($idPermiso)
    {
        $query = "SELECT  p.idPermiso, r.idRol, r.Rol
                    FROM tbl_ms_permisos p
                    INNER JOIN tbl_ms_roles r ON p.idRol=r.idRol
                    WHERE p.idPermiso =?";
        $result = $this->cnx->prepare($query);
        $result->bindParam(1, $idPermiso);
        if ($result->execute()) {
            if ($result->rowCount() > 0) { //validacion para verificar si trae datos

                while ($fila = $result->fetch(PDO::FETCH_ASSOC)) {
                    $datos[] = $fila;
                }
                return $datos;
            }
        }
        return false;
    }
}
