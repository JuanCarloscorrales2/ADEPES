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
                $this->Cell(160, 15, utf8_decode('ASOCIACIÓN DE DESARROLLO PESPIRENSE'), 0, 1, 'C', 0); // AnchoCelda,AltoCelda,titulo,borde(1-0),saltoLinea(1-0),posicion(L-C-R),ColorFondo(1-0)
                $this->Cell(135, 2, utf8_decode('"ADEPES"'), 0, 1, 'R', 0);
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
                $this->Cell(100); // mover a la derecha
                $this->SetFont('Arial', 'B', 12);
                $this->Cell(50, 10, utf8_decode("LISTADO DE PARÁMETROS DEL SISTEMA"), 0, 1, 'C', 0);
                $this->Ln(7);

                /* CAMPOS DE LA TABLA */
                //color
                $this->SetFillColor(204, 198, 196); //colorFondo
                $this->SetTextColor(0, 0, 0); //colorTexto
                $this->SetDrawColor(163, 163, 163); //colorBorde
                $this->SetFont('Arial', 'B', 11);

                //$this->Cell(18, 10, utf8_decode('N°'), 1, 0, 'C', 1);
                $this->Cell(100, 10, utf8_decode('PARÁMETROS'), 1, 0, 'C', 1);
                $this->Cell(30, 10, utf8_decode('VALOR'), 1, 0, 'C', 1);
                $this->Cell(60, 10, utf8_decode('FECHA DE CREACIÓN'), 1, 0, 'C', 1);
                $this->Cell(58, 10, utf8_decode('FECHA DE MODIFICACIÓN'), 1, 1, 'C', 1);
                
            }//fin de la cabecera de pagina
            //INicio de Pie de página
            function Footer()
            {
                $this->SetY(-15); // Posición: a 1,5 cm del final
                $this->SetFont('Arial', 'I', 8); //tipo fuente, negrita(B-I-U-BIU), tamañoTexto
                $this->Cell(0, 10, utf8_decode('Página ') . $this->PageNo() . '/{nb}', 0, 0, 'C'); //pie de pagina(numero de pagina)
                //fecha
                $this->SetY(-15); // Posición: a 1,5 cm del final
                $this->SetFont('Arial', 'I', 8); //tipo fuente, negrita(B-I-U-BIU), tamañoTexto
                $hoy = date('d/m/Y H:i:s');
                $this->Cell(445, 10, utf8_decode('Fecha y Hora de impresión:'.$hoy), 0, 0, 'C');
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
            //$pdf->Cell(18, 10, $fila['id'], 1, 0, 'C', 0); //LOS NOMBRE SON DE LA FUNCION: LlenarTablaParametro  JS
            $pdf->Cell(100, 10, utf8_decode($fila['parametro']), 1, 0, 'C', 0);
            $pdf->Cell(30, 10, $fila['valor'], 1, 0, 'C', 0);
            $pdf->Cell(60, 10, $fila['Fecha'], 1, 0, 'C', 0);
            $pdf->Cell(58, 10, $fila['FechaM'], 1, 1, 'C', 0);
        //$pdf->Ln();
        } //Fin de obtener todos los datos.
        // Enviar el PDF al navegador para su descarga 
        $pdf->Output('Reportes_de_parametros_del_Sistema.pdf', 'I'); //nombre de descarga
    } else{
        echo "Error, no se pudo realizar la descarga del listado de parametros";
    }
//Fin de recibir datos AJAX.
//Fin del listado de Usuarios del sistema.
?> 