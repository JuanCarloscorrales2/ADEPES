<?php

require('./fpdf.php');
// Establecer la zona horaria de Honduras
date_default_timezone_set('America/Tegucigalpa');
require "../../config/Conexion.php";
if (isset($_GET['idSolicitante'], $_GET['nombreCliente'], $_GET['identidadCliente'], $_GET['estadoCivilCliente'], $_GET['direccionCliente'])) {
  $idSolicitante = $_GET['idSolicitante'];
  $nombreCliente = $_GET['nombreCliente'];
  $identidadCliente = $_GET['identidadCliente'];
  $estadoCivilCliente = $_GET['estadoCivilCliente'];
  $direccionCliente = $_GET['direccionCliente'];
  $nombreAval1 = $_GET['nombreAval1'];
  $identidadAval1 = $_GET['identidadAval1'];
  $nombreAval2 = $_GET['nombreAval2'];
  $identidadAval2 = $_GET['identidadAval2'];
  $nombreAval3 = $_GET['nombreAval3'];
  $identidadAval3 = $_GET['identidadAval3'];

} else {
  // Manejo de error si no se recibieron todas las variables necesarias
  http_response_code(400); // Solicitud incorrecta
  echo 'No se proporcionaron todos los datos necesarios';
}



class PDF extends FPDF
{

   // Cabecera de página
   function Header()
   {
       $this->Image('logo.png', 175, 10, 30); //logo de la empresa,moverDerecha,moverAbajo,tamañoIMG
      $this->SetFont('Arial', 'B', 14); //tipo fuente, negrita(B-I-U-BIU), tamañoTexto
      $this->Cell(45); // Movernos a la derecha
      $this->SetTextColor(0, 0, 0); //color
    
      //creamos una celda o fila
      $this->Cell(100, 15, utf8_decode('ASOCIACIÓN DE DESARROLLO PESPIRENSE'), 0, 1, 'C', 0); // AnchoCelda,AltoCelda,titulo,borde(1-0),saltoLinea(1-0),posicion(L-C-R),ColorFondo(1-0)
      $this->Cell(110, 2, utf8_decode('"ADEPES"'), 0, 1, 'R', 0);
      $this->Ln(10); // Salto de línea
      $this->SetTextColor(103); //color
      $this->Ln(3); // Salto de línea   
      //fecha
      $this->SetTextColor(0, 0, 0); //color
      $this->SetFont('Arial', 'I', 12); //tipo fuente, negrita(B-I-U-BIU), tamañoTexto
      $this->Cell(160, 5, utf8_decode('Pespire, Choluteca'), 0, 0, 'L', 0); 
      $Fecha = date('d/m/Y');
      $this->Cell(100, 5, utf8_decode($Fecha), 0, 1, 'L', 0);
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
      $this->Cell(320, 10, utf8_decode('Fecha y Hora de impresión:'.$hoy), 0, 0, 'C');
      
   }
}

//para traer el municipio de residencia

if ($idSolicitante) {
  try {
      $cnx = Conexion::ConectarDB(); // Llamamos al método estático para obtener la conexión
  
      //consulta SQL
      $consulta = $cnx->prepare("
          SELECT muni.Descripcion FROM tbl_mn_personas persona
          INNER JOIN tbl_mn_municipio muni ON persona.idMunicipio = muni.idMunicipio
          WHERE persona.idPersona = :idSolicitante
      ");
  
      // Asignar el valor del parámetro
      $consulta->bindParam(':idSolicitante', $idSolicitante);
  
      // Ejecutar la consulta preparada
      $consulta->execute();
      $datos = $consulta->fetch(PDO::FETCH_ASSOC); // Almacena los datos de la solicitud en un array asociativo
  } catch (PDOException $ex) {
      die($ex->getMessage());
  }
}


$pdf = new PDF();
$pdf->AddPage("portrait", "letter"); /* carta: letter, aqui entran dos para parametros (horientazion,tamaño)V->portrait H->landscape tamaño (A3.A4.A5.letter.legal) */
$pdf->AliasNbPages(); //muestra la pagina / y total de paginas


$pdf->SetFont('Arial', '',12); //tipo fuente, negrita(B-I-U-BIU), tamañoTexto
// AnchoCelda,AltoCelda,titulo,borde(1-0),saltoLinea(1-0),posicion(L-C-R),ColorFondo(1-0)

if($nombreAval1 !=""){
  
  $pdf->MultiCell(195, 10, utf8_decode('Yo '.$nombreCliente.' mayor de edad con #ident. '.$identidadCliente.' '.$estadoCivilCliente.
  ' con domicilio en '.$direccionCliente.', MUNICIPIO DE '.$datos['Descripcion'].' por este medio estoy autorizando a la Asociación de Desarrollo Pespirence "ADEPES" a que '.
'haga las consultas necesarias en la Central de Riesgo "TRANS UNION" sobre mi situación Crediticia y la de mis avales en el Sistema Financiero Nacional.'), 0, 'L');
 
 $pdf->Ln(20); // Salto de línea
 $pdf->SetFont('Arial', 'B',11); //tipo fuente, negrita(B-I-U-BIU), tamañoTexto
 $pdf->Cell(195, 10, utf8_decode('______________________________________'), 0, 1, 'C', 0);
 $pdf->Cell(195, 7, utf8_decode($nombreCliente), 0, 1, 'C', 0);
 $pdf->Cell(195, 7, utf8_decode($identidadCliente), 0, 1, 'C', 0);
 $pdf->Ln(15); // Salto de línea
//aval 1
$pdf->Cell(195, 10, utf8_decode('______________________________________'), 0, 1, 'C', 0);
$pdf->Cell(195, 7, utf8_decode($nombreAval1), 0, 1, 'C', 0);
$pdf->Cell(195, 7, utf8_decode($identidadAval1), 0, 1, 'C', 0);
$pdf->Ln(15); // Salto de línea
//aval 2
if($nombreAval2 !=""){
  $pdf->Cell(195, 10, utf8_decode('______________________________________'), 0, 1, 'C', 0);
  $pdf->Cell(195, 7, utf8_decode($nombreAval2), 0, 1, 'C', 0);
  $pdf->Cell(195, 7, utf8_decode($identidadAval2), 0, 1, 'C', 0);
  $pdf->Ln(15); // Salto de línea
}
//aval 3
if($nombreAval3 !=""){
  $pdf->Cell(195, 10, utf8_decode('______________________________________'), 0, 1, 'C', 0);
  $pdf->Cell(195, 7, utf8_decode($nombreAval3), 0, 1, 'C', 0);
  $pdf->Cell(195, 7, utf8_decode($identidadAval3), 0, 1, 'C', 0);
}

}else{ //no tiene avales
  $pdf->MultiCell(195, 10, utf8_decode('Yo '.$nombreCliente.' mayor de edad con #ident. '.$identidadCliente.' '.$estadoCivilCliente.
  ' con domicilio en '.$direccionCliente.', MUNICIPIO DE '.$datos['Descripcion'].' por este medio estoy autorizando a la Asociación de Desarrollo Pespirence "ADEPES" a que '.
'haga las consultas necesarias en la Central de Riesgo "TRANS UNION" sobre mi situación Crediticia en el Sistema Financiero Nacional.'), 0, 'L');
 
 $pdf->Ln(20); // Salto de línea
 $pdf->Cell(195, 10, utf8_decode('______________________________________'), 0, 1, 'C', 0);
 $pdf->SetFont('Arial', 'B',11); //tipo fuente, negrita(B-I-U-BIU), tamañoTexto
 $pdf->Cell(195, 7, utf8_decode($nombreCliente), 0, 1, 'C', 0);
 $pdf->Cell(195, 7, utf8_decode($identidadCliente), 0, 1, 'C', 0);
}




$pdf->Output('CentralRiesgo_'.$nombreCliente.'', 'I');//nombreDescarga, Visor(I->visualizar - D->descargar)


?>