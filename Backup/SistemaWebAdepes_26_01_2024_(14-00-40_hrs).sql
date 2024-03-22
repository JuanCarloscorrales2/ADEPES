SET FOREIGN_KEY_CHECKS=0;

CREATE DATABASE IF NOT EXISTS SistemaWebADEPES;

USE SistemaWebADEPES;

DROP TABLE IF EXISTS tb_mn_estudio_economico;

CREATE TABLE `tb_mn_estudio_economico` (
  `idEstudioEconomico` int(11) NOT NULL AUTO_INCREMENT,
  `idSolicitud` int(11) NOT NULL,
  `idTiposEstudio` int(11) NOT NULL,
  `idNivelVentas` int(11) NOT NULL,
  `idRubro` int(11) NOT NULL,
  `idIngresoIndicador` int(11) NOT NULL,
  `MargenGanancia` decimal(8,4) NOT NULL,
  `ventaCredito` tinyint(4) NOT NULL,
  `cuentasPorCobrar` decimal(8,4) NOT NULL,
  PRIMARY KEY (`idEstudioEconomico`),
  KEY `idTipoEstudio_FK` (`idTiposEstudio`),
  KEY `idSolicitud_FK` (`idSolicitud`),
  KEY `idRubro_FK` (`idRubro`),
  KEY `idIngresoIndicador` (`idIngresoIndicador`),
  KEY `idNivelVentas_FK` (`idNivelVentas`),
  CONSTRAINT `idIngresoIndicador` FOREIGN KEY (`idIngresoIndicador`) REFERENCES `tbl_mn_ingreso_indicador` (`idIngresoIndicador`),
  CONSTRAINT `idNivelVentas_FK` FOREIGN KEY (`idNivelVentas`) REFERENCES `tbl_mn_nivel_ventas` (`idNivelVentas`),
  CONSTRAINT `idRubro_FK` FOREIGN KEY (`idRubro`) REFERENCES `tbl_mn_rubros` (`idRubro`),
  CONSTRAINT `idSolicitud_FK` FOREIGN KEY (`idSolicitud`) REFERENCES `tbl_mn_solicitudes_creditos` (`idSolicitud`),
  CONSTRAINT `idTipoEstudio_FK` FOREIGN KEY (`idTiposEstudio`) REFERENCES `tbl_mn_tipos_estudio` (`idTiposEstudio`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;




DROP TABLE IF EXISTS tbl_mn_actividad_negocio;

CREATE TABLE `tbl_mn_actividad_negocio` (
  `idActividadNegocio` int(11) NOT NULL AUTO_INCREMENT,
  `idEstudioEconomico` int(11) NOT NULL,
  `IdDia` int(11) NOT NULL,
  `valorVenta` decimal(8,4) NOT NULL,
  `valorCompra` decimal(8,4) NOT NULL,
  PRIMARY KEY (`idActividadNegocio`),
  KEY `idDia_FK_act_negocio` (`IdDia`),
  CONSTRAINT `idDia_FK_act_negocio` FOREIGN KEY (`IdDia`) REFERENCES `tbl_mn_dias_semana` (`idDia`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;




DROP TABLE IF EXISTS tbl_mn_afluencia;

CREATE TABLE `tbl_mn_afluencia` (
  `idAfluencia` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(45) NOT NULL,
  PRIMARY KEY (`idAfluencia`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;




DROP TABLE IF EXISTS tbl_mn_analisis_crediticio;

CREATE TABLE `tbl_mn_analisis_crediticio` (
  `idAnalisisCrediticio` int(11) NOT NULL AUTO_INCREMENT,
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
  `Descripcion` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`idAnalisisCrediticio`),
  KEY `id_solicitud_fk` (`idSolicitud`),
  KEY `id_idPersona_fk_analisis` (`idPersona`),
  KEY `id_estadoAnalisisCrediticio_fk` (`idEstadoAnalisisCrediticio`),
  CONSTRAINT `id_estadoAnalisisCrediticio_fk` FOREIGN KEY (`idEstadoAnalisisCrediticio`) REFERENCES `tbl_mn_estado_analisiscrediticio` (`idestadoAnalisisCrediticio`),
  CONSTRAINT `id_idPersona_fk_analisis` FOREIGN KEY (`idPersona`) REFERENCES `tbl_mn_personas` (`idPersona`),
  CONSTRAINT `id_solicitud_fk` FOREIGN KEY (`idSolicitud`) REFERENCES `tbl_mn_solicitudes_creditos` (`idSolicitud`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_mn_analisis_crediticio VALUES("1","1","19","1","12000.00","25000.00","0.00","0.00","6500.00","0.00","0.00","6500.00","8500.00","0.00","0.00","24841.08","CLIENTE TIENE CAPACIDAD DE PAGO, PARA EL MONTO QUE ESTA SOLICITANDO");
INSERT INTO tbl_mn_analisis_crediticio VALUES("2","1","21","1","20000.00","25000.00","0.00","8500.00","2500.00","0.00","0.00","0.00","9500.00","0.00","0.00","42841.08","ESTA PERSONA TIENE CAPACIDAD DE PAGO, PARA SERVIR COMO AVAL SOLIDARIO");
INSERT INTO tbl_mn_analisis_crediticio VALUES("4","1","25","1","15000.00","25000.00","0.00","0.00","0.00","0.00","0.00","1500.00","8500.00","0.00","2500.00","23841.08","ESTA PERSONA TIENE CAPACIDAD DE PAGO, PARA SERVIR COMO AVAL SOLIDARIO");
INSERT INTO tbl_mn_analisis_crediticio VALUES("5","2","27","1","15000.00","2500.00","0.00","0.00","2000.00","0.00","0.00","0.00","6400.00","0.00","0.00","12734.11","CLIENTE TIENE CAPACIDAD DE PAGO, PARA EL MONTO QUE ESTA SOLICITANDO");
INSERT INTO tbl_mn_analisis_crediticio VALUES("6","2","29","1","15000.00","20000.00","0.00","0.00","6500.00","0.00","0.00","8500.00","3500.00","0.00","0.00","27060.72","ESTA PERSONA TIENE CAPACIDAD DE PAGO, PARA SERVIR COMO AVAL SOLIDARIO");
INSERT INTO tbl_mn_analisis_crediticio VALUES("8","4","32","1","2000.00","25000.00","0.00","8500.00","0.00","0.00","0.00","0.00","8500.00","0.00","5500.00","20444.18","CLIENTE TIENE CAPACIDAD DE PAGO, PARA EL MONTO QUE ESTA SOLICITANDO");
INSERT INTO tbl_mn_analisis_crediticio VALUES("9","2","34","1","15000.00","25000.00","0.00","5500.00","0.00","0.00","0.00","0.00","8500.00","0.00","8500.00","26060.72","ESTA PERSONA TIENE CAPACIDAD DE PAGO, PARA SERVIR COMO AVAL SOLIDARIO");
INSERT INTO tbl_mn_analisis_crediticio VALUES("10","2","35","1","15500.00","0.00","0.00","8500.00","0.00","0.00","0.00","6500.00","4500.00","0.00","0.00","10560.72","ESTA PERSONA TIENE CAPACIDAD DE PAGO, PARA SERVIR COMO AVAL SOLIDARIO");
INSERT INTO tbl_mn_analisis_crediticio VALUES("11","5","38","1","15000.00","20000.00","7500.00","0.00","0.00","0.00","300.00","0.00","8300.00","0.00","8500.00","23957.52","CLIENTE TIENE CAPACIDAD DE PAGO, PARA EL MONTO QUE ESTA SOLICITANDO");
INSERT INTO tbl_mn_analisis_crediticio VALUES("12","5","39","1","13500.00","18500.00","0.00","3500.00","1000.00","0.00","0.00","0.00","3500.00","0.00","0.00","31557.52","ESTA PERSONA TIENE CAPACIDAD DE PAGO, PARA SERVIR COMO AVAL SOLIDARIO");
INSERT INTO tbl_mn_analisis_crediticio VALUES("13","5","41","1","18500.00","25000.00","0.00","0.00","0.00","0.00","0.00","8500.00","9500.00","0.00","0.00","24057.52","ESTA PERSONA TIENE CAPACIDAD DE PAGO, PARA SERVIR COMO AVAL SOLIDARIO");
INSERT INTO tbl_mn_analisis_crediticio VALUES("14","5","43","1","25200.00","0.00","2.00","0.00","0.00","0.00","0.00","0.00","855.00","0.00","0.00","22904.52","ESTA PERSONA TIENE CAPACIDAD DE PAGO, PARA SERVIR COMO AVAL SOLIDARIO");
INSERT INTO tbl_mn_analisis_crediticio VALUES("15","6","44","1","2000.00","8555.00","0.00","0.00","0.00","0.00","0.00","0.00","555.00","2.00","0.00","8414.27","CLIENTE TIENE CAPACIDAD DE PAGO, PARA EL MONTO QUE ESTA SOLICITANDO");



DROP TABLE IF EXISTS tbl_mn_antiguedad;

CREATE TABLE `tbl_mn_antiguedad` (
  `idAntiguedad` int(11) NOT NULL AUTO_INCREMENT,
  `Descripcion` varchar(45) NOT NULL,
  PRIMARY KEY (`idAntiguedad`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;




DROP TABLE IF EXISTS tbl_mn_avala_a_persona;

CREATE TABLE `tbl_mn_avala_a_persona` (
  `idEsAval` int(11) NOT NULL AUTO_INCREMENT,
  `Descripcion` varchar(30) NOT NULL,
  PRIMARY KEY (`idEsAval`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_mn_avala_a_persona VALUES("1","NO ES AVAL");
INSERT INTO tbl_mn_avala_a_persona VALUES("2","AVALA 1 PERSONA");
INSERT INTO tbl_mn_avala_a_persona VALUES("3","AVALA 2 PERSONAS");
INSERT INTO tbl_mn_avala_a_persona VALUES("4","AVALA MAS DE 2 PERSONAS");



DROP TABLE IF EXISTS tbl_mn_avales;

CREATE TABLE `tbl_mn_avales` (
  `idAval` int(11) NOT NULL AUTO_INCREMENT,
  `idSolicitud` int(11) NOT NULL,
  `idPersona` int(11) NOT NULL,
  PRIMARY KEY (`idAval`),
  KEY `idSolicitud_fk_avales` (`idSolicitud`),
  KEY `id_persona_fk` (`idPersona`),
  CONSTRAINT `idSolicitud_fk_avales` FOREIGN KEY (`idSolicitud`) REFERENCES `tbl_mn_solicitudes_creditos` (`idSolicitud`),
  CONSTRAINT `id_persona_fk` FOREIGN KEY (`idPersona`) REFERENCES `tbl_mn_personas` (`idPersona`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_mn_avales VALUES("1","1","21");
INSERT INTO tbl_mn_avales VALUES("3","1","25");
INSERT INTO tbl_mn_avales VALUES("4","2","29");
INSERT INTO tbl_mn_avales VALUES("5","2","34");
INSERT INTO tbl_mn_avales VALUES("6","2","35");
INSERT INTO tbl_mn_avales VALUES("7","5","39");
INSERT INTO tbl_mn_avales VALUES("8","5","41");
INSERT INTO tbl_mn_avales VALUES("9","5","43");



DROP TABLE IF EXISTS tbl_mn_categoria_casa;

CREATE TABLE `tbl_mn_categoria_casa` (
  `idcategoriaCasa` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(40) NOT NULL,
  PRIMARY KEY (`idcategoriaCasa`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_mn_categoria_casa VALUES("1","Propia");
INSERT INTO tbl_mn_categoria_casa VALUES("2","Alquila");
INSERT INTO tbl_mn_categoria_casa VALUES("3","Familiar");



DROP TABLE IF EXISTS tbl_mn_conyugues;

CREATE TABLE `tbl_mn_conyugues` (
  `idConyuge` int(11) NOT NULL AUTO_INCREMENT,
  `idSolicitud` int(11) NOT NULL,
  `idPersona` int(11) NOT NULL,
  `ingresosNegocio` decimal(8,2) DEFAULT NULL,
  `sueldoBase` decimal(8,2) DEFAULT NULL,
  `gastoAlimentacion` decimal(8,2) DEFAULT NULL,
  `idPersonaPareja` int(11) NOT NULL,
  PRIMARY KEY (`idConyuge`),
  KEY `idSolicitud_fk_conyuge` (`idSolicitud`),
  KEY `id_persona_fk_conyugue` (`idPersona`),
  CONSTRAINT `idSolicitud_fk_conyuge` FOREIGN KEY (`idSolicitud`) REFERENCES `tbl_mn_solicitudes_creditos` (`idSolicitud`),
  CONSTRAINT `id_persona_fk_conyugue` FOREIGN KEY (`idPersona`) REFERENCES `tbl_mn_personas` (`idPersona`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_mn_conyugues VALUES("1","1","20","15000.00","25000.00","2500.00","19");
INSERT INTO tbl_mn_conyugues VALUES("2","1","22","0.00","6500.00","2500.00","21");
INSERT INTO tbl_mn_conyugues VALUES("3","1","26","0.00","0.00","0.00","25");
INSERT INTO tbl_mn_conyugues VALUES("4","2","28","0.00","15000.00","2000.00","27");
INSERT INTO tbl_mn_conyugues VALUES("5","2","30","30000.00","20000.00","6500.00","29");
INSERT INTO tbl_mn_conyugues VALUES("6","4","33","0.00","2500.00","3500.00","32");
INSERT INTO tbl_mn_conyugues VALUES("7","2","36","20000.00","12000.00","2500.00","35");
INSERT INTO tbl_mn_conyugues VALUES("8","5","40","0.00","8500.00","2000.00","39");



DROP TABLE IF EXISTS tbl_mn_credito_aval;

CREATE TABLE `tbl_mn_credito_aval` (
  `idCreditoAval` int(11) NOT NULL AUTO_INCREMENT,
  `Descripcion` varchar(30) NOT NULL,
  PRIMARY KEY (`idCreditoAval`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_mn_credito_aval VALUES("1","CREDITO(S) AL DIA");
INSERT INTO tbl_mn_credito_aval VALUES("2","1 AVAL EN MORA");
INSERT INTO tbl_mn_credito_aval VALUES("3","2 AVALES EN MORA");
INSERT INTO tbl_mn_credito_aval VALUES("4","3 AVALES EN MORA");
INSERT INTO tbl_mn_credito_aval VALUES("5","4 AVALES EN MORA");



DROP TABLE IF EXISTS tbl_mn_dias_semana;

CREATE TABLE `tbl_mn_dias_semana` (
  `idDia` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(20) NOT NULL,
  PRIMARY KEY (`idDia`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;




DROP TABLE IF EXISTS tbl_mn_estado_analisiscrediticio;

CREATE TABLE `tbl_mn_estado_analisiscrediticio` (
  `idestadoAnalisisCrediticio` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(30) NOT NULL,
  PRIMARY KEY (`idestadoAnalisisCrediticio`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_mn_estado_analisiscrediticio VALUES("1","aprobado");
INSERT INTO tbl_mn_estado_analisiscrediticio VALUES("2","no aprobado");



DROP TABLE IF EXISTS tbl_mn_estado_credito;

CREATE TABLE `tbl_mn_estado_credito` (
  `idEstadoCredito` int(11) NOT NULL AUTO_INCREMENT,
  `Descripcion` varchar(30) NOT NULL,
  PRIMARY KEY (`idEstadoCredito`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_mn_estado_credito VALUES("1","CON PAGO NORMAL");
INSERT INTO tbl_mn_estado_credito VALUES("2","CON PAGO REGULAR");
INSERT INTO tbl_mn_estado_credito VALUES("3","CON PAGO IRREGULAR");



DROP TABLE IF EXISTS tbl_mn_estado_factor_riesgo;

CREATE TABLE `tbl_mn_estado_factor_riesgo` (
  `idEstadoFactorRiesgo` int(11) NOT NULL,
  `descripcion` varchar(20) NOT NULL,
  PRIMARY KEY (`idEstadoFactorRiesgo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;




DROP TABLE IF EXISTS tbl_mn_estado_negocio;

CREATE TABLE `tbl_mn_estado_negocio` (
  `idEstadoNegocio` int(11) NOT NULL AUTO_INCREMENT,
  `Descripcion` varchar(50) NOT NULL,
  PRIMARY KEY (`idEstadoNegocio`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;




DROP TABLE IF EXISTS tbl_mn_estadocivil;

CREATE TABLE `tbl_mn_estadocivil` (
  `idEstadoCivil` int(11) NOT NULL AUTO_INCREMENT,
  `Descripcion` varchar(20) NOT NULL,
  PRIMARY KEY (`idEstadoCivil`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_mn_estadocivil VALUES("1","SOLTERO");
INSERT INTO tbl_mn_estadocivil VALUES("2","CASADO");
INSERT INTO tbl_mn_estadocivil VALUES("3","UNION LIBRE");
INSERT INTO tbl_mn_estadocivil VALUES("4","NO ESTA DEFINIDO");



DROP TABLE IF EXISTS tbl_mn_estadoplanpagos;

CREATE TABLE `tbl_mn_estadoplanpagos` (
  `idEstadoPlanPagos` int(11) NOT NULL AUTO_INCREMENT,
  `Descripcion` varchar(30) NOT NULL,
  PRIMARY KEY (`idEstadoPlanPagos`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_mn_estadoplanpagos VALUES("1","PENDIENTE");
INSERT INTO tbl_mn_estadoplanpagos VALUES("2","CANCELADO");
INSERT INTO tbl_mn_estadoplanpagos VALUES("3","MORA");
INSERT INTO tbl_mn_estadoplanpagos VALUES("4","CANCELADA POR PAGO ANTICIPADO");



DROP TABLE IF EXISTS tbl_mn_estados_solicitudes;

CREATE TABLE `tbl_mn_estados_solicitudes` (
  `idEstadoSolicitud` int(11) NOT NULL AUTO_INCREMENT,
  `Descripcion` varchar(20) NOT NULL,
  PRIMARY KEY (`idEstadoSolicitud`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_mn_estados_solicitudes VALUES("1","Aprobada");
INSERT INTO tbl_mn_estados_solicitudes VALUES("2","Denegada");
INSERT INTO tbl_mn_estados_solicitudes VALUES("3","Pendiente");



DROP TABLE IF EXISTS tbl_mn_estadotipoprestamo;

CREATE TABLE `tbl_mn_estadotipoprestamo` (
  `idestadoTipoPrestamo` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(20) NOT NULL,
  PRIMARY KEY (`idestadoTipoPrestamo`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_mn_estadotipoprestamo VALUES("1","Activo");
INSERT INTO tbl_mn_estadotipoprestamo VALUES("2","Inactivo");



DROP TABLE IF EXISTS tbl_mn_evaluacion_negocio;

CREATE TABLE `tbl_mn_evaluacion_negocio` (
  `idEvaluacion` int(11) NOT NULL AUTO_INCREMENT,
  `idSolicitud` int(11) NOT NULL,
  `idPersona` int(11) NOT NULL,
  `idRubro` int(11) NOT NULL,
  `idUbicacion` int(11) NOT NULL,
  `idEstadoNegocio` int(11) NOT NULL,
  `idProveedor` int(11) NOT NULL,
  `nombreNegocio` varchar(60) NOT NULL,
  `ProveedorPrincipal` varchar(60) NOT NULL,
  `sustitutoNegocio` tinyint(4) NOT NULL,
  `cuentasPorPagar` decimal(8,4) NOT NULL,
  `idProfesion` int(11) NOT NULL,
  `idAfluencia` int(11) NOT NULL,
  `idTendencia` int(11) NOT NULL,
  `idFormaCompra` int(11) NOT NULL,
  `idPlazoProveedores` int(11) NOT NULL,
  `idNumEmpleados` int(11) NOT NULL,
  `idExperiencia` int(11) NOT NULL,
  `idAntiguedad` int(11) NOT NULL,
  `idTiempoLocal` int(11) NOT NULL,
  `idResultadoFactorRiesgo` int(11) NOT NULL,
  PRIMARY KEY (`idEvaluacion`),
  KEY `idSolicitud_fk_evaluacion` (`idSolicitud`),
  KEY `idPersona_fk_evaluacion` (`idPersona`),
  KEY `idRubro_FK_evaluacion` (`idRubro`),
  KEY `idProveedor_FK_` (`idProveedor`),
  KEY `idEstadoNegocio_FK_` (`idEstadoNegocio`),
  KEY `idUbicacion_FK_` (`idUbicacion`),
  KEY `idProfesion_FK_` (`idProfesion`),
  KEY `idAntiguedad_FK_` (`idAntiguedad`),
  KEY `idTendencia_FK_` (`idTendencia`),
  KEY `idAflencia_FK_` (`idAfluencia`),
  KEY `idFormaCompra_FK_` (`idFormaCompra`),
  KEY `idPlazoProveedor_FK_` (`idPlazoProveedores`),
  KEY `idTiempoLocal_FK_` (`idTiempoLocal`),
  KEY `idNumEmplea_FK_` (`idNumEmpleados`),
  KEY `idExperiencia_FK_` (`idExperiencia`),
  KEY `idRestFactRiesgo_FK_` (`idResultadoFactorRiesgo`),
  CONSTRAINT `idAflencia_FK_` FOREIGN KEY (`idAfluencia`) REFERENCES `tbl_mn_afluencia` (`idAfluencia`),
  CONSTRAINT `idAntiguedad_FK_` FOREIGN KEY (`idAntiguedad`) REFERENCES `tbl_mn_antiguedad` (`idAntiguedad`),
  CONSTRAINT `idEstadoNegocio_FK_` FOREIGN KEY (`idEstadoNegocio`) REFERENCES `tbl_mn_estado_negocio` (`idEstadoNegocio`),
  CONSTRAINT `idExperiencia_FK_` FOREIGN KEY (`idExperiencia`) REFERENCES `tbl_mn_experiencia` (`idExperiencia`),
  CONSTRAINT `idFormaCompra_FK_` FOREIGN KEY (`idFormaCompra`) REFERENCES `tbl_mn_forma_compra` (`idFormaCompra`),
  CONSTRAINT `idNumEmplea_FK_` FOREIGN KEY (`idNumEmpleados`) REFERENCES `tbl_mn_numero_empleados` (`idNumEmpleado`),
  CONSTRAINT `idPersona_fk_evaluacion` FOREIGN KEY (`idPersona`) REFERENCES `tbl_mn_personas` (`idPersona`),
  CONSTRAINT `idPlazoProveedor_FK_` FOREIGN KEY (`idPlazoProveedores`) REFERENCES `tbl_mn_plazo_proveedores` (`idPlazoProveedor`),
  CONSTRAINT `idProfesion_FK_` FOREIGN KEY (`idProfesion`) REFERENCES `tbl_mn_profesiones_oficios` (`idProfesion`),
  CONSTRAINT `idProveedor_FK_` FOREIGN KEY (`idProveedor`) REFERENCES `tbl_mn_proveedor` (`idProveedor`),
  CONSTRAINT `idRestFactRiesgo_FK_` FOREIGN KEY (`idResultadoFactorRiesgo`) REFERENCES `tbl_mn_resultado_factor_riesgo` (`idResultadoFactorRiesgo`),
  CONSTRAINT `idRubro_FK_evaluacion` FOREIGN KEY (`idRubro`) REFERENCES `tbl_mn_rubros` (`idRubro`),
  CONSTRAINT `idSolicitud_fk_evaluacion` FOREIGN KEY (`idSolicitud`) REFERENCES `tbl_mn_solicitudes_creditos` (`idSolicitud`),
  CONSTRAINT `idTendencia_FK_` FOREIGN KEY (`idTendencia`) REFERENCES `tbl_mn_tendencia` (`idTendencia`),
  CONSTRAINT `idTiempoLocal_FK_` FOREIGN KEY (`idTiempoLocal`) REFERENCES `tbl_mn_tiempo_local` (`idTiempoLocal`),
  CONSTRAINT `idUbicacion_FK_` FOREIGN KEY (`idUbicacion`) REFERENCES `tbl_mn_ubicacion_fisica` (`idUbicacion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;




DROP TABLE IF EXISTS tbl_mn_experiencia;

CREATE TABLE `tbl_mn_experiencia` (
  `idExperiencia` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(45) NOT NULL,
  PRIMARY KEY (`idExperiencia`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;




DROP TABLE IF EXISTS tbl_mn_forma_compra;

CREATE TABLE `tbl_mn_forma_compra` (
  `idFormaCompra` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(45) NOT NULL,
  PRIMARY KEY (`idFormaCompra`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;




DROP TABLE IF EXISTS tbl_mn_genero;

CREATE TABLE `tbl_mn_genero` (
  `idGenero` int(11) NOT NULL AUTO_INCREMENT,
  `Descripcion` varchar(20) NOT NULL,
  PRIMARY KEY (`idGenero`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_mn_genero VALUES("1","FEMENINO");
INSERT INTO tbl_mn_genero VALUES("2","MASCULINO");



DROP TABLE IF EXISTS tbl_mn_indicador_conf;

CREATE TABLE `tbl_mn_indicador_conf` (
  `idindicadorConf` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(25) NOT NULL,
  PRIMARY KEY (`idindicadorConf`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;




DROP TABLE IF EXISTS tbl_mn_ingreso_indicador;

CREATE TABLE `tbl_mn_ingreso_indicador` (
  `idIngresoIndicador` int(11) NOT NULL AUTO_INCREMENT,
  `idIndicadorConfig` int(11) NOT NULL,
  `monto` float NOT NULL,
  PRIMARY KEY (`idIngresoIndicador`),
  KEY `idIndicConfig_FK` (`idIndicadorConfig`),
  CONSTRAINT `idIndicConfig_FK` FOREIGN KEY (`idIndicadorConfig`) REFERENCES `tbl_mn_indicador_conf` (`idindicadorConf`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;




DROP TABLE IF EXISTS tbl_mn_movimientos_financieros;

CREATE TABLE `tbl_mn_movimientos_financieros` (
  `idMovimientoFinanciero` int(11) NOT NULL AUTO_INCREMENT,
  `idPlanCuota` int(11) NOT NULL,
  `fechaDeposito` date NOT NULL,
  `saldoInicial` decimal(8,2) NOT NULL DEFAULT 0.00,
  `pagos` decimal(8,2) DEFAULT NULL,
  `pagoAdicional` decimal(8,2) DEFAULT 0.00,
  `abonoCapital` decimal(8,2) NOT NULL,
  `flujoCaja` decimal(8,2) NOT NULL DEFAULT 0.00,
  `fechaPago` date DEFAULT NULL,
  `idSolicitud` int(11) DEFAULT NULL,
  PRIMARY KEY (`idMovimientoFinanciero`),
  KEY `idPlan_cuotas_fk` (`idPlanCuota`),
  CONSTRAINT `idPlan_cuotas_fk` FOREIGN KEY (`idPlanCuota`) REFERENCES `tbl_mn_plan_pagos_cuota_nivelada` (`idPlanCuota`)
) ENGINE=InnoDB AUTO_INCREMENT=211 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_mn_movimientos_financieros VALUES("196","1","2023-11-29","0.00","3658.92","1341.08","3067.14","0.00","2023-11-29","1");
INSERT INTO tbl_mn_movimientos_financieros VALUES("197","2","2023-11-28","0.00","3658.92","6341.08","3097.39","0.00","2023-11-28","1");
INSERT INTO tbl_mn_movimientos_financieros VALUES("198","3","2023-11-28","0.00","3658.92","841.08","3110.24","0.00","2023-11-28","1");
INSERT INTO tbl_mn_movimientos_financieros VALUES("199","4","2023-11-21","0.00","3658.92","0.00","3158.62","0.00","2023-11-21","1");
INSERT INTO tbl_mn_movimientos_financieros VALUES("200","5","2023-11-21","0.00","3658.92","0.00","3205.41","0.00","2023-11-21","1");
INSERT INTO tbl_mn_movimientos_financieros VALUES("201","6","2023-11-21","0.00","3658.92","841.08","3206.80","0.00","2023-11-21","1");
INSERT INTO tbl_mn_movimientos_financieros VALUES("202","7","2023-11-28","0.00","3658.92","0.00","3253.01","0.00","2023-11-28","1");
INSERT INTO tbl_mn_movimientos_financieros VALUES("203","8","2023-11-28","0.00","3658.92","5341.08","3272.64","0.00","2023-11-28","1");
INSERT INTO tbl_mn_movimientos_financieros VALUES("204","9","2023-11-29","0.00","3658.92","0.00","3317.38","0.00","2023-11-29","1");
INSERT INTO tbl_mn_movimientos_financieros VALUES("205","10","2023-11-27","0.00","3658.92","841.08","3339.80","0.00","2023-11-27","1");
INSERT INTO tbl_mn_movimientos_financieros VALUES("206","11","2023-11-20","0.00","3658.92","0.00","3373.84","0.00","2023-11-20","1");
INSERT INTO tbl_mn_movimientos_financieros VALUES("207","12","2023-11-28","0.00","3658.92","0.00","3416.31","0.00","2023-11-28","1");
INSERT INTO tbl_mn_movimientos_financieros VALUES("208","43","2023-12-09","0.00","897.45","0.00","813.61","0.00","2023-12-09","4");
INSERT INTO tbl_mn_movimientos_financieros VALUES("209","44","2024-01-09","0.00","897.45","2602.55","819.11","0.00","2024-01-09","4");
INSERT INTO tbl_mn_movimientos_financieros VALUES("210","45","2024-02-09","0.00","897.45","0.00","827.46","0.00","2024-02-09","4");



DROP TABLE IF EXISTS tbl_mn_municipio;

CREATE TABLE `tbl_mn_municipio` (
  `idMunicipio` int(11) NOT NULL AUTO_INCREMENT,
  `Descripcion` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`idMunicipio`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_mn_municipio VALUES("1","PESPIRE");
INSERT INTO tbl_mn_municipio VALUES("2","SAN ANTONIO DE FLORES");
INSERT INTO tbl_mn_municipio VALUES("3","SAN ISIDRO");
INSERT INTO tbl_mn_municipio VALUES("4","SAN JOSE");



DROP TABLE IF EXISTS tbl_mn_nacionalidades;

CREATE TABLE `tbl_mn_nacionalidades` (
  `idNacionalidad` int(11) NOT NULL AUTO_INCREMENT,
  `Descripcion` varchar(20) NOT NULL,
  PRIMARY KEY (`idNacionalidad`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_mn_nacionalidades VALUES("1","HONDUREÑA");



DROP TABLE IF EXISTS tbl_mn_nivel_ventas;

CREATE TABLE `tbl_mn_nivel_ventas` (
  `idNivelVentas` int(11) NOT NULL,
  `idIndicadorConfig` int(11) NOT NULL,
  `idDia` int(11) NOT NULL,
  PRIMARY KEY (`idNivelVentas`),
  KEY `idIndicConfig_FK_nivelVenta` (`idIndicadorConfig`),
  KEY `idDia_FK` (`idDia`),
  CONSTRAINT `idDia_FK` FOREIGN KEY (`idDia`) REFERENCES `tbl_mn_dias_semana` (`idDia`),
  CONSTRAINT `idIndicConfig_FK_nivelVenta` FOREIGN KEY (`idIndicadorConfig`) REFERENCES `tbl_mn_indicador_conf` (`idindicadorConf`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;




DROP TABLE IF EXISTS tbl_mn_numero_empleados;

CREATE TABLE `tbl_mn_numero_empleados` (
  `idNumEmpleado` int(11) NOT NULL,
  `cantidad` varchar(45) NOT NULL,
  PRIMARY KEY (`idNumEmpleado`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;




DROP TABLE IF EXISTS tbl_mn_parentesco;

CREATE TABLE `tbl_mn_parentesco` (
  `idParentesco` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(50) NOT NULL,
  PRIMARY KEY (`idParentesco`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_mn_parentesco VALUES("1","Hermano (a)");
INSERT INTO tbl_mn_parentesco VALUES("2","Abuelo (a)");
INSERT INTO tbl_mn_parentesco VALUES("3","Tio (a)");



DROP TABLE IF EXISTS tbl_mn_personas;

CREATE TABLE `tbl_mn_personas` (
  `idPersona` int(11) NOT NULL AUTO_INCREMENT,
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
  PRIMARY KEY (`idPersona`),
  KEY `id_tipoPersona_fk` (`idTipoPersona`),
  KEY `idNacionalidad_fk` (`idNacionalidad`),
  KEY `idGenero_fk` (`idGenero`),
  KEY `idEstado_civil_fk` (`idEstadoCivil`),
  KEY `idProfesion_fk` (`idProfesion`),
  KEY `id_tipo_clientes_fk` (`idTipoClientes`),
  KEY `idcategoriaCasa_fk` (`idcategoriaCasa`),
  KEY `idtiempoVivir_fk` (`idtiempoVivir`),
  KEY `idTiempoLaboral_fk` (`idTiempoLaboral`),
  KEY `TipoDePago_fk` (`PagaAlquiler`),
  KEY `esAval_fk_` (`esAval`),
  KEY `creditoAval_fk` (`avalMora`),
  KEY `estadoCredito_fk` (`estadoCredito`),
  KEY `PersonaBienes_fk_` (`idPersonaBienes`),
  KEY `Persona_municipio_fk` (`idMunicipio`),
  CONSTRAINT `PersonaBienes_fk_` FOREIGN KEY (`idPersonaBienes`) REFERENCES `tbl_mn_personas_bienes` (`idPersonaBienes`),
  CONSTRAINT `Persona_municipio_fk` FOREIGN KEY (`idMunicipio`) REFERENCES `tbl_mn_municipio` (`idMunicipio`),
  CONSTRAINT `TipoDePago_fk` FOREIGN KEY (`PagaAlquiler`) REFERENCES `tbl_mn_tipos_de_pago` (`idTipoPago`),
  CONSTRAINT `creditoAval_fk` FOREIGN KEY (`avalMora`) REFERENCES `tbl_mn_credito_aval` (`idCreditoAval`),
  CONSTRAINT `esAval_fk_` FOREIGN KEY (`esAval`) REFERENCES `tbl_mn_avala_a_persona` (`idEsAval`),
  CONSTRAINT `estadoCredito_fk` FOREIGN KEY (`estadoCredito`) REFERENCES `tbl_mn_estado_credito` (`idEstadoCredito`),
  CONSTRAINT `idEstado_civil_fk` FOREIGN KEY (`idEstadoCivil`) REFERENCES `tbl_mn_estadocivil` (`idEstadoCivil`),
  CONSTRAINT `idGenero_fk` FOREIGN KEY (`idGenero`) REFERENCES `tbl_mn_genero` (`idGenero`),
  CONSTRAINT `idNacionalidad_fk` FOREIGN KEY (`idNacionalidad`) REFERENCES `tbl_mn_nacionalidades` (`idNacionalidad`),
  CONSTRAINT `idProfesion_fk` FOREIGN KEY (`idProfesion`) REFERENCES `tbl_mn_profesiones_oficios` (`idProfesion`),
  CONSTRAINT `idTiempoLaboral_fk` FOREIGN KEY (`idTiempoLaboral`) REFERENCES `tbl_mn_tiempo_laboral` (`idTiempoLaboral`),
  CONSTRAINT `id_tipoPersona_fk` FOREIGN KEY (`idTipoPersona`) REFERENCES `tbl_mn_tipo_persona` (`idTipoPersona`),
  CONSTRAINT `id_tipo_clientes_fk` FOREIGN KEY (`idTipoClientes`) REFERENCES `tbl_mn_tipo_clientes` (`idTipoCliente`),
  CONSTRAINT `idcategoriaCasa_fk` FOREIGN KEY (`idcategoriaCasa`) REFERENCES `tbl_mn_categoria_casa` (`idcategoriaCasa`),
  CONSTRAINT `idtiempoVivir_fk` FOREIGN KEY (`idtiempoVivir`) REFERENCES `tbl_mn_tiempo_vivir` (`idtiempoVivir`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_mn_personas VALUES("19","1","1","2","2","1","1","2","2","3","5","1","1","1","1","2","JOSE FERNANDO","MARTINEZ AGUILAR","0801-2004-65522","2004-07-09","","PATRONO PROPIO","EMPRENDEDOR","SOLICITUD DE JOSE FERNANDO");
INSERT INTO tbl_mn_personas VALUES("20","2","1","1","2","1","","2","2","3","2","1","1","1","1","1","MARIA DE MARTINEZ","RAMIREZ","1565-2000-65656","2000-10-18","","NEGOCIO","GERENTE","");
INSERT INTO tbl_mn_personas VALUES("21","3","1","2","2","1","","2","1","2","3","1","1","1","1","1","ADAN","HERNANDEZ","0896-1999-23223","1999-07-09","","NEGOCIO PROPIO DE ADANA","VENDEDOR","SIN OBSERVACIONES AVAL 1");
INSERT INTO tbl_mn_personas VALUES("22","2","1","1","2","1","","2","1","2","1","1","1","1","1","1","ANA","ORTIZ","0212-2006-56565","2006-10-11","","NO TIENE NEGOCIO","NO TIENE CARGO","");
INSERT INTO tbl_mn_personas VALUES("24","2","1","2","3","1","","2","1","2","1","1","1","1","1","1","JEFFERSON SAID ","LOPEZ","0101-2010-56565","2010-09-07","","PATRONO DE JEFER","AYUDANTE EN FERRETERIA DE CELE","");
INSERT INTO tbl_mn_personas VALUES("25","3","1","1","2","1","","2","2","3","4","3","1","1","1","1","LOURDES","MATAMOROS","0801-2001-10147","2001-10-17","","NEGOCIO PROPIO","VENDEDORA DE ROPA","");
INSERT INTO tbl_mn_personas VALUES("26","2","1","2","2","1","","2","2","3","2","3","1","1","1","1","MAAYNOR","MATAMOROS","0701-2023-14588","2023-10-11","","NO TIENE","ASITENTE","");
INSERT INTO tbl_mn_personas VALUES("27","1","1","2","3","1","7","2","1","4","3","1","1","1","1","1","PEDRO JOSE ","RAUDALES","0611-1999-12555","1999-06-01","","NEGOCIO PROPIO","EMPRENDEDORA","");
INSERT INTO tbl_mn_personas VALUES("28","2","1","1","3","1","","2","1","4","2","1","1","1","1","1","NANCY ","BARAHONA","0801-1998-32222","1998-06-01","","NEGOCIO PROPIO","EMPRENDEDORA","");
INSERT INTO tbl_mn_personas VALUES("29","3","1","1","2","1","","3","2","3","3","4","1","1","1","1","LESLY JOHANA","ALVAREZ","0801-1996-22222","1996-09-01","","NEGOCIO PROPIO","VENDEDORA DE MERCADERIA","FALTA CONFIRMAR INFORMACION");
INSERT INTO tbl_mn_personas VALUES("30","2","1","2","2","1","","2","2","3","2","4","1","1","1","1","EDGAR ","SANCHEZ","0511-1997-23887","1997-07-11","","NEGOCIO PROPIO","GERENTE","");
INSERT INTO tbl_mn_personas VALUES("32","1","1","2","2","1","4","2","1","2","2","1","1","1","1","1","MARCO ANTONIO","RAMIREZ SOTO","0801-2009-87466","2009-06-10","","NEGOCIO PROPIO","DUEÑO","SIN OBSERVACIONES");
INSERT INTO tbl_mn_personas VALUES("33","2","1","1","2","1","","2","1","2","2","1","1","1","1","1","MARIA DE LOS ANEGELS","DE RAMIREZ","0648-2010-21755","2010-10-03","","PATRONO","VENDEDORA DE PLASTICOS","");
INSERT INTO tbl_mn_personas VALUES("34","3","1","2","1","1","","2","1","2","5","1","1","1","1","1","MAYNOR","GUTIERRES","0103-2023-30011","2023-11-09","","PATRANO","DUEÑO","NADA");
INSERT INTO tbl_mn_personas VALUES("35","3","1","2","2","4","","2","2","2","3","4","1","1","1","1","ELSA MARINA","CRUZ ","0611-1997-20311","1997-12-11","","PATRONO","ASEADORA DE CASAS","NADA");
INSERT INTO tbl_mn_personas VALUES("36","2","1","2","2","5","","2","2","2","2","4","1","1","1","1","SANTOS","CARAJAL","0611-1992-05412","1992-01-21","","NEGOCIO","SOLDADOR","");
INSERT INTO tbl_mn_personas VALUES("38","1","1","1","4","10","7","2","1","2","3","1","1","1","1","2","ADAN ANTONIO","TORRES MEZA","0611-1992-02227","1992-06-18","","NEGOCIO PROPIO","VENDEDOR DE FERRETERIA","SIN OBSERVACIONES");
INSERT INTO tbl_mn_personas VALUES("39","3","1","2","3","9","","2","3","5","2","1","1","1","1","4","MARIO ","BORJAS MARTINEZ","0801-2005-88888","2005-06-10","","NEGOCIO PROPIO","CHOFER DE BUSES","NADA");
INSERT INTO tbl_mn_personas VALUES("40","2","1","1","3","4","","2","3","5","5","1","1","1","1","4","REINA MARIBLE","GUARDIOLA","0801-2005-11399","2005-09-12","","PATRONO","ASEADORA","");
INSERT INTO tbl_mn_personas VALUES("41","3","1","1","1","2","","2","2","5","3","4","1","1","1","4","LOURDES ANTONIA","LAINEZ SANDOVAL","0711-1998-55222","1998-06-10","","NEGOCIO PROPIO","GERENTE","");
INSERT INTO tbl_mn_personas VALUES("42","1","1","2","1","2","5","2","1","2","1","1","1","1","1","1","LOURDES","SDSD","5555-2023-65555","2023-12-04","","SDSD","SDSD","");
INSERT INTO tbl_mn_personas VALUES("43","3","1","2","1","1","","1","1","1","2","1","1","1","1","1","SDSD","ASDSAD","2552-2023-51551","2023-12-30","","SDS","SDSD","");
INSERT INTO tbl_mn_personas VALUES("44","1","1","2","1","2","4","2","1","2","2","1","1","1","1","1","ADASD","SDASDASD","0801-2023-50000","2023-12-04","","SDW","QWDQDQW","");



DROP TABLE IF EXISTS tbl_mn_personas_bienes;

CREATE TABLE `tbl_mn_personas_bienes` (
  `idPersonaBienes` int(11) NOT NULL AUTO_INCREMENT,
  `Descripcion` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`idPersonaBienes`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_mn_personas_bienes VALUES("1","CASA");
INSERT INTO tbl_mn_personas_bienes VALUES("2","VEHICULO");
INSERT INTO tbl_mn_personas_bienes VALUES("3","TERRENO");
INSERT INTO tbl_mn_personas_bienes VALUES("4","CASA, VEHICULO, TERRENO");
INSERT INTO tbl_mn_personas_bienes VALUES("5","CASA, TERRENO");
INSERT INTO tbl_mn_personas_bienes VALUES("6","VEHICULO, CASA");
INSERT INTO tbl_mn_personas_bienes VALUES("7","TERRENO, VEHICULO");



DROP TABLE IF EXISTS tbl_mn_personas_contacto;

CREATE TABLE `tbl_mn_personas_contacto` (
  `idPersonaContacto` int(11) NOT NULL AUTO_INCREMENT,
  `idPersona` int(11) NOT NULL,
  `idTipoContacto` int(11) NOT NULL,
  `valor` varchar(120) DEFAULT NULL,
  PRIMARY KEY (`idPersonaContacto`),
  KEY `idPersona_fk` (`idPersona`),
  KEY `idTipo_contacto_fK` (`idTipoContacto`),
  CONSTRAINT `idPersona_fk` FOREIGN KEY (`idPersona`) REFERENCES `tbl_mn_personas` (`idPersona`),
  CONSTRAINT `idTipo_contacto_fK` FOREIGN KEY (`idTipoContacto`) REFERENCES `tbl_mn_tipo_contacto` (`idTipoContacto`)
) ENGINE=InnoDB AUTO_INCREMENT=106 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_mn_personas_contacto VALUES("1","19","1","9988-7444");
INSERT INTO tbl_mn_personas_contacto VALUES("2","19","2","DIRECCION DEL SOLICITANTE");
INSERT INTO tbl_mn_personas_contacto VALUES("3","19","3","2236-6565");
INSERT INTO tbl_mn_personas_contacto VALUES("4","19","4","DIRECCION DEL TRABAJO DEL SOLICITATE JOSE MARTINEZ");
INSERT INTO tbl_mn_personas_contacto VALUES("5","19","5","2266-5565");
INSERT INTO tbl_mn_personas_contacto VALUES("6","20","1","9887-5565");
INSERT INTO tbl_mn_personas_contacto VALUES("7","20","2","DIRECCION DE MARIA");
INSERT INTO tbl_mn_personas_contacto VALUES("8","20","3","2221-2212");
INSERT INTO tbl_mn_personas_contacto VALUES("9","20","4","DIRECION DE TRABAJO DE MARIA");
INSERT INTO tbl_mn_personas_contacto VALUES("10","20","5","2223-2323");
INSERT INTO tbl_mn_personas_contacto VALUES("11","21","1","9874-1111");
INSERT INTO tbl_mn_personas_contacto VALUES("12","21","2","DIRECCION DE ADAN");
INSERT INTO tbl_mn_personas_contacto VALUES("13","21","3","2233-5111");
INSERT INTO tbl_mn_personas_contacto VALUES("14","21","4","DIRECION DE TRABAJO DE ADAN");
INSERT INTO tbl_mn_personas_contacto VALUES("15","21","5","2251-3652");
INSERT INTO tbl_mn_personas_contacto VALUES("16","22","1","6565-6565");
INSERT INTO tbl_mn_personas_contacto VALUES("17","22","2","DIRECCION DE ANA");
INSERT INTO tbl_mn_personas_contacto VALUES("18","22","3","2251-1211");
INSERT INTO tbl_mn_personas_contacto VALUES("19","22","4","DIRECCION DEL TRABAJO DE ANA");
INSERT INTO tbl_mn_personas_contacto VALUES("20","22","5","2254-1233");
INSERT INTO tbl_mn_personas_contacto VALUES("21","25","1","9999-9988");
INSERT INTO tbl_mn_personas_contacto VALUES("22","25","2","DIRECCION DE MAYNOR");
INSERT INTO tbl_mn_personas_contacto VALUES("23","25","3","");
INSERT INTO tbl_mn_personas_contacto VALUES("24","25","4","DIRECCION DE TRABAJO DE LOURDES");
INSERT INTO tbl_mn_personas_contacto VALUES("25","25","5","2222-2888");
INSERT INTO tbl_mn_personas_contacto VALUES("26","26","1","8899-5999");
INSERT INTO tbl_mn_personas_contacto VALUES("27","26","2","DIRECCION DE MAYNOR PAREJA DE LOURDES");
INSERT INTO tbl_mn_personas_contacto VALUES("28","26","3","5555-5599");
INSERT INTO tbl_mn_personas_contacto VALUES("29","26","4","NO TRABAJA");
INSERT INTO tbl_mn_personas_contacto VALUES("30","26","5","5552-2289");
INSERT INTO tbl_mn_personas_contacto VALUES("31","27","1","9985-6565");
INSERT INTO tbl_mn_personas_contacto VALUES("32","27","2","DIRECCION DEL SOLICITANTE PEDRO");
INSERT INTO tbl_mn_personas_contacto VALUES("33","27","3","2255-5555");
INSERT INTO tbl_mn_personas_contacto VALUES("34","27","4","DIRECCION DEL TRABAJO DE PEDRO");
INSERT INTO tbl_mn_personas_contacto VALUES("35","27","5","2556-5656");
INSERT INTO tbl_mn_personas_contacto VALUES("36","28","1","9811-1111");
INSERT INTO tbl_mn_personas_contacto VALUES("37","28","2","DIRECION DE LA NANCY");
INSERT INTO tbl_mn_personas_contacto VALUES("38","28","3","2541-1111");
INSERT INTO tbl_mn_personas_contacto VALUES("39","28","4","DIRECCION DE TRABAJO DE NANCY");
INSERT INTO tbl_mn_personas_contacto VALUES("40","28","5","3222-3323");
INSERT INTO tbl_mn_personas_contacto VALUES("41","29","1","9293-3651");
INSERT INTO tbl_mn_personas_contacto VALUES("42","29","2","DIRECCION DE LESYLY");
INSERT INTO tbl_mn_personas_contacto VALUES("43","29","3","2255-1111");
INSERT INTO tbl_mn_personas_contacto VALUES("44","29","4","DIRECCION DEL TRABAJO DE LESLY");
INSERT INTO tbl_mn_personas_contacto VALUES("45","29","5","2222-2222");
INSERT INTO tbl_mn_personas_contacto VALUES("46","30","1","9885-5656");
INSERT INTO tbl_mn_personas_contacto VALUES("47","30","2","DIRECCION DE EDGAR");
INSERT INTO tbl_mn_personas_contacto VALUES("48","30","3","");
INSERT INTO tbl_mn_personas_contacto VALUES("49","30","4","DIRECCION DE TRABAJO DE EDGAR");
INSERT INTO tbl_mn_personas_contacto VALUES("50","30","5","2222-2278");
INSERT INTO tbl_mn_personas_contacto VALUES("51","32","1","9663-6085");
INSERT INTO tbl_mn_personas_contacto VALUES("52","32","2","DIRECCION DE MARCO ");
INSERT INTO tbl_mn_personas_contacto VALUES("53","32","3","2255-5444");
INSERT INTO tbl_mn_personas_contacto VALUES("54","32","4","DIRECCION DE TRABAJO DE EVA");
INSERT INTO tbl_mn_personas_contacto VALUES("55","32","5","1822-2222");
INSERT INTO tbl_mn_personas_contacto VALUES("56","33","1","9995-6262");
INSERT INTO tbl_mn_personas_contacto VALUES("57","33","2","DIRECCION DE MARIA ESPOSA DE MARCO ANOTNIO");
INSERT INTO tbl_mn_personas_contacto VALUES("58","33","3","2211-1111");
INSERT INTO tbl_mn_personas_contacto VALUES("59","33","4","DIRECCION DE MARIA DE LOS ANGELES");
INSERT INTO tbl_mn_personas_contacto VALUES("60","33","5","2235-2011");
INSERT INTO tbl_mn_personas_contacto VALUES("61","34","1","4444-4444");
INSERT INTO tbl_mn_personas_contacto VALUES("62","34","2","DIRECCION DE MAYNOR");
INSERT INTO tbl_mn_personas_contacto VALUES("63","34","3","2221-1111");
INSERT INTO tbl_mn_personas_contacto VALUES("64","34","4","DIRECCION DE MAYNOR TRABAJO");
INSERT INTO tbl_mn_personas_contacto VALUES("65","34","5","2555-5555");
INSERT INTO tbl_mn_personas_contacto VALUES("66","35","1","3215-4848");
INSERT INTO tbl_mn_personas_contacto VALUES("67","35","2","DIRECCION DE ELSA ");
INSERT INTO tbl_mn_personas_contacto VALUES("68","35","3","2217-8444");
INSERT INTO tbl_mn_personas_contacto VALUES("69","35","4","DIRECCION DE TRABAJO DE ELSA");
INSERT INTO tbl_mn_personas_contacto VALUES("70","35","5","2213-1444");
INSERT INTO tbl_mn_personas_contacto VALUES("71","36","1","8555-5222");
INSERT INTO tbl_mn_personas_contacto VALUES("72","36","2","DIRECCION DE SANTOS ESPOSO DE ELSA");
INSERT INTO tbl_mn_personas_contacto VALUES("73","36","3","");
INSERT INTO tbl_mn_personas_contacto VALUES("74","36","4","DIRECCION DE TRABAJO DE SANTOS");
INSERT INTO tbl_mn_personas_contacto VALUES("75","36","5","9985-5555");
INSERT INTO tbl_mn_personas_contacto VALUES("76","38","1","9999-9997");
INSERT INTO tbl_mn_personas_contacto VALUES("77","38","2","DIRECCION DE ADAN");
INSERT INTO tbl_mn_personas_contacto VALUES("78","38","3","2252-5541");
INSERT INTO tbl_mn_personas_contacto VALUES("79","38","4","DIRECCION DE TRABAJO DE ADAN");
INSERT INTO tbl_mn_personas_contacto VALUES("80","38","5","2366-5477");
INSERT INTO tbl_mn_personas_contacto VALUES("81","39","1","9955-6888");
INSERT INTO tbl_mn_personas_contacto VALUES("82","39","2","DIRECCION DE JOSE");
INSERT INTO tbl_mn_personas_contacto VALUES("83","39","3","2265-8888");
INSERT INTO tbl_mn_personas_contacto VALUES("84","39","4","DIRECCION DE TRABAJO DE MARIO");
INSERT INTO tbl_mn_personas_contacto VALUES("85","39","5","2222-2228");
INSERT INTO tbl_mn_personas_contacto VALUES("86","40","1","9955-2299");
INSERT INTO tbl_mn_personas_contacto VALUES("87","40","2","DIRECION DE LA PAREJA REINA");
INSERT INTO tbl_mn_personas_contacto VALUES("88","40","3","2565-9999");
INSERT INTO tbl_mn_personas_contacto VALUES("89","40","4","DIRECCION DE TRABAJO DE REINA");
INSERT INTO tbl_mn_personas_contacto VALUES("90","40","5","2222-9999");
INSERT INTO tbl_mn_personas_contacto VALUES("91","41","1","9895-3222");
INSERT INTO tbl_mn_personas_contacto VALUES("92","41","2","DIRECCION DE LOURDES");
INSERT INTO tbl_mn_personas_contacto VALUES("93","41","3","2223-2222");
INSERT INTO tbl_mn_personas_contacto VALUES("94","41","4","DIRECCION DE TRABAJO DE LOURDES");
INSERT INTO tbl_mn_personas_contacto VALUES("95","41","5","2225-5555");
INSERT INTO tbl_mn_personas_contacto VALUES("96","43","1","5555-5555");
INSERT INTO tbl_mn_personas_contacto VALUES("97","43","2","ASDASD");
INSERT INTO tbl_mn_personas_contacto VALUES("98","43","3","5555-5555");
INSERT INTO tbl_mn_personas_contacto VALUES("99","43","4","SDSD");
INSERT INTO tbl_mn_personas_contacto VALUES("100","43","5","");
INSERT INTO tbl_mn_personas_contacto VALUES("101","44","1","5555-5555");
INSERT INTO tbl_mn_personas_contacto VALUES("102","44","2","ASDASDA");
INSERT INTO tbl_mn_personas_contacto VALUES("103","44","3","8888-8888");
INSERT INTO tbl_mn_personas_contacto VALUES("104","44","4","SDADAD");
INSERT INTO tbl_mn_personas_contacto VALUES("105","44","5","");



DROP TABLE IF EXISTS tbl_mn_personas_cuenta;

CREATE TABLE `tbl_mn_personas_cuenta` (
  `idNumeroCuenta` int(11) NOT NULL AUTO_INCREMENT,
  `idPersona` int(11) NOT NULL,
  `idTipoCuenta` int(11) NOT NULL,
  `NumeroCuenta` varchar(20) DEFAULT NULL,
  `FechaCreacion` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`idNumeroCuenta`),
  KEY `id_persona_fk_cuenta` (`idPersona`),
  KEY `idTipoCuenta_fk` (`idTipoCuenta`),
  CONSTRAINT `idTipoCuenta_fk` FOREIGN KEY (`idTipoCuenta`) REFERENCES `tbl_mn_tipo_cuenta` (`idTipoCuenta`),
  CONSTRAINT `id_persona_fk_cuenta` FOREIGN KEY (`idPersona`) REFERENCES `tbl_mn_personas` (`idPersona`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_mn_personas_cuenta VALUES("1","19","1","123456789999999","2023-10-28 16:58:28");
INSERT INTO tbl_mn_personas_cuenta VALUES("2","20","1","","2023-10-28 16:58:28");
INSERT INTO tbl_mn_personas_cuenta VALUES("3","21","1","","2023-10-28 17:04:31");
INSERT INTO tbl_mn_personas_cuenta VALUES("4","22","1","","2023-10-28 17:04:31");
INSERT INTO tbl_mn_personas_cuenta VALUES("6","25","1","","2023-10-29 12:53:12");
INSERT INTO tbl_mn_personas_cuenta VALUES("7","26","1","","2023-10-29 12:53:12");
INSERT INTO tbl_mn_personas_cuenta VALUES("8","27","1","2020202355","2023-11-01 12:45:40");
INSERT INTO tbl_mn_personas_cuenta VALUES("9","28","1","","2023-11-01 12:45:40");
INSERT INTO tbl_mn_personas_cuenta VALUES("10","29","1","","2023-11-01 12:54:37");
INSERT INTO tbl_mn_personas_cuenta VALUES("11","30","1","","2023-11-01 12:54:37");
INSERT INTO tbl_mn_personas_cuenta VALUES("13","32","1","2020150255","2023-11-03 15:52:20");
INSERT INTO tbl_mn_personas_cuenta VALUES("14","33","1","","2023-11-03 15:52:20");
INSERT INTO tbl_mn_personas_cuenta VALUES("15","34","1","55522222","2023-11-03 17:21:29");
INSERT INTO tbl_mn_personas_cuenta VALUES("16","35","1","25000","2023-11-04 11:57:23");
INSERT INTO tbl_mn_personas_cuenta VALUES("17","36","1","","2023-11-04 11:57:23");
INSERT INTO tbl_mn_personas_cuenta VALUES("19","38","1","77455777","2023-11-07 13:47:03");
INSERT INTO tbl_mn_personas_cuenta VALUES("20","39","1","56565656888","2023-11-07 14:24:32");
INSERT INTO tbl_mn_personas_cuenta VALUES("21","40","1","","2023-11-07 14:24:32");
INSERT INTO tbl_mn_personas_cuenta VALUES("22","41","1","2352255","2023-11-07 21:59:03");
INSERT INTO tbl_mn_personas_cuenta VALUES("23","42","1","","2023-12-04 23:16:27");
INSERT INTO tbl_mn_personas_cuenta VALUES("24","43","1","","2023-12-04 23:25:23");
INSERT INTO tbl_mn_personas_cuenta VALUES("25","44","1","","2023-12-04 23:34:24");



DROP TABLE IF EXISTS tbl_mn_personas_dependientes;

CREATE TABLE `tbl_mn_personas_dependientes` (
  `idDependientes` int(11) NOT NULL AUTO_INCREMENT,
  `idPersona` int(11) NOT NULL,
  `idParentesco` int(11) NOT NULL,
  `nombre` varchar(120) DEFAULT NULL,
  PRIMARY KEY (`idDependientes`),
  KEY `idPersona_f_k` (`idPersona`),
  KEY `idparentesco_f_k` (`idParentesco`),
  CONSTRAINT `idPersona_f_k` FOREIGN KEY (`idPersona`) REFERENCES `tbl_mn_personas` (`idPersona`),
  CONSTRAINT `idparentesco_f_k` FOREIGN KEY (`idParentesco`) REFERENCES `tbl_mn_parentesco` (`idParentesco`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_mn_personas_dependientes VALUES("1","19","1","5 HIJOS");
INSERT INTO tbl_mn_personas_dependientes VALUES("2","27","1","HIJO, MARIO RAUDALES");
INSERT INTO tbl_mn_personas_dependientes VALUES("3","32","1","1 HIJO EDAD 9, JOSE CARLOS");
INSERT INTO tbl_mn_personas_dependientes VALUES("4","38","1","JUAN HIJO DE 9 AÑOS");
INSERT INTO tbl_mn_personas_dependientes VALUES("5","44","1","SDFSDFDF");



DROP TABLE IF EXISTS tbl_mn_plan_pagos_cuota_nivelada;

CREATE TABLE `tbl_mn_plan_pagos_cuota_nivelada` (
  `idPlanCuota` int(11) NOT NULL AUTO_INCREMENT,
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
  PRIMARY KEY (`idPlanCuota`),
  KEY `idPersona_forgn_keys` (`idPersona`),
  KEY `id_solicitud_fKysss` (`idSolicitud`),
  KEY `id_EstadoPlanPagos` (`idEstadoPlanPagos`),
  CONSTRAINT `idPersona_forgn_keys` FOREIGN KEY (`idPersona`) REFERENCES `tbl_mn_personas` (`idPersona`),
  CONSTRAINT `id_EstadoPlanPagos` FOREIGN KEY (`idEstadoPlanPagos`) REFERENCES `tbl_mn_estadoplanpagos` (`idEstadoPlanPagos`),
  CONSTRAINT `id_solicitud_fKysss` FOREIGN KEY (`idSolicitud`) REFERENCES `tbl_mn_solicitudes_creditos` (`idSolicitud`)
) ENGINE=InnoDB AUTO_INCREMENT=125 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_mn_plan_pagos_cuota_nivelada VALUES("1","","1","2","60000.00","18","12.00","18","1","2023-11-30","3658.92","591.78","3067.14","52524.64","","","","","","");
INSERT INTO tbl_mn_plan_pagos_cuota_nivelada VALUES("2","","1","2","60000.00","18","12.00","18","2","2023-12-31","3658.92","561.53","3097.39","43086.17","","","","","","");
INSERT INTO tbl_mn_plan_pagos_cuota_nivelada VALUES("3","","1","2","60000.00","18","12.00","18","3","2024-01-30","3658.92","548.68","3110.24","39134.85","","","","","","");
INSERT INTO tbl_mn_plan_pagos_cuota_nivelada VALUES("4","","1","2","60000.00","18","12.00","18","4","2024-02-29","3658.92","500.30","3158.62","35976.23","","","","","","");
INSERT INTO tbl_mn_plan_pagos_cuota_nivelada VALUES("5","","1","2","60000.00","18","12.00","18","5","2023-10-29","3658.92","453.51","3205.41","32770.82","30","","","","665.42","665.42");
INSERT INTO tbl_mn_plan_pagos_cuota_nivelada VALUES("6","","1","2","60000.00","18","12.00","18","6","2024-04-29","3658.92","452.12","3206.80","28722.94","","","","","","");
INSERT INTO tbl_mn_plan_pagos_cuota_nivelada VALUES("7","","1","2","60000.00","18","12.00","18","7","2024-05-29","3658.92","405.91","3253.01","25469.93","","","","","","");
INSERT INTO tbl_mn_plan_pagos_cuota_nivelada VALUES("8","","1","2","60000.00","18","12.00","18","8","2024-06-29","3658.92","386.28","3272.64","16856.21","","","","","","");
INSERT INTO tbl_mn_plan_pagos_cuota_nivelada VALUES("9","","1","2","60000.00","18","12.00","18","9","2024-07-29","3658.92","341.54","3317.38","13538.83","","","","","","");
INSERT INTO tbl_mn_plan_pagos_cuota_nivelada VALUES("10","","1","2","60000.00","18","12.00","18","10","2024-08-29","3658.92","319.12","3339.80","9357.95","","","","","","");
INSERT INTO tbl_mn_plan_pagos_cuota_nivelada VALUES("11","","1","2","60000.00","18","12.00","18","11","2024-09-29","3658.92","285.08","3373.84","5984.11","","","","","","");
INSERT INTO tbl_mn_plan_pagos_cuota_nivelada VALUES("12","","1","2","60000.00","18","12.00","18","12","2024-10-29","3658.92","242.61","3416.31","2567.80","","","","","","");
INSERT INTO tbl_mn_plan_pagos_cuota_nivelada VALUES("13","","1","4","60000.00","18","12.00","18","13","2024-11-29","2783.68","215.88","2567.80","0.00","","","","","","");
INSERT INTO tbl_mn_plan_pagos_cuota_nivelada VALUES("14","","1","4","60000.00","18","12.00","18","14","2024-12-29","3658.92","174.95","3483.97","0.00","","","","","","");
INSERT INTO tbl_mn_plan_pagos_cuota_nivelada VALUES("15","","1","4","60000.00","18","12.00","18","15","2025-01-29","1968.23","145.28","1822.95","0.00","","","","","","");
INSERT INTO tbl_mn_plan_pagos_cuota_nivelada VALUES("16","","1","4","60000.00","18","12.00","18","16","2025-02-28","3658.92","105.94","3552.98","0.00","","","","","","");
INSERT INTO tbl_mn_plan_pagos_cuota_nivelada VALUES("17","","1","4","60000.00","18","12.00","18","17","2025-03-28","2845.74","66.17","2779.57","0.00","","","","","","");
INSERT INTO tbl_mn_plan_pagos_cuota_nivelada VALUES("18","","1","4","60000.00","18","12.00","18","18","2025-04-28","3658.92","36.64","3595.04","0.00","","","","","","");
INSERT INTO tbl_mn_plan_pagos_cuota_nivelada VALUES("19","","2","3","25000.00","24","12.00","24","1","2021-07-18","1176.84","246.58","930.26","24069.74","922","","","","","");
INSERT INTO tbl_mn_plan_pagos_cuota_nivelada VALUES("20","","2","3","25000.00","24","12.00","24","2","2021-08-18","1176.84","245.31","931.53","23138.21","891","","","","","");
INSERT INTO tbl_mn_plan_pagos_cuota_nivelada VALUES("21","","2","3","25000.00","24","12.00","24","3","2021-09-18","1176.84","235.82","941.02","22197.19","860","","","","","");
INSERT INTO tbl_mn_plan_pagos_cuota_nivelada VALUES("22","","2","3","25000.00","24","12.00","24","4","2021-10-18","1176.84","218.93","957.91","21239.28","830","","","","","");
INSERT INTO tbl_mn_plan_pagos_cuota_nivelada VALUES("23","","2","3","25000.00","24","12.00","24","5","2021-11-18","1176.84","216.47","960.37","20278.91","799","","","","","");
INSERT INTO tbl_mn_plan_pagos_cuota_nivelada VALUES("24","","2","3","25000.00","24","12.00","24","6","2021-12-18","1176.84","200.01","976.83","19302.08","769","","","","","");
INSERT INTO tbl_mn_plan_pagos_cuota_nivelada VALUES("25","","2","3","25000.00","24","12.00","24","7","2022-01-18","1176.84","196.72","980.12","18321.96","738","","","","","");
INSERT INTO tbl_mn_plan_pagos_cuota_nivelada VALUES("26","","2","3","25000.00","24","12.00","24","8","2022-02-18","1176.84","186.73","990.11","17331.85","707","","","","","");
INSERT INTO tbl_mn_plan_pagos_cuota_nivelada VALUES("27","","2","3","25000.00","24","12.00","24","9","2022-03-18","1176.84","159.55","1017.29","16314.56","679","","","","","");
INSERT INTO tbl_mn_plan_pagos_cuota_nivelada VALUES("28","","2","3","25000.00","24","12.00","24","10","2022-04-18","1176.84","166.27","1010.57","15303.99","648","","","","","");
INSERT INTO tbl_mn_plan_pagos_cuota_nivelada VALUES("29","","2","3","25000.00","24","12.00","24","11","2022-05-18","1176.84","150.94","1025.90","14278.09","618","","","","","");
INSERT INTO tbl_mn_plan_pagos_cuota_nivelada VALUES("30","","2","3","25000.00","24","12.00","24","12","2022-06-18","1176.84","145.52","1031.32","13246.77","587","","","","","");
INSERT INTO tbl_mn_plan_pagos_cuota_nivelada VALUES("31","","2","3","25000.00","24","12.00","24","13","2022-07-18","1176.84","130.65","1046.19","12200.58","557","","","","","");
INSERT INTO tbl_mn_plan_pagos_cuota_nivelada VALUES("32","","2","3","25000.00","24","12.00","24","14","2022-08-18","1176.84","124.35","1052.49","11148.09","526","","","","","");
INSERT INTO tbl_mn_plan_pagos_cuota_nivelada VALUES("33","","2","3","25000.00","24","12.00","24","15","2022-09-18","1176.84","113.62","1063.22","10084.87","495","","","","","");
INSERT INTO tbl_mn_plan_pagos_cuota_nivelada VALUES("34","","2","3","25000.00","24","12.00","24","16","2022-10-18","1176.84","99.47","1077.37","9007.50","465","","","","","");
INSERT INTO tbl_mn_plan_pagos_cuota_nivelada VALUES("35","","2","3","25000.00","24","12.00","24","17","2022-11-18","1176.84","91.80","1085.04","7922.46","434","","","","","");
INSERT INTO tbl_mn_plan_pagos_cuota_nivelada VALUES("36","","2","3","25000.00","24","12.00","24","18","2022-12-18","1176.84","78.14","1098.70","6823.76","404","","","","","");
INSERT INTO tbl_mn_plan_pagos_cuota_nivelada VALUES("37","","2","3","25000.00","24","12.00","24","19","2023-01-18","1176.84","69.55","1107.29","5716.47","373","","","","","");
INSERT INTO tbl_mn_plan_pagos_cuota_nivelada VALUES("38","","2","3","25000.00","24","12.00","24","20","2023-02-18","1176.84","58.26","1118.58","4597.89","342","","","","","");
INSERT INTO tbl_mn_plan_pagos_cuota_nivelada VALUES("39","","2","3","25000.00","24","12.00","24","21","2023-03-18","1176.84","42.33","1134.51","3463.38","314","","","","","");
INSERT INTO tbl_mn_plan_pagos_cuota_nivelada VALUES("40","","2","3","25000.00","24","12.00","24","22","2023-04-18","1176.84","35.30","1141.54","2321.84","283","","","","","");
INSERT INTO tbl_mn_plan_pagos_cuota_nivelada VALUES("41","","2","3","25000.00","24","12.00","24","23","2023-05-18","1176.84","22.90","1153.94","1167.90","253","","","","","");
INSERT INTO tbl_mn_plan_pagos_cuota_nivelada VALUES("42","","2","3","25000.00","24","12.00","24","24","2023-06-18","1176.84","11.90","1167.90","0.00","222","","","","","");
INSERT INTO tbl_mn_plan_pagos_cuota_nivelada VALUES("43","","4","2","8500.00","10","12.00","10","1","2023-12-09","897.45","83.84","813.61","6872.78","","","","","","");
INSERT INTO tbl_mn_plan_pagos_cuota_nivelada VALUES("44","","4","2","8500.00","10","12.00","10","2","2024-01-09","897.45","78.34","819.11","3451.12","","","","","","");
INSERT INTO tbl_mn_plan_pagos_cuota_nivelada VALUES("45","","4","2","8500.00","10","12.00","10","3","2024-02-09","897.45","69.99","827.46","2623.66","","","","","","");
INSERT INTO tbl_mn_plan_pagos_cuota_nivelada VALUES("46","","4","1","8500.00","10","12.00","10","4","2024-03-09","897.45","57.59","839.86","1783.80","","","","","","");
INSERT INTO tbl_mn_plan_pagos_cuota_nivelada VALUES("47","","4","1","8500.00","10","12.00","10","5","2024-04-09","897.45","53.00","844.45","939.35","","","","","","");
INSERT INTO tbl_mn_plan_pagos_cuota_nivelada VALUES("48","","4","1","8500.00","10","12.00","10","6","2024-05-09","897.45","42.96","854.49","84.86","","","","","","");
INSERT INTO tbl_mn_plan_pagos_cuota_nivelada VALUES("49","","4","1","8500.00","10","12.00","10","7","2024-06-09","120.54","35.68","84.86","0.00","","","","","","");
INSERT INTO tbl_mn_plan_pagos_cuota_nivelada VALUES("50","","4","4","8500.00","10","12.00","10","8","2024-07-09","897.45","26.03","871.42","0.00","","","","","","");
INSERT INTO tbl_mn_plan_pagos_cuota_nivelada VALUES("51","","4","4","8500.00","10","12.00","10","9","2024-08-09","897.45","18.02","879.43","0.00","","","","","","");
INSERT INTO tbl_mn_plan_pagos_cuota_nivelada VALUES("52","","4","4","8500.00","10","12.00","10","10","2024-09-09","83.84","9.05","74.79","0.00","","","","","","");
INSERT INTO tbl_mn_plan_pagos_cuota_nivelada VALUES("53","","1","3","60000.00","18","12.00","18","1","2023-11-30","3658.92","591.78","3067.14","56932.86","57","","","","","");
INSERT INTO tbl_mn_plan_pagos_cuota_nivelada VALUES("54","","1","3","60000.00","18","12.00","18","2","2023-12-30","3658.92","561.53","3097.39","53835.47","27","","","","","");
INSERT INTO tbl_mn_plan_pagos_cuota_nivelada VALUES("55","","1","1","60000.00","18","12.00","18","3","2024-01-30","3658.92","548.68","3110.24","50725.23","","","","","","");
INSERT INTO tbl_mn_plan_pagos_cuota_nivelada VALUES("56","","1","1","60000.00","18","12.00","18","4","2024-02-29","3658.92","500.30","3158.62","47566.61","","","","","","");
INSERT INTO tbl_mn_plan_pagos_cuota_nivelada VALUES("57","","1","1","60000.00","18","12.00","18","5","2024-03-29","3658.92","453.51","3205.41","44361.20","","","","","","");
INSERT INTO tbl_mn_plan_pagos_cuota_nivelada VALUES("58","","1","1","60000.00","18","12.00","18","6","2024-04-29","3658.92","452.12","3206.80","41154.40","","","","","","");
INSERT INTO tbl_mn_plan_pagos_cuota_nivelada VALUES("59","","1","1","60000.00","18","12.00","18","7","2024-05-29","3658.92","405.91","3253.01","37901.39","","","","","","");
INSERT INTO tbl_mn_plan_pagos_cuota_nivelada VALUES("60","","1","1","60000.00","18","12.00","18","8","2024-06-29","3658.92","386.28","3272.64","34628.75","","","","","","");
INSERT INTO tbl_mn_plan_pagos_cuota_nivelada VALUES("61","","1","1","60000.00","18","12.00","18","9","2024-07-29","3658.92","341.54","3317.38","31311.37","","","","","","");
INSERT INTO tbl_mn_plan_pagos_cuota_nivelada VALUES("62","","1","1","60000.00","18","12.00","18","10","2024-08-29","3658.92","319.12","3339.80","27971.57","","","","","","");
INSERT INTO tbl_mn_plan_pagos_cuota_nivelada VALUES("63","","1","1","60000.00","18","12.00","18","11","2024-09-29","3658.92","285.08","3373.84","24597.73","","","","","","");
INSERT INTO tbl_mn_plan_pagos_cuota_nivelada VALUES("64","","1","1","60000.00","18","12.00","18","12","2024-10-29","3658.92","242.61","3416.31","21181.42","","","","","","");
INSERT INTO tbl_mn_plan_pagos_cuota_nivelada VALUES("65","","1","1","60000.00","18","12.00","18","13","2024-11-29","3658.92","215.88","3443.04","17738.38","","","","","","");
INSERT INTO tbl_mn_plan_pagos_cuota_nivelada VALUES("66","","1","1","60000.00","18","12.00","18","14","2024-12-29","3658.92","174.95","3483.97","14254.41","","","","","","");
INSERT INTO tbl_mn_plan_pagos_cuota_nivelada VALUES("67","","1","1","60000.00","18","12.00","18","15","2025-01-29","3658.92","145.28","3513.64","10740.77","","","","","","");
INSERT INTO tbl_mn_plan_pagos_cuota_nivelada VALUES("68","","1","1","60000.00","18","12.00","18","16","2025-02-28","3658.92","105.94","3552.98","7187.79","","","","","","");
INSERT INTO tbl_mn_plan_pagos_cuota_nivelada VALUES("69","","1","1","60000.00","18","12.00","18","17","2025-03-28","3658.92","66.17","3592.75","3595.04","","","","","","");
INSERT INTO tbl_mn_plan_pagos_cuota_nivelada VALUES("70","","1","1","60000.00","18","12.00","18","18","2025-04-28","3658.92","36.64","3595.04","0.00","","","","","","");
INSERT INTO tbl_mn_plan_pagos_cuota_nivelada VALUES("71","","1","3","60000.00","18","12.00","18","1","2023-11-30","3658.92","591.78","3067.14","56932.86","57","","","","","");
INSERT INTO tbl_mn_plan_pagos_cuota_nivelada VALUES("72","","1","3","60000.00","18","12.00","18","2","2023-12-30","3658.92","561.53","3097.39","53835.47","27","","","","","");
INSERT INTO tbl_mn_plan_pagos_cuota_nivelada VALUES("73","","1","1","60000.00","18","12.00","18","3","2024-01-30","3658.92","548.68","3110.24","50725.23","","","","","","");
INSERT INTO tbl_mn_plan_pagos_cuota_nivelada VALUES("74","","1","1","60000.00","18","12.00","18","4","2024-02-29","3658.92","500.30","3158.62","47566.61","","","","","","");
INSERT INTO tbl_mn_plan_pagos_cuota_nivelada VALUES("75","","1","1","60000.00","18","12.00","18","5","2024-03-29","3658.92","453.51","3205.41","44361.20","","","","","","");
INSERT INTO tbl_mn_plan_pagos_cuota_nivelada VALUES("76","","1","1","60000.00","18","12.00","18","6","2024-04-29","3658.92","452.12","3206.80","41154.40","","","","","","");
INSERT INTO tbl_mn_plan_pagos_cuota_nivelada VALUES("77","","1","1","60000.00","18","12.00","18","7","2024-05-29","3658.92","405.91","3253.01","37901.39","","","","","","");
INSERT INTO tbl_mn_plan_pagos_cuota_nivelada VALUES("78","","1","1","60000.00","18","12.00","18","8","2024-06-29","3658.92","386.28","3272.64","34628.75","","","","","","");
INSERT INTO tbl_mn_plan_pagos_cuota_nivelada VALUES("79","","1","1","60000.00","18","12.00","18","9","2024-07-29","3658.92","341.54","3317.38","31311.37","","","","","","");
INSERT INTO tbl_mn_plan_pagos_cuota_nivelada VALUES("80","","1","1","60000.00","18","12.00","18","10","2024-08-29","3658.92","319.12","3339.80","27971.57","","","","","","");
INSERT INTO tbl_mn_plan_pagos_cuota_nivelada VALUES("81","","1","1","60000.00","18","12.00","18","11","2024-09-29","3658.92","285.08","3373.84","24597.73","","","","","","");
INSERT INTO tbl_mn_plan_pagos_cuota_nivelada VALUES("82","","1","1","60000.00","18","12.00","18","12","2024-10-29","3658.92","242.61","3416.31","21181.42","","","","","","");
INSERT INTO tbl_mn_plan_pagos_cuota_nivelada VALUES("83","","1","1","60000.00","18","12.00","18","13","2024-11-29","3658.92","215.88","3443.04","17738.38","","","","","","");
INSERT INTO tbl_mn_plan_pagos_cuota_nivelada VALUES("84","","1","1","60000.00","18","12.00","18","14","2024-12-29","3658.92","174.95","3483.97","14254.41","","","","","","");
INSERT INTO tbl_mn_plan_pagos_cuota_nivelada VALUES("85","","1","1","60000.00","18","12.00","18","15","2025-01-29","3658.92","145.28","3513.64","10740.77","","","","","","");
INSERT INTO tbl_mn_plan_pagos_cuota_nivelada VALUES("86","","1","1","60000.00","18","12.00","18","16","2025-02-28","3658.92","105.94","3552.98","7187.79","","","","","","");
INSERT INTO tbl_mn_plan_pagos_cuota_nivelada VALUES("87","","1","1","60000.00","18","12.00","18","17","2025-03-28","3658.92","66.17","3592.75","3595.04","","","","","","");
INSERT INTO tbl_mn_plan_pagos_cuota_nivelada VALUES("88","","1","1","60000.00","18","12.00","18","18","2025-04-28","3658.92","36.64","3595.04","0.00","","","","","","");
INSERT INTO tbl_mn_plan_pagos_cuota_nivelada VALUES("89","","1","3","60000.00","18","12.00","18","1","2023-11-30","3658.92","591.78","3067.14","56932.86","57","","","","","");
INSERT INTO tbl_mn_plan_pagos_cuota_nivelada VALUES("90","","1","3","60000.00","18","12.00","18","2","2023-12-30","3658.92","561.53","3097.39","53835.47","27","","","","","");
INSERT INTO tbl_mn_plan_pagos_cuota_nivelada VALUES("91","","1","1","60000.00","18","12.00","18","3","2024-01-30","3658.92","548.68","3110.24","50725.23","","","","","","");
INSERT INTO tbl_mn_plan_pagos_cuota_nivelada VALUES("92","","1","1","60000.00","18","12.00","18","4","2024-02-29","3658.92","500.30","3158.62","47566.61","","","","","","");
INSERT INTO tbl_mn_plan_pagos_cuota_nivelada VALUES("93","","1","1","60000.00","18","12.00","18","5","2024-03-29","3658.92","453.51","3205.41","44361.20","","","","","","");
INSERT INTO tbl_mn_plan_pagos_cuota_nivelada VALUES("94","","1","1","60000.00","18","12.00","18","6","2024-04-29","3658.92","452.12","3206.80","41154.40","","","","","","");
INSERT INTO tbl_mn_plan_pagos_cuota_nivelada VALUES("95","","1","1","60000.00","18","12.00","18","7","2024-05-29","3658.92","405.91","3253.01","37901.39","","","","","","");
INSERT INTO tbl_mn_plan_pagos_cuota_nivelada VALUES("96","","1","1","60000.00","18","12.00","18","8","2024-06-29","3658.92","386.28","3272.64","34628.75","","","","","","");
INSERT INTO tbl_mn_plan_pagos_cuota_nivelada VALUES("97","","1","1","60000.00","18","12.00","18","9","2024-07-29","3658.92","341.54","3317.38","31311.37","","","","","","");
INSERT INTO tbl_mn_plan_pagos_cuota_nivelada VALUES("98","","1","1","60000.00","18","12.00","18","10","2024-08-29","3658.92","319.12","3339.80","27971.57","","","","","","");
INSERT INTO tbl_mn_plan_pagos_cuota_nivelada VALUES("99","","1","1","60000.00","18","12.00","18","11","2024-09-29","3658.92","285.08","3373.84","24597.73","","","","","","");
INSERT INTO tbl_mn_plan_pagos_cuota_nivelada VALUES("100","","1","1","60000.00","18","12.00","18","12","2024-10-29","3658.92","242.61","3416.31","21181.42","","","","","","");
INSERT INTO tbl_mn_plan_pagos_cuota_nivelada VALUES("101","","1","1","60000.00","18","12.00","18","13","2024-11-29","3658.92","215.88","3443.04","17738.38","","","","","","");
INSERT INTO tbl_mn_plan_pagos_cuota_nivelada VALUES("102","","1","1","60000.00","18","12.00","18","14","2024-12-29","3658.92","174.95","3483.97","14254.41","","","","","","");
INSERT INTO tbl_mn_plan_pagos_cuota_nivelada VALUES("103","","1","1","60000.00","18","12.00","18","15","2025-01-29","3658.92","145.28","3513.64","10740.77","","","","","","");
INSERT INTO tbl_mn_plan_pagos_cuota_nivelada VALUES("104","","1","1","60000.00","18","12.00","18","16","2025-02-28","3658.92","105.94","3552.98","7187.79","","","","","","");
INSERT INTO tbl_mn_plan_pagos_cuota_nivelada VALUES("105","","1","1","60000.00","18","12.00","18","17","2025-03-28","3658.92","66.17","3592.75","3595.04","","","","","","");
INSERT INTO tbl_mn_plan_pagos_cuota_nivelada VALUES("106","","1","1","60000.00","18","12.00","18","18","2025-04-28","3658.92","36.64","3595.04","0.00","","","","","","");
INSERT INTO tbl_mn_plan_pagos_cuota_nivelada VALUES("107","","1","3","60000.00","18","12.00","18","1","2023-11-30","3658.92","591.78","3067.14","56932.86","57","","","","","");
INSERT INTO tbl_mn_plan_pagos_cuota_nivelada VALUES("108","","1","3","60000.00","18","12.00","18","2","2023-12-30","3658.92","561.53","3097.39","53835.47","27","","","","","");
INSERT INTO tbl_mn_plan_pagos_cuota_nivelada VALUES("109","","1","1","60000.00","18","12.00","18","3","2024-01-30","3658.92","548.68","3110.24","50725.23","","","","","","");
INSERT INTO tbl_mn_plan_pagos_cuota_nivelada VALUES("110","","1","1","60000.00","18","12.00","18","4","2024-02-29","3658.92","500.30","3158.62","47566.61","","","","","","");
INSERT INTO tbl_mn_plan_pagos_cuota_nivelada VALUES("111","","1","1","60000.00","18","12.00","18","5","2024-03-29","3658.92","453.51","3205.41","44361.20","","","","","","");
INSERT INTO tbl_mn_plan_pagos_cuota_nivelada VALUES("112","","1","1","60000.00","18","12.00","18","6","2024-04-29","3658.92","452.12","3206.80","41154.40","","","","","","");
INSERT INTO tbl_mn_plan_pagos_cuota_nivelada VALUES("113","","1","1","60000.00","18","12.00","18","7","2024-05-29","3658.92","405.91","3253.01","37901.39","","","","","","");
INSERT INTO tbl_mn_plan_pagos_cuota_nivelada VALUES("114","","1","1","60000.00","18","12.00","18","8","2024-06-29","3658.92","386.28","3272.64","34628.75","","","","","","");
INSERT INTO tbl_mn_plan_pagos_cuota_nivelada VALUES("115","","1","1","60000.00","18","12.00","18","9","2024-07-29","3658.92","341.54","3317.38","31311.37","","","","","","");
INSERT INTO tbl_mn_plan_pagos_cuota_nivelada VALUES("116","","1","1","60000.00","18","12.00","18","10","2024-08-29","3658.92","319.12","3339.80","27971.57","","","","","","");
INSERT INTO tbl_mn_plan_pagos_cuota_nivelada VALUES("117","","1","1","60000.00","18","12.00","18","11","2024-09-29","3658.92","285.08","3373.84","24597.73","","","","","","");
INSERT INTO tbl_mn_plan_pagos_cuota_nivelada VALUES("118","","1","1","60000.00","18","12.00","18","12","2024-10-29","3658.92","242.61","3416.31","21181.42","","","","","","");
INSERT INTO tbl_mn_plan_pagos_cuota_nivelada VALUES("119","","1","1","60000.00","18","12.00","18","13","2024-11-29","3658.92","215.88","3443.04","17738.38","","","","","","");
INSERT INTO tbl_mn_plan_pagos_cuota_nivelada VALUES("120","","1","1","60000.00","18","12.00","18","14","2024-12-29","3658.92","174.95","3483.97","14254.41","","","","","","");
INSERT INTO tbl_mn_plan_pagos_cuota_nivelada VALUES("121","","1","1","60000.00","18","12.00","18","15","2025-01-29","3658.92","145.28","3513.64","10740.77","","","","","","");
INSERT INTO tbl_mn_plan_pagos_cuota_nivelada VALUES("122","","1","1","60000.00","18","12.00","18","16","2025-02-28","3658.92","105.94","3552.98","7187.79","","","","","","");
INSERT INTO tbl_mn_plan_pagos_cuota_nivelada VALUES("123","","1","1","60000.00","18","12.00","18","17","2025-03-28","3658.92","66.17","3592.75","3595.04","","","","","","");
INSERT INTO tbl_mn_plan_pagos_cuota_nivelada VALUES("124","","1","1","60000.00","18","12.00","18","18","2025-04-28","3658.92","36.64","3595.04","0.00","","","","","","");



DROP TABLE IF EXISTS tbl_mn_plazo_proveedores;

CREATE TABLE `tbl_mn_plazo_proveedores` (
  `idPlazoProveedor` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(45) NOT NULL,
  PRIMARY KEY (`idPlazoProveedor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;




DROP TABLE IF EXISTS tbl_mn_profesiones_oficios;

CREATE TABLE `tbl_mn_profesiones_oficios` (
  `idProfesion` int(11) NOT NULL AUTO_INCREMENT,
  `Descripcion` varchar(30) NOT NULL,
  PRIMARY KEY (`idProfesion`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_mn_profesiones_oficios VALUES("1","COMERCIANTE INDIVIDUAL");
INSERT INTO tbl_mn_profesiones_oficios VALUES("2","CARPINTERO");
INSERT INTO tbl_mn_profesiones_oficios VALUES("3","AGRICULTOR");
INSERT INTO tbl_mn_profesiones_oficios VALUES("4","ASEADOR");
INSERT INTO tbl_mn_profesiones_oficios VALUES("5","SOLDADOR");
INSERT INTO tbl_mn_profesiones_oficios VALUES("6","ELECTRICISTA");
INSERT INTO tbl_mn_profesiones_oficios VALUES("7","INFORMATICA");
INSERT INTO tbl_mn_profesiones_oficios VALUES("8","APICULTOR");
INSERT INTO tbl_mn_profesiones_oficios VALUES("9","CHOFER");
INSERT INTO tbl_mn_profesiones_oficios VALUES("10","VENDEDOR");
INSERT INTO tbl_mn_profesiones_oficios VALUES("11","AMA DE CASA");



DROP TABLE IF EXISTS tbl_mn_proveedor;

CREATE TABLE `tbl_mn_proveedor` (
  `idProveedor` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(50) NOT NULL,
  PRIMARY KEY (`idProveedor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;




DROP TABLE IF EXISTS tbl_mn_referencias_comerciales;

CREATE TABLE `tbl_mn_referencias_comerciales` (
  `idReferenciaComercial` int(11) NOT NULL AUTO_INCREMENT,
  `idPersona` int(11) NOT NULL,
  `nombre` varchar(120) DEFAULT NULL,
  `direccion` varchar(120) DEFAULT NULL,
  PRIMARY KEY (`idReferenciaComercial`),
  KEY `idPersona_fk_refeComercial` (`idPersona`),
  CONSTRAINT `idPersona_fk_refeComercial` FOREIGN KEY (`idPersona`) REFERENCES `tbl_mn_personas` (`idPersona`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_mn_referencias_comerciales VALUES("1","21","COMERCIAL LETI","DIRECIOON REFERENCIA 1 COMERCIAL");
INSERT INTO tbl_mn_referencias_comerciales VALUES("2","21","REFERENCIA COMERCIAL 2","DIRECCION DE REFERENCIA COMERCIAL 2");
INSERT INTO tbl_mn_referencias_comerciales VALUES("3","25","PULPERIA CHAYO","DIRECCION DE CHAYO");
INSERT INTO tbl_mn_referencias_comerciales VALUES("4","25","PULPERIA XIOMARA","DIRECCION XIOMARA");
INSERT INTO tbl_mn_referencias_comerciales VALUES("5","29","VARIEDADES ","DIRECION REFERENCIA 1");
INSERT INTO tbl_mn_referencias_comerciales VALUES("6","29","COMERCIAL LOS HERMANOS","DIRECCION DE COMERCIAL");
INSERT INTO tbl_mn_referencias_comerciales VALUES("7","34","COMERCIAL 1","DIRECIOON REFERENCIA COMERCIAL 1");
INSERT INTO tbl_mn_referencias_comerciales VALUES("8","34","COMERCIAL 2","DIRECCION DE REFERENCIA COMERCIAL 2");
INSERT INTO tbl_mn_referencias_comerciales VALUES("9","35","VIVEROS","DIRECCION DEL VIVERO");
INSERT INTO tbl_mn_referencias_comerciales VALUES("10","35","VIVEROS 2","DIRECCION DEL VIVERO 2");
INSERT INTO tbl_mn_referencias_comerciales VALUES("11","39","COMERCIAL 22","DIRECIOON REFERENCIA COMERCIAL 1");
INSERT INTO tbl_mn_referencias_comerciales VALUES("12","39","COMERCIAL 33","DIRECCION DE REFERENCIA COMERCIAL 2");
INSERT INTO tbl_mn_referencias_comerciales VALUES("13","41","COMERCIAL 1","DIRECIOON REFERENCIA COMERCIAL1");
INSERT INTO tbl_mn_referencias_comerciales VALUES("14","41","COMERCIAL 2","DIRECIOON REFERENCIA COMERCIAL 2");
INSERT INTO tbl_mn_referencias_comerciales VALUES("15","43","SDSDFF","SDFSDF");
INSERT INTO tbl_mn_referencias_comerciales VALUES("16","43","SDFDSF","DSFSDFSDF");



DROP TABLE IF EXISTS tbl_mn_referencias_familiares;

CREATE TABLE `tbl_mn_referencias_familiares` (
  `idReferencia` int(11) NOT NULL AUTO_INCREMENT,
  `idPersona` int(11) NOT NULL,
  `idParentesco` int(11) NOT NULL,
  `nombre` varchar(120) DEFAULT NULL,
  `celular` varchar(9) DEFAULT NULL,
  `direccion` varchar(120) DEFAULT NULL,
  PRIMARY KEY (`idReferencia`),
  KEY `idPersona_fk_refe` (`idPersona`),
  KEY `idparentesco_fk_paren` (`idParentesco`),
  CONSTRAINT `idPersona_fk_refe` FOREIGN KEY (`idPersona`) REFERENCES `tbl_mn_personas` (`idPersona`),
  CONSTRAINT `idparentesco_fk_paren` FOREIGN KEY (`idParentesco`) REFERENCES `tbl_mn_parentesco` (`idParentesco`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_mn_referencias_familiares VALUES("1","19","1","JOSE CARLO","9955-5222","DIRECCION DE REFERENCIA 1 DE JOSE");
INSERT INTO tbl_mn_referencias_familiares VALUES("2","19","3","LOURDES","8855-2222","DIRECCION DE REFERENCIA 2 DE JOSE");
INSERT INTO tbl_mn_referencias_familiares VALUES("3","21","1","ALEJANDRO","9999-9999","DIRECCION DE ALEJANDR REFERENCIA 1 AVAL 1");
INSERT INTO tbl_mn_referencias_familiares VALUES("4","21","2","LIZETH","9988-8888","DIRRECCION DE LIZETH REFERENCIA 2 DE AVAL 1");
INSERT INTO tbl_mn_referencias_familiares VALUES("5","25","2","ALEXIS","8895-4111","DIRECION DE ALEXIS");
INSERT INTO tbl_mn_referencias_familiares VALUES("6","25","2","ANTONIO","8555-1111","DIRECCION DE ANOTNIO");
INSERT INTO tbl_mn_referencias_familiares VALUES("7","27","2","JOSE ","9855-5522","DIRECCION DE JOSE");
INSERT INTO tbl_mn_referencias_familiares VALUES("8","27","3","MARVIN","3265-5555","DIRECCION DE MARVIN");
INSERT INTO tbl_mn_referencias_familiares VALUES("9","29","1","MAYNOR","9856-2323","DIRECCION DE MAYNOR");
INSERT INTO tbl_mn_referencias_familiares VALUES("10","29","3","ERLIN","8755-5555","DIRECCION DE ERLIN");
INSERT INTO tbl_mn_referencias_familiares VALUES("11","32","2","CARLOS","8855-6556","DIRECCION DE CARLOS");
INSERT INTO tbl_mn_referencias_familiares VALUES("12","32","3","JUAN","5588-8888","DIRECCION DE JUAN");
INSERT INTO tbl_mn_referencias_familiares VALUES("13","34","1","ASAS","5555-5551","DIRECCION DE REFERENCIA 1");
INSERT INTO tbl_mn_referencias_familiares VALUES("14","34","1","DFSDF","2222-2221","DIRECCION DE REFERENCIA 2");
INSERT INTO tbl_mn_referencias_familiares VALUES("15","35","1","DIGNA","9855-5555","DIRECION DE REFERENCIA DIGNA");
INSERT INTO tbl_mn_referencias_familiares VALUES("16","35","3","CARLOS","8751-5151","DIRECCCION DE CARLOS");
INSERT INTO tbl_mn_referencias_familiares VALUES("17","38","1","CARLOS TORRES","9985-7777","DIRECCION DE REFERENCIA 1");
INSERT INTO tbl_mn_referencias_familiares VALUES("18","38","1","MARIA MEZA","3226-6777","DIRECCION DE LA REFERENCIA 2");
INSERT INTO tbl_mn_referencias_familiares VALUES("19","39","1","KEVIN","9985-9999","DIRECION DE REFERENCIA 1");
INSERT INTO tbl_mn_referencias_familiares VALUES("20","39","1","FERNANDO","9995-9999","DIRECCION DE LA REFERENCIA 2");
INSERT INTO tbl_mn_referencias_familiares VALUES("21","41","3","LIZETH","9986-5656","DIRECCION DE REFERENCIA 1");
INSERT INTO tbl_mn_referencias_familiares VALUES("22","41","1","DALIA","9889-5655","DIRECCION DE LA REFERENCIA 2");
INSERT INTO tbl_mn_referencias_familiares VALUES("23","43","1","WREWR","5444-4444","SDAASDAD");
INSERT INTO tbl_mn_referencias_familiares VALUES("24","43","1","","5555-5555","SDSD");
INSERT INTO tbl_mn_referencias_familiares VALUES("25","44","1","ADASD","4444-4444","DFDFDFSSDF");
INSERT INTO tbl_mn_referencias_familiares VALUES("26","44","1","SDFDF","4444-4444","SDFDSF");



DROP TABLE IF EXISTS tbl_mn_resultado_factor_riesgo;

CREATE TABLE `tbl_mn_resultado_factor_riesgo` (
  `idResultadoFactorRiesgo` int(11) NOT NULL,
  `idTiposRiesgos` int(11) NOT NULL,
  `idEstadoFactorRiesgo` int(11) NOT NULL,
  `Control` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`idResultadoFactorRiesgo`),
  KEY `idTiposRiesgos_FK` (`idTiposRiesgos`),
  KEY `idEstadoFactorRiesgo_FK` (`idEstadoFactorRiesgo`),
  CONSTRAINT `idEstadoFactorRiesgo_FK` FOREIGN KEY (`idEstadoFactorRiesgo`) REFERENCES `tbl_mn_estado_factor_riesgo` (`idEstadoFactorRiesgo`),
  CONSTRAINT `idTiposRiesgos_FK` FOREIGN KEY (`idTiposRiesgos`) REFERENCES `tbl_mn_tipos_riesgos` (`idTiposRiesgos`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;




DROP TABLE IF EXISTS tbl_mn_rubros;

CREATE TABLE `tbl_mn_rubros` (
  `idRubro` int(11) NOT NULL AUTO_INCREMENT,
  `Descripcion` varchar(20) NOT NULL,
  PRIMARY KEY (`idRubro`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_mn_rubros VALUES("1","Agropecuario");
INSERT INTO tbl_mn_rubros VALUES("2","Comercio");
INSERT INTO tbl_mn_rubros VALUES("3","Servicio");
INSERT INTO tbl_mn_rubros VALUES("4","Transformacion");



DROP TABLE IF EXISTS tbl_mn_solicitudes_creditos;

CREATE TABLE `tbl_mn_solicitudes_creditos` (
  `idSolicitud` int(11) NOT NULL AUTO_INCREMENT,
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
  PRIMARY KEY (`idSolicitud`),
  KEY `id_persona_fk_` (`idPersona`),
  KEY `idTipoPrestamos_fk_` (`idTipoPrestamo`),
  KEY `idRubro_fk_` (`idRubro`),
  KEY `idEstadoSolicitud_fk_` (`idEstadoSolicitud`),
  KEY `idUsuario_fk_` (`idUsuario`),
  CONSTRAINT `idEstadoSolicitud_fk_` FOREIGN KEY (`idEstadoSolicitud`) REFERENCES `tbl_mn_estados_solicitudes` (`idEstadoSolicitud`),
  CONSTRAINT `idRubro_fk_` FOREIGN KEY (`idRubro`) REFERENCES `tbl_mn_rubros` (`idRubro`),
  CONSTRAINT `idTipoPrestamos_fk_` FOREIGN KEY (`idTipoPrestamo`) REFERENCES `tbl_mn_tipos_prestamos` (`idTipoPrestamo`),
  CONSTRAINT `idUsuario_fk_` FOREIGN KEY (`idUsuario`) REFERENCES `tbl_ms_usuario` (`idUsuario`),
  CONSTRAINT `id_persona_fk_` FOREIGN KEY (`idPersona`) REFERENCES `tbl_mn_personas` (`idPersona`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_mn_solicitudes_creditos VALUES("1","19","1","1","1","1","60000.00","12.00","18","2023-10-31","COMPRA DE INVENTARIO","","","","");
INSERT INTO tbl_mn_solicitudes_creditos VALUES("2","27","1","2","3","1","40000.00","12.00","18","2023-11-16","COMPRA DE MERCADERIA","","","","");
INSERT INTO tbl_mn_solicitudes_creditos VALUES("4","32","1","3","1","1","8500.00","12.00","10","2023-11-09","REMODELAR LOCAL","","2023-12-04 00:00:00","2","");
INSERT INTO tbl_mn_solicitudes_creditos VALUES("5","38","1","2","3","1","20000.00","12.00","15","2023-11-08","COMPRA DE INVENTARIO PARA FERRETERIA","","","","");
INSERT INTO tbl_mn_solicitudes_creditos VALUES("6","44","1","2","3","1","15000.00","12.00","10","2023-12-28","SDFSDFDF","","","","ES SU PRIMER CRÉDITO EN EL FONDO ROTATORIO");



DROP TABLE IF EXISTS tbl_mn_tendencia;

CREATE TABLE `tbl_mn_tendencia` (
  `idTendencia` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(45) NOT NULL,
  PRIMARY KEY (`idTendencia`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;




DROP TABLE IF EXISTS tbl_mn_tiempo_laboral;

CREATE TABLE `tbl_mn_tiempo_laboral` (
  `idTiempoLaboral` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(45) NOT NULL,
  PRIMARY KEY (`idTiempoLaboral`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_mn_tiempo_laboral VALUES("1","1 AÑO");
INSERT INTO tbl_mn_tiempo_laboral VALUES("2","2 AÑOS");
INSERT INTO tbl_mn_tiempo_laboral VALUES("3","3 AÑOS");
INSERT INTO tbl_mn_tiempo_laboral VALUES("4","4 AÑOS");
INSERT INTO tbl_mn_tiempo_laboral VALUES("5","MAS DE 5 AÑOS");



DROP TABLE IF EXISTS tbl_mn_tiempo_local;

CREATE TABLE `tbl_mn_tiempo_local` (
  `idTiempoLocal` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(45) NOT NULL,
  PRIMARY KEY (`idTiempoLocal`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;




DROP TABLE IF EXISTS tbl_mn_tiempo_vivir;

CREATE TABLE `tbl_mn_tiempo_vivir` (
  `idtiempoVivir` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(30) NOT NULL,
  PRIMARY KEY (`idtiempoVivir`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_mn_tiempo_vivir VALUES("1","1 AÑO");
INSERT INTO tbl_mn_tiempo_vivir VALUES("2","2 AÑOS");
INSERT INTO tbl_mn_tiempo_vivir VALUES("3","3 AÑOS");
INSERT INTO tbl_mn_tiempo_vivir VALUES("4","4 AÑOS");
INSERT INTO tbl_mn_tiempo_vivir VALUES("5","MAS DE 5 AÑOS");



DROP TABLE IF EXISTS tbl_mn_tipo_clientes;

CREATE TABLE `tbl_mn_tipo_clientes` (
  `idTipoCliente` int(11) NOT NULL AUTO_INCREMENT,
  `Descripcion` varchar(30) NOT NULL,
  PRIMARY KEY (`idTipoCliente`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_mn_tipo_clientes VALUES("1","ACTIVO");
INSERT INTO tbl_mn_tipo_clientes VALUES("2","INACTIVO");
INSERT INTO tbl_mn_tipo_clientes VALUES("3","PRIMERA VEZ");
INSERT INTO tbl_mn_tipo_clientes VALUES("4","NO DEFINIDO");



DROP TABLE IF EXISTS tbl_mn_tipo_contacto;

CREATE TABLE `tbl_mn_tipo_contacto` (
  `idTipoContacto` int(11) NOT NULL AUTO_INCREMENT,
  `Descripcion` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`idTipoContacto`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_mn_tipo_contacto VALUES("1","CELULAR CLIENTE");
INSERT INTO tbl_mn_tipo_contacto VALUES("2","Direccion Cliente");
INSERT INTO tbl_mn_tipo_contacto VALUES("3","Telefono\nCliente");
INSERT INTO tbl_mn_tipo_contacto VALUES("4","Direccion trabajo");
INSERT INTO tbl_mn_tipo_contacto VALUES("5","Telefono trabajo");



DROP TABLE IF EXISTS tbl_mn_tipo_cuenta;

CREATE TABLE `tbl_mn_tipo_cuenta` (
  `idTipoCuenta` int(11) NOT NULL AUTO_INCREMENT,
  `Descripcion` varchar(45) NOT NULL,
  PRIMARY KEY (`idTipoCuenta`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_mn_tipo_cuenta VALUES("1","IDC");



DROP TABLE IF EXISTS tbl_mn_tipo_persona;

CREATE TABLE `tbl_mn_tipo_persona` (
  `idTipoPersona` int(11) NOT NULL AUTO_INCREMENT,
  `Descripcion` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`idTipoPersona`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_mn_tipo_persona VALUES("1","Cliente");
INSERT INTO tbl_mn_tipo_persona VALUES("2","Pareja");
INSERT INTO tbl_mn_tipo_persona VALUES("3","AVAL");



DROP TABLE IF EXISTS tbl_mn_tipos_de_pago;

CREATE TABLE `tbl_mn_tipos_de_pago` (
  `idTipoPago` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(40) NOT NULL,
  PRIMARY KEY (`idTipoPago`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_mn_tipos_de_pago VALUES("1","NO REALIZA PAGO");
INSERT INTO tbl_mn_tipos_de_pago VALUES("2","SEMANAL");
INSERT INTO tbl_mn_tipos_de_pago VALUES("3","QUINCENAL");
INSERT INTO tbl_mn_tipos_de_pago VALUES("4","MENSUAL");



DROP TABLE IF EXISTS tbl_mn_tipos_estudio;

CREATE TABLE `tbl_mn_tipos_estudio` (
  `idTiposEstudio` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(50) NOT NULL,
  PRIMARY KEY (`idTiposEstudio`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;




DROP TABLE IF EXISTS tbl_mn_tipos_prestamos;

CREATE TABLE `tbl_mn_tipos_prestamos` (
  `idTipoPrestamo` int(11) NOT NULL AUTO_INCREMENT,
  `idEstadoTipoPrestamo` int(11) NOT NULL,
  `Descripcion` varchar(15) NOT NULL,
  `tasa` decimal(4,2) NOT NULL,
  `PlazoMaximo` int(11) NOT NULL,
  `montoMaximo` decimal(8,2) NOT NULL,
  `montoMinimo` decimal(8,2) NOT NULL,
  PRIMARY KEY (`idTipoPrestamo`),
  KEY `idEstadoTipoPrestamo_fk` (`idEstadoTipoPrestamo`),
  CONSTRAINT `idEstadoTipoPrestamo_fk` FOREIGN KEY (`idEstadoTipoPrestamo`) REFERENCES `tbl_mn_estadotipoprestamo` (`idestadoTipoPrestamo`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_mn_tipos_prestamos VALUES("1","1","FIDUCIARIO","12.00","48","60000.00","10000.00");
INSERT INTO tbl_mn_tipos_prestamos VALUES("2","1","SOLIDARIO","12.00","36","9999.00","999.00");



DROP TABLE IF EXISTS tbl_mn_tipos_riesgos;

CREATE TABLE `tbl_mn_tipos_riesgos` (
  `idTiposRiesgos` int(11) NOT NULL,
  `descripcion` varchar(50) NOT NULL,
  PRIMARY KEY (`idTiposRiesgos`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;




DROP TABLE IF EXISTS tbl_mn_ubicacion_fisica;

CREATE TABLE `tbl_mn_ubicacion_fisica` (
  `idUbicacion` int(11) NOT NULL AUTO_INCREMENT,
  `Descripcion` varchar(45) NOT NULL,
  PRIMARY KEY (`idUbicacion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;




DROP TABLE IF EXISTS tbl_ms_bitacora;

CREATE TABLE `tbl_ms_bitacora` (
  `idBitacora` int(11) NOT NULL AUTO_INCREMENT,
  `idUsuario` int(11) NOT NULL,
  `idObjetos` int(11) NOT NULL,
  `Accion` varchar(20) DEFAULT NULL,
  `Descripcion` varchar(100) DEFAULT NULL,
  `Fecha` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`idBitacora`),
  KEY `idUsuario_Bitacora_fk` (`idUsuario`),
  KEY `idObjeto_fk` (`idObjetos`),
  CONSTRAINT `idObjeto_fk` FOREIGN KEY (`idObjetos`) REFERENCES `tbl_ms_objetos` (`idObjetos`),
  CONSTRAINT `idUsuario_Bitacora_fk` FOREIGN KEY (`idUsuario`) REFERENCES `tbl_ms_usuario` (`idUsuario`)
) ENGINE=InnoDB AUTO_INCREMENT=412 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_ms_bitacora VALUES("1","1","1","Ingreso","Ingreso al Sistema","2023-10-28 16:50:58");
INSERT INTO tbl_ms_bitacora VALUES("2","1","4","Ingreso","Ingreso al Home Principal del Sistema","2023-10-28 16:50:59");
INSERT INTO tbl_ms_bitacora VALUES("3","1","1","Ingreso","Ingreso al Sistema","2023-10-28 17:11:08");
INSERT INTO tbl_ms_bitacora VALUES("4","1","4","Ingreso","Ingreso al Home Principal del Sistema","2023-10-28 17:11:08");
INSERT INTO tbl_ms_bitacora VALUES("5","1","1","Ingreso","Ingreso al Sistema","2023-10-28 17:56:27");
INSERT INTO tbl_ms_bitacora VALUES("6","1","4","Ingreso","Ingreso al Home Principal del Sistema","2023-10-28 17:56:27");
INSERT INTO tbl_ms_bitacora VALUES("7","1","1","Ingreso","Ingreso al Sistema","2023-10-28 19:58:12");
INSERT INTO tbl_ms_bitacora VALUES("8","1","4","Ingreso","Ingreso al Home Principal del Sistema","2023-10-28 19:58:12");
INSERT INTO tbl_ms_bitacora VALUES("9","1","1","Ingreso","Ingreso al Sistema","2023-10-28 20:21:11");
INSERT INTO tbl_ms_bitacora VALUES("10","1","4","Ingreso","Ingreso al Home Principal del Sistema","2023-10-28 20:21:11");
INSERT INTO tbl_ms_bitacora VALUES("11","1","1","Ingreso","Ingreso al Sistema","2023-10-29 11:42:47");
INSERT INTO tbl_ms_bitacora VALUES("12","1","4","Ingreso","Ingreso al Home Principal del Sistema","2023-10-29 11:42:47");
INSERT INTO tbl_ms_bitacora VALUES("13","1","1","Ingreso","Ingreso al Sistema","2023-10-29 12:03:06");
INSERT INTO tbl_ms_bitacora VALUES("14","1","4","Ingreso","Ingreso al Home Principal del Sistema","2023-10-29 12:03:06");
INSERT INTO tbl_ms_bitacora VALUES("15","1","1","Ingreso","Ingreso al Sistema","2023-10-29 12:38:15");
INSERT INTO tbl_ms_bitacora VALUES("16","1","4","Ingreso","Ingreso al Home Principal del Sistema","2023-10-29 12:38:15");
INSERT INTO tbl_ms_bitacora VALUES("17","1","4","Ingreso","Ingreso al Home Principal del Sistema","2023-10-29 12:58:38");
INSERT INTO tbl_ms_bitacora VALUES("18","1","1","Ingreso","Ingreso al Sistema","2023-10-29 13:03:05");
INSERT INTO tbl_ms_bitacora VALUES("19","1","4","Ingreso","Ingreso al Home Principal del Sistema","2023-10-29 13:03:05");
INSERT INTO tbl_ms_bitacora VALUES("20","1","1","Salio","Salio del Sistema","2023-10-29 20:19:32");
INSERT INTO tbl_ms_bitacora VALUES("21","1","1","Ingreso","Ingreso al Sistema","2023-10-29 20:19:43");
INSERT INTO tbl_ms_bitacora VALUES("22","1","4","Ingreso","Ingreso al Home Principal del Sistema","2023-10-29 20:19:43");
INSERT INTO tbl_ms_bitacora VALUES("23","1","4","Ingreso","Ingreso al Home Principal del Sistema","2023-10-29 21:27:54");
INSERT INTO tbl_ms_bitacora VALUES("24","1","3","Ingreso","Ingreso al Mantenimiento de Usuario","2023-10-29 22:10:13");
INSERT INTO tbl_ms_bitacora VALUES("25","1","3","Ingreso","Ingreso al Mantenimiento de Usuario","2023-10-29 22:11:00");
INSERT INTO tbl_ms_bitacora VALUES("26","1","1","Ingreso","Ingreso al Sistema","2023-10-30 18:28:57");
INSERT INTO tbl_ms_bitacora VALUES("27","1","4","Ingreso","Ingreso al Home Principal del Sistema","2023-10-30 18:28:58");
INSERT INTO tbl_ms_bitacora VALUES("28","1","1","Salio","Salio del Sistema","2023-10-30 18:29:00");
INSERT INTO tbl_ms_bitacora VALUES("29","1","1","Ingreso","Ingreso al Sistema","2023-10-30 19:53:55");
INSERT INTO tbl_ms_bitacora VALUES("30","1","4","Ingreso","Ingreso al Home Principal del Sistema","2023-10-30 19:53:55");
INSERT INTO tbl_ms_bitacora VALUES("31","1","1","Salio","Salio del Sistema","2023-10-30 19:53:59");
INSERT INTO tbl_ms_bitacora VALUES("32","1","1","Ingreso","Ingreso al Sistema","2023-10-30 21:21:22");
INSERT INTO tbl_ms_bitacora VALUES("33","1","4","Ingreso","Ingreso al Home Principal del Sistema","2023-10-30 21:21:23");
INSERT INTO tbl_ms_bitacora VALUES("34","1","1","Ingreso","Ingreso al Sistema","2023-10-31 18:37:31");
INSERT INTO tbl_ms_bitacora VALUES("35","1","4","Ingreso","Ingreso al Home Principal del Sistema","2023-10-31 18:37:31");
INSERT INTO tbl_ms_bitacora VALUES("36","1","4","Ingreso","Ingreso al Home Principal del Sistema","2023-10-31 19:09:44");
INSERT INTO tbl_ms_bitacora VALUES("37","1","4","Ingreso","Ingreso al Home Principal del Sistema","2023-10-31 19:09:55");
INSERT INTO tbl_ms_bitacora VALUES("38","1","4","Ingreso","Ingreso al Home Principal del Sistema","2023-10-31 19:10:11");
INSERT INTO tbl_ms_bitacora VALUES("39","1","4","Ingreso","Ingreso al Home Principal del Sistema","2023-10-31 19:10:13");
INSERT INTO tbl_ms_bitacora VALUES("40","1","4","Ingreso","Ingreso al Home Principal del Sistema","2023-10-31 19:12:30");
INSERT INTO tbl_ms_bitacora VALUES("41","1","1","Salio","Salio del Sistema","2023-10-31 19:12:32");
INSERT INTO tbl_ms_bitacora VALUES("42","1","1","Ingreso","Ingreso al Sistema","2023-10-31 19:16:03");
INSERT INTO tbl_ms_bitacora VALUES("43","1","4","Ingreso","Ingreso al Home Principal del Sistema","2023-10-31 19:16:03");
INSERT INTO tbl_ms_bitacora VALUES("44","1","1","Salio","Salio del Sistema","2023-10-31 19:16:08");
INSERT INTO tbl_ms_bitacora VALUES("45","1","1","Ingreso","Ingreso al Sistema","2023-10-31 19:21:01");
INSERT INTO tbl_ms_bitacora VALUES("46","1","4","Ingreso","Ingreso al Home Principal del Sistema","2023-10-31 19:21:02");
INSERT INTO tbl_ms_bitacora VALUES("47","1","1","Salio","Salio del Sistema","2023-10-31 19:21:04");
INSERT INTO tbl_ms_bitacora VALUES("48","1","1","Ingreso","Ingreso al Sistema","2023-10-31 19:22:57");
INSERT INTO tbl_ms_bitacora VALUES("49","1","4","Ingreso","Ingreso al Home Principal del Sistema","2023-10-31 19:22:57");
INSERT INTO tbl_ms_bitacora VALUES("50","1","1","Salio","Salio del Sistema","2023-10-31 19:23:00");
INSERT INTO tbl_ms_bitacora VALUES("51","1","1","Ingreso","Ingreso al Sistema","2023-11-01 12:30:47");
INSERT INTO tbl_ms_bitacora VALUES("52","1","4","Ingreso","Ingreso al Home Principal del Sistema","2023-11-01 12:30:47");
INSERT INTO tbl_ms_bitacora VALUES("53","1","3","Ingreso","Ingreso al Mantenimiento de Usuario","2023-11-01 12:31:22");
INSERT INTO tbl_ms_bitacora VALUES("54","1","1","Salio","Salio del Sistema","2023-11-01 12:36:22");
INSERT INTO tbl_ms_bitacora VALUES("55","1","1","Ingreso","Ingreso al Sistema","2023-11-01 12:36:28");
INSERT INTO tbl_ms_bitacora VALUES("56","1","4","Ingreso","Ingreso al Home Principal del Sistema","2023-11-01 12:36:28");
INSERT INTO tbl_ms_bitacora VALUES("57","1","4","Ingreso","Ingreso al Home Principal del Sistema","2023-11-01 12:36:35");
INSERT INTO tbl_ms_bitacora VALUES("58","1","1","Ingreso","Ingreso al Sistema","2023-11-01 12:39:50");
INSERT INTO tbl_ms_bitacora VALUES("59","1","4","Ingreso","Ingreso al Home Principal del Sistema","2023-11-01 12:39:50");
INSERT INTO tbl_ms_bitacora VALUES("60","1","1","Salio","Salio del Sistema","2023-11-01 12:56:20");
INSERT INTO tbl_ms_bitacora VALUES("61","1","1","Ingreso","Ingreso al Sistema","2023-11-01 12:56:27");
INSERT INTO tbl_ms_bitacora VALUES("62","1","4","Ingreso","Ingreso al Home Principal del Sistema","2023-11-01 12:56:27");
INSERT INTO tbl_ms_bitacora VALUES("63","1","1","Salio","Salio del Sistema","2023-11-01 12:56:47");
INSERT INTO tbl_ms_bitacora VALUES("64","1","1","Ingreso","Ingreso al Sistema","2023-11-01 12:56:59");
INSERT INTO tbl_ms_bitacora VALUES("65","1","4","Ingreso","Ingreso al Home Principal del Sistema","2023-11-01 12:56:59");
INSERT INTO tbl_ms_bitacora VALUES("66","1","1","Salio","Salio del Sistema","2023-11-01 12:58:34");
INSERT INTO tbl_ms_bitacora VALUES("67","1","1","Ingreso","Ingreso al Sistema","2023-11-01 12:58:56");
INSERT INTO tbl_ms_bitacora VALUES("68","1","4","Ingreso","Ingreso al Home Principal del Sistema","2023-11-01 12:58:57");
INSERT INTO tbl_ms_bitacora VALUES("69","1","1","Ingreso","Ingreso al Sistema","2023-11-01 13:03:18");
INSERT INTO tbl_ms_bitacora VALUES("70","1","4","Ingreso","Ingreso al Home Principal del Sistema","2023-11-01 13:03:18");
INSERT INTO tbl_ms_bitacora VALUES("71","1","1","Ingreso","Ingreso al Sistema","2023-11-01 13:05:57");
INSERT INTO tbl_ms_bitacora VALUES("72","1","4","Ingreso","Ingreso al Home Principal del Sistema","2023-11-01 13:05:57");
INSERT INTO tbl_ms_bitacora VALUES("73","1","1","Ingreso","Ingreso al Sistema","2023-11-01 13:08:52");
INSERT INTO tbl_ms_bitacora VALUES("74","1","4","Ingreso","Ingreso al Home Principal del Sistema","2023-11-01 13:08:52");
INSERT INTO tbl_ms_bitacora VALUES("75","1","1","Ingreso","Ingreso al Sistema","2023-11-01 13:12:48");
INSERT INTO tbl_ms_bitacora VALUES("76","1","4","Ingreso","Ingreso al Home Principal del Sistema","2023-11-01 13:12:48");
INSERT INTO tbl_ms_bitacora VALUES("77","1","3","Ingreso","Ingreso al Mantenimiento de Usuario","2023-11-01 13:13:24");
INSERT INTO tbl_ms_bitacora VALUES("78","1","1","Ingreso","Ingreso al Sistema","2023-11-03 13:52:55");
INSERT INTO tbl_ms_bitacora VALUES("79","1","4","Ingreso","Ingreso al Home Principal del Sistema","2023-11-03 13:52:55");
INSERT INTO tbl_ms_bitacora VALUES("80","1","1","Ingreso","Ingreso al Sistema","2023-11-03 13:58:39");
INSERT INTO tbl_ms_bitacora VALUES("81","1","4","Ingreso","Ingreso al Home Principal del Sistema","2023-11-03 13:58:39");
INSERT INTO tbl_ms_bitacora VALUES("82","1","1","Ingreso","Ingreso al Sistema","2023-11-03 15:03:23");
INSERT INTO tbl_ms_bitacora VALUES("83","1","4","Ingreso","Ingreso al Home Principal del Sistema","2023-11-03 15:03:23");
INSERT INTO tbl_ms_bitacora VALUES("84","1","1","Ingreso","Ingreso al Sistema","2023-11-03 15:22:04");
INSERT INTO tbl_ms_bitacora VALUES("85","1","4","Ingreso","Ingreso al Home Principal del Sistema","2023-11-03 15:22:04");
INSERT INTO tbl_ms_bitacora VALUES("86","1","1","Ingreso","Ingreso al Sistema","2023-11-03 16:33:38");
INSERT INTO tbl_ms_bitacora VALUES("87","1","4","Ingreso","Ingreso al Home Principal del Sistema","2023-11-03 16:33:38");
INSERT INTO tbl_ms_bitacora VALUES("88","1","4","Ingreso","Ingreso al Home Principal del Sistema","2023-11-03 16:33:39");
INSERT INTO tbl_ms_bitacora VALUES("89","1","1","Ingreso","Ingreso al Sistema","2023-11-03 18:31:51");
INSERT INTO tbl_ms_bitacora VALUES("90","1","4","Ingreso","Ingreso al Home Principal del Sistema","2023-11-03 18:31:51");
INSERT INTO tbl_ms_bitacora VALUES("91","1","1","Salio","Salio del Sistema","2023-11-03 19:22:00");
INSERT INTO tbl_ms_bitacora VALUES("92","1","1","Ingreso","Ingreso al Sistema","2023-11-03 19:22:10");
INSERT INTO tbl_ms_bitacora VALUES("93","1","4","Ingreso","Ingreso al Home Principal del Sistema","2023-11-03 19:22:10");
INSERT INTO tbl_ms_bitacora VALUES("94","1","1","Ingreso","Ingreso al Sistema","2023-11-03 20:58:12");
INSERT INTO tbl_ms_bitacora VALUES("95","1","4","Ingreso","Ingreso al Home Principal del Sistema","2023-11-03 20:58:12");
INSERT INTO tbl_ms_bitacora VALUES("96","1","1","Ingreso","Ingreso al Sistema","2023-11-03 21:50:00");
INSERT INTO tbl_ms_bitacora VALUES("97","1","4","Ingreso","Ingreso al Home Principal del Sistema","2023-11-03 21:50:00");
INSERT INTO tbl_ms_bitacora VALUES("98","1","1","Ingreso","Ingreso al Sistema","2023-11-03 22:01:53");
INSERT INTO tbl_ms_bitacora VALUES("99","1","4","Ingreso","Ingreso al Home Principal del Sistema","2023-11-03 22:01:53");
INSERT INTO tbl_ms_bitacora VALUES("100","1","1","Ingreso","Ingreso al Sistema","2023-11-03 23:02:31");
INSERT INTO tbl_ms_bitacora VALUES("101","1","4","Ingreso","Ingreso al Home Principal del Sistema","2023-11-03 23:02:31");
INSERT INTO tbl_ms_bitacora VALUES("102","1","1","Ingreso","Ingreso al Sistema","2023-11-03 23:03:19");
INSERT INTO tbl_ms_bitacora VALUES("103","1","4","Ingreso","Ingreso al Home Principal del Sistema","2023-11-03 23:03:20");
INSERT INTO tbl_ms_bitacora VALUES("104","1","1","Ingreso","Ingreso al Sistema","2023-11-04 11:00:35");
INSERT INTO tbl_ms_bitacora VALUES("105","1","4","Ingreso","Ingreso al Home Principal del Sistema","2023-11-04 11:00:35");
INSERT INTO tbl_ms_bitacora VALUES("106","1","1","Ingreso","Ingreso al Sistema","2023-11-04 11:18:37");
INSERT INTO tbl_ms_bitacora VALUES("107","1","4","Ingreso","Ingreso al Home Principal del Sistema","2023-11-04 11:18:37");
INSERT INTO tbl_ms_bitacora VALUES("108","1","1","Ingreso","Ingreso al Sistema","2023-11-04 11:44:04");
INSERT INTO tbl_ms_bitacora VALUES("109","1","4","Ingreso","Ingreso al Home Principal del Sistema","2023-11-04 11:44:04");
INSERT INTO tbl_ms_bitacora VALUES("110","1","1","Ingreso","Ingreso al Sistema","2023-11-04 12:08:57");
INSERT INTO tbl_ms_bitacora VALUES("111","1","4","Ingreso","Ingreso al Home Principal del Sistema","2023-11-04 12:08:57");
INSERT INTO tbl_ms_bitacora VALUES("112","1","1","Ingreso","Ingreso al Sistema","2023-11-04 14:23:24");
INSERT INTO tbl_ms_bitacora VALUES("113","1","4","Ingreso","Ingreso al Home Principal del Sistema","2023-11-04 14:23:24");
INSERT INTO tbl_ms_bitacora VALUES("114","1","1","Salio","Salio del Sistema","2023-11-04 14:30:56");
INSERT INTO tbl_ms_bitacora VALUES("115","1","1","Ingreso","Ingreso al Sistema","2023-11-04 14:31:09");
INSERT INTO tbl_ms_bitacora VALUES("116","1","4","Ingreso","Ingreso al Home Principal del Sistema","2023-11-04 14:31:09");
INSERT INTO tbl_ms_bitacora VALUES("117","1","1","Ingreso","Ingreso al Sistema","2023-11-04 14:31:55");
INSERT INTO tbl_ms_bitacora VALUES("118","1","4","Ingreso","Ingreso al Home Principal del Sistema","2023-11-04 14:31:55");
INSERT INTO tbl_ms_bitacora VALUES("119","1","1","Ingreso","Ingreso al Sistema","2023-11-04 14:37:27");
INSERT INTO tbl_ms_bitacora VALUES("120","1","4","Ingreso","Ingreso al Home Principal del Sistema","2023-11-04 14:37:28");
INSERT INTO tbl_ms_bitacora VALUES("121","1","3","Ingreso","Ingreso al Mantenimiento de Usuario","2023-11-04 14:37:38");
INSERT INTO tbl_ms_bitacora VALUES("122","1","4","Ingreso","Ingreso al Home Principal del Sistema","2023-11-04 16:32:07");
INSERT INTO tbl_ms_bitacora VALUES("123","1","1","Ingreso","Ingreso al Sistema","2023-11-04 16:37:58");
INSERT INTO tbl_ms_bitacora VALUES("124","1","4","Ingreso","Ingreso al Home Principal del Sistema","2023-11-04 16:37:58");
INSERT INTO tbl_ms_bitacora VALUES("125","1","4","Ingreso","Ingreso al Home Principal del Sistema","2023-11-04 17:03:03");
INSERT INTO tbl_ms_bitacora VALUES("126","1","4","Ingreso","Ingreso al Home Principal del Sistema","2023-11-04 17:03:11");
INSERT INTO tbl_ms_bitacora VALUES("127","1","1","Ingreso","Ingreso al Sistema","2023-11-04 17:07:25");
INSERT INTO tbl_ms_bitacora VALUES("128","1","4","Ingreso","Ingreso al Home Principal del Sistema","2023-11-04 17:07:25");
INSERT INTO tbl_ms_bitacora VALUES("129","1","1","Ingreso","Ingreso al Sistema","2023-11-04 21:34:44");
INSERT INTO tbl_ms_bitacora VALUES("130","1","4","Ingreso","Ingreso al Home Principal del Sistema","2023-11-04 21:34:44");
INSERT INTO tbl_ms_bitacora VALUES("131","1","1","Ingreso","Ingreso al Sistema","2023-11-04 22:05:57");
INSERT INTO tbl_ms_bitacora VALUES("132","1","4","Ingreso","Ingreso al Home Principal del Sistema","2023-11-04 22:05:57");
INSERT INTO tbl_ms_bitacora VALUES("133","1","1","Ingreso","Ingreso al Sistema","2023-11-05 10:32:54");
INSERT INTO tbl_ms_bitacora VALUES("134","1","4","Ingreso","Ingreso al Home Principal del Sistema","2023-11-05 10:32:54");
INSERT INTO tbl_ms_bitacora VALUES("135","1","1","Ingreso","Ingreso al Sistema","2023-11-05 10:47:40");
INSERT INTO tbl_ms_bitacora VALUES("136","1","4","Ingreso","Ingreso al Home Principal del Sistema","2023-11-05 10:47:40");
INSERT INTO tbl_ms_bitacora VALUES("137","1","1","Ingreso","Ingreso al Sistema","2023-11-05 11:29:22");
INSERT INTO tbl_ms_bitacora VALUES("138","1","4","Ingreso","Ingreso al Home Principal del Sistema","2023-11-05 11:29:22");
INSERT INTO tbl_ms_bitacora VALUES("139","1","1","Ingreso","Ingreso al Sistema","2023-11-05 12:17:07");
INSERT INTO tbl_ms_bitacora VALUES("140","1","4","Ingreso","Ingreso al Home Principal del Sistema","2023-11-05 12:17:07");
INSERT INTO tbl_ms_bitacora VALUES("141","1","1","Ingreso","Ingreso al Sistema","2023-11-05 12:19:34");
INSERT INTO tbl_ms_bitacora VALUES("142","1","4","Ingreso","Ingreso al Home Principal del Sistema","2023-11-05 12:19:34");
INSERT INTO tbl_ms_bitacora VALUES("143","1","4","Ingreso","Ingreso al Home Principal del Sistema","2023-11-05 13:19:59");
INSERT INTO tbl_ms_bitacora VALUES("144","1","4","Ingreso","Ingreso al Home Principal del Sistema","2023-11-05 13:21:19");
INSERT INTO tbl_ms_bitacora VALUES("145","1","1","Ingreso","Ingreso al Sistema","2023-11-05 17:10:11");
INSERT INTO tbl_ms_bitacora VALUES("146","1","4","Ingreso","Ingreso al Home Principal del Sistema","2023-11-05 17:10:11");
INSERT INTO tbl_ms_bitacora VALUES("147","1","1","Ingreso","Ingreso al Sistema","2023-11-05 17:19:45");
INSERT INTO tbl_ms_bitacora VALUES("148","1","4","Ingreso","Ingreso al Home Principal del Sistema","2023-11-05 17:19:45");
INSERT INTO tbl_ms_bitacora VALUES("149","1","1","Ingreso","Ingreso al Sistema","2023-11-05 17:20:18");
INSERT INTO tbl_ms_bitacora VALUES("150","1","4","Ingreso","Ingreso al Home Principal del Sistema","2023-11-05 17:20:18");
INSERT INTO tbl_ms_bitacora VALUES("151","1","1","Ingreso","Ingreso al Sistema","2023-11-05 21:43:28");
INSERT INTO tbl_ms_bitacora VALUES("152","1","4","Ingreso","Ingreso al Home Principal del Sistema","2023-11-05 21:43:28");
INSERT INTO tbl_ms_bitacora VALUES("153","1","1","Ingreso","Ingreso al Sistema","2023-11-05 22:42:09");
INSERT INTO tbl_ms_bitacora VALUES("154","1","4","Ingreso","Ingreso al Home Principal del Sistema","2023-11-05 22:42:09");
INSERT INTO tbl_ms_bitacora VALUES("155","1","1","Salio","Salio del Sistema","2023-11-05 22:49:20");
INSERT INTO tbl_ms_bitacora VALUES("156","1","1","Ingreso","Ingreso al Sistema","2023-11-05 22:49:32");
INSERT INTO tbl_ms_bitacora VALUES("157","1","4","Ingreso","Ingreso al Home Principal del Sistema","2023-11-05 22:49:32");
INSERT INTO tbl_ms_bitacora VALUES("158","1","4","Ingreso","Ingreso al Home Principal del Sistema","2023-11-05 22:55:20");
INSERT INTO tbl_ms_bitacora VALUES("159","1","1","Ingreso","Ingreso al Sistema","2023-11-05 22:59:31");
INSERT INTO tbl_ms_bitacora VALUES("160","1","4","Ingreso","Ingreso al Home Principal del Sistema","2023-11-05 22:59:31");
INSERT INTO tbl_ms_bitacora VALUES("161","1","1","Ingreso","Ingreso al Sistema","2023-11-06 13:29:24");
INSERT INTO tbl_ms_bitacora VALUES("162","1","4","Ingreso","Ingreso al Home Principal del Sistema","2023-11-06 13:29:24");
INSERT INTO tbl_ms_bitacora VALUES("163","1","4","Ingreso","Ingreso al Home Principal del Sistema","2023-11-06 13:32:07");
INSERT INTO tbl_ms_bitacora VALUES("164","1","1","Ingreso","Ingreso al Sistema","2023-11-06 13:52:41");
INSERT INTO tbl_ms_bitacora VALUES("165","1","4","Ingreso","Ingreso al Home Principal del Sistema","2023-11-06 13:52:42");
INSERT INTO tbl_ms_bitacora VALUES("166","1","3","Ingreso","Ingreso al Mantenimiento de Usuario","2023-11-06 13:52:46");
INSERT INTO tbl_ms_bitacora VALUES("167","1","3","Modifico","Actualizo al usuario: FERNANDO MATAMOROS","2023-11-06 13:54:12");
INSERT INTO tbl_ms_bitacora VALUES("168","1","3","Inserto","Creo el usuario: INFORMATICA","2023-11-06 13:54:54");
INSERT INTO tbl_ms_bitacora VALUES("169","1","3","Ingreso","Ingreso al Mantenimiento de Usuario","2023-11-06 13:56:01");
INSERT INTO tbl_ms_bitacora VALUES("170","1","3","Modifico","Actualizo al usuario: FERNANDO MATAMOROS","2023-11-06 13:56:18");
INSERT INTO tbl_ms_bitacora VALUES("171","1","3","Modifico","Actualizo al usuario: FERNANDO MATAMOROS","2023-11-06 13:56:26");
INSERT INTO tbl_ms_bitacora VALUES("172","1","1","Salio","Salio del Sistema","2023-11-06 13:58:22");
INSERT INTO tbl_ms_bitacora VALUES("173","1","1","Ingreso","Ingreso al Sistema","2023-11-06 21:41:57");
INSERT INTO tbl_ms_bitacora VALUES("174","1","4","Ingreso","Ingreso al Home Principal del Sistema","2023-11-06 21:41:57");
INSERT INTO tbl_ms_bitacora VALUES("175","1","1","Ingreso","Ingreso al Sistema","2023-11-07 12:08:12");
INSERT INTO tbl_ms_bitacora VALUES("176","1","4","Ingreso","Ingreso al Home Principal del Sistema","2023-11-07 12:08:12");
INSERT INTO tbl_ms_bitacora VALUES("177","1","1","Ingreso","Ingreso al Sistema","2023-11-07 12:29:39");
INSERT INTO tbl_ms_bitacora VALUES("178","1","4","Ingreso","Ingreso al Home Principal del Sistema","2023-11-07 12:29:39");
INSERT INTO tbl_ms_bitacora VALUES("179","1","1","Salio","Salio del Sistema","2023-11-07 12:45:30");
INSERT INTO tbl_ms_bitacora VALUES("180","1","1","Ingreso","Ingreso al Sistema","2023-11-07 12:45:40");
INSERT INTO tbl_ms_bitacora VALUES("181","1","4","Ingreso","Ingreso al Home Principal del Sistema","2023-11-07 12:45:40");
INSERT INTO tbl_ms_bitacora VALUES("182","1","1","Ingreso","Ingreso al Sistema","2023-11-07 12:54:36");
INSERT INTO tbl_ms_bitacora VALUES("183","1","4","Ingreso","Ingreso al Home Principal del Sistema","2023-11-07 12:54:36");
INSERT INTO tbl_ms_bitacora VALUES("184","1","1","Ingreso","Ingreso al Sistema","2023-11-07 12:55:41");
INSERT INTO tbl_ms_bitacora VALUES("185","1","4","Ingreso","Ingreso al Home Principal del Sistema","2023-11-07 12:55:41");
INSERT INTO tbl_ms_bitacora VALUES("186","1","1","Ingreso","Ingreso al Sistema","2023-11-07 13:01:14");
INSERT INTO tbl_ms_bitacora VALUES("187","1","4","Ingreso","Ingreso al Home Principal del Sistema","2023-11-07 13:01:14");
INSERT INTO tbl_ms_bitacora VALUES("188","1","1","Ingreso","Ingreso al Sistema","2023-11-07 21:48:57");
INSERT INTO tbl_ms_bitacora VALUES("189","1","4","Ingreso","Ingreso al Home Principal del Sistema","2023-11-07 21:49:03");
INSERT INTO tbl_ms_bitacora VALUES("190","1","1","Salio","Salio del Sistema","2023-11-07 22:16:47");
INSERT INTO tbl_ms_bitacora VALUES("191","1","1","Ingreso","Ingreso al Sistema","2023-11-07 22:17:02");
INSERT INTO tbl_ms_bitacora VALUES("192","1","4","Ingreso","Ingreso al Home Principal del Sistema","2023-11-07 22:17:02");
INSERT INTO tbl_ms_bitacora VALUES("193","1","1","Salio","Salio del Sistema","2023-11-07 22:17:30");
INSERT INTO tbl_ms_bitacora VALUES("194","1","1","Ingreso","Ingreso al Sistema","2023-11-07 22:17:44");
INSERT INTO tbl_ms_bitacora VALUES("195","1","4","Ingreso","Ingreso al Home Principal del Sistema","2023-11-07 22:17:44");
INSERT INTO tbl_ms_bitacora VALUES("196","1","1","Salio","Salio del Sistema","2023-11-07 22:22:40");
INSERT INTO tbl_ms_bitacora VALUES("197","1","1","Ingreso","Ingreso al Sistema","2023-11-07 22:22:59");
INSERT INTO tbl_ms_bitacora VALUES("198","1","4","Ingreso","Ingreso al Home Principal del Sistema","2023-11-07 22:23:00");
INSERT INTO tbl_ms_bitacora VALUES("199","1","1","Salio","Salio del Sistema","2023-11-07 22:38:15");
INSERT INTO tbl_ms_bitacora VALUES("200","1","1","Ingreso","Ingreso al Sistema","2023-11-07 22:38:29");
INSERT INTO tbl_ms_bitacora VALUES("201","1","4","Ingreso","Ingreso al Home Principal del Sistema","2023-11-07 22:38:29");
INSERT INTO tbl_ms_bitacora VALUES("202","1","1","Ingreso","Ingreso al Sistema","2023-11-07 23:21:36");
INSERT INTO tbl_ms_bitacora VALUES("203","1","4","Ingreso","Ingreso al Home Principal del Sistema","2023-11-07 23:21:36");
INSERT INTO tbl_ms_bitacora VALUES("204","1","1","Ingreso","Ingreso al Sistema","2023-11-07 23:24:59");
INSERT INTO tbl_ms_bitacora VALUES("205","1","4","Ingreso","Ingreso al Home Principal del Sistema","2023-11-07 23:24:59");
INSERT INTO tbl_ms_bitacora VALUES("206","1","1","Ingreso","Ingreso al Sistema","2023-11-10 12:00:57");
INSERT INTO tbl_ms_bitacora VALUES("207","1","4","Ingreso","Ingreso al Home Principal del Sistema","2023-11-10 12:00:57");
INSERT INTO tbl_ms_bitacora VALUES("208","1","3","Ingreso","Ingreso al Mantenimiento de Usuario","2023-11-10 12:02:17");
INSERT INTO tbl_ms_bitacora VALUES("209","1","1","Ingreso","Ingreso al Sistema","2023-11-10 13:06:33");
INSERT INTO tbl_ms_bitacora VALUES("210","1","4","Ingreso","Ingreso al Home Principal del Sistema","2023-11-10 13:06:33");
INSERT INTO tbl_ms_bitacora VALUES("211","1","4","Ingreso","Ingreso al Home Principal del Sistema","2023-11-10 13:11:40");
INSERT INTO tbl_ms_bitacora VALUES("212","1","1","Ingreso","Ingreso al Sistema","2023-11-10 13:16:06");
INSERT INTO tbl_ms_bitacora VALUES("213","1","4","Ingreso","Ingreso al Home Principal del Sistema","2023-11-10 13:16:06");
INSERT INTO tbl_ms_bitacora VALUES("214","1","3","Ingreso","Ingreso al Mantenimiento de Usuario","2023-11-10 15:26:07");
INSERT INTO tbl_ms_bitacora VALUES("215","1","3","Ingreso","Ingreso al Mantenimiento de Usuario","2023-11-10 15:29:07");
INSERT INTO tbl_ms_bitacora VALUES("216","1","4","Ingreso","Ingreso al Home Principal del Sistema","2023-11-10 17:00:35");
INSERT INTO tbl_ms_bitacora VALUES("217","1","3","Ingreso","Ingreso al Mantenimiento de Usuario","2023-11-10 17:23:40");
INSERT INTO tbl_ms_bitacora VALUES("218","1","3","Ingreso","Ingreso al Mantenimiento de Usuario","2023-11-10 17:32:13");
INSERT INTO tbl_ms_bitacora VALUES("219","1","3","Ingreso","Ingreso al Mantenimiento de Usuario","2023-11-10 17:32:35");
INSERT INTO tbl_ms_bitacora VALUES("220","1","3","Ingreso","Ingreso al Mantenimiento de Usuario","2023-11-10 17:37:40");
INSERT INTO tbl_ms_bitacora VALUES("221","1","3","Ingreso","Ingreso al Mantenimiento de Usuario","2023-11-10 17:38:39");
INSERT INTO tbl_ms_bitacora VALUES("222","1","3","Ingreso","Ingreso al Mantenimiento de Usuario","2023-11-10 17:39:12");
INSERT INTO tbl_ms_bitacora VALUES("223","1","3","Ingreso","Ingreso al Mantenimiento de Usuario","2023-11-10 17:39:13");
INSERT INTO tbl_ms_bitacora VALUES("224","1","3","Ingreso","Ingreso al Mantenimiento de Usuario","2023-11-10 17:42:23");
INSERT INTO tbl_ms_bitacora VALUES("225","1","3","Ingreso","Ingreso al Mantenimiento de Usuario","2023-11-10 17:43:36");
INSERT INTO tbl_ms_bitacora VALUES("226","1","3","Ingreso","Ingreso al Mantenimiento de Usuario","2023-11-10 17:46:09");
INSERT INTO tbl_ms_bitacora VALUES("227","1","3","Ingreso","Ingreso al Mantenimiento de Usuario","2023-11-10 17:46:21");
INSERT INTO tbl_ms_bitacora VALUES("228","1","3","Ingreso","Ingreso al Mantenimiento de Usuario","2023-11-10 17:47:17");
INSERT INTO tbl_ms_bitacora VALUES("229","1","3","Ingreso","Ingreso al Mantenimiento de Usuario","2023-11-10 17:47:36");
INSERT INTO tbl_ms_bitacora VALUES("230","1","3","Ingreso","Ingreso al Mantenimiento de Usuario","2023-11-10 17:47:47");
INSERT INTO tbl_ms_bitacora VALUES("231","1","3","Ingreso","Ingreso al Mantenimiento de Usuario","2023-11-10 17:48:05");
INSERT INTO tbl_ms_bitacora VALUES("232","1","3","Ingreso","Ingreso al Mantenimiento de Usuario","2023-11-10 17:48:19");
INSERT INTO tbl_ms_bitacora VALUES("233","1","3","Ingreso","Ingreso al Mantenimiento de Usuario","2023-11-10 17:48:35");
INSERT INTO tbl_ms_bitacora VALUES("234","1","3","Ingreso","Ingreso al Mantenimiento de Usuario","2023-11-10 17:48:58");
INSERT INTO tbl_ms_bitacora VALUES("235","1","3","Ingreso","Ingreso al Mantenimiento de Usuario","2023-11-10 17:49:12");
INSERT INTO tbl_ms_bitacora VALUES("236","1","3","Ingreso","Ingreso al Mantenimiento de Usuario","2023-11-10 17:50:16");
INSERT INTO tbl_ms_bitacora VALUES("237","1","3","Ingreso","Ingreso al Mantenimiento de Usuario","2023-11-10 17:50:29");
INSERT INTO tbl_ms_bitacora VALUES("238","1","3","Ingreso","Ingreso al Mantenimiento de Usuario","2023-11-10 17:52:26");
INSERT INTO tbl_ms_bitacora VALUES("239","1","3","Ingreso","Ingreso al Mantenimiento de Usuario","2023-11-10 17:52:55");
INSERT INTO tbl_ms_bitacora VALUES("240","1","3","Ingreso","Ingreso al Mantenimiento de Usuario","2023-11-10 17:53:05");
INSERT INTO tbl_ms_bitacora VALUES("241","1","3","Ingreso","Ingreso al Mantenimiento de Usuario","2023-11-10 17:58:27");
INSERT INTO tbl_ms_bitacora VALUES("242","1","3","Ingreso","Ingreso al Mantenimiento de Usuario","2023-11-10 17:58:47");
INSERT INTO tbl_ms_bitacora VALUES("243","1","3","Ingreso","Ingreso al Mantenimiento de Usuario","2023-11-10 17:58:48");
INSERT INTO tbl_ms_bitacora VALUES("244","1","3","Ingreso","Ingreso al Mantenimiento de Usuario","2023-11-10 17:59:11");
INSERT INTO tbl_ms_bitacora VALUES("245","1","3","Ingreso","Ingreso al Mantenimiento de Usuario","2023-11-10 17:59:12");
INSERT INTO tbl_ms_bitacora VALUES("246","1","3","Ingreso","Ingreso al Mantenimiento de Usuario","2023-11-10 17:59:39");
INSERT INTO tbl_ms_bitacora VALUES("247","1","3","Ingreso","Ingreso al Mantenimiento de Usuario","2023-11-10 17:59:50");
INSERT INTO tbl_ms_bitacora VALUES("248","1","3","Ingreso","Ingreso al Mantenimiento de Usuario","2023-11-10 17:59:52");
INSERT INTO tbl_ms_bitacora VALUES("249","1","3","Ingreso","Ingreso al Mantenimiento de Usuario","2023-11-10 18:00:59");
INSERT INTO tbl_ms_bitacora VALUES("250","1","3","Ingreso","Ingreso al Mantenimiento de Usuario","2023-11-10 18:01:00");
INSERT INTO tbl_ms_bitacora VALUES("251","1","3","Ingreso","Ingreso al Mantenimiento de Usuario","2023-11-10 18:01:09");
INSERT INTO tbl_ms_bitacora VALUES("252","1","3","Ingreso","Ingreso al Mantenimiento de Usuario","2023-11-10 18:01:14");
INSERT INTO tbl_ms_bitacora VALUES("253","1","3","Ingreso","Ingreso al Mantenimiento de Usuario","2023-11-10 18:01:27");
INSERT INTO tbl_ms_bitacora VALUES("254","1","3","Ingreso","Ingreso al Mantenimiento de Usuario","2023-11-10 18:01:31");
INSERT INTO tbl_ms_bitacora VALUES("255","1","3","Ingreso","Ingreso al Mantenimiento de Usuario","2023-11-10 18:01:42");
INSERT INTO tbl_ms_bitacora VALUES("256","1","3","Ingreso","Ingreso al Mantenimiento de Usuario","2023-11-10 18:03:06");
INSERT INTO tbl_ms_bitacora VALUES("257","1","3","Ingreso","Ingreso al Mantenimiento de Usuario","2023-11-10 18:03:20");
INSERT INTO tbl_ms_bitacora VALUES("258","1","3","Ingreso","Ingreso al Mantenimiento de Usuario","2023-11-10 18:04:01");
INSERT INTO tbl_ms_bitacora VALUES("259","1","3","Ingreso","Ingreso al Mantenimiento de Usuario","2023-11-10 18:04:12");
INSERT INTO tbl_ms_bitacora VALUES("260","1","3","Ingreso","Ingreso al Mantenimiento de Usuario","2023-11-10 18:04:13");
INSERT INTO tbl_ms_bitacora VALUES("261","1","3","Ingreso","Ingreso al Mantenimiento de Usuario","2023-11-10 18:04:26");
INSERT INTO tbl_ms_bitacora VALUES("262","1","3","Ingreso","Ingreso al Mantenimiento de Usuario","2023-11-10 18:04:49");
INSERT INTO tbl_ms_bitacora VALUES("263","1","3","Ingreso","Ingreso al Mantenimiento de Usuario","2023-11-10 18:04:49");
INSERT INTO tbl_ms_bitacora VALUES("264","1","3","Ingreso","Ingreso al Mantenimiento de Usuario","2023-11-10 18:05:07");
INSERT INTO tbl_ms_bitacora VALUES("265","1","3","Ingreso","Ingreso al Mantenimiento de Usuario","2023-11-10 18:06:26");
INSERT INTO tbl_ms_bitacora VALUES("266","1","3","Ingreso","Ingreso al Mantenimiento de Usuario","2023-11-10 18:06:32");
INSERT INTO tbl_ms_bitacora VALUES("267","1","3","Ingreso","Ingreso al Mantenimiento de Usuario","2023-11-10 18:06:41");
INSERT INTO tbl_ms_bitacora VALUES("268","1","3","Ingreso","Ingreso al Mantenimiento de Usuario","2023-11-10 18:06:52");
INSERT INTO tbl_ms_bitacora VALUES("269","1","3","Ingreso","Ingreso al Mantenimiento de Usuario","2023-11-10 18:07:13");
INSERT INTO tbl_ms_bitacora VALUES("270","1","3","Ingreso","Ingreso al Mantenimiento de Usuario","2023-11-10 18:07:52");
INSERT INTO tbl_ms_bitacora VALUES("271","1","3","Ingreso","Ingreso al Mantenimiento de Usuario","2023-11-10 18:08:09");
INSERT INTO tbl_ms_bitacora VALUES("272","1","3","Ingreso","Ingreso al Mantenimiento de Usuario","2023-11-10 18:10:05");
INSERT INTO tbl_ms_bitacora VALUES("273","1","3","Ingreso","Ingreso al Mantenimiento de Usuario","2023-11-10 18:10:07");
INSERT INTO tbl_ms_bitacora VALUES("274","1","3","Ingreso","Ingreso al Mantenimiento de Usuario","2023-11-10 18:10:25");
INSERT INTO tbl_ms_bitacora VALUES("275","1","3","Ingreso","Ingreso al Mantenimiento de Usuario","2023-11-10 18:14:51");
INSERT INTO tbl_ms_bitacora VALUES("276","1","3","Ingreso","Ingreso al Mantenimiento de Usuario","2023-11-10 18:15:44");
INSERT INTO tbl_ms_bitacora VALUES("277","1","3","Ingreso","Ingreso al Mantenimiento de Usuario","2023-11-10 18:15:45");
INSERT INTO tbl_ms_bitacora VALUES("278","1","3","Ingreso","Ingreso al Mantenimiento de Usuario","2023-11-10 18:15:52");
INSERT INTO tbl_ms_bitacora VALUES("279","1","3","Ingreso","Ingreso al Mantenimiento de Usuario","2023-11-10 18:16:15");
INSERT INTO tbl_ms_bitacora VALUES("280","1","3","Ingreso","Ingreso al Mantenimiento de Usuario","2023-11-10 18:16:59");
INSERT INTO tbl_ms_bitacora VALUES("281","1","3","Ingreso","Ingreso al Mantenimiento de Usuario","2023-11-10 18:17:35");
INSERT INTO tbl_ms_bitacora VALUES("282","1","3","Ingreso","Ingreso al Mantenimiento de Usuario","2023-11-10 18:18:22");
INSERT INTO tbl_ms_bitacora VALUES("283","1","3","Ingreso","Ingreso al Mantenimiento de Usuario","2023-11-10 18:18:35");
INSERT INTO tbl_ms_bitacora VALUES("284","1","3","Ingreso","Ingreso al Mantenimiento de Usuario","2023-11-10 18:19:23");
INSERT INTO tbl_ms_bitacora VALUES("285","1","3","Ingreso","Ingreso al Mantenimiento de Usuario","2023-11-10 18:19:36");
INSERT INTO tbl_ms_bitacora VALUES("286","1","3","Ingreso","Ingreso al Mantenimiento de Usuario","2023-11-10 18:20:23");
INSERT INTO tbl_ms_bitacora VALUES("287","1","3","Ingreso","Ingreso al Mantenimiento de Usuario","2023-11-10 18:21:24");
INSERT INTO tbl_ms_bitacora VALUES("288","1","3","Ingreso","Ingreso al Mantenimiento de Usuario","2023-11-10 18:22:20");
INSERT INTO tbl_ms_bitacora VALUES("289","1","3","Ingreso","Ingreso al Mantenimiento de Usuario","2023-11-10 18:27:11");
INSERT INTO tbl_ms_bitacora VALUES("290","1","3","Ingreso","Ingreso al Mantenimiento de Usuario","2023-11-10 18:27:35");
INSERT INTO tbl_ms_bitacora VALUES("291","1","3","Ingreso","Ingreso al Mantenimiento de Usuario","2023-11-10 18:27:57");
INSERT INTO tbl_ms_bitacora VALUES("292","1","3","Ingreso","Ingreso al Mantenimiento de Usuario","2023-11-10 18:28:23");
INSERT INTO tbl_ms_bitacora VALUES("293","1","3","Ingreso","Ingreso al Mantenimiento de Usuario","2023-11-10 18:28:24");
INSERT INTO tbl_ms_bitacora VALUES("294","1","3","Ingreso","Ingreso al Mantenimiento de Usuario","2023-11-10 18:28:45");
INSERT INTO tbl_ms_bitacora VALUES("295","1","3","Ingreso","Ingreso al Mantenimiento de Usuario","2023-11-10 18:29:33");
INSERT INTO tbl_ms_bitacora VALUES("296","1","3","Ingreso","Ingreso al Mantenimiento de Usuario","2023-11-10 18:30:15");
INSERT INTO tbl_ms_bitacora VALUES("297","1","3","Ingreso","Ingreso al Mantenimiento de Usuario","2023-11-10 18:31:18");
INSERT INTO tbl_ms_bitacora VALUES("298","1","3","Ingreso","Ingreso al Mantenimiento de Usuario","2023-11-10 18:32:13");
INSERT INTO tbl_ms_bitacora VALUES("299","1","3","Ingreso","Ingreso al Mantenimiento de Usuario","2023-11-10 18:33:39");
INSERT INTO tbl_ms_bitacora VALUES("300","1","3","Ingreso","Ingreso al Mantenimiento de Usuario","2023-11-10 18:33:47");
INSERT INTO tbl_ms_bitacora VALUES("301","1","3","Ingreso","Ingreso al Mantenimiento de Usuario","2023-11-10 18:34:45");
INSERT INTO tbl_ms_bitacora VALUES("302","1","3","Ingreso","Ingreso al Mantenimiento de Usuario","2023-11-10 18:35:01");
INSERT INTO tbl_ms_bitacora VALUES("303","1","3","Ingreso","Ingreso al Mantenimiento de Usuario","2023-11-10 18:35:22");
INSERT INTO tbl_ms_bitacora VALUES("304","1","3","Ingreso","Ingreso al Mantenimiento de Usuario","2023-11-10 18:36:06");
INSERT INTO tbl_ms_bitacora VALUES("305","1","3","Ingreso","Ingreso al Mantenimiento de Usuario","2023-11-10 18:36:37");
INSERT INTO tbl_ms_bitacora VALUES("306","1","3","Ingreso","Ingreso al Mantenimiento de Usuario","2023-11-10 18:37:21");
INSERT INTO tbl_ms_bitacora VALUES("307","1","3","Ingreso","Ingreso al Mantenimiento de Usuario","2023-11-10 18:37:46");
INSERT INTO tbl_ms_bitacora VALUES("308","1","3","Ingreso","Ingreso al Mantenimiento de Usuario","2023-11-10 18:39:29");
INSERT INTO tbl_ms_bitacora VALUES("309","1","3","Ingreso","Ingreso al Mantenimiento de Usuario","2023-11-10 18:39:31");
INSERT INTO tbl_ms_bitacora VALUES("310","1","3","Ingreso","Ingreso al Mantenimiento de Usuario","2023-11-10 18:39:37");
INSERT INTO tbl_ms_bitacora VALUES("311","1","3","Ingreso","Ingreso al Mantenimiento de Usuario","2023-11-10 18:40:23");
INSERT INTO tbl_ms_bitacora VALUES("312","1","3","Ingreso","Ingreso al Mantenimiento de Usuario","2023-11-10 18:40:26");
INSERT INTO tbl_ms_bitacora VALUES("313","1","3","Ingreso","Ingreso al Mantenimiento de Usuario","2023-11-10 18:40:29");
INSERT INTO tbl_ms_bitacora VALUES("314","1","3","Ingreso","Ingreso al Mantenimiento de Usuario","2023-11-10 18:40:45");
INSERT INTO tbl_ms_bitacora VALUES("315","1","3","Ingreso","Ingreso al Mantenimiento de Usuario","2023-11-10 18:44:12");
INSERT INTO tbl_ms_bitacora VALUES("316","1","3","Ingreso","Ingreso al Mantenimiento de Usuario","2023-11-10 18:44:26");
INSERT INTO tbl_ms_bitacora VALUES("317","1","3","Ingreso","Ingreso al Mantenimiento de Usuario","2023-11-10 18:45:00");
INSERT INTO tbl_ms_bitacora VALUES("318","1","3","Ingreso","Ingreso al Mantenimiento de Usuario","2023-11-10 18:45:27");
INSERT INTO tbl_ms_bitacora VALUES("319","1","3","Ingreso","Ingreso al Mantenimiento de Usuario","2023-11-10 18:45:35");
INSERT INTO tbl_ms_bitacora VALUES("320","1","3","Ingreso","Ingreso al Mantenimiento de Usuario","2023-11-10 18:46:58");
INSERT INTO tbl_ms_bitacora VALUES("321","1","3","Ingreso","Ingreso al Mantenimiento de Usuario","2023-11-10 18:47:37");
INSERT INTO tbl_ms_bitacora VALUES("322","1","3","Ingreso","Ingreso al Mantenimiento de Usuario","2023-11-10 18:48:33");
INSERT INTO tbl_ms_bitacora VALUES("323","1","3","Ingreso","Ingreso al Mantenimiento de Usuario","2023-11-10 18:48:36");
INSERT INTO tbl_ms_bitacora VALUES("324","1","3","Ingreso","Ingreso al Mantenimiento de Usuario","2023-11-10 18:48:49");
INSERT INTO tbl_ms_bitacora VALUES("325","1","3","Ingreso","Ingreso al Mantenimiento de Usuario","2023-11-10 18:49:26");
INSERT INTO tbl_ms_bitacora VALUES("326","1","3","Ingreso","Ingreso al Mantenimiento de Usuario","2023-11-10 18:49:46");
INSERT INTO tbl_ms_bitacora VALUES("327","1","3","Ingreso","Ingreso al Mantenimiento de Usuario","2023-11-10 18:52:54");
INSERT INTO tbl_ms_bitacora VALUES("328","1","3","Ingreso","Ingreso al Mantenimiento de Usuario","2023-11-10 18:53:30");
INSERT INTO tbl_ms_bitacora VALUES("329","1","3","Ingreso","Ingreso al Mantenimiento de Usuario","2023-11-10 18:53:39");
INSERT INTO tbl_ms_bitacora VALUES("330","1","3","Ingreso","Ingreso al Mantenimiento de Usuario","2023-11-10 18:53:51");
INSERT INTO tbl_ms_bitacora VALUES("331","1","3","Ingreso","Ingreso al Mantenimiento de Usuario","2023-11-10 18:54:18");
INSERT INTO tbl_ms_bitacora VALUES("332","1","4","Ingreso","Ingreso al Home Principal del Sistema","2023-11-10 18:54:19");
INSERT INTO tbl_ms_bitacora VALUES("333","1","3","Ingreso","Ingreso al Mantenimiento de Usuario","2023-11-10 19:06:23");
INSERT INTO tbl_ms_bitacora VALUES("334","1","4","Ingreso","Ingreso al Home Principal del Sistema","2023-11-10 19:06:26");
INSERT INTO tbl_ms_bitacora VALUES("335","1","4","Ingreso","Ingreso al Home Principal del Sistema","2023-11-10 19:10:35");
INSERT INTO tbl_ms_bitacora VALUES("336","1","4","Ingreso","Ingreso al Home Principal del Sistema","2023-11-10 19:11:02");
INSERT INTO tbl_ms_bitacora VALUES("337","1","4","Ingreso","Ingreso al Home Principal del Sistema","2023-11-10 19:11:07");
INSERT INTO tbl_ms_bitacora VALUES("338","1","3","Ingreso","Ingreso al Mantenimiento de Usuario","2023-11-10 19:11:22");
INSERT INTO tbl_ms_bitacora VALUES("339","1","4","Ingreso","Ingreso al Home Principal del Sistema","2023-11-10 19:11:24");
INSERT INTO tbl_ms_bitacora VALUES("340","1","4","Ingreso","Ingreso al Home Principal del Sistema","2023-11-10 19:11:28");
INSERT INTO tbl_ms_bitacora VALUES("341","1","4","Ingreso","Ingreso al Home Principal del Sistema","2023-11-10 19:11:47");
INSERT INTO tbl_ms_bitacora VALUES("342","1","4","Ingreso","Ingreso al Home Principal del Sistema","2023-11-10 19:12:44");
INSERT INTO tbl_ms_bitacora VALUES("343","1","4","Ingreso","Ingreso al Home Principal del Sistema","2023-11-10 19:12:48");
INSERT INTO tbl_ms_bitacora VALUES("344","1","4","Ingreso","Ingreso al Home Principal del Sistema","2023-11-10 19:14:12");
INSERT INTO tbl_ms_bitacora VALUES("345","1","4","Ingreso","Ingreso al Home Principal del Sistema","2023-11-10 19:22:33");
INSERT INTO tbl_ms_bitacora VALUES("346","1","4","Ingreso","Ingreso al Home Principal del Sistema","2023-11-10 19:24:24");
INSERT INTO tbl_ms_bitacora VALUES("347","1","4","Ingreso","Ingreso al Home Principal del Sistema","2023-11-10 19:32:26");
INSERT INTO tbl_ms_bitacora VALUES("348","1","4","Ingreso","Ingreso al Home Principal del Sistema","2023-11-10 19:36:20");
INSERT INTO tbl_ms_bitacora VALUES("349","1","4","Ingreso","Ingreso al Home Principal del Sistema","2023-11-10 19:48:24");
INSERT INTO tbl_ms_bitacora VALUES("350","1","4","Ingreso","Ingreso al Home Principal del Sistema","2023-11-10 19:53:44");
INSERT INTO tbl_ms_bitacora VALUES("351","1","4","Ingreso","Ingreso al Home Principal del Sistema","2023-11-10 19:57:36");
INSERT INTO tbl_ms_bitacora VALUES("352","1","4","Ingreso","Ingreso al Home Principal del Sistema","2023-11-10 20:00:31");
INSERT INTO tbl_ms_bitacora VALUES("353","1","4","Ingreso","Ingreso al Home Principal del Sistema","2023-11-10 20:03:37");
INSERT INTO tbl_ms_bitacora VALUES("354","1","4","Ingreso","Ingreso al Home Principal del Sistema","2023-11-10 20:05:57");
INSERT INTO tbl_ms_bitacora VALUES("355","1","1","Ingreso","Ingreso al Sistema","2023-11-27 12:59:44");
INSERT INTO tbl_ms_bitacora VALUES("356","1","4","Ingreso","Ingreso al Home Principal del Sistema","2023-11-27 12:59:44");
INSERT INTO tbl_ms_bitacora VALUES("357","1","1","Ingreso","Ingreso al Sistema","2023-11-27 13:11:00");
INSERT INTO tbl_ms_bitacora VALUES("358","1","4","Ingreso","Ingreso al Home Principal del Sistema","2023-11-27 13:11:00");
INSERT INTO tbl_ms_bitacora VALUES("359","1","4","Ingreso","Ingreso al Home Principal del Sistema","2023-11-27 13:11:36");
INSERT INTO tbl_ms_bitacora VALUES("360","1","4","Ingreso","Ingreso al Home Principal del Sistema","2023-11-27 13:17:25");
INSERT INTO tbl_ms_bitacora VALUES("361","1","3","Ingreso","Ingreso al Mantenimiento de Usuario","2023-11-27 13:18:15");
INSERT INTO tbl_ms_bitacora VALUES("362","1","4","Ingreso","Ingreso al Home Principal del Sistema","2023-11-27 13:18:17");
INSERT INTO tbl_ms_bitacora VALUES("363","1","4","Ingreso","Ingreso al Home Principal del Sistema","2023-11-27 13:29:03");
INSERT INTO tbl_ms_bitacora VALUES("364","1","4","Ingreso","Ingreso al Home Principal del Sistema","2023-11-27 13:29:19");
INSERT INTO tbl_ms_bitacora VALUES("365","1","4","Ingreso","Ingreso al Home Principal del Sistema","2023-11-27 13:35:59");
INSERT INTO tbl_ms_bitacora VALUES("366","1","4","Ingreso","Ingreso al Home Principal del Sistema","2023-11-27 13:37:16");
INSERT INTO tbl_ms_bitacora VALUES("367","1","4","Ingreso","Ingreso al Home Principal del Sistema","2023-11-27 13:41:32");
INSERT INTO tbl_ms_bitacora VALUES("368","1","4","Ingreso","Ingreso al Home Principal del Sistema","2023-11-27 13:45:45");
INSERT INTO tbl_ms_bitacora VALUES("369","1","4","Ingreso","Ingreso al Home Principal del Sistema","2023-11-27 13:50:51");
INSERT INTO tbl_ms_bitacora VALUES("370","1","4","Ingreso","Ingreso al Home Principal del Sistema","2023-11-27 13:55:18");
INSERT INTO tbl_ms_bitacora VALUES("371","1","4","Ingreso","Ingreso al Home Principal del Sistema","2023-11-27 14:00:16");
INSERT INTO tbl_ms_bitacora VALUES("372","1","4","Ingreso","Ingreso al Home Principal del Sistema","2023-11-27 14:05:55");
INSERT INTO tbl_ms_bitacora VALUES("373","1","4","Ingreso","Ingreso al Home Principal del Sistema","2023-11-27 14:08:13");
INSERT INTO tbl_ms_bitacora VALUES("374","1","4","Ingreso","Ingreso al Home Principal del Sistema","2023-11-27 14:09:07");
INSERT INTO tbl_ms_bitacora VALUES("375","1","4","Ingreso","Ingreso al Home Principal del Sistema","2023-11-27 14:09:14");
INSERT INTO tbl_ms_bitacora VALUES("376","1","4","Ingreso","Ingreso al Home Principal del Sistema","2023-11-27 14:12:28");
INSERT INTO tbl_ms_bitacora VALUES("377","1","4","Ingreso","Ingreso al Home Principal del Sistema","2023-11-27 20:28:55");
INSERT INTO tbl_ms_bitacora VALUES("378","1","1","Ingreso","Ingreso al Sistema","2023-11-27 20:32:00");
INSERT INTO tbl_ms_bitacora VALUES("379","1","4","Ingreso","Ingreso al Home Principal del Sistema","2023-11-27 20:32:01");
INSERT INTO tbl_ms_bitacora VALUES("380","1","4","Ingreso","Ingreso al Home Principal del Sistema","2023-11-27 20:37:59");
INSERT INTO tbl_ms_bitacora VALUES("381","1","1","Ingreso","Ingreso al Sistema","2023-11-29 15:16:58");
INSERT INTO tbl_ms_bitacora VALUES("382","1","4","Ingreso","Ingreso al Home Principal del Sistema","2023-11-29 15:16:58");
INSERT INTO tbl_ms_bitacora VALUES("383","1","4","Ingreso","Ingreso al Home Principal del Sistema","2023-11-29 15:17:02");
INSERT INTO tbl_ms_bitacora VALUES("384","1","1","Ingreso","Ingreso al Sistema","2023-11-29 15:19:01");
INSERT INTO tbl_ms_bitacora VALUES("385","1","4","Ingreso","Ingreso al Home Principal del Sistema","2023-11-29 15:19:01");
INSERT INTO tbl_ms_bitacora VALUES("386","1","4","Ingreso","Ingreso al Home Principal del Sistema","2023-11-29 15:22:11");
INSERT INTO tbl_ms_bitacora VALUES("387","1","4","Ingreso","Ingreso al Home Principal del Sistema","2023-11-29 19:01:23");
INSERT INTO tbl_ms_bitacora VALUES("388","1","1","Ingreso","Ingreso al Sistema","2023-11-29 19:03:53");
INSERT INTO tbl_ms_bitacora VALUES("389","1","4","Ingreso","Ingreso al Home Principal del Sistema","2023-11-29 19:03:53");
INSERT INTO tbl_ms_bitacora VALUES("390","1","4","Ingreso","Ingreso al Home Principal del Sistema","2023-11-29 21:13:46");
INSERT INTO tbl_ms_bitacora VALUES("391","1","4","Ingreso","Ingreso al Home Principal del Sistema","2023-11-29 21:23:28");
INSERT INTO tbl_ms_bitacora VALUES("392","1","4","Ingreso","Ingreso al Home Principal del Sistema","2023-11-29 21:24:16");
INSERT INTO tbl_ms_bitacora VALUES("393","1","4","Ingreso","Ingreso al Home Principal del Sistema","2023-11-29 21:25:17");
INSERT INTO tbl_ms_bitacora VALUES("394","1","1","Ingreso","Ingreso al Sistema","2023-11-30 20:01:23");
INSERT INTO tbl_ms_bitacora VALUES("395","1","4","Ingreso","Ingreso al Home Principal del Sistema","2023-11-30 20:01:23");
INSERT INTO tbl_ms_bitacora VALUES("396","1","1","Ingreso","Ingreso al Sistema","2023-11-30 20:13:14");
INSERT INTO tbl_ms_bitacora VALUES("397","1","4","Ingreso","Ingreso al Home Principal del Sistema","2023-11-30 20:13:14");
INSERT INTO tbl_ms_bitacora VALUES("398","1","1","Ingreso","Ingreso al Sistema","2023-12-04 00:16:46");
INSERT INTO tbl_ms_bitacora VALUES("399","1","4","Ingreso","Ingreso al Home Principal del Sistema","2023-12-04 00:16:46");
INSERT INTO tbl_ms_bitacora VALUES("400","1","1","Salio","Salio del Sistema","2023-12-04 22:36:08");
INSERT INTO tbl_ms_bitacora VALUES("401","1","1","Ingreso","Ingreso al Sistema","2023-12-04 22:36:14");
INSERT INTO tbl_ms_bitacora VALUES("402","1","4","Ingreso","Ingreso al Home Principal del Sistema","2023-12-04 22:36:14");
INSERT INTO tbl_ms_bitacora VALUES("403","1","1","Ingreso","Ingreso al Sistema","2023-12-04 23:08:31");
INSERT INTO tbl_ms_bitacora VALUES("404","1","4","Ingreso","Ingreso al Home Principal del Sistema","2023-12-04 23:08:31");
INSERT INTO tbl_ms_bitacora VALUES("405","1","1","Ingreso","Ingreso al Sistema","2024-01-26 12:41:28");
INSERT INTO tbl_ms_bitacora VALUES("406","1","4","Ingreso","Ingreso al Home Principal del Sistema","2024-01-26 12:41:28");
INSERT INTO tbl_ms_bitacora VALUES("407","1","4","Ingreso","Ingreso al Home Principal del Sistema","2024-01-26 13:15:28");
INSERT INTO tbl_ms_bitacora VALUES("408","1","4","Ingreso","Ingreso al Home Principal del Sistema","2024-01-26 13:26:53");
INSERT INTO tbl_ms_bitacora VALUES("409","1","4","Ingreso","Ingreso al Home Principal del Sistema","2024-01-26 13:44:00");
INSERT INTO tbl_ms_bitacora VALUES("410","1","1","Ingreso","Ingreso al Sistema","2024-01-26 13:58:42");
INSERT INTO tbl_ms_bitacora VALUES("411","1","4","Ingreso","Ingreso al Home Principal del Sistema","2024-01-26 13:58:42");



DROP TABLE IF EXISTS tbl_ms_estado_usuario;

CREATE TABLE `tbl_ms_estado_usuario` (
  `idEstadoUsuario` int(11) NOT NULL AUTO_INCREMENT,
  `Descripcion` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`idEstadoUsuario`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_ms_estado_usuario VALUES("1","Nuevo");
INSERT INTO tbl_ms_estado_usuario VALUES("2","Activo");
INSERT INTO tbl_ms_estado_usuario VALUES("3","Bloqueado");
INSERT INTO tbl_ms_estado_usuario VALUES("4","Inactivo");



DROP TABLE IF EXISTS tbl_ms_hist_contrasenna;

CREATE TABLE `tbl_ms_hist_contrasenna` (
  `idHist` int(11) NOT NULL AUTO_INCREMENT,
  `idUsuario` int(11) NOT NULL,
  `Contrasenna` text NOT NULL,
  `CreadoPor` varchar(15) DEFAULT NULL,
  `FechaCreacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `ModificadoPor` varchar(15) DEFAULT NULL,
  `FechaModificacion` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`idHist`),
  KEY `id_usuario_f_keyss` (`idUsuario`),
  CONSTRAINT `id_usuario_f_keyss` FOREIGN KEY (`idUsuario`) REFERENCES `tbl_ms_usuario` (`idUsuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;




DROP TABLE IF EXISTS tbl_ms_objetos;

CREATE TABLE `tbl_ms_objetos` (
  `idObjetos` int(11) NOT NULL AUTO_INCREMENT,
  `Objeto` varchar(100) DEFAULT NULL,
  `Descripcion` varchar(100) DEFAULT NULL,
  `TipoObjeto` varchar(15) DEFAULT NULL,
  `CreadoPor` varchar(15) DEFAULT NULL,
  `FechaCreacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `ModificadoPor` varchar(15) DEFAULT NULL,
  `FechaModificacion` date DEFAULT NULL,
  `esModulo` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idObjetos`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_ms_objetos VALUES("1","LOGIN","PANTALLA DE LOGIN ","PANTALLA","ADMIN","2023-07-04 15:36:18","","","");
INSERT INTO tbl_ms_objetos VALUES("2","AUTOREGISTRO USUARIO","PANTALLA DE AUTOREGISTRO DE USUARIO","PANTALLA","ADMIN","2023-07-05 10:19:23","","","1");
INSERT INTO tbl_ms_objetos VALUES("3","MANTENIMIENTO USUARIO","PANTALLA DE MANTENIMIENTO DE USUARIO","PANTALLA","ADMIN","2023-07-05 10:19:23","","","1");
INSERT INTO tbl_ms_objetos VALUES("4","HOME","PANTALLA HOME PRINCIPAL","PANTALLA","ADMIN","2023-07-05 15:08:01","","","1");
INSERT INTO tbl_ms_objetos VALUES("5","RECUPERACION DE CLAVE","PANTALLA DE RECUPERACION DE CLAVE","PANTALLA","ADMIN","2023-07-13 11:28:04","","","");
INSERT INTO tbl_ms_objetos VALUES("6","SOLICITUDES","PANTALLA DE SOLICITUDES","PANTALLA","ADMIN","2023-11-10 16:29:28","","","1");
INSERT INTO tbl_ms_objetos VALUES("7","CLIENTES","PANTALLA DE CLIENTES","PANTALLA","ADMIN","2023-11-10 16:29:28","","","1");
INSERT INTO tbl_ms_objetos VALUES("8","COBRO","PANTALLA DE COBROS","PANTALLA","ADMIN","2023-11-10 16:29:28","","","1");
INSERT INTO tbl_ms_objetos VALUES("9","ROLES","PANTALLA DE ROLES","PANTALLA","ADMIN","2023-11-10 16:29:28","","","1");
INSERT INTO tbl_ms_objetos VALUES("10","TIPO PRESTAMO","PANTALLA DE TIPO DE PRESTAMO","PANTALLA","ADMIN","2023-11-10 16:29:28","","","1");
INSERT INTO tbl_ms_objetos VALUES("11","ESTADO CIVIL","PANTALLA DE ESTADO CIVIL","PANTALLA","ADMIN","2023-11-10 16:29:28","","","1");
INSERT INTO tbl_ms_objetos VALUES("12","CATEGORIA CASA","PANTALLA DE CATEGORIA CASA","PANTALLA","ADMIN","2023-11-10 16:29:28","","","1");
INSERT INTO tbl_ms_objetos VALUES("13","PARENTESCO","PANTALLA DE PARENTESCO","PANTALLA","ADMIN","2023-11-10 16:29:28","","","1");
INSERT INTO tbl_ms_objetos VALUES("14","GENERO","PANTALLA DE GENERO","PANTALLA","ADMIN","2023-11-27 19:03:25","","","1");
INSERT INTO tbl_ms_objetos VALUES("15","TIPO CONTACTO","PANTALLA DE TIPO DE CONTACTO","PANTALLA","ADMIN","2023-11-27 19:35:15","","","1");
INSERT INTO tbl_ms_objetos VALUES("16","NACIONALIDAD","PANTALLA DE NACIONALIDAD","PANTALLA","ADMIN","2023-11-27 19:38:51","","","1");
INSERT INTO tbl_ms_objetos VALUES("17","PERSONAS BIENES","PANTALLA DE PERSONAS BIENES","PANTALLA","ADMIN","2023-11-27 19:43:09","","","1");
INSERT INTO tbl_ms_objetos VALUES("18","TIEMPO LABORAL","PANTALLA DE TIEMPO LABORAL","PANTALLA","ADMIN","2023-11-27 19:48:04","","","1");
INSERT INTO tbl_ms_objetos VALUES("19","ESTADO PLAN PAGO","PANTALLA ESTADO PLAN PAGO","PANTALLA","ADMIN","2023-11-27 19:52:57","","","1");
INSERT INTO tbl_ms_objetos VALUES("20","TIEMPO VIVIR","PANTALLA TIEMPO VIVIR","PANTALLA","ADMIN","2023-11-27 19:57:57","","","1");
INSERT INTO tbl_ms_objetos VALUES("21","ESTADO TIPO PRESTAMO","PANTALLA ESTADO TIPO PRESTAMO","PANTALLA","ADMIN","2023-11-27 20:01:30","","","1");
INSERT INTO tbl_ms_objetos VALUES("22","ESTADO SOLICITUDES","PANTALLA ESTADO SOLICITUDES","PANTALLA","ADMIN","2023-11-27 20:07:14","","","1");
INSERT INTO tbl_ms_objetos VALUES("23","RUBROS","PANTALLA RUBROS","PANTALLA","ADMIN","2023-11-27 20:10:24","","","1");
INSERT INTO tbl_ms_objetos VALUES("24","PROFESION U OFICIO","PANTALLA PROFESION U OFICIO","PANTALLA","ADMIN","2023-11-28 23:15:24","","","1");
INSERT INTO tbl_ms_objetos VALUES("25","PRESTAMOS","PANTALLA PRESTAMOS","PANTALLA","ADMIN","2023-11-28 23:41:24","","","1");
INSERT INTO tbl_ms_objetos VALUES("26","ESTADO USUARIO","PANTALLA ESTADO USUARIO","PANTALLA","ADMIN","2023-11-28 23:50:24","","","1");
INSERT INTO tbl_ms_objetos VALUES("27","MUNICIPIO","PANTALLA MUNICIPIO","PANTALLA","ADMIN","2023-11-28 23:51:24","","","1");
INSERT INTO tbl_ms_objetos VALUES("28","PERMISOS","PANTALLA PERMISOS","PANTALLA","ADMIN","2023-11-29 00:02:24","","","1");



DROP TABLE IF EXISTS tbl_ms_parametros;

CREATE TABLE `tbl_ms_parametros` (
  `idParametro` int(11) NOT NULL AUTO_INCREMENT,
  `Parametro` varchar(50) NOT NULL,
  `Valor` varchar(100) NOT NULL,
  `idUsuario` int(11) DEFAULT NULL,
  `FechaCreacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `FechaModificacion` date DEFAULT NULL,
  PRIMARY KEY (`idParametro`),
  KEY `idUsuario_fk` (`idUsuario`),
  CONSTRAINT `idUsuario_fk` FOREIGN KEY (`idUsuario`) REFERENCES `tbl_ms_usuario` (`idUsuario`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_ms_parametros VALUES("1","INTENTOS DE INICIO DE SESION","3","1","2023-07-24 14:37:32","2023-10-20");
INSERT INTO tbl_ms_parametros VALUES("2","CANTIDAD DE PREGUNTAS","2","1","2023-07-24 14:37:56","");
INSERT INTO tbl_ms_parametros VALUES("3","TAMAÑO MINIMO DE CLAVE","5","1","2023-07-24 14:38:22","");
INSERT INTO tbl_ms_parametros VALUES("4","TAMAÑO MAXIMO DE CLAVE","12","1","2023-07-24 14:39:37","");
INSERT INTO tbl_ms_parametros VALUES("5","DIAS DE VIGENCIA DE USUARIOS","91","1","2023-07-24 14:40:05","");
INSERT INTO tbl_ms_parametros VALUES("6","VIGENCIA DE RECUPERACION","24","1","2023-07-24 14:40:20","");



DROP TABLE IF EXISTS tbl_ms_permisos;

CREATE TABLE `tbl_ms_permisos` (
  `idPermiso` int(11) NOT NULL AUTO_INCREMENT,
  `idRol` int(11) NOT NULL,
  `idObjeto` int(11) NOT NULL,
  `insertar` int(11) NOT NULL DEFAULT 0,
  `eliminar` int(11) NOT NULL DEFAULT 0,
  `consultar` int(11) NOT NULL DEFAULT 0,
  `actualizar` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`idPermiso`),
  UNIQUE KEY `unique_index` (`idRol`,`idObjeto`),
  KEY `f_k_id_rol` (`idRol`),
  KEY `foreing_keyy_idObjeto` (`idObjeto`)
) ENGINE=InnoDB AUTO_INCREMENT=148 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_ms_permisos VALUES("52","4","3","1","1","1","1");
INSERT INTO tbl_ms_permisos VALUES("84","5","5","1","1","1","1");
INSERT INTO tbl_ms_permisos VALUES("94","4","2","1","1","1","1");
INSERT INTO tbl_ms_permisos VALUES("97","4","1","1","1","1","1");
INSERT INTO tbl_ms_permisos VALUES("123","2","3","1","-1","-1","1");
INSERT INTO tbl_ms_permisos VALUES("124","2","6","1","1","1","1");
INSERT INTO tbl_ms_permisos VALUES("125","2","7","1","1","1","1");
INSERT INTO tbl_ms_permisos VALUES("126","2","8","1","1","1","1");
INSERT INTO tbl_ms_permisos VALUES("127","2","9","-1","-1","1","1");
INSERT INTO tbl_ms_permisos VALUES("128","2","10","-1","-1","1","-1");
INSERT INTO tbl_ms_permisos VALUES("129","2","11","-1","1","-1","-1");
INSERT INTO tbl_ms_permisos VALUES("130","2","12","1","-1","1","-1");
INSERT INTO tbl_ms_permisos VALUES("133","2","13","1","1","1","1");
INSERT INTO tbl_ms_permisos VALUES("134","2","14","1","1","1","1");
INSERT INTO tbl_ms_permisos VALUES("135","2","15","1","1","1","1");
INSERT INTO tbl_ms_permisos VALUES("136","2","16","1","1","1","1");
INSERT INTO tbl_ms_permisos VALUES("138","2","17","1","1","1","1");
INSERT INTO tbl_ms_permisos VALUES("139","2","18","1","1","1","1");
INSERT INTO tbl_ms_permisos VALUES("140","2","19","1","1","1","1");
INSERT INTO tbl_ms_permisos VALUES("141","2","20","1","1","1","1");
INSERT INTO tbl_ms_permisos VALUES("142","2","21","1","1","1","1");
INSERT INTO tbl_ms_permisos VALUES("143","2","22","1","1","1","1");
INSERT INTO tbl_ms_permisos VALUES("144","2","23","1","1","1","1");
INSERT INTO tbl_ms_permisos VALUES("145","2","24","1","1","1","1");
INSERT INTO tbl_ms_permisos VALUES("146","2","26","1","1","1","1");
INSERT INTO tbl_ms_permisos VALUES("147","2","25","1","1","1","1");



DROP TABLE IF EXISTS tbl_ms_preguntas;

CREATE TABLE `tbl_ms_preguntas` (
  `idPregunta` int(11) NOT NULL AUTO_INCREMENT,
  `Pregunta` varchar(100) NOT NULL,
  `estadoPregunta` int(11) DEFAULT NULL,
  `CreadoPor` varchar(15) DEFAULT NULL,
  `FechaCreacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `ModificadoPor` varchar(15) DEFAULT NULL,
  `FechaModificacion` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`idPregunta`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_ms_preguntas VALUES("1","¿NOMBRE DE TU PRIMERA MASCOTA? 1","1","","2023-06-29 08:27:06","","2023-06-29 08:27:06");
INSERT INTO tbl_ms_preguntas VALUES("2","¿En que ciudad naciste?","1","","2023-06-29 08:27:06","","2023-06-29 08:27:06");
INSERT INTO tbl_ms_preguntas VALUES("3","¿Quién es tu mejor amigo(a)?","1","","2023-06-29 08:27:06","","2023-06-29 08:27:06");
INSERT INTO tbl_ms_preguntas VALUES("4","¿CUÁL ES SU COMIDA FAVORITA?","1","","2023-06-29 08:27:06","","2023-06-29 08:27:06");
INSERT INTO tbl_ms_preguntas VALUES("5","¿En qué ciudad nació su madre?","1","","2023-06-29 08:27:06","","2023-06-29 08:27:06");
INSERT INTO tbl_ms_preguntas VALUES("6","¿En qué ciudad nació su padre?","1","","2023-06-29 08:27:06","","2023-06-29 08:27:06");
INSERT INTO tbl_ms_preguntas VALUES("7","H","","","2023-08-15 16:22:48","","2023-08-15 16:22:48");
INSERT INTO tbl_ms_preguntas VALUES("8","A","","","2023-08-15 16:37:25","","2023-08-15 16:37:25");
INSERT INTO tbl_ms_preguntas VALUES("9","PRUEBA","","","2023-10-19 21:53:57","","2023-10-19 21:53:57");



DROP TABLE IF EXISTS tbl_ms_preguntas_usuario;

CREATE TABLE `tbl_ms_preguntas_usuario` (
  `idPregunta` int(11) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `Respuesta` varchar(100) NOT NULL,
  `CreadoPor` varchar(15) DEFAULT NULL,
  `FechaCreacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `ModificadoPor` varchar(15) DEFAULT NULL,
  `FechaModificacion` timestamp NOT NULL DEFAULT current_timestamp(),
  KEY `idPregunta_fk` (`idPregunta`),
  KEY `id_user_f_k` (`idUsuario`),
  CONSTRAINT `idPregunta_fk` FOREIGN KEY (`idPregunta`) REFERENCES `tbl_ms_preguntas` (`idPregunta`),
  CONSTRAINT `id_user_f_k` FOREIGN KEY (`idUsuario`) REFERENCES `tbl_ms_usuario` (`idUsuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_ms_preguntas_usuario VALUES("1","2","FERNANDO","FERNANDO","2023-07-18 23:09:51","","2023-07-18 23:09:51");
INSERT INTO tbl_ms_preguntas_usuario VALUES("2","2","TEGUCIGALPA","FERNANDO","2023-07-18 23:10:12","","2023-07-18 23:10:12");
INSERT INTO tbl_ms_preguntas_usuario VALUES("1","3","ROKI","PRUEBAREGISTRO","2023-07-18 23:19:31","","2023-07-18 23:19:31");
INSERT INTO tbl_ms_preguntas_usuario VALUES("2","3","TEGUCIGALPA","PRUEBAREGISTRO","2023-07-18 23:19:43","","2023-07-18 23:19:43");



DROP TABLE IF EXISTS tbl_ms_roles;

CREATE TABLE `tbl_ms_roles` (
  `idRol` int(11) NOT NULL AUTO_INCREMENT,
  `Rol` varchar(30) NOT NULL,
  `Descripcion` varchar(100) NOT NULL,
  `CreadoPor` varchar(15) NOT NULL,
  `FechaCreacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `ModificadoPor` varchar(15) DEFAULT NULL,
  `FechaModificacion` date DEFAULT NULL,
  PRIMARY KEY (`idRol`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_ms_roles VALUES("1","DEFAULT","rol cuando se crea un usuario desde el autoregistro","","2023-06-29 08:28:36","","");
INSERT INTO tbl_ms_roles VALUES("2","ADMINISTRADOR","Administrador del sistema","","2023-06-29 08:28:55","","");
INSERT INTO tbl_ms_roles VALUES("3","FACILITADOR TECNICO","procesos de solicitudes","","2023-07-03 09:46:01","","");



DROP TABLE IF EXISTS tbl_ms_usuario;

CREATE TABLE `tbl_ms_usuario` (
  `idUsuario` int(11) NOT NULL AUTO_INCREMENT,
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
  `CreadoPor` varchar(50) DEFAULT NULL,
  `FechaCreacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `ModificadoPor` varchar(15) DEFAULT NULL,
  `FechaModificacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `Intentos` int(11) DEFAULT 0,
  `token` text DEFAULT NULL,
  `fechaRecuperacion` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`idUsuario`),
  UNIQUE KEY `Usuario` (`Usuario`),
  KEY `idRol_fk` (`idRol`),
  KEY `id_estado_usuario_fk` (`idEstadoUsuario`),
  CONSTRAINT `idRol_fk` FOREIGN KEY (`idRol`) REFERENCES `tbl_ms_roles` (`idRol`),
  CONSTRAINT `id_estado_usuario_fk` FOREIGN KEY (`idEstadoUsuario`) REFERENCES `tbl_ms_estado_usuario` (`idEstadoUsuario`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_ms_usuario VALUES("1","2","ADMIN","ADMINISTRADOR","2","$2y$10$wSytLJucrv52iByen1RlE.Bsp1a0siWTNYTj/Ogr3CwZcaIl1dSCm","2023-07-18 23:00:26","","","2024-01-01","admin@gmail.com","ADMIN","2023-07-18 23:00:26","ADMIN","2023-07-19 00:00:00","0","","2023-07-18 23:00:26");
INSERT INTO tbl_ms_usuario VALUES("2","3","FERNANDO","FERNANDO MATAMOROS","2","$2y$10$xhM2.Ye632B9/jNW1wq5qe0F.nBcXADfyHKoVbnCy3XLNPWHG6WPW","2023-07-18 23:05:50","2","","2023-10-17","fernandomatamoros963@gmail.com","ADMIN","2023-07-18 23:05:50","ADMIN","2023-11-06 00:00:00","0","","2023-07-18 23:46:12");
INSERT INTO tbl_ms_usuario VALUES("3","1","PRUEBAREGISTRO","PRUEBA","2","$2y$10$4OfewvkF8Wlbcdag3tRqReIBo/YE0k9afyU1kAFxT/ImtraToxtkq","2023-07-18 23:18:39","2","","2023-10-17","prueba@gmail.com","PRUEBAREGISTRO","2023-07-18 23:18:39","ADMIN","2023-08-02 00:00:00","0","","2023-07-18 23:18:39");
INSERT INTO tbl_ms_usuario VALUES("4","1","INFORMATICA","INFORMATICA","1","$2y$10$Mrr5UfNyqABJu1.aAEyf1.oWbUPOzOVW19wfYyaDOrIEs7jg831TO","2023-11-06 13:54:51","","","2024-02-05","informatica@gmail.com","ADMIN","2023-11-06 13:54:51","","2023-11-06 13:54:51","0","","2023-11-06 13:54:51");



SET FOREIGN_KEY_CHECKS=1;