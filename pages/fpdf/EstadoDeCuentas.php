<?php

require('./fpdf.php');
// Establecer la zona horaria de Honduras
date_default_timezone_set('America/Tegucigalpa');
require "../../config/Conexion.php";
$idSolicitud = $_GET['idSoli']; 


if ($idSolicitud) {
    try {
        $cnx = Conexion::ConectarDB(); // Llamamos al método estático para obtener la conexión
    
        //consulta SQL
        $consulta = $cnx->prepare(" SELECT plan.NumeroCuotas, plan.FechaCuota, movi.fechaPago, movi.pagos, movi.abonoCapital, plan.valorInteres, movi.pagoAdicional,
                plan.valorCapital, plan.saldoCapital, plan.mora, estado.Descripcion
                FROM tbl_mn_plan_pagos_cuota_nivelada plan
                LEFT JOIN tbl_mn_movimientos_financieros movi ON movi.idPlanCuota = plan.idPlanCuota
                INNER JOIN tbl_mn_estadoplanpagos estado ON estado.idEstadoPlanPagos = plan.idEstadoPlanPagos	
                WHERE plan.idSolicitud = :idSolicitud
            ORDER BY plan.NumeroCuotas ASC
            
        ");
    
        // Asignar el valor del parámetro
        $consulta->bindParam(':idSolicitud', $idSolicitud);
    
        // Ejecutar la consulta preparada
        $consulta->execute();
        $datos = $consulta->fetchAll(PDO::FETCH_ASSOC); // Obtener la lista de datos
        // Puedes utilizar $datosSolicitud según tus necesidades
        // Por ejemplo, acceder a $datosSolicitud['nombres'], $datosSolicitud['Prestamo'], etc.
      //$numeroActa =$datosSolicitud['numeroActa'];
      

//consulta SQL
    $consultaDatos = $cnx->prepare(" SELECT CONCAT(persona.nombres,' ',persona.apellidos) as cliente, persona.identidad,
    soli.Monto, soli.plazo, soli.tasa, soli.fechaAprob, SUM(valorInteres) as totalInteres
     FROM tbl_mn_solicitudes_creditos soli
    INNER JOIN tbl_mn_personas persona ON persona.idPersona =  soli.idPersona
    INNER JOIN tbl_mn_plan_pagos_cuota_nivelada plan ON plan.idSolicitud =  soli.idSolicitud
    WHERE soli.idSolicitud = :idSolicitud
    

    ");

    // Asignar el valor del parámetro
    $consultaDatos->bindParam(':idSolicitud', $idSolicitud);

    // Ejecutar la consulta preparada
    $consultaDatos->execute();
    $datosCliente = $consultaDatos->fetch(PDO::FETCH_ASSOC); // Obtener la lista de datos

    } catch (PDOException $ex) {
        die($ex->getMessage());
    }
}


class PDF extends FPDF
{
 
    

   // Cabecera de página
   function Header()
   {
      $this->Image('logo.png', 230, 10, 28); //logo de la empresa,moverDerecha,moverAbajo,tamañoIMG
      $this->SetFont('Arial', 'B', 12); //tipo fuente, negrita(B-I-U-BIU), tamañoTexto
      //$this->Cell(45); // Movernos a la derecha
      $this->SetTextColor(0, 0, 0); //color
       
      //creamos una celda o fila
      $this->Cell(258, 10, utf8_decode('ASOCIACIÓN DE DESARROLLO PESPIRENSE'), 0, 1, 'C', 0); // AnchoCelda,AltoCelda,titulo,borde(1-0),saltoLinea(1-0),posicion(L-C-R),ColorFondo(1-0)
      $this->Cell(258, 10, utf8_decode('"ADEPES"'), 0, 1, 'C', 0);
      
     // $this->Ln(3); // Salto de línea
      $this->SetTextColor(103); //color
      $this->Ln(3); // Salto de línea 
      //fecha
      $this->SetTextColor(0, 0, 0); //color
      $this->SetFont('Arial', 'BIU', 12); //tipo fuente, negrita(B-I-U-BIU), tamañoTexto
      $this->Cell(258, 5, utf8_decode('Estado de Cuentas'), 0, 1, 'C', 0); 

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
      $this->Cell(255, 10, utf8_decode('Fecha y Hora de impresión:'.$hoy), 0, 0, 'R');
      
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
$pdf->AddPage("landscape", "letter"); /* carta: letter, aqui entran dos para parametros (horientazion,tamaño)V->portrait H->landscape tamaño (A3.A4.A5.letter.legal) */
$pdf->AliasNbPages(); //muestra la pagina / y total de paginas


$pdf->SetFont('Arial', '',11);
$pdf->Ln(5); // Salto de línea

//$pdf->Cell(20, 10, utf8_decode(''), 0, 0, 'L', 0);
$pdf->Cell(120, 10, utf8_decode('Cliente: '.$datosCliente['cliente']), 0, 0, 'L', 0);
$pdf->Cell(80, 10, utf8_decode('Identidad: '.$datosCliente['identidad']), 0, 0, 'L', 0);
$pdf->Cell(80, 10, utf8_decode('Fecha Desembolso: '.$datosCliente['fechaAprob']), 0, 1, 'L', 0);
$pdf->Cell(120, 10, utf8_decode('Préstamo: 0'.$idSolicitud), 0, 0, 'L', 0);
$pdf->Cell(80, 10, utf8_decode('Valor del Préstamo: '.$datosCliente['Monto']), 0, 0, 'L', 0);
$pdf->Cell(80, 10, utf8_decode('Cuotas: '.$datosCliente['plazo']), 0, 1, 'L', 0);
/* CAMPOS DE LA TABLA */
//color
$pdf->SetFillColor(204, 198, 196); //colorFondo
$pdf->SetTextColor(0, 0, 0); //colorTexto
$pdf->SetDrawColor(163, 163, 163); //colorBorde
$pdf->SetFont('Arial', '', 10);

$pdf->Cell(10, 10, utf8_decode('N '), 1, 0, 'C', 1);
$pdf->Cell(31, 10, utf8_decode('FECHA DE PAGO'), 1, 0, 'C', 1);
$pdf->Cell(32, 10, utf8_decode('FECHA DEPÓSITO'), 1, 0, 'C', 1);
$pdf->Cell(32, 10, utf8_decode('PAGO'), 1, 0, 'C', 1);
$pdf->Cell(30, 10, utf8_decode('INTERES'), 1, 0, 'C', 1);
$pdf->Cell(30, 10, utf8_decode('PAGO ADICIONAL'), 1, 0, 'C', 1);
$pdf->Cell(30, 10, utf8_decode('SALDO CAPITAL'), 1, 0, 'C', 1);
$pdf->Cell(25, 10, utf8_decode('MORA'), 1, 0, 'C', 1);
$pdf->Cell(40, 10, utf8_decode('ESTADO'), 1, 1, 'C', 1);

$pdf->SetFont('Arial', '',10);
$pdf->SetDrawColor(163, 163, 163); //colorBorde
$pdf->SetWidths(array(10, 31, 32, 32, 30, 30, 30, 25, 40)); //tamanio de las celdas segun el encabezado de la tabla


/* TABLA */
$pdf->Row(array("0","", "", "", "", "", $datosCliente['Monto'], "", ""), 0 );
foreach ($datos as $fila) {

    $pdf->Row(array($fila['NumeroCuotas'], $fila['FechaCuota'], $fila['fechaPago'], $fila['pagos'],  $fila['valorInteres'], $fila['pagoAdicional'],
     $fila['saldoCapital'], $fila['mora'], $fila['Descripcion']), 0 );
    
}


$pdf->Output('ESTADO_CUENTAS_'.$datosCliente['cliente'].'.pdf', 'I');//nombreDescarga, Visor(I->visualizar - D->descargar)


?>