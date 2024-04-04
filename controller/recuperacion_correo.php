<?php
 require "../config/Conexion.php";
 require "../pages/recuperacionContrasena.php"; //para el funcionamiento de las alertas
 require "../Model/funcionesRecuperacion.php";
 $recuperacion = new Conexion();
 $cnx = $recuperacion->ConectarDB();

 if (isset($_POST["username"])){
    try{
    $sql="SELECT idUsuario, NombreUsuario, CorreoElectronico FROM tbl_ms_usuario WHERE Usuario =? AND idEstadoUsuario!=4";
    $result =$cnx->prepare($sql);
    $result->bindParam(1, $_POST['username']);
    $result->execute();
    if($resultado=$result->fetch(PDO::FETCH_ASSOC)){
        $idUsuario=$resultado['idUsuario'];
        $token  = generarToken();
                //vigencia de  token recuperacion de contraseña 
                $sqlD = "SELECT * FROM tbl_ms_parametros WHERE idParametro = 6; ";
                $query =$cnx->query($sqlD);
                while($fila = $query->fetch(PDO::FETCH_ASSOC)){
                $fila; //retornamos el valor
                break;
                    }
            
                 foreach ($fila as $campos => $valor){
                $DIASPARAMETRO["valores"][$campos] = $valor; //almacena el valor del parametro minimo de la clave en un arreglo
                }
        $fechaRecuperacion = date('Y-m-d H:i:s', strtotime("+". $DIASPARAMETRO["valores"]["Valor"]."hours"));
        //$fechaRecuperacion = date("Y-m-d H:i:s", strtotime('+24 hours'));
        $nombreCompleto=$resultado['NombreUsuario'];
        $CorreoElectronicos=$resultado['CorreoElectronico'];
        //generar y almacenar token
        $sql ="UPDATE tbl_ms_usuario SET token= '$token', fechaRecuperacion='$fechaRecuperacion' WHERE CorreoElectronico ='$CorreoElectronicos'";
        
        $sqlp = "SELECT * FROM tbl_ms_parametros WHERE idParametro = 6;";
        $query = $cnx->query($sqlp);
        $nombreParametro["valores"] = array(); // Inicializamos el arreglo
        
        while ($fila = $query->fetch(PDO::FETCH_ASSOC)) {
            foreach ($fila as $campos => $valor) {
                $nombreParametro["valores"][$campos] = $valor; // Almacenamos el valor del parámetro
            }
            break; // Salimos del bucle después de la primera iteración
        }

        try{
            $cnx->exec($sql);

            require ('../Model/MailerPassword.php');
            $mailer = new Mailer();
            $url = SITE_URL . 'pages/restablecerPassword.php?idUsuario='.$idUsuario .'&token='.$token ;
            $asunto ="Recuperación de Contraseña";
            $cuerpo = "Estimado $nombreCompleto: <br> Se ha iniciado un proceso de restablecemiento de contraseña para acceder a su cuenta.
                        <br> Si fue usted, por favor presiona el botón de restablecer contraseña,
                        <br> Por favor, no compartir su contraseña, para mayor seguridad.
                        <br> Sino puede ignorar este mensaje. 
                        <br> <a class='btn btn-primary' href='$url' role='button'>Restablecer Contraseña</a>
                        <br> Este restablecimiento de contraseña solo es válido durante las próximas " . $nombreParametro["valores"]["Valor"] . " horas.";
        
            if($mailer->enviarEmail($CorreoElectronicos,$asunto, $cuerpo)){
                                    echo '<script>
                                            Swal.fire({
                                            icon: "success",
                                            title: "¡Listo! Estimado Usuario, Se ha enviado un correo de recuperación a su buzón.",
                                            showConfirmButton: true,
                                            confirmButtonText: "Aceptar"
                                            }).then(function(result){
                                                if(result.value){                   
                                                window.location = "../pages/welcome.php";
                                                }
                                            });
                                            </script>';
                                }
        }catch (PDOException $e ){
            echo 'No se pudo guardar el token: '.$e->getMessage();

        }
       
    }
    else if($resultado!=$_POST["username"]){
        echo '<script>
        Swal.fire({
        icon: "warning",
        title: "Atención...",
        text: "Ingrese un usuario válido",
        showConfirmButton: true,
        confirmButtonText: "Aceptar"
        }).then(function(result){
            if(result.value){                   
            window.location = "../pages/recuperacionContrasena.php";
            }
        });
        </script>';
    }
    else {
        echo '<script>
        Swal.fire({
        icon: "warning",
        title: "Atención...",
        text: "Ingrese un usuario",
        showConfirmButton: true,
        confirmButtonText: "Aceptar"
        }).then(function(result){
            if(result.value){                   
            window.location = "../pages/recuperacionContrasena.php";
            }
        });
        </script>';
    }

    }catch (PDOException $e ){
        echo 'Fallo conexion '.$e->getMessage();
    }
 }
