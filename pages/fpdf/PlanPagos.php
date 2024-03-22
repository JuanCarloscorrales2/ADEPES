<?php
    // Establecer la zona horaria de Honduras
    date_default_timezone_set('America/Tegucigalpa');
    require "../../config/Conexion.php";
    // Generar el PDF utilizando FPDF
    require('./fpdf.php');

    
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $prestamo = $_POST["montoR"];
    $plazoMeses = $_POST["plazoR"];
    $fechaEmision = $_POST['fechaEmisionR'];
    $id = $_POST['tipogarantiaR'];
   // $fechaFormateada = date("d/m/Y", strtotime($valor3));
    // Crear un objeto PDF

    try {
        $cnx = Conexion::ConectarDB(); // Llamamos al método estático para obtener la conexión
    
        //consulta SQL
        $consulta = $cnx->prepare("SELECT tasa FROM tbl_mn_tipos_prestamos WHERE idTipoPrestamo = :idTipoPrestamo");
    
        // Asignar el valor del parámetro
        $consulta->bindParam(':idTipoPrestamo', $id);
    
        // Ejecutar la consulta preparada
        $consulta->execute();
        $tasa = $consulta->fetchColumn(); // almacena la tasa del tipo de prestamo
    
    } catch (PDOException $ex) {
        die($ex->getMessage());
    }

    $tasaInteresAnual = $tasa /100;
$tasaInteresMensual = $tasaInteresAnual / 12;
$cuota = ($prestamo * $tasaInteresMensual * pow(1 + $tasaInteresMensual, $plazoMeses)) /
         (pow(1 + $tasaInteresMensual, $plazoMeses) - 1);
//$cuota1 =number_format($cuota, 2, '.', '');
$saldoPendiente = $prestamo;
$planPagos = array();
$totalInteres =0;
$fechaAnterior = date('Y-m-d', strtotime($fechaEmision));
// Dentro del bucle
for ($mes = 0; $mes < $plazoMeses; $mes++) {
    $diasEnElMes = date('t', strtotime($fechaAnterior));
    $pagoInteresDiario = ($saldoPendiente * $tasaInteresAnual) / 365 * $diasEnElMes;
    
    $pagoAmortizacion = $cuota - $pagoInteresDiario;
    $saldoPendiente -= $pagoAmortizacion;

    if ($mes == $plazoMeses - 1) { // Último mes
        $pagoAmortizacion += $saldoPendiente; // Ajuste para que el saldo pendiente quede en 0
        $saldoPendiente = 0;
        $cuota = $pagoInteresDiario + $pagoAmortizacion;
    }
    $totalInteres +=$pagoInteresDiario;
    $planPagos[] = array(
        'mes' => $mes + 1,
        'fecha' => date('Y-m-d', strtotime($fechaAnterior . ' + 1 month')),
        'cuota' => $cuota,
        'pago_interes' => $pagoInteresDiario,
        'pago_amortizacion' => $pagoAmortizacion,
        'saldo_pendiente' => $saldoPendiente
    );
    $totalInteres=number_format($totalInteres, 2, '.', '');
    $fechaAnterior = date('Y-m-d', strtotime($fechaAnterior . ' + 1 month'));
}
}
class PDF extends FPDF
{
    private $prestamo;
    private $tasa;
    private $fechaEmision;
    private $totalInteres;


    function __construct($prestamo, $tasa, $fechaEmision, $totalInteres) {
        parent::__construct();
        $this->prestamo = $prestamo;
        $this->tasa = $tasa;
        $this->fechaEmision = $fechaEmision;
        $this->totalInteres = $totalInteres;
        $this->monto = $totalInteres;
    }

     // Cabecera de página
   function Header()
   {
      //include '../../recursos/Recurso_conexion_bd.php';//llamamos a la conexion BD

      //$consulta_info = $conexion->query(" select *from hotel ");//traemos datos de la empresa desde BD
      //$dato_info = $consulta_info->fetch_object();
      $this->Image('logo.png', 170, 15, 30); //logo de la empresa,moverDerecha,moverAbajo,tamañoIMG
      $this->SetFont('Arial', 'B', 14); //tipo fuente, negrita(B-I-U-BIU), tamañoTexto
      $this->Cell(45); // Movernos a la derecha
      $this->SetTextColor(0, 0, 0); //color
       
      //creamos una celda o fila
      $this->Cell(100, 15, utf8_decode('ASOCIACIÓN DE DESARROLLO PESPIRENSE'), 0, 1, 'C', 0); // AnchoCelda,AltoCelda,titulo,borde(1-0),saltoLinea(1-0),posicion(L-C-R),ColorFondo(1-0)
      $this->Cell(110, 2, utf8_decode('"ADEPES"'), 0, 1, 'R', 0);
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
      $this->Cell(60); // mover a la derecha
      $this->SetFont('Arial', 'B', 10);
      $this->Cell(75, 10, utf8_decode("PLAN DE PAGOS CUOTA NIVELADA - PROYECTADA"), 0, 1, 'C', 0);
      $this->Cell(50, 5, utf8_decode('Monto: L. '.$this->prestamo), 1, 1, 'L', 0);
      $this->Cell(50, 5, utf8_decode('Tasa anual: '.$this->tasa.'%'), 1, 1, 'L', 0);
      $this->Cell(50, 5, utf8_decode('Intereses: L.'.$this->totalInteres), 1, 1, 'L', 0);
      $this->Cell(50, 5, utf8_decode('Total: L. '.($this->totalInteres+$this->prestamo)), 1, 1, 'L', 0);
      $this->Ln(7);

      /* CAMPOS DE LA TABLA */
      //color
      $this->SetFillColor(204, 198, 196); //colorFondo
      $this->SetTextColor(0, 0, 0); //colorTexto
      $this->SetDrawColor(163, 163, 163); //colorBorde
      $this->SetFont('Arial', 'B', 10);

     $this->Cell(18, 10, utf8_decode('N°'), 1, 0, 'C', 1);
     $this->Cell(30, 10, utf8_decode('FECHA'), 1, 0, 'C', 1);
     $this->Cell(35, 10, utf8_decode('VALOR CUOTA'), 1, 0, 'C', 1);
     $this->Cell(30, 10, utf8_decode('INTERES'), 1, 0, 'C', 1);
     $this->Cell(35, 10, utf8_decode('CAPITAL'), 1, 0, 'C', 1);
     $this->Cell(35, 10, utf8_decode('SALDO CAPITAL'), 1, 1, 'C', 1);
    
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
      $this->Cell(310, 10, utf8_decode('Fecha y Hora de impresión:'.$hoy), 0, 0, 'C');
      
   }
   // Pie de página
   

  

}



      
$pdf = new PDF($prestamo, $tasa, $fechaEmision, $totalInteres);
$pdf->AddPage("portrait", "letter"); /* aqui entran dos para parametros (horientazion,tamaño)V->portrait H->landscape tamaño (A3.A4.A5.letter.legal) */
$pdf->AliasNbPages(); //muestra la pagina / y total de paginas




$pdf->SetFont('Arial', '', 10);
$pdf->SetDrawColor(163, 163, 163); //colorBorde

    // Datos de la fila 0
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(18, 10, '0', 1, 0, 'C', 0);
    $pdf->Cell(30, 10, date('Y-m-d', strtotime($fechaEmision)), 1, 0, 'C', 0);
    $pdf->Cell(35, 10, '-', 1, 0, 'C', 0);
    $pdf->Cell(30, 10, '-', 1, 0, 'C', 0);
    $pdf->Cell(35, 10, '-', 1, 0, 'C', 0);
    $pdf->Cell(35, 10, round($prestamo, 2), 1, 1, 'C', 0);

    foreach ($planPagos as $pago) {
        
        $pdf->Cell(18, 10, $pago['mes'], 1, 0, 'C', 0);
        $pdf->Cell(30, 10, $pago['fecha'], 1, 0, 'C', 0);
        $pdf->Cell(35, 10, round($pago['cuota'], 2), 1, 0, 'C', 0);
        $pdf->Cell(30, 10, round($pago['pago_interes'], 2), 1, 0, 'C', 0);
        $pdf->Cell(35, 10, round($pago['pago_amortizacion'], 2), 1, 0, 'C', 0);
        $pdf->Cell(35, 10, round($pago['saldo_pendiente'], 2), 1, 1, 'C', 0);
        
    }

    // Generar el archivo PDF
   // $pdf->Output();

    // Enviar el PDF al navegador para su descarga 
    $pdf->Output('PLAN_PAGOS_CUOTA_NIVELADA.pdf', 'I'); //nombre de descarga

?>

