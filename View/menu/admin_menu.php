<?php 

include_once('../../configuracion.php');
include_once('../../Templates/header.php');
$objRol = new Rol();
$roles = $objRol->getRoles();
$objMenu = new Menu();
$menu = $objMenu->getAllMenus();

?>


<h2 style="text-align: center;" >Gestión Menu</h2>
<section>
        <div class="container mt-5 mb-5">

            <table class="table table-striped table-hover" width="100%" style="text-align: center;">
                <thead>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Ruta</th>
                    <th>Menú Padre</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </thead>

                <tbody id="tableContainer"></tbody>
            </table>
        </div>
</section>


<?php include_once('../../Templates/footer.php') ?>

<script>
let principal = <?= json_encode($PRINCIPAL); ?>
</script>

<script src="../../Assets/js/menu/index.js"></script>