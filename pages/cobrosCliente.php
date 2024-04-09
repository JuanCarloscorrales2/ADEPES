<!-- ============== | head | =================-->
<?php
session_start();
if (isset($_SESSION["user"])) {
	include "layouts/head.php";

?>
	<!--==========================================-->
	<style>
		.rz-card {
			background-color: #9BD8FD;
			/* Color de fondo personalizado */
			border: 1px solid #dee2e6;
			/* Borde personalizado */
			border-radius: 8px;
			/* Bordes redondeados */
			padding: 20px;
			/* Espaciado interno */

		}
	</style>

	<!-- =========== | contenido | ===============-->
	<div class="app-content content container-fluid">
		<div class="content-wrapper">

			<div class="content-body">
				<section id="basic-form-layouts">
					<div class="row match-height">
						<div class="col-md-12">
							<div class="card">
								<div class="rz-card card" style="width: 100%">
									<div class="row">

										<div class="col-md-10">
											<h2>
												<center>Cobros</center>
											</h2>
										</div>
										<div class="col-md-2">
											<b>Fecha de desembolso:</b>
											<input type="text" id="fecha" name="fecha" class="form-control" format="aaaa-mm-dd" readonly>
										</div>
										<div class="col-md-4">
											<!--id del solicitante -->
											<input type="hidden" id="idSoli">
											<b>Cliente:</b>
											<input type="text" id="cliente" class="form-control" readonly>
										</div>

										<div class="col-md-2">
											<b>Identidad:</b>
											<input type="text" id="identidad" class="form-control" readonly>
										</div>

										<div class="col-md-2">
											<b>Monto:</b>
											<input type="number" id="monto" class="form-control" readonly>
										</div>
										<div class="col-md-2">
											<b>Total de Interés:</b>
											<input type="number" id="interes" class="form-control" readonly>
										</div>
										<div class="col-md-2">
											<b>Cuotas:</b>
											<input type="number" id="cuotas" class="form-control" readonly>
										</div>
										<div class="col-md-2">
											<br><b>Fecha de pago:</b>
											<input type="date" id="fechaPago" class="form-control">
										</div>
										<div class="col-md-2">
											<input type="hidden" id="idPlanCuota">
											<input type="hidden" id="capital"> <!-- capital sin intereses de cuotas -->
											<br><b>Cuota</b>
											<input type="number" id="montoPago" class="form-control" readonly>
										</div>
										<div class="col-md-2">
											<br><b>Monto a Pagar:</b>
											<input type="number" id="montoPagoAdicional" class="form-control" oninput="validarInput(event)">
										</div>


										<div class="col-md-2">
											<br><br><button class="btn  btn-success" onclick="validarMontoPagoAdicional();">Registrar Pago</button>
										</div>
										<div class="col-md-2">
											<br><br><button class="btn  btn-warning" id = "btnLiquidar"onclick="AdvertenciaLiquidarPrestamo();">Liquidar Préstamo</button>
										</div>
										<div class="col-md-2">
											<br><br><button class="btn  btn-danger" onclick="EstadoDeCuentasPDF();" > <i class="fas icon-file-pdf"></i>Estado de Cuentas</button>
										</div>
									</div> <!-- div del row -->

								</div> <!-- fin dde las clase rz-card card -->
								<div class="card-body collapse in">

									<div class="card-block">
										<ul class="nav nav-tabs" id="myTab" role="tablist">
											<li class="nav-item">
												<a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Pago de Cuota</a>
											</li>
											<li class="nav-item">
												<a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Plan de Pagos Histórico</a>
											</li>
										</ul>
										<div class="tab-content" id="myTabContent">
											<div class="tab-pane active" id="home" role="tabpanel" aria-labelledby="home-tab">
											<br />	
											<div class="alert alert-success" role="alert">
													Se Muestra la Próxima cuota a cancelar, según el orden del plan de Pagos
												</div>

												<div class="table-responsive">
													<br />
													<table id="tabla_pagos" class="table table-bordered table-sm">
														<thead>
															<tr>
																<th></th>
																<th>N° de Cuota</th>
																<th>Fecha de Pago</th>
																<th>Fecha de Depósito</th>
																<th>Pago</th>
																<th>PagoAdicional</th>
																<th>Saldo de Capital</th>
																<th>Dias de Retraso</th>
																<th>Interés Moratorio</th>
																<th>Mora Total/días</th>
																<th>Estado</th>
															</tr>
														</thead>
														<tbody>
														</tbody>
														<tfoot>
															<tr>
																<th></th>
																<th>N° de Cuota</th>
																<th>Fecha de Pago</th>
																<th>Fecha de Depósito</th>
																<th>Pago</th>
																<th>PagoAdicional</th>
																<th>Saldo de Capital</th>
																<th>Dias de Retraso</th>
																<th>Interés Moratorio</th>
																<th>Mora Total/días</th>
																<th>Estado</th>
															</tr>
														</tfoot>
													</table>
												</div>
											</div>
											<div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
												<br />
												<div class="alert alert-success" role="alert">
													Se Muestra el plan de pagos y el historico de cobros realizado a dicho plan
												</div>
												<br />
												<div class="table-responsive">
													<table id="tabla_pagoshistorico" class="table table-bordered table-sm">
														<thead>
															<tr><th></th>
																<th>N° de Cuota</th>
																<th>Fecha de Pago</th>
																<th>Fecha de Depósito</th>
																<th>Pago</th>
																<th>PagoAdicional</th>
																<th>Saldo de Capital</th>
																<th>Dias de Retraso</th>
																<th>Interés Moratorio</th>
																<th>Mora Total/días</th>
																<th>Estado</th>
															</tr>
														</thead>
														<tbody>
														</tbody>
														<tfoot>
															<tr>
															<th></th>
																<th>N° de Cuota</th>
																<th>Fecha de Pago</th>
																<th>Fecha de Depósito</th>
																<th>Pago</th>
																<th>PagoAdicional</th>
																<th>Saldo de Capital</th>
																<th>Dias de Retraso</th>
																<th>Interés Moratorio</th>
																<th>Mora Total/días</th>
																<th>Estado</th>
															</tr>
														</tfoot>
													</table>
												</div>
											</div>
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

	
	<script>
		//valida que no se ingresen numeros negativos y que se ingresen numeros decimales
    function validarInput(event) {
        var input = event.target; // Obtén el elemento de entrada
        var entrada = event.data || ''; // Obtén la última entrada del usuario

        // Si la entrada es un número, un punto decimal o un espacio, o si es una acción de borrar, acepta la entrada
        if (/[\d. ]/.test(entrada) || event.inputType === 'deleteContentBackward' || event.inputType === 'deleteContentForward') {
            return;
        } else {
            // De lo contrario, evita la inserción de texto no válido
            input.value = input.value.slice(0, input.value.length - 1); // Elimina el último caracter ingresado
        }
    }
</script>

	<script>
	function validarMontoPagoAdicional() {
	var fechaPago = $('#fechaPago').val().trim();
	var idPlanCuota = $('#idPlanCuota').val().trim();
    var montoPagoAdicional = $('#montoPagoAdicional').val().trim();
    
		
    // Verificar si el campo de fechaPago está vacío
    if (fechaPago === "") {
        toastr.warning('Por favor ingrese la fecha de pago');
        return;
    }

	if (idPlanCuota === "") {
        toastr.warning('Para registrar un pago seleccione una cuota');
        return
    }
    // Verificar si el campo de montoPagoAdicional está vacío
    if (montoPagoAdicional === "") {
        toastr.warning('Por favor ingrese el monto a pagar');
        return;
    }

	// Obtener el monto de la cuota (asumiendo que lo tienes almacenado en una variable llamada montoCuota)
	var montoCuota = parseFloat($('#montoPago').val().trim());

	// Verificar si el campo de montoPagoAdicional está vacío o si es menor que el monto de la cuota
	if (isNaN(montoPagoAdicional) || montoPagoAdicional <= 0 || montoPagoAdicional < montoCuota) {
		toastr.warning('El monto a pagar debe ser mayor o igual que el monto de la cuota');
		return;
	}

    // Si el campo no está vacío, llamamos a la función validarPago
    validarPago();
	}
	</script>

	<!-- ========= | scripts robust | ============-->
	<?php include "layouts/main_scripts.php"; ?>
	<!-- Advertencias Toastr -->
	<script src="../app-assets/plugins/toastr/toastr.min.js"> </script>


	<!--=================  Plugins datatable.net para las tablas====================-->
	<link href="https://cdn.datatables.net/v/dt/dt-1.13.4/datatables.min.css" rel="stylesheet" />
	<script src="https://cdn.datatables.net/v/dt/dt-1.13.4/datatables.min.js"></script>
	<!-- referencias para las alertas -->
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<script src="../assets/js/cobros.js"></script>
	<!-- ============= | footer | ================-->
<?php //include "layouts/footer.php";

} else {
	header("location:../");
}
?>
<!--==========================================-->