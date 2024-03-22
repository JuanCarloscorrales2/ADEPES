<?php

require "../config/Conexion.php";

class Cliente {

    public $cnx; //variable publica para la conexion a la BD

    function __construct() //constructor
    {
        $this->cnx = Conexion::ConectarDB();
    }
    /***********************   CRUD   *********************************************************** */
    //funcion para listar los clientes
    function ListarClientes(){
        $query = "SELECT  solicitudes.idSolicitud,  personas.idPersona, concat(personas.nombres, ' ',personas.apellidos) as Nombre, identidad,  genero.Descripcion as genero, 
                    MAX(CASE WHEN tContacto.Descripcion = 'Celular cliente' THEN pContacto.Valor END) AS Telefono,
                    MAX(CASE WHEN tContacto.Descripcion = 'Direccion cliente' THEN pContacto.Valor END) AS Direccion, profesion.Descripcion as Profesion
                    FROM tbl_mn_personas personas
                    INNER JOIN tbl_mn_genero genero on genero.idGenero=personas.idGenero
                    INNER JOIN tbl_mn_profesiones_oficios profesion on profesion.idProfesion=personas.idProfesion
                    INNER JOIN tbl_mn_personas_contacto pContacto ON personas.idPersona = pContacto.idPersona
                    INNER JOIN tbl_mn_tipo_contacto tContacto ON tContacto.idTipoContacto = pContacto.idTipoContacto
                    INNER JOIN tbl_mn_solicitudes_creditos solicitudes ON personas.idPersona =solicitudes.idPersona
                    where personas.idPersona=pContacto.idPersona and solicitudes.idEstadoSolicitud IN(1,2,3)
                    GROUP BY concat(personas.nombres, ' ',personas.apellidos);"; 
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

        //funcion para listar los prestamos
        function ListarPrestamos(){
        $query = "SELECT  solicitudes.idSolicitud,  personas.idPersona, concat(personas.nombres, ' ',personas.apellidos) as Nombre,
                    prestamos.Descripcion as Prestamo, solicitudes.Monto, solicitudes.FechaAprob, solicitudes.Plazo, 
                    rubros.Descripcion as rubro, ep.Descripcion as Descripcion
                    FROM tbl_mn_personas personas
                    INNER JOIN tbl_mn_solicitudes_creditos solicitudes ON personas.idPersona =solicitudes.idPersona
                    INNER JOIN tbl_mn_rubros rubros on rubros.idRubro=solicitudes.idRubro
                    INNER JOIN tbl_mn_tipos_prestamos prestamos on prestamos.idTipoPrestamo=solicitudes.idTipoPrestamo
                    INNER JOIN tbl_mn_plan_pagos_cuota_nivelada  pl
                    INNER JOIN tbl_mn_estadoplanpagos ep ON ep.idEstadoPlanPagos=pl.idEstadoPlanPagos
                    where solicitudes.idEstadoSolicitud=1
                    GROUP BY concat(personas.nombres, ' ',personas.apellidos);"; 
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


    //funcion que valida que el cliente
    function ObtenerClientePorId($idPersona)
    {
        $query = "SELECT  solicitudes.idSolicitud, personas.idPersona, personas.nombres, personas.apellidos, identidad,  
        MAX(CASE WHEN tContacto.Descripcion = 'Celular cliente' THEN pContacto.Valor END) AS Telefono,
        MAX(CASE WHEN tContacto.Descripcion = 'Direccion cliente' THEN pContacto.Valor END) AS Direccion,
        solicitudes.Monto,  solicitudes.Plazo, solicitudes.FechaAprob, concat(solicitudes.tasa,'%') as tasa
        FROM tbl_mn_personas personas
        INNER JOIN tbl_mn_personas_contacto pContacto ON personas.idPersona = pContacto.idPersona
        INNER JOIN tbl_mn_tipo_contacto tContacto ON tContacto.idTipoContacto = pContacto.idTipoContacto
        INNER JOIN tbl_mn_solicitudes_creditos solicitudes ON personas.idPersona =solicitudes.idPersona
        where personas.idPersona=?"; 
        $result = $this->cnx->prepare($query);
        $result->bindParam(1,$idPersona);
        if($result->execute())
        {
           return $result->fetch(PDO::FETCH_ASSOC);
        }
        return false;
    }


      //funcion para actualizar cliente
      function ActualizarCliente($idPersona, $nombres, $apellidos, $contacto, $direccion) {
        // Actualiza tabla tbl_mn_persona
        $sql = "UPDATE tbl_mn_personas SET nombres = ?, apellidos = ? WHERE idPersona = ?";
        $resultCliente = $this->cnx->prepare($sql);
        $resultCliente->bindParam(1, $nombres);
        $resultCliente->bindParam(2, $apellidos);
        $resultCliente->bindParam(3, $idPersona);
    
        // actualiza los celular                 
        $sqlContacto = "UPDATE tbl_mn_personas_contacto SET valor = ? WHERE idPersona = ? and idTipoContacto = 1";
        $resultContacto = $this->cnx->prepare($sqlContacto);
        $resultContacto->bindParam(1, $contacto);
        $resultContacto->bindParam(2, $idPersona);

         // actualiza direccion              
         $sqlDireccion = "UPDATE tbl_mn_personas_contacto SET valor = ? WHERE idPersona = ? and idTipoContacto = 2";
         $resultDireccion = $this->cnx->prepare($sqlDireccion);
         $resultDireccion->bindParam(1, $direccion);
         $resultDireccion->bindParam(2, $idPersona);

    
       // Ejecutaa las actualizaciones
    try {
        $this->cnx->beginTransaction();

        // Ejecutar la actualización en tbl_mn_personas
        $resultCliente->execute();

        // Ejecuta la actualización en tbl_mn_personas_contacto
        $resultContacto->execute();
        
        //ejecuta la actualizacion en la tabla tbl_mn_personas_contacto
        $resultDireccion->execute();


        $this->cnx->commit();
        return true;  //se devuelve verdadero si se actualiza todo
    } catch (PDOException $e) {
        $this->cnx->rollback();  //si falla 
        return false;
    }
    
       
    }

    function PlanDePagos($idSolicitud)
    {
        $query = "SELECT pl.NumeroCuotas, pl.FechaCuota, pl.valorCuota, pl.valorInteres, pl.valorCapital, pl.saldoCapital, ep.Descripcion
                 FROM tbl_mn_plan_pagos_cuota_nivelada  pl
                     INNER JOIN tbl_mn_estadoplanpagos ep ON ep.idEstadoPlanPagos= pl.idEstadoPlanPagos
                    WHERE idSolicitud =?
                    ORDER BY pl.NumeroCuotas ASC"; 
        $result = $this->cnx->prepare($query);
        $result->bindParam(1,$idSolicitud);
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


    function ObtenerAvalPorId($idSolicitud)
    {
        $query = "SELECT  aval.idAval, aval.idSolicitud, aval.idPersona, concat(personas.nombres, ' ',personas.apellidos) as Nombre, identidad,  
                    MAX(CASE WHEN tContacto.Descripcion = 'Celular cliente' THEN pContacto.Valor END) AS Telefono,
                    MAX(CASE WHEN tContacto.Descripcion = 'Direccion cliente' THEN pContacto.Valor END) AS Direccion
                    FROM tbl_mn_avales aval    
                    INNER JOIN tbl_mn_personas personas ON aval.idPersona=personas.idPersona
                    INNER JOIN tbl_mn_personas_contacto pContacto ON personas.idPersona = pContacto.idPersona
                    INNER JOIN tbl_mn_tipo_contacto tContacto ON tContacto.idTipoContacto = pContacto.idTipoContacto
                    where aval.idSolicitud=?  
                    GROUP BY concat(personas.nombres, ' ',personas.apellidos)"; 
        $result = $this->cnx->prepare($query);
        $result->bindParam(1,$idSolicitud);
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


    //FUNCION PARA ELIMINAR UN  cliente
    function EliminarCliente($idPersona) {
        try {
            $query = "DELETE FROM tbl_mn_personas WHERE idPersona=?";
            $result = $this->cnx->prepare($query);
            $result->bindParam(1, $idPersona);
    
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





?>