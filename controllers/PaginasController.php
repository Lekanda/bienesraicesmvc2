<?php

namespace Controllers;

use MVC\Router;
use Model\Propiedad;

class PaginasController{

    public static function index (Router $router){
        $propiedades = Propiedad::all();

        $router->render('/',[
            'propiedades' => $propiedades,
        ]);
    }
    public static function nosotros(){
        echo "Desde nosotros";
    }
    public static function propiedades(){
        echo "Desde propiedades";
    }
    public static function propiedad(){
        echo "Desde propiedad";
    }
    public static function blog(){
        echo "Desde blog";
    }
    public static function entrada(){
        echo "Desde entrada";
    }
    public static function contacto(){
        echo "Desde contacto";
    }
}