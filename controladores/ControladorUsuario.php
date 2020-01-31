<?php


require_once MODEL_PATH . "Usuario.php";
require_once CONTROLLER_PATH . "ControladorBD.php";

class ControladorUsuario
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
    public function listarUsuarios($filtro)
    {
        // Creamos la conexión a la BD
        $lista = [];
        $bd = ControladorBD::getControlador();
        $bd->abrirBD();
        // creamos la consulta
        $consulta = "SELECT * FROM usuarios";

        $res = $bd->consultarBD($consulta);
        $filas = $res->fetchAll(PDO::FETCH_OBJ);

        if (count($filas) > 0) {
            foreach ($filas as $u) {
                // $id, $nombre, $alias, $email, $pass, $direccion, $imagen, $admin
                $usuario = new Usuario($u->ID, $u->NOMBRE, $u->ALIAS, $u->EMAIL, $u->PASS, $u->DIRECCION, $u->FOTO, $u->ADMIN);
                // Lo añadimos
                $lista[] = $usuario;
            }
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
    public function insertarUsuario($usuario)
    {
        $conexion = ControladorBD::getControlador();
        $conexion->abrirBD();
        $consulta = "insert into usuarios (nombre, alias, pass, email, direccion, foto) 
            values (:nombre, :alias, :pass, :email, :direccion, :foto)";
        $parametros = array(':nombre' => $usuario->getNombre(), ':alias' => $usuario->getAlias(),
            ':pass' => $usuario->getPass(), ':email' => $usuario->getEmail(), ':direccion' => $usuario->getDireccion(),
            ':foto' => $usuario->getImagen());
        $estado = $conexion->actualizarBD($consulta, $parametros);
        $conexion->cerrarBD();
        return $estado;
    }

    /**
     * Indica si existe un usuario dado un eamil, devuelve el id del usuario que lo tiene
     * @param $email
     * @return int
     */
    public function buscarEmail($email)
    {
        $bd = ControladorBD::getControlador();
        $bd->abrirBD();

        $consulta = "select * from usuarios where email = :email";
        $parametros = array(':email' => $email);

        $res = $bd->consultarBD($consulta, $parametros);
        $filas = $res->fetchAll(PDO::FETCH_OBJ);
        if (count($filas) > 0) {
            return $filas[0]->ID;
        } else {
            return 0;
        }


    }

    /**
     * Busca la existencia de un usuario por ID
     * @param $email
     * @return int
     */
    public function buscarUsuarioID($id)
    {
        $bd = ControladorBD::getControlador();
        $bd->abrirBD();

        $consulta = "select * from usuarios where id = :id";
        $parametros = array(':id' => $id);

        $res = $bd->consultarBD($consulta, $parametros);
        $filas = $res->fetchAll(PDO::FETCH_OBJ);

        if (count($filas) > 0) {
            $usuario = new Usuario($filas[0]->ID, $filas[0]->NOMBRE, $filas[0]->ALIAS,
                $filas[0]->EMAIL, $filas[0]->PASS, $filas[0]->DIRECCION, $filas[0]->FOTO, $filas[0]->ADMIN);
            $bd->cerrarBD();
            return $usuario;
        } else {
            return null;
        }

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

    /**
     * Elimina un usuario dado su id
     * @param $id
     * @return mixed
     */
    public function eliminarUsuario($id)
    {
        $bd = ControladorBD::getControlador();
        $bd->abrirBD();
        $consulta = "delete from usuarios where id = :id";
        $parametros = array(':id' => $id);
        $estado = $bd->consultarBD($consulta, $parametros);
        $bd->cerrarBD();
        return $estado;
    }

    /**
     * Actualiza un usuario
     * @param $usuario
     * @return mixed
     */
    public function actualizarUsuario($usuario)
    {
        $bd = ControladorBD::getControlador();
        $bd->abrirBD();
        $consulta = "Update usuarios set nombre =:nombre, alias=:alias, email=:email, direccion=:direccion, foto=:foto,
                    admin=:admin, pass=:pass where id=:id";
        $parametros = array(':id' => $usuario->getId(), ':nombre' => $usuario->getNombre(), ':alias' => $usuario->getAlias(),
            ':email' => $usuario->getEmail(), ':direccion' => $usuario->getDireccion(),
            ':foto' => $usuario->getImagen(), ':admin' => $usuario->getAdmin(), ':pass' => $usuario->getPass());
        $estado = $bd->actualizarBD($consulta, $parametros);
        $bd->cerrarBD();
        return $estado;
    }

}
