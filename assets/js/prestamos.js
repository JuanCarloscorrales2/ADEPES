var table;

init();
//funcion que se ejecutara al inicio

//FUNCION QUE SE EJECUTARA AL INICIO
function init(){
    //LlenarTablaClientes();
    LlenarTablaPrestamos();
    MostrarPlanPagos();
}

//FUNCION PARA LLENAR LA TABLA DE CAEGORIA AJAX
function LlenarTablaPrestamos(){
    table = $('#tabla_prestamos').DataTable({
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
        ajax: "../controller/PrestamoController.php?oper=listar_prestamos",
        columns : [
          { data : 'Acciones'},  //se ponen los datos del Controller.php
          //{ data : 'idSolicitud'},
          { data: 'IdSe' },
          { data : 'Nombre'},  //se ponen los datos del Controller.php
          { data : 'Prestamo'},
          { data : 'Monto'},
          { data : 'Desembolso'},
          { data : 'Plazo'},
          { data : 'Rubro'},
          { data : 'Descripcion'},

        ]

    });
}

  //  se manda a llamar desde la funcion ObtenerClientePorId()
  function MostrarPlanPagos(idSolicitud, saldoCapital, fechaDesembolso) {
    var totalInteres = 0;
    $.ajax({
        data: { "idSolicitud": idSolicitud },
        url: '../controller/ClienteController.php?op=mostrar_planPagos',
        type: 'POST',
        beforeSend: function () { },
        success: function (response) {
            //console.log(response);
            data = $.parseJSON(response);
            if (data.length > 0) { // Valida que existan datos
                $('#cuota').val(data[0]['valorCuota']);
                // Selecciona la tabla existente
                var tabla = $("#tabla_plan_pagos tbody");

                // Agrega filas a la tabla
                for (var i = 0; i < data.length; i++) {
                    // Verifica si es la primera fila para asi mostrar la fecha y el saldo
                    if (i === 0) {
                        // Muestra fechaDesembolso y saldoCapital en la primera fila
                        tabla.append("<tr>" +
                            "<td>0</td>" +
                            "<td>" + fechaDesembolso + "</td>" +
                            "<td>-</td>" +
                            "<td>-</td>" +
                            "<td>-</td>" +
                            "<td>" + saldoCapital + "</td>" +
                            "<td>-</td>" +
                            "</tr>");
                    }

                    tabla.append("<tr>" +
                        "<td>" + data[i]['NumeroCuotas'] + "</td>" +
                        "<td>" + data[i]['FechaCuota'] + "</td>" +
                        "<td>" + data[i]['valorCuota'] + "</td>" +
                        "<td>" + data[i]['valorInteres'] + "</td>" +
                        "<td>" + data[i]['valorCapital'] + "</td>" +
                        "<td>" + data[i]['saldoCapital'] + "</td>" +
                        "<td>" + data[i]['Descripcion'] + "</td>" +
                        "</tr>");
                        // Acumula el valor de los intereses
                    totalInteres += parseFloat(data[i]['valorInteres']);
                    
                }
         
                $('#totalInteres').val(totalInteres.toFixed(2))  //muestra el total de intereses
                // Para abri el modal
                var modal = document.getElementById("planPagos");
                modal.style.display = "block";
            }
        }
    });
}

//evento para detectar el cierre del modal
$('#planPagos').on('hidden.bs.modal', function () {
  // Selecciona las filas de datos de la tabla, excepto la primera
  $('#tabla_plan_pagos tbody tr:not(:first)').remove();
  // También puedes reiniciar la variable totalInteres si es necesario
  totalInteres = 0;
});

