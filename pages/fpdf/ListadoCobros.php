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
      $this->Cell(20, 10, utf8_decode("LISTADO DE COBROS"), 0, 1, 'C', 0);
      $this->Ln(7);

      /* CAMPOS DE LA TABLA */
      //color
      $this->SetFillColor(204, 198, 196); //colorFondo
      $this->SetTextColor(0, 0, 0); //colorTexto
      $this->SetDrawColor(163, 163, 163); //colorBorde
      $this->SetFont('Arial', 'B', 10);

     $this->Cell(10, 10, utf8_decode('N°'), 1, 0, 'C', 1);
     $this->Cell(57, 10, utf8_decode('NOMBRE COMPLETO'), 1, 0, 'C', 1);
     $this->Cell(31, 10, utf8_decode('IDENTIDAD'), 1, 0, 'C', 1);
     $this->Cell(22, 10, utf8_decode('MONTO'), 1, 0, 'C', 1);
     $this->Cell(25, 10, utf8_decode('PLAZO'), 1, 0, 'C', 1);
     $this->Cell(70, 10, utf8_decode('FECHA DESEMBOLSO'), 1, 0, 'C', 1);
     $this->Cell(42, 10, utf8_decode('ESTADO'), 1, 0, 'C', 1);
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

}  //fin de la clase fpdf

$pdf = new PDF();
$pdf->AddPage("landscape","letter"); /* aqui entran dos para parametros (horientazion,tamaño)V->portrait H->landscape tamaño (A3.A4.A5.letter.legal) */
$pdf->AliasNbPages(); //muestra la pagina / y total de paginas

$i=1;
$pdf->SetFont('Arial', '', 10);
$pdf->SetDrawColor(163, 163, 163); //colorBorde
$pdf->SetWidths(array(10, 57, 31, 22, 25, 70, 42)); //tamanio de las celdas segun el encabezado de la tabla
 


    //construir el contenido del PDF DE LOS DATOS OBTENIDOS DEL DATATABLESS
foreach ($datosFiltradosOrdenados as $fila) {

    $pdf->Row(array($fila['idSolicitud'], $fila['nombre'], $fila['identidad'], $fila['Monto'],  $fila['Plazo'], $fila['FechaDesembolso'],strip_tags(utf8_decode($fila['idEstadoPlanPagos']))), 0 );
    
    
}



    
    // Enviar el PDF al navegador para su descarga 
    $pdf->Output('listado_de_clientes.pdf', 'I'); //nombre de descarga
} else {
    echo 'error';
}
?>