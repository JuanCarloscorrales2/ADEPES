var tablaEstadousuario;
init();
//funcion que se ejecutara al inicio

//FUNCION QUE SE EJECUTARA AL INICIO
function init(){
   
    
    LlenartablaEstadousuario();
  
   
}
 
 
 
/***************************FUNCIONES DE LA USUARIO****************************************************************************************************** */

//FUNCION PARA LLENAR LA TABLA DE BIENES AJAX
function LlenartablaEstadousuario(){
    tablaEstadousuario = $('#tabla_estadoUser').DataTable({
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
        
        ajax: "../controller/EstadoUserController.php?operador=listar_ Estadousuario",
        columns : [
            { data : 'Acciones'},
            { data : 'NO'},  //se ponen los datos del Controller
            { data : 'ESTADOUSUARIO'}, //se ponen los datos del Controller  
        ]
    });

  }

  //funcion para obtener el id del cliente para actualizarlo
  function ObtenerEstadousuarioPorId(idEstadoUsuario, Acciones){
    $.ajax({
        data: { "idEstadoUsuario": idEstadoUsuario },
        url:'../controller/EstadoUserController.php?operador=obtener_estadousuario_por_id', //url del controlador Conttroller
        type:'POST',
        beforeSend:function(){},
        success:function(response){
           // console.log(response);  //para probar que traiga datos en consola
            data = $.parseJSON(response);
            if(data.length > 0){
  
              if(Acciones == "editar"){
                $('#id_editarU').val(data[0]['ID']);
                $('#estado_userdes').val(data[0]['ESTADOUSUARIO']);  //modal de actualizar estado civil
                
  
              }else if(Acciones == "eliminar"){
                AlertaEliminarEstadousuario(data[0]['ID'], data[0]['ESTADOUSUARIO']);
              }
            }
           
        }
  
    });
  }

  //funcion para actualizar el estado USUARIO
  function ActualizarEstadousuario(){
    idEstadoUsuario = $('#id_editarU').val();  //id de los input del modal de actualizar
    Descripcion = $('#estado_userdes').val();
   
    
   
    parametros = {
        "idEstadoUsuario":idEstadoUsuario, "Descripcion":Descripcion //parametros que se mandan al controlador: actualizar_estado_civil
    }
  
    //console.log("NOMBRE:"+Descripcion);
    //console.log("ID:"+idEstadoUsuario);
    $.ajax({
      data:parametros,
      url:'../controller/EstadoUserController.php?operador=actualizar_estadousuario', //url del controlador 
      type:'POST',
      beforeSend:function(){},
      success:function(response){
          if(response == "success"){  //si inserto correctamente
            tablaEstadousuario.ajax.reload();  //actualiza la tabla
             $('#actualizar_EstadoUser').modal('hide'); //cierra el modal id del modal
  
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


   //FUNCION PARA REGISTRA UN estado  AJAX
   function RegistrarEstadousuario(){
    descripcion = $('#descripcion_estadoU').val(); //id del modal
  
    parametros = {
        "Descripcion":descripcion
    }
  
    $.ajax({
        data:parametros,
        url:"../controller/EstadoUserController.php?operador=registrar_Estadousuario",
        type:'POST',
        beforeSend:function(){},
        success:function(response){
  
            if(response == "success"){  //si inserto correctamente
               tablaEstadousuario.ajax.reload();  //actualiza la tablaSSSS
               LimpiarControles();
               $('#RegistrarEstadoUser').modal('hide'); //cierra el modal
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


    //funcion paraEliminar estado user 
    function EliminarEstadousuario(idEstadoUsuario){
        $.ajax({
            data: { "idEstadoUsuario": idEstadoUsuario },
            url:'../controller/EstadoUserController.php?operador=eliminar_Estadousuario', //url del controlador Conttroller
            type:'POST',
            beforeSend:function(){},
            success:function(response){
                
                if(response == "success"){
                     //actualizar tabla
                     tablaEstadousuario.ajax.reload();
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
      function AlertaEliminarEstadousuario(idEstadoUsuario, descripcion){
        Swal.fire({
          title: '¿Está seguro que desea eliminar?',
          text: "Estado Usuario: "+descripcion,
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Aceptar',
          cancelButtonText: 'Cancelar',
          allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
        }).then((result) => {
          if (result.isConfirmed) {
            
            EliminarEstadousuario(idEstadoUsuario); //funcion que eliminar el estado
      
          }
        })
      }
    

        //funcion para limpiar los inputs de los modals nuevos de todas las tablas
    function LimpiarControles(){
    
        //estado 
        $('#descripcion_estadoU').val('');
    
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


    //función para generar el PDF y abrirlo en una nueva ventana del listado o registros de los Roles.
    function generarPDF() {
        var datosFiltradosOrdenados = tablaEstadousuario.rows({ search: 'applied', order: 'applied' }).data().toArray();
        // Convertir los datos a formato JSON
        var jsonData = JSON.stringify(datosFiltradosOrdenados);
        //console.log(datosFiltradosOrdenados); //para probar en consola que se envia datos
        // Crear un formulario y campos ocultos para enviar los datos al script PHP
        if (datosFiltradosOrdenados.length === 0) {
            toastr.error('Estimado usuario no hay datos que mostrar en el PDF');
            return; // Detener la ejecución de la función
        }
        var form = $('<form action="../pages/fpdf/listadoEstadoUser.php" method="post" target="_blank">');
        var input = $('<input type="hidden" name="data">').val(jsonData);
        form.append(input);

        // Agregar el formulario a la página y enviarlo
        form.appendTo('body').submit();
    }

    // Agregar un botón en la página para generar y descargar el PDF
    $('#btn_descargar_reporteEstado_pdf').on('click', function() {
        generarPDF();
    });
