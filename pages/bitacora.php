<!-- ============== | head | =================-->
<?php
session_start();
if (isset($_SESSION["user"])) {
	include "layouts/head.php";
	require "../model/Permisos.php";
	$permiso = new Permisos();
	$rol = $_SESSION["user"]["idRol"];
	$tiene_permiso = $permiso->ListarPermisosRol(31, $rol);
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
						<center>Bitácora del Sistema </center>
					</h2>
				</div>

			</div>
		</div>
	</div>

	<div class="app-content content container-fluid">
		<div class="content-wrapper">
			<div class="content-header row">

			</div>
			<div class="content-body">
				<section id="basic-form-layouts">
					<div class="row match-height">
						<div class="col-md-12">
							<div class="card">
								<div class="card-header">
									<?php
									if ($tiene_permiso &&  $tiene_permiso["reportes"] >= 1) {
										echo '<button id="boton_descargar_Rbitacora_pdf" class="btn  btn-danger"> <i class="fas icon-file-pdf"></i> Descargar Listado</button>';
									}
									?>
									<h4 class="card-title" id="basic-layout-form">


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
											<table id="tabla_bitacora" class="table table-bordered table-sm">
												<thead>
													<tr>
														<td width="15%">
															<input type="text" class="form-control filter-input" placeholder="Buscar por Usuario" data-column="0">
														</td>
														<td width="30%">
															<select data-column="1" class="form-control filter-select">
																<option value="">Seleccione una Acción</option>
																<option>Modifico</option>
																<option>Inserto</option>
																<option>Elimino</option>
																<option>Recuperación</option>
																<option>Ingreso</option>
																<option>Salio</option>
															</select>
														</td>

													</tr>
													<tr>
														<th width="15%">Usuario</th>
														<th width="30%">Acción</th>
														<th width="40%">Descripción</th>
														<th width="15%">Fecha</th>

													</tr>
												</thead>
												<tbody>
												</tbody>

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

	<!-- ========= | scripts robust | ============-->
	<?php include "layouts/main_scripts.php"; ?>


	<!--=================  Plugins datatable.net para las tablas====================-->
	<link href="https://cdn.datatables.net/v/dt/dt-1.13.4/datatables.min.css" rel="stylesheet" />
	<script src="https://cdn.datatables.net/v/dt/dt-1.13.4/datatables.min.js"></script>



	<!-- referencias para las alertas -->
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

	<!--Bitacora jS -->
	<script src="../assets/js/Bitacora.js"></script>
	<!--Bitacora jS: Agg. el Reporte de Bitacora -->
	|<script src="../assets/js/listadoBitacora.js"></script>



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