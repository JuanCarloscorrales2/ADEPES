<?php  
session_start();
if(isset($_SESSION["user"])){
include "layouts/head.php"; 
require "../model/Permisos.php";
$permiso = new Permisos();
$rol = $_SESSION["user"]["idRol"];
$tiene_permiso = $permiso->ListarPermisosRol(10, $rol);
$_SESSION["actualizar"] = $tiene_permiso ? $tiene_permiso["actualizar"] : 0;
$_SESSION["eliminar"] = $tiene_permiso ? $tiene_permiso["eliminar"] : 0;
$_SESSION["consultar"] = $tiene_permiso ? $tiene_permiso["consultar"] : 0;
?>
<!--==========================================-->



<!-- =========== | contenido | ===============-->
<div class="app-content content container-fluid">
	<div class="content-wrapper">
		<div class="content-header row">
			<div class="content-header-left col-md-12 col-xs-12 mb-1">
				<h2 class="content-header-title"><center>Mantenimiento</center></h2>
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

					<!-- tabla tipos de prestamos -->
					<div class="col-md-12">
						<div class="card">
							<div class="card-header">
								<h4 class="card-title" id="basic-layout-form">
									<h4><center>Tipos de Préstamos</center></h4>
									
									<?php
										if ($tiene_permiso && $tiene_permiso["insertar"] >= 1) {
											echo '<button class="btn btn-success" data-toggle="modal" data-target="#registral_tipo_prestamo"><span class="icon-plus"></span> Nuevo</button>';
											echo '<button id="btn_descargar_rtipoPrestamos_pdf" class="btn btn-danger"> <i class="fas icon-file-pdf"></i>Descargar Listado</button>';
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
										<table id="tabla_Tipo_Prestamo" class="table table-bordered table-sm">
											<thead>
												<tr>
													<th >Acciones</th>
												    <th >No.</th>
													<th >Estado</th>
													<th >Préstamo</th>
													<th >Tasa</th>
													<th >Plazo Máximo</th>
													<th >Monto Mínimo</th>
													<th >Monto Máximo</th>
													
												</tr>
											</thead>
											<tbody>
											</tbody>
											<tfoot>
												<tr>
													<th >Acciones</th>
												    <th >No.</th>
													<th >Estado</th>
													<th >Préstamo</th>
													<th >Tasa</th>
													<th >Plazo Máximo</th>
													<th >Monto Mínimo</th>
													<th >Monto Máximo</th>
													
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
include "Modals/Registrar/RegistrarTipoPrestamo.php";


?>

<!--===================   MODALS PARA ACTUALIZAR  =======================-->

<?php  
// ========= | Modal para actualizar una  tipo de prestamo| =======
include "Modals/Actualizar/ActualizarTipoPrestamo.php";


?>


<!-- ========= | scripts robust | ============-->
<?php  include "layouts/main_scripts.php"; ?>


<!--=================  Plugins datatable.net para las tablas====================-->
<link href="https://cdn.datatables.net/v/dt/dt-1.13.4/datatables.min.css" rel="stylesheet"/>
<script src="https://cdn.datatables.net/v/dt/dt-1.13.4/datatables.min.js"></script>

<!-- referencias para las alertas -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!--TABLAS jS -->
<script src="../assets/js/Tablas.js"></script>
<!-- Agg. reporte de Tipo de Prestamo. -->
<script src="../assets/js/listadoTipoPrestamos.js"></script>
<!-- Advertencias Toastr -->
<script src="../app-assets/plugins/toastr/toastr.min.js">  </script> 
<script>
	function validarNumeroNegativo(input) {
		if (input.value < 0) {
			input.value = ""; // Establecer el valor a 0 si se ingresa un número negativo
			toastr.warning('No estan permitidos los números negativos');
		}
	}
	//valida que no se ingresen más de 3 letras seguidas
	function validar3letras(input) {
		var texto = input.value;
		var regex = /([a-zA-Z])\1{3,}/g; // La expresión regular coincide con 3 letras iguales o más seguidas
		
		if (regex.test(texto)) {
			// Elimina el último caracter ingresado si es parte de una secuencia de 3 letras iguales o más
			input.value = texto.substring(0, texto.length - 1);
	    }
	}
</script>


<!--==========================================-->

<!-- ============= | footer | ================-->
<?php  include "layouts/footer.php";  
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
  }
  else {
	  header("location:../");
  }
?>
<!--==========================================-->