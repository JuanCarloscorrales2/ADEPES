<?php
   use PHPMailer\PHPMailer\PHPMailer;
   use PHPMailer\PHPMailer\Exception;
class Mailer {

    function enviarEmail($CorreoElectronico, $asunto, $cuerpo){
        //include ('registrarUser.php');
        $CorreoElectronico=$_POST["correoUser"];
        require '../phpmailer/src/Exception.php';
        require '../phpmailer/src/PHPMailer.php';
        require '../phpmailer/src/SMTP.php';

        $mail = new PHPMailer(true);
        $mail->CharSet = "UTF-8";

        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';  //gmail SMTP server
            $mail->SMTPAuth = true;
            $mail->Username = 'luisaarias319@gmail.com';   //username
            $mail->Password = 'rzqiyczosxcyaxhg';   //password
            $mail->SMTPSecure = 'ssl';
            $mail->Port = 465;                    //smtp port
            
            //correo emisor y nombre
            $mail->setFrom('luisaarias319@gmail.com', 'Fondo Revolvente ADEPES');
            //correo receptor
            $mail->addAddress($CorreoElectronico);
            //formato de correo electronico en HTML
            $mail->isHTML(true);
            //contenido
            $mail->Subject = 'Bienvenido al sistema de Fondo revolvente ADEPES'; //titulo
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
    //envia el usuario y clave crado por el ADMIN desde Mantenimiento de usuarios
    function enviarEmailRegistro($CorreoElectronico, $asunto, $cuerpo){
        //include ('registrarUser.php');
        $CorreoElectronico=$_POST["CorreoElectronico"];
        require '../phpmailer/src/Exception.php';
        require '../phpmailer/src/PHPMailer.php';
        require '../phpmailer/src/SMTP.php';

        $mail = new PHPMailer(true);
        $mail->CharSet = "UTF-8";

        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';  //gmail SMTP server
            $mail->SMTPAuth = true;
            $mail->Username = 'luisaarias319@gmail.com';   //username
            $mail->Password = 'rzqiyczosxcyaxhg';   //password
            $mail->SMTPSecure = 'ssl';
            $mail->Port = 465;                    //smtp port
            
            //correo emisor y nombre
            $mail->setFrom('luisaarias319@gmail.com', 'Fondo Revolente ADEPES');
            //correo receptor
            $mail->addAddress($CorreoElectronico);
            //formato de correo electronico en HTML
            $mail->isHTML(true);
            //contenido
            $mail->Subject = 'Bienvenido al sistema de Fondo revolvente ADEPES'; //titulo
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