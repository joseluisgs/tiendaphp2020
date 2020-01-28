<?php


class LineaVenta {

    private $idVenta;
    private $idProducto;
    private $marca;
    private $modelo;
    private $precio;
    private $cantidad;

    /**
     * LineaVenta constructor.
     * @param $idVenta
     * @param $idProducto
     * @param $marca
     * @param $modelo
     * @param $precio
     * @param $cantidad
     */
    public function __construct($idVenta, $idProducto, $marca, $modelo, $precio, $cantidad)
    {
        $this->idVenta = $idVenta;
        $this->idProducto = $idProducto;
        $this->marca = $marca;
        $this->modelo = $modelo;
        $this->precio = $precio;
        $this->cantidad = $cantidad;
    }

    /**
     * @return mixed
     */
    public function getIdVenta()
    {
        return $this->idVenta;
    }

    /**
     * @param mixed $idVenta
     */
    public function setIdVenta($idVenta): void
    {
        $this->idVenta = $idVenta;
    }

    /**
     * @return mixed
     */
    public function getIdProducto()
    {
        return $this->idProducto;
    }

    /**
     * @param mixed $idProducto
     */
    public function setIdProducto($idProducto): void
    {
        $this->idProducto = $idProducto;
    }

    /**
     * @return mixed
     */
    public function getMarca()
    {
        return $this->marca;
    }

    /**
     * @param mixed $marca
     */
    public function setMarca($marca): void
    {
        $this->marca = $marca;
    }

    /**
     * @return mixed
     */
    public function getModelo()
    {
        return $this->modelo;
    }

    /**
     * @param mixed $modelo
     */
    public function setModelo($modelo): void
    {
        $this->modelo = $modelo;
    }

    /**
     * @return mixed
     */
    public function getPrecio()
    {
        return $this->precio;
    }

    /**
     * @param mixed $precio
     */
    public function setPrecio($precio): void
    {
        $this->precio = $precio;
    }

    /**
     * @return mixed
     */
    public function getCantidad()
    {
        return $this->cantidad;
    }

    /**
     * @param mixed $cantidad
     */
    public function setCantidad($cantidad): void
    {
        $this->cantidad = $cantidad;
    }




}
