<?php

require_once("../config/Conexion.php");

class Solicitud {

    public $cnx; //variable publica para la conexion a la BD

    function __construct() //constructor
    {
        $this->cnx = Conexion::ConectarDB(); //conexion a la base de datos
    }
    
      //funcion para listar las solicitudes
    function ListarSolicitudes()
    {
        $query = "SELECT solicitud.idSolicitud, solicitud.idTipoPrestamo,
        CONCAT(persona.nombres, ' ', persona.apellidos) as Nombre, prestamo.Descripcion as Prestamo, estado.idEstadoSolicitud, 
        solicitud.idPersona as persona, CONCAT('L. ', solicitud.Monto) as Monto, CONCAT(solicitud.tasa, '%') as tasa, solicitud.Plazo, 
        estado.Descripcion as Estado, solicitud.fechaDesembolso, COUNT(aval.idSolicitud) as cantidadAval 
        FROM tbl_mn_solicitudes_creditos solicitud
        INNER JOIN tbl_mn_personas persona ON solicitud.idPersona = persona.idPersona
        INNER JOIN tbl_mn_estados_solicitudes estado ON solicitud.idEstadoSolicitud = estado.idEstadoSolicitud
        LEFT JOIN tbl_mn_avales aval ON solicitud.idSolicitud = aval.idSolicitud
        INNER JOIN tbl_mn_tipos_prestamos prestamo ON solicitud.idTipoPrestamo = prestamo.idTipoPrestamo
        GROUP BY solicitud.idSolicitud, persona.nombres, persona.apellidos, prestamo.Descripcion,
                estado.idEstadoSolicitud, solicitud.idPersona, solicitud.Monto, solicitud.tasa, solicitud.Plazo,
                estado.Descripcion, solicitud.fechaDesembolso ORDER BY solicitud.idSolicitud DESC"; //sentencia sql
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

    
    function listar_tipoPrestamo_select_edit($idSolicitud)
    {
        $query = "SELECT prestamo.idTipoPrestamo, prestamo.Descripcion FROM tbl_mn_solicitudes_creditos solicitud
                  INNER JOIN tbl_mn_tipos_prestamos prestamo ON solicitud.idTipoPrestamo = prestamo.idTipoPrestamo
                  WHERE solicitud.idSolicitud = ?
                  UNION SELECT idTipoPrestamo, Descripcion FROM tbl_mn_tipos_prestamos"; 
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


    //funcion para listar los generos
    function ListarGeneros()
    {
        $query = "SELECT * FROM tbl_mn_genero"; //sentencia sql
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

    //funcion para listar los tipos de prestamos
    function ListarTiposPrestamos()
    {
        $query = "SELECT * FROM tbl_mn_tipos_prestamos"; //sentencia sql
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

    //funcion para listar los tipos de rubros
    function ListarRubros()
    {
        $query = "SELECT * FROM tbl_mn_rubros"; //sentencia sql
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
   
    //funcion para listar los tipos de rubros
    function ListarNacionalidades()
    {
        $query = "SELECT * FROM tbl_mn_nacionalidades"; //sentencia sql
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

    //funcion para listar los tipos de rubros
    function ListarEstadosCiviles()
    {
        $query = "SELECT * FROM tbl_mn_estadocivil"; //sentencia sql
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

      //funcion para lista las categorias de casa
    function ListarCasa()
    {
        $query = "SELECT * FROM tbl_mn_categoria_casa"; //sentencia sql
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
 
    //funcion para lista las categorias de casa
    function ListarTiempoVivir()
    {
        $query = "SELECT * FROM tbl_mn_tiempo_vivir"; //sentencia sql
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

      //funcion para lista los tipos de pago de casa
    function ListarTipoPago()
    {
        $query = "SELECT * FROM tbl_mn_tipos_de_pago"; //sentencia sql
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

     //funcion para lista las categorias de casa
     function ListarTiempoLaboral()
     {
         $query = "SELECT * FROM tbl_mn_tiempo_laboral"; //sentencia sql
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

  //funcion para lista las categorias de casa
  function ListarProfesiones()
  {
      $query = "SELECT * FROM tbl_mn_profesiones_oficios"; //sentencia sql
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

  function ListarBienes()
  {
      $query = "SELECT * FROM tbl_mn_personas_bienes"; //sentencia sql
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

  function ListarTipoCliente()
  {
      $query = "SELECT * FROM tbl_mn_tipo_clientes"; //sentencia sql
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


  //funcion para listar los parentescos
  function ListarParentesco()
  {
      $query = "SELECT * FROM tbl_mn_parentesco"; //sentencia sql
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

  //funcion para listar los estadod e credito
  function ListarEstadoCredito()
  {
      $query = "SELECT * FROM tbl_mn_estado_credito"; //sentencia sql
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
  //funcion para listar los si la persona es aval
  function ListarSiEsAval()
  {
      $query = "SELECT * FROM tbl_mn_avala_a_persona"; //sentencia sql
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
  function ListarAvalMora()
  {
      $query = "SELECT * FROM tbl_mn_credito_aval"; //sentencia sql
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

   //funcion para listar los generos
   function ListarMunicipios()
   {
       $query = "SELECT * FROM tbl_mn_municipio"; //sentencia sql
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

/********************   CRUD     ********************************************/
//FUNCION PARA REGISTRAr UN solicitante

function RegistrarCliente($idTipoPersona, $idNacionalidad, $idGenero, $idEstadoCivil, $idProfesion, $bienes, $idTipoClientes, $idcategoriaCasa, $idtiempoVivir, $municipio,
                           $idTiempoLaboral, $nombres, $apellidos, $identidad, $fechaNacimiento, $PagaAlquiler, $patrono, $actividadDesempenia, $ObservacionesSolicitud, $esAval, $avalMora, $estadoCredito, $CreadoPor) {
    $query = "INSERT INTO tbl_mn_personas(idTipoPersona, idNacionalidad, idGenero, idEstadoCivil, idProfesion, idPersonaBienes, idTipoClientes, idcategoriaCasa,
                                          idtiempoVivir, idMunicipio, idTiempoLaboral, nombres, apellidos, identidad, fechaNacimiento, PagaAlquiler, PratronoNegocio,
                                          cargoDesempena, ObservacionesSolicitud, esAval, avalMora, estadoCredito, CreadoPor)
     VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";                                                                                                       
    $result = $this->cnx->prepare($query);

    $result->bindParam(1, $idTipoPersona);
    $result->bindParam(2, $idNacionalidad);
    $result->bindParam(3, $idGenero);
    $result->bindParam(4, $idEstadoCivil);
    $result->bindParam(5, $idProfesion);
    $result->bindParam(6, $bienes);
    $result->bindParam(7, $idTipoClientes);
    $result->bindParam(8, $idcategoriaCasa);
    $result->bindParam(9, $idtiempoVivir);
    $result->bindParam(10, $municipio);
    $result->bindParam(11, $idTiempoLaboral);
    $result->bindParam(12, $nombres);
    $result->bindParam(13, $apellidos);
    $result->bindParam(14, $identidad);
    $result->bindParam(15, $fechaNacimiento);
    $result->bindParam(16, $PagaAlquiler);
    $result->bindParam(17, $patrono);
    $result->bindParam(18, $actividadDesempenia);
    $result->bindParam(19, $ObservacionesSolicitud);
    $result->bindParam(20, $esAval);
    $result->bindParam(21, $avalMora);
    $result->bindParam(22, $estadoCredito);
    $result->bindParam(23, $CreadoPor);

    if ($result->execute()) {
        $lastInsertId = $this->cnx->lastInsertId(); // Obtiene el ID del último registro insertado
        return $lastInsertId;
    }

    return false;
}

function RegistrarAval($idSolicitud, $idPersona, $CreadoPor) {
    $query = "INSERT INTO tbl_mn_avales(idSolicitud, idPersona, CreadoPor)
     VALUES(?, ?, ?)";                                                                                                       
    $result = $this->cnx->prepare($query);

    $result->bindParam(1, $idSolicitud);
    $result->bindParam(2, $idPersona);
    $result->bindParam(3, $CreadoPor);
    
    if ($result->execute()) {
    
        return true;
    }

    return false;
}


function RegistrarConyuge($idSolicitud, $idPersona, $ingresosNegocio, $sueldoBase, $gastoAlimentacion, $idPersonaPareja){
    $query = "INSERT INTO tbl_mn_conyugues(idSolicitud, idPersona, ingresosNegocio, sueldoBase, gastoAlimentacion, idPersonaPareja)
     VALUES(?, ?, ?, ?, ?, ?)";                                                                                                       
    $result = $this->cnx->prepare($query); //preparacion de la sentencia
    $result->bindParam(1,$idSolicitud);
    $result->bindParam(2,$idPersona);
    $result->bindParam(3,$ingresosNegocio);
    $result->bindParam(4,$sueldoBase);
    $result->bindParam(5,$gastoAlimentacion);
    $result->bindParam(6,$idPersonaPareja);

    if($result->execute()){ //validacion de la ejecucion
        return true;
    }

    return false; //si fallo se devuelvo false

}
//registra cuenta
function RegistrarCuenta($idPersona, $tipoCuenta, $cuenta){
    $query = "INSERT INTO tbl_mn_personas_cuenta(idPersona, idTipoCuenta, NumeroCuenta)
     VALUES(?, ?, ?)";                                                                                                       
    $result = $this->cnx->prepare($query); //preparacion de la sentencia
    $result->bindParam(1,$idPersona);
    $result->bindParam(2,$tipoCuenta);
    $result->bindParam(3,$cuenta);

    if($result->execute()){ //validacion de la ejecucion
        return true;
    }

    return false; //si fallo se devuelvo false

}



function Registrar_contactos_referencias($contactos, $referencias, $CreadoPor) {
    $sqlContactos = "INSERT INTO tbl_mn_personas_contacto (idPersona, idTipoContacto, valor) VALUES (?, ?, ?)";
    $resultContactos = $this->cnx->prepare($sqlContactos);

    foreach ($contactos as $contacto) {
        $idPersonaContacto = $contacto['idPersona'];
        $idTipoContacto = $contacto['idTipoContacto'];
        $valor = $contacto['valor'];

        $resultContactos->bindParam(1, $idPersonaContacto);
        $resultContactos->bindParam(2, $idTipoContacto);
        $resultContactos->bindParam(3, $valor);

        $resultContactos->execute();
    }

    $sqlReferencias = "INSERT INTO tbl_mn_referencias_familiares (idPersona, idParentesco, nombre, celular, direccion, CreadoPor) 
                      VALUES (?, ?, ?, ?, ?, ?)";
    $resultReferencias = $this->cnx->prepare($sqlReferencias);

    foreach ($referencias as $referencia) {
        $idPersonaReferencia = $referencia['idPersona'];
        $idParentesco = $referencia['idParentesco'];
        $nombre = $referencia['nombre'];
        $celular = $referencia['celular'];
        $direccion = $referencia['direccion'];

        $resultReferencias->bindParam(1, $idPersonaReferencia);
        $resultReferencias->bindParam(2, $idParentesco);
        $resultReferencias->bindParam(3, $nombre);
        $resultReferencias->bindParam(4, $celular);
        $resultReferencias->bindParam(5, $direccion);
        $resultReferencias->bindParam(6, $CreadoPor);

        $resultReferencias->execute();
    }

    try {
        $this->cnx->beginTransaction();
        $this->cnx->commit();
        return true;
    } catch (PDOException $e) {
        $this->cnx->rollback();
        return false;
    }
}

function RegistrarReferenciasComerciales($comerciales, $CreadoPor) {
    try {
        $this->cnx->beginTransaction();

        $sqlReferencia = "INSERT INTO tbl_mn_referencias_comerciales (idPersona, nombre, direccion, CreadoPor) VALUES (?, ?, ?, ?)";
        $resultReferencia = $this->cnx->prepare($sqlReferencia);

        foreach ($comerciales as $referencia) {
            $idPersona = $referencia['idPersona'];
            $nombre = $referencia['nombre'];
            $direccion = $referencia['direccion'];

            $resultReferencia->bindParam(1, $idPersona);
            $resultReferencia->bindParam(2, $nombre);
            $resultReferencia->bindParam(3, $direccion);
            $resultReferencia->bindParam(4, $CreadoPor);

            $resultReferencia->execute();
        }

        $this->cnx->commit();
        return true;
    } catch (PDOException $e) {
        $this->cnx->rollback();
        return false;
    }
}


//registra os dependientes
function RegistrarDependientes($idPersona, $idParentesco, $nombre) {
 
    $query = "INSERT INTO tbl_mn_personas_dependientes (idPersona, idParentesco, nombre)  VALUES (?, ?, ?)";
    $result = $this->cnx->prepare($query); // preparación de la sentencia
    $result->bindParam(1, $idPersona);
    $result->bindParam(2, $idParentesco);
    $result->bindParam(3, $nombre);

    if ($result->execute()) { // validación de la ejecución
       return true; // si falló se devuelve false
    }
    

    return false;
}

//FUNCION PARA REGISTRAr la solicitd
function RegistrarSolicitud($idPersona, $idTipoPrestamo, $idRubro, $idEstadoSolicitud, $idUsuario, $Monto, $tasa, $Plazo, $fechaDesembolso, $invierteEn, $prestamoAprobados, $CreadoPor){
    $query = "INSERT INTO tbl_mn_solicitudes_creditos(idPersona, idTipoPrestamo, idRubro, idEstadoSolicitud, idUsuario, Monto, tasa, Plazo, fechaDesembolso, invierteEn, prestamoAprobados, CreadoPor )
     VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $result = $this->cnx->prepare($query); //preparacion de la sentencia
    $result->bindParam(1,$idPersona);
    $result->bindParam(2,$idTipoPrestamo);
    $result->bindParam(3,$idRubro);
    $result->bindParam(4,$idEstadoSolicitud);
    $result->bindParam(5,$idUsuario);
    $result->bindParam(6,$Monto);
    $result->bindParam(7,$tasa);
    $result->bindParam(8,$Plazo);
    $result->bindParam(9,$fechaDesembolso);
    $result->bindParam(10,$invierteEn);
    $result->bindParam(11,$prestamoAprobados);
    $result->bindParam(12,$CreadoPor);

    if($result->execute()){ //validacion de la ejecucion
        return true;
    }

    return false; //si fallo se devuelvo false

}

//FUNCION PARA REGISTRAr la solicitd
function RegistrarAnalisis($idSolicitud, $idEstadoAnalisisCrediticio, $sueldoBase, $ingresosNegocio, $rentaPropiedad, $remesas, 
                           $aporteConyugue, $ingresosSociedad, $cuotaApedes, $cuotaViviendad, $alimentacion, $deduccionesCentral,
                           $otrosEgresos, $Capital, $descripcion, $idPersona){
    $query = "INSERT INTO tbl_mn_analisis_crediticio (idSolicitud, idEstadoAnalisisCrediticio, sueldoBase, ingresosNegocio,
     rentaPropiedad, remesas, aporteConyugue, ingresosSociedad, cuotaPrestamoAdepes, cuotaVivienda, alimentacion, deduccionesCentralRiesgo, 
     otrosEgresos, LiquidezCliente, Descripcion, idPersona) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $result = $this->cnx->prepare($query); //preparacion de la sentencia
    $result->bindParam(1,$idSolicitud);
    $result->bindParam(2,$idEstadoAnalisisCrediticio);
    $result->bindParam(3,$sueldoBase);
    $result->bindParam(4,$ingresosNegocio);
    $result->bindParam(5,$rentaPropiedad);
    $result->bindParam(6,$remesas);
    $result->bindParam(7,$aporteConyugue);
    $result->bindParam(8,$ingresosSociedad);
    $result->bindParam(9,$cuotaApedes);
    $result->bindParam(10,$cuotaViviendad);
    $result->bindParam(11,$alimentacion);
    $result->bindParam(12,$deduccionesCentral);
    $result->bindParam(13,$otrosEgresos);
    $result->bindParam(14,$Capital);
    $result->bindParam(15,$descripcion);
    $result->bindParam(16,$idPersona);

    if($result->execute()){ //validacion de la ejecucion
        return true;
    }

    return false; //si fallo se devuelvo false

}


function idPersona($identidad) {
    $query = "SELECT idPersona FROM tbl_mn_personas WHERE identidad = ?;"; 
    $result = $this->cnx->prepare($query);
    $result->bindParam(1, $identidad);
    
    if ($result->execute()) {
        if ($result->rowCount() > 0) {
            $fila = $result->fetch(PDO::FETCH_ASSOC);
            return $fila['idPersona'];
        }
    }
    
    return false;
}


function id_Solicitud($idPersona){ //funcion que trae el id de la solicitud
    $query = "SELECT idSolicitud FROM tbl_mn_solicitudes_creditos WHERE idPersona = ?; "; 
    $result = $this->cnx->prepare($query);
    $result->bindParam(1,$idPersona);
    if($result->execute())
    {
        if($result->rowCount() > 0){ //validacion para verificar si trae datos
            
            $fila = $result->fetch(PDO::FETCH_ASSOC);
            return $fila['idSolicitud'];
            
        }
    }
    return false;
}
function Solicitud_id($idPersona){ //funcion que trae el id para aprobara o desaprobar una solicitud
    $query = "SELECT solicitud.idSolicitud, persona.nombres, persona.apellidos, prestamo.Descripcion as Prestamo, solicitud.idPersona, solicitud.invierteEn, persona.identidad, persona.fechaNacimiento, persona.PratronoNegocio, persona.cargoDesempena,
    solicitud.Monto, concat(solicitud.tasa,'%') as tasa, solicitud.Plazo, estado.Descripcion as Estado, estado.idEstadoSolicitud, solicitud.fechaDesembolso, prestamo.idTipoPrestamo, COUNT(aval.idSolicitud) as CantidadAval
   FROM tbl_mn_solicitudes_creditos solicitud
   INNER JOIN  tbl_mn_personas persona ON solicitud.idPersona = persona.idPersona
   INNER JOIN tbl_mn_estados_solicitudes estado ON solicitud.idEstadoSolicitud = estado.idEstadoSolicitud
   INNER JOIN tbl_mn_tipos_prestamos prestamo ON solicitud.idTipoPrestamo = prestamo.idTipoPrestamo
   LEFT JOIN tbl_mn_avales aval ON solicitud.idSolicitud = aval.idSolicitud
   WHERE solicitud.idPersona = ?
   GROUP BY solicitud.idSolicitud, persona.nombres, persona.apellidos, prestamo.Descripcion,
         solicitud.Monto, solicitud.tasa, solicitud.Plazo, estado.Descripcion, estado.idEstadoSolicitud,
         solicitud.fechaDesembolso, prestamo.idTipoPrestamo;"; 
    $result = $this->cnx->prepare($query);
    $result->bindParam(1,$idPersona);
    if($result->execute())
    {
      return $result->fetch(PDO::FETCH_ASSOC);
         
    }
    return false;
}

function ObtenerDatosPrestamo($idTipoPrestamo){ //funcion que trae el id de la solicitud
    $query = "SELECT * FROM tbl_mn_tipos_prestamos WHERE idTipoPrestamo = ?; "; 
    $result = $this->cnx->prepare($query);
    $result->bindParam(1,$idTipoPrestamo);
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


//funcion para  aprobar solicitud
function AprobarSolicitud($numeroActa, $idEstadoSolicitud, $idSolicitud){
    $query = "UPDATE tbl_mn_solicitudes_creditos SET fechaDesembolso= CURDATE(), numeroActa = ?, idEstadoSolicitud = ? WHERE idSolicitud = ?"; 
    $result = $this->cnx->prepare($query);
    $result->bindParam(1,$numeroActa);
    $result->bindParam(2,$idEstadoSolicitud);
    $result->bindParam(3,$idSolicitud);
    if($result->execute())
    {
      return true;
         
    }
    return false;
}

function idTipoTasa($idTipoPrestamo){ //funcion que trae la tasa
    $query = "SELECT * FROM tbl_mn_tipos_prestamos WHERE idTipoPrestamo = ?; "; 
    $result = $this->cnx->prepare($query);
    $result->bindParam(1,$idTipoPrestamo);
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

function CantidadAvales($idSolicitud) {
    $query = "SELECT COUNT(idSolicitud) as CantidadAval FROM tbl_mn_avales WHERE idSolicitud = ?"; 
    $result = $this->cnx->prepare($query);
    $result->bindParam(1, $idSolicitud);
    
    if ($result->execute()) {
        $fila = $result->fetch(PDO::FETCH_ASSOC);
        return (int)$fila['CantidadAval'];
    }
    
    return -1; // Indicar que ocurrió un error o no se encontraron datos
}

function BuscarClientePorId($identidad){ //funcion que trae el id para aprobara o desaprobar una solicitud
    $query = "SELECT persona.idPersona, persona.nombres, persona.apellidos, persona.identidad, persona.fechaNacimiento, persona.PratronoNegocio, 
                     persona.cargoDesempena, persona.idEstadoCivil, persona.idcategoriaCasa, persona.idtiempoVivir, persona.PagaAlquiler, persona.idGenero, 
                     persona.idProfesion, persona.idNacionalidad, persona.idTiempoLaboral,
                (SELECT valor FROM tbl_mn_personas_contacto WHERE idPersona = persona.idPersona AND idTipoContacto = 1) AS Celular,
                (SELECT valor FROM tbl_mn_personas_contacto WHERE idPersona = persona.idPersona AND idTipoContacto = 2) AS Direccion,
                (SELECT valor FROM tbl_mn_personas_contacto WHERE idPersona = persona.idPersona AND idTipoContacto = 3) AS Telefono,
                (SELECT valor FROM tbl_mn_personas_contacto WHERE idPersona = persona.idPersona AND idTipoContacto = 4) AS DireccionTrabajo,
                (SELECT valor FROM tbl_mn_personas_contacto WHERE idPersona = persona.idPersona AND idTipoContacto = 5) AS TelefonoTrabajo
                FROM tbl_mn_personas persona
                WHERE persona.identidad = ?
                ORDER BY persona.idPersona DESC;"; 
    $result = $this->cnx->prepare($query);
    $result->bindParam(1,$identidad);
    if($result->execute())
    {
      return $result->fetch(PDO::FETCH_ASSOC);
         
    }
    return false;
}

function BuscarClienteParejaPorId($idPersona){ //funcion que trae el id para aprobara o desaprobar una solicitud
    $query = "SELECT persona.idPersona, persona.nombres, persona.apellidos, persona.identidad, persona.fechaNacimiento, persona.PratronoNegocio, 
             persona.cargoDesempena, persona.idEstadoCivil, persona.idcategoriaCasa, persona.idtiempoVivir, persona.PagaAlquiler, persona.idGenero, 
             persona.idProfesion, persona.idNacionalidad, persona.idTiempoLaboral,
            (SELECT valor FROM tbl_mn_personas_contacto WHERE idPersona = persona.idPersona AND idTipoContacto = 1) AS Celular,
             (SELECT valor FROM tbl_mn_personas_contacto WHERE idPersona = persona.idPersona AND idTipoContacto = 2) AS Direccion,
             (SELECT valor FROM tbl_mn_personas_contacto WHERE idPersona = persona.idPersona AND idTipoContacto = 3) AS Telefono,
             (SELECT valor FROM tbl_mn_personas_contacto WHERE idPersona = persona.idPersona AND idTipoContacto = 4) AS DireccionTrabajo,
             (SELECT valor FROM tbl_mn_personas_contacto WHERE idPersona = persona.idPersona AND idTipoContacto = 5) AS TelefonoTrabajo
            FROM tbl_mn_solicitudes_creditos soli  
            INNER JOIN tbl_mn_conyugues pareja ON soli.idSolicitud = pareja.idSolicitud
            INNER JOIN tbl_mn_personas persona ON persona.idPersona = pareja.idPersona
            WHERE soli.idPersona = ?;"; 
    $result = $this->cnx->prepare($query);
    $result->bindParam(1,$idPersona);
    if($result->execute())
    {
      return $result->fetch(PDO::FETCH_ASSOC);
         
    }
    return false;
}


function RegistrarProfesion($descripcion){
    $query = "INSERT INTO tbl_mn_profesiones_oficios(Descripcion) VALUES(?)";
    $result = $this->cnx->prepare($query); //preparacion de la sentencia
    $result->bindParam(1,$descripcion);

    if($result->execute()){ //validacion de la ejecucion
        return true;
    }

    return false; //si fallo se devuelvo false

}
//funciion para listar las profesiones luego de que el usuario ingreso una nueva profesion
function ListarProfesionesPorUsuario()
{
    $query = "SELECT *FROM tbl_mn_profesiones_oficios ORDER BY idProfesion DESC"; //sentencia sql
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


function DictamenAsesor($idPersona){ //funcion que trae el id de la solicitud
    $query = "SELECT CONCAT('SOLICITANTE: ',persona.nombres,' ', persona.apellidos, ' SUS INGRESOS LOS OBTIENE POR ',persona.PratronoNegocio, ' ACTUALMENTE SE DEDICA COMO ',persona.cargoDesempena, ' EL TIPO DE CRÉDITO ES '
    ,cliente.Descripcion,' ',avala.Descripcion,', ',mora.Descripcion, ', EN RELACIÓN A LOS INGRESOS, EL ',analisis.Descripcion
    ,' LA FINALIDAD DEL CRÉDITO ES PARA, ',soli.invierteEn,' LA MODALIDAD DE PAGO ES POR CUOTA NIVELADA, OFRECIENDO UNA GARANTÍA '
    ,' ',prestamo.Descripcion) AS dictamen, persona.identidad, soli.prestamoAprobados, soli.numeroActa, estadoSoli.Descripcion, soli.dictamenAsesor
    FROM tbl_mn_personas persona
    INNER JOIN tbl_mn_tipo_clientes cliente ON persona.estadoCredito = cliente.idTipoCliente
    INNER JOIN tbl_mn_avala_a_persona avala ON persona.esAval = avala.idEsAval
    INNER JOIN tbl_mn_credito_aval mora ON persona.avalMora = mora.idCreditoAval
    INNER JOIN tbl_mn_analisis_crediticio analisis ON persona.idPersona = analisis.idPersona
    INNER JOIN tbl_mn_solicitudes_creditos soli ON soli.idPersona = persona.idPersona
    INNER JOIN tbl_mn_estados_solicitudes estadoSoli ON soli.idEstadoSolicitud = estadoSoli.idEstadoSolicitud
    INNER JOIN tbl_mn_tipos_prestamos prestamo ON prestamo.idTipoPrestamo = soli.idTipoPrestamo
    WHERE persona.idPersona = ?"; 
    $result = $this->cnx->prepare($query);
    $result->bindParam(1,$idPersona);
    if($result->execute())
    {
       return $result->fetch(PDO::FETCH_ASSOC);
    }
    return false;
}

function PrestamosAprobadosPorPersona($identidad){ //funcion que cuenta los prestamo por persona
    $query = "SELECT COUNT(persona.idPersona ) AS aprobados FROM tbl_mn_personas persona
    INNER JOIN tbl_mn_solicitudes_creditos soli ON persona.idPersona = soli.idPersona
    WHERE persona.identidad = ? AND soli.idEstadoSolicitud = 4"; 
    $result = $this->cnx->prepare($query);
    $result->bindParam(1,$identidad);
    if($result->execute())
    {
        $fila = $result->fetch(PDO::FETCH_ASSOC);
        return (int)$fila['aprobados'];
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



} //fin de la clase








?>