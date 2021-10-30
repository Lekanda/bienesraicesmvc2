<?php 

namespace Controllers;
use MVC\Router;

class PropiedadController {
    public static function index(Router $router){
        $router->render('propiedades/admin', [
            
        ]);
    }
    public static function crear(){
        $router->render('propiedades/crear');
    }
    public static function actualizar(){
        $router->render('propiedades/actualizar');
    }
    
}