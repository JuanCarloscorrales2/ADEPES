<?php
    // Establecer la zona horaria de Honduras
    date_default_timezone_set('America/Tegucigalpa');
// Recibir los datos enviados por AJAX
if (isset($_POST['data'])) {
    $jsonData = $_POST['data'];

    // Decodificar los datos JSON
    $datosFiltradosOrdenados = json_decode($jsonData, true);

    // Verificar si hay datos para generar el PDF
    if (empty($datosFiltradosOrdenados)) {
        echo 'No hay datos disponibles para generar el PDF.';
        exit; // Terminar la ejecución del script
    }

    // Generar el PDF utilizando FPDF
    require('./fpdf.php');
class PDF extends FPDF
{

   // Cabecera de página
   function Header()
   {
      //include '../../recursos/Recurso_conexion_bd.php';//llamamos a la conexion BD

      //$consulta_info = $conexion->query(" select *from hotel ");//traemos datos de la empresa desde BD
      //$dato_info = $consulta_info->fetch_object();
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
      //fecha
      /*$this->SetTextColor(0, 0, 0); //color
      $this->SetFont('Arial', 'B', 12); //tipo fuente, negrita(B-I-U-BIU), tamañoTexto
      $hoy = date('d/m/Y');
      $this->Cell(10, 10, utf8_decode('FECHA:'.$hoy), 0, 0, 'L', 0);*/
      

      /* TITULO DE LA TABLA */
      //color
      $this->SetTextColor(0, 0, 0);
      $this->Cell(122); // mover a la derecha
      $this->SetFont('Arial', 'B', 12);
      $this->Cell(25, 10, utf8_decode("LISTADO DE PRÉSTAMOS"), 0, 1, 'C', 0);
      $this->Ln(7);

      /* CAMPOS DE LA TABLA */
      //color
      $this->SetFillColor(204, 198, 196); //colorFondo
      $this->SetTextColor(0, 0, 0); //colorTexto
      $this->SetDrawColor(163, 163, 163); //colorBorde
      $this->SetFont('Arial', 'B', 10);

     $this->Cell(13, 10, utf8_decode('N°'), 1, 0, 'C', 1);
     $this->Cell(65, 10, utf8_decode('NOMBRE COMPLETO'), 1, 0, 'C', 1);
     $this->Cell(36, 10, utf8_decode('TIPO DE PRÉSTAMO'), 1, 0, 'C', 1);
     $this->Cell(25, 10, utf8_decode('MONTO'), 1, 0, 'C', 1);
     $this->Cell(40, 10, utf8_decode('FECHA DESEMBOLSO'), 1, 0, 'C', 1);
     $this->Cell(20, 10, utf8_decode('PLAZO'), 1, 0, 'C', 1);
     $this->Cell(30, 10, utf8_decode('RUBRO'), 1, 0, 'C', 1);
     $this->Cell(27, 10, utf8_decode('ESTADO'), 1, 0, 'C', 1);
     $this->Ln();

   }

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
      $this->Cell(455, 10, utf8_decode('Fecha y Hora de impresión:'.$hoy), 0, 0, 'C');
   }
}

$pdf = new PDF();
$pdf->AddPage("landscape","letter"); /* aqui entran dos para parametros (horientazion,tamaño)V->portrait H->landscape tamaño (A3.A4.A5.letter.legal) */
$pdf->AliasNbPages(); //muestra la pagina / y total de paginas

$i=1;
$pdf->SetFont('Arial', '', 9);
$pdf->SetDrawColor(163, 163, 163); //colorBorde

       
    //construir el contenido del PDF DE LOS DATOS OBTENIDOS DEL DATATABLESS
    foreach ($datosFiltradosOrdenados as $fila) {
        $pdf->Cell(13, 10, $fila['idSolicitud'], 1, 0, 'C', 0); //LOS NOMBRE SON DE LA FUNCION: LlenarTablaSolicitudes JS
        $pdf->Cell(65, 10, $fila['Nombre'], 1, 0, 'C', 0);
        $pdf->Cell(36, 10, $fila['Prestamo'], 1, 0, 'C', 0);
        $pdf->Cell(25, 10, $fila['Monto'], 1, 0, 'C', 0);
        $pdf->Cell(40, 10, $fila['Desembolso'], 1, 0, 'C', 0);
        $pdf->Cell(20, 10, utf8_decode($fila['Plazo']), 1, 0, 'C', 0);
        $pdf->Cell(30, 10, utf8_decode($fila['Rubro']), 1, 0, 'C', 0);
        $pdf->Cell(27, 10, utf8_decode($fila['Descripcion']), 1, 0, 'C', 0);

        $pdf->Ln();
        
    }


    // Enviar el PDF al navegador para su descarga 
    $pdf->Output('listado_de_clientes.pdf', 'I'); //nombre de descarga
} else {
    echo 'error';
}
?>