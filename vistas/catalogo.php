<?php
//Cabecera de la página web
require_once $_SERVER['DOCUMENT_ROOT'] . "/tienda/dirs.php";
require_once "cabecera.php";

//Cuerpo de la página web

?>

<div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
    <h1 class="display-4">Catálogo</h1>
    <p class="lead">Encuetra tu
        <?php
        if (isset($_GET['seccion'])) {
            echo strtolower($_GET['tipo']);
        } else {
            echo "producto";
        }
        ?>

        y cómpralo.</p>


    <?php
    //Comprobamos si existe un filtro de búsqueda por POST para recuperarlo
    $filtro = (isset($_REQUEST['filter']) ? $_REQUEST['filter'] : "");
    // Comprobamos si se ha pulsado en alguna sección desde NAVBAR por GET
    $tipo = (isset($_GET['tipo']) ? $_GET['tipo'] : "");

    ?>

    <!-- paso el valor de la sección por si estuviera seleccionada -->
    <form class="form-inline" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?tipo=" . $tipo; ?>"
          method="post">
        <div class="form-group mx-sm-10 mb-2">
            <label for="buscar" class="sr-only">Titulo o descripcion</label>
            <input type="text" class="form-control" id="buscar" name="filter" value="<?php echo $filtro ?>"
                   placeholder="Marca o modelo">
        </div>
        <button type="submit" class="btn btn-primary mb-2"><span class="glyphicon glyphicon-search"></span> Buscar
        </button>

        <!-- Aquí va el nuevo botón para dar de alta, podría ir al final -->

    </form>

    <?php
    //  $controlador = ControladorProducto::getControlador();
    //  $lista = $controlador->listarProductos($filtro);

    $consulta = "SELECT * FROM productos WHERE (marca LIKE :marca or modelo LIKE :modelo) and (tipo LIKE :tipo) 
                and (stock>0) and (disponible=1)";
    $parametros = array(':marca' => "%" . $filtro . "%", ':modelo' => "%" . $filtro . "%", ':tipo' => "%" . $tipo . "%");

    $pagina = isset($_GET['page']) ? $_GET['page'] : 1;
    $enlaces = isset($_GET['enlaces']) ? $_GET['enlaces'] : 10;

    $filas = 2;
    $columnas = 4;
    $limite = $filas * $columnas; // Dos filas de 4

    $paginador = new Paginador($consulta, $parametros, $limite);
    $resultados = $paginador->getDatos($pagina);


    ?>

    <div class="container" style="margin-top:50px;" id="catalogo">

        <?php
        if (count($resultados->datos) > 0) {
            $item = 0;
            $max = count($resultados->datos);

            // Recorro todas las filas
            for ($i = 0; $i < $filas && $item < $max; $i++) {
                ?>
                <!-- Fila -->
                <div class="row">
                    <?php
                    // Recorremos todas las columnas
                    for ($j = 0; $j < $columnas && $item < $max; $j++) {
                        $p = $resultados->datos[$item];
                        ?>
                        <!-- Item -->
                        <div class="col-xs-12 col-sm-6 col-md-3">
                            <div class="col-item col-md-12">
                                <div class="post-img-content">
                                    <a href='<?php echo "/tienda/vistas/producto.php?id=" . encode($p->ID) ?>'><img
                                                src='../img_productos/<?php echo $p->IMAGEN; ?>' class="center-block"
                                                class="img-responsive" width='100%' height='100%'/></a>
                                    <span class="post-title">
                        <b><?php echo $p->TIPO; ?></b>
                                        </span>
                                    <?php
                                    if ($p->OFERTA > 0)
                                        echo "<span class='round-tag'>-" . $p->OFERTA . "%</span>";
                                    ?>

                                </div>
                                <div class="info">
                                    <div class="row">
                                        <div class="price col-md-12">
                                            <h5> <?php echo $p->MARCA . " " . $p->MODELO; ?></h5>
                                        </div>
                                        <div class="price col-md-12">
                                            <h4 class="price-text-color"><?php echo $p->PRECIO; ?> €</h4>
                                        </div>
                                    </div>
                                    <div class="separator clear-left">
                                        <p class="btn-add">
                                            <i class="fa fa-shopping-cart"></i>
                                            <?php
                                                // Si está logueado, vamos al carrito, si no a login
                                                if (isset($_SESSION['id_usuario'])) {
                                                    // Metemos al carrito.
                                                    echo "<a href='/tienda/vistas/carrito_añadir.php?id=" . encode($p->ID) . "&page=" . encode("catalogo.php") . "' class='hidden-sm'>Comprar</a>";
                                                } else {
                                                    echo "<a href='/tienda/vistas/login.php' class='hidden-sm'>Comprar</a>";
                                                }
                                            ?>


                                        </p>
                                        <p class="btn-details">
                                            <i class="fa fa-list"></i><a
                                                    href='<?php echo "/tienda/vistas/producto.php?id=" . encode($p->ID) ?>'
                                                    class="hidden-sm">Detalles</a></p>
                                    </div>
                                    <div class="clearfix">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                        // aumento item
                        $item++;
                        // Fin de las columnas
                    }

                    ?>

                    <!--Fin de fila -->
                    <p>&nbsp;&nbsp;</p>
                </div>
                <?
            }// for de filas
            // Paginador
            echo "<ul class='pager'>"; //  <ul class="pagination">
            echo $paginador->crearLinks($enlaces, $filtro, $tipo);
            echo "</ul>";
        } else {  // Del if
            // Si no hay nada seleccionado
            echo "<p class='lead'><em>No se ha encontrado datos de productos.</em></p>";
        }
        ?>


    </div>
</div>

<?php
// Pie de la página web
require_once "pie.php";
?>
