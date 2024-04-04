var table;

init();
//funcion que se ejecutara al inicio

//FUNCION QUE SE EJECUTARA AL INICIO
function init(){
    LlenarTablaClientes();
    //LlenarTablaPrestamos();
    //MostrarPlanPagos();
}

//FUNCION PARA LLENAR LA TABLA DE CAEGORIA AJAX
function LlenarTablaClientes(){
    table = $('#tabla_clientes').DataTable({
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
        ajax: "../controller/ClienteController.php?op=listar_clientes",
        columns : [
            { data : 'Acciones'},  //se ponen los datos del Controller.php
            { data : 'Nombre'},  //se ponen los datos del Controller.php
            { data : 'Identidad'},
            { data : 'Genero'},
            { data : 'Contacto'},
            { data : 'Direccion'},
            { data : 'Profesion'},

        ]

    });

    let timeout = null;

    // Agregar controlador de eventos para detectar la búsqueda
    $('#tabla_clientes').on('search.dt', function(event) {
        // Limpiar el timeout anterior, si existe
        clearTimeout(timeout);
        
        // Iniciar un nuevo timeout
        timeout = setTimeout(function(){
            // Verificar si la búsqueda actual no está vacía
            if (table.search() !== '') {
                // Realizar acciones solo si hay una búsqueda activa
                EventoBitacora(2);
            }
        }, 2000); // Este es el tiempo en milisegundos antes de que se ejecute el código después de que el usuario deja de escribir
    });
    
}



//funcion para obtener el id del cliente para actualizarlo
function ObtenerClientePorId(idPersona, Acciones){
    $.ajax({
        data: { "idPersona": idPersona },
        url:'../controller/ClienteController.php?op=obtener_cliente_por_id', //url del controlador Conttroller
        type:'POST',
        beforeSend:function(){},
        success:function(response){
           // console.log(response);
            data = $.parseJSON(response);
            if(data.length > 0){
  
              if(Acciones == "editar"){
                $('#idS_edit').val(data[0]['idS']);
                $('#id_edit').val(data[0]['idP']);
                $('#nombre_edit').val(data[0]['nombre']);
                $('#apellido_edit').val(data[0]['apellido']);
                $('#identidad_edit').val(data[0]['identidad']);
                $('#cel_edit').val(data[0]['telefono']);
                $('#add_edit').val(data[0]['direccion']);

  
              }else if (Acciones == "plan"){
                MostrarPlanPagos(data[0]['idS'], data[0]['monto'], data[0]['fecha']); //para traer los datos del plan de pagos
                $('#id_editar').val(data[0]['idP']);
                $('#idprestamo').val(data[0]['idS']);
                $('#nombre').val(data[0]['nombre']+" "+data[0]['apellido']);
                $('#prestamo').val(data[0]['monto']);
                $('#plazo').val(data[0]['plazo']);
                $('#tasa').val(data[0]['tasa']);
                $('#fecha').val(data[0]['fecha']);

              }else if (Acciones == "avales"){
                ObtenerAvalPorId(data[0]['idS']);

              }else if(Acciones == "eliminar"){
                AlertaEliminarCliente(data[0]['idP'], data[0]['nombre']);
              }
              
            }
           
        }
  
    });
  
  }


  
//funcion para actualizar un cliente
function ActualizarClientes(){
    idPersona = $('#id_edit').val();
    nombres = $('#nombre_edit').val();
    apellidos = $('#apellido_edit').val();
    contacto = $('#cel_edit').val();
    direccion = $('#add_edit').val();
    
   
    parametros = {
        "idPersona":idPersona, "nombres":nombres, "apellidos":apellidos, "contacto":contacto,
        "direccion":direccion
    }
    $.ajax({
      data:parametros,
      url:'../controller/ClienteController.php?op=actualizar_cliente', //url del controlador RolConttroller
      type:'POST',
      beforeSend:function(){},
      success:function(response){
         // console.log(response);
          if(response == "success"){  //si inserto correctamente
             table.ajax.reload();  //actualiza la tabla
            // LimpiarControles();
             $('#ActualizarCliente').modal('hide'); //cierra el modal
            Swal.fire({
              icon: 'success',
              title: 'Actualización Exitosa',
              text: 'Se han guardado correctamente los datos del cliente',
            })
  
          }else if(response == "requerid"){
              Swal.fire({
                icon: 'Error',
                title: '¡Atención!',
                text: 'Complete todos los datos por favor',
              })
  
          }else{
              Swal.fire({
                icon: 'Error',
                title: '¡Atención!',
                text: 'Error al actualizar en la base de datos',
              })
          }
      }
  })
  
  }


 //función para generar el PDF y abrirlo en una nueva ventana DEl listado de clientes
 function generarPDF() {
  var datosFiltradosOrdenados = table.rows({ search: 'applied', order: 'applied' }).data().toArray();
  // Convertir los datos a formato JSON
  var jsonData = JSON.stringify(datosFiltradosOrdenados);
  //console.log(datosFiltradosOrdenados); //para probar en consola que se envia datos

  if (datosFiltradosOrdenados.length === 0) {
      toastr.error('Estimado cliente no hay datos que mostrar en el PDF');
      return; // Detener la ejecución de la función
  }
  var form = $('<form action="../pages/fpdf/listadoClientes.php" method="post" target="_blank">');
  var input = $('<input type="hidden" name="data">').val(jsonData);
  form.append(input);

  // Agregar el formulario a la página y enviarlo
  form.appendTo('body').submit();
  EventoBitacora(1); //evento de pdf
}

//botón en la página para generar y descargar el PDF
$('#boton_descargar_pdf_clientes').on('click', function() {
  generarPDF();
});

 //funcion paraEliminar un cliente
 function EliminarClientes(idPersona){
  $.ajax({
      data: { "idPersona": idPersona },
      url:'../controller/ClienteController.php?op=eliminar_cliente', //url del controlador Conttroller
      type:'POST',
      beforeSend:function(){},
      success:function(response){
          
          if(response == "success"){
               //actualizar tabla
               table.ajax.reload();
               swal.fire({
                  icon: "success",
                  title: "Eliminado",
                  text: "El registro se eliminó"   
              })
            
          }else if(response == "llave_uso"){
              swal.fire({
                  icon: "warning",
                  title: "Atención",
                  text: "El cliente no se puede eliminar ya que se encuentra en uso."
              })
          }else{
              swal.fire({
                  icon: "error",
                  title: "Atención",
                  text: "No se ha podido eliminar"
                  
              })
          }
         
      }

  });

}
function AlertaEliminarCliente(idPersona, nombres){
  Swal.fire({
    title: '¿Está seguro que desea eliminar?',
    text: "Cliente: "+nombres,
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Aceptar',
    cancelButtonText: 'Cancelar',
    allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
  }).then((result) => {
    if (result.isConfirmed) {
      
      EliminarClientes(idPersona); //funcion que eliminar el estado

    }
  })
}

 

function EventoBitacora(evento){ //registra el evento de pdf
  
  $.ajax({
      data: { "evento": evento },
      url:'../controller/ClienteController.php?op=registrarPDF', //url del controlador Conttroller
      type:'POST',
      beforeSend:function(){},
      success:function(response){
          
          if(response == "success"){
               //actualizar tabla
          
          }else{
              swal.fire({
                  icon: "error",
                  title: "Atención",
                  text: "No se pudo registrar el evento en bitacora de pdf"
                  
              })
          }
         
      }

  });

}
 