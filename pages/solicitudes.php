<!-- ============== | head | =================-->
<?php
session_start();
require "../model/Permisos.php";
$permiso = new Permisos();
$rol = $_SESSION["user"]["idRol"];
$tiene_permiso = $permiso->ListarPermisosRol(6, $rol);
$_SESSION["actualizar"] = $tiene_permiso ? $tiene_permiso["actualizar"] : 0;
$_SESSION["eliminar"] = $tiene_permiso ? $tiene_permiso["eliminar"] : 0;
$_SESSION["consultar"] = $tiene_permiso ? $tiene_permiso["consultar"] : 0;
$_SESSION["reportes"] = $tiene_permiso ? $tiene_permiso["reportes"] : 0;
if (isset($_SESSION["user"])) {
	include "layouts/head.php";  ?>

	<!--==========================================-->

	<style>
		.section h5 {
			text-align: center;
			background-color: #4CAF50;
			color: #fff;
			padding: 10px;
			border-radius: 5px;
		}
	</style>
	<!-- =========== | contenido | ===============-->
	<div class="app-content content container-fluid">
		<div class="content-wrapper">
			<div class="content-header row">
				<div class="content-header-left col-md-6 col-xs-12 mb-1">
					<h2 class="content-header-title">Listado de Solicitudes</h2>
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
											echo '<button class="btn btn-success"  onclick="location.href=\'../pages/nuevaSolicitud.php\';" >' .
												'<span class="icon-plus"></span> Nuevo</button>';
										}
										if ($tiene_permiso &&  $tiene_permiso["reportes"] >= 1) {
											echo '<button id="boton_descargar_pdf" class="btn  btn-danger"> <i class="fas icon-file-pdf"></i> Descargar Listado</button>';
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
											<table id="tabla_solicitudes" class="table table-bordered table-sm">
												<thead>
													<!-- para filtrar la tabla -->
													<tr>
														<td width="5%"></td>
														<td width="5%"></td>
														<td width="5%">
															<input type="text" class="form-control filter-input" placeholder="Buscar por nombre" data-column="2">
														</td>
														<td width="15%">
															<select data-column="3" class="form-control filter-select">
																<option value="">Filtrar</option>
																<option>Fiduciario</option>
																<option>Solidario</option>
															</select>
														</td>
														<td width="15%"></td>
														<td width="15%"></td>
														<td width="5%"></td>
														<td width="30%">
															<select data-column="7" class="form-control filter-select">
																<option value="">Filtrar</option>
																<option>Aprobado</option>
																<option>Pendiente</option>
																<option>No aprobado</option>
															</select>
														</td>
													</tr>

													<tr>
														<th width="5%">Acciones</th>
														<th width="5%">No°</th>
														<th width="30%">Nombre Completo</th>
														<th width="15%">Préstamo</th>
														<th width="15%">Monto</th>
														<th width="5%">Tasa (anual)</th>
														<th width="5%">Plazo (meses)</th>
														<th width="10%">Estado</th>
														<th width="10%">Fecha Emisión</th>
													</tr>
												</thead>
												<tbody>
												</tbody>
												<tfoot>
													<tr>
														<th width="5%">Acciones</th>
														<th width="5%">No°</th>
														<th width="30%">Nombre Completo</th>
														<th width="15%">Préstamo</th>
														<th width="15%">Monto</th>
														<th width="5%">Tasa (anual)</th>
														<th width="5%">Plazo (meses)</th>
														<th width="10%">Estado</th>
														<th width="10%">Fecha Emisión</th>

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
	<!--==========================================-->
	<!-- ========= | Modal para agregar una nuevo Rol | ============-->
	<?php // include "Modals/Actualizar/ActualizarEstadoSolicitud.php"; 
	?>

	<!-- ========= | scripts robust | ============-->
	<?php include "layouts/main_scripts.php"; ?>
	<?php include "Modals/Actualizar/ComiteCredito.php"; ?>
	<!-- Advertencias Toastr -->
	<script src="../app-assets/plugins/toastr/toastr.min.js"> </script>

	<!--=================  Plugins datatable.net para las tablas====================-->
	<link href="https://cdn.datatables.net/v/dt/dt-1.13.4/datatables.min.css" rel="stylesheet" />
	<script src="https://cdn.datatables.net/v/dt/dt-1.13.4/datatables.min.js"></script>

	<!-- referencias para las alertas -->
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<!--Solicitudes jS -->
	<!--Solicitudes jS -->
	<script src="../assets/js/listadoSolicitudes.js"></script>

	<!--==========================================-->

	<!-- ============= | footer | ================-->
<?php
	include "layouts/footer.php";
}

if ($_SESSION["consultar"] < 1) { ?>
	<script>
		swal.fire({
			title: "¡Prohibido!",
			text: "¡No puedes Accedeer a este recurso!",
			icon: "warning",
			allowOutsideClick: false
		}).then(function() {
			window.location = "../pages/welcome.php";
		});
	</script>
<?php
} else {
	header("location:../");
}
?>
<!--==========================================-->