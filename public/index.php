<?php 

require_once __DIR__ . '/../includes/app.php';

use MVC\Router;

$router = new Router();

$router->get('/nosotros', 'funcion_nosotros');
$router->get('/tienda', 'funcion_tienda');
$router->get('/menu', 'funcion_menu');
$router->get('/admin', 'funcion_admin');

$router->comprobarRutas();
