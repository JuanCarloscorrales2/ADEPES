//inicializar la variable de cada tabla
var tablaPrestamo;
var tablaEstadoCivil;
var tablaParentesco;
var tablaCategoria;
var tablaGenero;
var tablaContacto;
var tablaBienes;
var tablaNacionalidad;
var tablaLaboral;
var tablaEstadoplanpago;
var tablaTiempovivir;
var tablaEstadotipoprestamo;
var tablaEstadosolicitud;
var tablaRubro;
var tablaProfesion;
var tablaMunicipio;
var tablaTipopago;
var tablaTipocliente;
var tablaEstadocredito;
var tablaAnalisis;
var tablaAvala;
var tablaTipopersona;
var tablaTipocuenta;
var tablaCreditoaval;
var tablaObjetos;

init();
//funcion que se ejecutara al inicio

//FUNCION QUE SE EJECUTARA AL INICIO
function init(){
    LlenarTablaTipoPrestamos();
    LlenarTablaEstadoCivil();
    LlenarTablaParentesco();
    LlenarTablaCategoria();
    LlenarTablaGenero();
    LlenarTablaContacto();
    LlenarTablaBienes();
    LlenarTablaNacionalidad();
    LlenarTablaLaboral();
    LlenarTablaEstadoplanpago();
    LlenarTablaTiempovivir();
    LlenarTablaEstadotipoprestamo();
    LlenarTablaEstadosolicitud();
    LlenarTablaRubro();
    LlenarTablaProfesion();
    LlenarTablaMunicipio();
    LlenarTablaTipopago();
    LlenarTablaTipocliente();
    LlenarTablaEstadocredito();
    LlenarTablaAnalisis();
    LlenarTablaAvala();
    LlenarTablaTipopersona();
    LlenarTablaTipocuenta();
    LlenarTablaCreditoAval();
    LlenarTablaObjetos();
}


/**************************FUNCIONES DE LOS TIPOS DE PRESTAMOS ************************************************************* */
//FUNCION PARA LLENAR LA TABLA DE tipo de PRESTAMOS AJAX
function LlenarTablaTipoPrestamos(){
    tablaPrestamo = $('#tabla_Tipo_Prestamo').DataTable({
        pageLength:10,
        responsive: true,
        processign: true,
        "language": {   //para cambiar de idiomas a la tabla
            "lengthMenu": "Mostrar _MENU_ Registro por páginas",
            "zeroRecords": "El registro no existe",
            "info": "Mostrando la página _PAGE_ de _PAGES_",
            "infoEmpty": "No records available",
            "infoFiltered": "(Filtrado de _MAX_ Registros Totales)",
            "search": 'Buscar Registro:',
            "paginate": {
                'next': 'Siguiente',
                'previous': 'Anterior'
            }
        },
        ajax: "../controller/TablasController.php?operador=listar_tipos_prestamos",
        columns : [
            { data : 'Acciones'},
            { data : 'NO'},  //se ponen los datos del Controller
            { data : 'ESTADO'},  //se ponen los datos del Controller
            { data : 'DESCRIPCION'},
            { data : 'TASA'},
            { data : 'PLAZO'},
            { data : 'MINIMO'},
            { data : 'MAXIMO'},
            
        ]

       

    });

    let timeout = null;

    // Agregar controlador de eventos para detectar la búsqueda
    $('#tabla_Tipo_Prestamo').on('search.dt', function(event) {
        // Limpiar el timeout anterior, si existe
        clearTimeout(timeout);
        
        // Iniciar un nuevo timeout
        timeout = setTimeout(function(){
            // Verificar si la búsqueda actual no está vacía
            if (tablaPrestamo.search() !== '') {
                // Realizar acciones solo si hay una búsqueda activa
                //TIPOConsulta, ID DE LA PANTALLA, Y DESCRIPCION
                EventoBitacora(2, 10, "Realizo consulta de filtros en LISTADO DE TIPOS DE PRÉSTAMOS");
            }
        }, 2000); // Este es el tiempo en milisegundos antes de que se ejecute el código después de que el usuario deja de escribir
    });

    
}
//FUNCION PARA REGISTRA UN tipo de prestamo AJAX
function RegistrarTipoPrestamo(){
  nombre = $('#nombre').val();  //id del modal
  tasa = $('#tasa').val();
  plazoMaximo = $('#plazoMaximo').val();
  montoMinimo = $('#montoMinimo').val();
  montoMaximo = $('#montoMaximo').val();
  if( tasa == 0){
    Swal.fire({
      icon: 'warning',
      title: '¡Atención!',
      text: 'La tasa  debe ser mayor que 0',
      allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
   })

    return
  } 
  if( plazoMaximo == 0){
    Swal.fire({
      icon: 'warning',
      title: '¡Atención!',
      text: 'El plazo  debe ser mayor que 0',
      allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
  })

      return
  } 
  if( montoMinimo == 0 || montoMaximo == 0 ){
    Swal.fire({
      icon: 'warning',
      title: '¡Atención!',
      text: 'Los montos deben ser mayor que 0',
      allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
  })

    return
  } 

  parametros = {
      "nombre":nombre, "tasa":tasa, "plazoMaximo":plazoMaximo, "montoMinimo":montoMinimo, "montoMaximo":montoMaximo
  }

  $.ajax({
      data:parametros,
      url:"../controller/TablasController.php?operador=registrar_tipo_prestamo",
      type:'POST',
      beforeSend:function(){},
      success:function(response){

          if(response == "success"){  //si inserto correctamente
              tablaPrestamo.ajax.reload();  //actualiza la tablaSSSS
             LimpiarControles();
             $('#registral_tipo_prestamo').modal('hide'); //cierra el modal
             Swal.fire({
              icon: 'success',
              title: 'Registro exitoso',
              text: 'Se han guardado correctamente los datos',
              allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
            })
          }else if(response == "requerid"){
              Swal.fire({
                  icon: 'warning',
                  title: '¡Atención!',
                  text: 'Complete todos los campos',
                  allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
                })

          }else if(response == "minimo"){
              Swal.fire({
                 icon: 'warning',
                 title: '¡Atención!',
                 text: 'El monto mínimo debe ser menor que el máximo',
                 allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
             })   
          }else{
              Swal.fire({
                  icon: 'error',
                  title: '¡Atención!',
                  text: 'No se lograron guardar los datos',
                  allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
                })
          }
      }
  })
}

//funcion para obtener el id del cliente para actualizarlo
function ObtenerTipoPrestamoPorId(idTipoPrestamo, Acciones){
    $.ajax({
        data: { "idTipoPrestamo": idTipoPrestamo },
        url:'../controller/TablasController.php?operador=obtener_tipo_prestamo_por_id', //url del controlador Conttroller
        type:'POST',
        beforeSend:function(){},
        success:function(response){
          //  console.log(response);  //para probar que traiga datos en consola
            data = $.parseJSON(response);
            if(data.length > 0){
  
              if(Acciones == "editar"){
                $('#id_edit').val(data[0]['ID']);
                $('#nombre_edit').val(data[0]['NOMBRE']);  //modal de actualizar prestamos
                $('#tasa_edit').val(data[0]['TASA']);
                $('#plazoMaximo_edit').val(data[0]['PLAZO']);
                $('#montoMinimo_edit').val(data[0]['MONTO_MINIMO']);
                $('#montoMaximo_edit').val(data[0]['MONTO_MAXIMO']);
                
                ListarEstadoPrestamoSelect(data[0]['ID']); //SELECT DE ESTADOS DE PRESTAMO
  
              }else if(Acciones == "eliminar"){
                AlertaInactivarPrestamo(data[0]['ID'], data[0]['NOMBRE'], data[0]['IDESTADO']);
              }else if(Acciones == "activar"){
                AlertaActivarPrestamo(data[0]['ID'], data[0]['NOMBRE'], data[0]['IDESTADO']);
              }
              
            }
           
        }
  
    });
  
  }

  //FUNCION PARA LLENAR EL SELECT DE ESTADOS DE PRESTAMO
function ListarEstadoPrestamoSelect(idTipoPrestamo){

    $.ajax({
        data : { "idTipoPrestamo" : idTipoPrestamo},
        url:'../controller/TablasController.php?operador=listar_estadoPrestamo_select',
        type:'POST',
        beforeSend:function(){},
        success:function(respuesta){
            data = $.parseJSON(respuesta);
            if(data.length > 0){ //valida que existan datos
               // console.log(data); //para probar que traiga los datos
                 //se agrega value para que valida que no se selccione la opcion: seleccione una categoria
                select = "";
  
                 //each sirve para recorrer los elementos de una lista
                $.each(data,function(key,value){   
                select = select + "<option value=" +value[0]+ ">" +value[1]+ "</option>"; 
                    
                })
                $('#estado_prestamo_edit').html(select);
                      
            }
        }
    });
  
  }

  //funcion para actualizar un tipo de prestamo
  function ActualizarTipoPrestamo(){
    idTipoPrestamo = $('#id_edit').val();  //id de los input del modal de actualizar
    idEstadoTipoPrestamo = $('#estado_prestamo_edit').val();
    Descripcion = $('#nombre_edit').val();
    tasa = $('#tasa_edit').val();
    PlazoMaximo = $('#plazoMaximo_edit').val();
    montoMaximo = $('#montoMaximo_edit').val();
    montoMinimo = $('#montoMinimo_edit').val();
    
    if( tasa == 0){
      Swal.fire({
        icon: 'warning',
        title: '¡Atención!',
        text: 'La tasa  debe ser mayor que 0',
        allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
     })

      return
    } 
    if( PlazoMaximo == 0){
      Swal.fire({
        icon: 'warning',
        title: '¡Atención!',
        text: 'El plazo  debe ser mayor que 0',
        allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
    })

        return
    } 
    if( montoMinimo == 0 || montoMaximo == 0 ){
      Swal.fire({
        icon: 'warning',
        title: '¡Atención!',
        text: 'Los montos deben ser mayor que 0',
        allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
    })

      return
    } 
    parametros = {
        "idTipoPrestamo":idTipoPrestamo, "idEstadoTipoPrestamo":idEstadoTipoPrestamo, "Descripcion":Descripcion, "tasa":tasa,
        "PlazoMaximo":PlazoMaximo, "montoMaximo":montoMaximo, "montoMinimo":montoMinimo
    }
    $.ajax({
      data:parametros,
      url:'../controller/TablasController.php?operador=actualizar_tipo_prestamo', //url del controlador RolConttroller
      type:'POST',
      beforeSend:function(){},
      success:function(response){
          if(response == "success"){  //si inserto correctamente
            tablaPrestamo.ajax.reload();  //actualiza la tabla
             $('#actualizar_tipo_prestamo').modal('hide'); //cierra el modal

            Swal.fire({
              icon: 'success',
              title: 'Actualización Exitosa',
              text: 'Se han guardado correctamente los datos del préstamo',
              allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
            })
  
          }else if(response == "requerid"){
              Swal.fire({
                icon: 'error',
                title: '¡Atención!',
                text: 'Complete todos los datos por favor',
                allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
              })

        }else if(response == "minimo"){
            Swal.fire({
              icon: 'warning',
              title: '¡Atención!',
              text: 'El monto minimo debe ser menor que el máximo',
              allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
            })    

        }else if(response =="enUso"){
          swal.fire({
            icon: "warning",
            title: "Atención",
            text: "El tipo de préstamo ya se encuentra en uso no lo puedes inactivar",
            allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
            
          })   
  
         }else{
              Swal.fire({
                icon: 'error',
                title: '¡Atención!',
                text: 'Error al actualizar en la base de datos',
                allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
              })
          }
      }
  })
  
  }

    //funcion para no aprobara una solicitud
function InactivarTipoPrestamo(idTipoPrestamo){
    $.ajax({
        data: { "idTipoPrestamo": idTipoPrestamo },
        url:'../controller/TablasController.php?operador=inactivar_tipoPrestamo', //url del controlador Conttroller
        type:'POST',
        beforeSend:function(){},
        success:function(response){
            
            if(response == "success"){
                 //actualizar tabla
                 tablaPrestamo.ajax.reload();
                 swal.fire({
                    icon: "warning",
                    title: "No se ha podido eliminar",
                    text: "El préstamo se ha inactivado, para poder usuarlo activalo",
                    allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
                    
                })
              
            }else if(response =="enUso"){
              swal.fire({
                icon: "warning",
                title: "Atención",
                text: "El tipo de préstamo ya se encuentra en uso",
                allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
                
              })
                
            }else{
                swal.fire({
                    icon: "error",
                    title: "Atención",
                    text: "No se ha podido eliminar",
                    allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
                    
                })
            }
           
        }
  
    });
  
  }

  function ActivarTipoPrestamo(idTipoPrestamo){
    $.ajax({
        data: { "idTipoPrestamo": idTipoPrestamo },
        url:'../controller/TablasController.php?operador=activar_tipoPrestamo', //url del controlador Conttroller
        type:'POST',
        beforeSend:function(){},
        success:function(response){
            
            if(response == "success"){
                 //actualizar tabla
                 tablaPrestamo.ajax.reload();
                 swal.fire({
                    icon: "success",
                    title: "Activo",
                    text: "El préstamo se ha activo para su uso",
                    allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
                    
                })
              
              
            }else{
                swal.fire({
                    icon: "error",
                    title: "Atención",
                    text: "No se a activar",
                    allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
                    
                })
            }
           
        }
  
    });
  
  }

  function AlertaInactivarPrestamo(idTipoPrestamo, Nombre){
    Swal.fire({
      title: '¿Está seguro que desea eliminar, no podrá utilizarlo?',
      text: "Préstamo: "+Nombre,
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Aceptar',
      cancelButtonText: 'Cancelar',
      allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
    }).then((result) => {
      if (result.isConfirmed) {
        
        InactivarTipoPrestamo(idTipoPrestamo);
  
      }
    })
  }

  function AlertaActivarPrestamo(idTipoPrestamo, Nombre){
    Swal.fire({
      title: '¿Está seguro que desea activar?',
      text: "Préstamo: "+Nombre,
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Aceptar',
      cancelButtonText: 'Cancelar',
      allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
    }).then((result) => {
      if (result.isConfirmed) {
        
        ActivarTipoPrestamo(idTipoPrestamo);
  
      }
    })
  }


  /**************************FUNCIONES DE LOS ESTADOS CIVILES ***************************************************************** */

//FUNCION PARA LLENAR LA TABLA DE ESTADO CIVIL AJAX
function LlenarTablaEstadoCivil(){
    tablaEstadoCivil = $('#tabla_estadoCivil').DataTable({
        pageLength:10,
        responsive: true,
        processign: true,
        "language": {   //para cambiar de idiomas a la tabla
            "lengthMenu": "Mostrar _MENU_ Registro por páginas",
            "zeroRecords": "El registro no existe",
            "info": "Mostrando la página _PAGE_ de _PAGES_",
            "infoEmpty": "No records available",
            "infoFiltered": "(Filtrado de _MAX_ Registros Totales)",
            "search": 'Buscar Registro:',
            "paginate": {
                'next': 'Siguiente',
                'previous': 'Anterior'
            }
        },
        ajax: "../controller/TablasController.php?operador=listar_estadocivil",
        columns : [
            { data : 'Acciones'},
            { data : 'NO'},  //se ponen los datos del Controller
            { data : 'DESCRIPCION'}, //se ponen los datos del Controller
            
            
        ]

       

    });
    let timeout = null;

    // Agregar controlador de eventos para detectar la búsqueda
    $('#tabla_estadoCivil').on('search.dt', function(event) {
        // Limpiar el timeout anterior, si existe
        clearTimeout(timeout);
        
        // Iniciar un nuevo timeout
        timeout = setTimeout(function(){
            // Verificar si la búsqueda actual no está vacía
            if (tablaEstadoCivil.search() !== '') {
                // Realizar acciones solo si hay una búsqueda activa
                //TIPOConsulta, ID DE LA PANTALLA, Y DESCRIPCION
                EventoBitacora(2, 11, "Realizo consulta de filtros en LISTADO DE ESTADO CIVIL");
            }
        }, 2000); // Este es el tiempo en milisegundos antes de que se ejecute el código después de que el usuario deja de escribir
    });


    
}

//FUNCION PARA REGISTRA UN estado civil AJAX
function RegistrarEstadoCivil(){
    descripcion = $('#descripcion_estado_civil').val(); //id del modal

    parametros = {
        "descripcion":descripcion
    }

    $.ajax({
        data:parametros,
        url:"../controller/TablasController.php?operador=registrar_estado_civil",
        type:'POST',
        beforeSend:function(){},
        success:function(response){

            if(response == "success"){  //si inserto correctamente
               tablaEstadoCivil.ajax.reload();  //actualiza la tablaSSSS
               LimpiarControles();
               $('#registral_estadocivil').modal('hide'); //cierra el modal
               Swal.fire({
                icon: 'success',
                title: 'Registro exitoso',
                text: 'Se ha guardado correctamente los datos',
                allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
              })
            }else if(response == "requerid"){
                Swal.fire({
                    icon: 'warning',
                    title: '¡Atención!',
                    text: 'Complete todos los campos',
                    allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
                  })
            }else if(response == "existe"){
                  Swal.fire({
                      icon: 'warning',
                      title: '¡Atención!',
                      text: 'El estado civil que deseas crear ya existe',
                      allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
            })
            }else{
                Swal.fire({
                    icon: 'error',
                    title: '¡Atención!',
                    text: 'No se lograron guardar los datos',
                    allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
                  })
            }
        }
    })
}

//funcion para obtener el id del cliente para actualizarlo
function ObtenerEstadoCivilPorId(idEstadoCivil, Acciones){
    $.ajax({
        data: { "idEstadoCivil": idEstadoCivil },
        url:'../controller/TablasController.php?operador=obtener_estado_civil_por_id', //url del controlador Conttroller
        type:'POST',
        beforeSend:function(){},
        success:function(response){
           // console.log(response);  //para probar que traiga datos en consola
            data = $.parseJSON(response);
            if(data.length > 0){
  
              if(Acciones == "editar"){
                $('#id_edit').val(data[0]['ID']);
                $('#descripcion_estado_civil_edit').val(data[0]['DESCRIPCION']);  //modal de actualizar estado civil
                
  
              }else if(Acciones == "eliminar"){
                AlertaEliminarEstadoCivil(data[0]['ID'], data[0]['DESCRIPCION']);
              }
            }
           
        }
  
    });
}

  //funcion para actualizar el estado civil
  function ActualizarEstadoCivil(){
    idEstadoCivil = $('#id_edit').val();  //id de los input del modal de actualizar
    Descripcion = $('#descripcion_estado_civil_edit').val();
   
    
   
    parametros = {
        "idEstadoCivil":idEstadoCivil, "Descripcion":Descripcion //parametros que se mandan al controlador: actualizar_estado_civil
    }
    $.ajax({
      data:parametros,
      url:'../controller/TablasController.php?operador=actualizar_estado_civil', //url del controlador 
      type:'POST',
      beforeSend:function(){},
      success:function(response){
          if(response == "success"){  //si inserto correctamente
            tablaEstadoCivil.ajax.reload();  //actualiza la tabla
             $('#actualizar_estadocivil').modal('hide'); //cierra el modal id del modal

            Swal.fire({
              icon: 'success',
              title: 'Actualización Exitosa',
              text: 'Se han actualizado correctamente los datos',
              allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
            })
  
          }else if(response == "requerid"){
              Swal.fire({
                icon: 'warning',
                title: '¡Atención!',
                text: 'Complete todos los datos por favor',
                allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
              })     
          }else if(response == "existe"){
            Swal.fire({
                icon: 'warning',
                title: '¡Atención!',
                text: 'El nombre del estado civil ya existe',
                allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
            })
         }else{
              Swal.fire({
                icon: 'error',
                title: '¡Atención!',
                text: 'Error al actualizar en la base de datos',
                allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
              })
          }
      }
  })
  
  }

    //funcion paraEliminar un estado civil
function EliminarEstadoCivil(idEstadoCivil){
    $.ajax({
        data: { "idEstadoCivil": idEstadoCivil },
        url:'../controller/TablasController.php?operador=eliminar_estado_civil', //url del controlador Conttroller
        type:'POST',
        beforeSend:function(){},
        success:function(response){
            
            if(response == "success"){
                 //actualizar tabla
                 tablaEstadoCivil.ajax.reload();
                 swal.fire({
                    icon: "success",
                    title: "Eliminado",
                    text: "El registro se eliminó"   
                })
              
            }else if(response == "llave_uso"){
                swal.fire({
                    icon: "warning",
                    title: "Atención",
                    text: "El registro no se puede eliminar ya que se encuentra en uso.",
                    allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
                })
            }else{
                swal.fire({
                    icon: "error",
                    title: "Atención",
                    text: "No se ha podido eliminar",
                    allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
                    
                })
            }
           
        }
  
    });
  
  }
  function AlertaEliminarEstadoCivil(idEstadoCivil, Descripcion){
    Swal.fire({
      title: '¿Está seguro que desea eliminar?',
      text: "Estado Civil: "+Descripcion,
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Aceptar',
      cancelButtonText: 'Cancelar',
      allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
    }).then((result) => {
      if (result.isConfirmed) {
        
        EliminarEstadoCivil(idEstadoCivil); //funcion que eliminar el estado
  
      }
    })
  }

  
/***************************FUNCIONES DE LA TABLA PARENTESCO *******************************************************************************/

//FUNCION PARA LLENAR LA TABLA DE ESTADO CIVIL AJAX
function LlenarTablaParentesco(){
    tablaParentesco = $('#tabla_parentesco').DataTable({
        pageLength:10,
        responsive: true,
        processign: true,
        "language": {   //para cambiar de idiomas a la tabla
            "lengthMenu": "Mostrar _MENU_ Registro por páginas",
            "zeroRecords": "El registro no existe",
            "info": "Mostrando la página _PAGE_ de _PAGES_",
            "infoEmpty": "No records available",
            "infoFiltered": "(Filtrado de _MAX_ Registros Totales)",
            "search": 'Buscar Registro:',
            "paginate": {
                'next': 'Siguiente',
                'previous': 'Anterior'
            }
        },
        ajax: "../controller/TablasController.php?operador=listar_parentesco",
        columns : [
            { data : 'Acciones'},
            { data : 'NO'},  //se ponen los datos del Controller
            { data : 'PARENTESCO'}, //se ponen los datos del Controller
            
            
        ]

       

    });

    let timeout = null;
     // Agregar controlador de eventos para detectar la búsqueda
     $('#tabla_parentesco').on('search.dt', function(event) {
      // Limpiar el timeout anterior, si existe
      clearTimeout(timeout);
      
      // Iniciar un nuevo timeout
      timeout = setTimeout(function(){
          // Verificar si la búsqueda actual no está vacía
          if (tablaParentesco.search() !== '') {
              // Realizar acciones solo si hay una búsqueda activa
              //TIPOConsulta, ID DE LA PANTALLA, Y DESCRIPCION
              EventoBitacora(2, 13, "Realizo consulta de filtros en LISTADO DE PARENTESCO");
          }
      }, 2000); // Este es el tiempo en milisegundos antes de que se ejecute el código después de que el usuario deja de escribir
  });
}

//FUNCION PARA REGISTRA UN estado civil AJAX
function RegistrarParentesco(){
  descripcion = $('#descripcion_Parentesco').val(); //id del modal

  parametros = {
      "descripcion":descripcion
  }

  $.ajax({
      data:parametros,
      url:"../controller/TablasController.php?operador=registrar_Parentesco",
      type:'POST',
      beforeSend:function(){},
      success:function(response){

          if(response == "success"){  //si inserto correctamente
             tablaParentesco.ajax.reload();  //actualiza la tablaSSSS
             LimpiarControles();
             $('#registral_Parentesco').modal('hide'); //cierra el modal
             Swal.fire({
              icon: 'success',
              title: 'Registro exitoso',
              text: 'Se ha guardado correctamente los datos',
              allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
            })
          }else if(response == "existe"){
            Swal.fire({
                icon: 'warning',
                title: '¡Atención!',
                text: 'El parentesco ya existe',
                allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
            })

          }else if(response == "requerid"){
              Swal.fire({
                  icon: 'warning',
                  title: '¡Atención!',
                  text: 'Complete todos los campos',
                  allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
                })
          }else{
              Swal.fire({
                  icon: 'error',
                  title: '¡Atención!',
                  text: 'No se lograron guardar los datos',
                  allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
                })
          }
      }
  })
}
//funcion para obtener el id del cliente para actualizarlo
function ObtenerParentescoPorId(idParentesco, Acciones){
  $.ajax({
      data: { "idParentesco": idParentesco },
      url:'../controller/TablasController.php?operador=obtener_parentesco_por_id', //url del controlador Conttroller
      type:'POST',
      beforeSend:function(){},
      success:function(response){
         // console.log(response);  //para probar que traiga datos en consola
          data = $.parseJSON(response);
          if(data.length > 0){

            if(Acciones == "editar"){
              $('#id_edit').val(data[0]['ID']);
              $('#descripcion_parentesco_edit').val(data[0]['DESCRIPCION']);  //modal de actualizar estado civil
              

            }else if(Acciones == "eliminar"){
              AlertaEliminarParentesco(data[0]['ID'], data[0]['DESCRIPCION']);
            }
          }
         
      }

  });
}
//funcion para actualizar el estado civil
function ActualizarParentesco(){
  idParentesco = $('#id_edit').val();  //id de los input del modal de actualizar
  descripcion = $('#descripcion_parentesco_edit').val();
 
  
 
  parametros = {
      "idParentesco":idParentesco, "descripcion":descripcion //parametros que se mandan al controlador: actualizar_estado_civil
  }

  console.log("NOMBRE:"+descripcion);
  console.log("ID:"+idParentesco);
  $.ajax({
    data:parametros,
    url:'../controller/TablasController.php?operador=actualizar_parentesco', //url del controlador 
    type:'POST',
    beforeSend:function(){},
    success:function(response){
        if(response == "success"){  //si inserto correctamente
          tablaParentesco.ajax.reload();  //actualiza la tabla
           $('#actualizar_Parentesco').modal('hide'); //cierra el modal id del modal

          Swal.fire({
            icon: 'success',
            title: 'Actualización Exitosa',
            text: 'Se han actualizado correctamente los datos',
            allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
          })

        }else if(response == "requerid"){
            Swal.fire({
              icon: 'warning',
              title: '¡Atención!',
              text: 'Complete todos los datos por favor',
              allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
            })    
        }else if(response == "existe"){
          Swal.fire({
              icon: 'warning',
              title: '¡Atención!',
              text: 'No puedes actulizar ya que ese parentesco ya existe',
              allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
          }) 

       }else{
            Swal.fire({
              icon: 'error',
              title: '¡Atención!',
              text: 'Error al actualizar en la base de datos',
              allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
            })
        }
    }
})

}

    //funcion paraEliminar un estado civil
    function EliminarParentesco(idParentesco){
      $.ajax({
          data: { "idParentesco": idParentesco },
          url:'../controller/TablasController.php?operador=eliminar_Parentesco', //url del controlador Conttroller
          type:'POST',
          beforeSend:function(){},
          success:function(response){
              
              if(response == "success"){
                   //actualizar tabla
                   tablaParentesco.ajax.reload();
                   swal.fire({
                      icon: "success",
                      title: "Eliminado",
                      text: "El registro se eliminó"   
                  })
                
              }else if(response == "llave_uso"){
                  swal.fire({
                      icon: "warning",
                      title: "Atención",
                      text: "El registro no se puede eliminar ya que se encuentra en uso.",
                      allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
                  })
              }else{
                  swal.fire({
                      icon: "error",
                      title: "Atención",
                      text: "No se ha podido eliminar",
                      allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
                      
                  })
              }
             
          }
    
      });
    
    }
    function AlertaEliminarParentesco(idParentesco, descripcion){
      Swal.fire({
        title: '¿Está seguro que desea eliminar?',
        text: "Parentesco: "+descripcion,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Aceptar',
        cancelButtonText: 'Cancelar',
        allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
      }).then((result) => {
        if (result.isConfirmed) {
          
          EliminarParentesco(idParentesco); //funcion que eliminar el estado
    
        }
      })
    }
    /***************************FUNCIONES DE LA CATEGORIA****************************************************************************************************** */

//FUNCION PARA LLENAR LA TABLA DE CATEGORIA AJAX
function LlenarTablaCategoria(){
  tablaCategoria = $('#tabla_categoria').DataTable({
      pageLength:10,
      responsive: true,
      processign: true,
      "language": {   //para cambiar de idiomas a la tabla
          "lengthMenu": "Mostrar _MENU_ Registro por páginas",
          "zeroRecords": "El registro no existe",
          "info": "Mostrando la página _PAGE_ de _PAGES_",
          "infoEmpty": "No records available",
          "infoFiltered": "(Filtrado de _MAX_ Registros Totales)",
          "search": 'Buscar Registro:',
          "paginate": {
              'next': 'Siguiente',
              'previous': 'Anterior'
          }
      },
      
      ajax: "../controller/TablasController.php?operador=listar_Categoria",
      columns : [
          { data : 'Acciones'},
          { data : 'NO'},  //se ponen los datos del Controller
          { data : 'CATEGORIA'}, //se ponen los datos del Controller
          
          
      ]
  });

  let timeout = null;
     // Agregar controlador de eventos para detectar la búsqueda
     $('#tabla_categoria').on('search.dt', function(event) {
      // Limpiar el timeout anterior, si existe
      clearTimeout(timeout);
      
      // Iniciar un nuevo timeout
      timeout = setTimeout(function(){
          // Verificar si la búsqueda actual no está vacía
          if (tablaCategoria.search() !== '') {
              // Realizar acciones solo si hay una búsqueda activa
              //TIPOConsulta, ID DE LA PANTALLA, Y DESCRIPCION
              EventoBitacora(2, 12, "Realizo consulta de filtros en LISTADO DE CATEGORIA DE CASA");
          }
      }, 2000); // Este es el tiempo en milisegundos antes de que se ejecute el código después de que el usuario deja de escribir
  });
}
 //FUNCION PARA REGISTRA UN estado civil AJAX
function RegistrarCategoria(){
  descripcion = $('#descripcion_Categoria').val(); //id del modal

  parametros = {
      "descripcion":descripcion
  }

  $.ajax({
      data:parametros,
      url:"../controller/TablasController.php?operador=registrar_Categoria",
      type:'POST',
      beforeSend:function(){},
      success:function(response){

          if(response == "success"){  //si inserto correctamente
             tablaCategoria.ajax.reload();  //actualiza la tablaSSSS
             LimpiarControles();
             $('#registral_Categoria').modal('hide'); //cierra el modal
             Swal.fire({
              icon: 'success',
              title: 'Registro exitoso',
              text: 'Se ha guardado correctamente los datos',
              allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
            })
          }else if(response == "requerid"){
              Swal.fire({
                  icon: 'warning',
                  title: '¡Atención!',
                  text: 'Complete todos los campos',
                  allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
                })
          }else if(response == "existe"){
            Swal.fire({
                icon: 'warning',
                title: '¡Atención!',
                text: 'La categoría que intentas registrar ya existe',
                allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
            }) 
          }else{
              Swal.fire({
                  icon: 'error',
                  title: '¡Atención!',
                  text: 'No se lograron guardar los datos',
                  allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
                })
          }
      }
  })
} 
//funcion para obtener el id del cliente para actualizarlo
function ObtenerCategoriaPorId(idcategoriaCasa, Acciones){
  $.ajax({
      data: { "idcategoriaCasa": idcategoriaCasa },
      url:'../controller/TablasController.php?operador=obtener_categoria_por_id', //url del controlador Conttroller
      type:'POST',
      beforeSend:function(){},
      success:function(response){
         // console.log(response);  //para probar que traiga datos en consola
          data = $.parseJSON(response);
          if(data.length > 0){

            if(Acciones == "editar"){
              $('#id_edit').val(data[0]['ID']);
              $('#descripcion_categoria_edit').val(data[0]['CATEGORIA']);  //modal de actualizar estado civil
              

            }else if(Acciones == "eliminar"){
              AlertaEliminarCategoria(data[0]['ID'], data[0]['CATEGORIA']);
            }
          }
         
      }

  });
}
//funcion para actualizar el estado civil
function ActualizarCategoria(){
  idcategoriaCasa = $('#id_edit').val();  //id de los input del modal de actualizar
  descripcion = $('#descripcion_categoria_edit').val();
 
  
 
  parametros = {
      "idcategoriaCasa":idcategoriaCasa, "descripcion":descripcion //parametros que se mandan al controlador: actualizar_estado_civil
  }

  console.log("NOMBRE:"+descripcion);
  console.log("ID:"+idcategoriaCasa);
  $.ajax({
    data:parametros,
    url:'../controller/TablasController.php?operador=actualizar_categoria', //url del controlador 
    type:'POST',
    beforeSend:function(){},
    success:function(response){
        if(response == "success"){  //si inserto correctamente
          tablaCategoria.ajax.reload();  //actualiza la tabla
           $('#actualizar_Categoria').modal('hide'); //cierra el modal id del modal

          Swal.fire({
            icon: 'success',
            title: 'Actualización Exitosa',
            text: 'Se han actualizado correctamente los datos',
            allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
          })

        }else if(response == "requerid"){
            Swal.fire({
              icon: 'warning',
              title: '¡Atención!',
              text: 'Complete todos los datos por favor',
              allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
            })     

        }else if(response == "existe"){
          Swal.fire({
              icon: 'warning',
              title: '¡Atención!',
              text: 'No puedes actulizar ya que esa categoría ya existe',
              allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
          }) 

       }else{
            Swal.fire({
              icon: 'error',
              title: '¡Atención!',
              text: 'Error al actualizar en la base de datos',
              allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
            })
        }
    }
})

}
//funcion paraEliminar Categoria
function EliminarCategoria(idcategoriaCasa){
  $.ajax({
      data: { "idcategoriaCasa": idcategoriaCasa },
      url:'../controller/TablasController.php?operador=eliminar_Categoria', //url del controlador Conttroller
      type:'POST',
      beforeSend:function(){},
      success:function(response){
          
          if(response == "success"){
               //actualizar tabla
               tablaCategoria.ajax.reload();
               swal.fire({
                  icon: "success",
                  title: "Eliminado",
                  text: "El registro se eliminó"   
              })
            
          }else if(response == "llave_uso"){
              swal.fire({
                  icon: "warning",
                  title: "Atención",
                  text: "El registro no se puede eliminar ya que se encuentra en uso.",
                  allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
              })
          }else{
              swal.fire({
                  icon: "error",
                  title: "Atención",
                  text: "No se ha podido eliminar",
                  allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
                  
              })
          }
         
      }

  });

}
function AlertaEliminarCategoria(idcategoriaCasa, descripcion){
  Swal.fire({
    title: '¿Está seguro que desea eliminar?',
    text: "Categoria Casa: "+descripcion,
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Aceptar',
    cancelButtonText: 'Cancelar',
    allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
  }).then((result) => {
    if (result.isConfirmed) {
      
      EliminarCategoria(idcategoriaCasa); //funcion que eliminar el estado

    }
  })
}
 /***************************FUNCIONES DE LA GENERO****************************************************************************************************** */

//FUNCION PARA LLENAR LA TABLA DE CATEGORIA AJAX
function LlenarTablaGenero(){
  tablaGenero = $('#tabla_genero').DataTable({
      pageLength:10,
      responsive: true,
      processign: true,
      "language": {   //para cambiar de idiomas a la tabla
          "lengthMenu": "Mostrar _MENU_ Registro por páginas",
          "zeroRecords": "El registro no existe",
          "info": "Mostrando la página _PAGE_ de _PAGES_",
          "infoEmpty": "No records available",
          "infoFiltered": "(Filtrado de _MAX_ Registros Totales)",
          "search": 'Buscar Registro:',
          "paginate": {
              'next': 'Siguiente',
              'previous': 'Anterior'
          }
      },
      
      ajax: "../controller/TablasController.php?operador=listar_Genero",
      columns : [
          { data : 'Acciones'},
          { data : 'NO'},  //se ponen los datos del Controller
          { data : 'GENERO'}, //se ponen los datos del Controller
          
          
      ]
  });

  let timeout = null;
  // Agregar controlador de eventos para detectar la búsqueda
  $('#tabla_genero').on('search.dt', function(event) {
   // Limpiar el timeout anterior, si existe
   clearTimeout(timeout);
   
   // Iniciar un nuevo timeout
   timeout = setTimeout(function(){
       // Verificar si la búsqueda actual no está vacía
       if (tablaGenero.search() !== '') {
           // Realizar acciones solo si hay una búsqueda activa
           //TIPOConsulta, ID DE LA PANTALLA, Y DESCRIPCION
           EventoBitacora(2, 14, "Realizo consulta de filtros en LISTADO DE GENERO");
       }
   }, 2000); // Este es el tiempo en milisegundos antes de que se ejecute el código después de que el usuario deja de escribir
});
}
 //FUNCION PARA REGISTRA UN estado civil AJAX
function RegistrarGenero(){
  descripcion = $('#descripcion_Genero').val(); //id del modal

  parametros = {
      "Descripcion":descripcion
  }

  $.ajax({
      data:parametros,
      url:"../controller/TablasController.php?operador=registrar_Genero",
      type:'POST',
      beforeSend:function(){},
      success:function(response){

          if(response == "success"){  //si inserto correctamente
             tablaGenero.ajax.reload();  //actualiza la tablaSSSS
             LimpiarControles();
             $('#registral_Genero').modal('hide'); //cierra el modal
             Swal.fire({
              icon: 'success',
              title: 'Registro exitoso',
              text: 'Se han guardado correctamente los datos',
              allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
            })
          }else if(response == "requerid"){
              Swal.fire({
                  icon: 'warning',
                  title: '¡Atención!',
                  text: 'Complete todos los campos',
                  allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
                })
            }else if(response == "existe"){
              Swal.fire({
                  icon: 'warning',
                  title: '¡Atención!',
                  text: 'El genero que intentas registrar ya existe',
                  allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
              }) 
          }else{
              Swal.fire({
                  icon: 'error',
                  title: '¡Atención!',
                  text: 'No se lograron guardar los datos',
                  allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
                })
          }
      }
  })
} 
//funcion para obtener el id del cliente para actualizarlo
function ObtenerGeneroPorId(idGenero, Acciones){
  $.ajax({
      data: { "idGenero": idGenero },
      url:'../controller/TablasController.php?operador=obtener_genero_por_id', //url del controlador Conttroller
      type:'POST',
      beforeSend:function(){},
      success:function(response){
         // console.log(response);  //para probar que traiga datos en consola
          data = $.parseJSON(response);
          if(data.length > 0){

            if(Acciones == "editar"){
              $('#id_edit').val(data[0]['ID']);
              $('#descripcion_genero_edit').val(data[0]['GENERO']);  //modal de actualizar estado civil
              

            }else if(Acciones == "eliminar"){
              AlertaEliminarGenero(data[0]['ID'], data[0]['GENERO']);
            }
          }
         
      }

  });
}
//funcion para actualizar el estado civil
function ActualizarGenero(){
  idGenero = $('#id_edit').val();  //id de los input del modal de actualizar
  Descripcion = $('#descripcion_genero_edit').val();
 
  
 
  parametros = {
      "idGenero":idGenero, "Descripcion":Descripcion //parametros que se mandan al controlador: actualizar_estado_civil
  }

  console.log("NOMBRE:"+Descripcion);
  console.log("ID:"+idGenero);
  $.ajax({
    data:parametros,
    url:'../controller/TablasController.php?operador=actualizar_genero', //url del controlador 
    type:'POST',
    beforeSend:function(){},
    success:function(response){
        if(response == "success"){  //si inserto correctamente
          tablaGenero.ajax.reload();  //actualiza la tabla
           $('#actualizar_Genero').modal('hide'); //cierra el modal id del modal

          Swal.fire({
            icon: 'success',
            title: 'Actualización Exitosa',
            text: 'Se han actualizado correctamente los datos',
            allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
          })
        }else if(response == "existe"){
          Swal.fire({
              icon: 'warning',
              title: '¡Atención!',
              text: 'No puedes actualizar ya que el genero ya existe',
              allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
          }) 
        }else if(response == "requerid"){
            Swal.fire({
              icon: 'warning',
              title: '¡Atención!',
              text: 'Complete todos los datos por favor',
              allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
            })     

       }else{
            Swal.fire({
              icon: 'error',
              title: '¡Atención!',
              text: 'Error al actualizar en la base de datos',
              allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
            })
        }
    }
})

}
//funcion paraEliminar Categoria
function EliminarGenero(idGenero){
  $.ajax({
      data: { "idGenero": idGenero },
      url:'../controller/TablasController.php?operador=eliminar_Genero', //url del controlador Conttroller
      type:'POST',
      beforeSend:function(){},
      success:function(response){
          
          if(response == "success"){
               //actualizar tabla
               tablaGenero.ajax.reload();
               swal.fire({
                  icon: "success",
                  title: "Eliminado",
                  text: "El registro se eliminó"   
              })
            
          }else if(response == "llave_uso"){
              swal.fire({
                  icon: "warning",
                  title: "Atención",
                  text: "El registro no se puede eliminar ya que se encuentra en uso.",
                  allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
              })
          }else{
              swal.fire({
                  icon: "error",
                  title: "Atención",
                  text: "No se ha podido eliminar",
                  allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
                  
              })
          }
         
      }

  });

}
function AlertaEliminarGenero(idGenero, descripcion){
  Swal.fire({
    title: '¿Está seguro que desea eliminar?',
    text: "Género: "+descripcion,
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Aceptar',
    cancelButtonText: 'Cancelar',
    allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
  }).then((result) => {
    if (result.isConfirmed) {
      
      EliminarGenero(idGenero); //funcion que eliminar el estado

    }
  })
}
/***************************FUNCIONES DE LA CONTACTO****************************************************************************************************** */

//FUNCION PARA LLENAR LA TABLA DE CATEGORIA AJAX
function LlenarTablaContacto(){
  tablaContacto = $('#tabla_contacto').DataTable({
      pageLength:10,
      responsive: true,
      processign: true,
      "language": {   //para cambiar de idiomas a la tabla
          "lengthMenu": "Mostrar _MENU_ Registro por páginas",
          "zeroRecords": "El registro no existe",
          "info": "Mostrando la página _PAGE_ de _PAGES_",
          "infoEmpty": "No records available",
          "infoFiltered": "(Filtrado de _MAX_ Registros Totales)",
          "search": 'Buscar Registro:',
          "paginate": {
              'next': 'Siguiente',
              'previous': 'Anterior'
          }
      },
      
      ajax: "../controller/TablasController.php?operador=listar_Contacto",
      columns : [
          { data : 'Acciones'},
          { data : 'NO'},  //se ponen los datos del Controller
          { data : 'CONTACTO'}, //se ponen los datos del Controller
          
          
      ]
  });

  let timeout = null;
  // Agregar controlador de eventos para detectar la búsqueda
  $('#tabla_contacto').on('search.dt', function(event) {
   // Limpiar el timeout anterior, si existe
   clearTimeout(timeout);
   
   // Iniciar un nuevo timeout
   timeout = setTimeout(function(){
       // Verificar si la búsqueda actual no está vacía
       if (tablaContacto.search() !== '') {
           // Realizar acciones solo si hay una búsqueda activa
           //TIPOConsulta, ID DE LA PANTALLA, Y DESCRIPCION
           EventoBitacora(2, 15, "Realizo consulta de filtros en LISTADO DE TIPO CONTACTO");
       }
    }, 2000); // Este es el tiempo en milisegundos antes de que se ejecute el código después de que el usuario deja de escribir
  });
}
 //FUNCION PARA REGISTRA UN estado civil AJAX
function RegistrarContacto(){
  descripcion = $('#descripcion_Contacto').val(); //id del modal

  parametros = {
      "Descripcion":descripcion
  }

  $.ajax({
      data:parametros,
      url:"../controller/TablasController.php?operador=registrar_Contacto",
      type:'POST',
      beforeSend:function(){},
      success:function(response){

          if(response == "success"){  //si inserto correctamente
             tablaContacto.ajax.reload();  //actualiza la tablaSSSS
             LimpiarControles();
             $('#registral_Contacto').modal('hide'); //cierra el modal
             Swal.fire({
              icon: 'success',
              title: 'Registro exitoso',
              text: 'Se han guardado correctamente los datos',
              allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
            })
          }else if(response == "requerid"){
              Swal.fire({
                  icon: 'warning',
                  title: '¡Atención!',
                  text: 'Complete todos los campos',
                  allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
                })

          }else if(response == "existe"){
            Swal.fire({
                icon: 'warning',
                title: '¡Atención!',
                text: 'No puedes registrar ya que el contacto ya existe',
                allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
            }) 
          }else{
              Swal.fire({
                  icon: 'error',
                  title: '¡Atención!',
                  text: 'No se lograron guardar los datos',
                  allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
                })
          }
      }
  })
} 
//funcion para obtener el id del cliente para actualizarlo
function ObtenerContactoPorId(idTipoContacto, Acciones){
  $.ajax({
      data: { "idTipoContacto": idTipoContacto },
      url:'../controller/TablasController.php?operador=obtener_contacto_por_id', //url del controlador Conttroller
      type:'POST',
      beforeSend:function(){},
      success:function(response){
         // console.log(response);  //para probar que traiga datos en consola
          data = $.parseJSON(response);
          if(data.length > 0){

            if(Acciones == "editar"){
              $('#id_edit').val(data[0]['ID']);
              $('#descripcion_contacto_edit').val(data[0]['CONTACTO']);  //modal de actualizar estado civil
              

            }else if(Acciones == "eliminar"){
              AlertaEliminarContacto(data[0]['ID'], data[0]['CONTACTO']);
            }
          }
         
      }

  });
}
//funcion para actualizar el estado civil
function ActualizarContacto(){
  idTipoContacto = $('#id_edit').val();  //id de los input del modal de actualizar
  Descripcion = $('#descripcion_contacto_edit').val();
 
  
 
  parametros = {
      "idTipoContacto":idTipoContacto, "Descripcion":Descripcion //parametros que se mandan al controlador: actualizar_estado_civil
  }

  console.log("NOMBRE:"+Descripcion);
  console.log("ID:"+idTipoContacto);
  $.ajax({
    data:parametros,
    url:'../controller/TablasController.php?operador=actualizar_contacto', //url del controlador 
    type:'POST',
    beforeSend:function(){},
    success:function(response){
        if(response == "success"){  //si inserto correctamente
          tablaContacto.ajax.reload();  //actualiza la tabla
           $('#actualizar_Contacto').modal('hide'); //cierra el modal id del modal

          Swal.fire({
            icon: 'success',
            title: 'Actualización Exitosa',
            text: 'Se han actualizado correctamente los datos',
            allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
          })

        }else if(response == "requerid"){
            Swal.fire({
              icon: 'warning',
              title: '¡Atención!',
              text: 'Complete todos los datos por favor',
              allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
            })     
        }else if(response == "existe"){
          Swal.fire({
              icon: 'warning',
              title: '¡Atención!',
              text: 'No puedes actualizar ya que el contacto ya existe',
              allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
          }) 
       }else{
            Swal.fire({
              icon: 'error',
              title: '¡Atención!',
              text: 'Error al actualizar en la base de datos',
              allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
            })
        }
    }
})

}
//funcion paraEliminar Categoria
function EliminarContacto(idTipoContacto){
  $.ajax({
      data: { "idTipoContacto": idTipoContacto },
      url:'../controller/TablasController.php?operador=eliminar_Contacto', //url del controlador Conttroller
      type:'POST',
      beforeSend:function(){},
      success:function(response){
          
          if(response == "success"){
               //actualizar tabla
               tablaContacto.ajax.reload();
               swal.fire({
                  icon: "success",
                  title: "Eliminado",
                  text: "El registro se eliminó"   
              })
            
          }else if(response == "llave_uso"){
              swal.fire({
                  icon: "warning",
                  title: "Atención",
                  text: "El registro no se puede eliminar ya que se encuentra en uso.",
                  allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
              })
          }else{
              swal.fire({
                  icon: "error",
                  title: "Atención",
                  text: "No se ha podido eliminar",
                  allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
                  
              })
          }
         
      }

  });

}
function AlertaEliminarContacto(idTipoContacto, descripcion){
  Swal.fire({
    title: '¿Está seguro que desea eliminar?',
    text: "Contacto: "+descripcion,
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Aceptar',
    cancelButtonText: 'Cancelar',
    allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
  }).then((result) => {
    if (result.isConfirmed) {
      
      EliminarContacto(idTipoContacto); //funcion que eliminar el estado

    }
  })
}

/***************************FUNCIONES DE LA BIENES****************************************************************************************************** */

//FUNCION PARA LLENAR LA TABLA DE BIENES AJAX
function LlenarTablaBienes(){
  tablaBienes = $('#tabla_bienes').DataTable({
      pageLength:10,
      responsive: true,
      processign: true,
      "language": {   //para cambiar de idiomas a la tabla
          "lengthMenu": "Mostrar _MENU_ Registro por páginas",
          "zeroRecords": "El registro no existe",
          "info": "Mostrando la página _PAGE_ de _PAGES_",
          "infoEmpty": "No records available",
          "infoFiltered": "(Filtrado de _MAX_ Registros Totales)",
          "search": 'Buscar Registro:',
          "paginate": {
              'next': 'Siguiente',
              'previous': 'Anterior'
          }
      },
      
      ajax: "../controller/TablasController.php?operador=listar_Bienes",
      columns : [
          { data : 'Acciones'},
          { data : 'NO'},  //se ponen los datos del Controller
          { data : 'BIENES'}, //se ponen los datos del Controller
          
          
      ]
  });

  let timeout = null;
  // Agregar controlador de eventos para detectar la búsqueda
  $('#tabla_bienes').on('search.dt', function(event) {
   // Limpiar el timeout anterior, si existe
   clearTimeout(timeout);
   
   // Iniciar un nuevo timeout
   timeout = setTimeout(function(){
       // Verificar si la búsqueda actual no está vacía
       if (tablaBienes.search() !== '') {
           // Realizar acciones solo si hay una búsqueda activa
           //TIPOConsulta, ID DE LA PANTALLA, Y DESCRIPCION
           EventoBitacora(2, 17, "Realizo consulta de filtros en LISTADO DE BIENES");
       }
    }, 2000); // Este es el tiempo en milisegundos antes de que se ejecute el código después de que el usuario deja de escribir
  });
}
 //FUNCION PARA REGISTRA UN estado civil AJAX
function RegistrarBienes(){
  descripcion = $('#descripcion_Bienes').val(); //id del modal

  parametros = {
      "Descripcion":descripcion
  }

  $.ajax({
      data:parametros,
      url:"../controller/TablasController.php?operador=registrar_Bienes",
      type:'POST',
      beforeSend:function(){},
      success:function(response){

          if(response == "success"){  //si inserto correctamente
             tablaBienes.ajax.reload();  //actualiza la tablaSSSS
             LimpiarControles();
             $('#registral_Bienes').modal('hide'); //cierra el modal
             Swal.fire({
              icon: 'success',
              title: 'Registro exitoso',
              text: 'Se han guardado correctamente los datos',
              allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
            })
          }else if(response == "requerid"){
              Swal.fire({
                  icon: 'warning',
                  title: '¡Atención!',
                  text: 'Complete todos los campos',
                  allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
                })
          }else if(response == "existe"){
            Swal.fire({
                icon: 'warning',
                title: '¡Atención!',
                text: 'No puedes registrar ya existe',
                allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
            }) 
          }else{
              Swal.fire({
                  icon: 'error',
                  title: '¡Atención!',
                  text: 'No se pudieron guardar los datos',
                  allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
                })
          }
      }
  })
} 
//funcion para obtener el id del cliente para actualizarlo
function ObtenerBienesPorId(idPersonaBienes, Acciones){
  $.ajax({
      data: { "idPersonaBienes": idPersonaBienes },
      url:'../controller/TablasController.php?operador=obtener_bienes_por_id', //url del controlador Conttroller
      type:'POST',
      beforeSend:function(){},
      success:function(response){
         // console.log(response);  //para probar que traiga datos en consola
          data = $.parseJSON(response);
          if(data.length > 0){

            if(Acciones == "editar"){
              $('#id_edit').val(data[0]['ID']);
              $('#descripcion_bienes_edit').val(data[0]['BIENES']);  //modal de actualizar persona-bienes
              

            }else if(Acciones == "eliminar"){
              AlertaEliminarBienes(data[0]['ID'], data[0]['BIENES']);
            }
          }
         
      }

  });
}
//funcion para actualizar el estado civil
function ActualizarBienes(){
  idPersonaBienes = $('#id_edit').val();  //id de los input del modal de actualizar
  Descripcion = $('#descripcion_bienes_edit').val();
 
  
 
  parametros = {
      "idPersonaBienes":idPersonaBienes, "Descripcion":Descripcion //parametros que se mandan al controlador: actualizar_estado_civil
  }

  console.log("NOMBRE:"+Descripcion);
  console.log("ID:"+idPersonaBienes);
  $.ajax({
    data:parametros,
    url:'../controller/TablasController.php?operador=actualizar_bienes', //url del controlador 
    type:'POST',
    beforeSend:function(){},
    success:function(response){
        if(response == "success"){  //si inserto correctamente
          tablaBienes.ajax.reload();  //actualiza la tabla
           $('#actualizar_Bienes').modal('hide'); //cierra el modal id del modal

          Swal.fire({
            icon: 'success',
            title: 'Actualización Exitosa',
            text: 'Se han actualizado correctamente los datos',
            allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
          })

        }else if(response == "requerid"){
            Swal.fire({
              icon: 'warning',
              title: '¡Atención!',
              text: 'Complete todos los datos por favor',
              allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
            })     
        }else if(response == "existe"){
          Swal.fire({
              icon: 'warning',
              title: '¡Atención!',
              text: 'No puedes actualizar ya que el tipo de Bienes ya existe',
              allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
          }) 
       }else{
            Swal.fire({
              icon: 'error',
              title: '¡Atención!',
              text: 'Error al actualizar en la base de datos',
              allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
            })
        }
    }
})

}
//funcion paraEliminar Categoria
function EliminarBienes(idPersonaBienes){
  $.ajax({
      data: { "idPersonaBienes": idPersonaBienes },
      url:'../controller/TablasController.php?operador=eliminar_Bienes', //url del controlador Conttroller
      type:'POST',
      beforeSend:function(){},
      success:function(response){
          
          if(response == "success"){
               //actualizar tabla
               tablaBienes.ajax.reload();
               swal.fire({
                  icon: "success",
                  title: "Eliminado",
                  text: "El registro se eliminó"   
              })
            
          }else if(response == "llave_uso"){
              swal.fire({
                  icon: "warning",
                  title: "Atención",
                  text: "El registro no se puede eliminar ya que se encuentra en uso.",
                  allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
              })
          }else{
              swal.fire({
                  icon: "error",
                  title: "Atención",
                  text: "No se ha podido eliminar",
                  allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
                  
              })
          }
         
      }

  });

}
function AlertaEliminarBienes(idPersonaBienes, descripcion){
  Swal.fire({
    title: '¿Está seguro que desea eliminar?',
    text: "Bienes: "+descripcion,
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Aceptar',
    cancelButtonText: 'Cancelar',
    allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
  }).then((result) => {
    if (result.isConfirmed) {
      
      EliminarBienes(idPersonaBienes); //funcion que eliminar el estado

    }
  })
}

/***************************FUNCIONES DE LA NACIONALIDAD****************************************************************************************************** */

//FUNCION PARA LLENAR LA TABLA DE NACIONALIDAD AJAX
function LlenarTablaNacionalidad(){
  tablaNacionalidad = $('#tabla_nacionalidad').DataTable({
      pageLength:10,
      responsive: true,
      processign: true,
      "language": {   //para cambiar de idiomas a la tabla
          "lengthMenu": "Mostrar _MENU_ Registro por páginas",
          "zeroRecords": "El registro no existe",
          "info": "Mostrando la página _PAGE_ de _PAGES_",
          "infoEmpty": "No records available",
          "infoFiltered": "(Filtrado de _MAX_ Registros Totales)",
          "search": 'Buscar Registro:',
          "paginate": {
              'next': 'Siguiente',
              'previous': 'Anterior'
          }
      },
      
      ajax: "../controller/TablasController.php?operador=listar_Nacionalidad",
      columns : [
          { data : 'Acciones'},
          { data : 'NO'},  //se ponen los datos del Controller
          { data : 'NACIONALIDAD'}, //se ponen los datos del Controller
          
          
      ]
  });

  let timeout = null;
  // Agregar controlador de eventos para detectar la búsqueda
  $('#tabla_nacionalidad').on('search.dt', function(event) {
   // Limpiar el timeout anterior, si existe
   clearTimeout(timeout);
   
   // Iniciar un nuevo timeout
   timeout = setTimeout(function(){
       // Verificar si la búsqueda actual no está vacía
       if (tablaNacionalidad.search() !== '') {
           // Realizar acciones solo si hay una búsqueda activa
           //TIPOConsulta, ID DE LA PANTALLA, Y DESCRIPCION
           EventoBitacora(2, 16, "Realizo consulta de filtros en LISTADO DE NACIONALIDADES");
       }
    }, 2000); // Este es el tiempo en milisegundos antes de que se ejecute el código después de que el usuario deja de escribir
  });
}
 //FUNCION PARA REGISTRA UN estado civil AJAX
function RegistrarNacionalidad(){
  descripcion = $('#descripcion_Nacionalidad').val(); //id del modal

  parametros = {
      "Descripcion":descripcion
  }

  $.ajax({
      data:parametros,
      url:"../controller/TablasController.php?operador=registrar_Nacionalidad",
      type:'POST',
      beforeSend:function(){},
      success:function(response){

          if(response == "success"){  //si inserto correctamente
             tablaNacionalidad.ajax.reload();  //actualiza la tablaSSSS
             LimpiarControles();
             $('#registral_Nacionalidad').modal('hide'); //cierra el modal
             Swal.fire({
              icon: 'success',
              title: 'Registro exitoso',
              text: 'Se han guardado correctamente los datos',
              allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
            })
          }else if(response == "existe"){
            Swal.fire({
                icon: 'warning',
                title: '¡Atención!',
                text: 'No puedes registrar la nacionalidad ya existe',
                allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
            }) 
          }else if(response == "requerid"){
              Swal.fire({
                  icon: 'warning',
                  title: '¡Atención!',
                  text: 'Complete todos los campos',
                  allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
                })
          }else{
              Swal.fire({
                  icon: 'error',
                  title: '¡Atención!',
                  text: 'No se lograron guardar los datos',
                  allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
                })
          }
      }
  })
} 
//funcion para obtener el id del cliente para actualizarlo
function ObtenerNacionalidadPorId(idNacionalidad, Acciones){
  $.ajax({
      data: { "idNacionalidad": idNacionalidad },
      url:'../controller/TablasController.php?operador=obtener_nacionalidad_por_id', //url del controlador Conttroller
      type:'POST',
      beforeSend:function(){},
      success:function(response){
         // console.log(response);  //para probar que traiga datos en consola
          data = $.parseJSON(response);
          if(data.length > 0){

            if(Acciones == "editar"){
              $('#id_edit').val(data[0]['ID']);
              $('#descripcion_nacionalidad_edit').val(data[0]['NACIONALIDAD']);  //modal de actualizar estado civil
              

            }else if(Acciones == "eliminar"){
              AlertaEliminarNacionalidad(data[0]['ID'], data[0]['NACIONALIDAD']);
            }
          }
         
      }

  });
}
//funcion para actualizar el estado civil
function ActualizarNacionalidad(){
  idNacionalidad = $('#id_edit').val();  //id de los input del modal de actualizar
  Descripcion = $('#descripcion_nacionalidad_edit').val();
 
  
 
  parametros = {
      "idNacionalidad":idNacionalidad, "Descripcion":Descripcion //parametros que se mandan al controlador: actualizar_estado_civil
  }

  console.log("NOMBRE:"+Descripcion);
  console.log("ID:"+idNacionalidad);
  $.ajax({
    data:parametros,
    url:'../controller/TablasController.php?operador=actualizar_nacionalidad', //url del controlador 
    type:'POST',
    beforeSend:function(){},
    success:function(response){
        if(response == "success"){  //si inserto correctamente
          tablaNacionalidad.ajax.reload();  //actualiza la tabla
           $('#actualizar_Nacionalidad').modal('hide'); //cierra el modal id del modal

          Swal.fire({
            icon: 'success',
            title: 'Actualización Exitosa',
            text: 'Se han actualizado correctamente los datos',
            allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
          })
        }else if(response == "existe"){
          Swal.fire({
              icon: 'warning',
              title: '¡Atención!',
              text: 'No puedes actualizar ya que la nacionalidad ya existe',
              allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
          }) 

        }else if(response == "requerid"){
            Swal.fire({
              icon: 'warning',
              title: '¡Atención!',
              text: 'Complete todos los datos por favor',
              allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
            })     

       }else{
            Swal.fire({
              icon: 'error',
              title: '¡Atención!',
              text: 'Error al actualizar en la base de datos',
              allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
            })
        }
    }
})

}
//funcion paraEliminar Categoria
function EliminarNacionalidad(idNacionalidad){
  $.ajax({
      data: { "idNacionalidad": idNacionalidad },
      url:'../controller/TablasController.php?operador=eliminar_Nacionalidad', //url del controlador Conttroller
      type:'POST',
      beforeSend:function(){},
      success:function(response){
          
          if(response == "success"){
               //actualizar tabla
               tablaNacionalidad.ajax.reload();
               swal.fire({
                  icon: "success",
                  title: "Eliminado",
                  text: "El registro se eliminó"   
              })
            
          }else if(response == "llave_uso"){
              swal.fire({
                  icon: "warning",
                  title: "Atención",
                  text: "El registro no se puede eliminar ya que se encuentra en uso.",
                  allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
              })
          }else{
              swal.fire({
                  icon: "error",
                  title: "Atención",
                  text: "No se ha podido eliminar",
                  allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
                  
              })
          }
         
      }

  });

}
function AlertaEliminarNacionalidad(idNacionalidad, descripcion){
  Swal.fire({
    title: '¿Está seguro que desea eliminar?',
    text: "Nacionalidad: "+descripcion,
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Aceptar',
    cancelButtonText: 'Cancelar',
    allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
  }).then((result) => {
    if (result.isConfirmed) {
      
      EliminarNacionalidad(idNacionalidad); //funcion que eliminar el estado

    }
  })
}
/***************************FUNCIONES DE LA TABLA TIEMPO LABORAL*******************************************************************************/

//FUNCION PARA LLENAR LA TABLA DE TIEMPO LABORAL AJAX
function LlenarTablaLaboral(){
  tablaLaboral = $('#tabla_laboral').DataTable({
      pageLength:10,
      responsive: true,
      processign: true,
      "language": {   //para cambiar de idiomas a la tabla
          "lengthMenu": "Mostrar _MENU_ Registro por páginas",
          "zeroRecords": "El registro no existe",
          "info": "Mostrando la página _PAGE_ de _PAGES_",
          "infoEmpty": "No records available",
          "infoFiltered": "(Filtrado de _MAX_ Registros Totales)",
          "search": 'Buscar Registro:',
          "paginate": {
              'next': 'Siguiente',
              'previous': 'Anterior'
          }
      },
      ajax: "../controller/TablasController.php?operador=listar_Laboral",
      columns : [
          { data : 'Acciones'},
          { data : 'NO'},  //se ponen los datos del Controller
          { data : 'LABORAL'}, //se ponen los datos del Controller
          
          
      ]

    
  });

  let timeout = null;
  // Agregar controlador de eventos para detectar la búsqueda
  $('#tabla_laboral').on('search.dt', function(event) {
   // Limpiar el timeout anterior, si existe
   clearTimeout(timeout);
   
   // Iniciar un nuevo timeout
   timeout = setTimeout(function(){
       // Verificar si la búsqueda actual no está vacía
       if (tablaLaboral.search() !== '') {
           // Realizar acciones solo si hay una búsqueda activa
           //TIPOConsulta, ID DE LA PANTALLA, Y DESCRIPCION
           EventoBitacora(2, 18, "Realizo consulta de filtros en LISTADO DE TIEMPO LABORAL");
       }
    }, 2000); // Este es el tiempo en milisegundos antes de que se ejecute el código después de que el usuario deja de escribir
  });
}

//FUNCION PARA REGISTRA UN estado civil AJAX
function RegistrarLaboral(){
descripcion = $('#descripcion_Laboral').val(); //id del modal

parametros = {
    "descripcion":descripcion
}

$.ajax({
    data:parametros,
    url:"../controller/TablasController.php?operador=registrar_Laboral",
    type:'POST',
    beforeSend:function(){},
    success:function(response){

        if(response == "success"){  //si inserto correctamente
           tablaLaboral.ajax.reload();  //actualiza la tablaSSSS
           LimpiarControles();
           $('#registral_Laboral').modal('hide'); //cierra el modal
           Swal.fire({
            icon: 'success',
            title: 'Registro exitoso',
            text: 'Se han guardado correctamente los datos',
            allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
          })
        }else if(response == "requerid"){
            Swal.fire({
                icon: 'warning',
                title: '¡Atención!',
                text: 'Complete todos los campos',
                allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
              })
        }else if(response == "existe"){
          Swal.fire({
              icon: 'warning',
              title: '¡Atención!',
              text: 'No puedes registrar un dato que ya existe',
              allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
          }) 
        }else{
            Swal.fire({
                icon: 'error',
                title: '¡Atención!',
                text: 'No se lograron guardar los datos',
                allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
              })
        }
    }
})
}
//funcion para obtener el id del cliente para actualizarlo
function ObtenerLaboralPorId(idTiempoLaboral, Acciones){
$.ajax({
    data: { "idTiempoLaboral": idTiempoLaboral },
    url:'../controller/TablasController.php?operador=obtener_laboral_por_id', //url del controlador Conttroller
    type:'POST',
    beforeSend:function(){},
    success:function(response){
       // console.log(response);  //para probar que traiga datos en consola
        data = $.parseJSON(response);
        if(data.length > 0){

          if(Acciones == "editar"){
            $('#id_edit').val(data[0]['ID']);
            $('#descripcion_laboral_edit').val(data[0]['DESCRIPCION']);  //modal de actualizar estado civil
            

          }else if(Acciones == "eliminar"){
            AlertaEliminarLaboral(data[0]['ID'], data[0]['DESCRIPCION']);
          }
        }
       
    }

});
}
//funcion para actualizar el estado civil
function ActualizarLaboral(){
  idTiempoLaboral = $('#id_edit').val();  //id de los input del modal de actualizar
descripcion = $('#descripcion_laboral_edit').val();



parametros = {
    "idTiempoLaboral":idTiempoLaboral, "descripcion":descripcion //parametros que se mandan al controlador: actualizar_estado_civil
}

console.log("NOMBRE:"+descripcion);
console.log("ID:"+idTiempoLaboral);
$.ajax({
  data:parametros,
  url:'../controller/TablasController.php?operador=actualizar_laboral', //url del controlador 
  type:'POST',
  beforeSend:function(){},
  success:function(response){
      if(response == "success"){  //si inserto correctamente
        tablaLaboral.ajax.reload();  //actualiza la tabla
         $('#actualizar_Laboral').modal('hide'); //cierra el modal id del modal

        Swal.fire({
          icon: 'success',
          title: 'Actualización Exitosa',
          text: 'Se han actualizado correctamente los datos',
          allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
        })

      }else if(response == "requerid"){
          Swal.fire({
            icon: 'warning',
            title: '¡Atención!',
            text: 'Complete todos los datos por favor',
            allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
          })     
      }else if(response == "existe"){
        Swal.fire({
            icon: 'warning',
            title: '¡Atención!',
            text: 'No puedes actualizar ya que la tiempo laboral ya existe',
            allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
        }) 
     }else{
          Swal.fire({
            icon: 'error',
            title: '¡Atención!',
            text: 'Error al actualizar en la base de datos',
            allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
          })
      }
  }
})

}

  //funcion paraEliminar un estado civil
  function EliminarLaboral(idTiempoLaboral){
    $.ajax({
        data: { "idTiempoLaboral": idTiempoLaboral },
        url:'../controller/TablasController.php?operador=eliminar_Laboral', //url del controlador Conttroller
        type:'POST',
        beforeSend:function(){},
        success:function(response){
            
            if(response == "success"){
                 //actualizar tabla
                 tablaLaboral.ajax.reload();
                 swal.fire({
                    icon: "success",
                    title: "Eliminado",
                    text: "El registro se eliminó"   
                })
              
            }else if(response == "llave_uso"){
                swal.fire({
                    icon: "warning",
                    title: "Atención",
                    text: "El registro no se puede eliminar ya que se encuentra en uso.",
                    allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
                })
            }else{
                swal.fire({
                    icon: "error",
                    title: "Atención",
                    text: "No se ha podido eliminar",
                    allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
                    
                })
            }
           
        }
  
    });
  
  }
  function AlertaEliminarLaboral(idTiempoLaboral, descripcion){
    Swal.fire({
      title: '¿Está seguro que desea eliminar?',
      text: "Tiempo Laboral: "+descripcion,
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Aceptar',
      cancelButtonText: 'Cancelar',
      allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
    }).then((result) => {
      if (result.isConfirmed) {
        
        EliminarLaboral(idTiempoLaboral); //funcion que eliminar el estado
  
      }
    })
  }

/***************************FUNCIONES DE LA ESTADO PLAN PAGO****************************************************************************************************** */

//FUNCION PARA LLENAR LA TABLA DE NACIONALIDAD AJAX
function LlenarTablaEstadoplanpago(){
  tablaEstadoplanpago= $('#tabla_estadoplanpago').DataTable({
      pageLength:10,
      responsive: true,
      processign: true,
      "language": {   //para cambiar de idiomas a la tabla
          "lengthMenu": "Mostrar _MENU_ Registro por páginas",
          "zeroRecords": "El registro no existe",
          "info": "Mostrando la página _PAGE_ de _PAGES_",
          "infoEmpty": "No records available",
          "infoFiltered": "(Filtrado de _MAX_ Registros Totales)",
          "search": 'Buscar Registro:',
          "paginate": {
              'next': 'Siguiente',
              'previous': 'Anterior'
          }
      },
      
      ajax: "../controller/TablasController.php?operador=listar_Estadoplanpago",
      columns : [
          { data : 'Acciones'},
          { data : 'NO'},  //se ponen los datos del Controller
          { data : 'ESTADOPLANPAGO'}, //se ponen los datos del Controller
          
          
      ]
  });

  let timeout = null;
  // Agregar controlador de eventos para detectar la búsqueda
  $('#tabla_estadoplanpago').on('search.dt', function(event) {
   // Limpiar el timeout anterior, si existe
   clearTimeout(timeout);
   
   // Iniciar un nuevo timeout
   timeout = setTimeout(function(){
       // Verificar si la búsqueda actual no está vacía
       if (tablaEstadoplanpago.search() !== '') {
           // Realizar acciones solo si hay una búsqueda activa
           //TIPOConsulta, ID DE LA PANTALLA, Y DESCRIPCION
           EventoBitacora(2, 19, "Realizo consulta de filtros en LISTADO DE ESTADO PLAN DE PAGOS");
       }
    }, 2000); // Este es el tiempo en milisegundos antes de que se ejecute el código después de que el usuario deja de escribir
  });
}
 //FUNCION PARA REGISTRA UN estado civil AJAX
function RegistrarEstadoplanpago(){
  descripcion = $('#descripcion_estadoplanpago').val(); //id del modal

  parametros = {
      "Descripcion":descripcion
  }

  $.ajax({
      data:parametros,
      url:"../controller/TablasController.php?operador=registrar_Estadoplanpago",
      type:'POST',
      beforeSend:function(){},
      success:function(response){

          if(response == "success"){  //si inserto correctamente
             tablaEstadoplanpago.ajax.reload();  //actualiza la tablaSSSS
             LimpiarControles();
             $('#registral_estadoplanpago').modal('hide'); //cierra el modal
             Swal.fire({
              icon: 'success',
              title: 'Registro exitoso',
              text: 'Se han guardado correctamente los datos',
              allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
            })
          }else if(response == "requerid"){
              Swal.fire({
                  icon: 'warning',
                  title: '¡Atención!',
                  text: 'Complete todos los campos',
                  allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
                })
          }else if(response == "existe"){
            Swal.fire({
                icon: 'warning',
                title: '¡Atención!',
                text: 'No puedes registrar un plan de pagos que ya existe',
                allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
            }) 
          }else{
              Swal.fire({
                  icon: 'error',
                  title: '¡Atención!',
                  text: 'No se lograron guardar los datos',
                  allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
                })
          }
      }
  })
} 
//funcion para obtener el id del cliente para actualizarlo
function ObtenerEstadoplanpagoPorId(idEstadoPlanPagos, Acciones){
  $.ajax({
      data: { "idEstadoPlanPagos": idEstadoPlanPagos },
      url:'../controller/TablasController.php?operador=obtener_estadoplanpago_por_id', //url del controlador Conttroller
      type:'POST',
      beforeSend:function(){},
      success:function(response){
         // console.log(response);  //para probar que traiga datos en consola
          data = $.parseJSON(response);
          if(data.length > 0){

            if(Acciones == "editar"){
              $('#id_edit').val(data[0]['ID']);
              $('#descripcion_estadoplanpago_edit').val(data[0]['ESTADOPLANPAGO']);  //modal de actualizar estado civil
              

            }else if(Acciones == "eliminar"){
              AlertaEliminarEstadoplanpago(data[0]['ID'], data[0]['ESTADOPLANPAGO']);
            }
          }
         
      }

  });
}
//funcion para actualizar el estado civil
function ActualizarEstadoplanpago(){
  idEstadoPlanPagos = $('#id_edit').val();  //id de los input del modal de actualizar
  Descripcion = $('#descripcion_estadoplanpago_edit').val();
 
  
 
  parametros = {
      "idEstadoPlanPagos":idEstadoPlanPagos, "Descripcion":Descripcion //parametros que se mandan al controlador: actualizar_estado_civil
  }

  console.log("NOMBRE:"+Descripcion);
  console.log("ID:"+idEstadoPlanPagos);
  $.ajax({
    data:parametros,
    url:'../controller/TablasController.php?operador=actualizar_estadoplanpago', //url del controlador 
    type:'POST',
    beforeSend:function(){},
    success:function(response){
        if(response == "success"){  //si inserto correctamente
          tablaEstadoplanpago.ajax.reload();  //actualiza la tabla
           $('#actualizar_Estadoplanpago').modal('hide'); //cierra el modal id del modal

          Swal.fire({
            icon: 'success',
            title: 'Actualización Exitosa',
            text: 'Se han actualizado correctamente los datos',
            allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
          })

        }else if(response == "requerid"){
            Swal.fire({
              icon: 'warning',
              title: '¡Atención!',
              text: 'Complete todos los datos por favor',
              allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
            })
        }else if(response == "existe"){
          Swal.fire({
              icon: 'warning',
              title: '¡Atención!',
              text: 'No puedes actualizar a un plan de pagos que ya existe',
              allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
          }) 

       }else{
            Swal.fire({
              icon: 'error',
              title: '¡Atención!',
              text: 'Error al actualizar en la base de datos',
              allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
            })
        }
    }
})

}
//funcion paraEliminar Categoria
function EliminarEstadoplanpago(idEstadoPlanPagos){
  $.ajax({
      data: { "idEstadoPlanPagos": idEstadoPlanPagos },
      url:'../controller/TablasController.php?operador=eliminar_Estadoplanpago', //url del controlador Conttroller
      type:'POST',
      beforeSend:function(){},
      success:function(response){
          
          if(response == "success"){
               //actualizar tabla
               tablaEstadoplanpago.ajax.reload();
               swal.fire({
                  icon: "success",
                  title: "Eliminado",
                  text: "El registro se eliminó"   
              })
            
          }else if(response == "llave_uso"){
              swal.fire({
                  icon: "warning",
                  title: "Atención",
                  text: "El registro no se puede eliminar ya que se encuentra en uso.",
                  allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
              })
          }else{
              swal.fire({
                  icon: "error",
                  title: "Atención",
                  text: "No se ha podido eliminar",
                  allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
                  
              })
          }
         
      }

  });

}
function AlertaEliminarEstadoplanpago(idEstadoPlanPagos, descripcion){
  Swal.fire({
    title: '¿Está seguro que desea eliminar?',
    text: "Estado Plan de Pago: "+descripcion,
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Aceptar',
    cancelButtonText: 'Cancelar',
    allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
  }).then((result) => {
    if (result.isConfirmed) {
      
      EliminarEstadoplanpago(idEstadoPlanPagos); //funcion que eliminar el estado

    }
  })
}

/***************************FUNCIONES DE LA TABLA TIEMPO VIVIR*******************************************************************************/

//FUNCION PARA LLENAR LA TABLA DE TIEMPO VIVIR AJAX
function LlenarTablaTiempovivir(){
  tablaTiempovivir = $('#tabla_tiempovivir').DataTable({
      pageLength:10,
      responsive: true,
      processign: true,
      "language": {   //para cambiar de idiomas a la tabla
          "lengthMenu": "Mostrar _MENU_ Registro por páginas",
          "zeroRecords": "El registro no existe",
          "info": "Mostrando la página _PAGE_ de _PAGES_",
          "infoEmpty": "No records available",
          "infoFiltered": "(Filtrado de _MAX_ Registros Totales)",
          "search": 'Buscar Registro:',
          "paginate": {
              'next': 'Siguiente',
              'previous': 'Anterior'
          }
      },
      ajax: "../controller/TablasController.php?operador=listar_Tiempovivir",
      columns : [
          { data : 'Acciones'},
          { data : 'NO'},  //se ponen los datos del Controller
          { data : 'TIEMPOVIVIR'}, //se ponen los datos del Controller
          
          
      ]

  });

  let timeout = null;
  // Agregar controlador de eventos para detectar la búsqueda
  $('#tabla_tiempovivir').on('search.dt', function(event) {
   // Limpiar el timeout anterior, si existe
   clearTimeout(timeout);
   
   // Iniciar un nuevo timeout
   timeout = setTimeout(function(){
       // Verificar si la búsqueda actual no está vacía
       if (tablaTiempovivir.search() !== '') {
           // Realizar acciones solo si hay una búsqueda activa
           //TIPOConsulta, ID DE LA PANTALLA, Y DESCRIPCION
           EventoBitacora(2, 20, "Realizo consulta de filtros en LISTADO DE TIEMPO DE VIVIR");
       }
    }, 2000); // Este es el tiempo en milisegundos antes de que se ejecute el código después de que el usuario deja de escribir
  });
}

//FUNCION PARA REGISTRA UN estado civil AJAX
function RegistrarTiempovivir(){
descripcion = $('#descripcion_Tiempovivir').val(); //id del modal

parametros = {
    "descripcion":descripcion
}

$.ajax({
    data:parametros,
    url:"../controller/TablasController.php?operador=registrar_Tiempovivir",
    type:'POST',
    beforeSend:function(){},
    success:function(response){

        if(response == "success"){  //si inserto correctamente
           tablaTiempovivir.ajax.reload();  //actualiza la tablaSSSS
           LimpiarControles();
           $('#registral_Tiempovivir').modal('hide'); //cierra el modal
           Swal.fire({
            icon: 'success',
            title: 'Registro exitoso',
            text: 'Se han guardado correctamente los datos',
            allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
          })

        }else if(response == "existe"){
          Swal.fire({
              icon: 'warning',
              title: '¡Atención!',
              text: 'No puedes registrar un tiempo de vivir que ya existe',
              allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
          })
        }else if(response == "requerid"){
            Swal.fire({
                icon: 'warning',
                title: '¡Atención!',
                text: 'Complete todos los campos',
                allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
              })
        }else{
            Swal.fire({
                icon: 'error',
                title: '¡Atención!',
                text: 'No se lograron guardar los datos',
                allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
              })
        }
    }
})
}
//funcion para obtener el id del cliente para actualizarlo
function ObtenerTiempovivirPorId(idtiempoVivir, Acciones){
$.ajax({
    data: { "idtiempoVivir": idtiempoVivir },
    url:'../controller/TablasController.php?operador=obtener_tiempovivir_por_id', //url del controlador Conttroller
    type:'POST',
    beforeSend:function(){},
    success:function(response){
       // console.log(response);  //para probar que traiga datos en consola
        data = $.parseJSON(response);
        if(data.length > 0){

          if(Acciones == "editar"){
            $('#id_edit').val(data[0]['ID']);
            $('#descripcion_tiempovivir_edit').val(data[0]['DESCRIPCION']);  //modal de actualizar estado civil
            

          }else if(Acciones == "eliminar"){
            AlertaEliminarTiempovivir(data[0]['ID'], data[0]['DESCRIPCION']);
          }
        }
       
    }

});
}
//funcion para actualizar el estado civil
function ActualizarTiempovivir(){
  idtiempoVivir = $('#id_edit').val();  //id de los input del modal de actualizar
descripcion = $('#descripcion_tiempovivir_edit').val();



parametros = {
    "idtiempoVivir":idtiempoVivir, "descripcion":descripcion //parametros que se mandan al controlador: actualizar_estado_civil
}

console.log("NOMBRE:"+descripcion);
console.log("ID:"+idtiempoVivir);
$.ajax({
  data:parametros,
  url:'../controller/TablasController.php?operador=actualizar_tiempovivir', //url del controlador 
  type:'POST',
  beforeSend:function(){},
  success:function(response){
      if(response == "success"){  //si inserto correctamente
        tablaTiempovivir.ajax.reload();  //actualiza la tabla
         $('#actualizar_Tiempovivir').modal('hide'); //cierra el modal id del modal

        Swal.fire({
          icon: 'success',
          title: 'Actualización Exitosa',
          text: 'Se han actualizado correctamente los datos',
          allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
        })
      }else if(response == "existe"){
        Swal.fire({
            icon: 'warning',
            title: '¡Atención!',
            text: 'No puedes actualizar a un tiempo de vivir que ya existe',
            allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
        })
      }else if(response == "requerid"){
          Swal.fire({
            icon: 'warning',
            title: '¡Atención!',
            text: 'Complete todos los datos por favor',
            allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
          })     

     }else{
          Swal.fire({
            icon: 'error',
            title: '¡Atención!',
            text: 'Error al actualizar en la base de datos',
            allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
          })
      }
  }
})

}

  //funcion paraEliminar un estado civil
  function EliminarTiempovivir(idtiempoVivir){
    $.ajax({
        data: { "idtiempoVivir": idtiempoVivir },
        url:'../controller/TablasController.php?operador=eliminar_Tiempovivir', //url del controlador Conttroller
        type:'POST',
        beforeSend:function(){},
        success:function(response){
            
            if(response == "success"){
                 //actualizar tabla
                 tablaTiempovivir.ajax.reload();
                 swal.fire({
                    icon: "success",
                    title: "Eliminado",
                    text: "El registro se eliminó"   
                })
              
            }else if(response == "llave_uso"){
                swal.fire({
                    icon: "warning",
                    title: "Atención",
                    text: "El registro no se puede eliminar ya que se encuentra en uso.",
                    allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
                })
            }else{
                swal.fire({
                    icon: "error",
                    title: "Atención",
                    text: "No se ha podido eliminar",
                    allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
                    
                })
            }
           
        }
  
    });
  
  }
  function AlertaEliminarTiempovivir(idtiempoVivir, descripcion){
    Swal.fire({
      title: '¿Está seguro que desea eliminar?',
      text: "Tiempo de Vivir: "+descripcion,
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Aceptar',
      cancelButtonText: 'Cancelar',
      allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
    }).then((result) => {
      if (result.isConfirmed) {
        
        EliminarTiempovivir(idtiempoVivir); //funcion que eliminar el estado
  
      }
    })
  }
/***************************FUNCIONES DE LA TABLA ESTADO TIPO PRESTAMO*******************************************************************************/

//FUNCION PARA LLENAR LA TABLA DE TIEMPO VIVIR AJAX
function LlenarTablaEstadotipoprestamo(){
  tablaEstadotipoprestamo = $('#tabla_Estadotipoprestamo').DataTable({
      pageLength:10,
      responsive: true,
      processign: true,
      "language": {   //para cambiar de idiomas a la tabla
          "lengthMenu": "Mostrar _MENU_ Registro por páginas",
          "zeroRecords": "El registro no existe",
          "info": "Mostrando la página _PAGE_ de _PAGES_",
          "infoEmpty": "No records available",
          "infoFiltered": "(Filtrado de _MAX_ Registros Totales)",
          "search": 'Buscar Registro:',
          "paginate": {
              'next': 'Siguiente',
              'previous': 'Anterior'
          }
      },
      ajax: "../controller/TablasController.php?operador=listar_Estadotipoprestamo",
      columns : [
          { data : 'Acciones'},
          { data : 'NO'},  //se ponen los datos del Controller
          { data : 'ESTADOTIPOPRESTAMO'}, //se ponen los datos del Controller
          
          
      ]

     

  });
  let timeout = null;
  // Agregar controlador de eventos para detectar la búsqueda
  $('#tabla_Estadotipoprestamo').on('search.dt', function(event) {
   // Limpiar el timeout anterior, si existe
   clearTimeout(timeout);
   
   // Iniciar un nuevo timeout
   timeout = setTimeout(function(){
       // Verificar si la búsqueda actual no está vacía
       if (tablaEstadotipoprestamo.search() !== '') {
           // Realizar acciones solo si hay una búsqueda activa
           //TIPOConsulta, ID DE LA PANTALLA, Y DESCRIPCION
           EventoBitacora(2, 21, "Realizo consulta de filtros en LISTADO DE ESTADO TIPO PRÉSTAMO");
       }
    }, 2000); // Este es el tiempo en milisegundos antes de que se ejecute el código después de que el usuario deja de escribir
  });
}

//FUNCION PARA REGISTRA UN estado civil AJAX
function RegistrarEstadotipoprestamo(){
descripcion = $('#descripcion_Estadotipoprestamo').val(); //id del modal

parametros = {
    "descripcion":descripcion
}

$.ajax({
    data:parametros,
    url:"../controller/TablasController.php?operador=registrar_Estadotipoprestamo",
    type:'POST',
    beforeSend:function(){},
    success:function(response){

        if(response == "success"){  //si inserto correctamente
           tablaEstadotipoprestamo.ajax.reload();  //actualiza la tablaSSSS
           LimpiarControles();
           $('#registral_Estadotipoprestamo').modal('hide'); //cierra el modal
           Swal.fire({
            icon: 'success',
            title: 'Registro exitoso',
            text: 'Se han guardado correctamente los datos',
            allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
          })
        }else if(response == "requerid"){
            Swal.fire({
                icon: 'warning',
                title: '¡Atención!',
                text: 'Complete todos los campos',
                allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
              })
        }else{
            Swal.fire({
                icon: 'error',
                title: '¡Atención!',
                text: 'No se lograron guardar los datos',
                allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
              })
        }
    }
})
}
//funcion para obtener el id del cliente para actualizarlo
function ObtenerEstadotipoprestamoPorId(idestadoTipoPrestamo, Acciones){
$.ajax({
    data: { "idestadoTipoPrestamo": idestadoTipoPrestamo },
    url:'../controller/TablasController.php?operador=obtener_estamotipoprestamo_por_id', //url del controlador Conttroller
    type:'POST',
    beforeSend:function(){},
    success:function(response){
       // console.log(response);  //para probar que traiga datos en consola
        data = $.parseJSON(response);
        if(data.length > 0){

          if(Acciones == "editar"){
            $('#id_edit').val(data[0]['ID']);
            $('#descripcion_estadotipoprestamo_edit').val(data[0]['DESCRIPCION']);  //modal de actualizar estado civil
            

          }else if(Acciones == "eliminar"){
            AlertaEliminarEstadotipoprestamo(data[0]['ID'], data[0]['DESCRIPCION']);
          }
        }
       
    }

});
}
//funcion para actualizar el estado civil
function ActualizarEstadotipoprestamo(){
  idestadoTipoPrestamo = $('#id_edit').val();  //id de los input del modal de actualizar
descripcion = $('#descripcion_estadotipoprestamo_edit').val();



parametros = {
    "idestadoTipoPrestamo":idestadoTipoPrestamo, "descripcion":descripcion //parametros que se mandan al controlador: actualizar_estado_civil
}

console.log("NOMBRE:"+descripcion);
console.log("ID:"+idestadoTipoPrestamo);
$.ajax({
  data:parametros,
  url:'../controller/TablasController.php?operador=actualizar_estadotipoprestamo', //url del controlador 
  type:'POST',
  beforeSend:function(){},
  success:function(response){
      if(response == "success"){  //si inserto correctamente
        tablaEstadotipoprestamo.ajax.reload();  //actualiza la tabla
         $('#actualizar_Estadotipoprestamo').modal('hide'); //cierra el modal id del modal

        Swal.fire({
          icon: 'success',
          title: 'Actualización Exitosa',
          text: 'Se han actualizado correctamente los datos',
          allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
        })

      }else if(response == "requerid"){
          Swal.fire({
            icon: 'warning',
            title: '¡Atención!',
            text: 'Complete todos los datos por favor',
            allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
          })     

     }else{
          Swal.fire({
            icon: 'error',
            title: '¡Atención!',
            text: 'Error al actualizar en la base de datos',
            allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
          })
      }
  }
})

}

  //funcion paraEliminar un estado civil
  function EliminarEstadotipoprestamo(idestadoTipoPrestamo){
    $.ajax({
        data: { "idestadoTipoPrestamo": idestadoTipoPrestamo },
        url:'../controller/TablasController.php?operador=eliminar_Estadotipoprestamo', //url del controlador Conttroller
        type:'POST',
        beforeSend:function(){},
        success:function(response){
            
            if(response == "success"){
                 //actualizar tabla
                 tablaEstadotipoprestamo.ajax.reload();
                 swal.fire({
                    icon: "success",
                    title: "Eliminado",
                    text: "El registro se eliminó"   
                })
              
            }else if(response == "llave_uso"){
                swal.fire({
                    icon: "warning",
                    title: "Atención",
                    text: "El registro no se puede eliminar ya que se encuentra en uso.",
                    allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
                })
            }else{
                swal.fire({
                    icon: "error",
                    title: "Atención",
                    text: "No se ha podido eliminar",
                    allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
                    
                })
            }
           
        }
  
    });
  
  }
  function AlertaEliminarEstadotipoprestamo(idestadoTipoPrestamo, descripcion){
    Swal.fire({
      title: '¿Está seguro que desea eliminar?',
      text: "Estado Tipo del Préstamo: "+descripcion,
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Aceptar',
      cancelButtonText: 'Cancelar',
      allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
    }).then((result) => {
      if (result.isConfirmed) {
        
        EliminarEstadotipoprestamo(idestadoTipoPrestamo); //funcion que eliminar el estado
  
      }
    })
  }
/***************************FUNCIONES DE LA ESTADO SOLICITUD****************************************************************************************************** */

//FUNCION PARA LLENAR LA TABLA DE NACIONALIDAD AJAX
function LlenarTablaEstadosolicitud(){
  tablaEstadosolicitud= $('#tabla_estadosolicitud').DataTable({
      pageLength:10,
      responsive: true,
      processign: true,
      "language": {   //para cambiar de idiomas a la tabla
          "lengthMenu": "Mostrar _MENU_ Registro por páginas",
          "zeroRecords": "El registro no existe",
          "info": "Mostrando la página _PAGE_ de _PAGES_",
          "infoEmpty": "No records available",
          "infoFiltered": "(Filtrado de _MAX_ Registros Totales)",
          "search": 'Buscar Registro:',
          "paginate": {
              'next': 'Siguiente',
              'previous': 'Anterior'
          }
      },
      
      ajax: "../controller/TablasController.php?operador=listar_Estadosolicitud",
      columns : [
          { data : 'Acciones'},
          { data : 'NO'},  //se ponen los datos del Controller
          { data : 'ESTADOSOLICITUD'}, //se ponen los datos del Controller
          
          
      ]
  });

  let timeout = null;
  // Agregar controlador de eventos para detectar la búsqueda
  $('#tabla_estadosolicitud').on('search.dt', function(event) {
   // Limpiar el timeout anterior, si existe
   clearTimeout(timeout);
   
   // Iniciar un nuevo timeout
   timeout = setTimeout(function(){
       // Verificar si la búsqueda actual no está vacía
       if (tablaEstadosolicitud.search() !== '') {
           // Realizar acciones solo si hay una búsqueda activa
           //TIPOConsulta, ID DE LA PANTALLA, Y DESCRIPCION
           EventoBitacora(2, 22, "Realizo consulta de filtros en LISTADO DE ESTADO DE SOLICITUDES");
       }
    }, 2000); // Este es el tiempo en milisegundos antes de que se ejecute el código después de que el usuario deja de escribir
  });
}
 //FUNCION PARA REGISTRA UN estado civil AJAX
function RegistrarEstadosolicitud(){
  descripcion = $('#descripcion_estadosolicitud').val(); //id del modal

  parametros = {
      "Descripcion":descripcion
  }

  $.ajax({
      data:parametros,
      url:"../controller/TablasController.php?operador=registrar_Estadosolicitud",
      type:'POST',
      beforeSend:function(){},
      success:function(response){

          if(response == "success"){  //si inserto correctamente
             tablaEstadosolicitud.ajax.reload();  //actualiza la tablaSSSS
             LimpiarControles();
             $('#registral_Estadosolicitud').modal('hide'); //cierra el modal
             Swal.fire({
              icon: 'success',
              title: 'Registro exitoso',
              text: 'Se ha guardado correctamente los datos',
              allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
            })

          }else if(response == "existe"){
            Swal.fire({
                icon: 'warning',
                title: '¡Atención!',
                text: 'No puedes registrar un estado de solicitud que ya existe',
                allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
            })
          }else if(response == "requerid"){
              Swal.fire({
                  icon: 'warning',
                  title: '¡Atención!',
                  text: 'Complete todos los campos',
                  allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
                })
          }else{
              Swal.fire({
                  icon: 'error',
                  title: '¡Atención!',
                  text: 'No se lograron guardar los datos',
                  allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
                })
          }
      }
  })
} 
//funcion para obtener el id del cliente para actualizarlo
function ObtenerEstadosolicitudPorId(idEstadoSolicitud, Acciones){
  $.ajax({
      data: { "idEstadoSolicitud": idEstadoSolicitud },
      url:'../controller/TablasController.php?operador=obtener_estadosolicitud_por_id', //url del controlador Conttroller
      type:'POST',
      beforeSend:function(){},
      success:function(response){
         // console.log(response);  //para probar que traiga datos en consola
          data = $.parseJSON(response);
          if(data.length > 0){

            if(Acciones == "editar"){
              $('#id_edit').val(data[0]['ID']);
              $('#descripcion_estadosolicitud_edit').val(data[0]['ESTADOSOLICITUD']);  //modal de actualizar estado civil
              

            }else if(Acciones == "eliminar"){
              AlertaEliminarEstadosolicitud(data[0]['ID'], data[0]['ESTADOSOLICITUD']);
            }
          }
         
      }

  });
}
//funcion para actualizar el estado civil
function ActualizarEstadosolicitud(){
  idEstadoSolicitud = $('#id_edit').val();  //id de los input del modal de actualizar
  Descripcion = $('#descripcion_estadosolicitud_edit').val();
 
  
 
  parametros = {
      "idEstadoSolicitud":idEstadoSolicitud, "Descripcion":Descripcion //parametros que se mandan al controlador: actualizar_estado_civil
  }

  console.log("NOMBRE:"+Descripcion);
  console.log("ID:"+idEstadoSolicitud);
  $.ajax({
    data:parametros,
    url:'../controller/TablasController.php?operador=actualizar_estadosolicitud', //url del controlador 
    type:'POST',
    beforeSend:function(){},
    success:function(response){
        if(response == "success"){  //si inserto correctamente
          tablaEstadosolicitud.ajax.reload();  //actualiza la tabla
           $('#actualizar_Estadosolicitud').modal('hide'); //cierra el modal id del modal

          Swal.fire({
            icon: 'success',
            title: 'Actualización Exitosa',
            text: 'Se han actualizado correctamente los datos',
            allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
          })
        }else if(response == "existe"){
          Swal.fire({
              icon: 'warning',
              title: '¡Atención!',
              text: 'No puedes actualizar a un estado de solicitud que ya existe',
              allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
          })
        }else if(response == "requerid"){
            Swal.fire({
              icon: 'warning',
              title: '¡Atención!',
              text: 'Complete todos los datos por favor',
              allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
            })     

       }else{
            Swal.fire({
              icon: 'error',
              title: '¡Atención!',
              text: 'Error al actualizar en la base de datos',
              allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
            })
        }
    }
})

}
//funcion paraEliminar Categoria
function EliminarEstadosolicitud(idEstadoSolicitud){
  $.ajax({
      data: { "idEstadoSolicitud": idEstadoSolicitud },
      url:'../controller/TablasController.php?operador=eliminar_Estadosolicitud', //url del controlador Conttroller
      type:'POST',
      beforeSend:function(){},
      success:function(response){
          
          if(response == "success"){
               //actualizar tabla
               tablaEstadosolicitud.ajax.reload();
               swal.fire({
                  icon: "success",
                  title: "Eliminado",
                  text: "El registro se eliminó"   
              })
            
          }else if(response == "llave_uso"){
              swal.fire({
                  icon: "warning",
                  title: "Atención",
                  text: "El registro no se puede eliminar ya que se encuentra en uso.",
                  allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
              })
          }else{
              swal.fire({
                  icon: "error",
                  title: "Atención",
                  text: "No se ha podido eliminar",
                  allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
                  
              })
          }
         
      }

  });

}
function AlertaEliminarEstadosolicitud(idEstadoSolicitud, descripcion){
  Swal.fire({
    title: '¿Está seguro que desea eliminar?',
    text: "Estado Solicitud: "+descripcion,
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Aceptar',
    cancelButtonText: 'Cancelar',
    allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
  }).then((result) => {
    if (result.isConfirmed) {
      
      EliminarEstadosolicitud(idEstadoSolicitud); //funcion que eliminar el estado

    }
  })
}
/***************************FUNCIONES DE LA RUBRO****************************************************************************************************** */

//FUNCION PARA LLENAR LA TABLA DE NACIONALIDAD AJAX
function LlenarTablaRubro(){
  tablaRubro= $('#tabla_rubro').DataTable({
      pageLength:10,
      responsive: true,
      processign: true,
      "language": {   //para cambiar de idiomas a la tabla
          "lengthMenu": "Mostrar _MENU_ Registro por páginas",
          "zeroRecords": "El registro no existe",
          "info": "Mostrando la página _PAGE_ de _PAGES_",
          "infoEmpty": "No records available",
          "infoFiltered": "(Filtrado de _MAX_ Registros Totales)",
          "search": 'Buscar Registro:',
          "paginate": {
              'next': 'Siguiente',
              'previous': 'Anterior'
          }
      },
      
      ajax: "../controller/TablasController.php?operador=listar_Rubro",
      columns : [
          { data : 'Acciones'},
          { data : 'NO'},  //se ponen los datos del Controller
          { data : 'RUBRO'}, //se ponen los datos del Controller
          
          
      ]
  });
  let timeout = null;

    // Agregar controlador de eventos para detectar la búsqueda
    $('#tabla_rubro').on('search.dt', function(event) {
        // Limpiar el timeout anterior, si existe
        clearTimeout(timeout);
        
        // Iniciar un nuevo timeout
        timeout = setTimeout(function(){
            // Verificar si la búsqueda actual no está vacía
            if (tablaRubro.search() !== '') {
                // Realizar acciones solo si hay una búsqueda activa
                //TIPOConsulta, ID DE LA PANTALLA, Y DESCRIPCION
                EventoBitacora(2, 23, "Realizo consulta de filtros en LISTADO DE RUBROS");
            }
        }, 2000); // Este es el tiempo en milisegundos antes de que se ejecute el código después de que el usuario deja de escribir
    });
}
 //FUNCION PARA REGISTRA UN estado civil AJAX
function RegistrarRubro(){
  descripcion = $('#descripcion_rubro').val(); //id del modal

  parametros = {
      "Descripcion":descripcion
  }

  $.ajax({
      data:parametros,
      url:"../controller/TablasController.php?operador=registrar_Rubro",
      type:'POST',
      beforeSend:function(){},
      success:function(response){

          if(response == "success"){  //si inserto correctamente
             tablaRubro.ajax.reload();  //actualiza la tablaSSSS
             LimpiarControles();
             $('#registral_Rubro').modal('hide'); //cierra el modal
             Swal.fire({
              icon: 'success',
              title: 'Registro exitoso',
              text: 'Se ha guardado correctamente los datos',
              allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
            })
          }else if(response == "requerid"){
              Swal.fire({
                  icon: 'warning',
                  title: '¡Atención!',
                  text: 'Complete todos los campos',
                  allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
                })
          }else{
              Swal.fire({
                  icon: 'error',
                  title: '¡Atención!',
                  text: 'No se lograron guardar los datos',
                  allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
                })
          }
      }
  })
} 
//funcion para obtener el id del cliente para actualizarlo
function ObtenerRubroPorId(idRubro, Acciones){
  $.ajax({
      data: { "idRubro": idRubro },
      url:'../controller/TablasController.php?operador=obtener_rubro_por_id', //url del controlador Conttroller
      type:'POST',
      beforeSend:function(){},
      success:function(response){
         // console.log(response);  //para probar que traiga datos en consola
          data = $.parseJSON(response);
          if(data.length > 0){

            if(Acciones == "editar"){
              $('#id_edit').val(data[0]['ID']);
              $('#descripcion_rubro_edit').val(data[0]['RUBRO']);  //modal de actualizar estado civil
              

            }else if(Acciones == "eliminar"){
              AlertaEliminarRubro(data[0]['ID'], data[0]['RUBRO']);
            }
          }
         
      }

  });
}
//funcion para actualizar el estado civil
function ActualizarRubro(){
  idRubro = $('#id_edit').val();  //id de los input del modal de actualizar
  Descripcion = $('#descripcion_rubro_edit').val();
 
  
 
  parametros = {
      "idRubro":idRubro, "Descripcion":Descripcion //parametros que se mandan al controlador: actualizar_estado_civil
  }

  console.log("NOMBRE:"+Descripcion);
  console.log("ID:"+idRubro);
  $.ajax({
    data:parametros,
    url:'../controller/TablasController.php?operador=actualizar_rubro', //url del controlador 
    type:'POST',
    beforeSend:function(){},
    success:function(response){
        if(response == "success"){  //si inserto correctamente
          tablaRubro.ajax.reload();  //actualiza la tabla
           $('#actualizar_Rubro').modal('hide'); //cierra el modal id del modal

          Swal.fire({
            icon: 'success',
            title: 'Actualización Exitosa',
            text: 'Se han actualizado correctamente los datos',
            allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
          })

        }else if(response == "requerid"){
            Swal.fire({
              icon: 'warning',
              title: '¡Atención!',
              text: 'Complete todos los datos por favor',
              allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
            })     

       }else{
            Swal.fire({
              icon: 'error',
              title: '¡Atención!',
              text: 'Error al actualizar en la base de datos',
              allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
            })
        }
    }
})

}
//funcion paraEliminar Categoria
function EliminarRubro(idRubro){
  $.ajax({
      data: { "idRubro": idRubro },
      url:'../controller/TablasController.php?operador=eliminar_Rubro', //url del controlador Conttroller
      type:'POST',
      beforeSend:function(){},
      success:function(response){
          
          if(response == "success"){
               //actualizar tabla
               tablaRubro.ajax.reload();
               swal.fire({
                  icon: "success",
                  title: "Eliminado",
                  text: "El registro se eliminó"   
              })
            
          }else if(response == "llave_uso"){
              swal.fire({
                  icon: "warning",
                  title: "Atención",
                  text: "El registro no se puede eliminar ya que se encuentra en uso.",
                  allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
              })
          }else{
              swal.fire({
                  icon: "error",
                  title: "Atención",
                  text: "No se ha podido eliminar",
                  allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
                  
              })
          }
         
      }

  });

}
function AlertaEliminarRubro(idRubro, descripcion){
  Swal.fire({
    title: '¿Está seguro que desea eliminar?',
    text: "Rubro: "+descripcion,
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Aceptar',
    cancelButtonText: 'Cancelar',
    allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
  }).then((result) => {
    if (result.isConfirmed) {
      
      EliminarRubro(idRubro); //funcion que eliminar el estado

    }
  })
}
/***************************FUNCIONES DE LA Profesion****************************************************************************************************** */

//FUNCION PARA LLENAR LA TABLA DE BIENES AJAX
function LlenarTablaProfesion(){
  tablaProfesion = $('#tabla_profesion').DataTable({
      pageLength:10,
      responsive: true,
      processign: true,
      "language": {   //para cambiar de idiomas a la tabla
          "lengthMenu": "Mostrar _MENU_ Registro por páginas",
          "zeroRecords": "El registro no existe",
          "info": "Mostrando la página _PAGE_ de _PAGES_",
          "infoEmpty": "No records available",
          "infoFiltered": "(Filtrado de _MAX_ Registros Totales)",
          "search": 'Buscar Registro:',
          "paginate": {
              'next': 'Siguiente',
              'previous': 'Anterior'
          }
      },
      
      ajax: "../controller/TablasController.php?operador=listar_Profesion",
      columns : [
          { data : 'Acciones'},
          { data : 'NO'},  //se ponen los datos del Controller
          { data : 'PROFESION'}, //se ponen los datos del Controller
          
          
      ]
  });
}
 //FUNCION PARA REGISTRA UN estado civil AJAX
function RegistrarProfesion(){
  descripcion = $('#descripcion_Profesion').val(); //id del modal

  parametros = {
      "Descripcion":descripcion
  }

  $.ajax({
      data:parametros,
      url:"../controller/TablasController.php?operador=registrar_Profesion",
      type:'POST',
      beforeSend:function(){},
      success:function(response){

          if(response == "success"){  //si inserto correctamente
             tablaProfesion.ajax.reload();  //actualiza la tablaSSSS
             LimpiarControles();
             $('#registral_Profesion').modal('hide'); //cierra el modal
             Swal.fire({
              icon: 'success',
              title: 'Registro exitoso',
              text: 'Se ha guardado correctamente los datos',
              allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
              
            })
          }else if(response == "requerid"){
              Swal.fire({
                  icon: 'warning',
                  title: '¡Atención!',
                  text: 'Complete todos los campos',
                  allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
                })
          }else{
              Swal.fire({
                  icon: 'error',
                  title: '¡Atención!',
                  text: 'No se lograron guardar los datos',
                  allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
                })
          }
      }
  })
} 
//funcion para obtener el id del cliente para actualizarlo
function ObtenerProfesionPorId(idProfesion, Acciones){
  $.ajax({
      data: { "idProfesion": idProfesion },
      url:'../controller/TablasController.php?operador=obtener_profesion_por_id', //url del controlador Conttroller
      type:'POST',
      beforeSend:function(){},
      success:function(response){
         // console.log(response);  //para probar que traiga datos en consola
          data = $.parseJSON(response);
          if(data.length > 0){

            if(Acciones == "editar"){
              $('#id_edit').val(data[0]['ID']);
              $('#descripcion_profesion_edit').val(data[0]['PROFESION']);  //modal de actualizar estado civil
              

            }else if(Acciones == "eliminar"){
              AlertaEliminarProfesion(data[0]['ID'], data[0]['PROFESION']);
            }
          }
         
      }

  });
}
//funcion para actualizar el estado civil
function ActualizarProfesion(){
  idProfesion = $('#id_edit').val();  //id de los input del modal de actualizar
  Descripcion = $('#descripcion_profesion_edit').val();
 
  
 
  parametros = {
      "idProfesion":idProfesion, "Descripcion":Descripcion //parametros que se mandan al controlador: actualizar_estado_civil
  }

  console.log("NOMBRE:"+Descripcion);
  console.log("ID:"+idProfesion);
  $.ajax({
    data:parametros,
    url:'../controller/TablasController.php?operador=actualizar_profesion', //url del controlador 
    type:'POST',
    beforeSend:function(){},
    success:function(response){
        if(response == "success"){  //si inserto correctamente
         tablaProfesion.ajax.reload();  //actualiza la tabla
           $('#actualizar_Profesion').modal('hide'); //cierra el modal id del modal

          Swal.fire({
            icon: 'success',
            title: 'Actualización Exitosa',
            text: 'Se han actualizado correctamente los datos',
            allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
          })

        }else if(response == "requerid"){
            Swal.fire({
              icon: 'warning',
              title: '¡Atención!',
              text: 'Complete todos los datos por favor',
              allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
            })     

       }else{
            Swal.fire({
              icon: 'error',
              title: '¡Atención!',
              text: 'error al actualizar en la base de datos',
              allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
            })
        }
    }
})

}
//funcion paraEliminar Categoria
function EliminarProfesion(idProfesion){
  $.ajax({
      data: { "idProfesion": idProfesion },
      url:'../controller/TablasController.php?operador=eliminar_Profesion', //url del controlador Conttroller
      type:'POST',
      beforeSend:function(){},
      success:function(response){
          
          if(response == "success"){
               //actualizar tabla
              tablaProfesion.ajax.reload();
               swal.fire({
                  icon: "success",
                  title: "Eliminado",
                  text: "El registro se eliminó"   
              })
            
          }else if(response == "llave_uso"){
              swal.fire({
                  icon: "warning",
                  title: "Atención",
                  text: "El registro no se puede eliminar ya que se encuentra en uso.",
                  allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
              })
          }else{
              swal.fire({
                  icon: "error",
                  title: "Atención",
                  text: "No se ha podido eliminar",
                  allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
                  
              })
          }
         
      }

  });

}
function AlertaEliminarProfesion(idProfesion, descripcion){
  Swal.fire({
    title: '¿Está seguro que desea eliminar?',
    text: "Profesión: "+descripcion,
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Aceptar',
    cancelButtonText: 'Cancelar',
    allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
  }).then((result) => {
    if (result.isConfirmed) {
      
      EliminarProfesion(idProfesion); //funcion que eliminar el estado

    }
  })
}



/***************************FUNCIONES DE la tabla Municipio****************************************************************************************************** */

//FUNCION PARA LLENAR LA TABLA DE BIENES AJAX
function LlenarTablaMunicipio(){
  tablaMunicipio = $('#tabla_municipio').DataTable({
      pageLength:10,
      responsive: true,
      processign: true,
      "language": {   //para cambiar de idiomas a la tabla
          "lengthMenu": "Mostrar _MENU_ Registro por páginas",
          "zeroRecords": "El registro no existe",
          "info": "Mostrando la página _PAGE_ de _PAGES_",
          "infoEmpty": "No records available",
          "infoFiltered": "(Filtrado de _MAX_ Registros Totales)",
          "search": 'Buscar Registro:',
          "paginate": {
              'next': 'Siguiente',
              'previous': 'Anterior'
          }
      },
      
      ajax: "../controller/TablasController.php?operador=listar_Municipio",
      columns : [
          { data : 'Acciones'},
          { data : 'NO'},  //se ponen los datos del Controller
          { data : 'MUNICIPIO'}, //se ponen los datos del Controller
          
          
      ]
  });
  let timeout = null;

    // Agregar controlador de eventos para detectar la búsqueda
    $('#tabla_municipio').on('search.dt', function(event) {
        // Limpiar el timeout anterior, si existe
        clearTimeout(timeout);
        
        // Iniciar un nuevo timeout
        timeout = setTimeout(function(){
            // Verificar si la búsqueda actual no está vacía
            if (tablaMunicipio.search() !== '') {
                // Realizar acciones solo si hay una búsqueda activa
                //TIPOConsulta, ID DE LA PANTALLA, Y DESCRIPCION
                EventoBitacora(2, 25, "Realizo consulta de filtros en LISTADO DE MUNICIPIOS");
            }
        }, 2000); // Este es el tiempo en milisegundos antes de que se ejecute el código después de que el usuario deja de escribir
    });
}

 //FUNCION PARA REGISTRA UN estado civil AJAX
 function RegistrarMunicipio(){
  descripcion = $('#descripcion_Municipio').val(); //id del modal

  parametros = {
      "Descripcion":descripcion
  }

  $.ajax({
      data:parametros,
      url:"../controller/TablasController.php?operador=registrar_Municipio",
      type:'POST',
      beforeSend:function(){},
      success:function(response){

          if(response == "success"){  //si inserto correctamente
             tablaMunicipio.ajax.reload();  //actualiza la tablaSSSS
             LimpiarControles();
             $('#registral_Municipio').modal('hide'); //cierra el modal
             Swal.fire({
              icon: 'success',
              title: 'Registro exitoso',
              text: 'Se han guardado correctamente los datos',
              allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
            })
          }else if(response == "existe"){
            Swal.fire({
                icon: 'warning',
                title: '¡Atención!',
                text: 'No puedes registrar un municipio que ya existe',
                allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
            })
          }else if(response == "requerid"){
              Swal.fire({
                  icon: 'warning',
                  title: '¡Atención!',
                  text: 'Complete todos los campos',
                  allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
                })
          }else{
              Swal.fire({
                  icon: 'error',
                  title: '¡Atención!',
                  text: 'No se lograron guardar los datos',
                  allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
                })
          }
      }
  })
} 

//funcion para obtener el id del cliente para actualizarlo
function ObtenerMunicipioPorId(idMunicipio, Acciones){
  $.ajax({
      data: { "idMunicipio": idMunicipio },
      url:'../controller/TablasController.php?operador=obtener_municipio_por_id', //url del controlador Conttroller
      type:'POST',
      beforeSend:function(){},
      success:function(response){
         // console.log(response);  //para probar que traiga datos en consola
          data = $.parseJSON(response);
          if(data.length > 0){

            if(Acciones == "editar"){
              $('#id_edit').val(data[0]['ID']);
              $('#descripcion_municipio_edit').val(data[0]['MUNICIPIO']);  //modal de actualizar estado civil
              

            }else if(Acciones == "eliminar"){
              AlertaEliminarMunicipio(data[0]['ID'], data[0]['MUNICIPIO']);
            }
          }
         
      }

  });
}
//funcion para actualizar el estado civil
function ActualizarMunicipio(){
  idMunicipio = $('#id_edit').val();  //id de los input del modal de actualizar
  Descripcion = $('#descripcion_municipio_edit').val();
 
  
 
  parametros = {
      "idMunicipio":idMunicipio, "Descripcion":Descripcion //parametros que se mandan al controlador: actualizar_estado_civil
  }

  console.log("NOMBRE:"+Descripcion);
  console.log("ID:"+idMunicipio);
  $.ajax({
    data:parametros,
    url:'../controller/TablasController.php?operador=actualizar_municipio', //url del controlador 
    type:'POST',
    beforeSend:function(){},
    success:function(response){
        if(response == "success"){  //si inserto correctamente
         tablaMunicipio.ajax.reload();  //actualiza la tabla
           $('#actualizar_Municipio').modal('hide'); //cierra el modal id del modal

          Swal.fire({
            icon: 'success',
            title: 'Actualización Exitosa',
            text: 'Se han actualizado correctamente los datos',
            allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
          })
        }else if(response == "existe"){
          Swal.fire({
              icon: 'warning',
              title: '¡Atención!',
              text: 'No puedes actualizar a un municipio que ya existe',
              allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
          })
        }else if(response == "requerid"){
            Swal.fire({
              icon: 'warning',
              title: '¡Atención!',
              text: 'Complete todos los datos por favor',
              allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
            })     

       }else{
            Swal.fire({
              icon: 'error',
              title: '¡Atención!',
              text: 'Error al actualizar en la base de datos',
              allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
            })
        }
    }
})

}
//funcion paraEliminar Categoria
function EliminarMunicipio(idMunicipio){
  $.ajax({
      data: { "idMunicipio": idMunicipio },
      url:'../controller/TablasController.php?operador=eliminar_Municipio', //url del controlador Conttroller
      type:'POST',
      beforeSend:function(){},
      success:function(response){
          
          if(response == "success"){
               //actualizar tabla
              tablaMunicipio.ajax.reload();
               swal.fire({
                  icon: "success",
                  title: "Eliminado",
                  text: "El registro se eliminó"   
              })
            
          }else if(response == "llave_uso"){
              swal.fire({
                  icon: "warning",
                  title: "Atención",
                  text: "El registro no se puede eliminar ya que se encuentra en uso.",
                  allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
              })
          }else{
              swal.fire({
                  icon: "error",
                  title: "Atención",
                  text: "No se ha podido eliminar",
                  allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
                  
              })
          }
         
      }

  });

}
function AlertaEliminarMunicipio(idMunicipio, descripcion){
  Swal.fire({
    title: '¿Está seguro que desea eliminar?',
    text: "Municipio: "+descripcion,
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Aceptar',
    cancelButtonText: 'Cancelar',
    allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
  }).then((result) => {
    if (result.isConfirmed) {
      
      EliminarMunicipio(idMunicipio); //funcion que eliminar el estado

    }
  })
}
 
/***************************FUNCIONES DE TIPO PAGO***************************************************************************************************** */

//FUNCION PARA LLENAR LA TABLA DE TPO PAGO AJAX
function LlenarTablaTipopago(){
  tablaTipopago = $('#tabla_tipopago').DataTable({
      pageLength:10,
      responsive: true,
      processign: true,
      "language": {   //para cambiar de idiomas a la tabla
          "lengthMenu": "Mostrar _MENU_ Registro por páginas",
          "zeroRecords": "El registro no existe",
          "info": "Mostrando la página _PAGE_ de _PAGES_",
          "infoEmpty": "No records available",
          "infoFiltered": "(Filtrado de _MAX_ Registros Totales)",
          "search": 'Buscar Registro:',
          "paginate": {
              'next': 'Siguiente',
              'previous': 'Anterior'
          }
      },
      
      ajax: "../controller/TablasController.php?operador=listar_Tipo_Pago",
      columns : [
          { data : 'Acciones'},
          { data : 'NO'},  //se ponen los datos del Controller
          { data : 'TIPOPAGO'}, //se ponen los datos del Controller
          
          
      ]
  });
}
 //FUNCION PARA REGISTRA UN estado civil AJAX
function RegistrarTipoPago(){
  descripcion = $('#descripcion_Tipopago').val(); //id del modal

  parametros = {
      "descripcion":descripcion
  }

  $.ajax({
      data:parametros,
      url:"../controller/TablasController.php?operador=registrar_Tipopago",
      type:'POST',
      beforeSend:function(){},
      success:function(response){

          if(response == "success"){  //si inserto correctamente
             tablaTipopago.ajax.reload();  //actualiza la tablaSSSS
             LimpiarControles();
             $('#registral_Tipopago').modal('hide'); //cierra el modal
             Swal.fire({
              icon: 'success',
              title: 'Registro exitoso',
              text: 'Se ha guardado correctamente los datos',
              allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
            })
          }else if(response == "requerid"){
              Swal.fire({
                  icon: 'warning',
                  title: '¡Atención!',
                  text: 'Complete todos los campos',
                  allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
                })
          }else{
              Swal.fire({
                  icon: 'error',
                  title: '¡Atención!',
                  text: 'No se lograron guardar los datos',
                  allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
                })
          }
      }
  })
} 
//funcion para obtener el id del cliente para actualizarlo
function ObtenerTipoPagoPorId(idTipoPago, Acciones){
  $.ajax({
      data: { "idTipoPago": idTipoPago },
      url:'../controller/TablasController.php?operador=obtener_tipo_pago_por_id', //url del controlador Conttroller
      type:'POST',
      beforeSend:function(){},
      success:function(response){
         // console.log(response);  //para probar que traiga datos en consola
          data = $.parseJSON(response);
          if(data.length > 0){

            if(Acciones == "editar"){
              $('#id_edit').val(data[0]['ID']);
              $('#descripcion_tipopago_edit').val(data[0]['TIPOPAGO']);  //modal de actualizar estado civil
              

            }else if(Acciones == "eliminar"){
              AlertaEliminarTipopago(data[0]['ID'], data[0]['TIPOPAGO']);
            }
          }
         
      }

  });
}
//funcion para actualizar el estado civil
function ActualizarTipoPago(){
  idTipoPago = $('#id_edit').val();  //id de los input del modal de actualizar
  descripcion = $('#descripcion_tipopago_edit').val();
 
  
 
  parametros = {
      "idTipoPago":idTipoPago, "descripcion":descripcion //parametros que se mandan al controlador: actualizar_estado_civil
  }

  console.log("NOMBRE:"+descripcion);
  console.log("ID:"+idTipoPago);
  $.ajax({
    data:parametros,
    url:'../controller/TablasController.php?operador=actualizar_tipopago', //url del controlador 
    type:'POST',
    beforeSend:function(){},
    success:function(response){
        if(response == "success"){  //si inserto correctamente
          tablaTipopago.ajax.reload();  //actualiza la tabla
           $('#actualizar_Tipopago').modal('hide'); //cierra el modal id del modal

          Swal.fire({
            icon: 'success',
            title: 'Actualización Exitosa',
            text: 'Se han actualizado correctamente los datos',
            allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
          })

        }else if(response == "requerid"){
            Swal.fire({
              icon: 'warning',
              title: '¡Atención!',
              text: 'Complete todos los datos por favor',
              allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
            })     

       }else{
            Swal.fire({
              icon: 'error',
              title: '¡Atención!',
              text: 'Error al actualizar en la base de datos',
              allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
            })
        }
    }
})

}
//funcion paraEliminar Categoria
function EliminarTipoPago(idTipoPago){
  $.ajax({
      data: { "idTipoPago": idTipoPago },
      url:'../controller/TablasController.php?operador=eliminar_Tipopago', //url del controlador Conttroller
      type:'POST',
      beforeSend:function(){},
      success:function(response){
          
          if(response == "success"){
               //actualizar tabla
               tablaTipopago.ajax.reload();
               swal.fire({
                  icon: "success",
                  title: "Eliminado",
                  text: "El registro se eliminó"   
              })
            
          }else if(response == "llave_uso"){
              swal.fire({
                  icon: "warning",
                  title: "Atención",
                  text: "El registro no se puede eliminar ya que se encuentra en uso.",
                  allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
              })
          }else{
              swal.fire({
                  icon: "error",
                  title: "Atención",
                  text: "No se ha podido eliminar",
                  allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
                  
              })
          }
         
      }

  });

}
function AlertaEliminarTipopago(idTipoPago, descripcion){
  Swal.fire({
    title: '¿Está seguro que desea eliminar?',
    text: "Tipo de pago: "+descripcion,
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Aceptar',
    cancelButtonText: 'Cancelar',
    allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
  }).then((result) => {
    if (result.isConfirmed) {
      
      EliminarTipoPago(idTipoPago); //funcion que eliminar el estado

    }
  })
}
/***************************FUNCIONES DE TIPO CLIENTE***************************************************************************************************** */

//FUNCION PARA LLENAR LA TABLA DE TPO CLIENTE AJAX
function LlenarTablaTipocliente(){
  tablaTipocliente = $('#tabla_tipocliente').DataTable({
      pageLength:10,
      responsive: true,
      processign: true,
      "language": {   //para cambiar de idiomas a la tabla
          "lengthMenu": "Mostrar _MENU_ Registro por páginas",
          "zeroRecords": "El registro no existe",
          "info": "Mostrando la página _PAGE_ de _PAGES_",
          "infoEmpty": "No records available",
          "infoFiltered": "(Filtrado de _MAX_ Registros Totales)",
          "search": 'Buscar Registro:',
          "paginate": {
              'next': 'Siguiente',
              'previous': 'Anterior'
          }
      },
      
      ajax: "../controller/TablasController.php?operador=listar_Tipo_Cliente",
      columns : [
          { data : 'Acciones'},
          { data : 'NO'},  //se ponen los datos del Controller
          { data : 'TIPOCLIENTE'}, //se ponen los datos del Controller
          
          
      ]
  });
}
 //FUNCION PARA REGISTRA UN estado civil AJAX
function RegistrarTipoCliente(){
  descripcion = $('#descripcion_Tipocliente').val(); //id del modal

  parametros = {
      "Descripcion":descripcion
  }

  $.ajax({
      data:parametros,
      url:"../controller/TablasController.php?operador=registrar_Tipocliente",
      type:'POST',
      beforeSend:function(){},
      success:function(response){

          if(response == "success"){  //si inserto correctamente
             tablaTipocliente.ajax.reload();  //actualiza la tablaSSSS
             LimpiarControles();
             $('#registral_Tipocliente').modal('hide'); //cierra el modal
             Swal.fire({
              icon: 'success',
              title: 'Registro exitoso',
              text: 'Se ha guardado correctamente los datos',
              allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
            })
          }else if(response == "requerid"){
              Swal.fire({
                  icon: 'warning',
                  title: '¡Atención!',
                  text: 'Complete todos los campos',
                  allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
                })
          }else{
              Swal.fire({
                  icon: 'error',
                  title: '¡Atención!',
                  text: 'No se lograron guardar los datos',
                  allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
                })
          }
      }
  })
} 
//funcion para obtener el id del cliente para actualizarlo
function ObtenerTipoClientePorId(idTipoCliente, Acciones){
  $.ajax({
      data: { "idTipoCliente": idTipoCliente },
      url:'../controller/TablasController.php?operador=obtener_tipo_cliente_por_id', //url del controlador Conttroller
      type:'POST',
      beforeSend:function(){},
      success:function(response){
         // console.log(response);  //para probar que traiga datos en consola
          data = $.parseJSON(response);
          if(data.length > 0){

            if(Acciones == "editar"){
              $('#id_edit').val(data[0]['ID']);
              $('#descripcion_tipocliente_edit').val(data[0]['TIPOCLIENTE']);  //modal de actualizar estado civil
              

            }else if(Acciones == "eliminar"){
              AlertaEliminarTipocliente(data[0]['ID'], data[0]['TIPOCLIENTE']);
            }
          }
         
      }

  });
}
//funcion para actualizar el estado civil
function ActualizarTipoCliente(){
  idTipoCliente = $('#id_edit').val();  //id de los input del modal de actualizar
  descripcion = $('#descripcion_tipocliente_edit').val();
 
  
 
  parametros = {
      "idTipoCliente":idTipoCliente, "Descripcion":descripcion //parametros que se mandan al controlador: actualizar_estado_civil
  }

  console.log("NOMBRE:"+descripcion);
  console.log("ID:"+idTipoCliente);
  $.ajax({
    data:parametros,
    url:'../controller/TablasController.php?operador=actualizar_tipocliente', //url del controlador 
    type:'POST',
    beforeSend:function(){},
    success:function(response){
        if(response == "success"){  //si inserto correctamente
          tablaTipocliente.ajax.reload();  //actualiza la tabla
           $('#actualizar_Tipocliente').modal('hide'); //cierra el modal id del modal

          Swal.fire({
            icon: 'success',
            title: 'Actualización Exitosa',
            text: 'Se han actualizado correctamente los datos',
            allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
          })

        }else if(response == "requerid"){
            Swal.fire({
              icon: 'warning',
              title: '¡Atención!',
              text: 'Complete todos los datos por favor',
              allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
            })     

       }else{
            Swal.fire({
              icon: 'error',
              title: '¡Atención!',
              text: 'Error al actualizar en la base de datos',
              allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
            })
        }
    }
})

}
//funcion paraEliminar Categoria
function EliminarTipoCliente(idTipoCliente){
  $.ajax({
      data: { "idTipoCliente": idTipoCliente },
      url:'../controller/TablasController.php?operador=eliminar_Tipocliente', //url del controlador Conttroller
      type:'POST',
      beforeSend:function(){},
      success:function(response){
          
          if(response == "success"){
               //actualizar tabla
               tablaTipocliente.ajax.reload();
               swal.fire({
                  icon: "success",
                  title: "Eliminado",
                  text: "El registro se eliminó"   
              })
            
          }else if(response == "llave_uso"){
              swal.fire({
                  icon: "warning",
                  title: "Atención",
                  text: "El registro no se puede eliminar ya que se encuentra en uso.",
                  allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
              })
          }else{
              swal.fire({
                  icon: "error",
                  title: "Atención",
                  text: "No se ha podido eliminar",
                  allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
                  
              })
          }
         
      }

  });

}
function AlertaEliminarTipocliente(idTipoCliente, descripcion){
  Swal.fire({
    title: '¿Está seguro que desea eliminar?',
    text: "Tipo de Cliente: "+descripcion,
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Aceptar',
    cancelButtonText: 'Cancelar',
    allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
  }).then((result) => {
    if (result.isConfirmed) {
      
      EliminarTipoCliente(idTipoCliente); //funcion que eliminar el estado

    }
  })
}
/***************************FUNCIONES DE ESTADO CREDITO***************************************************************************************************** */

//FUNCION PARA LLENAR LA TABLA DE ESTADO CREDITO AJAX
function LlenarTablaEstadocredito(){
  tablaEstadocredito = $('#tabla_estadocredito').DataTable({
      pageLength:10,
      responsive: true,
      processign: true,
      "language": {   //para cambiar de idiomas a la tabla
          "lengthMenu": "Mostrar _MENU_ Registro por páginas",
          "zeroRecords": "El registro no existe",
          "info": "Mostrando la página _PAGE_ de _PAGES_",
          "infoEmpty": "No records available",
          "infoFiltered": "(Filtrado de _MAX_ Registros Totales)",
          "search": 'Buscar Registro:',
          "paginate": {
              'next': 'Siguiente',
              'previous': 'Anterior'
          }
      },
      
      ajax: "../controller/TablasController.php?operador=listar_Estado_Credito",
      columns : [
          { data : 'Acciones'},
          { data : 'NO'},  //se ponen los datos del Controller
          { data : 'ESTADOCREDITO'}, //se ponen los datos del Controller
          
          
      ]
  });
}
 //FUNCION PARA REGISTRA UN estado civil AJAX
function RegistrarEstadoCredito(){
  descripcion = $('#descripcion_Estadocredito').val(); //id del modal

  parametros = {
      "Descripcion":descripcion
  }

  $.ajax({
      data:parametros,
      url:"../controller/TablasController.php?operador=registrar_Estadocredito",
      type:'POST',
      beforeSend:function(){},
      success:function(response){

          if(response == "success"){  //si inserto correctamente
            tablaEstadocredito.ajax.reload();  //actualiza la tablaSSSS
             LimpiarControles();
             $('#registral_Estadocredito').modal('hide'); //cierra el modal
             Swal.fire({
              icon: 'success',
              title: 'Registro exitoso',
              text: 'Se ha guardado correctamente los datos',
              allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
            })
          }else if(response == "requerid"){
              Swal.fire({
                  icon: 'warning',
                  title: '¡Atención!',
                  text: 'Complete todos los campos',
                  allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
                })
          }else{
              Swal.fire({
                  icon: 'error',
                  title: '¡Atención!',
                  text: 'No se lograron guardar los datos',
                  allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
                })
          }
      }
  })
} 
//funcion para obtener el id del cliente para actualizarlo
function ObtenerEstadoCreditoPorId(idEstadoCredito, Acciones){
  $.ajax({
      data: { "idEstadoCredito": idEstadoCredito },
      url:'../controller/TablasController.php?operador=obtener_estado_credito_por_id', //url del controlador Conttroller
      type:'POST',
      beforeSend:function(){},
      success:function(response){
         // console.log(response);  //para probar que traiga datos en consola
          data = $.parseJSON(response);
          if(data.length > 0){

            if(Acciones == "editar"){
              $('#id_edit').val(data[0]['ID']);
              $('#descripcion_estadocredito_edit').val(data[0]['ESTADOCREDITO']);  //modal de actualizar estado civil
              

            }else if(Acciones == "eliminar"){
              AlertaEliminarEstadoCredito(data[0]['ID'], data[0]['ESTADOCREDITO']);
            }
          }
         
      }

  });
}
//funcion para actualizar el estado civil
function ActualizarEstadoCredito(){
  idEstadoCredito = $('#id_edit').val();  //id de los input del modal de actualizar
  descripcion = $('#descripcion_estadocredito_edit').val();
 
  
 
  parametros = {
      "idEstadoCredito":idEstadoCredito, "Descripcion":descripcion //parametros que se mandan al controlador: actualizar_estado_civil
  }

  console.log("NOMBRE:"+descripcion);
  console.log("ID:"+idEstadoCredito);
  $.ajax({
    data:parametros,
    url:'../controller/TablasController.php?operador=actualizar_estadocredito', //url del controlador 
    type:'POST',
    beforeSend:function(){},
    success:function(response){
        if(response == "success"){  //si inserto correctamente
          tablaEstadocredito.ajax.reload();  //actualiza la tabla
           $('#actualizar_Estadocredito').modal('hide'); //cierra el modal id del modal

          Swal.fire({
            icon: 'success',
            title: 'Actualización Exitosa',
            text: 'Se han actualizado correctamente los datos',
            allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
          })

        }else if(response == "requerid"){
            Swal.fire({
              icon: 'warning',
              title: '¡Atención!',
              text: 'Complete todos los datos por favor',
              allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
            })     

       }else{
            Swal.fire({
              icon: 'error',
              title: '¡Atención!',
              text: 'Error al actualizar en la base de datos',
              allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
            })
        }
    }
})

}
//funcion paraEliminar Categoria
function EliminarEstadoCredito(idEstadoCredito){
  $.ajax({
      data: { "idEstadoCredito": idEstadoCredito },
      url:'../controller/TablasController.php?operador=eliminar_Estadocredito', //url del controlador Conttroller
      type:'POST',
      beforeSend:function(){},
      success:function(response){
          
          if(response == "success"){
               //actualizar tabla
               tablaEstadocredito.ajax.reload();
               swal.fire({
                  icon: "success",
                  title: "Eliminado",
                  text: "El registro se eliminó"   
              })
            
          }else if(response == "llave_uso"){
              swal.fire({
                  icon: "warning",
                  title: "Atención",
                  text: "El registro no se puede eliminar ya que se encuentra en uso.",
                  allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
              })
          }else{
              swal.fire({
                  icon: "error",
                  title: "Atención",
                  text: "No se ha podido eliminar",
                  allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
                  
              })
          }
         
      }

  });

}
function AlertaEliminarEstadoCredito(idEstadoCredito, descripcion){
  Swal.fire({
    title: '¿Está seguro que desea eliminar?',
    text: "Estado Credito: "+descripcion,
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Aceptar',
    cancelButtonText: 'Cancelar',
    allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
  }).then((result) => {
    if (result.isConfirmed) {
      
      EliminarEstadoCredito(idEstadoCredito); //funcion que eliminar el estado

    }
  })
}
/***************************FUNCIONES DE Analisis Crediticio***************************************************************************************************** */

//FUNCION PARA LLENAR LA TABLA DE TPO PAGO AJAX
function LlenarTablaAnalisis(){
  tablaAnalisis= $('#tabla_analisis').DataTable({
      pageLength:10,
      responsive: true,
      processign: true,
      "language": {   //para cambiar de idiomas a la tabla
          "lengthMenu": "Mostrar _MENU_ Registro por páginas",
          "zeroRecords": "El registro no existe",
          "info": "Mostrando la página _PAGE_ de _PAGES_",
          "infoEmpty": "No records available",
          "infoFiltered": "(Filtrado de _MAX_ Registros Totales)",
          "search": 'Buscar Registro:',
          "paginate": {
              'next': 'Siguiente',
              'previous': 'Anterior'
          }
      },
      
      ajax: "../controller/TablasController.php?operador=listar_Analisis",
      columns : [
          { data : 'Acciones'},
          { data : 'NO'},  //se ponen los datos del Controller
          { data : 'ANALISIS'}, //se ponen los datos del Controller
          
          
      ]
  });
}
 //FUNCION PARA REGISTRA UN estado civil AJAX
function RegistrarAnalisis(){
  descripcion = $('#descripcion_Analisis').val(); //id del modal

  parametros = {
      "descripcion":descripcion
  }

  $.ajax({
      data:parametros,
      url:"../controller/TablasController.php?operador=registrar_Analisis",
      type:'POST',
      beforeSend:function(){},
      success:function(response){

          if(response == "success"){  //si inserto correctamente
             tablaAnalisis.ajax.reload();  //actualiza la tablaSSSS
             LimpiarControles();
             $('#registral_Analisis').modal('hide'); //cierra el modal
             Swal.fire({
              icon: 'success',
              title: 'Registro exitoso',
              text: 'Se ha guardado correctamente los datos',
              allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
            })
          }else if(response == "requerid"){
              Swal.fire({
                  icon: 'warning',
                  title: '¡Atención!',
                  text: 'Complete todos los campos',
                  allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
                })
          }else{
              Swal.fire({
                  icon: 'error',
                  title: '¡Atención!',
                  text: 'No se lograron guardar los datos',
                  allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
                })
          }
      }
  })
} 
//funcion para obtener el id del cliente para actualizarlo
function ObtenerAnalisisPorId(idestadoAnalisisCrediticio, Acciones){
  $.ajax({
      data: { "idestadoAnalisisCrediticio": idestadoAnalisisCrediticio },
      url:'../controller/TablasController.php?operador=obtener_analisis_por_id', //url del controlador Conttroller
      type:'POST',
      beforeSend:function(){},
      success:function(response){
         // console.log(response);  //para probar que traiga datos en consola
          data = $.parseJSON(response);
          if(data.length > 0){

            if(Acciones == "editar"){
              $('#id_edit').val(data[0]['ID']);
              $('#descripcion_analisis_edit').val(data[0]['ANALISIS']);  //modal de actualizar estado civil
              

            }else if(Acciones == "eliminar"){
              AlertaEliminarAnalisis(data[0]['ID'], data[0]['ANALISIS']);
            }
          }
         
      }

  });
}
//funcion para actualizar el estado civil
function ActualizarAnalisis(){
  idestadoAnalisisCrediticio = $('#id_edit').val();  //id de los input del modal de actualizar
  descripcion = $('#descripcion_analisis_edit').val();
 
  
 
  parametros = {
      "idestadoAnalisisCrediticio":idestadoAnalisisCrediticio, "descripcion":descripcion //parametros que se mandan al controlador: actualizar_estado_civil
  }

  console.log("NOMBRE:"+descripcion);
  console.log("ID:"+idestadoAnalisisCrediticio);
  $.ajax({
    data:parametros,
    url:'../controller/TablasController.php?operador=actualizar_analisis', //url del controlador 
    type:'POST',
    beforeSend:function(){},
    success:function(response){
        if(response == "success"){  //si inserto correctamente
          tablaAnalisis.ajax.reload();  //actualiza la tabla
           $('#actualizar_Analisis').modal('hide'); //cierra el modal id del modal

          Swal.fire({
            icon: 'success',
            title: 'Actualización Exitosa',
            text: 'Se han actualizado correctamente los datos',
            allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
          })

        }else if(response == "requerid"){
            Swal.fire({
              icon: 'warning',
              title: '¡Atención!',
              text: 'Complete todos los datos por favor',
              allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
            })     

       }else{
            Swal.fire({
              icon: 'error',
              title: '¡Atención!',
              text: 'Error al actualizar en la base de datos',
              allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
            })
        }
    }
})

}
//funcion paraEliminar Categoria
function EliminarAnalisis(idestadoAnalisisCrediticio){
  $.ajax({
      data: { "idestadoAnalisisCrediticio": idestadoAnalisisCrediticio },
      url:'../controller/TablasController.php?operador=eliminar_Analisis', //url del controlador Conttroller
      type:'POST',
      beforeSend:function(){},
      success:function(response){
          
          if(response == "success"){
               //actualizar tabla
               tablaAnalisis.ajax.reload();
               swal.fire({
                  icon: "success",
                  title: "Eliminado",
                  text: "El registro se eliminó"   
              })
            
          }else if(response == "llave_uso"){
              swal.fire({
                  icon: "warning",
                  title: "Atención",
                  text: "El registro no se puede eliminar ya que se encuentra en uso.",
                  allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
              })
          }else{
              swal.fire({
                  icon: "error",
                  title: "Atención",
                  text: "No se ha podido eliminar",
                  allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
                  
              })
          }
         
      }

  });

}
function AlertaEliminarAnalisis(idestadoAnalisisCrediticio, descripcion){
  Swal.fire({
    title: '¿Está seguro que desea eliminar?',
    text: "Analisis Crediticio: "+descripcion,
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Aceptar',
    cancelButtonText: 'Cancelar',
    allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
  }).then((result) => {
    if (result.isConfirmed) {
      
      EliminarAnalisis(idestadoAnalisisCrediticio); //funcion que eliminar el estado

    }
  })
}

/**********************FUNCIONES DE AVALA A PERSONAS***************************************************************************************************** */

//FUNCION PARA LLENAR LA TABLA DE TPO PAGO AJAX
function LlenarTablaAvala(){
  tablaAvala= $('#tabla_avala').DataTable({
      pageLength:10,
      responsive: true,
      processign: true,
      "language": {   //para cambiar de idiomas a la tabla
          "lengthMenu": "Mostrar _MENU_ Registro por páginas",
          "zeroRecords": "El registro no existe",
          "info": "Mostrando la página _PAGE_ de _PAGES_",
          "infoEmpty": "No records available",
          "infoFiltered": "(Filtrado de _MAX_ Registros Totales)",
          "search": 'Buscar Registro:',
          "paginate": {
              'next': 'Siguiente',
              'previous': 'Anterior'
          }
      },
      
      ajax: "../controller/TablasController.php?operador=listar_Avala",
      columns : [
          { data : 'Acciones'},
          { data : 'NO'},  //se ponen los datos del Controller
          { data : 'AVALA'}, //se ponen los datos del Controller
          
          
      ]
  });
}
 //FUNCION PARA REGISTRA UN estado civil AJAX
function RegistrarAvala(){
  descripcion = $('#descripcion_Avala').val(); //id del modal

  parametros = {
      "Descripcion":descripcion
  }

  $.ajax({
      data:parametros,
      url:"../controller/TablasController.php?operador=registrar_Avala",
      type:'POST',
      beforeSend:function(){},
      success:function(response){

          if(response == "success"){  //si inserto correctamente
             tablaAvala.ajax.reload();  //actualiza la tablaSSSS
             LimpiarControles();
             $('#registral_Avala').modal('hide'); //cierra el modal
             Swal.fire({
              icon: 'success',
              title: 'Registro exitoso',
              text: 'Se ha guardado correctamente los datos',
              allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
            })
          }else if(response == "requerid"){
              Swal.fire({
                  icon: 'warning',
                  title: '¡Atención!',
                  text: 'Complete todos los campos',
                  allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
                })
          }else{
              Swal.fire({
                  icon: 'error',
                  title: '¡Atención!',
                  text: 'No se lograron guardar los datos',
                  allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
                })
          }
      }
  })
} 
//funcion para obtener el id del cliente para actualizarlo
function ObtenerAvalaPorId(idEsAval, Acciones){
  $.ajax({
      data: { "idEsAval": idEsAval },
      url:'../controller/TablasController.php?operador=obtener_avala_por_id', //url del controlador Conttroller
      type:'POST',
      beforeSend:function(){},
      success:function(response){
         // console.log(response);  //para probar que traiga datos en consola
          data = $.parseJSON(response);
          if(data.length > 0){

            if(Acciones == "editar"){
              $('#id_edit').val(data[0]['ID']);
              $('#descripcion_avala_edit').val(data[0]['AVALA']);  //modal de actualizar estado civil
              

            }else if(Acciones == "eliminar"){
              AlertaEliminarAvala(data[0]['ID'], data[0]['AVALA']);
            }
          }
         
      }

  });
}
//funcion para actualizar el estado civil
function ActualizarAvala(){
  idEsAval = $('#id_edit').val();  //id de los input del modal de actualizar
  descripcion = $('#descripcion_avala_edit').val();
 
  
 
  parametros = {
      "idEsAval":idEsAval, "Descripcion":descripcion //parametros que se mandan al controlador: actualizar_estado_civil
  }

  console.log("NOMBRE:"+descripcion);
  console.log("ID:"+idEsAval);
  $.ajax({
    data:parametros,
    url:'../controller/TablasController.php?operador=actualizar_avala', //url del controlador 
    type:'POST',
    beforeSend:function(){},
    success:function(response){
        if(response == "success"){  //si inserto correctamente
          tablaAvala.ajax.reload();  //actualiza la tabla
           $('#actualizar_Avala').modal('hide'); //cierra el modal id del modal

          Swal.fire({
            icon: 'success',
            title: 'Actualización Exitosa',
            text: 'Se han actualizado correctamente los datos',
            allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
          })

        }else if(response == "requerid"){
            Swal.fire({
              icon: 'warning',
              title: '¡Atención!',
              text: 'Complete todos los datos por favor',
              allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
            })     

       }else{
            Swal.fire({
              icon: 'error',
              title: '¡Atención!',
              text: 'Error al actualizar en la base de datos',
              allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
            })
        }
    }
})

}
//funcion paraEliminar Categoria
function EliminarAvala(idEsAval){
  $.ajax({
      data: { "idEsAval": idEsAval },
      url:'../controller/TablasController.php?operador=eliminar_Avala', //url del controlador Conttroller
      type:'POST',
      beforeSend:function(){},
      success:function(response){
          
          if(response == "success"){
               //actualizar tabla
               tablaAvala.ajax.reload();
               swal.fire({
                  icon: "success",
                  title: "Eliminado",
                  text: "El registro se eliminó"   
              })
            
          }else if(response == "llave_uso"){
              swal.fire({
                  icon: "warning",
                  title: "Atención",
                  text: "El registro no se puede eliminar ya que se encuentra en uso.",
                  allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
              })
          }else{
              swal.fire({
                  icon: "error",
                  title: "Atención",
                  text: "No se ha podido eliminar",
                  allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
                  
              })
          }
         
      }

  });

}
function AlertaEliminarAvala(idEsAval, descripcion){
  Swal.fire({
    title: '¿Está seguro que desea eliminar?',
    text: "Avala a Persona: "+descripcion,
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Aceptar',
    cancelButtonText: 'Cancelar',
    allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
  }).then((result) => {
    if (result.isConfirmed) {
      
      EliminarAvala(idEsAval); //funcion que eliminar el estado

    }
  })
}
/***************************FUNCIONES DE TIPO PERSONA***************************************************************************************************** */

//FUNCION PARA LLENAR LA TABLA DE TPO CLIENTE AJAX
function LlenarTablaTipopersona(){
  tablaTipopersona = $('#tabla_tipopersona').DataTable({
      pageLength:10,
      responsive: true,
      processign: true,
      "language": {   //para cambiar de idiomas a la tabla
          "lengthMenu": "Mostrar _MENU_ Registro por páginas",
          "zeroRecords": "El registro no existe",
          "info": "Mostrando la página _PAGE_ de _PAGES_",
          "infoEmpty": "No records available",
          "infoFiltered": "(Filtrado de _MAX_ Registros Totales)",
          "search": 'Buscar Registro:',
          "paginate": {
              'next': 'Siguiente',
              'previous': 'Anterior'
          }
      },
      
      ajax: "../controller/TablasController.php?operador=listar_Tipo_Persona",
      columns : [
          { data : 'Acciones'},
          { data : 'NO'},  //se ponen los datos del Controller
          { data : 'TIPOPERSONA'}, //se ponen los datos del Controller
          
          
      ]
  });
}
 //FUNCION PARA REGISTRA UN estado civil AJAX
 function RegistrarTipoPersona(){
  descripcion = $('#descripcion_Tipopersona').val(); //id del modal

  parametros = {
      "Descripcion":descripcion
  }

  $.ajax({
      data:parametros,
      url:"../controller/TablasController.php?operador=registrar_Tipopersona",
      type:'POST',
      beforeSend:function(){},
      success:function(response){

          if(response == "success"){  //si inserto correctamente
             tablaTipopersona.ajax.reload();  //actualiza la tablaSSSS
             LimpiarControles();
             $('#registral_tipo_persona').modal('hide'); //cierra el modal
             Swal.fire({
              icon: 'success',
              title: 'Registro exitoso',
              text: 'Se ha guardado correctamente los datos',
              allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
            })
          }else if(response == "requerid"){
              Swal.fire({
                  icon: 'warning',
                  title: '¡Atención!',
                  text: 'Complete todos los campos',
                  allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
                })
          }else{
              Swal.fire({
                  icon: 'error',
                  title: '¡Atención!',
                  text: 'No se lograron guardar los datos',
                  allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
                })
          }
      }
  })
} 
//funcion para obtener el id del cliente para actualizarlo
function ObtenerTipoPersonaPorId(idTipoPersona, Acciones){
  $.ajax({
      data: { "idTipoPersona": idTipoPersona },
      url:'../controller/TablasController.php?operador=obtener_tipo_persona_por_id', //url del controlador Conttroller
      type:'POST',
      beforeSend:function(){},
      success:function(response){
         // console.log(response);  //para probar que traiga datos en consola
          data = $.parseJSON(response);
          if(data.length > 0){

            if(Acciones == "editar"){
              $('#id_edit').val(data[0]['ID']);
              $('#descripcion_tipopersona_edit').val(data[0]['TIPOPERSONA']);  //modal de actualizar estado civil
              

            }else if(Acciones == "eliminar"){
              AlertaEliminarTipopersona(data[0]['ID'], data[0]['TIPOPERSONA']);
            }
          }
         
      }

  });
}
//funcion para actualizar el estado civil
function ActualizarTipoPersona(){
  idTipoPersona = $('#id_edit').val();  //id de los input del modal de actualizar
  descripcion = $('#descripcion_tipopersona_edit').val();
 
  
 
  parametros = {
      "idTipoPersona":idTipoPersona, "Descripcion":descripcion //parametros que se mandan al controlador: actualizar_estado_civil
  }

  console.log("NOMBRE:"+descripcion);
  console.log("ID:"+idTipoPersona);
  $.ajax({
    data:parametros,
    url:'../controller/TablasController.php?operador=actualizar_tipopersona', //url del controlador 
    type:'POST',
    beforeSend:function(){},
    success:function(response){
        if(response == "success"){  //si inserto correctamente
          tablaTipopersona.ajax.reload();  //actualiza la tabla
           $('#actualizar_Tipopersona').modal('hide'); //cierra el modal id del modal

          Swal.fire({
            icon: 'success',
            title: 'Actualización Exitosa',
            text: 'Se han actualizado correctamente los datos',
            allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
          })

        }else if(response == "requerid"){
            Swal.fire({
              icon: 'warning',
              title: '¡Atención!',
              text: 'Complete todos los datos por favor',
              allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
            })     

       }else{
            Swal.fire({
              icon: 'error',
              title: '¡Atención!',
              text: 'Error al actualizar en la base de datos',
              allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
            })
        }
    }
})

}
//funcion paraEliminar Categoria
function EliminarTipoPersona(idTipoPersona){
  $.ajax({
      data: { "idTipoPersona": idTipoPersona },
      url:'../controller/TablasController.php?operador=eliminar_Tipopersona', //url del controlador Conttroller
      type:'POST',
      beforeSend:function(){},
      success:function(response){
          
          if(response == "success"){
               //actualizar tabla
               tablaTipopersona.ajax.reload();
               swal.fire({
                  icon: "success",
                  title: "Eliminado",
                  text: "El registro se eliminó"   
              })
            
          }else if(response == "llave_uso"){
              swal.fire({
                  icon: "warning",
                  title: "Atención",
                  text: "El registro no se puede eliminar ya que se encuentra en uso.",
                  allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
              })
          }else{
              swal.fire({
                  icon: "error",
                  title: "Atención",
                  text: "No se ha podido eliminar",
                  allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
                  
              })
          }
         
      }

  });

}
function AlertaEliminarTipopersona(idTipoPersona, descripcion){
  Swal.fire({
    title: '¿Está seguro que desea eliminar?',
    text: "Tipo Persona: "+descripcion,
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Aceptar',
    cancelButtonText: 'Cancelar',
    allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.s
  }).then((result) => {
    if (result.isConfirmed) {
      
      EliminarTipoPersona(idTipoPersona); //funcion que eliminar el estado

    }
  })
}
/***************************FUNCIONES DE TIPO CUENTA***************************************************************************************************** */

//FUNCION PARA LLENAR LA TABLA DE TIPO CUENYA AJAX
function LlenarTablaTipocuenta(){
  tablaTipocuenta = $('#tabla_tipocuenta').DataTable({
      pageLength:10,
      responsive: true,
      processign: true,
      "language": {   //para cambiar de idiomas a la tabla
          "lengthMenu": "Mostrar _MENU_ Registro por páginas",
          "zeroRecords": "El registro no existe",
          "info": "Mostrando la página _PAGE_ de _PAGES_",
          "infoEmpty": "No records available",
          "infoFiltered": "(Filtrado de _MAX_ Registros Totales)",
          "search": 'Buscar Registro:',
          "paginate": {
              'next': 'Siguiente',
              'previous': 'Anterior'
          }
      },
      
      ajax: "../controller/TablasController.php?operador=listar_Tipo_Cuenta",
      columns : [
          { data : 'Acciones'},
          { data : 'NO'},  //se ponen los datos del Controller
          { data : 'TIPOCUENTA'}, //se ponen los datos del Controller
          
          
      ]
  });
}
 //FUNCION PARA REGISTRA UN TIPO PERSONA AJAX
 function RegistrarTipoCuenta(){
  descripcion = $('#descripcion_Tipocuenta').val(); //id del modal

  parametros = {
      "Descripcion":descripcion
  }

  $.ajax({
      data:parametros,
      url:"../controller/TablasController.php?operador=registrar_Tipocuenta",
      type:'POST',
      beforeSend:function(){},
      success:function(response){

          if(response == "success"){  //si inserto correctamente
             tablaTipocuenta.ajax.reload();  //actualiza la tablaSSSS
             LimpiarControles();
             $('#registral_Tipocuenta').modal('hide'); //cierra el modal
             Swal.fire({
              icon: 'success',
              title: 'Registro exitoso',
              text: 'Se ha guardado correctamente los datos',
              allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
            })
          }else if(response == "requerid"){
              Swal.fire({
                  icon: 'warning',
                  title: '¡Atención!',
                  text: 'Complete todos los campos',
                  allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
                })
          }else{
              Swal.fire({
                  icon: 'error',
                  title: '¡Atención!',
                  text: 'No se lograron guardar los datos',
                  allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
                })
          }
      }
  })
} 
//funcion para obtener el id del tipo cuenta para actualizarlo
function ObtenerTipoCuentaPorId(idTipoCuenta, Acciones){
  $.ajax({
      data: { "idTipoCuenta": idTipoCuenta },
      url:'../controller/TablasController.php?operador=obtener_tipo_cuenta_por_id', //url del controlador Conttroller
      type:'POST',
      beforeSend:function(){},
      success:function(response){
         // console.log(response);  //para probar que traiga datos en consola
          data = $.parseJSON(response);
          if(data.length > 0){

            if(Acciones == "editar"){
              $('#id_edit').val(data[0]['ID']);
              $('#descripcion_tipocuenta_edit').val(data[0]['TIPOCUENTA']);  //modal de actualizar estado civil
              

            }else if(Acciones == "eliminar"){
              AlertaEliminarTipocuenta(data[0]['ID'], data[0]['TIPOCUENTA']);
            }
          }
         
      }

  });
}
//funcion para actualizar Tipo cuenta
function ActualizarTipoCuenta(){
  idTipoCuenta = $('#id_edit').val();  //id de los input del modal de actualizar
  descripcion = $('#descripcion_tipocuenta_edit').val();
 
  
 
  parametros = {
      "idTipoCuenta":idTipoCuenta, "Descripcion":descripcion //parametros que se mandan al controlador: actualizar_estado_civil
  }

  console.log("NOMBRE:"+descripcion);
  console.log("ID:"+idTipoCuenta);
  $.ajax({
    data:parametros,
    url:'../controller/TablasController.php?operador=actualizar_tipocuenta', //url del controlador 
    type:'POST',
    beforeSend:function(){},
    success:function(response){
        if(response == "success"){  //si inserto correctamente
          tablaTipocuenta.ajax.reload();  //actualiza la tabla
           $('#actualizar_Tipocuenta').modal('hide'); //cierra el modal id del modal

          Swal.fire({
            icon: 'success',
            title: 'Actualización Exitosa',
            text: 'Se han actualizado correctamente los datos',
            allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
          })

        }else if(response == "requerid"){
            Swal.fire({
              icon: 'warning',
              title: '¡Atención!',
              text: 'Complete todos los datos por favor',
              allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
            })     

       }else{
            Swal.fire({
              icon: 'error',
              title: '¡Atención!',
              text: 'Error al actualizar en la base de datos',
              allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
            })
        }
    }
})

}
//funcion paraEliminar Categoria
function EliminarTipoCuenta(idTipoCuenta){
  $.ajax({
      data: { "idTipoCuenta": idTipoCuenta },
      url:'../controller/TablasController.php?operador=eliminar_Tipocuenta', //url del controlador Conttroller
      type:'POST',
      beforeSend:function(){},
      success:function(response){
          
          if(response == "success"){
               //actualizar tabla
               tablaTipocuenta.ajax.reload();
               swal.fire({
                  icon: "success",
                  title: "Eliminado",
                  text: "El registro se eliminó"   
              })
            
          }else if(response == "llave_uso"){
              swal.fire({
                  icon: "warning",
                  title: "Atención",
                  text: "El registro no se puede eliminar ya que se encuentra en uso.",
                  allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
              })
          }else{
              swal.fire({
                  icon: "error",
                  title: "Atención",
                  text: "No se ha podido eliminar",
                  allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
                  
              })
          }
         
      }

  });

}
function AlertaEliminarTipocuenta(idTipoCuenta, descripcion){
  Swal.fire({
    title: '¿Está seguro que desea eliminar?',
    text: "Tipo Cuenta: "+descripcion,
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Aceptar',
    cancelButtonText: 'Cancelar',
    allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
  }).then((result) => {
    if (result.isConfirmed) {
      
      EliminarTipoCuenta(idTipoCuenta); //funcion que eliminar el estado

    }
  })
}

 /**************************FUNCIONES DE LOS CREDITO AVAL ***************************************************************** */

//FUNCION PARA LLENAR LA TABLA DE CREDITO AVAL AJAX
function LlenarTablaCreditoAval(){
  tablaCreditoaval = $('#tabla_creditoaval').DataTable({
      pageLength:10,
      responsive: true,
      processign: true,
      "language": {   //para cambiar de idiomas a la tabla
          "lengthMenu": "Mostrar _MENU_ Registro por páginas",
          "zeroRecords": "El registro no existe",
          "info": "Mostrando la página _PAGE_ de _PAGES_",
          "infoEmpty": "No records available",
          "infoFiltered": "(Filtrado de _MAX_ Registros Totales)",
          "search": 'Buscar Registro:',
          "paginate": {
              'next': 'Siguiente',
              'previous': 'Anterior'
          }
      },
      ajax: "../controller/TablasController.php?operador=listar_creditoaval",
      columns : [
          { data : 'Acciones'},
          { data : 'NO'},  //se ponen los datos del Controller
          { data : 'CREDITOAVAL'}, //se ponen los datos del Controller
          
          
      ]

     

  });

  
}

//FUNCION PARA REGISTRA UN estado civil AJAX
function RegistrarCreditoAval(){
  descripcion = $('#descripcion_credito_aval').val(); //id del modal

  parametros = {
      "Descripcion":descripcion
  }

  $.ajax({
      data:parametros,
      url:"../controller/TablasController.php?operador=registrar_credito_aval",
      type:'POST',
      beforeSend:function(){},
      success:function(response){

          if(response == "success"){  //si inserto correctamente
             tablaCreditoaval.ajax.reload();  //actualiza la tablaSSSS
             LimpiarControles();
             $('#registral_creditoaval').modal('hide'); //cierra el modal
             Swal.fire({
              icon: 'success',
              title: 'Registro exitoso',
              text: 'Se han guardado correctamente los datos',
              allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
            })
          }else if(response == "requerid"){
              Swal.fire({
                  icon: 'warning',
                  title: '¡Atención!',
                  text: 'Complete todos los campos',
                  allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
                })
          }else{
              Swal.fire({
                  icon: 'error',
                  title: '¡Atención!',
                  text: 'No se lograron guardar los datos',
                  allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
                })
          }
      }
  })
}

//funcion para obtener el id del credito ava para actualizarlo
function ObtenerCreditoAvalPorId(idCreditoAval, Acciones){
  $.ajax({
      data: { "idCreditoAval": idCreditoAval },
      url:'../controller/TablasController.php?operador=obtener_credito_aval_por_id', //url del controlador Conttroller
      type:'POST',
      beforeSend:function(){},
      success:function(response){
         // console.log(response);  //para probar que traiga datos en consola
          data = $.parseJSON(response);
          if(data.length > 0){

            if(Acciones == "editar"){
              $('#id_edit').val(data[0]['ID']);
              $('#descripcion_credito_aval_edit').val(data[0]['CREDITOAVAL']);  //modal de actualizar estado civil
              

            }else if(Acciones == "eliminar"){
              AlertaEliminarCreditoAval(data[0]['ID'], data[0]['CREDITOAVAL']);
            }
          }
         
      }

  });
}

//funcion para actualizar el estado civil
function ActualizarCreditoAval(){
  idCreditoAval = $('#id_edit').val();  //id de los input del modal de actualizar
  Descripcion = $('#descripcion_credito_aval_edit').val();
 
  
 
  parametros = {
      "idCreditoAval":idCreditoAval, "Descripcion":Descripcion //parametros que se mandan al controlador: actualizar_estado_civil
  }
  $.ajax({
    data:parametros,
    url:'../controller/TablasController.php?operador=actualizar_credito_aval', //url del controlador 
    type:'POST',
    beforeSend:function(){},
    success:function(response){
        if(response == "success"){  //si inserto correctamente
          tablaCreditoaval.ajax.reload();  //actualiza la tabla
           $('#actualizar_creditoaval').modal('hide'); //cierra el modal id del modal

          Swal.fire({
            icon: 'success',
            title: 'Actualización Exitosa',
            text: 'Se han actualizado correctamente los datos',
            allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
          })

        }else if(response == "requerid"){
            Swal.fire({
              icon: 'warning',
              title: '¡Atención!',
              text: 'Complete todos los datos por favor',
              allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
            })     

       }else{
            Swal.fire({
              icon: 'error',
              title: '¡Atención!',
              text: 'error al actualizar en la base de datos',
              allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
            })
        }
    }
})

}

  //funcion paraEliminar un estado civil
function EliminarCreditoAval(idCreditoAval){
  $.ajax({
      data: { "idCreditoAval": idCreditoAval },
      url:'../controller/TablasController.php?operador=eliminar_credito_aval', //url del controlador Conttroller
      type:'POST',
      beforeSend:function(){},
      success:function(response){
          
          if(response == "success"){
               //actualizar tabla
               tablaCreditoaval.ajax.reload();
               swal.fire({
                  icon: "success",
                  title: "Eliminado",
                  text: "El registro se eliminó"   
              })
            
          }else if(response == "llave_uso"){
              swal.fire({
                  icon: "warning",
                  title: "Atención",
                  text: "El registro no se puede eliminar ya que se encuentra en uso.",
                  allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
              })
          }else{
              swal.fire({
                  icon: "error",
                  title: "Atención",
                  text: "No se ha podido eliminar",
                  allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
                  
              })
          }
         
      }

  });

}
function AlertaEliminarCreditoAval(idCreditoAval, Descripcion){
  Swal.fire({
    title: '¿Está seguro que desea eliminar?',
    text: "Credito Aval: "+Descripcion,
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Aceptar',
    cancelButtonText: 'Cancelar',
    allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
  }).then((result) => {
    if (result.isConfirmed) {
      
      EliminarCreditoAval(idCreditoAval); //funcion que eliminar el estado

    }
  })
}
 /**************************FUNCIONES DE LOS OBJETOS ***************************************************************** */

//FUNCION PARA LLENAR LA TABLA DE OBJETOS AJAX
function LlenarTablaObjetos(){
  tablaObjetos = $('#tabla_objetos').DataTable({
      pageLength:10,
      responsive: true,
      processign: true,
      "language": {   //para cambiar de idiomas a la tabla
          "lengthMenu": "Mostrar _MENU_ Registro por páginas",
          "zeroRecords": "El registro no existe",
          "info": "Mostrando la página _PAGE_ de _PAGES_",
          "infoEmpty": "No records available",
          "infoFiltered": "(Filtrado de _MAX_ Registros Totales)",
          "search": 'Buscar Registro:',
          "paginate": {
              'next': 'Siguiente',
              'previous': 'Anterior'
          }
      },
      ajax: "../controller/TablasController.php?operador=listar_objeto",
      columns : [
          { data : 'Acciones'},
          { data : 'NO'},  //se ponen los datos del Controller
          { data : 'OBJETO'}, //se ponen los datos del Controller
          
          
      ]

     

  });

  
}

//FUNCION PARA REGISTRA UN estado civil AJAX
function RegistrarObjetos(){
  descripcion = $('#descripcion_objeto').val(); //id del modal

  parametros = {
      "Descripcion":descripcion
  }

  $.ajax({
      data:parametros,
      url:"../controller/TablasController.php?operador=registrar_objeto",
      type:'POST',
      beforeSend:function(){},
      success:function(response){

          if(response == "success"){  //si inserto correctamente
             tablaObjetos.ajax.reload();  //actualiza la tablaSSSS
             LimpiarControles();
             $('#registral_objetos').modal('hide'); //cierra el modal
             Swal.fire({
              icon: 'success',
              title: 'Registro exitoso',
              text: 'Se han guardado correctamente los datos',
              allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
            })
          }else if(response == "requerid"){
              Swal.fire({
                  icon: 'warning',
                  title: '¡Atención!',
                  text: 'Complete todos los campos',
                  allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
                })
          }else{
              Swal.fire({
                  icon: 'error',
                  title: '¡Atención!',
                  text: 'No se lograron guardar los datos',
                  allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
                })
          }
      }
  })
}

//funcion para obtener el id del credito ava para actualizarlo
function ObtenerObjetosPorId(idObjetos, Acciones){
  $.ajax({
      data: { "idObjetos": idObjetos },
      url:'../controller/TablasController.php?operador=obtener_objeto_por_id', //url del controlador Conttroller
      type:'POST',
      beforeSend:function(){},
      success:function(response){
         // console.log(response);  //para probar que traiga datos en consola
          data = $.parseJSON(response);
          if(data.length > 0){

            if(Acciones == "editar"){
              $('#id_edit').val(data[0]['ID']);
              $('#descripcion_objetos_edit').val(data[0]['OBJETO']);  //modal de actualizar estado civil
              

            }else if(Acciones == "eliminar"){
              AlertaEliminarObjetos(data[0]['ID'], data[0]['OBJETO']);
            }
          }
         
      }

  });
}

//funcion para actualizar Objetos
function ActualizarObjetos(){
  idCreditoAval = $('#id_edit').val();  //id de los input del modal de actualizar
  Descripcion = $('#descripcion_objetos_edit').val();
 
  
 
  parametros = {
      "idObjetos":idObjetos, "Descripcion":Descripcion //parametros que se mandan al controlador: actualizar_estado_civil
  }
  $.ajax({
    data:parametros,
    url:'../controller/TablasController.php?operador=actualizar_objeto', //url del controlador 
    type:'POST',
    beforeSend:function(){},
    success:function(response){
        if(response == "success"){  //si inserto correctamente
          tablaObjetos.ajax.reload();  //actualiza la tabla
           $('#actualizar_objetos').modal('hide'); //cierra el modal id del modal

          Swal.fire({
            icon: 'success',
            title: 'Actualización Exitosa',
            text: 'Se han actualizado correctamente los datos',
            allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
          })

        }else if(response == "requerid"){
            Swal.fire({
              icon: 'warning',
              title: '¡Atención!',
              text: 'Complete todos los datos por favor',
              allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
            })     

       }else{
            Swal.fire({
              icon: 'error',
              title: '¡Atención!',
              text: 'Error al actualizar en la base de datos',
              allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
            })
        }
    }
})

}

  //funcion paraEliminar un estado civil
function EliminarObjetos(idObjetos){
  $.ajax({
      data: { "idObjetos": idObjetos },
      url:'../controller/TablasController.php?operador=eliminar_objeto', //url del controlador Conttroller
      type:'POST',
      beforeSend:function(){},
      success:function(response){
          
          if(response == "success"){
               //actualizar tabla
               tablaObjetos.ajax.reload();
               swal.fire({
                  icon: "success",
                  title: "Eliminado",
                  text: "El registro se eliminó"   
              })
            
          }else if(response == "llave_uso"){
              swal.fire({
                  icon: "warning",
                  title: "Atención",
                  text: "El registro no se puede eliminar ya que se encuentra en uso.",
                  allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
              })
          }else{
              swal.fire({
                  icon: "error",
                  title: "Atención",
                  text: "No se ha podido eliminar",
                  allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
                  
              })
          }
         
      }

  });

}
function AlertaEliminarObjetos(idObjetos, Descripcion){
  Swal.fire({
    title: '¿Está seguro que desea eliminar?',
    text: "Objetos: "+Descripcion,
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Aceptar',
    cancelButtonText: 'Cancelar',
    allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
  }).then((result) => {
    if (result.isConfirmed) {
      
      EliminarObjetos(idObjetos); //funcion que eliminar el estado

    }
  })
}

//funcion para limpiar los inputs de los modals nuevos de todas las tablas
function LimpiarControles(){
    //tipo prestamo
    $('#nombre').val('');  //id del modal
    $('#tasa').val('');
    $('#plazoMaximo').val('');
    $('#montoMinimo').val('');
    $('#montoMaximo').val('');
    //estado civil
    $('#descripcion_estado_civil').val('');
    //Parentesco
    $('#descripcion_Parentesco').val('');
    //categoria Casa
    $('#descripcion_Categoria').val('');
   //Genero
    $('#descripcion_Genero').val('');
    //Contacto
    $('#descripcion_Contacto').val('');
    //bienes
    $('#descripcion_Bienes').val('');
    //Nacionalidad
    $('#descripcion_Nacionalidad').val('');
    //Laboral
    $('#descripcion_Laboral').val('');
    //Plan pago
    $('#descripcion_estadoplanpago').val('');
    //tiempo vvir
    $('#descripcion_Tiempovivir').val('');
    //Estado tipo prestamo
    $('#descripcion_Estadotipoprestamo').val('');
    //estado solicitud
    $('#descripcion_estadosolicitud').val('');
    //rubro
    $('#descripcion_rubro').val('');
    //profesion
    $('#descripcion_Profesion').val('');
    //municipio
    $('#descripcion_Municipio').val('');
    //tipo pago
    $('#descripcion_Tipopago').val('');
    //tipo cliente
    $('#descripcion_Tipocliente').val('');
    //estado credito
    $('#descripcion_Estadocredito').val('');
    //analisis
    $('#descripcion_Analisi').val('');
    //avala a persona
    $('#descripcion_Avala').val('');
    //tipo persona
    $('#descripcion_Tipopersona').val('');
    //tipo cuenta
    $('#descripcion_Tipocuenta').val('');
    //credito aval
    $('#descripcion_credito_aval').val('');
    //objetos
    $('#descripcion_objeto').val('');
    
    //AQUÍ AGREGAR los demas input de las demas tablas
   
   
}



//funciones para solo mayusculas y espacios. estas funcion van en los input de type="text"
 //funcion que valida un solo espacio entre palabras
espacios=function(input){
    input.value=input.value.replace('  ',' ');//sustituimos dos espacios seguidos por uno 
}
   
   //Valida que solo ingrese mayusculas 
function CambiarMayuscula(elemento){
    let texto = elemento.value;
    elemento.value = texto.toUpperCase();
}

//funcion para solo permitir letras en el elemento del formulario.
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


function EventoBitacora(evento, idPantalla, descripcion){ //registra el evento de pdf
  
  $.ajax({
      data: { "evento": evento, "idPantalla":idPantalla, "descripcion":descripcion },
      url:'../controller/TablasController.php?operador=registrarEventoBitacora', //url del controlador Conttroller
      type:'POST',
      beforeSend:function(){},
      success:function(response){
          
          if(response == "success"){
               //actualizar tabla
          
          }else{
              swal.fire({
                  icon: "error",
                  title: "Atención",
                  text: "No se pudo registrar el evento en bitacora de pdf",
                  allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
                  
              })
          }
         
      }

  });

}