<!-- ============== | head | =================-->
<?php
session_start();
if (isset($_SESSION["user"])) {
	include "layouts/head.php";
	require "../model/Permisos.php";
	require "../model/BitacoraModel.php";
	$permiso = new Permisos();
	$rol = $_SESSION["user"]["idRol"];
	$tiene_permiso = $permiso->ListarPermisosRol(27, $rol);
	$_SESSION["actualizar"] = $tiene_permiso ? $tiene_permiso["actualizar"] : 0;
	$_SESSION["eliminar"] = $tiene_permiso ? $tiene_permiso["eliminar"] : 0;
	$_SESSION["consultar"] = $tiene_permiso ? $tiene_permiso["consultar"] : 0;
	$_SESSION["reportes"] = $tiene_permiso ? $tiene_permiso["reportes"] : 0;
	$bita = new Bitacora();
	$bita->RegistrarBitacora($_SESSION["user"]["idUsuario"], 27, "Ingreso", "Ingreso a la pantalla de permisos");
?>
	<!--==========================================-->
	<style>
		.outerDivFull {
			margin: 50px;
		}

		.switchToggle input[type=checkbox] {
			height: 0;
			width: 0;
			visibility: hidden;
			position: absolute;
		}

		.switchToggle label {
			cursor: pointer;
			text-indent: -9999px;
			width: 70px;
			max-width: 70px;
			height: 30px;
			background: #d1d1d1;
			display: block;
			border-radius: 100px;
			position: relative;
		}

		.switchToggle label:after {
			content: '';
			position: absolute;
			top: 2px;
			left: 2px;
			width: 26px;
			height: 26px;
			background: #fff;
			border-radius: 90px;
			transition: 0.3s;
		}

		.switchToggle input:checked+label,
		.switchToggle input:checked+input+label {
			background: #3e98d3;
		}

		.switchToggle input+label:before,
		.switchToggle input+input+label:before {
			content: 'No';
			position: absolute;
			top: 5px;
			left: 35px;
			width: 26px;
			height: 26px;
			border-radius: 90px;
			transition: 0.3s;
			text-indent: 0;
			color: #fff;
		}

		.switchToggle input:checked+label:before,
		.switchToggle input:checked+input+label:before {
			content: 'Sí';
			position: absolute;
			top: 5px;
			left: 10px;
			width: 26px;
			height: 26px;
			border-radius: 90px;
			transition: 0.3s;
			text-indent: 0;
			color: #fff;
		}

		.switchToggle input:checked+label:after,
		.switchToggle input:checked+input+label:after {
			left: calc(100% - 2px);
			transform: translateX(-100%);
		}

		.switchToggle label:active:after {
			width: 60px;
		}

		.toggle-switchArea {
			margin: 10px 0 10px 0;
		}
	</style>

	<!-- =========== | contenido | ===============-->
	<div class="app-content content container-fluid">
		<div class="content-wrapper">
			<div class="content-header row">
				<div class="content-header-left col-md-6 col-xs-12 mb-1">
					<h2 class="content-header-title">Gestión de Permisos</h2>
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
											echo '<button class="btn  btn-success" data-toggle="modal" data-target="#RegistrarPermiso"> + Nuevo </button>';
										}
										if ($tiene_permiso &&  $tiene_permiso["reportes"] >= 1) {
											echo '<button id="boton_descargar_permisos_pdf" class="btn  btn-danger"> <i class="fas icon-file-pdf"></i>Generar Reporte</button>';
										}
										?>
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
											<table id="tabla_permisos" class="table table-bordered table-sm">
												<thead>
													<tr>
														<th width="10%">Noº</th>
														<th width="35%">Rol</th>
														<th width="40%">Objeto</th>
														<th width="5%">Acceder</th>
														<th width="5%">Insertar</th>
														<th width="5%">Actualizar</th>
														<th width="5%">Eliminar</th>
														<th width="5%">Generar Reportes</th>
														<th width="5%">Acciones</th>

													</tr>
												</thead>
												<tbody>
												</tbody>
												<tfoot>
													<tr>
														<th width="10%">Noº</th>
														<th width="35%">Rol</th>
														<th width="40%">Objeto</th>
														<th width="5%">Acceder</th>
														<th width="5%">Insertar</th>
														<th width="5%">Actualizar</th>
														<th width="5%">Eliminar</th>
														<th width="5%">Generar Reportes</th>
														<th width="5%">Acciones</th>

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
	<variables id="variables" rol="<?= $_SESSION["user"]["idRol"] ?>"></variables>




	<!--==========================================-->
	<!-- ========= | Modal para agregar una nuevo Rol | ============-->
	<?php include "Modals/Registrar/Registrarpermisos.php"; ?>
	<?php include "Modals/Actualizar/ActualizarPermiso.php"; ?>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.1/js/bootstrap.js"></script>
	<!-- ========= | scripts robust | ============-->
	<?php include "layouts/main_scripts.php"; ?>


	<!--=================  Plugins datatable.net para las tablas====================-->
	<link href="https://cdn.datatables.net/v/dt/dt-1.13.4/datatables.min.css" rel="stylesheet" />
	<script src="https://cdn.datatables.net/v/dt/dt-1.13.4/datatables.min.js"></script>

	<!-- referencias para las alertas -->
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<!-- Advertencias Toastr -->
	<script src="../app-assets/plugins/toastr/toastr.min.js">  </script>

	<!--Rol jS -->
	<script src="../assets/js/permisos.js"></script>
	<script src="../assets/js/generarPDFpermisos.js"></script>
	<script>
		window.addEventListener('beforeunload', function (event) {
			// Parámetros que deseas enviar al script PHP
			var usuarioId = <?php echo $_SESSION["user"]["idUsuario"]; ?>;
			var pantallaId = 27; // ID de la pantalla en la cual se esta registrado el evento
			var accion = "Salio"; // Acción del evento
			var descripcion = "Salió de la pantalla de permisos"; // Descripción de la acción
			
			// Realiza una solicitud AJAX para registrar la salida del usuario
			var xhr = new XMLHttpRequest();
			xhr.open('POST', '../pages/registrar_salida.php', true);
			xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
			xhr.send('usuarioId=' + usuarioId + '&pantallaId=' + pantallaId + '&accion=' + accion + '&descripcion=' + descripcion);
		});
 	</script>


	<!--==========================================-->

	<!-- ============= | footer | ================-->
	<?php include "layouts/footer.php";
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
	}
} else {
	header("location:../");
}
?>
<!--==========================================-->