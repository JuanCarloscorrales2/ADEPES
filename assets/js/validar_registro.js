//FUNCION PARA REGISTRA UN ROL AJAX
function AutoregistroUsuario(){

	Usuario = $('#username').val();
	NombreUsuario = $('#nombreCompleto').val();
	CorreoElectronico = $('#correoUser').val();
	Clave = $('#Userclave').val();
	ConfirmarClave = $('#ConfirmClave').val();

  
	parametros = {
		"Usuario":Usuario, "NombreUsuario":NombreUsuario, "correoUser":CorreoElectronico,
		"Clave":Clave, "ConfirmarClave":ConfirmarClave
	}
  
	$.ajax({
		data:parametros,
		url:'../controller/registroController.php?operador=autoregistro_usuario', //url del controlador RolConttroller
		type:'POST',
		beforeSend:function(){},
		success:function(response){
			//console.log(response);
			if(response == "success"){  //si inserto correctamente
			   Swal.fire({
				icon: 'success',
				title: 'Felicidades, te has registrado con éxito',
				text: '¡Se ha enviado un correo de confirmación!',
			}).then(function() {
				window.location = "../index.php";
			});
			   
  
			}else if(response == "requerid"){
			  Swal.fire({
				icon: 'error',
				title: '¡Atención!',
				text: 'Complete todos los campos del formulario',
			  })//mensaje
  
			}else if(response == "existeUsuario"){ 
			  Swal.fire({
				icon: 'warning',
				title: '¡Atención!',
				text: 'El usuario ya se encuentra en uso, ingrese otro',
			  })
			  $('#username').val(''); //limpia el input del usuario repetido
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
				text: 'Correo incorrecto, dominios permitidos (gmail, yahoo, icloud)',
			  })
			}else if(response == "ClaveDistinta"){
			  Swal.fire({
				icon: 'warning',
				title: '¡Atención!',
				text: 'Las contraseñas no coinciden',
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

			}else if(response == "caracteresClave"){
			  Swal.fire({
				icon: 'warning',
				title: '¡Atención!',
				text: 'Su contraseña debe tener mayúsculas, minúsculas, números y alguno de los siguientes caracteres: _#@$&%',
			  })
			  
			}else if(response == "errorCorreo"){
				Swal.fire({
				  icon: 'error',
				  title: '¡Atención!',
				  text: 'No se pudo enviar el correo de confirmación',
				})
			}else{
				Swal.fire({
					icon: 'error',
					title: '¡Atención!',
					text: 'Error al registrar sus datos, verifique su correo',
				  })
			}
		}
	})
  }





//validar espacio en blanco del campo usuario
function validarespacio(e){
	e.value = e.value.replace(/ /g, '');
}

function mayus(e) {
    e.value = e.value.toUpperCase();
}

