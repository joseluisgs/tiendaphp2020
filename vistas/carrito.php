<?php

// Lo que necesitamos
require_once $_SERVER['DOCUMENT_ROOT'] . "/tienda/dirs.php";
require_once VIEW_PATH . "cabecera.php";


// como esta página está restringida a usuarios administradores si no está logueado como admin
// lo remitirá a la pagina de inicio
// rol:1 administrador
if ((!isset($_SESSION['nombre']))) {
    header("location: error.php");
    exit();
}


?>



<br>
<!-- Pie de la página web -->
<?php require_once VIEW_PATH . "pie.php";

?>
