
/***********************************CRUD ********************************************* */
//Boton primer paso
function nextStep(currentStepId, nextStepId) {
    
    document.getElementById(currentStepId).classList.remove('active');
    document.getElementById(nextStepId).classList.add('active');
    //prestamo
    monto = $('#monto').val();
    plazo = $('#plazo').val();
    //DE la solicitud pasaran al analisi crediticio
    pagoCasa = $('#pagoCasa').val();
    ingresosPorNegocio = $('#ingresosPorNegocio').val();
    sueldoBase = $('#sueldoBase').val();
    gastosAlimentacion = $('#gastosAlimentacion').val();
    cuota = $('#cuota').val();
    
    //input del analisis crediticio
    $('#vivienda').val(pagoCasa); 
    $('#ingresosNegocio').val(ingresosPorNegocio); 
    $('#sueldoBase_analisis').val(sueldoBase); 
    $('#alimentacion').val(gastosAlimentacion); 
    $('#cuotaAdepes').val(cuota); 
    //datos del prestamo
    idTipoPrestamo = $('#tipogarantia').val();
    
    tipoPersona= $('#analisis').val();
    if(tipoPersona == "1"){
        sumarIngresosEgresos(); //funcion del Analisis crediticio para los calculos
    }else{
        sumarIngresosEgresosAval();//funcion del Analisis crediticio PARA AVAL
    }
    
    
    ObtenerDatosPrestamo(idTipoPrestamo, monto, plazo);
}

  function prevStep(currentStepId, prevStepId) {
    document.getElementById(currentStepId).classList.remove('active');
    document.getElementById(prevStepId).classList.add('active');
  }



function RegistrarCliente(){
    //datos del cliente
    idTipoPrestamo = $('#tipogarantia').val(); 
    monto = $('#monto').val(); 
    plazo = $('#plazo').val(); 
    rubro = $('#rubro').val(); 
    fechaEmision = $('#fechaEmision').val(); 
    idEstadoCivil =$('#estadoCivil').val();
    idGenero = $('#idGeneroCliente').val();  
    idcategoriaCasa = $('#casa').val();
    idtiempoVivir = $('#tiempoVivir').val();
    pagaAlquiler = $('#pagaAlquiler').val();
    idTiempoLaboral = $('#tiempoLaboral').val();
    actividadDesempenia = $('#actividadDesempeña').val();
    patrono = $('#patrono').val();
    idProfesion = $('#profesiones').val();
    idTipoClientes = $('#tipoCliente').val();
    nombres = $('#nombresCliente').val();
    apellidos = $('#apellidosCliente').val();
    identidad = $('#identidadCliente').val();
    fechaNacimiento = $('#fechaNacimiento').val();
    idNacionalidad = $('#nacionalidad').val();
    direccionCliente = $('#direccionCliente').val();
    celularCliente = $('#celularCLiente').val();
    telefonoCliente = $('#telefonoCliente').val();
    direccionTrabajoCliente = $('#direccionTrabajoCliente').val();
    telefonoTrabajoCliente = $('#telefonoClienteTrabajo').val();
    cuentaCliente = $('#cuentaCliente').val();
    esAval = $('#esAvalCliente').val();
    avalMora = $('#avalMoraCliente').val();
    estadoCredito = $('#estadoCreditoCliente').val();
    municipioCliente = $('#municipioCliente').val();
    //referencias
    nombreR1 = $('#nombreR1').val();
    parestencosR1 = $('#parestencosR1').val();
    celularR1 = $('#celularR1').val();
    direccionR1 = $('#direccionR1').val();
    nombreR2 = $('#nombreR2').val();
    parestencosR2 = $('#parestencosR2').val();
    celularR2 = $('#celularR2').val();
    direccionR2 = $('#direccionR2').val();
    //informacion adicional
    invierteEn = $('#invierteEn').val();
    dependientes = $('#dependientes').val();
    ObservacionesSolicitud = $('#observaciones').val();
    //datos de la paraja
    nombresPareja = $('#nombresPareja').val();
    apellidosPareja = $('#apellidosPareja').val();
    identidadPareja = $('#identidadPareja').val();
    fechaNacimientoPareja = $('#fechaNacimientoPareja').val();
    idGeneroPareja = $('#generoPareja').val();  
    actividadDesempeniaPareja = $('#actividadPareja').val();
    idTiempoLaboralPareja = $('#tiempoLaboralPareja').val();
    idProfesionPareja = $('#profesionPareja').val();
    patronoPareja = $('#patronoPareja').val();
    idTipoClientesPareja = $('#tipoClientePareja').val();
    direccionPareja = $('#direccionPareja').val();
    celularPareja = $('#celularPareja').val();
    telefonoPareja = $('#telefonoPareja').val();
    direccionTrabajoPareja = $('#direccionTrabajoPareja').val();
    telefonoTrabajoPareja = $('#telefonoParejaTrabajo').val();
    ingresoNegocioPareja = $('#ingresoNegocioPareja').val();
    sueldoBasePareja = $('#sueldoBasePareja').val();
    gastoAlimentacionPareja = $('#gastoAlimentacionPareja').val();
    cuentaPareja = $('#cuentaPareja').val();
    esAvalPareja = $('#esAvalPareja').val();
    avalMoraPareja = $('#avalMoraPareja').val();
    estadoCreditoPareja = $('#estadoCreditoPareja').val();
    municipioPareja = $('#municipioPareja').val();
    //analisis crediticio
    pagoCasa = $('#pagoCasa').val();
    ingresosPorNegocio = $('#ingresosPorNegocio').val();
    sueldoBase = $('#sueldoBase').val();
    gastosAlimentacion = $('#gastosAlimentacion').val();
    //2
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
    descripcion = $('#evaluacion').val();
  
   //bienes
   bienes = $('#bienes').val();
    
    if( idTipoPrestamo ===""){
        toastr.warning('Debe seleccionar un tipo de garantía');
        return
    } 
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
    if(nombres === ""){
        toastr.warning('¡Debes ingresar el nombre del solicitante!');
        var inputElement = document.getElementById("nombresCliente");
        inputElement.focus();
        return
    }
    if(apellidos === ""){
        toastr.warning('¡Debes ingresar el apellido del solicitante!');
        var inputElement = document.getElementById("apellidosCliente");
        inputElement.focus();
        return
    }
    if(identidad === ""){
        toastr.warning('¡Debes ingresar la identidad del solicitante');
        var inputElement = document.getElementById("identidadCliente");
        inputElement.focus();
        return
    }
    if(identidad === "0000-0000-00000" || identidad.length<15){
        toastr.warning('Número de indentidad incorrecto');
        var inputElement = document.getElementById("identidadCliente");
        inputElement.focus();
        return
    }
    if(fechaNacimiento === ""){
        toastr.warning('¡Debes ingresar la fecha de nacimiento solicitante');
        return
    }
    if(identidad.substring(5,9) != fechaNacimiento.substring(0,4) ){
        toastr.warning('El año de nacimiento no coincide con la identidad del solicitante');
        return
    }
    if(direccionCliente === ""){
        toastr.warning('Debe ingresar la dirección del solicitante');
        var inputElement = document.getElementById("direccionCliente");
        inputElement.focus();
        return
    }
    if(telefonoCliente !== "" && telefonoCliente.length <9 || telefonoCliente=="0000-0000" ){
        toastr.warning('Teléfono del solicitante incorrecto');
        var inputElement = document.getElementById("telefonoCliente");
        inputElement.focus();
        return
    }
   
    if(celularCliente === ""){
        toastr.warning('Debe ingresar el número de celular del solicitante');
        var inputElement = document.getElementById("celularCLiente");
        inputElement.focus();
        return
    }
    if(celularCliente.length <9 || celularCliente=="0000-0000" ){
        toastr.warning('Celular del solicitante incorrecto');
        var inputElement = document.getElementById("celularCLiente");
        inputElement.focus();
        return
    }
    if(idEstadoCivil === ""){
        toastr.warning('Debe seleccionar el estado civil');
        var inputElement = document.getElementById("estadoCivil");
        inputElement.focus();
        return
    }
    if(idcategoriaCasa === ""){
        toastr.warning('Selecciona una categoria de casa');
        return
    }
    if(idtiempoVivir === ""){
        toastr.warning('Debe seleccionar el tiempo de vivir');
        return
    }
    if(pagaAlquiler > 1 && pagoCasa==="" ){
        toastr.warning('Debe ingresar el pago del alquiler');
        var inputElement = document.getElementById("pagoCasa");
        inputElement.focus();
        return
    }
    if(idGenero === ""){
        toastr.warning('Debe seleccionar el genero del solicitante');
        var inputElement = document.getElementById("idGeneroCliente");
        inputElement.focus();
        return
    }
    if(idProfesion === ""){
        toastr.warning('Debe seleccionar la profesión, oficio o ocupacón');;
        return
    }
   
    if(actividadDesempenia === ""){
        toastr.warning('Debe ingresar la actividad que desempeña el solicitante');
        var inputElement = document.getElementById("actividadDesempeña");
        inputElement.focus();
        return
    }
    if(idTiempoLaboral === ""){
        toastr.warning('Debe seleccionar el tiempo de laboral');;
        return
    }
    if(sueldoBase === ""){
        toastr.warning('Ingrese el suelo base del solicitante');
        var inputElement = document.getElementById("sueldoBase");
        inputElement.focus();
        return
    }
    if(telefonoTrabajoCliente !== "" && telefonoTrabajoCliente.length <9 || telefonoTrabajoCliente=="0000-0000" ){
        toastr.warning('Teléfono del trabajo del solicitante incorrecto');
        var inputElement = document.getElementById("telefonoClienteTrabajo");
        inputElement.focus();
        return
    }
    
    if(idTipoClientes === ""){
        toastr.warning('Debe seleccionar el tipo de crédito');;
        return
    }
    if(celularR1 !== "" && celularR1.length <9 || celularR1=="0000-0000" ){
        toastr.warning('Celular de referencia 1 incorrecto');
        return
    }
    if(celularR2 !== "" && celularR2.length <9 || celularR2=="0000-0000" ){
        toastr.warning('Celular de referencia 2 incorrecto');
        return
    }

    if(invierteEn === ""){
        toastr.warning('Debe ingresar el motivo de la inversión');
        var inputElement = document.getElementById("invierteEn");
        inputElement.focus();
        return
    }

    if(bienes === ""){
        toastr.warning('Debe ingresar los bienes que posee');
        var inputElement = document.getElementById("bienes");
        inputElement.focus();
        return
    }

   parametros = {
    "idNacionalidad":idNacionalidad, "idGenero":idGenero, "idEstadoCivil":idEstadoCivil, "idProfesion":idProfesion,
    "idTipoClientes":idTipoClientes, "idcategoriaCasa":idcategoriaCasa , "idtiempoVivir":idtiempoVivir, "pagaAlquiler":pagaAlquiler, "idTiempoLaboral":idTiempoLaboral,
    "nombres":nombres, "apellidos":apellidos, "identidad":identidad, "fechaNacimiento":fechaNacimiento, "actividadDesempenia":actividadDesempenia, "patrono":patrono,
    "direccionCliente":direccionCliente, "celularCliente":celularCliente, "telefonoCliente":telefonoCliente, "direccionTrabajoCliente":direccionTrabajoCliente,
    "telefonoTrabajoCliente":telefonoTrabajoCliente, "cuentaCliente":cuentaCliente, "esAval":esAval, "avalMora":avalMora, "estadoCredito":estadoCredito,
    "municipioCliente":municipioCliente,
    //referencias
    "nombreR1":nombreR1, "parestencosR1":parestencosR1, "celularR1":celularR1, "direccionR1":direccionR1, "nombreR2":nombreR2, "parestencosR2":parestencosR2,
    "celularR2":celularR2, "direccionR2":direccionR2,
     //informacion adicional
     "invierteEn":invierteEn, "dependientes":dependientes, "ObservacionesSolicitud":ObservacionesSolicitud,
     //Bienes que posee
     "bienes":bienes, 
     //pagos
     "pagoCasa":pagoCasa, "ingresosPorNegocio":ingresosPorNegocio, "sueldoBase":sueldoBase, "gastosAlimentacion":gastosAlimentacion,
    //parametros de la pareja
    "nombresPareja":nombresPareja, "apellidosPareja":apellidosPareja, "identidadPareja":identidadPareja, "fechaNacimientoPareja":fechaNacimientoPareja,
    "idGeneroPareja":idGeneroPareja, "actividadDesempeniaPareja":actividadDesempeniaPareja,
    "idTiempoLaboralPareja":idTiempoLaboralPareja, "idProfesionPareja":idProfesionPareja, "patronoPareja":patronoPareja, "idTipoClientesPareja":idTipoClientesPareja,
    "idTipoPrestamo":idTipoPrestamo, "monto":monto, "plazo":plazo, "rubro":rubro, "fechaEmision":fechaEmision, "direccionPareja":direccionPareja, "celularPareja":celularPareja,
    "telefonoPareja":telefonoPareja, "direccionTrabajoPareja":direccionTrabajoPareja, "telefonoTrabajoPareja":telefonoTrabajoPareja,
    "ingresoNegocioPareja":ingresoNegocioPareja, "sueldoBasePareja":sueldoBasePareja, "gastoAlimentacionPareja":gastoAlimentacionPareja, "cuentaPareja":cuentaPareja,
    "esAvalPareja":esAvalPareja, "avalMoraPareja":avalMoraPareja, "estadoCreditoPareja":estadoCreditoPareja,"municipioPareja":municipioPareja,
   
    //analisis crediticio
    "sueldoBase":sueldoBase, "ingresosNegocio":ingresosNegocio, "RentaPropiedad":RentaPropiedad, "remesas":remesas, "aporteConyuge":aporteConyuge,
    "IngresosSociedad":IngresosSociedad, "cuotaPrestamoAdepes":cuotaPrestamoAdepes, "cuotaVivienda":cuotaVivienda, "alimentacion":alimentacion,
    "deduccionesCentral":deduccionesCentral, "otrosEgresos":otrosEgresos, "liquidezCliente":liquidezCliente, "descripcion":descripcion
    
   }

    $.ajax({
        data:parametros,
        url:'../controller/SolicitudNuevaController.php?operador=registrar_cliente', //url del controlador RolConttroller
        type:'POST',
        beforeSend:function(){},
        success:function(response){
            //console.log(response);
            if(response == "success"){  //si inserto correctamente
                swal.fire({
                    icon: "success",
                    title: "Registro exitoso",
                    text: "Datos personales del solicitante registrados"
                    
                }).then(function() {
                    window.location = "../pages/solicitudes.php";
                });
                //limpiarInputsCliente();
                  
            }else if(response == "requerid"){
                 toastr.warning('¡Debes ingresar el nombre del cliente!', 'Nombres');

            }else if(response == "montoMayor"){
                toastr.warning('El monto ingresado excede el máximo permitido para el tipo de garantía seleccionado');

            }else if(response == "montoMinimo"){
                toastr.warning('Para el tipo de garantia seleccionada el monto debe ser mayor');

            }else if(response == "plazoMaximo"){
                toastr.warning('El plazo a excedido lo permitido para el tipo de garantía seleccionado');

            }else if(response == "fechaAntigua"){
                toastr.warning('La fecha de emisión no debe ser antigua');

            }else if(response == "registrarPareja"){
                swal.fire({
                    icon: "success",
                    title: "Registro exitoso",
                    text: "Datos personales del solicitante registrados"
                    
                }).then(function() {
                    window.location = "../pages/solicitudes.php";
                });
                //  limpiarInputsCliente();
                //  limpiarInputsPareja();

            }else if(response == "genero"){
                toastr.warning('Debe seleccionar el genero del compañero (a)');

            }else if(response == "telefonoIncorrecto"){    
                toastr.warning('Teléfono incorrecto del compañero (a)');

            }else if(response == "celularIncorrecto"){    
                toastr.warning('Celular incorrecto del compañero (a)');

            }else if(response == "telefonoTrabajoIncorrecto"){    
                toastr.warning('Teléfono de trabajo incorrecto del compañero (a)');

            }else if(response == "profesion"){
                toastr.warning('Debe seleccionar la profesión, oficio o ocupación del compañero (a)');
                
            }else if(response == "tipoCliente"){
                toastr.warning('Debe seleccionar el tipo de cliente del compañero (a)');
            }else if(response == "tiempoLaboral"){
                toastr.warning('Debe seleccionar el tiempo laboral del compañero (a)');
            }else if(response == "nombrePareja"){
                toastr.warning('Debe ingresar el nombre del compañero (a)');
                 var inputElement = document.getElementById("nombresPareja");
                inputElement.focus(); 
            }else if(response == "apellidoPareja"){
                toastr.warning('Debe ingresar los apellidos del compañero (a)');
                 var inputElement = document.getElementById("apellidosPareja");
                inputElement.focus(); 
            }else if(response == "identidadPareja"){
                toastr.warning('Debe ingresar la identidad del compañero (a)');
                 var inputElement = document.getElementById("identidadPareja");
                inputElement.focus(); 
            }else if(response == "identidadIncorrecta"){
                toastr.warning('Número de indentidad incorrecto del compañero (a)');
                 var inputElement = document.getElementById("identidadPareja");
                inputElement.focus(); 
            }else if(response == "fechaNacimientoP"){ 
                toastr.warning('Debe ingresar la fecha de nacimiento del compañero (a)');
                 var inputElement = document.getElementById("fechaNacimientoPareja");
                inputElement.focus();
            }else if(response =="fechaIdentidadCorrecta"){
                toastr.warning('El año de nacimiento no coincide con la identidad del compañero (a)');
            }else if(response == "actividadP"){
                toastr.warning('Debe ingresar el cargo que desempeña del compañero (a)');
                 var inputElement = document.getElementById("actividadPareja");
                inputElement.focus();
            }else if(response == "patronoP"){
                toastr.warning('Debe ingresar el patrono del compañero (a)');
                 var inputElement = document.getElementById("patronoPareja");
                inputElement.focus();
            }else{
                Swal.fire({
                    icon: 'error',
                    title: 'error',
                    text: 'No se han podido almacenar los datos',
                  })
            }
        }
    })
    
}

function RegistrarAval(){
    //datos del cliente
    
    idEstadoCivil =$('#estadoCivil').val();
    idGenero = $('#idGeneroCliente').val();  
    idcategoriaCasa = $('#casa').val();
    idtiempoVivir = $('#tiempoVivir').val();
    pagaAlquiler = $('#pagaAlquiler').val();
    idTiempoLaboral = $('#tiempoLaboral').val();
    actividadDesempenia = $('#actividadDesempeña').val();
    patrono = $('#patrono').val();
    idProfesion = $('#profesiones').val();
    idTipoClientes = $('#tipoCliente').val();
    nombres = $('#nombresCliente').val();
    apellidos = $('#apellidosCliente').val();
    identidad = $('#identidadCliente').val();
    fechaNacimiento = $('#fechaNacimiento').val();
    idNacionalidad = $('#nacionalidad').val();
    direccionCliente = $('#direccionCliente').val();
    celularCliente = $('#celularCLiente').val();
    telefonoCliente = $('#telefonoCliente').val();
    direccionTrabajoCliente = $('#direccionTrabajoCliente').val();
    telefonoTrabajoCliente = $('#telefonoClienteTrabajo').val();
    cuentaCliente = $('#cuentaCliente').val();
    esAval = $('#esAvalCliente').val();
    avalMora = $('#avalMoraCliente').val();
    estadoCredito = $('#estadoCreditoCliente').val();
    municipioAval = $('#municipioCliente').val();
    //referencias familiares
    nombreR1 = $('#nombreR1').val();
    parestencosR1 = $('#parestencosR1').val();
    celularR1 = $('#celularR1').val();
    direccionR1 = $('#direccionR1').val();
    nombreR2 = $('#nombreR2').val();
    parestencosR2 = $('#parestencosR2').val();
    celularR2 = $('#celularR2').val();
    direccionR2 = $('#direccionR2').val();
     //referencias comerciales
     nombreRC1 = $('#nombreComercial1').val();
     direcionRC1 = $('#direccionComercial1').val();
     nombreRC2 = $('#nombreComercial2').val();
     direcionRC2 = $('#direccionComercial2').val();
    
    //informacion adicional
    ObservacionesSolicitud = $('#observaciones').val();
    //datos de la pareja
    nombresPareja = $('#nombresPareja').val();
    apellidosPareja = $('#apellidosPareja').val();
    identidadPareja = $('#identidadPareja').val();
    fechaNacimientoPareja = $('#fechaNacimientoPareja').val();
    idGeneroPareja = $('#generoPareja').val();  
    actividadDesempeniaPareja = $('#actividadPareja').val();
    idTiempoLaboralPareja = $('#tiempoLaboralPareja').val();
    idProfesionPareja = $('#profesionPareja').val();
    patronoPareja = $('#patronoPareja').val();
    idTipoClientesPareja = $('#tipoClientePareja').val();
    direccionPareja = $('#direccionPareja').val();
    celularPareja = $('#celularPareja').val();
    telefonoPareja = $('#telefonoPareja').val();
    direccionTrabajoPareja = $('#direccionTrabajoPareja').val();
    telefonoTrabajoPareja = $('#telefonoParejaTrabajo').val();
    ingresoNegocioPareja = $('#ingresoNegocioPareja').val();
    sueldoBasePareja = $('#sueldoBasePareja').val();
    gastoAlimentacionPareja = $('#gastoAlimentacionPareja').val();
    cuentaPareja = $('#cuentaPareja').val();
    esAvalPareja = $('#esAvalPareja').val();
    avalMoraPareja = $('#avalMoraPareja').val();
    estadoCreditoPareja = $('#estadoCreditoPareja').val();
    municipioParejaAval = $('#municipioPareja').val();

    //analisis crediticio
    pagoCasa = $('#pagoCasa').val();
    ingresosPorNegocio = $('#ingresosPorNegocio').val();
    sueldoBase = $('#sueldoBase').val();
    gastosAlimentacion = $('#gastosAlimentacion').val();
    //2
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
    descripcion = $('#evaluacion').val();
   // console.log(idcategoriaCasa);
      
    if(nombres === ""){
        toastr.warning('¡Debes ingresar el nombre del aval!');
        var inputElement = document.getElementById("nombresCliente");
        inputElement.focus();
        return
    }
    if(apellidos === ""){
        toastr.warning('¡Debes ingresar el apellido del aval!');
        var inputElement = document.getElementById("apellidosCliente");
        inputElement.focus();
        return
    }
    if(identidad === ""){
        toastr.warning('¡Debes ingresar la identidad del aval');
        var inputElement = document.getElementById("identidadCliente");
        inputElement.focus();
        return
    }
    if(identidad === "0000-0000-00000" || identidad.length<15){
        toastr.warning('Número de indentidad incorrecto del aval');
        var inputElement = document.getElementById("identidadCliente");
        inputElement.focus();
        return
    }
    if(fechaNacimiento === ""){
        toastr.warning('¡Debes ingresar la fecha de nacimiento aval');
        return
    }
    if(identidad.substring(5,9) != fechaNacimiento.substring(0,4) ){
        toastr.warning('El año de nacimiento no coincide con la identidad del aval');
        return
    }
    if(direccionCliente === ""){
        toastr.warning('Debe ingresar la dirección del aval');
        var inputElement = document.getElementById("direccionCliente");
        inputElement.focus();
        return
    }
    if(telefonoCliente !== "" && telefonoCliente.length <9 || telefonoCliente=="0000-0000" ){
        toastr.warning('Teléfono del aval incorrecto');
        var inputElement = document.getElementById("telefonoCliente");
        inputElement.focus();
        return
    }
   
    if(celularCliente === ""){
        toastr.warning('Debe ingresar el número de celular del aval');
        var inputElement = document.getElementById("celularCLiente");
        inputElement.focus();
        return
    }
    if(celularCliente.length <9 || celularCliente=="0000-0000" ){
        toastr.warning('Celular del aval incorrecto');
        var inputElement = document.getElementById("celularCLiente");
        inputElement.focus();
        return
    }
    if(idEstadoCivil === ""){
        toastr.warning('Debe seleccionar el estado civil');
        var inputElement = document.getElementById("estadoCivil");
        inputElement.focus();
        return
    }
    if(idcategoriaCasa === ""){
        toastr.warning('Selecciona una categoria de casa');
        return
    }
    if(idtiempoVivir === ""){
        toastr.warning('Debe seleccionar el tiempo de vivir');
        return
    }
    if(pagaAlquiler > 1 && pagoCasa==="" ){
        toastr.warning('Debe ingresar el pago del alquiler');
        var inputElement = document.getElementById("pagoCasa");
        inputElement.focus();
        return
    }
    if(idGenero === ""){
        toastr.warning('Debe seleccionar el genero del aval');
        var inputElement = document.getElementById("idGeneroCliente");
        inputElement.focus();
        return
    }
    if(idProfesion === ""){
        toastr.warning('Debe seleccionar la profesión, oficio o ocupacón');
        return
    }
   
    if(actividadDesempenia === ""){
        toastr.warning('Debe ingresar la actividad que desempeña el aval');
        var inputElement = document.getElementById("actividadDesempeña");
        inputElement.focus();
        return
    }
    if(idTiempoLaboral === ""){
        toastr.warning('Debe seleccionar el tiempo de laboral');;
        return
    }

    if(sueldoBase === ""){
        toastr.warning('Ingrese el suelo base del aval');
        var inputElement = document.getElementById("sueldoBase");
        inputElement.focus();
        return
    }
    if(telefonoTrabajoCliente !== "" && telefonoTrabajoCliente.length <9 || telefonoTrabajoCliente=="0000-0000" ){
        toastr.warning('Teléfono del trabajo del solicitante incorrecto');
        var inputElement = document.getElementById("telefonoClienteTrabajo");
        inputElement.focus();
        return
    }
    
    if(idTipoClientes === ""){
        toastr.warning('Debe seleccionar el tipo de crédito');;
        return
    }
    if(celularR1 !== "" && celularR1.length <9 || celularR1=="0000-0000" ){
        toastr.warning('Celular de referencia 1 incorrecto');
        return
    }
    if(celularR2 !== "" && celularR2.length <9 || celularR2=="0000-0000" ){
        toastr.warning('Celular de referencia 2 incorrecto');
        return
    }

   
   parametros = {
    "idNacionalidad":idNacionalidad, "idGenero":idGenero, "idEstadoCivil":idEstadoCivil, "idProfesion":idProfesion,
    "idTipoClientes":idTipoClientes, "idcategoriaCasa":idcategoriaCasa , "idtiempoVivir":idtiempoVivir, "pagaAlquiler":pagaAlquiler, "idTiempoLaboral":idTiempoLaboral,
    "nombres":nombres, "apellidos":apellidos, "identidad":identidad, "fechaNacimiento":fechaNacimiento, "actividadDesempenia":actividadDesempenia, "patrono":patrono,
    "direccionCliente":direccionCliente, "celularCliente":celularCliente, "telefonoCliente":telefonoCliente, "direccionTrabajoCliente":direccionTrabajoCliente,
    "telefonoTrabajoCliente":telefonoTrabajoCliente, "cuentaCliente":cuentaCliente, "esAval":esAval, "avalMora":avalMora, "estadoCredito":estadoCredito, "municipioAval":municipioAval,

    //referencias familiares
    "nombreR1":nombreR1, "parestencosR1":parestencosR1, "celularR1":celularR1, "direccionR1":direccionR1, "nombreR2":nombreR2, "parestencosR2":parestencosR2,
    "celularR2":celularR2, "direccionR2":direccionR2,
    //referencias comerciales
    "nombreRC1":nombreRC1, "direcionRC1":direcionRC1, "nombreRC2":nombreRC2, "direcionRC2":direcionRC2,

     //informacion adicional
     "ObservacionesSolicitud":ObservacionesSolicitud,
     //pagos
     "pagoCasa":pagoCasa, "ingresosPorNegocio":ingresosPorNegocio, "sueldoBase":sueldoBase, "gastosAlimentacion":gastosAlimentacion,
    //parametros de la pareja
    "nombresPareja":nombresPareja, "apellidosPareja":apellidosPareja, "identidadPareja":identidadPareja, "fechaNacimientoPareja":fechaNacimientoPareja,
    "idGeneroPareja":idGeneroPareja, "actividadDesempeniaPareja":actividadDesempeniaPareja,
    "idTiempoLaboralPareja":idTiempoLaboralPareja, "idProfesionPareja":idProfesionPareja, "patronoPareja":patronoPareja, "idTipoClientesPareja":idTipoClientesPareja,
    "direccionPareja":direccionPareja, "celularPareja":celularPareja,
    "telefonoPareja":telefonoPareja, "direccionTrabajoPareja":direccionTrabajoPareja, "telefonoTrabajoPareja":telefonoTrabajoPareja,
    "ingresoNegocioPareja":ingresoNegocioPareja, "sueldoBasePareja":sueldoBasePareja, "gastoAlimentacionPareja":gastoAlimentacionPareja, "cuentaPareja":cuentaPareja,
    "esAvalPareja":esAvalPareja, "avalMoraPareja":avalMoraPareja, "estadoCreditoPareja":estadoCreditoPareja, "municipioParejaAval":municipioParejaAval,

    //analisis crediticio
    "sueldoBase":sueldoBase, "ingresosNegocio":ingresosNegocio, "RentaPropiedad":RentaPropiedad, "remesas":remesas, "aporteConyuge":aporteConyuge,
    "IngresosSociedad":IngresosSociedad, "cuotaPrestamoAdepes":cuotaPrestamoAdepes, "cuotaVivienda":cuotaVivienda, "alimentacion":alimentacion,
    "deduccionesCentral":deduccionesCentral, "otrosEgresos":otrosEgresos, "liquidezCliente":liquidezCliente, "descripcion":descripcion
    
   }

    $.ajax({
        data:parametros,
        url:'../controller/SolicitudNuevaController.php?operador=registrar_aval', //url del controlador RolConttroller
        type:'POST',
        beforeSend:function(){},
        success:function(response){
            //console.log(response);
            if(response == "success"){  //si inserto correctamente
                swal.fire({
                    icon: "success",
                    title: "Registro exitoso",
                    text: "Datos personales del aval registrados"
                    
                }).then(function() {
                    window.location = "../pages/solicitudes.php";
                });
                //limpiarInputsCliente();
                  
            }else if(response == "requerid"){
                 toastr.warning('¡Debes ingresar el nombre del aval!', 'Nombres');

            }else if(response == "registrarPareja"){
                swal.fire({
                    icon: "success",
                    title: "Registro exitoso",
                    text: "Datos personales del aval registrados"
                    
                }).then(function() {
                    window.location = "../pages/solicitudes.php";
                });

            }else if(response == "genero"){
                toastr.warning('Debe seleccionar el genero del compañero (a)');

            }else if(response == "telefonoIncorrecto"){    
                toastr.warning('Teléfono incorrecto del compañero (a)');

            }else if(response == "celularIncorrecto"){    
                toastr.warning('Celular incorrecto del compañero (a)');

            }else if(response == "telefonoTrabajoIncorrecto"){    
                toastr.warning('Teléfono de trabajo incorrecto del compañero (a)');

            }else if(response == "profesion"){
                toastr.warning('Debe seleccionar la profesión, oficio o ocupación del compañero (a)');
                
            }else if(response == "tipoCliente"){
                toastr.warning('Debe seleccionar el tipo de cliente del compañero (a)');
            }else if(response == "tiempoLaboral"){
                toastr.warning('Debe seleccionar el tiempo laboral del compañero (a)');
            }else if(response == "nombrePareja"){
                toastr.warning('Debe ingresar el nombre del compañero (a)');
                 var inputElement = document.getElementById("nombresPareja");
                inputElement.focus(); 
            }else if(response == "apellidoPareja"){
                toastr.warning('Debe ingresar los apellidos del compañero (a)');
                 var inputElement = document.getElementById("apellidosPareja");
                inputElement.focus(); 
            }else if(response == "identidadPareja"){
                toastr.warning('Debe ingresar la identidad del compañero (a)');
                 var inputElement = document.getElementById("identidadPareja");
                inputElement.focus(); 
            }else if(response == "identidadIncorrecta"){
                toastr.warning('Número de indentidad incorrecto del compañero (a)');
                 var inputElement = document.getElementById("identidadPareja");
                inputElement.focus(); 
            }else if(response == "fechaNacimientoP"){ 
                toastr.warning('Debe ingresar la fecha de nacimiento del compañero (a)');
                 var inputElement = document.getElementById("fechaNacimientoPareja");
                inputElement.focus();
            }else if(response =="fechaIdentidadCorrecta"){
                toastr.warning('El año de nacimiento no coincide con la identidad del compañero (a)');
            }else if(response == "actividadP"){
                toastr.warning('Debe ingresar el cargo que desempeña del compañero (a)');
                 var inputElement = document.getElementById("actividadPareja");
                inputElement.focus();
            }else if(response == "patronoP"){
                toastr.warning('Debe ingresar el patrono del compañero (a)');
                 var inputElement = document.getElementById("patronoPareja");
                inputElement.focus();
            }else{
                Swal.fire({
                    icon: 'error',
                    title: 'error',
                    text: 'No se han podido almacenar los datos',
                  })
            }
        }
    })
    
}

function BuscarCliente(){
    identidad = $('#BuscarCliente').val();

    if(identidad === ""){
        toastr.warning('¡Para buscar un cliente ingrese el N° identidad');
        var inputElement = document.getElementById("BuscarCliente");
        inputElement.focus();
        return
    }
    if(identidad === "0000-0000-00000" || identidad.length<15){
        toastr.warning('El número de indentidad ingresado es incorrecto');
        var inputElement = document.getElementById("BuscarCliente");
        inputElement.focus();
        return
    }

    $.ajax({
        data: { "identidad": identidad},
        url:'../controller/SolicitudNuevaController.php?operador=buscar_cliente_por_id', //url del controlador Conttroller
        type:'POST',
        beforeSend:function(){},
        success:function(response){
            
           if(response){
            data = $.parseJSON(response);

            $('#nombresCliente').val(data[0]['NOMBRE']);
            $('#apellidosCliente').val(data[0]['APELLIDO']);
            $('#identidadCliente').val(data[0]['IDENTIDAD']);
            $('#fechaNacimiento').val(data[0]['NACIMIENTO']);
            $('#patrono').val(data[0]['PATRONO']);
            $('#actividadDesempeña').val(data[0]['CARGO']);
            $('#estadoCivil').val(data[0]['IDESTADOCIVIL']);
            $('#casa').val(data[0]['CASA']);
            $('#tiempoVivir').val(data[0]['TIEMPOVIVIR']);
            $('#pagaAlquiler').val(data[0]['PAGAALQUILER']);
            $('#idGeneroCliente').val(data[0]['GENERO']);
            $('#profesiones').val(data[0]['PROFESION']);
            $('#nacionalidad').val(data[0]['NACIONALIDAD']);
            $('#tiempoLaboral').val(data[0]['TIEMPOLABORAL']);
            $('#celularCLiente').val(data[0]['CELULAR']);
            $('#direccionCliente').val(data[0]['DIRECCION']);
            $('#telefonoCliente').val(data[0]['TELEFONO']);
            $('#direccionTrabajoCliente').val(data[0]['DIRECCIONTRABAJO']);
            $('#telefonoClienteTrabajo').val(data[0]['TELEFONOTRABAJO']);
           
            mostrarFormulario();
            BuscarClienteConyugue(data[0]['ID']);
           }else{
            toastr.warning('Cliente no existe, ó número de Indentidad incorrecto'); 
           }

        }
  
    });
}
function BuscarClienteConyugue(idPersona){
    

    $.ajax({
        data: { "idPersona": idPersona},
        url:'../controller/SolicitudNuevaController.php?operador=buscar_clienteConyugue_por_id', //url del controlador Conttroller
        type:'POST',
        beforeSend:function(){},
        success:function(response){
            
           if(response){
            data = $.parseJSON(response);

            $('#nombresPareja').val(data[0]['NOMBRE']);
            $('#apellidosPareja').val(data[0]['APELLIDO']);
            $('#identidadPareja').val(data[0]['IDENTIDAD']);
            $('#fechaNacimientoPareja').val(data[0]['NACIMIENTO']);
            $('#patronoPareja').val(data[0]['PATRONO']);
            $('#actividadPareja').val(data[0]['CARGO']);
           // $('#estadoCivil').val(data[0]['IDESTADOCIVIL']);
           // $('#casa').val(data[0]['CASA']);
          //  $('#tiempoVivir').val(data[0]['TIEMPOVIVIR']);
          //  $('#pagaAlquiler').val(data[0]['PAGAALQUILER']);
            $('#generoPareja').val(data[0]['GENERO']);
            $('#profesionPareja').val(data[0]['PROFESION']);
          //  $('#nacionalidad').val(data[0]['NACIONALIDAD']);
            $('#tiempoLaboralPareja').val(data[0]['TIEMPOLABORAL']);
            $('#telefonoPareja').val(data[0]['CELULAR']);
            $('#direccionPareja').val(data[0]['DIRECCION']);
            $('#telefonoCliente').val(data[0]['TELEFONO']);
            $('#direccionTrabajoPareja').val(data[0]['DIRECCIONTRABAJO']);
            $('#telefonoParejaTrabajo').val(data[0]['TELEFONOTRABAJO']);
            
           }

        }
  
    });
}

//funcion para obtener el id de la solicitud para actualizarlo
function ObtenerDatosPrestamo(idTipoPrestamo, monto, plazo){
    $.ajax({
        data: { "idTipoPrestamo": idTipoPrestamo },
        url:'../controller/SolicitudNuevaController.php?operador=obtener_datos_prestamo', //url del controlador Conttroller
        type:'POST',
        beforeSend:function(){},
        success:function(response){
            console.log(response);
            data = $.parseJSON(response);
           
            if(data.length > 0){
                //calculo de tasa de cuota mensual
                
                tasa = data[0]['TASA'];

                let tasaMensual = tasa / 12 / 100; // Convertir tasa anual a mensual y a decimal
                let denominador = Math.pow(1 + tasaMensual, plazo) - 1;
                let cuota = (monto * tasaMensual * Math.pow(1 + tasaMensual, plazo)) / denominador;
                
                let interesCorrienteMensual = monto * ((tasa / 100) / 12 / 30 * 31);
                
                // Letra mensual
                let letraMensual = cuota - interesCorrienteMensual;

                // Redondear a dos cifras decimales
                cuota = Math.round(cuota * 100) / 100;
                interesCorrienteMensual = Math.round(interesCorrienteMensual * 100) / 100;
                letraMensual = Math.round(letraMensual * 100) / 100;
              
                $('#cuotaMensual').val(cuota);
                $('#letraMensual').val(letraMensual);
                $('#interesCorriente').val(interesCorrienteMensual);

                sumarIngresosEgresos();
            }
           
        }
  
    });
  
  }


function sumarIngresosEgresos() {
    var sueldoBase = parseFloat(document.getElementById("sueldoBase_analisis").value) || 0;
    var ingresosNegocio = parseFloat(document.getElementById("ingresosNegocio").value) || 0;
    var renta = parseFloat(document.getElementById("renta").value) || 0;
    var remesas = parseFloat(document.getElementById("remesas").value) || 0;
    var aporteConyuge = parseFloat(document.getElementById("aporteConyuge").value) || 0;
    var sociedad = parseFloat(document.getElementById("sociedad").value) || 0;

    var sumaIngresos = sueldoBase+ ingresosNegocio + renta + remesas +aporteConyuge + sociedad;
    
    document.getElementById("totalIngresos").value = sumaIngresos.toFixed(2);
  
    var cuotaAdepes = parseFloat(document.getElementById("cuota").value) || 0; //esCuotaAdepes. corregir
    var vivienda = parseFloat(document.getElementById("vivienda").value) || 0;
    var alimentacion = parseFloat(document.getElementById("alimentacion").value) || 0;
    var centralRiesgo = parseFloat(document.getElementById("centralRiesgo").value) || 0;
    var otrosEgresos = parseFloat(document.getElementById("otrosEgresos").value) || 0;
    

    var sumaEgresos =cuotaAdepes+ vivienda + alimentacion + centralRiesgo +otrosEgresos;
    
    document.getElementById("totalEgresos").value = sumaEgresos.toFixed(2);
   
    //totales
    var IngresosNetos = sumaIngresos - sumaEgresos;
    document.getElementById("ingresosNetos").value = IngresosNetos.toFixed(2);
   
    //capital disponible
    var cuotaAdepes2 = parseFloat(document.getElementById("cuotaMensual").value) || 0;
    var capitalDisponible = IngresosNetos - cuotaAdepes2;
    document.getElementById("capitalDisponible").value = capitalDisponible;
 //evaluacion
    if(capitalDisponible > 0){
        document.getElementById('evaluacion').value ="CLIENTE TIENE CAPACIDAD DE PAGO, PARA EL MONTO QUE ESTA SOLICITANDO";
    }else if(capitalDisponible < 0){
        document.getElementById('evaluacion').value ="CLIENTE NO TIENE CAPACIDAD DE PAGO, PARA EL MONTO QUE ESTA SOLICITANDO";
    }else{
        document.getElementById('evaluacion').value ="";
    }
    
  //  var  = 
  
 
}

function sumarIngresosEgresosAval() {
    var sueldoBase = parseFloat(document.getElementById("sueldoBase_analisis").value) || 0;
    var ingresosNegocio = parseFloat(document.getElementById("ingresosNegocio").value) || 0;
    var renta = parseFloat(document.getElementById("renta").value) || 0;
    var remesas = parseFloat(document.getElementById("remesas").value) || 0;
    var aporteConyuge = parseFloat(document.getElementById("aporteConyuge").value) || 0;
    var sociedad = parseFloat(document.getElementById("sociedad").value) || 0;

    var sumaIngresos = sueldoBase+ ingresosNegocio + renta + remesas +aporteConyuge + sociedad;
    
    document.getElementById("totalIngresos").value = sumaIngresos;
    var cuotaAdepes = parseFloat(document.getElementById("cuotaAdepes").value) || 0;
    var vivienda = parseFloat(document.getElementById("vivienda").value) || 0;
    var alimentacion = parseFloat(document.getElementById("alimentacion").value) || 0;
    var centralRiesgo = parseFloat(document.getElementById("centralRiesgo").value) || 0;
    var otrosEgresos = parseFloat(document.getElementById("otrosEgresos").value) || 0;
    

    var sumaEgresos = cuotaAdepes+ vivienda + alimentacion + centralRiesgo +otrosEgresos;
    
    document.getElementById("totalEgresos").value = sumaEgresos;
   
    //totales
    var IngresosNetos = sumaIngresos - sumaEgresos;
    document.getElementById("ingresosNetos").value = IngresosNetos;
   
    //capital disponible
    var cuotaAdepes = parseFloat(document.getElementById("cuotaMensual").value) || 0;
    var capitalDisponible = IngresosNetos - cuotaAdepes;
    document.getElementById("capitalDisponible").value = capitalDisponible;
 //evaluacion
    if(capitalDisponible > 0){
        document.getElementById('evaluacion').value ="ESTA PERSONA TIENE CAPACIDAD DE PAGO, PARA SERVIR COMO AVAL SOLIDARIO";
    }else if(capitalDisponible < 0){
        document.getElementById('evaluacion').value ="ESTA PERSONA NO TIENE CAPACIDAD DE PAGO, PARA SERVIR COMO AVAL SOLIDARIO";
    }else{
        document.getElementById('evaluacion').value ="";
    }
    
  //  var  = 
  
 
}



// funciones para regresar al listado
function Cancelar(){
    Swal.fire({
        title: '¿Desea regresar al listado de solicitudes?',
        text: "La información ingresada se perderá",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si,',
        cancelButtonText: 'no',
      }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = '../pages/solicitudes.php';
        }
      })
}




function mostrarFormulario() {
    const seleccion = document.getElementById("estadoCivil").value;
    const formulario = document.getElementById("formulario");

    if (seleccion == 2 || seleccion == 3) {
      formulario.style.display = "block";
    } else {
      formulario.style.display = "none";
    }
  }

/***************************************************************** */
function generarPlan() {
    const prestamo = parseFloat(document.getElementById('monto').value);
    const plazoMeses = parseInt(document.getElementById('plazo').value);
    const fechaEmision = new Date(document.getElementById('fechaEmision').value);
    tipoPrestamo =$('#tipogarantia').val();
    
    fecha =$('#fechaEmision').val();
    $('#tipogarantiaR').val(tipoPrestamo);
    $('#montoR').val(prestamo);
    $('#plazoR').val(plazoMeses);
    $('#fechaEmisionR').val(fecha);

    if( tipoPrestamo ===""){
        toastr.warning('Para generar el plan de pagos seleccione un tipo de garantía');
        return
    }
    if( fecha ===""){
        toastr.warning('Para generar el plan de pagos ingrese la fecha de emisión');
        return
    } 
    const tasaInteresAnual = 0.12;
    const tasaInteresMensual = tasaInteresAnual / 12;
    let cuota = (prestamo * tasaInteresMensual * Math.pow(1 + tasaInteresMensual, plazoMeses)) /
                (Math.pow(1 + tasaInteresMensual, plazoMeses) - 1);
    let saldoPendiente = prestamo;
    const planPagos = [];

    let fechaAnterior = new Date(fechaEmision);
    for (let mes = 0; mes < plazoMeses; mes++) {
        const diasEnElMes = new Date(fechaAnterior.getFullYear(), fechaAnterior.getMonth() + 1, 0).getDate();
        const pagoInteresDiario = (saldoPendiente * tasaInteresAnual) / 365 * diasEnElMes;

        let pagoAmortizacion = cuota - pagoInteresDiario;
        saldoPendiente -= pagoAmortizacion;

        if (mes === plazoMeses - 1) {
            pagoAmortizacion += saldoPendiente;
            saldoPendiente = 0;
            cuota = pagoInteresDiario + pagoAmortizacion;
        }

        const cuotaFecha = new Date(fechaAnterior);
        cuotaFecha.setMonth(fechaAnterior.getMonth() + 1);

        planPagos.push({
            mes: mes + 1,
            fecha: cuotaFecha.toISOString().slice(0, 10),
            cuota: cuota,
            pago_interes: pagoInteresDiario,
            pago_amortizacion: pagoAmortizacion,
            saldo_pendiente: saldoPendiente
        });

        fechaAnterior.setMonth(fechaAnterior.getMonth() + 1);
    }

    const planContainer = document.getElementById('planModalBody');
    planContainer.innerHTML = `
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">No de cuota</th>
                    <th scope="col">Fecha</th>
                    <th scope="col">Valor de la cuota</th>
                    <th scope="col">Valor de Interés</th>
                    <th scope="col">Valor del Capital</th>
                    <th scope="col">Saldo del Capital</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>0</td>
                    <td>${fechaEmision.toISOString().slice(0, 10)}</td>
                    <td>-</td>
                    <td>-</td>
                    <td>-</td>
                    <td>${prestamo.toFixed(2)}</td>
                </tr>
                ${planPagos.map(pago => `
                    <tr>
                        <td>${pago.mes}</td>
                        <td>${pago.fecha}</td>
                        <td>${pago.cuota.toFixed(2)}</td>
                        <td>${pago.pago_interes.toFixed(2)}</td>
                        <td>${pago.pago_amortizacion.toFixed(2)}</td>
                        <td>${pago.saldo_pendiente.toFixed(2)}</td>
                    </tr>
                `).join('')}
            </tbody>
        </table>`;

    $('#planModal').modal('show');
}



//PARA MOSTRAR INFROMACIONA ADICIONAL DEL TIPO DE PRESTMO



function mostrarDatosPrestamos() {
    const select = document.getElementById("tipogarantia");
    const seleccion = select.value;
  
    $.ajax({
      data: { "idTipoPrestamo": seleccion },
      url: '../controller/SolicitudNuevaController.php?operador=obtener_datos_prestamo',
      type: 'POST',
      beforeSend: function () {},
      success: function (response) {
        try {
          data = $.parseJSON(response);
  
          if (data.length > 0) {
            const mensajeDiv = document.getElementById("mensaje");
  
            if (seleccion == 1) {
              mensajeDiv.style.display = "block";
            //  mensajeDiv.textContent = "Informacion adicional:";
              const mensajeHTML = "<center>Importante: <strong> Monto mínimo: L.</strong> " + data[0]['MINIMO'] + " <strong>Monto máximo: L. </strong>"+data[0]['MAXIMO']
              +" <strong>Plazo máximo:</strong> "+data[0]['PLAZO']+ " meses.</center>";
              //actualiza el contenido de la advertencia
                document.querySelector(".alert.alert-info").innerHTML = mensajeHTML;
            } else if (seleccion == 2) {
              mensajeDiv.style.display = "block";
              const mensajeHTML = "<center>Importante: <strong> Monto mínimo: L.</strong> " + data[0]['MINIMO'] + " <strong>Monto máximo: L. </strong>"+data[0]['MAXIMO']
              +" <strong>Plazo máximo:</strong> "+data[0]['PLAZO']+ " meses.</center>";
              //actualiza el contenido de la advertencia
                document.querySelector(".alert.alert-info").innerHTML = mensajeHTML;
            } else {
              mensajeDiv.style.display = "none";
            }
          }
        } catch (error) {
          // Manejo de errores: Puedes mostrar un mensaje de error o realizar acciones específicas
         
        }
      }
    });
  }
  














