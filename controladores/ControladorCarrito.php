<?php


require_once MODEL_PATH . "LineaVenta.php";
require_once MODEL_PATH . "Venta.php";
require_once MODEL_PATH . "Producto.php";
require_once MODEL_PATH . "Usuario.php";
require_once CONTROLLER_PATH . "ControladorBD.php";

class ControladorCarrito {

    // Variable instancia para Singleton
    static private $instancia = null;

    // constructor--> Private por el patrón Singleton
    private function __construct() {

    }

    /**
     * Patrón Singleton. Ontiene una instancia del Manejador de la BD
     * @return instancia de conexion
     */
    public static function getControlador() {
        if (self::$instancia == null) {
            self::$instancia = new ControladorCarrito();
        }
        return self::$instancia;
    }


    /**
     * Inserta una línea de venta, producto, y unidades
     * @param Producto $producto
     * @param $uds
     * @return bool
     */
    public function insertarLineaCarrito(Producto $producto, $uds) {
        //antes de añadir uds al carrito debemos comprobar que hay existencias en stock contando tambien
        //las unidades que hay ya en el carrito
        $conexion = ControladorProducto::getControlador();
        $articulo = $conexion->buscarProductoId($producto->getId());
        $udsStock = $articulo->getStock();

        //uds que tenemos en el carrito
        $carrito = new ControladorCarrito();
        $udsCarrito = $carrito->unidadesArticulo($producto->getId());

        // si las unidades que pedimos más las que ya hay en el carrito de ese producto
        // es mayor que lo que hay en Stock no lo añadirmos
        if (($udsStock - ($uds+$udsCarrito)) >= 0) {
            //echo "<br><br><br>Entra por donde hay stock";
            //añadimos las nuevas unidades a la sesión para el total uds del carrito
            $_SESSION['uds'] += $uds;

            // si el artículo existe el total de unidades es lo que había + las nuevas
            if (array_key_exists($producto->getId(), $_SESSION['carrito'])) {
                echo "<br><br><br>Existe";
                $uds = $_SESSION['carrito'][$producto->getId()][1] + $uds;
            }
            $_SESSION['carrito'][$producto->getId()] = [$producto/*->getModelo(), $producto->getMarca(), $producto->getTipo(), $producto->getImporte()*/, $uds];
            //echo "<br><br><br>Insertamos";
            //exit();
            return true;
        } else {
            $id = encode($producto->getId());
            alerta("No hay en stock suficiente tras añadir este producto a tu carrito", "producto.php?id=$id"); //devolvemos el foco al mismo sitio
            return false;
        }
    }

    /**
     * Comprueba las unidades de un producto en el carrito
     * @param $id
     * @return int
     */
    public function unidadesArticulo($id){

        $uds=0;
        // si el artículo existe devuelve el número
        if (array_key_exists($id, $_SESSION['carrito'])) {
            $uds = $_SESSION['carrito'][$id][1];
        }
        return $uds;
    }

    /**
     * Actualiza las líneas de Carrito
     * @param $id
     * @param $uds
     * @return bool
     */
    public function actualizarLineaCarrito($id, $uds) {
        //Antes de actualizar hay que comprobar si existen uds
        $conexion = ControladorProducto::getControlador();
        $articulo = $conexion->buscarProductoId($id);
        $udsStock = $articulo->getStock();

        // si hay unidades ponemos añadirlas
        if (($udsStock - $uds) >= 0) {

            // comprobamos diferencia de uds que había y las que tengo ahora
            $udsAnteriores = $_SESSION['carrito'][$id][1];
            $udsActualizar = $uds - $udsAnteriores;
            //Modificamos la linea del carrito con las nuevas unidades
            $_SESSION['carrito'][$id][1] = $uds;
            $_SESSION['uds'] += $udsActualizar;
            return true;
        } else {

            alerta("No hay en stock", "carritoMostrar.php");
            return false;
        }
    }

    /**
     * Elimina la líneas de carrito
     * @param $id
     * @param $uds
     */
    public function borrarLineaCarrito($id, $uds) {
        //eliminamos esa linea del array completa y restamos las uds al total uds carrito
        unset($_SESSION['carrito'][$id]);
        $_SESSION['uds'] -= $uds;
    }

    /**
     * Devuelve el número de líenas de carrito
     * @return int
     */
    public function unidadesEnCarrito(){
        $total=0;
        foreach ($_SESSION['carrito'] as $key => $value) {
            $total += $value[1];
        }
        return $total;
    }

    public function vaciarCarrito() {
        //eliminamos esa linea del array completa y restamos las uds al total uds carrito
        unset($_SESSION['carrito']);
        $_SESSION['uds'] = 0;
    }

}
