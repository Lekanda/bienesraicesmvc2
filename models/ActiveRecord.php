<?php

namespace App;

class ActiveRecord {
    
    // Base de datos.(Protected) Se instancia solo desde la clase. seguridad mayor
    //(Static)sí metemos 100 propiedades solo creamos una conexion a la DB.
    protected static $db;
    protected static $tabla='';
    // Errores o Validacion
    protected static $errores = [];

    // Definir la conexion a la DB desde app.php
    public static function setDB($database){
        self::$db = $database;
    }

    
    public function guardar(){
        if(!is_null($this->id)){
            // Actualizar
            $this->actualizar();

        } else {
            // Creando un nuevo registro
            $this->crear();
        }
    }

    public function actualizar(){
        //Sanitizar los datos del formulario
        $atributos = $this->sanitizarAtributos();

        $valores =[];
        foreach ($atributos as $key => $value) {
            $valores[]="{$key}='{$value}'";
        }

        $query = "UPDATE " . static::$tabla . " SET ";
        $query .= join(', ', $valores);
        $query .= " WHERE id= '" . self::$db->escape_string($this->id) . "' ";
        $query .= " LIMIT 1 ";
        
        $resultado = self::$db->query($query);

        if($resultado){
            // Redirecionar al usuario
            header('Location: /admin?resultado=2');
        }
    }

    public function crear(){
       

        //Sanitizar los datos del formulario
        $atributos = $this->sanitizarAtributos();

        // Insertar en la DB
        $query = "INSERT INTO " . static::$tabla . " ( ";
        $query .= join(', ', array_keys($atributos));
        $query .= " ) VALUES (' ";
        $query .= join("', '", array_values($atributos));
        $query .= " ') ";

        // debuguear($query);

        $resultado = self::$db->query($query);
        
        if($resultado){
            // Redirecionar al usuario
            header('Location: /admin?resultado=1');
        }

    }

    public function eliminar(){
        $query = "DELETE FROM " . static::$tabla . " WHERE id = " . self::$db->escape_string($this->id) . " LIMIT 1";
        // debuguear($query);

        $resultado = self::$db->query($query);
        // debuguear($resultado);

        if ($resultado) {
            $this->borrarImagen();
            header('Location: /admin?resultado=3' );
        }
    }

    // Itera los atributos de la tabla en la DB.
    // Identifica los atributos.
    public function atributos(){
        $atributos = [];
        foreach (static::$columnasDB as $columna) {
            // continue: no hace nada y pasa al siguiente.
            if($columna === 'id') continue;
            $atributos[$columna]= $this->$columna;
        }
        return $atributos;
    }

    // sanitiza los atributos de la tabla
    public function sanitizarAtributos(){
        // debuguear('Sanitizando....');

        $atributos = $this->atributos();
        $sanitizado = [];
        
        foreach($atributos as $key => $value){
            $sanitizado[$key] = self::$db->escape_string($value); 
        }
         return $sanitizado;
        
    }

    //Subida de archivos
    // Setear la imagen con el nombre que viene de crear.php
    public function setImagen ($imagen){
        // Elimina la imagen previa
        if (!is_null($this->id)) {
            $this->borrarImagen();
        }
        // Asignar al atributo de imagen el nombre de la imagen
        if($imagen){
            $this->imagen = $imagen;
        }
    }

    // Borrar la imagen al eliminar propiedad
    public function borrarImagen(){
        $existeArchivo = file_exists(CARPETAS_IMAGENES . $this->imagen);
            if($existeArchivo){
                unlink(CARPETAS_IMAGENES . $this->imagen);
            }
    }

    // Validacion
    public static function getErrores(){
        return static::$errores;
        
    }

    public function validar(){
        static::$errores = [];
        return static::$errores;
    }

    // Traer todos los registros de la DB
    public static function all () {

        $query = "SELECT * FROM " . static::$tabla;
        $resultado = self::consultarSQL($query);

        return $resultado;
    }

    // Trae un numero dado de propiedades.
    // Traer todos los registros de la DB
    public static function get ($cantidad) {
        $query = "SELECT * FROM " . static::$tabla . " LIMIT " . $cantidad;
        $resultado = self::consultarSQL($query);

        return $resultado;
    }


    // Conectarnos a la DB
    public static function find($id){
        $query = "SELECT * FROM " . static::$tabla . " WHERE id = ${id}";
        $resultado = self::consultarSQL($query);
        // debuguear($resultado[0]);
        // debuguear(array_shift($resultado));// Trae el primero.
        return array_shift($resultado);
    }

    /******************************************/
    public static function consultarSQL($query){
        // Consultar la DB
        $resultado = self::$db->query($query);
        // Iterar los resultados
        $array = [];
        while($registro = $resultado->fetch_assoc()){
            $array[] = static::crearObjeto($registro); 
        }
        // Liberar la memoria 
        $resultado->free();
        // Retorna los resultados
        return $array;
    }

    protected static function crearObjeto($registro){
        $objeto = new static;

        foreach ($registro as $key => $value) {
            if (property_exists($objeto,$key)) {
                $objeto->$key = $value;
            }
        }

        // debuguear($objeto);
        return $objeto;
    }
    /****************************************************/

    // Sincroniza el objeto en memoria con los cambios realizados por el usuario al actualizar propiedad
    public function sincronizar($args = []){
        foreach ($args as $key => $value) {
            if (property_exists($this,$key) && !is_null($value)){
                $this->$key = $value;
            }
        }
    }
    
}
