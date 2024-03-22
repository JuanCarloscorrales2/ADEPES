data = JSON.parse(localStorage.getItem('data')); //datos traidos de listadoSolicitudes.js
 //la variable 'data' en este archivo
console.log(data);
init();

function init(){
  $('#idSolicitante_edit').val(data[0]['idPerso']);
  $('#idSolicitud_edit').val(data[0]['idSoli']);
  TipoPrestamoSelectEdit(data[0]['idSoli']);
  $('#monto_edit').val(data[0]['monto']);
  $('#plazo_edit').val(data[0]['plazo']);
  RubroSelectEdit(data[0]['idSoli']);
  $('#fechaEmision_edit').val(data[0]['fecha']);
  $('#nombresCliente_edit').val(data[0]['nombre']);
  $('#apellidosCliente_edit').val(data[0]['apellido']);
  $('#identidadCliente_edit').val(data[0]['identidad']);
  $('#fechaNacimiento_edit').val(data[0]['nacimiento']);
  NacionalidadSelectEdit(data[0]['idPerso'], 1);
  ContactosEdit(data[0]['idPerso'], 0, 0);
  EstadoCivilSelectEdit(data[0]['idPerso'], 1);
  CasaSelectEdit(data[0]['idPerso'], 1);
  TiempoVivirEdit(data[0]['idPerso'], 1);
  FormaPagoEdit(data[0]['idPerso'], 1);
  GeneroEdit(data[0]['idPerso'], 1);
  ProfesionEdit(data[0]['idPerso'], 1);
  TiempoLaboralEdit(data[0]['idPerso'], 1);
  TipoCreditoEdit(data[0]['idPerso'], 1);
  EstadoCreditoEdit(data[0]['idPerso'], 1);
  EsAval(data[0]['idPerso'], 1);
  Municipios(data[0]['idPerso'], 1);
  AvalesMora(data[0]['idPerso'], 1);
  PersonasCuenta(data[0]['idPerso'], 1);
  ListarPersonaBienes(data[0]['idPerso']);
  $('#patrono_edit').val(data[0]['patrono']);
  $('#actividadDesempeña_edit').val(data[0]['cargo']);
  $('#invierteEn_edit').val(data[0]['invierte']);
  AnalisisCrediticio(data[0]['idPerso']);
  ReferenciasFamiliares(data[0]['idPerso'], 1);
  PersonaDependientes(data[0]['idPerso']);
  //

  
  //avales
  DatosAvales(data[0]['idSoli']);
  
  //FORMATO CONOZCA A SU CLIENTE
  $('#nombreFormato').val(data[0]['nombre']+" "+data[0]['apellido']);
  $('#fechaNacimientoFormato').val(data[0]['nacimiento']);
  $('#identidadFormato').val(data[0]['identidad']);
  $('#FechaEmisionFormato').val(data[0]['fecha']);
  $('#PatronoFormato').val(data[0]['patrono']);
  $('#ActividadDesempenaFormato').val(data[0]['cargo']);
  FormatoConozcaAsuCliente(data[0]['idPerso']);

  //CENTRAL DE RIESGO
  $('#nombreClienteCentral').val(data[0]['nombre']+" "+data[0]['apellido']);
  $('#identidadClienteCetral').val(data[0]['identidad']);
  $('#nombreClienteCentralFirma').val(data[0]['nombre']+" "+data[0]['apellido']);
  $('#identidadClienteCetralFirma').val(data[0]['identidad']);
  //DICTAMEN ASESOR
  $('#montoDictamenedit').val(data[0]['monto']);
  $('#plazoDictamenedit').val(data[0]['plazo']);
  DictamenAsesor(data[0]['idPerso']);
  //COMITE DE CREDITO
  $('#nombreComiteEdit').val(data[0]['nombre']+" "+data[0]['apellido']);
  $('#montoComiteEdit').val(data[0]['monto']);
  $('#plazoComiteEdit').val(data[0]['plazo']);
  $('#tipoPrestamoComite').val(data[0]['prestamo']);
  $('#destinoComiteEdit').val(data[0]['invierte']);
}


function TipoPrestamoSelectEdit(idSolicitud){

    $.ajax({
       data : { "idSolicitud" : idSolicitud},
        url:'../controller/EditarSolicitudController.php?operador=listar_tipoPrestamo_select_edit',
        type:'POST',
        beforeSend:function(){},
        success:function(respuesta){
            data = $.parseJSON(respuesta);
            if(data.length > 0){ //valida que existan datos
              // console.log(data); //para probar que traiga los datos
                 //se agrega value para que valida que no se selccione la opcion: seleccione una categoria
                select="";
  
                 //each sirve para recorrer los elementos de una lista
                $.each(data,function(key,value){   
                select = select + "<option value=" +value[0]+ ">" +value[1]+" al "+value[3]+"%"+ "</option>"; //  va 1 ya que es el nombre  por que a si se puso en RolController.php en el metdo
                    
                })
                $('#tipogarantia_edit').html(select);
                ObtenerDatosPrestamo(); //para calcular el interes y cuta en analisis crediticio
                     
            }
        }
    });
  
}

function RubroSelectEdit(idSolicitud){

  $.ajax({
     data : { "idSolicitud" : idSolicitud},
      url:'../controller/EditarSolicitudController.php?operador=listar_Rubro_select_',
      type:'POST',
      beforeSend:function(){},
      success:function(respuesta){
          data = $.parseJSON(respuesta);
          if(data.length > 0){ //valida que existan datos

              select="";
               //each sirve para recorrer los elementos de una lista
              $.each(data,function(key,value){   
              select = select + "<option value=" +value[0]+ ">" +value[1]+"</option>"; //  va 1 ya que es el nombre  por que a si se puso en RolController.php en el metdo
                  
              })
              $('#rubro_edit').html(select);
              $('#destinoDictamen').html(select);
                   
          }
      }
  });

}

function NacionalidadSelectEdit(idPersona, tipoPersona){

  $.ajax({
     data : { "idPersona" : idPersona},
      url:'../controller/EditarSolicitudController.php?operador=listar_nacionalidad_select_',
      type:'POST',
      beforeSend:function(){},
      success:function(respuesta){
          data = $.parseJSON(respuesta);
          if(data.length > 0){ //valida que existan datos
              select="";
               //each sirve para recorrer los elementos de una lista
              $.each(data,function(key,value){   
              select = select + "<option value=" +value[0]+ ">" +value[1]+"</option>"; //  va 1 ya que es el nombre  por que a si se puso en RolController.php en el metdo
                  
              })
              if(tipoPersona == 1){//solicitante
                $('#nacionalidad_edit').html(select);
              }else if(tipoPersona == 2){ //Aval1
                $('#nacionalidad_edit1').html(select);
              }else if(tipoPersona == 3){ //Aval2
                $('#nacionalidad_edit2').html(select);
              }else if(tipoPersona == 4){ //Aval3
                $('#nacionalidad_edit3').html(select);
              }
              
                   
          }
      }
  });

}

function ContactosEdit(idPersona, TipoPareja, ContactoAvales){

  $.ajax({
     data : { "idPersona" : idPersona},
      url:'../controller/EditarSolicitudController.php?operador=listar_contactos',
      type:'POST',
      beforeSend:function(){},
      success:function(response){
       // console.log(response); 
       data = $.parseJSON(response);
          if(data.length > 0){ //valida que existan datos

            if(data[0]['TIPO_PERSONA'] == 1){ //CLIENTE
              $('#celularCLiente_edit').val(data[0]['CELULAR']);
              $('#direccionCliente_edit').val(data[0]['DIRECCION']);
              $('#telefonoCliente_edit').val(data[0]['TELEFONO']);
              $('#direccionTrabajoCliente').val(data[0]['DIRECCION_T']);
              $('#telefonoClienteTrabajo').val(data[0]['TELEFONO_T']);
              //FORMATO CONOZACA A SU CLIENTE
              $('#CelularFormato').val(data[0]['CELULAR']);
              $('#DireccionCasaFormato').val(data[0]['DIRECCION']);
              $('#telefonoFormato').val(data[0]['TELEFONO']);
              $('#DireccionTrabajoFormato').val(data[0]['DIRECCION_T']);
              $('#TelefonoTrabajoFormato').val(data[0]['TELEFONO_T']);
              //CENTRAL DE RIESGO
              $('#direccionClienteCentral').val(data[0]['DIRECCION']);

            }else if(data[0]['TIPO_PERSONA'] == 2){ //conyungue
              
              if(TipoPareja == 1){ //PAREJA DEL SOLICITANTE
                $('#celularPareja_edit').val(data[0]['CELULAR']);
                $('#direccionPareja_edit').val(data[0]['DIRECCION']);
                $('#telefonoPareja_edit').val(data[0]['TELEFONO']);
                $('#direccionTrabajoPareja_edit').val(data[0]['DIRECCION_T']);
                $('#telefonoParejaTrabajo_edit').val(data[0]['TELEFONO_T']);
              }
              if(TipoPareja == 2){ //PAREJA DEL Aval1
                $('#celularParejaAval1').val(data[0]['CELULAR']);
                $('#direccionParejaAval1').val(data[0]['DIRECCION']);
                $('#telefonoParejaAval1').val(data[0]['TELEFONO']);
                $('#direccionTrabajoParejaAval1').val(data[0]['DIRECCION_T']);
                $('#telefonoParejaTrabajoAval1').val(data[0]['TELEFONO_T']);
              }

              if(TipoPareja == 3){ //PAREJA DEL Aval2
                $('#celularParejaAval2').val(data[0]['CELULAR']);
                $('#direccionParejaAval2').val(data[0]['DIRECCION']);
                $('#telefonoParejaAval2').val(data[0]['TELEFONO']);
                $('#direccionTrabajoParejaAval2').val(data[0]['DIRECCION_T']);
                $('#telefonoParejaTrabajoAval2').val(data[0]['TELEFONO_T']);
              }

              if(TipoPareja == 4){ //PAREJA DEL Aval3
                $('#celularParejaAval3').val(data[0]['CELULAR']);
                $('#direccionParejaAval3').val(data[0]['DIRECCION']);
                $('#telefonoParejaAval3').val(data[0]['TELEFONO']);
                $('#direccionTrabajoParejaAval3').val(data[0]['DIRECCION_T']);
                $('#telefonoParejaTrabajoAval3').val(data[0]['TELEFONO_T']);
              }
              

            }else if(data[0]['TIPO_PERSONA'] == 3){ //AVALES
              
              if(ContactoAvales == 1){
                $('#celularAval_edit1').val(data[0]['CELULAR']);
                $('#direccionAval_edit1').val(data[0]['DIRECCION']);
                $('#telefonoAval_edit1').val(data[0]['TELEFONO']);
                $('#direccionTrabajoAval_edit1').val(data[0]['DIRECCION_T']);
                $('#telefonoAvalTrabajo_edit1').val(data[0]['TELEFONO_T']);
              }
              if(ContactoAvales == 2){
                $('#celularAval_edit2').val(data[0]['CELULAR']);
                $('#direccionAval_edit2').val(data[0]['DIRECCION']);
                $('#telefonoAval_edit2').val(data[0]['TELEFONO']);
                $('#direccionTrabajoAval_edit2').val(data[0]['DIRECCION_T']);
                $('#telefonoAvalTrabajo_edit2').val(data[0]['TELEFONO_T']);
              }
              if(ContactoAvales == 3){
                $('#celularAval_edit3').val(data[0]['CELULAR']);
                $('#direccionAval_edit3').val(data[0]['DIRECCION']);
                $('#telefonoAval_edit3').val(data[0]['TELEFONO']);
                $('#direccionTrabajoAval_edit3').val(data[0]['DIRECCION_T']);
                $('#telefonoAvalTrabajo_edit3').val(data[0]['TELEFONO_T']);
              }

            }
           
                   
          }
      }
  });

}

function EstadoCivilSelectEdit(idPersona,tipoPersona){

  $.ajax({
     data : { "idPersona" : idPersona},
      url:'../controller/EditarSolicitudController.php?operador=listar_estadocivil_select',
      type:'POST',
      beforeSend:function(){},
      success:function(respuesta){
          data = $.parseJSON(respuesta);
          if(data.length > 0){ //valida que existan datos

              select="";
               //each sirve para recorrer los elementos de una lista
              $.each(data,function(key,value){   
              select = select + "<option value=" +value[0]+ ">" +value[1]+"</option>"; //  va 1 ya que es el nombre  por que a si se puso en RolController.php en el metdo
                  
              })

              if(tipoPersona == 1){ //SOLICITANTE
                $('#estadoCivil_edit').html(select);
                mostrarFormulario();  //si esta casado mostrara el formulario  
                pareja =  $('#estadoCivil_edit').val(); 
                if(pareja == "2" || pareja == "3"){
                    Conyugue(idPersona, 1); //trae los datos de la pareja
                }

              }else if(tipoPersona == 2){ //AVAL1
                $('#estadoCivil_edit1').html(select);
                mostrarFormulario();  //si esta casado mostrara el formulario 
                pareja =  $('#estadoCivil_edit1').val(); 
                if(pareja == "2" || pareja == "3"){
                    Conyugue(idPersona, 2); //trae los datos de la pareja
                }

              }else if(tipoPersona == 3){ //AVAL2
                $('#estadoCivil_edit2').html(select);
                mostrarFormulario();  //si esta casado mostrara el formulario 
                pareja =  $('#estadoCivil_edit2').val(); 
                if(pareja == "2" || pareja == "3"){
                    Conyugue(idPersona, 3); //trae los datos de la pareja
                }

              }else if(tipoPersona == 4){ //AVAL3
                $('#estadoCivil_edit3').html(select);
                mostrarFormulario();  //si esta casado mostrara el formulario 
                pareja =  $('#estadoCivil_edit3').val(); 
                if(pareja == "2" || pareja == "3"){
                    Conyugue(idPersona, 4); //trae los datos de la pareja
                }

              }
              
             
             
          }
      }
  });

}


function CasaSelectEdit(idPersona, tipoPersona){

  $.ajax({
     data : { "idPersona" : idPersona},
      url:'../controller/EditarSolicitudController.php?operador=listar_casa_select',
      type:'POST',
      beforeSend:function(){},
      success:function(respuesta){
          data = $.parseJSON(respuesta);
          if(data.length > 0){ //valida que existan datos

              select="";
               //each sirve para recorrer los elementos de una lista
              $.each(data,function(key,value){   
              select = select + "<option value=" +value[0]+ ">" +value[1]+"</option>"; //  va 1 ya que es el nombre  por que a si se puso en RolController.php en el metdo
                  
              })
              if(tipoPersona == 1){ //SOLICITANTE
                $('#casa_edit').html(select);
              }else if (tipoPersona == 2){ //AVAL 1
                $('#casa_edit1').html(select);
              }else if (tipoPersona == 3){ //AVAL 2
                $('#casa_edit2').html(select);
              }else if (tipoPersona == 4){ //AVAL 3
                $('#casa_edit3').html(select);
              }
          }
      }
  });

}

function TiempoVivirEdit(idPersona, tipoPersona){

  $.ajax({
     data : { "idPersona" : idPersona},
      url:'../controller/EditarSolicitudController.php?operador=listar_tiempoVivir_select',
      type:'POST',
      beforeSend:function(){},
      success:function(respuesta){
          data = $.parseJSON(respuesta);
          if(data.length > 0){ //valida que existan datos

              select="";
               //each sirve para recorrer los elementos de una lista
              $.each(data,function(key,value){   
              select = select + "<option value=" +value[0]+ ">" +value[1]+"</option>"; //  va 1 ya que es el nombre  por que a si se puso en RolController.php en el metdo
                  
              })
              if(tipoPersona == 1){ //SOLICITANTE
                 $('#tiempoVivir_edit').html(select);
              }else if(tipoPersona == 2){ //AVAL1
                $('#tiempoVivir_edit1').html(select);
              }else if(tipoPersona == 3){ //AVAL2
                $('#tiempoVivir_edit2').html(select);
              } else if(tipoPersona == 4){ //AVAL3
                $('#tiempoVivir_edit3').html(select);
              } 

          }
      }
  });

}

function FormaPagoEdit(idPersona, tipoPersona){

  $.ajax({
     data : { "idPersona" : idPersona},
      url:'../controller/EditarSolicitudController.php?operador=listar_formaPago_select',
      type:'POST',
      beforeSend:function(){},
      success:function(respuesta){
          data = $.parseJSON(respuesta);
          if(data.length > 0){ //valida que existan datos

              select="";
               //each sirve para recorrer los elementos de una lista
              $.each(data,function(key,value){   
              select = select + "<option value=" +value[0]+ ">" +value[1]+"</option>"; //  va 1 ya que es el nombre  por que a si se puso en RolController.php en el metdo
                  
              })

              if(tipoPersona == 1){ //SOLICITANTE
                $('#formaPago_edit').html(select);
              }else if(tipoPersona == 2){ //AVAL1
                $('#pagaAlquiler_edit1').html(select);
              }else if(tipoPersona == 3){ //AVAL2
                $('#pagaAlquiler_edit2').html(select);
              }else if(tipoPersona == 4){ //AVAL3
                $('#pagaAlquiler_edit3').html(select);
              }   
          }
      }
  });

}

function GeneroEdit(idPersona, tipoPersona){

  $.ajax({
     data : { "idPersona" : idPersona},
      url:'../controller/EditarSolicitudController.php?operador=listar_genero_select',
      type:'POST',
      beforeSend:function(){},
      success:function(respuesta){
          data = $.parseJSON(respuesta);
          if(data.length > 0){ //valida que existan datos

              select="";
               //each sirve para recorrer los elementos de una lista
              $.each(data,function(key,value){   
              select = select + "<option value=" +value[0]+ ">" +value[1]+"</option>"; //  va 1 ya que es el nombre  por que a si se puso en RolController.php en el metdo
                  
              })

              if(tipoPersona == 1){//solicitante
                $('#idGeneroCliente_edit').html(select);
              }else if(tipoPersona == 2){ //ParejSolicitante
                $('#generoPareja_edit').html(select); 
              }else if(tipoPersona == 3){ //Aval1
                $('#idGeneroAval_edit1').html(select); 
              }else if(tipoPersona == 4){ //ParejaAval 1
                $('#generoParejaAval1').html(select); 
              }else if(tipoPersona == 5){ //AVAL2
                $('#idGeneroAval_edit2').html(select); 
              }else if(tipoPersona == 6){ //ParejaAval 2
                $('#generoParejaAval2').html(select); 
              }else if(tipoPersona == 7){ //AVAL3
                $('#idGeneroAval_edit3').html(select); 
              }else if(tipoPersona == 8){ //ParejaAval 3
                $('#generoParejaAval3').html(select); 
              }
               
          }
      }
  });

}

function ProfesionEdit(idPersona, tipoPersona){

  $.ajax({
     data : { "idPersona" : idPersona},
      url:'../controller/EditarSolicitudController.php?operador=listar_profesion_select',
      type:'POST',
      beforeSend:function(){},
      success:function(respuesta){
          data = $.parseJSON(respuesta);
          if(data.length > 0){ //valida que existan datos

              select="";
               //each sirve para recorrer los elementos de una lista
              $.each(data,function(key,value){   
              select = select + "<option value=" +value[0]+ ">" +value[1]+"</option>"; //  va 1 ya que es el nombre  por que a si se puso en RolController.php en el metdo
                  
              })

              if(tipoPersona == 1){ //SOLICITANTE
                $('#profesiones_edit').html(select);
              }else if(tipoPersona == 2){ //pareja del solicitante
                $('#profesionPareja_edit').html(select);
              }else if(tipoPersona == 3){ //AVAL1
                $('#profesiones_edit1').html(select);
              }else if(tipoPersona == 4){ //Pareja del aval 1
                $('#profesionParejaAval1').html(select);
              }else if(tipoPersona == 5){ //AVAL2
                $('#profesiones_edit2').html(select);
              }else if(tipoPersona == 6){ //Pareja del aval 2
                $('#profesionParejaAval2').html(select);
              }else if(tipoPersona == 7){ //AVAL3
                $('#profesiones_edit3').html(select);
              }else if(tipoPersona == 8){ //Pareja del aval 3
                $('#profesionParejaAval3').html(select);
              }
              
             
                   
          }
      }
  });

}

function TiempoLaboralEdit(idPersona, tipoPersona){

  $.ajax({
     data : { "idPersona" : idPersona},
      url:'../controller/EditarSolicitudController.php?operador=listar_tiempoLaboral_select',
      type:'POST',
      beforeSend:function(){},
      success:function(respuesta){
          data = $.parseJSON(respuesta);
          if(data.length > 0){ //valida que existan datos

              select="";
               //each sirve para recorrer los elementos de una lista
              $.each(data,function(key,value){   
              select = select + "<option value=" +value[0]+ ">" +value[1]+"</option>"; //  va 1 ya que es el nombre  por que a si se puso en RolController.php en el metdo
                  
              })

              if(tipoPersona == 1){//SOLICITANTE
                $('#tiempoLaboral_edit').html(select);
              }else if(tipoPersona == 2){//Pareja del solicitante
                $('#tiempoLaboralPareja_edit').html(select);
              }else if(tipoPersona == 3){ //AVAL1
                $('#tiempoLaboral_edit1').html(select);
              }else if(tipoPersona == 4){ //PAREJA AVAL1
                $('#tiempoLaboralParejaAval1').html(select);
              }else if(tipoPersona == 5){ //AVAL2
                $('#tiempoLaboral_edit2').html(select);
              }else if(tipoPersona == 6){ //PAREJA AVAL 2
                $('#tiempoLaboralParejaAval2').html(select);
              }else if(tipoPersona == 7){ //AVAL3
                $('#tiempoLaboral_edit3').html(select);
              }else if(tipoPersona == 8){ //PAREJA AVAL 3
                $('#tiempoLaboralParejaAval3').html(select);
              }
              
              
          }
      }
  });

}

function TipoCreditoEdit(idPersona, tipoPersona){

  $.ajax({
     data : { "idPersona" : idPersona},
      url:'../controller/EditarSolicitudController.php?operador=listar_tipoCredito_select',
      type:'POST',
      beforeSend:function(){},
      success:function(respuesta){
          data = $.parseJSON(respuesta);
          if(data.length > 0){ //valida que existan datos

              select="";
               //each sirve para recorrer los elementos de una lista
              $.each(data,function(key,value){   
              select = select + "<option value=" +value[0]+ ">" +value[1]+"</option>"; //  va 1 ya que es el nombre  por que a si se puso en RolController.php en el metdo
                  
              })
              if(tipoPersona == 1){ //SOLICITANTE
                $('#tipoCliente_edit').html(select);
              }else if(tipoPersona == 2){//Pareja Solicitante
                $('#tipoClientePareja_edit').html(select);
              }else if(tipoPersona == 3){//AVAL1
                $('#tipoClienteAval_edit1').html(select);
              }else if(tipoPersona == 4){//Pareja Aval1
                $('#tipoClienteParejaAval1').html(select);
              }else if(tipoPersona == 5){//AVAL2
                $('#tipoClienteAval_edit2').html(select);
              }else if(tipoPersona == 6){//PAREJA DEL AVAL 2
                $('#tipoClienteParejaAval2').html(select);
              }else if(tipoPersona == 7){//AVAL3
                $('#tipoClienteAval_edit3').html(select);
              }else if(tipoPersona == 8){//PAREJA DEL AVAL 3
                $('#tipoClienteParejaAval3').html(select);
              }

              
              
                   
          }
      }
  });

}

function EstadoCreditoEdit(idPersona, tipoPersona){

  $.ajax({
     data : { "idPersona" : idPersona},
      url:'../controller/EditarSolicitudController.php?operador=listar_estadoCredito_select',
      type:'POST',
      beforeSend:function(){},
      success:function(respuesta){
          data = $.parseJSON(respuesta);
          if(data.length > 0){ //valida que existan datos

              select="";
               //each sirve para recorrer los elementos de una lista
              $.each(data,function(key,value){   
              select = select + "<option value=" +value[0]+ ">" +value[1]+"</option>"; //  va 1 ya que es el nombre  por que a si se puso en RolController.php en el metdo
                  
              })

              if(tipoPersona == 1){ //SOLICITANTE
                $('#estadoCreditoCliente_edit').html(select);
              }else if(tipoPersona == 2){//PAREJA DEL SOLICITANTE
                $('#estadoCreditoPareja_edit').html(select);
              }else if(tipoPersona == 3){//AVAL1
                $('#estadoCreditoAval_edit1').html(select);
              }else if(tipoPersona == 4){//PAREJA AVAL1
                $('#estadoCreditoParejaAVAL1').html(select);
              }else if(tipoPersona == 5){//AVAL2
                $('#estadoCreditoAval_edit2').html(select);
              }else if(tipoPersona == 6){//pareja del aval 2
                $('#estadoCreditoParejaAVAL2').html(select);
              }else if(tipoPersona == 7){//AVAL3
                $('#estadoCreditoAval_edit3').html(select);
              }else if(tipoPersona == 8){//pareja del aval 3
                $('#estadoCreditoParejaAVAL3').html(select);
              }
             
               
          }
      }
  });

}

function EsAval(idPersona, tipoPersona){

  $.ajax({
     data : { "idPersona" : idPersona},
      url:'../controller/EditarSolicitudController.php?operador=listar_esAval_select',
      type:'POST',
      beforeSend:function(){},
      success:function(respuesta){
          data = $.parseJSON(respuesta);
          if(data.length > 0){ //valida que existan datos

              select="";
               //each sirve para recorrer los elementos de una lista
              $.each(data,function(key,value){   
              select = select + "<option value=" +value[0]+ ">" +value[1]+"</option>"; //  va 1 ya que es el nombre  por que a si se puso en RolController.php en el metdo
                  
              })

              if(tipoPersona == 1){ //SOLICITANTE
                $('#esAvalCliente_edit').html(select);
              }else if(tipoPersona == 2){//PAREJA DEL SOLICITANTE
                $('#esAvalPareja_edit').html(select);
              }else if(tipoPersona == 3){//AVAL1
                $('#esAval_edit1').html(select);
              }else if(tipoPersona == 4){//PAREJA DEL AVAL1
                $('#esAvalParejaAVAL1').html(select);
              }else if(tipoPersona == 5){//AVAL2
                $('#esAval_edit2').html(select);
              }else if(tipoPersona == 6){//PAREJA DEL AVAL 2
                $('#esAvalParejaAVAL2').html(select);
              }else if(tipoPersona == 7){//AVAL3
                $('#esAval_edit3').html(select);
              }else if(tipoPersona == 8){//PAREJA DEL AVAL 3
                $('#esAvalParejaAVAL3').html(select);
              }
             
              
                   
          }
      }
  });

}
 
function AvalesMora(idPersona, tipoPersona){

  $.ajax({
     data : { "idPersona" : idPersona},
      url:'../controller/EditarSolicitudController.php?operador=listar_avalesMora_select',
      type:'POST',
      beforeSend:function(){},
      success:function(respuesta){
          data = $.parseJSON(respuesta);
          if(data.length > 0){ //valida que existan datos

              select="";
               //each sirve para recorrer los elementos de una lista
              $.each(data,function(key,value){   
              select = select + "<option value=" +value[0]+ ">" +value[1]+"</option>"; //  va 1 ya que es el nombre  por que a si se puso en RolController.php en el metdo
                  
              })

              if(tipoPersona == 1){ //SOLICITANTE
                $('#avalMoraCliente_edit').html(select);
              }else if(tipoPersona == 2){//PAREJA SOLICITANTE
                $('#avalMoraPareja_edit').html(select);
              }else if(tipoPersona == 3){//AVAL1
                $('#avalMoraAval_edit1').html(select);
              }else if(tipoPersona == 4){//PAREJA DEL AVAL1
                $('#avalMoraParejaAVAL1').html(select);
              }else if(tipoPersona == 5){//AVAL2
                $('#avalMoraAval_edit2').html(select);
              }else if(tipoPersona == 6){//PAREJA DEL AVAL 2
                $('#avalMoraParejaAVAL2').html(select);
              }else if(tipoPersona == 7){//AVAL3
                $('#avalMoraAval_edit3').html(select);
              }else if(tipoPersona == 8){//PAREJA DEL AVAL 3
                $('#avalMoraParejaAVAL3').html(select);
              }
             
              
                   
          }
      }
  });

}

function Municipios(idPersona, tipoPersona){

  $.ajax({
     data : { "idPersona" : idPersona},
      url:'../controller/EditarSolicitudController.php?operador=listar_municipio_select',
      type:'POST',
      beforeSend:function(){},
      success:function(respuesta){
          data = $.parseJSON(respuesta);
          if(data.length > 0){ //valida que existan datos

              select="";
               //each sirve para recorrer los elementos de una lista
              $.each(data,function(key,value){   
              select = select + "<option value=" +value[0]+ ">" +value[1]+"</option>"; //  va 1 ya que es el nombre  por que a si se puso en RolController.php en el metdo
                  
              })

              if(tipoPersona == 1){ //SOLICITANTE
                $('#municipio_edit').html(select);
              }else if(tipoPersona == 2){//PAREJA SOLICITANTE
                $('#municipioPareja_edit').html(select);
              }else if(tipoPersona == 3){//AVAL1
                $('#municipio_edit1').html(select);
              }else if(tipoPersona == 4){//PAREJA DEL AVAL1
                $('#municipioParejaAval1').html(select);
              }else if(tipoPersona == 5){//AVAL2
                $('#municipio_edit2').html(select);
              }else if(tipoPersona == 6){//PAREJA DEL AVAL 2
                $('#municipioParejaAval2').html(select);
              }else if(tipoPersona == 7){//AVAL3
                $('#municipio_edit3').html(select);
              }else if(tipoPersona == 8){//PAREJA DEL AVAL 3
                $('#municipioParejaAval3').html(select);
              }
             
              
                   
          }
      }
  });

}

function ListarPersonaBienes(idPersona){

  $.ajax({
     data : { "idPersona" : idPersona},
      url:'../controller/EditarSolicitudController.php?operador=listar_persona_bienes',
      type:'POST',
      beforeSend:function(){},
      success:function(respuesta){
          data = $.parseJSON(respuesta);
          if(data.length > 0){ //valida que existan datos
            
              select="";
               //each sirve para recorrer los elementos de una lista
              $.each(data,function(key,value){   
              select = select + "<option value=" +value[0]+ ">" +value[1]+"</option>";

              })
              $('#bienes').html(select);
             
          }
      }
  });

}

function AnalisisCrediticio(idPersona){

  $.ajax({
     data : { "idPersona" : idPersona},
      url:'../controller/EditarSolicitudController.php?operador=analisis_crediticio',
      type:'POST',
      beforeSend:function(){},
      success:function(response){
       // console.log(response); 
       data = $.parseJSON(response);
          if(data.length > 0){ //valida que existan datos
            //cliente
            $('#cuota_edit').val(data[0]['cuotaPrestamoAdepes']);
            $('#ingresosPorNegocio_edit').val(data[0]['ingresosNegocio']);
            $('#sueldoBase_edit').val(data[0]['sueldoBase']);
            $('#gastosAlimentacion_edit').val(data[0]['alimentacion']);
            $('#pagoCasa_edit').val(data[0]['cuotaVivienda']);
            //analisis 
            $('#sueldoBase_analisis').val(data[0]['sueldoBase']);
            $('#ingresosNegocio').val(data[0]['ingresosNegocio']);
            $('#renta').val(data[0]['rentaPropiedad']);
            $('#remesas').val(data[0]['remesas']);
            $('#aporteConyuge').val(data[0]['aporteConyugue']);
            $('#sociedad').val(data[0]['ingresosSociedad']);
            $('#cuotaAdepes').val(data[0]['cuotaPrestamoAdepes']);
            $('#vivienda').val(data[0]['cuotaVivienda']);
            $('#alimentacion').val(data[0]['alimentacion']);
            $('#centralRiesgo').val(data[0]['deduccionesCentralRiesgo']);
            $('#otrosEgresos').val(data[0]['otrosEgresos']);
            sumarIngresosEgresos();
            

          if(data.length > 1){ //AVAL 1
            $('#cuota_aval1').val(data[1]['cuotaPrestamoAdepes']);
            $('#ingresosPorNegocio_aval1').val(data[1]['ingresosNegocio']);
            $('#sueldoBase_aval1').val(data[1]['sueldoBase']);
            $('#gastosAlimentacion_aval1').val(data[1]['alimentacion']);
            $('#pagoCasa_aval1').val(data[1]['cuotaVivienda']);
            //analisis 
            $('#sueldoBase_analisisAval1').val(data[1]['sueldoBase']);
            $('#ingresosNegocioAval1').val(data[1]['ingresosNegocio']);
            $('#rentaAval1').val(data[1]['rentaPropiedad']);
            $('#remesasAval1').val(data[1]['remesas']);
            $('#aporteConyugeAval1').val(data[1]['aporteConyugue']);
            $('#sociedadAval1').val(data[1]['ingresosSociedad']);
            $('#cuotaAdepesAval1').val(data[1]['cuotaPrestamoAdepes']);
            $('#viviendaAval1').val(data[1]['cuotaVivienda']);
            $('#alimentacionAval1').val(data[1]['alimentacion']);
            $('#centralRiesgoAval1').val(data[1]['deduccionesCentralRiesgo']);
            $('#otrosEgresosAval1').val(data[1]['otrosEgresos']);
            sumarIngresosEgresosAval1();
          }
           
          if(data.length > 2){ //AVAL 2
            $('#cuota_aval2').val(data[2]['cuotaPrestamoAdepes']);
            $('#ingresosPorNegocio_aval2').val(data[2]['ingresosNegocio']);
            $('#sueldoBase_aval2').val(data[2]['sueldoBase']);
            $('#gastosAlimentacion_aval2').val(data[2]['alimentacion']);
            $('#pagoCasa_aval2').val(data[2]['cuotaVivienda']);
             //analisis 
             $('#sueldoBase_analisisAval2').val(data[2]['sueldoBase']);
             $('#ingresosNegocioAval2').val(data[2]['ingresosNegocio']);
             $('#rentaAval2').val(data[2]['rentaPropiedad']);
             $('#remesasAval2').val(data[2]['remesas']);
             $('#aporteConyugeAval2').val(data[2]['aporteConyugue']);
             $('#sociedadAval2').val(data[2]['ingresosSociedad']);
             $('#cuotaAdepesAval2').val(data[2]['cuotaPrestamoAdepes']);
             $('#viviendaAval2').val(data[2]['cuotaVivienda']);
             $('#alimentacionAval2').val(data[2]['alimentacion']);
             $('#centralRiesgoAval2').val(data[2]['deduccionesCentralRiesgo']);
             $('#otrosEgresosAval2').val(data[2]['otrosEgresos']);
             sumarIngresosEgresosAval2();
          }

          if(data.length > 3){ //AVAL 3
            $('#cuota_aval3').val(data[3]['cuotaPrestamoAdepes']);
            $('#ingresosPorNegocio_aval3').val(data[3]['ingresosNegocio']);
            $('#sueldoBase_aval3').val(data[3]['sueldoBase']);
            $('#gastosAlimentacion_aval3').val(data[3]['alimentacion']);
            $('#pagoCasa_aval3').val(data[3]['cuotaVivienda']);
            //analisis 
            $('#sueldoBase_analisisAval3').val(data[3]['sueldoBase']);
            $('#ingresosNegocioAval3').val(data[3]['ingresosNegocio']);
            $('#rentaAval3').val(data[3]['rentaPropiedad']);
            $('#remesasAval3').val(data[3]['remesas']);
            $('#aporteConyugeAval3').val(data[3]['aporteConyugue']);
            $('#sociedadAval3').val(data[3]['ingresosSociedad']);
            $('#cuotaAdepesAval3').val(data[3]['cuotaPrestamoAdepes']);
            $('#viviendaAval3').val(data[3]['cuotaVivienda']);
            $('#alimentacionAval3').val(data[3]['alimentacion']);
            $('#centralRiesgoAval3').val(data[3]['deduccionesCentralRiesgo']);
            $('#otrosEgresosAval3').val(data[3]['otrosEgresos']);
            sumarIngresosEgresosAval3();
          } 
            
           
                   
          }
      }
  });

}

function ReferenciasFamiliares(idPersona, tipoPersona){

    $.ajax({
       data : { "idPersona" : idPersona},
        url:'../controller/EditarSolicitudController.php?operador=referencias_familiares',
        type:'POST',
        beforeSend:function(){},
        success:function(response){
        //console.log(response); 
        data = $.parseJSON(response);
            if(data.length > 0){ //valida que existan datos
              if(tipoPersona == 1 ){ //Solicitante
                $('#nombreR1_edit').val(data[0]['nombre']);
                $('#celularR1_edit').val(data[0]['celular']);
                $('#direccionR1_edit').val(data[0]['direccion']);
                ParentescoReferencias(data[0]['idReferencia'], 1);
                $('#nombreR2_edit').val(data[1]['nombre']);
                $('#celularR2_edit').val(data[1]['celular']);
                $('#direccionR2_edit').val(data[1]['direccion']);
                ParentescoReferencias(data[1]['idReferencia'], 2);
              }else if(tipoPersona == 2){//AVAL1
                $('#nombreR1_aval').val(data[0]['nombre']);
                $('#celularR1aval').val(data[0]['celular']);
                $('#direccionR1aval').val(data[0]['direccion']);
                ParentescoReferencias(data[0]['idReferencia'], 3);
                $('#nombreR2aval1').val(data[1]['nombre']);
                $('#celularR2aval1').val(data[1]['celular']);
                $('#direccionR2aval1').val(data[1]['direccion']);
                ParentescoReferencias(data[1]['idReferencia'], 4);

              }else if(tipoPersona == 3){//AVAL2
                $('#nombreR1_aval2').val(data[0]['nombre']);
                $('#celularR1aval2').val(data[0]['celular']);
                $('#direccionR1aval2').val(data[0]['direccion']);
                ParentescoReferencias(data[0]['idReferencia'], 5);
                $('#nombreR2aval2').val(data[1]['nombre']);
                $('#celularR2aval2').val(data[1]['celular']);
                $('#direccionR2aval2').val(data[1]['direccion']);
                ParentescoReferencias(data[1]['idReferencia'], 6);
              }else if(tipoPersona == 4){//AVAL3
                $('#nombreR1_aval3').val(data[0]['nombre']);
                $('#celularR1aval3').val(data[0]['celular']);
                $('#direccionR1aval3').val(data[0]['direccion']);
                ParentescoReferencias(data[0]['idReferencia'], 7);
                $('#nombreR2aval3').val(data[1]['nombre']);
                $('#celularR2aval3').val(data[1]['celular']);
                $('#direccionR2aval3').val(data[1]['direccion']);
                ParentescoReferencias(data[1]['idReferencia'], 8);
              }

                     
            }
        }
    });
  
  }

  function ParentescoReferencias(idReferencia, numero){

    $.ajax({
       data : { "idReferencia" : idReferencia},
        url:'../controller/EditarSolicitudController.php?operador=listar_parentesco_select',
        type:'POST',
        beforeSend:function(){},
        success:function(respuesta){
            data = $.parseJSON(respuesta);
            if(data.length > 0){ //valida que existan datos
  
                select="";
                 //each sirve para recorrer los elementos de una lista
                $.each(data,function(key,value){   
                select = select + "<option value=" +value[0]+ ">" +value[1]+"</option>"; //  va 1 ya que es el nombre  por que a si se puso en RolController.php en el metdo
                    
                })
                if(numero==1){ //referencia 1 del solicitante 
                    $('#parestencosR1_edit').html(select); 
                }else if(numero == 2){//referencia 2 del solicitante 
                    $('#parestencosR2_edit').html(select); 
                }else if(numero == 3){//referencia 1 del AVAL1 
                  $('#parestencosR1aval1').html(select); 
                }else if(numero == 4){//referencia 2 del AVAL1 
                  $('#parestencosR2aval1').html(select); 
                }else if(numero == 5){//referencia 1 del AVAL2
                  $('#parestencosR1aval2').html(select); 
                }else if(numero == 6){//referencia 2 del AVAL2
                  $('#parestencosR2aval2').html(select); 
                }else if(numero == 7){//referencia 1 del AVAL3
                  $('#parestencosR1aval3').html(select); 
                }else if(numero == 8){//referencia 2 del AVAL3
                  $('#parestencosR2aval3').html(select); 
                }

            }
        }
    });
  
  }
 

function Conyugue(idPersona, tipoPareja){

  $.ajax({
     data : { "idPersonaPareja" : idPersona},
      url:'../controller/EditarSolicitudController.php?operador=conyugue',
      type:'POST',
      beforeSend:function(){},
      success:function(response){
        //console.log(response); 
       data = $.parseJSON(response);
          if(data.length > 0){ //valida que existan datos

            if(tipoPareja == 1){ //pareja del solicitante
              $('#idPareja').val(data[0]['IDPERSONA']);
              $('#ingresoNegocioPareja_edit').val(data[0]['INGRESOS']);
              $('#sueldoBasePareja_edit').val(data[0]['SUELDO']);
              $('#gastoAlimentacionPareja_edit').val(data[0]['ALIMENTACION']);
              $('#nombresPareja_edit').val(data[0]['NOMBRE']);
              $('#apellidosPareja_edit').val(data[0]['APELLIDO']);
              $('#identidadPareja_edit').val(data[0]['IDENTIDAD']);
              $('#fechaNacimientoPareja_edit').val(data[0]['NACIMIENTO']);
              $('#patronoPareja_edit').val(data[0]['PATRONO']);
              $('#actividadPareja_edit').val(data[0]['CARGO']);
              ContactosEdit(data[0]['IDPERSONA'], 1,0); //1 de pareja del solicitante
              GeneroEdit(data[0]['IDPERSONA'], 2);
              ProfesionEdit(data[0]['IDPERSONA'], 2);
              TiempoLaboralEdit(data[0]['IDPERSONA'], 2);
              TipoCreditoEdit(data[0]['IDPERSONA'], 2);
              EstadoCreditoEdit(data[0]['IDPERSONA'], 2);
              EsAval(data[0]['IDPERSONA'], 2);
              AvalesMora(data[0]['IDPERSONA'], 2);
              PersonasCuenta(data[0]['IDPERSONA'], 2);
              Municipios(data[0]['IDPERSONA'], 2);
              //FORMATO CONOZCO A SU CLIENTE
              $('#NombreConyugueFormato').val(data[0]['NOMBRE']+" "+data[0]['APELLIDO']);

            }else if(tipoPareja == 2){ //pareja del aval 1
              $('#idParejaval1').val(data[0]['IDPERSONA']);
              $('#ingresoNegocioParejaAval1').val(data[0]['INGRESOS']);
              $('#sueldoBaseParejaAval1').val(data[0]['SUELDO']);
              $('#gastoAlimentacionParejaAval1').val(data[0]['ALIMENTACION']);
              $('#nombresParejaAval1').val(data[0]['NOMBRE']);
              $('#apellidosParejaAval1').val(data[0]['APELLIDO']);
              $('#identidadParejaAval1').val(data[0]['IDENTIDAD']);
              $('#fechaNacimientoParejaAval1').val(data[0]['NACIMIENTO']);
              $('#patronoParejaAval1').val(data[0]['PATRONO']);
              $('#actividadParejaAval1').val(data[0]['CARGO']);
              ContactosEdit(data[0]['IDPERSONA'], 2, 0); //2 de pareja del aval 1
              GeneroEdit(data[0]['IDPERSONA'], 4);
              ProfesionEdit(data[0]['IDPERSONA'], 4);
              TiempoLaboralEdit(data[0]['IDPERSONA'], 4);
              TipoCreditoEdit(data[0]['IDPERSONA'], 4);
              EstadoCreditoEdit(data[0]['IDPERSONA'], 4);
              EsAval(data[0]['IDPERSONA'], 4);
              AvalesMora(data[0]['IDPERSONA'], 4);
              PersonasCuenta(data[0]['IDPERSONA'], 4);
              Municipios(data[0]['IDPERSONA'], 4);

            }else if(tipoPareja == 3){ //pareja del aval 2
              $('#idParejaval2').val(data[0]['IDPERSONA']);
              $('#ingresoNegocioParejaAval2').val(data[0]['INGRESOS']);
              $('#sueldoBaseParejaAval2').val(data[0]['SUELDO']);
              $('#gastoAlimentacionParejaAval2').val(data[0]['ALIMENTACION']);
              $('#nombresParejaAval2').val(data[0]['NOMBRE']);
              $('#apellidosParejaAval2').val(data[0]['APELLIDO']);
              $('#identidadParejaAval2').val(data[0]['IDENTIDAD']);
              $('#fechaNacimientoParejaAval2').val(data[0]['NACIMIENTO']);
              $('#patronoParejaAval2').val(data[0]['PATRONO']);
              $('#actividadParejaAval2').val(data[0]['CARGO']);
              ContactosEdit(data[0]['IDPERSONA'], 3, 0); //3 de pareja del aval 2
              GeneroEdit(data[0]['IDPERSONA'], 6);
              ProfesionEdit(data[0]['IDPERSONA'], 6);
              TiempoLaboralEdit(data[0]['IDPERSONA'], 6);
              TipoCreditoEdit(data[0]['IDPERSONA'], 6);
              EstadoCreditoEdit(data[0]['IDPERSONA'], 6);
              EsAval(data[0]['IDPERSONA'], 6);
              AvalesMora(data[0]['IDPERSONA'], 6);
              PersonasCuenta(data[0]['IDPERSONA'], 6);
              Municipios(data[0]['IDPERSONA'], 6);

            }else if(tipoPareja == 4){ //PAREJA DEL AVAL 3
              $('#idParejaval3').val(data[0]['IDPERSONA']);
              $('#ingresoNegocioParejaAval3').val(data[0]['INGRESOS']);
              $('#sueldoBaseParejaAval3').val(data[0]['SUELDO']);
              $('#gastoAlimentacionParejaAval3').val(data[0]['ALIMENTACION']);
              $('#nombresParejaAval3').val(data[0]['NOMBRE']);
              $('#apellidosParejaAval3').val(data[0]['APELLIDO']);
              $('#identidadParejaAval3').val(data[0]['IDENTIDAD']);
              $('#fechaNacimientoParejaAval3').val(data[0]['NACIMIENTO']);
              $('#patronoParejaAval3').val(data[0]['PATRONO']);
              $('#actividadParejaAval3').val(data[0]['CARGO']);
              ContactosEdit(data[0]['IDPERSONA'], 4, 0); //4 de pareja del aval 
              GeneroEdit(data[0]['IDPERSONA'], 8);
              ProfesionEdit(data[0]['IDPERSONA'], 8);
              TiempoLaboralEdit(data[0]['IDPERSONA'], 8);
              TipoCreditoEdit(data[0]['IDPERSONA'], 8);
              EstadoCreditoEdit(data[0]['IDPERSONA'], 8);
              EsAval(data[0]['IDPERSONA'], 8);
              AvalesMora(data[0]['IDPERSONA'], 8);
              PersonasCuenta(data[0]['IDPERSONA'], 8);
              Municipios(data[0]['IDPERSONA'], 8);
            }
            
          }
      }
  });

}

function PersonaDependientes(idPersona){ //personas dependientes y observaciones de la solicitud

    $.ajax({
       data : { "idPersona" : idPersona},
        url:'../controller/EditarSolicitudController.php?operador=personas_dependientes',
        type:'POST',
        beforeSend:function(){},
        success:function(response){
         data = $.parseJSON(response);
            if(data.length > 0){ //valida que existan datos
              $('#observaciones_edit').val(data[0]['observaciones']);
              $('#dependientes_edit').val(data[0]['nombreDependiente']);
              //FORMATO CONOZCA A SU CLIENTE
              $('#DependienteFormato').val(data[0]['nombreDependiente']);
                  
            }
        }
    });
  
  }



/*  ****************************                      AVALES SOLICITUD    **************************************** */

function DatosAvales(idSolicitud){
  $.ajax({
    data: { "idSolicitud": idSolicitud },
    url: '../controller/EditarSolicitudController.php?operador=datos_avales',
    type: 'POST',
    beforeSend: function (){ },
    success: function (response){
      if(response){ // Verifica si la respuesta no está vacía
        try {
          var data = $.parseJSON(response); // Intenta analizar la respuesta como JSON
          if (data.length > 0){ // Valida que existan datos
              //AVAL SOLIDARIO 1
              $('#idAval1').val(data[0]['idPersona']);
              $('#nombresAval_edit1').val(data[0]['nombres']);
              $('#apellidosAval_edit1').val(data[0]['apellidos']);
              $('#identidadAval__edit1').val(data[0]['identidad']);
              $('#fechaNacimiento_edit1').val(data[0]['fechaNacimiento']);
              $('#patrono_edit1').val(data[0]['PratronoNegocio']);
              $('#actividadDesempeña_edit1').val(data[0]['cargoDesempena']);
              $('#observaciones_edit1').val(data[0]['ObservacionesSolicitud']);
              ContactosEdit(data[0]['idPersona'], 0, 1);
              NacionalidadSelectEdit(data[0]['idPersona'], 2);
              EstadoCivilSelectEdit(data[0]['idPersona'], 2)
              CasaSelectEdit(data[0]['idPersona'], 2);
              TiempoVivirEdit(data[0]['idPersona'], 2);
              FormaPagoEdit(data[0]['idPersona'], 2);
              GeneroEdit(data[0]['idPersona'], 3);
              ProfesionEdit(data[0]['idPersona'], 3);
              TiempoLaboralEdit(data[0]['idPersona'], 3);
              TipoCreditoEdit(data[0]['idPersona'], 3);
              EstadoCreditoEdit(data[0]['idPersona'], 3);
              EsAval(data[0]['idPersona'], 3);
              AvalesMora(data[0]['idPersona'], 3);
              Municipios(data[0]['idPersona'], 3);
              PersonasCuenta(data[0]['idPersona'], 3)
              ReferenciasFamiliares(data[0]['idPersona'], 2);
              ReferenciasComerciales(data[0]['idPersona'], 1);
              //CENTRAL RIESGO
              $('#nombreAval1Central').val(data[0]['nombres']+" "+data[0]['apellidos']);
              $('#identidadAval1Central').val(data[0]['identidad']);
              
              //AVAL SOLIDARIO 2
              if (data.length > 1){
                $('#idPersonaAval2').val(data[1]['idPersona']);
                $('#nombresAval_edit2').val(data[1]['nombres']);
                $('#apellidosAval_edit2').val(data[1]['apellidos']);
                $('#identidadAval__edit2').val(data[1]['identidad']);
                $('#fechaNacimiento_edit2').val(data[1]['fechaNacimiento']);
                $('#patrono_edit2').val(data[1]['PratronoNegocio']);
                $('#actividadDesempeña_edit2').val(data[1]['cargoDesempena']);
                $('#observaciones_edit2').val(data[1]['ObservacionesSolicitud']);
                ContactosEdit(data[1]['idPersona'], 0, 2);
                NacionalidadSelectEdit(data[1]['idPersona'], 3);
                EstadoCivilSelectEdit(data[1]['idPersona'], 3)
                CasaSelectEdit(data[1]['idPersona'], 3);
                TiempoVivirEdit(data[1]['idPersona'], 3);
                FormaPagoEdit(data[1]['idPersona'], 3);
                GeneroEdit(data[1]['idPersona'], 5);
                ProfesionEdit(data[1]['idPersona'], 5);
                TiempoLaboralEdit(data[1]['idPersona'], 5);
                TipoCreditoEdit(data[1]['idPersona'], 5);
                EstadoCreditoEdit(data[1]['idPersona'], 5);
                EsAval(data[1]['idPersona'], 5);
                AvalesMora(data[1]['idPersona'], 5);
                Municipios(data[1]['idPersona'], 5);
                ReferenciasFamiliares(data[1]['idPersona'], 3);
                ReferenciasComerciales(data[1]['idPersona'], 2);
                PersonasCuenta(data[1]['idPersona'], 5)
                //CENTRAL RIESGO
                $('#nombreAval2Central').val(data[1]['nombres']+" "+data[1]['apellidos']);
                $('#identidadAval2Central').val(data[1]['identidad']);
              }

             //AVAL SOLIDARIO 3
              if(data.length > 2){
                $('#idPersonaAval3').val(data[2]['idPersona']);
                $('#nombresAval_edit3').val(data[2]['nombres']);
                $('#apellidosAval_edit3').val(data[2]['apellidos']);
                $('#identidadAval_edit3').val(data[2]['identidad']);
                $('#fechaNacimiento_edit3').val(data[2]['fechaNacimiento']);
                $('#patrono_edit3').val(data[2]['PratronoNegocio']);
                $('#actividadDesempeña_edit3').val(data[2]['cargoDesempena']);
                $('#observaciones_edit3').val(data[2]['ObservacionesSolicitud']);
                ContactosEdit(data[2]['idPersona'], 0, 3);
                NacionalidadSelectEdit(data[2]['idPersona'], 4);
                EstadoCivilSelectEdit(data[2]['idPersona'], 4)
                CasaSelectEdit(data[2]['idPersona'], 4);
                TiempoVivirEdit(data[2]['idPersona'], 4);
                FormaPagoEdit(data[2]['idPersona'], 4);
                GeneroEdit(data[2]['idPersona'], 7);
                ProfesionEdit(data[2]['idPersona'], 7);
                TiempoLaboralEdit(data[2]['idPersona'], 7);
                TipoCreditoEdit(data[2]['idPersona'], 7);
                EstadoCreditoEdit(data[2]['idPersona'], 7);
                EsAval(data[2]['idPersona'], 7);
                AvalesMora(data[2]['idPersona'], 7);
                Municipios(data[2]['idPersona'], 7);
                ReferenciasFamiliares(data[2]['idPersona'], 4);
                ReferenciasComerciales(data[2]['idPersona'], 3);
                PersonasCuenta(data[2]['idPersona'], 7)
                //CENTRAL RIESGO
                $('#nombreAval3Central').val(data[2]['nombres']+" "+data[2]['apellidos']);
                $('#identidadAval3Central').val(data[2]['identidad']);

              }
             
              
          }else{
            console.log("La respuesta no contiene datos.");
          }
        }catch (error) {
          console.error("Error al analizar JSON:", error);
        }
      }else{
        console.log("No existen avales");
      }
    }
  });
}


function ReferenciasComerciales(idPersona, numeroAval){

  $.ajax({
     data : { "idPersona" : idPersona},
      url:'../controller/EditarSolicitudController.php?operador=referencias_comerciales',
      type:'POST',
      beforeSend:function(){},
      success:function(response){
      //console.log(response); 
      data = $.parseJSON(response);
          if(data.length > 0){ //valida que existan datos
            if(numeroAval == 1 ){ //Aval1
              $('#nombreComercial1AVAL1').val(data[0]['nombre']);
              $('#direccionComercial1AVAL1').val(data[0]['direccion']);
              $('#nombreComercial2AVAL1').val(data[1]['nombre']);
              $('#direccionComercial2AVAL1').val(data[1]['direccion']);
      
            }else if(numeroAval == 2){//AVAL2
              $('#nombreComercial1AVAL2').val(data[0]['nombre']);
              $('#direccionComercial1AVAL2').val(data[0]['direccion']);
              $('#nombreComercial2AVAL2').val(data[1]['nombre']);
              $('#direccionComercial2AVAL2').val(data[1]['direccion']);
            }else if(numeroAval == 3){//AVAL3
              $('#nombreComercial1AVAL3').val(data[0]['nombre']);
              $('#direccionComercial1AVAL3').val(data[0]['direccion']);
              $('#nombreComercial2AVAL3').val(data[1]['nombre']);
              $('#direccionComercial2AVAL3').val(data[1]['direccion']);
            }

                   
          }
      }
  });

}




function FormatoConozcaAsuCliente(idPersona){ //personas dependientes y observaciones de la solicitud

  $.ajax({
     data : { "idPersona" : idPersona},
      url:'../controller/EditarSolicitudController.php?operador=formato_conozca_asu_Cliente',
      type:'POST',
      beforeSend:function(){},
      success:function(response){
       data = $.parseJSON(response);
          if(data.length > 0){ //valida que existan datos
            $('#estadoCivilFormato').val(data[0]['civil']);
            $('#NacionalidadFormato').val(data[0]['nacionalidad']);
            $('#GeneroFormato').val(data[0]['genero']);
            $('#ProfesionFormato').val(data[0]['profesiones']);
            $('#BienesFormato').val(data[0]['bienesPersona']);
            $('#profesionFormato').val(data[0]['profesiones']);
            $('#municipioFormato').val(data[0]['municipio']);
            //Central Riesgo
            $('#estadoCivilClienteCentral').val(data[0]['civil']);
            //dictamen del asesor
            $('#dictamenEdit').val(data[0]['dictamenAsesor']);
          }
      }
  });

}

function DictamenAsesor(idPersona){  //dictamen del asesor y Comite de credito
  $.ajax({
      data: { "idPersona": idPersona },
      url:'../controller/SolicitudNuevaController.php?operador=dictamen_asesor', //url del controlador Conttroller
      type:'POST',
      beforeSend:function(){},
      success:function(response){
         // console.log(response);
          data = $.parseJSON(response);
         
          if(data.length > 0){
         
            $('#analisisDictamenEdit').val(data[0]['dictamen']);
            $('#cantidadPrestamosDictamen').val(data[0]['prestamoAprobados']);
            $('#dictamenAsesor').val(data[0]['dictamenAsesor']);
            //comite de credito
            $('#numeroActaedit').val(data[0]['numeroActa']);
            $('#estadoSolicitudComite').val(data[0]['estadoSolicitudComite']);
           
          }
         
      }

  });

}



function PersonasCuenta(idPersona, tipoPersona){ //personas dependientes y observaciones de la solicitud

  $.ajax({
     data : { "idPersona" : idPersona},
      url:'../controller/EditarSolicitudController.php?operador=persona_cuenta',
      type:'POST',
      beforeSend:function(){},
      success:function(response){
       data = $.parseJSON(response);
          if(data.length > 0){ //valida que existan datos

            if(tipoPersona == 1){ //cliente
              $('#cuentaCliente_edit').val(data[0]['NumeroCuenta']);
            }else if(tipoPersona == 2){ //pareja cliente
              $('#cuentaPareja').val(data[0]['NumeroCuenta']);
            }else if(tipoPersona == 3){ //Aval1
              $('#cuentaAval_avl1').val(data[0]['NumeroCuenta']);
            }else if(tipoPersona == 4){ //pareja aval1
              $('#cuentaParejaAval1').val(data[0]['NumeroCuenta']);
            }else if(tipoPersona == 5){ //Aval2
              $('#cuentaAval_aval2').val(data[0]['NumeroCuenta']);
            }else if(tipoPersona == 6){ //pareja aval2
              $('#cuentaParejaAval2').val(data[0]['NumeroCuenta']);
            }else if(tipoPersona == 7){ //Aval3
              $('#cuentaAval_aval3').val(data[0]['NumeroCuenta']);
            }else if(tipoPersona == 8){ //pareja aval3
              $('#cuentaParejaAval3').val(data[0]['NumeroCuenta']);
            }
            

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
  $('#TotalIngresosFormato').val(sumaIngresos.toFixed(2));
  //document.getElementById("TotalIngresosFormato").value = sumaIngresos.toFixed(2);  //para el formato conaca asu cliente
  var cuotaAdepes = parseFloat(document.getElementById("cuotaAdepes").value) || 0;
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

//sumaingresos e egresos analisis del aval 1
function sumarIngresosEgresosAval1() {
  var sueldoBase = parseFloat(document.getElementById("sueldoBase_analisisAval1").value) || 0;
  var ingresosNegocio = parseFloat(document.getElementById("ingresosNegocioAval1").value) || 0;
  var renta = parseFloat(document.getElementById("rentaAval1").value) || 0;
  var remesas = parseFloat(document.getElementById("remesasAval1").value) || 0;
  var aporteConyuge = parseFloat(document.getElementById("aporteConyugeAval1").value) || 0;
  var sociedad = parseFloat(document.getElementById("sociedadAval1").value) || 0;

  var sumaIngresos = sueldoBase+ ingresosNegocio + renta + remesas +aporteConyuge + sociedad;
  
  document.getElementById("totalIngresosAval1").value = sumaIngresos.toFixed(2);
  var cuotaAdepes = parseFloat(document.getElementById("cuotaAdepesAval1").value) || 0;
  var vivienda = parseFloat(document.getElementById("viviendaAval1").value) || 0;
  var alimentacion = parseFloat(document.getElementById("alimentacionAval1").value) || 0;
  var centralRiesgo = parseFloat(document.getElementById("centralRiesgoAval1").value) || 0;
  var otrosEgresos = parseFloat(document.getElementById("otrosEgresosAval1").value) || 0;
  

  var sumaEgresos =cuotaAdepes+ vivienda + alimentacion + centralRiesgo +otrosEgresos;
  
  document.getElementById("totalEgresosAval1").value = sumaEgresos.toFixed(2);
 
  //totales
  var IngresosNetos = sumaIngresos - sumaEgresos;
  document.getElementById("ingresosNetosAval1").value = IngresosNetos.toFixed(2);
 
  //capital disponible
  var cuotaAdepes2 = parseFloat(document.getElementById("cuotaMensualAval1").value) || 0;
  var capitalDisponible = IngresosNetos - cuotaAdepes2;
  document.getElementById("capitalDisponibleAval1").value = capitalDisponible.toFixed(2);
//evaluacion
  if(capitalDisponible > 0){
      document.getElementById('evaluacionAval1').value ="ESTA PERSONA TIENE CAPACIDAD DE PAGO, PARA SERVIR COMO AVAL SOLIDARIO";
  }else if(capitalDisponible < 0){
      document.getElementById('evaluacionAval1').value ="ESTA PERSONA NO TIENE CAPACIDAD DE PAGO, PARA SERVIR COMO AVAL SOLIDARIO";
  }else{
      document.getElementById('evaluacionAval1').value ="";
  }
  
//  var  = 


}

//sumaingresos e egresos analisis del aval 2
function sumarIngresosEgresosAval2() {
  var sueldoBase = parseFloat(document.getElementById("sueldoBase_analisisAval2").value) || 0;
  var ingresosNegocio = parseFloat(document.getElementById("ingresosNegocioAval2").value) || 0;
  var renta = parseFloat(document.getElementById("rentaAval2").value) || 0;
  var remesas = parseFloat(document.getElementById("remesasAval2").value) || 0;
  var aporteConyuge = parseFloat(document.getElementById("aporteConyugeAval2").value) || 0;
  var sociedad = parseFloat(document.getElementById("sociedadAval2").value) || 0;

  var sumaIngresos = sueldoBase+ ingresosNegocio + renta + remesas +aporteConyuge + sociedad;
  
  document.getElementById("totalIngresosAval2").value = sumaIngresos.toFixed(2);
  var cuotaAdepes = parseFloat(document.getElementById("cuotaAdepesAval2").value) || 0;
  var vivienda = parseFloat(document.getElementById("viviendaAval2").value) || 0;
  var alimentacion = parseFloat(document.getElementById("alimentacionAval2").value) || 0;
  var centralRiesgo = parseFloat(document.getElementById("centralRiesgoAval2").value) || 0;
  var otrosEgresos = parseFloat(document.getElementById("otrosEgresosAval2").value) || 0;
  

  var sumaEgresos =cuotaAdepes+ vivienda + alimentacion + centralRiesgo +otrosEgresos;
  
  document.getElementById("totalEgresosAval2").value = sumaEgresos.toFixed(2);
 
  //totales
  var IngresosNetos = sumaIngresos - sumaEgresos;
  document.getElementById("ingresosNetosAval2").value = IngresosNetos.toFixed(2);
 
  //capital disponible
  var cuotaAdepes2 = parseFloat(document.getElementById("cuotaMensualAval2").value) || 0;
  var capitalDisponible = IngresosNetos - cuotaAdepes2;
  document.getElementById("capitalDisponibleAval2").value = capitalDisponible.toFixed(2);
//evaluacion
  if(capitalDisponible > 0){
      document.getElementById('evaluacionAval2').value ="ESTA PERSONA TIENE CAPACIDAD DE PAGO, PARA SERVIR COMO AVAL SOLIDARIO";
  }else if(capitalDisponible < 0){
      document.getElementById('evaluacionAval2').value ="ESTA PERSONA NO TIENE CAPACIDAD DE PAGO, PARA SERVIR COMO AVAL SOLIDARIO";
  }else{
      document.getElementById('evaluacionAval2').value ="";
  }
  
//  var  = 


}

//sumaingresos e egresos analisis del aval 2
function sumarIngresosEgresosAval3() {
  var sueldoBase = parseFloat(document.getElementById("sueldoBase_analisisAval3").value) || 0;
  var ingresosNegocio = parseFloat(document.getElementById("ingresosNegocioAval3").value) || 0;
  var renta = parseFloat(document.getElementById("rentaAval3").value) || 0;
  var remesas = parseFloat(document.getElementById("remesasAval3").value) || 0;
  var aporteConyuge = parseFloat(document.getElementById("aporteConyugeAval3").value) || 0;
  var sociedad = parseFloat(document.getElementById("sociedadAval3").value) || 0;

  var sumaIngresos = sueldoBase+ ingresosNegocio + renta + remesas +aporteConyuge + sociedad;
  
  document.getElementById("totalIngresosAval3").value = sumaIngresos.toFixed(2);
  var cuotaAdepes = parseFloat(document.getElementById("cuotaAdepesAval3").value) || 0;
  var vivienda = parseFloat(document.getElementById("viviendaAval3").value) || 0;
  var alimentacion = parseFloat(document.getElementById("alimentacionAval3").value) || 0;
  var centralRiesgo = parseFloat(document.getElementById("centralRiesgoAval3").value) || 0;
  var otrosEgresos = parseFloat(document.getElementById("otrosEgresosAval3").value) || 0;
  

  var sumaEgresos =cuotaAdepes+ vivienda + alimentacion + centralRiesgo +otrosEgresos;
  
  document.getElementById("totalEgresosAval3").value = sumaEgresos.toFixed(2);
 
  //totales
  var IngresosNetos = sumaIngresos - sumaEgresos;
  document.getElementById("ingresosNetosAval3").value = IngresosNetos.toFixed(2);
 
  //capital disponible
  var cuotaAdepes2 = parseFloat(document.getElementById("cuotaMensualAval3").value) || 0;
  var capitalDisponible = IngresosNetos - cuotaAdepes2;
  document.getElementById("capitalDisponibleAval3").value = capitalDisponible.toFixed(2);
//evaluacion
  if(capitalDisponible > 0){
      document.getElementById('evaluacionAval3').value ="ESTA PERSONA TIENE CAPACIDAD DE PAGO, PARA SERVIR COMO AVAL SOLIDARIO";
  }else if(capitalDisponible < 0){
      document.getElementById('evaluacionAval3').value ="ESTA PERSONA NO TIENE CAPACIDAD DE PAGO, PARA SERVIR COMO AVAL SOLIDARIO";
  }else{
      document.getElementById('evaluacionAval3').value ="";
  }
  


}


//funciones para pasar valores a los input del analisis

function copiarValores(inputId, outputId) {
  var input = document.getElementById(inputId);
  var output = document.getElementById(outputId);
  output.value = input.value;
  sumarIngresosEgresos();
  sumarIngresosEgresosAval1();
  sumarIngresosEgresosAval2();
  sumarIngresosEgresosAval3();
}

// Cliente
document.getElementById("sueldoBase_edit").addEventListener("input", function() {
  copiarValores("sueldoBase_edit", "sueldoBase_analisis");
});
document.getElementById("ingresosPorNegocio_edit").addEventListener("input", function() {
  copiarValores("ingresosPorNegocio_edit", "ingresosNegocio");
});
document.getElementById("cuota_edit").addEventListener("input", function() {
  copiarValores("cuota_edit", "cuotaAdepes");
});
document.getElementById("pagoCasa_edit").addEventListener("input", function() {
  copiarValores("pagoCasa_edit", "vivienda");
});
document.getElementById("gastosAlimentacion_edit").addEventListener("input", function() {
  copiarValores("gastosAlimentacion_edit", "alimentacion");
});
//aval1
document.getElementById("sueldoBase_aval1").addEventListener("input", function() {
  copiarValores("sueldoBase_aval1", "sueldoBase_analisisAval1");
});
document.getElementById("ingresosPorNegocio_aval1").addEventListener("input", function() {
  copiarValores("ingresosPorNegocio_aval1", "ingresosNegocioAval1");
});
document.getElementById("cuota_aval1").addEventListener("input", function() {
  copiarValores("cuota_aval1", "cuotaAdepesAval1");
});
document.getElementById("pagoCasa_aval1").addEventListener("input", function() {
  copiarValores("pagoCasa_aval1", "viviendaAval1");
});
document.getElementById("gastosAlimentacion_aval1").addEventListener("input", function() {
  copiarValores("gastosAlimentacion_aval1", "alimentacionAval1");
});

//aval2
document.getElementById("sueldoBase_aval2").addEventListener("input", function() {
  copiarValores("sueldoBase_aval2", "sueldoBase_analisisAval2");
});
document.getElementById("ingresosPorNegocio_aval2").addEventListener("input", function() {
  copiarValores("ingresosPorNegocio_aval2", "ingresosNegocioAval2");
});
document.getElementById("cuota_aval2").addEventListener("input", function() {
  copiarValores("cuota_aval2", "cuotaAdepesAval2");
});
document.getElementById("pagoCasa_aval2").addEventListener("input", function() {
  copiarValores("pagoCasa_aval2", "viviendaAval2");
});
document.getElementById("gastosAlimentacion_aval2").addEventListener("input", function() {
  copiarValores("gastosAlimentacion_aval2", "alimentacionAval2");
});

//aval3
document.getElementById("sueldoBase_aval3").addEventListener("input", function() {
  copiarValores("sueldoBase_aval3", "sueldoBase_analisisAval3");
});
document.getElementById("ingresosPorNegocio_aval3").addEventListener("input", function() {
  copiarValores("ingresosPorNegocio_aval3", "ingresosNegocioAval3");
});
document.getElementById("cuota_aval3").addEventListener("input", function() {
  copiarValores("cuota_aval3", "cuotaAdepesAval3");
});
document.getElementById("pagoCasa_aval3").addEventListener("input", function() {
  copiarValores("pagoCasa_aval3", "viviendaAval3");
});
document.getElementById("gastosAlimentacion_aval3").addEventListener("input", function() {
  copiarValores("gastosAlimentacion_aval3", "alimentacionAval3");
});



function generarPlan() {
  const prestamo = parseFloat(document.getElementById('monto_edit').value);
  const plazoMeses = parseInt(document.getElementById('plazo_edit').value);
  const fechaEmision = new Date(document.getElementById('fechaEmision_edit').value);
  tipoPrestamo =$('#tipogarantia_edit').val();
  
  fecha =$('#fechaEmision_edit').val();
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

//funcion para obtener el id de la solicitud para actualizarlo
function ObtenerDatosPrestamo(){
  idTipoPrestamo = $('#tipogarantia_edit').val(); 
  monto = $('#monto_edit').val(); 
  plazo = $('#plazo_edit').val(); 
  $.ajax({
      data: { "idTipoPrestamo": idTipoPrestamo },
      url:'../controller/SolicitudNuevaController.php?operador=obtener_datos_prestamo', //url del controlador Conttroller
      type:'POST',
      beforeSend:function(){},
      success:function(response){
          //console.log(response);
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
             //CLIENTE
              $('#cuotaMensual').val(cuota);
              $('#letraMensual').val(letraMensual);
              $('#interesCorriente').val(interesCorrienteMensual);
              sumarIngresosEgresos();
              //AVAL1
              $('#cuotaMensualAval1').val(cuota);
              $('#letraMensualAval1').val(letraMensual);
              $('#interesCorrienteAval1').val(interesCorrienteMensual);
              sumarIngresosEgresosAval1();
              //AVAL2
              $('#cuotaMensualAval2').val(cuota);
              $('#letraMensualAval2').val(letraMensual);
              $('#interesCorrienteAval2').val(interesCorrienteMensual);
              sumarIngresosEgresosAval2();
              //AVAL3
              $('#cuotaMensualAval3').val(cuota);
              $('#letraMensualAval3').val(letraMensual);
              $('#interesCorrienteAval3').val(interesCorrienteMensual);
              sumarIngresosEgresosAval3();
            
          }
         
      }

  });

}


/*validaciones de inputs */
function formatoIdentidad(event) {
  // Obtener el valor actual del input y eliminar caracteres no numéricos
  var identidad = event.target.value.replace(/\D/g, '');

  // Aplicar formato a los dos primeros grupos de 4 números
  if (identidad.length > 8) {
    identidad = identidad.slice(0, 4) + '-' + identidad.slice(4, 8) + '-' + identidad.slice(8);
  } else if (identidad.length > 4) {
    identidad = identidad.slice(0, 4) + '-' + identidad.slice(4);
  }

  // Actualizar el valor del input con el formato aplicado
  event.target.value = identidad;
}

 //funcion que valida un solo espacio entre palabras
 espacios=function(input){
  input.value=input.value.replace('  ',' ');//sustituimos dos espacios seguidos por uno 
 }
 
 //Valida que solo ingrese mayusculas 
 function CambiarMayuscula(elemento){
     let texto = elemento.value;
     elemento.value = texto.toUpperCase();
 }

//funcion para solo letras 
function soloLetras(e) {
  key = e.keyCode || e.which;
  tecla = String.fromCharCode(key).toLowerCase();
  letras = "abcdefghijklmnñopqrstuvwxyz";
  especiales = [32]; //permite caracteres especiales usando Caracteres ASCII

  tecla_especial = false
  for(var i in especiales) {
      if(key == especiales[i]) {
          tecla_especial = true;
          break;
      }
  }

  if(letras.indexOf(tecla) == -1 && !tecla_especial)
      return false;
}

/**************************************validaciones input  */
function formatearNumero(inputElement) {
  let input = inputElement.value;
  input = input.replace(/\D/g, '');

  const primeraParte = input.slice(0, 4);
  const segundaParte = input.slice(4, 8);

  const numeroFormateado = `${primeraParte}-${segundaParte}`;
  inputElement.value = numeroFormateado;
}

/***************************************************************** */

function mostrarFormularioAnalisis(persona) {
  const formulario = document.getElementById("AnalisisCrediticioCliente");
  const boton = document.getElementById("botonMostrarOcultar");
  if(persona == 1){
    if (formulario.style.display === "none" || formulario.style.display === "") {
      formulario.style.display = "block";
      boton.innerText = "Ocultar Análisis";
    } else {
      formulario.style.display = "none";
      boton.innerText = "Mostrar Análisis";
    }
  }
  //analisis crediticio AVAL1
  const formulario1 = document.getElementById("AnalisisCrediticioAval1");
  const botonAval1 = document.getElementById("botonMostrarOcultarAval1");
  if(persona == 2){
    if (formulario1.style.display === "none" || formulario1.style.display === "") {
      formulario1.style.display = "block";
      botonAval1.innerText = "Ocultar Análisis";
    } else {
      formulario1.style.display = "none";
      botonAval1.innerText = "Mostrar Análisis";
    }
  }

   //analisis crediticio AVAL2
   const formulario2 = document.getElementById("AnalisisCrediticioAval2");
   const botonAval2 = document.getElementById("botonMostrarOcultarAval2");
   if(persona == 3){
     if (formulario2.style.display === "none" || formulario2.style.display === "") {
       formulario2.style.display = "block";
       botonAval2.innerText = "Ocultar Análisis";
     } else {
       formulario2.style.display = "none";
       botonAval2.innerText = "Mostrar Análisis";
     }
   }

   //analisis crediticio AVAL3
   const formulario3 = document.getElementById("AnalisisCrediticioAval3");
   const botonAval3 = document.getElementById("botonMostrarOcultarAval3");
   if(persona == 4){
     if (formulario3.style.display === "none" || formulario3.style.display === "") {
       formulario3.style.display = "block";
       botonAval3.innerText = "Ocultar Análisis";
     } else {
       formulario3.style.display = "none";
       botonAval3.innerText = "Mostrar Análisis";
     }
   }
  
}



function mostrarFormulario() {
  const seleccion = document.getElementById("estadoCivil_edit").value;
  const formulario = document.getElementById("formulario");
 

  if (seleccion == 2 || seleccion == 3) {
    formulario.style.display = "block";
  } else if(seleccion == 1 || seleccion == 4) {
    formulario.style.display = "none";
  }

   //aval1
   const seleccionAval1 = document.getElementById("estadoCivil_edit1").value;
   const formularioAval1 = document.getElementById("formularioAval1");

  if (seleccionAval1 == 2 || seleccionAval1 == 3) {
    formularioAval1.style.display = "block";
  } else if(seleccionAval1 == 1 || seleccionAval1 == 4) {
    formularioAval1.style.display = "none";
  }

    //aval2
    const seleccionAval2 = document.getElementById("estadoCivil_edit2").value;
    const formularioAval2 = document.getElementById("formularioAval2");

  if (seleccionAval2 == 2 || seleccionAval2 == 3) {
    formularioAval2.style.display = "block";
  } else if(seleccionAval2 == 1 || seleccionAval2 == 4) {
    formularioAval2.style.display = "none";
  }

  //aval3
  const seleccionAval3 = document.getElementById("estadoCivil_edit3").value;
  const formularioAval3 = document.getElementById("formularioAval3");

  if (seleccionAval3 == 2 || seleccionAval3 == 3) {
    formularioAval3.style.display = "block";
  } else if(seleccionAval3 == 1 || seleccionAval3 == 4) {
    formularioAval3.style.display = "none";
  }


}


