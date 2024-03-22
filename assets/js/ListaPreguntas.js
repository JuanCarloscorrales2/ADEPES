var table;

init();
//funcion que se ejecutara al inicio

//FUNCION QUE SE EJECUTARA AL INICIO
function init(){
    LlenarTablaPreguntas();
}

//FUNCION PARA LLENAR LA TABLA DE CAEGORIA AJAX
function LlenarTablaPreguntas(){
    table = $('#tabla_preguntas').DataTable({
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
        ajax: "../controller/ListaPreguntasController.php?operador=listar_preguntas",
        columns : [
            { data : 'idP'},  //se ponen los datos del RolController.php
            { data : 'Pregunta'},  //se ponen los datos del RolController.php
            { data : 'Acciones'},
            
        ]

    });
}

//FUNCION PARA REGISTRA UN PREGUNTA AJAX
function RegistrarPregunta(){
    preguntas = $('#nueva_pregunta').val();

    parametros = {
        "Pregunta":preguntas
    }

    $.ajax({
        data:parametros,
        url:'../controller/ListaPreguntasController.php?operador=registrar_pregunta', //url del controlador RolConttroller
        type:'POST',
        beforeSend:function(){},
        success:function(response){
            console.log(response);
            if(response == "success"){  //si inserto correctamente
               table.ajax.reload();  //actualiza la tabla
               LimpiarControles();
               $('#RegistrarPregunta').modal('hide'); //cierra el modal
               Swal.fire({
                icon: 'success',
                title: 'Registro Exitoso',
                text: 'Se guardado correctamente los datos',
              })
               //mensaje
            }else if(response == "requerid"){
                Swal.fire({
                    icon: 'warning',
                    title: '¡Atención',
                    text: 'Complete todos los datos por favor',
                  })
                //mensaje
            }else{
                Swal.fire({
                    icon: 'error',
                    title: '¡Atención',
                    text: 'error inesperado',
                  })
               //mensaje
            }
        }
    })
}


//funcion para limpiar los inputs del modal
function LimpiarControles(){
    $('#nueva_pregunta').val('');

}


//funcion para obtener el id de la pregunta para actualizarlo
function ObtenerPreguntaPorId(idPregunta, Acciones){
    $.ajax({
        data: { "idPregunta": idPregunta },
        url:'../controller/ListaPreguntasController.php?operador=obtener_pregunta_por_id', //url del controlador Conttroller
        type:'POST',
        beforeSend:function(){},
        success:function(response){
           // console.log(response);
            data = $.parseJSON(response);
            if(data.length > 0){
  
              if(Acciones == "editar"){
                $('#id_editar').val(data[0]['id']);
                $('#pregunta_editar').val(data[0]['Pregunta']);
       
              }else if(Acciones == "eliminar"){
                AlertaEliminarPregunta(data[0]['id'], data[0]['Pregunta']);
              }
              
            }
           
        }
  
    });
  
  }


    
//funcion para actualizar un cliente
function ActualizarPregunta(){
    idPregunta = $('#id_editar').val();
    Pregunta = $('#pregunta_editar').val();

    parametros = {
        "idPregunta":idPregunta, "Pregunta":Pregunta
    }
    $.ajax({
      data:parametros,
      url:'../controller/ListaPreguntasController.php?operador=actualizar_pregunta', //url del controlador RolConttroller
      type:'POST',
      beforeSend:function(){},
      success:function(response){
         // console.log(response);
          if(response == "success"){  //si inserto correctamente
             table.ajax.reload();  //actualiza la tabla
            // LimpiarControles();
             $('#ActualizarPregunta').modal('hide'); //cierra el modal
            Swal.fire({
              icon: 'success',
              title: 'Actualización Exitosa',
              text: 'Se han actualizado correctamente los datos',
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

      //funcion paraEliminar un estado civil
function EliminarPregunta(idPregunta){
    $.ajax({
        data: { "idPregunta": idPregunta },
        url:'../controller/ListaPreguntasController.php?operador=eliminar_pregunta', //url del controlador Conttroller
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
  function AlertaEliminarPregunta(idPregunta, Descripcion){
    Swal.fire({
      title: '¿Esta seguro que desea eliminar?',
      text: "Pregunta: "+Descripcion,
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Aceptar',
      cancelButtonText: 'Cancelar',
    }).then((result) => {
      if (result.isConfirmed) {
        
        EliminarPregunta(idPregunta); //funcion que eliminar el estado
  
      }
    })
  }


