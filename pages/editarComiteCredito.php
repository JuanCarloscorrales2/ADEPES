<div class="container">
					<div class="header">
						<h2>COMITÉ DE CRÉDITO</h2>
						
					</div>
					<div class="section">
						<h2>PROYECTO FONDO ROTATORIO</h2>
						<div class="row">
						<button type="button" class="btn  btn-danger" style="float: right;" onclick="comiteCreeditoGenerarPDF();"> <i class="fas icon-file-pdf"> PDF</i></button>
							<div class="col-md-12 mb-1">
								<div class="col-md-5"> </div>	

								<div class="col-md-2"> 
								<b>No. de Acta:</b>
								<input type="number"  id="numeroActaedit" class="form-control"readonly></textarea>
								</div>
								
								<div class="col-md-5"> </div>
							</div>
							<div class="col-md-12 mb-1">
								
								<b>Nombre:</b>
								<input type="text" id="nombreComiteEdit" class="form-control" readonly>

							</div>
							<div class="col-md-12 mb-1">
								
								<div class="col-md-4">
									<b>Monto:</b>
									<input type="text" id="montoComiteEdit" class="form-control" readonly>
								</div>
								<div class="col-md-4">
									<b>Plazo:</b>
									<input type="text" id="plazoComiteEdit" class="form-control" readonly>
								</div>	
								<div class="col-md-4">
									<b>Garantía:</b>
									<input type="text" id="tipoPrestamoComite" class="form-control" readonly></select>
								</div>	

							</div>
							<div class="col-md-12 mb-1">
								<div class="col-md-8">
									<b>Destino:</b>
									<input type="text" id="destinoComiteEdit" class="form-control" readonly>
								</div>
								<div class="col-md-4">
									<b>Estado:</b>
									<input type="text" id="estadoSolicitudComite" class="form-control" readonly>
								</div>
								
							</div>
				

						</div>
						<!-- Agrega más campos según sea necesario -->
					</div>
					<button type="button" class="btn btn-success" style="float: left;" onclick="prevStep(8)">Anterior</button>
