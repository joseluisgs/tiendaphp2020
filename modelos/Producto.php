<?php

/**
 * Description of Producto
 *
 * @author link
 */
class Producto {
    private $id;
    private $tipo;
    private $marca;
    private $modelo;
    private $desc;
    private $precio;
    private $stock;
    private $oferta;
    private $disponible;
    private $fecha;
    private $imagen;

    /**
     * Producto constructor.
     * @param $id
     * @param $tipo
     * @param $marca
     * @param $modelo
     * @param $desc
     * @param $precio
     * @param $stock
     * @param $oferta
     * @param $disponible
     * @param $fecha
     * @param $imagen
     */

    public function __construct($id, $tipo, $marca, $modelo, $desc, $precio, $stock, $oferta, $disponible, $fecha, $imagen){
        $this->id = $id;
        $this->tipo = $tipo;
        $this->marca = $marca;
        $this->modelo = $modelo;
        $this->desc = $desc;
        $this->precio = $precio;
        $this->stock = $stock;
        $this->oferta = $oferta;
        $this->disponible = $disponible;
        $this->fecha = $fecha;
        $this->imagen = $imagen;
    }
    /**
     * @return mixed
     */
    public function getId(){
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id){
        $this->id = $id;
    }/**
     * @return mixed
     */
    public function getTipo(){
        return $this->tipo;
    }
    /**
     * @param mixed $tipo
     */
    public function setTipo($tipo){
        $this->tipo = $tipo;
    }
    /**
     * @return mixed
     */
    public function getMarca(){
        return $this->marca;
    }
    /**
     * @param mixed $marca
     */
    public function setMarca($marca){
        $this->marca = $marca;
    }

    /**
     * @return mixed
     */
    public function getModelo(){
        return $this->modelo;
    }

    /**
     * @param mixed $modelo
     */
    public function setModelo($modelo){
        $this->modelo = $modelo;
    }

    /**
     * @return mixed
     */
    public function getDesc(){
        return $this->desc;
    }

    /**
     * @param mixed $desc
     */
    public function setDesc($desc){
        $this->desc = $desc;
    }

    /**
     * @return mixed
     */
    public function getPrecio(){
        return $this->precio;
    }

    /**
     * @param mixed $precio
     */
    public function setPrecio($precio){
        $this->precio = $precio;
    }

    /**
     * @return mixed
     */
    public function getStock(){
        return $this->stock;
    }

    /**
     * @param mixed $stock
     */
    public function setStock($stock){
        $this->stock = $stock;
    }

    /**
     * @return mixed
     */
    public function getOferta(){
        return $this->oferta;
    }

    /**
     * @param mixed $oferta
     */
    public function setOferta($oferta){
        $this->oferta = $oferta;
    }

    /**
     * @return mixed
     */
    public function getDisponible(){
        return $this->disponible;
    }/**
     * @param mixed $disponible
     */

    public function setDisponible($disponible){
        $this->disponible = $disponible;
    }

    /**
     * @return mixed
     */
    public function getFecha(){
        return $this->fecha;
    }

    /**
     * @param mixed $fecha
     */
    public function setFecha($fecha){
        $this->fecha = $fecha;
    }

    /**
     * @return mixed
     */
    public function getImagen(){
        return $this->imagen;
    }

    /**
     * @param mixed $imagen
     */
    public function setImagen($imagen){
        $this->imagen = $imagen;
    }
}
