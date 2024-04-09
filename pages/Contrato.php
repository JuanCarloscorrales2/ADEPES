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


		
</style>

<div class="app-content content container-fluid">
    <div class="content-wrapper">
        <div class="content-body ">
            <section id="basic-form-layouts">
                <div id="steps-container">
                    <div class="step active" onclick="showStep(1)">Contrato de Crédito</div>
                    <div class="step" onclick="showStep(2)">Fianza Solidaria</div>
                    <div class="step" onclick="showStep(3)">Pagaré</div>
                    <div class="step" onclick="showStep(4)">Por Avales</div>
                    <div class="step" onclick="showStep(5)">Emisión de Cheques</div>
                    <div class="step" onclick="showStep(6)">Cuentas</div>
                    <div class="step" onclick="showStep(7)">Adicional</div>
					<button type="button" id="guardarContrato" class="btn btn-info" style="float: right;"  onclick="RegistrarContrato();">Guardar</button>
               
                </div>
				<form id="form">
                    <div class="form-step active" id="step1">
                        <!-- *********************************  Contrato ***************************************** -->
                      
						    <br>
						    <h2><center>Contrato de Préstamos</center> </h2>
                            <div class="col-md-12">
                                <div class="col-md-3">
                                    <b>Fecha de aprobación de contrato:</b>
                                    <input type="date" id="fechaContrato" class="form-control" ><br>
                                </div>
                               
                            </div>
		
						    <textarea id="contratoCredito" cols="40" rows="30"></textarea>
						
						    <br><button type="button" class="btn btn-success" style="float: right;" onclick="nextStep(1)">Siguiente</button><br>

						</div> <!-- final de la clase dic card card -->
						
						
						
                    </div>

<!-- *********************************  Fianza Solidaria ***************************************** -->
                    <div class="form-step" id="step2">
                      <center> <textarea id="fianzaSolidaria" style="width: 1300px; height: 750px;"></textarea> </center>

                    </div>
 <!-- *********************************  Pagare ***************************************** -->
                    <div class="form-step" id="step3">
                        <center>  <textarea id="pagare" style="width: 1300px; height: 750px;"></textarea>  </center>
					    
                
                    </div>
 <!-- *********************************  Por Avales ***************************************** -->
                    <div class="form-step" id="step4">
                        <center><textarea id="porAvales" style="width: 1300px; height: 100;"></textarea> </center>
                    </div>
 <!-- *****************************     Emision de cheques *************************************** -->
                    <div class="form-step" id="step5">
                        <center><textarea id="cheque" style="width: 1300px; height: 750px;"></textarea>  </center>
                    </div>
<!-- *********************************  Cuentas ***************************************** -->
                    <div class="form-step" id="step6">
                        <center><textarea id="cuentas" style="width: 1300px; height: 750px;"></textarea> </center>
                    </div>
	<!-- *********************************  Adicional ***************************************** -->
                    <div class="form-step" id="step7">
                        <center><textarea id="adicional" style="width: 1300px; height: 750px;"></textarea> </center>
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
            if (currentStep < 7) {
                showStep(currentStep + 1);
            }
        }

        function prevStep(currentStep) {
            if (currentStep > 1) {
                showStep(currentStep - 1);
            }
        }
		
        //tiNY para editor de contrato
        //contrato
		tinymce.init({
            selector: '#contratoCredito',
            language: 'es_MX',
            branding: false,
            menubar: true,
            toolbar: 'undo redo | styles forecolor | bold italic | alignleft aligncenter alignright alignjustify | outdent indent | lineheight',
            plugins: 'table',
            
            
        });

        //fianza solidaria
        tinymce.init({
                selector: '#fianzaSolidaria',
                language: 'es_MX',
                branding: false,
                menubar: true,
                toolbar:
                'undo redo | styles forecolor | bold italic | alignleft aligncenter alignright alignjustify |outdent indent | lineheight | table tabledelete',
                plugins: 'table',
        });
         //pagare
         tinymce.init({
                selector: '#pagare',
                language: 'es_MX',
                branding: false,
                menubar: true,
                toolbar:
                'undo redo | styles forecolor | bold italic | alignleft aligncenter alignright alignjustify |outdent indent | lineheight | table tabledelete',
                plugins: 'table',
        });
         //porAvales
         tinymce.init({
                selector: '#porAvales',
                language: 'es_MX',
                branding: false,
                menubar: true,
                toolbar:
                'undo redo | styles forecolor | bold italic | alignleft aligncenter alignright alignjustify |outdent indent | lineheight | table tabledelete',
                plugins: 'table',
        });
         //Emison de cheques
         tinymce.init({
                selector: '#cheque',
                language: 'es_MX',
                branding: false,
                menubar: true,
                toolbar:
                'undo redo | styles forecolor | bold italic | alignleft aligncenter alignright alignjustify |outdent indent | lineheight | table tabledelete',
                plugins: 'table',
        });
         //cuentas
         tinymce.init({
                selector: '#cuentas',
                language: 'es_MX',
                branding: false,
                menubar: true,
                toolbar:
                'undo redo | styles forecolor | bold italic | alignleft aligncenter alignright alignjustify |outdent indent | lineheight | table tabledelete',
                plugins: 'table',
        });
         //adicional
         tinymce.init({
                selector: '#adicional',
                language: 'es_MX',
                branding: false,
                menubar: true,
                toolbar:
                'undo redo | styles forecolor | bold italic | alignleft aligncenter alignright alignjustify |outdent indent | lineheight | table tabledelete',
                plugins: 'table',
        });


        
    </script>
  
<!-- ========= | scripts robust | ============-->
<?php  include "layouts/main_scripts.php"; ?>


<!-- Advertencias Toastr -->
<script src="../app-assets/plugins/toastr/toastr.min.js">  </script>
<!-- obtencion de los datos por javascript -->
<script src="../assets/js/Contrato.js"></script>


<!--Solicitudes jS -->



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