var tablaCobros;

init();
//funcion que se ejecutara al inicio

//FUNCION QUE SE EJECUTARA AL INICIO
function init(){
    LlenarTablaCobros();
}

//FUNCION PARA LLENAR LA TABLA DE CAEGORIA AJAX
function LlenarTablaCobros(){
    tablaCobros = $('#tabla_cobros_').DataTable({
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
        ajax: "../controller/CobrosController.php?operador=listar_prestamos_cobro",
        columns : [
            { data : 'Acciones'},
            { data : 'idSolicitud'},  //se ponen los datos del RolController.php
            { data : 'nombre'},  //se ponen los datos del RolController.php
            { data : 'identidad'},
            { data : 'Monto'},
            { data : 'Plazo'},
            { data : 'FechaDesembolso'},
            { data : 'idEstadoPlanPagos'},
            
        ]
     
        

    });
     //Para buscar en la tabla por medio de input
    $('.filter-input').keyup(function(){
        tablaCobros.column($(this).data('column'))
        .search($(this).val() )
        .draw();
    });

}


  // Función en tu archivo JavaScript
function ObtenerDatosPrestamo(idSolicitud, nombre) {
    localStorage.setItem('variableParaEnviar', idSolicitud);

}


//función para generar el PDF y abrirlo en una nueva ventana del listado de cobrs
function listadoCobrosPDF() {
    var datosFiltradosOrdenados = tablaCobros.rows({ search: 'applied', order: 'applied' }).data().toArray();
    // Convertir los datos a formato JSON
    var jsonData = JSON.stringify(datosFiltradosOrdenados);
    //console.log(datosFiltradosOrdenados); //para probar en consola que se envia datos
    // Crear un formulario y campos ocultos para enviar los datos al script PHP
    if (datosFiltradosOrdenados.length === 0) {
        toastr.error('Estimado usuario no hay datos que mostrar en el PDF');
        return; // Detener la ejecución de la función
    }
    var form = $('<form action="../pages/fpdf/ListadoCobros.php" method="post" target="_blank">');
    var input = $('<input type="hidden" name="data">').val(jsonData);
    form.append(input);

    // Agregar el formulario a la página y enviarlo
    form.appendTo('body').submit();
}

// Agregar un botón en la página para generar y descargar el PDF
$('#boton_descargarListadoCobro_pdf').on('click', function() {
    listadoCobrosPDF();
});



