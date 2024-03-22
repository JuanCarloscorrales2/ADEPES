<!-- ============== | head | =================-->
<?php  
session_start();
if(isset($_SESSION["user"])){
include "layouts/head.php";  ?>
<!--==========================================-->



<!-- =========== | contenido | ===============-->
<div class="app-content content container-fluid">
	<div class="content-wrapper">
		<div class="content-header row">
			<div class="content-header-left col-md-12 col-xs-12 mb-1">
				<h2 class="content-header-title"><center>Tablas Descriptivas </center></h2>
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
									<button class="btn btn-sm btn-success" data-toggle="modal" data-target="#registral_tipo_prestamo">
									Nuevo</button>
                                       
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

                   <!-- tabla estado civil -->
					<div class="col-md-6">
						<div class="card">
							<div class="card-header">
								<h4 class="card-title" id="basic-layout-form">
								<h4><center>Estado Civil</center></h4>
									<button class="btn btn-sm btn-success" data-toggle="modal" data-target="#registral_estadocivil">Nuevo</button>
                                       
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
										<table id="tabla_estadoCivil" class="table table-bordered table-sm">
											<thead>
												<tr>
													<th >Acciones</th>
												    <th >No.</th>
													<th >Estado Civil</th>
													
												</tr>
											</thead>
											<tbody>
											</tbody>
											<tfoot>
												<tr>
													<th >Acciones</th>
												    <th >No.</th>
													<th >Estado Civil</th>
													
												</tr>
											</tfoot>
										</table>
										
                    				</div>
								</div>
							</div>

						</div>
					</div>


					 <!-- tabla estado civil -->
					 <div class="col-md-6">
						<div class="card">
							<div class="card-header">
								<h4 class="card-title" id="basic-layout-form">
									<h4><center>Parentescos</center></h4>
									<button class="btn btn-sm btn-success" data-toggle="modal" data-target="#AQUI VA EL ID DEL MODAL DE REGISTRAR">Nuevo</button>
                                       
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
										<table id="tabla_parentesco" class="table table-bordered table-sm">
											<thead>
												<tr>
													<th >Acciones</th>
												    <th >No.</th>
													<th >Parentesco</th>
													
												</tr>
											</thead>
											<tbody>
											</tbody>
											<tfoot>
												<tr>
													<th >Acciones</th>
												    <th >No.</th>
													<th >Parentesco</th>
													
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
// ========= | Modal para agregar una nuevo Nuevo estado civil | =======
include "Modals/Registrar/RegistrarEstadoCivil.php";


?>

<!--===================   MODALS PARA ACTUALIZAR  =======================-->

<?php  
// ========= | Modal para actualizar una  tipo de prestamo| =======
include "Modals/Actualizar/ActualizarTipoPrestamo.php";
// ========= | Modal para actualizar los estado civiles| =======
include "Modals/Actualizar/ActualizarEstadoCivil.php";

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



<!--==========================================-->

<!-- ============= | footer | ================-->
<?php  include "layouts/footer.php";  
  }
  else {
	  header("location:../");
  }
?>
<!--==========================================-->