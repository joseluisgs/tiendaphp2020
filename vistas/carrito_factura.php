<?php

// Lo que necesitamos
require_once $_SERVER['DOCUMENT_ROOT'] . "/tienda/dirs.php";
require_once CONTROLLER_PATH . "ControladorSesion.php";
require_once UTILITY_PATH . "funciones.php";
require_once CONTROLLER_PATH . "ControladorVenta.php";
require_once VIEW_PATH . "cabecera.php";

$cs = ControladorSesion::getControlador();
$cs->reiniciarCarrito();
//$cs->destruirCookie();


// Solo entramos si somos el usuario y hay items
if ((!isset($_SESSION['nombre']))) {
    header("location: error.php");
    exit();
}

// Recuperamos la venta
if ((!isset($_GET['venta']))) {
    header("location: error.php");
    exit();
}

$idVenta = decode($_GET['venta']);
$cv = ControladorVenta::getControlador();
$venta = $cv->buscarVentaID($idVenta);
$lineas = $cv->buscarLineasID($idVenta);


?>


<main role="main">
    <div class="container">
    <div class="row">
        <div class="col-xs-12">
    		<section class="page-header clearfix text-center">
                    <h3 class="pull-left">Factura</h3>
                    <h3 class="pull-right">Pedido nº: <?php echo $venta->getId(); ?></h3>
</section>
</div>

<hr>
<div class="row">
    <div class="col-xs-6">
        <address>
            <strong>Facturado a:</strong><br>
            <?php echo $venta->getNombreTarjeta(); ?><br>
        </address>
    </div>
    <div class="col-xs-6 text-right">
        <address>
            <strong>Enviado a:</strong><br>
            <?php echo $venta->getNombre(); ?><br>
            <?php echo $venta->getEmail(); ?><br>
            <?php echo $venta->getDireccion(); ?><br>
        </address>
    </div>
</div>
<div class="row">
    <div class="col-xs-6">
        <address>
            <strong>Método de pago:</strong><br>
            Tarjeta de crédito/debito: **** <?php echo substr($venta->getNumTarjeta(),-4); ?><br>
        </address>
    </div>
    <div class="col-xs-6 text-right">
        <address>
            <strong>Fecha de compra:</strong><br>
            <?php
                $date = new DateTime($venta->getFecha());
                echo $date->format('d/m/Y'); ?><br><br>
        </address>
    </div>
</div>
</div>
</div>
    <div class="content content_content" style="width: 95%; margin: auto;">
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><strong>Productos</strong></h3>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-condensed">
                        <thead>
                        <tr>
                            <td><strong>Item</strong></td>
                            <td class="text-center"><strong>Precio (PVP)</strong></td>
                            <td class="text-center"><strong>Cantidad</strong></td>
                            <td class="text-right"><strong>Total</strong></td>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach ($lineas as $linea) {
                            echo "<tr>";
                            echo "<td>".$linea->getMarca()." ".$linea->getModelo()."</td>";
                            echo "<td class='text-center'>".$linea->getPrecio()." €</td>";
                            echo "<td class='text-center'>".$linea->getCantidad()."</td>";
                            echo "<td class='text-right'>".($linea->getPrecio()*$linea->getCantidad())." €</td>";
                            echo "</tr>";
                        }
                        ?>

                        <tr>
                            <td class="thick-line"></td>
                            <td class="thick-line"></td>
                            <td class="thick-line text-center"><strong>Total sin IVA</strong></td>
                            <td class="thick-line text-right"><?php echo $venta->getSubtotal(); ?> €</td>
                        </tr>
                        <tr>
                            <td class="no-line"></td>
                            <td class="no-line"></td>
                            <td class="no-line text-center"><strong>I.V.A</strong></td>
                            <td class="no-line text-right"><?php echo $venta->getIva(); ?> €</td>
                        </tr>
                        <tr>
                            <td class="no-line"></td>
                            <td class="no-line"></td>
                            <td class="no-line text-center"><strong>TOTAL</strong></td>
                            <td class="no-line text-right"><strong><?php echo $venta->getTotal(); ?> €</strong></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
    </div>
    <div class="row no-print nover">
        <div class='text-center'>
            <a href="javascript:window.print()" class='btn btn-info'><span class='glyphicon glyphicon-print'></span> Imprimir </a>
            <a href="../index.php" class='btn btn-success'><span class='glyphicon glyphicon-ok'></span> Finalizar </a>
            <?php
            echo "<a href='/tienda/utilidades/descargas.php?opcion=FAC_PDF&id=".encode($idVenta). " ' target='_blank' class='btn btn-primary'><span class='glyphicon glyphicon-download'></span>  PDF</a>";
            ?>

        </div>
    </div>

</main>
<br><br>

<?php
require_once VIEW_PATH . "pie.php";
?>