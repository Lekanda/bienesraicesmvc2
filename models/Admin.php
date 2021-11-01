<?php 

namespace Model;

class Admin extends ActiveRecord{
    // Base de datos
    protected static $tabla = 'usuarios';
    protected static $columnasDB = [
        'id',
        'email',
        'password'
    ];

    public $id;
    public $email;
    public $password;

    public function __construct($args=[]){
        $this->id = $args['id'] ?? null;
        $this->email = $args['email'] ?? '';
        $this->password = $args['password'] ?? '';
    }

    public function validar(){
        if (!$this->email) {
            self::$errores[] = "Debes añadir un email";
        }
        if (!$this->password) {
            self::$errores[] = "Debes añadir un password";
        }

        return self::$errores;
    }

    public function existeUsuario(){
        // Revisar sí un usuario existe o no
        $query = "SELECT * FROM " . self::$tabla . " WHERE  email = '" . $this->email . "' LIMIT 1";

        $resultado = self::$db->query($query);
        // debuguear($resultado);

        if (!$resultado->num_rows) {
            self::$errores[]= "El Usuario no existe";
            return;
        } 
        return $resultado;
    }

}