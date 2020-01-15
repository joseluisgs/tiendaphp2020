<?php

/**
 * Class ControladorImagen
 */

class ControladorImagen {

    // Variable instancia para Singleton
    static private $instancia = null;

    // constructor--> Private por el patrón Singleton
    private function __construct() {
        //echo "Conector creado";
    }

    /**
     * Patrón Singleton. Ontiene una instancia del Controlador de Descargas
     * @return instancia de conexion
     */
    public static function getControlador() {
        if (self::$instancia == null) {
            self::$instancia = new ControladorImagen();
        }
        return self::$instancia;
    }

    /**
     * Almacena un fichero en el servidor que se encuetra en la variable FILE
     * @param $fichero_tmp
     * @param $fichero_destino
     * @return bool
     */
    function salvarImagen($fichero_tmp, $fichero_destino) {
        echo $fichero_tmp .'<br>';
        echo $fichero_destino .'<br>';
        if (move_uploaded_file($fichero_tmp, $fichero_destino)) {
            return true;
        }
        return false;
    }

    /**
     * Elimina un fichero almacenado en el servidor
     * @param $fichero
     * @return bool
     */
    function eliminarImagen($fichero) {
        if (file_exists($fichero)) {
            unlink($fichero); // Funcion para borrar desde el servidor
            return true;
            //throw new Exception('No se puede borrar el fichero ' . $fichero . ' Por favor cierre otras aplicaciones que lo pueden estar usando.');
        }
        return false;
    }

    function actualizarFoto(){
        $fotoAnterior = trim($_POST["fotoAnterior"]);
        // Procesamos la imagen
        $extension = explode("/", $_FILES['foto']['type']);
        $nombreFoto = md5($_FILES['foto']['tmp_name'] . $_FILES['foto']['name']) . "." . $extension[1];
        if (!move_uploaded_file($_FILES['foto']['tmp_name'], ROOT_PATH . "/fotos/$nombreFoto")) {
            //header("location: error.php");
            //exit();
            $nombreFoto = $fotoAnterior;
        }
        return $nombreFoto;
    }

}

?>