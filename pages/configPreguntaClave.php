<?php  
session_start();
if(isset($_SESSION["user"])){
 ?>
<!-- ========= | scripts robust | ============-->
<?php  include "layouts/main_scripts.php";?> <!-- referencias ajax -->
 
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <link rel="icon" type="image/x-icon" href="/assets/logo-vt.svg" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>ADEPES | Configuración clave</title>
    <link rel="shortcut icon" type="image/x-icon" href="../app-assets/images/ico/logox.ico">
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx"
      crossorigin="anonymous"
    />

  
  </head>
  <body class="bg-success d-flex justify-content-center align-items-center vh-100">
    <div
      class="bg-white p-5 rounded-5 text-secondary shadow"
      style="width: 40rem">
      <div class="d-flex justify-content-center">
        <img
          src="../app-assets/images/ico/logo.png"
          alt="login-icon"
          style="height: 7rem"
        />
      </div>
      <center>
      <div class="text-left fs-4 fw-light">Cambia tu contraseña</div>
      <br>
      <div class="text-left fs-8 fw-bold">Estimado <?php echo $_SESSION["user"]["Usuario"]?> debe realizar el cambio de su contraseña</div>
      <br>
    </center>

      <form>
      
          <div class="input-group mt-1">
            <div class="input-group-text ">
              <img
                src="../app-assets/images/candado.png"
                alt="password-icon"
                style="height: 1.5rem"
              />
            </div>
            <input
              class="form-control bg-light" id="user_clave" 
              type="password"
              onkeyup="validarespacio(this);"
              maxlength="30"
              placeholder="Ingrese una nueva Contraseña"
            />
            <button type="button" class="btn btn-light" style="border: 2px solid #e7e7e7" onclick="mostrarClave();" ><img src="../app-assets/images/noVer2.png" id="foto2"
                style="height: 1rem"> </button>
          </div>
          <br>
          <div class="input-group mt-1">
            <div class="input-group-text ">
              <img
                src="../app-assets/images/candado.png"
                alt="password-icon"
                style="height: 1.5rem"
              />
            </div>
            <input
              class="form-control bg-light" id="confirmar_clave" 
              type="password"
              onkeyup="validarespacio(this);"
              maxlength="30"
              placeholder="Confirme su Contraseña"
            />
            <button type="button" class="btn btn-light" style="border: 2px solid #e7e7e7" onclick="mostrarClaveConfirmar();" ><img src="../app-assets/images/noVer.png" id="foto"
                style="height: 1rem"> </button>
          </div>
            

            <br>
            <button type="button" id="refresh" class="btn btn-primary" onclick="CambiarClave();" >Cambiar Contraseña</button>
            
        </form> 
      </section>
      <section id="lista">
     <!-- <a href="../index.php"><input type="button" value="Regresar"></a> -->
      </section>
    </div> 

    <!-- referencias para las alertas -->
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<!--validaciones -->
<script src="../assets/js/confClave.js"></script>
<script src="../assets/js/funciones_validaciones.js"></script>
    
</body>
<script type="text/javascript">
  //funcion java script para mostrar la clave
  var fotoMostrada2 = 'noVer2';

  function mostrarClave(){ 
    var contra = document.getElementById("user_clave");
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
    var contraConfirmar = document.getElementById("confirmar_clave");
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


  //funion que bloquea el copiar y pegar
window.onload = function() {
  var myInput = document.getElementById('user_clave');
  
  myInput.onpaste = function(e) {
    e.preventDefault();
   
  }
  
  myInput.oncopy = function(e) {
    e.preventDefault();
 
  }
  var myClave = document.getElementById('confirmar_clave');
  //clave
  myClave.onpaste = function(e) {
    e.preventDefault();
   
  }
  
  myClave.oncopy = function(e) {
    e.preventDefault();
 
  }
}

  </script>

</html>

<?php  //include "layouts/footer.php";  
  }
  else {
	  header("location:../");
  }
?>