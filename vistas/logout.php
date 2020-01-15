<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/tienda/dirs.php";
require_once VIEW_PATH . "cabecera.php";

$cs = ControladorSesion::getControlador();
$cs->destruirSesion();

