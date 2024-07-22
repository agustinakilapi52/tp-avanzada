<?php
include('../../../configuracion.php');
$objCompra = new Compra();
$datos = $_POST;
$datos['tipo'] = 1;
$compra_item = $objCompra->modificarCantProductosCarrito($datos);
?>
<?php
