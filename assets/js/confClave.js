
function CambiarClave(){
    Clave = $('#user_clave').val();
    ConfirmarClave = $('#confirmar_clave').val();
  
    parametros = {
        "Clave":Clave, "ConfirmarClave":ConfirmarClave
    }
  
    $.ajax({
        data:parametros,
        url:'../controller/preguntasController.php?operador=cambiar_clave', //url del controlador RolConttroller
        type:'POST',
        beforeSend:function(){},
        success:function(response){
           // console.log(response);
            if(response == "success"){  //si inserto correctamente
          
    
                      swal({
                        type: "success",
                        title: "Actualización exitosa",
                        text: "Haz actualizado tu contraseña"
                        
                    }).then(function() {
                        window.location = "../index.php";
                    });
                    
              
            }else if(response == "claveDistinta"){
                swal('¡Atención!','Las contraseñas no coinciden','warning'); //mensaje
            }else if(response == "claveminima" ){
                swal('¡Atención!','su contraseña es mu debil','warning'); //mensaje
            }else if(response == "claveMaxima"){
                swal('¡Atención!','Su contraseña a accedido el máximo de caracteres permitido','warning'); //mensaje
            }else if(response == "mismaClave"){
                swal('¡Atención!','Ya haz usado esa contraseña, crea una nueva','warning'); //mensaje
                LimpiarControles(); //LIMPIA LOS INPUT
            }else if(response == "minuscula"){
                swal('¡Atención!','La contraseña debe tener al menos una minúscula','warning'); //mensaje
                
            }else if(response == "mayuscula"){
                swal('¡Atención!','La contraseña debe tener al menos una mayúscula','warning'); //mensaje
     
            }else if(response == "numero"){
                swal('¡Atención!','La contraseña debe tener al menos un número','warning'); //mensaje
                
            }else if(response == "caracteres"){
                swal('¡Atención!','Su contraseña debe tener al menos unos de los siguientes caracteres: _#@$&%','warning'); //mensaje 

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
    $('#user_clave').val('');
    $('#confirmar_clave').val('');
}