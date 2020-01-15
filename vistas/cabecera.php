<!-- Cabecera de las páginas web común a todos -->
<?php
// Incluimos los directorios a trabajar
require_once $_SERVER['DOCUMENT_ROOT'] . "/tienda/dirs.php";

// Incluimos los controladores que vamos a usar
require_once CONTROLLER_PATH . "ControladorProducto.php";
require_once CONTROLLER_PATH . "ControladorSesion.php";
require_once CONTROLLER_PATH . "ControladorUsuario.php";
require_once CONTROLLER_PATH . "ControladorImagen.php";
require_once CONTROLLER_PATH . "Paginador.php";
/*
require_once CONTROLLER_PATH . "ControladorCarrito.php";
require_once CONTROLLER_PATH . "ControladorVenta.php";


*/
require_once UTILITY_PATH . "funciones.php";

session_start();




?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Tienda PHP 2020</title>
    <!--
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="css/estilos.css">
    <script src="script/jquery.min.js"></script>
    <script src="script/bootstrap.js"></script>
    -->
    <link rel="icon" type="image/png" href='favicon.png'>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="css/estilos.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.js"></script>

    <style type="text/css">
        .wrapper{
            width: 950px;
            margin: 0 auto;
        }
        .page-header h2{
            margin-top: 0;
        }
        table tr td:last-child a{
            margin-right: 15px;
        }

        body {
            margin: 0;
            background: url('<?php echo DIRECTORIO_PATH . "images/fondo.jpg"; ?>');
            background-size:     cover;
            background-repeat:yes-repeat;
            display: compact;
        }



    </style>

    <script type="text/javascript">
        $(document).ready(function () {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
</head>
<body>

<!-- Cabecera de las páginas web común a todos -->
<!-- Barra de Navegacion -->
<?php require_once "navbar.php"; ?>