<?php


class ControladorSesion
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
            self::$instancia = new ControladorSesion();
        }
        return self::$instancia;
    }

    /**
     * Crea la Sesiond e usuario
     * @param Usuario $usuario
     */
    public function crearSesion(Usuario $usuario){
        //valores de usuario
        $_SESSION['nombre'] = $usuario->getNombre();
        $_SESSION['alias'] = $usuario->getAlias();
        $_SESSION['rol'] = $usuario->getAdmin();
        $_SESSION['email'] = $usuario->getEmail();
        $_SESSION['direccion'] = $usuario->getDireccion();
        $_SESSION['id_usuario'] = $usuario->getId();
        // Ponemos las unidades y el carrito a nulos
        $_SESSION['uds'] = 0;
        $_SESSION['carrito'] = array();

    }

    /**
     * Reinicia la sesion de usuario
     */
    public function reiniciarSesion()
    {
        //valores de carrito
        $_SESSION['uds'] = 0;
        $_SESSION['total'] = 0;
        $_SESSION['carrito'] = array();
        crearCookie();  // crea o modifica
    }


    /**
     * Cra la Cookie
     * la cookie tendrá el siguiente formato clave email-> valor: carrito actual del logueado
     * utilizamos esta funcion para crear ó actualizar el valor cada vez q se añada algo a la cookie
     */
    public function crearCookie()
    {
        $expiracion = time() + 2 * 24 * 60 * 60; // expiración para 2 días
        $clave = $_SESSION['email'];
        $valor = serialize($_SESSION['carrito']); // Ojo al recuperar carrito en cookie
        setcookie($clave, $valor, $expiracion);
    }

    /**
     * Destruye la Cookie
     */
    public function destruirCookie()
    {
        setcookie($_SESSION['email'], '', time() - 100);
        exit();
    }

    /**
     * Destruye la sesion
     */
    public function destruirSesion()
    {
        session_destroy();
        session_unset();
        alerta("Hasta pronto", "../index.php");
        exit();
    }
}
