<?php

namespace Controllers;

use MVC\Router;
use Model\Propiedad;
use PHPMailer\PHPMailer\PHPMailer;

class PaginasController{

    public static function index (Router $router){

        $propiedades = Propiedad::get(3);
        $inicio = true;

        $router->render('paginas/index', [
            'propiedades' => $propiedades,
            'inicio' => $inicio
        ]);
    }


    public static function nosotros(Router $router){

        $router->render('paginas/nosotros', []);
    }


    public static function propiedades(Router $router){
        $propiedades = Propiedad::all();

        $router->render('paginas/propiedades', [
            'propiedades' => $propiedades
        ]);
    }


    public static function propiedad(Router $router){
        $id = validarORedireccionar('/propiedades');
        $propiedad = Propiedad::find($id);

        $router->render('paginas/propiedad', [
            'propiedad' => $propiedad
        ]);
    }


    public static function blog(Router $router){
        $router->render('paginas/blog', []);
    }


    public static function entrada(Router $router){
        $router->render('paginas/entrada', []);
    }


    public static function contacto(Router $router){

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $respuestas = $_POST['contacto'];

            // Crear una instancia de PHPMailer
            $mail = new PHPMailer();

            // Configurar SMTP
            $mail->isSMTP();
            $mail->Host = 'smtp.mailtrap.io';
            $mail->SMTPAuth   = true;
            $mail->Username   = '0aa2429c90a0f5';
            $mail->Password  =  '3f8880e6995f75';
            $mail->SMTPSecure = 'tls';
            $mail->Port       = 2525;  

            // Configurar el contenido del mail
            $mail->setFrom('admin@bienesraices.com'); // Quien envia el eMail
            $mail->addAddress('admin@bienesraices.com', 'BienesRaices.com'); // A que email llega el correo
            $mail->Subject = 'Tienes un nuevo mensaje'; // Asunto del mail

            //Habilitar
            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';

            // Definir el contenido
            $contenido = '<html>';
            $contenido .= '<p>Tienes un nuevo mensaje</p>';
            $contenido .= '<p>Nombre: ' . $respuestas['nombre']  . '</p>';
            $contenido .= '<p>Email: ' . $respuestas['email']  . '</p>';
            $contenido .= '<p>Telefono: ' . $respuestas['telefono']  . '</p>';
            $contenido .= '<p>Mensaje: ' . $respuestas['mensaje']  . '</p>';
            $contenido .= '<p>Venta o compra: ' . $respuestas['tipo']  . '</p>';
            $contenido .= '<p>Presupuesto:  €' . $respuestas['precio']  . '</p>';
            $contenido .= '<p>Tipo Contacto: ' . $respuestas['contacto']  . '</p>';
            $contenido .= '<p>Fecha: ' . $respuestas['fecha']  . '</p>';
            $contenido .= '<p>Hora: ' . $respuestas['hora']  . '</p>';
            $contenido .= '</html>';

            $mail->Body = $contenido;
            $mail->AltBody = 'Esto es txt alternativo sin HTML';

            // Enviar el mail
            if($mail->send()){
                echo 'Mensaje enviado correctamente';
            } else {
                echo 'Mensaje NO enviado';
            }
        }



        $router->render('paginas/contacto', []);
    }
}