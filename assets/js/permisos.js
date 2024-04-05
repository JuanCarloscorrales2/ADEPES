var table;
var table_modulos;
var table_modulos_actualizacion;
var generic_table;
init();
//funcion que se ejecutara al inicio

//FUNCION QUE SE EJECUTARA AL INICIO
function init() {
    LlenarTablaPermisos();
    ListarRolesSelect();
    ListarRolesSelect('tipos_roles_actualizacion');
    ListarObjetosSelect();
    LlenarTablaObjetosIngreso();
}
function LlenarTablaObjetosIngreso(id, objeto) {
    try {
        $('#' + (id || 'tabla_modulos_ingreso')).dataTable().fnClearTable();
        $('#' + (id || 'tabla_modulos_ingreso')).dataTable().fnDestroy();
        const extra = id ? '&actualizacion=1&objeto=' + objeto : '';
        generic_table = $('#' + (id || 'tabla_modulos_ingreso')).DataTable({
            pageLength: 10,
            responsive: true,
            processign: true,
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
            },
            "ajax": {

                url: '../controller/PermisoController.php?operador=listar_objetos_select&solo_modulos=true' + extra,
                "data": function (d) {
                    console.log(d)
                }
            },
            columns: [
                { data: 'id' },  //se ponen los datos del RolController.php
                { data: 'objeto' },
                { data: 'ver' },
                { data: 'insertar' },
                { data: 'actualizar' },
                { data: 'reportes' },
                { data: 'eliminar' },

            ]
        });
        table_modulos_actualizacion = id ? generic_table : null
        table_modulos = !id ? generic_table : null
    }
    catch (ex) {
        console.log(ex)
    }
}
//FUNCION PARA LLENAR LA TABLA DE CAEGORIA AJAX
function LlenarTablaPermisos() {
    table = $('#tabla_permisos').DataTable({
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
        ajax: "../controller/PermisoController.php?operador=listar_permisos",
        columns: [
          //  { data: 'Id' },  //se ponen los datos del RolController.php
            { data: 'IdSe' },
            { data: 'Rol' },  //se ponen los datos del RolController.php
            { data: 'Objeto' },
            { data: 'Consultar' },
            { data: 'Insertar' },
            { data: 'Actualizar' },
            { data: 'Eliminar' },
            { data: 'Reportes' },
            { data: 'Acciones' },


        ],
        order: [[0, 'desc']]
        

    });
    let timeout = null;

    // Agregar controlador de eventos para detectar la búsqueda
    $('#tabla_permisos').on('search.dt', function(event) {
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

//FUNCION PARA LLENAR EL SELECT DE usuarios
function ListarRolesSelect(id) {

    $.ajax({
        url: '../controller/PermisoController.php?operador=listar_roles_select',
        type: 'GET',
        beforeSend: function () { },
        success: function (respuesta) {
            data = $.parseJSON(respuesta);
            if (data.length > 0) { //valida que existan datos
                // console.log(data); //para probar que traiga los datos
                //se agrega value para que valida que no se selccione la opcion: seleccione una categoria
                select = "<option value>Seleccione...</option" + "<br>";

                //each sirve para recorrer los elementos de una lista
                $.each(data, function (key, value) {
                    select = select + "<option value=" + value[0] + ">" + value[1] + "</option>"; //  va 1 ya que es el nombre  por que a si se puso en RolController.php en el metdo

                })
                $('#' + (id || 'tipos_roles')).html(select);

            }
        }
    });
}



//FUNCION PARA LLENAR EL SELECT DE usuarios
function ListarObjetosSelect() {

    $.ajax({
        url: '../controller/PermisoController.php?operador=listar_objetos_select&solo_modulos=true',
        type: 'GET',
        beforeSend: function () { },
        success: function (respuesta) {
            data = $.parseJSON(respuesta);
            if (data.length > 0) { //valida que existan datos
                // console.log(data); //para probar que traiga los datos
                //se agrega value para que valida que no se selccione la opcion: seleccione una categoria
                select = "<option value>Seleccione...</option" + "<br>";

                //each sirve para recorrer los elementos de una lista
                $.each(data, function (key, value) {
                    select = select + "<option value=" + value[0] + ">" + value[1] + "</option>"; //  va 1 ya que es el nombre  por que a si se puso en RolController.php en el metdo

                })
                $('#tipos_objetos').html(select);

            }
        }
    });

}

var permisos = [];
function guardar_actualizar_permiso(nuevo, esActualizacion) {
    if (esActualizacion) {
        permisos = permisos.filter(permiso => permiso.modulo != nuevo.modulo)
    }
    permisos.push(nuevo)
}
function chequear_permiso(e, permiso, modulo) {
    const { checked } = e.target;
    const guardado = permisos.find(permiso => permiso.modulo == modulo)
    var nuevo_permiso = guardado || {
        "modulo": modulo
    }
    nuevo_permiso[permiso] = checked ? 1 : 0
    guardar_actualizar_permiso(nuevo_permiso, guardado ? true : false)
}

//FUNCION PARA REGISTRA UN Permiso AJAX
async function RegistrarPermiso() {
    var objeto, insertar, eliminar, consultar, actualizar, reportes
    rol = $('#tipos_roles').val();
    await Promise.all( permisos.map(permiso => {
        objeto = permiso.modulo;
        insertar = permiso.insertar || -1;
        eliminar = permiso.eliminar || -1;
        consultar = permiso.ver || -1;
        actualizar = permiso.actualizar || -1;
        reportes = permiso.reportes || -1;

    }))
    parametros = {
        "rol": rol, "objeto": objeto, "insertar": insertar, "eliminar": eliminar, "consultar": consultar, "actualizar": actualizar, "reportes": reportes
    }
    realizar_registro(parametros)




}
function realizar_registro(parametros) {
    $.ajax({
        data: parametros,
        url: '../controller/PermisoController.php?operador=registrar_permiso', //url del controlador RolConttroller
        type: 'POST',
        beforeSend: function () { },
        success: function (response) {
            console.log(response);
            if (response == "success") {  //si inserto correctamente
                $('#RegistrarPermiso').modal('hide'); //cierra el modal
                table.ajax.reload();  //actualiza la tabla
                table_modulos.ajax.reload();
                Swal.fire('Registro Exitoso', 'Se han guardado correctamente los datos', 'success'); //mensaje
            } else if (response == "requerid") {
                Swal.fire('¡Atención!', 'Complete todos los datos por favor', 'error'); //mensaje
            } else {
                Swal.fire('¡Atención!', '¡El permiso que está intentando crear ya existe en el sistema! Por favor, seleccione otro.', 'error'); //mensaje
            }
        }
    })
}
$('#Actualizarpermiso').on('show.bs.modal', function (e) {

});
async function actualizar_registro(parametros) {

    rol = $('#tipos_roles_actualizacion').val();
    var id = 0;
    await Promise.all(permisos.map(permiso => {
        objeto = permiso.modulo;
        insertar = permiso.insertar || -1;
        eliminar = permiso.eliminar || -1;
        consultar = permiso.ver || -1;
        actualizar = permiso.actualizar || -1;
        reportes = permiso.reportes || -1;
        id = permiso.id
    }))
    parametros = {
        "id": id, "rol": rol, "objeto": objeto, "insertar": insertar, "eliminar": eliminar, "consultar": consultar, "actualizar": actualizar, "reportes": reportes
    }
    $.ajax({
        data: parametros,
        url: '../controller/PermisoController.php?operador=actualizar_permiso', //url del controlador RolConttroller
        type: 'POST',
        beforeSend: function () { },
        success: function (response) {
            console.log(response);
            if (response == "success") {  //si inserto correctamente
                $('#Actualizarpermiso').modal('hide'); //cierra el modal
                table.ajax.reload();  //actualiza la tabla
                table_modulos_actualizacion.ajax.reload();
                swal.fire('Actualización Exitosa', 'Se han guardado correctamente los datos', 'success'); //mensaje
            } else if (response == "requerid") {
                swal.fire('¡Atención!', 'Complete todos los datos por favor', 'error'); //mensaje
            } else {
                swal.fire('¡Atención!', 'error inesperado', 'error'); //mensaje
            }
        }
    })


}
function eliminar_permiso(id) {
    swal.fire({
        title: "¿Esta seguro que desea Eliminar?",
        text: "Esta Accion no puede revertirse",
        icon: "warning",
        buttons: [
            '¡No, Cancelar!',
            'Si, Eliminar'
        ],
        dangerMode: true,
    }).then(function (isConfirm) {
        if (isConfirm) {
            $.ajax({
                data: { "id": id },
                url: '../controller/PermisoController.php?operador=eliminar_permiso', //url del controlador RolConttroller
                type: 'POST',
                beforeSend: function () { },
                success: function (response) {
                    console.log(response);
                    if (response == "success") {
                        table.ajax.reload();  //actualiza la tabla
                        swal.fire('Eliminación Exitosa', 'Se han guardado correctamente los datos', 'success'); //mensaje
                    } else {
                        swal.fire('¡Atención!', 'error inesperado', 'error'); //mensaje
                    }
                }
            })
        }
    })
}

//FUNCION PARA LLENAR EL SELECT DE usuarios para actualizarlo
function ListarRolesSelectEdit(idPermiso) {

    $.ajax({
        data: { "idPermiso": idPermiso },
        url: '../controller/PermisoController.php?operador=listar_roles_select_edit',
        type: 'POST',
        beforeSend: function () { },
        success: function (respuesta) {
            data = $.parseJSON(respuesta);
            if (data.length > 0) { //valida que existan datos
                // console.log(data); //para probar que traiga los datos
                //se agrega value para que valida que no se selccione la opcion: seleccione una categoria
                select = "";

                //each sirve para recorrer los elementos de una lista
                $.each(data, function (key, value) {
                    select = select + "<option value=" + value[0] + ">" + value[1] + "</option>"; //  va 1 ya que es el nombre  por que a si se puso en RolController.php en el metdo

                })
                $('#tipos_roles_edit').html(select);

            }
        }
    });

}
//funcion para obtener el idpermiso para actualizarlo
function ObtenerPermisoPorId(idPermiso, Acciones, idRol) {
    $("#tipos_roles_actualizacion").attr("disabled", true);
    var rol = $('#variables').attr("rol")
    var selected = idRol
    if (parseInt(rol || 0) !== 2 && parseInt(selected || 0) === 2) {
        $('#modal_body_actualizar').hide();
        Swal.fire({
            title: "¡Prohibido!",
            text: "¡No puede cambiar los permisos del administrador!",
            icon: "warning",
            allowOutsideClick: false
        }).then(function () {
            $('#Actualizarpermiso').modal('hide');
            setTimeout(() => {
                $('#modal_body_actualizar').show();
            }, 200);
        })
    } else {
        $.ajax({
            data: { "idPermiso": idPermiso },
            url: '../controller/PermisoController.php?operador=obtener_permiso_por_id', //url del controlador Conttroller
            type: 'POST',
            beforeSend: function () { },
            success: function (response) {
                // console.log(response);
                data = $.parseJSON(response);
                if (data.length > 0) {

                    if (Acciones == "editar") {
                        $('#id_edit').val(data[0]['idPermiso']);

                        LlenarTablaObjetosIngreso('tabla_modulos_edicion', data[0]['idObjeto']);
                        setTimeout(() => {
                            $('#tipos_objetos').val(data[0]['Objeto']);
                            $('#tipos_roles_actualizacion').val(data[0]['Rol']);
                            $('#switchvera' + data[0]['idObjeto']).prop("checked", data[0]['Consultar'] > 0 ? true : false);
                            $('#switchactualizara' + data[0]['idObjeto']).prop("checked", data[0]['Actualizar'] > 0 ? true : false);
                            $('#switchreportesa' + data[0]['idObjeto']).prop("checked", data[0]['Reportes'] > 0 ? true : false);
                            $('#switcheliminara' + data[0]['idObjeto']).prop("checked", data[0]['Eliminar'] > 0 ? true : false);
                            $('#switchinsertara' + data[0]['idObjeto']).prop("checked", data[0]['Insertar'] > 0 ? true : false);
                            permisos = [{ "id": data[0]['idPermiso'], "modulo": data[0]['idObjeto'], "insertar": data[0]['Insertar'], "actualizar": data[0]['Actualizar'], "eliminar": data[0]['Eliminar'], "ver": data[0]['Consultar'], "reportes": data[0]['Reportes'] }]

                        }, 950);

                    } else if (Acciones == "eliminar") {
                        //AlertaEliminarUsuario(data[0]['id'], data[0]['usuario']);
                    }

                }

            }

        });
    }

}



function EventoBitacora(evento){ //registra el evento de filtrar
  
    $.ajax({
        data: { "evento": evento },
        url:'../controller/PermisoController.php?operador=registrarEventoBitacora', //url del controlador Conttroller
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