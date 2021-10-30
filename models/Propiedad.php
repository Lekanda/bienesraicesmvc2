<?php
namespace Model;

class Propiedad extends ActiveRecord{
   
    protected static $tabla='propiedades';

    protected static $columnasDB=[
        'id',
        'titulo',
        'precio',
        'imagen',
        'descripcion',
        'habitaciones',
        'wc',
        'estacionamiento',
        'creado',
        'vendedorId'
    ];

    public function __construct($args=[]){
        $this->id = $args['id'] ?? null;
        $this->titulo = $args['titulo'] ?? '';
        $this->precio = $args['precio'] ?? '';
        $this->imagen = $args['imagen'] ?? '';
        $this->descripcion = $args['descripcion'] ?? '';
        $this->habitaciones = $args['habitaciones'] ?? '';
        $this->wc = $args['wc'] ?? '';
        $this->estacionamiento = $args['estacionamiento'] ?? '';
        $this->creado = date('Y/m/d');
        $this->vendedorId = $args['vendedorId'] ?? '';
    }

    public function validar(){

        // Validar que no vaya vacio
        if (!$this->titulo) {
            self::$errores[] = "Debes añadir un titulo";
        }
        
        if (!$this->precio) {
            self::$errores[] = "Debes añadir un precio";
        }
        if (strlen($this->descripcion) < 20) {
            self::$errores[] = "Debes añadir una descripcion";
        }
        if (!$this->habitaciones) {
            self::$errores[] = "Debes añadir numero de Habitaciones";
        }
        if (!$this->wc) {
            self::$errores[] = "Debes añadir numero de Baños";
        }
        if (!$this->estacionamiento) {
            self::$errores[] = "Debes añadir numero de plazas de aparcamiento";
        }
        if (!$this->vendedorId) {
            self::$errores[] = "Debes añadir Identificador de vendedor";
        }
        if (!$this->imagen) {
            self::$errores[] = "Debes seleccionar una imagen";
        }

        return self::$errores;
    }


}
    