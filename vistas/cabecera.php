<!-- Cabecera de las páginas web común a todos -->
<?php

// Para evitar notice errores y warnings
error_reporting(E_ALL & ~E_NOTICE);

header("Content-Type: text/html; charset=utf-8");
// Incluimos los directorios a trabajar
require_once $_SERVER['DOCUMENT_ROOT'] . "/tienda/dirs.php";


// Incluimos los controladores que vamos a usar
require_once CONTROLLER_PATH . "ControladorProducto.php";
require_once CONTROLLER_PATH . "ControladorSesion.php";
require_once CONTROLLER_PATH . "ControladorUsuario.php";
require_once CONTROLLER_PATH . "ControladorImagen.php";
require_once CONTROLLER_PATH . "Paginador.php";
require_once CONTROLLER_PATH . "ControladorCarrito.php";
require_once CONTROLLER_PATH . "ControladorVenta.php";
require_once UTILITY_PATH . "funciones.php";

ob_start();
session_start();




?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
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
        .wrapper {
            width: 950px;
            margin: 0 auto;
        }

        .page-header h2 {
            margin-top: 0;
        }

        table tr td:last-child a {
            margin-right: 15px;
        }

        body {
            margin: 0;
            background: url('<?php echo DIRECTORIO_PATH . "images/fondo.jpg"; ?>');
            background-size: cover;
            background-repeat: yes-repeat;
            display: compact;
        }


    </style>

    <!-- Estilos de la factura -->
    <style>
        .invoice-title h2, .invoice-title h3 {
            display: inline-block;
        }

        .table > tbody > tr > .no-line {
            border-top: none;
        }

        .table > thead > tr > .no-line {
            border-bottom: none;
        }

        .table > tbody > tr > .thick-line {
            border-top: 2px solid;
        }
    </style>
    <!-- Para imprimir -->
    <style type="text/css" media="print">
        @media print {
            .nover {
                visibility: hidden
            }
        }
    </style>

    <!-- Catalog de productos-->
    <style>
        @import url(http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css);
        .col-item
        {
            border: 1px solid #E1E1E1;
            border-radius: 10px;
            background: #FFF;
        }
        .col-item:hover
        {
            box-shadow: 0px 2px 5px -1px #000;
            -moz-box-shadow: 0px 2px 5px -1px #000;
            -webkit-box-shadow: 0px 2px 5px -1px #000;
            -webkit-border-radius: 0px;
            -moz-border-radius: 0px;
            border-radius: 10px;
            -webkit-transition: all 0.3s ease-in-out;
            -moz-transition: all 0.3s ease-in-out;
            -o-transition: all 0.3s ease-in-out;
            -ms-transition: all 0.3s ease-in-out;
            transition: all 0.3s ease-in-out;
            border-bottom:2px solid #52A1D5;
        }
        .col-item .photo img
        {
            margin: 0 auto;
            width: 100%;
            padding: 1px;
            border-radius: 10px 10px 0 0 ;
        }

        .col-item .info
        {
            padding: 10px;
            border-radius: 0 0 5px 5px;
            margin-top: 1px;
        }

        .col-item .price
        {
            /*width: 50%;*/
            float: left;
            margin-top: 5px;
        }

        .col-item .price h5
        {
            line-height: 20px;
            margin: 0;
        }

        .price-text-color
        {
            color: #219FD1;
        }

        .col-item .info .rating
        {
            color: #777;
        }

        .col-item .rating
        {
            /*width: 50%;*/
            float: left;
            font-size: 17px;
            text-align: right;
            line-height: 52px;
            margin-bottom: 10px;
            height: 52px;
        }

        .col-item .separator
        {
            border-top: 1px solid #E1E1E1;
        }

        .clear-left
        {
            clear: left;
        }

        .col-item .separator p
        {
            line-height: 20px;
            margin-bottom: 0;
            margin-top: 10px;
            text-align: center;
        }

        .col-item .separator p i
        {
            margin-right: 5px;
        }
        .col-item .btn-add
        {
            width: 50%;
            float: left;
        }

        .col-item .btn-add
        {
            border-right: 1px solid #E1E1E1;

        }

        .col-item .btn-details
        {
            width: 50%;
            float: left;
            padding-left: 10px;
        }
        .controls
        {
            margin-top: 20px;
        }
        [data-slide="prev"]
        {
            margin-right: 10px;
        }

        /*
        Hover the image
        */
        .post-img-content
        {
            height: 196px;
            position: relative;
        }
        .post-img-content img
        {
            position: absolute;
            padding: 1px;
            border-radius: 10px 10px 0 0 ;
        }
        .post-title{
            display: table-cell;
            vertical-align: bottom;
            z-index: 2;
            position: relative;
        }
        .post-title b{
            background-color: rgba(51, 51, 51, 0.58);
            display: inline-block;
            margin-bottom: 5px;
            margin-left: 2px;
            color: #FFF;
            padding: 10px 15px;
            margin-top: 10px;
            font-size: 12px;
        }
        .post-title b:first-child{
            font-size: 14px;
        }
        .round-tag{
            width: 60px;
            height: 60px;
            border-radius: 50% 50% 50% 0;
            border: 4px solid #FFF;
            background: #245da1;
            position: absolute;
            bottom: 0px;
            padding: 15px 6px;
            font-size: 17px;
            color: #FFF;
            font-weight: bold;
        }
    </style>

    <!-- Otros -->

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