<br><h4 class="content-header-title"><center>AVAL SOLIDARIO #3 </center></h4><br>

<div class="rz-card card">
        <div class="row">
            <b><center>INFORMACIÓN PERSONAL</center></b>
            <br>
            <br>
            <div class="col-md-12 mb-1">
            <input type="hidden" id="idPersonaAval3">
            <div class="col-md-3">
                <b>Nombres:</b>
                <input type="text" id="nombresAval_edit3" class="form-control" style="text-transform:uppercase;" onblur="CambiarMayuscula(this);" onkeypress="return soloLetras(event)" onblur="limpiaNombreCliente()" onkeyup="espacios(this);" maxlength="45" >
            </div>
            <div class="col-md-3">
                <b>Apellidos:</b>
                <input type="text" id="apellidosAval_edit3" class="form-control" style="text-transform:uppercase;" onblur="CambiarMayuscula(this);" onkeypress="return soloLetras(event)" onblur="limpiaApellidoCliente()" onkeyup="espacios(this);" maxlength="45" >
            </div>
            <div class="col-md-2">
                <b>N° de identidad:</b>
                <input type="numer" id="identidadAval_edit3" class="form-control" maxlength="15" placeholder="0000-0000-00000" oninput="formatoIdentidad(event)">
                <span id="errorMensaje" style="color: red;"></span>
            </div>
            <div class="col-md-2">
                <b>Fecha de nacimiento:</b>
                <input type="date" id="fechaNacimiento_edit3" class="form-control" >
                
            </div>
            <div class="col-md-2">
                <b>Nacionalidad:</b>
                <select id="nacionalidad_edit3" class="form-control" ></select>
            </div>	

        </div>	
    <div class="col-md-12 mb-1">
            <div class="col-md-2">
                <b>Municipio:</b>
                <select id="municipio_edit3" class="form-control" >	</select>
            </div>	
            <div class="col-md-5">
                <b>Dirección:</b>
                <input type="text" id="direccionAval_edit3" class="form-control" style="text-transform:uppercase;" onblur="CambiarMayuscula(this);"  onkeyup="espacios(this);" maxlength="120" >
            </div>
            <div class="col-md-3">
                <b>Teléfono:</b>
                <input type="text" id="telefonoAval_edit3" oninput="formatoTelefono(this)" class="form-control" maxlength="9">
            </div>
            <div class="col-md-2">
                <b>Celular:</b>
                <input type="text" id="celularAval_edit3" oninput="formatoTelefono(this)" class="form-control" maxlength="9"  >
            </div>
            
    </div>			

    <div class="col-md-12 mb-1">
          <div class="col-md-2">
                <b>Estado civil:</b>
                <select id="estadoCivil_edit3" class="form-control" >	</select>
            </div>	
        
            <div class="col-md-2">
                <b>Casa:</b>
                <select id="casa_edit3" class="form-control" > </select>
            </div>
            <div class="col-md-2">
                <b>Tiempo de vivir:</b>
                <select id="tiempoVivir_edit3" class="form-control" > </select>
            </div>
            <div class="col-md-2">
                <b>Forma de pago:</b>
                <select id="pagaAlquiler_edit3" class="form-control" > </select>
            </div>
            <div class="col-md-2">
                <b>Pago del alquiler:</b>
                <input type="number" id="pagoCasa_aval3" class="form-control">
            </div>
            
            <div class="col-md-2">
                <b>Genero:</b>
                <select class="form-control" id="idGeneroAval_edit3" > </select>
            </div>
            
    </div>
    <!-- desde aqui -->
    
    <div class="col-md-12 mb-1">
            <div class="col-md-2">
                <b>Profesión u oficio:</b>
                <select id="profesiones_edit3" class="form-control" > </select>
            </div>
            <div class="col-md-4">
                <b>Patrono o negocio:</b>
                <input type="text" id="patrono_edit3" class="form-control" style="text-transform:uppercase;" onblur="CambiarMayuscula(this);"  onkeyup="espacios(this);" onkeyup="espacios(this);"  maxlength="30"  >
            </div>
            <div class="col-md-4">
                <b>Actividad que desempeña:</b>
                <input type="text" id="actividadDesempeña_edit3" class="form-control" style="text-transform:uppercase;" onblur="CambiarMayuscula(this);" onkeyup="espacios(this);" maxlength="30"  >
            </div>
            <div class="col-md-2">
                <b>Tiempo de laborar:</b>
                <select id="tiempoLaboral_edit3" class="form-control" ></select>
            </div>
    </div>		

    <div class="col-md-12 mb-1">	
        <div class="col-md-2">
            <b>Ingresos por negocio:</b>
            <input type="number" id="ingresosPorNegocio_aval3" class="form-control">
        </div>
        <div class="col-md-2">
            <b>Sueldo Base:</b>
            <input type="number" id="sueldoBase_aval3" class="form-control">
        </div>
        <div class="col-md-2">
            <b>Gastos de alimentacion:</b>
            <input type="number" id="gastosAlimentacion_aval3" class="form-control">
        </div>
        <div class="col-md-6">
                <b>Dirección del trabajo:</b>
                <input type="text" id="direccionTrabajoAval_edit3" class="form-control" style="text-transform:uppercase;" onblur="CambiarMayuscula(this);" onkeyup="espacios(this);" maxlength="120"  >
        </div>
    </div>	
            
    <div class="col-md-12 mb-1">		
        <div class="col-md-2">
            <b>Teléfono del trabajo:</b>
            <input type="text" id="telefonoAvalTrabajo_edit3" oninput="formatoTelefono(this)" class="form-control" maxlength="9" >
        </div>
        <div class="col-md-2">
            <b>Tipo de Cliente:</b>
            <select id="tipoClienteAval_edit3" class="form-control" ></select>
        </div>
        <div class="col-md-2">
            <b>Cuenta #:</b>
            <input type="text" id="cuentaAval_aval3" class="form-control" maxlength="15" >
        </div>
        <div class="col-md-2">
            <b>Estado del crédito:</b>
            <select id="estadoCreditoAval_edit3"class="form-control" ></select>
        </div>
        <div class="col-md-2">
            <b>Valor de la cuota:</b>
            <input type="number" id="cuota_aval3" class="form-control" step="0.01" pattern="^\d+(\.\d{1,2})?$" title="Ingrese un número con hasta dos decimales">
        </div>
        <div class="col-md-2">
            <b>Es aval:</b>
            <select id="esAval_edit3" class="form-control" ></select>
            <select id="avalMoraAval_edit3" class="form-control" > </select>
        </div>
        
    </div>		

            
    </div> <!-- div del row-->

</div> <!-- div final de la clase rz-card card"-->


<button type="button" id="botonMostrarOcultarAval3" class="btn btn-success" onclick="mostrarFormularioAnalisis(4)">
	<span class="icon-plus"></span> Mostra Análisis
</button>
<div id="AnalisisCrediticioAval3">
								
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
                                Sueldo Base: <input type="number" id="sueldoBase_analisisAval3" class="form-control" oninput="sumarIngresosEgresosAval3()"  value="0" readonly>
                            </th>
                            <th scope="row">
                                Cuota de préstamo en ADEPES: <input type="number" id="cuotaAdepesAval3"  class="form-control" oninput="sumarIngresosEgresosAval3()" value="0" readonly>
                            </th>
                            
                        </tr>

                    <tr>
                            <th scope="row">
                                Ingresos del negocio: <input type="number" id="ingresosNegocioAval3" class="form-control" oninput="sumarIngresosEgresosAval3()" value="0" readonly>
                            </th>
                            <th scope="row">
                                Cuota de vivienda: <input type="number" id="viviendaAval3" class="form-control" oninput="sumarIngresosEgresosAval3()" value="0" readonly>
                            </th>
                    </tr>

                    <tr>
                            <th scope="row">
                                Renta de propiedades: <input type="number" id="rentaAval3" class="form-control" oninput="sumarIngresosEgresosAval3()" value="0">
                            </th>
                            <th scope="row">
                                Gastos de alimentación: <input type="number" id="alimentacionAval3" class="form-control" oninput="sumarIngresosEgresosAval3()"  value="0" readonly >
                            </th>
                    </tr>

                    <tr>
                            <th scope="row">
                                Remesas: <input type="number" id="remesasAval3" class="form-control" oninput="sumarIngresosEgresosAval3()" value="0">
                            </th>
                            <th scope="row">
                                Central de riesgo como cliente: <input type="number" id="centralRiesgoAval3"  class="form-control" oninput="sumarIngresosEgresosAval3()" value="0">
                            </th>
                    </tr>

                    <tr>
                            <th scope="row">
                                Aporte del conyugue: <input type="number" id="aporteConyugeAval3" class="form-control" oninput="sumarIngresosEgresosAval3()" value="0">
                            </th>
                            <th scope="row">
                                Otros egresos: <input type="number" id="otrosEgresosAval3" class="form-control" oninput="sumarIngresosEgresosAval3()" value="0">
                            </th>
                    </tr>

                    <tr>
                            <th scope="row">
                                Ingresos por sociedad: <input type="number" id="sociedadAval3" class="form-control" oninput="sumarIngresosEgresosAval3()" value="0">
                            </th>
                            <th scope="row">
                                <b>Total  egresos:</b> <input type="number" id="totalEgresosAval3" class="form-control" value="0" readonly>
                            </th>
                    </tr>

                    <tr>
                            <th scope="row">
                                <b>Total ingresos:</b> <input type="number" id="totalIngresosAval3" class="form-control"  value="0" readonly>
                            </th>
                            <th scope="row">
                                <b>TOTAL INGRESOS NETOS:</b> <input type="number" id="ingresosNetosAval3" class="form-control" value="0" readonly>
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
                                Letra mensual: <input type="number" id="letraMensualAval3" class="form-control" oninput="sumarIngresosEgresosAval3()" readonly>
                            </th>
                            
                            
                        </tr>

                    <tr>
                        <th scope="row">
                            Interés corriente mensual: <input type="number" id="interesCorrienteAval3" class="form-control"   oninput="sumarIngresosEgresosAval3()" readonly>
                        </th>
                            
                    </tr>

                    <tr>
                        <th scope="row">
                            Cuota mensual: <input type="number" id="cuotaMensualAval3" class="form-control"  oninput="sumarIngresosEgresosAval3()"  readonly>
                        </th>
                        
                    </tr>

                    <tr>
                        <th scope="row">
                            <b>Capital disponible para el crédito:</b> <input type="number" id="capitalDisponibleAval3" class="form-control"  oninput="sumarIngresosEgresosAval3()" value="0" readonly>
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
                                <textarea  id="evaluacionAval3" cols="40" rows="5"  oninput="sumarIngresosEgresosAval3()" readonly></textarea>
                            </th>
                                        
                        </tr>
                    </tbody>
                </table>
            </div>

        </div> <!-- div del row -->
        </div>

    
    </div>

        
</div>	<!-- fin del div ocultar analisis -->				
						



 <!-- FORMULARIO DE ESPOSO O COMPAñERO DEL AVAL 3 -->
 <div id="formularioAval3">

<div class="rz-card card" style="width: 100%" >

    <div class="row">

        <b><center>INFORMACIÓN DEL ESPOSO(A) O COMPAÑERO(A) </center></b>
        <br>
        <br>
<div class="col-md-12 mb-1">
<input type="hidden" id="idParejaval3">
        <div class="col-md-3">
            <b>Nombres:</b>
            <input type="text" id="nombresParejaAval3" class="form-control" style="text-transform:uppercase;" onblur="CambiarMayuscula(this);" onkeypress="return soloLetras(event)" onblur="limpiaNombre()" onkeyup="espacios(this);" maxlength="45" >
        </div>
        <div class="col-md-3">
            <b>Apellidos:</b>
            <input type="text" id="apellidosParejaAval3" class="form-control" style="text-transform:uppercase;" onblur="CambiarMayuscula(this);" onkeypress="return soloLetras(event)" onblur="limpiaNombre()" onkeyup="espacios(this);" maxlength="45" >
        </div>
        <div class="col-md-3">
            <b>N° de identidad:</b>
            <input type="numer" id="identidadParejaAval3" class="form-control" maxlength="15" placeholder="0000-0000-00000" oninput="formatoIdentidad(event)">
            <span id="errorMensaje1" style="color: red;"></span>
        </div>
        <div class="col-md-3">
            <b>Fecha de nacimiento:</b>
            <input type="date" id="fechaNacimientoParejaAval3" class="form-control" >
            
        </div>
            
</div>
        
<div class="col-md-12 mb-1">
        <div class="col-md-2">
            <b>Municipio:</b>
            <select id="municipioParejaAval3"  class="form-control"></select>
        </div>
        <div class="col-md-5">
            <b>Dirección:</b>
            <input type="text" id="direccionParejaAval3" class="form-control" style="text-transform:uppercase;" onblur="CambiarMayuscula(this);"  onkeyup="espacios(this);" maxlength="120">
        </div>
        <div class="col-md-3">
            <b>Teléfono:</b>
            <input type="text" id="telefonoParejaAval3" oninput="formatoTelefono(this)" class="form-control" maxlength="9" >
        </div>
        <div class="col-md-2">
            <b>Celular:</b>
            <input type="text" id="celularParejaAval3" oninput="formatoTelefono(this)" class="form-control" maxlength="9"  >
        </div>

    </div>
        
        

<div class="col-md-12 mb-1">
        <div class="col-md-2">
            <b>Genero:</b>
            <select id="generoParejaAval3"  class="form-control"></select>
        </div>

        <div class="col-md-2">
            <b>Profesión u oficio:</b>
            <select id="profesionParejaAval3" class="form-control" > </select>
        </div>		
        <div class="col-md-3">
            <b>Patrono o negocio:</b>
            <input type="text" id="patronoParejaAval3" class="form-control" maxlength="50" style="text-transform:uppercase;" onblur="CambiarMayuscula(this);"  onkeyup="espacios(this);" >
        </div>
        <div class="col-md-3">
            <b>Cargo que desempeña:</b>
            <input type="text" id="actividadParejaAval3" class="form-control" style="text-transform:uppercase;" onblur="CambiarMayuscula(this);"  onkeyup="espacios(this);" maxlength="50"  >
        </div>
        <div class="col-md-2">
            <b>Tiempo de laborar:</b>
            <select id="tiempoLaboralParejaAval3" class="form-control" >	</select>
        </div>
</div>

<div class="col-md-12 mb-1">
        <div class="col-md-2 ">
            <b>Ingresos del Negocio:</b>
            <input type="number" id="ingresoNegocioParejaAval3" class="form-control">
        </div>
        <div class="col-md-2 ">
            <b>Sueldo Base:</b>
            <input type="number" id="sueldoBaseParejaAval3" class="form-control">
        </div>
        <div class="col-md-2 ">
            <b>Gastos Alimentación:</b>
            <input type="number" id="gastoAlimentacionParejaAval3" class="form-control">
        </div>
        
        
        <div class="col-md-4">
            <b>Dirección del trabajo:</b>
            <input type="text" id="direccionTrabajoParejaAval3" class="form-control" maxlength="120" style="text-transform:uppercase;" onblur="CambiarMayuscula(this);"  onkeyup="espacios(this);" >
        </div>
        <div class="col-md-2">
            <b>Teléfono del trabajo:</b>
            <input type="text" id="telefonoParejaTrabajoAval3" oninput="formatoTelefono(this)" class="form-control" maxlength="9" >
        </div>
</div>
        <!-- -->
<div class="col-md-12 mb-1">
        <div class="col-md-2">
            <b>Tipo de cliente:</b>
            <select id="tipoClienteParejaAval3" name="tipoCliente" class="form-control" > </select>
        </div>
        <div class="col-md-2">
            <b>Cuenta IDC#:</b>
            <input type="text" id="cuentaParejaAval3" class="form-control" maxlength="15" >
        </div>
        <div class="col-md-2">
            <b>Estado del crédito:</b>
            <select id="estadoCreditoParejaAVAL3" class="form-control" > </select>
        </div>
        <div class="col-md-2">
            <b>Valor de la cuota:</b>
            <input type="number" id="cuotaParejaAval3" class="form-control" step="0.01" pattern="^\d+(\.\d{1,2})?$" title="Ingrese un número con hasta dos decimales">
        </div>
        <div class="col-md-2">
            <b>Es aval:</b>
            <select id="esAvalParejaAVAL3" class="form-control" > </select>
            
        </div>
        <div class="col-md-2">
            <b>Avales en mora:</b>
            <select id="avalMoraParejaAVAL3" class="form-control" > </select>
        </div>
</div>
        
        
</div> <!-- div del row-->
                
</div> <!-- div final de la clase rz-card card"-->

</div> <!-- final del ocultar div formulario -->	

<div class="rz-card card" style="width: 100%" >

<div class="row">

    <b><center>REFERENCIAS FAMILIARES QUE NO VIVAN EN SU MISMA CASA</center></b>
    <br>
    <br>
    <div class="col-md-3">
        <b>1. Nombre:</b>
        <input type="text" id="nombreR1_aval3" class="form-control" style="text-transform:uppercase;" onblur="CambiarMayuscula(this);" onkeypress="return soloLetras(event)" onblur="limpiaNombre()" onkeyup="espacios(this);" maxlength="45" >
    </div>
    <div class="col-md-2">
        <b>Parentesco:</b>
        <select id="parestencosR1aval3" class="form-control" > </select>
    </div>
    <div class="col-md-2">
        <b>Celular:</b>
        <input type="text" id="celularR1aval3" oninput="formatoTelefono(this)" class="form-control" maxlength="9"  >
    </div>
    <div class="col-md-5">
        <b>Dirección Completa:</b>
        <input type="text" id="direccionR1aval3" class="form-control" maxlength="120" style="text-transform:uppercase;" onblur="CambiarMayuscula(this);"  onkeyup="espacios(this);" >
    </div>


    <div class="col-md-3">
        <b>2. Nombre:</b>
        <input type="text" id="nombreR2aval3" class="form-control" style="text-transform:uppercase;" onblur="CambiarMayuscula(this);" onkeypress="return soloLetras(event)" onblur="limpiaNombre()" onkeyup="espacios(this);" maxlength="45" >
    </div>
    <div class="col-md-2">
        <b>Parentesco:</b>
        <select id="parestencosR2aval3" class="form-control" > </select>
    </div>
    <div class="col-md-2">
        <b>Celular:</b>
        <input type="text" id="celularR2aval3" oninput="formatoTelefono(this)" class="form-control" maxlength="9"  >
    </div>
    <div class="col-md-5">
        <b>Dirección Completa:</b>
        <input type="text" id="direccionR2aval3" class="form-control" maxlength="120" style="text-transform:uppercase;" onblur="CambiarMayuscula(this);"  onkeyup="espacios(this);" >
    </div>
    <div class="col-md-12 mb-3">
        
    </div>
    
    <b><center>REFERENCIAS COMERCIALES</center></b>
    <br>
    <div class="col-md-12">
        <div class="col-md-2">
        </div>

        <div class="col-md-3">
            <b>1. Nombre:</b>
            <input type="text" id="nombreComercial1AVAL3" class="form-control" style="text-transform:uppercase;" onblur="CambiarMayuscula(this);"  onkeyup="espacios(this);" maxlength="120" >
        </div>
        <div class="col-md-5">
            <b>Dirección</b>
            <input type="text" id="direccionComercial1AVAL3" class="form-control" style="text-transform:uppercase;" onblur="CambiarMayuscula(this);"  onkeyup="espacios(this);" maxlength="120" >
        </div>

    </div>

    <div class="col-md-12 mb-2">
        <div class="col-md-2">
        </div>
        <div class="col-md-3">
            <b>2. Nombre:</b>
            <input type="text" id="nombreComercial2AVAL3" class="form-control" style="text-transform:uppercase;" onblur="CambiarMayuscula(this);"  onkeyup="espacios(this);" maxlength="120" >
        </div>
        <div class="col-md-5">
            <b>Dirección</b>
            <input type="text" id="direccionComercial2AVAL3" class="form-control" style="text-transform:uppercase;" onblur="CambiarMayuscula(this);"  onkeyup="espacios(this);" maxlength="120" >
        </div>
    </div>
    <div class="col-md-9">
    
        <b>OBSERVACIONES:</b>
        <input type="text" id="observaciones_edit3" class="form-control" style="text-transform:uppercase;" onblur="CambiarMayuscula(this);"  onkeyup="espacios(this);" maxlength="120">
    </div>
    <div class="button-container">

</div>
    
</div> <!-- div del row-->
<br><button type="button" class="btn btn-success" style="float: left;" onclick="prevStep(4)">Anterior</button>
<button type="button" class="btn btn-success" style="float: right;" onclick="nextStep(4)">Siguiente</button><br>

</div> <!-- final de la clase dic card card --> 