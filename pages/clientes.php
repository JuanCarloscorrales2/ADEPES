<!-- ============== | head | =================-->
<?php
session_start();
require "../model/Permisos.php";
$permiso = new Permisos();
$rol = $_SESSION["user"]["idRol"];
$tiene_permiso = $permiso->ListarPermisosRol(7, $rol);
$_SESSION["actualizar"] = $tiene_permiso ? $tiene_permiso["actualizar"] : 0;
$_SESSION["eliminar"] = $tiene_permiso ? $tiene_permiso["eliminar"] : 0;
$_SESSION["consultar"] = $tiene_permiso ? $tiene_permiso["consultar"] : 0;
$_SESSION["reportes"] = $tiene_permiso ? $tiene_permiso["reportes"] : 0;
if (isset($_SESSION["user"])) {
	include "layouts/head.php"; ?>
	<!--==========================================-->


	<!-- =========== | contenido | ===============-->
	<div class="app-content content container-fluid">
		<div class="content-wrapper">
			<div class="content-header row">
				<div class="content-header-left col-md-6 col-xs-12 mb-1">
					<h2 class="content-header-title">Listado de Clientes</h2>
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
											echo '<button class="btn  btn-success" onclick="location.href=\'../pages/nuevaSolicitud.php\';" >' . '<span class="icon-plus"></span> Nuevo</button>';
										}
										if ($tiene_permiso &&  $tiene_permiso["reportes"] >= 1) {
											echo '<button id="boton_descargar_pdf_clientes" class="btn  btn-danger"> <i class="fas icon-file-pdf"></i> Descargar Listado</button>';
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
											<table id="tabla_clientes" class="table table-bordered table-sm">
												<thead>
													<tr>
														<th width="">Acciones</th>
														<th width="">Nombre Completo</th>
														<th width="">Número de Identidad</th>
														<th width="">Género</th>
														<th width="">Contacto</th>
														<th width="">Dirección</th>
														<th width="">Profesión/Oficio</th>
													</tr>
												</thead>
												<tbody>
												</tbody>
												<tfoot>
													<tr>
														<th width="">Acciones</th>
														<th width="">Nombre Completo</th>
														<th width="">Número de Identidad</th>
														<th width="">Género</th>
														<th width="">Contacto</th>
														<th width="">Dirección</th>
														<th width="">Profesión/Oficio</th>
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

	<!-- ========= | scripts robust | ============-->
	<?php include "layouts/main_scripts.php"; ?>
	<?php include "Modals/Actualizar/ActualizarCliente.php"; ?>

	<!-- Advertencias Toastr -->
	<script src="../app-assets/plugins/toastr/toastr.min.js"> </script>


	<!--=================  Plugins datatable.net para las tablas====================-->
	<link href="https://cdn.datatables.net/v/dt/dt-1.13.4/datatables.min.css" rel="stylesheet" />
	<script src="https://cdn.datatables.net/v/dt/dt-1.13.4/datatables.min.js"></script>
	<!-- referencias para las alertas -->
	<!-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> -->
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

	<!--clientes jS -->
	<script src="../assets/js/clientes.js"></script>


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