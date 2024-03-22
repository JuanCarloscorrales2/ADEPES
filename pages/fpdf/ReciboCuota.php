<?php

require('./fpdf.php');
// Establecer la zona horaria de Honduras
date_default_timezone_set('America/Tegucigalpa');
require "../../config/Conexion.php";
$idPlanCuota = $_GET['idPlan']; 
$nombre = $_GET['nombre']; 

if ($idPlanCuota) {
    try {
        $cnx = Conexion::ConectarDB(); // Llamamos al método estático para obtener la conexión
    
        //consulta SQL
        $consulta = $cnx->prepare(" SELECT plan.idSolicitud, plan.NumeroCuotas, movi.fechaDeposito, movi.pagos, movi.pagoAdicional
            FROM tbl_mn_plan_pagos_cuota_nivelada plan
            LEFT JOIN tbl_mn_movimientos_financieros movi ON plan.idPlanCuota = movi.idPlanCuota
            WHERE plan.idPlanCuota = :idPlanCuota
        ");
    
        // Asignar el valor del parámetro
        $consulta->bindParam(':idPlanCuota', $idPlanCuota);
    
        // Ejecutar la consulta preparada
        $consulta->execute();
        $datosCuota = $consulta->fetch(PDO::FETCH_ASSOC); // Almacena los datos de la solicitud en un array asociativo
    
        // Puedes utilizar $datosSolicitud según tus necesidades
        // Por ejemplo, acceder a $datosSolicitud['nombres'], $datosSolicitud['Prestamo'], etc.
      //$numeroActa =$datosSolicitud['numeroActa'];
    } catch (PDOException $ex) {
        die($ex->getMessage());
    }
}


class PDF extends FPDF
{
 
    

   // Cabecera de página
   function Header()
   {
      $this->Image('logo.png', 160, 10, 28); //logo de la empresa,moverDerecha,moverAbajo,tamañoIMG
      $this->SetFont('Arial', 'B', 12); //tipo fuente, negrita(B-I-U-BIU), tamañoTexto
      //$this->Cell(45); // Movernos a la derecha
      $this->SetTextColor(0, 0, 0); //color
       
      //creamos una celda o fila
      $this->Cell(195, 10, utf8_decode('ASOCIACIÓN DE DESARROLLO PESPIRENSE'), 0, 1, 'C', 0); // AnchoCelda,AltoCelda,titulo,borde(1-0),saltoLinea(1-0),posicion(L-C-R),ColorFondo(1-0)
      $this->Cell(195, 10, utf8_decode('"ADEPES"'), 0, 1, 'C', 0);

      
      $this->Ln(3); // Salto de línea
      $this->SetTextColor(103); //color
      $this->Ln(3); // Salto de línea 
      //fecha
      $this->SetTextColor(0, 0, 0); //color
      $this->SetFont('Arial', 'BIU', 12); //tipo fuente, negrita(B-I-U-BIU), tamañoTexto
      $this->Cell(195, 5, utf8_decode('Recibo de Pago'), 0, 1, 'C', 0); 

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

  
} //fin de la clase FPDF


$pdf = new PDF();
$pdf->AddPage("portrait", "letter"); /* carta: letter, aqui entran dos para parametros (horientazion,tamaño)V->portrait H->landscape tamaño (A3.A4.A5.letter.legal) */
$pdf->AliasNbPages(); //muestra la pagina / y total de paginas


$pdf->SetFont('Arial', '',11);
$pdf->Ln(10); // Salto de línea
//marco de pagina
$pdf->SetLineWidth(0.1);
$pdf->Rect(20, 50, 170, 45); 

$pdf->Cell(20, 10, utf8_decode(''), 0, 0, 'L', 0);
$pdf->Cell(170, 10, utf8_decode('Prestatario: '.$nombre), 0, 1, 'L', 0);
$pdf->Cell(20, 10, utf8_decode(''), 0, 0, 'L', 0);
$pdf->Cell(170, 10, utf8_decode('Número de Préstamo: 0'.$datosCuota['idSolicitud']), 0, 1, 'L', 0);
$pdf->Cell(20, 10, utf8_decode(''), 0, 0, 'L', 0);
$pdf->Cell(85, 10, utf8_decode('Número de Cuota: '.$datosCuota['NumeroCuotas']), 0, 0, 'L', 0);
$pdf->Cell(60, 10, utf8_decode('Fecha de Depósito: '.$datosCuota['fechaDeposito']), 0, 1, 'R', 0);
$pdf->Cell(20, 10, utf8_decode(''), 0, 0, 'L', 0);
$pdf->Cell(170, 10, utf8_decode('Monto Pagado: L. '.$datosCuota['pagos']), 0, 1, 'L', 0);

$pdf->Ln(15); // Salto de línea
$pdf->Cell(195, 10, utf8_decode('___________________________'), 0, 1, 'C', 0);
$pdf->Cell(195, 10, utf8_decode('Firma'), 0, 1, 'C', 0);


$pdf->Output('Recibo Cuota# '.$datosCuota['NumeroCuotas'].'.pdf', 'I');//nombreDescarga, Visor(I->visualizar - D->descargar)


?>