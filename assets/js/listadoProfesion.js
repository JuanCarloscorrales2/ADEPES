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

//funcion para controlar el evento click fuera del modal
function eventoCerrarModal(){

    if($('#descripcion_Profesion').val() != ""){ //validad que los input hayan datos
        
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
            $('#descripcion_Profesion').val('');
      
          } else {
            // Si el usuario cancela, vuelve a abrir el modal
            $('#registral_Profesion').modal('show');
          }
        });
    }
   
  }