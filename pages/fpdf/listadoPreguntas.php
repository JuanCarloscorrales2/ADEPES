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
                $this->Image('logo.png', 230, 15, 30); //logo de la empresa,moverDerecha,moverAbajo,tamañoIMG
                $this->SetFont('Arial', 'B', 14);      //tipo fuente, negrita(B-I-U-BIU), tamañoTexto
                $this->Cell(45);                       // Movernos a la derecha
                $this->SetTextColor(0, 0, 0);          //color
            
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
                $this->Cell(96); // mover a la derecha
                $this->SetFont('Arial', 'B', 12);
                $this->Cell(75, 10, utf8_decode("LISTADO DE PREGUNTAS DE SEGURIDAD"), 0, 1, 'C', 0);
                $this->Ln(7);
                $this->SetLeftMargin(75);
                /* CAMPOS DE LA TABLA */
                //color
                $this->SetFillColor(204, 198, 196); //colorFondo
                $this->SetTextColor(0, 0, 0); //colorTexto
                $this->SetDrawColor(163, 163, 163); //colorBorde
                $this->SetFont('Arial', 'B', 10);
                
                $this->Cell(20, 10, utf8_decode('NÚMERO'), 1, 0, 'C', 1);
                $this->Cell(130, 10, utf8_decode('PREGUNTA DE SEGURIDAD'), 1, 0, 'C', 1);
                
            }//fin de la cabecera de pagina
            //INicio de Pie de página
            function Footer()
            {
                $this->SetLeftMargin(2);
                $this->SetY(-15); // Posición: a 1,5 cm del final
                $this->SetFont('Arial', 'I', 8); //tipo fuente, negrita(B-I-U-BIU), tamañoTexto
                $this->Cell(0, 10, utf8_decode('Página ') . $this->PageNo() . '/{nb}', 0, 0, 'C'); //pie de pagina(numero de pagina)
                //fecha
                $this->SetY(-15); // Posición: a 1,5 cm del final
                $this->SetFont('Arial', 'I', 8); //tipo fuente, negrita(B-I-U-BIU), tamañoTexto
                $hoy = date('d/m/Y H:i:s');
                $this->Cell(470, 10, utf8_decode('Fecha y Hora de impresión:'.$hoy), 0, 0, 'C');     
            } // Fin de pie de pagina.
        } //Fin de libreria de reporte.

        //Ahora instanciar para la pagina y el formato y su contenido.
        $pdf = new PDF();
        $pdf->AddPage("landscape","letter"); /* aqui entran dos para parametros (horientazion,tamaño)V->portrait H->landscape tamaño (A3.A4.A5.letter.legal) */
        $pdf->AliasNbPages(); //muestra la pagina / y total de paginas
        
        $i = 0;
        $pdf->SetFont('Arial', '', 10);
        $pdf->SetDrawColor(163, 163, 163); //colorBorde
        //construir el contenido del PDF DE LOS DATOS OBTENIDOS DEL DATATABLESS
        foreach ($datosFiltradosOrdenados as $fila) {
            //LOS NOMBRE SON DE LA FUNCION: LlenarTablaPreguntas JS
            $pdf->Ln(10); //SOLO CON ESTO, PUDE ACOMODARLO BIEN-
            $pdf->Cell(20, 10, $fila['idP'], 1, 0, 'C', 0);
            $pdf->Cell(130, 10, utf8_decode($fila['Pregunta']), 1, 0, 'J', 0);
        
        //$pdf->Ln();
        } //Fin de obtener todos los datos.

        // Enviar el PDF al navegador para su descarga 
        $pdf->Output('listado_de_Preguntas_de_Seguridad.pdf', 'I'); //nombre de descarga
    } else{
        echo "Error, no se pudo realizar la descarga de los registros de preguntas de seguridad";  
    }
//Fin de recibir datos AJAX.
//Fin del listado de Usuarios del sistema.
?> 