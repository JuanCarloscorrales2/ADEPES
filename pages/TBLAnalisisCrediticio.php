<!-- ============== | head | =================-->
<?php
session_start();
if (isset($_SESSION["user"])) {
	include "layouts/head.php";
	require "../model/Permisos.php";
	$permiso = new Permisos();
	$rol = $_SESSION["user"]["idRol"];
	$tiene_permiso = $permiso->ListarPermisosRol(33, $rol);
	$_SESSION["actualizar"] = $tiene_permiso ? $tiene_permiso["actualizar"] : 0;
	$_SESSION["eliminar"] = $tiene_permiso ? $tiene_permiso["eliminar"] : 0;
	$_SESSION["consultar"] = $tiene_permiso ? $tiene_permiso["consultar"] : 0;
	$_SESSION["reportes"] = $tiene_permiso ? $tiene_permiso["reportes"] : 0;
?>
	<!--==========================================-->



	<!-- =========== | contenido | ===============-->
	<div class="app-content content container-fluid">
		<div class="content-wrapper">
			<div class="content-header row">
				<div class="content-header-left col-md-12 col-xs-12 mb-1">
					<h2 class="content-header-title">
						<center>Mantenimiento </center>
					</h2>
				</div>
				<div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-12 col-xs-12">
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
						<!-- tabla Categoria Casa-->
						<div class="col-md-18">
							<div class="card">
								<div class="card-header">
									<h4 class="card-title" id="basic-layout-form">
										<h4>
											<center>Estado de Análisis Crediticio</center>
										</h4>
										<?php
										if ($tiene_permiso && $tiene_permiso["insertar"] >= 1) {
											echo '<button class="btn btn-success" data-toggle="modal" data-target="#registral_Analisis"><span class="icon-plus"></span> Nuevo</button>';
										}
										if ($tiene_permiso &&  $tiene_permiso["reportes"] >= 1) {
											echo '<button id="btn_descargar_rEstAnCredit_pdf" class="btn btn-danger"> <i class="fas icon-file-pdf"></i> Descargar Listado</button>';
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
											<table id="tabla_analisis" class="table table-bordered table-sm">
												<thead>
													<tr>
														<th>Acciones</th>
														<th>No.</th>
														<th>Estado de análisis crediticio</th>

													</tr>
												</thead>
												<tbody>
												</tbody>
												<tfoot>
													<tr>
														<th>Acciones</th>
														<th>No.</th>
														<th>Estado de análisis crediticio</th>

													</tr>
												</tfoot>
											</table>

										</div>
									</div>
								</div>

							</div>
						</div>
						<!--                       NO PASAR DE AQUI    -->
					</div>
				</section>
			</div>
		</div>
	</div>




	<!--===================   MODALS PARA REGISTRAR =======================-->

	<?php
	// ========= | Modal para agregar una nuevo Nuevo tipo de prestamo| =======
	include "Modals/Registrar/RegistrarAnalisis.php";



	?>

	<!--===================   MODALS PARA ACTUALIZAR  =======================-->

	<?php
	// ========= | Modal para actualizar una  tipo de prestamo| =======
	include "Modals/Actualizar/ActualizarAnalisis.php";

	?>


	<!-- ========= | scripts robust | ============-->
	<?php include "layouts/main_scripts.php"; ?>


	<!--=================  Plugins datatable.net para las tablas====================-->
	<link href="https://cdn.datatables.net/v/dt/dt-1.13.4/datatables.min.css" rel="stylesheet" />
	<script src="https://cdn.datatables.net/v/dt/dt-1.13.4/datatables.min.js"></script>

	<!-- referencias para las alertas -->
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

	<!--TABLAS jS -->
	<script src="../assets/js/Tablas.js"></script>

	<!-- Agg. el reporte de Categoria de Casa -->
	<script src="../assets/js/listadoEstadoAnCredit.js"></script>


	<!--==========================================-->

	<!-- ============= | footer | ================-->
	<?php include "layouts/footer.php";

	if ($_SESSION["consultar"] < 1) { ?>
		<script>
			swal.fire({
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