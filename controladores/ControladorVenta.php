<?php

require_once MODEL_PATH . "Venta.php";
require_once MODEL_PATH . "LineaVenta.php";
require_once CONTROLLER_PATH . "ControladorBD.php";
require_once CONTROLLER_PATH . "ControladorProducto.php";

class ControladorVenta {

    // Variable instancia para Singleton
    static private $instancia = null;

    // constructor--> Private por el patrón Singleton
    private function __construct() {
        //echo "Conector creado";
    }

    /**
     * Patrón Singleton. Ontiene una instancia del Manejador de la BD
     * @return instancia de conexion
     */
    public static function getControlador() {
        if (self::$instancia == null) {
            self::$instancia = new ControladorVenta();
        }
        return self::$instancia;
    }

    /**
     * Busca una venta por un id
     * @param $id
     * @return Venta|null
     */
    public function buscarVentaID($id) {
        $bd = ControladorBD::getControlador();
        $bd->abrirBD();

        $consulta = "select * from ventas where idVenta = :idVenta";
        $parametros = array(':idVenta' => $id);

        $res = $bd->consultarBD($consulta, $parametros);
        $filas = $res->fetchAll(PDO::FETCH_OBJ);

        if (count($filas) > 0) {
            $venta = new Venta($filas[0]->idVenta, $filas[0]->fecha, $filas[0]->total,
                $filas[0]->subtotal, $filas[0]->iva, $filas[0]->nombre, $filas[0]->email, $filas[0]->direccion,
                $filas[0]->nombreTarjeta, $filas[0]->numTarjeta);
            $bd->cerrarBD();
            return $venta;
        } else {
            return null;
        }

    }

    public function buscarLineasID($id) {
        $lista = [];

        $bd = ControladorBD::getControlador();
        $bd->abrirBD();

        $consulta = "select * from lineasventas where idVenta = :idVenta";
        $parametros = array(':idVenta' => $id);

        $res = $bd->consultarBD($consulta, $parametros);
        $filas = $res->fetchAll(PDO::FETCH_OBJ);

        if (count($filas) > 0) {
            foreach ($filas as $venta) {
                $venta = new LineaVenta($venta->idVenta, $venta->idProducto, $venta->marca,
                    $venta->modelo, $venta->precio, $venta->cantidad);
                $bd->cerrarBD();
                $lista[] = $venta;
            }
            return $lista;
        } else {
            return null;
        }

    }

    /**
     * Almacena una venta en la línea de venta
     * @return mixed
     */
    public function insertarVenta($venta) {
        $conexion = ControladorBD::getControlador();
        $conexion->abrirBD();
        $consulta = "insert into ventas (idVenta, total, subtotal, iva, nombre, email, direccion, 
                    nombreTarjeta, numTarjeta) 
            values (:idVenta, :total, :subtotal, :iva, :nombre, :email, :direccion, :nombreTarjeta, :numTarjeta)";

        $parametros = array(':idVenta' => $venta->getId(), ':total' => $venta->getTotal(),
            ':subtotal'=>$venta->getSubtotal(), ':iva'=>$venta->getIva(), ':nombre'=>$venta->getNombre(),
            ':email'=>$venta->getEmail(), ':direccion'=>$venta->getDireccion(), ':nombreTarjeta'=>$venta->getNombreTarjeta(),
            'numTarjeta'=>$venta->getNumTarjeta());

        $estado = $conexion->actualizarBD($consulta, $parametros);
        $conexion->cerrarBD();

        // Procesamos cada línea del carrito
        foreach ($_SESSION['carrito'] as $key => $value) {

            $producto = $value[0];
            $cantidad = $value[1];

            $conexion->abrirBD();

            $consulta = "insert into lineasventas (idVenta, idProducto, marca, modelo, precio, cantidad) 
                    values (:idVenta, :idProducto, :marca, :modelo, :precio, :cantidad)";

            $parametros = array(':idVenta' => $venta->getId(), ':idProducto' => $producto->getId(),
                ':marca'=>$producto->getMarca(), ':modelo'=>$producto->getModelo(), ':precio'=>$producto->getPrecio(),
                ':cantidad'=>$cantidad);

            $estado = $conexion->actualizarBD($consulta, $parametros);

            // Actualizo el stock
            $cp = ControladorProducto::getControlador();
            $estado = $cp->actualizarStock($producto->getId(), ($producto->getStock()-$cantidad));
        }

        $conexion->cerrarBD();
        return $estado;
    }

}
