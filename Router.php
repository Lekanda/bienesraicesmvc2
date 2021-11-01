<?php 

namespace MVC;
    
class Router  {

    public $rutasGET = [];
    public $rutasPOST = [];

    // Mete en $rutasGET los nombres de las funciones de las rutas de 'public/index.php'.
    public function get($url,$fn){
        $this->rutasGET[$url] = $fn;
        // debuguear($this->rutasGET[$url]);
    }

    public function post($url,$fn){
        $this->rutasPOST[$url] = $fn;
        // debuguear($this->rutasGET[$url]);
    }


    public function comprobarRutas(){

        session_start();

        $auth = $_SESSION['login'] ?? null;
        // debuguear($auth);

        // Arreglo de rutas protegidas
        $rutas_protegidas = ['/admin',
                             '/propiedades/crear',
                             '/propiedades/actualizar',
                             '/propiedades/eliminar',
                             '/vendedores/crear',
                             '/vendedores/actualizar',
                             '/vendedores/eliminar',
        ];


        // Con PATH_INFO leemos la peticion que le hacemos  al servidor (p.ej: /propiedades)
        $urlActual = $_SERVER['PATH_INFO'] ?? '/';
        $metodo = $_SERVER['REQUEST_METHOD'];

        if ($metodo === 'GET') {
            // Comprueba que 'rutasGET[]' y lo escrito en la url sea igual y trae la funcion asociada a $fn.
            $fn = $this->rutasGET[$urlActual] ?? null;
        } else {
            // Comprueba que 'rutasPOST[]' y lo escrito en la url sea igual y trae la funcion asociada a $fn.
            $fn = $this->rutasPOST[$urlActual] ?? null;
        }

        // Proteger las rutas
        if (in_array($urlActual,$rutas_protegidas) && !$auth) {
            header('Location: /');
        }
        
        // Sí La funcion existe y su funcion asociada
        if ($fn) {
            // Llamar a una funcion cuando no se sabe como se llamara. 
            call_user_func($fn,$this);
        } else {
            echo 'Pagina no encontrada';
        }

        
    }

    // Muestra una vista
    public function render($view,$datos = []){

        foreach ($datos as $key => $value) {
            // $$:Al llamar a $key devuelve el valor $value
            $$key = $value;
        }

        ob_start(); // Inicia un almacenamiento en memoria.
        include __DIR__ . "/views/$view.php";
        $contenido = ob_get_clean(); //Guarda en $contenido la mememoria y la limpia.
        include __DIR__ . "/views/layout.php"; // Incluye el 'layout.php'(header y footer).
    }
}
