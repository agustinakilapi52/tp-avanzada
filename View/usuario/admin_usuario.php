<?php 

include_once('../../configuracion.php');
include_once('../../Templates/header.php');
$objUsuario = new Usuario();
$usuario = $objUsuario->getAllUsersHistorico();



?>

<h2 style="text-align: center;" >Gestión de Usuarios </h2>
<section>
        <div class="container mt-5 mb-5">

            <table class="table table-striped table-hover" width="100%" style="text-align: center;">
                <thead>
                    <th>ID</th>
                    <th>Imagen</th>
                    <th>Nombre</th>
                    <th>Telefono</th>
                    <th>Mail</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </thead>

                <tbody id="tableContainer"></tbody>
            </table>
        </div>
</section>


<div class="modal fade" id="modal_edicion_producto" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edición Producto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formulario" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="text-center">
                            <img id="img_add" class="img_add" style="width: 150px; height: 150px;" src="" alt="Foto del producto">
                            <input type="file" name="edit_img" id="edit_img" style="display: none;">
                            <button type="button" id="changeImg">Cambiar Imagen</button>
                        </div>
                        <div class="form-group">
                            <label for="pronombre">Nombre</label>
                            <input type="text" class="form-control" id="pronombre" name="pronombre">
                        </div>
                        <div class="form-group">
                            <label for="prodetalle">Detalle</label>
                            <input type="text" class="form-control" id="prodetalle" name="prodetalle">
                        </div>
                        <div class="form-group">
                            <label for="procantstock">Stock</label>
                            <input type="number" class="form-control" id="procantstock" name="procantstock">
                        </div>
                        <div class="form-group">
                            <label for="proprecio">Precio</label>
                            <input type="number" class="form-control" id="proprecio" name="proprecio">
                        </div>
                        <input type="hidden" id="id_producto" name="id_producto">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" id="btnSubmit" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>



    <?php include_once('../../Templates/footer.php') ?>

<script>
let principal = <?= json_encode($PRINCIPAL); ?>
</script>

<script src="../../Assets/js/usuario/index.js"></script>