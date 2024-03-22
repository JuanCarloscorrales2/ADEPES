<?php

require "../config/Conexion.php";

$recuperacion = new Conexion();
$cnx = $recuperacion->ConectarDB();
//valida que traiga token o no
if (array_key_exists('token',$_GET)){
  $sql="SELECT idUsuario, Usuario, fechaRecuperacion FROM tbl_ms_usuario WHERE token =?";
  $result =$cnx->prepare($sql);
  $result->bindParam(1, $_GET['token']);
  $result->execute();
  if($resultado=$result->fetch(PDO::FETCH_ASSOC)){
    $current = date("Y-m-d H:i:s");
    $fechaRecuperacion=$resultado['fechaRecuperacion'];
    if(strtotime($current) > strtotime($fechaRecuperacion)) {
      echo"<script type='text/javascript' >
          alert('EL código de recuperación ha expirado.Por Favor intenta de nuevo.');
          window.location.href='../index.php';
          </script>";
    }
    //$token =null;
    //$idUsuario=$resultado['idUsuario'];
    //$sql="UPDATE tbl_ms_usuario SET token = null WHERE idUsuario ='$idUsuario'";
    //echo"<script type='text/javascript' >
    //alert('Token inválido');
    //window.location.href='../index.php';
    //</script>";
    ?>
    
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <link rel="icon" type="image/x-icon" href="../assets/logo-vt.svg" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>ADEPES | Restablecer contraseña</title>
    <link rel="shortcut icon" type="image/x-icon" href="../app-assets/images/ico/logox.ico">
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx"
      crossorigin="anonymous"
    />
       <!-- Referencias de las alertas sweetalert-->
       <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

        <!--para ejecutra el jquery -->
         <script src="app-assets/js/core/libraries/jquery.min.js" type="text/javascript"> </script>

  </head>
  <body class="bg-success d-flex justify-content-center align-items-center vh-100">
    <div
        class="bg-white p-5 rounded-5 text-secondary shadow"
        style="width: 25rem">
        <div class="d-flex justify-content-center">
        <img
        src="../app-assets/images/ico/lockr.png"
        alt="login-icon"
        style="height: 6rem"/>
        </div>
        <br>
        <div class="text-center fs-6 fw-bold">Restablecer contraseña</div>
   
        <!-- Login Form -->
        <form  autocomplete="off" method="POST" name="restablecer" action="restablecerPassword.php">
                <input type="hidden" value="<?php echo $resultado['idUsuario']; ?>"  name="idUsuario">
                <div class="input-group mt-2">
                    <input class="form-control bg-light" type="password" id="txtContrasena" name="txtContrasena" placeholder="Nueva Contraseña" 
                    onkeyup="validarespacio(this);"
                    pattern="(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*[_#@$&%]).{4,}"
                    title="Debe ingresar por los menos un número, una letra Mayúscula, una minúscula y caracteres especiales"
                    maxlength="30" required>
                    <button type="button" class="btn btn-light" style="border: 2px solid #e7e7e7" onclick="mostrarClave();" ><img src="../app-assets/images/noVer2.png" id="foto2"
                    style="height: 1rem"> </button>
                </div>
               <div class="input-group mt-2">
                    <input class="form-control bg-light" type="password" id="txtRepetirContrasena" name="txtRepetirContrasena" placeholder="Repetir Contraseña" 
                    onkeyup="validarespacio(this);"
                    pattern="(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*[_#@$&%]).{4,}"
                    title="Debe ingresar por los menos un número, una letra Mayúscula, una minúscula y caracteres especiales"
                    maxlength="30" required>
                    <button type="button"  class="btn btn-light" style="border: 2px solid #e7e7e7" onclick="mostrarClaveConfirmar();" ><img src="../app-assets/images/noVer.png" id="foto"
                    style="height: 1rem" ></button>
               </div>
                <br>
                <div class="loginButton">
                    <center>
                    <input id="btnGuardar" name="btnGuardar" class="btn btn-primary  btn-block" type="submit" value="Cambiar Contraseña">
                    </center>
                </div>
                
            </form>
            <!--ejecuta  validar espacio -->
            <script>
                //validar espacio en blanco del campo usuario
                function validarespacio(e){
                  e.value = e.value.replace(/ /g, '');
                }
            
              </script>
       
            <div class="p-2">
                <center>
                <a class="text-decoration-none text-info fw-semibold" href="../index.php">Volver a iniciar sesión</a>
                </center>
                
            </div>
          <!--para ejecutra el jquery -->
    <script src="app-assets/js/core/libraries/jquery.min.js" type="text/javascript"> </script>
    <script src="assets/js/validar_usuario.js" type="text/javascript"> </script>
            
    <script>

<?php
  //PARAMETRO MINIMO DE CLAVE
  $sqlP = "SELECT * FROM tbl_ms_parametros WHERE idParametro = 3; "; 
  $query =$cnx->query($sqlP);
  while($fila = $query->fetch(PDO::FETCH_ASSOC)){
   $fila; //retornamos el valor
  break;
    }
  foreach ($fila as $campos => $valor){
 $CLAVEMINIMA["valores"][$campos] = $valor; //almacena el valor del parametro minimo de la clave en un arreglo
   }

  //PARAMETRO MAXIMO DE CLAVE
  $sqlM = "SELECT * FROM tbl_ms_parametros WHERE idParametro = 4; "; 
  $query =$cnx->query($sqlM);
  while($fila2 = $query->fetch(PDO::FETCH_ASSOC)){
   $fila2; //retornamos el valor
    break;
  }
  foreach ($fila2 as $campos => $valor){
   $CLAVEMAXIMA["valores"][$campos] = $valor; //almacena el valor del parametro minimo de la clave en un arreglo
   }
     ?>

 
        //validar contrasenas iguales
    with(document.restablecer){
	    onsubmit = function(e){
		e.preventDefault();

    textoArea = document.getElementById("txtContrasena").value; //cuenta la cantidad de caracteres del input
    minimo = <?php echo $CLAVEMINIMA["valores"]["Valor"]?>;  //pasa el parametro de php a la variable java
    maximo = <?php echo $CLAVEMAXIMA["valores"]["Valor"]?>;
		ok = true;
		if(ok && txtContrasena.value==""){
			ok=false;
			//alert("Debe escribir su password");
			txtContrasena.focus();
			Swal.fire({
				icon: 'warning',
				title: 'Dato requerido',
				text: 'Ingrese una contraseña',
				
			})
		}
  

		if(ok && txtRepetirContrasena.value==""){
			ok=false;
			//alert("Debe reconfirmar su password");
			txtRepetirContrasena.focus();
			Swal.fire({
				icon: 'warning',
				title: 'Error',
				text: 'confirme su contraseña',
				
			})
		}
        if(ok && txtContrasena.value!= txtRepetirContrasena.value){
			ok=false;
			//alert("Los passwords no coinciden");
			txtRepetirContrasena.focus();
			Swal.fire({
				icon: 'error',
				title: 'Advertencia',
				text: 'Las contraseña no coinciden ',
				
			})
		} //valida el maximo y minimo de caracteres segun parametros 
    if(ok && txtContrasena && textoArea.length < minimo || textoArea.length > maximo ){
			ok=false;
			//alert("Debe escribir su password");
			txtContrasena.focus();
			Swal.fire({
				icon: 'warning',
				title: 'Estimado usuario:',
				text: 'La contraseña debe tener un mínimo de '+minimo+' y máximo de'+maximo,
				
			})
		}
		if(ok){ submit(); }
	}

    }   
   </script>
	
    
<script type="text/javascript">
  //funcion java script para mostrar la clave
  var fotoMostrada2 = 'noVer2';

  function mostrarClave(){ 
    var contra = document.getElementById("txtContrasena");
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
    var contraConfirmar = document.getElementById("txtRepetirContrasena");
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
</script>

  </div>
  </body>
  </html>
  <?php
  } else {
    echo"<script type='text/javascript' >
        alert('EL código de recuperación ha expirado.Por Favor intenta de nuevo.');
        window.location.href='../index.php';
        </script>";
  }
  }else if(array_key_exists('idUsuario',$_POST)){
    $idUsuario=$_POST['idUsuario'];
    //dias de vencimiento
    $sqlD = "SELECT * FROM tbl_ms_parametros WHERE idParametro = 5; ";
    $query =$cnx->query($sqlD);
    while($fila3 = $query->fetch(PDO::FETCH_ASSOC)){
    $fila3; //retornamos el valor
    break;
  }
  
  foreach ($fila3 as $campos => $valor){
    $DIASPARAMETRO["valores"][$campos] = $valor; //almacena el valor del parametro minimo de la clave en un arreglo
    }
  
  $fecha_actual =  date('Y-m-d');
  $FechaVencimiento =  date('Y-m-d', strtotime($fecha_actual."+" .$DIASPARAMETRO["valores"]["Valor"]." days")); //almacena la fecha actual
  $clave=$_POST["txtContrasena"];
  $clave_hash = password_hash($clave,PASSWORD_DEFAULT); //encripta la clave
  $sql="UPDATE tbl_ms_usuario SET idEstadoUsuario=2, FechaVencimiento='$FechaVencimiento', Intentos =0, token=null, fechaRecuperacion=null, Clave ='$clave_hash'  WHERE idUsuario='$idUsuario'";
  //registro de bitacora
  $sqlB = "insert into tbl_ms_bitacora (idUsuario, idObjetos, Accion, Descripcion) value (\"$idUsuario\",5,\"Recuperación\",\"Recupero su clave por correo\")";
  $cnx->exec($sqlB); //bitacora
  $cnx->exec($sql);//update usuario

  echo"<script type='text/javascript' >
  alert('Contraseña cambiada con éxito!');
  window.location.href='../index.php';
  </script>";
  }
?>
