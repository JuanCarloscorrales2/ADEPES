var table;

init();
//funcion que se ejecutara al inicio

//FUNCION QUE SE EJECUTARA AL INICIO
function init(){
    LlenarTablaBitacora();
   // LlenarTablaBitacoraPorFecha();
}

//FUNCION PARA LLENAR LA TABLA DE CAEGORIA AJAX
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
            { data : 'USUARIO'},  //se ponen los datos del RolController.php
            { data : 'ACCION'},  //se ponen los datos del RolController.php
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

    //Para buscar en la tabla por medio de select
    $('.filter-select').change(function(){
        table.column($(this).data('column'))
        .search($(this).val() )
        .draw();
    });
}




