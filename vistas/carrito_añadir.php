<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/tienda/dirs.php";
require_once VIEW_PATH . "cabecera.php";


// Compramos la existencia del parámetro id antes de usarlo
if (isset($_GET["id"]) && !empty(trim($_GET["id"])) && isset($_GET["page"]) && !empty(trim($_GET["page"]))) {
    $id = decode($_GET["id"]);
    $page = decode($_GET["page"]);
    // Cargamos el controlador
    $controlador = ControladorProducto::getControlador();
    $producto= $controlador->buscarProductoID($id);
    // Lo insertamos y vamos a la página antaerior
    $carrito = ControladorCarrito::getControlador();
    if ($carrito->insertarLineaCarrito($producto,1)) {
        // si es correcto recarga la página y actualizamos la cookie
        $sesion = ControladorSesion::getControlador();
        $sesion->crearCookie();
        // Volvemos atras
        header("location:".$page);
        exit();
    }

}

//si no existe el usuario lo enviamos a error para que no haga nada
if (is_null($producto)) {
    // hay un error
    alerta("Operación no permitida", "error.php");
    exit();
}