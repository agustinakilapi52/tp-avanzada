<?php
include('../../../configuracion.php');

$objCompra = new Compra();

$datos = $_POST;
$datos['tipo'] = 0;

$compra_item = $objCompra->modificarCantProductosCarrito($datos);
?>