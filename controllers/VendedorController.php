<?php 

namespace Controllers;

use MVC\Router;
use Model\Vendedor;

class VendedorController {
    public static function crear(Router $router){
        $vendedor = new Vendedor;

        // Arreglo con mensajes de errores
        $errores = Vendedor::getErrores();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Crea una nueva instancia.
            $vendedor =new Vendedor($_POST['vendedor']);

            $errores = $vendedor->validar();
            if (empty($errores)) {
                $vendedor->guardar();
            }
        }
        $router->render('/vendedores/crear',[
            'errores' => $errores,
            'vendedor' => $vendedor
    ]);
    }
}