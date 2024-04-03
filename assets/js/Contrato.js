dataP = JSON.parse(localStorage.getItem('dataP')); //datos traidos de listadoSolicitudes.js
 //la variable 'data' en este archivo
//console.log(dataP);
ContratoEdit(dataP[0]['idSoli'] );

//FUNCION PARA REGISTRA el contrato
function RegistrarContrato(){
    var nombre =dataP[0]['nombre']+" "+dataP[0]['apellido'];
    idSolicitud = dataP[0]['idSoli'];
    var fechaContrato = $('#fechaContrato').val();
    const contratoCredito = tinymce.get('contratoCredito').getContent();
    const fianzaSolidaria = tinymce.get('fianzaSolidaria').getContent();
    const pagare = tinymce.get('pagare').getContent();
    const porAvales = tinymce.get('porAvales').getContent();
    const emisionCheques = tinymce.get('cheque').getContent();
    const cuentas = tinymce.get('cuentas').getContent();
    const adicional = tinymce.get('adicional').getContent();

    

    parametros = {
        "idSolicitud":idSolicitud, "fechaContrato":fechaContrato, "contratoCredito":contratoCredito, "fianzaSolidaria":fianzaSolidaria, "pagare":pagare,
         "porAvales":porAvales, "emisionCheques":emisionCheques, "cuentas":cuentas, "adicional":adicional, "nombre":nombre

    }

    if(fechaContrato ==""){  //solo actualzia el contrato sin aprobarlo
        $.ajax({
            data:parametros,
            url:'../controller/ContratoController.php?operador=guardar_contrato', //url del contralador contrato
            type:'POST',
            beforeSend:function(){},
            success:function(response){
                //console.log(response);
                if(response == "success"){  //si inserto correctamente
                 
                    swal.fire({
                        icon: "success",
                        title: "Actualizado",
                        text: "El contrato ha sido actualizado con exito"   
                        
                    }).then(function() {
                        window.location = "../pages/solicitudes.php";
                    });
                    
                }else if(response == "requerid"){
                    swal.fire({
                        icon: "warning",
                        title: "El contrato de crédito no debe estar vacio",
                        text: ""   
                    });
                }else{
                    swal.fire({
                        icon: "error",
                        title: "Error",
                        text: "No se pudo actualizar en el contrato"   
                    });
                }
            }
        })
    }else{  //actualiza el contrato y lo aprueba
        Swal.fire({
            title: '¿Estas seguro que desea aprobar el contrato?',
            text: 'Una vez aprobado, la fecha y contrato no podrá ser editado.',
            icon: 'info',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Aceptar',
            cancelButtonText: 'Cancelar',
            allowOutsideClick: false,
          }).then((result) => {
            if (result.isConfirmed) {
 
                $.ajax({
                    data:parametros,
                    url:'../controller/ContratoController.php?operador=guardar_contrato_y_aprobar', //url del contralador contrato
                    type:'POST',
                    beforeSend:function(){},
                    success:function(response){
                        //console.log(response);
                        if(response == "success"){  //si inserto correctamente
                         
                            swal.fire({
                                icon: "success",
                                title: "Actualizado",
                                text: "El contrato ha sido actualizado y aprobado con éxito"   
                            }).then(function() {
                                window.location = "../pages/solicitudes.php";
                            });
                        }else if(response == "requerid"){
                            swal.fire({
                                icon: "warning",
                                title: "El contrato de crédito, pagare y emisión de cheque no debe estar vacio",
                                text: ""   
                            });
        
                        }else if(response == "fechaMenor"){
                            swal.fire({
                                icon: "warning",
                                title: "Fecha incorrecta",
                                text: "La fecha de aprobación de contrato no debe ser menor que la fecha actual"   
                            });
                        
                        }else if(response == "NoAprobado"){
                            swal.fire({
                                icon: "warning",
                                title: "¡Atención!",
                                text: "Para aprobar el contrato, la solicitud debe estar aprobada por el comité."   
                            });
        
                        }else{
                            swal.fire({
                                icon: "error",
                                title: "Error",
                                text: "No se pudo actualizar en el contrato"   
                            });
                        }
                    }
                })
            }
          })
        
    }
}


    


//funcion para traer los contratos
function ContratoEdit(idSolicitud){
  
    $.ajax({
       data : { "idSolicitud" : idSolicitud},
        url:'../controller/ContratoController.php?operador=traer_contrato',
        type:'POST',
        beforeSend:function(){},
        success:function(response){
         //console.log(response); 
         data = $.parseJSON(response);
            if(data.length > 0){ //valida que existan datos

                if(data[0].estado == 4){ //si el credito fue aprobado no le permitira editar
                    //bloquea los inputs
                    document.getElementById("fechaContrato").disabled = true;
                    var boton = document.getElementById("guardarContrato");
                     // Oculta el botón guardar
                     boton.style.display = "none";

                    $('#contratoCredito').val(data[0].contratoCredito);
                    $('#fianzaSolidaria').val(data[0].fianzaSolidaria);
                    $('#pagare').val(data[0].pagare);
                    $('#porAvales').val(data[0].porAvales);
                    $('#cheque').val(data[0].emisionCheque);
                    $('#cuentas').val(data[0].cuenta);
                    $('#adicional').val(data[0].adicional);       
                    $('#fechaContrato').val(data[0].fechaAprob);
                    
                }else{
                    $('#contratoCredito').val(data[0].contratoCredito);
                    $('#fianzaSolidaria').val(data[0].fianzaSolidaria);
                    $('#pagare').val(data[0].pagare);
                    $('#porAvales').val(data[0].porAvales);
                    $('#cheque').val(data[0].emisionCheque);
                    $('#cuentas').val(data[0].cuenta);
                    $('#adicional').val(data[0].adicional);       
                    $('#fechaContrato').val(data[0].fechaAprob);   
                  }
                }
             
              
        }
    });
  
  }



  //funcion para generar el reporte de contrato
function ReporteContrato() {
    idSolicitud = dataP[0]['idSoli'];
    // Envía el idSoli al script PHP que genera el PDF
    window.open('../pages/fpdf/Contrato.php?idSolicitud=' + idSolicitud, '_blank');
  }
  
