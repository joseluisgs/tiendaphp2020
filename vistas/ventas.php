<!-- Cabecera de la página web -->
<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/tienda/dirs.php";
require_once VIEW_PATH . "cabecera.php";

// como esta página está restringida a usuarios administradores si no está logueado como admin
// lo remitirá a la pagina de inicio
// rol:1 administrador
if ((($_SESSION['rol'])!=1) || (!isset($_SESSION['nombre']))){
    alerta("Operación no permitida", "error.php");
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
                    <h2 class="pull-left">Panel Administración de Ventas</h2>
                </div>
                <form class="form-inline">
                    <div class="form-group mx-sm-5 mb-2">
                        <label for="buscar" class="sr-only">Titulo o descripcion</label>
                        <input type="text" class="form-control" id="buscar" name="filter" value="<?php echo $filtro ?>" placeholder="Nombre o email">
                    </div>
                    <button type="submit" class="btn btn-primary mb-2"> <span class="glyphicon glyphicon-search"></span>  Buscar</button>
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
            $consulta = "SELECT * FROM ventas WHERE nombre LIKE :nombre OR email LIKE :email";
            $parametros = array(':nombre' => "%".$filtro."%", ':email'=>"%".$filtro."%");
            $limite = 5; // Limite del paginador

            $paginador  = new Paginador($consulta, $parametros, $limite);
            $resultados = $paginador->getDatos($pagina);

            if(count( $resultados->datos)>0){

                // Pintamos la tabla el pass como está codificado no se mostrará
                echo "<table class='table table-bordered table-striped'>";
                echo "<thead>";
                echo "<tr>";
                echo "<th>ID</th>";
                echo "<th>Fecha</th>";
                echo "<th>Nombre</th>";
                echo "<th>EMail</th>";
                echo "<th>Total</th>";
                echo "<th>IVA</th>";
                echo "<th>Acción</th>";
                echo "</tr>";
                echo "</thead>";
                echo "<tbody>";

                foreach ($resultados->datos as $p) {
                    // Pintamos cada fila
                    echo "<tr>";
                    echo "<td>" . $p->idVenta . "</td>";
                    $date = new DateTime($p->fecha);
                    echo "<td>" . $date->format('d/m/Y'). "</td>";
                    echo "<td>" . $p->nombre . "</td>";
                    echo "<td>" . $p->email . "</td>";
                    echo "<td>" . $p->total . " €</td>";
                    echo "<td>" . $p->iva . " €</td>";
                    echo "<td>";
                    echo "<a href='ventas_read.php?id=" . encode($p->idVenta) . "' title='Ver Venta' data-toggle='tooltip'><span class='glyphicon glyphicon-eye-open'></span></a>";
                    echo "<a href='/tienda/utilidades/descargas.php?opcion=FAC_PDF&id=".encode($p->idVenta). " ' title='Descargar en PDF' data-toggle='tooltip'><span class='glyphicon glyphicon-download'></span></a>";
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

