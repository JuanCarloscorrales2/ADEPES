<!-- ============== | head | =================-->
<?php  
session_start();
require "../config/Conexion.php";

if(isset($_SESSION["user"])){
	$idUsuario=$_SESSION["user"]["idUsuario"];
include "layouts/head.php"; ?>
<!--==========================================-->


<!-- =========== | contenido | ===============-->
<div class="app-content content container-fluid">
	<div class="content-wrapper">
		<div class="content-header row">
			<div class="content-header-left col-md-6 col-xs-12 mb-1">
				<h4 class="content-header-title">CAMBIAR CONTRASEÑA</h4>
			</div>
			<div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-xs-12">
				<div class="breadcrumb-wrapper col-xs-12">
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="welcome.php">Home</a></li>
					</ol>
				</div>
			</div>
		</div>
		<div class="content-body" >
			<section id="basic-form-layouts">
				<div class="row match-height">
					<div class="col-md-12">
						<div class="card">
							<div class="card-header">
								<h5 class="card-title" id="basic-layout-form">
                                <span class="avatar "><img src="../app-assets/images/perfil.png" alt="avatar"><i></i></span><span class="user-name">  <?php echo $_SESSION["user"]["NombreUsuario"]; ?> </span></a>
								</h5>
								<a class="heading-elements-toggle"><i class="icon-ellipsis font-medium-3"></i></a>
								<div class="heading-elements">
									<ul class="list-inline mb-0">
										<li><a data-action="collapse"><i class="icon-minus4"></i></a></li>
										<li><a data-action="expand"><i class="icon-expand2"></i></a></li>
									</ul>
								</div>
							</div>
                            <br>
                            <div class="col-md-4">
                                            <div class="tile ">
                                                <ul class="nav flex-column nav-tabs user-tabs">
                                                <li class="nav-item"><a class="nav-link " href="../pages/perfilUser.php">Editar Perfil</a></li>
                                                <li class="nav-item"><a class="nav-link active" href="cambiarClave.php" >Cambiar Contraseña</a></li>
                                                </ul>
                                            </div>
                            </div>
                                            <br><br>
							<div class="card-body collapse in">
								<div class="card-block">
                                <form class="col-md-6" autocomplete="off" method="POST" name="restablecer" action="">
    <?php
    $recuperacion = new Conexion();
    $cnx = $recuperacion->ConectarDB();

    if(isset($_POST["btnmodificar"])){
        $passActual = $_POST["txtContrasena"];
        $passNew = $_POST["txtContrasenaNueva"];
        $passConf = $_POST["txtConfirmar"];

        // No encriptar la contraseña actual para compararla
        $sqlM = "SELECT Clave FROM tbl_ms_usuario WHERE idUsuario=:idUsuario";
        $query = $cnx->prepare($sqlM);
        $query->execute(array(":idUsuario" => $_SESSION["user"]["idUsuario"]));
        $row = $query->fetch(PDO::FETCH_ASSOC);

        if($query->rowCount() > 0){
            // Verificar si la contraseña actual es correcta
            if(password_verify($passActual, $row['Clave'])){
                // Verificar que la nueva contraseña no sea igual a la actual
                if($passActual !== $passNew){
                    // Encriptar las contraseñas nuevas
                    $passNewHash = password_hash($passNew, PASSWORD_DEFAULT);
                    $passConfHash = password_hash($passConf, PASSWORD_DEFAULT);

                    // Verificar si las contraseñas nuevas coinciden
                    if(password_verify($passConf, $passNewHash)){
                        $update = "UPDATE tbl_ms_usuario SET Clave=:clave WHERE idUsuario=:idUsuario";
                        $queryU = $cnx->prepare($update);
                        $queryU->execute(array(":clave" => $passNewHash, ":idUsuario" => $_SESSION["user"]["idUsuario"]));

                        if($queryU){
                            echo "Contraseña Actualizada!";
                        } else {
                            echo "Error al actualizar la contraseña.";
                        }
                    } else {
                        echo "Las Contraseñas nuevas no coinciden.";
                    }
                } else {
                    echo "La nueva contraseña no puede ser igual a la actual.";
                }
            } else {
                echo "La contraseña actual es incorrecta.";
            }
        } else {
            echo "Usuario no encontrado.";
        }
    }
    ?>

    <input type="hidden" class="form-control" id="id_editar" name="id_editar" value="<?php echo $_SESSION["user"]["idUsuario"]; ?>">

    <div class="input-group mt-2">
        <label for="nombre_rol" class="col-form-label"><strong>Contraseña Actual:</strong></label>  
        <input class="form-control bg-light" type="password" id="txtContrasena" name="txtContrasena" placeholder="Contraseña Actual" maxlength="30" required>
    </div>
    
    <div class="input-group mt-2">
        <label for="nombre_rol" class="col-form-label"><strong>Contraseña Nueva:</strong></label>
        <input class="form-control bg-light" type="password" id="txtContrasenaNueva" name="txtContrasenaNueva" placeholder="Contraseña Nueva" maxlength="30" required>
    </div>

    <div class="input-group mt-2">
        <label for="nombre_rol" class="col-form-label"><strong>Confirmar Contraseña:</strong></label>
        <input class="form-control bg-light" type="password" id="txtConfirmar" name="txtConfirmar" placeholder="Confirmar Contraseña" maxlength="30" required>
    </div>

    <input type="checkbox" onclick="togglePassword()"> Mostrar Contraseña
    <br>
    <center>
        <button type="submit" class="btn btn-xl btn-primary" value="ok" name="btnmodificar">Cambiar</button>
    </center>
</form>
                                         
    
                                </div>
                               
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>
		</div>
	</div>
</div>
<script>
        function togglePassword() {
            var passwordField = document.getElementById("txtContrasena");
			var passwordField1 = document.getElementById("txtContrasenaNueva");
			var passwordField2 = document.getElementById("txtConfirmar");
            if (passwordField.type === "txtContrasena") {
                passwordField.type = "text";
            } else {
                passwordField.type = "txtContrasena";
            }

			if (passwordField1.type === "txtContrasenaNueva") {
                passwordField1.type = "text";
            } else {
                passwordField1.type = "txtContrasenaNueva";
            }

			if (passwordField2.type === "txtConfirmar") {
                passwordField1.type = "text";
            } else {
                passwordField2.type = "txtConfirmar";
            }
        }
    </script>

<!--<script>
  //validar contrasenas iguales
    with(document.restablecer){
	    onsubmit = function(e){
		e.preventDefault();
		ok = true;
		if(ok && txtContrasena.value==""){
			ok=false;
			//alert("Debe escribir su password");
			txtContrasena.focus();
			Swal.fire({
				icon: 'warning',
				title: 'Dato requerido',
				text: 'Ingrese su contraseña actual',
				
			})
		}
  

		if(ok && txtContrasenaNueva.value==""){
			ok=false;
			//alert("Debe reconfirmar su password");
			txtContrasenaNueva.focus();
			Swal.fire({
				icon: 'warning',
				title: 'Error',
				text: 'Ingrese su nueva contraseña',
				
			})
		}
		if(ok && txtConfirmar.value==""){
			ok=false;
			//alert("Debe reconfirmar su password");
			txtConfirmar.focus();
			Swal.fire({
				icon: 'warning',
				title: 'Error',
				text: 'Confirmar contraseña',
				
			})
		}
        if(ok && txtContrasenaNueva.value!= txtConfirmar.value){
			ok=false;
			//alert("Los passwords no coinciden");
			txtConfirmar.focus();
			Swal.fire({
				icon: 'error',
				title: 'Advertencia',
				text: 'Las contraseñas no coinciden ',
				
			})
		} 
		if(ok){ submit(); }
		
		
	}

    }   
   </script>-->



       
<!-- ========= | scripts robust | ============-->
<?php  include "layouts/main_scripts.php"; ?>
<?php  include "Modals/Actualizar/ActualizarPerfil.php"; ?>


<!-- Advertencias Toastr -->
<script src="../app-assets/plugins/toastr/toastr.min.js">  </script> 


<!--=================  Plugins datatable.net para las tablas====================-->
<link href="https://cdn.datatables.net/v/dt/dt-1.13.4/datatables.min.css" rel="stylesheet"/>
<script src="https://cdn.datatables.net/v/dt/dt-1.13.4/datatables.min.js"></script>
<!-- referencias para las alertas -->
<!-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- ============= | footer | ================-->
<?php  include "layouts/footer.php";  
  }
?>
<!--==========================================-->