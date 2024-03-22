<?php

require('./fpdf.php');
// Establecer la zona horaria de Honduras
date_default_timezone_set('America/Tegucigalpa');
require "../../config/Conexion.php";
$idSoli = isset($_GET['idSoli']) ? $_GET['idSoli'] : '';


if ($idSoli) {
    try {
        $cnx = Conexion::ConectarDB(); // Llamamos al método estático para obtener la conexión
    
        //consulta SQL
        $consulta = $cnx->prepare("
            SELECT solicitud.idSolicitud, persona.nombres, persona.apellidos, prestamo.Descripcion as Prestamo, solicitud.invierteEn,
                solicitud.Monto, solicitud.Plazo, estado.Descripcion as estadoSolicitud, solicitud.numeroActa
            FROM tbl_mn_solicitudes_creditos solicitud
            INNER JOIN tbl_mn_personas persona ON solicitud.idPersona = persona.idPersona
            INNER JOIN tbl_mn_estados_solicitudes estado ON solicitud.idEstadoSolicitud = estado.idEstadoSolicitud
            INNER JOIN tbl_mn_tipos_prestamos prestamo ON solicitud.idTipoPrestamo = prestamo.idTipoPrestamo
            WHERE solicitud.idSolicitud = :idSoli
        ");
    
        // Asignar el valor del parámetro
        $consulta->bindParam(':idSoli', $idSoli);
    
        // Ejecutar la consulta preparada
        $consulta->execute();
        $datosSolicitud = $consulta->fetch(PDO::FETCH_ASSOC); // Almacena los datos de la solicitud en un array asociativo
    
        // Puedes utilizar $datosSolicitud según tus necesidades
        // Por ejemplo, acceder a $datosSolicitud['nombres'], $datosSolicitud['Prestamo'], etc.
      $numeroActa =$datosSolicitud['numeroActa'];
    } catch (PDOException $ex) {
        die($ex->getMessage());
    }
}


class PDF extends FPDF
{
    private $numeroActa;

    function __construct($numeroActa) {
        parent::__construct();
        $this->numeroActa = $numeroActa;
   
    }
    

   // Cabecera de página
   function Header()
   {
      $this->Image('logo.png', 240, 10, 30); //logo de la empresa,moverDerecha,moverAbajo,tamañoIMG
      $this->SetFont('Arial', 'B', 14); //tipo fuente, negrita(B-I-U-BIU), tamañoTexto
      $this->Cell(45); // Movernos a la derecha
      $this->SetTextColor(0, 0, 0); //color
       
      //creamos una celda o fila
      $this->Cell(170, 10, utf8_decode('ASOCIACIÓN DE DESARROLLO PESPIRENSE'), 0, 1, 'C', 0); // AnchoCelda,AltoCelda,titulo,borde(1-0),saltoLinea(1-0),posicion(L-C-R),ColorFondo(1-0)
      $this->Cell(140, 2, utf8_decode('"ADEPES"'), 0, 1, 'R', 0);
      $this->Cell(255, 10, utf8_decode('Proyecto Fondo Rotatorio'), 0, 1, 'C', 0); 
      $this->Cell(255, 5, utf8_decode('Acta # '.$this->numeroActa), 0, 1, 'C', 0);
      
      $this->Ln(3); // Salto de línea
      $this->SetTextColor(103); //color
      $this->Ln(3); // Salto de línea 
      //fecha
      $this->SetTextColor(0, 0, 0); //color
      $this->SetFont('Arial', 'I', 12); //tipo fuente, negrita(B-I-U-BIU), tamañoTexto
      $this->Cell(255, 5, utf8_decode('Resolución'), 0, 1, 'C', 0); 
      $this->Cell(270, 5, utf8_decode('Reunidos el Comite de Crédito:'), 0, 1, 'L', 0);
      $this->Cell(270, 5, utf8_decode('Se ingreso la solicitud de préstamo del proyecto de fondo rotatorio:'), 0, 1, 'L', 0);
      

      /* TITULO DE LA TABLA */
       /* CAMPOS DE LA TABLA */
      //color
     $this->SetFillColor(204, 198, 196); //colorFondo
      $this->SetTextColor(0, 0, 0); //colorTexto
      $this->SetDrawColor(163, 163, 163); //colorBorde
      $this->SetFont('Arial', 'B', 10);

     $this->Cell(10, 10, utf8_decode('N°'), 1, 0, 'C', 1);
     $this->Cell(85, 10, utf8_decode('NOMBRE'), 1, 0, 'C', 1);
     $this->Cell(25, 10, utf8_decode('MONTO'), 1, 0, 'C', 1);
     $this->Cell(15, 10, utf8_decode('PLAZO'), 1, 0, 'C', 1);
     $this->Cell(30, 10, utf8_decode('GARANTÍA'), 1, 0, 'C', 1);
     $this->Cell(70, 10, utf8_decode('DESTINO'), 1, 0, 'C', 1);
     $this->Cell(25, 10, utf8_decode('ESTADO'), 1, 1, 'C', 1);
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
      $this->Cell(450, 10, utf8_decode('Fecha y Hora de impresión:'.$hoy), 0, 0, 'C');
      
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


$pdf = new PDF($numeroActa);
$pdf->AddPage("landscape", "letter"); /* carta: letter, aqui entran dos para parametros (horientazion,tamaño)V->portrait H->landscape tamaño (A3.A4.A5.letter.legal) */
$pdf->AliasNbPages(); //muestra la pagina / y total de paginas


$pdf->SetFont('Arial', '',10);
$pdf->SetDrawColor(163, 163, 163); //colorBorde
$pdf->SetWidths(array(10, 85, 25, 15, 30, 70, 25)); //tamanio de las celdas segun el encabezado de la tabla


/* TABLA */
$pdf->Row(array("1", $datosSolicitud['nombres'].' '.$datosSolicitud['apellidos'], $datosSolicitud['Monto'], $datosSolicitud['Plazo'], $datosSolicitud['Prestamo'], 
              $datosSolicitud['invierteEn'], $datosSolicitud['estadoSolicitud']), 0 );
    
/*$pdf->Cell(10, 10, utf8_decode('1'), 1, 0, 'C', 0);
$pdf->Cell(85, 10, utf8_decode($datosSolicitud['nombres'].' '.$datosSolicitud['apellidos']), 1, 0, 'C', 0);
$pdf->Cell(25, 10, utf8_decode($datosSolicitud['Monto']), 1, 0, 'C', 0);
$pdf->Cell(15, 10, utf8_decode($datosSolicitud['Plazo']), 1, 0, 'C', 0);
$pdf->Cell(30, 10, utf8_decode($datosSolicitud['Prestamo']), 1, 0, 'C', 0);
$pdf->Cell(70, 10, utf8_decode($datosSolicitud['invierteEn']), 1, 0, 'C', 0);
$pdf->Cell(25, 10, utf8_decode($datosSolicitud['estadoSolicitud']), 1, 1, 'C', 0);*/
// Dibuja un marco alrededor de toda la página


$pdf->SetFont('Arial', 'B',12);
//PARA MARCO DE PAGINA
$pdf->SetLineWidth(1);
$pdf->Rect(5, 5, 270, 205); 

$pdf->Ln(25); // Salto de línea
$pdf->Cell(250, 10, utf8_decode('____________________________                    ____________________________'), 0, 1, 'C', 0);
$pdf->Cell(240, 10, utf8_decode('      Presidente                                                               Secretario'), 0, 1, 'C', 0);
$pdf->Ln(15); // Salto de línea
$pdf->Cell(250, 10, utf8_decode('____________________________                    ____________________________'), 0, 1, 'C', 0);
$pdf->Cell(240, 10, utf8_decode('    Vocal I                                                                    Vocal II'), 0, 1, 'C', 0);
$pdf->Ln(15); // Salto de línea
$pdf->Cell(250, 10, utf8_decode('____________________________'), 0, 1, 'C', 0);
$pdf->Cell(240, 10, utf8_decode('         Vocal III'), 0, 1, 'C', 0);
$pdf->Output('ComiteCreditoActa#'.$datosSolicitud['numeroActa'].'.pdf', 'I');//nombreDescarga, Visor(I->visualizar - D->descargar)


?>