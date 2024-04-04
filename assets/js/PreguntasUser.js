init();
//funcion que se ejecutara al inicio cuando se cargue la paginas
function init(){
  ListarPreguntaSelect();
}




//FUNCION PARA LLENAR EL SELECT DE usuarios
function ListarPreguntaSelect(){

  $.ajax({
      url:'../controller/preguntasController.php?operador=listar_preguntas_select',
      type:'GET',
      beforeSend:function(){},
      success:function(respuesta){
          data = $.parseJSON(respuesta);
          if(data.length > 0){ //valida que existan datos
              //console.log(data); //para probar que traiga los datos
               //se agrega value para que valida que no se selccione la opcion: seleccione una categoria
              select = "<option value>Seleccione...</option"+"<br>";

               //each sirve para recorrer los elementos de una lista
              $.each(data,function(key,value){   
              select = select + "<option value=" +value[0]+ ">" +value[1]+ "</option>"; //  va 1 ya que es el nombre  por que a si se puso en RolController.php en el metdo
                  
              })
              $('#pregunta_usuario').html(select);
                    
          }
      }
  });

}

//FUNCION PARA REGISTRA UNa preguntan
function RegistrarPregunta(){

  idPregunta = $('#pregunta_usuario').val();
  Respuesta = $('#respuesta').val();


  parametros = {
      "idPregunta":idPregunta, "Respuesta":Respuesta
  }

  $.ajax({
      data:parametros,
      url:'../controller/preguntasController.php?operador=registrar_pregunta', //url del controlador RolConttroller
      type:'POST',
      beforeSend:function(){},
      success:function(response){
          //console.log(response);
          if(response == "success"){  //si inserto correctamente
            // $('#RegistrarUsuario').modal('hide'); //cierra el modal
             swal('Registro Exitoso','Se han guardado correctamente los datos','success'); //mensaje
             LimpiarController();
             //location.href="../pages/configPreguntasUser.php";

          }else if(response == "preguntaRegistrada"){
            
            swal('¡Atención!','Ya has registrado esa pregunta, Selecciona otra','warning'); //men
            LimpiarController();
              
          }else if(response == "requerid"){
            swal('¡Atención!','Complete todos los datos por favor','error'); //mensaje

          }else if(response == "error"){
            swal('¡Atención!','error inesperado','error'); //mensaje
          }
         
          //actuaiza la pagina
          setTimeout(function(){
            location.reload()
           }, 2000);
          
      }
      
  })
  
}



//funcion para limpira los campos clave y usuario
function LimpiarController(){
    $('#pregunta_usuario').val("");
    $('#respuesta').val("");
  }