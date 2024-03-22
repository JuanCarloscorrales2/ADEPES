

<div class="modal fade" id="planModal" tabindex="-1" role="dialog" aria-labelledby="planModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document"> <!-- Set modal-xl for extra large width -->
            <div class="modal-content">
                <div class="modal-header">
                   
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                   
                </div>
                <form method="post" action="../pages/fpdf/PlanPagos.php" id="loanForm">
                <h5 class="modal-title" id="planModalLabel"><center>Plan de Pago Cuota Nivelada</center></h5>
					
					<input type="hidden" id="tipogarantiaR" name="tipogarantiaR" requerid>
					
					<input type="hidden" id="montoR" name="montoR"  >	
				
					<input type="hidden" id="plazoR" name="plazoR">
							
					<input type="hidden" id="fechaEmisionR" name="fechaEmisionR">
					
					<button type="submit" class="btn btn-danger"><span class="icon-file-pdf" aria-hidden="true"></span></button>
                    
                        
                    </from>
                <div class="modal-body" id="planModalBody"></div>
                
            </div>
        </div>
    </div>