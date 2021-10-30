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


    public function comprobarRutas(){
        // Con PATH_INFO leemos la peticion que le hacemos  al servidor (p.ej: /propiedades)
        $urlActual = $_SERVER['PATH_INFO'] ?? '/';
        $metodo = $_SERVER['REQUEST_METHOD'];

        if ($metodo === 'GET') {
            // Comprueba que 'rutasGET[]' y lo escrito en la url sea igual y trae la funcion asociada a $fn.
            $fn = $this->rutasGET[$urlActual] ?? null;
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
    public function render($view){
        include __DIR__ . "/views/$view.php";
    }
}
