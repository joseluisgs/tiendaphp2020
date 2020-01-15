<?php


require_once MODEL_PATH . "Usuario.php";
require_once CONTROLLER_PATH . "ControladorBD.php";

class ControladorUsuario {

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
            self::$instancia = new ControladorUsuario();
        }
        return self::$instancia;
    }

    /**
     * Lista los usuarios
     * @param type $titulo
     * @param type $descripcion
     * devuelte: array de objetos
     *
     * se puede filtrar por nombre ó email
     * @return array|null
     */
    public function listarUsuarios($filtro) {
        // Creamos la conexión a la BD
        $lista = [];
        $bd = ControladorBD::getControlador();
        $bd->abrirBD();
        // creamos la consulta
        $consulta = "SELECT * FROM usuario WHERE nombre LIKE '%" . $filtro . "%' or email LIKE '%" . $filtro . "%'";
        //echo "Consulta desde controlador" . $consulta;
        $filas = $bd->consultarBD($consulta);

        if ($filas->rowCount() > 0) {
            while ($fila = $filas->fetch()) {
                $producto = new Usuario($fila['id'], $fila['nombre'], $fila['email'], $fila['direccion'], $fila['rol'], $fila['pass']);
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
     * Inserta un usuario en la base de datos
     * @param $usuario usuario a insertar
     * @return mixed
     */
    public function insertarUsuario($usuario) {
        $conexion = ControladorBD::getControlador();
        $conexion->abrirBD();
        $consulta = "insert into usuarios (nombre, alias, pass, email, direccion, foto) 
            values (:nombre, :alias, :pass, :email, :direccion, :foto)";
        $parametros = array(':nombre' => $usuario->getNombre(), ':alias' => $usuario->getAlias(),
            ':pass'=>$usuario->getPass(), ':email'=>$usuario->getEmail(), ':direccion'=>$usuario->getDireccion(),
            ':foto'=>$usuario->getImagen());
        $estado = $conexion->actualizarBD($consulta, $parametros);
        $conexion->cerrarBD();
        return $estado;
    }

    /**
     * Busca la existencia de un usuario por email
     * @param $email
     * @return int
     */
    public function buscarUsuario($email) {
        $bd = ControladorBD::getControlador();
        $bd->abrirBD();

        $consulta = "select * from usuarios where email = :email";
        $parametros = array(':email' => $email);

        $res = $bd->consultarBD($consulta, $parametros);
        $filas = $res->fetchAll(PDO::FETCH_OBJ);
        $bd->cerrarBD();

        return count($filas);

    }

    /**
     * Realiza el login buscando un usuario en una base de datos
     * @param $email email de usuario
     * @param $pass password
     * @return Usuario|null
     */
    public function login($email, $pass)
    {
        $bd = ControladorBD::getControlador();
        $bd->abrirBD();

        $consulta = "select * from usuarios where email = :email and pass = :pass";
        $parametros = array(':email' => $email, ':pass' => $pass);

        $res = $bd->consultarBD($consulta, $parametros);
        $filas = $res->fetchAll(PDO::FETCH_OBJ);

        if (count($filas) > 0) {
            $usuario = new Usuario($filas[0]->ID, $filas[0]->NOMBRE, $filas[0]->ALIAS, $filas[0]->EMAIL, $filas[0]->PASS, $filas[0]->DIRECCION, $filas[0]->FOTO, $filas[0]->ADMIN);
            $bd->cerrarBD();
            return $usuario;
        } else {
            return null;
        }
    }

    public function borrarUsuario($id) {
        $bd = ControladorBD::getControlador();
        $bd->abrirBD();
        $consulta = "delete from usuario where id = '" . $id . "'";
        $estado = $bd->consultarBD($consulta);
        $bd->cerrarBD();
        return $estado;
    }

    public function actualizarUsuario($id, $nombre, $email, $direccion, $rol, $pass) {
        $bd = ControladorBD::getControlador();
        $bd->abrirBD();
        $consulta = "update usuario set nombre='" . $nombre . "',email='" . $email . "', direccion='" . $direccion . "', rol=" . $rol . ", pass='" . $pass . "' where id=".$id."";
        //echo "<br><br><br>".$consulta;
        $estado = $bd->consultarBD($consulta);
        $bd->cerrarBD();
        return $estado;
    }

}