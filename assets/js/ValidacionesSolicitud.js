inict();
//funcion que se ejecutara al inicio cuando se cargue la paginas
function inict(){
    ListarGeneroSelect();
    ListarTipoPrestamoSelect();
    ListarRubrosSelect();
    ListarNacionalidadSelect();
    ListarEstadosCivilesSelect();
    ListarCategoriaCasaSelect();
    ListarTiempoVivirSelect();
    ListarTiempoLaboralSelect();
    ListarProfesionSelect();
    ListarTipoClienteSelect();
    ListarParentescoSelect();
    ListarEstadoCreditoSelect();
    ListarSiEsAvalSelect();
    ListarAvalMoraSelect();
    ListarMunicipioSelect();
    ListarTipoPagoSelect();
    ListarBienesSelect();
}

//FUNCION PARA una nueva profesion por el usuario AJAX
function RegistrarProfesionSolicitud(){
    descripcion = $('#descripcionProfesion').val();

    parametros = {
        "descripcion":descripcion
    }

    $.ajax({
        data:parametros,
        url:'../controller/SolicitudNuevaController.php?operador=registrar_profesion', //url del controlador RolConttroller
        type:'POST',
        beforeSend:function(){},
        success:function(response){
           // console.log(response);
            if(response == "success"){  //si inserto correctamente
               $('#descripcionProfesion').val('');
               $('#RegistarProfesionSolicitud').modal('hide'); //cierra el modal
               toastr.success('Profesión u ocupación agregada con éxito');
               ListarProfesionSelectPorUsuario();
            }else if(response == "requerid"){
                toastr.warning('Agregue una descripción');
            }else{
                toastr.error('error al gurdar el dato');
            }
        }
    })
}

function ListarGeneroSelect(){

    $.ajax({
        url:'../controller/SolicitudNuevaController.php?operador=listar_generos_select',
        type:'GET',
        beforeSend:function(){},
        success:function(respuesta){
            data = $.parseJSON(respuesta);
            if(data.length > 0){ //valida que existan datos
               // console.log(data); //para probar que traiga los datos
                select = "<option value>Seleccione...</option"+"<br>";
  
                 //each sirve para recorrer los elementos de una lista
                $.each(data,function(key,value){   
                select = select + "<option value=" +value[0]+ ">" +value[1]+ "</option>"; //  va 1 ya que es el nombre  por que a si se puso en RolController.php en el metdo
                    
                })
                $('#idGeneroCliente').html(select); //cliente
                $('#generoPareja').html(select);   //pareja
            }
        }
    });
  
}

//FUNCION PARA LLENAR EL SELECT DE prestamos
function ListarTipoPrestamoSelect(){

    $.ajax({
        url:'../controller/SolicitudNuevaController.php?operador=listar_tiposPrestamos_select',
        type:'GET',
        beforeSend:function(){},
        success:function(respuesta){
            data = $.parseJSON(respuesta);
            if(data.length > 0){ //valida que existan datos
                //console.log(data); //para probar que traiga los datos
                select = "<option value>Seleccione...</option"+"<br>";
  
                 //each sirve para recorrer los elementos de una lista
                $.each(data,function(key,value){   
                select = select + "<option value=" +value[0]+ ">" +value[1]+ " al "+value[2]+"%</option>"; //  va 1 ya que es el nombre  por que a si se puso en RolController.php en el metdo
                    
                })
                $('#tipogarantia').html(select);
 
            }
        }
    });
  
}

//FUNCION PARA LLENAR EL SELECT DE rubros
function ListarRubrosSelect(){

    $.ajax({
        url:'../controller/SolicitudNuevaController.php?operador=listar_rubros_select',
        type:'GET',
        beforeSend:function(){},
        success:function(respuesta){
            data = $.parseJSON(respuesta);
            if(data.length > 0){ //valida que existan datos
               // console.log(data); //para probar que traiga los datos
                select = "<option value>Seleccione...</option"+"<br>";
  
                 //each sirve para recorrer los elementos de una lista
                $.each(data,function(key,value){   
                select = select + "<option value=" +value[0]+ ">" +value[1]+ "</option>"; //  va 1 ya que es el nombre  por que a si se puso en RolController.php en el metdo
                    
                })
                $('#rubro').html(select); //cliente
            }
        }
    });
  
}

//FUNCION PARA LLENAR EL SELECT DE Nacionalidades
function ListarNacionalidadSelect(){

    $.ajax({
        url:'../controller/SolicitudNuevaController.php?operador=listar_nacionalidades_select',
        type:'GET',
        beforeSend:function(){},
        success:function(respuesta){
            data = $.parseJSON(respuesta);
            if(data.length > 0){ //valida que existan datos
               // console.log(data); //para probar que traiga los datos
                 select1 ="";
                 //each sirve para recorrer los elementos de una lista
                $.each(data,function(key,value){   
                select1 = select1 + "<option value=" +value[0]+ ">" +value[1]+ "</option>"; //  va 1 ya que es el nombre  por que a si se puso en RolController.php en el metdo
                    
                })
                $('#nacionalidad').html(select1); //cliente
            }
        }
    });
  
}

//FUNCION PARA LLENAR EL SELECT DE estado civiles
function ListarEstadosCivilesSelect(){

    $.ajax({
        url:'../controller/SolicitudNuevaController.php?operador=listar_estadosciviles_select',
        type:'GET',
        beforeSend:function(){},
        success:function(respuesta){
            data = $.parseJSON(respuesta);
            if(data.length > 0){ //valida que existan datos
               // console.log(data); //para probar que traiga los datos
                select1 = "<option value>Seleccione...</option"+"<br>";
  
                 //each sirve para recorrer los elementos de una lista
                $.each(data,function(key,value){   
                select1 = select1 + "<option value=" +value[0]+ ">" +value[1]+ "</option>"; //  va 1 ya que es el nombre  por que a si se puso en RolController.php en el metdo
                    
                })
                $('#estadoCivil').html(select1); //cliente
            }
        }
    });
  
}

//FUNCION PARA LLENAR EL SELECT DE categorias de casa
function ListarCategoriaCasaSelect(){

    $.ajax({
        url:'../controller/SolicitudNuevaController.php?operador=listar_casa_select',
        type:'GET',
        beforeSend:function(){},
        success:function(respuesta){
            data = $.parseJSON(respuesta);
            if(data.length > 0){ //valida que existan datos
               // console.log(data); //para probar que traiga los datos
                select1 = "<option value>Seleccione...</option"+"<br>";
  
                 //each sirve para recorrer los elementos de una lista
                $.each(data,function(key,value){   
                select1 = select1 + "<option value=" +value[0]+ ">" +value[1]+ "</option>"; //  va 1 ya que es el nombre  por que a si se puso en RolController.php en el metdo
                    
                })
                $('#casa').html(select1); //cliente
            }
        }
    });
  
}

//FUNCION PARA LLENAR EL SELECT DE categorias de casa
function ListarTiempoVivirSelect(){

    $.ajax({
        url:'../controller/SolicitudNuevaController.php?operador=listar_tiempovivir_select',
        type:'GET',
        beforeSend:function(){},
        success:function(respuesta){
            data = $.parseJSON(respuesta);
            if(data.length > 0){ //valida que existan datos
               // console.log(data); //para probar que traiga los datos
                select = "<option value>Seleccione...</option"+"<br>";
  
                 //each sirve para recorrer los elementos de una lista
                $.each(data,function(key,value){   
                select = select + "<option value=" +value[0]+ ">" +value[1]+ "</option>"; //  va 1 ya que es el nombre  por que a si se puso en RolController.php en el metdo
                    
                })
                $('#tiempoVivir').html(select); //cliente
            }
        }
    });
  
}

//FUNCION PARA LLENAR EL SELECT DE categorias de casa
function ListarTipoPagoSelect(){

    $.ajax({
        url:'../controller/SolicitudNuevaController.php?operador=listar_tipo_pago_select',
        type:'GET',
        beforeSend:function(){},
        success:function(respuesta){
            data = $.parseJSON(respuesta);
            if(data.length > 0){ //valida que existan datos
               // console.log(data); //para probar que traiga los datos
                select = "";
  
                 //each sirve para recorrer los elementos de una lista
                $.each(data,function(key,value){   
                select = select + "<option value=" +value[0]+ ">" +value[1]+ "</option>"; //  va 1 ya que es el nombre  por que a si se puso en RolController.php en el metdo
                    
                })
                $('#pagaAlquiler').html(select); //cliente
            }
        }
    });
  
}

//FUNCION PARA LLENAR EL SELECT DE categorias de casa
function ListarTiempoLaboralSelect(){

    $.ajax({
        url:'../controller/SolicitudNuevaController.php?operador=listar_tiempolaboral_select',
        type:'GET',
        beforeSend:function(){},
        success:function(respuesta){
            data = $.parseJSON(respuesta);
            if(data.length > 0){ //valida que existan datos
               // console.log(data); //para probar que traiga los datos
                select = "<option value>Seleccione...</option"+"<br>";
  
                 //each sirve para recorrer los elementos de una lista
                $.each(data,function(key,value){   
                select = select + "<option value=" +value[0]+ ">" +value[1]+ "</option>"; //  va 1 ya que es el nombre  por que a si se puso en RolController.php en el metdo
                    
                })
                $('#tiempoLaboral').html(select); //cliente
                $('#tiempoLaboralPareja').html(select); //pareja
            }
        }
    });
  
}

//FUNCION PARA LLENAR EL SELECT DE categorias de casa
function ListarProfesionSelect(){

    $.ajax({
        url:'../controller/SolicitudNuevaController.php?operador=listar_profesiones_select',
        type:'GET',
        beforeSend:function(){},
        success:function(respuesta){
            data = $.parseJSON(respuesta);
            if(data.length > 0){ //valida que existan datos
               // console.log(data); //para probar que traiga los datos
                select = "<option value>Seleccione...</option"+"<br>";
  
                 //each sirve para recorrer los elementos de una lista
                $.each(data,function(key,value){   
                select = select + "<option value=" +value[0]+ ">" +value[1]+ "</option>"; //  va 1 ya que es el nombre  por que a si se puso en RolController.php en el metdo
                    
                })
                $('#profesiones').html(select); //cliente
                $('#profesionPareja').html(select); //Pareja
            }
        }
    });
  
}

function ListarProfesionSelectPorUsuario(){

    $.ajax({
        url:'../controller/SolicitudNuevaController.php?operador=listar_profesion_edit_porusuario',
        type:'GET',
        beforeSend:function(){},
        success:function(respuesta){
            data = $.parseJSON(respuesta);
            if(data.length > 0){ //valida que existan datos
               // console.log(data); //para probar que traiga los datos
                select = "";
  
                 //each sirve para recorrer los elementos de una lista
                $.each(data,function(key,value){   
                select = select + "<option value=" +value[0]+ ">" +value[1]+ "</option>"; 
                    
                })
                $('#profesiones').html(select); //cliente
               
            }
        }
    });
  
}

//FUNCION PARA LLENAR EL SELECT DE categorias de casa
function ListarBienesSelect(){

    $.ajax({
        url:'../controller/SolicitudNuevaController.php?operador=listar_bienes_select',
        type:'GET',
        beforeSend:function(){},
        success:function(respuesta){
            data = $.parseJSON(respuesta);
            if(data.length > 0){ //valida que existan datos
               // console.log(data); //para probar que traiga los datos
                select = "<option value>Seleccione...</option"+"<br>";
  
                 //each sirve para recorrer los elementos de una lista
                $.each(data,function(key,value){   
                select = select + "<option value=" +value[0]+ ">" +value[1]+ "</option>"; //  va 1 ya que es el nombre  por que a si se puso en RolController.php en el metdo
                    
                })
                $('#bienes').html(select); //cliente
               
            }
        }
    });
  
}

//FUNCION PARA LLENAR EL SELECT DE categorias de casa
function ListarTipoClienteSelect(){

    $.ajax({
        url:'../controller/SolicitudNuevaController.php?operador=listar_tipocliente_select',
        type:'GET',
        beforeSend:function(){},
        success:function(respuesta){
            data = $.parseJSON(respuesta);
            if(data.length > 0){ //valida que existan datos
               // console.log(data); //para probar que traiga los datos
                select = "<option value>Seleccione...</option"+"<br>";
  
                 //each sirve para recorrer los elementos de una lista
                $.each(data,function(key,value){   
                select = select + "<option value=" +value[0]+ ">" +value[1]+ "</option>"; //  va 1 ya que es el nombre  por que a si se puso en RolController.php en el metdo
                    
                })
                $('#tipoCliente').html(select); //cliente
                $('#tipoClientePareja').html(select); //pareja
            }
        }
    });
  
}

//FUNCION PARA LLENAR EL SELECT DE categorias de casa
function ListarParentescoSelect(){

    $.ajax({
        url:'../controller/SolicitudNuevaController.php?operador=listar_parentesco_select',
        type:'GET',
        beforeSend:function(){},
        success:function(respuesta){
            data = $.parseJSON(respuesta);
            if(data.length > 0){ //valida que existan datos
               // console.log(data); //para probar que traiga los datos
                select = "";
  
                 //each sirve para recorrer los elementos de una lista
                $.each(data,function(key,value){   
                select = select + "<option value=" +value[0]+ ">" +value[1]+ "</option>"; //  va 1 ya que es el nombre  por que a si se puso en RolController.php en el metdo
                    
                })
                $('#parestencosR1').html(select); //cliente
                $('#parestencosR2').html(select); //pareja
            }
        }
    });
  
}

//FUNCION PARA LLENAR EL SELECT DE categorias de casa
function ListarEstadoCreditoSelect(){

    $.ajax({
        url:'../controller/SolicitudNuevaController.php?operador=listar_estado_credito_select',
        type:'GET',
        beforeSend:function(){},
        success:function(respuesta){
            data = $.parseJSON(respuesta);
            if(data.length > 0){ //valida que existan datos
               // console.log(data); //para probar que traiga los datos
                select = "";
  
                 //each sirve para recorrer los elementos de una lista
                $.each(data,function(key,value){   
                select = select + "<option value=" +value[0]+ ">" +value[1]+ "</option>"; //  va 1 ya que es el nombre  por que a si se puso en RolController.php en el metdo
                    
                })
                $('#estadoCreditoCliente').html(select); //cliente
                $('#estadoCreditoPareja').html(select); //pareja
            }
        }
    });
  
}

//FUNCION PARA LLENAR EL SELECT DE categorias de casa
function ListarSiEsAvalSelect(){

    $.ajax({
        url:'../controller/SolicitudNuevaController.php?operador=listar_sies_aval_select',
        type:'GET',
        beforeSend:function(){},
        success:function(respuesta){
            data = $.parseJSON(respuesta);
            if(data.length > 0){ //valida que existan datos
               // console.log(data); //para probar que traiga los datos
                select = "";
  
                 //each sirve para recorrer los elementos de una lista
                $.each(data,function(key,value){   
                select = select + "<option value=" +value[0]+ ">" +value[1]+ "</option>"; //  va 1 ya que es el nombre  por que a si se puso en RolController.php en el metdo
                    
                })
                $('#esAvalCliente').html(select); //cliente
                $('#esAvalPareja').html(select); //pareja
            }
        }
    });
  
}

//FUNCION PARA LLENAR EL SELECT DE categorias de casa
function ListarAvalMoraSelect(){

    $.ajax({
        url:'../controller/SolicitudNuevaController.php?operador=listar_aval_mora_select',
        type:'GET',
        beforeSend:function(){},
        success:function(respuesta){
            data = $.parseJSON(respuesta);
            if(data.length > 0){ //valida que existan datos
               // console.log(data); //para probar que traiga los datos
                select = "";
  
                 //each sirve para recorrer los elementos de una lista
                $.each(data,function(key,value){   
                select = select + "<option value=" +value[0]+ ">" +value[1]+ "</option>"; //  va 1 ya que es el nombre  por que a si se puso en RolController.php en el metdo
                    
                })
                $('#avalMoraCliente').html(select); //cliente
                $('#avalMoraPareja').html(select); //pareja
            }
        }
    });
  
}

//FUNCION PARA LLENAR EL SELECT DE municipios
function ListarMunicipioSelect(){

    $.ajax({
        url:'../controller/SolicitudNuevaController.php?operador=listar_municipios_select',
        type:'GET',
        beforeSend:function(){},
        success:function(respuesta){
            data = $.parseJSON(respuesta);
            if(data.length > 0){ //valida que existan datos
               // console.log(data); //para probar que traiga los datos
                select = "";
  
                 //each sirve para recorrer los elementos de una lista
                $.each(data,function(key,value){   
                select = select + "<option value=" +value[0]+ ">" +value[1]+ "</option>"; //  va 1 ya que es el nombre  por que a si se puso en RolController.php en el metdo
                    
                })
                $('#municipioCliente').html(select); //cliente
                $('#municipioPareja').html(select); //pareja
            }
        }
    });
  
}




  //funcion para controlar el evento click fuera del modal
  function eventoCerrarModal(){

    if($('#descripcionProfesion').val() != ""){ //validad que los input hayan datos
        
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
            $('#descripcionProfesion').val('');
      
          } else {
            // Si el usuario cancela, vuelve a abrir el modal
            $('#RegistarProfesionSolicitud').modal('show');
          }
        });
    }
  }

 

function formatoIdentidad(event) {
    // Obtener el valor actual del input y eliminar caracteres no numéricos
    var identidad = event.target.value.replace(/\D/g, '');
  
    // Aplicar formato a los dos primeros grupos de 4 números
    if (identidad.length > 8) {
      identidad = identidad.slice(0, 4) + '-' + identidad.slice(4, 8) + '-' + identidad.slice(8);
    } else if (identidad.length > 4) {
      identidad = identidad.slice(0, 4) + '-' + identidad.slice(4);
    }
  
    // Actualizar el valor del input con el formato aplicado
    event.target.value = identidad;
}


        
//validaciones de celulares 
const celularInput = document.getElementById('celularCLiente');  //cliente

            celularInput.addEventListener('input', function() {
            const valorIngresadoC = celularInput.value.replace(/\D/g, ''); // Eliminar caracteres que no sean números
            const grupos = valorIngresadoC.match(/(\d{0,4})/g);
            if (grupos) {
                const valorFormateadoC = grupos.filter(Boolean).join('-');
                celularInput.value = valorFormateadoC;
            }
        });

const celularInputP = document.getElementById('celularPareja');  //Pareja

        celularInputP.addEventListener('input', function() {
        const valorIngresadoP = celularInputP.value.replace(/\D/g, ''); // Eliminar caracteres que no sean números
        const gruposP = valorIngresadoP.match(/(\d{0,4})/g);
        if (gruposP) {
            const valorFormateadoP = gruposP.filter(Boolean).join('-');
            celularInputP.value = valorFormateadoP;
        }
    });

//validaciones de telefonos 
const numeroInput = document.getElementById('telefonoCliente');

        numeroInput.addEventListener('input', function() {
            const valorIngresado = numeroInput.value.replace(/\D/g, ''); // Eliminar caracteres que no sean números
            const grupos = valorIngresado.match(/(\d{0,4})/g);
            if (grupos) {
                const valorFormateado = grupos.filter(Boolean).join('-');
                numeroInput.value = valorFormateado;
            }
        });

const numeroInputTrabajo = document.getElementById('telefonoClienteTrabajo');

        numeroInputTrabajo.addEventListener('input', function() {
            const valorIngresadoT = numeroInputTrabajo.value.replace(/\D/g, ''); // Eliminar caracteres que no sean números
            const grupos = valorIngresadoT.match(/(\d{0,4})/g);
            if (grupos) {
                const valorFormateado = grupos.filter(Boolean).join('-');
                numeroInputTrabajo.value = valorFormateado;
            }
        });
//TELEFONOS PAREJAS
 const numeroInputP1 = document.getElementById('telefonoPareja');

        numeroInputP1.addEventListener('input', function() {
            const valorIngresadoP1 = numeroInputP1.value.replace(/\D/g, ''); // Eliminar caracteres que no sean números
            const gruposP1 = valorIngresadoP1.match(/(\d{0,4})/g);
            if (gruposP1) {
                const valorFormateadoP1 = gruposP1.filter(Boolean).join('-');
                numeroInputP1.value = valorFormateadoP1;
            }
        });

const numeroInputTrabajoP = document.getElementById('telefonoParejaTrabajo');

        numeroInputTrabajoP.addEventListener('input', function() {
            const valorIngresadoTP = numeroInputTrabajoP.value.replace(/\D/g, ''); // Eliminar caracteres que no sean números
            const gruposTP = valorIngresadoTP.match(/(\d{0,4})/g);
            if (gruposTP) {
                const valorFormateadoTP = gruposTP.filter(Boolean).join('-');
                numeroInputTrabajoP.value = valorFormateadoTP;
            }
        });

//TELEFONOS referencias
const numeroInputR1 = document.getElementById('celularR1');

numeroInputR1.addEventListener('input', function() {
    const valorIngresadoR1 = numeroInputR1.value.replace(/\D/g, ''); // Eliminar caracteres que no sean números
    const gruposR1 = valorIngresadoR1.match(/(\d{0,4})/g);
    if (gruposR1) {
        const valorFormateadoR1 = gruposR1.filter(Boolean).join('-');
        numeroInputR1.value = valorFormateadoR1;
    }
});

const numeroInputR2 = document.getElementById('celularR2');

numeroInputR2.addEventListener('input', function() {
    const valorIngresadoR2 = numeroInputR2.value.replace(/\D/g, ''); // Eliminar caracteres que no sean números
    const gruposR2 = valorIngresadoR2.match(/(\d{0,4})/g);
    if (gruposR2) {
        const valorFormateadoR2 = gruposR2.filter(Boolean).join('-');
        numeroInputR2.value = valorFormateadoR2;
    }
});
//
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
//nombre cliente
function limpiaNombreCliente() {
    var val = document.getElementById("nombresCliente").value;
    var tam = val.length;
    for(i = 0; i < tam; i++) {
        if(!isNaN(val[i]))
            document.getElementById("nombresCliente").value = '';
    }
}
//nombre cliente
function limpiaApellidoCliente() {
    var val = document.getElementById("apellidosCliente").value;
    var tam = val.length;
    for(i = 0; i < tam; i++) {
        if(!isNaN(val[i]))
            document.getElementById("apellidosCliente").value = '';
    }
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

function validarNumeroNegativo(input) {
    if (input.value < 0) {
        input.value = 0; // Establecer el valor a 0 si se ingresa un número negativo
        toastr.warning('No estan permitidos los números negativos');
    }
}
