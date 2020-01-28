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
     * Lista los productos
     * @param type $titulo
     * @param type $descripcion
     * devuelte: array de objetos
     */
    public function listarVentas($filtro) {
        // Creamos la conexión a la BD
        $lista = [];
        $bd = ControladorBD::getControlador();
        $bd->abrirBD();
        // creamos la consulta
        $consulta = "SELECT * FROM producto WHERE titulo LIKE '%" . $filtro . "%' or seccion LIKE '%" . $filtro . "%' or descripcion LIKE '%" . $filtro . "%'";
        //echo "Consulta desde controlador".$consulta;
        $filas = $bd->consultarBD($consulta);

        if ($filas->rowCount() > 0) {
            while ($fila = $filas->fetch()) {
                $producto = new Producto($fila['id'], $fila['titulo'], $fila['descripcion'], $fila['seccion'], $fila['importe'], $fila['foto'], $fila['stock']);
                // Lo añadimos
                $lista[] = $producto;
            }
            //$filas->free();
            $bd->cerrarBD();
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

    // aquí debemos recorrer el array de sesion carrito e ir añadiendo las lineas
    // tambien debemos controlar que hay que modificar el valor de stock en el producto correspondiente.
    // sesion carrito: clave[id] -> [$producto->getTitulo(), $producto->getSeccion(), $producto->getImporte(), $uds]
    // LIMPIAR CARRITO SESION
    // LIMPIAR CARRITO COOKIE
    public function almacenarLineasVenta() {

        $conexion = ControladorBD::getControlador();
        $conexion->abrirBD();

        foreach ($_SESSION['carrito'] as $key => $value) {

            $consulta = "INSERT INTO `lineaVenta` (`idVenta`, `idProducto`, `titulo`, `seccion`, `precio`, `cantidad`, `total`) "
                . "VALUES ('" . $_SESSION['idCompra'] . "', '" . $key . "', '" . $value[0] . "', '" . htmlentities($value[1]) . "', '" . $value[2] . "', '" . $value[3] . "', '" . $value[2] * $value[3] . "')";
            $estado = $conexion->actualizarBD($consulta);
        }
        $conexion->cerrarBD();
    }
}
