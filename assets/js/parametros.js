var table;

init();
//funcion que se ejecutara al inicio

//FUNCION QUE SE EJECUTARA AL INICIO
function init(){
    LlenarTablaParametros();
}

//FUNCION PARA LLENAR LA TABLA DE CAEGORIA AJAX
function LlenarTablaParametros(){
    table = $('#tabla_parametros').DataTable({
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
        ajax: "../controller/ParametroController.php?operador=listar_parametros",
        columns : [
            { data : 'IDSECUENCIAL'},  
            { data : 'parametro'},  
            { data : 'valor'},
            { data : 'Fecha'},
            { data : 'FechaM'},
            { data : 'Acciones'},
            
        ]

    });
}


//funcion para obtener el id del parametro para actualizarlo
function ObtenerParametroPorId(idParametro, Acciones){
    $.ajax({
        data: { "idParametro": idParametro },
        url:'../controller/ParametroController.php?operador=obtener_parametro_por_id', //url del controlador Conttroller
        type:'POST',
        beforeSend:function(){},
        success:function(response){
           // console.log(response);
            data = $.parseJSON(response);
            if(data.length > 0){
  
              if(Acciones == "editar"){
                $('#idp_editar').val(data[0]['Id']);
                $('#nombre_editar').val(data[0]['parametro']);
                $('#valor_edit').val(data[0]['valor']);

              }
              
            }
           
        }
  
    });
  
  }


    //funcion para actualizar el parametro
  function ActualizarParametro(){
      idParametro = $('#idp_editar').val();  //id de los input del modal de actualizar
      Valor = $('#valor_edit').val();

      parametros = {
          "idParametro":idParametro,"Valor":Valor //parametros que se mandan al controlador: actualizar_estado_civil
      }
      $.ajax({
        data:parametros,
        url:'../controller/ParametroController.php?operador=actualizar_parametro', //url del controlador 
        type:'POST',
        beforeSend:function(){},
        success:function(response){
            if(response == "success"){  //si inserto correctamente
              table.ajax.reload();  //actualiza la tabla
               $('#ActualizarParametro').modal('hide'); //cierra el modal id del modal
              Swal.fire({
                icon: 'success',
                title: 'Actualización Exitosa',
                text: 'Se han actualizado correctamente los datos',
              })
    
            }else if(response == "requerid"){
                Swal.fire({
                  icon: 'warning',
                  title: '¡Atención!',
                  text: 'Complete todos los datos por favor',
                })     
            }else if(response == "soloNumero"){
              Swal.fire({
                icon: 'warning',
                title: '¡Atención!',
                text: 'Este tipo de parámetro solo acepta números',
              }) 

            }else if(response == "soloLetra"){
              Swal.fire({
                icon: 'warning',
                title: '¡Atención!',
                text: 'Este tipo de parámetro solo acepta letras',
              }) 
            
            }else if(response == "excedePreguntas"){
              Swal.fire({
                icon: 'warning',
                title: '¡Atención!',
                text: 'El parámetro de preguntas no puede ser mayor que las preguntas registradas en la tabla Preguntas',
            })

            }else{
                  Swal.fire({
                    icon: 'error',
                    title: '¡Atención!',
                    text: 'error al actualizar en la base de datos',
                  })
              }
        }
    })
    
  }