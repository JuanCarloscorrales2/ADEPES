var table;

inict();
//funcion que se ejecutara al inicio cuando se cargue la paginas
function inict(){
  LlenarTablaUsuario();
  ListarRolesSelect();
 // ListarEstadoSelect();
}


//FUNCION PARA LLENAR LA TABLA DE USUARIOS AJAX
function LlenarTablaUsuario(){
  table = $('#tabla_usuarios').DataTable({
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
      ajax: "../controller/UsuarioController.php?operador=listar_usuarios",
      columns : [
          { data : 'Acciones'},
        //  { data : 'Id'},  //se ponen los datos del RolController.php
          { data : 'Usuario'},  //se ponen los datos del RolController.php
          { data : 'Nombre'},
          { data : 'Rol'},
          { data : 'Estado'},
          { data : 'Correo'},
        //  { data : 'FechaC'},  
          { data : 'Fecha'},          
          
      ], 
     /* columnDefs: [ //estas columnas no se mostraran en la tabla
        {
            target: 1, //id
            visible: false,
            searchable: false
        },
        {
          target: 7, //fecha creacion
          visible: false
        },
        {
          target: 8, //fecha vencimiento
          visible: false
      }
    ]*/
    

  });

  //ocultar y mostrar columnas
  $('.showHideColumn').on('click', function (){
    var tableColumn = table.column($(this).attr('data-columnindex'));
    tableColumn.visible(!tableColumn.visible());
  });
}

//FUNCION PARA LLENAR EL SELECT DE usuarios
function ListarRolesSelect(){

  $.ajax({
      url:'../controller/RolController.php?operador=listar_roles_select',
      type:'GET',
      beforeSend:function(){},
      success:function(respuesta){
          data = $.parseJSON(respuesta);
          if(data.length > 0){ //valida que existan datos
             // console.log(data); //para probar que traiga los datos
               //se agrega value para que valida que no se selccione la opcion: seleccione una categoria
              select = "<option value>Seleccione...</option"+"<br>";

               //each sirve para recorrer los elementos de una lista
              $.each(data,function(key,value){   
              select = select + "<option value=" +value[0]+ ">" +value[1]+ "</option>"; //  va 1 ya que es el nombre  por que a si se puso en RolController.php en el metdo
                  
              })
              $('#tipos_roles').html(select);
                    
          }
      }
  });

}

//FUNCION PARA LLENAR EL SELECT de estados DE usuarios para editar
function ListarEstadoSelect(idUsuario){

  $.ajax({
      data : { "idUsuario" : idUsuario},
      url:'../controller/UsuarioController.php?operador=listar_estados_select',
      type:'POST',
      beforeSend:function(){},
      success:function(respuesta){
          data = $.parseJSON(respuesta);
          if(data.length > 0){ //valida que existan datos
              //console.log(data); //para probar que traiga los datos
               //se agrega value para que valida que no se selccione la opcion: seleccione una categoria
              select = "";

               //each sirve para recorrer los elementos de una lista
              $.each(data,function(key,value){   
              select = select + "<option value=" +value[0]+ ">" +value[1]+ "</option>"; //  va 1 ya que es el nombre  por que a si se puso en RolController.php en el metdo
                  
              })
              $('#tipos_estado_edit').html(select);
                    
          }
      }
  });

}


//FUNCION PARA LLENAR EL SELECT DE usuarios para actualizarlo
function ListarRolesSelectEdit(idUsuario){

  $.ajax({
     data : { "idUsuario" : idUsuario},
      url:'../controller/RolController.php?operador=listar_roles_select_edit',
      type:'POST',
      beforeSend:function(){},
      success:function(respuesta){
          data = $.parseJSON(respuesta);
          if(data.length > 0){ //valida que existan datos
             // console.log(data); //para probar que traiga los datos
               //se agrega value para que valida que no se selccione la opcion: seleccione una categoria
              select="";

               //each sirve para recorrer los elementos de una lista
              $.each(data,function(key,value){   
              select = select + "<option value=" +value[0]+ ">" +value[1]+ "</option>"; //  va 1 ya que es el nombre  por que a si se puso en RolController.php en el metdo
                  
              })
              $('#tipos_roles_edit').html(select);
                    
          }
      }
  });

}



//funcion para obtener el id del usuario para actualizarlo
function ObtenerUsuarioPorId(idUsuario, Acciones){
  $.ajax({
      data: { "idUsuario": idUsuario },
      url:'../controller/UsuarioController.php?operador=obtener_usuario_por_id', //url del controlador RolConttroller
      type:'POST',
      beforeSend:function(){},
      success:function(response){
          //console.log(response);
          data = $.parseJSON(response);
          if(data.length > 0){

            if(Acciones == "editar"){
              $('#id_edit').val(data[0]['id']);
              $('#nombre_edit').val(data[0]['nombre']);
              $('#usuario_edit').val(data[0]['usuario']);
              $('#correo_edit').val(data[0]['correo']);
              $('#clave_edit').val(data[0]['clave']);
              $('#clave_confirmar_edit').val(data[0]['clave']);
              ListarRolesSelectEdit(data[0]['id']);
              ListarEstadoSelect(data[0]['id']);
             //ListarEstadosSelect(data[0]['id']);

            }else if(Acciones == "eliminar"){
              AlertaEliminarUsuario(data[0]['id'], data[0]['usuario']);
            }
            
          }
         
      }

  });

}

//fncion para regsitrar un usuario
//FUNCION PARA REGISTRA UN ROL AJAX
function RegistrarUsuario(){

  Usuario = $('#usuario').val();
  idRol = $('#tipos_roles').val();
  NombreUsuario = $('#nombre').val();
  CorreoElectronico = $('#correo').val();
  Clave = $('#clave').val();
  ConfirmarClave = $('#claveConfirmar').val();
  FechaVencimiento = $('#vencimiento').val();

  parametros = {
      "Usuario":Usuario, "idRol":idRol, "NombreUsuario":NombreUsuario, "CorreoElectronico":CorreoElectronico,
      "Clave":Clave, "ConfirmarClave":ConfirmarClave
  }

  $.ajax({
      data:parametros,
      url:'../controller/UsuarioController.php?operador=registrar_usuario', //url del controlador RolConttroller
      type:'POST',
      beforeSend:function(){},
      success:function(response){
          console.log(response);
          if(response == "success"){  //si inserto correctamente
             table.ajax.reload();  //actualiza la tabla
             LimpiarControles();
             $('#RegistrarUsuario').modal('hide'); //cierra el modal
             Swal.fire({
              icon: 'success',
              title: 'Registro Exitoso',
              text: 'Se ha mandado los datos de acceso al usuario por correo',
              allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
            })//mensaje
             

          }else if(response == "requerid"){
            Swal.fire({
              icon: 'error',
              title: '¡Atención!',
              text: 'Complete todos los datos por favor',
            })//mensaje

          }else if(response == "existeUsuario"){ 
            Swal.fire({
              icon: 'warning',
              title: '¡Atención!',
              text: 'El usuario ya se encuentra en uso',
            })
          }else if(response == "existeCorreo"){ 
            Swal.fire({
              icon: 'warning',
              title: '¡Atención!',
              text: 'El Correo ya esta en uso',
            })
          }else if(response == "dominio"){
            Swal.fire({
              icon: 'warning',
              title: '¡Atención!',
              text: 'has ingresado un correo incorrecto, Dominios permitidos (gmail, yahoo, icloud)',
            })
          }else if(response == "ClaveDistinta"){
            Swal.fire({
              icon: 'warning',
              title: '¡Atención!',
              text: 'La contraseñas no coinciden',
            })

          }else if(response == "claveminima"){
            Swal.fire({
              icon: 'warning',
              title: '¡Atención!',
              text: 'La contraseña es muy debil',
            })
          }else if(response == "clavemaxima"){
            Swal.fire({
              icon: 'warning',
              title: '¡Atención!',
              text: 'Su contraseña ha alcanzado el máximo de caracteres permitido',
            })
          }else if(response == "minuscula"){
            Swal.fire({
              icon: 'warning',
              title: '¡Atención!',
              text: 'La contraseña debe tener al menos una minúscula',
            })
            
          }else if(response == "mayuscula"){
            Swal.fire({
              icon: 'warning',
              title: '¡Atención!',
              text: 'La contraseña debe tener al menos una mayúscula',
            })
          }else if(response == "numero"){
            Swal.fire({
              icon: 'warning',
              title: '¡Atención!',
              text: 'La contraseña debe tener al menos un número',
            })
          }else if(response == "caracteres"){
            Swal.fire({
              icon: 'warning',
              title: '¡Atención!',
              text: 'Su contraseña debe tener al menos unos de los siguientes caracteres: "_#@$&%"',
            })
          }else{
              Swal.fire({
                icon: 'error',
                title: '¡Atención!',
                text: 'error inesperado',
              })
          }
      }
  })
}

//funcion para actualizar un usuario
function ActualizarUsuario( ){
  Usuario = $('#usuario_edit').val();
  idUsuario = $('#id_edit').val();
  NombreUsuario = $('#nombre_edit').val();
  CorreoElectronico = $('#correo_edit').val();
  idRol = $('#tipos_roles_edit').val();
  idEstadoUsuario = $('#tipos_estado_edit').val();

  parametros = {
      "Usuario":Usuario, "idUsuario":idUsuario, "NombreUsuario":NombreUsuario, "CorreoElectronico":CorreoElectronico,
      "idRol":idRol, "idEstadoUsuario":idEstadoUsuario
  }
  $.ajax({
    data:parametros,
    url:'../controller/UsuarioController.php?operador=actualizar_usuario', //url del controlador RolConttroller
    type:'POST',
    beforeSend:function(){},
    success:function(response){
        console.log(response);
        if(response == "success"){  //si inserto correctamente
           table.ajax.reload();  //actualiza la tabla
          // LimpiarControles();
           $('#ActualizarUsuario').modal('hide'); //cierra el modal
          Swal.fire({
            icon: 'success',
            title: 'Actualización Exitosa',
            text: 'Se han guardado correctamente los datos',
            allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
          })

        }else if(response == "requerid"){
            Swal.fire({
              icon: 'error',
              title: '¡Atención!',
              text: 'Complete todos los datos por favors',
            })
        }else if(response == "dominio"){
            Swal.fire({
              icon: 'warning',
              title: '¡Atención!',
              text: 'has ingresado un correo incorrecto, Dominios permitidos (gmail, yahoo, icloud)',
        })

        }else{
            Swal.fire({
              icon: 'Error',
              title: '¡Atención!',
              text: 'Error inesperado',
            })
        }
    }
})

}

function AlertaEliminarUsuario(idUsuario, Usuario){
  Swal.fire({
    title: '¿Está seguro que desea eliminar?',
    text: "El usuario: "+Usuario,
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Si, eliminar',
    cancelButtonText: 'Cancelar',
    allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
  }).then((result) => {
    if (result.isConfirmed) {
      //metodo que mandara la solicitud para eliminar al usuario
      EliminarUsuario(idUsuario, Usuario);

    }
  })
}

function EliminarUsuario(idUsuario, Usuario){

  $.ajax({
    data : { "idUsuario" : idUsuario},
    url:'../controller/UsuarioController.php?operador=eliminar_usuario', 
      type:'POST',
      beforeSend:function(){},
      success:function(response){
        console.log(response);
        if(response == "success"){  //si inserto correctamente
           table.ajax.reload();  //actualiza la tabla
           
           Swal.fire(
            'Eliminado!',
            'El usuario '+Usuario+' ha sido eliminado',
            'success'
          )
        }else if(response == "inactivo"){
          table.ajax.reload();  //actualiza la tabla
          Swal.fire({
            icon: 'warning',
            title: 'Atención..',
            text: 'El usuario '+Usuario+' no se ha podido eliminar, se ha inactivado',
          })
        
        }else{
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'No se ha podido eliminar el usuario',
          })
        }

      }

  });

}

//funcion para limpiar los inputs del modal
function LimpiarControles(){
  $('#usuario').val('');
  $('#tipos_roles').val('');
  $('#nombre').val('');
  $('#correo').val('');
  $('#clave').val('');
  $('#claveConfirmar').val('');
}



/************************* 
//funcion java script para mostrar la clave
var fotoMostrada2 = 'noVer2';
 //actualizar
 function mostrarClaveEdit(){ 
  var contra = document.getElementById("clave_edit");
  var imagen = document.getElementById("foto2"); //variable para la imagen

  if(contra.type == 'password'){
    contra.type = 'text';
  }else{
    contra.type = 'password';
  }
  //funcion para cambir imagen de clave
  if(fotoMostrada2 == 'ver2'){
    imagen.src = '../app-assets/images/noVer2.png';
    fotoMostrada2 = 'noVer2';
  }else{
    imagen.src = '../app-assets/images/ver2.png';
    fotoMostrada2 = 'ver2';
  }
  

}



var fotoMostrada = 'noVer';
 //funcion java script para mostrar la clave confirmada
function mostrarClaveConfirmarEdit(){
  var contraConfirmar = document.getElementById("clave_confirmar_edit");
  var imagen = document.getElementById("foto");
  if(contraConfirmar.type =='password' ){
    contraConfirmar.type = 'text';
    
  }else{
    contraConfirmar.type = 'password';
  }
   
  //funcion para cambir imagen de clave
  if(fotoMostrada == 'ver'){
    imagen.src = '../app-assets/images/noVer.png';
    fotoMostrada = 'noVer';
  }else{
    imagen.src = '../app-assets/images/ver.png';
    fotoMostrada = 'ver';
  }
}


*/
/******************* */