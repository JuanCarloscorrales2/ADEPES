<!-- ============== | head | =================-->
<?php  
  session_start();

  if(isset($_SESSION ["user"]) ){  //si existe un usuario logeado ingresaraal home
    require "../model/BitacoraModel.php";

    //instancia de la clase rol
    $bitaHome = new Bitacora();  //registra en bitacora el home
    $bitaHome->RegistrarBitacora($_SESSION["user"]["idUsuario"], 4,"Ingreso", "Ingreso al Home Principal del Sistema"); //registro de bitacora
  include "layouts/head.php";  
 ?>
<!--==========================================-->

<!-- =========== | contenido | ===============-->
<div class="app-content content container-fluid"> 
    <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <!--<img src="../pages/fpdf/logo.png" class="rounded mx-auto d-block"alt="">  Imagen en medio -->
        <div class="content-body" >
            <div class="app-content content container-fluid">
              <div class="content-header row">
                <h1 class="content-title"><center><b>Bienvenido al Sistema del Fondo Revolvente (Crédito de Préstamos)</b></center></h1>
              </div>
              <div class="container" style="width: 300px;">
                <div class="row">
                    <div class="col">
                    <div class="card-text" style="width: 20rem;"> <!-- Primer columna con una tarjeta -->
                      <img src="../pages/fpdf/logo.png" class="img-fluid" alt=""> 
                    <div class="card-body" style="width: 300px;">
                      <h5 class="card-title"><center><br><b>FONDO REVOLVENTE</b></center></h5>
                      <p style="text-align: justify;"class="card-text"><font size=4>ADEPES es una asociación de desarrollo económico y social que trabaja en el municipio de Pespire,
                        en el departamento de Choluteca, Honduras.<br>ADEPES, busca fortalecer a las pequeñas empresas,
                        brindando las oportunidades crediticias a productores(as), emprendedores(as), etc.
                        <br>Considerando en el sector informal que no cuentan con estos espacios, por medio un préstamo financiero
                        y así poder innovar en la sostenibilidad, seguimiento y crecimiento de la asociación tanto para los recursos financieros, así como su consolidación y eficacia del programa socio-economico.<br><br></font></p>
                    </div> 
                   
      </div>
    </div>
    <div class="container">
  <div class="row">
    <div class="col align-self-start">
      <div class="table-responsive">
   
      </div>
    </div>
   </div>
   
</div>
    
    </div>
  </div>            
    </div> 
    </div>
        </div>
    </div>
</div>
</div>

<!--==========================================-->

<!-- ========= | scripts robust | ============-->
<?php  include "layouts/main_scripts.php"; ?>
<!--==========================================-->

<!-- ============= | footer | ================-->
<?php  include "layouts/footer.php";  

}else{  //si no existe un usuario que redireccione al login
    header("location:../");
}

?>
<!--==========================================-->


