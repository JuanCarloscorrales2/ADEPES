//función para generar el PDF y abrirlo en una nueva ventana del listado de Estado Plan de Pago
function generarPDF() {
    var datosFiltradosOrdenados = tablaEstadoplanpago.rows({ search: 'applied', order: 'applied' }).data().toArray();
    // Convertir los datos a formato JSON
    var jsonData = JSON.stringify(datosFiltradosOrdenados);
    //console.log(datosFiltradosOrdenados); //para probar en consola que se envia datos
  
    if (datosFiltradosOrdenados.length === 0) {
        toastr.error('Estimado cliente no hay datos que mostrar en el PDF');
        return; // Detener la ejecución de la función
    }
    var form = $('<form action="../pages/fpdf/listadoEstadoPlanPago.php" method="post" target="_blank">');
    var input = $('<input type="hidden" name="data">').val(jsonData);
    form.append(input);
  
    // Agregar el formulario a la página y enviarlo
    form.appendTo('body').submit();
    EventoBitacora(1, 19, "Imprimió el reporte de LISTADO DE ESTADO PLAN DE PAGO");//bitacora reporte
  }
  
  //botón en la página para generar y descargar el PDF
  $('#btn_descargar_reporteEstPlanPago_pdf').on('click', function() {
    generarPDF();
  });

  //funcion para controlar el evento click fuera del modal
function eventoCerrarModal(){

  if($('#descripcion_estadoplanpago').val() != ""){ //validad que los input hayan datos
      
    Swal.fire({
        title: '¿Estás seguro?',
        text: "La información ingresada se perderá.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, salir',
        cancelButtonText: 'Cancelar'
      }).then((result) => {
        // Si el usuario confirma, cierra el modal 
        if (result.isConfirmed) {
          //limpia los inputs
          $('#descripcion_estadoplanpago').val('');
    
        } else {
          // Si el usuario cancela, vuelve a abrir el modal
          $('#registral_estadoplanpago').modal('show');
        }
      });
  }
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
                  text: "No se pudo registrar el evento en bitacora de pdf"
                  
              })
          }
         
      }

  });

}