<div class="container">
					<div class="header">
						<h2>DICTAMEN DEL ASESOR</h2>
						
					</div>
					<div class="section">
						<h2>A. DATOS PARA EL ANÁLISIS</h2>
						<div class="row">
							<div class="col-md-12 mb-1">
								
								<div class="col-md-4">
									<b>Monto:</b>
									<input type="text" id="montoDictamenedit" class="form-control" readonly>
								</div>
								<div class="col-md-4">
									<b>Plazo:</b>
									<input type="text" id="plazoDictamenedit" class="form-control" readonly>
								</div>	
								<div class="col-md-4">
									<b>Destino en:</b>
									<select id="destinoDictamen" class="form-control" readonly></select>
								</div>	

							</div>
							<div class="col-md-12 mb-1">
								<div class="col-md-2"> </div>	

								<div class="col-md-8"> 
								<textarea  id="analisisDictamenEdit" class="form-control" cols="90" rows="10" readonly></textarea>
								</div>
								
								<div class="col-md-2"> </div>
							</div>
							<div class="col-md-12 mb-1">
								<div class="col-md-2"> </div>	

								<div class="col-md-8"> 
								<textarea  id="cantidadPrestamosDictamen" class="form-control" cols="90" rows="3" readonly></textarea>
								</div>
								
								<div class="col-md-2"> </div>
							</div>
				

						</div>
						<!-- Agrega más campos según sea necesario -->
					</div>
					<div class="section">
						<h2>B. DICTAMEN</h2>
						<div class="row">
							<div class="col-md-12 mb-1">
								<div class="col-md-2"> </div>	

								<div class="col-md-8"> 
								<textarea  id="dictamenEdit" class="form-control" cols="90" rows="5" style="text-transform:uppercase;"  onblur="CambiarMayuscula(this);"  onkeyup="espacios(this);" maxlength="100"></textarea>
								</div>
								
								<div class="col-md-2"> </div>
							</div>
						</div>
						<!-- Agrega más campos según sea necesario -->
					</div>
					<br><button type="button" class="btn btn-success" style="float: left;" onclick="prevStep(6)">Anterior</button>
                    <button type="button" class="btn btn-success" style="float: right;" onclick="nextStep(6)">Siguiente</button><br>
				</div>
		