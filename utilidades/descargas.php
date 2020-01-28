<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/tienda/dirs.php";
require_once CONTROLLER_PATH . "ControladorDescargas.php";
require_once UTILITY_PATH . "funciones.php";

// Filtrado por rol

$opcion = $_GET["opcion"];
$id= decode($_GET["id"]);

$fichero = ControladorDescargas::getControlador();
switch ($opcion) {
    case 'U_JSON':
        $fichero->usuariosJSON();
        break;
    case 'U_PDF':
        $fichero->usuariosPDF();
        break;
        case 'P_JSON':
        $fichero->productosJSON();
        break;
    case 'P_PDF':
        $fichero->productosPDF();
        break;
        case 'PROD_PDF':
        $fichero->productoPDF($id);
        break;
    case 'USR_PDF':
        $fichero->usuarioPDF($id);
        break;
    case 'FAC_PDF':
        $fichero->facturaPDF($id);
        break;

}
