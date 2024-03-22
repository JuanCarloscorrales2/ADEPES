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
  }
  
  //botón en la página para generar y descargar el PDF
  $('#btn_descargar_reporteEstPlanPago_pdf').on('click', function() {
    generarPDF();
  });