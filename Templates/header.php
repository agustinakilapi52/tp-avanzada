 
 <?php
$objMenu = new Menu();
$menu = $objMenu->getRolesParaMenu($MI_SESION->getUsuarioRolesLogueado());
$menu = $objMenu->estructuraMenu($menu);
 ?>
 <!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="author" content="Untree.co" />
  <link href="<?= $PRINCIPAL ?>node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css" rel="stylesheet">
  <meta name="description" content="" />
  <meta name="keywords" content="bootstrap, bootstrap5" />
 

  <title>
    libreria 
  </title>
  
 
</head>

<body>
<!-- menu de navegacion -->
<nav class="navbar navbar-expand-lg bg-white">
  <div class="container-fluid">
    <a class="navbar-brand" href="../../index.php">
    <img src="<?= $PRINCIPAL ?>Assets/images/logo.png"  class="d-block w-50 h-30" alt="...">
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarScroll">
      <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll gap-3" style="--bs-scroll-height: 100px;">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#">INICIO</a>
        </li>

        <?php if ($MI_SESION->validar()): 
        $usuario =  $MI_SESION->getUsuario();
        ?>
          <?php echo $menu ?>
          <li><a class="btn btn-danger" href="<?= $PRINCIPAL ?>View/login/action/accion_cerrar_sesion.php">Cerrar Sesión</a></li>
          
        <?php else: ?>
          <li class="nav-item">
            <a class="btn btn-primary" href="<?= $PRINCIPAL ?>View/login/login.php">Iniciar Sesion</a>
          </li>
        <?php endif; ?>

      </ul>
    
      <ul class="d-flex p-4 ">
      <li class="nav-item">
      <a href="#/" onclick="getAllCarrito();">
        <i class="bi bi-bag-heart" style="font-size: 2rem;"></i>
      </a>
       
        </li>

      </ul>
      
    </div>
  </div>
</nav>

//modal carrito


  <!-- <script src="<?= $PRINCIPAL ?>Assets/js/header.js"></script>
<script src="<?= $PRINCIPAL ?>Assets/js/jquery-3.7.1.min.js"></script> -->
<!-- <script src="<?= $PRINCIPAL ?>Assets/js/bootstrap.bundle.min.js"></script> -->
</body>
