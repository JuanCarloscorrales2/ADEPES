<?php
  
   use PHPMailer\PHPMailer\PHPMailer;
   use PHPMailer\PHPMailer\Exception;


class Mailer {

    function enviarEmail($CorreoElectronico, $asunto, $cuerpo){
        //include ('registrarUser.php');
        //$CorreoElectronico=$_POST["correoUser"];
        require '../phpmailer/src/Exception.php';
        require '../phpmailer/src/PHPMailer.php';
        require '../phpmailer/src/SMTP.php';

        require_once "../config/Conexion.php";
        $parametro = new Conexion();
        $cnx = $parametro->ConectarDB();
        
        // Sentencia para el parámetro de nombre del sistema
        $sqlD = "SELECT * FROM tbl_ms_parametros WHERE idParametro IN (10, 11, 12); "; // Añade más IDs de parámetros si es necesario
        $query = $cnx->query($sqlD);
        
        $nombreParametro["valores"] = array(); // Inicializamos el arreglo
        
        while ($fila = $query->fetch(PDO::FETCH_ASSOC)) {
            foreach ($fila as $campos => $valor) {
                $nombreParametro["valores"][$fila['idParametro']][$campos] = $valor; // Almacenamos el valor del parámetro
            }
        }

        $mail = new PHPMailer(true);
        $mail->CharSet = "UTF-8";

        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.hostinger.com';  //gmail SMTP server
            $mail->SMTPAuth = true;
            $mail->Username = $nombreParametro["valores"][10]["Valor"];   //username
            $mail->Password = $nombreParametro["valores"][11]["Valor"];   //password
            $mail->SMTPSecure = 'ssl';
            $mail->Port = $nombreParametro["valores"][12]["Valor"];                    //smtp port
            
            //correo emisor y nombre
            $mail->setFrom('adepes@fondorevolvente.com', 'Fondo Revolvente ADEPES');
            //correo receptor
            $mail->addAddress($CorreoElectronico);
            //formato de correo electronico en HTML
            $mail->isHTML(true);
            //contenido
            $mail->Subject = 'Recuperación de Contraseña-Fondo revolvente ADEPES'; //titulo
            $mail->Body = $cuerpo;
            $mail->setLanguage('es', 'phpmailer/language/phpmailer.lang-es.php');

            //enviar correo
            if ($mail->send()) {
                return true;
            }else {
                return false;
            }
        } catch (Exception $e) {
            echo "No se pudo enviar el mensaje. Error de envío: {$mail->ErrorInfo}";
            return false;

        }

    }

}