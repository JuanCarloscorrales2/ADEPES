<?php 
session_start();
  require_once "../model/EditarSolicitud.php";
  // Establecer la zona horaria de Honduras
date_default_timezone_set('America/Tegucigalpa');

  //instancia de la clase 
  $editarSoli = new EditarSolicitud();

  switch($_REQUEST["operador"]){

    
    case "listar_tipoPrestamo_select_edit":

        if(isset($_POST["idSolicitud"]) && !empty($_POST["idSolicitud"])){
            $datos = $editarSoli->ListarTipoPrestamo($_POST["idSolicitud"]);
            if($datos){  //valida que traiga datos
                for($i=0; $i<count($datos); $i++){
                    $list[]=array(  //se pone los campos que queremos guardar
                        "0"=>$datos[$i]['idTipoPrestamo'],
                        "1"=>$datos[$i]['Descripcion'],
                        "3"=>$datos[$i]['tasa'],
                    );
                }
                echo json_encode($list); //se devuelve los datos en formato json 
            }
        }
 
    break;

    case "listar_Rubro_select_":

        if(isset($_POST["idSolicitud"]) && !empty($_POST["idSolicitud"])){
            $datos = $editarSoli->ListarRubro($_POST["idSolicitud"]);
            if($datos){  //valida que traiga datos
                for($i=0; $i<count($datos); $i++){
                    $list[]=array(  //se pone los campos que queremos guardar
                        "0"=>$datos[$i]['idRubro'],
                        "1"=>$datos[$i]['Descripcion'],
                    );
                }
                echo json_encode($list); //se devuelve los datos en formato json 
            }
        }
 
    break;

    case "listar_nacionalidad_select_":

        if(isset($_POST["idPersona"]) && !empty($_POST["idPersona"])){
            $datos = $editarSoli->ListarNacionalidad($_POST["idPersona"]);
            if($datos){  //valida que traiga datos
                for($i=0; $i<count($datos); $i++){
                    $list[]=array(  //se pone los campos que queremos guardar
                        "0"=>$datos[$i]['idNacionalidad'],
                        "1"=>$datos[$i]['Descripcion'],
                    );
                }
                echo json_encode($list); //se devuelve los datos en formato json 
            }
        }
 
    break;

    case "listar_contactos":

        if(isset($_POST["idPersona"]) && !empty($_POST["idPersona"])){
            $data = $editarSoli->ListarContactos($_POST["idPersona"]);
            if($data){
                $list[] = array(
                    "TIPO_PERSONA"=>$data['idTipoPersona'],
                    "CELULAR"=>$data['celular'],
                    "DIRECCION"=>$data['direccion'],
                    "TELEFONO"=>$data['telefono'],
                    "DIRECCION_T"=>$data['direccionTrabajo'],
                    "TELEFONO_T"=>$data['telefonoTrabajo'],

                );
                echo json_encode($list);
            }
        }
 
    break;

    case "listar_estadocivil_select":

        if(isset($_POST["idPersona"]) && !empty($_POST["idPersona"])){
            $datos = $editarSoli->ListarEstadoCivil($_POST["idPersona"]);
            if($datos){  //valida que traiga datos
                for($i=0; $i<count($datos); $i++){
                    $list[]=array(  //se pone los campos que queremos guardar
                        "0"=>$datos[$i]['idEstadoCivil'],
                        "1"=>$datos[$i]['Descripcion'],
                    );
                }
                echo json_encode($list); //se devuelve los datos en formato json 
            }
        }
 
    break;

    case "listar_casa_select":

        if(isset($_POST["idPersona"]) && !empty($_POST["idPersona"])){
            $datos = $editarSoli->ListarCasa($_POST["idPersona"]);
            if($datos){  //valida que traiga datos
                for($i=0; $i<count($datos); $i++){
                    $list[]=array(  //se pone los campos que queremos guardar
                        "0"=>$datos[$i]['idcategoriaCasa'],
                        "1"=>$datos[$i]['descripcion'],
                    );
                }
                echo json_encode($list); //se devuelve los datos en formato json 
            }
        }
 
    break;

    case "listar_tiempoVivir_select":

        if(isset($_POST["idPersona"]) && !empty($_POST["idPersona"])){
            $datos = $editarSoli->TiempoVivir($_POST["idPersona"]);
            if($datos){  //valida que traiga datos
                for($i=0; $i<count($datos); $i++){
                    $list[]=array(  //se pone los campos que queremos guardar
                        "0"=>$datos[$i]['idtiempoVivir'],
                        "1"=>$datos[$i]['descripcion'],
                    );
                }
                echo json_encode($list); //se devuelve los datos en formato json 
            }
        }
 
    break;

    case "listar_formaPago_select":

        if(isset($_POST["idPersona"]) && !empty($_POST["idPersona"])){
            $datos = $editarSoli->FormaPagoAlquiler($_POST["idPersona"]);
            if($datos){  //valida que traiga datos
                for($i=0; $i<count($datos); $i++){
                    $list[]=array(  //se pone los campos que queremos guardar
                        "0"=>$datos[$i]['idTipoPago'],
                        "1"=>$datos[$i]['descripcion'],
                    );
                }
                echo json_encode($list); //se devuelve los datos en formato json 
            }
        }
 
    break;

    case "listar_genero_select":

        if(isset($_POST["idPersona"]) && !empty($_POST["idPersona"])){
            $datos = $editarSoli->Genero($_POST["idPersona"]);
            if($datos){  //valida que traiga datos
                for($i=0; $i<count($datos); $i++){
                    $list[]=array(  //se pone los campos que queremos guardar
                        "0"=>$datos[$i]['idGenero'],
                        "1"=>$datos[$i]['Descripcion'],
                    );
                }
                echo json_encode($list); //se devuelve los datos en formato json 
            }
        }
 
    break;

    case "listar_profesion_select":

        if(isset($_POST["idPersona"]) && !empty($_POST["idPersona"])){
            $datos = $editarSoli->Profesion($_POST["idPersona"]);
            if($datos){  //valida que traiga datos
                for($i=0; $i<count($datos); $i++){
                    $list[]=array(  //se pone los campos que queremos guardar
                        "0"=>$datos[$i]['idProfesion'],
                        "1"=>$datos[$i]['Descripcion'],
                    );
                }
                echo json_encode($list); //se devuelve los datos en formato json 
            }
        }
 
    break;

    case "listar_persona_bienes":

        if(isset($_POST["idPersona"]) && !empty($_POST["idPersona"])){
            $datos = $editarSoli->ListarBienesPersona($_POST["idPersona"]);
            if($datos){  //valida que traiga datos
                for($i=0; $i<count($datos); $i++){
                    $list[]=array(  //se pone los campos que queremos guardar
                        "0"=>$datos[$i]['idPersonaBienes'],
                        "1"=>$datos[$i]['Descripcion'],
                    );
                }
                echo json_encode($list); //se devuelve los datos en formato json 
            }
        }
 
    break;

    case "listar_tiempoLaboral_select":

        if(isset($_POST["idPersona"]) && !empty($_POST["idPersona"])){
            $datos = $editarSoli->TiempoLavoral($_POST["idPersona"]);
            if($datos){  //valida que traiga datos
                for($i=0; $i<count($datos); $i++){
                    $list[]=array(  //se pone los campos que queremos guardar
                        "0"=>$datos[$i]['idTiempoLaboral'],
                        "1"=>$datos[$i]['descripcion'],
                    );
                }
                echo json_encode($list); //se devuelve los datos en formato json 
            }
        }
 
    break;

    case "listar_tipoCredito_select":

        if(isset($_POST["idPersona"]) && !empty($_POST["idPersona"])){
            $datos = $editarSoli->TipoCredito($_POST["idPersona"]);
            if($datos){  //valida que traiga datos
                for($i=0; $i<count($datos); $i++){
                    $list[]=array(  //se pone los campos que queremos guardar
                        "0"=>$datos[$i]['idTipoCliente'],
                        "1"=>$datos[$i]['Descripcion'],
                    );
                }
                echo json_encode($list); //se devuelve los datos en formato json 
            }
        }
 
    break;

    case "listar_estadoCredito_select":

        if(isset($_POST["idPersona"]) && !empty($_POST["idPersona"])){
            $datos = $editarSoli->EstadoCredito($_POST["idPersona"]);
            if($datos){  //valida que traiga datos
                for($i=0; $i<count($datos); $i++){
                    $list[]=array(  //se pone los campos que queremos guardar
                        "0"=>$datos[$i]['idEstadoCredito'],
                        "1"=>$datos[$i]['Descripcion'],
                    );
                }
                echo json_encode($list); //se devuelve los datos en formato json 
            }
        }
 
    break;

    case "listar_esAval_select":

        if(isset($_POST["idPersona"]) && !empty($_POST["idPersona"])){
            $datos = $editarSoli->EsAval($_POST["idPersona"]);
            if($datos){  //valida que traiga datos
                for($i=0; $i<count($datos); $i++){
                    $list[]=array(  //se pone los campos que queremos guardar
                        "0"=>$datos[$i]['idEsAval'],
                        "1"=>$datos[$i]['Descripcion'],
                    );
                }
                echo json_encode($list); //se devuelve los datos en formato json 
            }
        }
 
    break;

    case "listar_avalesMora_select":

        if(isset($_POST["idPersona"]) && !empty($_POST["idPersona"])){
            $datos = $editarSoli->AvalesMora($_POST["idPersona"]);
            if($datos){  //valida que traiga datos
                for($i=0; $i<count($datos); $i++){
                    $list[]=array(  //se pone los campos que queremos guardar
                        "0"=>$datos[$i]['idCreditoAval'],
                        "1"=>$datos[$i]['Descripcion'],
                    );
                }
                echo json_encode($list); //se devuelve los datos en formato json 
            }
        }
 
    break;

    case "analisis_crediticio":

        if(isset($_POST["idPersona"]) && !empty($_POST["idPersona"])){
            $data = $editarSoli->AnalisisCredticio($_POST["idPersona"]);
            if($data){
                for($i=0; $i<count($data); $i++){
                    $list[] = array(
                        "sueldoBase"=>$data[$i]['sueldoBase'],
                        "ingresosNegocio"=>$data[$i]['ingresosNegocio'],
                        "rentaPropiedad"=>$data[$i]['rentaPropiedad'],
                        "remesas"=>$data[$i]['remesas'],
                        "aporteConyugue"=>$data[$i]['aporteConyugue'],
                        "ingresosSociedad"=>$data[$i]['ingresosSociedad'],
                        "cuotaPrestamoAdepes"=>$data[$i]['cuotaPrestamoAdepes'],
                        "cuotaVivienda"=>$data[$i]['cuotaVivienda'],
                        "alimentacion"=>$data[$i]['alimentacion'],
                        "deduccionesCentralRiesgo"=>$data[$i]['deduccionesCentralRiesgo'],
                        "otrosEgresos"=>$data[$i]['otrosEgresos'],
                        "LiquidezCliente"=>$data[$i]['LiquidezCliente'],
                        "Descripcion"=>$data[$i]['Descripcion'],

                    );
               }
               
                echo json_encode($list);
            }
        }
 
    break;

    case "conyugue":

        if(isset($_POST["idPersonaPareja"]) && !empty($_POST["idPersonaPareja"])){
            $data = $editarSoli->Conyugue($_POST["idPersonaPareja"]);
            if($data){
                $list[] = array(
                    "IDPERSONA"=>$data['idPersona'],
                    "INGRESOS"=>$data['ingresosNegocio'],
                    "SUELDO"=>$data['sueldoBase'],
                    "ALIMENTACION"=>$data['gastoAlimentacion'],
                    "NACIONALIDAD"=>$data['idNacionalidad'],
                    "GENERO"=>$data['idGenero'],
                    "PROFESION"=>$data['idProfesion'],
                    "TIEMPOLABORAL"=>$data['idtiempoLaboral'],
                    "FORMAPAGO"=>$data['PagaAlquiler'],
                    "TIPOCLIENTE"=>$data['idTipoClientes'],
                    "ESTADOCREDITO"=>$data['estadoCredito'],
                    "ES_AVAL"=>$data['esAval'],
                    "AVAL_MORA"=>$data['avalMora'],
                    "NOMBRE"=>$data['nombres'],
                    "APELLIDO"=>$data['apellidos'],
                    "IDENTIDAD"=>$data['identidad'],
                    "NACIMIENTO"=>$data['fechaNacimiento'],
                    "PATRONO"=>$data['PratronoNegocio'],
                    "CARGO"=>$data['cargoDesempena'],

                );
                echo json_encode($list);
            }
        }
 
    break;

    case "referencias_familiares":

        if(isset($_POST["idPersona"]) && !empty($_POST["idPersona"])){
            $data = $editarSoli->ReferenciasFamiliares($_POST["idPersona"]);
            if($data){
             
                for($i=0; $i<count($data); $i++){
                    $list[]=array(  //se pone los campos que queremos guardar
                        "nombre"=>$data[$i]['nombre'],
                        "celular"=>$data[$i]['celular'],
                        "direccion"=>$data[$i]['direccion'],
                        "idParentesco"=>$data[$i]['idParentesco'],
                        "idReferencia"=>$data[$i]['idReferencia'],
                        
                    );
                }
                echo json_encode($list); //se devuelve los datos en formato json 

               
            }
        }
 
    break;

    case "listar_parentesco_select":

        if(isset($_POST["idReferencia"]) && !empty($_POST["idReferencia"])){
            $datos = $editarSoli->Parentesco($_POST["idReferencia"]);
            if($datos){  //valida que traiga datos
                for($i=0; $i<count($datos); $i++){
                    $list[]=array(  //se pone los campos que queremos guardar
                        "0"=>$datos[$i]['idParentesco'],
                        "1"=>$datos[$i]['descripcion'],
                    );
                }
                echo json_encode($list); //se devuelve los datos en formato json 
            }
        }
 
    break;

    case "personas_dependientes":

        if(isset($_POST["idPersona"]) && !empty($_POST["idPersona"])){
            $data = $editarSoli->PersonasDependientes($_POST["idPersona"]);
            if($data){
                $list[] = array(
                    "observaciones"=>$data['ObservacionesSolicitud'],
                    "nombreDependiente"=>$data['nombre'],
                );
                echo json_encode($list);
            }
        }
 
    break;
    
    
    /*                               AVALES SOLICITUD */
    
    case "datos_avales":

            if(isset($_POST["idSolicitud"]) && !empty($_POST["idSolicitud"])){
                $data = $editarSoli->DatosAval($_POST["idSolicitud"]);
                if($data){
                
                    for($i=0; $i<count($data); $i++){
                        $list[]=array(  //se pone los campos que queremos guardar
                            "idPersona"=>$data[$i]['idPersona'],
                            "nombres"=>$data[$i]['nombres'],
                            "apellidos"=>$data[$i]['apellidos'],
                            "identidad"=>$data[$i]['identidad'],
                            "idSolicitud"=>$data[$i]['idSolicitud'],
                            "fechaNacimiento"=>$data[$i]['fechaNacimiento'],
                            "PratronoNegocio"=>$data[$i]['PratronoNegocio'],
                            "cargoDesempena"=>$data[$i]['cargoDesempena'],
                            "ObservacionesSolicitud"=>$data[$i]['ObservacionesSolicitud'],
                            
                        );
                    }
                    echo json_encode($list); //se devuelve los datos en formato json 

                
                }
            }
 
    break;


    case "referencias_comerciales":

        if(isset($_POST["idPersona"]) && !empty($_POST["idPersona"])){
            $data = $editarSoli->ReferenciasComerciales($_POST["idPersona"]);
            if($data){
             
                for($i=0; $i<count($data); $i++){
                    $list[]=array(  //se pone los campos que queremos guardar
                        "idReferenciaComercial"=>$data[$i]['idReferenciaComercial'],
                        "idPersona"=>$data[$i]['idPersona'],
                        "nombre"=>$data[$i]['nombre'],
                        "direccion"=>$data[$i]['direccion'],
                        
                    );
                }
                echo json_encode($list); //se devuelve los datos en formato json 

               
            }
        }
 
    break;


    case "formato_conozca_asu_Cliente":

        if(isset($_POST["idPersona"]) && !empty($_POST["idPersona"])){
            $data = $editarSoli->FormatoConozcaCliente($_POST["idPersona"]);
            if($data){
                $list[] = array(
                    "civil"=>$data['civil'],
                    "nacionalidad"=>$data['nacionalidad'],
                    "genero"=>$data['genero'],
                    "profesiones"=>$data['profesiones'],
                    "bienesPersona"=>$data['bienesPersona'],
                    "municipio"=>$data['municipio'],
                    "dictamenAsesor"=>$data['dictamenAsesor']
                    
                );
                echo json_encode($list);
            }
        }
 
    break;

    case "persona_cuenta":

        if(isset($_POST["idPersona"]) && !empty($_POST["idPersona"])){
            $data = $editarSoli->PersonasCuenta($_POST["idPersona"]);
            if($data){
                $list[] = array(
                    "NumeroCuenta"=>$data['NumeroCuenta']
                    
                );
                echo json_encode($list);
            }
        }
 
    break;

    case "listar_municipio_select":

        if(isset($_POST["idPersona"]) && !empty($_POST["idPersona"])){
            $datos = $editarSoli->Municipios($_POST["idPersona"]);
            if($datos){  //valida que traiga datos
                for($i=0; $i<count($datos); $i++){
                    $list[]=array(  //se pone los campos que queremos guardar
                        "0"=>$datos[$i]['idMunicipio'],
                        "1"=>$datos[$i]['Descripcion'],
                    );
                }
                echo json_encode($list); //se devuelve los datos en formato json 
            }
        }
 
    break;


    case "Actualizar_Persona":

      $hoy = date('Y-m-d H:i:s');
      //$FechaModificacion = strtotime($hoy);
      $ModificadoPor =  $_SESSION["user"]["Usuario"];
      $idUsuario =  $_SESSION["user"]["idUsuario"];

      $idTipoPersona = 1; //cliente
      $idPersonaEdit = $_POST["idPersonaEdit"];
      $idSolicitudEdit =  $_POST["idSolicitudEdit"];
      $plazo = $_POST["plazo"];
      $monto = $_POST["monto"];
      $idTipoPrestamo =  $_POST["idTipoPrestamo"];
      $rubro = $_POST["rubro"];
      $fechaEmision = $_POST["fechaEmision"];
      $nombreCliente = $_POST["nombreCliente"];
      $apellidoCliente = $_POST["apellidoCliente"];
      $identidadCliente = $_POST["identidad"];
      $fechaNacimiento = $_POST["fechaNacimiento"];
      $idNacionalidad = $_POST["idNacionalidad"];
      $idMunicipio = $_POST["idMunicipio"];
      $direccionCliente = $_POST["direccionCliente"];
      $celularCliente = $_POST["celularCliente"];
      $telefonoCliente = $_POST["telefonoCliente"];
      $direccionTrabajoCliente = $_POST["direccionTrabajoCliente"];
      $telefonoTrabajoCliente = $_POST["telefonoTrabajoCliente"];
      $idEstadoCivil = $_POST["idEstadoCivil"];
      $idcategoriaCasa = $_POST["idcategoriaCasa"];
      $idtiempoVivir = $_POST["idtiempoVivir"];
      $pagaAlquiler = $_POST["pagaAlquiler"];
      $pagoCasa = $_POST["pagoCasa"];
      $idGenero = $_POST["idGenero"];
      $idProfesion = $_POST["idProfesion"];
      $patrono = $_POST["patrono"];
      $actividadDesempenia = $_POST["actividadDesempenia"];
      $idTiempoLaboral = $_POST["idTiempoLaboral"];
      $idTipoClientes = $_POST["idTipoClientes"];
      $cuentaCliente = $_POST["cuentaCliente"];
      $esAval = $_POST["esAval"];
      $avalMora = $_POST["avalMora"];
      $estadoCredito = $_POST["estadoCredito"];

      //referencias familiares
      $nombreR1 = $_POST["nombreR1"];
      $parestencosR1 = $_POST["parestencosR1"];
      $celularR1 = $_POST["celularR1"];
      $direccionR1 = $_POST["direccionR1"];
      $nombreR2 = $_POST["nombreR2"];
      $parestencosR2 = $_POST["parestencosR2"];
      $celularR2 = $_POST["celularR2"];
      $direccionR2 = $_POST["direccionR2"];
        //informacion adicional
      $invierteEn = $_POST["invierteEn"];
      $idBienes = $_POST["idBienes"];
      $dependientes = $_POST["dependientes"];
      $ObservacionesSolicitud = $_POST["ObservacionesSolicitud"];
      //dictamen asesor
      $dictamenAsesor = $_POST["dictamenAsesor"];
      //analisisCrediticio
      $sueldoBase = $_POST["sueldoBase"];
      $ingresosNegocio = $_POST["ingresosNegocio"];
      $RentaPropiedad =  $_POST["RentaPropiedad"];
      $remesas = $_POST["remesas"];
      $aporteConyuge = $_POST["aporteConyuge"];
      $IngresosSociedad =  $_POST["IngresosSociedad"];
      $cuotaPrestamoAdepes = $_POST["cuotaPrestamoAdepes"];
      $cuotaVivienda = $_POST["cuotaVivienda"];
      $alimentacion = $_POST["alimentacion"];
      $deduccionesCentral = $_POST["deduccionesCentral"];
      $otrosEgresos = $_POST["otrosEgresos"];
      $liquidezCliente = $_POST["liquidezCliente"];
      $evaluacionAnalisis = $_POST["evaluacionAnalisis"];
      //Datos pareja
      $idPareja = $_POST["idPareja"];
      $nombresPareja = $_POST["nombresPareja"];
      $apellidosPareja =  $_POST["apellidosPareja"];
      $identidadPareja = $_POST["identidadPareja"];
      $fechaNacimientoPareja = $_POST["fechaNacimientoPareja"];
      $idMunicipioPareja =  $_POST["idMunicipioPareja"];
      $idGeneroPareja =  $_POST["idGeneroPareja"];
      $actividadDesempeniaPareja =  $_POST["actividadDesempeniaPareja"];
      $idTiempoLaboralPareja =  $_POST["idTiempoLaboralPareja"];
      $idProfesionPareja =  $_POST["idProfesionPareja"];
      $patronoPareja =  $_POST["patronoPareja"];
      $idTipoClientesPareja =  $_POST["idTipoClientesPareja"];
      $direccionPareja =  $_POST["direccionPareja"];
      $celularPareja =  $_POST["celularPareja"];
      $telefonoPareja =  $_POST["telefonoPareja"];
      $direccionTrabajoPareja =  $_POST["direccionTrabajoPareja"];
      $telefonoTrabajoPareja =  $_POST["telefonoTrabajoPareja"];
      $ingresoNegocioPareja =  $_POST["ingresoNegocioPareja"];
      $sueldoBasePareja =  $_POST["sueldoBasePareja"];
      $gastoAlimentacionPareja =  $_POST["gastoAlimentacionPareja"];
      $cuotaPareja =  $_POST["cuotaPareja"];
      $cuentaPareja =  $_POST["cuentaPareja"];
      $esAvalPareja =  $_POST["esAvalPareja"];
      $avalMoraPareja =  $_POST["avalMoraPareja"];
      $estadoCreditoPareja =  $_POST["estadoCreditoPareja"];
  
     

      if($prestamo = $editarSoli->datosPrestamos($idTipoPrestamo) ){ //trae datos del prestamo
        foreach ($prestamo as $campos => $valor){
           $IDPRESTAMO["prestamo"][$campos] = $valor; //ALMACENA EL numero de intentos DE INTENTOS
        }
      }
      $tasa = $IDPRESTAMO["prestamo"]["tasa"];



      if($monto > $IDPRESTAMO["prestamo"]["montoMaximo"] ){
        $response ="montoMayor";
       
      }else if($monto < $IDPRESTAMO["prestamo"]["montoMinimo"]){
        $response ="montoMinimo";
        
      }else if($plazo > $IDPRESTAMO["prestamo"]["PlazoMaximo"]){
        $response ="plazoMaximo";
        
      }else if($idEstadoCivil == 2 || $idEstadoCivil == 3){

        if($nombresPareja == ""){
            $response = "nombrePareja";
         
         }else if($apellidosPareja == ""){
            $response = "apellidoPareja";
   
         }else if($identidadPareja == ""){
            $response = "identidadPareja";
         }else if($identidadPareja == "0000-0000-00000" || $identidadPareja == "1111-1111-11111" || strlen($identidadPareja) <15 ){
            $response = "identidadIncorrecta";
   
         //casado o en union libre
         }else if($editarSoli->ActualizarPersona($idPersonaEdit, $idNacionalidad, $idGenero, $idEstadoCivil, $idProfesion, $idBienes, 
            $idTipoClientes, $idcategoriaCasa, $idtiempoVivir, $idTiempoLaboral, $pagaAlquiler, $estadoCredito, $esAval, $avalMora, $idMunicipio,
            $nombreCliente, $apellidoCliente, $identidadCliente, $fechaNacimiento, $patrono, $actividadDesempenia, $ObservacionesSolicitud, $ModificadoPor)){
            
            //actualizacion de los datos de la pareja;
            $editarSoli->ActualizarPersona($idPareja, 1, $idGeneroPareja, $idEstadoCivil, $idProfesionPareja, null, 
            $idTipoClientesPareja, $idcategoriaCasa, $idtiempoVivir, $idTiempoLaboralPareja, $pagaAlquiler, $estadoCreditoPareja, $esAvalPareja, $avalMoraPareja, $idMunicipioPareja,
            $nombresPareja, $apellidosPareja, $identidadPareja, $fechaNacimientoPareja, $patronoPareja, $actividadDesempeniaPareja, null, $ModificadoPor);

            //actualiza los ingresos de la persona
            $editarSoli->ActualizarIngresosConyugue($idPareja, $ingresoNegocioPareja, $sueldoBasePareja, $gastoAlimentacionPareja);
            //CONTACTOS
            $contactos = array(
                //solicitante
                array('valor' => $celularCliente, 'idTipoContacto' => 1,  'idPersona' => $idPersonaEdit),
                array('valor' => $direccionCliente, 'idTipoContacto' => 2,  'idPersona' => $idPersonaEdit),
                array('valor' => $telefonoCliente, 'idTipoContacto' => 3,  'idPersona' => $idPersonaEdit),
                array('valor' => $direccionTrabajoCliente, 'idTipoContacto' => 4,  'idPersona' => $idPersonaEdit),
                array('valor' => $telefonoTrabajoCliente, 'idTipoContacto' => 5, 'idPersona' => $idPersonaEdit),
                //pareja
                array('valor' => $celularPareja, 'idTipoContacto' => 1,  'idPersona' => $idPareja),
                array('valor' => $direccionPareja, 'idTipoContacto' => 2,  'idPersona' => $idPareja),
                array('valor' => $telefonoPareja, 'idTipoContacto' => 3,  'idPersona' => $idPareja),
                array('valor' => $direccionTrabajoPareja, 'idTipoContacto' => 4,  'idPersona' => $idPareja),
                array('valor' => $telefonoTrabajoPareja, 'idTipoContacto' => 5, 'idPersona' => $idPareja),
            );   

            //trae el id para actualizar las referencias
            $idReferenciaFamiliares = $editarSoli->idReferenciasFamiliares($idPersonaEdit);
            
            $referencias = array( //arreglo las referencias
                //solicitante
                array('idParentesco' => $parestencosR1, 'nombre' => $nombreR1, 'celular' => $celularR1, 'direccion' => $direccionR1, 'idReferencia' => $idReferenciaFamiliares[0]['idReferencia']),
                array('idParentesco' => $parestencosR2, 'nombre' => $nombreR2, 'celular' => $celularR2, 'direccion' => $direccionR2, 'idReferencia' => $idReferenciaFamiliares[1]['idReferencia']),
            
            ); 
            //cuentas
            $cuentas = array( //arreglo las referencias
                //solicitante
                array('cuenta'=>$cuentaCliente, 'idPersona' =>$idPersonaEdit),
                //pareja
                 array('cuenta'=>$cuentaPareja, 'idPersona' =>$idPareja),
            
            ); 
            //actualiza los contactos y referencias
            $editarSoli->Actualizar_contactos_referencias_cuentas($contactos, $referencias, $cuentas);
            //actualiza las personas dependientes
            $editarSoli->ActualizarPersonaDependiente($dependientes, $idPersonaEdit);
            //actualiza la solicitud
            
            $editarSoli->ActualizarSolicitud($idSolicitudEdit, $idTipoPrestamo, $rubro, $monto, $tasa, $plazo, $fechaEmision, $invierteEn, $dictamenAsesor);
            
           
            //Actualizar analisis crediticio
            $editarSoli->ActualizarAnalisisCrediticio($idPersonaEdit, $sueldoBase, $ingresosNegocio, $RentaPropiedad, $remesas, $aporteConyuge, $IngresosSociedad,
            $cuotaPrestamoAdepes, $cuotaVivienda, $alimentacion, $deduccionesCentral, $otrosEgresos, $liquidezCliente, $evaluacionAnalisis);

            //registro de modificacion en bitacora
            $descripcionB = "Modifico las solicitud del cliente: ".$nombreCliente." ".$apellidoCliente;
            $editarSoli->RegistrarBitacora($idUsuario, 6, "Modifico", $descripcionB);

            $response ="success";

        
        }else{
            $response = "error";
        }


      }else if($idEstadoCivil == 1 || $idEstadoCivil == 4){ //soltero o no definido
        if($prueba =$editarSoli->ActualizarPersona($idPersonaEdit, $idNacionalidad, $idGenero, $idEstadoCivil, $idProfesion, $idBienes, 
            $idTipoClientes, $idcategoriaCasa, $idtiempoVivir, $idTiempoLaboral, $pagaAlquiler, $estadoCredito, $esAval, $avalMora, $idMunicipio,
            $nombreCliente, $apellidoCliente, $identidadCliente, $fechaNacimiento, $patrono, $actividadDesempenia, $ObservacionesSolicitud, $ModificadoPor)){
            

            //CONTACTOS
            $contactos = array(
                //solicitante
                array('valor' => $celularCliente, 'idTipoContacto' => 1,  'idPersona' => $idPersonaEdit),
                array('valor' => $direccionCliente, 'idTipoContacto' => 2,  'idPersona' => $idPersonaEdit),
                array('valor' => $telefonoCliente, 'idTipoContacto' => 3,  'idPersona' => $idPersonaEdit),
                array('valor' => $direccionTrabajoCliente, 'idTipoContacto' => 4,  'idPersona' => $idPersonaEdit),
                array('valor' => $telefonoTrabajoCliente, 'idTipoContacto' => 5, 'idPersona' => $idPersonaEdit),
            );   

            //trae el id para actualizar las referencias
            $idReferenciaFamiliares = $editarSoli->idReferenciasFamiliares($idPersonaEdit);
            
            $referencias = array( //arreglo las referencias
                //solicitante
                array('idParentesco' => $parestencosR1, 'nombre' => $nombreR1, 'celular' => $celularR1, 'direccion' => $direccionR1, 'idReferencia' => $idReferenciaFamiliares[0]['idReferencia']),
                array('idParentesco' => $parestencosR2, 'nombre' => $nombreR2, 'celular' => $celularR2, 'direccion' => $direccionR2, 'idReferencia' => $idReferenciaFamiliares[1]['idReferencia']),
            
            ); 
            //cuentas
            $cuentas = array( //arreglo las referencias
                //solicitante
                array('cuenta'=>$cuentaCliente, 'idPersona' =>$idPersonaEdit),
            ); 
            //actualiza los contactos y referencias
            $editarSoli->Actualizar_contactos_referencias_cuentas($contactos, $referencias, $cuentas);
            //actualiza las personas dependientes
            $editarSoli->ActualizarPersonaDependiente($dependientes, $idPersonaEdit);
            //actualiza la solicitud
            
            $editarSoli->ActualizarSolicitud($idSolicitudEdit, $idTipoPrestamo, $rubro, $monto, $tasa, $plazo, $fechaEmision, $invierteEn, $dictamenAsesor);
            
            
            //Actualizar analisis crediticio
            $editarSoli->ActualizarAnalisisCrediticio($idPersonaEdit, $sueldoBase, $ingresosNegocio, $RentaPropiedad, $remesas, $aporteConyuge, $IngresosSociedad,
            $cuotaPrestamoAdepes, $cuotaVivienda, $alimentacion, $deduccionesCentral, $otrosEgresos, $liquidezCliente, $evaluacionAnalisis);
            //registro de modificacion en bitacora
            $descripcionB = "Modifico las solicitud del cliente: ".$nombreCliente." ".$apellidoCliente;
            $editarSoli->RegistrarBitacora($idUsuario, 6, "Modifico", $descripcionB);
            
            $response ="success";
        }else{
            $response = "error";
        }

      }else{
        $response = "error";
      }
      
        
 

      echo $response;

    break;

    case "Actualizar_aval1":

        $ModificadoPor =  $_SESSION["user"]["Usuario"];
        //datos del aval
        $idPersonaAvalEdit = $_POST["idPersonaAvalEdit"];
        $nombreAval1 = $_POST["nombreAval1"];
        $apellidoAval1 = $_POST["apellidoAval1"];
        $identidadAval1 = $_POST["identidadAval1"];
        $fechaNacimientoAval1 = $_POST["fechaNacimientoAval1"];
        $idNacionalidadAval1 = $_POST["idNacionalidadAval1"];
        $idMunicipioAval1 = $_POST["idMunicipioAval1"];
        $direccionAval1 = $_POST["direccionAval1"];
        $celularAval1 = $_POST["celularAval1"];
        $telefonoAval1 = $_POST["telefonoAval1"];
        $direccionTrabajoAval1 = $_POST["direccionTrabajoAval1"];
        $telefonoTrabajoAval1 = $_POST["telefonoTrabajoAval1"];
    
        $idEstadoCivilAval1 = $_POST["idEstadoCivilAval1"]; 
        $idcategoriaCasaAval1 = $_POST["idcategoriaCasaAval1"];
        $idtiempoVivirAval1 = $_POST["idtiempoVivirAval1"];
        $pagaAlquilerAval1 = $_POST["pagaAlquilerAval1"];
        $pagoCasaAval1 = $_POST["pagoCasaAval1"];
        $idGeneroAval1 = $_POST["idGeneroAval1"];
        $idProfesionAval1 = $_POST["idProfesionAval1"];
        $patronoAval1 = $_POST["patronoAval1"];
        $actividadDesempeniaAval1 = $_POST["actividadDesempeniaAval1"];
        $idTiempoLaboralAval1 = $_POST["idTiempoLaboralAval1"];
        $idTipoClientesAval1 = $_POST["idTipoClientesAval1"];
        
        $cuentaAval1 = $_POST["cuentaAval1"];
        $esAvalAval1 = $_POST["esAvalAval1"];
        $avalMoraAval1 = $_POST["avalMoraAval1"];
        $estadoCreditoAval1 = $_POST["estadoCreditoAval1"];
        
        //referencias Familiares
        $nombreR1Aval1 = $_POST["nombreR1Aval1"];
        $parestencosR1Aval1 = $_POST["parestencosR1Aval1"];
        $celularR1Aval1 = $_POST["celularR1Aval1"];
        $direccionR1Aval1 = $_POST["direccionR1Aval1"];
        $nombreR2Aval1 = $_POST["nombreR2Aval1"];
        $parestencosR2Aval1 = $_POST["parestencosR2Aval1"];
        $celularR2Aval1 = $_POST["celularR2Aval1"];
        $direccionR2Aval1 = $_POST["direccionR2Aval1"];
        $ObservacionesSolicitudAval1 = $_POST["ObservacionesSolicitudAval1"];
        //referencias comerciales
        $nombreComercial1AVAL1 = $_POST["nombreComercial1AVAL1"];
        $direccionComercial1AVAL1 = $_POST["direccionComercial1AVAL1"];
        $nombreComercial2AVAL1 = $_POST["nombreComercial2AVAL1"];
        $direccionComercial2AVAL1 = $_POST["direccionComercial2AVAL1"];
        //analisisCrediticio
        $sueldoBase_analisisAval1 = $_POST["sueldoBase_analisisAval1"];
        $ingresosNegocioAval1 = $_POST["ingresosNegocioAval1"];
        $rentaAval1 = $_POST["rentaAval1"];
        $remesasAval1 = $_POST["remesasAval1"];
        $aporteConyugeAval1 = $_POST["aporteConyugeAval1"];
        $sociedadAval1 = $_POST["sociedadAval1"];
    
        $cuotaAdepesAval1 = $_POST["cuotaAdepesAval1"];
        $viviendaAval1= $_POST["viviendaAval1"];
        $alimentacionAval1= $_POST["alimentacionAval1"];
        $centralRiesgoAval1 = $_POST["centralRiesgoAval1"];
        $otrosEgresosAval1 = $_POST["otrosEgresosAval1"];
        $capitalDisponibleAval1 = $_POST["capitalDisponibleAval1"];
        $evaluacionAval1 = $_POST["evaluacionAval1"];
        //Datos pareja
        $idParejaAval1 = $_POST["idParejaAval1"];
        $nombresParejaAval1 = $_POST["nombresParejaAval1"];
        $apellidosParejaAval1 = $_POST["apellidosParejaAval1"];
        $identidadParejaAval1 = $_POST["identidadParejaAval1"];
        $fechaNacimientoParejaAval1 = $_POST["fechaNacimientoParejaAval1"];
        $municipioParejaAval1 = $_POST["municipioParejaAval1"]; 
        $generoParejaAval1 = $_POST["generoParejaAval1"]; 
        $actividadParejaAval1 = $_POST["actividadParejaAval1"];
        $tiempoLaboralParejaAval1 = $_POST["tiempoLaboralParejaAval1"];
        $profesionParejaAval1 = $_POST["profesionParejaAval1"];
        $patronoParejaAval1 = $_POST["patronoParejaAval1"];
        $tipoClienteParejaAval1 = $_POST["tipoClienteParejaAval1"];
        $direccionParejaAval1 = $_POST["direccionParejaAval1"];
        $celularParejaAval1 = $_POST["celularParejaAval1"];
        $telefonoParejaAval1 = $_POST["telefonoParejaAval1"];
        $direccionTrabajoParejaAval1 = $_POST["direccionTrabajoParejaAval1"];
        $telefonoParejaTrabajoAval1 = $_POST["telefonoParejaTrabajoAval1"];
        $ingresoNegocioParejaAval1 = $_POST["ingresoNegocioParejaAval1"];
        $sueldoBaseParejaAval1 = $_POST["sueldoBaseParejaAval1"];
        $gastoAlimentacionParejaAval1 = $_POST["gastoAlimentacionParejaAval1"];
        $cuotaParejaAval1 = $_POST["cuotaParejaAval1"];
        $cuentaParejaAval1 = $_POST["cuentaParejaAval1"];
        $esAvalParejaAVAL1 = $_POST["esAvalParejaAVAL1"];
        $avalMoraParejaAVAL1 = $_POST["avalMoraParejaAVAL1"];
        $estadoCreditoParejaAVAL1 = $_POST["estadoCreditoParejaAVAL1"];
  
  
    

        if($idEstadoCivilAval1 == 2 || $idEstadoCivilAval1 == 3){
  
            if($nombresParejaAval1 == ""){
                $response = "nombrePareja";
            
            }else if($apellidosParejaAval1 == ""){
                $response = "apellidoPareja";
        
            }else if($identidadParejaAval1 == ""){
                $response = "identidadPareja";
            }else if($identidadParejaAval1 == "0000-0000-00000" || $identidadParejaAval1 == "1111-1111-11111" || strlen($identidadParejaAval1) <15 ){
                $response = "identidadIncorrecta";
        
            //casado o en union libre
            }else if($editarSoli->ActualizarPersona($idPersonaAvalEdit, $idNacionalidadAval1, $idGeneroAval1, $idEstadoCivilAval1, $idProfesionAval1, null, 
            $idTipoClientesAval1, $idcategoriaCasaAval1, $idtiempoVivirAval1, $idTiempoLaboralAval1, $pagaAlquilerAval1, $estadoCreditoAval1, $esAvalAval1, $avalMoraAval1, $idMunicipioAval1,
            $nombreAval1, $apellidoAval1, $identidadAval1, $fechaNacimientoAval1, $patronoAval1, $actividadDesempeniaAval1, $ObservacionesSolicitudAval1, $ModificadoPor) ){
                
                //actualizacion de los datos de la pareja;
                $editarSoli->ActualizarPersona($idParejaAval1, 1, $generoParejaAval1, $idEstadoCivilAval1, $profesionParejaAval1, null, 
                $tipoClienteParejaAval1, $idcategoriaCasaAval1, $idtiempoVivirAval1, $tiempoLaboralParejaAval1, $pagaAlquilerAval1, $estadoCreditoParejaAVAL1, $esAvalParejaAVAL1, $avalMoraParejaAVAL1, $municipioParejaAval1,
                $nombresParejaAval1, $apellidosParejaAval1, $identidadParejaAval1, $fechaNacimientoParejaAval1, $patronoParejaAval1, $actividadParejaAval1, null, $ModificadoPor);
    
                //actualiza los ingresos de la persona
                $editarSoli->ActualizarIngresosConyugue($idParejaAval1, $ingresoNegocioParejaAval1, $sueldoBaseParejaAval1, $gastoAlimentacionParejaAval1);
                //CONTACTOS
                $contactos = array(
                    //Aval 1
                    array('valor' => $celularAval1, 'idTipoContacto' => 1,  'idPersona' => $idPersonaAvalEdit),
                    array('valor' => $direccionAval1, 'idTipoContacto' => 2,  'idPersona' => $idPersonaAvalEdit),
                    array('valor' => $telefonoAval1, 'idTipoContacto' => 3,  'idPersona' => $idPersonaAvalEdit),
                    array('valor' => $direccionTrabajoAval1, 'idTipoContacto' => 4,  'idPersona' => $idPersonaAvalEdit),
                    array('valor' => $telefonoTrabajoAval1, 'idTipoContacto' => 5, 'idPersona' => $idPersonaAvalEdit),
                    //pareja aval 1
                    array('valor' => $celularParejaAval1, 'idTipoContacto' => 1,  'idPersona' => $idParejaAval1),
                    array('valor' => $direccionParejaAval1, 'idTipoContacto' => 2,  'idPersona' => $idParejaAval1),
                    array('valor' => $telefonoParejaAval1, 'idTipoContacto' => 3,  'idPersona' => $idParejaAval1),
                    array('valor' => $direccionTrabajoParejaAval1, 'idTipoContacto' => 4,  'idPersona' => $idParejaAval1),
                    array('valor' => $telefonoParejaTrabajoAval1, 'idTipoContacto' => 5, 'idPersona' => $idParejaAval1),
                );   
    
                //trae el id para actualizar las referencias
                $idReferenciaFamiliares = $editarSoli->idReferenciasFamiliares($idPersonaAvalEdit);
                
                $referencias = array( //arreglo las referencias
                    //solicitante
                    array('idParentesco' => $parestencosR1Aval1, 'nombre' => $nombreR1Aval1, 'celular' => $celularR1Aval1, 'direccion' => $direccionR1Aval1, 'idReferencia' => $idReferenciaFamiliares[0]['idReferencia']),
                    array('idParentesco' => $parestencosR2Aval1, 'nombre' => $nombreR2Aval1, 'celular' => $celularR2Aval1, 'direccion' => $direccionR2Aval1, 'idReferencia' => $idReferenciaFamiliares[1]['idReferencia']),
                ); 
                //cuentas
                $cuentas = array( //arreglo las referencias
                    //solicitante
                    array('cuenta'=>$cuentaAval1, 'idPersona' =>$idPersonaAvalEdit),
                    //pareja
                    array('cuenta'=>$cuentaParejaAval1, 'idPersona' =>$idParejaAval1),
                
                ); 
                //actualiza los contactos y referencias
                $editarSoli->Actualizar_contactos_referencias_cuentas($contactos, $referencias, $cuentas);

                //trae el id para actualizar las referencias comerciales
                $idReferenciaComercial = $editarSoli->idReferenciasComerciales($idPersonaAvalEdit);
                //REFERENCIAS COMERCIALES
                $comerciales = array(
                    //solicitante
                    array('nombre' => $nombreComercial1AVAL1, 'direccion' => $direccionComercial1AVAL1,  'idReferenciaComercial' => $idReferenciaComercial[0]['idReferenciaComercial']),
                    array('nombre' => $nombreComercial2AVAL1, 'direccion' => $direccionComercial2AVAL1,  'idReferenciaComercial' => $idReferenciaComercial[1]['idReferenciaComercial'])
                ); 
                //actualiza las referencias comerciales
                $editarSoli->Actualizar_referencias_comerciales($comerciales);
            
                //Actualizar analisis crediticio
                $editarSoli->ActualizarAnalisisCrediticio($idPersonaAvalEdit, $sueldoBase_analisisAval1, $ingresosNegocioAval1, $rentaAval1, $remesasAval1, $aporteConyugeAval1, $sociedadAval1,
                $cuotaAdepesAval1, $viviendaAval1, $alimentacionAval1, $centralRiesgoAval1, $otrosEgresosAval1, $capitalDisponibleAval1, $evaluacionAval1);
    
                
                $response ="success";
            
            }else{
                $response = "error";
            }
  
  
        }else if($idEstadoCivilAval1 == 1 || $idEstadoCivilAval1 == 4){ //soltero o no definido

          if($editarSoli->ActualizarPersona($idPersonaAvalEdit, $idNacionalidadAval1, $idGeneroAval1, $idEstadoCivilAval1, $idProfesionAval1, null, 
              $idTipoClientesAval1, $idcategoriaCasaAval1, $idtiempoVivirAval1, $idTiempoLaboralAval1, $pagaAlquilerAval1, $estadoCreditoAval1, $esAvalAval1, $avalMoraAval1, $idMunicipioAval1,
              $nombreAval1, $apellidoAval1, $identidadAval1, $fechaNacimientoAval1, $patronoAval1, $actividadDesempeniaAval1, $ObservacionesSolicitudAval1, $ModificadoPor)){
              
  
              //CONTACTOS
              $contactos = array(
                  //solicitante
                  array('valor' => $celularAval1, 'idTipoContacto' => 1,  'idPersona' => $idPersonaAvalEdit),
                  array('valor' => $direccionAval1, 'idTipoContacto' => 2,  'idPersona' => $idPersonaAvalEdit),
                  array('valor' => $telefonoAval1, 'idTipoContacto' => 3,  'idPersona' => $idPersonaAvalEdit),
                  array('valor' => $direccionTrabajoAval1, 'idTipoContacto' => 4,  'idPersona' => $idPersonaAvalEdit),
                  array('valor' => $telefonoTrabajoAval1, 'idTipoContacto' => 5, 'idPersona' => $idPersonaAvalEdit),
              );   
  
              //trae el id para actualizar las referencias
              $idReferenciaFamiliares = $editarSoli->idReferenciasFamiliares($idPersonaAvalEdit);
              
              $referencias = array( //arreglo las referencias
                  //solicitante
                  array('idParentesco' => $parestencosR1Aval1, 'nombre' => $nombreR1Aval1, 'celular' => $celularR1Aval1, 'direccion' => $direccionR1Aval1, 'idReferencia' => $idReferenciaFamiliares[0]['idReferencia']),
                  array('idParentesco' => $parestencosR2Aval1, 'nombre' => $nombreR2Aval1, 'celular' => $celularR2Aval1, 'direccion' => $direccionR2Aval1, 'idReferencia' => $idReferenciaFamiliares[1]['idReferencia']),
              ); 
              //cuentas
              $cuentas = array( //arreglo las referencias
                  //solicitante
                  array('cuenta'=>$cuentaAval1, 'idPersona' =>$idPersonaAvalEdit),
              ); 
              //actualiza los contactos y referencias
              $editarSoli->Actualizar_contactos_referencias_cuentas($contactos, $referencias, $cuentas);

              //trae el id para actualizar las referencias comerciales
              $idReferenciaComercial = $editarSoli->idReferenciasComerciales($idPersonaAvalEdit);
              //REFERENCIAS COMERCIALES
              $comerciales = array(
                //solicitante
                array('nombre' => $nombreComercial1AVAL1, 'direccion' => $direccionComercial1AVAL1,  'idReferenciaComercial' => $idReferenciaComercial[0]['idReferenciaComercial']),
                array('nombre' => $nombreComercial2AVAL1, 'direccion' => $direccionComercial2AVAL1,  'idReferenciaComercial' => $idReferenciaComercial[1]['idReferenciaComercial'])
             ); 
             //actualiza las referencias comerciales
             $editarSoli->Actualizar_referencias_comerciales($comerciales);
   
              //Actualizar analisis crediticio
              $editarSoli->ActualizarAnalisisCrediticio($idPersonaAvalEdit, $sueldoBase_analisisAval1, $ingresosNegocioAval1, $rentaAval1, $remesasAval1, $aporteConyugeAval1, $sociedadAval1,
              $cuotaAdepesAval1, $viviendaAval1, $alimentacionAval1, $centralRiesgoAval1, $otrosEgresosAval1, $capitalDisponibleAval1, $evaluacionAval1);
  
              $response ="success";
          }else{
              $response = "error";
          }
  
        }else{
          $response = "error";
        }
        
          
   
  
        echo $response;
  
    break;


    
    case "Actualizar_aval2":

        $ModificadoPor =  $_SESSION["user"]["Usuario"];
        //datos del aval
        $idPersonaAval2 = $_POST["idPersonaAval2"];
        $nombreAval2 = $_POST["nombreAval2"];
        $apellidoAval2 = $_POST["apellidoAval2"];
        $identidadAval2 = $_POST["identidadAval2"];
        $fechaNacimientoAval2 = $_POST["fechaNacimientoAval2"];
        $idNacionalidadAval2 = $_POST["idNacionalidadAval2"];
        $idMunicipioAval2 = $_POST["idMunicipioAval2"];
        $direccionAval2 = $_POST["direccionAval2"];
        $celularAval2 = $_POST["celularAval2"];
        $telefonoAval2 = $_POST["telefonoAval2"];
        $direccionTrabajoAval2 = $_POST["direccionTrabajoAval2"];
        $telefonoTrabajoAval2 = $_POST["telefonoTrabajoAval2"];
    
        $idEstadoCivilAval2 = $_POST["idEstadoCivilAval2"]; 
        $idcategoriaCasaAval2 = $_POST["idcategoriaCasaAval2"];
        $idtiempoVivirAval2 = $_POST["idtiempoVivirAval2"];
        $pagaAlquilerAval2 = $_POST["pagaAlquilerAval2"];
        $pagoCasaAval2 = $_POST["pagoCasaAval2"];
        $idGeneroAval2 = $_POST["idGeneroAval2"];
        $idProfesionAval2 = $_POST["idProfesionAval2"];
        $patronoAval2 = $_POST["patronoAval2"];
        $actividadDesempeniaAval2 = $_POST["actividadDesempeniaAval2"];
        $idTiempoLaboralAval2 = $_POST["idTiempoLaboralAval2"];
        $idTipoClientesAval2 = $_POST["idTipoClientesAval2"];
        
        $cuentaAval2 = $_POST["cuentaAval2"];
        $esAvalAval2 = $_POST["esAvalAval2"];
        $avalMoraAval2 = $_POST["avalMoraAval2"];
        $estadoCreditoAval2 = $_POST["estadoCreditoAval2"];
        
        //referencias Familiares
        $nombreR1Aval2 = $_POST["nombreR1Aval2"];
        $parestencosR1Aval2 = $_POST["parestencosR1Aval2"];
        $celularR1Aval2 = $_POST["celularR1Aval2"];
        $direccionR1Aval2 = $_POST["direccionR1Aval2"];
        $nombreR2Aval2 = $_POST["nombreR2Aval2"];
        $parestencosR2Aval2 = $_POST["parestencosR2Aval2"];
        $celularR2Aval2 = $_POST["celularR2Aval2"];
        $direccionR2Aval2 = $_POST["direccionR2Aval2"];
        $ObservacionesSolicitudAval2 = $_POST["ObservacionesSolicitudAval2"];
        //referencias comerciales
        $nombreComercial1AVAL2 = $_POST["nombreComercial1AVAL2"];
        $direccionComercial1AVAL2 = $_POST["direccionComercial1AVAL2"];
        $nombreComercial2AVAL2 = $_POST["nombreComercial2AVAL2"];
        $direccionComercial2AVAL2 = $_POST["direccionComercial2AVAL2"];
        //analisisCrediticio
        $sueldoBase_analisisAval2 = $_POST["sueldoBase_analisisAval2"];
        $ingresosNegocioAval2 = $_POST["ingresosNegocioAval2"];
        $rentaAval2 = $_POST["rentaAval2"];
        $remesasAval2 = $_POST["remesasAval2"];
        $aporteConyugeAval2 = $_POST["aporteConyugeAval2"];
        $sociedadAval2 = $_POST["sociedadAval2"];
    
        $cuotaAdepesAval2 = $_POST["cuotaAdepesAval2"];
        $viviendaAval2= $_POST["viviendaAval2"];
        $alimentacionAval2= $_POST["alimentacionAval2"];
        $centralRiesgoAval2 = $_POST["centralRiesgoAval2"];
        $otrosEgresosAval2 = $_POST["otrosEgresosAval2"];
        $capitalDisponibleAval2 = $_POST["capitalDisponibleAval2"];
        $evaluacionAval2 = $_POST["evaluacionAval2"];
        //Datos pareja
        $idParejaAval2 = $_POST["idParejaAval2"];
        $nombresParejaAval2 = $_POST["nombresParejaAval2"];
        $apellidosParejaAval2 = $_POST["apellidosParejaAval2"];
        $identidadParejaAval2 = $_POST["identidadParejaAval2"];
        $fechaNacimientoParejaAval2 = $_POST["fechaNacimientoParejaAval2"];
        $municipioParejaAval2 = $_POST["municipioParejaAval2"]; 
        $generoParejaAval2 = $_POST["generoParejaAval2"]; 
        $actividadParejaAval2 = $_POST["actividadParejaAval2"];
        $tiempoLaboralParejaAval2 = $_POST["tiempoLaboralParejaAval2"];
        $profesionParejaAval2 = $_POST["profesionParejaAval2"];
        $patronoParejaAval2 = $_POST["patronoParejaAval2"];
        $tipoClienteParejaAval2 = $_POST["tipoClienteParejaAval2"];
        $direccionParejaAval2 = $_POST["direccionParejaAval2"];
        $celularParejaAval2 = $_POST["celularParejaAval2"];
        $telefonoParejaAval2 = $_POST["telefonoParejaAval2"];
        $direccionTrabajoParejaAval2 = $_POST["direccionTrabajoParejaAval2"];
        $telefonoParejaTrabajoAval2 = $_POST["telefonoParejaTrabajoAval2"];
        $ingresoNegocioParejaAval2 = $_POST["ingresoNegocioParejaAval2"];
        $sueldoBaseParejaAval2 = $_POST["sueldoBaseParejaAval2"];
        $gastoAlimentacionParejaAval2 = $_POST["gastoAlimentacionParejaAval2"];
        $cuotaParejaAval2 = $_POST["cuotaParejaAval2"];
        $cuentaParejaAval2 = $_POST["cuentaParejaAval2"];
        $esAvalParejaAVAL2 = $_POST["esAvalParejaAVAL2"];
        $avalMoraParejaAVAL2 = $_POST["avalMoraParejaAVAL2"];
        $estadoCreditoParejaAVAL2 = $_POST["estadoCreditoParejaAVAL2"];
  
  
    

        if($idEstadoCivilAval2 == 2 || $idEstadoCivilAval2 == 3){
  
            if($nombresParejaAval2 == ""){
                $response = "nombrePareja";
            
            }else if($apellidosParejaAval2 == ""){
                $response = "apellidoPareja";
        
            }else if($identidadParejaAval2 == ""){
                $response = "identidadPareja";
            }else if($identidadParejaAval2 == "0000-0000-00000" || $identidadParejaAval2 == "1111-1111-11111" || strlen($identidadParejaAval2) <15 ){
                $response = "identidadIncorrecta";
        
            //casado o en union libre
            }else if($editarSoli->ActualizarPersona($idPersonaAval2, $idNacionalidadAval2, $idGeneroAval2, $idEstadoCivilAval2, $idProfesionAval2, null, 
            $idTipoClientesAval2, $idcategoriaCasaAval2, $idtiempoVivirAval2, $idTiempoLaboralAval2, $pagaAlquilerAval2, $estadoCreditoAval2, $esAvalAval2, $avalMoraAval2, $idMunicipioAval2,
            $nombreAval2, $apellidoAval2, $identidadAval2, $fechaNacimientoAval2, $patronoAval2, $actividadDesempeniaAval2, $ObservacionesSolicitudAval2, $ModificadoPor) ){
                
                //actualizacion de los datos de la pareja;
               $editarSoli->ActualizarPersona($idParejaAval2, 1, $generoParejaAval2, $idEstadoCivilAval2, $profesionParejaAval2, null, 
                $tipoClienteParejaAval2, $idcategoriaCasaAval2, $idtiempoVivirAval2, $tiempoLaboralParejaAval2, $pagaAlquilerAval2, $estadoCreditoParejaAVAL2, $esAvalParejaAVAL2, $avalMoraParejaAVAL2, $municipioParejaAval2,
                $nombresParejaAval2, $apellidosParejaAval2, $identidadParejaAval2, $fechaNacimientoParejaAval2, $patronoParejaAval2, $actividadParejaAval2, null, $ModificadoPor);
    
                //actualiza los ingresos de la persona
                $editarSoli->ActualizarIngresosConyugue($idParejaAval2, $ingresoNegocioParejaAval2, $sueldoBaseParejaAval2, $gastoAlimentacionParejaAval2);
                //CONTACTOS
                $contactos = array(
                    //Aval 1
                    array('valor' => $celularAval2, 'idTipoContacto' => 1,  'idPersona' => $idPersonaAval2),
                    array('valor' => $direccionAval2, 'idTipoContacto' => 2,  'idPersona' => $idPersonaAval2),
                    array('valor' => $telefonoAval2, 'idTipoContacto' => 3,  'idPersona' => $idPersonaAval2),
                    array('valor' => $direccionTrabajoAval2, 'idTipoContacto' => 4,  'idPersona' => $idPersonaAval2),
                    array('valor' => $telefonoTrabajoAval2, 'idTipoContacto' => 5, 'idPersona' => $idPersonaAval2),
                    //pareja aval 1
                    array('valor' => $celularParejaAval2, 'idTipoContacto' => 1,  'idPersona' => $idParejaAval2),
                    array('valor' => $direccionParejaAval2, 'idTipoContacto' => 2,  'idPersona' => $idParejaAval2),
                    array('valor' => $telefonoParejaAval2, 'idTipoContacto' => 3,  'idPersona' => $idParejaAval2),
                    array('valor' => $direccionTrabajoParejaAval2, 'idTipoContacto' => 4,  'idPersona' => $idParejaAval2),
                    array('valor' => $telefonoParejaTrabajoAval2, 'idTipoContacto' => 5, 'idPersona' => $idParejaAval2),
                );   
    
                //trae el id para actualizar las referencias
                $idReferenciaFamiliares = $editarSoli->idReferenciasFamiliares($idPersonaAval2);
                
                $referencias = array( //arreglo las referencias
                    //solicitante
                    array('idParentesco' => $parestencosR1Aval2, 'nombre' => $nombreR1Aval2, 'celular' => $celularR1Aval2, 'direccion' => $direccionR1Aval2, 'idReferencia' => $idReferenciaFamiliares[0]['idReferencia']),
                    array('idParentesco' => $parestencosR2Aval2, 'nombre' => $nombreR2Aval2, 'celular' => $celularR2Aval2, 'direccion' => $direccionR2Aval2, 'idReferencia' => $idReferenciaFamiliares[1]['idReferencia']),
                ); 
                //cuentas
                $cuentas = array( //arreglo las referencias
                    //solicitante
                    array('cuenta'=>$cuentaAval2, 'idPersona' =>$idPersonaAval2),
                    //pareja
                    array('cuenta'=>$cuentaParejaAval2, 'idPersona' =>$idParejaAval2),
                
                ); 
                //actualiza los contactos y referencias
                $editarSoli->Actualizar_contactos_referencias_cuentas($contactos, $referencias, $cuentas);

                //trae el id para actualizar las referencias comerciales
                $idReferenciaComercial = $editarSoli->idReferenciasComerciales($idPersonaAval2);
                //REFERENCIAS COMERCIALES
                $comerciales = array(
                    //solicitante
                    array('nombre' => $nombreComercial1AVAL2, 'direccion' => $direccionComercial1AVAL2,  'idReferenciaComercial' => $idReferenciaComercial[0]['idReferenciaComercial']),
                    array('nombre' => $nombreComercial2AVAL2, 'direccion' => $direccionComercial2AVAL2,  'idReferenciaComercial' => $idReferenciaComercial[1]['idReferenciaComercial'])
                );
                //actualiza las referencias comerciales
                $editarSoli->Actualizar_referencias_comerciales($comerciales);
            
                //Actualizar analisis crediticio
                $editarSoli->ActualizarAnalisisCrediticio($idPersonaAval2, $sueldoBase_analisisAval2, $ingresosNegocioAval2, $rentaAval2, $remesasAval2, $aporteConyugeAval2, $sociedadAval2,
                $cuotaAdepesAval2, $viviendaAval2, $alimentacionAval2, $centralRiesgoAval2, $otrosEgresosAval2, $capitalDisponibleAval2, $evaluacionAval2);
                
                $response ="success";
            
            }else{
                $response = "error";
            }
  
  
        }else if($idEstadoCivilAval2 == 1 || $idEstadoCivilAval2 == 4){ //soltero o no definido

          if($editarSoli->ActualizarPersona($idPersonaAval2, $idNacionalidadAval2, $idGeneroAval2, $idEstadoCivilAval2, $idProfesionAval2, null, 
              $idTipoClientesAval2, $idcategoriaCasaAval2, $idtiempoVivirAval2, $idTiempoLaboralAval2, $pagaAlquilerAval2, $estadoCreditoAval2, $esAvalAval2, $avalMoraAval2, $idMunicipioAval2,
              $nombreAval2, $apellidoAval2, $identidadAval2, $fechaNacimientoAval2, $patronoAval2, $actividadDesempeniaAval2, $ObservacionesSolicitudAval2, $ModificadoPor)){
              
  
              //CONTACTOS
              $contactos = array(
                  //solicitante
                  array('valor' => $celularAval2, 'idTipoContacto' => 1,  'idPersona' => $idPersonaAval2),
                  array('valor' => $direccionAval2, 'idTipoContacto' => 2,  'idPersona' => $idPersonaAval2),
                  array('valor' => $telefonoAval2, 'idTipoContacto' => 3,  'idPersona' => $idPersonaAval2),
                  array('valor' => $direccionTrabajoAval2, 'idTipoContacto' => 4,  'idPersona' => $idPersonaAval2),
                  array('valor' => $telefonoTrabajoAval2, 'idTipoContacto' => 5, 'idPersona' => $idPersonaAval2),
              );   
  
              //trae el id para actualizar las referencias
              $idReferenciaFamiliares = $editarSoli->idReferenciasFamiliares($idPersonaAval2);
              
              $referencias = array( //arreglo las referencias
                  //solicitante
                  array('idParentesco' => $parestencosR1Aval2, 'nombre' => $nombreR1Aval2, 'celular' => $celularR1Aval2, 'direccion' => $direccionR1Aval2, 'idReferencia' => $idReferenciaFamiliares[0]['idReferencia']),
                  array('idParentesco' => $parestencosR2Aval2, 'nombre' => $nombreR2Aval2, 'celular' => $celularR2Aval2, 'direccion' => $direccionR2Aval2, 'idReferencia' => $idReferenciaFamiliares[1]['idReferencia']),
              ); 
              //cuentas
              $cuentas = array( //arreglo las referencias
                  //solicitante
                  array('cuenta'=>$cuentaAval2, 'idPersona' =>$idPersonaAval2),
              ); 
              //actualiza los contactos y referencias
              $editarSoli->Actualizar_contactos_referencias_cuentas($contactos, $referencias, $cuentas);

              //trae el id para actualizar las referencias comerciales
              $idReferenciaComercial = $editarSoli->idReferenciasComerciales($idPersonaAval2);
              //REFERENCIAS COMERCIALES
              $comerciales = array(
                //solicitante
                array('nombre' => $nombreComercial1AVAL2, 'direccion' => $direccionComercial1AVAL2,  'idReferenciaComercial' => $idReferenciaComercial[0]['idReferenciaComercial']),
                array('nombre' => $nombreComercial2AVAL2, 'direccion' => $direccionComercial2AVAL2,  'idReferenciaComercial' => $idReferenciaComercial[1]['idReferenciaComercial'])
             ); 
             //actualiza las referencias comerciales
             $editarSoli->Actualizar_referencias_comerciales($comerciales);
   
              //Actualizar analisis crediticio
              $editarSoli->ActualizarAnalisisCrediticio($idPersonaAval2, $sueldoBase_analisisAval2, $ingresosNegocioAval2, $rentaAval2, $remesasAval2, $aporteConyugeAval2, $sociedadAval2,
              $cuotaAdepesAval2, $viviendaAval2, $alimentacionAval2, $centralRiesgoAval2, $otrosEgresosAval2, $capitalDisponibleAval2, $evaluacionAval2);
  
              $response ="success";
          }else{
              $response = "error";
          }
  
        }else{
          $response = "error";
        }
        
          
   
  
        echo $response;
  
    break;





    case "Actualizar_aval3":

        $ModificadoPor =  $_SESSION["user"]["Usuario"];
        //datos del aval
        $idPersonaAval3 = $_POST["idPersonaAval3"];
        $nombreAval3 = $_POST["nombreAval3"];
        $apellidoAval3 = $_POST["apellidoAval3"];
        $identidadAval3 = $_POST["identidadAval3"];
        $fechaNacimientoAval3 = $_POST["fechaNacimientoAval3"];
        $idNacionalidadAval3 = $_POST["idNacionalidadAval3"];
        $idMunicipioAval3 = $_POST["idMunicipioAval3"];
        $direccionAval3 = $_POST["direccionAval3"];
        $celularAval3 = $_POST["celularAval3"];
        $telefonoAval3 = $_POST["telefonoAval3"];
        $direccionTrabajoAval3 = $_POST["direccionTrabajoAval3"];
        $telefonoTrabajoAval3 = $_POST["telefonoTrabajoAval3"];
    
        $idEstadoCivilAval3 = $_POST["idEstadoCivilAval3"]; 
        $idcategoriaCasaAval3 = $_POST["idcategoriaCasaAval3"];
        $idtiempoVivirAval3 = $_POST["idtiempoVivirAval3"];
        $pagaAlquilerAval3 = $_POST["pagaAlquilerAval3"];
        $pagoCasaAval3 = $_POST["pagoCasaAval3"];
        $idGeneroAval3 = $_POST["idGeneroAval3"];
        $idProfesionAval3 = $_POST["idProfesionAval3"];
        $patronoAval3 = $_POST["patronoAval3"];
        $actividadDesempeniaAval3 = $_POST["actividadDesempeniaAval3"];
        $idTiempoLaboralAval3 = $_POST["idTiempoLaboralAval3"];
        $idTipoClientesAval3 = $_POST["idTipoClientesAval3"];
        
        $cuentaAval3 = $_POST["cuentaAval3"];
        $esAvalAval3 = $_POST["esAvalAval3"];
        $avalMoraAval3 = $_POST["avalMoraAval3"];
        $estadoCreditoAval3 = $_POST["estadoCreditoAval3"];
        
        //referencias Familiares
        $nombreR1Aval3 = $_POST["nombreR1Aval3"];
        $parestencosR1Aval3 = $_POST["parestencosR1Aval3"];
        $celularR1Aval3 = $_POST["celularR1Aval3"];
        $direccionR1Aval3 = $_POST["direccionR1Aval3"];
        $nombreR2Aval3 = $_POST["nombreR2Aval3"];
        $parestencosR2Aval3 = $_POST["parestencosR2Aval3"];
        $celularR2Aval3 = $_POST["celularR2Aval3"];
        $direccionR2Aval3 = $_POST["direccionR2Aval3"];
        $ObservacionesSolicitudAval3 = $_POST["ObservacionesSolicitudAval3"];
        //referencias comerciales
        $nombreComercial1AVAL3 = $_POST["nombreComercial1AVAL3"];
        $direccionComercial1AVAL3 = $_POST["direccionComercial1AVAL3"];
        $nombreComercial2AVAL3 = $_POST["nombreComercial2AVAL3"];
        $direccionComercial2AVAL3 = $_POST["direccionComercial2AVAL3"];
        //analisisCrediticio
        $sueldoBase_analisisAval3 = $_POST["sueldoBase_analisisAval3"];
        $ingresosNegocioAval3 = $_POST["ingresosNegocioAval3"];
        $rentaAval3 = $_POST["rentaAval3"];
        $remesasAval3 = $_POST["remesasAval3"];
        $aporteConyugeAval3 = $_POST["aporteConyugeAval3"];
        $sociedadAval3 = $_POST["sociedadAval3"];
    
        $cuotaAdepesAval3 = $_POST["cuotaAdepesAval3"];
        $viviendaAval3= $_POST["viviendaAval3"];
        $alimentacionAval3= $_POST["alimentacionAval3"];
        $centralRiesgoAval3 = $_POST["centralRiesgoAval3"];
        $otrosEgresosAval3 = $_POST["otrosEgresosAval3"];
        $capitalDisponibleAval3 = $_POST["capitalDisponibleAval3"];
        $evaluacionAval3 = $_POST["evaluacionAval3"];
        //Datos pareja
        $idParejaAval3 = $_POST["idParejaAval3"];
        $nombresParejaAval3 = $_POST["nombresParejaAval3"];
        $apellidosParejaAval3 = $_POST["apellidosParejaAval3"];
        $identidadParejaAval3 = $_POST["identidadParejaAval3"];
        $fechaNacimientoParejaAval3 = $_POST["fechaNacimientoParejaAval3"];
        $municipioParejaAval3 = $_POST["municipioParejaAval3"]; 
        $generoParejaAval3 = $_POST["generoParejaAval3"]; 
        $actividadParejaAval3 = $_POST["actividadParejaAval3"];
        $tiempoLaboralParejaAval3 = $_POST["tiempoLaboralParejaAval3"];
        $profesionParejaAval3 = $_POST["profesionParejaAval3"];
        $patronoParejaAval3 = $_POST["patronoParejaAval3"];
        $tipoClienteParejaAval3 = $_POST["tipoClienteParejaAval3"];
        $direccionParejaAval3 = $_POST["direccionParejaAval3"];
        $celularParejaAval3 = $_POST["celularParejaAval3"];
        $telefonoParejaAval3 = $_POST["telefonoParejaAval3"];
        $direccionTrabajoParejaAval3 = $_POST["direccionTrabajoParejaAval3"];
        $telefonoParejaTrabajoAval3 = $_POST["telefonoParejaTrabajoAval3"];
        $ingresoNegocioParejaAval3 = $_POST["ingresoNegocioParejaAval3"];
        $sueldoBaseParejaAval3 = $_POST["sueldoBaseParejaAval3"];
        $gastoAlimentacionParejaAval3 = $_POST["gastoAlimentacionParejaAval3"];
        $cuotaParejaAval3 = $_POST["cuotaParejaAval3"];
        $cuentaParejaAval3 = $_POST["cuentaParejaAval3"];
        $esAvalParejaAVAL3 = $_POST["esAvalParejaAVAL3"];
        $avalMoraParejaAVAL3 = $_POST["avalMoraParejaAVAL3"];
        $estadoCreditoParejaAVAL3 = $_POST["estadoCreditoParejaAVAL3"];
  
  
    

        if($idEstadoCivilAval3 == 2 || $idEstadoCivilAval3 == 3){
  
            if($nombresParejaAval3 == ""){
                $response = "nombrePareja";
            
            }else if($apellidosParejaAval3 == ""){
                $response = "apellidoPareja";
        
            }else if($identidadParejaAval3 == ""){
                $response = "identidadPareja";
            }else if($identidadParejaAval3 == "0000-0000-00000" || $identidadParejaAval3 == "1111-1111-11111" || strlen($identidadParejaAval3) <15 ){
                $response = "identidadIncorrecta";
        
            //casado o en union libre
            }else if($editarSoli->ActualizarPersona($idPersonaAval3, $idNacionalidadAval3, $idGeneroAval3, $idEstadoCivilAval3, $idProfesionAval3, null, 
            $idTipoClientesAval3, $idcategoriaCasaAval3, $idtiempoVivirAval3, $idTiempoLaboralAval3, $pagaAlquilerAval3, $estadoCreditoAval3, $esAvalAval3, $avalMoraAval3, $idMunicipioAval3,
            $nombreAval3, $apellidoAval3, $identidadAval3, $fechaNacimientoAval3, $patronoAval3, $actividadDesempeniaAval3, $ObservacionesSolicitudAval3, $ModificadoPor) ){
                
                //actualizacion de los datos de la pareja;
               $editarSoli->ActualizarPersona($idParejaAval3, 1, $generoParejaAval3, $idEstadoCivilAval3, $profesionParejaAval3, null, 
                $tipoClienteParejaAval3, $idcategoriaCasaAval3, $idtiempoVivirAval3, $tiempoLaboralParejaAval3, $pagaAlquilerAval3, $estadoCreditoParejaAVAL3, $esAvalParejaAVAL3, $avalMoraParejaAVAL3, $municipioParejaAval3,
                $nombresParejaAval3, $apellidosParejaAval3, $identidadParejaAval3, $fechaNacimientoParejaAval3, $patronoParejaAval3, $actividadParejaAval3, null, $ModificadoPor);
    
                //actualiza los ingresos de la persona
                $editarSoli->ActualizarIngresosConyugue($idParejaAval3, $ingresoNegocioParejaAval3, $sueldoBaseParejaAval3, $gastoAlimentacionParejaAval3);
                //CONTACTOS
                $contactos = array(
                    //Aval 3
                    array('valor' => $celularAval3, 'idTipoContacto' => 1,  'idPersona' => $idPersonaAval3),
                    array('valor' => $direccionAval3, 'idTipoContacto' => 2,  'idPersona' => $idPersonaAval3),
                    array('valor' => $telefonoAval3, 'idTipoContacto' => 3,  'idPersona' => $idPersonaAval3),
                    array('valor' => $direccionTrabajoAval3, 'idTipoContacto' => 4,  'idPersona' => $idPersonaAval3),
                    array('valor' => $telefonoTrabajoAval3, 'idTipoContacto' => 5, 'idPersona' => $idPersonaAval3),
                    //pareja aval 1
                    array('valor' => $celularParejaAval3, 'idTipoContacto' => 1,  'idPersona' => $idParejaAval3),
                    array('valor' => $direccionParejaAval3, 'idTipoContacto' => 2,  'idPersona' => $idParejaAval3),
                    array('valor' => $telefonoParejaAval3, 'idTipoContacto' => 3,  'idPersona' => $idParejaAval3),
                    array('valor' => $direccionTrabajoParejaAval3, 'idTipoContacto' => 4,  'idPersona' => $idParejaAval3),
                    array('valor' => $telefonoParejaTrabajoAval3, 'idTipoContacto' => 5, 'idPersona' => $idParejaAval3),
                );   
    
                //trae el id para actualizar las referencias
                $idReferenciaFamiliares = $editarSoli->idReferenciasFamiliares($idPersonaAval3);
                
                $referencias = array( //arreglo las referencias
                    //solicitante
                    array('idParentesco' => $parestencosR1Aval3, 'nombre' => $nombreR1Aval3, 'celular' => $celularR1Aval3, 'direccion' => $direccionR1Aval3, 'idReferencia' => $idReferenciaFamiliares[0]['idReferencia']),
                    array('idParentesco' => $parestencosR2Aval3, 'nombre' => $nombreR2Aval3, 'celular' => $celularR2Aval3, 'direccion' => $direccionR2Aval3, 'idReferencia' => $idReferenciaFamiliares[1]['idReferencia']),
                ); 
                //cuentas
                $cuentas = array( //arreglo las referencias
                    //Aval 3
                    array('cuenta'=>$cuentaAval3, 'idPersona' =>$idPersonaAval3),
                    //pareja
                    array('cuenta'=>$cuentaParejaAval3, 'idPersona' =>$idParejaAval3),
                
                ); 
                //actualiza los contactos y referencias
                $editarSoli->Actualizar_contactos_referencias_cuentas($contactos, $referencias, $cuentas);

                //trae el id para actualizar las referencias comerciales
                $idReferenciaComercial = $editarSoli->idReferenciasComerciales($idPersonaAval3);
                //REFERENCIAS COMERCIALES
                $comerciales = array(
                    //solicitante
                    array('nombre' => $nombreComercial1AVAL3, 'direccion' => $direccionComercial1AVAL3,  'idReferenciaComercial' => $idReferenciaComercial[0]['idReferenciaComercial']),
                    array('nombre' => $nombreComercial2AVAL3, 'direccion' => $direccionComercial2AVAL3,  'idReferenciaComercial' => $idReferenciaComercial[1]['idReferenciaComercial'])
                );
                //actualiza las referencias comerciales
                $editarSoli->Actualizar_referencias_comerciales($comerciales);
            
                //Actualizar analisis crediticio
                $editarSoli->ActualizarAnalisisCrediticio($idPersonaAval3, $sueldoBase_analisisAval3, $ingresosNegocioAval3, $rentaAval3, $remesasAval3, $aporteConyugeAval3, $sociedadAval3,
                $cuotaAdepesAval3, $viviendaAval3, $alimentacionAval3, $centralRiesgoAval3, $otrosEgresosAval3, $capitalDisponibleAval3, $evaluacionAval3);
                
                $response ="success";
            
            }else{
                $response = "error";
            }
  
  
        }else if($idEstadoCivilAval3 == 1 || $idEstadoCivilAval3 == 4){ //soltero o no definido

          if($editarSoli->ActualizarPersona($idPersonaAval3, $idNacionalidadAval3, $idGeneroAval3, $idEstadoCivilAval3, $idProfesionAval3, null, 
          $idTipoClientesAval3, $idcategoriaCasaAval3, $idtiempoVivirAval3, $idTiempoLaboralAval3, $pagaAlquilerAval3, $estadoCreditoAval3, $esAvalAval3, $avalMoraAval3, $idMunicipioAval3,
          $nombreAval3, $apellidoAval3, $identidadAval3, $fechaNacimientoAval3, $patronoAval3, $actividadDesempeniaAval3, $ObservacionesSolicitudAval3, $ModificadoPor)){
              
  
              //CONTACTOS
              $contactos = array(
                  //Aval 3
                  array('valor' => $celularAval3, 'idTipoContacto' => 1,  'idPersona' => $idPersonaAval3),
                  array('valor' => $direccionAval3, 'idTipoContacto' => 2,  'idPersona' => $idPersonaAval3),
                  array('valor' => $telefonoAval3, 'idTipoContacto' => 3,  'idPersona' => $idPersonaAval3),
                  array('valor' => $direccionTrabajoAval3, 'idTipoContacto' => 4,  'idPersona' => $idPersonaAval3),
                  array('valor' => $telefonoTrabajoAval3, 'idTipoContacto' => 5, 'idPersona' => $idPersonaAval3),
              );   
  
              //trae el id para actualizar las referencias
              $idReferenciaFamiliares = $editarSoli->idReferenciasFamiliares($idPersonaAval3);
              
              $referencias = array( //arreglo las referencias
                //solicitante
                array('idParentesco' => $parestencosR1Aval3, 'nombre' => $nombreR1Aval3, 'celular' => $celularR1Aval3, 'direccion' => $direccionR1Aval3, 'idReferencia' => $idReferenciaFamiliares[0]['idReferencia']),
                array('idParentesco' => $parestencosR2Aval3, 'nombre' => $nombreR2Aval3, 'celular' => $celularR2Aval3, 'direccion' => $direccionR2Aval3, 'idReferencia' => $idReferenciaFamiliares[1]['idReferencia']),
            ); 
              //cuentas
              $cuentas = array( //arreglo las referencias
                  //Aval 3
                  array('cuenta'=>$cuentaAval3, 'idPersona' =>$idPersonaAval3),
              ); 
              //actualiza los contactos y referencias
              $editarSoli->Actualizar_contactos_referencias_cuentas($contactos, $referencias, $cuentas);

              //trae el id para actualizar las referencias comerciales
              $idReferenciaComercial = $editarSoli->idReferenciasComerciales($idPersonaAval3);
              //REFERENCIAS COMERCIALES
            $comerciales = array(
                //solicitante
                array('nombre' => $nombreComercial1AVAL3, 'direccion' => $direccionComercial1AVAL3,  'idReferenciaComercial' => $idReferenciaComercial[0]['idReferenciaComercial']),
                array('nombre' => $nombreComercial2AVAL3, 'direccion' => $direccionComercial2AVAL3,  'idReferenciaComercial' => $idReferenciaComercial[1]['idReferenciaComercial'])
            );
            //actualiza las referencias comerciales
             $editarSoli->Actualizar_referencias_comerciales($comerciales);
   
              //Actualizar analisis crediticio
              $editarSoli->ActualizarAnalisisCrediticio($idPersonaAval3, $sueldoBase_analisisAval3, $ingresosNegocioAval3, $rentaAval3, $remesasAval3, $aporteConyugeAval3, $sociedadAval3,
              $cuotaAdepesAval3, $viviendaAval3, $alimentacionAval3, $centralRiesgoAval3, $otrosEgresosAval3, $capitalDisponibleAval3, $evaluacionAval3);
              
              $response ="success";
          }else{
              $response = "error";
          }
  
        }else{
          $response = "error";
        }
        
          
   
  
        echo $response;
  
    break;

    case "Consultar_estado_solicitud":

        if(isset($_POST["idSolicitud"]) && !empty($_POST["idSolicitud"])){
            $data = $editarSoli->ConsultarEstadoSolicitud($_POST["idSolicitud"]);
            if($data){
             
                $list[]=array(  //se pone los campos que queremos guardar
                    "ESTADO"=>$data['idEstadoSolicitud']
            
                    
                );
                
                echo json_encode($list); //se devuelve los datos en formato json 

               
            }
        }
 
    break;
    
    

  } //fin switch

  

?>