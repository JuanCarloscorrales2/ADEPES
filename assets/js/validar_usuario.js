function ValidarUsuario(){
  usuario = $('#user').val();
  clave = $('#user_clave').val();

  parametros ={
    "usuario":usuario,"clave":clave

  }

  $.ajax({
    data:parametros,
    type:'POST',
    url:'controller/UsuarioController.php?operador=validar_usuario', 
    beforeSend:function(){},
    success:function(response){
      //console.log(response); //para probrar que funciona el login
      
      if( response == "success"){
        location.href="pages/welcome.php";
      
      }else if(response == "nuevo"){
       location.href="pages/configPreguntasUser.php";

      }else if(response == "bloqueado"){
        msg = '<div class="alert alert-danger mb-2" role"alert"> <strong> Haz alcanzado el limite de intentos, su usuario se ha bloqueado </strong> </div>';

      }else if(response == "default"){
        msg = '<div class="alert alert-warning mb-2" role"alert"> <strong>Usuario no autorizado para el ingreso, contacte al administrador</strong> </div>';

      }else if(response == "inactivo"){
        msg = '<div class="alert alert-warning mb-2" role"alert"> <strong> Su usuario esta inactivo</strong> </div>';

      }else if(response == "notfound"){
        msg = '<div class="alert alert-danger mb-2" role"alert"> <strong> Usuario / Clave incorrecto </strong> </div>';

      }else if(response == "requerid"){
        msg = '<div class="alert alert-danger mb-2" role"alert"> <center> <strong> Ingrese su usuario y contraseña </strong> <center> </div>';

      }
      $('#estado_login').html(msg); //mostrarar los mensajes de errores en el divdel index
      LimpiarController();
    }

  });

}

//funcion para limpira los campos clave y usuario
function LimpiarController(){
  $('#user').val("");
  $('#user_clave').val("");
}