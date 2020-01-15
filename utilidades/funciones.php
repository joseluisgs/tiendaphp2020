<?php

/**
 * Función de alerta en JS
 * @param $texto
 * @param $ruta
 */
function alerta($texto, $ruta=null)
{
    echo "<script>
                alert('" . $texto . "')";
                if($ruta!=null)
                    echo "window.location= '" . $ruta . "'";
    echo "</script>";
}


    /**
     * Función de Filtrado de datos en formularios
     * @param $datos
     * @return string
     */
    function filtrado($datos) {
        $datos = trim($datos); // Elimina espacios antes y después de los datos
        $datos = stripslashes($datos); // Elimina backslashes \
        $datos = htmlspecialchars($datos); // Traduce caracteres especiales en entidades HTML
        return $datos;
    }

    /**
     * Codifica en BASE 64
     * @param $str
     * @return string
     */
    function encode($str){
        return urlencode(base64_encode($str));
    }

    /**
     * Descodifica en Base 64
     * @param $str
     * @return false|string
     */
    function decode($str){
        return base64_decode(urldecode($str));
    }
