//función para generar el PDF y abrirlo en una nueva ventana del listado o registros de los Roles.
function generarPDF() {
    var datosFiltradosOrdenados = table.rows({ search: 'applied', order: 'applied' }).data().toArray();
    // Convertir los datos a formato JSON
    var jsonData = JSON.stringify(datosFiltradosOrdenados);
    //console.log(datosFiltradosOrdenados); //para probar en consola que se envia datos
    // Crear un formulario y campos ocultos para enviar los datos al script PHP
    if (datosFiltradosOrdenados.length === 0) {
        toastr.error('Estimado usuario no hay datos que mostrar en el PDF');
        return; // Detener la ejecución de la función
    }
    var form = $('<form action="../pages/fpdf/listadoRoles.php" method="post" target="_blank">');
    var input = $('<input type="hidden" name="data">').val(jsonData);
    form.append(input);

    // Agregar el formulario a la página y enviarlo
    form.appendTo('body').submit();
    EventoBitacora(1)//bitacora reporte
}

// Agregar un botón en la página para generar y descargar el PDF
$('#boton_descargar_Rroles_pdf').on('click', function() {
    generarPDF();
});

//funcion para controlar el evento click fuera del modal
function eventoCerrarModal(){

    if($('#nombre_rol').val() != "" || $('#descripcion_rol').val() != ""){ //validad que los input hayan datos
        
      Swal.fire({
          title: '¿Estás seguro?',
          text: "La información ingresada se perderá.",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Sí, salir',
          cancelButtonText: 'Cancelar',
          allowOutsideClick: false //Evita que se cierre la advertencia de cerrar.
        }).then((result) => {
          // Si el usuario confirma, cierra el modal 
          if (result.isConfirmed) {
            //limpia los inputs
            $('#nombre_rol').val('');
            $('#descripcion_rol').val('');

          } else {
            // Si el usuario cancela, vuelve a abrir el modal
            $('#RegistrarRol').modal('show');
          }
        });
    }
   
  }


  function EventoBitacora(evento){ //registra el evento de pdf
  
    $.ajax({
        data: { "evento": evento },
        url:'../controller/RolController.php?operador=registrarEventoBitacora', //url del controlador Conttroller
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

//funcion para solo letras 
function soloLetras(e) {
  key = e.keyCode || e.which;
  tecla = String.fromCharCode(key).toLowerCase();
  letras = "abcdefghijklmnñopqrstuvwxyz";
  especiales = [32]; //permite caracteres especiales usando Caracteres ASCII

  tecla_especial = false
  for(var i in especiales) {
      if(key == especiales[i]) {
          tecla_especial = true;
          break;
      }
  }

  if(letras.indexOf(tecla) == -1 && !tecla_especial)
      return false;
}
