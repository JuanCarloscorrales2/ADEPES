<!-- ============== | head | =================-->
<?php  
//session_start();
 ?>
<!--==========================================-->
<div class="modal fade" id="MostrarAvales" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">   <strong> <center>Listado de Avales</center> </strong>   </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
		<section id="basic-form-layouts">
                <div class="row match-height">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title" id="basic-layout-form">
                                    <button class="btn  btn-success" onclick="location.href='../pages/nuevaSolicitud.php';" >+ Nuevo</button>
                                    <button id="boton_descargar_pdf" class="btn  btn-danger"> <i class="fas icon-file-pdf"></i> Descargar Listado</button>
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
                                    <table id="tabla_clientes" class="table table-bordered table-sm">
                                            <thead>
                                                <tr>
                                                    <th width="">Noº Solicitud</th>
                                                    <th width="">Nombre Completo</th>
                                                    <th width="">Número de Identidad</th>
                                                    <th width="">Contacto</th>
                                                    <th width="">Dirección</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <td><?php  echo  $_SESSION["Cliente"]["idSolicitud"];?></td>
                                                
                                                
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th width="">Noº Solicitud</th>
                                                    <th width="">Nombre Completo</th>
                                                    <th width="">Número de Identidad</th>
                                                    <th width="">Contacto</th>
                                                    <th width="">Dirección</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
