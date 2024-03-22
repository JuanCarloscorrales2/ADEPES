<?php

require "../config/Conexion.php";

class EditarSolicitud {

    public $cnx; //variable publica para la conexion a la BD

    function __construct() //constructor
    {
        $this->cnx = Conexion::ConectarDB(); //conexion a la base de datos
    }
    
    function ListarTipoPrestamo($idSolicitud)
    {
        $query = "SELECT prestamo.idTipoPrestamo, prestamo.Descripcion, prestamo.tasa FROM tbl_mn_solicitudes_creditos solicitud
                  INNER JOIN tbl_mn_tipos_prestamos prestamo ON solicitud.idTipoPrestamo = prestamo.idTipoPrestamo
                  WHERE solicitud.idSolicitud = ?
                  UNION SELECT idTipoPrestamo, Descripcion, tasa FROM tbl_mn_tipos_prestamos"; 
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

    function ListarRubro($idSolicitud)
    {
        $query = "SELECT rubro.idRubro, rubro.Descripcion FROM tbl_mn_solicitudes_creditos solicitud
                  INNER JOIN tbl_mn_rubros rubro ON solicitud.idRubro = rubro.idRubro
                  WHERE solicitud.idSolicitud = ?
                  UNION SELECT idRubro, Descripcion FROM tbl_mn_rubros"; 
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

    function ListarNacionalidad($idPersona)
    {
        $query = "SELECT nacionalidad.idNacionalidad, nacionalidad.Descripcion FROM tbl_mn_personas persona
                  INNER JOIN tbl_mn_nacionalidades nacionalidad ON persona.idNacionalidad = nacionalidad.idNacionalidad
                  WHERE persona.idPersona = ?
                  UNION SELECT idNacionalidad, Descripcion FROM tbl_mn_nacionalidades"; 
        $result = $this->cnx->prepare($query);
        $result->bindParam(1,$idPersona);
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

    function ListarContactos($idPersona)
    {
        $query = "SELECT persona.idPersona, persona.idTipoPersona,
        MAX(CASE WHEN tipo.idTipoContacto = 1 THEN contacto.valor END) AS celular,
        MAX(CASE WHEN tipo.idTipoContacto = 2 THEN contacto.valor END) AS direccion,
        MAX(CASE WHEN tipo.idTipoContacto = 3 THEN contacto.valor END) AS telefono,
        MAX(CASE WHEN tipo.idTipoContacto = 4 THEN contacto.valor END) AS direccionTrabajo,
        MAX(CASE WHEN tipo.idTipoContacto = 5 THEN contacto.valor END) AS telefonoTrabajo
        FROM tbl_mn_personas persona
        LEFT JOIN tbl_mn_personas_contacto contacto ON persona.idPersona = contacto.idPersona
        LEFT JOIN tbl_mn_tipo_contacto tipo ON contacto.idTipoContacto = tipo.idTipoContacto
        WHERE persona.idPersona = ?
        GROUP BY persona.idPersona;"; 
        $result = $this->cnx->prepare($query);
        $result->bindParam(1,$idPersona);
        if($result->execute())
        {
            return $result->fetch(PDO::FETCH_ASSOC);
        }
        return false;
    }

    function ListarEstadoCivil($idPersona)
    {
        $query = "SELECT civil.idEstadoCivil, civil.Descripcion FROM tbl_mn_personas persona
                 INNER JOIN tbl_mn_estadocivil civil ON persona.idEstadoCivil = civil.idEstadoCivil
                 WHERE persona.idPersona = ?
                 UNION SELECT idEstadoCivil, Descripcion FROM tbl_mn_estadocivil"; 
        $result = $this->cnx->prepare($query);
        $result->bindParam(1,$idPersona);
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

    function ListarCasa($idPersona)
    {
        $query = "SELECT casa.idcategoriaCasa, casa.descripcion FROM tbl_mn_personas persona
                  INNER JOIN tbl_mn_categoria_casa casa ON persona.idcategoriaCasa = casa.idcategoriaCasa
                  WHERE persona.idPersona = ?
                  UNION SELECT idcategoriaCasa, descripcion FROM tbl_mn_categoria_casa"; 
        $result = $this->cnx->prepare($query);
        $result->bindParam(1,$idPersona);
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

    function TiempoVivir($idPersona)
    {
        $query = "SELECT tiempo.idtiempoVivir, tiempo.descripcion FROM tbl_mn_personas persona
        INNER JOIN tbl_mn_tiempo_vivir tiempo ON persona.idtiempoVivir = tiempo.idtiempoVivir
        WHERE persona.idPersona = ?
        UNION SELECT idtiempoVivir, descripcion FROM tbl_mn_tiempo_vivir "; 
        $result = $this->cnx->prepare($query);
        $result->bindParam(1,$idPersona);
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

    function FormaPagoAlquiler($idPersona)
    {
        $query = "SELECT pago.idTipoPago, pago.descripcion FROM tbl_mn_personas persona
                 INNER JOIN tbl_mn_tipos_de_pago pago ON persona.PagaAlquiler = pago.idTipoPago
                 WHERE persona.idPersona = ?
                 UNION SELECT idTipoPago, descripcion FROM tbl_mn_tipos_de_pago"; 
        $result = $this->cnx->prepare($query);
        $result->bindParam(1,$idPersona);
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

    function Genero($idPersona)
    {
        $query = "SELECT genero.idGenero, genero.Descripcion FROM tbl_mn_personas persona
                INNER JOIN tbl_mn_genero genero ON persona.idGenero = genero.idGenero
                WHERE persona.idPersona = ?
                UNION SELECT idGenero, Descripcion FROM tbl_mn_genero"; 
        $result = $this->cnx->prepare($query);
        $result->bindParam(1,$idPersona);
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

    function Profesion($idPersona)
    {
        $query = "SELECT profe.idProfesion, profe.Descripcion FROM tbl_mn_personas persona
                INNER JOIN tbl_mn_profesiones_oficios profe ON persona.idProfesion = profe.idProfesion
                WHERE persona.idPersona = ?
                UNION SELECT idProfesion, Descripcion FROM tbl_mn_profesiones_oficios"; 
        $result = $this->cnx->prepare($query);
        $result->bindParam(1,$idPersona);
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

    function TiempoLavoral($idPersona)
    {
        $query = "SELECT tiempo.idTiempoLaboral, tiempo.descripcion FROM tbl_mn_personas persona
                INNER JOIN tbl_mn_tiempo_laboral tiempo ON persona.idTiempoLaboral = tiempo.idTiempoLaboral
                WHERE persona.idPersona = ?
                UNION SELECT idTiempoLaboral, descripcion FROM tbl_mn_tiempo_laboral"; 
        $result = $this->cnx->prepare($query);
        $result->bindParam(1,$idPersona);
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
    function ListarBienesPersona($idPersona)
    {
        $query = "SELECT bienes.idPersonaBienes, bienes.Descripcion FROM tbl_mn_personas persona 
                INNER JOIN tbl_mn_personas_bienes bienes ON persona.idPersonaBienes = bienes.idPersonaBienes
                WHERE persona.idPersona =?
                UNION SELECT idPersonaBienes, Descripcion FROM tbl_mn_personas_bienes"; 
        $result = $this->cnx->prepare($query);
        $result->bindParam(1,$idPersona);
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
    function TipoCredito($idPersona)
    {
        $query = "SELECT cliente.idTipoCliente, cliente.Descripcion FROM tbl_mn_personas persona
                    INNER JOIN tbl_mn_tipo_clientes cliente ON persona.idTipoClientes = cliente.idTipoCliente
                    WHERE persona.idPersona = ?
                    UNION SELECT idTipoCliente, Descripcion FROM tbl_mn_tipo_clientes"; 
        $result = $this->cnx->prepare($query);
        $result->bindParam(1,$idPersona);
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

    function EstadoCredito($idPersona)
    {
        $query = "SELECT estado.idEstadoCredito, estado.Descripcion FROM tbl_mn_personas persona
                    INNER JOIN tbl_mn_estado_credito estado ON persona.estadoCredito = estado.idEstadoCredito
                    WHERE persona.idPersona = ?
                    UNION SELECT idEstadoCredito, Descripcion FROM tbl_mn_estado_credito"; 
        $result = $this->cnx->prepare($query);
        $result->bindParam(1,$idPersona);
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

    function EsAval($idPersona)
    {
        $query = "SELECT aval.idEsAval, aval.Descripcion FROM tbl_mn_personas persona
                INNER JOIN tbl_mn_avala_a_persona aval ON persona.esAval = aval.idEsAval
                WHERE persona.idPersona = ?
                UNION SELECT idEsAval, Descripcion FROM tbl_mn_avala_a_persona"; 
        $result = $this->cnx->prepare($query);
        $result->bindParam(1,$idPersona);
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

    function AvalesMora($idPersona)
    {
        $query = "SELECT aval.idCreditoAval, aval.Descripcion FROM tbl_mn_personas persona
                    INNER JOIN tbl_mn_credito_aval aval ON persona.avalMora = aval.idCreditoAval
                    WHERE persona.idPersona = ?
                    UNION SELECT idCreditoAval, Descripcion FROM tbl_mn_credito_aval"; 
        $result = $this->cnx->prepare($query);
        $result->bindParam(1,$idPersona);
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

    function AnalisisCredticio($idPersona)
    {
        $query = "SELECT  * FROM tbl_mn_solicitudes_creditos solicitud 
                    INNER JOIN tbl_mn_analisis_crediticio analisis ON solicitud.idSolicitud = analisis.idSolicitud
                    WHERE solicitud.idPersona = ?"; 
        $result = $this->cnx->prepare($query);
        $result->bindParam(1,$idPersona);
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

    function Conyugue($idPersonaPareja)
    {
        $query = "SELECT  conyugue.idPersona, conyugue.ingresosNegocio, conyugue.sueldoBase, conyugue.gastoAlimentacion,
                    persona.idNacionalidad, persona.idGenero, persona.idProfesion, persona.idTipoClientes, persona.idtiempoLaboral,
                    persona.PagaAlquiler, persona.estadoCredito, persona.esAval, persona.avalMora, persona.nombres, persona.apellidos,
                    persona.identidad, persona.fechaNacimiento, persona.PratronoNegocio, persona.cargoDesempena
                    FROM tbl_mn_solicitudes_creditos solicitud 
                    INNER JOIN tbl_mn_conyugues conyugue ON solicitud.idSolicitud =  conyugue.idSolicitud
                    INNER JOIN tbl_mn_personas persona ON persona.idPersona =  conyugue.idPersona
                    WHERE conyugue.idPersonaPareja = ?"; 
        $result = $this->cnx->prepare($query);
        $result->bindParam(1,$idPersonaPareja);
        if($result->execute())
        {
            return $result->fetch(PDO::FETCH_ASSOC);
        }
        return false;
    }

    function ReferenciasFamiliares($idPersona)
    {
        $query = "SELECT refe.nombre, refe.celular, refe.direccion, refe.idParentesco, refe.idReferencia FROM tbl_mn_referencias_familiares refe
                  INNER JOIN tbl_mn_personas persona ON refe.idPersona = persona.idPersona
                  WHERE persona.idPersona = ?"; 
        $result = $this->cnx->prepare($query);
        $result->bindParam(1,$idPersona);
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

    function Parentesco($idReferencia) //lista los tipos de parentescos
    {
        $query = "SELECT paren.idParentesco, paren.descripcion FROM tbl_mn_referencias_familiares refe 
                 INNER JOIN tbl_mn_parentesco paren ON refe.idParentesco = paren.idParentesco
                 WHERE refe.idReferencia =?
                 UNION SELECT idParentesco, descripcion FROM tbl_mn_parentesco"; 
        $result = $this->cnx->prepare($query);
        $result->bindParam(1,$idReferencia);
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

    function PersonasDependientes($idPersona)
    {
        $query = "SELECT perso.ObservacionesSolicitud, depen.nombre FROM tbl_mn_personas perso
                  INNER JOIN tbl_mn_personas_dependientes depen ON perso.idPersona =  depen.idPersona
                  WHERE perso.idPersona = ?"; 
        $result = $this->cnx->prepare($query);
        $result->bindParam(1,$idPersona);
        if($result->execute())
        {
            return $result->fetch(PDO::FETCH_ASSOC);
        }
        return false;
    }

    /*                               Avales de solicitud */


 function DatosAval($idSolicitud) //lista los tipos de parentescos
    {
        $query = "SELECT persona.idPersona, persona.nombres, persona.apellidos, persona.identidad, avales.idSolicitud,
        persona.fechaNacimiento, persona.PratronoNegocio, persona.cargoDesempena, persona.ObservacionesSolicitud
        FROM tbl_mn_personas persona INNER JOIN tbl_mn_avales avales ON avales.idPersona = persona.idPersona
        WHERE avales.idSolicitud = ?"; 
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


    function ReferenciasComerciales($idPersona)
    {
        $query = "SELECT *FROM tbl_mn_referencias_comerciales WHERE idPersona = ?"; 
        $result = $this->cnx->prepare($query);
        $result->bindParam(1,$idPersona);
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

    function FormatoConozcaCliente($idPersona)
    {
        $query = "SELECT civil.descripcion as civil, nacionalidad.Descripcion as nacionalidad, genero.Descripcion as genero,
                profesion.Descripcion as profesiones, bienes.Descripcion as bienesPersona, muni.Descripcion as municipio, soli.dictamenAsesor
                FROM tbl_mn_personas persona
                INNER JOIN tbl_mn_estadocivil civil ON persona.idEstadoCivil = civil.idEstadoCivil
                INNER JOIN tbl_mn_nacionalidades nacionalidad ON persona.idNacionalidad =  nacionalidad.idNacionalidad
                INNER JOIN tbl_mn_genero genero ON persona.idGenero = genero.idGenero
                INNER JOIN tbl_mn_profesiones_oficios profesion ON persona.idProfesion = profesion.idProfesion
                INNER JOIN tbl_mn_personas_bienes bienes ON persona.idPersonaBienes = bienes.idPersonaBienes
                INNER JOIN tbl_mn_municipio muni ON persona.idMunicipio = muni.idMunicipio
                INNER JOIN tbl_mn_solicitudes_creditos soli ON persona.idPersona = soli.idPersona
                WHERE persona.idPersona = ?"; 
        $result = $this->cnx->prepare($query);
        $result->bindParam(1,$idPersona);
        if($result->execute())
        {
            return $result->fetch(PDO::FETCH_ASSOC);
        }
        return false;
    }

    function PersonasCuenta($idPersona)
    {
        $query = "SELECT cuenta.NumeroCuenta FROM tbl_mn_personas persona
        INNER JOIN tbl_mn_personas_cuenta cuenta ON cuenta.idPersona = persona.idPersona WHERE persona.idPersona = ?"; 
        $result = $this->cnx->prepare($query);
        $result->bindParam(1,$idPersona);
        if($result->execute())
        {
            return $result->fetch(PDO::FETCH_ASSOC);
        }
        return false;
    }


    function Municipios($idPersona) //lista los tipos de parentescos
    {
        $query = "SELECT muni.idMunicipio, muni.Descripcion FROM tbl_mn_personas persona 
            INNER JOIN tbl_mn_municipio muni ON persona.idMunicipio = muni.idMunicipio
            WHERE persona.idPersona =?
            UNION SELECT idMunicipio, Descripcion FROM tbl_mn_municipio"; 
        $result = $this->cnx->prepare($query);
        $result->bindParam(1,$idPersona);
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


    /****************************** FUNCIONES DE ACTUALIZACION DE SOLICITUD ****************************** */
    function ActualizarPersona($idPersona, $idNacionalidad, $idGenero, $idEstadoCivil, $idProfesion, $idPersonaBienes, $idTipoClientes, $idcategoriaCasa,
     $idtiempoVivir, $idTiempoLaboral, $PagaAlquiler, $estadoCredito, $esAval, $avalMora, $idMunicipio, $nombres, $apellidos, $identidad,
      $fechaNacimiento, $PratronoNegocio, $cargoDesempena, $ObservacionesSolicitud){
        
        $query = "UPDATE tbl_mn_personas SET  idNacionalidad = ?, idGenero = ?, idEstadoCivil = ?, idProfesion = ?,
        idPersonaBienes = ?, idTipoClientes = ?, idcategoriaCasa = ?, idtiempoVivir = ?, idTiempoLaboral = ?, PagaAlquiler = ?,
        estadoCredito = ?, esAval = ?, avalMora = ?, idMunicipio = ?, nombres = ?, apellidos = ?, identidad = ?, fechaNacimiento = ?,
        PratronoNegocio = ?, cargoDesempena = ?, ObservacionesSolicitud = ?
        WHERE idPersona = ?";
        $result = $this->cnx->prepare($query); //preparacion de la sentencia
        $result->bindParam(1,$idNacionalidad);
        $result->bindParam(2,$idGenero);
        $result->bindParam(3,$idEstadoCivil);
        $result->bindParam(4,$idProfesion);
        $result->bindParam(5,$idPersonaBienes);
        $result->bindParam(6,$idTipoClientes);
        $result->bindParam(7,$idcategoriaCasa);
        $result->bindParam(8,$idtiempoVivir);
        $result->bindParam(9,$idTiempoLaboral);
        $result->bindParam(10,$PagaAlquiler);
        $result->bindParam(11,$estadoCredito);
        $result->bindParam(12,$esAval);
        $result->bindParam(13,$avalMora);
        $result->bindParam(14,$idMunicipio);
        $result->bindParam(15,$nombres);
        $result->bindParam(16,$apellidos);
        $result->bindParam(17,$identidad);
        $result->bindParam(18,$fechaNacimiento);
        $result->bindParam(19,$PratronoNegocio);
        $result->bindParam(20,$cargoDesempena);
        $result->bindParam(21,$ObservacionesSolicitud);
        $result->bindParam(22,$idPersona);


        if($result->execute()){ //validacion de la ejecucion
            return true;
        }

        return false; //si fallo se devuelvo false
    
    }
    //funcion para traer los id de referencias familiares
    function idReferenciasFamiliares($idPersona) {
        $query = "SELECT idReferencia FROM tbl_mn_referencias_familiares WHERE idPersona = ?;"; 
        $result = $this->cnx->prepare($query);
        $result->bindParam(1, $idPersona);
        
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
        
        return false;
    }

    function Actualizar_contactos_referencias_cuentas($contactos, $referencias, $cuentas) {
        $sqlContactos = "UPDATE tbl_mn_personas_contacto SET valor = ? WHERE idPersona = ? AND idTipoContacto = ?";
        $resultContactos = $this->cnx->prepare($sqlContactos);
    
        foreach ($contactos as $contacto) {
            
            $valor = $contacto['valor'];
            $idTipoContacto = $contacto['idTipoContacto'];
            $idPersonaContacto = $contacto['idPersona'];
            
            $resultContactos->bindParam(1, $valor);
            $resultContactos->bindParam(2, $idPersonaContacto);
            $resultContactos->bindParam(3, $idTipoContacto);
            $resultContactos->execute();
        }
    
        $sqlReferencias = "UPDATE tbl_mn_referencias_familiares SET idParentesco = ?, nombre = ?, celular = ?, direccion = ?
         WHERE idReferencia = ?";
        $resultReferencias = $this->cnx->prepare($sqlReferencias);
    
        foreach ($referencias as $referencia) {
            
            $idParentesco = $referencia['idParentesco'];
            $nombre = $referencia['nombre'];
            $celular = $referencia['celular'];
            $direccion = $referencia['direccion'];
            $idReferencia = $referencia['idReferencia'];
           
            $resultReferencias->bindParam(1, $idParentesco);
            $resultReferencias->bindParam(2, $nombre);
            $resultReferencias->bindParam(3, $celular);
            $resultReferencias->bindParam(4, $direccion);
            $resultReferencias->bindParam(5, $idReferencia);
            $resultReferencias->execute();
        }
       
        $sqlCuentas = "UPDATE tbl_mn_personas_cuenta SET NumeroCuenta = ? WHERE idPersona = ?";
        $resultCuentas = $this->cnx->prepare($sqlCuentas);
    
        foreach ($cuentas as $cuenta) {
            
            $numeroCuenta = $cuenta['cuenta'];
            $idPersona = $cuenta['idPersona'];
           
            $resultCuentas->bindParam(1, $numeroCuenta);
            $resultCuentas->bindParam(2, $idPersona);
            $resultCuentas->execute();
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

    //funcion actualizar persona dependientes
    function ActualizarPersonaDependiente($nombre, $idPersona){
        
        $query = "UPDATE tbl_mn_personas_dependientes SET  nombre = ? WHERE idPersona = ?";
        $result = $this->cnx->prepare($query); //preparacion de la sentencia
        $result->bindParam(1,$nombre);
        $result->bindParam(2,$idPersona);
       
        if($result->execute()){ //validacion de la ejecucion
            return true;
        }

        return false; //si fallo se devuelvo false
    
    }

    //funcion para traer datos del prestamo
    function datosPrestamos($idTipoPrestamo){ //funcion que trae la tasa
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

    //funcion para actualizar los datos de prestamos de solicitud
    function ActualizarSolicitud($idSolicitud, $idTipoPrestamo, $idRubro, $Monto, $tasa, $Plazo, $FechaDesembolso, $invierteEn, $dictamenAsesor){
        
        $query = "UPDATE tbl_mn_solicitudes_creditos SET  idTipoPrestamo = ?, idRubro = ?, Monto = ?, tasa = ?,
        Plazo = ?, fechaDesembolso = ?, invierteEn = ?, dictamenAsesor = ?  WHERE idSolicitud = ?";
        $result = $this->cnx->prepare($query); //preparacion de la sentencia
        $result->bindParam(1,$idTipoPrestamo);
        $result->bindParam(2,$idRubro);
        $result->bindParam(3,$Monto);
        $result->bindParam(4,$tasa);
        $result->bindParam(5,$Plazo);
        $result->bindParam(6,$FechaDesembolso);
        $result->bindParam(7,$invierteEn);
        $result->bindParam(8,$dictamenAsesor);
        $result->bindParam(9,$idSolicitud);

        if($result->execute()){ //validacion de la ejecucion
            return true;
        }

        return false; //si fallo se devuelvo false
    
    }

    //funcion para actualizar el analisis crediticio
    function ActualizarAnalisisCrediticio($idPersona, $sueldoBase, $ingresosNegocio, $rentaPropiedad, $remesas, $aporteConyugue, $ingresosSociedad,
     $cuotaPrestamoAdepes, $cuotaVivienda, $alimentacion, $deduccionesCentralRiesgo, $otrosEgresos, $LiquidezCliente, $Descripcion){
        
        $query = "UPDATE tbl_mn_analisis_crediticio SET  sueldoBase = ?, ingresosNegocio = ?, rentaPropiedad = ?, remesas = ?,
        aporteConyugue = ?, ingresosSociedad = ?, cuotaPrestamoAdepes = ?, cuotaVivienda = ?, alimentacion = ?, deduccionesCentralRiesgo = ?,
        otrosEgresos = ?, LiquidezCliente = ?, Descripcion = ? WHERE idPersona = ?";
        $result = $this->cnx->prepare($query); //preparacion de la sentencia
        $result->bindParam(1,$sueldoBase);
        $result->bindParam(2,$ingresosNegocio);
        $result->bindParam(3,$rentaPropiedad);
        $result->bindParam(4,$remesas);
        $result->bindParam(5,$aporteConyugue);
        $result->bindParam(6,$ingresosSociedad);
        $result->bindParam(7,$cuotaPrestamoAdepes);
        $result->bindParam(8,$cuotaVivienda);
        $result->bindParam(9,$alimentacion);
        $result->bindParam(10,$deduccionesCentralRiesgo);
        $result->bindParam(11,$otrosEgresos);
        $result->bindParam(12,$LiquidezCliente);
        $result->bindParam(13,$Descripcion);
        $result->bindParam(14,$idPersona);

        if($result->execute()){ //validacion de la ejecucion
            return true;
        }

        return false; //si fallo se devuelvo false
    
    }

    //funcion para actualizar los ingresos del conyuge
    function ActualizarIngresosConyugue($idPersona, $ingresosNegocio, $sueldoBase, $gastoAlimentacion){
        
        $query = "UPDATE tbl_mn_conyugues SET  ingresosNegocio = ?, sueldoBase = ?, gastoAlimentacion = ? WHERE idPersona = ?";
        $result = $this->cnx->prepare($query); //preparacion de la sentencia
        $result->bindParam(1,$ingresosNegocio);
        $result->bindParam(2,$sueldoBase);
        $result->bindParam(3,$gastoAlimentacion);
        $result->bindParam(4,$idPersona);

        if($result->execute()){ //validacion de la ejecucion
            return true;
        }

        return false; //si fallo se devuelvo false
    
    }


    //funcion para traer los id de referencias comerciales
    function idReferenciasComerciales($idPersona) {
        $query = "SELECT idReferenciaComercial FROM tbl_mn_referencias_comerciales WHERE idPersona = ?;"; 
        $result = $this->cnx->prepare($query);
        $result->bindParam(1, $idPersona);
        
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
        
        return false;
    }

    function Actualizar_referencias_comerciales($comerciales) {
        $sqlComerciales = "UPDATE tbl_mn_referencias_comerciales SET nombre = ?, direccion = ? WHERE idReferenciaComercial = ?";
        
        try {
            $this->cnx->beginTransaction();
            
            $resultComerciales = $this->cnx->prepare($sqlComerciales);
    
            foreach ($comerciales as $comerciale) {
                $nombre = $comerciale['nombre'];
                $direccion = $comerciale['direccion'];
                $idPersonaReferencia = $comerciale['idReferenciaComercial'];
                
                $resultComerciales->bindParam(1, $nombre);
                $resultComerciales->bindParam(2, $direccion);
                $resultComerciales->bindParam(3, $idPersonaReferencia);
                $resultComerciales->execute();
            }
    
            $this->cnx->commit();
            return true;
        } catch (PDOException $e) {
            $this->cnx->rollback();
            // Aquí puedes manejar la excepción si es necesario, por ejemplo, escribir en un registro de errores.
            return false;
        }
    }
    

} //fin de la clase






?>