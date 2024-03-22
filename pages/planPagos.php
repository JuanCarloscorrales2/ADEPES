
<div class="modal fade" id="planPagos" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title" id="exampleModalLabel"> <strong> <center>Plan de Pagos</center> </strong>   </h3>
        <br>
        
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">

          <span aria-hidden="true">&times;</span>
        </button>

        <strong> Nº Préstamo:</strong>
        <input type="number" class="form_control" style="border: 0;" id="idprestamo" readonly>
        <br>
        <strong> Cliente:</strong>
        <input type="text" class="form_control" style="border: 0;" id="nombre" readonly >
        <br>
      </div>
      
      <div class="modal-body">

        <strong>Monto del Préstamo:</strong> 
        <input type="number" style="border: 0;" id="prestamo" name="prestamo" readonly>
        <br>
        <strong>Plazo en Meses: </strong>
        <input type="number" style="border: 0;" id="plazo" name="plazo" readonly>
        <br>
        <strong>Tasa de Interés Anual: </strong>
        <input type="text" style="border: 0;"  id="tasa" name="tasa" readonly >
        <br>
        <strong>Fecha de Emisión: </strong>
        <input type="text" style="border: 0;" id="fecha" name="fecha"  readonly>
        <br>
        <strong>Cuota Mensual: </strong>
        <input type="text" style="border: 0;" id="cuota" readonly>
        
        <button id="boton_descargar_plan_pdf" class="btn  btn-danger" onclick ="PlanPagosPDF();" style ="float: right;"> <i class="fas icon-file-pdf"></i> PDF </button>
        <br>
        <br>
        <div id="modalContent"></div>

    <table class="table table-bordered " id="tabla_plan_pagos">
            <tr>
                <th width="10%">Nº cuota</th>
                <th width="20%">Fecha Pago</th>
                <th>Valor Cuota</th>
                <th>Valor Interés</th>
                <th>Valor Capital</th>
                <th>Saldo Capital</th>
                <th>Estado</th>
            </tr>
            <tr>
                
            </tr>
            
        </table> 
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<script src="../assets/js/clientes.js"></script>
<script src="../assets/js/generarPlanPDF.js"></script>