var table;

init();
//funcion que se ejecutara al inicio

//FUNCION QUE SE EJECUTARA AL INICIO
function init(){
    LlenarTablaBitacora();

}

//FUNCION PARA LLENAR LA TABLA DE bitacora AJAX
function LlenarTablaBitacora(){
    table = $('#tabla_bitacora').DataTable({
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
       
        ajax: "../controller/BitacoraController.php?operador=listar_Bitacora",
        columns : [
            { data : 'USUARIO'},  //se ponen los datos del BITACORAController.php
            { data : 'OBJETO'},
            { data : 'ACCION'},  //se ponen los datos del BITACORAController.php
            { data : 'DESCRIPCION'},
            { data : 'FECHA'},
            
        ]

    });

    //Para buscar en la tabla por medio de input
    $('.filter-input').keyup(function(){
        table.column($(this).data('column'))
        .search($(this).val() )
        .draw();
    });
    //Para buscar en la tabla por medio de input
    $('.filter-input').keyup(function(){
        table.column($(this).data('column'))
        .search($(this).val() )
        .draw();
    });

    //Para buscar en la tabla por medio de select
    $('.filter-select').change(function(){
        table.column($(this).data('column'))
        .search($(this).val() )
        .draw();
    });
    
}


//FUNCION PARA LLENAR LA TABLA DE CAEGORIA AJAX
function LlenarTablaBitacoraPorFecha(){
    fechaInicio = $('#fechainicio').val();
    fechaFinal = $('#fechafinal').val();

    //validacion para no filtrar fechas vacios
    if(fechaInicio == ""){
        toastr.warning('¡La fecha inicio no debe estar vacio!');
        return
    }
    if(fechaFinal == ""){
        toastr.warning('¡La fecha final no debe estar vacio!');
        return
    }

    if(fechaInicio > fechaFinal){ //VALIDACION PARA NO PERMITIR FECHA MENOR QUE LA FECHA INICIO
        toastr.warning('¡La fecha final no puede ser menor que la fecha incio');
        return
    }
        
    // Verificar si la tabla ya está inicializada
    if ($.fn.DataTable.isDataTable('#tabla_bitacora')) {
        // Si ya está inicializada, destruye antes de volver a inicializarla para cargar los nuevo datos
        table.destroy();
    }

    table = $('#tabla_bitacora').DataTable({
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
       
        ajax: {
            url: "../controller/BitacoraController.php",
            type: "GET",
            data: {
                operador: "listar_Bitacora_porFecha",
                fechaInicio: fechaInicio,
                fechaFinal: fechaFinal
            }
        },
        columns : [
            { data : 'USUARIO'},  //se ponen los datos del BITACORAController.php
            { data : 'OBJETO'},
            { data : 'ACCION'},  //se ponen los datos del BITACORAController.php
            { data : 'DESCRIPCION'},
            { data : 'FECHA'},
        ]

    });

    
    
}


