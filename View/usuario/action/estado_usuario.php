<?php 

include_once('../../../configuracion.php');

$datos = $_POST;
$objUsuario = new Usuario();
$verificacion = $objUsuario->estadoUsuario($datos);
echo json_encode($verificacion);

?>