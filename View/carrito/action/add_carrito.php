<?php 
include('../../../configuracion.php');

/* Acá voy agregar un producto al carrito e iniciar la compra */

$objCompra = new Compra();
$datos = $_POST;

$datos['idusuario'] = $usuario->getIdUsuario();

$compraRealizada = $objCompra->iniciarCompra($datos);

?>