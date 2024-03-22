<?php

require "../config/Conexion.php";

class Cobros {

    public $cnx; //variable publica para la conexion a la BD

    function __construct() //constructor
    {
        $this->cnx = Conexion::ConectarDB();
    }


    //funcion para listar los prestamos
    function ListarPrestamosCobros(){
        $query = "SELECT 
        sub.idSolicitud, 
        CONCAT(sub.nombres,' ',sub.apellidos) AS nombre, 
        sub.identidad,
        sub.Monto, 
        sub.Plazo,
        sub.fechaAprob, 
        sub.idEstadoPlanPagos
    FROM (
        SELECT 
            soli.idSolicitud, 
            persona.nombres, 
            persona.apellidos,
            persona.identidad,
            soli.Monto, 
            soli.Plazo, 
            soli.fechaAprob, 
            cobro.idEstadoPlanPagos,
            ROW_NUMBER() OVER(PARTITION BY soli.idSolicitud ORDER BY cobro.FechaCuota DESC) AS rn
        FROM  
            tbl_mn_solicitudes_creditos soli 
        INNER JOIN 
            tbl_mn_plan_pagos_cuota_nivelada cobro ON soli.idSolicitud =  cobro.idSolicitud
        INNER JOIN 
            tbl_mn_personas persona ON persona.idPersona = soli.idPersona 
    ) sub
    WHERE 
        sub.rn = 1;"; 

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


    //funcion para listar los prestamos
    function ListarCuotaPersona($idSolicitud,$next_pay){
        $extra_info=$next_pay?'and pagos is null and idEstadoPlanPagos <> 4 ORDER BY plan.NumeroCuotas ASC limit 1':'ORDER BY plan.NumeroCuotas ASC';
        $query = "SELECT plan.idPlanCuota, plan.NumeroCuotas, plan.FechaCuota, movi.fechaDeposito, movi.pagos, movi.pagoAdicional, plan.saldoCapital,
        plan.diasRetraso, plan.interesesMoratorios, plan.mora, plan.idEstadoPlanPagos
        FROM tbl_mn_plan_pagos_cuota_nivelada  plan
        LEFT JOIN tbl_mn_movimientos_financieros movi ON movi.idPlanCuota = plan.idPlanCuota
        WHERE plan.idSolicitud = ? {$extra_info}"; 

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


    //funcion que valida que el cliente
    function datosCliente($idSolicitud)
    {
        $query = "SELECT CONCAT(persona.nombres,' ',persona.apellidos) as cliente, persona.identidad,
        soli.Monto, soli.plazo, soli.FechaAprob, SUM(valorInteres) as totalInteres
         FROM tbl_mn_solicitudes_creditos soli
        INNER JOIN tbl_mn_personas persona ON persona.idPersona =  soli.idPersona
        INNER JOIN tbl_mn_plan_pagos_cuota_nivelada plan ON plan.idSolicitud =  soli.idSolicitud
        WHERE soli.idSolicitud = ?"; 
        $result = $this->cnx->prepare($query);
        $result->bindParam(1,$idSolicitud);
        if($result->execute())
        {
           return $result->fetch(PDO::FETCH_ASSOC);
        }
        return false;
    }

    //obtener cuota por id
     function ObtenerCuotaPorId($idPlanCuota)
     {
         $query = "SELECT idPlanCuota, NumeroCuotas, FechaCuota, valorCuota, valorInteres, valorCapital, mora
        FROM tbl_mn_plan_pagos_cuota_nivelada
        WHERE idPlanCuota = ?"; 
         $result = $this->cnx->prepare($query);
         $result->bindParam(1,$idPlanCuota);
         if($result->execute())
         {
            return $result->fetch(PDO::FETCH_ASSOC);
         }
         return false;
     }


    function AgregarPagoPlanCuotas($idPlanCuota, $fechaDeposito, $montoPago, $abonoCapital, $pagoAdicional,$idSolicitud) {
        try {
            $this->cnx->beginTransaction();
    
            $sqlPlanPagos = "UPDATE tbl_mn_plan_pagos_cuota_nivelada SET idEstadoPlanPagos = 2 WHERE idPlanCuota = ?";
            $resultPlanPagos = $this->cnx->prepare($sqlPlanPagos);
            $resultPlanPagos->bindParam(1, $idPlanCuota);
            $resultPlanPagos->execute();
    
            $sqlMovimiento = "INSERT INTO tbl_mn_movimientos_financieros (idPlanCuota, fechaDeposito, fechaPago,pagos, abonoCapital, pagoAdicional,idSolicitud) VALUES(?, ?,?, ?, ?, ?,?)";
            $resultMovimiento = $this->cnx->prepare($sqlMovimiento);
            $resultMovimiento->bindParam(1, $idPlanCuota);
            $resultMovimiento->bindParam(2, $fechaDeposito);
            $resultMovimiento->bindParam(3, $fechaDeposito);
            $resultMovimiento->bindParam(4, $montoPago);
            $resultMovimiento->bindParam(5, $abonoCapital);
            $resultMovimiento->bindParam(6, $pagoAdicional);
            $resultMovimiento->bindParam(7, $idSolicitud);
            $resultMovimiento->execute();

            //quita la mora si pago a tiempo POR FECHA DEPOSITO
            $sqlMora = "UPDATE tbl_mn_plan_pagos_cuota_nivelada AS plan
            LEFT JOIN tbl_mn_movimientos_financieros AS movi ON plan.idPlanCuota = movi.idPlanCuota
            SET plan.interesesMoratorios = null, plan.mora = null
            WHERE plan.idPlanCuota = ?
            AND movi.fechaDeposito <= plan.fechaCuota;";
            $resultMora = $this->cnx->prepare($sqlMora);
            $resultMora->bindParam(1, $idPlanCuota);
            $resultMora->execute();
    
            // Confirmar transacción después de que ambas consultas se ejecuten correctamente
            $this->cnx->commit();
            return true;
        } catch (PDOException $e) {
            $this->cnx->rollback();
            // Puedes hacer un registro del error $e->getMessage() o manejarlo de otra manera
            return $e;
        }
    }
    
    //funcion que trae el obono total del capital
    function ObtenerValorCapitalTotal($idSolicitud)
    {
        $query = "SELECT SUM(valorCapital) AS totalAbonoCapital FROM tbl_mn_plan_pagos_cuota_nivelada WHERE idSolicitud = ? AND idEstadoPlanpagos = 2;"; 
        $result = $this->cnx->prepare($query);
        $result->bindParam(1,$idSolicitud);
        if($result->execute())
        {
           return $result->fetch(PDO::FETCH_ASSOC);
        }
        return false;
    }

    function LiquidarPrestamo($idSolicitud, $fechaDeposito) {
        // Llamar al procedimiento almacenado liquidarPrestamo
        $query = "CALL liquidarPrestamo(?, ?)"; // Nombre del procedimiento almacenado y sus parámetros
        $stmt = $this->cnx->prepare($query);
        $stmt->bindParam(1, $idSolicitud, PDO::PARAM_INT);
        $stmt->bindParam(2, $fechaDeposito, PDO::PARAM_STR); // Cambiado a PARAM_STR para la fecha
    
        // Ejecutar el procedimiento almacenado
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
     


    
   




}





?>