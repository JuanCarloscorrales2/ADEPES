var table;

inict();
//funcion que se ejecutara al inicio cuando se cargue la paginas
function inict(){
//LlenarTablaUsuario();
}


// Función para recargar la página cada 5 segundos (5000 milisegundos)
function recargarPagina() {
    setTimeout(function() {
        location.reload();
    }, 5000);
}

//FUNCION PARA LLENAR LA TABLA DE USUARIOS AJAX
function LlenarTablaUsuario(){
  table = $('#tabla_usuario').DataTable({
      ajax: "../controller/perfilController.php?operador=listar_usuarios",
      columns : [
          { data : 'Usuario'},  //se ponen los datos del RolController.php
          { data : 'Nombre'},
          { data : 'Correo'},          
          
      ], 

  });

}

//funcion para obtener el id del usuario para actualizarlo
function ObtenerUsuarioPorId(){
  $.ajax({
      data: { "idUsuario": idUsuario },
      url:'../controller/perfilController.php?operador=obtener_usuario_por_id', //url del controlador Conttroller
      type:'POST',
      beforeSend:function(){},
      success:function(response){
         // console.log(response);
          data = $.parseJSON(response);
          if(data.length > 0){
       
              $('#id_edit').val(data[0]['idusuario']);
              $('#usuario_edit').val(data[0]['Usuario']);
              $('#nombre_edit').val(data[0]['nombre']);
              $('#correo_edit').val(data[0]['Correo']);

          }
         
      }

  });

}


//funcion para actualizar un usuario
function ActualizarUsuario( ){
    idUsuario = $('#id_edit').val();
    NombreUsuario = $('#nombre_edit').val();
    CorreoElectronico = $('#correo_edit').val();
  
    parametros = {
        "idUsuario":idUsuario, "NombreUsuario":NombreUsuario, "CorreoElectronico":CorreoElectronico
    }
    $.ajax({
      data:parametros,
      url:'../controller/perfilController.php?operador=actualizar_usuario', //url del controlador RolConttroller
      type:'POST',
      beforeSend:function(){},
      success:function(response){
          console.log(response);
          if(response == "success"){  //si inserto correctamente
             //table.ajax.reload();  //actualiza la tabla
            // LimpiarControles();
             $('#ActualizarPerfil').modal('hide'); //cierra el modal
            Swal.fire({
              icon: 'success',
              title: 'Actualización Exitosa',
              text: 'Se han guardado correctamente los datos',
            })
  
          }else if(response == "requerid"){
              Swal.fire({
                icon: 'error',
                title: '¡Atención!',
                text: 'Complete todos los datos por favors',
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


