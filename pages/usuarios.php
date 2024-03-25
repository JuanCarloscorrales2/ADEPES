<!-- ============== | head | =================-->
<?php
session_start();
if (isset($_SESSION["user"])) {
	include "layouts/head.php";

	require "../model/Usuario.php";
	require "../model/Permisos.php";


	//instancia de la clase Usuario
	$usu = new Usuario();
	$permiso = new Permisos();
	$dias = $usu->DiasVencimiento(); //trae la cantidad de dias
	foreach ($dias as $campos => $valor) {
		$DIASPARAMETRO["valores"][$campos] = $valor; //ALMACENA LA CANTIDAD DE dias de vencimiento DEL USUARIO
	}

	$fecha_actual =  date('Y-m-d'); //almacena la fecha actual

	$maximo = $usu->ClaveMaxima(); //TRAE EL PARAMETRO DE INTENTOS
	foreach ($maximo as $campos => $valor) {
		$CLAVEMAXIMA["valores"][$campos] = $valor; //ALMACENA EL numero de intentos DE INTENTOS
	}

	//registro de bitacora
	$usu->RegistrarBitacora($_SESSION["user"]["idUsuario"], 3, "Ingreso", "Ingreso al Mantenimiento de Usuario"); //registro de bitacora
	$rol = $_SESSION["user"]["idRol"];
	$tiene_permiso = $permiso->ListarPermisosRol(3, $rol);
	$_SESSION["actualizar"] = $tiene_permiso ? $tiene_permiso["actualizar"] : 0;
	$_SESSION["eliminar"] = $tiene_permiso ? $tiene_permiso["eliminar"] : 0;

?>
	<!--==========================================-->





	<!-- =========== | contenido | ===============-->
	<div class="app-content content container-fluid">
		<div class="content-wrapper">
			<div class="content-header row">
				<div class="content-header-left col-md-6 col-xs-12 mb-1">
					<h2 class="content-header-title">Mantenimiento de Usuarios</h2>
				</div>
				<div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-xs-12">
					<div class="breadcrumb-wrapper col-xs-12">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="welcome.php">Home</a></li>
						</ol>
					</div>
				</div>
			</div>
			<div class="content-body">
				<section id="basic-form-layouts">
					<div class="row match-height">
						<div class="col-md-12">
							<div class="card">
								<div class="card-header">
									<h4 class="card-title" id="basic-layout-form">
										<?php
										if ($tiene_permiso && $tiene_permiso["insertar"] >= 1) {
											echo '<button class="btn btn-success" data-toggle="modal" data-target="#RegistrarUsuario"><span class="icon-plus"></span> Nuevo</button>';
											echo '<button id="boton_descargar_Ruser_pdf" class="btn  btn-danger"> <i class="fas icon-file-pdf"></i> Descargar Listado</button>';
										} ?>

									</h4>
									<a class="heading-elements-toggle"><i class="icon-ellipsis font-medium-3"></i></a>
									<div class="heading-elements">
										<ul class="list-inline mb-0">
											<li><a data-action="collapse"><i class="icon-minus4"></i></a></li>
											<li><a data-action="expand"><i class="icon-expand2"></i></a></li>
										</ul>
									</div>
								</div>

								<div class="card-body collapse in">

									<div class="card-block">

										<div class="table-responsive">
											<table id="tabla_usuarios" class="table table-bordered table-sm">
												<thead>
													<tr>

														<th width="">Acciones</th>
														<!-- <th width="">Id</th> -->
														<th width="">Usuario</th>
														<th width="">Nombre del Usuario</th>
														<th width="">Rol</th>
														<th width="">Estado</th>
														<th width="">Correo</th>
														<!--	<th width="">Fecha de Creación</th> -->
														<th width="">Fecha de Vencimiento</th>
													</tr>
												</thead>
												<tbody>
												</tbody>
												<tfoot>
													<tr>
														<th width="">Acciones</th>
														<!--    <th width="">Id</th> -->
														<th width="">Usuario</th>
														<th width="">Nombre del Usuario</th>
														<th width="">Rol</th>
														<th width="">Estado</th>
														<th width="">Correo</th>
														<!--<th width="">Fecha de Creación</th>-->
														<th width="">Fecha de Vencimiento</th>
													</tr>
												</tfoot>
											</table>
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

	<?php
	//funcion para geneara una clave aleatoria
	function generarPassword($length)
	{
		$key = "";
		$mayu = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
		$minu = "abcdefghijklmnopqrstuvwxyz";
		$num = "1234567890";
		$carac = "_#@$&%";
		$max1 = strlen($mayu) - 1;
		$max2 = strlen($minu) - 1;
		$max3 = strlen($num) - 1;
		$max4 = strlen($carac) - 1;
		for ($i = 0; $i < $length - 7; $i++) {
			$key .= substr($mayu, mt_rand(0, $max1), 1);
		}
		for ($i = 0; $i < 5; $i++) {
			$key .= substr($minu, mt_rand(0, $max2), 1);
		}
		for ($i = 0; $i < 1; $i++) {
			$key .= substr($num, mt_rand(0, $max3), 1);
		}
		for ($i = 0; $i < 1; $i++) {
			$key .= substr($carac, mt_rand(0, $max4), 1);
		}
		return $key;
	}

	?>


	<!--==========================================-->
	<!-- ========= | Modal para agregar una nuevo Usuario | ============-->
	<?php include "Modals/Registrar/RegistrarUsuario.php"; ?>
	<?php include "Modals/Actualizar/ActualizarUsuario.php"; ?>
	<script type="text/javascript">
		/******************************************************************* */

		//funcion para solo letras del input usuario
		function soloLetras(e) {
			key = e.keyCode || e.which;
			tecla = String.fromCharCode(key).toLowerCase();
			letras = "abcdefghijklmnñopqrstuvwxyz";
			especiales = [32]; //permite caracteres especiales usando Caracteres ASCII

			tecla_especial = false
			for (var i in especiales) {
				if (key == especiales[i]) {
					tecla_especial = true;
					break;
				}
			}

			if (letras.indexOf(tecla) == -1 && !tecla_especial)
				return false;
		}
		//user
		function limpiaUsuario() {
			var val = document.getElementById("usuario").value;
			var tam = val.length;
			for (i = 0; i < tam; i++) {
				if (!isNaN(val[i]))
					document.getElementById("usuario").value = '';
			}
		}
		//nombre
		function limpiaNombre() {
			var val = document.getElementById("nombreCompleto").value;
			var tam = val.length;
			for (i = 0; i < tam; i++) {
				if (!isNaN(val[i]))
					document.getElementById("nombreCompleto").value = '';
			}
		}
		//funcion que valida un solo espacio entre palabras
		espacios = function(input) {
			input.value = input.value.replace('  ', ' '); //sustituimos dos espacios seguidos por uno 
		}
		/************************************************************************* */
		// funcion que valida que no se repite mas de 3 veces una misma letra
		function contarLetras(input) {
			const contador = {};

			for (let i = 0; i < input.length; i++) {
				const letra = input[i];
				contador[letra] = (contador[letra] || 0) + 1;
			}

			return contador;
		}

		function validarRepeticionMaxima(input, nuevaLetra) {
			const contador = contarLetras(input);
			contador[nuevaLetra] = (contador[nuevaLetra] || 0) + 1;

			for (let letra in contador) {
				if (contador[letra] > 3) {
					return false;
				}
			}

			return true;
		}

		const inputElement = document.getElementById("usuario"); //id del input

		inputElement.addEventListener("input", function() {
			const textoInput = inputElement.value;
			const nuevaLetra = textoInput[textoInput.length - 1];
			const esValido = validarRepeticionMaxima(textoInput.slice(0, -1), nuevaLetra);

			if (!esValido) {
				inputElement.value = textoInput.slice(0, -1); // Eliminamos la última letra ingresada.
			}
		});





		/******************************************************************************************** */
	</script>
	<!-- ========= | scripts robust | ============-->
	<?php include "layouts/main_scripts.php"; ?>


	<!--=================  Plugins datatable.net para las tablas====================-->
	<link href="https://cdn.datatables.net/v/dt/dt-1.13.4/datatables.min.css" rel="stylesheet" />
	<script src="https://cdn.datatables.net/v/dt/dt-1.13.4/datatables.min.js"></script>
	<!-- referencias para las alertas -->
	<!-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> -->
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

	<!--user jS -->
	<script src="../assets/js/users.js"></script>
	<!--user jS: Agg. el Reporte de Usuarios. -->
	<script src="../assets/js/listadoUsuarios.js"></script>

	<!--validaciones -->
	<script src="../assets/js/funciones_validaciones.js"></script>

	<!--==========================================-->


<?php  
//include "layouts/footer.php";
 }
$_SESSION["consultar"] = $tiene_permiso ? $tiene_permiso["consultar"] : 0;
if ($_SESSION["consultar"] < 1) { ?>
	<script>
		Swal.fire({
			title: "¡Prohibido!",
			text: "¡No puedes Acceder a este recurso!",
			icon: "warning",
			allowOutsideClick: false
		}).then(function() {
			window.location = "../pages/welcome.php";
		});
	</script>
<?php
exit;
} else {
	exit; // Agregado para detener la ejecución del script
	header("location:../");
	
}
?>
<!--==========================================-->