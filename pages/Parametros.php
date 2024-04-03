<!-- ============== | head | =================-->
<?php
session_start();
if (isset($_SESSION["user"])) {
	include "layouts/head.php";
	require "../model/Permisos.php";
	require "../model/BitacoraModel.php";
	$permiso = new Permisos();
	$rol = $_SESSION["user"]["idRol"];
	$tiene_permiso = $permiso->ListarPermisosRol(28, $rol);
	$_SESSION["actualizar"] = $tiene_permiso ? $tiene_permiso["actualizar"] : 0;
	$_SESSION["eliminar"] = $tiene_permiso ? $tiene_permiso["eliminar"] : 0;
	$_SESSION["consultar"] = $tiene_permiso ? $tiene_permiso["consultar"] : 0;
	$_SESSION["reportes"] = $tiene_permiso ? $tiene_permiso["reportes"] : 0;
	$bita = new Bitacora();
	$bita->RegistrarBitacora($_SESSION["user"]["idUsuario"], 28, "Ingreso", "Ingreso a la pantalla de parámetros");
?>
	<!--==========================================-->



	<!-- =========== | contenido | ===============-->
	<div class="app-content content container-fluid">
		<div class="content-wrapper">
			<div class="content-header row">
				<div class="content-header-left col-md-6 col-xs-12 mb-1">
					<h2 class="content-header-title">Listado de Parámetros del Sistema</h2>
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
										if ($tiene_permiso &&  $tiene_permiso["reportes"] >= 1) {
											echo	'<button id="boton_descargar_Rparamet_pdf" class="btn  btn-danger"> <i class="fas icon-file-pdf"></i> Descargar Listado</button>';
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
											<table id="tabla_parametros" class="table table-bordered table-sm">
												<thead>
													<tr>
														<th width="10%">Nº</th>
														<th width="25%">Parámetro</th>
														<th width="40%">Valor</th>
														<th width="20%">Fecha de Creación</th>
														<th width="20%">Fecha de Modificación</th>
														<th width="5%">Acciones</th>

													</tr>
												</thead>
												<tbody>
												</tbody>
												<tfoot>
													<tr>
														<th width="10%">Nº</th>
														<th width="30%">Parámetro</th>
														<th width="40%">Valor</th>
														<th width="25%">Fecha de Creación</th>
														<th width="25%">Fecha de Modificación</th>
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

	<div class="modal fade modalPermisos" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-xl">
			<div class="modal-content">
			</div>
		</div>
	</div>





	<!--==========================================-->
	<!-- ========= | Modal para agregar una nuevo parametro | ============-->
	<?php include "Modals/Actualizar/ActualizarParametro.php"; ?>

	<!-- ========= | scripts robust | ============-->
	<?php include "layouts/main_scripts.php"; ?>


	<!--=================  Plugins datatable.net para las tablas====================-->
	<link href="https://cdn.datatables.net/v/dt/dt-1.13.4/datatables.min.css" rel="stylesheet" />
	<script src="https://cdn.datatables.net/v/dt/dt-1.13.4/datatables.min.js"></script>

	<!-- referencias para las alertas -->
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<!-- Advertencias Toastr -->
	<script src="../app-assets/plugins/toastr/toastr.min.js">  </script> 

	<!--Parametro jS -->
	<script src="../assets/js/parametros.js"></script>

	<!--Parametro jS: Agg. por Sebastian, es un Reporte -->
	<script src="../assets/js/listadoParametros.js"></script>
	<script>
		window.addEventListener('beforeunload', function (event) {
			// Parámetros que deseas enviar al script PHP
			var usuarioId = <?php echo $_SESSION["user"]["idUsuario"]; ?>;
			var pantallaId = 28; // ID de la pantalla en la cual se esta registrado el evento
			var accion = "Salio"; // Acción del evento
			var descripcion = "Salió de la pantalla de parámetros"; // Descripción de la acción
			
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