<!-- ============== | head | =================-->
<?php  
session_start();
if(isset($_SESSION["user"])){
include "layouts/head.php"; 

?>
<!--==========================================-->


<!-- =========== | contenido | ===============-->
	<style>
		.form-step {
    		display: none;
 		 }

		.form-step.active {
			display: block;
		}	

		.button-container {
			margin-top: 20px;
		}
        
		.rz-card {
            background-color: #f8f9fa; /* Color de fondo personalizado */
            border: 1px solid #dee2e6; /* Borde personalizado */
            border-radius: 8px; /* Bordes redondeados */
            padding: 20px; /* Espaciado interno */
        }
		#rz-card-analisis { /*estilo del estado de igresos y gastos*/
            background-color: #f8f9fa; /* Color de fondo personalizado */
            border: 1px solid #dee2e6; /* Borde personalizado */
            border-radius: 8px; /* Bordes redondeados */
            padding: 20px; /* Espaciado interno */
        }

		#formulario {
     	 display: none;
 		 }
		  #planModal .modal-dialog {
        max-width: 70%; /* Puedes ajustar el porcentaje según de ancho del modal planpagosvista */
    }
		
    </style>
	
<div class="app-content content container-fluid">
	<div class="content-wrapper">
		<div class="content-header row">
			<div class="content-header-left col-md-12 col-xs-12 mb-1">
				<h2 class="content-header-title"><center>Solicitud de Préstamo</center></h2>
				<br>
				<h4 class="content-header-title"><center>Solicitante</center></h4>
				<button type="button" class="btn btn-warning" style="float: right;" onclick="Cancelar();"><span class="icon-arrow-left"></span> Cancelar</button>
			</div>
			<div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-xs-12">
				<div class="breadcrumb-wrapper col-xs-12">
					<ol class="breadcrumb">
					<!--	<li class="breadcrumb-item"><a href="welcome.php">Home</a></li> -->
					</ol>
				</div>
			</div>
		</div>

	<!-- desde aquiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiii -->

	<div id="step1" class="step">

        <div class="mb-3">
          <div class="rz-card card" style="width: 100%" >
				<div id="mensaje" class="alert alert-info" role="alert" style="display: none;"> </div> <!-- para mostrar infromacion del prestamo -->
				<div class="col-md-12 mb-1">
					
					<button class="btn btn-success" style="float: right;" onclick="nextStep(1)">Siguiente</button>
					
				</div>
				<div class="row">
					<input type="hidden" id="analisis" value="1">
					<div class="col-md-3 mb-2 ">
					<b>Tipo de Garantía y Tasa (anual): *</b>
					<select id="tipogarantia" name="tipogarantia" class="form-control" onchange="mostrarDatosPrestamos()" ></select>
					</div>	
					
					<div class="col-md-2 mb-2">
					<b>Monto: *</b>
					<input type="number" id="monto" name="monto" class="form-control"  min="1" max="300000" step="0.01"  >	
					</div>

					<div class="col-md-2 mb-2">
					<b>Plazo (en meses): *</b>
					<input type="number" id="plazo" name="plazo" class="form-control" min="1" max="130" >
					</div>
				
					<div class="col-md-2 mb-2">
					<b>Invierte en: *</b>
					<select id="rubro" class="form-control" ></select>
					</div>		

					<div class="col-md-2 mb-2">
					<b>Fecha de emision: *</b>
					
					<input type="date" id="fechaEmision" name="fechaEmision" class="form-control"><br><br>
					</div>
					<div class="col-md-1 mb-2">
					<br>
					<input type="button" class="btn btn-warning" value="Ver Plan" style="float: right;"  onclick="generarPlan()">
					</div>
					
				<!--	<input type="submit" value="Generar PDF">
					
    </form> -->
				</div> <!-- div del row -->
			
		  	</div> <!-- fin dde las clase rz-card card -->
        </div>
        
      </div>
	

	<div id="step2" class="step" style="display: none;">
	
		<div class="rz-card card">
				<div class="button-container">
					
					<button class="btn btn-warning" style="float: left;" onclick="prevStep(2)">Anterior</button>
					<button class="btn btn-success" style="float: right;" onclick="nextStep(2)">Siguiente</button>
					
				</div>
						<div class="row">
							<b><center>INFORMACIÓN PERSONAL</center></b>
							<br>
							<br>
							<div class="col-md-12 mb-1">
								<div class="col-md-3">
									<b>Buscar cliente por identidad:</b>
									<input type="numer" id="BuscarCliente" class="form-control" maxlength="15" placeholder="0000-0000-00000" oninput="formatoIdentidad(event)">
									
								</div>
								<div class="col-md-1">
									<br>
									<button type="button" class="btn btn-info" onclick="BuscarCliente();"><span class="icon-search"></span></button>
								</div>
								
							</div>

							<div class="col-md-12 mb-1">
							<div class="col-md-3">
								<b>Nombres: *</b>
								<input type="text" id="nombresCliente" class="form-control" style="text-transform:uppercase;" onblur="CambiarMayuscula(this);" onkeypress="return soloLetras(event)" onblur="limpiaNombreCliente()" onkeyup="espacios(this);" maxlength="45" >
							</div>
							<div class="col-md-3">
								<b>Apellidos: *</b>
								<input type="text" id="apellidosCliente" class="form-control" style="text-transform:uppercase;" onblur="CambiarMayuscula(this);" onkeypress="return soloLetras(event)" onblur="limpiaApellidoCliente()" onkeyup="espacios(this);" maxlength="45" >
							</div>
							<div class="col-md-2">
								<b>N° de identidad: *</b>
								<input type="numer" id="identidadCliente" class="form-control" maxlength="15" placeholder="0000-0000-00000" oninput="formatoIdentidad(event)">
								<span id="errorMensaje" style="color: red;"></span>
							</div>
							<div class="col-md-2">
								<b>Fecha de nacimiento: *</b>
								<input type="date" id="fechaNacimiento" class="form-control" >
								
							</div>
							<div class="col-md-2">
								<b>Nacionalidad: *</b>
								<select id="nacionalidad" class="form-control" ></select>
							</div>	

						</div>	
					<div class="col-md-12 mb-1">
							<div class="col-md-2">
								<b>Municipio: *</b>
								<select id="municipioCliente" class="form-control" >	</select>
							</div>	
							<div class="col-md-5">
								<b>Dirección: *</b>
								<input type="text" id="direccionCliente" class="form-control" style="text-transform:uppercase;" onblur="CambiarMayuscula(this);"  onkeyup="espacios(this);" maxlength="120" >
							</div>
							<div class="col-md-3">
								<b>Teléfono:</b>
								<input type="text" id="telefonoCliente" class="form-control" maxlength="9">
							</div>
							<div class="col-md-2">
								<b>Celular: *</b>
								<input type="text" id="celularCLiente" class="form-control" maxlength="9"  >
							</div>
								
					</div>			

					<div class="col-md-12 mb-1">
							<div class="col-md-2">
								<b>Estado civil: *</b>
								<select id="estadoCivil" class="form-control"  onchange="mostrarFormulario();" >	</select>
							</div>
						
							<div class="col-md-2">
								<b>Casa: *</b>
								<select id="casa" class="form-control" > </select>
							</div>
							<div class="col-md-2">
								<b>Tiempo de vivir: *</b>
								<select id="tiempoVivir" class="form-control" > </select>
							</div>
							<div class="col-md-2">
								<b>Forma de pago: *</b>
								<select id="pagaAlquiler" class="form-control" > </select>
							</div>
							<div class="col-md-2">
								<b>Pago del alquiler:</b>
								<input type="number" id="pagoCasa" oninput="validarNumeroNegativo(this);" class="form-control">
							</div>
							
							<div class="col-md-2">
								<b>Genero: *</b>
								<select class="form-control" id="idGeneroCliente" > </select>
							</div>
							
					</div>
                    <!-- desde aqui -->
					
					<div class="col-md-12 mb-1">
							<div class="col-md-2">
								<b>Profesión u oficio: * <span class="icon-arrow-right"></span></b>
								<select id="profesiones" class="form-control" > </select>
								
							</div>
							<div class="col-md-1">
								<b>Agregar</b>
							<button class="btn btn-success" data-toggle="modal" data-target="#RegistarProfesionSolicitud"><span class="icon-plus"></span> </button>
							</div>
							<div class="col-md-3">
								<b>Patrono o negocio:</b>
								<input type="text" id="patrono" class="form-control" style="text-transform:uppercase;" onblur="CambiarMayuscula(this);"  onkeyup="espacios(this);" onkeyup="espacios(this);"  maxlength="30"  >
							</div>
							<div class="col-md-4">
								<b>Actividad que desempeña: *</b>
								<input type="text" id="actividadDesempeña" class="form-control" style="text-transform:uppercase;" onblur="CambiarMayuscula(this);" onkeyup="espacios(this);" maxlength="30"  >
							</div>
							<div class="col-md-2">
								<b>Tiempo de laborar: *</b>
								<select id="tiempoLaboral" class="form-control" ></select>
							</div>
					</div>		

					<div class="col-md-12 mb-1">	
						<div class="col-md-2">
							<b>Ingresos por negocio:</b>
							<input type="number" id="ingresosPorNegocio" oninput="validarNumeroNegativo(this);" class="form-control">
						</div>
						<div class="col-md-2">
							<b>Sueldo Base:</b>
							<input type="number" id="sueldoBase" oninput="validarNumeroNegativo(this);" class="form-control">
						</div>
						<div class="col-md-2">
							<b>Gastos de alimentacion:</b>
							<input type="number" id="gastosAlimentacion" oninput="validarNumeroNegativo(this);" class="form-control">
						</div>
						<div class="col-md-6">
								<b>Dirección del trabajo:</b>
								<input type="text" id="direccionTrabajoCliente" class="form-control" style="text-transform:uppercase;" onblur="CambiarMayuscula(this);" onkeyup="espacios(this);" maxlength="120"  >
						</div>
					</div>	
							
					<div class="col-md-12 mb-1">		
						<div class="col-md-2">
							<b>Teléfono del trabajo:</b>
							<input type="text" id="telefonoClienteTrabajo" class="form-control" maxlength="9" >
						</div>
						<div class="col-md-2">
							<b>Tipo de crédito: *</b>
							<select id="tipoCliente" class="form-control" ></select>
						</div>
						<div class="col-md-2">
							<b>Cuenta #:</b>
							<input type="text" id="cuentaCliente" class="form-control" maxlength="15" >
						</div>
						<div class="col-md-2">
							<b>Estado del crédito:</b>
							<select id="estadoCreditoCliente"class="form-control" ></select>
						</div>
						<div class="col-md-2">
							<b>Valor de la cuota:</b>
							<input type="number" id="cuota" class="form-control" step="0.01" pattern="^\d+(\.\d{1,2})?$" title="Ingrese un número con hasta dos decimales">
						</div>
						<div class="col-md-2">
							<b>Es aval:</b>
							<select id="esAvalCliente" class="form-control" ></select>
							<select id="avalMoraCliente" class="form-control" > </select>
						</div>
						
					</div>		
				
							
					</div> <!-- div del row-->
					
				</div> <!-- div final de la clase rz-card card"-->
		
	</div>

	<div id="step3" class="step" style="display: none;">


	<div class="rz-card card" style="width: 100%" >
			<div class="button-container">
				
				<button class="btn btn-warning" style="float: left;" onclick="prevStep(3)">Anterior</button>
				<button class="btn btn-success" style="float: right;" onclick="nextStep(3)">Siguiente</button>	
				
			</div>
			
			<div class="row">

				<b><center>INFORMACIÓN DEL ESPOSO(A) O COMPAÑERO(A) </center></b>
				<br>
				<br>
		<div class="col-md-12 mb-1">
				<div class="col-md-3">
					<b>Nombres: *</b>
					<input type="text" id="nombresPareja" class="form-control" style="text-transform:uppercase;" onblur="CambiarMayuscula(this);" onkeypress="return soloLetras(event)" onblur="limpiaNombre()" onkeyup="espacios(this);" maxlength="45" >
				</div>
				<div class="col-md-3">
					<b>Apellidos: *</b>
					<input type="text" id="apellidosPareja" class="form-control" style="text-transform:uppercase;" onblur="CambiarMayuscula(this);" onkeypress="return soloLetras(event)" onblur="limpiaNombre()" onkeyup="espacios(this);" maxlength="45" >
				</div>
				<div class="col-md-3">
					<b>N° de identidad: *</b>
					<input type="numer" id="identidadPareja" class="form-control" maxlength="15" placeholder="0000-0000-00000" oninput="formatoIdentidad(event)">
					<span id="errorMensaje1" style="color: red;"></span>
				</div>
				<div class="col-md-3">
					<b>Fecha de nacimiento: *</b>
					<input type="date" id="fechaNacimientoPareja" class="form-control" >
					
				</div>
					
		</div>
				
		<div class="col-md-12 mb-1">
				<div class="col-md-2">
					<b>Municipio: *</b>
					<select id="municipioPareja" class="form-control" >	</select>
				</div>	
				<div class="col-md-4">
					<b>Dirección completa:</b>
					<input type="text" id="direccionPareja" class="form-control" style="text-transform:uppercase;" onblur="CambiarMayuscula(this);"  onkeyup="espacios(this);" maxlength="120">
				</div>
				<div class="col-md-2">
					<b>Teléfono:</b>
					<input type="text" id="telefonoPareja" class="form-control" maxlength="9" >
				</div>
				<div class="col-md-2">
					<b>Celular: *</b>
					<input type="text" id="celularPareja" class="form-control" maxlength="9"  >
				</div>

				<div class="col-md-2">
					<b>Genero: *</b>
					<select id="generoPareja"  class="form-control"></select>
				</div>
			</div>
				
				

		<div class="col-md-12 mb-1">
				<div class="col-md-2">
					<b>Profesión u oficio: *</b>
					<select id="profesionPareja" class="form-control" > </select>
				</div>		
			
				<div class="col-md-4">
					<b>Patrono o negocio:</b>
					<input type="text" id="patronoPareja" class="form-control" maxlength="50" style="text-transform:uppercase;" onblur="CambiarMayuscula(this);"  onkeyup="espacios(this);" >
				</div>
				<div class="col-md-4 ">
					<b>Cargo que desempeña:</b>
					<input type="text" id="actividadPareja" class="form-control" style="text-transform:uppercase;" onblur="CambiarMayuscula(this);"  onkeyup="espacios(this);" maxlength="50"  >
				</div>
				<div class="col-md-2">
					<b>Tiempo de laborar: *</b>
					<select id="tiempoLaboralPareja" class="form-control" >	</select>
				</div>
		</div>

		<div class="col-md-12 mb-1">
				<div class="col-md-2 ">
					<b>Ingresos del Negocio:</b>
					<input type="number" id="ingresoNegocioPareja" oninput="validarNumeroNegativo(this);" class="form-control">
				</div>
				<div class="col-md-2 ">
					<b>Sueldo Base:</b>
					<input type="number" id="sueldoBasePareja" oninput="validarNumeroNegativo(this);" class="form-control">
				</div>
				<div class="col-md-2 ">
					<b>Gastos Alimentación:</b>
					<input type="number" id="gastoAlimentacionPareja" oninput="validarNumeroNegativo(this);" class="form-control">
				</div>
				
				
				<div class="col-md-4">
					<b>Dirección del trabajo:</b>
					<input type="text" id="direccionTrabajoPareja" class="form-control" maxlength="120" style="text-transform:uppercase;" onblur="CambiarMayuscula(this);"  onkeyup="espacios(this);" >
				</div>
				<div class="col-md-2">
					<b>Teléfono del trabajo:</b>
					<input type="text" id="telefonoParejaTrabajo" class="form-control" maxlength="9" >
				</div>
		</div>
				<!-- -->
		<div class="col-md-12 mb-1">
				<div class="col-md-2">
					<b>Tipo de cliente: *</b>
					<select id="tipoClientePareja" name="tipoCliente" class="form-control" > </select>
				</div>
				<div class="col-md-2">
					<b>Cuenta IDC#:</b>
					<input type="text" id="cuentaPareja" class="form-control" maxlength="15" >
				</div>
				<div class="col-md-2">
					<b>Estado del crédito:</b>
					<select id="estadoCreditoPareja" class="form-control" > </select>
				</div>
				<div class="col-md-2">
					<b>Valor de la cuota:</b>
					<input type="number" id="cuota" class="form-control" step="0.01" pattern="^\d+(\.\d{1,2})?$" title="Ingrese un número con hasta dos decimales">
				</div>
				<div class="col-md-2">
					<b>Es aval:</b>
					<select id="esAvalPareja" class="form-control" > </select>
					
				</div>
				<div class="col-md-2">
					<b>Avales en mora:</b>
					<select id="avalMoraPareja" class="form-control" > </select>
				</div>
		</div>
		
				
		</div> <!-- div del row-->
		
						
		</div> <!-- div final de la clase rz-card card"-->

		

	</div>


	<div id="step4" class="step" style="display: none;">
        
	<div class="rz-card card" style="width: 100%" >
			<div class="button-container">
				
				<button class="btn btn-warning" style="float: left;" onclick="prevStep(4)">Anterior</button>
				<button class="btn btn-success" style="float: right;" onclick="nextStep(4)">Siguiente</button>
				
			</div>
				
				<div class="row">

					<b><center>REFERENCIAS FAMILIARES QUE NO VIVAN EN SU MISMA CASA</center></b>
					<br>
					<br>
					<div class="col-md-3">
						<b>1. Nombre:</b>
						<input type="text" id="nombreR1" class="form-control" style="text-transform:uppercase;" onblur="CambiarMayuscula(this);" onkeypress="return soloLetras(event)" onblur="limpiaNombre()" onkeyup="espacios(this);" maxlength="45" >
					</div>
					<div class="col-md-2">
						<b>Parentesco:</b>
						<select id="parestencosR1" class="form-control" > </select>
					</div>
					<div class="col-md-2">
						<b>Celular:</b>
						<input type="text" id="celularR1" class="form-control" maxlength="9"  >
					</div>
					<div class="col-md-5">
						<b>Dirección Completa:</b>
						<input type="text" id="direccionR1" class="form-control" maxlength="120" style="text-transform:uppercase;" onblur="CambiarMayuscula(this);"  onkeyup="espacios(this);" >
					</div>


					<div class="col-md-3">
						<b>2. Nombre:</b>
						<input type="text" id="nombreR2" class="form-control" style="text-transform:uppercase;" onblur="CambiarMayuscula(this);" onkeypress="return soloLetras(event)" onblur="limpiaNombre()" onkeyup="espacios(this);" maxlength="45" >
					</div>
					<div class="col-md-2">
						<b>Parentesco:</b>
						<select id="parestencosR2" class="form-control" > </select>
					</div>
					<div class="col-md-2">
						<b>Celular:</b>
						<input type="text" id="celularR2" class="form-control" maxlength="9"  >
					</div>
					<div class="col-md-5">
						<b>Dirección Completa:</b>
						<input type="text" id="direccionR2" class="form-control" maxlength="120" style="text-transform:uppercase;" onblur="CambiarMayuscula(this);"  onkeyup="espacios(this);" >
					</div>
					<div class="col-md-12 mb-3">
						
					</div>
					
					<b><center>INFORMACIÓN ADICIONAL</center></b>
					<br>

					<div class="col-md-5">
						<b>Lo invertira en: *</b>
						<input type="text" id="invierteEn" class="form-control" maxlength="120" style="text-transform:uppercase;" onblur="CambiarMayuscula(this);"  onkeyup="espacios(this);" >
					</div>
					<div class="col-md-3">
							<b>Bienes que posee: *</b>
							<select id="bienes" class="form-control" > </select>
							
					</div>
           
					<div class="col-md-4">
						<b>Nombre de los dependientes:</b> <br>
						<textarea id="dependientes" cols="55" rows="2" style="text-transform:uppercase;" onblur="CambiarMayuscula(this);"  onkeyup="espacios(this);" maxlength="120"></textarea>
					</div>
					<div class="col-md-8">
					
						<b>OBSERVACIONES:</b>
						<input type="text" id="observaciones" class="form-control" style="text-transform:uppercase;" onblur="CambiarMayuscula(this);"  onkeyup="espacios(this);" maxlength="120">
					</div>
					<div class="button-container">
				
			</div>
			
			</div> <!-- div del row-->
			
			
			</div> <!-- final de la clase dic card card -->

        
    </div>


	<div id="step5" class="step" style="display: none;">
        
	<div class="rz-card card" id="rz-card-analisis" style="width: 100%" >
			<div class="button-container">
				
				<button class="btn btn-success" style="float: left;" onclick="prevStep(5)">Anterior</button>
       			<button class="btn btn-info" style="float: right;" onclick="RegistrarCliente();">Guardar</button>
				
			</div>
					<div class="row">
		
					<h4><b><center>ANÁLISIS CREDITICIO</center></b></h4>
					<br>
					
					<div class="col-md-6 mb-2 ">
					<b><center>ESTADO DE INGRESOS Y GASTOS</center></b>
					<table class="table table-bordered">
						<thead>
							<tr>
								<th scope="col"><center><b>INGRESOS MENSUALES</b></center></th>
								<th scope="col"><center><b>EGRESOS MENSUALES </b></center></th>
							</tr>
						
						</thead>
						<tbody>
							<tr>
								<th scope="row">
									Sueldo Base: <input type="number" id="sueldoBase_analisis" class="form-control" oninput="sumarIngresosEgresos()" value="0" readonly>
								</th>
								<th scope="row">
									Cuota de préstamo en ADEPES: <input type="number" id="cuotaAdepes" oninput="sumarIngresosEgresos()" class="form-control" value="0" readonly>
								</th>
								
							</tr>

						   <tr>
						   		<th scope="row">
									Ingresos del negocio: <input type="number" id="ingresosNegocio" class="form-control" oninput="sumarIngresosEgresos()" value="0" readonly>
								</th>
								<th scope="row">
									Cuota de vivienda: <input type="number" id="vivienda" class="form-control" oninput="sumarIngresosEgresos()" value="0" readonly>
								</th>
						   </tr>

						   <tr>
						   		<th scope="row">
									Renta de propiedades: <input type="number" id="renta" class="form-control"  oninput="validarNumeroNegativo(this); sumarIngresosEgresos();" value="0">
								</th>
								<th scope="row">
									Gastos de alimentación: <input type="number" id="alimentacion" class="form-control" oninput="sumarIngresosEgresos()" value="0" readonly >
								</th>
						   </tr>

						   <tr>
						   		<th scope="row">
									Remesas: <input type="number" id="remesas" class="form-control" oninput="validarNumeroNegativo(this); sumarIngresosEgresos();"value="0">
								</th>
								<th scope="row">
									Central de riesgo como cliente: <input type="number" id="centralRiesgo" oninput="validarNumeroNegativo(this); sumarIngresosEgresos();" class="form-control" value="0">
								</th>
						   </tr>

						   <tr>
						   		<th scope="row">
									Aporte del conyugue: <input type="number" id="aporteConyuge" class="form-control" oninput="validarNumeroNegativo(this); sumarIngresosEgresos();" value="0">
								</th>
								<th scope="row">
									Otros egresos: <input type="number" id="otrosEgresos" class="form-control" oninput="validarNumeroNegativo(this); sumarIngresosEgresos();" value="0">
								</th>
						   </tr>

						   <tr>
						   		<th scope="row">
									Ingresos por sociedad: <input type="number" id="sociedad" class="form-control" oninput="validarNumeroNegativo(this); sumarIngresosEgresos();" value="0">
								</th>
								<th scope="row">
									<b>Total  egresos:</b> <input type="number" id="totalEgresos" class="form-control" oninput="sumarIngresosEgresos()" value="0" readonly>
								</th>
						   </tr>

						   <tr>
						   		<th scope="row">
									<b>Total ingresos:</b> <input type="number" id="totalIngresos" class="form-control"  value="0" readonly>
								</th>
								<th scope="row">
									<b>TOTAL INGRESOS NETOS:</b> <input type="number" id="ingresosNetos" class="form-control" value="0" readonly>
								</th>
						   </tr>
						  
						 

						
						</tbody>
					</table>
			</div>

			<div class="col-md-1 mb-2 ">
			</div>
			
			<div class="col-md-4 mb-2 ">
				<b><center>Relacion cuotas en cuanto a ingresos netos</center></b>
				<table class="table table-bordered">
						<thead>
							<tr>
								<th scope="col"><center><b></b></center></th>
								
							</tr>
						
						</thead>
						<tbody>
							<tr>
								<th scope="row">
									Letra mensual: <input type="number" id="letraMensual" class="form-control" value="<?php echo round($letraMensual,2); ?>" oninput="sumarIngresosEgresos()" readonly>
								</th>
								
								
							</tr>

						   <tr>
						   		<th scope="row">
									Interés corriente mensual: <input type="number" id="interesCorriente" class="form-control" oninput="sumarIngresosEgresos()" value="<?php echo round($interesCorrienteMensual,2); ?>" readonly>
								</th>
								
						   </tr>

						   <tr>
						   		<th scope="row">
									Cuota mensual: <input type="number" id="cuotaMensual" class="form-control"  value="<?php echo round($cuota, 2);  ?>" readonly>
								</th>
							
						   </tr>

						   <tr>
						   		<th scope="row">
									<b>Capital disponible para el crédito:</b> <input type="number" id="capitalDisponible" class="form-control"  value="0" readonly>
								</th>
							
						   </tr>
						  
						 

						
						</tbody>
					</table>

					<table class="table table-bordered">
						<thead>
							<tr>
								<th scope="col"><center><b>EVALUACIÓN SEGÚN INFORMACION RECOPILADA</b></center></th>
								
							</tr>
						
						</thead>
						<tbody>
							<tr>
								<th scope="row">
									<textarea  id="evaluacion" cols="40" rows="5" readonly></textarea>
								</th>
											
							</tr>
						</tbody>
					</table>
				</div>
				
				
				</div> <!-- div del row -->

        
    </div>
	
	<!-- hasta aquiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiii -->
    
    <div id="planContainer"></div>
		<div class="content-body ">
			<section id="basic-form-layouts">
	
				
				
			
					
			</section>
		</div>
	</div>


	


<!-- =========== | contenido | ===============-->

<!-- ========= | scripts robust | ============-->
<?php  include "layouts/main_scripts.php"; ?>
<?php  include "Modals/Registrar/PlanPagosVista.php"; ?>
<?php  include "Modals/Registrar/NuevaProfesionSolicitud.php"; ?>
<!-- Advertencias Toastr -->
<script src="../app-assets/plugins/toastr/toastr.min.js">  </script> 


<!--Contiene las Validaciones de los input -->
<script src="../assets/js/ValidacionesSolicitud.js"></script>
<!-- obtencion de los datos por javascript -->
<script src="../assets/js/SolicitudNueva.js"></script>
<!-- referencias para las alertas -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>



</body>
</html>

<!--==========================================-->

<!-- ============= | footer | ================-->
<?php  include "layouts/footer.php";  
  }
  else {
	  header("location:../");
  }
?>
<!--==========================================-->