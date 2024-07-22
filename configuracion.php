<?php

// configuracion de la app//


$PROYECTO ='libreria';

//variable que almacena el directorio del proyectoooo
$ROOT =$_SERVER['DOCUMENT_ROOT']."/$PROYECTO/";

include_once($ROOT.'Controller/Session.php');
// Inicio la sesión
$MI_SESION = new Session();
// Variable que define la pagina de autenticacion del proyecto
$INICIO = "Location:http://".$_SERVER['HTTP_HOST']."/$PROYECTO/vista/login/login.php";

include_once($ROOT.'includes/funciones.php');

// Constante que define la ruta de todo el proyecto
$PRINCIPAL = "http://".$_SERVER['HTTP_HOST']."/$PROYECTO/";


?>