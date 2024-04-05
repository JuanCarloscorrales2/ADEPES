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
     
      

      /* TITULO DE LA TABLA */
      //color
      $this->SetTextColor(0, 0, 0);
      $this->Cell(115); // mover a la derecha
      $this->SetFont('Arial', 'B', 12);
      $this->Cell(35, 10, utf8_decode("LISTADO DE PERMISOS"), 0, 1, 'C', 0);
      $this->Ln(7);

      /* CAMPOS DE LA TABLA */
      //color
      $this->SetFillColor(204, 198, 196); //colorFondo
      $this->SetTextColor(0, 0, 0); //colorTexto
      $this->SetDrawColor(163, 163, 163); //colorBorde
      $this->SetFont('Arial', 'B', 11);

     $this->Cell(15, 10, utf8_decode('NO.'), 1, 0, 'C', 1);
     $this->Cell(50, 10, utf8_decode('ROL'), 1, 0, 'C', 1);
     $this->Cell(50, 10, utf8_decode('OBJETO'), 1, 0, 'C', 1);
     $this->Cell(30, 10, utf8_decode('CONSULTAR'), 1, 0, 'C', 1);
     $this->Cell(25, 10, utf8_decode('INSERTAR'), 1, 0, 'C', 1);
     $this->Cell(30, 10, utf8_decode('ACTUALIZAR'), 1, 0, 'C', 1);
     $this->Cell(30, 10, utf8_decode('ELIMINAR'), 1, 0, 'C', 1);
     $this->Cell(40, 10, utf8_decode('GENERAR REPORTE'), 1, 0, 'C', 1);
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
      $this->Cell(470, 10, utf8_decode('Fecha y Hora de impresión: '.$hoy), 0, 0, 'C');
      
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

} //fin de la clase FPDF

   
$pdf = new PDF();
$pdf->AddPage("landscape","A4"); /* aqui entran dos para parametros (horientazion,tamaño)V->portrait H->landscape tamaño (A3.A4.A5.letter.legal) */
$pdf->AliasNbPages(); //muestra la pagina / y total de paginas

$i = 0;
$pdf->SetFont('Arial', '', 10);
$pdf->SetDrawColor(163, 163, 163); //colorBorde
$pdf->SetWidths(array(15, 50, 50, 30, 25, 30, 30, 40));    
//construir el contenido del PDF DE LOS DATOS OBTENIDOS DEL DATATABLESS
foreach ($datosFiltradosOrdenados as $fila) {
    
    $pdf->Row(array( $fila['IdSe'],$fila['Rol'],$fila['Objeto'],strip_tags(utf8_decode($fila['Consultar'])), strip_tags(utf8_decode($fila['Insertar'])), strip_tags(utf8_decode($fila['Actualizar'])), strip_tags(utf8_decode($fila['Eliminar'])), strip_tags(utf8_decode($fila['Reportes']))), 0 );
    
}


    // Enviar el PDF al navegador para su descarga 
    $pdf->Output('listado_de_permisos.pdf', 'I'); //nombre de descarga
} else {
    echo 'error';
}
?>

