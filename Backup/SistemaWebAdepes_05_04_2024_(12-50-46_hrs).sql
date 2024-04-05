-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 05-04-2024 a las 18:06:30
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `sistemawebadepes`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `liquidarPrestamo` (IN `idSolicitud_` INT, IN `fechaDeposito_` DATE)   BEGIN
    DECLARE v_idPlanCuota INT;
    DECLARE v_valorCapital DECIMAL(10, 2);
    DECLARE no_more_rows BOOLEAN DEFAULT FALSE; -- Variable para controlar el bucle

    -- Cursor para recorrer los resultados de la consulta
    DECLARE cur CURSOR FOR
        SELECT idPlanCuota, valorCapital 
        FROM tbl_mn_plan_pagos_cuota_nivelada 
        WHERE idSolicitud = idSolicitud_ AND (idEstadoPlanPagos = 1 OR idEstadoPlanPagos = 3);
    
    -- Manejo de errores
    DECLARE CONTINUE HANDLER FOR NOT FOUND SET no_more_rows = TRUE; -- Usar la nueva variable para controlar el bucle

    OPEN cur;
    read_loop: LOOP
        FETCH cur INTO v_idPlanCuota, v_valorCapital;
        IF no_more_rows THEN
            LEAVE read_loop;
        END IF;
        
        -- Insertar datos en la tabla tbl_mn_movimientos_financieros con la fecha de depósito proporcionada
        INSERT INTO tbl_mn_movimientos_financieros (idPlanCuota, pagos, abonoCapital, fechaDeposito) 
        VALUES (v_idPlanCuota, v_valorCapital, v_valorCapital, fechaDeposito_);
        
        -- Actualizar el estado a 2 en tbl_mn_plan_pagos_cuota_nivelada
        UPDATE tbl_mn_plan_pagos_cuota_nivelada SET idEstadoPlanPagos = 2 WHERE idPlanCuota = v_idPlanCuota;
    END LOOP;

    CLOSE cur;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_logs_bitacora`
--

CREATE TABLE `tbl_logs_bitacora` (
  `idBitacora` int(11) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `idObjetos` int(11) NOT NULL,
  `Accion` varchar(20) NOT NULL,
  `Descripcion` varchar(100) NOT NULL,
  `Fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `Ip` varchar(250) NOT NULL,
  `Usuario` varchar(50) NOT NULL,
  `FechaHora` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_logs_bitacora`
--

INSERT INTO `tbl_logs_bitacora` (`idBitacora`, `idUsuario`, `idObjetos`, `Accion`, `Descripcion`, `Fecha`, `Ip`, `Usuario`, `FechaHora`) VALUES
(91, 1, 1, 'Salio', 'Salio del Sistema', '2024-04-05 02:06:02', 'localhost', 'root@localhost', '2024-04-04 20:19:06');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_mn_analisis_crediticio`
--

CREATE TABLE `tbl_mn_analisis_crediticio` (
  `idAnalisisCrediticio` int(11) NOT NULL,
  `idSolicitud` int(11) NOT NULL,
  `idPersona` int(11) NOT NULL,
  `idEstadoAnalisisCrediticio` int(11) NOT NULL,
  `sueldoBase` decimal(8,2) DEFAULT NULL,
  `ingresosNegocio` decimal(8,2) DEFAULT NULL,
  `rentaPropiedad` decimal(8,2) DEFAULT NULL,
  `remesas` decimal(8,2) DEFAULT NULL,
  `aporteConyugue` decimal(8,2) DEFAULT NULL,
  `ingresosSociedad` decimal(8,2) DEFAULT NULL,
  `cuotaPrestamoAdepes` decimal(8,2) DEFAULT NULL,
  `cuotaVivienda` decimal(8,2) DEFAULT NULL,
  `alimentacion` decimal(8,2) DEFAULT NULL,
  `deduccionesCentralRiesgo` decimal(8,2) DEFAULT NULL,
  `otrosEgresos` decimal(8,2) DEFAULT NULL,
  `LiquidezCliente` decimal(8,2) DEFAULT NULL,
  `Descripcion` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_mn_analisis_crediticio`
--

INSERT INTO `tbl_mn_analisis_crediticio` (`idAnalisisCrediticio`, `idSolicitud`, `idPersona`, `idEstadoAnalisisCrediticio`, `sueldoBase`, `ingresosNegocio`, `rentaPropiedad`, `remesas`, `aporteConyugue`, `ingresosSociedad`, `cuotaPrestamoAdepes`, `cuotaVivienda`, `alimentacion`, `deduccionesCentralRiesgo`, `otrosEgresos`, `LiquidezCliente`, `Descripcion`) VALUES
(1, 1, 1, 1, 6000.00, 12000.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 3000.00, 0.00, 0.00, 13431.72, 'CLIENTE TIENE CAPACIDAD DE PAGO, PARA EL MONTO QUE ESTA SOLICITANDO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_mn_avala_a_persona`
--

CREATE TABLE `tbl_mn_avala_a_persona` (
  `idEsAval` int(11) NOT NULL,
  `Descripcion` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_mn_avala_a_persona`
--

INSERT INTO `tbl_mn_avala_a_persona` (`idEsAval`, `Descripcion`) VALUES
(1, 'NO ES AVAL'),
(2, 'AVALA 1 PERSONA'),
(3, 'AVALA 2 PERSONAS'),
(4, 'AVALA MAS DE 2 PERSONAS');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_mn_avales`
--

CREATE TABLE `tbl_mn_avales` (
  `idAval` int(11) NOT NULL,
  `idSolicitud` int(11) NOT NULL,
  `idPersona` int(11) NOT NULL,
  `CreadoPor` varchar(15) NOT NULL,
  `FechaCreacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `ModificadoPor` varchar(15) DEFAULT NULL,
  `FechaModificacion` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_mn_categoria_casa`
--

CREATE TABLE `tbl_mn_categoria_casa` (
  `idcategoriaCasa` int(11) NOT NULL,
  `descripcion` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_mn_categoria_casa`
--

INSERT INTO `tbl_mn_categoria_casa` (`idcategoriaCasa`, `descripcion`) VALUES
(1, 'Propia'),
(2, 'Alquila'),
(3, 'Familiar');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_mn_contrato`
--

CREATE TABLE `tbl_mn_contrato` (
  `idContrato` int(11) NOT NULL,
  `idSolicitud` int(11) NOT NULL,
  `contratoCredito` text DEFAULT NULL,
  `fianzaSolidaria` text DEFAULT NULL,
  `pagare` text DEFAULT NULL,
  `porAvales` text DEFAULT NULL,
  `emisionCheque` text DEFAULT NULL,
  `cuenta` text DEFAULT NULL,
  `adicional` text DEFAULT NULL,
  `CreadoPor` varchar(15) NOT NULL,
  `FechaCreacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `ModificadoPor` varchar(15) DEFAULT NULL,
  `FechaModificacion` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_mn_contrato`
--

INSERT INTO `tbl_mn_contrato` (`idContrato`, `idSolicitud`, `contratoCredito`, `fianzaSolidaria`, `pagare`, `porAvales`, `emisionCheque`, `cuenta`, `adicional`, `CreadoPor`, `FechaCreacion`, `ModificadoPor`, `FechaModificacion`) VALUES
(1, 1, '<p style=\"text-align: center;\">CONTRATO</p>', '<p style=\"text-align: center;\">FIANZA SOLIDARIA</p>', '<p style=\"text-align: center;\">PAGAR&Eacute;</p>', '', '<p style=\"text-align: center;\">CHEQUES</p>', '', '', 'ADMIN', '2024-04-04 16:41:37', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_mn_conyugues`
--

CREATE TABLE `tbl_mn_conyugues` (
  `idConyuge` int(11) NOT NULL,
  `idSolicitud` int(11) NOT NULL,
  `idPersona` int(11) NOT NULL,
  `ingresosNegocio` decimal(8,2) DEFAULT NULL,
  `sueldoBase` decimal(8,2) DEFAULT NULL,
  `gastoAlimentacion` decimal(8,2) DEFAULT NULL,
  `idPersonaPareja` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_mn_credito_aval`
--

CREATE TABLE `tbl_mn_credito_aval` (
  `idCreditoAval` int(11) NOT NULL,
  `Descripcion` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_mn_credito_aval`
--

INSERT INTO `tbl_mn_credito_aval` (`idCreditoAval`, `Descripcion`) VALUES
(1, 'CREDITO(S) AL DIA'),
(2, '1 AVAL EN MORA'),
(3, '2 AVALES EN MORA'),
(4, '3 AVALES EN MORA'),
(5, '4 AVALES EN MORA');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_mn_estadocivil`
--

CREATE TABLE `tbl_mn_estadocivil` (
  `idEstadoCivil` int(11) NOT NULL,
  `Descripcion` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_mn_estadocivil`
--

INSERT INTO `tbl_mn_estadocivil` (`idEstadoCivil`, `Descripcion`) VALUES
(1, 'SOLTERO'),
(2, 'CASADO'),
(3, 'UNION LIBRE'),
(4, 'NO ESTA DEFINIDO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_mn_estadoplanpagos`
--

CREATE TABLE `tbl_mn_estadoplanpagos` (
  `idEstadoPlanPagos` int(11) NOT NULL,
  `Descripcion` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_mn_estadoplanpagos`
--

INSERT INTO `tbl_mn_estadoplanpagos` (`idEstadoPlanPagos`, `Descripcion`) VALUES
(1, 'PENDIENTE'),
(2, 'CANCELADO'),
(3, 'MORA'),
(4, 'CANCELADA POR PAGO ANTICIPADO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_mn_estados_solicitudes`
--

CREATE TABLE `tbl_mn_estados_solicitudes` (
  `idEstadoSolicitud` int(11) NOT NULL,
  `Descripcion` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_mn_estados_solicitudes`
--

INSERT INTO `tbl_mn_estados_solicitudes` (`idEstadoSolicitud`, `Descripcion`) VALUES
(1, 'APROBADA'),
(2, 'DENEGADA'),
(3, 'PENDIENTE'),
(4, 'CONTRATO APROBADO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_mn_estadotipoprestamo`
--

CREATE TABLE `tbl_mn_estadotipoprestamo` (
  `idestadoTipoPrestamo` int(11) NOT NULL,
  `descripcion` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_mn_estadotipoprestamo`
--

INSERT INTO `tbl_mn_estadotipoprestamo` (`idestadoTipoPrestamo`, `descripcion`) VALUES
(1, 'ACTIVO'),
(2, 'INACTIVO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_mn_estado_analisiscrediticio`
--

CREATE TABLE `tbl_mn_estado_analisiscrediticio` (
  `idestadoAnalisisCrediticio` int(11) NOT NULL,
  `descripcion` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_mn_estado_analisiscrediticio`
--

INSERT INTO `tbl_mn_estado_analisiscrediticio` (`idestadoAnalisisCrediticio`, `descripcion`) VALUES
(1, 'APROBADO'),
(2, 'NO APROBADO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_mn_estado_credito`
--

CREATE TABLE `tbl_mn_estado_credito` (
  `idEstadoCredito` int(11) NOT NULL,
  `Descripcion` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_mn_estado_credito`
--

INSERT INTO `tbl_mn_estado_credito` (`idEstadoCredito`, `Descripcion`) VALUES
(1, 'CON PAGO NORMAL'),
(2, 'CON PAGO REGULAR'),
(3, 'CON PAGO IRREGULAR');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_mn_genero`
--

CREATE TABLE `tbl_mn_genero` (
  `idGenero` int(11) NOT NULL,
  `Descripcion` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_mn_genero`
--

INSERT INTO `tbl_mn_genero` (`idGenero`, `Descripcion`) VALUES
(1, 'FEMENINO'),
(2, 'MASCULINO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_mn_movimientos_financieros`
--

CREATE TABLE `tbl_mn_movimientos_financieros` (
  `idMovimientoFinanciero` int(11) NOT NULL,
  `idPlanCuota` int(11) NOT NULL,
  `fechaDeposito` date NOT NULL,
  `saldoInicial` decimal(8,2) NOT NULL DEFAULT 0.00,
  `pagos` decimal(8,2) DEFAULT NULL,
  `pagoAdicional` decimal(8,2) DEFAULT 0.00,
  `abonoCapital` decimal(8,2) NOT NULL,
  `flujoCaja` decimal(8,2) NOT NULL DEFAULT 0.00,
  `fechaPago` date DEFAULT NULL,
  `idSolicitud` int(11) DEFAULT NULL,
  `CreadoPor` varchar(15) NOT NULL,
  `FechaCreacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `ModificadoPor` varchar(15) DEFAULT NULL,
  `FechaModificacion` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_mn_movimientos_financieros`
--

INSERT INTO `tbl_mn_movimientos_financieros` (`idMovimientoFinanciero`, `idPlanCuota`, `fechaDeposito`, `saldoInicial`, `pagos`, `pagoAdicional`, `abonoCapital`, `flujoCaja`, `fechaPago`, `idSolicitud`, `CreadoPor`, `FechaCreacion`, `ModificadoPor`, `FechaModificacion`) VALUES
(1, 15, '2024-04-04', 0.00, 1568.28, 431.72, 1449.92, 0.00, '2024-04-04', 1, '', '2024-04-04 19:18:03', NULL, NULL),
(2, 16, '2024-04-04', 0.00, 1568.28, 0.00, 1460.76, 0.00, '2024-04-04', 1, '', '2024-04-04 22:55:12', NULL, NULL),
(3, 17, '2024-04-04', 0.00, 1568.28, 0.00, 1478.63, 0.00, '2024-04-04', 1, '', '2024-04-04 23:26:23', NULL, NULL);

--
-- Disparadores `tbl_mn_movimientos_financieros`
--
DELIMITER $$
CREATE TRIGGER `actualizar_plan_pago` BEFORE INSERT ON `tbl_mn_movimientos_financieros` FOR EACH ROW begin
 	DECLARE done INT DEFAULT FALSE;
    DECLARE counter int;
 	DECLARE saldo_anterior double;
    DECLARE saldo_capital double;
      DECLARE pago_adicional double;
    DECLARE valor_capital double;
 	DECLARE cursor_id_cuota int;
 	declare cursor_cuotas CURSOR FOR SELECT idPlanCuota,saldoCapital,valorCapital FROM tbl_mn_plan_pagos_cuota_nivelada dr where idPlanCuota>=new.idPlanCuota and idSolicitud=new.idSolicitud;
 	
    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;
    
     OPEN cursor_cuotas;
      loop_through_rows:LOOP
        FETCH cursor_cuotas INTO cursor_id_cuota,saldo_capital,valor_capital;
        IF done THEN
          LEAVE loop_through_rows;
        END IF;
         SELECT count(*) INTO counter FROM tbl_mn_plan_pagos_cuota_nivelada WHERE idPlanCuota = (cursor_id_cuota-1)and idSolicitud=new.idSolicitud;
         if counter>0 then 
			 if new.idPlanCuota=cursor_id_cuota then
				SET pago_adicional := new.pagoAdicional;
			 else 
				SET pago_adicional := 0;
			 end if;
			 SELECT ifnull(saldoCapital,0) INTO saldo_anterior FROM tbl_mn_plan_pagos_cuota_nivelada WHERE idPlanCuota = (cursor_id_cuota-1);
			  update tbl_mn_plan_pagos_cuota_nivelada set saldoCapital=(saldo_anterior-(valor_capital+pago_adicional)) where idPlanCuota=cursor_id_cuota and idSolicitud=new.idSolicitud;
	else
     update tbl_mn_plan_pagos_cuota_nivelada set saldoCapital=saldoCapital-(valorCapital+new.pagoAdicional) where idPlanCuota=cursor_id_cuota and idSolicitud=new.idSolicitud;
        end if;
		SIGNAL SQLSTATE '01000' SET MESSAGE_TEXT = saldo_capital, MYSQL_ERRNO = 1000;

      
       
       if (saldo_anterior-(new.abonoCapital+pago_adicional))<0 and saldo_anterior< new.pagos and saldo_anterior>0 then 
			update tbl_mn_plan_pagos_cuota_nivelada set valorCuota=valorInteres+saldo_anterior,valorCapital=ifnull(saldo_anterior,valorCapital) where idPlanCuota=cursor_id_cuota;
            update tbl_mn_plan_pagos_cuota_nivelada set saldoCapital=(ifnull(saldo_anterior,saldoCapital)-valorCapital) where idPlanCuota=cursor_id_cuota;
        end if;
    
      END LOOP;
       CLOSE cursor_cuotas;
      update  tbl_mn_plan_pagos_cuota_nivelada set idEstadoPlanPagos=4,saldoCapital=0 where saldoCapital<0 and idSolicitud=new.idSolicitud;
        /*   IF NEW.pagoAdicional > 0 THEN
		UPDATE tbl_mn_plan_pagos_cuota_nivelada SET saldoCapital=(saldoCapital-NEW.pagoAdicional) where idPlanCuota=new.idPlanCuota;
	END IF; */
       end
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_mn_municipio`
--

CREATE TABLE `tbl_mn_municipio` (
  `idMunicipio` int(11) NOT NULL,
  `Descripcion` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_mn_municipio`
--

INSERT INTO `tbl_mn_municipio` (`idMunicipio`, `Descripcion`) VALUES
(1, 'PESPIRE'),
(2, 'SAN ANTONIO DE FLORES'),
(3, 'SAN ISIDRO'),
(4, 'SAN JOSE');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_mn_nacionalidades`
--

CREATE TABLE `tbl_mn_nacionalidades` (
  `idNacionalidad` int(11) NOT NULL,
  `Descripcion` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_mn_nacionalidades`
--

INSERT INTO `tbl_mn_nacionalidades` (`idNacionalidad`, `Descripcion`) VALUES
(1, 'HONDUREÑA');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_mn_parentesco`
--

CREATE TABLE `tbl_mn_parentesco` (
  `idParentesco` int(11) NOT NULL,
  `descripcion` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_mn_parentesco`
--

INSERT INTO `tbl_mn_parentesco` (`idParentesco`, `descripcion`) VALUES
(1, 'Hermano (a)'),
(2, 'Abuelo (a)'),
(3, 'Tio (a)');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_mn_personas`
--

CREATE TABLE `tbl_mn_personas` (
  `idPersona` int(11) NOT NULL,
  `idTipoPersona` int(11) NOT NULL,
  `idNacionalidad` int(11) NOT NULL,
  `idGenero` int(11) NOT NULL,
  `idEstadoCivil` int(11) NOT NULL,
  `idProfesion` int(11) NOT NULL,
  `idPersonaBienes` int(11) DEFAULT NULL,
  `idTipoClientes` int(11) NOT NULL,
  `idcategoriaCasa` int(11) NOT NULL,
  `idtiempoVivir` int(11) NOT NULL,
  `idTiempoLaboral` int(11) NOT NULL,
  `PagaAlquiler` int(11) NOT NULL,
  `estadoCredito` int(11) NOT NULL,
  `esAval` int(11) NOT NULL,
  `avalMora` int(11) NOT NULL,
  `idMunicipio` int(11) NOT NULL,
  `nombres` varchar(45) NOT NULL,
  `apellidos` varchar(45) NOT NULL,
  `identidad` varchar(15) NOT NULL,
  `fechaNacimiento` date NOT NULL,
  `valorPagoAlquiler` decimal(8,2) DEFAULT NULL,
  `PratronoNegocio` varchar(30) DEFAULT NULL,
  `cargoDesempena` varchar(30) DEFAULT NULL,
  `ObservacionesSolicitud` varchar(120) DEFAULT NULL,
  `CreadoPor` varchar(15) NOT NULL,
  `FechaCreacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `ModificadoPor` varchar(15) DEFAULT NULL,
  `FechaModificacion` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_mn_personas`
--

INSERT INTO `tbl_mn_personas` (`idPersona`, `idTipoPersona`, `idNacionalidad`, `idGenero`, `idEstadoCivil`, `idProfesion`, `idPersonaBienes`, `idTipoClientes`, `idcategoriaCasa`, `idtiempoVivir`, `idTiempoLaboral`, `PagaAlquiler`, `estadoCredito`, `esAval`, `avalMora`, `idMunicipio`, `nombres`, `apellidos`, `identidad`, `fechaNacimiento`, `valorPagoAlquiler`, `PratronoNegocio`, `cargoDesempena`, `ObservacionesSolicitud`, `CreadoPor`, `FechaCreacion`, `ModificadoPor`, `FechaModificacion`) VALUES
(1, 1, 1, 1, 1, 7, 4, 3, 1, 5, 5, 1, 1, 1, 1, 1, 'LUISA ', 'COTO', '1705-1999-00089', '1999-07-01', NULL, 'PROPIO', 'NEGOCIO', 'CON PROBABILIDAD DE PAGO', 'ADMIN', '2024-04-04 16:39:21', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_mn_personas_bienes`
--

CREATE TABLE `tbl_mn_personas_bienes` (
  `idPersonaBienes` int(11) NOT NULL,
  `Descripcion` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_mn_personas_bienes`
--

INSERT INTO `tbl_mn_personas_bienes` (`idPersonaBienes`, `Descripcion`) VALUES
(1, 'CASA'),
(2, 'VEHICULO'),
(3, 'TERRENO'),
(4, 'CASA, VEHICULO, TERRENO'),
(5, 'CASA, TERRENO'),
(6, 'VEHICULO, CASA'),
(7, 'TERRENO, VEHICULO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_mn_personas_contacto`
--

CREATE TABLE `tbl_mn_personas_contacto` (
  `idPersonaContacto` int(11) NOT NULL,
  `idPersona` int(11) NOT NULL,
  `idTipoContacto` int(11) NOT NULL,
  `valor` varchar(120) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_mn_personas_contacto`
--

INSERT INTO `tbl_mn_personas_contacto` (`idPersonaContacto`, `idPersona`, `idTipoContacto`, `valor`) VALUES
(26, 1, 1, '3345-6787'),
(27, 1, 2, 'COL ELVEL '),
(28, 1, 3, '2345-6789'),
(29, 1, 4, 'SANTA MARIA'),
(30, 1, 5, '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_mn_personas_cuenta`
--

CREATE TABLE `tbl_mn_personas_cuenta` (
  `idNumeroCuenta` int(11) NOT NULL,
  `idPersona` int(11) NOT NULL,
  `idTipoCuenta` int(11) NOT NULL,
  `NumeroCuenta` varchar(20) DEFAULT NULL,
  `FechaCreacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_mn_personas_cuenta`
--

INSERT INTO `tbl_mn_personas_cuenta` (`idNumeroCuenta`, `idPersona`, `idTipoCuenta`, `NumeroCuenta`, `FechaCreacion`) VALUES
(1, 1, 1, '', '2024-04-04 16:39:21');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_mn_personas_dependientes`
--

CREATE TABLE `tbl_mn_personas_dependientes` (
  `idDependientes` int(11) NOT NULL,
  `idPersona` int(11) NOT NULL,
  `idParentesco` int(11) NOT NULL,
  `nombre` varchar(120) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_mn_personas_dependientes`
--

INSERT INTO `tbl_mn_personas_dependientes` (`idDependientes`, `idPersona`, `idParentesco`, `nombre`) VALUES
(4, 1, 1, 'NO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_mn_plan_pagos_cuota_nivelada`
--

CREATE TABLE `tbl_mn_plan_pagos_cuota_nivelada` (
  `idPlanCuota` int(11) NOT NULL,
  `idPersona` int(11) DEFAULT NULL,
  `idSolicitud` int(11) NOT NULL,
  `idEstadoPlanPagos` int(11) NOT NULL,
  `monto` decimal(8,2) NOT NULL,
  `cantidadCuotas` int(11) NOT NULL,
  `tasaInteresAnual` decimal(8,2) NOT NULL,
  `plazo` int(11) NOT NULL,
  `NumeroCuotas` int(11) NOT NULL,
  `FechaCuota` date NOT NULL,
  `valorCuota` decimal(8,2) NOT NULL DEFAULT 0.00,
  `valorInteres` decimal(8,2) NOT NULL,
  `valorCapital` decimal(8,2) NOT NULL,
  `saldoCapital` decimal(8,2) NOT NULL,
  `diasRetraso` int(11) DEFAULT NULL,
  `estadoPago` tinyint(4) DEFAULT NULL,
  `intereses` decimal(8,2) DEFAULT NULL,
  `tasaInteresMoratorio` decimal(8,2) DEFAULT NULL,
  `interesesMoratorios` decimal(8,2) DEFAULT NULL,
  `mora` decimal(8,2) DEFAULT NULL,
  `CreadoPor` varchar(15) NOT NULL,
  `FechaCreacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `ModificadoPor` varchar(15) DEFAULT NULL,
  `FechaModificacion` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_mn_plan_pagos_cuota_nivelada`
--

INSERT INTO `tbl_mn_plan_pagos_cuota_nivelada` (`idPlanCuota`, `idPersona`, `idSolicitud`, `idEstadoPlanPagos`, `monto`, `cantidadCuotas`, `tasaInteresAnual`, `plazo`, `NumeroCuotas`, `FechaCuota`, `valorCuota`, `valorInteres`, `valorCapital`, `saldoCapital`, `diasRetraso`, `estadoPago`, `intereses`, `tasaInteresMoratorio`, `interesesMoratorios`, `mora`, `CreadoPor`, `FechaCreacion`, `ModificadoPor`, `FechaModificacion`) VALUES
(15, NULL, 1, 2, 12000.00, 8, 12.00, 8, 1, '2024-05-04', 1568.28, 118.36, 1449.92, 8668.44, NULL, NULL, NULL, NULL, NULL, NULL, '', '2024-04-04 19:18:03', NULL, NULL),
(16, NULL, 1, 2, 12000.00, 8, 12.00, 8, 2, '2024-06-04', 1568.28, 107.52, 1460.76, 7207.68, NULL, NULL, NULL, NULL, NULL, NULL, '', '2024-04-04 22:55:12', NULL, NULL),
(17, NULL, 1, 2, 12000.00, 8, 12.00, 8, 3, '2024-07-04', 1568.28, 89.65, 1478.63, 5729.05, NULL, NULL, NULL, NULL, NULL, NULL, '', '2024-04-04 23:26:23', NULL, NULL),
(18, NULL, 1, 1, 12000.00, 8, 12.00, 8, 4, '2024-08-04', 1568.28, 77.57, 1490.71, 4238.34, NULL, NULL, NULL, NULL, NULL, NULL, '', '2024-04-04 19:18:03', NULL, NULL),
(19, NULL, 1, 1, 12000.00, 8, 12.00, 8, 5, '2024-09-04', 1568.28, 62.37, 1505.91, 2732.43, NULL, NULL, NULL, NULL, NULL, NULL, '', '2024-04-04 19:18:03', NULL, NULL),
(20, NULL, 1, 1, 12000.00, 8, 12.00, 8, 6, '2024-10-04', 1568.28, 45.51, 1522.77, 1209.66, NULL, NULL, NULL, NULL, NULL, NULL, '', '2024-04-04 19:18:03', NULL, NULL),
(21, NULL, 1, 1, 12000.00, 8, 12.00, 8, 7, '2024-11-04', 1241.17, 31.51, 1209.66, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, '', '2024-04-04 19:18:03', NULL, NULL),
(22, NULL, 1, 4, 12000.00, 8, 12.00, 8, 8, '2024-12-04', 1568.28, 15.33, 1554.53, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, '', '2024-04-04 23:26:23', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_mn_profesiones_oficios`
--

CREATE TABLE `tbl_mn_profesiones_oficios` (
  `idProfesion` int(11) NOT NULL,
  `Descripcion` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_mn_profesiones_oficios`
--

INSERT INTO `tbl_mn_profesiones_oficios` (`idProfesion`, `Descripcion`) VALUES
(1, 'COMERCIANTE INDIVIDUAL'),
(2, 'CARPINTERO'),
(3, 'AGRICULTOR'),
(4, 'ASEADOR'),
(5, 'SOLDADOR'),
(6, 'ELECTRICISTA'),
(7, 'INFORMATICA'),
(8, 'APICULTOR'),
(9, 'CHOFER'),
(10, 'VENDEDOR'),
(11, 'AMA DE CASA'),
(12, 'EMPRESARIO'),
(13, 'PRUEBA TRE');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_mn_referencias_comerciales`
--

CREATE TABLE `tbl_mn_referencias_comerciales` (
  `idReferenciaComercial` int(11) NOT NULL,
  `idPersona` int(11) NOT NULL,
  `nombre` varchar(120) DEFAULT NULL,
  `direccion` varchar(120) DEFAULT NULL,
  `CreadoPor` varchar(15) NOT NULL,
  `FechaCreacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `ModificadoPor` varchar(15) DEFAULT NULL,
  `FechaModificacion` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_mn_referencias_familiares`
--

CREATE TABLE `tbl_mn_referencias_familiares` (
  `idReferencia` int(11) NOT NULL,
  `idPersona` int(11) NOT NULL,
  `idParentesco` int(11) NOT NULL,
  `nombre` varchar(120) DEFAULT NULL,
  `celular` varchar(9) DEFAULT NULL,
  `direccion` varchar(120) DEFAULT NULL,
  `CreadoPor` varchar(15) NOT NULL,
  `FechaCreacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `ModificadoPor` varchar(15) DEFAULT NULL,
  `FechaModificacion` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_mn_referencias_familiares`
--

INSERT INTO `tbl_mn_referencias_familiares` (`idReferencia`, `idPersona`, `idParentesco`, `nombre`, `celular`, `direccion`, `CreadoPor`, `FechaCreacion`, `ModificadoPor`, `FechaModificacion`) VALUES
(1, 1, 1, 'HEDMAN RUIZ', '8790-5432', 'LA VIÑA', 'ADMIN', '2024-04-04 16:39:21', NULL, NULL),
(2, 1, 1, '', '', '', 'ADMIN', '2024-04-04 16:39:21', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_mn_rubros`
--

CREATE TABLE `tbl_mn_rubros` (
  `idRubro` int(11) NOT NULL,
  `Descripcion` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_mn_rubros`
--

INSERT INTO `tbl_mn_rubros` (`idRubro`, `Descripcion`) VALUES
(1, 'Agropecuario'),
(2, 'Comercio'),
(3, 'Servicio'),
(4, 'Transformacion');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_mn_solicitudes_creditos`
--

CREATE TABLE `tbl_mn_solicitudes_creditos` (
  `idSolicitud` int(11) NOT NULL,
  `idPersona` int(11) NOT NULL,
  `idTipoPrestamo` int(11) NOT NULL,
  `idRubro` int(11) NOT NULL,
  `idEstadoSolicitud` int(11) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `Monto` decimal(8,2) NOT NULL,
  `tasa` decimal(4,2) NOT NULL,
  `Plazo` int(11) NOT NULL,
  `fechaDesembolso` date NOT NULL,
  `invierteEn` varchar(120) NOT NULL,
  `dictamenAsesor` varchar(100) DEFAULT NULL,
  `fechaAprob` datetime DEFAULT NULL,
  `numeroActa` int(11) DEFAULT NULL,
  `prestamoAprobados` varchar(120) DEFAULT NULL,
  `CreadoPor` varchar(15) NOT NULL,
  `FechaCreacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `ModificadoPor` varchar(15) DEFAULT NULL,
  `FechaModificacion` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_mn_solicitudes_creditos`
--

INSERT INTO `tbl_mn_solicitudes_creditos` (`idSolicitud`, `idPersona`, `idTipoPrestamo`, `idRubro`, `idEstadoSolicitud`, `idUsuario`, `Monto`, `tasa`, `Plazo`, `fechaDesembolso`, `invierteEn`, `dictamenAsesor`, `fechaAprob`, `numeroActa`, `prestamoAprobados`, `CreadoPor`, `FechaCreacion`, `ModificadoPor`, `FechaModificacion`) VALUES
(1, 1, 1, 2, 4, 1, 12000.00, 12.00, 8, '2024-04-04', 'MEJORA DE NEGOCIO', NULL, '2024-04-04 00:00:00', 2, 'ES SU PRIMER CRÉDITO EN EL FONDO ROTATORIO', 'ADMIN', '2024-04-04 16:39:21', NULL, NULL);

--
-- Disparadores `tbl_mn_solicitudes_creditos`
--
DELIMITER $$
CREATE TRIGGER `generar_plan_de_pagos` AFTER UPDATE ON `tbl_mn_solicitudes_creditos` FOR EACH ROW BEGIN
    DECLARE monto_total DECIMAL(8, 2);
    DECLARE numero_cuotas INT;
    DECLARE fecha_pago DATE;
    DECLARE tasa_interes DECIMAL(4, 2);
    DECLARE cuota_mensual DECIMAL(8, 2);
    DECLARE saldo_actual DECIMAL(8, 2);
    DECLARE i INT;
    DECLARE fecha_anterior DATE; 
    DECLARE valor_interes DECIMAL(8, 2); 
    DECLARE valor_capital DECIMAL(8, 2); 

    
    SET monto_total = new.Monto;
    SET numero_cuotas = new.Plazo;
    SET tasa_interes = new.tasa;
    SET fecha_pago = DATE_ADD(New.fechaAprob, INTERVAL 1 MONTH);

    
    SET cuota_mensual = (monto_total * tasa_interes) / (12 * 100) / (1 - POW(1 + (tasa_interes / 1200), -numero_cuotas));

    
    SET saldo_actual = monto_total;
    SET fecha_anterior = New.fechaAprob;

    
    SET i = 1;

    IF NEW.idEstadoSolicitud = 4 THEN
        WHILE i <= numero_cuotas DO
            
            SET valor_interes = saldo_actual * (tasa_interes / 100) / 365 * DATEDIFF(fecha_pago, fecha_anterior);

            
            IF i = numero_cuotas THEN
                SET valor_capital = saldo_actual;
            ELSE
                SET valor_capital = cuota_mensual - valor_interes;
            END IF;

            INSERT INTO tbl_mn_plan_pagos_cuota_nivelada (idSolicitud, idEstadoPlanPagos, monto, cantidadCuotas, tasaInteresAnual, plazo, FechaCuota, valorCuota, NumeroCuotas, valorInteres, valorCapital, saldoCapital)
            VALUES (NEW.idSolicitud, 1, NEW.Monto, NEW.Plazo, NEW.tasa, NEW.Plazo, fecha_pago, cuota_mensual, i, valor_interes, valor_capital, saldo_actual - valor_capital);

            SET fecha_anterior = fecha_pago; 
            SET fecha_pago = DATE_ADD(fecha_pago, INTERVAL 1 MONTH);
            SET saldo_actual = saldo_actual - valor_capital;
            SET i = i + 1;
        END WHILE;
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_mn_tiempo_laboral`
--

CREATE TABLE `tbl_mn_tiempo_laboral` (
  `idTiempoLaboral` int(11) NOT NULL,
  `descripcion` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_mn_tiempo_laboral`
--

INSERT INTO `tbl_mn_tiempo_laboral` (`idTiempoLaboral`, `descripcion`) VALUES
(1, '1 AÑO'),
(2, '2 AÑOS'),
(3, '3 AÑOS'),
(4, '4 AÑOS'),
(5, 'MAS DE 5 AÑOS'),
(6, 'NO LABORA');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_mn_tiempo_vivir`
--

CREATE TABLE `tbl_mn_tiempo_vivir` (
  `idtiempoVivir` int(11) NOT NULL,
  `descripcion` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_mn_tiempo_vivir`
--

INSERT INTO `tbl_mn_tiempo_vivir` (`idtiempoVivir`, `descripcion`) VALUES
(1, '1 AÑO'),
(2, '2 AÑOS'),
(3, '3 AÑOS'),
(4, '4 AÑOS'),
(5, 'MAS DE 5 AÑOS');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_mn_tipos_de_pago`
--

CREATE TABLE `tbl_mn_tipos_de_pago` (
  `idTipoPago` int(11) NOT NULL,
  `descripcion` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_mn_tipos_de_pago`
--

INSERT INTO `tbl_mn_tipos_de_pago` (`idTipoPago`, `descripcion`) VALUES
(1, 'NO REALIZA PAGO'),
(2, 'SEMANAL'),
(3, 'QUINCENAL'),
(4, 'MENSUAL');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_mn_tipos_prestamos`
--

CREATE TABLE `tbl_mn_tipos_prestamos` (
  `idTipoPrestamo` int(11) NOT NULL,
  `idEstadoTipoPrestamo` int(11) NOT NULL,
  `Descripcion` varchar(15) NOT NULL,
  `tasa` decimal(4,2) NOT NULL,
  `PlazoMaximo` int(11) NOT NULL,
  `montoMaximo` decimal(8,2) NOT NULL,
  `montoMinimo` decimal(8,2) NOT NULL,
  `CreadoPor` varchar(15) NOT NULL,
  `FechaCreacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `ModificadoPor` varchar(15) DEFAULT NULL,
  `FechaModificacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_mn_tipos_prestamos`
--

INSERT INTO `tbl_mn_tipos_prestamos` (`idTipoPrestamo`, `idEstadoTipoPrestamo`, `Descripcion`, `tasa`, `PlazoMaximo`, `montoMaximo`, `montoMinimo`, `CreadoPor`, `FechaCreacion`, `ModificadoPor`, `FechaModificacion`) VALUES
(1, 1, 'FIDUCIARIO', 12.00, 48, 60000.00, 10000.00, '', '2024-04-03 06:32:42', NULL, '2024-04-03 00:58:18'),
(2, 1, 'SOLIDARIO', 12.00, 36, 9999.00, 999.00, '', '2024-04-03 06:32:42', NULL, '2024-04-03 00:58:18'),
(3, 1, 'NUEVO PRESTAMO', 2.50, 15, 999999.99, 20000.00, '', '2024-04-03 06:32:42', NULL, '2024-04-03 00:58:18');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_mn_tipo_clientes`
--

CREATE TABLE `tbl_mn_tipo_clientes` (
  `idTipoCliente` int(11) NOT NULL,
  `Descripcion` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_mn_tipo_clientes`
--

INSERT INTO `tbl_mn_tipo_clientes` (`idTipoCliente`, `Descripcion`) VALUES
(1, 'ACTIVO'),
(2, 'INACTIVO'),
(3, 'PRIMERA VEZ'),
(4, 'NO DEFINIDO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_mn_tipo_contacto`
--

CREATE TABLE `tbl_mn_tipo_contacto` (
  `idTipoContacto` int(11) NOT NULL,
  `Descripcion` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_mn_tipo_contacto`
--

INSERT INTO `tbl_mn_tipo_contacto` (`idTipoContacto`, `Descripcion`) VALUES
(1, 'CELULAR CLIENTE'),
(2, 'Direccion Cliente'),
(3, 'Telefono\nCliente'),
(4, 'Direccion trabajo'),
(5, 'Telefono trabajo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_mn_tipo_cuenta`
--

CREATE TABLE `tbl_mn_tipo_cuenta` (
  `idTipoCuenta` int(11) NOT NULL,
  `Descripcion` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_mn_tipo_cuenta`
--

INSERT INTO `tbl_mn_tipo_cuenta` (`idTipoCuenta`, `Descripcion`) VALUES
(1, 'IDC');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_mn_tipo_persona`
--

CREATE TABLE `tbl_mn_tipo_persona` (
  `idTipoPersona` int(11) NOT NULL,
  `Descripcion` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_mn_tipo_persona`
--

INSERT INTO `tbl_mn_tipo_persona` (`idTipoPersona`, `Descripcion`) VALUES
(1, 'Cliente'),
(2, 'Pareja'),
(3, 'AVAL');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_ms_bitacora`
--

CREATE TABLE `tbl_ms_bitacora` (
  `idBitacora` int(11) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `idObjetos` int(11) NOT NULL,
  `Accion` varchar(20) DEFAULT NULL,
  `Descripcion` varchar(100) DEFAULT NULL,
  `Fecha` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_ms_bitacora`
--

INSERT INTO `tbl_ms_bitacora` (`idBitacora`, `idUsuario`, `idObjetos`, `Accion`, `Descripcion`, `Fecha`) VALUES
(1, 1, 1, 'Ingreso', 'Ingreso al Sistema', '2024-04-04 16:24:22'),
(2, 1, 4, 'Ingreso', 'Ingreso al Home Principal del Sistema', '2024-04-04 16:24:22'),
(3, 1, 10, 'Ingreso', 'Ingreso a la pantalla de tipo de préstamos', '2024-04-04 16:27:03'),
(4, 1, 10, 'Salio', 'Salió de la pantalla de tipo de préstamos', '2024-04-04 16:27:09'),
(5, 1, 6, 'Ingreso', 'Ingreso a la pantalla de solicitudes', '2024-04-04 16:27:16'),
(6, 1, 6, 'Salio', 'Salió de la pantalla de solicitudes', '2024-04-04 16:27:19'),
(7, 1, 7, 'Ingreso', 'Ingreso a la pantalla de clientes', '2024-04-04 16:27:19'),
(8, 1, 7, 'Salio', 'Salió de la pantalla de clientes', '2024-04-04 16:36:26'),
(9, 1, 6, 'Inserto', 'Se creo una nueva solicitud al cliente: LUISA  COTO', '2024-04-04 16:39:21'),
(10, 1, 6, 'Ingreso', 'Ingreso a la pantalla de solicitudes', '2024-04-04 16:39:23'),
(11, 1, 6, 'Salio', 'Salió de la pantalla de solicitudes', '2024-04-04 16:39:28'),
(12, 1, 7, 'Ingreso', 'Ingreso a la pantalla de clientes', '2024-04-04 16:39:28'),
(13, 1, 7, 'Salio', 'Salió de la pantalla de clientes', '2024-04-04 16:39:50'),
(14, 1, 6, 'Ingreso', 'Ingreso a la pantalla de solicitudes', '2024-04-04 16:39:50'),
(15, 1, 6, 'Modifico', 'Aprobó la solicitud del cliente: LUISA  COTO', '2024-04-04 16:40:25'),
(16, 1, 6, 'Salio', 'Salió de la pantalla de solicitudes', '2024-04-04 16:40:30'),
(17, 1, 6, 'Modifico', 'Modificó y aprobó el contrato del cliente: LUISA  COTO| Aprobación: 04-04-2024', '2024-04-04 16:41:37'),
(18, 1, 6, 'Ingreso', 'Ingreso a la pantalla de solicitudes', '2024-04-04 16:41:39'),
(19, 1, 6, 'Salio', 'Salió de la pantalla de solicitudes', '2024-04-04 16:41:43'),
(20, 1, 6, 'Ingreso', 'Ingreso a la pantalla de solicitudes', '2024-04-04 16:50:37'),
(21, 1, 6, 'Salio', 'Salió de la pantalla de solicitudes', '2024-04-04 16:50:39'),
(22, 1, 31, 'Ingreso', 'Ingreso a la pantalla de Bitácora', '2024-04-04 16:55:43'),
(23, 1, 31, 'Salio', 'Salió de la pantalla de Bitácora', '2024-04-04 16:56:31'),
(24, 1, 11, 'Ingreso', 'Ingreso a la pantalla de estado civil', '2024-04-04 16:56:32'),
(25, 1, 11, 'Salio', 'Salió de la pantalla de tipo de estado civil', '2024-04-04 16:56:37'),
(26, 1, 31, 'Ingreso', 'Ingreso a la pantalla de Bitácora', '2024-04-04 16:56:37'),
(27, 1, 31, 'Salio', 'Salió de la pantalla de Bitácora', '2024-04-04 16:57:01'),
(28, 1, 6, 'Ingreso', 'Ingreso a la pantalla de solicitudes', '2024-04-04 16:57:01'),
(29, 1, 6, 'Salio', 'Salió de la pantalla de solicitudes', '2024-04-04 17:06:27'),
(30, 1, 4, 'Ingreso', 'Ingreso al Home Principal del Sistema', '2024-04-04 17:06:52'),
(31, 1, 4, 'Ingreso', 'Ingreso al Home Principal del Sistema', '2024-04-04 19:03:12'),
(32, 1, 4, 'Ingreso', 'Ingreso al Home Principal del Sistema', '2024-04-04 19:11:20'),
(33, 1, 28, 'Ingreso', 'Ingreso a la pantalla de parámetros', '2024-04-04 19:26:03'),
(34, 1, 28, 'Modifico', 'Modificó el parámetro con id: 11 con valor: Adepes@123', '2024-04-04 19:26:22'),
(35, 1, 28, 'Salio', 'Salió de la pantalla de parámetros', '2024-04-04 19:30:49'),
(36, 1, 28, 'Ingreso', 'Ingreso a la pantalla de parámetros', '2024-04-04 19:30:49'),
(37, 1, 28, 'Modifico', 'Modificó el parámetro con id: 6 con valor: 12', '2024-04-04 19:30:58'),
(38, 1, 28, 'Salio', 'Salió de la pantalla de parámetros', '2024-04-04 19:31:11'),
(39, 1, 3, 'Ingreso', 'Ingreso al Mantenimiento de Usuario', '2024-04-04 19:31:12'),
(40, 1, 3, 'Modifico', 'Actualizo al usuario: ADMINISTRADOR', '2024-04-04 19:31:25'),
(41, 1, 3, 'Salio', 'Salió de la pantalla de mantenimiento de usuarios', '2024-04-04 19:31:31'),
(42, 1, 1, 'Salio', 'Salio del Sistema', '2024-04-04 19:31:31'),
(43, 1, 1, 'Ingreso', 'Ingreso al Sistema', '2024-04-04 19:41:08'),
(44, 1, 4, 'Ingreso', 'Ingreso al Home Principal del Sistema', '2024-04-04 19:41:08'),
(45, 1, 1, 'Salio', 'Salio del Sistema', '2024-04-04 20:09:17'),
(46, 1, 1, 'Ingreso', 'Ingreso al Sistema', '2024-04-04 20:09:35'),
(47, 1, 4, 'Ingreso', 'Ingreso al Home Principal del Sistema', '2024-04-04 20:09:35'),
(48, 1, 1, 'Salio', 'Salio del Sistema', '2024-04-04 20:19:41'),
(49, 1, 1, 'Ingreso', 'Ingreso al Sistema', '2024-04-04 20:25:44'),
(50, 1, 4, 'Ingreso', 'Ingreso al Home Principal del Sistema', '2024-04-04 20:25:44'),
(51, 1, 1, 'Salio', 'Salio del Sistema', '2024-04-04 20:40:21'),
(52, 1, 1, 'Ingreso', 'Ingreso al Sistema', '2024-04-04 20:41:49'),
(53, 1, 4, 'Ingreso', 'Ingreso al Home Principal del Sistema', '2024-04-04 20:41:49'),
(54, 1, 4, 'Ingreso', 'Ingreso al Home Principal del Sistema', '2024-04-04 20:41:57'),
(55, 1, 6, 'Ingreso', 'Ingreso a la pantalla de solicitudes', '2024-04-04 20:41:59'),
(56, 1, 6, 'Salio', 'Salió de la pantalla de solicitudes', '2024-04-04 20:42:03'),
(57, 1, 31, 'Ingreso', 'Ingreso a la pantalla de Bitácora', '2024-04-04 21:06:24'),
(58, 1, 31, 'Salio', 'Salió de la pantalla de Bitácora', '2024-04-04 21:07:02'),
(59, 1, 7, 'Ingreso', 'Ingreso a la pantalla de clientes', '2024-04-04 21:07:02'),
(60, 1, 7, 'Salio', 'Salió de la pantalla de clientes', '2024-04-04 21:07:10'),
(61, 1, 31, 'Ingreso', 'Ingreso a la pantalla de Bitácora', '2024-04-04 21:07:10'),
(62, 1, 31, 'Filtrar', 'Realizo consulta en el filtro general', '2024-04-04 21:07:15'),
(63, 1, 31, 'Filtrar', 'Realizo consulta por rango de fechas', '2024-04-04 21:07:30'),
(64, 1, 31, 'Filtrar', 'Realizo consulta en el filtro general', '2024-04-04 21:07:36'),
(65, 1, 31, 'Filtrar', 'Realizo consulta en el filtro general', '2024-04-04 21:07:48'),
(66, 1, 31, 'Salio', 'Salió de la pantalla de Bitácora', '2024-04-04 21:07:57'),
(67, 1, 31, 'Ingreso', 'Ingreso a la pantalla de Bitácora', '2024-04-04 21:07:57'),
(68, 1, 31, 'Filtrar', 'Realizo consulta en el filtro general', '2024-04-04 21:08:03'),
(69, 1, 31, 'Salio', 'Salió de la pantalla de Bitácora', '2024-04-04 21:16:00'),
(70, 1, 1, 'Ingreso', 'Ingreso al Sistema', '2024-04-04 22:34:23'),
(71, 1, 4, 'Ingreso', 'Ingreso al Home Principal del Sistema', '2024-04-04 22:34:23'),
(72, 1, 4, 'Ingreso', 'Ingreso al Home Principal del Sistema', '2024-04-04 22:34:49'),
(73, 1, 1, 'Ingreso', 'Ingreso al Sistema', '2024-04-04 22:35:58'),
(74, 1, 4, 'Ingreso', 'Ingreso al Home Principal del Sistema', '2024-04-04 22:35:58'),
(75, 1, 4, 'Ingreso', 'Ingreso al Home Principal del Sistema', '2024-04-04 22:41:17'),
(76, 1, 1, 'Salio', 'Salio del Sistema', '2024-04-04 22:44:55'),
(77, 1, 1, 'Ingreso', 'Ingreso al Sistema', '2024-04-04 22:45:17'),
(78, 1, 4, 'Ingreso', 'Ingreso al Home Principal del Sistema', '2024-04-04 22:45:17'),
(79, 1, 3, 'Ingreso', 'Ingreso al Mantenimiento de Usuario', '2024-04-05 00:19:23'),
(80, 1, 1, 'Salio', 'Salio del Sistema', '2024-04-05 00:20:26'),
(81, 1, 3, 'Salio', 'Salió de la pantalla de mantenimiento de usuarios', '2024-04-05 00:20:26'),
(82, 8, 2, 'Inserto', 'Creo su cuenta de usuario desde autoregistro', '2024-04-05 00:21:53'),
(83, 9, 2, 'Inserto', 'Creo su cuenta de usuario desde autoregistro', '2024-04-05 00:23:55'),
(84, 1, 1, 'Salio', 'Salio del Sistema', '2024-04-05 00:40:54'),
(85, 1, 1, 'Ingreso', 'Ingreso al Sistema', '2024-04-05 02:05:02'),
(86, 1, 4, 'Ingreso', 'Ingreso al Home Principal del Sistema', '2024-04-05 02:05:02'),
(87, 1, 7, 'Ingreso', 'Ingreso a la pantalla de clientes', '2024-04-05 02:05:09'),
(88, 1, 7, 'Salio', 'Salió de la pantalla de clientes', '2024-04-05 02:05:12'),
(89, 1, 6, 'Ingreso', 'Ingreso a la pantalla de solicitudes', '2024-04-05 02:05:12'),
(90, 1, 6, 'Salio', 'Salió de la pantalla de solicitudes', '2024-04-05 02:05:17'),
(92, 1, 1, 'Ingreso', 'Ingreso al Sistema', '2024-04-05 03:08:46'),
(93, 1, 4, 'Ingreso', 'Ingreso al Home Principal del Sistema', '2024-04-05 03:08:46'),
(94, 1, 9, 'Ingreso', 'Ingreso a la pantalla de roles', '2024-04-05 03:08:51'),
(95, 1, 9, 'Reporte', 'Imprimió el reporte de LISTADO DE ROLES', '2024-04-05 03:08:53'),
(96, 1, 9, 'Salio', 'Salió de la pantalla de roles', '2024-04-05 03:09:02'),
(97, 1, 27, 'Ingreso', 'Ingreso a la pantalla de permisos', '2024-04-05 03:09:02'),
(98, 1, 27, 'Reporte', 'Imprimió el reporte de LISTADO DE PERMISOS', '2024-04-05 03:09:40'),
(99, 1, 27, 'Reporte', 'Imprimió el reporte de LISTADO DE PERMISOS', '2024-04-05 03:09:55'),
(100, 1, 27, 'Salio', 'Salió de la pantalla de permisos', '2024-04-05 03:10:36'),
(101, 1, 29, 'Ingreso', 'Ingreso a la pantalla de preguntas de seguridad', '2024-04-05 03:10:36'),
(102, 1, 29, 'Salio', 'Salió de la pantalla de preguntas de seguridad', '2024-04-05 03:10:39'),
(103, 1, 4, 'Ingreso', 'Ingreso al Home Principal del Sistema', '2024-04-05 03:10:39'),
(104, 1, 3, 'Ingreso', 'Ingreso al Mantenimiento de Usuario', '2024-04-05 03:10:42'),
(105, 1, 3, 'Salio', 'Salió de la pantalla de mantenimiento de usuarios', '2024-04-05 05:35:00');

--
-- Disparadores `tbl_ms_bitacora`
--
DELIMITER $$
CREATE TRIGGER `TGR_LOGS_BITACORA` AFTER DELETE ON `tbl_ms_bitacora` FOR EACH ROW BEGIN
	INSERT INTO TBL_LOGS_BITACORA ( idBitacora, idUsuario, idObjetos, Accion, Descripcion, Fecha, Ip, Usuario, FechaHora)
        SELECT OLD.idBitacora, OLD.idUsuario, OLD.idObjetos,
		OLD.Accion,
		OLD.Descripcion,
		OLD.Fecha,
		SUBSTRING_INDEX(SUBSTRING_INDEX(USER(), '@', -1), ':', 1),
		USER(),
		CURRENT_TIMESTAMP();
    END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_ms_estado_usuario`
--

CREATE TABLE `tbl_ms_estado_usuario` (
  `idEstadoUsuario` int(11) NOT NULL,
  `Descripcion` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_ms_estado_usuario`
--

INSERT INTO `tbl_ms_estado_usuario` (`idEstadoUsuario`, `Descripcion`) VALUES
(1, 'Nuevo'),
(2, 'Activo'),
(3, 'Bloqueado'),
(4, 'Inactivo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_ms_hist_contrasenna`
--

CREATE TABLE `tbl_ms_hist_contrasenna` (
  `idHist` int(11) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `Contrasenna` text NOT NULL,
  `CreadoPor` varchar(15) NOT NULL,
  `FechaCreacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `ModificadoPor` varchar(15) DEFAULT NULL,
  `FechaModificacion` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_ms_objetos`
--

CREATE TABLE `tbl_ms_objetos` (
  `idObjetos` int(11) NOT NULL,
  `Objeto` varchar(100) DEFAULT NULL,
  `Descripcion` varchar(100) DEFAULT NULL,
  `TipoObjeto` varchar(15) DEFAULT NULL,
  `CreadoPor` varchar(15) DEFAULT NULL,
  `FechaCreacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `ModificadoPor` varchar(15) DEFAULT NULL,
  `FechaModificacion` date DEFAULT NULL,
  `esModulo` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_ms_objetos`
--

INSERT INTO `tbl_ms_objetos` (`idObjetos`, `Objeto`, `Descripcion`, `TipoObjeto`, `CreadoPor`, `FechaCreacion`, `ModificadoPor`, `FechaModificacion`, `esModulo`) VALUES
(1, 'LOGIN', 'PANTALLA DE LOGIN ', 'PANTALLA', 'ADMIN', '2023-07-05 03:36:18', NULL, NULL, NULL),
(2, 'AUTOREGISTRO USUARIO', 'PANTALLA DE AUTOREGISTRO DE USUARIO', 'PANTALLA', 'ADMIN', '2023-07-05 22:19:23', NULL, NULL, '1'),
(3, 'MANTENIMIENTO USUARIO', 'PANTALLA DE MANTENIMIENTO DE USUARIO', 'PANTALLA', 'ADMIN', '2023-07-05 22:19:23', NULL, NULL, '1'),
(4, 'HOME', 'PANTALLA HOME PRINCIPAL', 'PANTALLA', 'ADMIN', '2023-07-06 03:08:01', NULL, NULL, '1'),
(5, 'RECUPERACION DE CLAVE', 'PANTALLA DE RECUPERACION DE CLAVE', 'PANTALLA', 'ADMIN', '2023-07-13 23:28:04', NULL, NULL, NULL),
(6, 'SOLICITUDES', 'PANTALLA DE SOLICITUDES', 'PANTALLA', 'ADMIN', '2023-11-11 04:29:28', NULL, NULL, '1'),
(7, 'CLIENTES', 'PANTALLA DE CLIENTES', 'PANTALLA', 'ADMIN', '2023-11-11 04:29:28', NULL, NULL, '1'),
(8, 'COBRO', 'PANTALLA DE COBROS', 'PANTALLA', 'ADMIN', '2023-11-11 04:29:28', NULL, NULL, '1'),
(9, 'ROLES', 'PANTALLA DE ROLES', 'PANTALLA', 'ADMIN', '2023-11-11 04:29:28', NULL, NULL, '1'),
(10, 'TIPO PRESTAMO', 'PANTALLA DE TIPO DE PRESTAMO', 'PANTALLA', 'ADMIN', '2023-11-11 04:29:28', NULL, NULL, '1'),
(11, 'ESTADO CIVIL', 'PANTALLA DE ESTADO CIVIL', 'PANTALLA', 'ADMIN', '2023-11-11 04:29:28', NULL, NULL, '1'),
(12, 'CATEGORIA CASA', 'PANTALLA DE CATEGORIA CASA', 'PANTALLA', 'ADMIN', '2023-11-11 04:29:28', NULL, NULL, '1'),
(13, 'PARENTESCO', 'PANTALLA DE PARENTESCO', 'PANTALLA', 'ADMIN', '2023-11-11 04:29:28', NULL, NULL, '1'),
(14, 'GENERO', 'PANTALLA DE GENERO', 'PANTALLA', 'ADMIN', '2023-11-28 01:03:25', NULL, NULL, '1'),
(15, 'TIPO CONTACTO', 'PANTALLA DE TIPO DE CONTACTO', 'PANTALLA', 'ADMIN', '2023-11-28 01:35:15', NULL, NULL, '1'),
(16, 'NACIONALIDAD', 'PANTALLA DE NACIONALIDAD', 'PANTALLA', 'ADMIN', '2023-11-28 01:38:51', NULL, NULL, '1'),
(17, 'PERSONAS BIENES', 'PANTALLA DE PERSONAS BIENES', 'PANTALLA', 'ADMIN', '2023-11-28 01:43:09', NULL, NULL, '1'),
(18, 'TIEMPO LABORAL', 'PANTALLA DE TIEMPO LABORAL', 'PANTALLA', 'ADMIN', '2023-11-28 01:48:04', NULL, NULL, '1'),
(19, 'ESTADO PLAN PAGO', 'PANTALLA ESTADO PLAN PAGO', 'PANTALLA', 'ADMIN', '2023-11-28 01:52:57', NULL, NULL, '1'),
(20, 'TIEMPO VIVIR', 'PANTALLA TIEMPO VIVIR', 'PANTALLA', 'ADMIN', '2023-11-28 01:57:57', NULL, NULL, '1'),
(21, 'ESTADO TIPO PRESTAMO', 'PANTALLA ESTADO TIPO PRESTAMO', 'PANTALLA', 'ADMIN', '2023-11-28 02:01:30', NULL, NULL, '1'),
(22, 'ESTADO SOLICITUDES', 'PANTALLA ESTADO SOLICITUDES', 'PANTALLA', 'ADMIN', '2023-11-28 02:07:14', NULL, NULL, '1'),
(23, 'RUBROS', 'PANTALLA RUBROS', 'PANTALLA', 'ADMIN', '2023-11-28 02:10:24', NULL, NULL, '1'),
(24, 'PRESTAMOS', 'PANTALLA DE PRESTAMOS', 'PANTALLA', 'ADMIN', '2023-11-30 09:11:11', NULL, NULL, '1'),
(25, 'MUNICIPIO', 'PANTALLA DE MUNICIPIO', 'PANTALLA', 'ADMIN', '2023-11-30 09:17:28', NULL, NULL, '1'),
(26, 'PROFESION', 'PANTALLA DE PROFESION', 'PANTALLA', 'ADMIN', '2023-11-30 09:18:32', NULL, NULL, '1'),
(27, 'PERMISOS', 'PANTALLA DE PERMISOS', 'PANTALLA', 'ADMIN', '2023-11-30 09:18:32', NULL, NULL, '1'),
(28, 'PARAMETROS', 'PANTALLA DE PARAMETROS', 'PANTALLA', 'ADMIN', '2023-11-30 09:18:32', NULL, NULL, '1'),
(29, 'PREGUNTAS DE SEGURIDAD', 'PANTALLA DE PREGUNTAS DE SEGURIDAD', 'PANTALLA', 'ADMIN', '2023-11-30 09:18:32', NULL, NULL, '1'),
(30, 'BACKUP', 'PANTALLA DE BACKUP', 'PANTALLA', 'ADMIN', '2023-11-30 09:18:32', NULL, NULL, '1'),
(31, 'BITACORA', 'PANTALLA DE BITACORA', 'PANTALLA', 'ADMIN', '2023-11-30 09:18:32', NULL, NULL, '1'),
(32, 'ESTADO USUARIO', 'PANTALLA ESTADO USUARIO', 'PANTALLA', 'ADMIN', '2023-11-28 02:07:14', NULL, NULL, '1'),
(33, 'ANALISIS CREDITICIO', 'PANTALLA CREDITICIO', 'PANTALLA', 'ADMIN', '2023-11-28 02:07:14', NULL, NULL, '1'),
(34, 'ESTADO CREDITO', 'PANTALLA ESTADO CREDITO', 'PANTALLA', 'ADMIN', '2023-11-28 02:07:14', NULL, NULL, '1'),
(35, 'TIPO CLIENTE', 'PANTALLA TIPO CLIENTE', 'PANTALLA', 'ADMIN', '2023-11-28 02:07:14', NULL, NULL, '1'),
(36, 'TIPOS DE PAGO', 'PANTALLA TIPOS DE PAGO', 'PANTALLA', 'ADMIN', '2023-11-28 02:07:14', NULL, NULL, '1'),
(37, 'AVAL PERSONA', 'PANTALLA AVAL PERSONA', 'PANTALLA', 'ADMIN', '2023-11-28 02:07:14', NULL, NULL, '1'),
(38, 'CREDITO AVAL', 'PANTALLA CREDITO AVAL', 'PANTALLA', 'ADMIN', '2023-11-28 02:07:14', NULL, NULL, '1'),
(39, 'OBJETOS', 'PANTALLA OBJETOS', 'PANTALLA', 'ADMIN', '2023-11-28 02:07:14', NULL, NULL, '1'),
(40, 'TIPO CUENTA', 'PANTALLA TIPO CUENTA', 'PANTALLA', 'ADMIN', '2023-11-28 02:07:14', NULL, NULL, '1'),
(41, 'TIPO PERSONA', 'PANTALLA TIPO PERSONA', 'PANTALLA', 'ADMIN', '2023-11-28 02:07:14', NULL, NULL, '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_ms_parametros`
--

CREATE TABLE `tbl_ms_parametros` (
  `idParametro` int(11) NOT NULL,
  `idTipoDato` int(11) NOT NULL,
  `Parametro` varchar(50) NOT NULL,
  `Valor` varchar(100) NOT NULL,
  `idUsuario` int(11) DEFAULT NULL,
  `FechaCreacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `FechaModificacion` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_ms_parametros`
--

INSERT INTO `tbl_ms_parametros` (`idParametro`, `idTipoDato`, `Parametro`, `Valor`, `idUsuario`, `FechaCreacion`, `FechaModificacion`) VALUES
(1, 2, 'INTENTOS DE INICIO DE SESION', '3', 1, '2023-07-25 02:37:32', '2024-03-26'),
(2, 2, 'CANTIDAD DE PREGUNTAS', '3', 1, '2023-07-25 02:37:56', '2024-03-26'),
(3, 2, 'TAMAÑO MINIMO DE CLAVE', '5', 1, '2023-07-25 02:38:22', '2024-03-21'),
(4, 2, 'TAMAÑO MAXIMO DE CLAVE', '10', 1, '2023-07-25 02:39:37', '2024-02-17'),
(5, 2, 'DIAS DE VIGENCIA DE USUARIOS', '91', 1, '2023-07-25 02:40:05', '2024-03-17'),
(6, 2, 'VIGENCIA DE RECUPERACION', '12', 1, '2023-07-25 02:40:20', '2024-04-04'),
(7, 2, 'TASA MORA', '1.5', 1, '2024-03-18 08:29:17', '2024-03-26'),
(8, 2, 'INTENTOS DE RECUPERACION POR PREGUNTAS', '2', 1, '2024-03-18 08:31:07', '2024-03-17'),
(9, 1, 'NOMBRE DEL SISTEMA', 'FONDO ROTATORIO', 1, '2024-03-18 08:53:23', '2024-03-26'),
(10, 3, 'CORREO SERVIDOR ', 'root@fondorevolvente.com', 1, '2024-03-21 08:51:49', '2024-03-26'),
(11, 3, 'CLAVE SERVIDOR', 'Adepes@123', 1, '2024-03-21 08:51:49', '2024-04-04'),
(12, 2, 'PUERTO SERVIDOR', '465', 1, '2024-03-21 08:52:29', '2024-03-21');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_ms_permisos`
--

CREATE TABLE `tbl_ms_permisos` (
  `idPermiso` int(11) NOT NULL,
  `idRol` int(11) NOT NULL,
  `idObjeto` int(11) NOT NULL,
  `insertar` int(11) NOT NULL DEFAULT 0,
  `eliminar` int(11) NOT NULL DEFAULT 0,
  `consultar` int(11) NOT NULL DEFAULT 0,
  `actualizar` int(11) NOT NULL DEFAULT 0,
  `reportes` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_ms_permisos`
--

INSERT INTO `tbl_ms_permisos` (`idPermiso`, `idRol`, `idObjeto`, `insertar`, `eliminar`, `consultar`, `actualizar`, `reportes`) VALUES
(52, 4, 3, 1, 1, 1, 1, 1),
(84, 5, 5, 1, 1, 1, 1, 0),
(94, 4, 2, 1, 1, 1, 1, 0),
(97, 4, 1, 1, 1, 1, 1, 0),
(124, 2, 6, 1, 1, 1, 1, 1),
(125, 2, 7, 1, -1, 1, 1, 1),
(126, 2, 8, 1, 1, 1, 1, 1),
(127, 2, 9, 1, 1, 1, 1, 1),
(128, 2, 10, 1, 1, 1, 1, 1),
(130, 2, 12, 1, -1, 1, -1, 0),
(133, 2, 13, 1, 1, 1, 1, 0),
(134, 2, 14, 1, 1, 1, 1, 1),
(135, 2, 15, 1, 1, 1, 1, 0),
(136, 2, 16, 1, 1, 1, 1, 1),
(138, 2, 17, 1, 1, 1, 1, 0),
(139, 2, 18, 1, 1, 1, 1, 0),
(140, 2, 19, 1, 1, 1, 1, 0),
(141, 2, 20, 1, 1, 1, 1, 0),
(142, 2, 21, 1, 1, 1, 1, 0),
(143, 2, 22, 1, 1, 1, 1, 1),
(144, 2, 23, 1, 1, 1, 1, 1),
(145, 2, 24, 1, 1, 1, 1, 1),
(146, 2, 26, 1, 1, 1, 1, 0),
(147, 2, 25, 1, 1, 1, 1, 1),
(150, 3, 2, 1, 1, 1, 1, 1),
(151, 2, 27, 1, 1, 1, 1, 1),
(157, 2, 30, 1, 1, 1, 1, 1),
(158, 2, 31, 1, 1, 1, 1, 1),
(159, 2, 32, 1, 1, 1, 1, 1),
(160, 2, 3, 1, 1, 1, 1, -1),
(161, 2, 28, 1, 1, 1, 1, 1),
(162, 2, 11, 1, 1, 1, 1, 1),
(163, 3, 12, 1, 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_ms_preguntas`
--

CREATE TABLE `tbl_ms_preguntas` (
  `idPregunta` int(11) NOT NULL,
  `Pregunta` varchar(100) NOT NULL,
  `estadoPregunta` int(11) DEFAULT NULL,
  `CreadoPor` varchar(15) NOT NULL,
  `FechaCreacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `ModificadoPor` varchar(15) DEFAULT NULL,
  `FechaModificacion` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_ms_preguntas`
--

INSERT INTO `tbl_ms_preguntas` (`idPregunta`, `Pregunta`, `estadoPregunta`, `CreadoPor`, `FechaCreacion`, `ModificadoPor`, `FechaModificacion`) VALUES
(1, '¿NOMBRE DE TU PRIMERA MASCOTA? 1', 1, '', '2023-06-29 20:27:06', '', '2023-06-29 20:27:06'),
(2, '¿En que ciudad naciste?', 1, '', '2023-06-29 20:27:06', '', '2023-06-29 20:27:06'),
(3, '¿Quién es tu mejor amigo(a)?', 1, '', '2023-06-29 20:27:06', '', '2023-06-29 20:27:06'),
(4, '¿CUÁL ES SU COMIDA FAVORITA?', 1, '', '2023-06-29 20:27:06', '', '2023-06-29 20:27:06'),
(5, '¿En qué ciudad nació su madre?', 1, '', '2023-06-29 20:27:06', '', '2023-06-29 20:27:06'),
(6, '¿En qué ciudad nació su padre?', 1, '', '2023-06-29 20:27:06', '', '2023-06-29 20:27:06');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_ms_preguntas_usuario`
--

CREATE TABLE `tbl_ms_preguntas_usuario` (
  `idPregunta` int(11) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `Respuesta` varchar(100) NOT NULL,
  `CreadoPor` varchar(15) NOT NULL,
  `FechaCreacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `ModificadoPor` varchar(15) DEFAULT NULL,
  `FechaModificacion` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_ms_roles`
--

CREATE TABLE `tbl_ms_roles` (
  `idRol` int(11) NOT NULL,
  `Rol` varchar(30) NOT NULL,
  `Descripcion` varchar(100) NOT NULL,
  `CreadoPor` varchar(15) NOT NULL,
  `FechaCreacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `ModificadoPor` varchar(15) DEFAULT NULL,
  `FechaModificacion` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_ms_roles`
--

INSERT INTO `tbl_ms_roles` (`idRol`, `Rol`, `Descripcion`, `CreadoPor`, `FechaCreacion`, `ModificadoPor`, `FechaModificacion`) VALUES
(1, 'DEFAULT', 'ROL CUANDO SE CREA UN USUARIO DESDE EL AUTOREGISTRO', '', '2024-04-03 22:34:38', NULL, NULL),
(2, 'ADMINISTRADOR', 'ADMINISTRADOR DEL SISTEMA', '', '2024-04-03 22:35:23', NULL, NULL),
(3, 'FACILITADOR TECNICO', 'PROCESOS DE SOLICITUDES', '', '2024-04-03 22:35:55', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_ms_tipodato_parametros`
--

CREATE TABLE `tbl_ms_tipodato_parametros` (
  `idTipoDato` int(11) NOT NULL,
  `Descripcion` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_ms_tipodato_parametros`
--

INSERT INTO `tbl_ms_tipodato_parametros` (`idTipoDato`, `Descripcion`) VALUES
(1, 'SOLO LETRAS'),
(2, 'NUMEROS'),
(3, 'LETRAS Y NUMERO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_ms_usuario`
--

CREATE TABLE `tbl_ms_usuario` (
  `idUsuario` int(11) NOT NULL,
  `idRol` int(11) DEFAULT NULL,
  `Usuario` varchar(15) NOT NULL,
  `NombreUsuario` varchar(100) NOT NULL,
  `idEstadoUsuario` int(11) DEFAULT NULL,
  `Clave` varchar(100) DEFAULT NULL,
  `FechaUltimaConexion` timestamp NULL DEFAULT current_timestamp(),
  `PreguntasContestadas` int(11) DEFAULT NULL,
  `PrimerIngreso` int(11) DEFAULT NULL,
  `FechaVencimiento` date DEFAULT NULL,
  `CorreoElectronico` varchar(50) NOT NULL,
  `CreadoPor` varchar(50) NOT NULL,
  `FechaCreacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `ModificadoPor` varchar(15) DEFAULT NULL,
  `FechaModificacion` timestamp NULL DEFAULT current_timestamp(),
  `Intentos` int(11) DEFAULT 0,
  `token` text DEFAULT NULL,
  `fechaRecuperacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_ms_usuario`
--

INSERT INTO `tbl_ms_usuario` (`idUsuario`, `idRol`, `Usuario`, `NombreUsuario`, `idEstadoUsuario`, `Clave`, `FechaUltimaConexion`, `PreguntasContestadas`, `PrimerIngreso`, `FechaVencimiento`, `CorreoElectronico`, `CreadoPor`, `FechaCreacion`, `ModificadoPor`, `FechaModificacion`, `Intentos`, `token`, `fechaRecuperacion`) VALUES
(1, 2, 'ADMIN', 'ADMINISTRADOR', 2, '$2y$10$6F6COhsTbrfmalZb7H4Lauo/c7oGXz2Yqx.tHk3qO4w7qYXgT4uGG', '2023-07-19 11:00:26', 0, 0, '2024-05-19', 'luisaarias319@gmail.com', 'ADMIN', '2023-07-19 11:00:26', 'ADMIN', '2024-04-04 06:00:00', 0, '189e7744d0e63802414aa8d7adaf4a1a', '2024-04-05 15:31:40'),
(8, 1, 'SAMATH', 'SAMANTHA ARIAS', 1, '$2y$10$ycwh.tzfDKQydpmpBmZTX.lmhvEqOu36R2wZ594uiTQDJ7vRQBvYK', '2024-04-05 00:21:53', NULL, NULL, '2024-07-05', 'ariaslizeth266@gmail.com', 'SAMATH', '2024-04-05 00:21:53', NULL, '2024-04-05 00:21:53', 0, NULL, '2024-04-05 00:21:53'),
(9, 1, 'AMIR', 'ANA MARIA', 1, '$2y$10$vcqe7vtfgf0zi7g2vSBF3uoqgoGF9lmcYPrDxKiFG7SaDeOqVxu5G', '2024-04-05 00:23:55', NULL, NULL, '2024-07-05', 'ariaslizeth26@gmail.com', 'AMIR', '2024-04-05 00:23:55', NULL, '2024-04-05 00:23:55', 0, NULL, '2024-04-05 00:23:55');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `tbl_logs_bitacora`
--
ALTER TABLE `tbl_logs_bitacora`
  ADD PRIMARY KEY (`idBitacora`);

--
-- Indices de la tabla `tbl_mn_analisis_crediticio`
--
ALTER TABLE `tbl_mn_analisis_crediticio`
  ADD PRIMARY KEY (`idAnalisisCrediticio`),
  ADD KEY `id_estadoAnalisisCrediticio_fk` (`idEstadoAnalisisCrediticio`),
  ADD KEY `id_idPersona_fk_analisis` (`idPersona`),
  ADD KEY `id_solicitud_fk` (`idSolicitud`);

--
-- Indices de la tabla `tbl_mn_avala_a_persona`
--
ALTER TABLE `tbl_mn_avala_a_persona`
  ADD PRIMARY KEY (`idEsAval`);

--
-- Indices de la tabla `tbl_mn_avales`
--
ALTER TABLE `tbl_mn_avales`
  ADD PRIMARY KEY (`idAval`),
  ADD KEY `idSolicitud_fk_avales` (`idSolicitud`),
  ADD KEY `id_persona_fk` (`idPersona`);

--
-- Indices de la tabla `tbl_mn_categoria_casa`
--
ALTER TABLE `tbl_mn_categoria_casa`
  ADD PRIMARY KEY (`idcategoriaCasa`);

--
-- Indices de la tabla `tbl_mn_contrato`
--
ALTER TABLE `tbl_mn_contrato`
  ADD PRIMARY KEY (`idContrato`),
  ADD KEY `fk_contratoSolicitud` (`idSolicitud`);

--
-- Indices de la tabla `tbl_mn_conyugues`
--
ALTER TABLE `tbl_mn_conyugues`
  ADD PRIMARY KEY (`idConyuge`),
  ADD KEY `idSolicitud_fk_conyuge` (`idSolicitud`),
  ADD KEY `id_persona_fk_conyugue` (`idPersona`);

--
-- Indices de la tabla `tbl_mn_credito_aval`
--
ALTER TABLE `tbl_mn_credito_aval`
  ADD PRIMARY KEY (`idCreditoAval`);

--
-- Indices de la tabla `tbl_mn_estadocivil`
--
ALTER TABLE `tbl_mn_estadocivil`
  ADD PRIMARY KEY (`idEstadoCivil`);

--
-- Indices de la tabla `tbl_mn_estadoplanpagos`
--
ALTER TABLE `tbl_mn_estadoplanpagos`
  ADD PRIMARY KEY (`idEstadoPlanPagos`);

--
-- Indices de la tabla `tbl_mn_estados_solicitudes`
--
ALTER TABLE `tbl_mn_estados_solicitudes`
  ADD PRIMARY KEY (`idEstadoSolicitud`);

--
-- Indices de la tabla `tbl_mn_estadotipoprestamo`
--
ALTER TABLE `tbl_mn_estadotipoprestamo`
  ADD PRIMARY KEY (`idestadoTipoPrestamo`);

--
-- Indices de la tabla `tbl_mn_estado_analisiscrediticio`
--
ALTER TABLE `tbl_mn_estado_analisiscrediticio`
  ADD PRIMARY KEY (`idestadoAnalisisCrediticio`);

--
-- Indices de la tabla `tbl_mn_estado_credito`
--
ALTER TABLE `tbl_mn_estado_credito`
  ADD PRIMARY KEY (`idEstadoCredito`);

--
-- Indices de la tabla `tbl_mn_genero`
--
ALTER TABLE `tbl_mn_genero`
  ADD PRIMARY KEY (`idGenero`);

--
-- Indices de la tabla `tbl_mn_movimientos_financieros`
--
ALTER TABLE `tbl_mn_movimientos_financieros`
  ADD PRIMARY KEY (`idMovimientoFinanciero`),
  ADD KEY `idPlan_cuotas_fk` (`idPlanCuota`);

--
-- Indices de la tabla `tbl_mn_municipio`
--
ALTER TABLE `tbl_mn_municipio`
  ADD PRIMARY KEY (`idMunicipio`);

--
-- Indices de la tabla `tbl_mn_nacionalidades`
--
ALTER TABLE `tbl_mn_nacionalidades`
  ADD PRIMARY KEY (`idNacionalidad`);

--
-- Indices de la tabla `tbl_mn_parentesco`
--
ALTER TABLE `tbl_mn_parentesco`
  ADD PRIMARY KEY (`idParentesco`);

--
-- Indices de la tabla `tbl_mn_personas`
--
ALTER TABLE `tbl_mn_personas`
  ADD PRIMARY KEY (`idPersona`),
  ADD KEY `id_tipoPersona_fk` (`idTipoPersona`),
  ADD KEY `idNacionalidad_fk` (`idNacionalidad`),
  ADD KEY `idGenero_fk` (`idGenero`),
  ADD KEY `idEstado_civil_fk` (`idEstadoCivil`),
  ADD KEY `idProfesion_fk` (`idProfesion`),
  ADD KEY `id_tipo_clientes_fk` (`idTipoClientes`),
  ADD KEY `idcategoriaCasa_fk` (`idcategoriaCasa`),
  ADD KEY `idtiempoVivir_fk` (`idtiempoVivir`),
  ADD KEY `idTiempoLaboral_fk` (`idTiempoLaboral`),
  ADD KEY `PersonaBienes_fk_` (`idPersonaBienes`),
  ADD KEY `TipoDePago_fk` (`PagaAlquiler`),
  ADD KEY `estadoCredito_fk` (`estadoCredito`),
  ADD KEY `esAval_fk_` (`esAval`),
  ADD KEY `creditoAval_fk` (`avalMora`),
  ADD KEY `Persona_municipio_fk` (`idMunicipio`);

--
-- Indices de la tabla `tbl_mn_personas_bienes`
--
ALTER TABLE `tbl_mn_personas_bienes`
  ADD PRIMARY KEY (`idPersonaBienes`);

--
-- Indices de la tabla `tbl_mn_personas_contacto`
--
ALTER TABLE `tbl_mn_personas_contacto`
  ADD PRIMARY KEY (`idPersonaContacto`),
  ADD KEY `idPersona_fk` (`idPersona`),
  ADD KEY `idTipo_contacto_fK` (`idTipoContacto`);

--
-- Indices de la tabla `tbl_mn_personas_cuenta`
--
ALTER TABLE `tbl_mn_personas_cuenta`
  ADD PRIMARY KEY (`idNumeroCuenta`),
  ADD KEY `id_persona_fk_cuenta` (`idPersona`),
  ADD KEY `idTipoCuenta_fk` (`idTipoCuenta`);

--
-- Indices de la tabla `tbl_mn_personas_dependientes`
--
ALTER TABLE `tbl_mn_personas_dependientes`
  ADD PRIMARY KEY (`idDependientes`),
  ADD KEY `idPersona_f_k` (`idPersona`),
  ADD KEY `idparentesco_f_k` (`idParentesco`);

--
-- Indices de la tabla `tbl_mn_plan_pagos_cuota_nivelada`
--
ALTER TABLE `tbl_mn_plan_pagos_cuota_nivelada`
  ADD PRIMARY KEY (`idPlanCuota`),
  ADD KEY `idPersona_forgn_keys` (`idPersona`),
  ADD KEY `id_solicitud_fKysss` (`idSolicitud`),
  ADD KEY `id_EstadoPlanPagos` (`idEstadoPlanPagos`);

--
-- Indices de la tabla `tbl_mn_profesiones_oficios`
--
ALTER TABLE `tbl_mn_profesiones_oficios`
  ADD PRIMARY KEY (`idProfesion`);

--
-- Indices de la tabla `tbl_mn_referencias_comerciales`
--
ALTER TABLE `tbl_mn_referencias_comerciales`
  ADD PRIMARY KEY (`idReferenciaComercial`),
  ADD KEY `idPersona_fk_refeComercial` (`idPersona`);

--
-- Indices de la tabla `tbl_mn_referencias_familiares`
--
ALTER TABLE `tbl_mn_referencias_familiares`
  ADD PRIMARY KEY (`idReferencia`),
  ADD KEY `idPersona_fk_refe` (`idPersona`),
  ADD KEY `idparentesco_fk_paren` (`idParentesco`);

--
-- Indices de la tabla `tbl_mn_rubros`
--
ALTER TABLE `tbl_mn_rubros`
  ADD PRIMARY KEY (`idRubro`);

--
-- Indices de la tabla `tbl_mn_solicitudes_creditos`
--
ALTER TABLE `tbl_mn_solicitudes_creditos`
  ADD PRIMARY KEY (`idSolicitud`),
  ADD KEY `id_persona_fk_` (`idPersona`),
  ADD KEY `idTipoPrestamos_fk_` (`idTipoPrestamo`),
  ADD KEY `idRubro_fk_` (`idRubro`),
  ADD KEY `idEstadoSolicitud_fk_` (`idEstadoSolicitud`),
  ADD KEY `idUsuario_fk_` (`idUsuario`);

--
-- Indices de la tabla `tbl_mn_tiempo_laboral`
--
ALTER TABLE `tbl_mn_tiempo_laboral`
  ADD PRIMARY KEY (`idTiempoLaboral`);

--
-- Indices de la tabla `tbl_mn_tiempo_vivir`
--
ALTER TABLE `tbl_mn_tiempo_vivir`
  ADD PRIMARY KEY (`idtiempoVivir`);

--
-- Indices de la tabla `tbl_mn_tipos_de_pago`
--
ALTER TABLE `tbl_mn_tipos_de_pago`
  ADD PRIMARY KEY (`idTipoPago`);

--
-- Indices de la tabla `tbl_mn_tipos_prestamos`
--
ALTER TABLE `tbl_mn_tipos_prestamos`
  ADD PRIMARY KEY (`idTipoPrestamo`),
  ADD KEY `idEstadoTipoPrestamo_fk` (`idEstadoTipoPrestamo`);

--
-- Indices de la tabla `tbl_mn_tipo_clientes`
--
ALTER TABLE `tbl_mn_tipo_clientes`
  ADD PRIMARY KEY (`idTipoCliente`);

--
-- Indices de la tabla `tbl_mn_tipo_contacto`
--
ALTER TABLE `tbl_mn_tipo_contacto`
  ADD PRIMARY KEY (`idTipoContacto`);

--
-- Indices de la tabla `tbl_mn_tipo_cuenta`
--
ALTER TABLE `tbl_mn_tipo_cuenta`
  ADD PRIMARY KEY (`idTipoCuenta`);

--
-- Indices de la tabla `tbl_mn_tipo_persona`
--
ALTER TABLE `tbl_mn_tipo_persona`
  ADD PRIMARY KEY (`idTipoPersona`);

--
-- Indices de la tabla `tbl_ms_bitacora`
--
ALTER TABLE `tbl_ms_bitacora`
  ADD PRIMARY KEY (`idBitacora`),
  ADD KEY `idUsuario_Bitacora_fk` (`idUsuario`),
  ADD KEY `idObjeto_fk` (`idObjetos`);

--
-- Indices de la tabla `tbl_ms_estado_usuario`
--
ALTER TABLE `tbl_ms_estado_usuario`
  ADD PRIMARY KEY (`idEstadoUsuario`) USING BTREE;

--
-- Indices de la tabla `tbl_ms_hist_contrasenna`
--
ALTER TABLE `tbl_ms_hist_contrasenna`
  ADD PRIMARY KEY (`idHist`),
  ADD KEY `id_usuario_f_keyss` (`idUsuario`);

--
-- Indices de la tabla `tbl_ms_objetos`
--
ALTER TABLE `tbl_ms_objetos`
  ADD PRIMARY KEY (`idObjetos`);

--
-- Indices de la tabla `tbl_ms_parametros`
--
ALTER TABLE `tbl_ms_parametros`
  ADD PRIMARY KEY (`idParametro`),
  ADD KEY `fk_tipoParametro` (`idTipoDato`),
  ADD KEY `fk_usuarioParametro` (`idUsuario`);

--
-- Indices de la tabla `tbl_ms_permisos`
--
ALTER TABLE `tbl_ms_permisos`
  ADD PRIMARY KEY (`idPermiso`),
  ADD KEY `f_k_id_rol` (`idRol`),
  ADD KEY `foreing_keyy_idObjeto` (`idObjeto`);

--
-- Indices de la tabla `tbl_ms_preguntas`
--
ALTER TABLE `tbl_ms_preguntas`
  ADD PRIMARY KEY (`idPregunta`);

--
-- Indices de la tabla `tbl_ms_preguntas_usuario`
--
ALTER TABLE `tbl_ms_preguntas_usuario`
  ADD KEY `id_user_f_k` (`idUsuario`),
  ADD KEY `idPregunta_fk` (`idPregunta`);

--
-- Indices de la tabla `tbl_ms_roles`
--
ALTER TABLE `tbl_ms_roles`
  ADD PRIMARY KEY (`idRol`);

--
-- Indices de la tabla `tbl_ms_tipodato_parametros`
--
ALTER TABLE `tbl_ms_tipodato_parametros`
  ADD PRIMARY KEY (`idTipoDato`);

--
-- Indices de la tabla `tbl_ms_usuario`
--
ALTER TABLE `tbl_ms_usuario`
  ADD PRIMARY KEY (`idUsuario`),
  ADD KEY `idRol_fk` (`idRol`),
  ADD KEY `id_estado_usuario_fk` (`idEstadoUsuario`) USING BTREE;

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `tbl_logs_bitacora`
--
ALTER TABLE `tbl_logs_bitacora`
  MODIFY `idBitacora` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92;

--
-- AUTO_INCREMENT de la tabla `tbl_mn_analisis_crediticio`
--
ALTER TABLE `tbl_mn_analisis_crediticio`
  MODIFY `idAnalisisCrediticio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `tbl_mn_avala_a_persona`
--
ALTER TABLE `tbl_mn_avala_a_persona`
  MODIFY `idEsAval` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `tbl_mn_avales`
--
ALTER TABLE `tbl_mn_avales`
  MODIFY `idAval` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `tbl_mn_categoria_casa`
--
ALTER TABLE `tbl_mn_categoria_casa`
  MODIFY `idcategoriaCasa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tbl_mn_contrato`
--
ALTER TABLE `tbl_mn_contrato`
  MODIFY `idContrato` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `tbl_mn_conyugues`
--
ALTER TABLE `tbl_mn_conyugues`
  MODIFY `idConyuge` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `tbl_mn_credito_aval`
--
ALTER TABLE `tbl_mn_credito_aval`
  MODIFY `idCreditoAval` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `tbl_mn_estadocivil`
--
ALTER TABLE `tbl_mn_estadocivil`
  MODIFY `idEstadoCivil` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `tbl_mn_estadoplanpagos`
--
ALTER TABLE `tbl_mn_estadoplanpagos`
  MODIFY `idEstadoPlanPagos` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `tbl_mn_estados_solicitudes`
--
ALTER TABLE `tbl_mn_estados_solicitudes`
  MODIFY `idEstadoSolicitud` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `tbl_mn_estadotipoprestamo`
--
ALTER TABLE `tbl_mn_estadotipoprestamo`
  MODIFY `idestadoTipoPrestamo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tbl_mn_estado_analisiscrediticio`
--
ALTER TABLE `tbl_mn_estado_analisiscrediticio`
  MODIFY `idestadoAnalisisCrediticio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tbl_mn_estado_credito`
--
ALTER TABLE `tbl_mn_estado_credito`
  MODIFY `idEstadoCredito` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tbl_mn_genero`
--
ALTER TABLE `tbl_mn_genero`
  MODIFY `idGenero` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `tbl_mn_movimientos_financieros`
--
ALTER TABLE `tbl_mn_movimientos_financieros`
  MODIFY `idMovimientoFinanciero` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tbl_mn_municipio`
--
ALTER TABLE `tbl_mn_municipio`
  MODIFY `idMunicipio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `tbl_mn_nacionalidades`
--
ALTER TABLE `tbl_mn_nacionalidades`
  MODIFY `idNacionalidad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `tbl_mn_parentesco`
--
ALTER TABLE `tbl_mn_parentesco`
  MODIFY `idParentesco` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tbl_mn_personas`
--
ALTER TABLE `tbl_mn_personas`
  MODIFY `idPersona` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `tbl_mn_personas_bienes`
--
ALTER TABLE `tbl_mn_personas_bienes`
  MODIFY `idPersonaBienes` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `tbl_mn_personas_contacto`
--
ALTER TABLE `tbl_mn_personas_contacto`
  MODIFY `idPersonaContacto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de la tabla `tbl_mn_personas_cuenta`
--
ALTER TABLE `tbl_mn_personas_cuenta`
  MODIFY `idNumeroCuenta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `tbl_mn_personas_dependientes`
--
ALTER TABLE `tbl_mn_personas_dependientes`
  MODIFY `idDependientes` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `tbl_mn_plan_pagos_cuota_nivelada`
--
ALTER TABLE `tbl_mn_plan_pagos_cuota_nivelada`
  MODIFY `idPlanCuota` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `tbl_mn_profesiones_oficios`
--
ALTER TABLE `tbl_mn_profesiones_oficios`
  MODIFY `idProfesion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `tbl_mn_referencias_comerciales`
--
ALTER TABLE `tbl_mn_referencias_comerciales`
  MODIFY `idReferenciaComercial` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tbl_mn_referencias_familiares`
--
ALTER TABLE `tbl_mn_referencias_familiares`
  MODIFY `idReferencia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tbl_mn_rubros`
--
ALTER TABLE `tbl_mn_rubros`
  MODIFY `idRubro` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `tbl_mn_solicitudes_creditos`
--
ALTER TABLE `tbl_mn_solicitudes_creditos`
  MODIFY `idSolicitud` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `tbl_mn_tiempo_laboral`
--
ALTER TABLE `tbl_mn_tiempo_laboral`
  MODIFY `idTiempoLaboral` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `tbl_mn_tiempo_vivir`
--
ALTER TABLE `tbl_mn_tiempo_vivir`
  MODIFY `idtiempoVivir` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `tbl_mn_tipos_de_pago`
--
ALTER TABLE `tbl_mn_tipos_de_pago`
  MODIFY `idTipoPago` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `tbl_mn_tipos_prestamos`
--
ALTER TABLE `tbl_mn_tipos_prestamos`
  MODIFY `idTipoPrestamo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tbl_mn_tipo_clientes`
--
ALTER TABLE `tbl_mn_tipo_clientes`
  MODIFY `idTipoCliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `tbl_mn_tipo_contacto`
--
ALTER TABLE `tbl_mn_tipo_contacto`
  MODIFY `idTipoContacto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `tbl_mn_tipo_cuenta`
--
ALTER TABLE `tbl_mn_tipo_cuenta`
  MODIFY `idTipoCuenta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `tbl_mn_tipo_persona`
--
ALTER TABLE `tbl_mn_tipo_persona`
  MODIFY `idTipoPersona` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tbl_ms_bitacora`
--
ALTER TABLE `tbl_ms_bitacora`
  MODIFY `idBitacora` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=106;

--
-- AUTO_INCREMENT de la tabla `tbl_ms_estado_usuario`
--
ALTER TABLE `tbl_ms_estado_usuario`
  MODIFY `idEstadoUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `tbl_ms_hist_contrasenna`
--
ALTER TABLE `tbl_ms_hist_contrasenna`
  MODIFY `idHist` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tbl_ms_objetos`
--
ALTER TABLE `tbl_ms_objetos`
  MODIFY `idObjetos` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT de la tabla `tbl_ms_parametros`
--
ALTER TABLE `tbl_ms_parametros`
  MODIFY `idParametro` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `tbl_ms_permisos`
--
ALTER TABLE `tbl_ms_permisos`
  MODIFY `idPermiso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=164;

--
-- AUTO_INCREMENT de la tabla `tbl_ms_preguntas`
--
ALTER TABLE `tbl_ms_preguntas`
  MODIFY `idPregunta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `tbl_ms_roles`
--
ALTER TABLE `tbl_ms_roles`
  MODIFY `idRol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `tbl_ms_tipodato_parametros`
--
ALTER TABLE `tbl_ms_tipodato_parametros`
  MODIFY `idTipoDato` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tbl_ms_usuario`
--
ALTER TABLE `tbl_ms_usuario`
  MODIFY `idUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `tbl_mn_analisis_crediticio`
--
ALTER TABLE `tbl_mn_analisis_crediticio`
  ADD CONSTRAINT `id_estadoAnalisisCrediticio_fk` FOREIGN KEY (`idEstadoAnalisisCrediticio`) REFERENCES `tbl_mn_estado_analisiscrediticio` (`idestadoAnalisisCrediticio`),
  ADD CONSTRAINT `id_idPersona_fk_analisis` FOREIGN KEY (`idPersona`) REFERENCES `tbl_mn_personas` (`idPersona`),
  ADD CONSTRAINT `id_solicitud_fk` FOREIGN KEY (`idSolicitud`) REFERENCES `tbl_mn_solicitudes_creditos` (`idSolicitud`);

--
-- Filtros para la tabla `tbl_mn_avales`
--
ALTER TABLE `tbl_mn_avales`
  ADD CONSTRAINT `idSolicitud_fk_avales` FOREIGN KEY (`idSolicitud`) REFERENCES `tbl_mn_solicitudes_creditos` (`idSolicitud`),
  ADD CONSTRAINT `id_persona_fk` FOREIGN KEY (`idPersona`) REFERENCES `tbl_mn_personas` (`idPersona`);

--
-- Filtros para la tabla `tbl_mn_contrato`
--
ALTER TABLE `tbl_mn_contrato`
  ADD CONSTRAINT `fk_contratoSolicitud` FOREIGN KEY (`idSolicitud`) REFERENCES `tbl_mn_solicitudes_creditos` (`idSolicitud`);

--
-- Filtros para la tabla `tbl_mn_conyugues`
--
ALTER TABLE `tbl_mn_conyugues`
  ADD CONSTRAINT `idSolicitud_fk_conyuge` FOREIGN KEY (`idSolicitud`) REFERENCES `tbl_mn_solicitudes_creditos` (`idSolicitud`),
  ADD CONSTRAINT `id_persona_fk_conyugue` FOREIGN KEY (`idPersona`) REFERENCES `tbl_mn_personas` (`idPersona`);

--
-- Filtros para la tabla `tbl_mn_movimientos_financieros`
--
ALTER TABLE `tbl_mn_movimientos_financieros`
  ADD CONSTRAINT `idPlan_cuotas_fk` FOREIGN KEY (`idPlanCuota`) REFERENCES `tbl_mn_plan_pagos_cuota_nivelada` (`idPlanCuota`);

--
-- Filtros para la tabla `tbl_mn_personas`
--
ALTER TABLE `tbl_mn_personas`
  ADD CONSTRAINT `PersonaBienes_fk_` FOREIGN KEY (`idPersonaBienes`) REFERENCES `tbl_mn_personas_bienes` (`idPersonaBienes`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `Persona_municipio_fk` FOREIGN KEY (`idMunicipio`) REFERENCES `tbl_mn_municipio` (`idMunicipio`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `TipoDePago_fk` FOREIGN KEY (`PagaAlquiler`) REFERENCES `tbl_mn_tipos_de_pago` (`idTipoPago`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `creditoAval_fk` FOREIGN KEY (`avalMora`) REFERENCES `tbl_mn_credito_aval` (`idCreditoAval`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `esAval_fk_` FOREIGN KEY (`esAval`) REFERENCES `tbl_mn_avala_a_persona` (`idEsAval`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `estadoCredito_fk` FOREIGN KEY (`estadoCredito`) REFERENCES `tbl_mn_estado_credito` (`idEstadoCredito`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_nacionalidad` FOREIGN KEY (`idNacionalidad`) REFERENCES `tbl_mn_nacionalidades` (`idNacionalidad`),
  ADD CONSTRAINT `idEstado_civil_fk` FOREIGN KEY (`idEstadoCivil`) REFERENCES `tbl_mn_estadocivil` (`idEstadoCivil`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `idGenero_fk` FOREIGN KEY (`idGenero`) REFERENCES `tbl_mn_genero` (`idGenero`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `idProfesion_fk` FOREIGN KEY (`idProfesion`) REFERENCES `tbl_mn_profesiones_oficios` (`idProfesion`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `idTiempoLaboral_fk` FOREIGN KEY (`idTiempoLaboral`) REFERENCES `tbl_mn_tiempo_laboral` (`idTiempoLaboral`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `id_tipoPersona_fk` FOREIGN KEY (`idTipoPersona`) REFERENCES `tbl_mn_tipo_persona` (`idTipoPersona`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `id_tipo_clientes_fk` FOREIGN KEY (`idTipoClientes`) REFERENCES `tbl_mn_tipo_clientes` (`idTipoCliente`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `idcategoriaCasa_fk` FOREIGN KEY (`idcategoriaCasa`) REFERENCES `tbl_mn_categoria_casa` (`idcategoriaCasa`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `idtiempoVivir_fk` FOREIGN KEY (`idtiempoVivir`) REFERENCES `tbl_mn_tiempo_vivir` (`idtiempoVivir`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `tbl_mn_personas_contacto`
--
ALTER TABLE `tbl_mn_personas_contacto`
  ADD CONSTRAINT `idPersona_fk` FOREIGN KEY (`idPersona`) REFERENCES `tbl_mn_personas` (`idPersona`),
  ADD CONSTRAINT `idTipo_contacto_fK` FOREIGN KEY (`idTipoContacto`) REFERENCES `tbl_mn_tipo_contacto` (`idTipoContacto`);

--
-- Filtros para la tabla `tbl_mn_personas_cuenta`
--
ALTER TABLE `tbl_mn_personas_cuenta`
  ADD CONSTRAINT `idTipoCuenta_fk` FOREIGN KEY (`idTipoCuenta`) REFERENCES `tbl_mn_tipo_cuenta` (`idTipoCuenta`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `id_persona_fk_cuenta` FOREIGN KEY (`idPersona`) REFERENCES `tbl_mn_personas` (`idPersona`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `tbl_mn_personas_dependientes`
--
ALTER TABLE `tbl_mn_personas_dependientes`
  ADD CONSTRAINT `idPersona_f_k` FOREIGN KEY (`idPersona`) REFERENCES `tbl_mn_personas` (`idPersona`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `idparentesco_f_k` FOREIGN KEY (`idParentesco`) REFERENCES `tbl_mn_parentesco` (`idParentesco`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `tbl_mn_plan_pagos_cuota_nivelada`
--
ALTER TABLE `tbl_mn_plan_pagos_cuota_nivelada`
  ADD CONSTRAINT `idPersona_forgn_keys` FOREIGN KEY (`idPersona`) REFERENCES `tbl_mn_personas` (`idPersona`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `id_EstadoPlanPagos` FOREIGN KEY (`idEstadoPlanPagos`) REFERENCES `tbl_mn_estadoplanpagos` (`idEstadoPlanPagos`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `id_solicitud_fKysss` FOREIGN KEY (`idSolicitud`) REFERENCES `tbl_mn_solicitudes_creditos` (`idSolicitud`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `tbl_mn_referencias_comerciales`
--
ALTER TABLE `tbl_mn_referencias_comerciales`
  ADD CONSTRAINT `idPersona_fk_refeComercial` FOREIGN KEY (`idPersona`) REFERENCES `tbl_mn_personas` (`idPersona`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `tbl_mn_referencias_familiares`
--
ALTER TABLE `tbl_mn_referencias_familiares`
  ADD CONSTRAINT `idPersona_fk_refe` FOREIGN KEY (`idPersona`) REFERENCES `tbl_mn_personas` (`idPersona`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `idparentesco_fk_paren` FOREIGN KEY (`idParentesco`) REFERENCES `tbl_mn_parentesco` (`idParentesco`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `tbl_mn_solicitudes_creditos`
--
ALTER TABLE `tbl_mn_solicitudes_creditos`
  ADD CONSTRAINT `idEstadoSolicitud_fk_` FOREIGN KEY (`idEstadoSolicitud`) REFERENCES `tbl_mn_estados_solicitudes` (`idEstadoSolicitud`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `idRubro_fk_` FOREIGN KEY (`idRubro`) REFERENCES `tbl_mn_rubros` (`idRubro`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `idTipoPrestamos_fk_` FOREIGN KEY (`idTipoPrestamo`) REFERENCES `tbl_mn_tipos_prestamos` (`idTipoPrestamo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `idUsuario_fk_` FOREIGN KEY (`idUsuario`) REFERENCES `tbl_ms_usuario` (`idUsuario`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `id_persona_fk_` FOREIGN KEY (`idPersona`) REFERENCES `tbl_mn_personas` (`idPersona`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `tbl_mn_tipos_prestamos`
--
ALTER TABLE `tbl_mn_tipos_prestamos`
  ADD CONSTRAINT `idEstadoTipoPrestamo_fk` FOREIGN KEY (`idEstadoTipoPrestamo`) REFERENCES `tbl_mn_estadotipoprestamo` (`idestadoTipoPrestamo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `tbl_ms_bitacora`
--
ALTER TABLE `tbl_ms_bitacora`
  ADD CONSTRAINT `idObjeto_fk` FOREIGN KEY (`idObjetos`) REFERENCES `tbl_ms_objetos` (`idObjetos`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `idUsuario_Bitacora_fk` FOREIGN KEY (`idUsuario`) REFERENCES `tbl_ms_usuario` (`idUsuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `tbl_ms_hist_contrasenna`
--
ALTER TABLE `tbl_ms_hist_contrasenna`
  ADD CONSTRAINT `id_usuario_f_keyss` FOREIGN KEY (`idUsuario`) REFERENCES `tbl_ms_usuario` (`idUsuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `tbl_ms_parametros`
--
ALTER TABLE `tbl_ms_parametros`
  ADD CONSTRAINT `fk_tipoParametro` FOREIGN KEY (`idTipoDato`) REFERENCES `tbl_ms_tipodato_parametros` (`idTipoDato`),
  ADD CONSTRAINT `fk_usuarioParametro` FOREIGN KEY (`idUsuario`) REFERENCES `tbl_ms_usuario` (`idUsuario`);

--
-- Filtros para la tabla `tbl_ms_preguntas_usuario`
--
ALTER TABLE `tbl_ms_preguntas_usuario`
  ADD CONSTRAINT `idPregunta_fk` FOREIGN KEY (`idPregunta`) REFERENCES `tbl_ms_preguntas` (`idPregunta`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `id_user_f_k` FOREIGN KEY (`idUsuario`) REFERENCES `tbl_ms_usuario` (`idUsuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `tbl_ms_usuario`
--
ALTER TABLE `tbl_ms_usuario`
  ADD CONSTRAINT `fk_rolusuario` FOREIGN KEY (`idRol`) REFERENCES `tbl_ms_roles` (`idRol`);

DELIMITER $$
--
-- Eventos
--
CREATE DEFINER=`root`@`localhost` EVENT `verificacion_mora` ON SCHEDULE EVERY 1 DAY STARTS '2023-12-04 21:00:00' ON COMPLETION NOT PRESERVE ENABLE DO BEGIN
    DECLARE parametro_valor DECIMAL(10, 2); -- Utilizando DECIMAL para almacenar valores decimales, ajusta la precisión según sea necesario

    -- Obteniendo el valor de la tabla tbl_ms_parametros con idParametro = 7
    SELECT CAST(Valor AS DECIMAL(10, 2)) INTO parametro_valor
    FROM tbl_ms_parametros
    WHERE idParametro = 7;

    -- Realizando la actualización utilizando el valor obtenido y los cálculos
    UPDATE tbl_mn_plan_pagos_cuota_nivelada
    SET idEstadoPlanPagos = 3,
        diasRetraso = DATEDIFF(CURRENT_DATE, FechaCuota),
        interesesMoratorios = saldoCapital * (parametro_valor / 100), -- Multiplica saldoCapital por parametro_valor (que se asume como porcentaje)
        mora = (DATEDIFF(CURRENT_DATE, FechaCuota) / 30) * (saldoCapital * (parametro_valor / 100)) -- Multiplica (diasRetraso / 30) por el resultado anterior
    WHERE FechaCuota <= CURRENT_DATE AND idEstadoPlanPagos = 1 OR idEstadoPlanPagos = 3;

END$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
