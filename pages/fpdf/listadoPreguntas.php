<?php  
    //Establecer la zon ahoraria de HND.
    date_default_timezone_set('America/Tegucigalpa');
    // Recibir los datos enviados por AJAX
    if (isset($_POST['data'])){
        $jsonData = $_POST['data'];

    //Decodificar los datos JSON, para ordenar el listado deseado.
    $datosFiltradosOrdenados = json_decode($jsonData, true);
    
    // Verificar si hay datos para generar el PDF.
    if (empty($datosFiltradosOrdenados)){
        echo 'No se econtraron registros para generar el PDF.';
        exit; // Terminar la ejecución del script.
    }
    //Generar el PDF utilizando la Libreria de FPDF
        require('./fpdf.php');
        class PDF extends FPDF{
            //cabecera de pagina
            function Header(){
                $this->Image('logo.png', 170, 15, 30); //logo de la empresa,moverDerecha,moverAbajo,tamañoIMG
                $this->SetFont('Arial', 'B', 14);      //tipo fuente, negrita(B-I-U-BIU), tamañoTexto
                $this->Cell(45);                       // Movernos a la derecha
                $this->SetTextColor(0, 0, 0);          //color
            
                //creamos una celda o fila
                $this->Cell(100, 15, utf8_decode('ASOCIACIÓN DE DESARROLLO PESPIRENSE'), 0, 1, 'C', 0); // AnchoCelda,AltoCelda,titulo,borde(1-0),saltoLinea(1-0),posicion(L-C-R),ColorFondo(1-0)
                $this->Cell(110, 2, utf8_decode('"ADEPES"'), 0, 1, 'R', 0);
                $this->Ln(3); // Salto de línea
                $this->SetTextColor(103); //color
                $this->Ln(3); // Salto de línea
            
                
                /* TITULO DE LA TABLA */
                //color
                $this->SetTextColor(0, 0, 0);
                $this->Cell(122); // mover a la derecha
                $this->SetFont('Arial', 'B', 12);
                $this->Cell(20, 10, utf8_decode("LISTADO DE PREGUNTAS DE SEGURIDAD"), 0, 1, 'R', 0);
                $this->Ln(7);
                $this->SetLeftMargin(35);
                /* CAMPOS DE LA TABLA */
                //color
                $this->SetFillColor(204, 198, 196); //colorFondo
                $this->SetTextColor(0, 0, 0); //colorTexto
                $this->SetDrawColor(163, 163, 163); //colorBorde
                $this->SetFont('Arial', 'B', 10);
                
                $this->Cell(20, 10, utf8_decode('NO.'), 1, 0, 'C', 1);
                $this->Cell(140, 10, utf8_decode('PREGUNTA DE SEGURIDAD'), 1, 0, 'C', 1);
                $this->Ln();
                
            }//fin de la cabecera de pagina
            //INicio de Pie de página
            function Footer()
            {

                $this->SetY(-15); // Posición: a 1,5 cm del final
                $this->SetFont('Arial', 'I', 8); //tipo fuente, negrita(B-I-U-BIU), tamañoTexto
                $this->Cell(150, 10, utf8_decode('Página ') . $this->PageNo() . '/{nb}', 0, 0, 'C'); //pie de pagina(numero de pagina)
                //fecha
                $this->SetY(-15); // Posición: a 1,5 cm del final
                $this->SetFont('Arial', 'I', 8); //tipo fuente, negrita(B-I-U-BIU), tamañoTexto
                $hoy = date('d/m/Y H:i:s');
                $this->Cell(280, 10, utf8_decode('Fecha y Hora de impresión: '.$hoy), 0, 0, 'C');     
            } // Fin de pie de pagina.

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
        } //Fin de libreria de reporte.

        //Ahora instanciar para la pagina y el formato y su contenido.
        $pdf = new PDF();
        $pdf->AddPage("portrait","letter"); /* aqui entran dos para parametros (horientazion,tamaño)V->portrait H->landscape tamaño (A3.A4.A5.letter.legal) */
        $pdf->AliasNbPages(); //muestra la pagina / y total de paginas
        
        $i = 0;
        $pdf->SetFont('Arial', '', 10);
        $pdf->SetDrawColor(163, 163, 163); //colorBorde
        $pdf->setWidths(array(20, 140)); //tamano de las celdas segun el encabezado de la tabla
        //construir el contenido del PDF DE LOS DATOS OBTENIDOS DEL DATATABLESS
        foreach ($datosFiltradosOrdenados as $fila) {
            $pdf->Row(array($fila['idP'], utf8_decode($fila['Pregunta'])), 0);
        } //Fin de obtener todos los datos.

        // Enviar el PDF al navegador para su descarga 
        $pdf->Output('listado_de_Preguntas_de_Seguridad.pdf', 'I'); //nombre de descarga
    } else{
        echo "Error, no se pudo realizar la descarga de los registros de preguntas de seguridad";  
    }
//Fin de recibir datos AJAX.
//Fin del listado de Usuarios del sistema.
?> 