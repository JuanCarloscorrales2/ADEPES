<?php
session_start();
require "../model/BitacoraModel.php";

// Verifica si se han enviado los parámetros esperados
if (isset($_POST["usuarioId"], $_POST["pantallaId"], $_POST["accion"], $_POST["descripcion"])) {
    $usuarioId = $_POST["usuarioId"];
    $pantallaId = $_POST["pantallaId"];
    $accion = $_POST["accion"];
    $descripcion = $_POST["descripcion"];

    // Registra la salida del usuario en la bitácora
    $bita = new Bitacora();
    $bita->RegistrarBitacora($usuarioId, $pantallaId, $accion, $descripcion);
}
?>
