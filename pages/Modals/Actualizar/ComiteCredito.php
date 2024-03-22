<div class="modal fade" id="comiteCredito" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">   <strong> <center><h4>COMITÉ DE CRÉDITO</h4></center></strong>   </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
          <div class="section">
              <center><h5>PROYECTO FONDO ROTATORIO</h5></center>

              <!-- input en el va oculto el SOLICITUD para actualizarlo -->
             <input type="hidden"  class="form-control" id="idSoli" >

               <center><h4>Resolución</h4></center>
                
                <div class="col-md-12">

                  <div class="col-md-4"> </div>

                  <div class="col-md-4">
                    <b>NO. DE ACTA:</b>
                    <input type="number" id="numeroActa" class="form-control">
                  </div>

                  <div class="col-md-4"> </div>

                </div>
              
                <b>NOMBRE:</b>
                <input type="text" id="nombreComite" class="form-control" readonly>

                <div class="col-md-12">

                  <div class="col-md-6">
                    <b>MONTO:</b>
                    <input type="text" id="montoComite" class="form-control" readonly>
                  </div>

                  <div class="col-md-6">
                    <b>PLAZO:</b>
                    <input type="text" id="plazoComite" class="form-control" readonly>
                  </div>
                </div>
               
                <br>
                <b>GARANTÍA:</b>
                <input type="text" id="prestamoComite" class="form-control" readonly>
                <br>
                <b>DESTINO:</b>
                <input type="text" id="invierteEn" class="form-control" readonly>
                <br>
                <b>SELECCIONE UNA OPCIÓN:</b>
                <select id="estado" class="form-control" >	
                  <option value="">SELECCIONE..</option>
                  <option value="1">APROBADO</option>
                  <option value="2">DENEGADO</option>
                </select>
    
             
          </div>
             
          
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-success" onclick="AlertaAprobarSolicitud()" >Guardar</button>
      </div>
    </div>
  </div>
</div>
