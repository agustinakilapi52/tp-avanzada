<?php include_once('configuracion.php'); 

$objProducto = new Producto();
$productos = $objProducto->getProductos();

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link href="node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

  <title>
    libreria 
  </title>
</head>

<body>


<?php include_once('Templates/header.php') ?>

<div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="true">
  <div class="carousel-indicators">
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
  </div>
  <div class="carousel-inner" style="height: 600px;">
    <div class="carousel-item active">
      <img src="./assets/images/carusel.jpg" class="d-block w-100" alt="...">
    </div>
   
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>





<div class="container p-4" > 
<h2 class="titulo p-4" style="text-align: center; font-size: 28px; font-family: 'Segoe UI';">LO MAS VENDIDO</h2>
    <!-- listar productos -->
    <div class="row">
        <?php if (!empty($productos)) : ?>

        <?php foreach ($productos as $p) : ?>
        <div class="col-3 mb-3">   
            <div class="card shadow custom-card" style="width: 18rem; border: none;  " >
                <div class="card-body">
                <img src="./uploads/fotosproductos/<?= $p->getUrlImagen() ?>" class="card-img-top" alt="..." style="width: 100%; height: 300px; object-fit: cover;">
                    <p class="card-title m-2" style="font-weight: bold;  color: #333;font-size: 14px; margin: bottom 8px;"><span><?= strtoupper($p->getPronombre()) ?></span></p>
                    <p class="card-description m-2" style="font-size: 10px;">   <span><?= ucwords($p->getProdetalle()) ?></span></p>

                    <p class="card-text m-2"><span>$<?= $p->getPrecio() ?></span></p>
                    
                
                    <button class="btn btn-primary w-100 shadow add-to-cart" data-id="<?= $p->getIdProducto() ?>" style="border: none; border-radius: 0; background-color:#B36690;color:white;">Agregar al Carrito</button>
                </div>

            </div>      
        </div>
        <?php endforeach; ?>
        <?php endif; ?>
            
    </div>
   
    
</div>

<?php include_once('Templates/footer.php') ?>


<script src="Assets/js/carrito/cart.js"></script>

</body>
</html>