<?php
    // Establecer la zona horaria de Honduras
    date_default_timezone_set('America/Tegucigalpa');
// Recibir los datos enviados por AJAX
if (isset($_POST['data'])) {
    $jsonData = $_POST['data'];
   
    $datosFiltradosOrdenados = json_decode($jsonData, true); // Decodificar los datos JSON
    
    if (empty($datosFiltradosOrdenados)) { // Verificar si hay datos para generar el PDF
        echo 'No hay datos disponibles para generar el PDF.';
        exit; // Terminar la ejecución del script
    }
    require('./fpdf.php'); // Generar el PDF utilizando FPDF
class PDF extends FPDF
{
   function Header() // Cabecera de página
   {
      $this->Image('logo.png', 235, 15, 30); //logo de la empresa,moverDerecha,moverAbajo,tamañoIMG
      $this->SetFont('Arial', 'B', 14); //tipo fuente, negrita(B-I-U-BIU), tamañoTexto
      $this->Cell(45); // Movernos a la derecha
      $this->SetTextColor(0, 0, 0); //color
       
      //creamos una celda o fila
      $this->Cell(180, 15, utf8_decode('ASOCIACIÓN DE DESARROLLO PESPIRENSE'), 0, 1, 'C', 0); // AnchoCelda,AltoCelda,titulo,borde(1-0),saltoLinea(1-0),posicion(L-C-R),ColorFondo(1-0)
      $this->Cell(145, 2, utf8_decode('"ADEPES"'), 0, 1, 'R', 0);
      $this->Ln(3); // Salto de línea
      $this->SetTextColor(103); //color
      $this->Ln(3); // Salto de línea
    
      /* TITULO DE LA TABLA */
      //color
      $this->SetTextColor(0, 0, 0);
      $this->Cell(122); // mover a la derecha
      $this->SetFont('Arial', 'B', 12);
      $this->Cell(20, 10, utf8_decode("LISTADO DE TIPOS DE CONTACTOS"), 0, 1, 'C', 0);
      $this->Ln(7);
      $this->SetLeftMargin(105);

      /* CAMPOS DE LA TABLA */
      //color
      $this->SetFillColor(204, 198, 196); //colorFondo
      $this->SetTextColor(0, 0, 0); //colorTexto
      $this->SetDrawColor(163, 163, 163); //colorBorde
      $this->SetFont('Arial', 'B', 10);

     $this->Cell(10, 10, utf8_decode('NO.'), 1, 0, 'C', 1);
     $this->Cell(60, 10, utf8_decode('CONTACTOS'), 1, 0, 'C', 1);
     $this->Ln();
   }
   // Pie de página
   function Footer(){
      $this->SetY(-15); // Posición: a 1,5 cm del final
      $this->SetFont('Arial', 'I', 8); //tipo fuente, negrita(B-I-U-BIU), tamañoTexto
      $this->Cell(65, 10, utf8_decode('Página ') . $this->PageNo() . '/{nb}', 0, 0, 'C'); //pie de pagina(numero de pagina)
       //fecha
       $this->SetY(-15); // Posición: a 1,5 cm del final
      $this->SetFont('Arial', 'I', 8); //tipo fuente, negrita(B-I-U-BIU), tamañoTexto
      $hoy = date('d/m/Y H:i:s');
      $this->Cell(270, 10, utf8_decode('Fecha y Hora de impresión:'.$hoy), 0, 0, 'C');
   }
}

$pdf = new PDF();
$pdf->AddPage("landscape","letter"); /* aqui entran dos para parametros (horientazion,tamaño)V->portrait H->landscape tamaño (A3.A4.A5.letter.legal) */
$pdf->AliasNbPages(); //muestra la pagina / y total de paginas

$i=1;
$pdf->SetFont('Arial', '', 8);
$pdf->SetDrawColor(163, 163, 163); //colorBorde 
    //construir el contenido del PDF DE LOS DATOS OBTENIDOS DEL DATATABLESS
    foreach ($datosFiltradosOrdenados as $fila) {
        //$pdf->Cell(10, 10, $i++, 1, 0, 'C', 0); //LOS NOMBRE SON DE LA FUNCION: LlenarTablaSolicitudes JS
        $pdf->Cell(10, 10, $fila['NO'], 1, 0, 'C', 0);
        $pdf->Cell(60, 10, utf8_decode($fila['CONTACTO']), 1, 0, 'C', 0);
        $pdf->Ln();
    }
    // Enviar el PDF al navegador para su descarga 
    $pdf->Output('listado_de_Tipo_de_Contactos.pdf', 'I'); //nombre de descarga
} else {
    echo 'error';
}
?>