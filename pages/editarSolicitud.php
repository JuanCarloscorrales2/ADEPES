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
            background-color: #9BD8FD; /* Color de fondo personalizado */
            border: 1px solid #dee2e6; /* Borde personalizado */
            border-radius: 8px; /* Bordes redondeados */
            padding: 20px; /* Espaciado interno */
			margin: 0 auto; /* Centrar horizontalmente */
        }

		#formulario {
     	 display: none;
 		 }
		#AnalisisCrediticioCliente {
			display: none;
			font-size: 14px; /* El tamaño de fuente que desees */
		}
		#AnalisisCrediticioAval1 {
			display: none;
			font-size: 14px; /* El tamaño de fuente que desees */
		}
		#AnalisisCrediticioAval2 {
			display: none;
			font-size: 14px; /* El tamaño de fuente que desees */
		}
		#AnalisisCrediticioAval3 {
			display: none;
			font-size: 14px; /* El tamaño de fuente que desees */
		}
		

		#formularioAval1 {
     	 display: none;
 		}

		#formularioAval2 {
     	 display: none;
 		}  

	    #formularioAval3 {
     	 display: none;
 		}  
		 
		  #header {
            background-color: #007bff;
            color: white;
            padding: 10px 0;
            text-align: center;
        }
    #steps-container {
        display: flex;
        justify-content: space-between;
        background-color: #f2f2f2;
        padding: 10px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    .step {
        flex: 1;
        text-align: center;
        padding: 10px;
        cursor: pointer;
        transition: background-color 0.3s, color 0.3s;
    }
    .step.active {
        background-color: green;
        color: white;
    }
    .form-step {
        display: none;
    }
    .form-step.active {
        display: block;
    }

	/* TABLA CONOZCO A SU CLIENTE */
	.container {
            width: 80%;
            margin: 20px auto;
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .section {
            margin-bottom: 20px;
        }
        .section h2 {
            text-align: center;
            background-color: #4CAF50;
            color: #fff;
            padding: 10px;
            border-radius: 5px;
        }
       
        
        .col label {
            font-weight: bold;
        }

		/*CENTRAL RIESGO*/
		.sin-borde {
			border: none;
			text-align: center;
			font-weight: bold;
		}
		
		
</style>

<div class="app-content content container-fluid">
    <div class="content-wrapper">
        <div class="content-body ">
            <section id="basic-form-layouts">
                <div id="steps-container">
                    <div class="step active" onclick="showStep(1)">Cliente</div>
                    <div class="step" onclick="showStep(2)">Aval 1</div>
                    <div class="step" onclick="showStep(3)">Aval 2</div>
                    <div class="step" onclick="showStep(4)">Aval 3</div>
                    <div class="step" onclick="showStep(5)">Conozca a su cliente</div>
                    <div class="step" onclick="showStep(6)">Dictamen</div>
                    <div class="step" onclick="showStep(7)">Central</div>
                    <div class="step" onclick="showStep(8)">Comité</div>
					<button type="button" class="btn btn-info" style="float: right;"  onclick="ActualizarCliente();">Guardar</button>
                </div>
				<form id="form">
                    <div class="form-step active" id="step1">
                        <!-- *********************************  FORMULARIO CLIENTE ***************************************** -->
                      
						<br>
					<h2><center>Solicitud de Préstamo</center> </h2>
					<input type="button" class="btn btn-warning" value="Ver Plan" onclick="generarPlan()">
					<!-- <input type="button" class="btn btn-warning" value="Guardar" onclick="ActualizarCliente()"> -->
					<div class="rz-card card" style="width: 100%" >
						<div class="row">
							<div class="col-md-4 mb-2 ">
						<!--id del solicitante -->
							<input type="hidden" id="idSolicitante_edit">
							<input type="hidden" id="idSolicitud_edit">
							<b>Tipo de Garantía y Tasa (anual):</b>
							<select id="tipogarantia_edit" class="form-control" oninput="ObtenerDatosPrestamo()" ></select>
							</div>	

							<div class="col-md-2 mb-2">
							<b>Monto:</b>
							<input type="number" id="monto_edit" class="form-control"  min="1" max="300000" step="0.01" oninput="ObtenerDatosPrestamo()">	
							</div>

							<div class="col-md-2 mb-2">
							<b>Plazo (en meses):</b>
							<input type="number" id="plazo_edit" class="form-control" min="1" max="130" oninput="ObtenerDatosPrestamo()" >
							</div>

							<div class="col-md-2 mb-2">
							<b>Invierte en:</b>
							<select id="rubro_edit" class="form-control" ></select>
							</div>		

							<div class="col-md-2 mb-2">
							<b>Fecha de emision:</b>
							<input type="date" id="fechaEmision_edit" name="fecha" class="form-control" format="aaaa-mm-dd" min="" >
							</div>
						</div> <!-- div del row -->

					</div> <!-- fin dde las clase rz-card card -->

		
				 
			
					<div class="rz-card card">
						<div class="row">
							<b><center>INFORMACIÓN PERSONAL</center></b>
							<br>
							<br>
							
							<div class="col-md-12 mb-1">
							<div class="col-md-3">
								<b>Nombres:</b>
								<input type="text" id="nombresCliente_edit" class="form-control" style="text-transform:uppercase;" onblur="CambiarMayuscula(this);" onkeypress="return soloLetras(event)" onblur="limpiaNombreCliente()" onkeyup="espacios(this);" maxlength="45" >
							</div>
							<div class="col-md-3">
								<b>Apellidos:</b>
								<input type="text" id="apellidosCliente_edit" class="form-control" style="text-transform:uppercase;" onblur="CambiarMayuscula(this);" onkeypress="return soloLetras(event)" onblur="limpiaApellidoCliente()" onkeyup="espacios(this);" maxlength="45" >
							</div>
							<div class="col-md-2">
								<b>N° de identidad:</b>
								<input type="numer" id="identidadCliente_edit" class="form-control" maxlength="15" placeholder="0000-0000-00000" oninput="formatoIdentidad(event)">
								<span id="errorMensaje" style="color: red;"></span>
							</div>
							<div class="col-md-2">
								<b>Fecha de nacimiento:</b>
								<input type="date" id="fechaNacimiento_edit" class="form-control" >
								
							</div>
							<div class="col-md-2">
								<b>Nacionalidad:</b>
								<select id="nacionalidad_edit" class="form-control" ></select>
							</div>	

						</div>	
					<div class="col-md-12 mb-1">
							<div class="col-md-2">
								<b>Municipio:</b>
								<select id="municipio_edit" class="form-control" >	</select>
							</div>	
							<div class="col-md-5">
								<b>Dirección:</b>
								<input type="text" id="direccionCliente_edit" class="form-control" style="text-transform:uppercase;" onblur="CambiarMayuscula(this);"  onkeyup="espacios(this);" maxlength="120" >
							</div>
							<div class="col-md-3">
								<b>Teléfono:</b>
								<input type="text" id="telefonoCliente_edit" class="form-control" oninput="formatearNumero(this)" maxlength="9">
							</div>
							<div class="col-md-2">
								<b>Celular:</b>
								<input type="text" id="celularCLiente_edit" class="form-control" oninput="formatearNumero(this)" maxlength="9"  >
							</div>
							
					</div>			

					<div class="col-md-12 mb-1">
							<div class="col-md-2">
								<b>Estado civil:</b>
								<select id="estadoCivil_edit" class="form-control" >	</select>
							</div>	
						
							<div class="col-md-2">
								<b>Casa:</b>
								<select id="casa_edit" class="form-control" > </select>
							</div>
							<div class="col-md-2">
								<b>Tiempo de vivir:</b>
								<select id="tiempoVivir_edit" class="form-control" > </select>
							</div>
							<div class="col-md-2">
								<b>Forma de pago:</b>
								<select id="formaPago_edit" class="form-control" > </select>
							</div>
							<div class="col-md-2">
								<b>Pago del alquiler:</b>
								<input type="number" id="pagoCasa_edit" class="form-control">
							</div>
							
							<div class="col-md-2">
								<b>Genero:</b>
								<select class="form-control" id="idGeneroCliente_edit" > </select>
							</div>
							
					</div>
                    <!-- desde aqui -->
					
					<div class="col-md-12 mb-1">
							<div class="col-md-2">
								<b>Profesión u oficio:</b>
								<select id="profesiones_edit" class="form-control" > </select>
							</div>
							<div class="col-md-4">
								<b>Patrono o negocio:</b>
								<input type="text" id="patrono_edit" class="form-control" style="text-transform:uppercase;" onblur="CambiarMayuscula(this);"  onkeyup="espacios(this);" onkeyup="espacios(this);"  maxlength="30"  >
							</div>
							<div class="col-md-4">
								<b>Actividad que desempeña:</b>
								<input type="text" id="actividadDesempeña_edit" class="form-control" style="text-transform:uppercase;" onblur="CambiarMayuscula(this);" onkeyup="espacios(this);" maxlength="30"  >
							</div>
							<div class="col-md-2">
								<b>Tiempo de laborar:</b>
								<select id="tiempoLaboral_edit" class="form-control" ></select>
							</div>
					</div>		

					<div class="col-md-12 mb-1">	
						<div class="col-md-2">
							<b>Ingresos por negocio:</b>
							<input type="number" id="ingresosPorNegocio_edit" class="form-control">
						</div>
						<div class="col-md-2">
							<b>Sueldo Base:</b>
							<input type="number" id="sueldoBase_edit" class="form-control">
						</div>
						<div class="col-md-2">
							<b>Gastos de alimentacion:</b>
							<input type="number" id="gastosAlimentacion_edit" class="form-control">
						</div>
						<div class="col-md-6">
								<b>Dirección del trabajo:</b>
								<input type="text" id="direccionTrabajoCliente" class="form-control" style="text-transform:uppercase;" onblur="CambiarMayuscula(this);" onkeyup="espacios(this);" maxlength="120"  >
						</div>
					</div>	
							
					<div class="col-md-12 mb-1">		
						<div class="col-md-2">
							<b>Teléfono del trabajo:</b>
							<input type="text" id="telefonoClienteTrabajo" class="form-control" oninput="formatearNumero(this)" maxlength="9" >
						</div>
						<div class="col-md-2">
							<b>Tipo de crédito:</b>
							<select id="tipoCliente_edit" class="form-control" ></select>
						</div>
						<div class="col-md-2">
							<b>Cuenta #:</b>
							<input type="text" id="cuentaCliente_edit" class="form-control" maxlength="15" >
						</div>
						<div class="col-md-2">
							<b>Estado del crédito:</b>
							<select id="estadoCreditoCliente_edit"class="form-control" ></select>
						</div>
						<div class="col-md-2">
							<b>Valor de la cuota:</b>
							<input type="number" id="cuota_edit" class="form-control" step="0.01" pattern="^\d+(\.\d{1,2})?$" title="Ingrese un número con hasta dos decimales">
						</div>
						<div class="col-md-2">
							<b>Es aval:</b>
							<select id="esAvalCliente_edit" class="form-control" ></select>
							<select id="avalMoraCliente_edit" class="form-control" > </select>
						</div>
						
					</div>		
		
							
					</div> <!-- div del row-->
		
							</div> <!-- div final de la clase rz-card card"-->
					
							

							<!-- FORMULARIO DE ESPOSO O COMPAñERO -->
							<div id="formulario">
							
							<div id="analisis" class="rz-card card" style="width: 100%" >
						
								<div class="row">

									<b><center>INFORMACIÓN DEL ESPOSO(A) O COMPAÑERO(A) </center></b>
									<br>
									<br>
							<div class="col-md-12 mb-1">
								<input type="hidden" id="idPareja">
									<div class="col-md-3">
										<b>Nombres:</b>
										<input type="text" id="nombresPareja_edit" class="form-control" style="text-transform:uppercase;" onblur="CambiarMayuscula(this);" onkeypress="return soloLetras(event)" onblur="limpiaNombre()" onkeyup="espacios(this);" maxlength="45" >
									</div>
									<div class="col-md-3">
										<b>Apellidos:</b>
										<input type="text" id="apellidosPareja_edit" class="form-control" style="text-transform:uppercase;" onblur="CambiarMayuscula(this);" onkeypress="return soloLetras(event)" onblur="limpiaNombre()" onkeyup="espacios(this);" maxlength="45" >
									</div>
									<div class="col-md-3">
										<b>N° de identidad:</b>
										<input type="numer" id="identidadPareja_edit" class="form-control" maxlength="15" placeholder="0000-0000-00000" oninput="formatoIdentidad(event)">
										<span id="errorMensaje1" style="color: red;"></span>
									</div>
									<div class="col-md-3">
										<b>Fecha de nacimiento:</b>
										<input type="date" id="fechaNacimientoPareja_edit" class="form-control" >
										
									</div>
										
							</div>
									
							<div class="col-md-12 mb-1">
									<div class="col-md-2">
										<b>Municipio:</b>
										<select id="municipioPareja_edit"  class="form-control"></select>
									</div>
									<div class="col-md-5">
										<b>Dirección:</b>
										<input type="text" id="direccionPareja_edit" class="form-control" style="text-transform:uppercase;" onblur="CambiarMayuscula(this);"  onkeyup="espacios(this);" maxlength="120">
									</div>
									<div class="col-md-3">
										<b>Teléfono:</b>
										<input type="text" id="telefonoPareja_edit" class="form-control" oninput="formatearNumero(this)" maxlength="9" >
									</div>
									<div class="col-md-2">
										<b>Celular:</b>
										<input type="text" id="celularPareja_edit" class="form-control" oninput="formatearNumero(this)" maxlength="9"  >
									</div>

									
								</div>
									
									

							<div class="col-md-12 mb-1">
									<div class="col-md-2">
										<b>Genero:</b>
										<select id="generoPareja_edit"  class="form-control"></select>
									</div>
									<div class="col-md-2">
										<b>Profesión u oficio:</b>
										<select id="profesionPareja_edit" class="form-control" > </select>
									</div>		
									<div class="col-md-3">
										<b>Patrono o negocio:</b>
										<input type="text" id="patronoPareja_edit" class="form-control" maxlength="50" style="text-transform:uppercase;" onblur="CambiarMayuscula(this);"  onkeyup="espacios(this);" >
									</div>
									<div class="col-md-3">
										<b>Cargo que desempeña:</b>
										<input type="text" id="actividadPareja_edit" class="form-control" style="text-transform:uppercase;" onblur="CambiarMayuscula(this);"  onkeyup="espacios(this);" maxlength="50"  >
									</div>
									<div class="col-md-2">
										<b>Tiempo de laborar:</b>
										<select id="tiempoLaboralPareja_edit" class="form-control" >	</select>
									</div>
							</div>

							<div class="col-md-12 mb-1">
									<div class="col-md-2 ">
										<b>Ingresos del Negocio:</b>
										<input type="number" id="ingresoNegocioPareja_edit" class="form-control">
									</div>
									<div class="col-md-2 ">
										<b>Sueldo Base:</b>
										<input type="number" id="sueldoBasePareja_edit" class="form-control">
									</div>
									<div class="col-md-2 ">
										<b>Gastos Alimentación:</b>
										<input type="number" id="gastoAlimentacionPareja_edit" class="form-control">
									</div>
									
									
									<div class="col-md-4">
										<b>Dirección del trabajo:</b>
										<input type="text" id="direccionTrabajoPareja_edit" class="form-control" maxlength="120" style="text-transform:uppercase;" onblur="CambiarMayuscula(this);"  onkeyup="espacios(this);" >
									</div>
									<div class="col-md-2">
										<b>Teléfono del trabajo:</b>
										<input type="text" id="telefonoParejaTrabajo_edit" oninput="formatearNumero(this)" class="form-control" maxlength="9" >
									</div>
							</div>
									<!-- -->
							<div class="col-md-12 mb-1">
									<div class="col-md-2">
										<b>Tipo de cliente:</b>
										<select id="tipoClientePareja_edit" name="tipoCliente" class="form-control" > </select>
									</div>
									<div class="col-md-2">
										<b>Cuenta IDC#:</b>
										<input type="text" id="cuentaPareja" class="form-control" maxlength="15" >
									</div>
									<div class="col-md-2">
										<b>Estado del crédito:</b>
										<select id="estadoCreditoPareja_edit" class="form-control" > </select>
									</div>
									<div class="col-md-2">
										<b>Valor de la cuota:</b>
										<input type="number" id="cuotaPareja_edit" class="form-control" step="0.01" pattern="^\d+(\.\d{1,2})?$" title="Ingrese un número con hasta dos decimales">
									</div>
									<div class="col-md-2">
										<b>Es aval:</b>
										<select id="esAvalPareja_edit" class="form-control" > </select>
										
									</div>
									<div class="col-md-2">
										<b>Avales en mora:</b>
										<select id="avalMoraPareja_edit" class="form-control" > </select>
									</div>
							</div>
									
									
							</div> <!-- div del row-->
											
							</div> <!-- div final de la clase rz-card card"-->
						
						</div> <!-- final del ocultar div formulario -->	
						
						<button type="button" id="botonMostrarOcultar" class="btn btn-success" onclick="mostrarFormularioAnalisis(1)">
								<span class="icon-plus"></span> Mostra Análisis
						</button>
					
						<div id="AnalisisCrediticioCliente">
								
						<div class="form-group">
						<div class="rz-card card" id="rz-card-analisis" style="width: 80%" >
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
												Sueldo Base: <input type="number" id="sueldoBase_analisis" class="form-control" oninput="sumarIngresosEgresos()"  value="0" readonly>
											</th>
											<th scope="row">
												Cuota de préstamo en ADEPES: <input type="number" id="cuotaAdepes"  class="form-control" oninput="sumarIngresosEgresos()" value="0" readonly>
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
												Renta de propiedades: <input type="number" id="renta" class="form-control" oninput="sumarIngresosEgresos()" value="0">
											</th>
											<th scope="row">
												Gastos de alimentación: <input type="number" id="alimentacion" class="form-control" oninput="sumarIngresosEgresos()"  value="0" readonly >
											</th>
									</tr>

									<tr>
											<th scope="row">
												Remesas: <input type="number" id="remesas" class="form-control" oninput="sumarIngresosEgresos()" value="0">
											</th>
											<th scope="row">
												Central de riesgo como cliente: <input type="number" id="centralRiesgo"  class="form-control" oninput="sumarIngresosEgresos()" value="0">
											</th>
									</tr>

									<tr>
											<th scope="row">
												Aporte del conyugue: <input type="number" id="aporteConyuge" class="form-control" oninput="sumarIngresosEgresos()" value="0">
											</th>
											<th scope="row">
												Otros egresos: <input type="number" id="otrosEgresos" class="form-control" oninput="sumarIngresosEgresos()" value="0">
											</th>
									</tr>

									<tr>
											<th scope="row">
												Ingresos por sociedad: <input type="number" id="sociedad" class="form-control" oninput="sumarIngresosEgresos()" value="0">
											</th>
											<th scope="row">
												<b>Total  egresos:</b> <input type="number" id="totalEgresos" class="form-control" value="0" readonly>
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
												Letra mensual: <input type="number" id="letraMensual" class="form-control" oninput="sumarIngresosEgresos()" readonly>
											</th>
											
											
										</tr>

									<tr>
											<th scope="row">
												Interés corriente mensual: <input type="number" id="interesCorriente" class="form-control"   oninput="sumarIngresosEgresos()" readonly>
											</th>
											
									</tr>

									<tr>
											<th scope="row">
												Cuota mensual: <input type="number" id="cuotaMensual" class="form-control"  oninput="sumarIngresosEgresos()"  readonly>
											</th>
										
									</tr>

									<tr>
											<th scope="row">
												<b>Capital disponible para el crédito:</b> <input type="number" id="capitalDisponible" class="form-control"  oninput="sumarIngresosEgresos()" value="0" readonly>
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
												<textarea  id="evaluacion" cols="40" rows="5"  oninput="sumarIngresosEgresos()" readonly></textarea>
											</th>
														
										</tr>
									</tbody>
								</table>
							</div>

						</div> <!-- div del row -->
						</div>

					
					</div>

						
					</div>	<!-- fin del div ocultar analisis -->
				



						<div class="rz-card card" style="width: 100%" >
							
							<div class="row">

								<b><center>REFERENCIAS FAMILIARES QUE NO VIVAN EN SU MISMA CASA</center></b>
								<br>
								<br>
								<div class="col-md-3">
									<b>1. Nombre:</b>
									<input type="text" id="nombreR1_edit" class="form-control" style="text-transform:uppercase;" onblur="CambiarMayuscula(this);" onkeypress="return soloLetras(event)" onblur="limpiaNombre()" onkeyup="espacios(this);" maxlength="45" >
								</div>
								<div class="col-md-2">
									<b>Parentesco:</b>
									<select id="parestencosR1_edit" class="form-control" > </select>
								</div>
								<div class="col-md-2">
									<b>Celular:</b>
									<input type="text" id="celularR1_edit" oninput="formatoTelefono(this)" class="form-control" maxlength="9"  >
								</div>
								<div class="col-md-5">
									<b>Dirección Completa:</b>
									<input type="text" id="direccionR1_edit" class="form-control" maxlength="120" style="text-transform:uppercase;" onblur="CambiarMayuscula(this);"  onkeyup="espacios(this);" >
								</div>


								<div class="col-md-3">
									<b>2. Nombre:</b>
									<input type="text" id="nombreR2_edit" class="form-control" style="text-transform:uppercase;" onblur="CambiarMayuscula(this);" onkeypress="return soloLetras(event)" onblur="limpiaNombre()" onkeyup="espacios(this);" maxlength="45" >
								</div>
								<div class="col-md-2">
									<b>Parentesco:</b>
									<select id="parestencosR2_edit" class="form-control" > </select>
								</div>
								<div class="col-md-2">
									<b>Celular:</b>
									<input type="text" id="celularR2_edit" oninput="formatoTelefono(this)" class="form-control" maxlength="9"  >
								</div>
								<div class="col-md-5">
									<b>Dirección Completa:</b>
									<input type="text" id="direccionR2_edit" class="form-control" maxlength="120" style="text-transform:uppercase;" onblur="CambiarMayuscula(this);"  onkeyup="espacios(this);" >
								</div>
								<div class="col-md-12 mb-3">
									
								</div>
								
								<b><center>INFORMACIÓN ADICIONAL</center></b>
								<br>

								<div class="col-md-5">
									<b>Lo invertira en:</b>
									<input type="text" id="invierteEn_edit" class="form-control" maxlength="120" style="text-transform:uppercase;" onblur="CambiarMayuscula(this);"  onkeyup="espacios(this);" >
								</div>
								<div class="col-md-3">
									<b>Bienes que posee:</b>
									<select id="bienes" class="form-control" > </select>
								</div>
					
								<div class="col-md-4">
									<b>Nombre de los pedendientes:</b> <br>
									<textarea id="dependientes_edit" cols="55" rows="2" style="text-transform:uppercase;" onblur="CambiarMayuscula(this);"  onkeyup="espacios(this);" maxlength="120"></textarea>
								</div>
								<div class="col-md-8">
								
									<b>OBSERVACIONES:</b>
									<input type="text" id="observaciones_edit" class="form-control" style="text-transform:uppercase;" onblur="CambiarMayuscula(this);"  onkeyup="espacios(this);" maxlength="120">
								</div>
								<div class="button-container">
								
							
						</div>
								
						</div> <!-- div del row-->
						
						<br><button type="button" class="btn btn-success" style="float: right;" onclick="nextStep(1)">Siguiente</button><br>

						</div> <!-- final de la clase dic card card -->
						
						
						
                    </div>

<!-- *********************************  FORMULARIO AVAL 1 ***************************************** -->
                    <div class="form-step" id="step2">
                        <?php  include "../pages/editarAval1.php"; ?>

                    </div>
 <!-- *********************************  FORMULARIO AVAL 2 ***************************************** -->
                    <div class="form-step" id="step3">
						<?php  include "../pages/editarAval2.php"; ?>
                
                    </div>
 <!-- *********************************  FORMULARIO AVAL 3 ***************************************** -->
                    <div class="form-step" id="step4">
					<?php  include "../pages/editarAval3.php"; ?>
                        
                    </div>
 <!-- *****************************     FORMATO CONOZCA A SU CLIENTE *************************************** -->
                    <div class="form-step" id="step5">
					<?php  include "../pages/conozcaAsuCliente.php"; ?>
                       
                    </div>
<!-- *********************************  FORMULARIO DICTAMEN ***************************************** -->
                    <div class="form-step" id="step6">
						<?php  include "../pages/editarDictamenAsesor.php"; ?>
                    
                    </div>
	<!-- *********************************  FORMULARIO CENTRAL ***************************************** -->
                    <div class="form-step" id="step7">
						<?php  include "../pages/centralRiesgo.php"; ?>
				
                  
                    </div>
<!-- *********************************  FORMULARIO COMITÉ ***************************************** -->
                    <div class="form-step" id="step8">
						<?php  include "../pages/editarComiteCredito.php"; ?>
                        
                    </div>
                </form>
            </section>
        </div>
    </div>

    <!-- =========== | contenido | ===============-->
    <script>
		
        let currentStep = 1;

        function showStep(step) {
            document.querySelectorAll('.step').forEach(stepElement => {
                stepElement.classList.remove('active');
            });
            document.querySelectorAll('.form-step').forEach(formStep => {
                formStep.classList.remove('active');
            });

            document.getElementById(`step${step}`).classList.add('active');
            document.querySelector(`.step:nth-child(${step})`).classList.add('active');
            currentStep = step;
        }

        function nextStep(currentStep) {
            if (currentStep < 8) {
                showStep(currentStep + 1);
            }
        }

        function prevStep(currentStep) {
            if (currentStep > 1) {
                showStep(currentStep - 1);
            }
        }
		

    </script>
  
<!-- ========= | scripts robust | ============-->
<?php  include "layouts/main_scripts.php"; ?>
<?php  include "Modals/Registrar/PlanPagosVista.php"; ?>

<!-- Advertencias Toastr -->
<script src="../app-assets/plugins/toastr/toastr.min.js">  </script>



<!--Solicitudes jS -->

<script src="../assets/js/editarSolicitud.js"></script> 
<script src="../assets/js/guardarSolicitudEditar.js"></script> 
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


</body>
</html>

<!--==========================================-->

<!-- ============= | footer | ================-->
<?php   
  }
  else {
	  header("location:../");
  }
?>
<!--==========================================-->