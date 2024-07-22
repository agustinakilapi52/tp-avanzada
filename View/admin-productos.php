<?php 
include_once('../configuracion.php');
include_once('../Templates/header.php');

$objProducto = new Producto();
$productos = $objProducto->getProductos();
?>

<h2 style="text-align: center;">Gestión de Productos </h2>
<section>
    <div class="container mt-5 mb-5">
        <table width="100%" style="text-align: center;">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Producto</th>
                    <th>Nombre</th>
                    <th>Detalle</th>
                    <th>Stock</th>
                    <th>Precio</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody id="tableContainer"></tbody>
        </table>
    </div>
</section>

<!-- Modal de Edición Producto -->
<div class="modal fade" id="modal_edicion_producto" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edición Producto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formulario" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="d-flex flex-column ">
                        <img id="img_add" class="img_add" style="width: 150px; height: 150px;" src="" >
                        <input type="file" name="edit_img" onChange="displayImage(this)" id="edit_img">
                        <i id="changeImg" class="fa-solid fa-pen-to-square fs-5"></i>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-md-12 mb-3">
                            <div class="form-group">
                                <label class="mb-2">Nombre</label>
                                <input type="text" class="form-control inpEdit" id="pronombre" name="pronombre">
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-12 mb-3">
                            <div class="form-group">
                                <label class="mb-2">Detalle</label>
                                <input type="text" class="form-control inpEdit" id="prodetalle" name="prodetalle">
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-12 mb-3">
                            <div class="form-group">
                                <label class="mb-2">Stock</label>
                                <input type="number" class="form-control inpEdit" id="procantstock" name="procantstock">
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-12 mb-3">
                            <div class="form-group">
                                <label class="mb-2">Precio</label>
                                <input type="number" class="form-control inpEdit" id="proprecio" name="proprecio">
                            </div>
                        </div>
                        <input type="hidden" id="idproducto" name="idproducto">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" style="font-size: 13px;" data-bs-dismiss="modal">Cerrar</button>
                    <input type="submit"  id="btnSubmit" value="Guardar Edición" class="btn btn-primary" style="font-size: 13px;">
                </div>
            </form>
        </div>
    </div>
</div>

<?php include_once('../Templates/footer.php'); ?>

<script>
let principal = <?= json_encode($PRINCIPAL); ?>;
</script>

<script src="../Assets/js/producto/index.js"></script>
