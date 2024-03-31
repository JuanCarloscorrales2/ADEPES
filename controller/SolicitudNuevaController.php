<?php
session_start();
require "../model/SolicitudNueva.php";
// Establecer la zona horaria de Honduras
date_default_timezone_set('America/Tegucigalpa');
//instancia de la clase rol
$solicitud = new Solicitud();

switch ($_REQUEST["operador"]) {

   case "listar_solicitudes":
      $resultados = array(
         "sEcho" => 0,
         "iTotalRecords" => 0,
         "iTotalDisplayRecords" => 0,
         "aaData" => []
      );
      $datos = $_SESSION["consultar"] >= 1 ?  $solicitud->ListarSolicitudes() : [];
      if ($datos) {
         for ($i = 0; $i < count($datos); $i++) {
            $boton_editar = $_SESSION["actualizar"] >= 1 ? '<a class="dropdown-item" href="../pages/editarSolicitud.php"
            onclick="ObtenerSolicitudPor_Id(' . $datos[$i]['persona'] . ",'Editar'" . ');"><i class="icon-edit"></i>Editar</a>
            <a class="dropdown-item" href="../pages/Contrato.php"
            onclick="ObtenerSolicitudPor_Id(' . $datos[$i]['persona'] . ",'Contrato'" . ');"><i class="icon-document"></i>Contrato</a>
            ' : '<span class="tag tag-warning">No puede editar</span>  ';
            $boton_reporte = $_SESSION["reportes"] >= 1 ? '<a class="dropdown-item"
            onclick="ObtenerSolicitudPor_Id(' . $datos[$i]['persona'] . ",'Imprimir'" . ');"> <i class="icon-print"></i> Imprimir</a>
            ' : '<span class="tag tag-warning">No puede imprimir</span>   <a class="dropdown-item" ';
            $list[] = array(
               "Acciones" => ($datos[$i]['idEstadoSolicitud'] == 1 || $datos[$i]['idEstadoSolicitud'] == 4) ?
                  '<div class="btn-group"> 
                     <button class="btn btn-info dropdown-toggle btn-sm" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="true"> <i class="icon-gear"> </i>
                     </button>
                     <div class="dropdown-menu">
                     ' . $boton_editar  . '
                     ' . $boton_reporte  . '
                     </div>
                  </div>' : (($datos[$i]['idEstadoSolicitud'] == 3 && $datos[$i]['idTipoPrestamo'] == 1 && $datos[$i]['cantidadAval'] < 3) ?
                     '<div class="btn-group"> 
                    <button class="btn btn-info dropdown-toggle btn-sm" data-toggle="dropdown"
                           aria-haspopup="true" aria-expanded="true"> <i class="icon-gear"> </i>
                     </button>
                     <div class="dropdown-menu">
                     ' . $boton_editar  . '
                     ' . $boton_reporte  . '
                           <a class="dropdown-item" data-toggle="modal" data-target="#comiteCredito"
                              onclick="ObtenerSolicitudPor_Id(' . $datos[$i]['persona'] . ",'Comite'" . ');">
                              <i class="icon-check"></i>Comité Crédito
                           </a>
                           <a class="dropdown-item"  onclick="ObtenerSolicitudPor_Id(' . $datos[$i]['persona'] . ",'registrarAval'" . ')" href="../pages/nuevaSolicitudAval.php"><i class="icon-person"></i>Agregar Aval</a>
                     </div>
                     
                  </div>' :


                     '<div class="btn-group"> 
              <button class="btn btn-info dropdown-toggle btn-sm" data-toggle="dropdown"
                   aria-haspopup="true" aria-expanded="true"> <i class="icon-gear"> </i>
              </button>
              <div class="dropdown-menu">
              ' . $boton_editar  . '
              ' . $boton_reporte  . '
                   <a class="dropdown-item" data-toggle="modal" data-target="#comiteCredito"
                      onclick="ObtenerSolicitudPor_Id(' . $datos[$i]['persona'] . ",'Comite'" . ');">
                      <i class="icon-check"></i>Comité Crédito
                   </a>
                 
                
              </div>
              
           </div>'),

               "ID" => $datos[$i]['idSolicitud'], //nombre de la tablas en la base de datos
               "NOMBRE" => $datos[$i]['Nombre'], //nombre de la tablas en la base de datos
               "PRESTAMO" => $datos[$i]['Prestamo'],
               "MONTO" => $datos[$i]['Monto'],
               "TASA" => $datos[$i]['tasa'],
               "PLAZO" => $datos[$i]['Plazo'],
               "ESTADO" => ($datos[$i]['idEstadoSolicitud'] == 1) ? '<span class="tag tag-info">Aprobado</span>' : (($datos[$i]['idEstadoSolicitud'] == 2) ? '<span class="tag tag-danger">No aprobado</span>' : (($datos[$i]['idEstadoSolicitud'] == 4) ?
                '<span class="tag tag-success">Contrato Aprobado</span>' : '<span class="tag tag-warning">Pendiente</span>')),
               "FECHA_DESEMBOLSO" => $datos[$i]['fechaDesembolso'],



            );
         }

         $resultados = array(
            "sEcho" => 1,
            "iTotalRecords" => count($list),
            "iTotalDisplayRecords" => count($list),
            "aaData" => $list
         );
      }
      echo json_encode($resultados); //datos en formato json para la datatable

      break;

   case "obtener_solicitud_por_id":
      if (isset($_POST["persona"]) && !empty($_POST["persona"])) {

         $data = $solicitud->Solicitud_id($_POST["persona"]);
         $idSoli = $_POST["Acciones"];
         if ($idSoli == "registrarAval") {

            foreach ($data as $campos => $valor) {
               $_SESSION["Solicitud"][$campos] = $valor; //ALMACENA el id de solicitud para agregarle avales
            }

            $list[] = array(
               "monto" => $data['Monto'],
               "tasa" => $data['tasa'],
               "nombre" => $data['nombres'],
               "apellido" => $data['apellidos'],
               "invierte" => $data['invierteEn'],
               "idSoli" => $data['idSolicitud'],
               "idPerso" => $data['idPersona']

            );
            echo json_encode($list);
         } else if ($data) {

            $list[] = array(
               "monto" => $data['Monto'],
               "tasa" => $data['tasa'],
               "nombre" => $data['nombres'],
               "apellido" => $data['apellidos'],
               "invierte" => $data['invierteEn'],
               "identidad" => $data['identidad'],
               "nacimiento" => $data['fechaNacimiento'],
               "fecha" => $data['fechaDesembolso'],
               "patrono" => $data['PratronoNegocio'],
               "cargo" => $data['cargoDesempena'],
               "plazo" => $data['Plazo'],
               "idSoli" => $data['idSolicitud'],
               "idPerso" => $data['idPersona'],
               "prestamo" => $data['Prestamo']
            );
            echo json_encode($list);
         }
      }

      break;

   case "buscar_cliente_por_id":
      if (isset($_POST["identidad"]) && !empty($_POST["identidad"])) {

         $data = $solicitud->BuscarClientePorId($_POST["identidad"]);

         if ($data) {
            $list[] = array(
               "ID" => $data['idPersona'],
               "IDENTIDAD" => $data['identidad'],
               "NOMBRE" => $data['nombres'],
               "APELLIDO" => $data['apellidos'],
               "NACIMIENTO" => $data['fechaNacimiento'],
               "PATRONO" => $data['PratronoNegocio'],
               "CARGO" => $data['cargoDesempena'],
               "IDESTADOCIVIL" => $data['idEstadoCivil'],
               "CASA" => $data['idcategoriaCasa'],
               "TIEMPOVIVIR" => $data['idtiempoVivir'],
               "PAGAALQUILER" => $data['PagaAlquiler'],
               "GENERO" => $data['idGenero'],
               "PROFESION" => $data['idProfesion'],
               "NACIONALIDAD" => $data['idNacionalidad'],
               "TIEMPOLABORAL" => $data['idTiempoLaboral'],
               "CELULAR" => $data['Celular'],
               "DIRECCION" => $data['Direccion'],
               "TELEFONO" => $data['Telefono'],
               "DIRECCIONTRABAJO" => $data['DireccionTrabajo'],
               "TELEFONOTRABAJO" => $data['TelefonoTrabajo']
            );
            echo json_encode($list);
         }
      }

      break;

   case "buscar_clienteConyugue_por_id":
      if (isset($_POST["idPersona"]) && !empty($_POST["idPersona"])) {

         $data = $solicitud->BuscarClienteParejaPorId($_POST["idPersona"]);

         if ($data) {
            $list[] = array(
               "ID" => $data['idPersona'],
               "IDENTIDAD" => $data['identidad'],
               "NOMBRE" => $data['nombres'],
               "APELLIDO" => $data['apellidos'],
               "NACIMIENTO" => $data['fechaNacimiento'],
               "PATRONO" => $data['PratronoNegocio'],
               "CARGO" => $data['cargoDesempena'],
               "IDESTADOCIVIL" => $data['idEstadoCivil'],
               "CASA" => $data['idcategoriaCasa'],
               "TIEMPOVIVIR" => $data['idtiempoVivir'],
               "PAGAALQUILER" => $data['PagaAlquiler'],
               "GENERO" => $data['idGenero'],
               "PROFESION" => $data['idProfesion'],
               "NACIONALIDAD" => $data['idNacionalidad'],
               "TIEMPOLABORAL" => $data['idTiempoLaboral'],
               "CELULAR" => $data['Celular'],
               "DIRECCION" => $data['Direccion'],
               "TELEFONO" => $data['Telefono'],
               "DIRECCIONTRABAJO" => $data['DireccionTrabajo'],
               "TELEFONOTRABAJO" => $data['TelefonoTrabajo']
            );
            echo json_encode($list);
         }
      }

      break;

   case "cancelar_registrar_aval":  //
      unset($_SESSION["Solicitud"]); //destruye las datos que para registrar el aval
      header("location:../pages/solicitudes.php"); //redirige al listado de solicitudes
      break;

      break;


   case "aprobar_Solicitud":
      //$idUsuarioDictamen =  $_SESSION["user"]["idUsuario"];
      if (isset($_POST["idSoli"], $_POST["estadoSoli"]) && !empty($_POST["idSoli"])) {


         if ($solicitud->AprobarSolicitud($_POST["numeroActa"], $_POST["estadoSoli"], $_POST["idSoli"])) {
            $response = "success";
         } else {
            $response = "error";
         }
      } else {
         $response = "vacio";
      }
      echo $response;

      break;

   case "listar_generos_select":

      $datos = $solicitud->ListarGeneros();
      if ($datos) {  //valida que traiga datos
         for ($i = 0; $i < count($datos); $i++) {
            $list[] = array(  //se pone los campos que queremos guardar
               "0" => $datos[$i]['idGenero'],
               "1" => $datos[$i]['Descripcion'],
            );
         }
         echo json_encode($list); //se devuelve los datos en formato json 
      }

      break;

   case "listar_tiposPrestamos_select":

      $datos = $solicitud->ListarTiposPrestamos();
      if ($datos) {  //valida que traiga datos
         for ($i = 0; $i < count($datos); $i++) {
            $list[] = array(  //se pone los campos que queremos guardar
               "0" => $datos[$i]['idTipoPrestamo'],
               "1" => $datos[$i]['Descripcion'],
               "2" => $datos[$i]['tasa'],
            );
         }
         echo json_encode($list); //se devuelve los datos en formato json 
      }

      break;

   case "listar_rubros_select":

      $datos = $solicitud->ListarRubros();
      if ($datos) {  //valida que traiga datos
         for ($i = 0; $i < count($datos); $i++) {
            $list[] = array(  //se pone los campos que queremos guardar
               "0" => $datos[$i]['idRubro'],
               "1" => $datos[$i]['Descripcion'],
            );
         }
         echo json_encode($list); //se devuelve los datos en formato json 
      }

      break;

   case "listar_nacionalidades_select":

      $datos = $solicitud->ListarNacionalidades();
      if ($datos) {  //valida que traiga datos
         for ($i = 0; $i < count($datos); $i++) {
            $list[] = array(  //se pone los campos que queremos guardar
               "0" => $datos[$i]['idNacionalidad'],
               "1" => $datos[$i]['Descripcion'],
            );
         }
         echo json_encode($list); //se devuelve los datos en formato json 
      }

      break;

   case "listar_estadosciviles_select":

      $datos = $solicitud->ListarEstadosCiviles();
      if ($datos) {  //valida que traiga datos
         for ($i = 0; $i < count($datos); $i++) {
            $list[] = array(  //se pone los campos que queremos guardar
               "0" => $datos[$i]['idEstadoCivil'],
               "1" => $datos[$i]['Descripcion'],
            );
         }
         echo json_encode($list); //se devuelve los datos en formato json 
      }

      break;

   case "listar_casa_select":

      $datos = $solicitud->ListarCasa();
      if ($datos) {  //valida que traiga datos
         for ($i = 0; $i < count($datos); $i++) {
            $list[] = array(  //se pone los campos que queremos guardar
               "0" => $datos[$i]['idcategoriaCasa'],
               "1" => $datos[$i]['descripcion'],
            );
         }
         echo json_encode($list); //se devuelve los datos en formato json 
      }

      break;

   case "listar_tipo_pago_select":

      $datos = $solicitud->ListarTipoPago();
      if ($datos) {  //valida que traiga datos
         for ($i = 0; $i < count($datos); $i++) {
            $list[] = array(  //se pone los campos que queremos guardar
               "0" => $datos[$i]['idTipoPago'],
               "1" => $datos[$i]['descripcion'],
            );
         }
         echo json_encode($list); //se devuelve los datos en formato json 
      }

      break;

   case "listar_tiempovivir_select":

      $datos = $solicitud->ListarTiempoVivir();
      if ($datos) {  //valida que traiga datos
         for ($i = 0; $i < count($datos); $i++) {
            $list[] = array(  //se pone los campos que queremos guardar
               "0" => $datos[$i]['idtiempoVivir'],
               "1" => $datos[$i]['descripcion'],
            );
         }
         echo json_encode($list); //se devuelve los datos en formato json 
      }

      break;

   case "listar_tiempolaboral_select":

      $datos = $solicitud->ListarTiempoLaboral();
      if ($datos) {  //valida que traiga datos
         for ($i = 0; $i < count($datos); $i++) {
            $list[] = array(  //se pone los campos que queremos guardar
               "0" => $datos[$i]['idTiempoLaboral'],
               "1" => $datos[$i]['descripcion'],
            );
         }
         echo json_encode($list); //se devuelve los datos en formato json 
      }

      break;

   case "listar_profesiones_select":

      $datos = $solicitud->ListarProfesiones();
      if ($datos) {  //valida que traiga datos
         for ($i = 0; $i < count($datos); $i++) {
            $list[] = array(  //se pone los campos que queremos guardar
               "0" => $datos[$i]['idProfesion'],
               "1" => $datos[$i]['Descripcion'],
            );
         }
         echo json_encode($list); //se devuelve los datos en formato json 
      }

      break;

   case "listar_bienes_select":

      $datos = $solicitud->ListarBienes();
      if ($datos) {  //valida que traiga datos
         for ($i = 0; $i < count($datos); $i++) {
            $list[] = array(  //se pone los campos que queremos guardar
               "0" => $datos[$i]['idPersonaBienes'],
               "1" => $datos[$i]['Descripcion'],
            );
         }
         echo json_encode($list); //se devuelve los datos en formato json 
      }

      break;


   case "listar_tipocliente_select":

      $datos = $solicitud->ListarTipoCliente();
      if ($datos) {  //valida que traiga datos
         for ($i = 0; $i < count($datos); $i++) {
            $list[] = array(  //se pone los campos que queremos guardar
               "0" => $datos[$i]['idTipoCliente'],
               "1" => $datos[$i]['Descripcion'],
            );
         }
         echo json_encode($list); //se devuelve los datos en formato json 
      }

      break;

   case "listar_parentesco_select":

      $datos = $solicitud->ListarParentesco();
      if ($datos) {  //valida que traiga datos
         for ($i = 0; $i < count($datos); $i++) {
            $list[] = array(  //se pone los campos que queremos guardar
               "0" => $datos[$i]['idParentesco'],
               "1" => $datos[$i]['descripcion'],
            );
         }
         echo json_encode($list); //se devuelve los datos en formato json 
      }

      break;

   case "listar_estado_credito_select":

      $datos = $solicitud->ListarEstadoCredito();
      if ($datos) {  //valida que traiga datos
         for ($i = 0; $i < count($datos); $i++) {
            $list[] = array(  //se pone los campos que queremos guardar
               "0" => $datos[$i]['idEstadoCredito'],
               "1" => $datos[$i]['Descripcion'],
            );
         }
         echo json_encode($list); //se devuelve los datos en formato json 
      }

      break;

   case "listar_sies_aval_select":

      $datos = $solicitud->ListarSiEsAval();
      if ($datos) {  //valida que traiga datos
         for ($i = 0; $i < count($datos); $i++) {
            $list[] = array(  //se pone los campos que queremos guardar
               "0" => $datos[$i]['idEsAval'],
               "1" => $datos[$i]['Descripcion'],
            );
         }
         echo json_encode($list); //se devuelve los datos en formato json 
      }

      break;

   case "listar_aval_mora_select":

      $datos = $solicitud->ListarAvalMora();
      if ($datos) {  //valida que traiga datos
         for ($i = 0; $i < count($datos); $i++) {
            $list[] = array(  //se pone los campos que queremos guardar
               "0" => $datos[$i]['idCreditoAval'],
               "1" => $datos[$i]['Descripcion'],
            );
         }
         echo json_encode($list); //se devuelve los datos en formato json 
      }

      break;

   case "listar_municipios_select":

      $datos = $solicitud->ListarMunicipios();
      if ($datos) {  //valida que traiga datos
         for ($i = 0; $i < count($datos); $i++) {
            $list[] = array(  //se pone los campos que queremos guardar
               "0" => $datos[$i]['idMunicipio'],
               "1" => $datos[$i]['Descripcion'],
            );
         }
         echo json_encode($list); //se devuelve los datos en formato json 
      }

      break;

      /*******************************************  CRUD ***********************************************/
   case "registrar_cliente":

      $hoy = date('Y-m-d');
      $CreadoPor =  $_SESSION["user"]["Usuario"];
      $idTipoPersona =  1; //cliente
      $idNacionalidad =  $_POST["idNacionalidad"];
      $idGenero =  $_POST["idGenero"];
      $idEstadoCivil = $_POST["idEstadoCivil"];
      $idProfesion =  $_POST["idProfesion"];
      $idTipoClientes =  $_POST["idTipoClientes"];
      $idcategoriaCasa =  $_POST["idcategoriaCasa"];
      $idtiempoVivir =  $_POST["idtiempoVivir"];
      $idtiempoLaboral =  $_POST["idTiempoLaboral"];
      $nombres =  $_POST["nombres"];
      $apellidos =  $_POST["apellidos"];
      $identidad =  $_POST["identidad"];
      $fechaNacimiento = $_POST["fechaNacimiento"];
      $PagaAlquiler =  $_POST["pagaAlquiler"];
      $actividadDesempenia =  $_POST["actividadDesempenia"];
      $patrono = $_POST["patrono"];
      $direccionCliente = $_POST["direccionCliente"];
      $celularCliente = $_POST["celularCliente"];
      $telefonoCliente = $_POST["telefonoCliente"];
      $direccionTrabajoCliente = $_POST["direccionTrabajoCliente"];
      $telefonoTrabajoCliente = $_POST["telefonoTrabajoCliente"];
      $cuentaCliente = $_POST["cuentaCliente"];
      $esAval = $_POST["esAval"];
      $avalMora = $_POST["avalMora"];
      $estadoCreditoCliente = $_POST["estadoCredito"];
      $municipioCliente = $_POST["municipioCliente"];
      //referencias
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
      $dependientes = $_POST["dependientes"];
      $ObservacionesSolicitud = $_POST["ObservacionesSolicitud"];
      //Bienes que posee
      $bienes = $_POST["bienes"];
      //Pareja
      $idTipoPersonaP =  2; //pareja
      $idNacionalidadP =  $_POST["idNacionalidad"];
      $idGeneroP =  $_POST["idGeneroPareja"];
      $idEstadoCivilP = $_POST["idEstadoCivil"];
      $idProfesionP =  $_POST["idProfesionPareja"];
      $idTipoClientesP =  $_POST["idTipoClientesPareja"];
      $idcategoriaCasaP =  $_POST["idcategoriaCasa"];
      $idtiempoVivirP =  $_POST["idtiempoVivir"];
      $idtiempoLaboralP =  $_POST["idTiempoLaboralPareja"];
      $nombresP =  $_POST["nombresPareja"];
      $apellidosP =  $_POST["apellidosPareja"];
      $identidadP =  $_POST["identidadPareja"];
      $fechaNacimientoP = $_POST["fechaNacimientoPareja"];
      $PagaAlquilerP =  $_POST["pagaAlquiler"];
      $actividadDesempeniaP =  $_POST["actividadDesempeniaPareja"];
      $patronoP = $_POST["patronoPareja"];
      $ingresoNegocioPareja = $_POST["ingresoNegocioPareja"];
      $sueldoBasePareja = $_POST["sueldoBasePareja"];
      $gastoAlimentacionPareja = $_POST["gastoAlimentacionPareja"];
      $cuentaPareja = $_POST["cuentaPareja"];
      $esAvalPareja = $_POST["esAvalPareja"];
      $avalMoraPareja = $_POST["avalMoraPareja"];
      $estadoCreditoPareja = $_POST["estadoCreditoPareja"];
      $bienesPareja = null;
      $municipioPareja = $_POST["municipioPareja"];
      $direccionPareja = $_POST["direccionPareja"];
      $celularPareja = $_POST["celularPareja"];
      $telefonoPareja = $_POST["telefonoPareja"];
      $direccionTrabajoPareja = $_POST["direccionTrabajoPareja"];
      $telefonoTrabajoPareja = $_POST["telefonoTrabajoPareja"];


      //analisis
      $sueldoBase = $_POST["sueldoBase"];
      $ingresosNegocio = $_POST["ingresosNegocio"];
      $RentaPropiedad = $_POST["RentaPropiedad"];
      $remesas = $_POST["remesas"];
      $aporteConyuge = $_POST["aporteConyuge"];
      $IngresosSociedad = $_POST["IngresosSociedad"];

      $cuotaPrestamoAdepes = $_POST["cuotaPrestamoAdepes"];
      $cuotaVivienda = $_POST["cuotaVivienda"];
      $alimentacion = $_POST["alimentacion"];
      $deduccionesCentral = $_POST["deduccionesCentral"];
      $otrosEgresos = $_POST["otrosEgresos"];
      $liquidezCliente = $_POST["liquidezCliente"];
      $descripcion = $_POST["descripcion"];
      $idEstadoAnalisisCrediticio = 1;

      //DATOS DEL PRESTAMO
      $idTipoPrestamo = $_POST["idTipoPrestamo"];
      $monto = $_POST["monto"];
      $plazo = $_POST["plazo"];
      $rubro = $_POST["rubro"];
      $fechaEmision = $_POST["fechaEmision"];
      $idUsuario =  $_SESSION["user"]["idUsuario"];
      $idEstadoSolicitud = 3;
      if ($prestamo = $solicitud->idTipoTasa($idTipoPrestamo)) { //TRAE EL PARAMETRO DE INTENTOS
         foreach ($prestamo as $campos => $valor) {
            $IDPRESTAMO["prestamo"][$campos] = $valor; //ALMACENA EL numero de intentos DE INTENTOS
         }
      }
      $tasa = $IDPRESTAMO["prestamo"]["tasa"];
      // $maximo = $IDPRESTAMO["prestamo"]["MAXIMO"];
      if ($monto > $IDPRESTAMO["prestamo"]["montoMaximo"]) {
         $response = "montoMayor";
      } else if ($monto < $IDPRESTAMO["prestamo"]["montoMinimo"]) {
         $response = "montoMinimo";
      } else if ($plazo > $IDPRESTAMO["prestamo"]["PlazoMaximo"]) {
         $response = "plazoMaximo";
      } else if ($fechaEmision < $hoy) {
         $response = "fechaAntigua";
      } else if ($idEstadoCivil == 2 || $idEstadoCivil == 3) {

            //inserta los datos del cliente
         if ($idPersona = $solicitud->RegistrarCliente(
            $idTipoPersona,
            $idNacionalidad,
            $idGenero,
            $idEstadoCivil,
            $idProfesion,
            $bienes,
            $idTipoClientes,
            $idcategoriaCasa,
            $idtiempoVivir,
            $municipioCliente,
            $idtiempoLaboral,
            $nombres,
            $apellidos,
            $identidad,
            $fechaNacimiento,
            $PagaAlquiler,
            $patrono,
            $actividadDesempenia,
            $ObservacionesSolicitud,
            $esAval,
            $avalMora,
            $estadoCreditoCliente,
            $CreadoPor
         )) {

            //solicitud
            $cantidad = $solicitud->PrestamosAprobadosPorPersona($identidad);
            if ($cantidad == 0) {
               $prestamoAprobados = "ES SU PRIMER CRÉDITO EN EL FONDO ROTATORIO";
            } else if ($cantidad == 1) {
               $prestamoAprobados = "ES SU SEGUNDO CRÉDITO EN EL FONDO ROTATORIO";
            } else if ($cantidad == 2) {
               $prestamoAprobados = "ES SU TERCER CRÉDITO EN EL FONDO ROTATORIO";
            } else if ($cantidad == 3) {
               $prestamoAprobados = "ES SU CUARTO CRÉDITO EN EL FONDO ROTATORIO";
            } else {
               $prestamoAprobados = "ES SU QUINTO CRÉDITO EN EL FONDO ROTATORIO";
            }

            //se registra la nueva solicitud
            $solicitud->RegistrarSolicitud($idPersona, $idTipoPrestamo, $rubro, $idEstadoSolicitud, $idUsuario, $monto, $tasa, $plazo, $fechaEmision, $invierteEn, $prestamoAprobados, $CreadoPor);
            //registra la cuenta
            $solicitud->RegistrarCuenta($idPersona, 1, $cuentaCliente);
            //obtiene el id de la solicitud para registrar el analisis crediticio
            $id = $solicitud->id_Solicitud($idPersona);

            $solicitud->RegistrarAnalisis(
               $id,
               $idEstadoAnalisisCrediticio,
               $sueldoBase,
               $ingresosNegocio,
               $RentaPropiedad,
               $remesas,
               $aporteConyuge,
               $IngresosSociedad,
               $cuotaPrestamoAdepes,
               $cuotaVivienda,
               $alimentacion,
               $deduccionesCentral,
               $otrosEgresos,
               $liquidezCliente,
               $descripcion,
               $idPersona
            );



            $ObservacionesSolicitud = ""; //para pareja vacio
            //inserta los datos de la pareja
            if ($idPersonaPareja = $solicitud->RegistrarCliente(
               $idTipoPersonaP,
               $idNacionalidadP,
               $idGeneroP,
               $idEstadoCivilP,
               $idProfesionP,
               $bienesPareja,
               $idTipoClientesP,
               $idcategoriaCasaP,
               $idtiempoVivirP,
               $municipioPareja,
               $idtiempoLaboralP,
               $nombresP,
               $apellidosP,
               $identidadP,
               $fechaNacimientoP,
               $PagaAlquilerP,
               $patronoP,
               $actividadDesempeniaP,
               $ObservacionesSolicitud,
               $esAvalPareja,
               $avalMoraPareja,
               $estadoCreditoPareja,
               $CreadoPor
            )) {
               //  
               //$idPersonaPareja = $solicitud->idPersona($identidadP); //id de la pareja para guardar los contactos
               //registra los ingresos del conyugue
               $solicitud->RegistrarConyuge($id, $idPersonaPareja, $ingresoNegocioPareja, $sueldoBasePareja, $gastoAlimentacionPareja, $idPersona);
               //registra la cuenta
               $solicitud->RegistrarCuenta($idPersonaPareja, 1, $cuentaPareja);
               $contactos = array(
                  //solicitante
                  array('idPersona' => $idPersona, 'idTipoContacto' => 1, 'valor' => $celularCliente),
                  array('idPersona' => $idPersona, 'idTipoContacto' => 2, 'valor' => $direccionCliente),
                  array('idPersona' => $idPersona, 'idTipoContacto' => 3, 'valor' => $telefonoCliente),
                  array('idPersona' => $idPersona, 'idTipoContacto' => 4, 'valor' => $direccionTrabajoCliente),
                  array('idPersona' => $idPersona, 'idTipoContacto' => 5, 'valor' => $telefonoTrabajoCliente),
                  //pareja
                  array('idPersona' => $idPersonaPareja, 'idTipoContacto' => 1, 'valor' => $celularPareja),
                  array('idPersona' => $idPersonaPareja, 'idTipoContacto' => 2, 'valor' => $direccionPareja),
                  array('idPersona' => $idPersonaPareja, 'idTipoContacto' => 3, 'valor' => $telefonoPareja),
                  array('idPersona' => $idPersonaPareja, 'idTipoContacto' => 4, 'valor' => $direccionTrabajoPareja),
                  array('idPersona' => $idPersonaPareja, 'idTipoContacto' => 5, 'valor' => $telefonoTrabajoPareja),
               );


               $referencias = array( //arreglo las referencias
                  //solicitante
                  array('idPersona' => $idPersona, 'idParentesco' => $parestencosR1, 'nombre' => $nombreR1, 'celular' => $celularR1, 'direccion' => $direccionR1),
                  array('idPersona' => $idPersona, 'idParentesco' => $parestencosR2, 'nombre' => $nombreR2, 'celular' => $celularR2, 'direccion' => $direccionR2),

               );

               //registras los contactos y referencias
               $solicitud->Registrar_contactos_referencias($contactos, $referencias, $CreadoPor);

               $solicitud->RegistrarDependientes($idPersona, 1, $dependientes);  //registra los dependientes
               //registrar en bitacora
               $descripcionBitacora = "Se creo una nueva solicitud al cliente: ".$nombres." ".$apellidos;
               $solicitud->RegistrarBitacora($idUsuario, 6, "Inserto", $descripcionBitacora);

            }

            $response = "registrarPareja";  //si se inserto en la BD manda mensaje de exito
         } else {
            $response = "error";
         }
      } else {  //soltero o no definido
         if ($idPersona = $solicitud->RegistrarCliente(
            $idTipoPersona,
            $idNacionalidad,
            $idGenero,
            $idEstadoCivil,
            $idProfesion,
            $bienes,
            $idTipoClientes,
            $idcategoriaCasa,
            $idtiempoVivir,
            $municipioCliente,
            $idtiempoLaboral,
            $nombres,
            $apellidos,
            $identidad,
            $fechaNacimiento,
            $PagaAlquiler,
            $patrono,
            $actividadDesempenia,
            $ObservacionesSolicitud,
            $esAval,
            $avalMora,
            $estadoCreditoCliente,
            $CreadoPor
         )) {
            //solicitud
            //trae el id de la persona para registrala en la solicitud
            //$idPersona = $solicitud->idPersona($identidad);

            //registra la cuenta
            $solicitud->RegistrarCuenta($idPersona, 1, $cuentaCliente);

            $contactos = array(
               array('idPersona' => $idPersona, 'idTipoContacto' => 1, 'valor' => $celularCliente),
               array('idPersona' => $idPersona, 'idTipoContacto' => 2, 'valor' => $direccionCliente),
               array('idPersona' => $idPersona, 'idTipoContacto' => 3, 'valor' => $telefonoCliente),
               array('idPersona' => $idPersona, 'idTipoContacto' => 4, 'valor' => $direccionTrabajoCliente),
               array('idPersona' => $idPersona, 'idTipoContacto' => 5, 'valor' => $telefonoTrabajoCliente),

            );

            $referencias = array( //arreglo las referencias
               //solicitante
               array('idPersona' => $idPersona, 'idParentesco' => $parestencosR1, 'nombre' => $nombreR1, 'celular' => $celularR1, 'direccion' => $direccionR1),
               array('idPersona' => $idPersona, 'idParentesco' => $parestencosR2, 'nombre' => $nombreR2, 'celular' => $celularR2, 'direccion' => $direccionR2),

            );
            //registra al solicitante en la solicitud
            $cantidad = $solicitud->PrestamosAprobadosPorPersona($identidad);
            if ($cantidad == 0) {
               $prestamoAprobados = "ES SU PRIMER CRÉDITO EN EL FONDO ROTATORIO";
            } else if ($cantidad == 1) {
               $prestamoAprobados = "ES SU SEGUNDO CRÉDITO EN EL FONDO ROTATORIO";
            } else if ($cantidad == 2) {
               $prestamoAprobados = "ES SU TERCER CRÉDITO EN EL FONDO ROTATORIO";
            } else if ($cantidad == 3) {
               $prestamoAprobados = "ES SU CUARTO CRÉDITO EN EL FONDO ROTATORIO";
            } else {
               $prestamoAprobados = "ES SU QUINTO CRÉDITO EN EL FONDO ROTATORIO";
            }

            $solicitud->RegistrarSolicitud($idPersona, $idTipoPrestamo, $rubro, $idEstadoSolicitud, $idUsuario, $monto, $tasa, $plazo, $fechaEmision, $invierteEn, $prestamoAprobados, $CreadoPor);

            //obtiene el id de la solicitud para registrar el analisis crediticio
            $id = $solicitud->id_Solicitud($idPersona);

            $solicitud->RegistrarAnalisis(
               $id,
               $idEstadoAnalisisCrediticio,
               $sueldoBase,
               $ingresosNegocio,
               $RentaPropiedad,
               $remesas,
               $aporteConyuge,
               $IngresosSociedad,
               $cuotaPrestamoAdepes,
               $cuotaVivienda,
               $alimentacion,
               $deduccionesCentral,
               $otrosEgresos,
               $liquidezCliente,
               $descripcion,
               $idPersona
            );

            //registras los contactos y referencias
            $solicitud->Registrar_contactos_referencias($contactos, $referencias, $CreadoPor);


            $solicitud->RegistrarDependientes($idPersona, 1, $dependientes);  //registra los dependientes
            //registrar en bitacora
            $descripcionBitacora = "Se creo una nueva solicitud al cliente: ".$nombres." ".$apellidos;
            $solicitud->RegistrarBitacora($idUsuario, 6, "Inserto", $descripcionBitacora);

            $response = "success";  //si se inserto en la BD manda mensaje de exito
         } else {
            $response = "error";
         }
      }

      // }else{
      //   $response = "requerid"; //validad que ingresa todo los datos requeridos
      //}

      echo $response;


      break;

   case "registrar_aval":

      $hoy = date('Y-m-d');
      $idTipoPersona =  3; //AVAL
      $nombres =  $_POST["nombres"];
      $apellidos =  $_POST["apellidos"];
      $identidad =  $_POST["identidad"];
      $fechaNacimiento = $_POST["fechaNacimiento"];
      $idNacionalidad =  $_POST["idNacionalidad"];
      $idGenero =  $_POST["idGenero"];
      $idEstadoCivil = $_POST["idEstadoCivil"];
      $idProfesion =  $_POST["idProfesion"];
      $idTipoClientes =  $_POST["idTipoClientes"];
      $idcategoriaCasa =  $_POST["idcategoriaCasa"];
      $idtiempoVivir =  $_POST["idtiempoVivir"];
      $idtiempoLaboral =  $_POST["idTiempoLaboral"];

      $PagaAlquiler =  $_POST["pagaAlquiler"];
      $actividadDesempenia =  $_POST["actividadDesempenia"];
      $patrono = $_POST["patrono"];
      $direccionCliente = $_POST["direccionCliente"];
      $celularCliente = $_POST["celularCliente"];
      $telefonoCliente = $_POST["telefonoCliente"];
      $direccionTrabajoCliente = $_POST["direccionTrabajoCliente"];
      $telefonoTrabajoCliente = $_POST["telefonoTrabajoCliente"];
      $cuentaCliente = $_POST["cuentaCliente"];
      $esAval = $_POST["esAval"];
      $avalMora = $_POST["avalMora"];
      $estadoCreditoCliente = $_POST["estadoCredito"];
      $municipioAval = $_POST["municipioAval"];
      //referencias familiares
      $nombreR1 = $_POST["nombreR1"];
      $parestencosR1 = $_POST["parestencosR1"];
      $celularR1 = $_POST["celularR1"];
      $direccionR1 = $_POST["direccionR1"];
      $nombreR2 = $_POST["nombreR2"];
      $parestencosR2 = $_POST["parestencosR2"];
      $celularR2 = $_POST["celularR2"];
      $direccionR2 = $_POST["direccionR2"];
      //referencias comerciales
      $nombreRC1 = $_POST["nombreRC1"];
      $direccionRC1 = $_POST["direcionRC1"];
      $nombreRC2 = $_POST["nombreRC2"];
      $direccionRC2 = $_POST["direcionRC2"];
      //informacion adicional
      $bienesAval = null;
      $ObservacionesSolicitud = $_POST["ObservacionesSolicitud"];

      //Pareja
      $idTipoPersonaP =  2; //pareja
      $idNacionalidadP =  $_POST["idNacionalidad"];
      $idGeneroP =  $_POST["idGeneroPareja"];
      $idEstadoCivilP = $_POST["idEstadoCivil"];
      $idProfesionP =  $_POST["idProfesionPareja"];
      $idTipoClientesP =  $_POST["idTipoClientesPareja"];
      $idcategoriaCasaP =  $_POST["idcategoriaCasa"];
      $idtiempoVivirP =  $_POST["idtiempoVivir"];
      $idtiempoLaboralP =  $_POST["idTiempoLaboralPareja"];
      $nombresP =  $_POST["nombresPareja"];
      $apellidosP =  $_POST["apellidosPareja"];
      $identidadP =  $_POST["identidadPareja"];
      $fechaNacimientoP = $_POST["fechaNacimientoPareja"];
      $PagaAlquilerP =  $_POST["pagaAlquiler"];
      $actividadDesempeniaP =  $_POST["actividadDesempeniaPareja"];
      $patronoP = $_POST["patronoPareja"];
      $ingresoNegocioPareja = $_POST["ingresoNegocioPareja"];
      $sueldoBasePareja = $_POST["sueldoBasePareja"];
      $gastoAlimentacionPareja = $_POST["gastoAlimentacionPareja"];
      $cuentaPareja = $_POST["cuentaPareja"];
      $esAvalPareja = $_POST["esAvalPareja"];
      $avalMoraPareja = $_POST["avalMoraPareja"];
      $estadoCreditoPareja = $_POST["estadoCreditoPareja"];
      $municipioParejaAval = $_POST["municipioParejaAval"];
      $bienesParejaAval = null;
      $direccionPareja = $_POST["direccionPareja"];
      $celularPareja = $_POST["celularPareja"];
      $telefonoPareja = $_POST["telefonoPareja"];
      $direccionTrabajoPareja = $_POST["direccionTrabajoPareja"];
      $telefonoTrabajoPareja = $_POST["telefonoTrabajoPareja"];

      //analisis
      $sueldoBase = $_POST["sueldoBase"];
      $ingresosNegocio = $_POST["ingresosNegocio"];
      $RentaPropiedad = $_POST["RentaPropiedad"];
      $remesas = $_POST["remesas"];
      $aporteConyuge = $_POST["aporteConyuge"];
      $IngresosSociedad = $_POST["IngresosSociedad"];

      $cuotaPrestamoAdepes = $_POST["cuotaPrestamoAdepes"];
      $cuotaVivienda = $_POST["cuotaVivienda"];
      $alimentacion = $_POST["alimentacion"];
      $deduccionesCentral = $_POST["deduccionesCentral"];
      $otrosEgresos = $_POST["otrosEgresos"];
      $liquidezCliente = $_POST["liquidezCliente"];
      $descripcion = $_POST["descripcion"];
      $idEstadoAnalisisCrediticio = 1;

      $idUsuario =  $_SESSION["user"]["idUsuario"];
      $CreadoPor =  $_SESSION["user"]["Usuario"];
      $idEstadoSolicitud = 3;


      if ($idEstadoCivil == 2 || $idEstadoCivil == 3) {
    
            //inserta los datos del cliente
         if ($idPersona = $solicitud->RegistrarCliente(
            $idTipoPersona,
            $idNacionalidad,
            $idGenero,
            $idEstadoCivil,
            $idProfesion,
            $bienesAval,
            $idTipoClientes,
            $idcategoriaCasa,
            $idtiempoVivir,
            $municipioAval,
            $idtiempoLaboral,
            $nombres,
            $apellidos,
            $identidad,
            $fechaNacimiento,
            $PagaAlquiler,
            $patrono,
            $actividadDesempenia,
            $ObservacionesSolicitud,
            $esAval,
            $avalMora,
            $estadoCreditoCliente,
            $CreadoPor
         )) {


            //registra la cuenta
            $solicitud->RegistrarCuenta($idPersona, 1, $cuentaCliente);
            //obtiene el id de la solicitud para registrar el analisis crediticio
            $solicitud_id = $_SESSION["Solicitud"]["idSolicitud"];
            //registra el aval
            $solicitud->RegistrarAval($solicitud_id, $idPersona, $CreadoPor);

            $solicitud->RegistrarAnalisis(
               $solicitud_id,
               $idEstadoAnalisisCrediticio,
               $sueldoBase,
               $ingresosNegocio,
               $RentaPropiedad,
               $remesas,
               $aporteConyuge,
               $IngresosSociedad,
               $cuotaPrestamoAdepes,
               $cuotaVivienda,
               $alimentacion,
               $deduccionesCentral,
               $otrosEgresos,
               $liquidezCliente,
               $descripcion,
               $idPersona
            );



            $ObservacionesSolicitud = "";
            //inserta los datos de la pareja
            if ($idPersonaPareja = $solicitud->RegistrarCliente(
               $idTipoPersonaP,
               $idNacionalidadP,
               $idGeneroP,
               $idEstadoCivilP,
               $idProfesionP,
               $bienesParejaAval,
               $idTipoClientesP,
               $idcategoriaCasaP,
               $idtiempoVivirP,
               $municipioParejaAval,
               $idtiempoLaboralP,
               $nombresP,
               $apellidosP,
               $identidadP,
               $fechaNacimientoP,
               $PagaAlquilerP,
               $patronoP,
               $actividadDesempeniaP,
               $ObservacionesSolicitud,
               $esAvalPareja,
               $avalMoraPareja,
               $estadoCreditoPareja,
               $CreadoPor
            )) {

               //registra los ingresos del conyugue
               $solicitud->RegistrarConyuge($solicitud_id, $idPersonaPareja, $ingresoNegocioPareja, $sueldoBasePareja, $gastoAlimentacionPareja, $idPersona);
               //registra la cuenta
               $solicitud->RegistrarCuenta($idPersonaPareja, 1, $cuentaPareja);
               $contactos = array(
                  //solicitante
                  array('idPersona' => $idPersona, 'idTipoContacto' => 1, 'valor' => $celularCliente),
                  array('idPersona' => $idPersona, 'idTipoContacto' => 2, 'valor' => $direccionCliente),
                  array('idPersona' => $idPersona, 'idTipoContacto' => 3, 'valor' => $telefonoCliente),
                  array('idPersona' => $idPersona, 'idTipoContacto' => 4, 'valor' => $direccionTrabajoCliente),
                  array('idPersona' => $idPersona, 'idTipoContacto' => 5, 'valor' => $telefonoTrabajoCliente),
                  //pareja
                  array('idPersona' => $idPersonaPareja, 'idTipoContacto' => 1, 'valor' => $celularPareja),
                  array('idPersona' => $idPersonaPareja, 'idTipoContacto' => 2, 'valor' => $direccionPareja),
                  array('idPersona' => $idPersonaPareja, 'idTipoContacto' => 3, 'valor' => $telefonoPareja),
                  array('idPersona' => $idPersonaPareja, 'idTipoContacto' => 4, 'valor' => $direccionTrabajoPareja),
                  array('idPersona' => $idPersonaPareja, 'idTipoContacto' => 5, 'valor' => $telefonoTrabajoPareja),
               );


               $referencias = array( //arreglo las referencias familiares
                  //solicitante
                  array('idPersona' => $idPersona, 'idParentesco' => $parestencosR1, 'nombre' => $nombreR1, 'celular' => $celularR1, 'direccion' => $direccionR1),
                  array('idPersona' => $idPersona, 'idParentesco' => $parestencosR2, 'nombre' => $nombreR2, 'celular' => $celularR2, 'direccion' => $direccionR2),

               );

               $comerciales = array( //arreglo las referencias comerciales
                  //solicitante
                  array('idPersona' => $idPersona, 'nombre' => $nombreRC1, 'direccion' => $direccionRC1),
                  array('idPersona' => $idPersona, 'nombre' => $nombreRC2, 'direccion' => $direccionRC2),

               );

               //registras los contactos y referencias
               $solicitud->Registrar_contactos_referencias($contactos, $referencias, $CreadoPor);
               //referencias comerciales del aval
               $solicitud->RegistrarReferenciasComerciales($comerciales, $CreadoPor);
            }

            $response = "registrarPareja";  //si se inserto en la BD manda mensaje de exito
         } else {
            $response = "error";
         }
      } else {  //soltero o no definido
         if ($idPersona = $solicitud->RegistrarCliente(
            $idTipoPersona,
            $idNacionalidad,
            $idGenero,
            $idEstadoCivil,
            $idProfesion,
            $bienesAval,
            $idTipoClientes,
            $idcategoriaCasa,
            $idtiempoVivir,
            $municipioAval,
            $idtiempoLaboral,
            $nombres,
            $apellidos,
            $identidad,
            $fechaNacimiento,
            $PagaAlquiler,
            $patrono,
            $actividadDesempenia,
            $ObservacionesSolicitud,
            $esAval,
            $avalMora,
            $estadoCreditoCliente,
            $CreadoPor
         )) {
            //solicitud

            //registra la cuenta
            $solicitud->RegistrarCuenta($idPersona, 1, $cuentaCliente);
            //registra el aval con el id del solicitante
            $solicitud_id = $_SESSION["Solicitud"]["idSolicitud"];
            $solicitud->RegistrarAval($solicitud_id, $idPersona, $CreadoPor);

            $contactos = array(
               array('idPersona' => $idPersona, 'idTipoContacto' => 1, 'valor' => $celularCliente),
               array('idPersona' => $idPersona, 'idTipoContacto' => 2, 'valor' => $direccionCliente),
               array('idPersona' => $idPersona, 'idTipoContacto' => 3, 'valor' => $telefonoCliente),
               array('idPersona' => $idPersona, 'idTipoContacto' => 4, 'valor' => $direccionTrabajoCliente),
               array('idPersona' => $idPersona, 'idTipoContacto' => 5, 'valor' => $telefonoTrabajoCliente),

            );

            $referencias = array( //arreglo las referencias
               //solicitante
               array('idPersona' => $idPersona, 'idParentesco' => $parestencosR1, 'nombre' => $nombreR1, 'celular' => $celularR1, 'direccion' => $direccionR1),
               array('idPersona' => $idPersona, 'idParentesco' => $parestencosR2, 'nombre' => $nombreR2, 'celular' => $celularR2, 'direccion' => $direccionR2),

            );

            $comerciales = array( //arreglo las referencias
               //solicitante
               array('idPersona' => $idPersona, 'nombre' => $nombreRC1, 'direccion' => $direccionRC1),
               array('idPersona' => $idPersona, 'nombre' => $nombreRC2, 'direccion' => $direccionRC2),

            );
            //hasta aqui


            //obtiene el id de la solicitud para registrar el analisis crediticio
            // $id = $solicitud->id_Solicitud($idPersona);

            $solicitud->RegistrarAnalisis(
               $solicitud_id,
               $idEstadoAnalisisCrediticio,
               $sueldoBase,
               $ingresosNegocio,
               $RentaPropiedad,
               $remesas,
               $aporteConyuge,
               $IngresosSociedad,
               $cuotaPrestamoAdepes,
               $cuotaVivienda,
               $alimentacion,
               $deduccionesCentral,
               $otrosEgresos,
               $liquidezCliente,
               $descripcion,
               $idPersona
            );

            //registras los contactos y referencias
            $solicitud->Registrar_contactos_referencias($contactos, $referencias, $CreadoPor);
            //referencia comercial
            $solicitud->RegistrarReferenciasComerciales($comerciales, $CreadoPor);



            $response = "success";  //si se inserto en la BD manda mensaje de exito
         } else {
            $response = "error";
         }
      }

      // }else{
      //   $response = "requerid"; //validad que ingresa todo los datos requeridos
      //}

      echo $response;


      break;

   case "obtener_datos_prestamo":
      if (isset($_POST["idTipoPrestamo"]) && !empty($_POST["idTipoPrestamo"])) {

         $data = $solicitud->ObtenerDatosPrestamo($_POST["idTipoPrestamo"]);
         if ($data) {
            $list[] = array(
               "ID" => $data['idTipoPrestamo'],
               "TASA" => $data['tasa'],
               "PLAZO" => $data['PlazoMaximo'],
               "MAXIMO" => $data['montoMaximo'],
               "MINIMO" => $data['montoMinimo']
            );
            echo json_encode($list);
         }
      }

      break;

   case "registrar_profesion":
      if (isset($_POST["descripcion"]) && !empty($_POST["descripcion"])) {
         $descripcion = $_POST["descripcion"];

         if ($solicitud->RegistrarProfesion($descripcion)) {
            $response = "success";  //si se inserto en la BD manda mensaje de exito
         } else {
            $response = "error";
         }
      } else {
         $response = "requerid"; //validad que ingresa todo los datos requeridos
      }

      echo $response;


      break;

   case "listar_profesion_edit_porusuario":

      $datos = $solicitud->ListarProfesionesPorUsuario();
      if ($datos) {  //valida que traiga datos
         for ($i = 0; $i < count($datos); $i++) {
            $list[] = array(  //se pone los campos que queremos guardar
               "0" => $datos[$i]['idProfesion'],
               "1" => $datos[$i]['Descripcion'],
            );
         }
         echo json_encode($list); //se devuelve los datos en formato json 
      }

      break;

   case "dictamen_asesor":
      if (isset($_POST["idPersona"]) && !empty($_POST["idPersona"])) {

         $data = $solicitud->DictamenAsesor($_POST["idPersona"]);
         if ($data) {
            $list[] = array(
               "dictamen" => $data['dictamen'],
               "identidad" => $data['identidad'],
               "prestamoAprobados" => $data['prestamoAprobados'],
               "numeroActa" => $data['numeroActa'],
               "dictamenAsesor" => $data['dictamenAsesor'],
               "estadoSolicitudComite" => $data['Descripcion']
            );
            echo json_encode($list);
         }
      }

   break;

  
} //fin switch
