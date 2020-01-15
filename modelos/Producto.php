<?php

/**
 * Description of Producto
 *
 * @author link
 */
class Producto {
    private $id;
    private $titulo;
    private $descripcion;
    private $seccion;
    private $importe;
    private $imagen;
    private $stock;

    function __construct($id, $titulo, $descripcion, $seccion, $importe, $imagen, $stock) {
        $this->id = $id;
        $this->titulo = $titulo;
        $this->descripcion = $descripcion;
        $this->seccion = $seccion;
        $this->importe = $importe;
        $this->imagen = $imagen;
        $this->stock = $stock;
    }
    function getId() {
        return $this->id;
    }

    function getTitulo() {
        return $this->titulo;
    }

    function getDescripcion() {
        return $this->descripcion;
    }

    function getSeccion() {
        return $this->seccion;
    }

    function getImporte() {
        return $this->importe;
    }

    function getImagen() {
        return $this->imagen;
    }

    function getStock() {
        return $this->stock;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setTitulo($titulo) {
        $this->titulo = $titulo;
    }

    function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    function setSeccion($seccion) {
        $this->seccion = $seccion;
    }

    function setImporte($importe) {
        $this->importe = $importe;
    }

    function setImagen($imagen) {
        $this->imagen = $imagen;
    }

    function setStock($stock) {
        $this->stock = $stock;
    }




}
