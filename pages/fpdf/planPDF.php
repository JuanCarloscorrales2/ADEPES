<?php
    // Establecer la zona horaria de Honduras
    date_default_timezone_set('America/Tegucigalpa');
     // Generar el PDF utilizando FPDF
     require('./fpdf.php');
     require "../../config/Conexion.php";
// Recibir los datos enviados por AJAX
if (isset( $_GET['idSoli'])) {
    $idSolicitud = $_GET['idSoli'];
    $nombre = $_GET['nombre'];
    $monto = $_GET['monto'];
    $tasaInteres = $_GET['tasaInteres'];
    $fechaEmision =  $_GET['fechaEmision'];
    $cuota = $_GET['cuota'];

    //SENTENCIA SQL PRA TRAER EL PLAN DE PAGOS
    $cnx = Conexion::ConectarDB(); // Llamamos al método estático para obtener la conexión
    
        //consulta SQL
        $consulta = $cnx->prepare("
        SELECT plan.NumeroCuotas, plan.FechaCuota, plan.valorCuota, plan.valorInteres, plan.valorCapital, plan.saldoCapital,
        estado.Descripcion
        FROM tbl_mn_plan_pagos_cuota_nivelada plan
        INNER JOIN tbl_mn_estadoplanpagos estado ON estado.idEstadoPlanPagos =  plan.idEstadoPlanPagos

        WHERE plan.idSolicitud = :idSolicitud ORDER BY plan.NumeroCuotas ASC
        ");
        // Asignar el valor del parámetro
        $consulta->bindParam(':idSolicitud', $idSolicitud);
        // Ejecutar la consulta preparada
        $consulta->execute();
        $datos = $consulta->fetchAll(PDO::FETCH_ASSOC); // Obtener la lista de datos

   
class PDF extends FPDF
{

   // Cabecera de página
   function Header()
   {

      $this->Image('logo.png', 170, 15, 30); //logo de la empresa,moverDerecha,moverAbajo,tamañoIMG
      $this->SetFont('Arial', 'B', 14); //tipo fuente, negrita(B-I-U-BIU), tamañoTexto

      $this->SetTextColor(0, 0, 0); //color
       
      //creamos una celda o fila
      $this->Cell(195, 15, utf8_decode('ASOCIACIÓN DE DESARROLLO PESPIRENSE'), 0, 1, 'C', 0); // AnchoCelda,AltoCelda,titulo,borde(1-0),saltoLinea(1-0),posicion(L-C-R),ColorFondo(1-0)
      $this->Cell(195, 2, utf8_decode('"ADEPES"'), 0, 1, 'C', 0);
      $this->Ln(7);
      $this->Cell(195, 2, utf8_decode('PLAN DE PAGOS CUOTA NIVELADA'), 0, 1, 'C', 0);
      $this->Ln(3); // Salto de línea
      $this->SetTextColor(103); //color
      $this->Ln(3); // Salto de línea

     
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
      $this->Cell(195, 10, utf8_decode('Fecha y Hora de impresión:'.$hoy), 0, 0, 'R');
      
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
$pdf->AddPage("portrait", "letter"); /* aqui entran dos para parametros (horientazion,tamaño)V->portrait H->landscape tamaño (A3.A4.A5.letter.legal) */
$pdf->AliasNbPages(); //muestra la pagina / y total de paginas


    /* CAMPOS DE LA TABLA */
    //color
    $pdf->SetFillColor(204, 198, 196); //colorFondo
    $pdf->SetTextColor(0, 0, 0); //colorTexto
    $pdf->SetDrawColor(163, 163, 163); //colorBorde
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(195, 5, utf8_decode('N° de préstamo: 0'.$idSolicitud), 0, 1, 'L', 0);
    $pdf->Cell(195, 5, utf8_decode('Cliente: '.$nombre), 0, 1, 'L', 0);
    $pdf->ln(7);
    //$this->Cell(18, 10, utf8_decode('N°'), 1, 0, 'C', 1);
    $pdf->Cell(20, 10, utf8_decode('Nº Cuota'), 1, 0, 'C', 1);
    $pdf->Cell(25, 10, utf8_decode('Fecha Pago'), 1, 0, 'C', 1);
    $pdf->Cell(30, 10, utf8_decode('Valor Cuota'), 1, 0, 'C', 1);
    $pdf->Cell(30, 10, utf8_decode('Valor Interés'), 1, 0, 'C', 1);
    $pdf->Cell(30, 10, utf8_decode('Valor Capital'), 1, 0, 'C', 1);
    $pdf->Cell(30, 10, utf8_decode('Saldo Capital'), 1, 0, 'C', 1);
    $pdf->Cell(30, 10, utf8_decode('Estado'), 1, 1, 'C', 1);

    $pdf->SetWidths(array(20, 25, 30, 30, 30, 30, 30)); //tamanio de las celdas segun el encabezado de la tabla

    $pdf->SetFont('Arial', '', 10);
    /* TABLA */
    foreach ($datos as $dato) {

    $pdf->Row(array($dato['NumeroCuotas'], $dato['FechaCuota'], $dato['valorCuota'], $dato['valorInteres'], $dato['valorCapital'], $dato['saldoCapital'], $dato['Descripcion']), 0);
    }
   


    // Enviar el PDF al navegador para su descarga 
    $pdf->Output('plan_pagos'.$nombre.'.pdf', 'I'); //nombre de descarga
} else {
    echo 'error';
}
?>
