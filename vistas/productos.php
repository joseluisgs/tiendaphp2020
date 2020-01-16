<!-- Cabecera de la página web -->
<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/tienda/dirs.php";
require_once VIEW_PATH . "cabecera.php";

// como esta página está restringida a usuarios administradores si no está logueado como admin
// lo remitirá a la pagina de inicio
// rol:1 administrador
if ((($_SESSION['rol'])!=1) || (!isset($_SESSION['nombre']))){
    header("location: error.php");
    exit();
}

//Comprobamos si existe un filtro de búsqueda para recuperarlo
$filtro = (isset($_REQUEST['filter']) ? $_REQUEST['filter'] : "");
$seccion = ""; // aquí no filtraremos por sección como en el navbar

?>
<?php
?>
<div class="wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="page-header clearfix">
                    <h2 class="pull-left">Panel Administración de Usuarios</h2>
                </div>
                <form class="form-inline" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="form-group mx-sm-5 mb-2">
                        <label for="buscar" class="sr-only">Titulo o descripcion</label>
                        <input type="text" class="form-control" id="buscar" name="filter" value="<?php echo $filtro ?>" placeholder="marca o modelo">
                    </div>
                    <button type="submit" class="btn btn-primary mb-2"> <span class="glyphicon glyphicon-search"></span>  Buscar</button>

                    <!-- <a href="utilidades/descargar.php" class="btn pull-right" target="_blank"><span class="glyphicon glyphicon-download"></span>  Descargar</a>-->
                    <a href="/tienda/vistas/productos_create.php" class="btn btn-success pull-right"><span class="glyphicon glyphicon-phone"></span>  Añadir Producto</a>

                </form>
            </div>
            <!-- Linea para dividir -->
            <div class="page-header clearfix">
            </div>
            <?php
            $controlador = ControladorProducto::getControlador();
            $pagina = ( isset($_GET['page']) ) ? $_GET['page'] : 1;
            $enlaces = ( isset($_GET['enlaces']) ) ? $_GET['enlaces'] : 10;

            // Consulta a realizar filtraremos o bien por email o por nombre y configuramos el paginador
            $consulta = "SELECT * FROM productos WHERE marca LIKE :marca OR modelo LIKE :modelo";
            $parametros = array(':marca' => "%".$filtro."%", ':modelo'=>"%".$filtro."%");
            $limite = 5; // Limite del paginador

            $paginador  = new Paginador($consulta, $parametros, $limite);
            $resultados = $paginador->getDatos($pagina);

            if(count( $resultados->datos)>0){

                // Pintamos la tabla el pass como está codificado no se mostrará
                echo "<table class='table table-bordered table-striped'>";
                echo "<thead>";
                echo "<tr>";
                echo "<th>Imagen</th>";
                echo "<th>ID</th>";
                echo "<th>Marca</th>";
                echo "<th>Modelo</th>";
                echo "<th>Precio</th>";
                echo "<th>Unidades</th>";
                echo "<th>Tipo</th>";
                echo "<th>Fecha</th>";
                echo "<th>Acción</th>";
                echo "</tr>";
                echo "</thead>";
                echo "<tbody>";

                foreach ($resultados->datos as $p) {
                    // Pintamos cada fila
                    echo "<tr>";
                    echo "<td><img src='/tienda/img_productos/" . $p->IMAGEN . "' class='rounded' class='img-thumbnail' width='50' height='auto'></td>";
                    echo "<td>" . $p->ID . "</td>";
                    echo "<td>" . $p->MARCA . "</td>";
                    echo "<td>" . $p->MODELO . "</td>";
                    echo "<td>" . $p->PRECIO . " €</td>";
                    if($p->STOCK==0)
                        echo "<td><span class='label label-danger'>". $p->STOCK . "</span></td>";
                    else if($p->STOCK>0 && $p->STOCK<5)
                        echo "<td><span class='label label-warning'>" .$p->STOCK . "</span></td>";
                    else
                        echo "<td><span class='label label-info'>" .$p->STOCK . "</span></td>";
                    echo "<td>" . $p->TIPO . "</td>";
                    $date = new DateTime($p->FECHA);
                    echo "<td>" . $date->format('d/m/Y'). "</td>";
                    echo "<td>";
                    echo "<a href='productos_read.php?id=" . encode($p->ID) . "' title='Ver Producto' data-toggle='tooltip'><span class='glyphicon glyphicon-eye-open'></span></a>";
                    echo "<a href='productos_update.php?id=" . encode($p->ID) . "' title='Actualizar Producto' data-toggle='tooltip'><span class='glyphicon glyphicon-pencil'></span></a>";
                    echo "<a href='productos_delete.php?id=" . encode($p->ID) . "' title='Borar Producto' data-toggle='tooltip'><span class='glyphicon glyphicon-trash'></span></a>";
                    echo "</td>";
                    echo "</tr>";
                }
                echo "</tbody>";
                echo "</table>";

                echo "<ul class='pager'>"; //  <ul class="pagination">
                echo $paginador->crearLinks($enlaces, $filtro, $seccion);
                echo "</ul>";
            } else {
                // Si no hay nada seleccionado
                echo "<p class='lead'><em>No se ha encontrado datos de productos.</em></p>";
            }
            ?>

        </div>
    </div>
</div>
<br>
<!-- Pie de la página web -->
<?php require_once VIEW_PATH . "pie.php"; ?>

