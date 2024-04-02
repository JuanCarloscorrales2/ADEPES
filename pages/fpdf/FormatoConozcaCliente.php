<?php

require('./fpdf.php');
// Establecer la zona horaria de Honduras
date_default_timezone_set('America/Tegucigalpa');
if (isset($_GET['nombreCliente'])) {
    $nombreCliente = $_GET['nombreCliente'];
    $identidadCliente = $_GET['identidadCliente'];
    $estadoCivilCliente = $_GET['estadoCivilCliente'];
    $municipioFormato = $_GET['municipioFormato'];
    $direccionCliente = $_GET['direccionCliente'];
    $FechaEmisionFormato = $_GET['FechaEmisionFormato'];
    $fechaNacimientoFormato = $_GET['fechaNacimientoFormato'];
    $NacionalidadFormato = $_GET['NacionalidadFormato'];
    $GeneroFormato = $_GET['GeneroFormato'];
    $ProfesionFormato = $_GET['ProfesionFormato'];
    $CelularFormato = $_GET['CelularFormato'];
    $telefonoFormato = $_GET['telefonoFormato'];
    $NombreConyugueFormato = $_GET['NombreConyugueFormato'];
    $PatronoFormato = $_GET['PatronoFormato'];
    $DependienteFormato = $_GET['DependienteFormato'];
    $DireccionTrabajoFormato = $_GET['DireccionTrabajoFormato'];
    $TelefonoTrabajoFormato = $_GET['TelefonoTrabajoFormato'];
    $BienesFormato = $_GET['BienesFormato'];
    $ActividadDesempenaFormato = $_GET['ActividadDesempenaFormato'];
    $tiempoLaboral = $_GET['tiempoLaboral'];
    $TotalIngresosFormato = $_GET['TotalIngresosFormato'];

} else {
  // Manejo de error si no se recibieron todas las variables necesarias
  http_response_code(400); // Solicitud incorrecta
  echo 'No se proporcionaron todos los datos necesarios';
}



class PDF extends FPDF
{
   // Pie de página
   function Footer()
   {
      $this->SetY(-15); // Posición: a 1,5 cm del final
      $this->SetFont('Arial', 'I', 8); //tipo fuente, negrita(B-I-U-BIU), tamañoTexto
      $this->Cell(0, 10, utf8_decode('Página ') . $this->PageNo() . '/{nb}', 0, 0, 'C'); //pie de pagina(numero de pagina)
       //fecha
       $this->SetY(-15); // Posición: a 1,5 cm del final
      $this->SetFont('Arial', 'I', 8); //tipo fuente, negrita(B-I-U-BIU), tamañoTexto
      $hoy = date('d/m/Y H:i:s');
      $this->Cell(320, 10, utf8_decode('Fecha y Hora de impresión:'.$hoy), 0, 0, 'C');
      
   }
}




$pdf = new PDF();
/********************************** FORMATO CONOZCA A SU CLIENTE ************************************************************/
$pdf->AddPage("portrait", "letter");
$pdf->AliasNbPages(); //muestra la pagina / y total de paginas
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
$pdf->Cell(195, 5, utf8_decode('Nombre: '.$nombreCliente), 0, 1, 'L', 0); 
$pdf->Cell(95, 5, utf8_decode('Fecha de Nacimiento: '.$fechaNacimientoFormato), 0, 0, 'L', 0); 
$pdf->Cell(100, 5, utf8_decode('# Identidad: '.$identidadCliente), 0, 1, 'R', 0); 
$pdf->Cell(95, 5, utf8_decode('Estado Civil: '. $estadoCivilCliente), 0, 0, 'L', 0); 
$pdf->Cell(100, 5, utf8_decode('Nacionalidad: '.$NacionalidadFormato), 0, 1, 'R', 0); 
$pdf->Cell(50, 5, utf8_decode('Genero: '.$GeneroFormato), 0, 0, 'L', 0); 
$pdf->Cell(145, 5, utf8_decode('Profesión, Ocupación u Oficio: '.$ProfesionFormato), 0, 1, 'R', 0); 
$pdf->Cell(95, 5, utf8_decode('Teléfono: '.$telefonoFormato), 0, 0, 'L', 0); 
$pdf->Cell(100, 5, utf8_decode('Celular: '.$CelularFormato), 0, 1, 'R', 0); 
$pdf->SetFillColor(255,255,255); //colorFondo blanco
$pdf->MultiCell(195, 5, utf8_decode('Dirección de su Residencia: '. $direccionCliente.', '. $municipioFormato), 0, 1, 'L', 1);
if(!empty($NombreConyugueFormato)){
    $pdf->Cell(195, 5, utf8_decode('Nombre Conyugue: '.$NombreConyugueFormato), 0, 1, 'L', 0); 
}
$pdf->MultiCell(195, 5, utf8_decode('Nombre de la Persona que Depende Económicamente: '.$DependienteFormato), 0, 1, 'L', 0); 
$pdf->Cell(195, 5, utf8_decode('Nombre de la Empresa en la que Labora: '. $PatronoFormato), 0, 1, 'L', 0); 
$pdf->MultiCell(195, 5, utf8_decode('Dirección de su Trabajo: '.$DireccionTrabajoFormato), 0, 1, 'L', 1);
$pdf->Cell(195, 5, utf8_decode('Teléfono Trabajo: '.$TelefonoTrabajoFormato), 0, 1, 'L', 0); 
$pdf->Cell(195, 5, utf8_decode('Cargo que Desempeña: '.$ProfesionFormato), 0, 1, 'L', 0); 
$pdf->Cell(195, 5, utf8_decode('Tiempo de Laborar en la Empresa: '.$tiempoLaboral), 0, 1, 'L', 0); 
$pdf->Cell(195, 5, utf8_decode('Bienes que posee: '. $BienesFormato), 0, 1, 'L', 0); 
$pdf->ln(2);
$pdf->SetFillColor(143,188,143); //colorFondo verde
$pdf->SetFont('Arial', 'B', 14); //tipo fuente, negrita(B-I-U-BIU), tamañoTexto
$pdf->Cell(195, 10, utf8_decode('B. ACTIVIDAD ECONÓMICA'), 0, 1, 'C', 1); 
$pdf->SetFillColor(255,255,255); //colorFondo blanco
$pdf->ln(2);
$pdf->SetFont('Arial', '', 11); //tipo fuente, negrita(B-I-U-BIU), tamañoTexto
$pdf->MultiCell(195, 5, utf8_decode('Actividad Económica que realiza: '.$ActividadDesempenaFormato), 0, 1, 'L', 0);
$pdf->Cell(195, 5, utf8_decode('Total Ingresos Mensuales: L. '. $TotalIngresosFormato), 0, 1, 'L', 0); 
$pdf->ln(2);
$pdf->SetFillColor(143,188,143); //colorFondo verde
$pdf->SetFont('Arial', 'B', 14); //tipo fuente, negrita(B-I-U-BIU), tamañoTexto
$pdf->Cell(195, 10, utf8_decode('C. PERFIL TRANSACCIONAL'), 0, 1, 'C', 1); 
$pdf->ln(2);
$pdf->MultiCell(30, 8, utf8_decode('PRÉSTAMO'), 0, 1, 'L', 0);
$pdf->SetFillColor(255,255,255); //colorFondo verde
$pdf->SetFont('Arial', '', 10); //tipo fuente, negrita(B-I-U-BIU), tamañoTexto
$pdf->MultiCell(195, 5, utf8_decode('La Asociacion de Desarrollo Pespirense ADEPES cuenta y aplica políticas y código de ética para el reguardo de la información de sus clientes, así como para el impedimento de la utilización de sus datos por parte de terceros ajenos a la Asociación.'), 0, 'J', 0);
$pdf->ln(4);
$pdf->MultiCell(195, 5, utf8_decode('Declaro que este formulario contiene información que he sumunistrado y que es fiel y verdadera, por lo tanto acepto que cualquier falsedad por acción u omisión de mi parte dara derecho a ADEPES a cancelar la relacion crediticia.'), 0, 'J', 0);
$pdf->ln(10);
$pdf->SetFont('Arial', 'B', 11); //tipo fuente, negrita(B-I-U-BIU), tamañoTexto
$pdf->Cell(195, 10, utf8_decode('__________________________________________'), 0, 1, 'C', 1); 
$pdf->Cell(195, 10, utf8_decode('Firma y Huella del Cliente'), 0, 1, 'C', 1); 
$pdf->ln(5);
$pdf->Cell(195, 10, utf8_decode('Fecha Emisón '.$FechaEmisionFormato), 0, 1, 'R', 1);



$pdf->Output('FormatoConozcaAsuCliente_'.$nombreCliente.'', 'I');//nombreDescarga, Visor(I->visualizar - D->descargar)


?>