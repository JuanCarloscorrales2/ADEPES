var table;

init();
//funcion que se ejecutara al inicio

//FUNCION QUE SE EJECUTARA AL INICIO
function init(){
    LlenarTablaRol();
}

//FUNCION PARA LLENAR LA TABLA DE CAEGORIA AJAX
function LlenarTablaRol(){
    table = $('#tabla_roles').DataTable({
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
        ajax: "../controller/RolController.php?operador=listar_roles",
        columns : [
            { data : 'Id'},  //se ponen los datos del RolController.php
            { data : 'Rol'},  //se ponen los datos del RolController.php
            { data : 'Descripcion'},
            { data : 'Fecha'},
            { data : 'Acciones'},
            
        ]

    });
}



//FUNCION PARA REGISTRA UN ROL AJAX
function RegistrarRol(){
    rol = $('#nombre_rol').val();
    descripcion = $('#descripcion_rol').val();

    parametros = {
        "rol":rol, "descripcion":descripcion
    }

    $.ajax({
        data:parametros,
        url:'../controller/RolController.php?operador=registrar_rol', //url del controlador RolConttroller
        type:'POST',
        beforeSend:function(){},
        success:function(response){
            console.log(response);
            if(response == "success"){  //si inserto correctamente
               table.ajax.reload();  //actualiza la tabla
               LimpiarControles();
               $('#RegistrarRol').modal('hide'); //cierra el modal
               swal('Registro Exitoso','Se guardado correctamente los datos','success'); //mensaje
            }else if(response == "requerid"){
                swal('¡Atención!','Complete todos los datos por favor','error'); //mensaje
            }else{
                swal('¡Atención!','error inesperado','error'); //mensaje
            }
        }
    })
}


//funcion para limpiar los inputs del modal
function LimpiarControles(){
    $('#nombre_rol').val('');
    $('#descripcion_rol').val('');
}

//funcion para obtener el id del rol para actualizarlo
function ObtenerRolPorId(idRol, Acciones){
    $.ajax({
        data: { "idRol": idRol },
        url:'../controller/RolController.php?operador=obtener_rol_por_id', //url del controlador Conttroller
        type:'POST',
        beforeSend:function(){},
        success:function(response){
           // console.log(response);  //para probar que traiga datos en consola
            data = $.parseJSON(response);
            if(data.length > 0){
  
              if(Acciones == "editar"){
                $('#id_editar').val(data[0]['id']);
                $('#nombres_rol').val(data[0]['rol']);
                $('#rol_desc').val(data[0]['descripcion']);  //modal de actualizar estado civil
                
  
              }else if(Acciones == "eliminar"){
                AlertaEliminarRol(data[0]['id'], data[0]['descripcion']);
              }
            }
           
        }
  
    });
}


//funcion para actualizar un rol
function ActualizarRoles(){
    idRol = $('#id_editar').val();
    Rol = $('#nombres_rol').val();
    Descripcion = $('#rol_desc').val();
 
    parametros = {
        "idRol":idRol, "Rol":Rol, "Descripcion":Descripcion
    }
    $.ajax({
      data:parametros,
      url:'../controller/RolController.php?operador=actualizar_rol', //url del controlador RolConttroller
      type:'POST',
      beforeSend:function(){},
      success:function(response){
         // console.log(response);
          if(response == "success"){  //si inserto correctamente
             table.ajax.reload();  //actualiza la tabla
            // LimpiarControles();
             $('#actualizar_rol').modal('hide'); //cierra el modal
            Swal.fire({
              icon: 'success',
              title: 'Actualización Exitosa',
              text: 'Se a guardado correctamente los datos del cliente',
            })
  
          }else if(response == "requerid"){
              Swal.fire({
                icon: 'error',
                title: '¡Atención!',
                text: 'Complete todos los datos por favor',
              })
  
          }else{
              Swal.fire({
                icon: 'error',
                title: '¡Atención!',
                text: 'error al actaulizar en la base de datos',
              })
          }
      }
  })
  
  }

      //funcion paraEliminar un rol
function EliminarRol(idRol){
    $.ajax({
        data: { "idRol": idRol },
        url:'../controller/RolController.php?operador=eliminar_rol', //url del controlador Conttroller
        type:'POST',
        beforeSend:function(){},
        success:function(response){
            
            if(response == "success"){
                 //actualizar tabla
                 table.ajax.reload();
                 swal.fire({
                    icon: "success",
                    title: "Eliminado",
                    text: "El registro se elimino"   
                })
              
            }else if(response == "llave_uso"){
                swal.fire({
                    icon: "warning",
                    title: "Atención",
                    text: "El registro no se puede eliminar ya que se encuentra en uso."
                })
            }else{
                swal.fire({
                    icon: "error",
                    title: "Atención",
                    text: "No se a podido eliminar"
                    
                })
            }
           
        }
  
    });
  
  }
  function AlertaEliminarRol(idRol, Descripcion){
    Swal.fire({
      title: '¿Esta seguro que desea eliminar?',
      text: "Rol: "+Descripcion,
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Aceptar',
      cancelButtonText: 'Cancelar',
    }).then((result) => {
      if (result.isConfirmed) {
        
        EliminarRol(idRol); //funcion que eliminar el estado
  
      }
    })
  }

  //funciones para solo mayusculas y espacios. estas funcion van en los input de type="text"
 //funcion que valida un solo espacio entre palabras
espacios=function(input){
    input.value=input.value.replace('  ',' ');//sustituimos dos espacios seguidos por uno 
}
   
   //Valida que solo ingrese mayusculas 
function CambiarMayuscula(elemento){
    let texto = elemento.value;
    elemento.value = texto.toUpperCase();
}

