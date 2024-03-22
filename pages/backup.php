<!-- ============== | head | =================-->
<?php

session_start();
if (isset($_SESSION["user"])) {
	include "layouts/head.php";
	require "../model/Permisos.php";
	$permiso = new Permisos();
	$rol = $_SESSION["user"]["idRol"];
	$tiene_permiso = $permiso->ListarPermisosRol(30, $rol);
	$_SESSION["actualizar"] = $tiene_permiso ? $tiene_permiso["actualizar"] : 0;
	$_SESSION["eliminar"] = $tiene_permiso ? $tiene_permiso["eliminar"] : 0;
	$_SESSION["consultar"] = $tiene_permiso ? $tiene_permiso["consultar"] : 0;
	$_SESSION["reportes"] = $tiene_permiso ? $tiene_permiso["reportes"] : 0;

?>
	<!--==========================================-->
	<style>
		.loader {
			border: 2px solid #FFF;
			width: 48px;
			height: 48px;
			background: #FF3D00;
			border-radius: 50%;
			display: inline-block;
			position: relative;
			box-sizing: border-box;
			animation: rotation 2s linear infinite;
		}

		.loader::after {
			content: '';
			box-sizing: border-box;
			position: absolute;
			left: 50%;
			top: 50%;
			border: 24px solid;
			border-color: transparent #FFF;
			border-radius: 50%;
			transform: translate(-50%, -50%);
		}

		@keyframes rotation {
			0% {
				transform: rotate(0deg);
			}

			100% {
				transform: rotate(360deg);
			}
		}
	</style>

	<!-- =========== | contenido | ===============-->
	<div class="app-content content container-fluid">
		<div class="content-wrapper">
			<div class="content-header row">
				<div class="content-header-left col-md-6 col-xs-12 mb-1">
					<h2 class="content-header-title">Gestión Base de Datos</h2>
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
										<?php
										if ($tiene_permiso && $tiene_permiso["insertar"] >= 1) {
											echo '<a class="btn btn-success btn-lg" style="height:48px;" href="./Backupf.php">
											<h4>Realizar copia de seguridad</h4>
										</a><br><br>';
										}
										?>
										<?php
										if ($tiene_permiso && $tiene_permiso["actualizar"] >= 1) { ?>
											<form action="./Restore.php" method="POST" id="restore_backup">
												<label>
													<h4>Selecciona un punto de restauración:</h4>
												</label><br>
												<select class="form-select form-select-lg" style="height:45px;" name="restorePoint" id="restorePoint" required>
													<option value="" disabled="" selected=""> Selecciona un punto de restauración...</option>

													<?php
													include_once './Connet.php';
													$ruta = BACKUP_PATH;
													if (is_dir($ruta)) {
														if ($aux = opendir($ruta)) {
															while (($archivo = readdir($aux)) !== false) {
																if ($archivo != "." && $archivo != "..") {
																	$nombrearchivo = str_replace(".sql", "", $archivo);
																	$nombrearchivo = str_replace("-", ":", $nombrearchivo);
																	$ruta_completa = $ruta . $archivo;
																	if (is_dir($ruta_completa)) {
																	} else {
																		echo '<option value="' . $ruta_completa . '">' . $nombrearchivo . '</option>';
																	}
																}
															}
															closedir($aux);
														}
													} else {
														echo $ruta . " No es ruta válida";
													}
													?>
												</select>
												<button class="btn btn-success" style="height:47px;" type="submit" value="Restaurar">
													<h4>Restaurar</h4>
												</button>
												<br />
												<div id="loader" style="display:none;">

													<span class="loader"></span>
													<h5>Realizando Operación...</h5>
												</div>
											</form>
										<?php }
										?>
										<?php
										if (isset($_GET['success'])) {
											echo '<div class="alert alert-success mt-2" role="alert" id="backup_success">
												Respaldo realizado exitosamente. Su archivo se ha guardado en : ' . $ruta . $nombrearchivo . '
											</div>';
										}
										?>
										<div class="alert alert-danger mt-2" id="error" role="alert" style="display:none;">
											Realización del Respaldo ha fallado, intente de nuevo
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

	<!-- Advertencias Toastr -->
	<script src="../app-assets/plugins/toastr/toastr.min.js"> </script>


	<!--=================  Plugins datatable.net para las tablas====================-->
	<link href="https://cdn.datatables.net/v/dt/dt-1.13.4/datatables.min.css" rel="stylesheet" />
	<script src="https://cdn.datatables.net/v/dt/dt-1.13.4/datatables.min.js"></script>
	<!-- referencias para las alertas -->
	<!-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> -->
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

	<!--clientes jS -->
	<script>
		function do_backup() {
			$.ajax({
				data: {},
				url: "Backupf.php",
				type: 'GET',
				beforeSend: function() {
					$("#loader").show();
				},
				success: function(response) {
					if (response === "ok") {
						window.location.href = 'backup.php?success=1';
					} else {
						$("#error").show();
					}
				}
			})
		}
	</script>

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