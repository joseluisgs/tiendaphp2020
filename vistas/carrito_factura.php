<?php

// Lo que necesitamos
require_once $_SERVER['DOCUMENT_ROOT'] . "/tienda/dirs.php";
require_once CONTROLLER_PATH . "ControladorSesion.php";

$cs = ControladorSesion::getControlador();
$cs->reiniciarCarrito();
//$cs->destruirCookie();

require_once VIEW_PATH . "cabecera.php";

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
            Tarejta de Credito/debito: **** <?php echo substr($venta->getNumTarjeta(),-4); ?><br>
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
                        <!-- foreach ($order->lineItems as $line) or some such thing here -->
                        <?php
                        /*
                        $lineas = $contCarrito->getVenta()->getLineas();
                        foreach ($lineas as $linea) {
                            echo "<tr>";
                            echo "<td>".$linea->getMarca()." ".$linea->getModelo()."</td>";
                            echo "<td class='text-center'>".$linea->getPrecio()." €</td>";
                            echo "<td class='text-center'>".$linea->getCantidad()."</td>";
                            echo "<td class='text-right'>".$linea->getTotal()." €</td>";
                            echo "</tr>";
                        }
                        */
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
    <div class="form-group">
        <div class='text-center'>
            <button type="button" class="btn btn-info" name="finalizar" onclick="window.print()"> <span class="glyphicon glyphicon-print"></span> Imprimir</button>
            <button type="submit" class="btn btn-success" name="finalizar"> <span class="glyphicon glyphicon-ok"></span>  Finalizar</button>
        </div>
    </div>

</main>

<?php
require_once VIEW_PATH . "pie.php";
?>