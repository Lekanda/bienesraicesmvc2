<?php 

namespace Controllers;

use MVC\Router;
use Model\Admin;

class LoginController{

    public static function login(Router $router){

        $errores = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $auth = new Admin($_POST);

            $errores = $auth->validar();

            if (empty($errores)) {
                // verificar si el usuario existe
                

                // verificar el password


                // autenticar al usuario



            }
        }

        $router->render('auth/login',[
            'errores' => $errores
        ]);
    }

    public static function logout(){
        echo 'Desde Logout';
    }

}

