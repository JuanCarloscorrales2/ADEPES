<?php

require('./fpdf.php');
// Establecer la zona horaria de Honduras
date_default_timezone_set('America/Tegucigalpa');
require "../../config/Conexion.php";

if ( isset($_GET['idSolicitud']) && isset($_GET['idPersona']) ) {
   
    $idSolicitud = $_GET['idSolicitud'];
    $idPersona = $_GET['idPersona'];
    try {
        $cnx = Conexion::ConectarDB(); // Llamamos al método estático para obtener la conexión
    
        //consulta SQL
        $consulta = $cnx->prepare("
        SELECT solicitud.idSolicitud, persona.nombres, persona.apellidos, rubro.Descripcion as rubro, prestamo.Descripcion as Prestamo, solicitud.invierteEn,
        solicitud.Monto, solicitud.Plazo, solicitud.tasa, estado.Descripcion as estadoSolicitud, usuario.NombreUsuario,
        solicitud.fechaDesembolso, solicitud.invierteEn, solicitud.dictamenAsesor, solicitud.prestamoAprobados, solicitud.numeroActa,
        persona.identidad, persona.fechaNacimiento, TIMESTAMPDIFF(YEAR, persona.fechaNacimiento, CURDATE()) AS edad, persona.PratronoNegocio,
        persona.CargoDesempena, persona.ObservacionesSolicitud, depen.nombre as dependiente
      
            FROM tbl_mn_solicitudes_creditos solicitud
            INNER JOIN  tbl_mn_personas persona ON solicitud.idPersona = persona.idPersona
            INNER JOIN tbl_mn_estados_solicitudes estado ON solicitud.idEstadoSolicitud = estado.idEstadoSolicitud
            INNER JOIN tbl_mn_tipos_prestamos prestamo ON solicitud.idTipoPrestamo = prestamo.idTipoPrestamo
            INNER JOIN tbl_ms_usuario usuario ON solicitud.idUsuario = usuario.idUsuario
            INNER JOIN tbl_mn_rubros rubro ON solicitud.idRubro = rubro.idRubro
            INNER JOIN tbl_mn_personas_dependientes depen ON solicitud.idPersona = depen.idPersona
            WHERE solicitud.idSolicitud = :idSolicitud
        ");
    
        // Asignar el valor del parámetro
        $consulta->bindParam(':idSolicitud', $idSolicitud);
    
        // Ejecutar la consulta preparada
        $consulta->execute();
        $datosSolicitud = $consulta->fetch(PDO::FETCH_ASSOC); // Almacena los datos de la solicitud en un array asociativo
       
        //Calculo de interese y cuota
        $tasaMensual = $datosSolicitud['tasa'] / 12 / 100; // Convertir tasa anual a mensual y a decimal
        $denominador = pow(1 + $tasaMensual,  $datosSolicitud['Plazo']) - 1;
        $cuota = ($datosSolicitud['Monto'] * $tasaMensual * pow(1 + $tasaMensual, $datosSolicitud['Plazo'])) / $denominador;

        $interesCorrienteMensual = $datosSolicitud['Monto'] * (($datosSolicitud['tasa'] / 100) / 12 / 30 * 31);
        $cuota = round($cuota * 100) / 100;
        $interesCorrienteMensual = round($interesCorrienteMensual * 100) / 100;
        // Letra mensual
        $letraMensual =round(($cuota - $interesCorrienteMensual),2);
        

        function datosPersona($idPersona, $cnx){ //funcion de datos de personas
            $consultaPersona = $cnx->prepare("
            SELECT nacio.Descripcion AS nacionalidad, genero.Descripcion AS genero, civil.Descripcion AS estadoCivil,
            profe.Descripcion AS profesion, bienes.Descripcion AS bienes, cliente.Descripcion AS tipoCliente,
            casa.Descripcion AS categoriaCasa, tiempo.descripcion AS tiempoVivir, tipopago.descripcion AS tipoPago,
            laboral.descripcion AS tiempoLaboral, credito.Descripcion AS estadoCredito, esaval.Descripcion AS esAval,
            creditoaval.Descripcion AS creditoAval, municipio.Descripcion AS municipio, CONCAT(persona.nombres,' ',persona.apellidos) AS nombres,
            persona.identidad, persona.fechaNacimiento, TIMESTAMPDIFF(YEAR, persona.fechaNacimiento, CURDATE()) AS edad, 
            persona.PratronoNegocio, persona.cargoDesempena, persona.ObservacionesSolicitud, conyugue.idPersona AS idConyuge,
            cuenta.NumeroCuenta
            FROM tbl_mn_personas persona
            LEFT JOIN tbl_mn_nacionalidades nacio ON persona.idNacionalidad = nacio.idNacionalidad
            LEFT JOIN tbl_mn_genero genero ON persona.idGenero = genero.idGenero
            LEFT JOIN tbl_mn_estadocivil civil ON persona.idEstadoCivil = civil.idEstadoCivil
            LEFT JOIN tbl_mn_profesiones_oficios profe ON persona.idProfesion = profe.idProfesion
            LEFT JOIN tbl_mn_personas_bienes bienes ON persona.idPersonaBienes = bienes.idPersonaBienes
            LEFT JOIN tbl_mn_tipo_clientes cliente ON persona.idTipoClientes = cliente.idTipoCliente
            LEFT JOIN tbl_mn_categoria_casa casa ON persona.idCategoriaCasa = casa.idCategoriaCasa
            LEFT JOIN tbl_mn_tiempo_vivir tiempo ON persona.idTiempoVivir = tiempo.idtiempoVivir 
            LEFT JOIN tbl_mn_tipos_de_pago tipopago ON persona.PagaAlquiler = tipopago.idTipoPago
            LEFT JOIN tbl_mn_tiempo_laboral laboral ON persona.idTiempoLaboral = laboral.idTiempoLaboral
            LEFT JOIN tbl_mn_estado_credito credito ON persona.estadoCredito = credito.idEstadoCredito
            LEFT JOIN tbl_mn_avala_a_persona esaval ON persona.esAval = esaval.idEsAval
            LEFT JOIN tbl_mn_credito_aval creditoaval ON persona.avalMora = creditoaval.idCreditoAval
            LEFT JOIN tbl_mn_municipio municipio ON persona.idMunicipio = municipio.idMunicipio
            LEFT JOIN tbl_mn_conyugues conyugue ON persona.idPersona = conyugue.idPersonaPareja
            LEFT JOIN tbl_mn_personas_cuenta cuenta ON persona.idPersona = cuenta.idPersona
            WHERE persona.idPersona = :idPersona
            
          ");
    
        // Asignar el valor del parámetro
            $consultaPersona->bindParam(':idPersona', $idPersona);
        
            // Ejecutar la consulta preparada
            $consultaPersona->execute();
            $datosPersona = $consultaPersona->fetch(PDO::FETCH_ASSOC); // Almacena los datos de la solicitud en un array asociativo
        
            return $datosPersona; //retorna los datos de las personas
        }

        //funcion de contactos de personas
        function ContactoPersona($idPersona, $cnx){
            $consultaContactos = $cnx->prepare("
            SELECT valor FROM tbl_mn_personas_contacto WHERE idPersona = :idPersona
            
          ");
    
        // Asignar el valor del parámetro
            $consultaContactos->bindParam(':idPersona', $idPersona);
        
            // Ejecutar la consulta preparada
            $consultaContactos->execute();
            $datos = $consultaContactos->fetchAll(PDO::FETCH_ASSOC); // Obtener la lista de datos
        
            return $datos; //retorna los datos de las personas
        }

        //funcion para traer datos del analisis crediticio
        function datosAnalisis($idPersona, $cnx){ //funcion de datos de personas
            $consultaAnalisis = $cnx->prepare("
            SELECT sueldoBase, ingresosNegocio, rentaPropiedad, remesas, aporteConyugue, ingresosSociedad,
            SUM(sueldoBase + ingresosNegocio + rentaPropiedad + remesas + aporteConyugue + ingresosSociedad) AS totalIngresos,
            cuotaPrestamoAdepes, cuotaVivienda, alimentacion, deduccionesCentralRiesgo, otrosEgresos,
            SUM(cuotaPrestamoAdepes + cuotaVivienda + alimentacion + deduccionesCentralRiesgo + otrosEgresos) AS totalEgresos,
            SUM((sueldoBase + ingresosNegocio + rentaPropiedad + remesas + aporteConyugue + ingresosSociedad)-
            (cuotaPrestamoAdepes + cuotaVivienda + alimentacion + deduccionesCentralRiesgo + otrosEgresos)) AS totalNetos,
            LiquidezCliente, Descripcion
            FROM tbl_mn_analisis_crediticio 
            WHERE idPersona = :idPersona
            
          ");
    
        // Asignar el valor del parámetro
            $consultaAnalisis->bindParam(':idPersona', $idPersona);
        
            // Ejecutar la consulta preparada
            $consultaAnalisis->execute();
            $datos = $consultaAnalisis->fetch(PDO::FETCH_ASSOC); // Almacena los datos de la solicitud en un array asociativo
        
            return $datos; //retorna los datos de las personas
        }

        //funcion para traer datos del analisis crediticio de parejas
        function datosAnalisisPareja($idPersona, $cnx){ //funcion de datos de personas
            $consultaAnalisisPareja = $cnx->prepare("
            SELECT ingresosNegocio, sueldoBase, gastoAlimentacion FROM tbl_mn_conyugues 
            WHERE idPersona = :idPersona
            
          ");
    
        // Asignar el valor del parámetro
            $consultaAnalisisPareja->bindParam(':idPersona', $idPersona);
        
            // Ejecutar la consulta preparada
            $consultaAnalisisPareja->execute();
            $datos = $consultaAnalisisPareja->fetch(PDO::FETCH_ASSOC); // Almacena los datos de la solicitud en un array asociativo
        
            return $datos; //retorna los datos de las personas
        }

        //funcion para traer referencias familiares
        function referenciasFamiliares($idPersona, $cnx){
            $consulta = $cnx->prepare("
            SELECT refe.nombre, paren.descripcion, refe.celular, refe.direccion FROM tbl_mn_referencias_familiares refe
            INNER JOIN tbl_mn_parentesco paren ON paren.idParentesco = refe.idParentesco
            WHERE refe.idPersona = :idPersona
            
          ");
    
        // Asignar el valor del parámetro
            $consulta->bindParam(':idPersona', $idPersona);
        
            // Ejecutar la consulta preparada
            $consulta->execute();
            $datos = $consulta->fetchAll(PDO::FETCH_ASSOC); // Obtener la lista de datos
        
            return $datos; //retorna los datos de las personas
        }

          //funcion para traer idPersonas de avales
          function idAvales($idSolicitud, $cnx){
            $consulta = $cnx->prepare("
                SELECT idPersona FROM tbl_mn_avales WHERE idSolicitud = :idSolicitud
                
            ");
        
            // Asignar el valor del parámetro
                $consulta->bindParam(':idSolicitud', $idSolicitud);
            
                // Ejecutar la consulta preparada
                $consulta->execute();
                $datos = $consulta->fetchAll(PDO::FETCH_ASSOC); // Obtener la lista de datos
            
                return $datos; //retorna los datos de las personas
            }

        //funcion para traer referencias comerciales de avales
        function referenciasComerciales($idPersona, $cnx){
            $consulta = $cnx->prepare("
            SELECT nombre, direccion FROM tbl_mn_referencias_comerciales WHERE idPersona = :idPersona
            
          ");
    
        // Asignar el valor del parámetro
            $consulta->bindParam(':idPersona', $idPersona);
        
            // Ejecutar la consulta preparada
            $consulta->execute();
            $datos = $consulta->fetchAll(PDO::FETCH_ASSOC); // Obtener la lista de datos
        
            return $datos; //retorna los datos de las personas
        }

        //funcion para traer datos del analisis crediticio de parejas
        function dictamenAsesor($idPersona, $cnx){ //funcion de datos de personas
            $consulta = $cnx->prepare("
            SELECT CONCAT('SOLICITANTE: ',persona.nombres,' ', persona.apellidos, ' SUS INGRESOS LOS OBTIENE POR ',persona.PratronoNegocio, ', ACTUALMENTE SE DEDICA COMO ',persona.cargoDesempena, ', EL TIPO DE CRÉDITO ES '
            ,cliente.Descripcion,' ',avala.Descripcion,', ',mora.Descripcion, ', EN RELACIÓN A LOS INGRESOS, EL ',analisis.Descripcion
            ,' LA FINALIDAD DEL CRÉDITO ES PARA, ',soli.invierteEn,' LA MODALIDAD DE PAGO ES POR CUOTA NIVELADA, OFRECIENDO UNA GARANTÍA '
            ,' ',prestamo.Descripcion) AS dictamen, soli.prestamoAprobados, soli.numeroActa, estadoSoli.Descripcion
            FROM tbl_mn_personas persona
            INNER JOIN tbl_mn_tipo_clientes cliente ON persona.estadoCredito = cliente.idTipoCliente
            INNER JOIN tbl_mn_avala_a_persona avala ON persona.esAval = avala.idEsAval
            INNER JOIN tbl_mn_credito_aval mora ON persona.avalMora = mora.idCreditoAval
            INNER JOIN tbl_mn_analisis_crediticio analisis ON persona.idPersona = analisis.idPersona
            INNER JOIN tbl_mn_solicitudes_creditos soli ON soli.idPersona = persona.idPersona
            INNER JOIN tbl_mn_estados_solicitudes estadoSoli ON soli.idEstadoSolicitud = estadoSoli.idEstadoSolicitud
            INNER JOIN tbl_mn_tipos_prestamos prestamo ON prestamo.idTipoPrestamo = soli.idTipoPrestamo
            WHERE persona.idPersona = :idPersona
            
          ");
    
        // Asignar el valor del parámetro
            $consulta->bindParam(':idPersona', $idPersona);
        
            // Ejecutar la consulta preparada
            $consulta->execute();
            $datos = $consulta->fetch(PDO::FETCH_ASSOC); // Almacena los datos de la solicitud en un array asociativo
        
            return $datos; //retorna los datos de las personas
        }
      
    } catch (PDOException $ex) {
        die($ex->getMessage());
    }
}


class PDF extends FPDF
{
        
   // Pie de página
   function Footer()
   {
      $this->SetY(-15); // Posición: a 1,5 cm del final
      $this->SetFont('Arial', 'I', 7); //tipo fuente, negrita(B-I-U-BIU), tamañoTexto
      $this->Cell(0, 10, utf8_decode('Página ') . $this->PageNo() . '/{nb}', 0, 0, 'C'); //pie de pagina(numero de pagina)
       //fecha
       $this->SetY(-15); // Posición: a 1,5 cm del final
      $this->SetFont('Arial', 'I', 7); //tipo fuente, negrita(B-I-U-BIU), tamañoTexto
      $hoy = date('d/m/Y H:i:s');
      $this->Cell(320, 10, utf8_decode('  Fecha y Hora de impresión:'.$hoy), 0, 0, 'C');
      
   }

   /******************************* METODO PARA AJUSTAR CELDAS ********************************** */
   protected $widths;
   protected $aligns;

   function SetWidths($w)
   {
       // Set the array of column widths
       $this->widths = $w;
   }

   function SetAligns($a)
   {
       // Set the array of column alignments
       $this->aligns = $a;
   }

   function Row($data)
   {
       // Calculate the height of the row
       $nb = 0;
       for($i=0;$i<count($data);$i++)
           $nb = max($nb,$this->NbLines($this->widths[$i],$data[$i]));
       $h = 5*$nb;
       // Issue a page break first if needed
       $this->CheckPageBreak($h);
       // Draw the cells of the row
       for($i=0;$i<count($data);$i++)
       {
           $w = $this->widths[$i];
           $a = isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
           // Save the current position
           $x = $this->GetX();
           $y = $this->GetY();
           // Draw the border
           $this->Rect($x,$y,$w,$h);
           // Print the text
           $this->MultiCell($w,5,$data[$i],0,$a);
           // Put the position to the right of the cell
           $this->SetXY($x+$w,$y);
       }
       // Go to the next line
       $this->Ln($h);
   }

   function CheckPageBreak($h)
   {
       // If the height h would cause an overflow, add a new page immediately
       if($this->GetY()+$h>$this->PageBreakTrigger)
           $this->AddPage($this->CurOrientation);
   }

   function NbLines($w, $txt)
   {
       // Compute the number of lines a MultiCell of width w will take
       if(!isset($this->CurrentFont))
           $this->Error('No font has been set');
       $cw = $this->CurrentFont['cw'];
       if($w==0)
           $w = $this->w-$this->rMargin-$this->x;
       $wmax = ($w-2*$this->cMargin)*1000/$this->FontSize;
       $s = str_replace("\r",'',(string)$txt);
       $nb = strlen($s);
       if($nb>0 && $s[$nb-1]=="\n")
           $nb--;
       $sep = -1;
       $i = 0;
       $j = 0;
       $l = 0;
       $nl = 1;
       while($i<$nb)
       {
           $c = $s[$i];
           if($c=="\n")
           {
               $i++;
               $sep = -1;
               $j = $i;
               $l = 0;
               $nl++;
               continue;
           }
           if($c==' ')
               $sep = $i;
           $l += $cw[$c];
           if($l>$wmax)
           {
               if($sep==-1)
               {
                   if($i==$j)
                       $i++;
               }
               else
                   $i = $sep+1;
               $sep = -1;
               $j = $i;
               $l = 0;
               $nl++;
           }
           else
               $i++;
       }
       return $nl;
   } // FIN DEL METODO AJUSTAR CELDAS
  
} //FIN DE LA CLASE FPDF


$pdf = new PDF();
$datosCliente = datosPersona($idPersona, $cnx);//funcion para traer Datos
$datosContactos = ContactoPersona($idPersona, $cnx); //trae datos de contactos
$datosAnalisis = datosAnalisis($idPersona, $cnx); //analisis crediticio
$dictamen = dictamenAsesor($idPersona, $cnx);
/***************************************    DICTAMEN DE ASESOR ******************************************* */
$pdf->AddPage("portrait", "letter"); 
$pdf->AliasNbPages(); //agrega la pagina / y total de paginas

//$pdf->Cell(45); // Movernos a la derecha
///encabezado
$pdf->SetFont('Arial', 'B', 14); //tipo fuente, negrita(B-I-U-BIU), tamañoTexto
$pdf->SetFillColor(143,188,143); //colorFondo verde
$pdf->Cell(195, 10, utf8_decode('ASOCIACIÓN DE DESARROLLO PESPIRENSE'), 0, 1, 'C', 1); // AnchoCelda,AltoCelda,titulo,borde(1-0),saltoLinea(1-0),posicion(L-C-R),ColorFondo(1-0)
$pdf->Cell(195, 10, utf8_decode('"ADEPES"'), 0, 1, 'C', 1);
$pdf->Image('logo.png', 175, 10, 30); //logo de la empresa,moverDerecha,moverAbajo,tamañoIMG
$pdf->SetFont('Arial', 'B', 14); //tipo fuente, negrita(B-I-U-BIU), tamañoTexto
$pdf->Ln(5); // Salto de línea
$pdf->SetFont('Arial', 'BIU', 14);
$pdf->Cell(195, 5, utf8_decode('DICTAMEN DEL ASESOR'), 0, 1, 'C', 0);
$pdf->Ln(7); // Salto de línea
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(190, 5, utf8_decode('MONTO: '.$datosSolicitud['Monto'].'      PLAZO:  '.$datosSolicitud['Plazo'].'      DESTINO: '.$datosSolicitud['rubro']), 0, 1, 'C', 0);
$pdf->Ln(7); // Salto de línea
$pdf->Cell(195, 10, utf8_decode('DATOS PARA EL ANÁLISIS'), 1, 1, 'C', 1);
$pdf->SetFont('Arial', '', 12);
$pdf->SetFillColor(255,255,255); //colorFondo BLANCO
$pdf->MultiCell(195, 5, utf8_decode($dictamen['dictamen']), 1, 1, 'C', 0);
$pdf->MultiCell(195, 10, utf8_decode($dictamen['prestamoAprobados']), 1, 1, 'C', 0);
$pdf->Ln(7); // Salto de línea
$pdf->SetFillColor(143,188,143); //colorFondo verde
$pdf->Cell(195, 10, utf8_decode('DICTAMEN'), 1, 1, 'C', 1);
$pdf->SetFillColor(255,255,255); //colorFondo BLANCO
$pdf->MultiCell(195, 10, utf8_decode($datosSolicitud['dictamenAsesor']), 1, 1, 'C', 0);
$pdf->Ln(12); // Salto de línea
$pdf->CELL(195, 10, utf8_decode('ASESOR DE CRÉDITO: '.$datosSolicitud['NombreUsuario']), 0, 1, 'L', 0);
//********************** SOLICITUD DEL CLIENTE */

$pdf->AddPage("portrait", "letter");
//encabezado
$pdf->Image('logo.png', 175, 10, 20); //logo de la empresa,moverDerecha,moverAbajo,tamañoIMG
$pdf->SetFont('Arial', 'B', 11); //tipo fuente, negrita(B-I-U-BIU), tamañoTexto
$pdf->Cell(45); // Movernos a la derecha
$pdf->SetTextColor(0, 0, 0); //color

//creamos una celda o fila
$pdf->Cell(100, 5, utf8_decode('ASOCIACIÓN DE DESARROLLO PESPIRENSE'), 0, 1, 'C', 0); // AnchoCelda,AltoCelda,titulo,borde(1-0),saltoLinea(1-0),posicion(L-C-R),ColorFondo(1-0)
$pdf->Cell(195, 5, utf8_decode('"ADEPES"'), 0, 1, 'C', 0);
$pdf->Cell(195, 5, utf8_decode('SOLICITUD DE PRÉSTAMO'), 0, 1, 'C', 0);
$pdf->Ln(2); // Salto de línea

$pdf->SetFont('Arial', 'B',9);
$pdf->Cell(190, 5, utf8_decode('Tipo de Garantía: '.$datosSolicitud['Prestamo'].'   NIVELADA    Plazo:  '.$datosSolicitud['Plazo'].'    Tasa:   '.$datosSolicitud['tasa'].'  Anual   Monto:  '.$datosSolicitud['Monto'].
'  Invierte en: '.$datosSolicitud['rubro']), 0, 1, 'C', 0);
$pdf->SetFont('Arial', 'B',9);
$pdf->Cell(190, 5, utf8_decode('INFORMACIÓN PERSONAL'), 0, 1, 'L', 0);
$pdf->SetFont('Arial', '',9);
$pdf->Cell(120, 5, utf8_decode('Nombres y Apellidos: '.$datosSolicitud['nombres'].' '.$datosSolicitud['apellidos']), 0, 0, 'L', 0);
$pdf->Cell(75, 5, utf8_decode('N° Identidad: '.$datosSolicitud['identidad']), 0, 1, 'R', 0);
$pdf->Cell(80, 5, utf8_decode('Fecha Nacimiento: '.$datosSolicitud['fechaNacimiento']), 0, 0, 'L', 0);
$pdf->Cell(50, 5, utf8_decode('Edad: '.$datosSolicitud['edad']), 0, 0, 'L', 0);
$pdf->Cell(65, 5, utf8_decode('Nacionalidad: '.$datosCliente['nacionalidad']), 0, 1, 'R', 0);
$pdf->Cell(190, 5, utf8_decode('Dirección Completa: '.$datosContactos[1]['valor'].', '.$datosCliente['municipio']), 0, 1, 'L', 0);
$pdf->Cell(80, 5, utf8_decode('Teléfono: '.$datosContactos[2]['valor']), 0, 0, 'L', 0);
$pdf->Cell(50, 5, utf8_decode('Celular: '.$datosContactos[0]['valor']), 0, 0, 'L', 0);
$pdf->Cell(65, 5, utf8_decode('Estado Civil: '.$datosCliente['estadoCivil']), 0, 1, 'R', 0);
$pdf->Cell(35, 5, utf8_decode('Casa: '.$datosCliente['categoriaCasa']), 0, 0, 'L', 0);
$pdf->Cell(50, 5, utf8_decode('Tiempo de Vivir: '.$datosCliente['tiempoVivir']), 0, 0, 'L', 0);
$pdf->Cell(80, 5, utf8_decode('Valor Pago: '.$datosAnalisis['cuotaVivienda'].' '.$datosCliente['tipoPago']), 0, 0, 'C', 0);
$pdf->Cell(30, 5, utf8_decode('Genero: '.$datosCliente['genero']), 0, 1, 'R', 0);
$pdf->Cell(100, 5, utf8_decode('Profesión u oficio: '.$datosCliente['profesion']), 0, 0, 'L', 0);
$pdf->Cell(95, 5, utf8_decode('Patrono o Negocio: '.$datosCliente['PratronoNegocio']), 0, 1, 'R', 0);
$pdf->Cell(100, 5, utf8_decode('Actividad que desempeña: '.$datosCliente['cargoDesempena']), 0, 0, 'L', 0);
$pdf->Cell(95, 5, utf8_decode('Tiempo de laborar: '.$datosCliente['tiempoLaboral']), 0, 1, 'R', 0);
$pdf->Cell(65, 5, utf8_decode('Ingresos por Negocio: '.$datosAnalisis['ingresosNegocio']), 0, 0, 'L', 0);
$pdf->Cell(65, 5, utf8_decode('SueldoBase: '.$datosAnalisis['sueldoBase']), 0, 0, 'C', 0);
$pdf->Cell(65, 5, utf8_decode('Gasto Alimentación: '.$datosAnalisis['alimentacion']), 0, 1, 'R', 0);
$pdf->Cell(190, 5, utf8_decode('Dirección del Trabajo: '.$datosContactos[3]['valor']), 0, 1, 'L', 0);
$pdf->Cell(65, 5, utf8_decode('Teléfono del Trabajo: '.$datosContactos[4]['valor']), 0, 0, 'L', 0);
$pdf->Cell(65, 5, utf8_decode('Tipo de Crédito: '.$datosCliente['tipoCliente']), 0, 0, 'C', 0);//,posicion(L-C-R)
$pdf->Cell(65, 5, utf8_decode('Cuenta #: '.$datosCliente['NumeroCuenta']), 0, 1, 'R', 0);
$pdf->Cell(75, 5, utf8_decode('Estado del Crédito: '.$datosCliente['estadoCredito']), 0, 0, 'L', 0);
$pdf->Cell(75, 5, utf8_decode('Es Aval: '.$datosCliente['esAval'].' '.$datosCliente['creditoAval']), 0, 0, 'C', 0);//,posicion(L-C-R)
$pdf->Cell(45, 5, utf8_decode('Valor Cuota: L. '.$datosAnalisis['cuotaPrestamoAdepes']), 0, 1, 'R', 0);

//********************** Datos pareja del solicitante */
if(!empty($datosCliente['idConyuge'])){ //validad que tenga pareja

    $datosParejaCliente = datosPersona($datosCliente['idConyuge'], $cnx);//funcion para traer Datos
$parejaContactoCliente = ContactoPersona($datosCliente['idConyuge'], $cnx); //trae datos de contactos
$datosAnalisisPareja = datosAnalisisPareja($datosCliente['idConyuge'], $cnx); //analisis crediticio*/
$pdf->SetFont('Arial', 'B',9);
$pdf->Cell(190, 5, utf8_decode('INFORMACIÓN DEL ESPOSO(A) O COMPAÑERO(A)                        ['.$datosCliente['estadoCivil'].']'), 0, 1, 'L', 0);
$pdf->SetFont('Arial', '',9);
$pdf->Cell(120, 5, utf8_decode('Nombres y Apellidos: '.$datosParejaCliente['nombres']), 0, 0, 'L', 0);
$pdf->Cell(75, 5, utf8_decode('N° Identidad: '.$datosParejaCliente['identidad']), 0, 1, 'R', 0);
$pdf->Cell(80, 5, utf8_decode('Fecha Nacimiento: '.$datosParejaCliente['fechaNacimiento']), 0, 0, 'L', 0);
$pdf->Cell(50, 5, utf8_decode('Edad: '.$datosParejaCliente['edad']), 0, 1, 'L', 0);
$pdf->Cell(190, 5, utf8_decode('Dirección Completa: '.$parejaContactoCliente[1]['valor'].', '.$datosParejaCliente['municipio']), 0, 1, 'L', 0);
$pdf->Cell(80, 5, utf8_decode('Teléfono: '.$parejaContactoCliente[2]['valor']), 0, 0, 'L', 0);
$pdf->Cell(50, 5, utf8_decode('Celular: '.$parejaContactoCliente[0]['valor']), 0, 1, 'L', 0);
$pdf->Cell(100, 5, utf8_decode('Profesión u oficio: '.$datosParejaCliente['profesion']), 0, 0, 'L', 0);
$pdf->Cell(95, 5, utf8_decode('Patrono o Negocio: '.$datosParejaCliente['PratronoNegocio']), 0, 1, 'R', 0);
$pdf->Cell(100, 5, utf8_decode('Actividad que desempeña: '.$datosParejaCliente['cargoDesempena']), 0, 0, 'L', 0);
$pdf->Cell(95, 5, utf8_decode('Tiempo de laborar: '.$datosParejaCliente['tiempoLaboral']), 0, 1, 'R', 0);
$pdf->Cell(65, 5, utf8_decode('Ingresos por Negocio: '.$datosAnalisisPareja['ingresosNegocio']), 0, 0, 'L', 0);
$pdf->Cell(65, 5, utf8_decode('SueldoBase: '.$datosAnalisisPareja['sueldoBase']), 0, 0, 'C', 0);
$pdf->Cell(65, 5, utf8_decode('Gasto Alimentación: '.$datosAnalisisPareja['gastoAlimentacion']), 0, 1, 'R', 0);
$pdf->Cell(190, 5, utf8_decode('Dirección del Trabajo: '.$parejaContactoCliente[3]['valor']), 0, 1, 'L', 0);
$pdf->Cell(65, 5, utf8_decode('Teléfono del Trabajo: '.$parejaContactoCliente[4]['valor']), 0, 0, 'L', 0);
$pdf->Cell(65, 5, utf8_decode('Tipo de Cliente: '.$datosParejaCliente['tipoCliente']), 0, 0, 'C', 0);//,posicion(L-C-R)
$pdf->Cell(65, 5, utf8_decode('IDC #: '.$datosParejaCliente['NumeroCuenta']), 0, 1, 'R', 0);
$pdf->Cell(75, 5, utf8_decode('Estado del Crédito: '.$datosParejaCliente['estadoCredito']), 0, 0, 'L', 0);
$pdf->Cell(75, 5, utf8_decode('Es Aval: '.$datosParejaCliente['esAval'].' '.$datosParejaCliente['creditoAval']), 0, 0, 'C', 0);//,posicion(L-C-R)
$pdf->Cell(45, 5, utf8_decode('Valor Cuota: L. '), 0, 1, 'R', 0);

}else{ //soltero o no definido
    $pdf->SetFont('Arial', 'B',9);
    $pdf->Cell(190, 5, utf8_decode('INFORMACIÓN DEL ESPOSO(A) O COMPAÑERO(A)                        ['.$datosCliente['estadoCivil'].']'), 0, 1, 'L', 0); 
}

/**************************** ESTADO DE INGRESOS Y GASTOS ***************************/
 /* CAMPOS DE LA TABLA */
//color
$pdf->SetFillColor(204, 198, 196); //colorFondo
$pdf->SetTextColor(0, 0, 0); //colorTexto
$pdf->SetDrawColor(163, 163, 163); //colorBorde
$pdf->SetFont('Arial', 'B', 9);
$pdf->Ln(2);
$pdf->Cell(120, 5, utf8_decode('ESTADO DE INGRESOS Y GASTOS'), 1, 1, 'C', 1);
$pdf->Cell(60, 5, utf8_decode('Ingresos Mensuales'), 1, 0, 'C', 0);
$pdf->Cell(60, 5, utf8_decode('Egresos Mensuales'), 1, 1, 'C', 0);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(60, 5, utf8_decode('Sueldo Base L.'.$datosAnalisis['sueldoBase']), 1, 0, 'R', );
$pdf->Cell(60, 5, utf8_decode('Cuota Préstamo en ADEPES L. '.$datosAnalisis['cuotaPrestamoAdepes']), 1, 1, 'R', );
$pdf->Cell(60, 5, utf8_decode('Ingresos del Negocio L.'.$datosAnalisis['ingresosNegocio']), 1, 0, 'R', );
$pdf->Cell(60, 5, utf8_decode('Cuota de Vivienda L. '.$datosAnalisis['cuotaVivienda']), 1, 1, 'R', );
$pdf->Cell(60, 5, utf8_decode('Renta de Propiedades L.'.$datosAnalisis['rentaPropiedad']), 1, 0, 'R', );
$pdf->Cell(60, 5, utf8_decode('Alimentación L. '.$datosAnalisis['alimentacion']), 1, 0, 'R', );
$pdf->SetFillColor(255, 255, 0); //colorFondo
$pdf->Cell(75, 5, utf8_decode('Relación cuotas en cuanto a Ingresos Netos'), 1, 1, 'C', 1);
$pdf->Cell(60, 5, utf8_decode('Remesas L.'.$datosAnalisis['remesas']), 1, 0, 'R', );
$pdf->Cell(60, 5, utf8_decode('Central de Riesgo como Cliente L. '.$datosAnalisis['deduccionesCentralRiesgo']), 1, 0, 'R', );
$pdf->Cell(75, 5, utf8_decode('Letra Mensual L. '.$letraMensual), 1, 1, 'R', 0);

$pdf->Cell(60, 5, utf8_decode('Aporte del Conyugue L.'.$datosAnalisis['aporteConyugue']), 1, 0, 'R', );
$pdf->cell(60, 5, utf8_decode('Otros Egresos L. '.$datosAnalisis['otrosEgresos']), 1,0, 'R', );
$pdf->Cell(75, 5, utf8_decode('Interés corriente mensual L. '.$interesCorrienteMensual), 1, 1, 'R', 0);

$pdf->Cell(60, 5, utf8_decode('Ingresos por Sociedad L.'.$datosAnalisis['ingresosSociedad']), 1, 0, 'R', );
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(60, 5, utf8_decode('Total Egresos L. '.$datosAnalisis['totalEgresos']), 1, 0, 'R', );
$pdf->Cell(75, 5, utf8_decode('Total por pagar cuota L. '.$cuota), 1, 1, 'R', 0);

$pdf->Cell(60, 5, utf8_decode('Total Ingresos L.'.$datosAnalisis['totalIngresos']), 1, 0, 'R', );
$pdf->Cell(60, 5, utf8_decode('Total Ingresos Netos L.'.$datosAnalisis['totalNetos']), 1, 0, 'R', );
$pdf->Cell(75, 5, utf8_decode('Capital disponible para el crédito L. '.$datosAnalisis['LiquidezCliente']), 1, 1, 'R', 0);
$pdf->Ln(2);
$pdf->MultiCell(200, 5, utf8_decode('Evalucación según información recopilada: '.$datosAnalisis['Descripcion']), 1, 'L');
$pdf->Ln(2);
/**********  REFERENCIAS FAMILIARES */
//FUNCION PARA TRAER LAS REFERENCIAS FAMILIARES
$refeFamilares = referenciasFamiliares($idPersona, $cnx);
$pdf->Cell(190, 3, utf8_decode('REFERENCIAS FAMILIARES QUE NO VIVAN EN SU MISMA CASA'), 0, 1, 'L', 0);
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(80, 5, utf8_decode('1. Nombre: '.$refeFamilares[0]['nombre']), 0, 0, 'L', );
$pdf->Cell(60, 5, utf8_decode('Parentesco: '.$refeFamilares[0]['descripcion']), 0, 0, 'C', );
$pdf->Cell(55, 5, utf8_decode('Celular: '.$refeFamilares[0]['celular']), 0, 1, 'R', );
$pdf->Cell(195, 5, utf8_decode('Dirección: '.$refeFamilares[0]['direccion']), 0, 1, 'L', );
$pdf->Cell(80, 5, utf8_decode('2. Nombre: '.$refeFamilares[1]['nombre']), 0, 0, 'L', );
$pdf->Cell(60, 5, utf8_decode('Parentesco: '.$refeFamilares[1]['descripcion']), 0, 0, 'C', );
$pdf->Cell(55, 5, utf8_decode('Celular: '.$refeFamilares[1]['celular']), 0, 1, 'R', );
$pdf->Cell(195, 5, utf8_decode('Dirección: '.$refeFamilares[1]['direccion']), 0, 1, 'L', );
$pdf->Ln(2);
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(190, 3, utf8_decode('INFORMACIÓN ADICIONAL'), 0, 1, 'L', 0);
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(80, 5, utf8_decode('Lo invertira en: '.$datosSolicitud['invierteEn']), 0, 0, 'L', );
$pdf->Cell(120, 5, utf8_decode('Personas dependientes: '.$datosSolicitud['dependiente']), 0, 1, 'R', );
$pdf->ln(5);
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(100, 5, utf8_decode('_____________________________________________________'), 0, 1, 'L',0 );
$pdf->Cell(100, 5, utf8_decode('Nombre o Firma del Solicitante'), 0, 0, 'C', 0);
$pdf->Cell(95, 5, utf8_decode('Fecha Emisión: '.$datosSolicitud['fechaDesembolso']), 0, 1, 'R', 0);
$pdf->Cell(190, 5, utf8_decode('OBSERVACIONES: '.$datosSolicitud['ObservacionesSolicitud']), 0, 1, 'L', 0);




$avales= idAvales($idSolicitud, $cnx); //cuenta los avales
if(count($avales) >= 1){
/************************************ Solicitud de aval 1 *********************************************** */

$datosAval1 = datosPersona($avales[0]['idPersona'], $cnx);//funcion para traer Datos
$contactosAval1 = ContactoPersona($avales[0]['idPersona'], $cnx); //trae datos de contactos
$analisisAval1 = datosAnalisis($avales[0]['idPersona'], $cnx); //analisis crediticio


$pdf->AddPage("portrait", "letter");
//encabezado
$pdf->Image('logo.png', 175, 10, 20); //logo de la empresa,moverDerecha,moverAbajo,tamañoIMG
$pdf->SetFont('Arial', 'B', 11); //tipo fuente, negrita(B-I-U-BIU), tamañoTexto
$pdf->Cell(45); // Movernos a la derecha
$pdf->SetTextColor(0, 0, 0); //color

//creamos una celda o fila
$pdf->Cell(100, 5, utf8_decode('ASOCIACIÓN DE DESARROLLO PESPIRENSE'), 0, 1, 'C', 0); // AnchoCelda,AltoCelda,titulo,borde(1-0),saltoLinea(1-0),posicion(L-C-R),ColorFondo(1-0)
$pdf->Cell(195, 5, utf8_decode('"ADEPES"'), 0, 1, 'C', 0);
$pdf->Cell(195, 5, utf8_decode('SOLICITUD DE PRÉSTAMO'), 0, 1, 'C', 0);
$pdf->Ln(2); // Salto de línea

$pdf->SetFont('Arial', 'B',10);

$pdf->Cell(120, 5, utf8_decode('Prestatario: '.$datosSolicitud['nombres'].' '.$datosSolicitud['apellidos']), 0, 0, 'C', 0);
$pdf->Cell(75, 5, utf8_decode('Tipo de Garantía: '.$datosSolicitud['Prestamo']), 0, 1, 'C', 0);
$pdf->Cell(195, 5, utf8_decode('Monto:  '.$datosSolicitud['Monto'].'  Plazo:  '.$datosSolicitud['Plazo'].'  Tasa:   '.$datosSolicitud['tasa'].'  Anual'), 0, 1, 'C', 0);
$pdf->SetFont('Arial', 'B',9);
$pdf->Cell(190, 5, utf8_decode('INFORMACIÓN PERSONAL                                           AVAL SOLIDARIO #1'), 0, 1, 'L', 0);
$pdf->SetFont('Arial', '',9);
$pdf->Cell(120, 5, utf8_decode('Nombres y Apellidos: '.$datosAval1['nombres']), 0, 0, 'L', 0);
$pdf->Cell(75, 5, utf8_decode('N° Identidad: '.$datosAval1['identidad']), 0, 1, 'R', 0);
$pdf->Cell(80, 5, utf8_decode('Fecha Nacimiento: '.$datosAval1['fechaNacimiento']), 0, 0, 'L', 0);
$pdf->Cell(50, 5, utf8_decode('Edad: '.$datosAval1['edad']), 0, 1, 'L', 0);
$pdf->Cell(190, 5, utf8_decode('Dirección Completa: '.$contactosAval1[1]['valor'].', '.$datosAval1['municipio']), 0, 1, 'L', 0);
$pdf->Cell(80, 5, utf8_decode('Teléfono: '.$contactosAval1[2]['valor']), 0, 0, 'L', 0);
$pdf->Cell(50, 5, utf8_decode('Celular: '.$contactosAval1[0]['valor']), 0, 0, 'L', 0);
$pdf->Cell(65, 5, utf8_decode('Estado Civil: '.$datosAval1['estadoCivil']), 0, 1, 'R', 0);
$pdf->Cell(35, 5, utf8_decode('Casa: '.$datosAval1['categoriaCasa']), 0, 0, 'L', 0);
$pdf->Cell(50, 5, utf8_decode('Tiempo de Vivir: '.$datosAval1['tiempoVivir']), 0, 0, 'L', 0);
$pdf->Cell(80, 5, utf8_decode('Valor Pago: '.$analisisAval1['cuotaVivienda'].' '.$datosAval1['tipoPago']), 0, 0, 'C', 0);
$pdf->Cell(30, 5, utf8_decode('Genero: '.$datosAval1['genero']), 0, 1, 'R', 0);
$pdf->Cell(100, 5, utf8_decode('Profesión u oficio: '.$datosAval1['profesion']), 0, 0, 'L', 0);
$pdf->Cell(95, 5, utf8_decode('Patrono o Negocio: '.$datosAval1['PratronoNegocio']), 0, 1, 'R', 0);
$pdf->Cell(100, 5, utf8_decode('Actividad que desempeña: '.$datosAval1['cargoDesempena']), 0, 0, 'L', 0);
$pdf->Cell(95, 5, utf8_decode('Tiempo de laborar: '.$datosAval1['tiempoLaboral']), 0, 1, 'R', 0);
$pdf->Cell(65, 5, utf8_decode('Sueldo Mensual: '.$analisisAval1['ingresosNegocio']), 0, 0, 'L', 0);
$pdf->Cell(65, 5, utf8_decode('SueldoBase: '.$analisisAval1['sueldoBase']), 0, 0, 'C', 0);
$pdf->Cell(65, 5, utf8_decode('Gasto Alimentación: '.$analisisAval1['alimentacion']), 0, 1, 'R', 0);
$pdf->Cell(190, 5, utf8_decode('Dirección del Trabajo: '.$contactosAval1[3]['valor']), 0, 1, 'L', 0);
$pdf->Cell(65, 5, utf8_decode('Teléfono del Trabajo: '.$contactosAval1[4]['valor']), 0, 0, 'L', 0);
$pdf->Cell(65, 5, utf8_decode('Tipo de Cliente: '.$datosAval1['tipoCliente']), 0, 0, 'C', 0);//,posicion(L-C-R)
$pdf->Cell(65, 5, utf8_decode('IDC #: '.$datosAval1['NumeroCuenta']), 0, 1, 'R', 0);
$pdf->Cell(75, 5, utf8_decode('Estado del Crédito: '.$datosAval1['estadoCredito']), 0, 0, 'L', 0);
$pdf->Cell(75, 5, utf8_decode('Es Aval: '.$datosAval1['esAval'].' '.$datosAval1['creditoAval']), 0, 0, 'C', 0);//,posicion(L-C-R)
$pdf->Cell(45, 5, utf8_decode('Valor Cuota: L. '.$analisisAval1['cuotaPrestamoAdepes']), 0, 1, 'R', 0);

//********************** Datos pareja del aval1 */
if(!empty($datosAval1['idConyuge'])){ //validad que tenga pareja

$datosParejaAval1 = datosPersona($datosAval1['idConyuge'], $cnx);//funcion para traer Datos
$parejaContactoAval1 = ContactoPersona($datosAval1['idConyuge'], $cnx); //trae datos de contactos
$datosAnalisisParejaAval1 = datosAnalisisPareja($datosAval1['idConyuge'], $cnx); //analisis crediticio*/

$pdf->SetFont('Arial', 'B',9);
$pdf->Cell(190, 5, utf8_decode('INFORMACIÓN DEL ESPOSO(A) O COMPAÑERO(A)                        ['.$datosAval1['estadoCivil'].']'), 0, 1, 'L', 0);
$pdf->SetFont('Arial', '',9);
$pdf->Cell(120, 5, utf8_decode('Nombres y Apellidos: '.$datosParejaAval1['nombres']), 0, 0, 'L', 0);
$pdf->Cell(75, 5, utf8_decode('N° Identidad: '.$datosParejaAval1['identidad']), 0, 1, 'R', 0);
$pdf->Cell(50, 5, utf8_decode('Fecha Nacimiento: '.$datosParejaAval1['fechaNacimiento']), 0, 0, 'L', 0);
$pdf->Cell(50, 5, utf8_decode('Edad: '.$datosParejaAval1['edad']), 0, 0, 'C', 0);
$pdf->Cell(50, 5, utf8_decode('Teléfono: '.$parejaContactoAval1[2]['valor']), 0, 0, 'R', 0);
$pdf->Cell(45, 5, utf8_decode('Celular: '.$parejaContactoAval1[0]['valor']), 0, 1, 'R', 0);

$pdf->Cell(190, 5, utf8_decode('Dirección Completa: '.$parejaContactoAval1[1]['valor'].', '.$datosParejaAval1['municipio']), 0, 1, 'L', 0);

$pdf->Cell(100, 5, utf8_decode('Profesión u oficio: '.$datosParejaAval1['profesion']), 0, 0, 'L', 0);
$pdf->Cell(95, 5, utf8_decode('Patrono o Negocio: '.$datosParejaAval1['PratronoNegocio']), 0, 1, 'R', 0);
$pdf->Cell(100, 5, utf8_decode('Actividad que desempeña: '.$datosParejaAval1['cargoDesempena']), 0, 0, 'L', 0);
$pdf->Cell(95, 5, utf8_decode('Tiempo de laborar: '.$datosParejaAval1['tiempoLaboral']), 0, 1, 'R', 0);
$pdf->Cell(65, 5, utf8_decode('Ingresos por Negocio: '.$datosAnalisisParejaAval1['ingresosNegocio']), 0, 0, 'L', 0);
$pdf->Cell(65, 5, utf8_decode('SueldoBase: '.$datosAnalisisParejaAval1['sueldoBase']), 0, 0, 'C', 0);
$pdf->Cell(65, 5, utf8_decode('Gasto Alimentación: '.$datosAnalisisParejaAval1['gastoAlimentacion']), 0, 1, 'R', 0);
$pdf->Cell(190, 5, utf8_decode('Dirección del Trabajo: '.$parejaContactoAval1[3]['valor']), 0, 1, 'L', 0);
$pdf->Cell(65, 5, utf8_decode('Teléfono del Trabajo: '.$parejaContactoAval1[4]['valor']), 0, 0, 'L', 0);
$pdf->Cell(65, 5, utf8_decode('Tipo de Cliente: '.$datosParejaAval1['tipoCliente']), 0, 0, 'C', 0);//,posicion(L-C-R)
$pdf->Cell(65, 5, utf8_decode('IDC #: '.$datosParejaAval1['NumeroCuenta']), 0, 1, 'R', 0);
$pdf->Cell(75, 5, utf8_decode('Estado del Crédito: '.$datosParejaAval1['estadoCredito']), 0, 0, 'L', 0);
$pdf->Cell(75, 5, utf8_decode('Es Aval: '.$datosParejaAval1['esAval'].' '.$datosParejaAval1['creditoAval']), 0, 0, 'C', 0);//,posicion(L-C-R)
$pdf->Cell(45, 5, utf8_decode('Valor Cuota: L. '), 0, 1, 'R', 0);

}else{ //soltero o no definido
    $pdf->SetFont('Arial', 'B',9);
    $pdf->Cell(190, 5, utf8_decode('INFORMACIÓN DEL ESPOSO(A) O COMPAÑERO(A)                        ['.$datosAval1['estadoCivil'].']'), 0, 1, 'L', 0); 
}
/***************************** ESTADO INGRESOS Y GASTOS AVAL 1 *************************/

$pdf->SetFillColor(204, 198, 196); //colorFondo
$pdf->SetTextColor(0, 0, 0); //colorTexto
$pdf->SetDrawColor(163, 163, 163); //colorBorde
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(120, 5, utf8_decode('ESTADO DE INGRESOS Y GASTOS'), 1, 1, 'C', 1);
$pdf->Cell(60, 5, utf8_decode('Ingresos Mensuales'), 1, 0, 'C', 0);
$pdf->Cell(60, 5, utf8_decode('Egresos Mensuales'), 1, 1, 'C', 0);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(60, 5, utf8_decode('Sueldo Base L.'.$analisisAval1['sueldoBase']), 1, 0, 'R', );
$pdf->Cell(60, 5, utf8_decode('Cuota Préstamo en ADEPES L. '.$analisisAval1['cuotaPrestamoAdepes']), 1, 1, 'R', );
$pdf->Cell(60, 5, utf8_decode('Ingresos del Negocio L.'.$analisisAval1['ingresosNegocio']), 1, 0, 'R', );
$pdf->Cell(60, 5, utf8_decode('Cuota de Vivienda L. '.$analisisAval1['cuotaVivienda']), 1, 1, 'R', );
$pdf->Cell(60, 5, utf8_decode('Renta de Propiedades L.'.$analisisAval1['rentaPropiedad']), 1, 0, 'R', );
$pdf->Cell(60, 5, utf8_decode('Alimentación L. '.$analisisAval1['alimentacion']), 1, 0, 'R', );
$pdf->SetFillColor(255, 255, 0); //colorFondo
$pdf->Cell(75, 5, utf8_decode('Relación cuotas en cuanto a Ingresos Netos'), 1, 1, 'C', 1);
$pdf->Cell(60, 5, utf8_decode('Remesas L.'.$analisisAval1['remesas']), 1, 0, 'R', );
$pdf->Cell(60, 5, utf8_decode('Central de Riesgo como Cliente L. '.$analisisAval1['deduccionesCentralRiesgo']), 1, 0, 'R', );
$pdf->Cell(75, 5, utf8_decode('Letra Mensual L. '.$letraMensual), 1, 1, 'R', 0);

$pdf->Cell(60, 5, utf8_decode('Aporte del Conyugue L.'.$analisisAval1['aporteConyugue']), 1, 0, 'R', );
$pdf->cell(60, 5, utf8_decode('Otros Egresos L. '.$analisisAval1['otrosEgresos']), 1,0, 'R', );
$pdf->Cell(75, 5, utf8_decode('Interés corriente mensual L. '.$interesCorrienteMensual), 1, 1, 'R', 0);

$pdf->Cell(60, 5, utf8_decode('Ingresos por Sociedad L.'.$analisisAval1['ingresosSociedad']), 1, 0, 'R', );
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(60, 5, utf8_decode('Total Egresos L. '.$analisisAval1['totalEgresos']), 1, 0, 'R', );
$pdf->Cell(75, 5, utf8_decode('Total por pagar cuota L. '.$cuota), 1, 1, 'R', 0);

$pdf->Cell(60, 5, utf8_decode('Total Ingresos L.'.$analisisAval1['totalIngresos']), 1, 0, 'R', );
$pdf->Cell(60, 5, utf8_decode('Total Ingresos Netos L.'.$analisisAval1['totalNetos']), 1, 0, 'R', );
$pdf->Cell(75, 5, utf8_decode('Capital disponible para el crédito L. '.$analisisAval1['LiquidezCliente']), 1, 1, 'R', 0);
$pdf->MultiCell(195, 5, utf8_decode('Evalucación según información recopilada: '.$analisisAval1['Descripcion']), 1, 'L');
$pdf->ln(2);

/**********  REFERENCIAS FAMILIARES */
//FUNCION PARA TRAER LAS REFERENCIAS FAMILIARES
$refeFamilaresAval1 = referenciasFamiliares($avales[0]['idPersona'], $cnx);
$pdf->Cell(190, 3, utf8_decode('REFERENCIAS FAMILIARES QUE NO VIVAN EN SU MISMA CASA'), 0, 1, 'L', 0);
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(80, 5, utf8_decode('1. Nombre: '.$refeFamilaresAval1[0]['nombre']), 0, 0, 'L', );
$pdf->Cell(60, 5, utf8_decode('Parentesco: '.$refeFamilaresAval1[0]['descripcion']), 0, 0, 'C', );
$pdf->Cell(55, 5, utf8_decode('Celular: '.$refeFamilaresAval1[0]['celular']), 0, 1, 'R', );
$pdf->Cell(195, 5, utf8_decode('Dirección: '.$refeFamilaresAval1[0]['direccion']), 0, 1, 'L', );
$pdf->Cell(80, 5, utf8_decode('2. Nombre: '.$refeFamilaresAval1[1]['nombre']), 0, 0, 'L', );
$pdf->Cell(60, 5, utf8_decode('Parentesco: '.$refeFamilaresAval1[1]['descripcion']), 0, 0, 'C', );
$pdf->Cell(55, 5, utf8_decode('Celular: '.$refeFamilaresAval1[1]['celular']), 0, 1, 'R', );
$pdf->Cell(195, 5, utf8_decode('Dirección: '.$refeFamilaresAval1[1]['direccion']), 0, 1, 'L', );
$pdf->SetFont('Arial', 'B', 9);
//              REFERENCIAS COMERCIALES
$refeComercialesAval1 = referenciasComerciales($avales[0]['idPersona'], $cnx);
$pdf->Cell(190, 3, utf8_decode('REFERENCIAS COMERCIALES'), 0, 1, 'L', 0);
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(60, 5, utf8_decode('1. Nombre: '.$refeComercialesAval1[0]['nombre']), 0, 0, 'L', );
$pdf->Cell(135, 5, utf8_decode('Dirección: '.$refeComercialesAval1[0]['direccion']), 0, 1, 'R', );
$pdf->Cell(60, 5, utf8_decode('2. Nombre: '.$refeComercialesAval1[1]['nombre']), 0, 0, 'L', );
$pdf->Cell(135, 5, utf8_decode('Dirección: '.$refeComercialesAval1[1]['direccion']), 0, 1, 'R', );
$pdf->SetFont('Arial', 'B', 9);
$pdf->ln(4);
$pdf->Cell(100, 5, utf8_decode('_____________________________________________________'), 0, 1, 'L',0 );
$pdf->Cell(100, 5, utf8_decode('Nombre o Firma del Aval Solidario'), 0, 0, 'C', 0);
$pdf->Cell(95, 5, utf8_decode('Fecha Emisión: '.$datosSolicitud['fechaDesembolso']), 0, 1, 'R', 0);
$pdf->Cell(190, 5, utf8_decode('OBSERVACIONES: '.$datosAval1['ObservacionesSolicitud']), 0, 1, 'L', 0);

}//fin del if si existe aval 1


/************************************ Solicitud de aval 2 *********************************************** */

if(count($avales) >= 2){
$datosAval2 = datosPersona($avales[1]['idPersona'], $cnx);//funcion para traer Datos
$contactosAval2 = ContactoPersona($avales[1]['idPersona'], $cnx); //trae datos de contactos
$analisisAval2 = datosAnalisis($avales[1]['idPersona'], $cnx); //analisis crediticio


$pdf->AddPage("portrait", "letter");
//encabezado
$pdf->Image('logo.png', 175, 10, 20); //logo de la empresa,moverDerecha,moverAbajo,tamañoIMG
$pdf->SetFont('Arial', 'B', 11); //tipo fuente, negrita(B-I-U-BIU), tamañoTexto
$pdf->Cell(45); // Movernos a la derecha
$pdf->SetTextColor(0, 0, 0); //color

//creamos una celda o fila
$pdf->Cell(100, 5, utf8_decode('ASOCIACIÓN DE DESARROLLO PESPIRENSE'), 0, 1, 'C', 0); // AnchoCelda,AltoCelda,titulo,borde(1-0),saltoLinea(1-0),posicion(L-C-R),ColorFondo(1-0)
$pdf->Cell(195, 5, utf8_decode('"ADEPES"'), 0, 1, 'C', 0);
$pdf->Cell(195, 5, utf8_decode('SOLICITUD DE PRÉSTAMO'), 0, 1, 'C', 0);
$pdf->Ln(2); // Salto de línea

$pdf->SetFont('Arial', 'B',10);

$pdf->Cell(120, 5, utf8_decode('Prestatario: '.$datosSolicitud['nombres'].' '.$datosSolicitud['apellidos']), 0, 0, 'C', 0);
$pdf->Cell(75, 5, utf8_decode('Tipo de Garantía: '.$datosSolicitud['Prestamo']), 0, 1, 'C', 0);
$pdf->Cell(195, 5, utf8_decode('Monto:  '.$datosSolicitud['Monto'].'  Plazo:  '.$datosSolicitud['Plazo'].'  Tasa:   '.$datosSolicitud['tasa'].'  Anual'), 0, 1, 'C', 0);
$pdf->SetFont('Arial', 'B',9);
$pdf->Cell(190, 5, utf8_decode('INFORMACIÓN PERSONAL                                           AVAL SOLIDARIO #2'), 0, 1, 'L', 0);
$pdf->SetFont('Arial', '',9);
$pdf->Cell(120, 5, utf8_decode('Nombres y Apellidos: '.$datosAval2['nombres']), 0, 0, 'L', 0);
$pdf->Cell(75, 5, utf8_decode('N° Identidad: '.$datosAval2['identidad']), 0, 1, 'R', 0);
$pdf->Cell(80, 5, utf8_decode('Fecha Nacimiento: '.$datosAval2['fechaNacimiento']), 0, 0, 'L', 0);
$pdf->Cell(50, 5, utf8_decode('Edad: '.$datosAval2['edad']), 0, 1, 'L', 0);
$pdf->Cell(190, 5, utf8_decode('Dirección Completa: '.$contactosAval2[1]['valor'].', '.$datosAval2['municipio']), 0, 1, 'L', 0);
$pdf->Cell(80, 5, utf8_decode('Teléfono: '.$contactosAval2[2]['valor']), 0, 0, 'L', 0);
$pdf->Cell(50, 5, utf8_decode('Celular: '.$contactosAval2[0]['valor']), 0, 0, 'L', 0);
$pdf->Cell(65, 5, utf8_decode('Estado Civil: '.$datosAval2['estadoCivil']), 0, 1, 'R', 0);
$pdf->Cell(35, 5, utf8_decode('Casa: '.$datosAval2['categoriaCasa']), 0, 0, 'L', 0);
$pdf->Cell(50, 5, utf8_decode('Tiempo de Vivir: '.$datosAval2['tiempoVivir']), 0, 0, 'L', 0);
$pdf->Cell(80, 5, utf8_decode('Valor Pago: '.$analisisAval2['cuotaVivienda'].' '.$datosAval2['tipoPago']), 0, 0, 'C', 0);
$pdf->Cell(30, 5, utf8_decode('Genero: '.$datosAval2['genero']), 0, 1, 'R', 0);
$pdf->Cell(100, 5, utf8_decode('Profesión u oficio: '.$datosAval2['profesion']), 0, 0, 'L', 0);
$pdf->Cell(95, 5, utf8_decode('Patrono o Negocio: '.$datosAval2['PratronoNegocio']), 0, 1, 'R', 0);
$pdf->Cell(100, 5, utf8_decode('Actividad que desempeña: '.$datosAval2['cargoDesempena']), 0, 0, 'L', 0);
$pdf->Cell(95, 5, utf8_decode('Tiempo de laborar: '.$datosAval2['tiempoLaboral']), 0, 1, 'R', 0);
$pdf->Cell(65, 5, utf8_decode('Sueldo Mensual: '.$analisisAval2['ingresosNegocio']), 0, 0, 'L', 0);
$pdf->Cell(65, 5, utf8_decode('SueldoBase: '.$analisisAval2['sueldoBase']), 0, 0, 'C', 0);
$pdf->Cell(65, 5, utf8_decode('Gasto Alimentación: '.$analisisAval2['alimentacion']), 0, 1, 'R', 0);
$pdf->Cell(190, 5, utf8_decode('Dirección del Trabajo: '.$contactosAval2[3]['valor']), 0, 1, 'L', 0);
$pdf->Cell(65, 5, utf8_decode('Teléfono del Trabajo: '.$contactosAval2[4]['valor']), 0, 0, 'L', 0);
$pdf->Cell(65, 5, utf8_decode('Tipo de Cliente: '.$datosAval2['tipoCliente']), 0, 0, 'C', 0);//,posicion(L-C-R)
$pdf->Cell(65, 5, utf8_decode('IDC #: '.$datosAval2['NumeroCuenta']), 0, 1, 'R', 0);
$pdf->Cell(75, 5, utf8_decode('Estado del Crédito: '.$datosAval2['estadoCredito']), 0, 0, 'L', 0);
$pdf->Cell(75, 5, utf8_decode('Es Aval: '.$datosAval2['esAval'].' '.$datosAval2['creditoAval']), 0, 0, 'C', 0);//,posicion(L-C-R)
$pdf->Cell(45, 5, utf8_decode('Valor Cuota: L. '.$analisisAval1['cuotaPrestamoAdepes']), 0, 1, 'R', 0);

//********************** Datos pareja del aval2 */
if(!empty($datosAval2['idConyuge'])){ //validad que tenga pareja

    $datosParejaAval2 = datosPersona($datosAval2['idConyuge'], $cnx);//funcion para traer Datos
    $parejaContactoAval2 = ContactoPersona($datosAval2['idConyuge'], $cnx); //trae datos de contactos
    $datosAnalisisParejaAval2 = datosAnalisisPareja($datosAval2['idConyuge'], $cnx); //analisis crediticio*/
    
    $pdf->SetFont('Arial', 'B',9);
    $pdf->Cell(190, 5, utf8_decode('INFORMACIÓN DEL ESPOSO(A) O COMPAÑERO(A)                        ['.$datosAval2['estadoCivil'].']'), 0, 1, 'L', 0);
    $pdf->SetFont('Arial', '',9);
    $pdf->Cell(120, 5, utf8_decode('Nombres y Apellidos: '.$datosParejaAval2['nombres']), 0, 0, 'L', 0);
    $pdf->Cell(75, 5, utf8_decode('N° Identidad: '.$datosParejaAval2['identidad']), 0, 1, 'R', 0);
    $pdf->Cell(50, 5, utf8_decode('Fecha Nacimiento: '.$datosParejaAval2['fechaNacimiento']), 0, 0, 'L', 0);
    $pdf->Cell(50, 5, utf8_decode('Edad: '.$datosParejaAval2['edad']), 0, 0, 'C', 0);
    $pdf->Cell(50, 5, utf8_decode('Teléfono: '.$parejaContactoAval2[2]['valor']), 0, 0, 'R', 0);
    $pdf->Cell(45, 5, utf8_decode('Celular: '.$parejaContactoAval2[0]['valor']), 0, 1, 'R', 0);
    
    $pdf->Cell(190, 5, utf8_decode('Dirección Completa: '.$parejaContactoAval2[1]['valor'].', '.$datosParejaAval2['municipio']), 0, 1, 'L', 0);
    
    $pdf->Cell(100, 5, utf8_decode('Profesión u oficio: '.$datosParejaAval2['profesion']), 0, 0, 'L', 0);
    $pdf->Cell(95, 5, utf8_decode('Patrono o Negocio: '.$datosParejaAval2['PratronoNegocio']), 0, 1, 'R', 0);
    $pdf->Cell(100, 5, utf8_decode('Actividad que desempeña: '.$datosParejaAval2['cargoDesempena']), 0, 0, 'L', 0);
    $pdf->Cell(95, 5, utf8_decode('Tiempo de laborar: '.$datosParejaAval2['tiempoLaboral']), 0, 1, 'R', 0);
    $pdf->Cell(65, 5, utf8_decode('Ingresos por Negocio: '.$datosAnalisisParejaAval2['ingresosNegocio']), 0, 0, 'L', 0);
    $pdf->Cell(65, 5, utf8_decode('SueldoBase: '.$datosAnalisisParejaAval2['sueldoBase']), 0, 0, 'C', 0);
    $pdf->Cell(65, 5, utf8_decode('Gasto Alimentación: '.$datosAnalisisParejaAval2['gastoAlimentacion']), 0, 1, 'R', 0);
    $pdf->Cell(190, 5, utf8_decode('Dirección del Trabajo: '.$parejaContactoAval2[3]['valor']), 0, 1, 'L', 0);
    $pdf->Cell(65, 5, utf8_decode('Teléfono del Trabajo: '.$parejaContactoAval2[4]['valor']), 0, 0, 'L', 0);
    $pdf->Cell(65, 5, utf8_decode('Tipo de Cliente: '.$datosParejaAval2['tipoCliente']), 0, 0, 'C', 0);//,posicion(L-C-R)
    $pdf->Cell(65, 5, utf8_decode('IDC #: '.$datosParejaAval2['NumeroCuenta']), 0, 1, 'R', 0);
    $pdf->Cell(75, 5, utf8_decode('Estado del Crédito: '.$datosParejaAval2['estadoCredito']), 0, 0, 'L', 0);
    $pdf->Cell(75, 5, utf8_decode('Es Aval: '.$datosParejaAval2['esAval'].' '.$datosParejaAval2['creditoAval']), 0, 0, 'C', 0);//,posicion(L-C-R)
    $pdf->Cell(45, 5, utf8_decode('Valor Cuota: L. '), 0, 1, 'R', 0);
    
    }else{ //soltero o no definido
        $pdf->SetFont('Arial', 'B',9);
        $pdf->Cell(190, 5, utf8_decode('INFORMACIÓN DEL ESPOSO(A) O COMPAÑERO(A)                        ['.$datosAval2['estadoCivil'].']'), 0, 1, 'L', 0); 
    }

/***************************** ESTADO INGRESOS Y GASTOS AVAL 2 *************************/

$pdf->SetFillColor(204, 198, 196); //colorFondo
$pdf->SetTextColor(0, 0, 0); //colorTexto
$pdf->SetDrawColor(163, 163, 163); //colorBorde
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(120, 5, utf8_decode('ESTADO DE INGRESOS Y GASTOS'), 1, 1, 'C', 1);
$pdf->Cell(60, 5, utf8_decode('Ingresos Mensuales'), 1, 0, 'C', 0);
$pdf->Cell(60, 5, utf8_decode('Egresos Mensuales'), 1, 1, 'C', 0);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(60, 5, utf8_decode('Sueldo Base L.'.$analisisAval2['sueldoBase']), 1, 0, 'R', );
$pdf->Cell(60, 5, utf8_decode('Cuota Préstamo en ADEPES L. '.$analisisAval2['cuotaPrestamoAdepes']), 1, 1, 'R', );
$pdf->Cell(60, 5, utf8_decode('Ingresos del Negocio L.'.$analisisAval2['ingresosNegocio']), 1, 0, 'R', );
$pdf->Cell(60, 5, utf8_decode('Cuota de Vivienda L. '.$analisisAval2['cuotaVivienda']), 1, 1, 'R', );
$pdf->Cell(60, 5, utf8_decode('Renta de Propiedades L.'.$analisisAval2['rentaPropiedad']), 1, 0, 'R', );
$pdf->Cell(60, 5, utf8_decode('Alimentación L. '.$analisisAval2['alimentacion']), 1, 0, 'R', );
$pdf->SetFillColor(255, 255, 0); //colorFondo
$pdf->Cell(75, 5, utf8_decode('Relación cuotas en cuanto a Ingresos Netos'), 1, 1, 'C', 1);
$pdf->Cell(60, 5, utf8_decode('Remesas L.'.$analisisAval2['remesas']), 1, 0, 'R', );
$pdf->Cell(60, 5, utf8_decode('Central de Riesgo como Cliente L. '.$analisisAval2['deduccionesCentralRiesgo']), 1, 0, 'R', );
$pdf->Cell(75, 5, utf8_decode('Letra Mensual L. '.$letraMensual), 1, 1, 'R', 0);

$pdf->Cell(60, 5, utf8_decode('Aporte del Conyugue L.'.$analisisAval2['aporteConyugue']), 1, 0, 'R', );
$pdf->cell(60, 5, utf8_decode('Otros Egresos L. '.$analisisAval2['otrosEgresos']), 1,0, 'R', );
$pdf->Cell(75, 5, utf8_decode('Interés corriente mensual L. '.$interesCorrienteMensual), 1, 1, 'R', 0);

$pdf->Cell(60, 5, utf8_decode('Ingresos por Sociedad L.'.$analisisAval2['ingresosSociedad']), 1, 0, 'R', );
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(60, 5, utf8_decode('Total Egresos L. '.$analisisAval2['totalEgresos']), 1, 0, 'R', );
$pdf->Cell(75, 5, utf8_decode('Total por pagar cuota L. '.$cuota), 1, 1, 'R', 0);

$pdf->Cell(60, 5, utf8_decode('Total Ingresos L.'.$analisisAval2['totalIngresos']), 1, 0, 'R', );
$pdf->Cell(60, 5, utf8_decode('Total Ingresos Netos L.'.$analisisAval2['totalNetos']), 1, 0, 'R', );
$pdf->Cell(75, 5, utf8_decode('Capital disponible para el crédito L. '.$analisisAval2['LiquidezCliente']), 1, 1, 'R', 0);
$pdf->MultiCell(195, 5, utf8_decode('Evalucación según información recopilada: '.$analisisAval2['Descripcion']), 1, 'L');
$pdf->ln(2);

/**********  REFERENCIAS FAMILIARES */
//FUNCION PARA TRAER LAS REFERENCIAS FAMILIARES
$refeFamilaresAval2 = referenciasFamiliares($avales[1]['idPersona'], $cnx);
$pdf->Cell(190, 3, utf8_decode('REFERENCIAS FAMILIARES QUE NO VIVAN EN SU MISMA CASA'), 0, 1, 'L', 0);
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(80, 5, utf8_decode('1. Nombre: '.$refeFamilaresAval2[0]['nombre']), 0, 0, 'L', );
$pdf->Cell(60, 5, utf8_decode('Parentesco: '.$refeFamilaresAval2[0]['descripcion']), 0, 0, 'C', );
$pdf->Cell(55, 5, utf8_decode('Celular: '.$refeFamilaresAval2[0]['celular']), 0, 1, 'R', );
$pdf->Cell(195, 5, utf8_decode('Dirección: '.$refeFamilaresAval2[0]['direccion']), 0, 1, 'L', );
$pdf->Cell(80, 5, utf8_decode('2. Nombre: '.$refeFamilaresAval2[1]['nombre']), 0, 0, 'L', );
$pdf->Cell(60, 5, utf8_decode('Parentesco: '.$refeFamilaresAval2[1]['descripcion']), 0, 0, 'C', );
$pdf->Cell(55, 5, utf8_decode('Celular: '.$refeFamilaresAval2[1]['celular']), 0, 1, 'R', );
$pdf->Cell(195, 5, utf8_decode('Dirección: '.$refeFamilaresAval2[1]['direccion']), 0, 1, 'L', );
$pdf->SetFont('Arial', 'B', 9);
//              REFERENCIAS COMERCIALES
$refeComercialesAval2 = referenciasComerciales($avales[1]['idPersona'], $cnx);
$pdf->Cell(190, 3, utf8_decode('REFERENCIAS COMERCIALES'), 0, 1, 'L', 0);
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(60, 5, utf8_decode('1. Nombre: '.$refeComercialesAval2[0]['nombre']), 0, 0, 'L', );
$pdf->Cell(135, 5, utf8_decode('Dirección: '.$refeComercialesAval2[0]['direccion']), 0, 1, 'R', );
$pdf->Cell(60, 5, utf8_decode('2. Nombre: '.$refeComercialesAval2[1]['nombre']), 0, 0, 'L', );
$pdf->Cell(135, 5, utf8_decode('Dirección: '.$refeComercialesAval2[1]['direccion']), 0, 1, 'R', );
$pdf->SetFont('Arial', 'B', 9);
$pdf->ln(4);
$pdf->Cell(100, 5, utf8_decode('_____________________________________________________'), 0, 1, 'L',0 );
$pdf->Cell(100, 5, utf8_decode('Nombre o Firma del Aval Solidario'), 0, 0, 'C', 0);
$pdf->Cell(95, 5, utf8_decode('Fecha Emisión: '.$datosSolicitud['fechaDesembolso']), 0, 1, 'R', 0);
$pdf->Cell(190, 5, utf8_decode('OBSERVACIONES: '.$datosAval2['ObservacionesSolicitud']), 0, 1, 'L', 0);


}//fin del if si existe aval 1


/************************************ Solicitud de aval 3 *********************************************** */

if(count($avales) >= 3){
    $datosAval3 = datosPersona($avales[2]['idPersona'], $cnx);//funcion para traer Datos
    $contactosAval3 = ContactoPersona($avales[2]['idPersona'], $cnx); //trae datos de contactos
    $analisisAval3 = datosAnalisis($avales[2]['idPersona'], $cnx); //analisis crediticio
    
    
    $pdf->AddPage("portrait", "letter");
    //encabezado
    $pdf->Image('logo.png', 175, 10, 20); //logo de la empresa,moverDerecha,moverAbajo,tamañoIMG
    $pdf->SetFont('Arial', 'B', 11); //tipo fuente, negrita(B-I-U-BIU), tamañoTexto
    $pdf->Cell(45); // Movernos a la derecha
    $pdf->SetTextColor(0, 0, 0); //color

    //creamos una celda o fila
    $pdf->Cell(100, 5, utf8_decode('ASOCIACIÓN DE DESARROLLO PESPIRENSE'), 0, 1, 'C', 0); // AnchoCelda,AltoCelda,titulo,borde(1-0),saltoLinea(1-0),posicion(L-C-R),ColorFondo(1-0)
    $pdf->Cell(195, 5, utf8_decode('"ADEPES"'), 0, 1, 'C', 0);
    $pdf->Cell(195, 5, utf8_decode('SOLICITUD DE PRÉSTAMO'), 0, 1, 'C', 0);
    $pdf->Ln(2); // Salto de línea

    $pdf->SetFont('Arial', 'B',10);
    
    $pdf->Cell(120, 5, utf8_decode('Prestatario: '.$datosSolicitud['nombres'].' '.$datosSolicitud['apellidos']), 0, 0, 'C', 0);
    $pdf->Cell(75, 5, utf8_decode('Tipo de Garantía: '.$datosSolicitud['Prestamo']), 0, 1, 'C', 0);
    $pdf->Cell(195, 5, utf8_decode('Monto:  '.$datosSolicitud['Monto'].'  Plazo:  '.$datosSolicitud['Plazo'].'  Tasa:   '.$datosSolicitud['tasa'].'  Anual'), 0, 1, 'C', 0);
    $pdf->SetFont('Arial', 'B',9);
    $pdf->Cell(190, 5, utf8_decode('INFORMACIÓN PERSONAL                                           AVAL SOLIDARIO #3'), 0, 1, 'L', 0);
    $pdf->SetFont('Arial', '',9);
    $pdf->Cell(120, 5, utf8_decode('Nombres y Apellidos: '.$datosAval3['nombres']), 0, 0, 'L', 0);
    $pdf->Cell(75, 5, utf8_decode('N° Identidad: '.$datosAval3['identidad']), 0, 1, 'R', 0);
    $pdf->Cell(80, 5, utf8_decode('Fecha Nacimiento: '.$datosAval3['fechaNacimiento']), 0, 0, 'L', 0);
    $pdf->Cell(50, 5, utf8_decode('Edad: '.$datosAval3['edad']), 0, 1, 'L', 0);
    $pdf->Cell(190, 5, utf8_decode('Dirección Completa: '.$contactosAval3[1]['valor'].', '.$datosAval3['municipio']), 0, 1, 'L', 0);
    $pdf->Cell(80, 5, utf8_decode('Teléfono: '.$contactosAval3[2]['valor']), 0, 0, 'L', 0);
    $pdf->Cell(50, 5, utf8_decode('Celular: '.$contactosAval3[0]['valor']), 0, 0, 'L', 0);
    $pdf->Cell(65, 5, utf8_decode('Estado Civil: '.$datosAval3['estadoCivil']), 0, 1, 'R', 0);
    $pdf->Cell(35, 5, utf8_decode('Casa: '.$datosAval3['categoriaCasa']), 0, 0, 'L', 0);
    $pdf->Cell(50, 5, utf8_decode('Tiempo de Vivir: '.$datosAval3['tiempoVivir']), 0, 0, 'L', 0);
    $pdf->Cell(80, 5, utf8_decode('Valor Pago: '.$analisisAval3['cuotaVivienda'].' '.$datosAval3['tipoPago']), 0, 0, 'C', 0);
    $pdf->Cell(30, 5, utf8_decode('Genero: '.$datosAval3['genero']), 0, 1, 'R', 0);
    $pdf->Cell(100, 5, utf8_decode('Profesión u oficio: '.$datosAval3['profesion']), 0, 0, 'L', 0);
    $pdf->Cell(95, 5, utf8_decode('Patrono o Negocio: '.$datosAval3['PratronoNegocio']), 0, 1, 'R', 0);
    $pdf->Cell(100, 5, utf8_decode('Actividad que desempeña: '.$datosAval3['cargoDesempena']), 0, 0, 'L', 0);
    $pdf->Cell(95, 5, utf8_decode('Tiempo de laborar: '.$datosAval3['tiempoLaboral']), 0, 1, 'R', 0);
    $pdf->Cell(65, 5, utf8_decode('Sueldo Mensual: '.$analisisAval3['ingresosNegocio']), 0, 0, 'L', 0);
    $pdf->Cell(65, 5, utf8_decode('SueldoBase: '.$analisisAval3['sueldoBase']), 0, 0, 'C', 0);
    $pdf->Cell(65, 5, utf8_decode('Gasto Alimentación: '.$analisisAval3['alimentacion']), 0, 1, 'R', 0);
    $pdf->Cell(190, 5, utf8_decode('Dirección del Trabajo: '.$contactosAval3[3]['valor']), 0, 1, 'L', 0);
    $pdf->Cell(65, 5, utf8_decode('Teléfono del Trabajo: '.$contactosAval3[4]['valor']), 0, 0, 'L', 0);
    $pdf->Cell(65, 5, utf8_decode('Tipo de Cliente: '.$datosAval3['tipoCliente']), 0, 0, 'C', 0);//,posicion(L-C-R)
    $pdf->Cell(65, 5, utf8_decode('IDC #: '.$datosAval3['NumeroCuenta']), 0, 1, 'R', 0);
    $pdf->Cell(75, 5, utf8_decode('Estado del Crédito: '.$datosAval3['estadoCredito']), 0, 0, 'L', 0);
    $pdf->Cell(75, 5, utf8_decode('Es Aval: '.$datosAval3['esAval'].' '.$datosAval3['creditoAval']), 0, 0, 'C', 0);//,posicion(L-C-R)
    $pdf->Cell(45, 5, utf8_decode('Valor Cuota: L. '.$analisisAval3['cuotaPrestamoAdepes']), 0, 1, 'R', 0);
    
    //********************** Datos pareja del aval3 */
    if(!empty($datosAval3['idConyuge'])){ //validad que tenga pareja
    
        $datosParejaAval3 = datosPersona($datosAval3['idConyuge'], $cnx);//funcion para traer Datos
        $parejaContactoAval3 = ContactoPersona($datosAval3['idConyuge'], $cnx); //trae datos de contactos
        $datosAnalisisParejaAval3 = datosAnalisisPareja($datosAval3['idConyuge'], $cnx); //analisis crediticio*/
        
        $pdf->SetFont('Arial', 'B',9);
        $pdf->Cell(190, 5, utf8_decode('INFORMACIÓN DEL ESPOSO(A) O COMPAÑERO(A)                        ['.$datosAval3['estadoCivil'].']'), 0, 1, 'L', 0);
        $pdf->SetFont('Arial', '',9);
        $pdf->Cell(120, 5, utf8_decode('Nombres y Apellidos: '.$datosParejaAval3['nombres']), 0, 0, 'L', 0);
        $pdf->Cell(75, 5, utf8_decode('N° Identidad: '.$datosParejaAval3['identidad']), 0, 1, 'R', 0);
        $pdf->Cell(50, 5, utf8_decode('Fecha Nacimiento: '.$datosParejaAval3['fechaNacimiento']), 0, 0, 'L', 0);
        $pdf->Cell(50, 5, utf8_decode('Edad: '.$datosParejaAval3['edad']), 0, 0, 'C', 0);
        $pdf->Cell(50, 5, utf8_decode('Teléfono: '.$parejaContactoAval3[2]['valor']), 0, 0, 'R', 0);
        $pdf->Cell(45, 5, utf8_decode('Celular: '.$parejaContactoAval3[0]['valor']), 0, 1, 'R', 0);
        
        $pdf->Cell(190, 5, utf8_decode('Dirección Completa: '.$parejaContactoAval3[1]['valor'].', '.$datosParejaAval3['municipio']), 0, 1, 'L', 0);
        
        $pdf->Cell(100, 5, utf8_decode('Profesión u oficio: '.$datosParejaAval3['profesion']), 0, 0, 'L', 0);
        $pdf->Cell(95, 5, utf8_decode('Patrono o Negocio: '.$datosParejaAval3['PratronoNegocio']), 0, 1, 'R', 0);
        $pdf->Cell(100, 5, utf8_decode('Actividad que desempeña: '.$datosParejaAval3['cargoDesempena']), 0, 0, 'L', 0);
        $pdf->Cell(95, 5, utf8_decode('Tiempo de laborar: '.$datosParejaAval3['tiempoLaboral']), 0, 1, 'R', 0);
        $pdf->Cell(65, 5, utf8_decode('Ingresos por Negocio: '.$datosAnalisisParejaAval3['ingresosNegocio']), 0, 0, 'L', 0);
        $pdf->Cell(65, 5, utf8_decode('SueldoBase: '.$datosAnalisisParejaAval3['sueldoBase']), 0, 0, 'C', 0);
        $pdf->Cell(65, 5, utf8_decode('Gasto Alimentación: '.$datosAnalisisParejaAval3['gastoAlimentacion']), 0, 1, 'R', 0);
        $pdf->Cell(190, 5, utf8_decode('Dirección del Trabajo: '.$parejaContactoAval3[3]['valor']), 0, 1, 'L', 0);
        $pdf->Cell(65, 5, utf8_decode('Teléfono del Trabajo: '.$parejaContactoAval3[4]['valor']), 0, 0, 'L', 0);
        $pdf->Cell(65, 5, utf8_decode('Tipo de Cliente: '.$datosParejaAval3['tipoCliente']), 0, 0, 'C', 0);//,posicion(L-C-R)
        $pdf->Cell(65, 5, utf8_decode('IDC #: '.$datosParejaAval3['NumeroCuenta']), 0, 1, 'R', 0);
        $pdf->Cell(75, 5, utf8_decode('Estado del Crédito: '.$datosParejaAval3['estadoCredito']), 0, 0, 'L', 0);
        $pdf->Cell(75, 5, utf8_decode('Es Aval: '.$datosParejaAval3['esAval'].' '.$datosParejaAval3['creditoAval']), 0, 0, 'C', 0);//,posicion(L-C-R)
        $pdf->Cell(45, 5, utf8_decode('Valor Cuota: L. '), 0, 1, 'R', 0);
        
    }else{ //soltero o no definido
        $pdf->SetFont('Arial', 'B',9);
        $pdf->Cell(190, 5, utf8_decode('INFORMACIÓN DEL ESPOSO(A) O COMPAÑERO(A)                        ['.$datosAval3['estadoCivil'].']'), 0, 1, 'L', 0); 
    }
    
    /***************************** ESTADO INGRESOS Y GASTOS AVAL 3 *************************/
    
    $pdf->SetFillColor(204, 198, 196); //colorFondo
    $pdf->SetTextColor(0, 0, 0); //colorTexto
    $pdf->SetDrawColor(163, 163, 163); //colorBorde
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(120, 5, utf8_decode('ESTADO DE INGRESOS Y GASTOS'), 1, 1, 'C', 1);
    $pdf->Cell(60, 5, utf8_decode('Ingresos Mensuales'), 1, 0, 'C', 0);
    $pdf->Cell(60, 5, utf8_decode('Egresos Mensuales'), 1, 1, 'C', 0);
    $pdf->SetFont('Arial', '', 8);
    $pdf->Cell(60, 5, utf8_decode('Sueldo Base L.'.$analisisAval3['sueldoBase']), 1, 0, 'R', );
    $pdf->Cell(60, 5, utf8_decode('Cuota Préstamo en ADEPES L. '.$analisisAval3['cuotaPrestamoAdepes']), 1, 1, 'R', );
    $pdf->Cell(60, 5, utf8_decode('Ingresos del Negocio L.'.$analisisAval3['ingresosNegocio']), 1, 0, 'R', );
    $pdf->Cell(60, 5, utf8_decode('Cuota de Vivienda L. '.$analisisAval3['cuotaVivienda']), 1, 1, 'R', );
    $pdf->Cell(60, 5, utf8_decode('Renta de Propiedades L.'.$analisisAval3['rentaPropiedad']), 1, 0, 'R', );
    $pdf->Cell(60, 5, utf8_decode('Alimentación L. '.$analisisAval3['alimentacion']), 1, 0, 'R', );
    $pdf->SetFillColor(255, 255, 0); //colorFondo
    $pdf->Cell(75, 5, utf8_decode('Relación cuotas en cuanto a Ingresos Netos'), 1, 1, 'C', 1);
    $pdf->Cell(60, 5, utf8_decode('Remesas L.'.$analisisAval3['remesas']), 1, 0, 'R', );
    $pdf->Cell(60, 5, utf8_decode('Central de Riesgo como Cliente L. '.$analisisAval3['deduccionesCentralRiesgo']), 1, 0, 'R', );
    $pdf->Cell(75, 5, utf8_decode('Letra Mensual L. '.$letraMensual), 1, 1, 'R', 0);
    
    $pdf->Cell(60, 5, utf8_decode('Aporte del Conyugue L.'.$analisisAval3['aporteConyugue']), 1, 0, 'R', );
    $pdf->cell(60, 5, utf8_decode('Otros Egresos L. '.$analisisAval3['otrosEgresos']), 1,0, 'R', );
    $pdf->Cell(75, 5, utf8_decode('Interés corriente mensual L. '.$interesCorrienteMensual), 1, 1, 'R', 0);
    
    $pdf->Cell(60, 5, utf8_decode('Ingresos por Sociedad L.'.$analisisAval3['ingresosSociedad']), 1, 0, 'R', );
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(60, 5, utf8_decode('Total Egresos L. '.$analisisAval3['totalEgresos']), 1, 0, 'R', );
    $pdf->Cell(75, 5, utf8_decode('Total por pagar cuota L. '.$cuota), 1, 1, 'R', 0);
    
    $pdf->Cell(60, 5, utf8_decode('Total Ingresos L.'.$analisisAval3['totalIngresos']), 1, 0, 'R', );
    $pdf->Cell(60, 5, utf8_decode('Total Ingresos Netos L.'.$analisisAval3['totalNetos']), 1, 0, 'R', );
    $pdf->Cell(75, 5, utf8_decode('Capital disponible para el crédito L. '.$analisisAval3['LiquidezCliente']), 1, 1, 'R', 0);
    $pdf->MultiCell(195, 5, utf8_decode('Evalucación según información recopilada: '.$analisisAval3['Descripcion']), 1, 'L');
    $pdf->ln(2);
    
    /**********  REFERENCIAS FAMILIARES */
    //FUNCION PARA TRAER LAS REFERENCIAS FAMILIARES
    $refeFamilaresAval3 = referenciasFamiliares($avales[2]['idPersona'], $cnx);
    $pdf->Cell(190, 3, utf8_decode('REFERENCIAS FAMILIARES QUE NO VIVAN EN SU MISMA CASA'), 0, 1, 'L', 0);
    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell(80, 5, utf8_decode('1. Nombre: '.$refeFamilaresAval3[0]['nombre']), 0, 0, 'L', );
    $pdf->Cell(60, 5, utf8_decode('Parentesco: '.$refeFamilaresAval3[0]['descripcion']), 0, 0, 'C', );
    $pdf->Cell(55, 5, utf8_decode('Celular: '.$refeFamilaresAval3[0]['celular']), 0, 1, 'R', );
    $pdf->Cell(195, 5, utf8_decode('Dirección: '.$refeFamilaresAval3[0]['direccion']), 0, 1, 'L', );
    $pdf->Cell(80, 5, utf8_decode('2. Nombre: '.$refeFamilaresAval3[1]['nombre']), 0, 0, 'L', );
    $pdf->Cell(60, 5, utf8_decode('Parentesco: '.$refeFamilaresAval3[1]['descripcion']), 0, 0, 'C', );
    $pdf->Cell(55, 5, utf8_decode('Celular: '.$refeFamilaresAval3[1]['celular']), 0, 1, 'R', );
    $pdf->Cell(195, 5, utf8_decode('Dirección: '.$refeFamilaresAval3[1]['direccion']), 0, 1, 'L', );
    $pdf->SetFont('Arial', 'B', 9);
    //              REFERENCIAS COMERCIALES
    $refeComercialesAval3 = referenciasComerciales($avales[2]['idPersona'], $cnx);
    $pdf->Cell(190, 3, utf8_decode('REFERENCIAS COMERCIALES'), 0, 1, 'L', 0);
    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell(60, 5, utf8_decode('1. Nombre: '.$refeComercialesAval3[0]['nombre']), 0, 0, 'L', );
    $pdf->Cell(135, 5, utf8_decode('Dirección: '.$refeComercialesAval3[0]['direccion']), 0, 1, 'R', );
    $pdf->Cell(60, 5, utf8_decode('2. Nombre: '.$refeComercialesAval3[1]['nombre']), 0, 0, 'L', );
    $pdf->Cell(135, 5, utf8_decode('Dirección: '.$refeComercialesAval3[1]['direccion']), 0, 1, 'R', );
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->ln(4);
    $pdf->Cell(100, 5, utf8_decode('_____________________________________________________'), 0, 1, 'L',0 );
    $pdf->Cell(100, 5, utf8_decode('Nombre o Firma del Aval Solidario'), 0, 0, 'C', 0);
    $pdf->Cell(95, 5, utf8_decode('Fecha Emisión: '.$datosSolicitud['fechaDesembolso']), 0, 1, 'R', 0);
    $pdf->Cell(190, 5, utf8_decode('OBSERVACIONES: '.$datosAval3['ObservacionesSolicitud']), 0, 1, 'L', 0);
    
    
}//fin del if si existe aval 3



/********************************** CENTRAL DE RIESGO ************************************************************/
$pdf->AddPage("portrait", "letter");
//encabezado
$pdf->Image('logo.png', 175, 10, 25); //logo de la empresa,moverDerecha,moverAbajo,tamañoIMG
$pdf->SetFont('Arial', 'B', 14); //tipo fuente, negrita(B-I-U-BIU), tamañoTexto
$pdf->SetTextColor(0, 0, 0); //color

//creamos una celda o fila
$pdf->Cell(195, 5, utf8_decode('ASOCIACIÓN DE DESARROLLO PESPIRENSE'), 0, 1, 'C', 0); // AnchoCelda,AltoCelda,titulo,borde(1-0),saltoLinea(1-0),posicion(L-C-R),ColorFondo(1-0)
$pdf->Cell(195, 5, utf8_decode('"ADEPES"'), 0, 1, 'C', 0);
$pdf->Ln(15); // Salto de línea
//fecha actual
$hoyFecha = date('d/m/Y');
$pdf->Cell(97, 5, utf8_decode('Pespire, Choluteca'), 0, 0, 'C', 0);
$pdf->Cell(97, 5, utf8_decode($hoyFecha), 0, 1, 'C', 0);
if(count($avales) >= 1 ){
    $pdf->Ln(5); // Salto de línea
    $pdf->SetFont('Arial', '', 12);
    $pdf->MultiCell(195, 10, utf8_decode('Yo '.$datosCliente['nombres'].' mayor de edad con #ident. '.$datosCliente['identidad'].' '.$datosCliente['estadoCivil'].
    ' con domicilio en '.$datosContactos[1]['valor'].', MUNICIPIO DE '.$datosCliente['municipio'].' por este medio estoy autorizando a la Asociación de Desarrollo Pespirence "ADEPES" a que '.
  'haga las consultas necesarias en la Central de Riesgo "TRANS UNION" sobre mi situación Crediticia y la de mis avales en el Sistema Financiero Nacional.'), 0, 'L');

   
   $pdf->Ln(20); // Salto de línea
   $pdf->SetFont('Arial', 'B',11); //tipo fuente, negrita(B-I-U-BIU), tamañoTexto
   $pdf->Cell(195, 10, utf8_decode('______________________________________'), 0, 1, 'C', 0);
   $pdf->Cell(195, 7, utf8_decode($datosCliente['nombres']), 0, 1, 'C', 0);
   $pdf->Cell(195, 7, utf8_decode($datosCliente['identidad']), 0, 1, 'C', 0);
   $pdf->Ln(15); // Salto de línea
  //aval 1
  $pdf->Cell(195, 10, utf8_decode('______________________________________'), 0, 1, 'C', 0);
  $pdf->Cell(195, 7, utf8_decode($datosAval1['nombres']), 0, 1, 'C', 0);
  $pdf->Cell(195, 7, utf8_decode($datosAval1['identidad']), 0, 1, 'C', 0);
  $pdf->Ln(15); // Salto de línea
  //aval 2
  if(count($avales) >= 2){
    $pdf->Cell(195, 10, utf8_decode('______________________________________'), 0, 1, 'C', 0);
    $pdf->Cell(195, 7, utf8_decode($datosAval2['nombres']), 0, 1, 'C', 0);
    $pdf->Cell(195, 7, utf8_decode($datosAval2['identidad']), 0, 1, 'C', 0);
    $pdf->Ln(15); // Salto de línea
  }
  //aval 3
  if(count($avales) >= 3){
    $pdf->Cell(195, 10, utf8_decode('______________________________________'), 0, 1, 'C', 0);
    $pdf->Cell(195, 7, utf8_decode($datosAval3['nombres']), 0, 1, 'C', 0);
    $pdf->Cell(195, 7, utf8_decode($datosAval3['identidad']), 0, 1, 'C', 0);
  }
  
  }else{ //no tiene avales
    $pdf->Ln(10); // Salto de línea
    $pdf->SetFont('Arial', '', 12);
    $pdf->MultiCell(195, 10, utf8_decode('Yo '.$datosCliente['nombres'].' mayor de edad con #ident. '.$datosCliente['identidad'].' '.$datosCliente['estadoCivil'].
    ' con domicilio en '.$datosContactos[1]['valor'].', MUNICIPIO DE '.$datosCliente['municipio'].' por este medio estoy autorizando a la Asociación de Desarrollo Pespirence "ADEPES" a que '.
    'haga las consultas necesarias en la Central de Riesgo "TRANS UNION" sobre mi situación Crediticia en el Sistema Financiero Nacional.'), 0, 'L');
   
   $pdf->Ln(20); // Salto de línea
   $pdf->SetFont('Arial', 'B',11); //tipo fuente, negrita(B-I-U-BIU), tamañoTexto
   $pdf->Cell(195, 10, utf8_decode('______________________________________'), 0, 1, 'C', 0);
   $pdf->Cell(195, 7, utf8_decode($datosCliente['nombres']), 0, 1, 'C', 0);
   $pdf->Cell(195, 7, utf8_decode($datosCliente['identidad']), 0, 1, 'C', 0);
  }
  



/********************************** FORMATO CONOZCA A SU CLIENTE ************************************************************/
$pdf->AddPage("portrait", "letter");
//encabezado
$pdf->Image('logo.png', 175, 10, 25); //logo de la empresa,moverDerecha,moverAbajo,tamañoIMG
$pdf->SetFont('Arial', 'B', 14); //tipo fuente, negrita(B-I-U-BIU), tamañoTexto
$pdf->SetTextColor(0, 0, 0); //color

//creamos una celda o fila
$pdf->Cell(195, 5, utf8_decode('ASOCIACIÓN DE DESARROLLO PESPIRENSE'), 0, 1, 'C', 0); // AnchoCelda,AltoCelda,titulo,borde(1-0),saltoLinea(1-0),posicion(L-C-R),ColorFondo(1-0)
$pdf->Cell(195, 5, utf8_decode('"ADEPES"'), 0, 1, 'C', 0);
$pdf->Ln(15); // Salto de línea
$pdf->SetFillColor(255,165,0); //colorFondo verde
$pdf->Cell(195, 10, utf8_decode('FORMATO CONOZCA A SU CLIENTE'), 0, 1, 'C', 1); 
$pdf->ln(4);
$pdf->SetFillColor(143,188,143); //colorFondo verde
$pdf->Cell(195, 10, utf8_decode('A. DATOS GENERALES'), 0, 1, 'C', 1); 
$pdf->ln(4);
$pdf->SetFont('Arial', '', 11); 
$pdf->Cell(195, 5, utf8_decode('Nombre: '.$datosCliente['nombres']), 0, 1, 'L', 0); 
$pdf->Cell(95, 5, utf8_decode('Fecha de Nacimiento: '.$datosCliente['fechaNacimiento']), 0, 0, 'L', 0); 
$pdf->Cell(100, 5, utf8_decode('# Identidad: '.$datosCliente['identidad']), 0, 1, 'R', 0); 
$pdf->Cell(95, 5, utf8_decode('Estado Civil: '.$datosCliente['estadoCivil']), 0, 0, 'L', 0); 
$pdf->Cell(100, 5, utf8_decode('Nacionalidad: '.$datosCliente['nacionalidad']), 0, 1, 'R', 0); 
$pdf->Cell(50, 5, utf8_decode('Genero: '.$datosCliente['genero']), 0, 0, 'L', 0); 
$pdf->Cell(145, 5, utf8_decode('Profesión, Ocupación u Oficio: '.$datosCliente['profesion']), 0, 1, 'R', 0); 
$pdf->Cell(95, 5, utf8_decode('Teléfono: '.$datosContactos[2]['valor']), 0, 0, 'L', 0); 
$pdf->Cell(100, 5, utf8_decode('Celular: '.$datosContactos[0]['valor']), 0, 1, 'R', 0); 
$pdf->SetFillColor(255,255,255); //colorFondo blanco
$pdf->MultiCell(195, 5, utf8_decode('Dirección de su Residencia: '.$datosContactos[1]['valor'].', '.$datosCliente['municipio']), 0, 1, 'L', 1);
if(!empty($datosCliente['idConyuge'])){
    $pdf->Cell(195, 5, utf8_decode('Nombre Conyugue: '.$datosParejaCliente['nombres']), 0, 1, 'L', 0); 
}
$pdf->MultiCell(195, 5, utf8_decode('Nombre de la Persona que Depende Económicamente: '.$datosSolicitud['dependiente']), 0, 1, 'L', 0); 
$pdf->Cell(195, 5, utf8_decode('Nombre de la Empresa en la que Labora: '.$datosCliente['PratronoNegocio']), 0, 1, 'L', 0); 
$pdf->MultiCell(195, 5, utf8_decode('Dirección de su Trabajo: '.$datosContactos[3]['valor']), 0, 1, 'L', 1);
$pdf->Cell(195, 5, utf8_decode('Teléfono Trabajo: '.$datosContactos[4]['valor']), 0, 1, 'L', 0); 
$pdf->Cell(195, 5, utf8_decode('Cargo que Desempeña: '.$datosCliente['profesion']), 0, 1, 'L', 0); 
$pdf->Cell(195, 5, utf8_decode('Tiempo de Laborar en la Empresa: '.$datosCliente['tiempoLaboral']), 0, 1, 'L', 0); 
$pdf->Cell(195, 5, utf8_decode('Bienes que posee: '.$datosCliente['bienes']), 0, 1, 'L', 0); 
$pdf->ln(2);
$pdf->SetFillColor(143,188,143); //colorFondo verde
$pdf->SetFont('Arial', 'B', 14); //tipo fuente, negrita(B-I-U-BIU), tamañoTexto
$pdf->Cell(195, 10, utf8_decode('B. ACTIVIDAD ECONÓMICA'), 0, 1, 'C', 1); 
$pdf->SetFillColor(255,255,255); //colorFondo blanco
$pdf->ln(2);
$pdf->SetFont('Arial', '', 11); //tipo fuente, negrita(B-I-U-BIU), tamañoTexto
$pdf->MultiCell(195, 5, utf8_decode('Actividad Económica que realiza: '.$datosCliente['cargoDesempena']), 0, 1, 'L', 0);
$pdf->Cell(195, 5, utf8_decode('Total Ingresos Mensuales: L. '.$datosAnalisis['totalIngresos']), 0, 1, 'L', 0); 
$pdf->ln(2);
$pdf->SetFillColor(143,188,143); //colorFondo verde
$pdf->SetFont('Arial', 'B', 14); //tipo fuente, negrita(B-I-U-BIU), tamañoTexto
$pdf->Cell(195, 10, utf8_decode('C. PERFIL TRANSACCIONAL'), 0, 1, 'C', 1); 
$pdf->ln(2);
$pdf->MultiCell(30, 8, utf8_decode('PRÉSTAMO'), 0, 1, 'L', 0);
$pdf->SetFillColor(255,255,255); //colorFondo verde
$pdf->SetFont('Arial', '', 10); //tipo fuente, negrita(B-I-U-BIU), tamañoTexto
$pdf->MultiCell(195, 5, utf8_decode('La Asociacion de Desarrollo Pespirense ADEPES cuenta y aplica políticas y código de etica para el reguardo de la informacion de sus clientes, así como para el impedimento de la utilización de sus datos por parte de terceros ajenos a la Asociación.'), 0, 1, 'L', 0);
$pdf->ln(4);
$pdf->MultiCell(195, 5, utf8_decode('Declaro que este formulario contiene información que he sumunistrado y que es fiel y verdadera, por lo tanto acepto que cualquier falsedad por acción u omisión de mi parte dara derecho a ADEPES a cancelar la relacion crediticia.'), 0, 1, 'L', 0);
$pdf->ln(10);
$pdf->SetFont('Arial', 'B', 11); //tipo fuente, negrita(B-I-U-BIU), tamañoTexto
$pdf->Cell(195, 10, utf8_decode('__________________________________________'), 0, 1, 'C', 1); 
$pdf->Cell(195, 10, utf8_decode('Firma y Huella del Cliente'), 0, 1, 'C', 1); 
$pdf->ln(5);
$pdf->Cell(195, 10, utf8_decode('Fecha '.$datosSolicitud['fechaDesembolso']), 0, 1, 'R', 1);



  /********************************** COMITE DE CREDITO ************************************************************/
if($datosSolicitud['numeroActa'] != ""){
    $pdf->AddPage("landscape", "letter");
    //encabezado

    $pdf->Image('logo.png', 240, 10, 30); //logo de la empresa,moverDerecha,moverAbajo,tamañoIMG
    $pdf->SetFont('Arial', 'B', 14); //tipo fuente, negrita(B-I-U-BIU), tamañoTexto
    $pdf->Cell(45); // Movernos a la derecha
    $pdf->SetTextColor(0, 0, 0); //color
        
    //creamos una celda o fila
    $pdf->Cell(170, 10, utf8_decode('ASOCIACIÓN DE DESARROLLO PESPIRENSE'), 0, 1, 'C', 0); // AnchoCelda,AltoCelda,titulo,borde(1-0),saltoLinea(1-0),posicion(L-C-R),ColorFondo(1-0)
    $pdf->Cell(140, 2, utf8_decode('"ADEPES"'), 0, 1, 'R', 0);
    $pdf->Cell(255, 10, utf8_decode('Proyecto Fondo Rotatorio'), 0, 1, 'C', 0); 
    $pdf->Cell(255, 5, utf8_decode('Acta # '.$datosSolicitud['numeroActa']), 0, 1, 'C', 0);
    $pdf->Ln(12); // Salto de línea
    $pdf->SetTextColor(0, 0, 0); //color
    $pdf->SetFont('Arial', 'I', 12); //tipo fuente, negrita(B-I-U-BIU), tamañoTexto
    $pdf->Cell(255, 5, utf8_decode('Resolución'), 0, 1, 'C', 0); 
    $pdf->Cell(270, 5, utf8_decode('Reunidos el Comite de Crédito:'), 0, 1, 'L', 0);
    $pdf->Cell(270, 5, utf8_decode('Se ingreso la solicitud de préstamo del proyecto de fondo rotatorio:'), 0, 1, 'L', 0);
    

    /* CAMPOS DE LA TABLA */
    //color
    $pdf->SetFillColor(204, 198, 196); //colorFondo
    $pdf->SetTextColor(0, 0, 0); //colorTexto
    $pdf->SetDrawColor(163, 163, 163); //colorBorde
    $pdf->SetFont('Arial', 'B', 12);

    $pdf->Cell(10, 10, utf8_decode('N°'), 1, 0, 'C', 1);
    $pdf->Cell(85, 10, utf8_decode('NOMBRE'), 1, 0, 'C', 1);
    $pdf->Cell(25, 10, utf8_decode('MONTO'), 1, 0, 'C', 1);
    $pdf->Cell(15, 10, utf8_decode('PLAZO'), 1, 0, 'C', 1);
    $pdf->Cell(30, 10, utf8_decode('GARANTÍA'), 1, 0, 'C', 1);
    $pdf->Cell(70, 10, utf8_decode('DESTINO'), 1, 0, 'C', 1);
    $pdf->Cell(25, 10, utf8_decode('ESTADO'), 1, 1, 'C', 1);

    $pdf->SetFont('Arial', '',11);
    $pdf->SetDrawColor(163, 163, 163); //colorBorde
    $pdf->SetWidths(array(10, 85, 25, 15, 30, 70, 25)); //tamanio de las celdas segun el encabezado de la tabla


    /* TABLA */
    $pdf->Row(array("1", $datosSolicitud['nombres'].' '.$datosSolicitud['apellidos'], $datosSolicitud['Monto'], $datosSolicitud['Plazo'], $datosSolicitud['Prestamo'], 
                $datosSolicitud['invierteEn'], $datosSolicitud['estadoSolicitud']), 0 );
        
    
    $pdf->SetFont('Arial', 'B',12);
    //PARA MARCO DE PAGINA
    $pdf->SetLineWidth(1);
    $pdf->Rect(5, 5, 270, 205); 

    $pdf->Ln(20); // Salto de línea
    $pdf->Cell(250, 10, utf8_decode('____________________________                    ____________________________'), 0, 1, 'C', 0);
    $pdf->Cell(240, 10, utf8_decode('      Presidente                                                               Secretario'), 0, 1, 'C', 0);
    $pdf->Ln(15); // Salto de línea
    $pdf->Cell(250, 10, utf8_decode('____________________________                    ____________________________'), 0, 1, 'C', 0);
    $pdf->Cell(240, 10, utf8_decode('    Vocal I                                                                    Vocal II'), 0, 1, 'C', 0);
    $pdf->Ln(15); // Salto de línea
    $pdf->Cell(250, 10, utf8_decode('____________________________'), 0, 1, 'C', 0);
    $pdf->Cell(240, 10, utf8_decode('         Vocal III'), 0, 1, 'C', 0);
    $pdf->Output('ComiteCreditoActa#'.$datosSolicitud['numeroActa'].'.pdf', 'I');//nombreDescarga, Visor(I->visualizar - D->descargar)

}






$pdf->Output('Solicitud_'.$datosSolicitud['nombres'].' '.$datosSolicitud['apellidos'], 'I');

?>