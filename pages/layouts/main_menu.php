<!-- main menu-->
<div data-scroll-to-active="true" class="main-menu menu-fixed menu-dark menu-accordion menu-shadow">

      <div class="main-menu-header">
        <div class="media">
          <div class="media-left">
              <span class="avatar avatar-sm avatar-online rounded-circle"> 
                <img src="../app-assets/images/perfil.png"><i></i>
              </span>
                    
          </div>
          <div class="media-body">
              <h6 class="media-heading"> <?php echo $_SESSION["user"]["Usuario"]; ?></h6>
              <p class="notification-text font-small-3 text-muted"> <?php echo $_SESSION["user"]["CorreoElectronico"]; ?></p>
                    
          </div>
                   
        </div>
      </div>

      <div class="main-menu-content">
        <ul id="main-menu-navigation" data-menu="menu-navigation" class="navigation navigation-main">


          <li class=" nav-item"><a href="welcome.php"><i class="icon-home3"></i><span class="menu-title">Home</span></a>
          <!--</li>
          <li class=" nav-item"><a href="#"><i class="icon-gears"></i><span class="menu-title">Configuración</span></a>
          </li>-->
          
          <li class=" nav-item"><a href="#"><i class="icon-file"></i><span  class="menu-title">Solicitudes de Crédito</span></a>
            <ul class="menu-content">
               <li><a href="../pages/solicitudes.php" class="menu-item">Solicitudes</a></li>
            </ul>
          </li>
          
          <li class=" nav-item"><a href="#"><i class="icon-folder-open"></i><span class="menu-title">Gestión de Clientes</span></a>
            <ul class="menu-content">
              <li><a href="../pages/clientes.php" class="menu-item">Clientes</a></li>
            </ul>
          </li>
          <li class=" nav-item"><a href="#"><i class="icon-folder-open"></i><span class="menu-title">Gestión de Préstamos</span></a>
            <ul class="menu-content">
              <li><a href="../pages/vistaPrestamos.php" class="menu-item">Préstamos</a></li>
            </ul>
          </li>
          <li class=" nav-item"><a href="#"><i class="icon-usd"></i><span class="menu-title">Gestión de Cobros</span></a>
            <ul class="menu-content">
              <li><a href="../pages/cobros.php" class="menu-item">Cobro</a></li>
            </ul>
          </li>
          
          <li class=" nav-item"><a href="#"><i class="icon-unlock-alt"></i><span class="menu-title">Seguridad</span></a>
            <ul class="menu-content">
              <li><a href="../pages/roles.php" class="icon-group"> Roles</a></li>
              <li><a href="../pages/Permisos.php" class="icon-edit"> Permisos</a></li>
              <li><a href="../pages/Parametros.php" class="icon-file"> Parámetros</a></li>
              <li><a href="../pages/Preguntas.php" class="icon-question"> Preguntas de Seguridad</a></li>
            </ul>
          </li>

          <li class=" nav-item"><a href="#"><i class="icon-wrench"></i><span class="menu-title">Administración</span></a>
            <ul class="menu-content">
            <li><a href="../pages/usuarios.php" class="icon-group"> Usuarios</a></li>
              <li><a href="../pages/bitacora.php" class="icon-edit"> Bitácora</a></li>
            </ul>
          </li>

          <li class=" nav-item"><a href="#"><i class="icon-wrench"></i><span class="menu-title">Mantenimiento</span></a>
            <ul class="menu-content">
              <li><a href="../pages/TBLPrestamo.php" class="icon-table">  Tipo Prestamo</a></li>
              <li><a href="../pages/TBLEstadoCivil.php" class="icon-table">  Estado Civil</a></li>
              <li><a href="../pages/TBLCategoriaCasa.php" class="icon-table">  Categoría Casa</a></li>
              <li><a href="../pages/TBLParentesco.php" class="icon-table">  Parentesco</a></li>
              <li><a href="../pages/TBLGenero.php" class="icon-table">  Género</a></li>
              <li><a href="../pages/TBLContacto.php" class="icon-table">  Tipo Contacto</a></li>
              <li><a href="../pages/TBLNacionalidad.php" class="icon-table">  Nacionalidad</a></li>
              <li><a href="../pages/TBLPBienes.php" class="icon-table">  Personas Bienes</a></li>
              <li><a href="../pages/TBLTLaboral.php" class="icon-table">  Tiempo laboral</a></li>
              <li><a href="../pages/TBLPlanpago.php" class="icon-table"> Estado Plan de Pago</a></li>
              <li><a href="../pages/TBLTvivir.php" class="icon-table">  Tiempo vivir</a></li>
              <li><a href="../pages/TBLEPrestamo.php" class="icon-table">  Estado Tipo Prestamo</a></li>
              <li><a href="../pages/TBLESolicitud.php" class="icon-table">  Estado Solicitudes</a></li>
              <li><a href="../pages/TBLRubros.php" class="icon-table">  Rubros</a></li>
              <li><a href="../pages/TBLProfesion.php" class="icon-table">  Profesión u Oficio</a></li>
              <li><a href="../pages/TBLestadoUser.php" class="icon-table">  Estado Usuario</a></li>
              <li><a href="../pages/TBLMunicipio.php" class="icon-table">  Municipio</a></li>
              <li><a href="../pages/TBLTipoPago.php" class="icon-table"> Tipos de Pagos</a></li>
              <li><a href="../pages/TBLTipoCliente.php" class="icon-table"> Tipo Cliente</a></li>
              <li><a href="../pages/TBLEstadoCredito.php" class="icon-table"> Estado de Crédito</a></li>
              <li><a href="../pages/TBLAnalisisCrediticio.php" class="icon-table"> Análisis Crediticio</a></li>
            </ul>
          </li>

         <!-- <li class=" navigation-header"><span>Informes</span>
          </li>
          <li class=" nav-item"><a href="#"><i class="icon-file-text2"></i><span class="menu-title">Reportes </span></a>
          </li>
          <li class=" nav-item"><a href="#"><i class="icon-stats-dots"></i><span  class="menu-title">Gráficas</span></a>
          </li>-->
          <li class=" navigation-header"><span>Soporte</span>
          </li>
          <li class=" nav-item"><a href="../pages/backup.php"><i class="icon-database2"></i><span  class="menu-title">Backup</span></a>
          </li>
        </ul>
      </div>

</div>
<!-- / main menu-->