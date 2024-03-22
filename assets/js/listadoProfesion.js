//función para generar el PDF y abrirlo en una nueva ventana del listado de Municipios
function generarPDF() {
    var datosFiltradosOrdenados = tablaProfesion.rows({ search: 'applied', order: 'applied' }).data().toArray();
    // Convertir los datos a formato JSON
    var jsonData = JSON.stringify(datosFiltradosOrdenados);
    //console.log(datosFiltradosOrdenados); //para probar en consola que se envia datos
    // Crear un formulario y campos ocultos para enviar los datos al script PHP
    if (datosFiltradosOrdenados.length === 0) {
        toastr.error('Estimado usuario no hay datos que mostrar en el PDF');
        return; // Detener la ejecución de la función
    }
    var form = $('<form action="../pages/fpdf/listadoProfesion.php" method="post" target="_blank">');
    var input = $('<input type="hidden" name="data">').val(jsonData);
    form.append(input);

    // Agregar el formulario a la página y enviarlo
    form.appendTo('body').submit();
}

// Agregar un botón en la página para generar y descargar el PDF
$('#btn_descargar_reporteProfesion_pdf').on('click', function() {
    generarPDF();
});