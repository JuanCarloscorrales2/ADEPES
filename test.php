<?php
require "model/Usuario.php";

$usuario = new Usuario();

$Usuario = "ADMIN";
$idRol = 2;
$NombreUsuario = "ADMINISTRADOR";
$EstadoUsuario = 2;
$Clave = "admin@123";
$CorreoElectronico = "admin@gmail.com";
$CreadoPor = "ADMIN";
$FechaVencimiento = "2024-01-01";

if($usuario->RegistrarUsuario($Usuario, $idRol, $NombreUsuario, $EstadoUsuario, $CorreoElectronico, $Clave, $CreadoPor, $FechaVencimiento)){
    echo "registro exitoso";

}else{
    echo "Fallo";
}
/*

if($usuario->ValidarUsuario($Usuario,$Clave)){
    echo "Encontrado";
} else{
    echo "No existe";
}
*/
?>