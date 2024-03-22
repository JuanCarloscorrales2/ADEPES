// *********************************** Validaciones de Mayusculas, Espacios y Ver claves ***********************
  //funcion java script para mostrar la clave
  //funcion java script para mostrar la clave
  var fotoMostrada2 = 'noVer2';

  function mostrarClave(){ 
    var contra = document.getElementById("clave");
    var imagen = document.getElementById("foto2"); //variable para la imagen

    if(contra.type == 'password'){
      contra.type = 'text';
    }else{
      contra.type = 'password';
    }
    //funcion para cambir imagen de clave
    if(fotoMostrada2 == 'ver2'){
      imagen.src = '../app-assets/images/noVer2.png';
      fotoMostrada2 = 'noVer2';
    }else{
      imagen.src = '../app-assets/images/ver2.png';
      fotoMostrada2 = 'ver2';
    }
    

  }


  var fotoMostrada = 'noVer';
   //funcion java script para mostrar la clave confirmada
  function mostrarClaveConfirmar(){
    var contraConfirmar = document.getElementById("claveConfirmar");
    var imagen = document.getElementById("foto");
    if(contraConfirmar.type =='password' ){
      contraConfirmar.type = 'text';
      
    }else{
      contraConfirmar.type = 'password';
    }
     
    //funcion para cambir imagen de clave
    if(fotoMostrada == 'ver'){
      imagen.src = '../app-assets/images/noVer.png';
      fotoMostrada = 'noVer';
    }else{
      imagen.src = '../app-assets/images/ver.png';
      fotoMostrada = 'ver';
    }
  }

    //validar espacio en blanco del campo usuario
  function validarespacio(e){
    e.value = e.value.replace(/ /g, '');
  }
   
  //Valida que solo ingrese mayusculas 
  function CambiarMayuscula(elemento){
    let texto = elemento.value;
    elemento.value = texto.toUpperCase();
  }



//*************************************************************************************** */