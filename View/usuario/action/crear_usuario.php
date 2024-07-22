<?php
include('../../../configuracion.php');

$datos = $_POST;
$objUser = new Usuario();
$respuesta = $objUser->crearUsuario($datos);

var_dump($respuesta);

echo $respuesta;
