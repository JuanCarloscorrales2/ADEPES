<!-- ============== | head | =================-->
<?php  
session_start();

if(isset($_SESSION["user"])){
	$idUsuario=$_SESSION["user"]["idUsuario"];
	$Usuario=$_SESSION["user"]["Usuario"];
	$Nombre=$_SESSION["user"]["NombreUsuario"];
	$Correo=$_SESSION["user"]["CorreoElectronico"];

include "layouts/head.php"; ?>
<!--==========================================-->


<!-- =========== | contenido | ===============-->
<div class="app-content content container-fluid">
	<div class="content-wrapper">
		<div class="content-header row">
			<div class="content-header-left col-md-6 col-xs-12 mb-1">
				<h4 class="content-header-title">EDITAR PERFIL</h4>
			</div>
			<div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-xs-12">
				<div class="breadcrumb-wrapper col-xs-12">
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="welcome.php">Home</a></li>
					</ol>
				</div>
			</div>
		</div>
		<div class="content-body" >
			<section id="basic-form-layouts">
				<div class="row match-height">
					<div class="col-md-12">
						<div class="card">
							<div class="card-header">
								<h5 class="card-title" id="basic-layout-form">
                                <span class="avatar "><img src="../app-assets/images/perfil.png" alt="avatar"><i></i></span><span class="user-name">  <?php echo $_SESSION["user"]["NombreUsuario"]; ?> </span></a>
								</h5>
								<a class="heading-elements-toggle"><i class="icon-ellipsis font-medium-3"></i></a>
								<div class="heading-elements">
									<ul class="list-inline mb-0">
										<li><a data-action="collapse"><i class="icon-minus4"></i></a></li>
										<li><a data-action="expand"><i class="icon-expand2"></i></a></li>
									</ul>
								</div>
							</div>
                            <br>
                            <div class="col-md-4">
                                            <div class="tile ">
                                                <ul class="nav flex-column nav-tabs user-tabs">
                                                <li class="nav-item"><a class="nav-link active" href="perfilUser.php">Editar Perfil</a></li>
                                                <li class="nav-item"><a class="nav-link" href="cambiarClave.php" >Cambiar Contraseña</a></li>
                                                </ul>
                                            </div>
                            </div>
                                            <br><br>
							<div class="card-body collapse in">
								<div class="card-block">
									<div class="table-responsive">
                                    <h5>DATOS PERSONALES   <a class="btn btn-sm btn-warning" data-toggle="modal" data-target="#ActualizarPerfil" ><i class="icon-edit"></i> Editar </a> 
                                    </h5>
                                    <table id="tabla_clientes" class="table table-bordered table-sm">
									<tr>
                                        <th width="40">USUARIO:</th>
                                        <td width="20"><?php echo $Usuario?></td>
                                    </tr>
                                    <tr>
                                        <th width="40">NOMBRE COMPLETO:</th>
                                        <td width="20"><?php  echo $Nombre?></td>
                                    </tr>
                                    <tr>
                                        <th width="40">CORREO ELECTRÓNICO:</th>
                                        <td width="20"><?php echo  $Correo ?></td>
                                    </tr>
                                    </table>
                                    
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

<!-- ========= | scripts robust | ============-->
<?php  include "layouts/main_scripts.php"; ?>
<?php  include "Modals/Actualizar/ActualizarPerfil.php"; ?>

<!-- Advertencias Toastr -->
<script src="../app-assets/plugins/toastr/toastr.min.js">  </script> 


<!--=================  Plugins datatable.net para las tablas====================-->
<link href="https://cdn.datatables.net/v/dt/dt-1.13.4/datatables.min.css" rel="stylesheet"/>
<script src="https://cdn.datatables.net/v/dt/dt-1.13.4/datatables.min.js"></script>
<!-- referencias para las alertas -->
<!-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!--clientes jS -->
<script src="../assets/js/perfil.js"></script>
<!-- ============= | footer | ================-->
<?php  include "layouts/footer.php";  
  }
  else {
	  header("location:../");
  }
?>
<!--==========================================-->