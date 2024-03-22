function ActualizarCliente(){
    //datos del cliente
    idPersonaEdit = $('#idSolicitante_edit').val(); 
    idSolicitudEdit = $('#idSolicitud_edit').val(); 
    idTipoPrestamo = $('#tipogarantia_edit').val(); 
    monto = $('#monto_edit').val(); 
    plazo = $('#plazo_edit').val(); 
    rubro = $('#rubro_edit').val(); 
    fechaEmision = $('#fechaEmision_edit').val(); 
    nombreCliente = $('#nombresCliente_edit').val();
    apellidoCliente = $('#apellidosCliente_edit').val();
    identidad = $('#identidadCliente_edit').val();
    fechaNacimiento = $('#fechaNacimiento_edit').val();
    idNacionalidad = $('#nacionalidad_edit').val();
    idMunicipio = $('#municipio_edit').val();
    direccionCliente = $('#direccionCliente_edit').val();
    celularCliente = $('#celularCLiente_edit').val();
    telefonoCliente = $('#telefonoCliente_edit').val();
    direccionTrabajoCliente = $('#direccionTrabajoCliente').val();
    telefonoTrabajoCliente = $('#telefonoClienteTrabajo').val();
  
    idEstadoCivil =$('#estadoCivil_edit').val(); 
    idcategoriaCasa = $('#casa_edit').val();
    idtiempoVivir = $('#tiempoVivir_edit').val();
    pagaAlquiler = $('#formaPago_edit').val();
    pagoCasa = $('#pagoCasa_edit').val();
    idGenero = $('#idGeneroCliente_edit').val();
    idProfesion = $('#profesiones_edit').val(); 
    patrono = $('#patrono_edit').val();
    actividadDesempenia = $('#actividadDesempeña_edit').val();
    idTiempoLaboral = $('#tiempoLaboral_edit').val();
    idTipoClientes = $('#tipoCliente_edit').val();
    
    cuentaCliente = $('#cuentaCliente_edit').val();
    esAval = $('#esAvalCliente_edit').val();
    avalMora = $('#avalMoraCliente_edit').val();
    estadoCredito = $('#estadoCreditoCliente_edit').val();
    
    //referencias Familiares
    nombreR1 = $('#nombreR1_edit').val();
    parestencosR1 = $('#parestencosR1_edit').val();
    celularR1 = $('#celularR1_edit').val();
    direccionR1 = $('#direccionR1_edit').val();
    nombreR2 = $('#nombreR2_edit').val();
    parestencosR2 = $('#parestencosR2_edit').val();
    celularR2 = $('#celularR2_edit').val();
    direccionR2 = $('#direccionR2_edit').val();
    //informacion adicional
    invierteEn = $('#invierteEn_edit').val();
    idBienes = $('#bienes').val();
    dependientes = $('#dependientes_edit').val();
    ObservacionesSolicitud = $('#observaciones_edit').val();
    //datos de la pareja
    idPareja = $('#idPareja').val();
    nombresPareja = $('#nombresPareja_edit').val();
    apellidosPareja = $('#apellidosPareja_edit').val();
    identidadPareja = $('#identidadPareja_edit').val();
    fechaNacimientoPareja = $('#fechaNacimientoPareja_edit').val();
    idMunicipioPareja = $('#municipioPareja_edit').val(); 
    idGeneroPareja = $('#generoPareja_edit').val();  
    actividadDesempeniaPareja = $('#actividadPareja_edit').val();
    idTiempoLaboralPareja = $('#tiempoLaboralPareja_edit').val();
    idProfesionPareja = $('#profesionPareja_edit').val();
    patronoPareja = $('#patronoPareja_edit').val();
    idTipoClientesPareja = $('#tipoClientePareja_edit').val();
    direccionPareja = $('#direccionPareja_edit').val();
    celularPareja = $('#celularPareja_edit').val();
    telefonoPareja = $('#telefonoPareja_edit').val();
    direccionTrabajoPareja = $('#direccionTrabajoPareja_edit').val();
    telefonoTrabajoPareja = $('#telefonoParejaTrabajo_edit').val();
    ingresoNegocioPareja = $('#ingresoNegocioPareja_edit').val();
    sueldoBasePareja = $('#sueldoBasePareja_edit').val();
    gastoAlimentacionPareja = $('#gastoAlimentacionPareja_edit').val();
    cuotaPareja = $('#cuotaPareja_edit').val();
    cuentaPareja = $('#cuentaPareja').val();
    esAvalPareja = $('#esAvalPareja_edit').val();
    avalMoraPareja = $('#avalMoraPareja_edit').val();
    estadoCreditoPareja = $('#estadoCreditoPareja_edit').val();
  
    //analisis crediticio
    sueldoBase = $('#sueldoBase_analisis').val();
    ingresosNegocio = $('#ingresosNegocio').val();
    RentaPropiedad = $('#renta').val();
    remesas = $('#remesas').val();
    aporteConyuge = $('#aporteConyuge').val();
    IngresosSociedad = $('#sociedad').val();
  
    cuotaPrestamoAdepes = $('#cuotaAdepes').val();
    cuotaVivienda= $('#vivienda').val();
    alimentacion= $('#alimentacion').val();
    deduccionesCentral = $('#centralRiesgo').val();
    otrosEgresos = $('#otrosEgresos').val();
    liquidezCliente = $('#capitalDisponible').val();
    evaluacionAnalisis = $('#evaluacion').val();
  
    
   //DICTAMEN ASESOR
   dictamenAsesor = $('#dictamenEdit').val();
    
    if( monto ===""){
        toastr.warning('Debe ingresar un monto');
        var inputElement = document.getElementById("monto");
        inputElement.focus();
        return
    } 
    if( plazo ===""){
        toastr.warning('Debe ingresar el plazo');
        var inputElement = document.getElementById("plazo");
        inputElement.focus();
        return
    } 
    if( rubro ===""){
        toastr.warning('Debe seleccionar un rubro');
        return
    } 
    if( fechaEmision ===""){
        toastr.warning('Debe ingresar la fecha de emisión');
        return
    } 
    if(nombreCliente === ""){
        toastr.warning('¡Debes ingresar el nombre del solicitante!');
        return
    }
    if(apellidoCliente === ""){
        toastr.warning('¡Debes ingresar el apellido del solicitante!');
        return
    }
    if(identidad === ""){
        toastr.warning('¡Debes ingresar la identidad del solicitante');
        return
    }
    if(identidad === "0000-0000-00000" || identidad.length<15){
        toastr.warning('Número de indentidad incorrecto');
        return
    }
    if(fechaNacimiento === ""){
        toastr.warning('¡Debes ingresar la fecha de nacimiento solicitante');
        return
    }
   
    if(direccionCliente === ""){
        toastr.warning('Debe ingresar la dirección del solicitante');
        return
    }
    if(telefonoCliente !== "" && telefonoCliente.length <9 || telefonoCliente=="0000-0000" ){
        toastr.warning('Teléfono del solicitante incorrecto');
        return
    }
   
    if(celularCliente === ""){
        toastr.warning('Debe ingresar el número de celular del solicitante');
        return
    }
    if(celularCliente.length <9 || celularCliente=="0000-0000" ){
        toastr.warning('Celular del solicitante incorrecto');
        return
    }
  
    if(pagaAlquiler > 1 && pagoCasa==="" ){
        toastr.warning('Debe ingresar el pago del alquiler');
        return
    }
  
   
    if(actividadDesempenia === ""){
        toastr.warning('Debe ingresar la actividad que desempeña el solicitante');
        return
    }
  
    if(telefonoTrabajoCliente !== "" && telefonoTrabajoCliente.length <9 || telefonoTrabajoCliente=="0000-0000" || telefonoTrabajoCliente=="1111-1111"){
        toastr.warning('Teléfono del trabajo del solicitante incorrecto');
        return
    }
    
  
    if(celularR1 !== "" && celularR1.length <9 || celularR1=="0000-0000" || celularR1=="1111-1111"){
        toastr.warning('Celular de referencia 1 incorrecto');
        return
    }
    if(celularR2 !== "" && celularR2.length <9 || celularR2=="0000-0000" || celularR2=="1111-1111" ){
        toastr.warning('Celular de referencia 2 incorrecto');
        return
    }
  
    if(invierteEn === ""){
        toastr.warning('Debe ingresar el motivo de la inversión');
        return
    }
  
   parametros = {
   //SOLICITANTE
   "idPersonaEdit":idPersonaEdit, "idSolicitudEdit":idSolicitudEdit, "monto":monto, "idTipoPrestamo":idTipoPrestamo, "plazo":plazo, "plazo":plazo, "rubro":rubro,
   "fechaEmision":fechaEmision, "nombreCliente":nombreCliente, "apellidoCliente":apellidoCliente, "identidad":identidad, "fechaNacimiento":fechaNacimiento,
   "idNacionalidad":idNacionalidad, "idMunicipio":idMunicipio,  "direccionCliente":direccionCliente, "celularCliente":celularCliente, "telefonoCliente":telefonoCliente,
   "direccionTrabajoCliente":direccionTrabajoCliente, "telefonoTrabajoCliente":telefonoTrabajoCliente, "idEstadoCivil":idEstadoCivil, "idcategoriaCasa":idcategoriaCasa,
   "idtiempoVivir":idtiempoVivir, "pagaAlquiler":pagaAlquiler, "pagoCasa":pagoCasa, "idGenero":idGenero,  "idProfesion":idProfesion, "patrono":patrono, "actividadDesempenia":actividadDesempenia, 
   "idTiempoLaboral":idTiempoLaboral,   "idTipoClientes":idTipoClientes, "cuentaCliente":cuentaCliente, "esAval":esAval, "avalMora":avalMora, "estadoCredito":estadoCredito,
   
    //referencias
    "nombreR1":nombreR1, "parestencosR1":parestencosR1, "celularR1":celularR1, "direccionR1":direccionR1, "nombreR2":nombreR2, "parestencosR2":parestencosR2,
    "celularR2":celularR2, "direccionR2":direccionR2,
     //informacion adicional
     "invierteEn":invierteEn, "idBienes":idBienes, "dependientes":dependientes, "ObservacionesSolicitud":ObservacionesSolicitud, 
     //dictamen del asesor
     "dictamenAsesor":dictamenAsesor,
     //analisis crediticio
     "sueldoBase":sueldoBase, "ingresosNegocio":ingresosNegocio, "RentaPropiedad":RentaPropiedad, "remesas":remesas, "aporteConyuge":aporteConyuge, "IngresosSociedad":IngresosSociedad,
     "cuotaPrestamoAdepes":cuotaPrestamoAdepes, "cuotaVivienda":cuotaVivienda, "alimentacion":alimentacion, "deduccionesCentral":deduccionesCentral, "otrosEgresos":otrosEgresos,
     "liquidezCliente":liquidezCliente, "evaluacionAnalisis":evaluacionAnalisis,
     //Datos pareja
     "idPareja":idPareja, "nombresPareja":nombresPareja, "apellidosPareja":apellidosPareja, "identidadPareja":identidadPareja, "fechaNacimientoPareja":fechaNacimientoPareja, "idMunicipioPareja":idMunicipioPareja,
     "idGeneroPareja":idGeneroPareja, "actividadDesempeniaPareja":actividadDesempeniaPareja, "idTiempoLaboralPareja":idTiempoLaboralPareja, "idProfesionPareja":idProfesionPareja, "patronoPareja":patronoPareja,
     "idTipoClientesPareja":idTipoClientesPareja, "direccionPareja":direccionPareja, "celularPareja":celularPareja, "telefonoPareja":telefonoPareja, "direccionTrabajoPareja":direccionTrabajoPareja, "telefonoTrabajoPareja":telefonoTrabajoPareja,
     "ingresoNegocioPareja":ingresoNegocioPareja, "sueldoBasePareja":sueldoBasePareja, "gastoAlimentacionPareja":gastoAlimentacionPareja, "cuotaPareja":cuotaPareja, "cuentaPareja":cuentaPareja, "esAvalPareja":esAvalPareja,
     "avalMoraPareja":avalMoraPareja, "estadoCreditoPareja":estadoCreditoPareja
     
   }
  
    $.ajax({
        data:parametros,
        url:'../controller/EditarSolicitudController.php?operador=Actualizar_Persona', //url del controlador RolConttroller
        type:'POST',
        beforeSend:function(){},
        success:function(response){
            //console.log(response);
            if(response == "success"){  //si inserto correctamente
              ActualizarAval1();
              
            }else if(response == "montoMayor"){
              toastr.warning('El monto excede lo permitido');
            }else if(response == "montoMinimo"){
              toastr.warning('Monto minimo no permitido');
            }else if(response == "plazoMaximo"){
              toastr.warning('El plazo ingresado excede lo permitido');
            }else if(response == "nombrePareja"){
              toastr.warning('Ingrese el nombre de la pareja');
            }else if(response == "apellidoPareja"){
              toastr.warning('Ingrese el apellido de la pareja');
            }else if(response == "identidadPareja"){
              toastr.warning('Ingrese la identidad de la pareja');
            }else if(response == "identidadIncorrecta"){
              toastr.warning('Identidad de la pareja incorrecta');
            }else{
                Swal.fire({
                    icon: 'error',
                    title: 'error',
                    text: 'No se han podido alctualizar correctamente los datos',
                  })
            }
        }
    })
    
  }
  
  function ActualizarAval1(){
      //datos del aval
      idPersonaAvalEdit = $('#idAval1').val();  
      nombreAval1 = $('#nombresAval_edit1').val();
      apellidoAval1 = $('#apellidosAval_edit1').val();
      identidadAval1 = $('#identidadAval__edit1').val();
      fechaNacimientoAval1 = $('#fechaNacimiento_edit1').val();
      idNacionalidadAval1 = $('#nacionalidad_edit1').val();
      idMunicipioAval1 = $('#municipio_edit1').val();
      direccionAval1 = $('#direccionAval_edit1').val();
      celularAval1 = $('#celularAval_edit1').val();
      telefonoAval1 = $('#telefonoAval_edit1').val();
      direccionTrabajoAval1 = $('#direccionTrabajoAval_edit1').val();
      telefonoTrabajoAval1 = $('#telefonoAvalTrabajo_edit1').val();
    
      idEstadoCivilAval1 =$('#estadoCivil_edit1').val(); 
      idcategoriaCasaAval1 = $('#casa_edit1').val();
      idtiempoVivirAval1 = $('#tiempoVivir_edit1').val();
      pagaAlquilerAval1 = $('#pagaAlquiler_edit1').val();
      pagoCasaAval1 = $('#pagoCasa_aval1').val();
      idGeneroAval1 = $('#idGeneroAval_edit1').val();
      idProfesionAval1 = $('#profesiones_edit1').val(); 
      patronoAval1 = $('#patrono_edit1').val();
      actividadDesempeniaAval1 = $('#actividadDesempeña_edit1').val();
      idTiempoLaboralAval1 = $('#tiempoLaboral_edit1').val();
      idTipoClientesAval1 = $('#tipoClienteAval_edit1').val();
      
      cuentaAval1 = $('#cuentaAval_avl1').val();
      esAvalAval1 = $('#esAval_edit1').val();
      avalMoraAval1 = $('#avalMoraAval_edit1').val();
      estadoCreditoAval1 = $('#estadoCreditoAval_edit1').val();
      
      //referencias Familiares
      nombreR1Aval1 = $('#nombreR1_aval').val();
      parestencosR1Aval1 = $('#parestencosR1aval1').val();
      celularR1Aval1 = $('#celularR1aval').val();
      direccionR1Aval1 = $('#direccionR1aval').val();
      nombreR2Aval1 = $('#nombreR2aval1').val();
      parestencosR2Aval1 = $('#parestencosR2aval1').val();
      celularR2Aval1 = $('#celularR2aval1').val();
      direccionR2Aval1 = $('#direccionR2aval1').val();
      //informacion adicional
      ObservacionesSolicitudAval1 = $('#observaciones_edit1').val();
      //referencias Comerciales
      nombreComercial1AVAL1 = $('#nombreComercial1AVAL1').val();
      direccionComercial1AVAL1 = $('#direccionComercial1AVAL1').val();
      nombreComercial2AVAL1 = $('#nombreComercial2AVAL1').val();
      direccionComercial2AVAL1 = $('#direccionComercial2AVAL1').val();
      //datos de la pareja
      idParejaAval1 = $('#idParejaval1').val();
      nombresParejaAval1 = $('#nombresParejaAval1').val();
      apellidosParejaAval1 = $('#apellidosParejaAval1').val();
      identidadParejaAval1 = $('#identidadParejaAval1').val();
      fechaNacimientoParejaAval1 = $('#fechaNacimientoParejaAval1').val();
      municipioParejaAval1 = $('#municipioParejaAval1').val(); 
      generoParejaAval1 = $('#generoParejaAval1').val();  
      actividadParejaAval1 = $('#actividadParejaAval1').val();
      tiempoLaboralParejaAval1 = $('#tiempoLaboralParejaAval1').val();
      profesionParejaAval1 = $('#profesionParejaAval1').val();
      patronoParejaAval1 = $('#patronoParejaAval1').val();
      tipoClienteParejaAval1 = $('#tipoClienteParejaAval1').val();
      direccionParejaAval1 = $('#direccionParejaAval1').val();
      celularParejaAval1 = $('#celularParejaAval1').val();
      telefonoParejaAval1 = $('#telefonoParejaAval1').val();
      direccionTrabajoParejaAval1 = $('#direccionTrabajoParejaAval1').val();
      telefonoParejaTrabajoAval1 = $('#telefonoParejaTrabajoAval1').val();
      ingresoNegocioParejaAval1 = $('#ingresoNegocioParejaAval1').val();
      sueldoBaseParejaAval1 = $('#sueldoBaseParejaAval1').val();
      gastoAlimentacionParejaAval1 = $('#gastoAlimentacionParejaAval1').val();
      cuotaParejaAval1 = $('#cuotaParejaAval1').val();
      cuentaParejaAval1 = $('#cuentaParejaAval1').val();
      esAvalParejaAVAL1 = $('#esAvalParejaAVAL1').val();
      avalMoraParejaAVAL1 = $('#avalMoraParejaAVAL1').val();
      estadoCreditoParejaAVAL1 = $('#estadoCreditoParejaAVAL1').val();
    
      //analisis crediticio
      sueldoBase_analisisAval1 = $('#sueldoBase_analisisAval1').val();
      ingresosNegocioAval1 = $('#ingresosNegocioAval1').val();
      rentaAval1 = $('#rentaAval1').val();
      remesasAval1 = $('#remesasAval1').val();
      aporteConyugeAval1 = $('#aporteConyugeAval1').val();
      sociedadAval1 = $('#sociedadAval1').val();
    
      cuotaAdepesAval1 = $('#cuotaAdepesAval1').val();
      viviendaAval1= $('#viviendaAval1').val();
      alimentacionAval1= $('#alimentacionAval1').val();
      centralRiesgoAval1 = $('#centralRiesgoAval1').val();
      otrosEgresosAval1 = $('#otrosEgresosAval1').val();
      capitalDisponibleAval1 = $('#capitalDisponibleAval1').val();
      evaluacionAval1 = $('#evaluacionAval1').val();
      
  if(idPersonaAvalEdit !== ""){
  
  
      if(nombreAval1 === ""){
          toastr.warning('¡Debes ingresar el nombre del aval 1!');
          return
      }
      if(apellidoAval1 === ""){
          toastr.warning('¡Debes ingresar el apellido del aval 1!');
          return
      }
      if(identidadAval1 === ""){
          toastr.warning('¡Debes ingresar la identidad del aval 1');
          return
      }
      if(identidadAval1 === "0000-0000-00000" || identidadAval1 === "1111-1111-11111" || identidadAval1.length<15){
          toastr.warning('Número de indentidad incorrecto del aval 1');
          return
      }
      if(fechaNacimientoAval1 === ""){
          toastr.warning('¡Debes ingresar la fecha de nacimiento del aval 1');
          return
      }
     
      if(direccionAval1 === ""){
          toastr.warning('Debe ingresar la dirección del aval 1');
          return
      }
      if(telefonoAval1 !== "" && telefonoAval1.length <9 || telefonoAval1=="0000-0000" ){
          toastr.warning('Teléfono del aval 1 incorrecto');
          return
      }
     
      if(celularAval1 === ""){
          toastr.warning('Debe ingresar el número de celular del aval 1');
          return
      }
      if(celularAval1.length <9 || celularAval1=="0000-0000" || celularAval1=="1111-1111" ){
          toastr.warning('Celular del aval 1 incorrecto');
          return
      }
    
      if(pagaAlquilerAval1 > 1 && pagoCasaAval1==="" ){
          toastr.warning('Debe ingresar el pago del alquiler del aval 1');
          return
      }
      
     
      if(actividadDesempeniaAval1 === ""){
          toastr.warning('Debe ingresar la actividad que desempeña el aval 1');
          return
      }
    
      if(telefonoTrabajoAval1 !== "" && telefonoTrabajoAval1.length <9 || telefonoTrabajoAval1=="0000-0000" || telefonoTrabajoAval1=="1111-1111"){
          toastr.warning('Teléfono del trabajo del aval 1 incorrecto');
          return
      }
      
    
      if(celularR1Aval1 !== "" && celularR1Aval1.length <9 || celularR1Aval1=="0000-0000" || celularR1Aval1=="1111-1111"){
          toastr.warning('Celular de referencia 1 de aval 1 incorrecto');
          return
      }
      if(celularR2Aval1 !== "" && celularR2Aval1.length <9 || celularR2Aval1=="0000-0000" || celularR2Aval1=="1111-1111" ){
          toastr.warning('Celular de referencia 2 de aval 1 incorrecto');
          return
      }
    
  
    
     parametros = {
     //SOLICITANTE
     "idPersonaAvalEdit":idPersonaAvalEdit,
     "nombreAval1":nombreAval1, "apellidoAval1":apellidoAval1, "identidadAval1":identidadAval1, "fechaNacimientoAval1":fechaNacimientoAval1,
     "idNacionalidadAval1":idNacionalidadAval1, "idMunicipioAval1":idMunicipioAval1,  "direccionAval1":direccionAval1, "celularAval1":celularAval1, "telefonoAval1":telefonoAval1,
     "direccionTrabajoAval1":direccionTrabajoAval1, "telefonoTrabajoAval1":telefonoTrabajoAval1, "idEstadoCivilAval1":idEstadoCivilAval1, "idcategoriaCasaAval1":idcategoriaCasaAval1,
     "idtiempoVivirAval1":idtiempoVivirAval1, "pagaAlquilerAval1":pagaAlquilerAval1, "pagoCasaAval1":pagoCasaAval1, "idGeneroAval1":idGeneroAval1,  "idProfesionAval1":idProfesionAval1,
     "patronoAval1":patronoAval1, "actividadDesempeniaAval1":actividadDesempeniaAval1, "idTiempoLaboralAval1":idTiempoLaboralAval1, "idTipoClientesAval1":idTipoClientesAval1, "cuentaAval1":cuentaAval1,
     "esAvalAval1":esAvalAval1, "avalMoraAval1":avalMoraAval1, "estadoCreditoAval1":estadoCreditoAval1, 
     
      //referencias
      "nombreR1Aval1":nombreR1Aval1, "parestencosR1Aval1":parestencosR1Aval1, "celularR1Aval1":celularR1Aval1, "direccionR1Aval1":direccionR1Aval1, "nombreR2Aval1":nombreR2Aval1, 
      "parestencosR2Aval1":parestencosR2Aval1, "celularR2Aval1":celularR2Aval1, "direccionR2Aval1":direccionR2Aval1, "ObservacionesSolicitudAval1":ObservacionesSolicitudAval1,
      //referencias Comerciales
      "nombreComercial1AVAL1":nombreComercial1AVAL1, "direccionComercial1AVAL1":direccionComercial1AVAL1, "nombreComercial2AVAL1":nombreComercial2AVAL1, "direccionComercial2AVAL1":direccionComercial2AVAL1,
      
       //analisis crediticio
       "sueldoBase_analisisAval1":sueldoBase_analisisAval1, "ingresosNegocioAval1":ingresosNegocioAval1, "rentaAval1":rentaAval1, "remesasAval1":remesasAval1, "aporteConyugeAval1":aporteConyugeAval1, "sociedadAval1":sociedadAval1,
       "cuotaAdepesAval1":cuotaAdepesAval1, "viviendaAval1":viviendaAval1, "alimentacionAval1":alimentacionAval1, "centralRiesgoAval1":centralRiesgoAval1, "otrosEgresosAval1":otrosEgresosAval1,
       "capitalDisponibleAval1":capitalDisponibleAval1, "evaluacionAval1":evaluacionAval1,
  
       //Datos pareja
       "idParejaAval1":idParejaAval1, "nombresParejaAval1":nombresParejaAval1, "apellidosParejaAval1":apellidosParejaAval1, "identidadParejaAval1":identidadParejaAval1, "fechaNacimientoParejaAval1":fechaNacimientoParejaAval1, "municipioParejaAval1":municipioParejaAval1,
       "generoParejaAval1":generoParejaAval1, "actividadParejaAval1":actividadParejaAval1, "tiempoLaboralParejaAval1":tiempoLaboralParejaAval1, "profesionParejaAval1":profesionParejaAval1, "patronoParejaAval1":patronoParejaAval1,
       "tipoClienteParejaAval1":tipoClienteParejaAval1, "direccionParejaAval1":direccionParejaAval1, "celularParejaAval1":celularParejaAval1, "telefonoParejaAval1":telefonoParejaAval1, "direccionTrabajoParejaAval1":direccionTrabajoParejaAval1, "telefonoParejaTrabajoAval1":telefonoParejaTrabajoAval1,
       "ingresoNegocioParejaAval1":ingresoNegocioParejaAval1, "sueldoBaseParejaAval1":sueldoBaseParejaAval1, "gastoAlimentacionParejaAval1":gastoAlimentacionParejaAval1, "cuotaParejaAval1":cuotaParejaAval1, "cuentaParejaAval1":cuentaParejaAval1, "esAvalParejaAVAL1":esAvalParejaAVAL1,
       "avalMoraParejaAVAL1":avalMoraParejaAVAL1, "estadoCreditoParejaAVAL1":estadoCreditoParejaAVAL1
       
     }
    
      $.ajax({
          data:parametros,
          url:'../controller/EditarSolicitudController.php?operador=Actualizar_aval1', //url del controlador RolConttroller
          type:'POST',
          beforeSend:function(){},
          success:function(response){
              //console.log(response);
              if(response == "success"){  //si inserto correctamente
                  
                  ActualizarAval2();
              }else if(response == "nombrePareja"){
                toastr.warning('Ingrese el nombre de la pareja del aval 1');
              }else if(response == "apellidoPareja"){
                toastr.warning('Ingrese el apellido de la pareja del aval 1');
              }else if(response == "identidadPareja"){
                toastr.warning('Ingrese la identidad de la pareja del aval 1');
              }else if(response == "identidadIncorrecta"){
                toastr.warning('Identidad de la pareja del aval 1 incorrecta');
              }else{
                  Swal.fire({
                      icon: 'error',
                      title: 'error',
                      text: 'No se han podido alctualizar correctamente los datos',
                    })
              }
          }
      })
  }else{
      ActualizarAval2(); 
  }  //fin del if de si existe aval
  
  }
  
  
  function ActualizarAval2(){
      //datos del aval
      idPersonaAval2 = $('#idPersonaAval2').val(); 
      nombreAval2 = $('#nombresAval_edit2').val();
      apellidoAval2 = $('#apellidosAval_edit2').val();
      identidadAval2 = $('#identidadAval__edit2').val();
      fechaNacimientoAval2 = $('#fechaNacimiento_edit2').val();
      idNacionalidadAval2 = $('#nacionalidad_edit2').val();
      idMunicipioAval2 = $('#municipio_edit2').val();
      direccionAval2 = $('#direccionAval_edit2').val();
      celularAval2 = $('#celularAval_edit2').val();
      telefonoAval2 = $('#telefonoAval_edit2').val();
      direccionTrabajoAval2 = $('#direccionTrabajoAval_edit2').val();
      telefonoTrabajoAval2 = $('#telefonoAvalTrabajo_edit2').val();
    
      idEstadoCivilAval2 =$('#estadoCivil_edit2').val(); 
      idcategoriaCasaAval2 = $('#casa_edit2').val();
      idtiempoVivirAval2 = $('#tiempoVivir_edit2').val();
      pagaAlquilerAval2 = $('#pagaAlquiler_edit2').val();
      pagoCasaAval2 = $('#pagoCasa_aval2').val();
      idGeneroAval2 = $('#idGeneroAval_edit2').val();
      idProfesionAval2 = $('#profesiones_edit2').val(); 
      patronoAval2 = $('#patrono_edit2').val();
      actividadDesempeniaAval2 = $('#actividadDesempeña_edit2').val();
      idTiempoLaboralAval2 = $('#tiempoLaboral_edit2').val();
      idTipoClientesAval2 = $('#tipoClienteAval_edit2').val();
      
      cuentaAval2 = $('#cuentaAval_aval2').val();
      esAvalAval2 = $('#esAval_edit2').val();
      avalMoraAval2 = $('#avalMoraAval_edit2').val();
      estadoCreditoAval2 = $('#estadoCreditoAval_edit2').val();
      
      //referencias Familiares
      nombreR1Aval2 = $('#nombreR1_aval2').val();
      parestencosR1Aval2 = $('#parestencosR1aval2').val();
      celularR1Aval2 = $('#celularR1aval2').val();
      direccionR1Aval2 = $('#direccionR1aval2').val();
      nombreR2Aval2 = $('#nombreR2aval2').val();
      parestencosR2Aval2 = $('#parestencosR2aval2').val();
      celularR2Aval2 = $('#celularR2aval2').val();
      direccionR2Aval2 = $('#direccionR2aval2').val();
      //informacion adicional
      ObservacionesSolicitudAval2 = $('#observaciones_edit2').val();
      //referencias Comerciales
      nombreComercial1AVAL2 = $('#nombreComercial1AVAL2').val();
      direccionComercial1AVAL2 = $('#direccionComercial1AVAL2').val();
      nombreComercial2AVAL2 = $('#nombreComercial2AVAL2').val();
      direccionComercial2AVAL2 = $('#direccionComercial2AVAL2').val();
      //datos de la pareja
      idParejaAval2 = $('#idParejaval2').val();
      nombresParejaAval2 = $('#nombresParejaAval2').val();
      apellidosParejaAval2 = $('#apellidosParejaAval2').val();
      identidadParejaAval2 = $('#identidadParejaAval2').val();
      fechaNacimientoParejaAval2 = $('#fechaNacimientoParejaAval2').val();
      municipioParejaAval2 = $('#municipioParejaAval2').val(); 
      generoParejaAval2 = $('#generoParejaAval2').val();  
      actividadParejaAval2 = $('#actividadParejaAval2').val();
      tiempoLaboralParejaAval2 = $('#tiempoLaboralParejaAval2').val();
      profesionParejaAval2 = $('#profesionParejaAval2').val();
      patronoParejaAval2 = $('#patronoParejaAval2').val();
      tipoClienteParejaAval2 = $('#tipoClienteParejaAval2').val();
      direccionParejaAval2 = $('#direccionParejaAval2').val();
      celularParejaAval2 = $('#celularParejaAval2').val();
      telefonoParejaAval2 = $('#telefonoParejaAval2').val();
      direccionTrabajoParejaAval2 = $('#direccionTrabajoParejaAval2').val();
      telefonoParejaTrabajoAval2 = $('#telefonoParejaTrabajoAval2').val();
      ingresoNegocioParejaAval2 = $('#ingresoNegocioParejaAval2').val();
      sueldoBaseParejaAval2 = $('#sueldoBaseParejaAval2').val();
      gastoAlimentacionParejaAval2 = $('#gastoAlimentacionParejaAval2').val();
      cuotaParejaAval2 = $('#cuotaParejaAval2').val();
      cuentaParejaAval2 = $('#cuentaParejaAval2').val();
      esAvalParejaAVAL2 = $('#esAvalParejaAVAL2').val();
      avalMoraParejaAVAL2 = $('#avalMoraParejaAVAL2').val();
      estadoCreditoParejaAVAL2 = $('#estadoCreditoParejaAVAL2').val();
    
      //analisis crediticio
      sueldoBase_analisisAval2 = $('#sueldoBase_analisisAval2').val();
      ingresosNegocioAval2 = $('#ingresosNegocioAval2').val();
      rentaAval2 = $('#rentaAval2').val();
      remesasAval2 = $('#remesasAval2').val();
      aporteConyugeAval2 = $('#aporteConyugeAval2').val();
      sociedadAval2 = $('#sociedadAval2').val();
    
      cuotaAdepesAval2 = $('#cuotaAdepesAval2').val();
      viviendaAval2= $('#viviendaAval2').val();
      alimentacionAval2= $('#alimentacionAval2').val();
      centralRiesgoAval2 = $('#centralRiesgoAval2').val();
      otrosEgresosAval2 = $('#otrosEgresosAval2').val();
      capitalDisponibleAval2 = $('#capitalDisponibleAval2').val();
      evaluacionAval2 = $('#evaluacionAval2').val();
      
  if(idPersonaAval2 !== ""){
  
  
      if(nombreAval2 === ""){
          toastr.warning('¡Debes ingresar el nombre del aval 2!');
          return
      }
      if(apellidoAval2 === ""){
          toastr.warning('¡Debes ingresar el apellido del aval 2!');
          return
      }
      if(identidadAval2 === ""){
          toastr.warning('¡Debes ingresar la identidad del aval 2');
          return
      }
      if(identidadAval2 === "0000-0000-00000" || identidadAval2 === "1111-1111-11111" || identidadAval2.length<15){
          toastr.warning('Número de indentidad incorrecto del aval 2');
          return
      }
      if(fechaNacimientoAval2 === ""){
          toastr.warning('¡Debes ingresar la fecha de nacimiento del aval 2');
          return
      }
     
      if(direccionAval2 === ""){
          toastr.warning('Debe ingresar la dirección del aval 2');
          return
      }
      if(telefonoAval2 !== "" && telefonoAval2.length <9 || telefonoAval2=="0000-0000" ){
          toastr.warning('Teléfono del aval 2 incorrecto');
          return
      }
     
      if(celularAval2 === ""){
          toastr.warning('Debe ingresar el número de celular del aval 2');
          return
      }
      if(celularAval2.length <9 || celularAval2=="0000-0000" || celularAval2=="1111-1111" ){
          toastr.warning('Celular del aval 2 incorrecto');
          return
      }
    
      if(pagaAlquilerAval2 > 1 && pagoCasaAval2==="" ){
          toastr.warning('Debe ingresar el pago del alquiler del aval 2');
          return
      }
      
     
      if(actividadDesempeniaAval2 === ""){
          toastr.warning('Debe ingresar la actividad que desempeña el aval 2');
          return
      }
    
      if(telefonoTrabajoAval2 !== "" && telefonoTrabajoAval2.length <9 || telefonoTrabajoAval2=="0000-0000" || telefonoTrabajoAval2=="1111-1111"){
          toastr.warning('Teléfono del trabajo del aval 2 incorrecto');
          return
      }
      
    
      if(celularR1Aval2 !== "" && celularR1Aval2.length <9 || celularR1Aval2=="0000-0000" || celularR1Aval2=="1111-1111"){
          toastr.warning('Celular de referencia 1 de aval 2 incorrecto');
          return
      }
      if(celularR2Aval2 !== "" && celularR2Aval2.length <9 || celularR2Aval2=="0000-0000" || celularR2Aval2=="1111-1111" ){
          toastr.warning('Celular de referencia 2 de aval 2 incorrecto');
          return
      }
    
  
    
     parametros = {
     //SOLICITANTE
     "idPersonaAval2":idPersonaAval2,
     "nombreAval2":nombreAval2, "apellidoAval2":apellidoAval2, "identidadAval2":identidadAval2, "fechaNacimientoAval2":fechaNacimientoAval2,
     "idNacionalidadAval2":idNacionalidadAval2, "idMunicipioAval2":idMunicipioAval2, "direccionAval2":direccionAval2, "celularAval2":celularAval2, "telefonoAval2":telefonoAval2,
     "direccionTrabajoAval2":direccionTrabajoAval2, "telefonoTrabajoAval2":telefonoTrabajoAval2, "idEstadoCivilAval2":idEstadoCivilAval2, "idcategoriaCasaAval2":idcategoriaCasaAval2,
     "idtiempoVivirAval2":idtiempoVivirAval2, "pagaAlquilerAval2":pagaAlquilerAval2, "pagoCasaAval2":pagoCasaAval2, "idGeneroAval2":idGeneroAval2,  "idProfesionAval2":idProfesionAval2,
     "patronoAval2":patronoAval2, "actividadDesempeniaAval2":actividadDesempeniaAval2, "idTiempoLaboralAval2":idTiempoLaboralAval2, "idTipoClientesAval2":idTipoClientesAval2, "cuentaAval2":cuentaAval2,
     "esAvalAval2":esAvalAval2, "avalMoraAval2":avalMoraAval2, "estadoCreditoAval2":estadoCreditoAval2, 
     
      //referencias
      "nombreR1Aval2":nombreR1Aval2, "parestencosR1Aval2":parestencosR1Aval2, "celularR1Aval2":celularR1Aval2, "direccionR1Aval2":direccionR1Aval2, "nombreR2Aval2":nombreR2Aval2, 
      "parestencosR2Aval2":parestencosR2Aval2, "celularR2Aval2":celularR2Aval2, "direccionR2Aval2":direccionR2Aval2, "ObservacionesSolicitudAval2":ObservacionesSolicitudAval2,
      //referencias Comerciales
      "nombreComercial1AVAL2":nombreComercial1AVAL2, "direccionComercial1AVAL2":direccionComercial1AVAL2, "nombreComercial2AVAL2":nombreComercial2AVAL2, "direccionComercial2AVAL2":direccionComercial2AVAL2,
      
       //analisis crediticio
       "sueldoBase_analisisAval2":sueldoBase_analisisAval2, "ingresosNegocioAval2":ingresosNegocioAval2, "rentaAval2":rentaAval2, "remesasAval2":remesasAval2, "aporteConyugeAval2":aporteConyugeAval2, "sociedadAval2":sociedadAval2,
       "cuotaAdepesAval2":cuotaAdepesAval2, "viviendaAval2":viviendaAval2, "alimentacionAval2":alimentacionAval2, "centralRiesgoAval2":centralRiesgoAval2, "otrosEgresosAval2":otrosEgresosAval2,
       "capitalDisponibleAval2":capitalDisponibleAval2, "evaluacionAval2":evaluacionAval2,
  
       //Datos pareja
       "idParejaAval2":idParejaAval2, "nombresParejaAval2":nombresParejaAval2, "apellidosParejaAval2":apellidosParejaAval2, "identidadParejaAval2":identidadParejaAval2, "fechaNacimientoParejaAval2":fechaNacimientoParejaAval2, "municipioParejaAval2":municipioParejaAval2,
       "generoParejaAval2":generoParejaAval2, "actividadParejaAval2":actividadParejaAval2, "tiempoLaboralParejaAval2":tiempoLaboralParejaAval2, "profesionParejaAval2":profesionParejaAval2, "patronoParejaAval2":patronoParejaAval2,
       "tipoClienteParejaAval2":tipoClienteParejaAval2, "direccionParejaAval2":direccionParejaAval2, "celularParejaAval2":celularParejaAval2, "telefonoParejaAval2":telefonoParejaAval2, "direccionTrabajoParejaAval2":direccionTrabajoParejaAval2, "telefonoParejaTrabajoAval2":telefonoParejaTrabajoAval2,
       "ingresoNegocioParejaAval2":ingresoNegocioParejaAval2, "sueldoBaseParejaAval2":sueldoBaseParejaAval2, "gastoAlimentacionParejaAval2":gastoAlimentacionParejaAval2, "cuotaParejaAval2":cuotaParejaAval2, "cuentaParejaAval2":cuentaParejaAval2, "esAvalParejaAVAL2":esAvalParejaAVAL2,
       "avalMoraParejaAVAL2":avalMoraParejaAVAL2, "estadoCreditoParejaAVAL2":estadoCreditoParejaAVAL2
       
     }
    
      $.ajax({
          data:parametros,
          url:'../controller/EditarSolicitudController.php?operador=Actualizar_aval2', //url del controlador RolConttroller
          type:'POST',
          beforeSend:function(){},
          success:function(response){
              //console.log(response);
              if(response == "success"){  //si inserto correctamente
                  ActualizarAval3();
  
              }else if(response == "nombrePareja"){
                toastr.warning('Ingrese el nombre de la pareja del aval 2');
              }else if(response == "apellidoPareja"){
                toastr.warning('Ingrese el apellido de la pareja del aval 2');
              }else if(response == "identidadPareja"){
                toastr.warning('Ingrese la identidad de la pareja del aval 2');
              }else if(response == "identidadIncorrecta"){
                toastr.warning('Identidad de la pareja del aval 2 incorrecta');
              }else{
                  Swal.fire({
                      icon: 'error',
                      title: 'error',
                      text: 'No se han podido alctualizar correctamente los datos',
                    })
              }
          }
      })
  }else{
      ActualizarAval3(); 
  } //fin del if de si existe aval
  
  }
  
  
  function ActualizarAval3(){
      //datos del aval
      idPersonaAval3 = $('#idPersonaAval3').val(); 
      nombreAval3 = $('#nombresAval_edit3').val();
      apellidoAval3 = $('#apellidosAval_edit3').val();
      identidadAval3 = $('#identidadAval_edit3').val();
      fechaNacimientoAval3 = $('#fechaNacimiento_edit3').val();
      idNacionalidadAval3 = $('#nacionalidad_edit3').val();
      idMunicipioAval3 = $('#municipio_edit3').val();
      direccionAval3 = $('#direccionAval_edit3').val();
      celularAval3 = $('#celularAval_edit3').val();
      telefonoAval3 = $('#telefonoAval_edit3').val();
      direccionTrabajoAval3 = $('#direccionTrabajoAval_edit3').val();
      telefonoTrabajoAval3 = $('#telefonoAvalTrabajo_edit3').val();
    
      idEstadoCivilAval3 =$('#estadoCivil_edit3').val(); 
      idcategoriaCasaAval3 = $('#casa_edit3').val();
      idtiempoVivirAval3 = $('#tiempoVivir_edit3').val();
      pagaAlquilerAval3 = $('#pagaAlquiler_edit3').val();
      pagoCasaAval3 = $('#pagoCasa_aval3').val();
      idGeneroAval3 = $('#idGeneroAval_edit3').val();
      idProfesionAval3 = $('#profesiones_edit3').val(); 
      patronoAval3 = $('#patrono_edit3').val();
      actividadDesempeniaAval3 = $('#actividadDesempeña_edit3').val();
      idTiempoLaboralAval3 = $('#tiempoLaboral_edit3').val();
      idTipoClientesAval3 = $('#tipoClienteAval_edit3').val();
      
      cuentaAval3 = $('#cuentaAval_aval3').val();
      esAvalAval3 = $('#esAval_edit3').val();
      avalMoraAval3 = $('#avalMoraAval_edit3').val();
      estadoCreditoAval3 = $('#estadoCreditoAval_edit3').val();
      
      //referencias Familiares
      nombreR1Aval3 = $('#nombreR1_aval3').val();
      parestencosR1Aval3 = $('#parestencosR1aval3').val();
      celularR1Aval3 = $('#celularR1aval3').val();
      direccionR1Aval3 = $('#direccionR1aval3').val();
      nombreR2Aval3 = $('#nombreR2aval3').val();
      parestencosR2Aval3 = $('#parestencosR2aval3').val();
      celularR2Aval3 = $('#celularR2aval3').val();
      direccionR2Aval3 = $('#direccionR2aval3').val();
      //informacion adicional
      ObservacionesSolicitudAval3 = $('#observaciones_edit3').val();
      //referencias Comerciales
      nombreComercial1AVAL3 = $('#nombreComercial1AVAL3').val();
      direccionComercial1AVAL3 = $('#direccionComercial1AVAL3').val();
      nombreComercial2AVAL3 = $('#nombreComercial2AVAL3').val();
      direccionComercial2AVAL3 = $('#direccionComercial2AVAL3').val();
      //datos de la pareja
      idParejaAval3 = $('#idParejaval3').val();
      nombresParejaAval3 = $('#nombresParejaAval3').val();
      apellidosParejaAval3 = $('#apellidosParejaAval3').val();
      identidadParejaAval3 = $('#identidadParejaAval3').val();
      fechaNacimientoParejaAval3 = $('#fechaNacimientoParejaAval3').val();
      municipioParejaAval3 = $('#municipioParejaAval3').val(); 
      generoParejaAval3 = $('#generoParejaAval3').val();  
      actividadParejaAval3 = $('#actividadParejaAval3').val();
      tiempoLaboralParejaAval3 = $('#tiempoLaboralParejaAval3').val();
      profesionParejaAval3 = $('#profesionParejaAval3').val();
      patronoParejaAval3 = $('#patronoParejaAval3').val();
      tipoClienteParejaAval3 = $('#tipoClienteParejaAval3').val();
      direccionParejaAval3 = $('#direccionParejaAval3').val();
      celularParejaAval3 = $('#celularParejaAval3').val();
      telefonoParejaAval3 = $('#telefonoParejaAval3').val();
      direccionTrabajoParejaAval3 = $('#direccionTrabajoParejaAval3').val();
      telefonoParejaTrabajoAval3 = $('#telefonoParejaTrabajoAval3').val();
      ingresoNegocioParejaAval3 = $('#ingresoNegocioParejaAval3').val();
      sueldoBaseParejaAval3 = $('#sueldoBaseParejaAval3').val();
      gastoAlimentacionParejaAval3 = $('#gastoAlimentacionParejaAval3').val();
      cuotaParejaAval3 = $('#cuotaParejaAval3').val();
      cuentaParejaAval3 = $('#cuentaParejaAval3').val();
      esAvalParejaAVAL3 = $('#esAvalParejaAVAL3').val();
      avalMoraParejaAVAL3 = $('#avalMoraParejaAVAL3').val();
      estadoCreditoParejaAVAL3 = $('#estadoCreditoParejaAVAL3').val();
    
      //analisis crediticio
      sueldoBase_analisisAval3 = $('#sueldoBase_analisisAval3').val();
      ingresosNegocioAval3 = $('#ingresosNegocioAval3').val();
      rentaAval3 = $('#rentaAval3').val();
      remesasAval3 = $('#remesasAval3').val();
      aporteConyugeAval3 = $('#aporteConyugeAval3').val();
      sociedadAval3 = $('#sociedadAval3').val();
    
      cuotaAdepesAval3 = $('#cuotaAdepesAval3').val();
      viviendaAval3 = $('#viviendaAval3').val();
      alimentacionAval3 = $('#alimentacionAval3').val();
      centralRiesgoAval3 = $('#centralRiesgoAval3').val();
      otrosEgresosAval3 = $('#otrosEgresosAval3').val();
      capitalDisponibleAval3 = $('#capitalDisponibleAval3').val();
      evaluacionAval3 = $('#evaluacionAval3').val();
      
  if(idPersonaAval3 !== ""){
  
  
      if(nombreAval3 === ""){
          toastr.warning('¡Debes ingresar el nombre del aval 3!');
          return
      }
      if(apellidoAval3 === ""){
          toastr.warning('¡Debes ingresar el apellido del aval 3!');
          return
      }
      if(identidadAval3 === ""){
          toastr.warning('¡Debes ingresar la identidad del aval 3');
          return
      }
      if(identidadAval3 === "0000-0000-00000" || identidadAval3 === "1111-1111-11111" || identidadAval3.length<15){
          toastr.warning('Número de indentidad incorrecto del aval 3');
          return
      }
      if(fechaNacimientoAval3 === ""){
          toastr.warning('¡Debes ingresar la fecha de nacimiento del aval 3');
          return
      }
     
      if(direccionAval3 === ""){
          toastr.warning('Debe ingresar la dirección del aval 3');
          return
      }
      if(telefonoAval3 !== "" && telefonoAval3.length <9 || telefonoAval3=="0000-0000" ){
          toastr.warning('Teléfono del aval 3 incorrecto');
          return
      }
     
      if(celularAval3 === ""){
          toastr.warning('Debe ingresar el número de celular del aval 3');
          return
      }
      if(celularAval3.length <9 || celularAval3=="0000-0000" || celularAval3=="1111-1111" ){
          toastr.warning('Celular del aval 3 incorrecto');
          return
      }
    
      if(pagaAlquilerAval3 > 1 && pagoCasaAval3==="" ){
          toastr.warning('Debe ingresar el pago del alquiler del aval 3');
          return
      }
      
     
      if(actividadDesempeniaAval3 === ""){
          toastr.warning('Debe ingresar la actividad que desempeña el aval 3');
          return
      }
    
      if(telefonoTrabajoAval3 !== "" && telefonoTrabajoAval3.length <9 || telefonoTrabajoAval3=="0000-0000" || telefonoTrabajoAval3=="1111-1111"){
          toastr.warning('Teléfono del trabajo del aval 3 incorrecto');
          return
      }
      
    
      if(celularR1Aval3 !== "" && celularR1Aval3.length <9 || celularR1Aval3=="0000-0000" || celularR1Aval3=="1111-1111"){
          toastr.warning('Celular de referencia 1 de aval 3 incorrecto');
          return
      }
      if(celularR2Aval3 !== "" && celularR2Aval3.length <9 || celularR2Aval3=="0000-0000" || celularR2Aval3=="1111-1111" ){
          toastr.warning('Celular de referencia 2 de aval 3 incorrecto');
          return
      }
    
  
    
     parametros = {
     //SOLICITANTE
     "idPersonaAval3":idPersonaAval3,
     "nombreAval3":nombreAval3, "apellidoAval3":apellidoAval3, "identidadAval3":identidadAval3, "fechaNacimientoAval3":fechaNacimientoAval3,
     "idNacionalidadAval3":idNacionalidadAval3, "idMunicipioAval3":idMunicipioAval3, "direccionAval3":direccionAval3, "celularAval3":celularAval3, "telefonoAval3":telefonoAval3,
     "direccionTrabajoAval3":direccionTrabajoAval3, "telefonoTrabajoAval3":telefonoTrabajoAval3, "idEstadoCivilAval3":idEstadoCivilAval3, "idcategoriaCasaAval3":idcategoriaCasaAval3,
     "idtiempoVivirAval3":idtiempoVivirAval3, "pagaAlquilerAval3":pagaAlquilerAval3, "pagoCasaAval3":pagoCasaAval3, "idGeneroAval3":idGeneroAval3,  "idProfesionAval3":idProfesionAval3,
     "patronoAval3":patronoAval3, "actividadDesempeniaAval3":actividadDesempeniaAval3, "idTiempoLaboralAval3":idTiempoLaboralAval3, "idTipoClientesAval3":idTipoClientesAval3, "cuentaAval3":cuentaAval3,
     "esAvalAval3":esAvalAval3, "avalMoraAval3":avalMoraAval3, "estadoCreditoAval3":estadoCreditoAval3,
     
      //referencias
      "nombreR1Aval3":nombreR1Aval3, "parestencosR1Aval3":parestencosR1Aval3, "celularR1Aval3":celularR1Aval3, "direccionR1Aval3":direccionR1Aval3, "nombreR2Aval3":nombreR2Aval3, 
      "parestencosR2Aval3":parestencosR2Aval3, "celularR2Aval3":celularR2Aval3, "direccionR2Aval3":direccionR2Aval3, "ObservacionesSolicitudAval3":ObservacionesSolicitudAval3,
      //referencias Comerciales
      "nombreComercial1AVAL3":nombreComercial1AVAL3, "direccionComercial1AVAL3":direccionComercial1AVAL3, "nombreComercial2AVAL3":nombreComercial2AVAL3, "direccionComercial2AVAL3":direccionComercial2AVAL3,
      
       //analisis crediticio
       "sueldoBase_analisisAval3":sueldoBase_analisisAval3, "ingresosNegocioAval3":ingresosNegocioAval3, "rentaAval3":rentaAval3, "remesasAval3":remesasAval3, "aporteConyugeAval3":aporteConyugeAval3, "sociedadAval3":sociedadAval3,
       "cuotaAdepesAval3":cuotaAdepesAval3, "viviendaAval3":viviendaAval3, "alimentacionAval3":alimentacionAval3, "centralRiesgoAval3":centralRiesgoAval3, "otrosEgresosAval3":otrosEgresosAval3,
       "capitalDisponibleAval3":capitalDisponibleAval3, "evaluacionAval3":evaluacionAval3,
  
       //Datos pareja
       "idParejaAval3":idParejaAval3, "nombresParejaAval3":nombresParejaAval3, "apellidosParejaAval3":apellidosParejaAval3, "identidadParejaAval3":identidadParejaAval3, "fechaNacimientoParejaAval3":fechaNacimientoParejaAval3, "municipioParejaAval3":municipioParejaAval3,
       "generoParejaAval3":generoParejaAval3, "actividadParejaAval3":actividadParejaAval3, "tiempoLaboralParejaAval3":tiempoLaboralParejaAval3, "profesionParejaAval3":profesionParejaAval3, "patronoParejaAval3":patronoParejaAval3,
       "tipoClienteParejaAval3":tipoClienteParejaAval3, "direccionParejaAval3":direccionParejaAval3, "celularParejaAval3":celularParejaAval3, "telefonoParejaAval3":telefonoParejaAval3, "direccionTrabajoParejaAval3":direccionTrabajoParejaAval3, "telefonoParejaTrabajoAval3":telefonoParejaTrabajoAval3,
       "ingresoNegocioParejaAval3":ingresoNegocioParejaAval3, "sueldoBaseParejaAval3":sueldoBaseParejaAval3, "gastoAlimentacionParejaAval3":gastoAlimentacionParejaAval3, "cuotaParejaAval3":cuotaParejaAval3, "cuentaParejaAval3":cuentaParejaAval3, "esAvalParejaAVAL3":esAvalParejaAVAL3,
       "avalMoraParejaAVAL3":avalMoraParejaAVAL3, "estadoCreditoParejaAVAL3":estadoCreditoParejaAVAL3
       
     }
    
      $.ajax({
          data:parametros,
          url:'../controller/EditarSolicitudController.php?operador=Actualizar_aval3', //url del controlador RolConttroller
          type:'POST',
          beforeSend:function(){},
          success:function(response){
              //console.log(response);
              if(response == "success"){  //si inserto correctamente
                  swal.fire({ 
                      icon: "success",
                      title: "Actualización exitosa",
                      text: "Datos actualizados correctamente"
                      
                  }).then(function() {
                      window.location = "../pages/solicitudes.php";
                  });
  
              }else if(response == "nombrePareja"){
                toastr.warning('Ingrese el nombre de la pareja del aval 3');
              }else if(response == "apellidoPareja"){
                toastr.warning('Ingrese el apellido de la pareja del aval 3');
              }else if(response == "identidadPareja"){
                toastr.warning('Ingrese la identidad de la pareja del aval 3');
              }else if(response == "identidadIncorrecta"){
                toastr.warning('Identidad de la pareja del aval 3 incorrecta');
              }else{
                  Swal.fire({
                      icon: 'error',
                      title: 'error',
                      text: 'No se han podido alctualizar correctamente los datos',
                    })
              }
          }
      })
  }else{
      swal.fire({ 
          icon: "success",
          title: "Actualización exitosa",
          text: "Datos actualizados correctamente"
          
      }).then(function() {
          window.location = "../pages/solicitudes.php";
      });  
  } //fin del if de si existe aval
  
  }
  

  //funcion para generar reporte de central de riesgo
function CentrarRiesgoGenerarPDF() {
    var idSolicitante = $('#idSolicitante_edit').val();
    var nombreCliente = $('#nombreClienteCentral').val();
    var identidadCliente = $('#identidadClienteCetral').val();
    var estadoCivilCliente = $('#estadoCivilClienteCentral').val();
    var direccionCliente = $('#direccionClienteCentral').val();
    var nombreAval1 = $('#nombreAval1Central').val();
    var identidadAval1 = $('#identidadAval1Central').val();
    var nombreAval2 = $('#nombreAval2Central').val();
    var identidadAval2 = $('#identidadAval2Central').val();
    var nombreAval3 = $('#nombreAval3Central').val();
    var identidadAval3 = $('#identidadAval3Central').val();
// Verifica campos requeridos
if (!idSolicitante || !nombreCliente || !identidadCliente || !estadoCivilCliente || !direccionCliente) {
    alert('Por favor, complete todos los campos requeridos.');
    return;
}
// Codifica todos los parámetros antes de agregarlos a la URL
idSolicitante = encodeURIComponent(idSolicitante);
nombreCliente = encodeURIComponent(nombreCliente);
identidadCliente = encodeURIComponent(identidadCliente);
estadoCivilCliente = encodeURIComponent(estadoCivilCliente);
direccionCliente = encodeURIComponent(direccionCliente);
nombreAval1 = encodeURIComponent(nombreAval1);
identidadAval1 = encodeURIComponent(identidadAval1);
nombreAval2 = encodeURIComponent(nombreAval2);
identidadAval2 = encodeURIComponent(identidadAval2);
nombreAval3 = encodeURIComponent(nombreAval3);
identidadAval3 = encodeURIComponent(identidadAval3);
    // Construye la URL con todas las variables
    var url = '../pages/fpdf/CentralRiesgo.php?' +
        'idSolicitante=' + idSolicitante +
        '&nombreCliente=' + nombreCliente +
        '&identidadCliente=' + identidadCliente +
        '&estadoCivilCliente=' + estadoCivilCliente +
        '&direccionCliente=' + direccionCliente +
        '&nombreAval1=' + nombreAval1 +
        '&identidadAval1=' + identidadAval1 +
        '&nombreAval2=' + nombreAval2 +
        '&identidadAval2=' + identidadAval2 +
        '&nombreAval3=' + nombreAval3 +
        '&identidadAval3=' + identidadAval3;

    // Redirige el navegador a la URL construida
    window.location.href = url;
}


//funcion para generar reporte de Formato conozca a su cliente
function FormatoConozcaClientePDF() {
    // var idSolicitante = $('#idSolicitante_edit').val();
     var nombreCliente = $('#nombreFormato').val();
     var identidadCliente = $('#identidadFormato').val();
     var estadoCivilCliente = $('#estadoCivilFormato').val();
     var municipioFormato = $('#municipioFormato').val();
     var direccionCliente = $('#DireccionCasaFormato').val();
     var FechaEmisionFormato = $('#FechaEmisionFormato').val();
     var fechaNacimientoFormato = $('#fechaNacimientoFormato').val();
     var NacionalidadFormato = $('#NacionalidadFormato').val();
     var GeneroFormato = $('#GeneroFormato').val();
     var ProfesionFormato = $('#ProfesionFormato').val();
     var CelularFormato = $('#CelularFormato').val();
     var telefonoFormato = $('#telefonoFormato').val();
     var NombreConyugueFormato = $('#NombreConyugueFormato').val();
     var PatronoFormato = $('#PatronoFormato').val();
     var DependienteFormato = $('#DependienteFormato').val();
     var DireccionTrabajoFormato = $('#DireccionTrabajoFormato').val();
     var TelefonoTrabajoFormato = $('#TelefonoTrabajoFormato').val();
     var BienesFormato = $('#BienesFormato').val();
     var ActividadDesempenaFormato = $('#ActividadDesempenaFormato').val();
     var TotalIngresosFormato = $('#TotalIngresosFormato').val();
 // Obtener el elemento select
 var selectElement = document.getElementById("tiempoLaboral_edit");
 // Obtener el índice de la opción seleccionada
 var selectedIndex = selectElement.selectedIndex
 // Obtener el texto de la opción seleccionada
 var tiempoLaboral = selectElement.options[selectedIndex].text;
     // Construye la URL con todas las variables
     var url = '../pages/fpdf/FormatoConozcaCliente.php?' +
         'nombreCliente=' + nombreCliente +
         '&identidadCliente=' + identidadCliente +
         '&estadoCivilCliente=' + estadoCivilCliente +
         '&municipioFormato=' + municipioFormato +
         '&direccionCliente=' + direccionCliente +
         '&FechaEmisionFormato=' + FechaEmisionFormato +
         '&fechaNacimientoFormato=' + fechaNacimientoFormato +
         '&NacionalidadFormato=' + NacionalidadFormato +
         '&GeneroFormato=' + GeneroFormato +
         '&ProfesionFormato=' + ProfesionFormato +
         '&CelularFormato=' + CelularFormato +
         '&telefonoFormato=' + telefonoFormato +
         '&NombreConyugueFormato=' + NombreConyugueFormato +
         '&PatronoFormato=' + PatronoFormato +
         '&DependienteFormato=' + DependienteFormato +
         '&DireccionTrabajoFormato=' + DireccionTrabajoFormato +
         '&TelefonoTrabajoFormato=' + TelefonoTrabajoFormato +
         '&BienesFormato=' + BienesFormato +
         '&ActividadDesempenaFormato=' + ActividadDesempenaFormato +
         '&tiempoLaboral=' + tiempoLaboral +
         '&TotalIngresosFormato=' + TotalIngresosFormato;
 
     // Redirige el navegador a la URL construida
     window.location.href = url;
 }
  
  
//funcion para generar el reporte de comite de credito
function comiteCreeditoGenerarPDF(){
    var idSoli = $('#idSolicitud_edit').val();
    var numeroActa = $('#numeroActaedit').val();
    if(numeroActa == ""){
        toastr.warning('Para imprimir la resolución, la solicitud debe ser aprobada o desaprobada por el comité de crédito');
        return;
    }
    // Envía el idSoli al script PHP que genera el PDF
      window.location.href = '../pages/fpdf/ComiteCredito.php?idSoli=' + idSoli;
}

  //validaciones de formato de telefonos y celulares
  // JavaScript
  function formatoTelefono(inputElement) {
      const valorIngresado = inputElement.value.replace(/\D/g, ''); // Eliminar caracteres que no sean números
      const grupos = valorIngresado.match(/(\d{0,4})/g);
      if (grupos) {
          const valorFormateado = grupos.filter(Boolean).join('-');
          inputElement.value = valorFormateado;
      }
  }
  