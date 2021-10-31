<?php 

namespace Controllers;
use MVC\Router;
use Model\Propiedad;
use Model\Vendedor;
use Intervention\Image\ImageManagerStatic as Image;

class PropiedadController {
    public static function index(Router $router){
        $propiedades = Propiedad::all();
        $vendedores = Vendedor::all();
        // Muestra mensaje condicional, si no hay lo pone como null
        $resultado = $_GET['resultado'] ?? null;

        $router->render('propiedades/admin', [
            'propiedades' => $propiedades,
            'resultado' => $resultado,
            'vendedores' => $vendedores
        ]);
    }


    public static function crear(Router $router){
        $propiedad = new Propiedad;
        $vendedores = Vendedor::all();

        // Arreglo con mensajes de errores
        $errores = Propiedad::getErrores();


        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Crea una nueva instancia.
            $propiedad =new Propiedad($_POST['propiedad']);
    
            // debuguear($_FILES['propiedad']['tmp_name']['imagen']);
            // Generar un nombre unico
            $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";

            // Setear la imagen
            if ($_FILES['propiedad']['tmp_name']['imagen']) {
                $image = Image::make($_FILES['propiedad']['tmp_name']['imagen'])->fit(800,600);
                $propiedad->setImagen($nombreImagen);
            }
    
            $errores = $propiedad->validar();
            
    
            // Comprobar que no haya errores en arreglo $errores. Comprueba que este VACIO (empty).
            if (empty($errores)) {
                // Crear una carpeta
                if (!is_dir(CARPETAS_IMAGENES)){
                    mkdir(CARPETAS_IMAGENES);
                }
                // Guarda la imagen en el servidor/Carpeta imagenes en raiz
                $image->save(CARPETAS_IMAGENES . $nombreImagen);
                
                $propiedad->guardar();
                
            }
        }
        
        $router->render('propiedades/crear',[
            'propiedad' => $propiedad,
            'vendedores' => $vendedores,
            'errores' => $errores
        ]);
    }

    public static function actualizar(Router $router){
        $id = validarORedireccionar('/admin');
        $propiedad = Propiedad::find($id);
        $vendedores = Vendedor::all();

        // Arreglo con mensajes de errores
        $errores = Propiedad::getErrores();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Asignar los atributos
            $args = $_POST['propiedad'];
            $propiedad->sincronizar($args);
    
            // Validacion
            $errores = $propiedad->validar();
    
            // Subida de archivos(Imagen). Realiza un resize a la imagen con Intervention Image.
            // Generar un nombre unico
            $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";

            if ($_FILES['propiedad']['tmp_name']['imagen']) {
                $image = Image::make($_FILES['propiedad']['tmp_name']['imagen'])->fit(800,600);
                $propiedad->setImagen($nombreImagen);
                }
        
                // Comprobar que no haya errores en arreglo $errores. Comprueba que este VACIO (empty).
                if (empty($errores)) {
                    // Almacenar la imagen
                    if ($_FILES['propiedad']['tmp_name']['imagen']){
                        $image->save(CARPETAS_IMAGENES . $nombreImagen);
                    }
                    $propiedad->guardar();
                }
        }

        $router->render('propiedades/actualizar',[
            'propiedad' => $propiedad,
            'vendedores' => $vendedores,
            'errores' => $errores
        ]);
    }


    /*********ELIMINAR PROPIEDAD*********/
    public static function eliminar(){
        
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // debuguear($_POST['tipo']);
                $id = $_POST['id'];
                $id = filter_var($id, FILTER_VALIDATE_INT);
                if ($id) {
                    $tipo = $_POST['tipo'];
        
                    if (validarTipoContenido($tipo)) {
                        $propiedad = Propiedad::find($id);
                        $propiedad->eliminar();
                    }
                }
            }
    }
    
}