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

    function getId(){
        return $this->id;
    }


    function setId($id){
        $this->id = $id;
    }


    function getTipo(){
        return $this->tipo;
    }

    function setTipo($tipo){
        $this->tipo = $tipo;
    }

    function getMarca(){
        return $this->marca;
    }

    function setMarca($marca){
        $this->marca = $marca;
    }

    function getModelo(){
        return $this->modelo;
    }

    function setModelo($modelo){
        $this->modelo = $modelo;
    }

    function getDesc(){
        return $this->desc;
    }

    function setDesc($desc){
        $this->desc = $desc;
    }

    function getPrecio(){
        return $this->precio;
    }

    function setPrecio($precio){
        $this->precio = $precio;
    }

    function getStock(){
        return $this->stock;
    }

    function setStock($stock){
        $this->stock = $stock;
    }

    function getOferta(){
        return $this->oferta;
    }

    function setOferta($oferta){
        $this->oferta = $oferta;
    }

    function getDisponible(){
        return $this->disponible;
    }

    function setDisponible($disponible){
        $this->disponible = $disponible;
    }

    function getFecha(){
        return $this->fecha;
    }

    function setFecha($fecha){
        $this->fecha = $fecha;
    }

    function getImagen(){
        return $this->imagen;
    }

  function setImagen($imagen){
        $this->imagen = $imagen;
    }
}
