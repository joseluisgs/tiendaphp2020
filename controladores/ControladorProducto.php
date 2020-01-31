<?php

/**
 * Description of ControladorProducto
 *
 * @author link
 */
require_once MODEL_PATH . "Producto.php";
require_once CONTROLLER_PATH . "ControladorBD.php";

class ControladorProducto
{

    // Variable instancia para Singleton
    static private $instancia = null;

    // constructor--> Private por el patrón Singleton
    private function __construct()
    {
        //echo "Conector creado";
    }

    /**
     * Patrón Singleton. Ontiene una instancia del Manejador de la BD
     * @return instancia de conexion
     */
    public static function getControlador()
    {
        if (self::$instancia == null) {
            self::$instancia = new ControladorProducto();
        }
        return self::$instancia;
    }

    /**
     * Lista los productos dado un filtro
     * @param $filtro
     * @return array|null
     */
    public function listarProductos($filtro)
    {
        // Creamos la conexión a la BD
        $lista = [];
        $bd = ControladorBD::getControlador();
        $bd->abrirBD();
        // creamos la consulta
        $consulta = "SELECT * FROM productos";

        $res = $bd->consultarBD($consulta);
        $filas = $res->fetchAll(PDO::FETCH_OBJ);

        if (count($filas) > 0) {
            foreach ($filas as $p) {
                $producto = new Producto($p->ID, $p->TIPO, $p->MARCA, $p->MODELO, $p->DESCRIPCION, $p->PRECIO,
                    $p->STOCK, $p->OFERTA, $p->DISPONIBLE, $p->FECHA, $p->IMAGEN);
                // Lo añadimos
                $lista[] = $producto;
            }
            $bd->cerrarBD();
            return $lista;
        } else {
            return null;
        }

    }

    /**
     * Inserta un producto en la base de datos
     * @param $producto
     * @return mixed
     */
    public function insertarProducto($producto)
    {
        $conexion = ControladorBD::getControlador();
        $conexion->abrirBD();
        $consulta = "insert into productos (tipo, marca, modelo, descripcion, precio, stock, oferta, imagen, disponible, fecha) 
            values (:tipo, :marca, :modelo, :descripcion, :precio, :stock, :oferta, :imagen, :disponible, :fecha)";
        $parametros = array(':tipo' => $producto->getTipo(), ':marca' => $producto->getMarca(), ':modelo' => $producto->getModelo(),
            ':descripcion' => $producto->getDesc(), ':precio' => $producto->getPrecio(), ':stock' => $producto->getStock(),
            ':oferta' => $producto->getOferta(), ':imagen' => $producto->getImagen(), ':disponible' => $producto->getDisponible(),
            ':fecha' => $producto->getFecha());
        $estado = $conexion->actualizarBD($consulta, $parametros);
        $conexion->cerrarBD();
        return $estado;
    }

    /**
     * Busca un producto en la base de datos
     * @param $id
     * @return Producto|null
     */
    public function buscarProductoID($id)
    {
        $bd = ControladorBD::getControlador();
        $bd->abrirBD();
        $consulta = "select * from productos where id = :id";
        $parametros = array(':id' => $id);

        $res = $bd->consultarBD($consulta, $parametros);
        $filas = $res->fetchAll(PDO::FETCH_OBJ);

        if (count($filas) > 0) {
            $producto = new Producto($filas[0]->ID, $filas[0]->TIPO, $filas[0]->MARCA, $filas[0]->MODELO, $filas[0]->DESCRIPCION,
                $filas[0]->PRECIO, $filas[0]->STOCK, $filas[0]->OFERTA, $filas[0]->DISPONIBLE, $filas[0]->FECHA, $filas[0]->IMAGEN);
            $bd->cerrarBD();
            return $producto;
        } else {
            return null;
        }
    }

    /**
     * Elimina un usuario de la BD
     * @param $id
     * @return mixed
     */
    public function eliminarProducto($id)
    {
        $bd = ControladorBD::getControlador();
        $bd->abrirBD();
        $consulta = "delete from productos where id = :id";
        $parametros = array(':id' => $id);
        $estado = $bd->consultarBD($consulta, $parametros);
        $bd->cerrarBD();
        return $estado;
    }

    /**
     * Actualiza un producto en la base de datos
     * @param $producto
     * @return mixed
     */
    public function actualizarProducto($producto)
    {
        $bd = ControladorBD::getControlador();
        $bd->abrirBD();
        $consulta = "update productos set tipo=:tipo, marca=:marca, modelo=:modelo, descripcion=:descripcion, 
                    precio=:precio, stock=:stock, oferta=:oferta, imagen=:imagen, disponible=:disponible, fecha=:fecha
                    where id=:id";
        $parametros = array(':id' => $producto->getId(), ':tipo' => $producto->getTipo(), ':marca' => $producto->getMarca(), ':modelo' => $producto->getModelo(),
            ':descripcion' => $producto->getDesc(), ':precio' => $producto->getPrecio(), ':stock' => $producto->getStock(),
            ':oferta' => $producto->getOferta(), ':imagen' => $producto->getImagen(), ':disponible' => $producto->getDisponible(),
            ':fecha' => $producto->getFecha());
        $estado = $bd->actualizarBD($consulta, $parametros);
        $bd->cerrarBD();
        return $estado;
    }

    /**
     * Lista los productos de ofertas
     * @param $filtro
     * @return array|null
     */
    public function listarDestacados()
    {
        // Creamos la conexión a la BD
        $lista = [];
        $bd = ControladorBD::getControlador();
        $bd->abrirBD();
        // creamos la consulta
        $consulta = "SELECT * FROM productos WHERE stock>0 and oferta>0 and disponible=1 order by RAND() limit 4";

        $res = $bd->consultarBD($consulta);
        $filas = $res->fetchAll(PDO::FETCH_OBJ);

        if (count($filas) > 0) {
            foreach ($filas as $p) {
                $producto = new Producto($p->ID, $p->TIPO, $p->MARCA, $p->MODELO, $p->DESCRIPCION, $p->PRECIO,
                    $p->STOCK, $p->OFERTA, $p->DISPONIBLE, $p->FECHA, $p->IMAGEN);
                // Lo añadimos
                $lista[] = $producto;
            }
            $bd->cerrarBD();
            return $lista;
        } else {
            return null;
        }

    }

    /**
     * Actualiza el Stock
     * @return mixed
     */
    public function actualizarStock($id, $stock)
    {
        $bd = ControladorBD::getControlador();
        $bd->abrirBD();

        $consulta = "update productos set stock=:stock where id=:id";
        $parametros = array(':id' => $id, ':stock' => $stock);
        $estado = $bd->actualizarBD($consulta, $parametros);
        $bd->cerrarBD();
        return $estado;

        $conexion->cerrarBD();
        return $estado;
    }


    /**
     * Mustra la distintas secciones que hay de un producto
     * @return array|null
     */
    public function mostrarSecciones()
    {
        $bd = ControladorBD::getControlador();
        $bd->abrirBD();
        // creamos la consulta
        $consulta = "SELECT DISTINCT tipo as nombre FROM producto_tipo";
        $res = $bd->consultarBD($consulta);
        $filas = $res->fetchAll(PDO::FETCH_OBJ);
        if (count($filas) > 0) {
            return $filas;
            $conexion->cerrarBD();
            return $secciones;
        } else {
            return null;
        }
    }

}
