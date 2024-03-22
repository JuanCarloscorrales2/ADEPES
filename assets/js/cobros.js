var tablaPagos;
var tablaPagosHistorico;
//obtenerDatosDeLocalStorage(); envidos desde listadoCobros
var idSolicitud = localStorage.getItem('variableParaEnviar');
$('#idSoli').val(idSolicitud);
//console.log(idSolicitud); //
LlenarTablaCobros(idSolicitud);
LlenarTablaCobrosHistorico(idSolicitud)
DatosCliente(idSolicitud);
//valorCapitalTotal(idSolicitud);
//FUNCION PARA LLENAR LA TABLA DE cobros por cliente AJAX
function LlenarTablaCobros(idSolicitud) {
    $('.nav-tabs > .active').next('li').find('a').trigger('click');
    tablaPagos = $('#tabla_pagos').DataTable({
        pageLength: 10,
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

        ajax: {
            url: '../controller/CobrosController.php?operador=listar_cuota_persona',
            type: 'POST',
            data: {
                "idSolicitud": idSolicitud, "next_pay": "yes"
            },
            // Resto de las configuraciones AJAX
        },
        columns: [
            { data: 'Acciones' },
            { data: 'NumeroCuotas' },
            { data: 'FechaCuota' },
            { data: 'fechaDeposito' },
            { data: 'valorCuota' },
            { data: 'pagoAdicional' },
            { data: 'saldoCapital' },
            { data: 'diasRetraso' },
            { data: 'interesesMoratorios' },
            { data: 'mora' },
            { data: 'Descripcion' }

        ],
        order: [[1, 'asc']]


    });

}
function LlenarTablaCobrosHistorico(idSolicitud) {

    tablaPagosHistorico = $('#tabla_pagoshistorico').DataTable({
        pageLength: 10,
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

        ajax: {
            url: '../controller/CobrosController.php?operador=listar_cuota_persona',
            type: 'POST',
            data: {
                "idSolicitud": idSolicitud, "no_actions": true
            },
            // Resto de las configuraciones AJAX
        },
        columns: [
            { data: 'Acciones' },
            { data: 'NumeroCuotas' },
            { data: 'FechaCuota' },
            { data: 'fechaDeposito' },
            { data: 'valorCuota' },
            { data: 'pagoAdicional' },
            { data: 'saldoCapital' },
            { data: 'diasRetraso' },
            { data: 'interesesMoratorios' },
            { data: 'mora' },
            { data: 'Descripcion' }

        ],
        order: [[1, 'asc']]


    });

}

//funcion para traer datos egnerales del cliente
function DatosCliente(idSolicitud) {

    $.ajax({
        data: { "idSolicitud": idSolicitud },
        url: '../controller/CobrosController.php?operador=datos_cliente',
        type: 'POST',
        beforeSend: function () { },
        success: function (response) {
            //console.log(response); 
            data = $.parseJSON(response);
            if (data.length > 0) { //valida que existan datos
                $('#cliente').val(data[0]['cliente']);
                $('#identidad').val(data[0]['identidad']);
                $('#monto').val(data[0]['Monto']);
                $('#interes').val(data[0]['totalInteres']);
                $('#cuotas').val(data[0]['plazo']);
                $('#fecha').val(data[0]['FechaAprob']);
            }
        }
    });

}


function ObtenerCuotaPorId(idPlanCuota, opcion) {

    $.ajax({
        data: { "idPlanCuota": idPlanCuota },
        url: '../controller/CobrosController.php?operador=obtener_cuota_por_id',
        type: 'POST',
        beforeSend: function () { },
        success: function (response) {
            // console.log(response);
            var data = $.parseJSON(response);
            if (data.length > 0) {
                if (opcion == "PagarCuota") {
                    // $('#fechaPago').val(data[0]['cliente']);
                    $('#montoPago').val(data[0]['valorCuota']);
                    $('#idPlanCuota').val(data[0]['idPlanCuota']);
                    $('#capital').val(data[0]['valorCapital']);
                    var montoPagar = parseFloat($('#montoPago').val());

                    // var valorCuota = parseFloat(data[0]['valorCuota']);
                    // var pagoAdicional = montoPagar - valorCuota;
                    // Redondear el pago adicional a dos decimales
                    // pagoAdicional = pagoAdicional.toFixed(2);
                    // $('#montoPagoAdicional').val(pagoAdicional);

                } else if (opcion == "Imprimir") {
                    reciboCuota(data[0]['idPlanCuota']);
                }

            }
        },
        error: function (xhr, status, error) {
            // Manejar errores aquí si es necesario
            console.error(error);
        }
    });


}
function validarPago() {
    var montoPago = parseFloat($('#montoPago').val() || 0);
    var pagoAdicional = parseFloat($('#montoPagoAdicional').val() || 0);
    var diferencia = (pagoAdicional - montoPago).toFixed(2)
    if (pagoAdicional && (montoPago < pagoAdicional)) {
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: "btn btn-success mr-1 ml-1",
                cancelButton: "btn btn-danger"
            },
            buttonsStyling: false
        });
        swalWithBootstrapButtons.fire({
            title: "¿Desea recibir cambio o Abonar como pago Adicional?",
            text: "El cliente debe responder esta pregunta",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Si, Hacer pago Adicional!",
            cancelButtonText: "No, Recibir cambio!",
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                swalWithBootstrapButtons.fire({
                    title: "¡Hará un Pago Adicional!",
                    text: "Su pago Adicional sera de " + diferencia,
                    icon: "success"
                }).then(()=>{
                    RegistrarPago(diferencia)
                });
            } else if (
                /* Read more about handling dismissals below */
                result.dismiss === Swal.DismissReason.cancel
            ) {
                swalWithBootstrapButtons.fire({
                    title: "Debe brindar cambio al cliente",
                    text: "El efectivo que debe entregar es de " + diferencia,
                    icon: "info"
                }).then(()=>{
                    RegistrarPago(0)
                });
            }
        });
    }
    else { RegistrarPago(0) }
}

function RegistrarPago(pagoAdicional) {
    idPlanCuota = $('#idPlanCuota').val();
    montoPago = $('#montoPago').val();
    pagoAdicional = pagoAdicional;
    abonoCapital = $('#capital').val();
    fechaDeposito = $('#fechaPago').val();
    if (idPlanCuota === "") {
        toastr.warning('Para registrar un pago seleccione una cuota');
        return
    }
    if (fechaDeposito === "") {
        toastr.warning('Ingrese la fecha de depósito');
        return
    }

    parametros = {
        "idPlanCuota": idPlanCuota, "montoPago": montoPago, "abonoCapital": abonoCapital, "fechaDeposito": fechaDeposito, "pagoAdicional": pagoAdicional, "idSolicitud": idSolicitud
    }

    $.ajax({
        data: parametros,
        url: '../controller/CobrosController.php?operador=actualizar_pagoCuota_movimiento',
        type: 'POST',
        beforeSend: function () { },
        success: function (response) {
            //console.log(response);
            if (response == "success") {  //si inserto correctamente
                tablaPagos.ajax.reload();  //actualiza la tabla
                tablaPagosHistorico.ajax.reload();
                toastr.success('El pago se ha registrado correctamente');
                $('#idPlanCuota').val('');
                $('#montoPago').val('');
                $('#fechaPago').val('');
                $('#montoPagoAdicional').val('');
            } else if (response == "requerid") {
                Swal.fire({
                    icon: 'error',
                    title: '¡Atención!',
                    text: 'Complete todos los datos por favor',
                })//mensaje


            } else {
                Swal.fire({
                    icon: 'error',
                    title: '¡Atención!',
                    text: 'error inesperado',
                })
            }
        }
    })
}

//funcion que obtiene el valor pagado a capital
function AdvertenciaLiquidarPrestamo() {
    idSolicitud = $('#idSoli').val();
    var monto = parseFloat($('#monto').val());
    parametros = {
        "idSolicitud": idSolicitud
    }
    $.ajax({
        data: parametros,
        url: '../controller/CobrosController.php?operador=obtener_valorCapital',
        type: 'POST',
        beforeSend: function () { },
        success: function (response) {
            console.log(response);
            data = $.parseJSON(response);
            if (data.length > 0) { //valida que existan datos
                var capitalAdeudado = monto - data[0]['totalAbonoCapital'];
                Swal.fire({
                    title: '¿Esta seguro de liquidar el préstamo?',
                    icon: 'info',
                    html: 'Capital Abonado: L. ' + data[0]['totalAbonoCapital'] + '<br><b>Capital Adeudado: L. ' + capitalAdeudado + '</b>',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Aceptar',
                    cancelButtonText: 'Cancelar',
                }).then((result) => {
                    if (result.isConfirmed) {
                        //metodo que mandara la solicitud para eliminar al usuario

                        valorCapitalTotal(idSolicitud);

                    }
                })

            }
        }
    });

}

function valorCapitalTotal(idSolicitud) {

    parametros = {
        "idSolicitud": idSolicitud
    }

    $.ajax({
        data: parametros,
        url: '../controller/CobrosController.php?operador=liquidar_prestamo',
        type: 'POST',
        beforeSend: function () { },
        success: function (response) {
            //console.log(response);
            if (response == "success") {  //si inserto correctamente
                tablaPagos.ajax.reload();  //actualiza la tabla

                Swal.fire({
                    icon: 'success',
                    title: 'Préstamo Liquidado',

                })//mensaje

            } else {
                Swal.fire({
                    icon: 'error',
                    title: '¡Atención!',
                    text: 'error en la Base de datos al liquidar el préstamo',
                })
            }
        }
    })
}


function reciboCuota(idPlanCuota) {
    var cliente = $('#cliente').val();
    // Envía el idSoli al script PHP que genera el PDF
    window.location.href = '../pages/fpdf/ReciboCuota.php?idPlan=' + idPlanCuota + '&nombre=' + cliente;
}

function EstadoDeCuentasPDF() {
    var idSolicitud = $('#idSoli').val();
    // Envía el idSoli al script PHP que genera el PDF
    window.location.href = '../pages/fpdf/EstadoDeCuentas.php?idSoli=' + idSolicitud;
}