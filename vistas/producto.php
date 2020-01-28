
<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/tienda/dirs.php";
require_once VIEW_PATH . "cabecera.php";


// Compramos la existencia del parámetro id antes de usarlo
if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
    $id = decode($_GET["id"]);
    // Cargamos el controlador
    $controlador = ControladorProducto::getControlador();
    $producto= $controlador->buscarProductoID($id);

}

//si no existe el usuario lo enviamos a error para que no haga nada
if (is_null($producto)) {
    // hay un error
    alerta("Operación no permitida", "error.php");
    exit();
}

// si se ha pulsado añadir al carrito:
// actualizamos carrito en sesiones
// actualizamos carrito en cookies
if (isset($_POST["id"]) && !empty(trim($_POST["id"]))) {
    echo "<br>";
    $carrito = ControladorCarrito::getControlador();
    if ($carrito->insertarLineaCarrito($producto, $_POST['uds'])) {
        // si es correcto recarga la página y actualizamos la cookie
        $sesion=ControladorSesion::getControlador();
        $sesion->crearCookie();
        header("location: producto.php?id=" . $_POST['id']);
        exit();
    }
}

?>


<!-- Cuerpo de la página web -->
<div class="container">
    <div id="loginbox" style="margin-top:50px;" class="mainbox col-md-9 col-md-offset-1 col-sm-2 col-sm-offset-1">
        <div class="panel panel-info">
            <div class="panel-heading">
                <div class="panel-title">Ficha de Producto</div>
            </div>
            <div class="panel-body" >
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6">

                            <div class="page-header">
                                <h1><?php echo $producto->getModelo();?></h1>
                                <h4><?php echo $producto->getMarca();?></h4>
                                <h4><?php echo $producto->getTipo();?></h4>
                                <h2><?php echo $producto->getPrecio();?> €</h2>
                                <p class="form-control-static"><b>Descripción:</b></p>
                                <p class="form-control-static"><?php echo $producto->getDesc(); ?></p>
                                <p class="form-control-static"><b>Unidades: </b>
                                    <?php
                                    if($producto->getStock()==0)
                                        echo "<td><span class='label label-danger'>". $producto->getStock() . "</span></td>";
                                    else if($producto->getStock()>0 && $producto->getStock()<5)
                                        echo "<td><span class='label label-warning'>" .$producto->getStock() . "</span></td>";
                                    else
                                        echo "<td><span class='label label-info'>" .$producto->getStock() . "</span></td>";
                                        ?>
                                </p>
                                <p class="form-control-static"><b>Disponible: </b>
                                    <?php
                                    if($producto->getDisponible()==0)
                                        echo "<td><span class='label label-danger'>No</span></td>";
                                    else
                                        echo "<td><span class='label label-success'>Sí</span></td>";
                                    ?>
                                </p>
                                <p class="form-control-static"><b>Oferta: </b>
                                    <?php
                                    if($producto->getOferta()==0)
                                        echo "<td><span class='label label-info'>No</span></td>";
                                    else
                                        echo "<td><span class='label label-success'>-".$producto->getOferta()."%</span></td>";
                                    ?>
                                </p>
                                <p class="form-control-static"><b>Fecha: </b>
                                <?php
                                $date = new DateTime($producto->getFecha());
                                echo $date->format('d/m/Y');
                                ?>
                                </p>
                            </div>
                            <?php
                            // Si está logueado, vamos al carrito, si no a login
                            if(isset($_SESSION['id_usuario']) && $producto->getDisponible()==1 && $producto->getStock()>0) {
                                // Metemos al carrito.
                                // Podemos indicar la cantidad
                                ?>

                                <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                                    <input type="number" name="uds" value="1" min="1" max="<?php echo $producto->getStock(); ?>"> Uds
                                    <button type="submit" class="btn btn btn-default"><span class='glyphicon glyphicon-shopping-cart'></span> Añadir</button>
                                    <input type="hidden" id="id" name="id" value="<?php echo $producto->getId(); ?>">
                                    <input type="hidden" name="marca" value="<?php echo $producto->getMarca(); ?>">
                                    <input type="hidden" name="modelo" value="<?php echo $producto->getModelo(); ?>">
                                    <input type="hidden" name="tipo" value="<?php echo $producto->getTipo(); ?>">
                                    <input type="hidden" name="precio" value="<?php echo $producto->getPrecio(); ?>">
                                    <input type="hidden" name="oferta" value="<?php echo $producto->getOferta(); ?>">
                                    <input type="hidden" name="stock" value="<?php echo $producto->getStock(); ?>">
                                </form>



                                <?php

                            } // Cerramos el if
                            ?>

                            <div>
                                <!-- Button -->
                                <div class="col-md-offset-6 col-md-9">
                                    <p><a href="catalogo.php" class="btn btn-primary"><span class="glyphicon glyphicon-ok"></span> Aceptar</a>

                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 form-group">
                            <div >
                                <br><br>
                                <img src='../img_productos/<?php echo $producto->getImagen();?>' class='rounded' class='img-thumbnail' width='380' height='auto' enctype="multipart/form-data">
                            </div>
                        </div>
                    </div>


            </div>
        </div>
    </div>
</div>
</div>

<br>
<!-- Pie de la página web -->
<?php require_once VIEW_PATH . "pie.php"; ?>

