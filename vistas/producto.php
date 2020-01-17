
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
                                        echo "<td><span class='label label-success'>Sí</span></td>";
                                    ?>
                                </p>
                                <p class="form-control-static"><b>Fecha: </b>
                                <?php
                                $date = new DateTime($producto->getFecha());
                                echo $date->format('d/m/Y');
                                ?>
                                </p>
                            </div>
                            <div>
                                <!-- Button -->
                                <div class="col-md-offset-3 col-md-9">
                                    <p><a href="javascript:history.go(-1)" class="btn btn-primary"><span class="glyphicon glyphicon-ok"></span> Aceptar</a>
                                        <?php
                                            // Si está logueado, vamos al carrito, si no a login
                                            if(isset($_SESSION['id_usuario'])) {
                                                // Metemos al carrito.
                                                echo "<a href='#' class='btn btn-info'><span class='glyphicon glyphicon-shopping-cart'></span> Comprar</a>";
                                            }
                                            ?>

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

