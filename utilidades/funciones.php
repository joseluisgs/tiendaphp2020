<?php

/**
 * Función de alerta en JS
 * @param $texto
 * @param $ruta
 */
function alerta($texto, $ruta = null)
{
    echo "<script>";
    echo "alert('" . $texto . "');";
    if ($ruta != null)
        echo "window.location= '" . $ruta . "'";
    echo "</script>";
}


/**
 * Función de Filtrado de datos en formularios
 * @param $datos
 * @return string
 */
function filtrado($datos)
{
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
function encode($str)
{
    return urlencode(base64_encode($str));
}

/**
 * Descodifica en Base 64
 * @param $str
 * @return false|string
 */
function decode($str)
{
    return base64_decode(urldecode($str));
}

/**
 * Te devuelve el formato para meterlo en base de datos
 * @param string $date
 * @return string
 */
function getfechaBD(string $fecha): string
{
    $date = date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $fecha)));
    echo $date;
    return $date;
}
