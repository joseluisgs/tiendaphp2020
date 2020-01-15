<?php

/**
 * Description of ControladorProducto
 *
 * @author link
 */
require_once MODEL_PATH . "Producto.php";
require_once CONTROLLER_PATH . "ControladorBD.php";

class ControladorProducto {

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
            self::$instancia = new ControladorProducto();
        }
        return self::$instancia;
    }

    /**
     * Lista los productos
     * @param type $titulo
     * @param type $descripcion
     * devuelte: array de objetos
     * @return array|null
     */
    public function listarProductos($filtro) {
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
     * Almacenana un objeto alumno en la base de datos
     * @param type $nombre
     * @param type $apellidos
     * @param type $email
     */
    public function almacenarProducto($id, $titulo, $descripcion, $seccion, $importe, $foto, $stock) {
        $producto = new Producto($id, $titulo, $descripcion, $seccion, $importe, $foto, $stock);
        $conexion = ControladorBD::getControlador();
        $conexion->abrirBD();
        $consulta = "insert into producto (id, titulo, descripcion, seccion, importe, foto, stock) values ('" . $producto->getId() . "','" . $producto->getTitulo() . "','" . $producto->getDescripcion() . "','" . $producto->getSeccion() . "'," . $producto->getImporte() . ",'" . $producto->getFoto() . "'," . $producto->getStock() . ")";
        //echo $consulta;
        $estado = $conexion->actualizarBD($consulta);
        $conexion->cerrarBD();
        return estado;
    }

    public function buscarProducto($id) {
        $bd = ControladorBD::getControlador();
        $bd->abrirBD();
        $consulta = "select * from producto where id = '" . $id . "'";
        //echo "<br><br>".$consulta;
        $filas = $bd->consultarBD($consulta);
        if ($filas->rowCount() > 0) {
            while ($fila = $filas->fetch()) {
                $producto = new Producto($fila['id'], $fila['titulo'], $fila['descripcion'], $fila['seccion'], $fila['importe'], $fila['foto'], $fila['stock']);
                // Lo añadimos
            }
            //$filas->free();
            $bd->cerrarBD();
            return $producto;
        } else {
            return null;
        }
    }

    public function borrarProducto($id) {
        $bd = ControladorBD::getControlador();
        $bd->abrirBD();
        $consulta = "delete from producto where id = '" . $id . "'";
        $estado = $bd->consultarBD($consulta);
        $bd->cerrarBD();
        return $estado;
    }

    public function actualizarProducto($id, $titulo, $descripcion, $seccion, $importe, $foto, $stock) {
        $bd = ControladorBD::getControlador();
        $bd->abrirBD();
        $consulta = "update producto set id='" . $id . "', titulo='" . $titulo . "', descripcion='" . $descripcion . "', seccion='" . $seccion . "', importe=" . $importe . ", foto='" . $foto . "', stock=" . $stock . " where id= '" . $id . "'";
        //echo "<br><br>La consulta:" . $consulta;
        $estado = $bd->consultarBD($consulta);
        $bd->cerrarBD();
        return $estado;
    }

    // restamos las unidades que se han comprado al stock del producto
    public function actualizarLineasStock() {

        $conexion = ControladorBD::getControlador();
        $conexion->abrirBD();

        foreach ($_SESSION['carrito'] as $key => $value) {
            $consulta = "UPDATE producto set stock=stock-" . $value[3] . " where id= '" . $key . "'";
            $estado = $conexion->consultarBD($consulta);
        }
        $conexion->cerrarBD();
        return $estado;
    }


    /**
     * @return array|null
     */
    public function mostrarSecciones() {
        $bd = ControladorBD::getControlador();
        $bd->abrirBD();
        // creamos la consulta
        $consulta = "SELECT DISTINCT tipo as nombre FROM producto_tipo";
        $res = $bd->consultarBD($consulta);
        $filas=$res->fetchAll(PDO::FETCH_OBJ);
        if (count($filas)>0) {
            return $filas;
            $conexion->cerrarBD();
            return $secciones;
        } else {
            return null;
        }
    }

    public function serializarProducto($producto) {
        return serialize($producto);
    }

    public function deserializarProducto($cadena) {
        return unserialize($cadena);
    }

}
