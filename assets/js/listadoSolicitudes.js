var table;

init();
//funcion que se ejecutara al inicio

//FUNCION QUE SE EJECUTARA AL INICIO
function init(){
    LlenarTablaSolicitudes();
}

//FUNCION PARA LLENAR LA TABLA DE CAEGORIA AJAX
function LlenarTablaSolicitudes(){
    table = $('#tabla_solicitudes').DataTable({
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
        ajax: "../controller/SolicitudNuevaController.php?operador=listar_solicitudes",
        columns : [
            { data : 'Acciones'},
            { data : 'ID'},  //se ponen los datos del RolController.php
            { data : 'NOMBRE'},  //se ponen los datos del RolController.php
            { data : 'PRESTAMO'},
            { data : 'MONTO'},
            { data : 'TASA'},
            { data : 'PLAZO'},
            { data : 'ESTADO'},
            { data : 'FECHA_DESEMBOLSO'},
            
        ]
     
        

    });
     //Para buscar en la tabla por medio de input
    $('.filter-input').keyup(function(){
        table.column($(this).data('column'))
        .search($(this).val() )
        .draw();
    });

    //Para buscar en la tabla por medio de select
    $('.filter-select').change(function(){
        table.column($(this).data('column'))
        .search($(this).val() )
        .draw();
    });

}
//funcion para obtener el id de la solicitud para actualizarlo
function ObtenerSolicitudPor_Id(persona, Acciones){
    $.ajax({
        data: { "persona": persona, "Acciones":Acciones },
        url:'../controller/SolicitudNuevaController.php?operador=obtener_solicitud_por_id', //url del controlador Conttroller
        type:'POST',
        beforeSend:function(){},
        success:function(response){
            //console.log(response);
            data = $.parseJSON(response);
           
            if(data.length > 0){
  
              if(Acciones == "Editar"){
                //manda la informacion al archivo editarSolicitud
                localStorage.setItem('data', JSON.stringify(data));
                 
              }else if(Acciones == "Comite"){
                $('#idSoli').val(data[0]['idSoli']);
                $('#nombreComite').val(data[0]['nombre']+' '+data[0]['apellido']);
                $('#montoComite').val(data[0]['monto']);
                $('#plazoComite').val(data[0]['plazo']);
                $('#prestamoComite').val(data[0]['prestamo']);
                $('#invierteEn').val(data[0]['invierte']);
             
              }else if(Acciones == "Imprimir"){
                ReporteSolicitud(data[0]['idSoli'], data[0]['idPerso']);
              }else if(Acciones == "Contrato"){
                localStorage.setItem('dataP', JSON.stringify(data));
              }
              
            }
           
        }
  
    });
  
}




 //funcion para aprobar una solicitud
  function GuardarComiteCredito(){

    idSoli = $('#idSoli').val();
    numeroActa = $('#numeroActa').val();
    estadoSoli = $('#estado').val();
    nombre = $('#nombreComite').val();

    $.ajax({
        data: { "idSoli": idSoli, "numeroActa": numeroActa, "estadoSoli": estadoSoli, "nombre":nombre  },
        url:'../controller/SolicitudNuevaController.php?operador=aprobar_Solicitud', //url del controlador Conttroller
        type:'POST',
        beforeSend:function(){},
        success:function(response){
            
            if(response == "success"){

                if(estadoSoli == 1){  //solicitud aprobada
                  Swal.fire({
                    title: 'La solicitud a sido aprobada',
                    icon: 'success',
                    text:'¿Desea imprimir la Resolución?',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si',
                    cancelButtonText: 'No',
                  }).then((result) => {
                    if (result.isConfirmed) {
                      
                       //GENERA EL PDF
                      comiteCreeditoGenerarPDF(idSoli);
                      
                    }
                  })
                }

                if(estadoSoli == 2){  //solicitud no aprobada
                  
                  Swal.fire({
                    title: 'La solicitud a sido denegada',
                    icon: 'success',
                    text:'¿Desea imprimir la Resolución?',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si',
                    cancelButtonText: 'No',
                  }).then((result) => {
                    if (result.isConfirmed) {
                      
                       //GENERA EL PDF
                      comiteCreeditoGenerarPDF(idSoli);
                      
                    }
                  })
                }
                //actualizar tabla
                table.ajax.reload();
                //limpia los inputs
                $('#numeroActa').val('');
                $('#estado').val('');
                
                $('#comiteCredito').modal('hide'); //cierra el modal
              
            }else if(response == "vacio"){
              toastr.error('vacio');
            }else{
              toastr.error('No se pudo aprobar o denegar la solicitud');
            }
           
        }
  
    });
  
  }

 

  function AlertaAprobarSolicitud(){
    numeroActa = $('#numeroActa').val();
    idEstadoSolicitud = $('#estado').val();

    if(numeroActa ===""){
      toastr.warning('Ingrese el # de acta');
      return
    }
    if(idEstadoSolicitud ===""){
      toastr.warning('Seleccione una opción');
      return
    }
    
    if(idEstadoSolicitud == 1){
      
      mensaje ="¿El comité esta seguro que desea aprobar la solicitud?";
      
    }else{
      mensaje ="¿El comité esta seguro que desea denegar la solicitud?";
    }


    Swal.fire({
      title: mensaje,
      icon: 'info',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Aceptar',
      cancelButtonText: 'Cancelar',
    }).then((result) => {
      if (result.isConfirmed) {
        //metodo que mandara la solicitud para eliminar al usuario
       
        GuardarComiteCredito();
        
      }
    })
  }


  function comiteCreeditoGenerarPDF(idSoli){
 // Envía el idSoli al script PHP que genera el PDF
   window.open('../pages/fpdf/ComiteCredito.php?idSoli=' + idSoli, '_blank');
  }



//función para generar el PDF y abrirlo en una nueva ventana DEl listado de usuarios
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
    var form = $('<form action="../pages/fpdf/listadoSolicitudes.php" method="post" target="_blank">');
    var input = $('<input type="hidden" name="data">').val(jsonData);
    form.append(input);

    // Agregar el formulario a la página y enviarlo
    form.appendTo('body').submit();
}

// Agregar un botón en la página para generar y descargar el PDF
$('#boton_descargar_pdf').on('click', function() {
    generarPDF();
});


//funcion para generar el reporte de toda la solicitud
function ReporteSolicitud(idSolicitud, idPersona) {
  
  window.open('../pages/fpdf/SolicitudReporteCompleto.php?idSolicitud=' + idSolicitud + '&idPersona=' + idPersona, '_blank');
}

 //funcion que valida un solo espacio entre palabras
 espacios=function(input){
  input.value=input.value.replace('  ',' ');//sustituimos dos espacios seguidos por uno 
 }
 
 //Valida que solo ingrese mayusculas 
 function CambiarMayuscula(elemento){
     let texto = elemento.value;
     elemento.value = texto.toUpperCase();
 }

 //funcion para controlar el evento click fuera del modal
 function eventoCerrarModalComite(){

  if($('#numeroActa').val() != "" || $('#estado').val() != ""){ //validad que los input hayan datos
      
    Swal.fire({
        title: '¿Estás seguro?',
        text: "La información ingresada se perderá.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, salir',
        cancelButtonText: 'Cancelar'
      }).then((result) => {
        // Si el usuario confirma, cierra el modal 
        if (result.isConfirmed) {
          //limpia los inputs
          $('#numeroActa').val('');
          $('#estado').val('');
    
        } else {
          // Si el usuario cancela, vuelve a abrir el modal
          $('#comiteCredito').modal('show');
        }
      });
  }
}