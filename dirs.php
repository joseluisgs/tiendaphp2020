<?php

// Definimos con una constante cada uno de los directorios que tenemos para poder llamarlos


if (!defined('ROOT_PATH'))
    define('ROOT_PATH', dirname(__FILE__) . "/");

// Subidirectorio, modificar nombre de la carpeta donde se haya instalado la tienda
if (!defined('DIRECTORIO_PATH'))
    define('DIRECTORIO_PATH', "/tienda/");

if (!defined('MODEL_PATH'))
    define('MODEL_PATH', ROOT_PATH . "modelos/");

if (!defined('VIEW_PATH'))
    define('VIEW_PATH', ROOT_PATH . "vistas/");

if (!defined('CONTROLLER_PATH'))
    define('CONTROLLER_PATH', ROOT_PATH . "controladores/");

if (!defined('UTILITY_PATH'))
    define('UTILITY_PATH', ROOT_PATH . "utilidades/");

if (!defined('RESOURCE_PATH'))
    define('RESOURCE_PATH', ROOT_PATH . "recursos/");

if (!defined('IMAGES_PATH'))
    define('IMAGES_PATH', ROOT_PATH . "images/");

if (!defined('PRODUCTS_IMAGES_PATH'))
    define('PRODUCTS_IMAGES_PATH', ROOT_PATH. "img_productos/");

if (!defined('USERS_IMAGES_PATH'))
    define('USERS_IMAGES_PATH', ROOT_PATH. "img_usuarios/");

if ( !defined('VENDOR_PATH') )
    define('VENDOR_PATH', ROOT_PATH."vendor/");

?>