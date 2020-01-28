<?php


class LineaVenta {

    private $idVenta;
    private $idProducto;
    private $titulo; //linea descriptiva del producto
    private $seccion; // en mi tabla no he incluido ni modelo ni marca
    private $precio;
    private $cantidad;
    private $total;

    function __construct($idVenta, $idProducto, $titulo, $seccion, $precio, $cantidad, $total) {
        $this->idVenta = $idVenta;
        $this->idProducto = $idProducto;
        $this->titulo = $titulo;
        $this->seccion = $seccion;
        $this->precio = $precio;
        $this->cantidad = $cantidad;
        $this->total = $total;
    }
    function getIdVenta() {
        return $this->idVenta;
    }

    function getIdProducto() {
        return $this->idProducto;
    }

    function getTitulo() {
        return $this->titulo;
    }

    function getSeccion() {
        return $this->seccion;
    }

    function getPrecio() {
        return $this->precio;
    }

    function getCantidad() {
        return $this->cantidad;
    }

    function getTotal() {
        return $this->total;
    }

    function setIdVenta($idVenta) {
        $this->idVenta = $idVenta;
    }

    function setIdProducto($idProducto) {
        $this->idProducto = $idProducto;
    }

    function setTitulo($titulo) {
        $this->titulo = $titulo;
    }

    function setSeccion($seccion) {
        $this->seccion = $seccion;
    }

    function setPrecio($precio) {
        $this->precio = $precio;
    }

    function setCantidad($cantidad) {
        $this->cantidad = $cantidad;
    }

    function setTotal($total) {
        $this->total = $total;
    }



}
